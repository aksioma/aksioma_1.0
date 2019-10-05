<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/distribusiprofit.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Distribusiprofit extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "param";
        $this->menuactsub = "distribusiprofit";
	}

    //---- Pameter Nasabah
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('param/distribusiprofit',$data);
	}
    
/*
 *  --------------------- perhimpunan -----------------------------------------
 */
    //---- Simpan perhimpunan
    function saveperhimpunan()
    {
        echo $this->master->simpan('tb_akunperhimpunan',$this->allfunct->securePost());
    }
    function delperhimpunan()
    {
        $where = array('perhimpunan_id' => $this->input->post('id'));
        echo $this->master->delete("tb_akunperhimpunan",$where);
    }
    //---- Edit perhimpunan
    function editperhimpunan()
    {
        $data = $this->allfunct->securePost();
        $id	= $data['id'];
		unset($data['id']);
        $where = array('perhimpunan_id' => $id);
        echo $this->master->update("tb_akunperhimpunan",$data,$where);
    }
    function get_perhimpunan()
    {
        $ff			= $this->input->post('ff'); // Jenis Filter
		$if			= $this->input->post('if'); // Value Filter
		$fd			= $this->input->post('fd'); // Field Sorting
		$adsc		= $this->input->post('adsc'); // Asc or Desc
		$hal		= $this->input->post('hal'); // Offset Limit
		$juml		= $this->input->post('juml'); // Jumlah Limit
		$awal 		= $juml * ($hal - 1);
		$alldata 	= $this->modelku->getAllPerhimpunan($ff,$if,$fd,$adsc,$awal,$juml);
		$records 	= $alldata['numrow'];
		$page_num 	= ceil($records / $juml);
		if ($records > 0)
        {
            $hasil['total'] = $page_num;
            $hasil['alldata'] = $alldata['result'];
        	echo json_encode($hasil);
		}
    }
/*
 *  --------------------- pendapatan -----------------------------------------
 */
    //---- Simpan pendapatan
    function savependapatan()
    {
        echo $this->master->simpan('tb_akunpendapatan',$this->allfunct->securePost());
    }
    function delpendapatan()
    {
        $where = array('akunpendapatan_id' => $this->input->post('id'));
        echo $this->master->delete("tb_akunpendapatan",$where);
    }
    //---- Edit perhimpunan
    function editpendapatan()
    {
        $data = $this->allfunct->securePost();
        $id	= $data['id'];
		unset($data['id']);
        $where = array('akunpendapatan_id' => $id);
        echo $this->master->update("tb_akunpendapatan",$data,$where);
    }
    function get_pendapatan()
    {
        $ff			= $this->input->post('ff'); // Jenis Filter
		$if			= $this->input->post('if'); // Value Filter
		$fd			= $this->input->post('fd'); // Field Sorting
		$adsc		= $this->input->post('adsc'); // Asc or Desc
		$hal		= $this->input->post('hal'); // Offset Limit
		$juml		= $this->input->post('juml'); // Jumlah Limit
		$awal 		= $juml * ($hal - 1);
		$alldata 	= $this->modelku->getAllPendapatanprofit($ff,$if,$fd,$adsc,$awal,$juml);
		$records 	= $alldata['numrow'];
		$page_num 	= ceil($records / $juml);
		if ($records > 0)
        {
            $hasil['total'] = $page_num;
            $hasil['alldata'] = $alldata['result'];
        	echo json_encode($hasil);
		}
    }
}

/* End of file */