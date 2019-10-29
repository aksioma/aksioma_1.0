<?php
/*
 * Aplikasi BMT v1.0
 * Copyright (c) 2013
 *
 * file   : basil.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Basil extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
        
	}
	
	function index()
	{
        $tglawal = "2014-10-01";
        $tglakhir = "2014-10-07";
        $hari = substr($tglawal,8,2);
        $bulan = substr($tglakhir,5,2);
        $tahun = substr($tglakhir,0,4);
        
        $s = strtotime($tglawal);
        $e = strtotime($tglakhir);
        $jlhH = ($e - $s)/ (24 *3600);
        $nomor_rek = "";
        $saldo = 0;
        $saldor = 0;
        $saldorr = 0;
        $saldo_rata = 0;
        $ptitle ="";
        $i = 1;
        for($a=floor($hari);$a<=$jlhH + 1;$a++){
            if($a<10){$hri = "0".$a;}else{$hri = $a;}
            $query1 = $this->db->query("SELECT accounttrans_user,`accounttrans_date`,SUM(CASE WHEN accounttrans_type like '01' THEN accounttrans_value END) AS jlh1,
                                        SUM(CASE WHEN accounttrans_type like '02' THEN accounttrans_value END) AS jlh2 
                                        FROM tb_accounttrans 
                                        WHERE accounttrans_listid=203  
                                        AND DAY(accounttrans_date) ='$hri' AND MONTH(accounttrans_date) ='$bulan' AND YEAR(accounttrans_date)='$tahun'
                                        GROUP BY accounttrans_user,`accounttrans_date`");
            $data1 = $query1->result_array();
            if($query1->num_rows() > 0) {
                $nomor_rek = $data1[0]["accounttrans_user"];
                $saldo += ($data1[0]["jlh1"] - $data1[0]["jlh2"]) * 1;
                $saldor += $saldo;
                $saldorr = floor($saldor / $i);
                //$ptitle .= $nomor_rek." = ".number_format($saldo,0)." = ".number_format($saldor,0)." / ".$a." ".$i." : ".number_format($saldorr,0)."<br>";
                $saldo_rata = $saldorr;
                $i++;
            }else{
                $saldor += $saldo;
                $saldorr = floor($saldor / $i);
                //$ptitle .= $nomor_rek." = ".number_format($saldo,0)." = ".number_format($saldor,0)." / ".$a." ".$i." : ".number_format($saldorr,0)."<br>";
                $saldo_rata = $saldorr;
                if($saldo !=0){
                    $i++;
                }
            }
            
        }
        echo $saldo_rata;
	}
    
}

/* End of file */