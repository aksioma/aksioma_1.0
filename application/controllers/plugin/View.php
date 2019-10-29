<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : plugin/view.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class View extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->plugin =  $this->uri->segment(4);
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
	    $this->menuact = "plugin";
	    $this->menuactsub = $this->plugin;
    }

    //---- Admin
	function index()
	{
		redirect('plugin/view/main', 'refresh');
	}
	function main(){
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $data['logo'] = $this->authlib->getLogo();
        $data['imgsrc'] = $this->authlib->getLogo();
        ///plugin
        $data['plugin'] = $this->plugin;
        $iframplugin = "assets/plugin/hello/hello.php";
        $data['iframplugin'] = $iframplugin;
        $this->load->view('plugin/view',$data);
		
	}
}

/* End of file */