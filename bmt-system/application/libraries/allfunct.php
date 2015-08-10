<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : libraries/allfunct.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Allfunct {
	var $CI;
	var $dasar = array(1=>'satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan');
	var $angka = array(1000000000,1000000,1000,100,10,1);
	var $satuan = array('milyar','juta','ribu','ratus','puluh','');
	
    //---- Konstruktor
    function  __construct() {
		//$this->CI =& get_instance();
        $this->CI = get_instance();
	}

/*
 * -------------------- SETUP APP ------------------------------------------------------
 */
    //---- Get Setup App
    function getSetupapp($tem)
    {
        $hasil = $this->CI->db->get_where('setupapp', array('name_setup' => $tem))->result_array();
        return $hasil[0]['value'];
    }
    //---- Get Menu active
    function getmenuActive($tem)
    {
        return $tem;
    }
    //---- Update Setup App
    function setSetupapp($key,$val)
    {
        return $this->CI->db->where('name_setup', $key)->update('setupapp', array('value' => $val));
    }
    //--- menu app
    function loadMenu($parent)
    {
    	$hasil = $this->master->getAllMenu($parent);
    	if ($hasil)
    	{
    		$this->isi[] = "<ul>";
    		foreach($hasil as $item)
    		{
    			$groupx = unserialize($item['groups']);
    			if (in_array($this->nama_group, $groupx))
    			{
    				if($this->menuact == $item['css']){$active = "active";}else{$active = "";}
    				if($item['href'] == "."){
    					$this->isi[] = "<li class=\"start $active\"><a href=\".\"><i class=\"icon-home\"></i> <span class=\"title\">Dashboard</span></a>";
    				}else{
    					$this->isi[] = "<li class=\"has-sub $active\"><a href=\"javascript:;\">".$item['icon']."<span class=\"title\"> ".$item['nama']."</span><span class=\"arrow\"></span></a>";
    				}
    				$submenu = $this->master->getAllMenu($item['menu_id']);
    				if ($submenu)
    				{
    					$this->isi[] = "<ul class=\"sub\">";
    					foreach($submenu as $item1)
    					{
    						$groupx = unserialize($item['groups']);
    						if (in_array($this->nama_group, $groupx))
    						{
    							if($this->menuactsub == $item1['sub']){$activesub = "class='active'";}else{$activesub = "";}
    							$this->isi[] = "<li $activesub> <a href=\"".$item1['href']."\">".$item1['nama']."</a></li>";
    						}
    					}
    					$this->isi[] = "</ul>";
    				}
    			}
    		}
    		$this->isi[] = "</ul>";
    	} else {
    		$this->isi[] = "</li>";
    	}
    }
    
    function uangDB($nilai) {
		$nilai =  str_replace("Rp, ", "", $nilai);
		$nilai =  str_replace(".", "", $nilai);
		$nilai =  str_replace(",", ".", $nilai);
		$nilai =  str_replace("_", "", $nilai);
		return $nilai;
	}
/*
 * -------------------- TANGGALAN ------------------------------------------------------
 */
	function revDate($date) {
		$date = explode("-",$date);
		$date = $date[2]."-".$date[1]."-".$date[0];
		return $date;
	}
	
	
	
	function getTglReg($date) {
		$date = explode("-",$date);
		$bl = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		$bln = $bl[$date[1]];
		$date = $date[0]."-".$bln."-".$date[2];
		return $date;
	}
	
	
	function getBirthDate($date) {
		$month = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		$day = date("j",strtotime($date));
		$mnt = $month[date("n",strtotime($date))];
		$year = date("Y", strtotime($date) );
		$bd = "$day $mnt $year";
		return $bd;
	}
	
	function getShortDate($date) {
		$day = date("j",strtotime($date));
		$mnt = date("M",strtotime($date));
		$year = date("Y", strtotime($date));
		$date = "$day-$mnt-$year";
		return $date;
	}

	function findInArray ($string, $arry = array ()) {       
        $i=-1;
        $s = array();
        foreach ($arry as $array) {
            $i++;
            foreach ($array as $key => $value) {
                if (strpos($value, $string) !== false) {
                        $s = array_merge($s,array($arry[$i]));
                }
            }       
        }
        return $s;   	
  	}
	
	function Terbilang($n) {
	    $i=0;
	    $str = '';
	    while($n!=0){
	        $count = (int)($n/$this->angka[$i]);
	        if($count>=10) $str .= $this->Terbilang($count). " ".$this->satuan[$i]." ";
	        else if($count > 0 && $count < 10)
	            $str .= $this->dasar[$count] . " ".$this->satuan[$i]." ";
            $n -= $this->angka[$i] * $count;
            $i++;
        }
        $str = preg_replace("/satu puluh (\w+)/i","\\1 belas",$str);
        $str = preg_replace("/satu (ribu|ratus|puluh|belas)/i","Se\\1",$str);
        return $str;
	}
	
	function rupiah($nilai) {
		return 'Rp. '.number_format($nilai, 0, ",", ".").',-';
	}
	
	function nilai($nilai) {
		return number_format($nilai, 0, ",", ".");
	}

/*
 * -------------------- MENDAPATKAN ARRAY HASIL POST YANG SECURE ----------------------
 */
	function securePost() {
		$post = $_POST;
		foreach ($post as $key => $val) {
            $dt[$key] = $this->CI->input->post($key);
		}
		return $dt;
	}

/*
 * ---- Cetak Bulan
 */
    function cetakbulan()
    {
        $isi = "<select class=\"selbln\">";
        $isi .= "<option value=\"01\">Januari</option>";
        $isi .= "<option value=\"02\">Februari</option>";
        $isi .= "<option value=\"03\">Maret</option>";
        $isi .= "<option value=\"04\">April</option>";
        $isi .= "<option value=\"05\">Mei</option>";
        $isi .= "<option value=\"06\">Juni</option>";
        $isi .= "<option value=\"07\">Juli</option>";
        $isi .= "<option value=\"08\">Agustus</option>";
        $isi .= "<option value=\"09\">September</option>";
        $isi .= "<option value=\"10\">Oktober</option>";
        $isi .= "<option value=\"11\">November</option>";
        $isi .= "<option value=\"12\">Desember</option>";
        $isi .= "</select>";
        return $isi;
    }

    function dayofdate()
    {
        $hari = array("Sun" => "Minggu", "Mon" => "Senin", "Tue" => "Selasa", "Wed" => "Rabu", "Thu" => "Kamis", "Fri" => "Jum'at", "Sat" => "Sabtu");
        return $hari[date("D", strtotime('29-06-2009'))];
    }

// ---- Fungsi mendapatkan nama tema dari dalam css/themes
	function scanThemes()
	{
		$root = ('./assets/css/themes/');
		$hasil = scandir($root);
		foreach($hasil as $val)
		{
			if((is_dir($root.$val) == TRUE) AND (!preg_match('/^\./',$val)))
			{
				$direk[] = $val;
			}
		}
		return $direk;
	}
//----- menghitung jumlah hari
	function tenggang($tenggang,$tgl=false){
	    if(!$tgl){
	        $tgl = date('Y-m-d');
	    }
	    $pecah = explode("-",$tgl);
	    $tambah = mktime(0,0,0,$pecah[1],$pecah[2]+$tenggang,$pecah[0]); // Y-m-d
	    $besok = date("Y-m-d", $tambah);
	    return $besok;
	}
	function dateRange($start,$end){
        $xdate    = $this->frmDate($start,4);
        $ydate    = $this->frmDate($end,4);
        $xmonth   = $this->frmDate($start,5);
        $ymonth   = $this->frmDate($end,5);
        $xyear    = $this->frmDate($start,6);
        $yyear    = $this->frmDate($end,6);
        // Jika Input tanggal berada ditahun yang sama
        if($xyear==$yyear){
            // Jika Input tanggal berada dibulan yang sama
            if($xmonth==$ymonth){
                $nday=$ydate+1-$xdate;
            } else {
                $r2=NULL;
                $nmonth = $ymonth-$xmonth;            
                $r1 = $this->nmonth($xmonth)-$xdate+1;
                for($i=$xmonth+1;$i<$ymonth;$i++){
                    $r2 = $r2+ $this->nmonth($i);
                }
                $r3 = $ydate;
                $nday = $r1+$r2+$r3;
            }
        } else {
            // Jika Input tahun awal berbeda dengan tahun akhir
            $r2=NULL; $r3=NULL;
            $r1=$this->nmonth($xmonth)-$xdate+1;

            for($i=$xmonth+1;$i<13;$i++){
                $r2 = $r2+$this->nmonth($i);
            }
            for($i=1;$i<$ymonth;$i++){
                $r3 = $r3+$this->nmonth($i);
            }
            $r4 = $ydate;
            $nday = $r1+$r2+$r3+$r4;
        }            
        return $nday;
	}
	function nmonth($month){
        $thn_kabisat = date("Y") % 4;
        ($thn_kabisat==0)?$feb=29:$feb=28;
        $init_month = array(1=>31,    // Januari
                            2=>$feb,    // Feb
                            3=>31,    // Mar
                            4=>30,    // Apr
                            5=>31,    // Mei
                            6=>30,    // Juni
                            7=>31,    // Juli
                            8=>31,    // Aug
                            9=>30,    // Sep
                            10=>31,    // Oct    
                            11=>30,    // Nov
                            12=>31);// Des
        $nmonth = $init_month[$month];
        return $nmonth;
	}
    
	function frmDate($date,$code){
        $explode = explode("-",$date);
        $year  = $explode[0];
        $month = (substr($explode[1],0,1)=="0")?str_replace("0","",$explode[1]):$explode[1];
        $dated = $explode[2];
        $explode_time = explode(" ",$dated);
        $dates = $explode_time[0];
        switch($code){
            case 4: $format = $dates; break;                                                    
            case 5: $format = $month; break;                                                        
            case 6: $format = $year; break;                
        }        
        return $format; 
	}
	function datatocsv($fileName, $assocDataArray){
		ob_clean();
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment;filename=' . $fileName);
		if(isset($assocDataArray['0'])){
			$fp = fopen('php://output', 'w');
			fputcsv($fp, array_keys($assocDataArray['0']));
			foreach($assocDataArray AS $values){
				fputcsv($fp, $values);
			}
			fclose($fp);
		}
		ob_flush();
	}
//-----------------------
}
/* End of file */