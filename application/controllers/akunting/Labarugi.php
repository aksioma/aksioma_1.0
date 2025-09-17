<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
* Copyright (c) 2014
*
* file   : akunting/labarugi.php
* author : Edi Suwoto S.Komp
* email  : edi.suwoto@gmail.com
*/
/*----------------------------------------------------------*/
class Labarugi extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
        $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "akun";
        $this->menuactsub = "labarugi";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('akunting/labarugi',$data);
	}
    
	function getCOAjurnal()
    {
        $id = $this->input->post('id');
        $tglawal = $this->allfunct->revDate($this->input->post('tglawal'));
        $tglakhir = $this->allfunct->revDate($this->input->post('tglakhir'));
        $hasil = $this->db->query("SELECT listakun_id,listakun_code,listakun_name,listakun_pattern FROM coa_listakun WHERE listakun_parent = '0' AND listakun_pattern IN(".$id.") ORDER BY `coa_listakun`.`listakun_code` ASC")->result();
        $isi = "";
        $totalLabaAll = 0;
		foreach ($hasil as $row)
		{
    		$totalLaba = 0;
            $isi .= "<tr><td align=\"left\" colspan=\"4\">".$row->listakun_code." ".$row->listakun_name."</td></tr>";
            $hasill = $this->db->query("SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun WHERE listakun_alias='GL' AND listakun_parent = '".$row->listakun_id."' ORDER BY `coa_listakun`.`listakun_code` ASC")->result();
            foreach ($hasill as $val) 
            {
                $isi .= "<tr><td width=\"5%\">&nbsp;</td><td align=\"left\">".$val->listakun_code." ".$val->listakun_name."</td>";
                $totaln = 0;
                $totaln1 = 0;
                $hasilll = $this->db->query("SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun WHERE listakun_parent = '".$val->listakun_id."'")->result();
                foreach ($hasilll as $val1) 
                {
                    $hasillll = $this->db->query("SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun WHERE listakun_parent = '".$val1->listakun_id."'")->result();
                    foreach ($hasillll as $val2) 
                    {
                        $nilai2 = $this->nilaivalue($val2->listakun_id,$tglawal,$tglakhir);
                        $totaln += $nilai2;
                    }
                }
                $isi .= "<td align=\"right\"><b>".number_format($totaln, 0)."</b></td></tr>";
                $totalLaba += $totaln;
            }
            $isi .= "<tr><td align=\"left\" colspan=\"3\"><b>TOTAL ".$row->listakun_name."</b></td>";
            $isi .= "<td align=\"right\"><b>".number_format($totalLaba, 0)."</b></td></tr>";
            
            $item = substr($row->listakun_pattern,0,2);
            if(($item == "5")||($item == "6")){
            	$totalLabaAll += $totalLaba;
            }else{
            	$totalLabaAll -= $totalLaba;
            }
        }
        $isi .= "<tr style=\"text-align:left;border-top:1px solid #000\"><td align=\"left\" colspan=\"3\"><b>LABA / RUGI</b></td>";
        $isi .= "<td align=\"right\"><b>".number_format($totalLabaAll, 0)."</b></td></tr>";
        echo $isi;
    }
    function getCOAjurnaldetail()
    {
        $id = $this->input->post('id');
        $tglawal = $this->allfunct->revDate($this->input->post('tglawal'));
        $tglakhir = $this->allfunct->revDate($this->input->post('tglakhir'));
        $hasil = $this->db->query("SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun WHERE listakun_parent = '0' AND listakun_pattern IN(".$id.") ORDER BY `coa_listakun`.`listakun_code` ASC")->result();
        $isi = "";
        $totalLaba = 0;
		foreach ($hasil as $row)
		{
    		$isi .= "<tr><td align=\"left\" colspan=\"4\">".$row->listakun_code." ".$row->listakun_name."</td></tr>";
            $hasill = $this->db->query("SELECT listakun_id,listakun_code,listakun_name,listakun_pattern FROM coa_listakun WHERE listakun_alias='GL' AND listakun_parent = '".$row->listakun_id."'")->result();
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
                        $nilai2 = $this->nilaivalue($val2->listakun_id,$tglawal,$tglakhir);
                        $isi .= "<td align=\"right\">".number_format($nilai2, 0)."</td></tr>";
                        $totaln += $nilai2;
                    }
                }
                $isi .= "<tr><td width=\"5%\">&nbsp;</td><td align=\"left\" colspan=\"2\"><b>TOTAL ".$val->listakun_name."</b></td>";
                $isi .= "<td align=\"right\"><b>".number_format($totaln, 0)."</b></td></tr>";
                $item = substr($val->listakun_pattern,0,2);
                if(($item == "5*")||($item == "6*")){
                	$totalLaba += $totaln;
                }else{
                	$totalLaba -= $totaln;
                }
            }
        }
        $isi .= "<tr style=\"text-align:left;border-top:1px solid #000\"><td align=\"left\" colspan=\"3\"><b>LABA / RUGI</b></td>";
        $isi .= "<td align=\"right\"><b>".number_format($totalLaba, 0)."</b></td></tr>";
        echo $isi;
    }
    function nilaivalue($id,$tglawal,$tglakhir){
        //$query = $this->db->query("SELECT SUM(CASE WHEN accounttrans_type like '01' THEN accounttrans_value END) AS jlh FROM tb_accounttrans WHERE accounttrans_listid=$id AND accounttrans_date BETWEEN '$tglawal' AND '$tglakhir'");
        //$data = $query->result_array();
        //return $data[0]["jlh"] * 1;
        if(($id =="349")||($id =="348")||($id =="350")||($id =="352")||($id =="353") ||($id =="342")||($id =="343") ||($id == "325")||($id == "326")||($id == "327")||($id == "328")||($id == "329")||($id == "330") || ($id == "334")||($id == "335")||($id == "336")||($id == "337")||($id == "338")||($id == "339")||($id == "448")||($id == "449")||($id == "450")||($id == "451")){
        	$query1 = $this->db->query("SELECT SUM(CASE WHEN accounttrans_type like '02' THEN accounttrans_value END) AS jlh1 FROM tb_accounttrans WHERE accounttrans_listid=$id AND accounttrans_date BETWEEN '$tglawal' AND '$tglakhir'");
        }else{
        	$query1 = $this->db->query("SELECT SUM(CASE WHEN accounttrans_type like '01' THEN accounttrans_value END) AS jlh1 FROM tb_accounttrans WHERE accounttrans_listid=$id AND accounttrans_date BETWEEN '$tglawal' AND '$tglakhir'");
        }
        $query2 = $this->db->query("SELECT SUM(CASE WHEN accounttrans_type like '02' THEN accounttrans_value END) AS jlh2 FROM tb_accounttrans WHERE accounttrans_listid=$id AND accounttrans_date BETWEEN '$tglawal' AND '$tglakhir'");
        $query3 = $this->db->query("SELECT listakun_pattern FROM coa_listakun WHERE listakun_id=$id");
        $data1 = $query1->result_array();
        
        $data2 = $query2->result_array();
        $data3 = $query3->result_array();
        $item = substr($data3[0]["listakun_pattern"],0,2);
        if($item == "5*"){
        	///525.02
        	///525.32
        	///525.52
        	if(($id =="349")||($id =="348")||($id =="350")||($id =="352")||($id =="353") ||($id =="342")||($id =="343") ||($id == "325")||($id == "326")||($id == "327")||($id == "328")||($id == "329")||($id == "330") || ($id == "334")||($id == "335")||($id == "336")||($id == "337")||($id == "338")||($id == "339")){
        		$trans  = $data1[0]["jlh1"] * -1;
        	}else{
        		$trans  = $data1[0]["jlh1"] * 1;
        	}
        }elseif($item == "6*"){
        	$trans  = $data1[0]["jlh1"] * -1;
        }elseif($item == "7*"){
        	$trans  = $data2[0]["jlh2"] * 1;
        }else{
        	$trans  = ($data2[0]["jlh2"] - $data1[0]["jlh1"]) * 1;
        }
        return $trans;
    }
    function cetak()
	{
        $this->load->view('cetak/laporan');
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