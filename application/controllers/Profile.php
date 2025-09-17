<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : profile.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Profile extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
        $this->load->library('encrypt');
        $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "index";
        $this->menuactsub = "";
	}
	
	function index()
	{
		$this->authlib->cekmain();
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = 'vader';
        $this->load->view('profile',$data);
	}
   function get_info()
   {
   	$query = $this->db->query("SELECT username,nama_pegawai FROM users AS t1 INNER JOIN pegawai AS t2 ON t1.id_pegawai=t2.pegawai_id WHERE username='".$this->session->userdata('username')."'");
      $data = $query->result_array();
      $hasil['alldata'] = $data;
      echo json_encode($hasil);
   }
   function editprofile()
   {
       $data = $this->allfunct->securePost();
    	$query = $this->db->query("SELECT username,nama_pegawai,pegawai_id FROM users AS t1 INNER JOIN pegawai AS t2 ON t1.id_pegawai=t2.pegawai_id WHERE username='".$this->session->userdata('username')."'");
    	$data1 = $query->result_array();
    	$pegawai_id = $data1[0]["pegawai_id"];
		
		$where1 = array('pegawai_id' => $pegawai_id);
		$resp['nama_pegawai'] = $data['nama_pegawai'];
		$this->master->update("pegawai",$resp,$where1);
		
       unset($data['username']);
       unset($data['nama_pegawai']);
       
       if ($this->input->post('password') != "")
       {
           $data['password'] = $this->encrypt->encode($this->input->post('password'));
       } else {
           unset($data['password']);
       }
       unset($data['password1']);
       $where = array('username' => $this->session->userdata('username'));
       $this->master->update("users",$data,$where);
       $this->authlib->logout();
	}
}

/* End of file */