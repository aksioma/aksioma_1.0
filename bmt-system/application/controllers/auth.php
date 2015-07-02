<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : auth.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Auth extends Controller {

	function __construct()
	{
		parent::Controller();
	}
	
	function index(){
		if($this->session->userdata('username') !=""){
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=http://".$_SERVER['HTTP_HOST']."\">";
			exit();
		}
		$this->authlib->logged();
        $data['tema'] = 'blitzer';
        $this->load->view('auth',$data);
	}

    function login()
	{
		$login = array($this->input->post('username'), $this->input->post('password'));
		$resp = $this->authlib->login($login);
		echo $resp;
	}

	function logout()
	{
		$this->authlib->logout();
	}

	function denied()
	{
		$this->load->view('denied');
	}

}

/* End of file */
