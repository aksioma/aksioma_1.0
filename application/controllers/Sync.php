<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : sync.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Sync extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        //$this->authlib->cekcontr();
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
        $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
    }
	
	function index()
	{
	}
    function login(){
    	$data = $this->allfunct->securePost();
    	$id = $data['id'];
    	$query = $this->db->query("SELECT nama AS name,DATE_FORMAT(tgl_masuk,'%d-%m-%Y') as entrydate,t1.status AS active,
    							SUM(CASE WHEN accounttrans_type='01' THEN accounttrans_value END) AS simpanan
								FROM tb_nasabah AS t1 
    							INNER JOIN tb_tabungan AS t2 ON t2.nomor_nasabah=t1.nomor_nasabah 
    							INNER JOIN tb_accounttrans AS t3 ON t3.accounttrans_user=t2.nomor_rekening 
    							WHERE t1.nomor_nasabah='".$id."'");
    	$hasil = $query->result_array();
    	echo json_encode($hasil);
    }
}

/* End of file */