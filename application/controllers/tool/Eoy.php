<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : tool/eoy.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Eoy extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "tools";
        $this->menuactsub = "eoy";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $data['tahunbuku'] = $this->authlib->TahunBuku();
        $this->load->view('tool/eoy',$data);
	}
    function prosesEOY(){
    	//$thnbukunext = $this->authlib->TahunBuku() + 1;
    	$thnbukunext = $this->authlib->TahunBuku();
    	$thnbukunextn = $thnbukunext."-12-31 00:00:01";
    	$this->db->query("DELETE FROM `tb_accounttrans` WHERE YEAR(accounttrans_date)='".$thnbukunext."' AND accounttrans_code LIKE 'EOY%'");
    	/// ======
    	// Pendapatan (d) (semua code account pendapatan yg ada nilainya kecuali nomor account 525.02 , 525.32 , 525.52 di kredit)
		// SHU tahun lulu (k) (430.01.01 LABA/RUGI TAHUN LALU)
		// =======
    	$hasil = $this->db->query("SELECT listakun_id,t2.listakun_code AS listakun_code,t1.* FROM `tb_accounttrans` AS t1 
									INNER JOIN coa_listakun AS t2 ON t2.listakun_id=t1.`accounttrans_listid` 
    								WHERE listakun_code LIKE '5%' AND listakun_code NOT LIKE '525%' AND YEAR(accounttrans_date)='".$this->authlib->TahunBuku()."'")->result();
    	$shuP = 0;
    	foreach ($hasil as $row){
    		/// data pendapatan
    		$shuP += $row->accounttrans_value;
    		$listakun_code = $row->listakun_code;
    		$listakun_id = $row->listakun_id;
    		$data['accounttrans_type'] = "02";
    		$data['accounttrans_listid'] = $listakun_id;
    		$data['accounttrans_code'] = "EOY ".$row->accounttrans_code;
    		$data['accounttrans_user'] = $row->accounttrans_user;
    		$data['accounttrans_desc'] = 'EOY '.$row->accounttrans_desc;
    		$data['accounttrans_value'] = $row->accounttrans_value;
    		$data['accounttrans_date'] = $thnbukunextn;
    		$data['create_date'] = $thnbukunextn;
    		$data['create_by'] = $this->session->userdata('username');
    		$data['update_by'] = $this->session->userdata('username');
    		$this->master->simpan("tb_accounttrans",$data);
    	}
    	/// data pendapatan LABA/RUGI TAHUN LALU
    	$data1['accounttrans_type'] = "01";
    	$data1['accounttrans_listid'] = "283";
    	$data1['accounttrans_code'] = "EOY-430.01.01";
    	$data1['accounttrans_user'] = "EOY";
    	$data1['accounttrans_desc'] = 'EOY LABA/RUGI TAHUN LALU';
    	$data1['accounttrans_value'] = $shuP;
    	$data1['accounttrans_date'] = $thnbukunextn;
    	$data1['create_date'] = $thnbukunextn;
    	$data1['create_by'] = $this->session->userdata('username');
    	$data1['update_by'] = $this->session->userdata('username');
    	$this->master->simpan("tb_accounttrans",$data1);
    	///=====================
    	$hasil = $this->db->query("SELECT listakun_id,t2.listakun_code AS listakun_code,t1.* FROM `tb_accounttrans` AS t1
									INNER JOIN coa_listakun AS t2 ON t2.listakun_id=t1.`accounttrans_listid`
    								WHERE listakun_code LIKE '525%' AND YEAR(accounttrans_date)='".$this->authlib->TahunBuku()."'")->result();
    	$shuP1 = 0;
    	foreach ($hasil as $row){
    		/// data pendapatan
    		$shuP1 += $row->accounttrans_value;
    		$listakun_code = $row->listakun_code;
    		$listakun_id = $row->listakun_id;
    		$data2['accounttrans_type'] = "01";
    		$data2['accounttrans_listid'] = $listakun_id;
    		$data2['accounttrans_code'] = "EOY ".$row->accounttrans_code;
    		$data2['accounttrans_user'] = $row->accounttrans_user;
    		$data2['accounttrans_desc'] = 'EOY '.$row->accounttrans_desc;
    		$data2['accounttrans_value'] = $row->accounttrans_value;
    		$data2['accounttrans_date'] = $thnbukunextn;
    		$data2['create_date'] = $thnbukunextn;
    		$data2['create_by'] = $this->session->userdata('username');
    		$data2['update_by'] = $this->session->userdata('username');
    		$this->master->simpan("tb_accounttrans",$data2);
    	}
    	/// data pendapatan LABA/RUGI TAHUN LALU
    	$data3['accounttrans_type'] = "02";
    	$data3['accounttrans_listid'] = "283";
    	$data3['accounttrans_code'] = "EOY-430.01.01";
    	$data3['accounttrans_user'] = "EOY";
    	$data3['accounttrans_desc'] = 'EOY LABA/RUGI TAHUN LALU';
    	$data3['accounttrans_value'] = $shuP1;
    	$data3['accounttrans_date'] = $thnbukunextn;
    	$data3['create_date'] = $thnbukunextn;
    	$data3['create_by'] = $this->session->userdata('username');
    	$data3['update_by'] = $this->session->userdata('username');
    	$this->master->simpan("tb_accounttrans",$data3);
    	// =========
    	// SHU tahun lulu  (d) (430.01.01 LABA/RUGI TAHUN LALU)
    	// Beban (k)	(semua code beban yg ada nilainya dan semua hak bagi hasil 605.)
    	// =========
    	$hasil = $this->db->query("SELECT listakun_id,t2.listakun_code AS listakun_code,t1.* FROM `tb_accounttrans` AS t1
									INNER JOIN coa_listakun AS t2 ON t2.listakun_id=t1.`accounttrans_listid`
    								WHERE listakun_code LIKE '6%' AND YEAR(accounttrans_date)='".$this->authlib->TahunBuku()."'")->result();
    	$shuB = 0;
    	foreach ($hasil as $row){
    		/// data beban dan bagi hasil
    		$shuB += $row->accounttrans_value;
    		$listakun_code = $row->listakun_code;
    		$listakun_id = $row->listakun_id;
    		$data4['accounttrans_type'] = "01";
    		$data4['accounttrans_listid'] = $listakun_id;
    		$data4['accounttrans_code'] = "EOY ".$row->accounttrans_code;
    		$data4['accounttrans_user'] = $row->accounttrans_user;
    		$data4['accounttrans_desc'] = 'EOY '.$row->accounttrans_desc;
    		$data4['accounttrans_value'] = $row->accounttrans_value;
    		$data4['accounttrans_date'] = $thnbukunextn;
    		$data4['create_date'] = $thnbukunextn;
    		$data4['create_by'] = $this->session->userdata('username');
    		$data4['update_by'] = $this->session->userdata('username');
    		$this->master->simpan("tb_accounttrans",$data4);
    	}
    	/// data pendapatan LABA/RUGI TAHUN LALU
    	$data5['accounttrans_type'] = "02";
    	$data5['accounttrans_listid'] = "283";
    	$data5['accounttrans_code'] = "EOY-430.01.01";
    	$data5['accounttrans_user'] = "EOY";
    	$data5['accounttrans_desc'] = 'EOY LABA/RUGI TAHUN LALU';
    	$data5['accounttrans_value'] = $shuB;
    	$data5['accounttrans_date'] = $thnbukunextn;
    	$data5['create_date'] = $thnbukunextn;
    	$data5['create_by'] = $this->session->userdata('username');
    	$data5['update_by'] = $this->session->userdata('username');
    	$resp = $this->master->simpan("tb_accounttrans",$data5);
    	
    	////===
    	$hasil = $this->db->query("SELECT listakun_id,t2.listakun_code AS listakun_code,t1.* FROM `tb_accounttrans` AS t1
									INNER JOIN coa_listakun AS t2 ON t2.listakun_id=t1.`accounttrans_listid`
    								WHERE listakun_code LIKE '7%' AND YEAR(accounttrans_date)='".$this->authlib->TahunBuku()."'")->result();
    	$shuBA = 0;
    	foreach ($hasil as $row){
    		/// data beban dan bagi hasil
    		$shuBA += $row->accounttrans_value;
    		$listakun_code = $row->listakun_code;
    		$listakun_id = $row->listakun_id;
    		$data4['accounttrans_type'] = "01";
    		$data4['accounttrans_listid'] = $listakun_id;
    		$data4['accounttrans_code'] = "EOY ".$row->accounttrans_code;
    		$data4['accounttrans_user'] = $row->accounttrans_user;
    		$data4['accounttrans_desc'] = 'EOY '.$row->accounttrans_desc;
    		$data4['accounttrans_value'] = $row->accounttrans_value;
    		$data4['accounttrans_date'] = $thnbukunextn;
    		$data4['create_date'] = $thnbukunextn;
    		$data4['create_by'] = $this->session->userdata('username');
    		$data4['update_by'] = $this->session->userdata('username');
    		$this->master->simpan("tb_accounttrans",$data4);
    	}
    	/// data pendapatan LABA/RUGI TAHUN LALU
    	$data5['accounttrans_type'] = "02";
    	$data5['accounttrans_listid'] = "283";
    	$data5['accounttrans_code'] = "EOY-430.01.01";
    	$data5['accounttrans_user'] = "EOY";
    	$data5['accounttrans_desc'] = 'EOY LABA/RUGI TAHUN LALU';
    	$data5['accounttrans_value'] = $shuBA;
    	$data5['accounttrans_date'] = $thnbukunextn;
    	$data5['create_date'] = $thnbukunextn;
    	$data5['create_by'] = $this->session->userdata('username');
    	$data5['update_by'] = $this->session->userdata('username');
    	$resp = $this->master->simpan("tb_accounttrans",$data5);
    	echo $resp;
    }
}

/* End of file */