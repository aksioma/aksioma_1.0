<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : trans/selisihkuranglebuh.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Selisihkuranglebih extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "transaksikas";
        $this->menuactsub = "selisihkuranglebih";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('trans/selisihkuranglebih',$data);
	}
    
    function selisih(){
        $data = $this->allfunct->securePost();
        if($data['accounttrans_type'] == "02"){
        	$data1['accounttrans_date'] = $this->allfunct->revDate($data['tgl_transaksi']);
        	$data1['accounttrans_value'] = $this->allfunct->uangDB($data['jumlah']);
        	$data1['accounttrans_desc'] = $data['ket'];
        	$data1['accounttrans_code'] = $data['nomor_ref']."-01";
        	$data1['accounttrans_type'] = "01";
        	$data1['accounttrans_listid'] = "19";
        	$data1['create_date'] = date("Y-m-d H:i:s");
        	$data1['create_by'] = $this->session->userdata('username');
        	$data1['update_by'] = $this->session->userdata('username');
        	$this->master->simpan('tb_accounttemp',$data1);
        	
        	$data2['accounttrans_date'] = $this->allfunct->revDate($data['tgl_transaksi']);
        	$data2['accounttrans_value'] = $this->allfunct->uangDB($data['jumlah']);
        	$data2['accounttrans_desc'] = $data['ket'];
        	$data2['accounttrans_code'] = $data['nomor_ref']."-02";
        	$data2['accounttrans_type'] = "02";
        	$data2['accounttrans_listid'] = "187";
        	$data2['create_date'] = date("Y-m-d H:i:s");
        	$data2['create_by'] = $this->session->userdata('username');
        	$data2['update_by'] = $this->session->userdata('username');
        	echo $this->master->simpan('tb_accounttemp',$data2);
        }
        if($data['accounttrans_type'] == "01"){
        	$data1['accounttrans_date'] = $this->allfunct->revDate($data['tgl_transaksi']);
        	$data1['accounttrans_value'] = $this->allfunct->uangDB($data['jumlah']);
        	$data1['accounttrans_desc'] = $data['ket'];
        	$data1['accounttrans_code'] = $data['nomor_ref']."-02";
        	$data1['accounttrans_type'] = "02";
        	$data1['accounttrans_listid'] = "19";
        	$data1['create_date'] = date("Y-m-d H:i:s");
        	$data1['create_by'] = $this->session->userdata('username');
        	$data1['update_by'] = $this->session->userdata('username');
        	$this->master->simpan('tb_accounttemp',$data1);
        	 
        	$data2['accounttrans_date'] = $this->allfunct->revDate($data['tgl_transaksi']);
        	$data2['accounttrans_value'] = $this->allfunct->uangDB($data['jumlah']);
        	$data2['accounttrans_desc'] = $data['ket'];
        	$data2['accounttrans_code'] = $data['nomor_ref']."-01";
        	$data2['accounttrans_type'] = "01";
        	$data2['accounttrans_listid'] = "187";
        	$data2['create_date'] = date("Y-m-d H:i:s");
        	$data2['create_by'] = $this->session->userdata('username');
        	$data2['update_by'] = $this->session->userdata('username');
        	echo $this->master->simpan('tb_accounttemp',$data2);
        }
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