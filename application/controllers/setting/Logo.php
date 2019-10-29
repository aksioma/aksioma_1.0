<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : setting/logo.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Logo extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "setting";
        $this->menuactsub = "logo";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $data['logo'] = $this->authlib->getLogo();
        $data['imgsrc'] = $this->authlib->getLogo();
        $this->load->view('setting/logo',$data);
	}
    
	function uploadfoto()
	{
		$config['upload_path'] = 'assets/img/';
		$config['allowed_types'] = 'png';
		$config['max_size']	= '500';
		$config['max_width']  = '800';
		$config['max_height']  = '600';

	$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
            echo  strip_tags($this->upload->display_errors());
		} else {
            $hasil = $this->upload->data();
            $fileasli = $hasil['full_path'];
            $logofoto = 'test.jpg';
            if (file_exists($logofoto))
            {
              unlink($logofoto);
            }
            echo rename( $fileasli , $logofoto );
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