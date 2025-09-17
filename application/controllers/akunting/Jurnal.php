<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
* Copyright (c) 2014
*
* file   : akunting/jurnal.php
* author : Edi Suwoto S.Komp
* email  : edi.suwoto@gmail.com
*/
/*----------------------------------------------------------*/
class Jurnal extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		error_reporting(E_ALL & ~E_NOTICE);
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
        $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "akun";
        $this->menuactsub = "jurnal";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('akunting/jurnal',$data);
	}

    function infoaccount()
    {
        $id	= $this->input->post('id');
        $query = $this->db->query("SELECT listakun_code,listakun_name FROM coa_listakun WHERE listakun_id=$id");
        $data = $query->result_array();
        echo $data[0]['listakun_code']." ".$data[0]['listakun_name'];
    }
    function savejurnal(){
        $objord = json_decode($this->input->post('ord'));
        $data['accounttrans_date'] = $this->allfunct->revDate($objord->accounttrans_date);
        $code = $objord->accounttrans_code;
        $data['accounttrans_desc'] = $objord->accounttrans_desc;
        foreach ($objord->orderan as $objpro)
        {
            $data['accounttrans_type'] = $objpro->dk;
            $data['accounttrans_listid'] = $objpro->code;
            $data['accounttrans_code'] = $code."-".$objpro->code;
            $data['accounttrans_user'] = $objpro->ketval;
            $data['accounttrans_value'] = $objpro->qty;
            $data['create_date'] = date("Y-m-d H:i:s");
            $data['create_by'] = $this->session->userdata('username');
            $data['update_by'] = $this->session->userdata('username');
            $rsp = $this->master->simpan("tb_accounttemp",$data);
        }
        if ($this->db->trans_status() === FALSE)
        {
           $this->db->trans_rollback();
           echo "Rollback : ".$rsp;
        } else {
           $this->db->trans_commit();
           echo "1";
        }
    }

    //cek otorisasi transaksi
    function login()
	{
		$data = $this->allfunct->securePost();
        $login = array($data['username'], $data['password']);
		$resp = $this->authlib->login1($login);
		echo $resp;
	}
    
}

/* End of file */