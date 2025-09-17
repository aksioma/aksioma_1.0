<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : monitor/pembiayaan.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Pembiayaan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "monitor";
        $this->menuactsub = "pembiayaan";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('monitor/pembiayaan',$data);
	}
	function get_dataangsuran(){
		$data = $this->allfunct->securePost();
        $id	= $data['id'];
		$query = $this->db->query("SELECT pokok,margin FROM tb_pembiayaandetail WHERE id_pembiayaan='$id'");
		$data = $query->result_array();
        if($query->num_rows() > 0) {
        	echo $data[0]["pokok"]."#".$data[0]["margin"];
        }else{
        	echo "0#0";
        }
	}
   function get_transview()
   {
       $objord = $this->input->post('id');
       $query = $this->db->query("SELECT accounttrans_code,accounttrans_date,accounttrans_value FROM tb_accounttrans WHERE accounttrans_user='".$objord."' AND accounttrans_type='02' AND accounttrans_ref=1 order by accounttrans_date");
       $data = $query->result_array();
       //echo $data;
       $hasil['alldata'] = $data;
       echo json_encode($hasil);
   }
	function get_outstanding(){
		$data = $this->allfunct->securePost();
        $id	= $data['id'];
		$query = $this->db->query("SELECT sum(pokok + margin) AS jlh FROM tb_pembiayaandetail AS t1 
                                    INNER JOIN tb_pembiayaan AS t2 ON t2.pembiayaan_id=t1.id_pembiayaan 
                                    WHERE nomor_rekening='$id'");
		$data = $query->result_array();
        if($query->num_rows() > 0) {
        	echo $data[0]["jlh"];
        }else{
        	echo "0";
        }
	}
	
	function get_dataview(){
		$tgl1 = $this->allfunct->revDate($this->input->post('tgl1'));
    	$tgl2 = $this->allfunct->revDate($this->input->post('tgl2'));
		$fv = $this->input->post('fv');
        $ifv = $this->input->post('ifv');
        $where = " WHERE t1.status=0 ";
    	if(($tgl1 != "")&&($tgl2 != "")){
    		$where .= " AND tgl_dibuka BETWEEN '$tgl1' AND '$tgl2'";
    	}
    	if(($fv != "")){
    		$where .= " AND `$fv` LIKE '%".$ifv."%'";
    	}
    	$query = $this->db->query("SELECT t1.*,t2.nama,t3.nama_pegawai FROM tb_pembiayaan AS t1 
    								INNER JOIN tb_nasabah AS t2 ON t2.nomor_nasabah=t1.nomor_nasabah 
    								INNER JOIN pegawai AS t3 ON t1.nomor_ao=t3.nip
    								".$where."");
    	$data = $query->result_array();
    	$hasil['alldata'] = $data;
    	echo json_encode($hasil);
	}
     
    function get_angsuranview(){
	    $rek = $this->input->post('id');
	    $query = $this->db->query("SELECT t1.* FROM tb_pembiayaandetail AS t1 
                                    INNER JOIN tb_pembiayaan AS t2 ON t2.pembiayaan_id=t1.id_pembiayaan 
                                    WHERE nomor_rekening='$rek'");
        $data = $query->result_array();
        //echo $data;
        $hasil['alldata'] = $data;
        echo json_encode($hasil);
    }
    function get_setoranview()
    {
        $rek = $this->input->post('id');
        $query = $this->db->query("SELECT t1.*,sum(accounttrans_value) AS jlh FROM tb_accounttrans AS t1 
        						WHERE accounttrans_user='$rek' AND `accounttrans_desc` LIKE 'ANGSURAN%' AND `accounttrans_listid` !=19 AND 
        						`accounttrans_type`='01' GROUP BY `accounttrans_code` ORDER BY `accounttrans_id`,accounttrans_date");
        $data = $query->result_array();
        //echo $data;
        $hasil['alldata'] = $data;
        echo json_encode($hasil);
    }
    
    
    function cetak()
    {
    	$this->load->view('cetak/laporan');
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