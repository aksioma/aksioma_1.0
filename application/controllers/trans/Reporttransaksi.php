<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : trans/reporttransaksi.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Reporttransaksi extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "transaksikas";
        $this->menuactsub = "reporttransaksi";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('trans/reporttransaksi',$data);
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
    function viewtransaksi()
    {
        $data = $this->allfunct->securePost();
        $tglawal = $this->allfunct->revDate($data['tglawal']);
        $tglakhir = $this->allfunct->revDate($data['tglakhir']);
        $id = $data['id'];
        $where = "WHERE accounttrans_date BETWEEN '$tglawal' AND '$tglakhir' ";
        if($id != "0"){
            $where .= " AND t2.user_id='".$id."'";
        }
        $query = $this->db->query("SELECT TIME(create_date) AS waktu, accounttrans_date,accounttrans_code,accounttrans_type,accounttrans_desc,accounttrans_value,create_by,
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
    function isi_user()
    {
        $hasil = $this->db->query("select user_id,username from users")->result();;
        $i=0;
        $pTitle = "<option style=\"background:#EFF1F1\" value=\"0\">--------pilih teller-------</option>";
        foreach ($hasil as $row)
		{
    		$clr = (($i%2) == 0) ? '#fff' : '#EFF1F1';
            $pTitle .= "<option style=\"background:".$clr."\" value=\"".$row->user_id."\">".$row->username."</option>";
            $i++;
		}
        echo $pTitle;
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