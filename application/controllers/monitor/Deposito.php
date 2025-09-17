<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : monitor/deposito.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Deposito extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "monitor";
        $this->menuactsub = "deposito";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('monitor/deposito',$data);
	}
	function get_dataview(){
		$tgl1 = $this->allfunct->revDate($this->input->post('tgl1'));
		$tgl2 = $this->allfunct->revDate($this->input->post('tgl2'));
		$fv = $this->input->post('fv');
		$ifv = $this->input->post('ifv');
		$where = " WHERE accounttrans_listid !='19' ";
		if(($tgl1 != "")&&($tgl2 != "")){
			$where .= " AND accounttrans_date BETWEEN '$tgl1' AND '$tgl2'";
		}
		if(($fv != "")){
			$where .= " AND `$fv` LIKE '%".$ifv."%'";
		}
		$query = $this->db->query("SELECT SUM(accounttrans_value) AS nominal,t1.*,t2.nama,t2.alamat,t2.kabupaten,t5.groupdeposito_nama FROM tb_deposito AS t1
    								INNER JOIN tb_nasabah AS t2 ON t2.nomor_nasabah=t1.nomor_nasabah
    								INNER JOIN tb_accounttrans AS t4 ON t4.accounttrans_user=t1.nomor_rekening 
									INNER JOIN master_groupdeposito AS t5 ON t5.kode_produk=t1.nama_produk  
									".$where." GROUP BY t1.nomor_rekening");
		$data = $query->result_array();
		$hasil['alldata'] = $data;
		echo json_encode($hasil);
	}
	function get_transview(){
		$rek = $this->input->post('id');
		$query = $this->db->query("SELECT * FROM tb_accounttrans WHERE accounttrans_user='$rek' AND accounttrans_listid !='19'");
		$data = $query->result_array();
		//echo $data;
		$hasil['alldata'] = $data;
		echo json_encode($hasil);
	}
    
    function single_pegawai()
    {
        $data = $this->allfunct->securePost();
        $peg	= $data['peg'];
        $query = $this->db->query("SELECT nama_pegawai FROM pegawai WHERE nip='".$peg."'");
        $data = $query->result_array();
        if($query->num_rows() > 0) {
            $ppeg = $data[0]["nama_pegawai"];
            echo $ppeg;
        }else{
            echo "";
        }
    }
    function login()
	{
		$data = $this->allfunct->securePost();
        $login = array($data['username'], $data['password']);
		$resp = $this->authlib->login1($login);
		echo $resp;
	}
    
}

/* End of file */