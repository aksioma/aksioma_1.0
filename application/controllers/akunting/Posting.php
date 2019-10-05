<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
* Copyright (c) 2014
*
* file   : akunting/posting.php
* author : Edi Suwoto S.Komp
* email  : edi.suwoto@gmail.com
*/
/*----------------------------------------------------------*/
class Posting extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
        $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "akun";
        $this->menuactsub = "posting";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('akunting/posting',$data);
	}
    
    function get_koreksiview()
    {
    	$tgl1 = $this->allfunct->revDate($this->input->post('tgl1'));
    	$tgl2 = $this->allfunct->revDate($this->input->post('tgl2'));
    	$where = " WHERE 1 ";
    	if(($tgl1 != "")&&($tgl2 != "")){
    		$where .= " AND accounttrans_date BETWEEN '$tgl1' AND '$tgl2'";
    	}
    	$query = $this->db->query("SELECT * FROM tb_accounttrans ".$where." ORDER BY accounttrans_id ASC");
    	$data = $query->result_array();
    	//echo $data;
    	$hasil['alldata'] = $data;
    	echo json_encode($hasil);
    }
    function delkoreksi(){
    	$data = $this->allfunct->securePost();
    	$val = $data['val'];
    	$x = substr($val,0,+3);
    	if($x == "on,"){
    		$val = str_replace('on,','',$val);
    	}
    	$val = explode(",", $val);
    	for($i=0;$i<count($val);$i++){
    		$where = array('accounttrans_id' => $val[$i]);
    		echo $this->master->delete("tb_accounttrans",$where);
    	}
    }
    function get_transaksiview()
    {
        $tgl1 = $this->allfunct->revDate($this->input->post('tgl1'));
        $tgl2 = $this->allfunct->revDate($this->input->post('tgl2'));
        $where = " WHERE accounttrans_posted = 0";
        if(($tgl1 != "")&&($tgl2 != "")){
            $where .= " AND accounttrans_date BETWEEN '$tgl1' AND '$tgl2'";
        }
        $query = $this->db->query("SELECT * FROM tb_accounttemp ".$where." ORDER BY accounttrans_id ASC");
        $data = $query->result_array();
        //echo $data;
        $hasil['alldata'] = $data;
        echo json_encode($hasil);
    }
    function updatepost(){
        $data = $this->allfunct->securePost();
        $val = $data['val'];
        $x = substr($val,0,+3);
        if($x == "on,"){
            $val = str_replace('on,','',$val);
        }
        $val = explode(",", $val);
        for($i=0;$i<count($val);$i++){
            $query = $this->db->query("SELECT * FROM tb_accounttemp WHERE accounttrans_id=".$val[$i]."");
            $result = $query->result_array();
            $resp['accounttrans_listid'] = $result[0]['accounttrans_listid'];
            $resp['accounttrans_date'] = $result[0]['accounttrans_date'];
            $resp['accounttrans_code'] = $result[0]['accounttrans_code'];
            $resp['accounttrans_type'] = $result[0]['accounttrans_type'];
            $resp['accounttrans_desc'] = $result[0]['accounttrans_desc'];
            $resp['accounttrans_value'] = $result[0]['accounttrans_value'];
            $resp['accounttrans_curency'] = $result[0]['accounttrans_curency'];
            $resp['accounttrans_direct'] = $result[0]['accounttrans_direct'];
            $resp['accounttrans_ref'] = $result[0]['accounttrans_ref'];
            $resp['accounttrans_user'] = $result[0]['accounttrans_user'];
            $resp['create_date'] = date("Y-m-d H:i:s");
            $resp['create_by'] = $this->session->userdata('username');
            $resp['update_by'] = $this->session->userdata('username');
            $resp['accounttrans_curency'] = $this->session->userdata('cbg');
            
            $this->master->simpan('tb_accounttrans',$resp);
            
            $data1['accounttrans_posted'] = "1";
            $where = array('accounttrans_id' => $val[$i]);
            echo $this->master->update("tb_accounttemp",$data1,$where);
        }
        
    }
    
    function delpost(){
        $data = $this->allfunct->securePost();
        $val = $data['val'];
        $x = substr($val,0,+3);
        if($x == "on,"){
            $val = str_replace('on,','',$val);
        }
        $val = explode(",", $val);
        for($i=0;$i<count($val);$i++){
            $where = array('accounttrans_id' => $val[$i]);
            echo $this->master->delete("tb_accounttemp",$where);
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