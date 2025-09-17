<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
* Copyright (c) 2014
*
* file   : akunting/neraca.php
* author : Edi Suwoto S.Komp
* email  : edi.suwoto@gmail.com
*/
/*----------------------------------------------------------*/
class Neraca extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
        $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "akun";
        $this->menuactsub = "neraca";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('akunting/neraca',$data);
	}
    
    function sum_neraca()
    {
        $id = $this->input->post('id');
        //$query = $this->db->query("SELECT sum(accounttrans_value) as jlh FROM tb_accounttrans WHERE YEAR(accounttrans_date)='".$this->authlib->TahunBuku()."' AND accounttrans_listid=$id");
        $query = $this->db->query("SELECT sum(accounttrans_value) as jlh FROM tb_accounttrans WHERE accounttrans_listid=$id");
        $data = $query->result_array();
        echo $data[0]["jlh"] * 1;
    }
    function head_neraca()
    {
        $id = $this->input->post('id');
        $query = $this->db->query("SELECT listakun_id,`listakun_code`,`listakun_name` FROM `coa_listakun` WHERE listakun_parent=0 AND listakun_pattern=$id");
        $data = $query->result_array();
        echo $data[0]["listakun_code"]." ".$data[0]["listakun_name"] ;
    }
    function get_neraca()
    {
        $type = $this->input->post('type');
        $patten = $this->input->post('patten');
        $tglakhir = $this->allfunct->revDate($this->input->post('tglakhir'));
        $query = $this->db->query("SELECT listakun_id,`listakun_code`,`listakun_name` FROM `coa_listakun` WHERE listakun_alias='GL' AND `listakun_pattern` like '$patten%' order by listakun_code");
        $data = $query->result_array();
        $hasil['alldata'] = $data;
        echo json_encode($hasil);
    }
    function getCOAjurnal()
    {
        $id = $this->input->post('id');
        $tglawal = $this->allfunct->revDate($this->input->post('tglawal'));
        //$tglakhir = $this->allfunct->revDate($this->input->post('tglakhir'));
        $hasil = $this->db->query("SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun WHERE listakun_parent = '0' AND listakun_pattern IN(".$id.")")->result();
        $isi = "";
        $totalNeraca = 0;
		foreach ($hasil as $row)
		{
    		$isi .= "<tr><td align=\"left\" colspan=\"3\">".$row->listakun_code." ".$row->listakun_name."</td></tr>";
            $hasill = $this->db->query("SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun WHERE listakun_alias='GL' AND listakun_parent = '".$row->listakun_id."' ORDER BY listakun_code")->result();
            foreach ($hasill as $val) 
            {
                $isi .= "<tr><td width=\"5%\">&nbsp;</td><td align=\"left\">".$val->listakun_code." ".$val->listakun_name."</td>";
                $totaln = 0;
                $hasilll = $this->db->query("SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun WHERE listakun_parent = '".$val->listakun_id."'")->result();
                foreach ($hasilll as $val1) 
                {
                    $hasillll = $this->db->query("SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun WHERE listakun_parent = '".$val1->listakun_id."'")->result();
                    foreach ($hasillll as $val2) 
                    {
                        $nilai2 = $this->nilaivalue($val2->listakun_id,$tglawal);
                        $totaln += $nilai2;
                    }
                }
                $isi .= "<td align=\"right\">".number_format($totaln, 0)."</td></tr>";
                $totalNeraca += $totaln;
            }
        }
        if($id == "1"){
            $isi .= "<tr style=\"text-align:left;border-top:1px solid #000\"><td align=\"center\" colspan=\"2\"><b>TOTAL AKTIVA</b></td>";
            $isi .= "<td align=\"right\"><b>".number_format($totalNeraca, 0)."</b></td></tr>";
        }else{
            $isi .= "<tr style=\"text-align:left;border-top:1px solid #000\"><td align=\"center\" colspan=\"2\"><b>TOTAL PASSIVA</b></td>";
            $isi .= "<td align=\"right\"><b>".number_format($totalNeraca, 0)."</b></td></tr>";
        }
        echo $isi;
    }
    function getCOAjurnaldetail()
    {
        $id = $this->input->post('id');
        $rown = $this->input->post('row');
        $tglawal = $this->allfunct->revDate($this->input->post('tglawal'));
        //$tglakhir = $this->allfunct->revDate($this->input->post('tglakhir'));
        $hasil = $this->db->query("SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun WHERE listakun_parent = '0' AND listakun_pattern IN(".$id.")")->result();
        $isi = "";
        $totalNeraca = 0;
		foreach ($hasil as $row)
		{
    		$isi .= "<tr><td align=\"left\" colspan=\"3\">".$row->listakun_code." ".$row->listakun_name."</td></tr>";
            $hasill = $this->db->query("SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun WHERE listakun_alias='GL' AND listakun_parent = '".$row->listakun_id."' ORDER BY listakun_code")->result();
            foreach ($hasill as $val) 
            {
                $totaln = 0;
                $isi .= "<tr><td width=\"5%\">&nbsp;</td><td align=\"left\">".$val->listakun_code." ".$val->listakun_name."</td>";
                $isi .= "<td align=\"right\"></td></tr>";
                $hasilll = $this->db->query("SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun WHERE listakun_parent = '".$val->listakun_id."'")->result();
                foreach ($hasilll as $val1) 
                {
                    $isi .= "<tr><td width=\"5%\">&nbsp;</td><td align=\"left\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$val1->listakun_code." ".$val1->listakun_name."</td>";
                    $isi .= "<td align=\"right\"></td></tr>";
                    $hasillll = $this->db->query("SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun WHERE listakun_parent = '".$val1->listakun_id."'")->result();
                    foreach ($hasillll as $val2) 
                    {
                        $isi .= "<tr><td width=\"5%\">&nbsp;</td><td align=\"left\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$val2->listakun_code." ".$val2->listakun_name."</td>";
                        $nilai2 = $this->nilaivalue($val2->listakun_id,$tglawal);
                        $isi .= "<td align=\"right\">".number_format($nilai2, 0)."</td></tr>";
                        $totaln += $nilai2;
                    }
                }
                $isi .= "<tr><td width=\"5%\">&nbsp;</td><td align=\"left\"><b>TOTAL ".$val->listakun_name."</b></td>";
                $isi .= "<td align=\"right\"><b>".number_format($totaln, 0)."</b></td></tr>";
                $totalNeraca += $totaln;
            }
        }
        if($id == "1"){
            $isi .= "<tr style=\"text-align:left;border-top:1px solid #000\"><td align=\"center\" colspan=\"2\"><b>TOTAL AKTIVA</b></td>";
            $isi .= "<td align=\"right\"><b>".number_format($totalNeraca, 0)."</b></td></tr>";
        }else{
            for($i=0;$i<= $rown -1;$i++){
            $isi .= "<tr><td align=\"center\" colspan=\"3\">&nbsp;</td></tr>";
            }
            $isi .= "<tr style=\"text-align:left;border-top:1px solid #000\"><td align=\"center\" colspan=\"2\"><b>TOTAL PASSIVA</b></td>";
            $isi .= "<td align=\"right\"><b>".number_format($totalNeraca, 0)."</b></td></tr>";
        }
        echo $isi;
    }
    function nilaivalue($id,$tglawal){
        $query1 = $this->db->query("SELECT SUM(CASE WHEN accounttrans_type like '01' THEN accounttrans_value END) AS jlh1 FROM tb_accounttrans WHERE accounttrans_listid=$id AND accounttrans_date <='$tglawal'");
        $query2 = $this->db->query("SELECT SUM(CASE WHEN accounttrans_type like '02' THEN accounttrans_value END) AS jlh2 FROM tb_accounttrans WHERE accounttrans_listid=$id AND accounttrans_date <='$tglawal'");
        $data1 = $query1->result_array();
        $data2 = $query2->result_array();
        $query3 = $this->db->query("SELECT listakun_pattern FROM coa_listakun WHERE listakun_id=$id");
        $data1 = $query1->result_array();
        $data2 = $query2->result_array();
        $data3 = $query3->result_array();
        $item = substr($data3[0]["listakun_pattern"],0,2);
        $item1 = substr($data3[0]["listakun_pattern"],0,3);
        if($id =="285"){
        	$trans  = $this->Labarugi($tglawal);
        }else{
	        if($item == "2*"){
	        	$trans  = ($data1[0]["jlh1"] - $data2[0]["jlh2"]) * 1;
	        }elseif($item == "3*"){
	        	$trans  = ($data1[0]["jlh1"] - $data2[0]["jlh2"]) * 1;
	        }elseif($item == "4*"){
	        	$trans  = ($data1[0]["jlh1"] - $data2[0]["jlh2"]) * 1;
	        }else{
	        	$trans  = ($data2[0]["jlh2"] - $data1[0]["jlh1"]) * 1;
	        }
        }
		return $trans;
    }
    function Labarugi($tglakhir){
        $id = "5,6,7";
        $hasil = $this->db->query("SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun WHERE listakun_parent = '0' AND listakun_pattern IN(".$id.")")->result();
        $totalLabaAll = 0;
		foreach ($hasil as $row)
		{
    		$totalLaba = 0;
            $hasill = $this->db->query("SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun WHERE listakun_alias='GL' AND listakun_parent = '".$row->listakun_id."' ORDER BY listakun_code")->result();
            foreach ($hasill as $val) 
            {
                $totaln = 0;
                $hasilll = $this->db->query("SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun WHERE listakun_parent = '".$val->listakun_id."'")->result();
                foreach ($hasilll as $val1) 
                {
                    $hasillll = $this->db->query("SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun WHERE listakun_parent = '".$val1->listakun_id."'")->result();
                    foreach ($hasillll as $val2) 
                    {
                        $nilai2 = $this->nilaivalueLaba($val2->listakun_id,$tglakhir);
                        $totaln += $nilai2;
                    }
                }
                $totalLaba += $totaln;
            }
            $totalLabaAll += $totalLaba;
        }
        return $totalLabaAll;
    }
    function nilaivalueLaba($id,$tglakhir){
        $query1 = $this->db->query("SELECT SUM(CASE WHEN accounttrans_type like '01' THEN accounttrans_value END) AS jlh1 FROM tb_accounttrans WHERE accounttrans_listid=$id AND accounttrans_date <='$tglakhir'");
        $query2 = $this->db->query("SELECT SUM(CASE WHEN accounttrans_type like '02' THEN accounttrans_value END) AS jlh2 FROM tb_accounttrans WHERE accounttrans_listid=$id AND accounttrans_date <='$tglakhir'");
        $query3 = $this->db->query("SELECT listakun_pattern FROM coa_listakun WHERE listakun_id=$id");
        $data1 = $query1->result_array();
        $data2 = $query2->result_array();
        $data3 = $query3->result_array();
        $item = substr($data3[0]["listakun_pattern"],0,2);
        if($item == "5*"){
        	$trans  = ($data1[0]["jlh1"] - $data2[0]["jlh2"]) * 1;
        }elseif($item == "6*"){
        	$trans  = ($data1[0]["jlh1"] - $data2[0]["jlh2"]) * 1;
        }elseif($item == "7*"){
        	$trans  = ($data1[0]["jlh1"] - $data2[0]["jlh2"]) * 1;
        }else{
        	$trans  = ($data2[0]["jlh2"] - $data1[0]["jlh1"]) * 1;
        }
        return $trans;
    }
    function rowtotal(){
        $id1 = $this->input->post('id1');
        $id2 = $this->input->post('id2');
        $hasil = $this->db->query("SELECT COUNT(*) AS jlh FROM coa_listakun WHERE listakun_pattern IN(".$id1.") GROUP BY listakun_code")->result();
        $jlh1 = 0;
        foreach ($hasil as $row)
		{
            $jlh1 += $row->jlh;
        }
        $hasil1 = $this->db->query("SELECT COUNT(*) AS jlh FROM coa_listakun WHERE listakun_pattern IN(".$id2.") GROUP BY listakun_code")->result();
        $jlh2 = 0;
        foreach ($hasil1 as $row)
		{
            $jlh2 += $row->jlh;
        }
        echo ($jlh1 - $jlh2) - 2;
    }
    function cetakneraca()
	{
        $this->load->view('cetak/lapneraca');
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