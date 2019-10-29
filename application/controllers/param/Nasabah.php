<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/nasabah.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Nasabah extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "param";
        $this->menuactsub = "nasabah";
	}

    //---- Pameter Nasabah
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('param/nasabah',$data);
	}
    
/*
 *  --------------------- pendapatan -----------------------------------------
 */
    //---- Simpan pendapatan
    function savependapatan()
    {
        echo $this->master->simpan('pendapatan',$this->allfunct->securePost());
    }

    //---- Edit pendapatan
    function editpendapatan()
    {
        $data = $this->allfunct->securePost();
        $id	= $data['id'];
		unset($data['id']);
        $where = array('pendapatan_id' => $id);
        echo $this->master->update("pendapatan",$data,$where);
    }

    //---- Hapus pendapatan
    function delpendapatan()
    {
        $where = array('pendapatan_id' => $this->input->post('id'));
        echo  $this->master->delete("pendapatan",$where);
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
		$alldata 	= $this->modelku->getAllPendapatan($ff,$if,$fd,$adsc,$awal,$juml);
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
 *  --------------------- status -----------------------------------------
 */
    //---- Simpan status
    function savestatus()
    {
        echo $this->master->simpan('status_pekerjaan',$this->allfunct->securePost());
    }

    //---- Edit status
    function editstatus()
    {
        $data = $this->allfunct->securePost();
        $id	= $data['id'];
		unset($data['id']);
        $where = array('status_id' => $id);
        echo $this->master->update("status_pekerjaan",$data,$where);
    }

    //---- Hapus status
    function delstatus()
    {
        $where = array('status_id' => $this->input->post('id'));
        echo  $this->master->delete("status_pekerjaan",$where);
    }

    function get_status()
    {
        $ff			= $this->input->post('ff'); // Jenis Filter
		$if			= $this->input->post('if'); // Value Filter
		$fd			= $this->input->post('fd'); // Field Sorting
		$adsc		= $this->input->post('adsc'); // Asc or Desc
		$hal		= $this->input->post('hal'); // Offset Limit
		$juml		= $this->input->post('juml'); // Jumlah Limit
		$awal 		= $juml * ($hal - 1);
		$alldata 	= $this->modelku->getAllStatusPekerjaan($ff,$if,$fd,$adsc,$awal,$juml);
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
 *  --------------------- Pekerjaan -----------------------------------------
 */
    //---- Simpan pekerjaan
    function savepekerjaan()
    {
        echo $this->master->simpan('sektor_pekerjaan',$this->allfunct->securePost());
    }

    //---- Edit pekerjaan
    function editpekerjaan()
    {
        $data = $this->allfunct->securePost();
        $id	= $data['id'];
		unset($data['id']);
        $where = array('pekerjaan_id' => $id);
        echo $this->master->update("sektor_pekerjaan",$data,$where);
    }

    //---- Hapus pekerjaan
    function delpekerjaan()
    {
        $where = array('pekerjaan_id' => $this->input->post('id'));
        echo  $this->master->delete("sektor_pekerjaan",$where);
    }

    function get_pekerjaan()
    {
        $ff			= $this->input->post('ff'); // Jenis Filter
		$if			= $this->input->post('if'); // Value Filter
		$fd			= $this->input->post('fd'); // Field Sorting
		$adsc		= $this->input->post('adsc'); // Asc or Desc
		$hal		= $this->input->post('hal'); // Offset Limit
		$juml		= $this->input->post('juml'); // Jumlah Limit
		$awal 		= $juml * ($hal - 1);
		$alldata 	= $this->modelku->getAllSektorPekerjaan($ff,$if,$fd,$adsc,$awal,$juml);
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