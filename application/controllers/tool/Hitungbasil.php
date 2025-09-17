<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/hitungbasil.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Hitungbasil extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "tools";
        $this->menuactsub = "hitungbasil";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('tool/hitungbasil',$data);
	}
	function distribusiprofit(){
		$tglawal = $this->allfunct->revDate($this->input->post('tgl1'));
        $tglakhir = $this->allfunct->revDate($this->input->post('tgl2'));
        //distribusi bonus
        $query = $this->db->query("SELECT gl_produk,gl_bagihasil FROM master_tabungan");
        $data = $query->result_array();
        $glproduk = $data[0]["gl_produk"];
        $glbonus = $data[0]["gl_bagihasil"];
        $hasil = $this->db->query("SELECT basilwadiah_value AS jlh,basilwadiah_code,basilwadiah_rek  FROM tb_basilwadiah WHERE start_date >='$tglawal' AND end_date <='$tglakhir'")->result();
        foreach ($hasil as $row){
        	$data1['accounttrans_listid'] = $glbonus;
			$data1['accounttrans_date'] = date('Y-m-d');
			$data1['accounttrans_code'] = $glbonus." - ".$row->basilwadiah_rek;
			$data1['accounttrans_type'] = '02';
			$data1['accounttrans_value'] = $row->jlh;
			$data1['accounttrans_desc'] = "BONUS WADIAH - ".$row->basilwadiah_rek;
			$data1['accounttrans_user'] = $row->basilwadiah_rek;
			$data1['create_date'] = date("Y-m-d H:i:s");
			$data1['create_by'] = $this->session->userdata('username');
			$data1['update_by'] = $this->session->userdata('username');
			$this->master->simpan('tb_accounttrans',$data1);
			//$data1['accounttrans_posted'] = '1';
			//$this->master->simpan('tb_accounttemp',$data1);
			
			$data2['accounttrans_listid'] = $glproduk;
			$data2['accounttrans_date'] = date('Y-m-d');
			$data2['accounttrans_code'] = $glproduk." - ".$row->basilwadiah_rek;
			$data2['accounttrans_type'] = '01';
			$data2['accounttrans_value'] = $row->jlh;
			$data2['accounttrans_desc'] = "BONUS WADIAH";
			$data2['accounttrans_user'] = $row->basilwadiah_rek;
			$data2['create_date'] = date("Y-m-d H:i:s");
			$data2['create_by'] = $this->session->userdata('username');
			$data2['update_by'] = $this->session->userdata('username');
			$this->master->simpan('tb_accounttrans',$data2);
			//$data2['accounttrans_posted'] = '1';
			//$this->master->simpan('tb_accounttemp',$data2);
		}
		
		//distribusi basil
		$basiln = 0;
		$hasil = $this->db->query("SELECT basiltrans_value AS jlh,kode_produk,basiltrans_rek FROM tb_basiltrans WHERE basiltrans_type=0 AND start_date >='$tglawal' AND end_date <='$tglakhir'")->result();
        foreach ($hasil as $row){
        	$basiln = $row->jlh;
        	$query = $this->db->query("SELECT gl_produk,gl_bagihasil,gl_titipanbagihasil FROM master_deposito WHERE kode_produk='".$row->kode_produk."'");
        	$data = $query->result_array();
        	$glproduk = $data[0]["gl_produk"];
        	$glbasil = $data[0]["gl_bagihasil"];
        	$gltitipanbasil = $data[0]["gl_titipanbagihasil"];
        	// cek rekening nasabah
        	$query1 = $this->db->query("SELECT rekening_basil FROM tb_deposito WHERE nomor_rekening='".$row->basiltrans_rek."'");
        	$dataa = $query1->result_array();
        	$rekening_basil = $dataa[0]["rekening_basil"];
        	if(isset($rekening_basil)){
        		$data1['accounttrans_listid'] = $glbasil;
        		$data1['accounttrans_date'] = date('Y-m-d');
        		$data1['accounttrans_code'] = $glbasil." - ".$rekening_basil;
        		$data1['accounttrans_type'] = '02';
        		$data1['accounttrans_value'] = $basiln;
        		$data1['accounttrans_desc'] = "BASIL - ".$rekening_basil;
        		$data1['accounttrans_user'] = $rekening_basil;
        		$data1['create_date'] = date("Y-m-d H:i:s");
        		$data1['create_by'] = $this->session->userdata('username');
        		$data1['update_by'] = $this->session->userdata('username');
        		$this->master->simpan('tb_accounttrans',$data1);
        		//$data1['accounttrans_posted'] = '1';
        		//$this->master->simpan('tb_accounttemp',$data1);
        		
        		$data2['accounttrans_listid'] = $glproduk;
        		$data2['accounttrans_date'] = date('Y-m-d');
        		$data2['accounttrans_code'] = $glproduk." - ".$rekening_basil;
        		$data2['accounttrans_type'] = '01';
        		$data2['accounttrans_value'] = $basiln;
        		$data2['accounttrans_desc'] = "BASIL";
        		$data2['accounttrans_user'] = $rekening_basil;
        		$data2['create_date'] = date("Y-m-d H:i:s");
        		$data2['create_by'] = $this->session->userdata('username');
        		$data2['update_by'] = $this->session->userdata('username');
        		$this->master->simpan('tb_accounttrans',$data2);
        		//$data2['accounttrans_posted'] = '1';
        		//$this->master->simpan('tb_accounttemp',$data2);
        	}else{
        		$data1['accounttrans_listid'] = $gltitipanbasil;
        		$data1['accounttrans_date'] = date('Y-m-d');
        		$data1['accounttrans_code'] = $gltitipanbasil." - ".$row->basiltrans_rek;
        		$data1['accounttrans_type'] = '02';
        		$data1['accounttrans_value'] = $basiln;
        		$data1['accounttrans_desc'] = "BASIL - ".$row->basiltrans_rek;
        		$data1['accounttrans_user'] = $row->basiltrans_rek;
        		$data1['create_date'] = date("Y-m-d H:i:s");
        		$data1['create_by'] = $this->session->userdata('username');
        		$data1['update_by'] = $this->session->userdata('username');
        		$this->master->simpan('tb_accounttrans',$data1);
        		//$data1['accounttrans_posted'] = '1';
        		//$this->master->simpan('tb_accounttemp',$data1);
        		
        		$data2['accounttrans_listid'] = $glproduk;
        		$data2['accounttrans_date'] = date('Y-m-d');
        		$data2['accounttrans_code'] = $glproduk." - ".$row->basiltrans_rek;
        		$data2['accounttrans_type'] = '01';
        		$data2['accounttrans_value'] = $basiln;
        		$data2['accounttrans_desc'] = "BASIL";
        		$data2['accounttrans_user'] = $row->basiltrans_rek;
        		$data2['create_date'] = date("Y-m-d H:i:s");
        		$data2['create_by'] = $this->session->userdata('username');
        		$data2['update_by'] = $this->session->userdata('username');
        		$this->master->simpan('tb_accounttrans',$data2);
        		//$data2['accounttrans_posted'] = '1';
        		//$this->master->simpan('tb_accounttemp',$data2);
        	}
		}
	}
	function rincianbasil2(){
		$tglawal = $this->allfunct->revDate($this->input->post('tgl1'));
        $tglakhir = $this->allfunct->revDate($this->input->post('tgl2'));
        $hasil = $this->db->query("SELECT basil_rek,basil_value,basil_type FROM tb_basil WHERE basil_rek !='P001' AND end_date='$tglakhir'")->result();
        $isi = "";
        $basilbonus = 0;
		
		foreach ($hasil as $row)
		{
    		$nomor_rekening = $row->basil_rek;
    		if($row->basil_type == 2){
	    		$query1 = $this->db->query("SELECT nama FROM tb_nasabah AS t1 INNER JOIN tb_tabungan AS t2 ON t1.nomor_nasabah = t2.nomor_nasabah WHERE nomor_rekening='$nomor_rekening'");
	    		$query2 = $this->db->query("SELECT basilwadiah_value AS jlh FROM tb_basilwadiah WHERE basilwadiah_rek='$nomor_rekening' AND end_date='$tglakhir'");
    		}elseif($row->basil_type == 3){
	    		$query1 = $this->db->query("SELECT nama FROM tb_nasabah AS t1 INNER JOIN tb_deposito AS t2 ON t1.nomor_nasabah = t2.nomor_nasabah WHERE nomor_rekening='$nomor_rekening'");
    			$query2 = $this->db->query("SELECT basiltrans_value AS jlh FROM tb_basiltrans WHERE basiltrans_rek='$nomor_rekening' AND end_date='$tglakhir'");
    		}elseif($row->basil_type == 5){
	    		$query1 = $this->db->query("SELECT nama FROM tb_nasabah AS t1 INNER JOIN tb_deposito AS t2 ON t1.nomor_nasabah = t2.nomor_nasabah WHERE nomor_rekening='$nomor_rekening'");
    		}
    		$data = $query1->result_array();
    		if($query1->num_rows() > 0) {
				$nama  = $data[0]["nama"];
			}
			$data1 = $query2->result_array();
			if($query2->num_rows() > 0) {
				$basilbonus  = $data1[0]["jlh"];
			}else{
				$basilbonus = 0;
			}
			
    		$isi .= "<tr><td align=\"left\">".$nomor_rekening."</td><td>".$nama."</td><td align='center'>".$this->allfunct->revDate($tglawal)."</td><td align='center'>".$this->allfunct->revDate($tglakhir)."</td>";
            $isi .= "<td align='right'>".$this->allfunct->rupiah($row->basil_value)."</td><td align='right'>".$this->allfunct->rupiah($basilbonus)."</td></tr>";
        }
        echo $isi;
	}
	function rincianbasil1(){
		$tglawal = $this->allfunct->revDate($this->input->post('tgl1'));
        $tglakhir = $this->allfunct->revDate($this->input->post('tgl2'));
        $hasil = $this->db->query("SELECT listakun_id,listakun_code,listakun_name,nama_produk FROM coa_listakun AS t1 INNER JOIN tb_akunperhimpunan AS t2 ON t2.akun=t1.listakun_id")->result();
        $isi = "";
        $totalsaldor = 0;
		$saldor = 0;
		$saldor1 = 0;
		foreach ($hasil as $row)
		{
    		$saldor = $this->transnilaivalue(0,$row->listakun_id,$tglawal,$tglakhir);
    		$saldor1 = $this->transnilaivalue(1,$row->listakun_id,$tglawal,$tglakhir);
    		$isi .= "<tr><td align=\"left\">".$row->nama_produk."</td><td>".$row->listakun_code." ".$row->listakun_name."</td>";
            $isi .= "<td align='right'>".$this->allfunct->rupiah($saldor)."</td><td align='right'>".$this->allfunct->rupiah($saldor1)."</td></tr>";
            $totalsaldor += $saldor;
        }
        echo $isi;
	}
	function transnilaivalue($type,$id,$tglawal,$tglakhir){
		if($id == "203"){
			$query1 = $this->db->query("SELECT SUM(basilwadiah_value) AS jlh FROM tb_basilwadiah WHERE basilwadiah_type=$type AND basilwadiah_code='$id' AND end_date='$tglakhir'");
		}else{
			$query1 = $this->db->query("SELECT SUM(basiltrans_value) AS jlh FROM tb_basiltrans WHERE basiltrans_type=$type AND basiltrans_code='$id' AND end_date='$tglakhir'");
		}
        $data1 = $query1->result_array();
        $trans  = $data1[0]["jlh"] * 1;
        return $trans;
    }
	function rinciansaldorata(){
		$tglawal = $this->allfunct->revDate($this->input->post('tgl1'));
        $tglakhir = $this->allfunct->revDate($this->input->post('tgl2'));
        $hasil = $this->db->query("SELECT listakun_id,listakun_code,listakun_name,nama_produk FROM coa_listakun AS t1 INNER JOIN tb_akunperhimpunan AS t2 ON t2.akun=t1.listakun_id")->result();
        $isi = "";
        $totalsaldor = 0;
		$saldor = 0;
		foreach ($hasil as $row)
		{
    		$saldor = $this->nilaivalue($row->listakun_id,$tglawal,$tglakhir);
    		$isi .= "<tr><td align=\"left\">".$row->nama_produk."</td><td>".$row->listakun_code." ".$row->listakun_name."</td>";
            $isi .= "<td align='right'>".$this->allfunct->rupiah($saldor)."</td></tr>";
            $totalsaldor += $saldor;
        }
        echo $isi;
	}
	function nilaivalue($id,$tglawal,$tglakhir){
        $query1 = $this->db->query("SELECT SUM(basil_value) AS jlh FROM tb_basil WHERE basil_code='$id' AND start_date='$tglawal' AND end_date='$tglakhir'");
        $data1 = $query1->result_array();
        $trans  = $data1[0]["jlh"] * 1;
        return $trans;
    }
	function hitungbasilwadiah(){
		$pBasilW = 0;
		$tglawal = $this->allfunct->revDate($this->input->post('tgl1'));
        $tglakhir = $this->allfunct->revDate($this->input->post('tgl2'));
        $bonusdibagi = $this->input->post('bonusdibagi');
        $minsaldo = $this->input->post('minsaldo');
        //total saldo ratarata
        $query = $this->db->query("SELECT sum(basil_value) AS Tot FROM tb_basil WHERE basil_value >'".$minsaldo."' AND basil_type=2 AND end_date='$tglakhir' AND basil_rek !='P001'");
        $data = $query->result_array();
        $totalRata = $data[0]["Tot"];
        $this->db->query("TRUNCATE TABLE `tb_basilwadiah`");
        
        $hasil = $this->db->query("SELECT DISTINCT(basil_rek),basil_value,basil_code 
        							FROM tb_basil WHERE basil_value >'".$minsaldo."' AND 
        							basil_type=2 AND end_date='$tglakhir' AND basil_rek !='P001'")->result();;
        foreach ($hasil as $row){
	        $nomor_rekening = $row->basil_rek;
	        $totalrata2 = $row->basil_value;
	        $basil_code = $row->basil_code;
	        $basilUser = ($totalrata2 / $totalRata) * $bonusdibagi;
	        //echo $totalrata2."/".$totalRata."*".$bonusdibagi;
	        if($basilUser !=0){
            	//hapus dulu
            	$datenow = date("Y-m-d");  
				//$where = array('basilwadiah_rek' => $nomor_rekening,'end_date' => $this->allfunct->revDate($this->input->post('tgl2')));
				//$this->master->delete("tb_basilwadiah",$where);
				//$query = $this->db->query("DELETE FROM tb_basil WHERE basil_rek");
				//masukkan ke tb_basil
				$basil['basilwadiah_rek'] = $nomor_rekening;
				$basil['basilwadiah_code'] = $basil_code;
				$basil['tanggal'] = $datenow;
				$basil['start_date'] = $this->allfunct->revDate($this->input->post('tgl1'));
				$basil['end_date'] = $this->allfunct->revDate($this->input->post('tgl2'));
				$basil['basilwadiah_value'] = $basilUser;
				$basil['create_by'] = $this->session->userdata('username');
				$basil['update_by'] = $this->session->userdata('username');
				$this->master->simpan('tb_basilwadiah',$basil);
				$pBasilW += $basilUser;
            }
	    }
		echo $pBasilW;
	}
	function hitungbasiltotol(){
		$pBasil = 0;
		$tglawal = $this->allfunct->revDate($this->input->post('tgl1'));
        $tglakhir = $this->allfunct->revDate($this->input->post('tgl2'));
        $hari = substr($tglawal,8,2);
        $bulan = substr($tglakhir,5,2);
        $tahun = substr($tglakhir,0,4);
        //saldo pendapatan
        $query = $this->db->query("SELECT basil_value FROM tb_basil WHERE end_date='$tglakhir' AND basil_rek='P001'");
        $data = $query->result_array();
        $pendTot = $data[0]["basil_value"];
        //Total dpk
        $query = $this->db->query("SELECT sum(basil_value) AS Tot FROM tb_basil WHERE end_date='$tglakhir' AND basil_rek !='P001'");
        $data = $query->result_array();
        $dpk = $data[0]["Tot"];
        
        $basilUser = 0;
        $basilBank = 0;
        $this->db->query("TRUNCATE TABLE `tb_basiltrans`");
        
        $hasil = $this->db->query("SELECT DISTINCT(basil_rek),basil_value,basil_type,basil_code FROM tb_basil WHERE end_date='$tglakhir' AND basil_rek !='P001'")->result();;
        foreach ($hasil as $row){
	        $nomor_rekening = $row->basil_rek;
	        $totalrata2 = $row->basil_value;
	        $basil_code = $row->basil_code;
	        //hitung basil simpanan
	        if($row->basil_type == 2){
	        	$query = $this->db->query("SELECT kode_produk 
											FROM master_tabungan INNER JOIN tb_tabungan ON master_tabungan.kode_produk = tb_tabungan.jenis_simpanan WHERE nomor_rekening ='$nomor_rekening'");
		        $data = $query->result_array();
		        $kode_produk = $data[0]["kode_produk"];
		        
		        $basilUser = ($row->basil_value / $dpk) * $pendTot;
	        }
	        // hitung basil deposito
	        if($row->basil_type == 3){
		        $query = $this->db->query("SELECT nisbah_nasabah, 
											nisbah_bank,
											nisbah_tambahan,kode_produk 
											FROM master_deposito INNER JOIN tb_deposito ON master_deposito.kode_produk = tb_deposito.nama_produk WHERE nomor_rekening ='$nomor_rekening'");
		        $data = $query->result_array();
		        $kode_produk = $data[0]["kode_produk"];
		        $nisbah_bank = $data[0]["nisbah_bank"];
		        $nisbah_nasabah = $data[0]["nisbah_nasabah"];
		        $nisbah_tambahan = $data[0]["nisbah_tambahan"];
		        $nisbahAllbank = $nisbah_bank - $nisbah_tambahan;
		        $nisbahAllNasabah = $nisbah_nasabah + $nisbah_tambahan;
		        
		        $basilUser = ($totalrata2 / $dpk) * ($nisbahAllNasabah / 100) * $pendTot;
		        $basilBank = ($totalrata2 / $dpk) * ($nisbahAllbank / 100) * $pendTot;
		    }
	        if($basilUser !=0){
            	//hapus dulu
            	$datenow = date("Y-m-d");  
				//masukkan ke tb_basil
				$basil['basiltrans_rek'] = $nomor_rekening;
				$basil['basiltrans_code'] = $basil_code;
				$basil['kode_produk'] = $kode_produk;
				$basil['tanggal'] = $datenow;
				$basil['start_date'] = $this->allfunct->revDate($this->input->post('tgl1'));
				$basil['end_date'] = $this->allfunct->revDate($this->input->post('tgl2'));
				$basil['basiltrans_type'] = '0';
				$basil['basiltrans_value'] = $basilUser;
				$basil['create_by'] = $this->session->userdata('username');
				$basil['update_by'] = $this->session->userdata('username');
				$this->master->simpan('tb_basiltrans',$basil);
				
				//hapus dulu bank
            	$datenow = date("Y-m-d");  
				//masukkan ke tb_basil
				$basil1['basiltrans_rek'] = 'BANK01';
				$basil1['basiltrans_code'] = $basil_code;
				$basil1['tanggal'] = $datenow;
				$basil1['start_date'] = $this->allfunct->revDate($this->input->post('tgl1'));
				$basil1['end_date'] = $this->allfunct->revDate($this->input->post('tgl2'));
				$basil1['basiltrans_type'] = '1';
				$basil1['basiltrans_value'] = $basilBank;
				$basil1['create_by'] = $this->session->userdata('username');
				$basil1['update_by'] = $this->session->userdata('username');
				$this->master->simpan('tb_basiltrans',$basil1);
				$pBasil += $basilUser;
            }
	    }
	    echo $pBasil;
	}
    function hitung(){
        $saldo_rataOK = 0;
        $tglawal = $this->allfunct->revDate($this->input->post('tgl1'));
        $tglakhir = $this->allfunct->revDate($this->input->post('tgl2'));
        $this->db->query("TRUNCATE TABLE `tb_basil`");
				
        /*$hasil = $this->db->query("SELECT accounttrans_date,accounttrans_user,COUNT(*) 
									FROM tb_accounttrans AS t1
									INNER JOIN tb_deposito AS t2 ON t2.nomor_rekening=t1.accounttrans_user
									WHERE accounttrans_direct=1 AND date(jatuh_tempo) BETWEEN '$tglawal' AND '$tglakhir'
									GROUP BY accounttrans_user")->result();
									*/
        /*$hasil = $this->db->query("SELECT accounttrans_date,accounttrans_user,COUNT(*) 
									FROM tb_accounttrans AS t1
									WHERE accounttrans_user !=0 AND accounttrans_date BETWEEN '$tglawal' AND '$tglakhir'	
									GROUP BY accounttrans_user")->result();*/
        $hasil = $this->db->query("SELECT accounttrans_date,accounttrans_user,COUNT(*) AS jlhtrans 
									FROM tb_accounttrans AS t1
									WHERE accounttrans_user !=0 AND accounttrans_date <='$tglakhir'	
									GROUP BY accounttrans_user")->result();
        foreach ($hasil as $row){
    		$nomor_rekening = $row->accounttrans_user;
            $startdate = $row->accounttrans_date;
			$enddate   = $tglakhir;
			$jhhari    = $this->allfunct->dateRange($startdate,$enddate);
			$xdate     = $this->allfunct->frmDate($startdate,4);
			$ydate     = $this->allfunct->frmDate($enddate,4);
			$xmonth    = $this->allfunct->frmDate($startdate,5);
			$ymonth    = $this->allfunct->frmDate($enddate,5);
			$xyear     = $this->allfunct->frmDate($startdate,6);
			$yyear     = $this->allfunct->frmDate($enddate,6);
			
			$saldo = 0;
            $saldor = 0;
            $saldorr = 0;
            $saldo_rata = 0;
            $ptitle ="";
        	$i = 1;
            for($a=0;$a< $jhhari;$a++){
    			$datenext = $this->allfunct->tenggang($a,$startdate);
	    		$query1 = $this->db->query("SELECT accounttrans_user,`accounttrans_date`,SUM(CASE WHEN accounttrans_type like '01' THEN accounttrans_value END) AS jlh1,
	                                        SUM(CASE WHEN accounttrans_type like '02' THEN accounttrans_value END) AS jlh2 
	                                        FROM tb_accounttrans 
	                                        WHERE accounttrans_listid=203  AND accounttrans_user='".$nomor_rekening."'
	                                        AND accounttrans_date ='$datenext' 
	                                        GROUP BY accounttrans_user,`accounttrans_date`");
	            $data1 = $query1->result_array();
	            if($query1->num_rows() > 0) {
	                $saldo += ($data1[0]["jlh1"] - $data1[0]["jlh2"]) * 1;
	                $saldor += $saldo;
	                $saldorr = floor($saldor / $i);
	                $ptitle .= $nomor_rekening." = ".number_format($saldo,0)." = ".number_format($saldor,0)." / ".$a." ".$i." : ".number_format($saldorr,0)."<br>";
	                $saldo_rata = $saldorr;
	                $i++;
	            }else{
	                $saldor += $saldo;
	                $saldorr = floor($saldor / $i);
	                $ptitle .= $nomor_rekening." = ".number_format($saldo,0)." = ".number_format($saldor,0)." / ".$a." ".$i." : ".number_format($saldorr,0)."<br>";
	                $saldo_rata = $saldorr;
	                if($saldo !=0){
	                    $i++;
	                }
	            }
			}
            if($saldo_rata !=0){
            	//hapus dulu detail 
				//$where = array('basil_rek' => $nomor_rekening,'end_date' => $this->allfunct->revDate($this->input->post('tgl2')));
				//$this->master->delete("tb_basil",$where);
				//masukkan ke tb_basil
				$basil['basil_code'] = '203';
				$basil['basil_rek'] = $nomor_rekening;
				$basil['start_date'] = $this->allfunct->revDate($this->input->post('tgl1'));
				$basil['end_date'] = $this->allfunct->revDate($this->input->post('tgl2'));
				$basil['basil_value'] = $saldo_rata;
				$basil['basil_type'] = '2';
				$basil['create_by'] = $this->session->userdata('username');
				$basil['update_by'] = $this->session->userdata('username');
				$this->master->simpan('tb_basil',$basil);
				$saldo_rataOK += $saldo_rata;
            }
        }
        // saldo rata-rata deposito
        $saldo_rata1OK = 0;
        $code = array('257','258','259','260');
        for($aa=0;$aa<count($code);$aa++){
        	$hasil1 = $this->db->query("SELECT accounttrans_date,accounttrans_user,COUNT(*) FROM tb_accounttrans WHERE accounttrans_listid ='".$code[$aa]."' GROUP BY accounttrans_user")->result();
        	foreach ($hasil1 as $row){
        		$nomorrekeningdepo = $row->accounttrans_user;
            	$startdate = $row->accounttrans_date;
				$enddate   = $tglakhir;
				$jhhari    = $this->allfunct->dateRange($startdate,$enddate);
				$xdate     = $this->allfunct->frmDate($startdate,4);
				$ydate     = $this->allfunct->frmDate($enddate,4);
				$xmonth    = $this->allfunct->frmDate($startdate,5);
				$ymonth    = $this->allfunct->frmDate($enddate,5);
				$xyear     = $this->allfunct->frmDate($startdate,6);
				$yyear     = $this->allfunct->frmDate($enddate,6);
				$nomor_rek = "";
            	$saldo = 0;
            	$saldor = 0;
            	$saldorr = 0;
            	$saldo_rata = 0;
            	$ptitle ="";
            	$i = 1;
				for($a=0;$a< $jhhari;$a++){
    				$datenext = $this->allfunct->tenggang($a,$startdate);
					$query1 = $this->db->query("SELECT accounttrans_user,`accounttrans_date`,SUM(CASE WHEN accounttrans_type like '01' THEN accounttrans_value END) AS jlh1,
                                            SUM(CASE WHEN accounttrans_type like '02' THEN accounttrans_value END) AS jlh2 
                                            FROM tb_accounttrans 
                                            WHERE accounttrans_listid ='".$code[$aa]."' AND accounttrans_user='".$nomorrekeningdepo."' 
                                            AND accounttrans_date ='$datenext'
                                            GROUP BY accounttrans_user,`accounttrans_date`");
					$data1 = $query1->result_array();
                	if($query1->num_rows() > 0) {
                    	$nomor_rek = $data1[0]["accounttrans_user"];
                    	$saldo += ($data1[0]["jlh1"] - $data1[0]["jlh2"]) * 1;
                    	$saldor += $saldo;
                    	$saldorr = floor($saldor / $i);
                    	$saldo_rata = $saldorr;
                    	$i++;
                	}else{
                    	$saldor += $saldo;
                    	$saldorr = floor($saldor / $i);
                    	$saldo_rata = $saldorr;
                    	if($saldo !=0){
                        	$i++;
                    	}
                	}
    			
				}
            	if($saldo_rata != 0){
            		//hapus dulu detail 
					$where = array('basil_rek' => $nomorrekeningdepo,'basil_code'=> $code[$aa],'end_date' => $this->allfunct->revDate($this->input->post('tgl2')));
					$this->master->delete("tb_basil",$where);
					//masukkan ke tb_basil
					$basil['basil_code'] = $code[$aa];
					$basil['basil_rek'] = $nomorrekeningdepo;
					$basil['start_date'] = $this->allfunct->revDate($this->input->post('tgl1'));
					$basil['end_date'] = $this->allfunct->revDate($this->input->post('tgl2'));
					$basil['basil_value'] = $saldo_rata;
					$basil['basil_type'] = '3';
					$basil['create_by'] = $this->session->userdata('username');
					$basil['update_by'] = $this->session->userdata('username');
					$this->master->simpan('tb_basil',$basil);
				
					$saldo_rata1OK += $saldo_rata;
            	}
	    	}
	    }
	    $nilaiTotal = $saldo_rataOK + $saldo_rata1OK;
	    // pendapatan penyaluran
	    $nilaitotPenyaluran = 0;
	    $nilaitotPenyaluran0 = 0;
	    $nilaitotPenyaluran1 = 0;
	    $nilaitotPenyaluran2 = 0;
	    
	    $codepend = array('288','315','319');
	    $hasil2 = $this->db->query("SELECT SUM(accounttrans_value) AS jlh FROM tb_accounttrans WHERE accounttrans_listid ='288' AND date(accounttrans_date) BETWEEN '$tglawal' AND '$tglakhir' GROUP BY accounttrans_user")->result();
		foreach ($hasil2 as $row){
	        $nilaitotPenyaluran0 += $row->jlh;
	    }
		//masukkan ke tb_basil
		if($nilaitotPenyaluran0 != 0){
			$where = array('basil_rek' => 'P001','basil_code'=> '288','start_date' => $this->allfunct->revDate($this->input->post('tgl1')),'end_date' => $this->allfunct->revDate($this->input->post('tgl2')));
			$this->master->delete("tb_basil",$where);
			$basil['basil_code'] = "288";
			$basil['basil_rek'] = 'P001';
			$basil['start_date'] = $this->allfunct->revDate($this->input->post('tgl1'));
			$basil['end_date'] = $this->allfunct->revDate($this->input->post('tgl2'));
			$basil['basil_value'] = $nilaitotPenyaluran0;
			$basil['basil_type'] = '4';
			$basil['create_by'] = $this->session->userdata('username');
			$basil['update_by'] = $this->session->userdata('username');
			$this->master->simpan('tb_basil',$basil);	
		}
		$hasil2 = $this->db->query("SELECT SUM(accounttrans_value) AS jlh FROM tb_accounttrans WHERE accounttrans_listid ='315' AND date(accounttrans_date) BETWEEN '$tglawal' AND '$tglakhir' GROUP BY accounttrans_user")->result();
		foreach ($hasil2 as $row){
	        $nilaitotPenyaluran1 += $row->jlh;
	    }
		
		//masukkan ke tb_basil
		if($nilaitotPenyaluran1 != 0){
			$where = array('basil_rek' => 'P001','basil_code'=> '315','start_date' => $this->allfunct->revDate($this->input->post('tgl1')),'end_date' => $this->allfunct->revDate($this->input->post('tgl2')));
			$this->master->delete("tb_basil",$where);
			$basil['basil_code'] = "315";
			$basil['basil_rek'] = 'P001';
			$basil['start_date'] = $this->allfunct->revDate($this->input->post('tgl1'));
			$basil['end_date'] = $this->allfunct->revDate($this->input->post('tgl2'));
			$basil['basil_value'] = $nilaitotPenyaluran1;
			$basil['basil_type'] = '4';
			$basil['create_by'] = $this->session->userdata('username');
			$basil['update_by'] = $this->session->userdata('username');
			$this->master->simpan('tb_basil',$basil);	
		}
		$hasil2 = $this->db->query("SELECT SUM(accounttrans_value) AS jlh FROM tb_accounttrans WHERE accounttrans_listid ='319' AND date(accounttrans_date) BETWEEN '$tglawal' AND '$tglakhir' GROUP BY accounttrans_user")->result();
		foreach ($hasil2 as $row){
	        $nilaitotPenyaluran2 += $row->jlh;
	    }
		//masukkan ke tb_basil
		if($nilaitotPenyaluran1 != 0){
			$where = array('basil_rek' => 'P001','basil_code'=> '319','start_date' => $this->allfunct->revDate($this->input->post('tgl1')),'end_date' => $this->allfunct->revDate($this->input->post('tgl2')));
			$this->master->delete("tb_basil",$where);
			$basil['basil_code'] = "319";
			$basil['basil_rek'] = 'P001';
			$basil['start_date'] = $this->allfunct->revDate($this->input->post('tgl1'));
			$basil['end_date'] = $this->allfunct->revDate($this->input->post('tgl2'));
			$basil['basil_value'] = $nilaitotPenyaluran2;
			$basil['basil_type'] = '4';
			$basil['create_by'] = $this->session->userdata('username');
			$basil['update_by'] = $this->session->userdata('username');
			$this->master->simpan('tb_basil',$basil);	
		}
		$nilaitotPenyaluran = $nilaitotPenyaluran0 + $nilaitotPenyaluran1 + $nilaitotPenyaluran2;
        echo $nilaiTotal."#".$nilaitotPenyaluran;
        
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
    function login()
	{
		$data = $this->allfunct->securePost();
        $login = array($data['username'], $data['password']);
		$resp = $this->authlib->login1($login);
		echo $resp;
	}
    
}

/* End of file */