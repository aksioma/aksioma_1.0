<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : trans/reportteller.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Reportteller extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "transaksikas";
        $this->menuactsub = "reportteller";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('trans/reportteller',$data);
	}
    
    function saldokhasanah()
    {
        $query = $this->db->query("SELECT sum(accounttrans_value) as jlh FROM tb_accounttrans WHERE accounttrans_type='01'");
        $data = $query->result_array();
        if($query->num_rows() > 0) {
            $query1 = $this->db->query("SELECT sum(accounttrans_value) as jlh FROM tb_accounttrans WHERE accounttrans_type='02'");
            $data1 = $query1->result_array();
            $query2 = $this->db->query("SELECT sum(accounttrans_value) as jlh FROM tb_accounttrans WHERE accounttrans_type='15'");
            $data2 = $query2->result_array();
            $jlh = $data[0]["jlh"] - $data1[0]["jlh"] - $data2[0]["jlh"];
            echo $jlh;
        }else{
            echo "0";
        }
    }
    function viewtransaksihead()
    {
    	$data = $this->allfunct->securePost();
    	$tglawal = $this->allfunct->revDate($data['tglawal']);
    	$tglakhir = $this->allfunct->revDate($data['tglakhir']);
    	$id = $this->session->userdata('user_id');
    	$where = "WHERE accounttrans_date BETWEEN '$tglawal' AND '$tglakhir' ";
    	if($id != "0"){
    		$where .= " AND accounttrans_listid='568' AND t2.user_id='".$id."'";
    	}
    	$hasil = $this->db->query("SELECT accounttrans_date,accounttrans_code,accounttrans_type,accounttrans_desc,accounttrans_value,create_by,
                                    accounttrans_value
                                    FROM tb_accounttrans AS t1
                                    INNER JOIN users AS t2 ON t2.username=t1.create_by
                                    ".$where."")->result();
    	$pTitle = "";
    	$i = 0;
    	foreach ($hasil as $row){
    		if($row->accounttrans_type == "01"){
    			$kredit = $row->accounttrans_value;
    			$debet = 0;
    		}else{
    			$kredit = 0;
    			$debet = $row->accounttrans_value;
    		}
    		$saldo = $kredit + $debet;
    		$clr = (($i%2) == 0) ? '#fff' : '#EFF1F1';
    		$pTitle .= $row->accounttrans_value."**<tr style=\"background:".$clr."\"><td></td><td></td><td align='center'>".$this->allfunct->revDate($row->accounttrans_date)."</td><td>Saldo</td><td align='right'>".$this->allfunct->rupiah($debet)."</td><td align='right'>".$this->allfunct->rupiah($kredit)."</td><td align='right'>".$this->allfunct->rupiah($saldo)."</td></tr>";
    		$i++;
    	}
    	
    	echo $pTitle;
    }
    function viewtransaksi()
    {
        $data = $this->allfunct->securePost();
        $tglawal = $this->allfunct->revDate($data['tglawal']);
        $tglakhir = $this->allfunct->revDate($data['tglakhir']);
        $where = "WHERE accounttrans_listid !=19 AND accounttrans_listid !='568' AND accounttrans_date BETWEEN '$tglawal' AND '$tglakhir' AND t2.user_id='".$this->session->userdata('user_id')."'";
        $query = $this->db->query("SELECT accounttrans_user,TIME(create_date) AS waktu, accounttrans_date,accounttrans_code,accounttrans_type,accounttrans_desc,accounttrans_value,create_by,
                                    SUM(CASE WHEN accounttrans_type = '01' THEN accounttrans_value END) AS mutasi_kredit, 
                                    SUM(CASE WHEN accounttrans_type = '02' THEN accounttrans_value END) AS mutasi_debet         
                                    FROM tb_accounttrans AS t1 
                                    INNER JOIN users AS t2 ON t2.username=t1.create_by
                                    ".$where."
                                    GROUP BY accounttrans_id");
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
    function cetakLapTeller()
	{
        $this->load->view('cetak/laporan');
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