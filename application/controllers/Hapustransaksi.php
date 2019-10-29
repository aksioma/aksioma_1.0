<?php
/*
 * Aplikasi BMT v1.0
 * Copyright (c) 2013
 *
 * file   : hapustransaksi.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Hapustransaksi extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
        $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "transaksiumum";
        $this->menuactsub = "hapustransaksi";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('hapustransaksi',$data);
	}
    
    function get_trans()
    {
        $ff			= $this->input->post('ff'); // Jenis Filter
		$if			= $this->input->post('if'); // Value Filter
		$fd			= $this->input->post('fd'); // Field Sorting
		$adsc		= $this->input->post('adsc'); // Asc or Desc
		$hal		= $this->input->post('hal'); // Offset Limit
		$juml		= $this->input->post('juml'); // Jumlah Limit
		$pawal		= $this->allfunct->revDate($this->input->post('pawal'));// Periode Awal
        $pakhir		= $this->allfunct->revDate($this->input->post('pakhir')); // Periode Akhir
		$awal 		= $juml * ($hal - 1);
        $alldata 	= $this->modelku->getAllTransaksi($ff,$if,$fd,$adsc,$awal,$juml,$pawal,$pakhir);
		$records 	= $alldata['numrow'];
		$page_num 	= ceil($records / $juml);
		if ($records > 0)
        {
            $hasil['total'] = $page_num;
            $hasil['alldata'] = $alldata['result'];
        	echo json_encode($hasil);
		}else{
            $hasil['alldata'] = 0;
            echo $hasil;
        }
    }
    function delTransaksi()
    {
        $where = array('accounttrans_id' => $this->input->post('id'));
        echo $this->master->delete("tb_accounttrans",$where);
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