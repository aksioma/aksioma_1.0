<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : setting/sampultab.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Sampultab extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "setting";
        $this->menuactsub = "sampultab";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $data['logo'] = $this->authlib->getLogo();
        $data['imgsrc'] = $this->authlib->getLogo();
        $this->load->view('setting/sampultab',$data);
	}
	// conversi cm ke pixel 1 cm = 37.8 px => 1 cm = 10 mm
	function editSampulInfo()
	{
		$data = $this->allfunct->securePost();
		$id	= 1;
		$where = array('id' => $id);
		echo $this->master->update("setting",$data,$where);
	}
	function get_info()
	{
		$objord = $this->input->post('id');
		$where = "";
		$query = $this->db->query("SELECT set1,set2,set3 FROM setting");
		$data = $query->result_array();
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