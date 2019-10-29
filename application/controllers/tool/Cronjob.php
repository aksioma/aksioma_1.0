<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : tool/cronjob.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Cronjob extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        //$this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "tools";
        $this->menuactsub = "cronjob";
	}
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('tool/cronjob',$data);
	}
	function pembiayaan(){
		$tgl2 = date('Y-m-d');
		$hasil1 = $this->db->query("SELECT t1.*,t2.nama,t3.nama_pegawai FROM tb_pembiayaan AS t1 
    								INNER JOIN tb_nasabah AS t2 ON t2.nomor_nasabah=t1.nomor_nasabah 
    								INNER JOIN pegawai AS t3 ON t1.nomor_ao=t3.nip WHERE t1.status=0")->result();
		foreach ($hasil1 as $row1)
		{
			$id = $row1->pembiayaan_id;
			$rek = $row1->nomor_rekening;
			$hasil = $this->db->query("SELECT t1.*,sum(accounttrans_value) AS jlh FROM tb_accounttrans AS t1
					WHERE accounttrans_user='$rek' AND `accounttrans_desc` LIKE 'ANGSURAN%' AND `accounttrans_listid` !=19 AND
					`accounttrans_type`='01' AND `accounttrans_date` <='$tgl2' GROUP BY accounttrans_listid ORDER BY `accounttrans_value` ASC")->result();
			$pokok = 0;
			$margin = 0;
			$i=0;
			foreach ($hasil as $row)
			{
				if($i==0){
					$margin += $row->jlh;
				}else{
					$pokok += $row->jlh;
				}
				$i++;
			}
			$query = $this->db->query("SELECT pokok,margin FROM tb_pembiayaandetail WHERE id_pembiayaan='$id'");
			$data = $query->result_array();
			if($query->num_rows() > 0) {
				$pokokdetail = $data[0]["pokok"];
			}
			$pCount = floor($pokok / $pokokdetail);
			//update pembiayaan detail menjadi o
			$data1['status'] = '0';
			$where1 = array('id_pembiayaan' => $id);
			$this->master->update("tb_pembiayaandetail",$data1,$where1);
			//update pembiayaan real
			for($i=1;$i<=$pCount;$i++){
				$query = $this->db->query("SELECT pembiayaandetail_id FROM tb_pembiayaandetail WHERE id_pembiayaan='$id' AND status=0");
				$data = $query->result_array();
				if($query->num_rows() > 0) {
					$data5['status'] = '1';
					$where = array('pembiayaandetail_id' => $data[0]["pembiayaandetail_id"]);
					$this->master->update("tb_pembiayaandetail",$data5,$where);
				}
			}
			//update status pembiayan menjadi lunas
			$query1 = $this->db->query("SELECT count(*) AS tot FROM tb_pembiayaandetail WHERE id_pembiayaan='$id' AND status=0");
			$datar = $query1->result_array();
			if($datar[0]["tot"] > 0) { 
				
			}else{
				$dataa['status'] = '1';
				$wherea = array('pembiayaan_id' => $id);
				$this->master->update("tb_pembiayaan",$dataa,$wherea);
			}
			$total = $pokok + $margin;
			//echo $rek." => ".$pokok."#".$margin.":".$total."== ".$pCount."<br>";
		}
		echo "1";
	}
    function zakat(){
    	//$tglawal = $this->allfunct->revDate($this->input->post('tgl1'));
    	//$tglakhir = $this->allfunct->revDate($this->input->post('tgl2'));
    	$this->db->query("TRUNCATE TABLE `tb_zakat`");
    	
    	$hasil = $this->db->query("SELECT basilwadiah_value,basilwadiah_code,basilwadiah_rek FROM tb_basilwadiah")->result();
        foreach ($hasil as $row)
    	{
    		$nomor_rek = $row->basilwadiah_rek;
    		$nilai = $row->basilwadiah_value;
    		//cari yg zakat ya
    		$query1 = $this->db->query("SELECT count(*) AS tot,jenis_simpanan FROM tb_tabungan WHERE nomor_rekening ='$nomor_rek' AND zakat='YA'");
    		$data = $query1->result_array();
    		if($data[0]["tot"] > 0) {
    			$query = $this->db->query("SELECT tab_zakat FROM master_tabungan WHERE kode_produk='".$data[0]["jenis_simpanan"]."'");
    			if($query->num_rows() > 0){
    				$rsl = $query->result_array();
    				$zakat = $rsl[0]["tab_zakat"] / 100;
	    			$nilaizakat = $nilai * $zakat;
	    			//masukkan ke tb_zakat
	    			$datenow = date("Y-m-d");
	    			$zakata['zakat_rek'] = $nomor_rek;
	    			$zakata['tanggal'] = $datenow;
	    			//$zakata['start_date'] = $tglawal;
	    			//$zakata['end_date'] = $tglakhir;
	    			$zakata['zakat_value'] = $nilaizakat;
	    			$zakata['create_by'] = $this->session->userdata('username');
	    			$this->master->simpan('tb_zakat',$zakata);
    			}
    		}
    	}
    	
    	$hasil1 = $this->db->query("SELECT basiltrans_value,kode_produk,basiltrans_rek FROM tb_basiltrans WHERE basiltrans_type=0")->result();
    	foreach ($hasil1 as $row)
    	{
    		$nomor_rek = $row->basiltrans_rek;
    		$nilai = $row->basiltrans_value;
    		$query1 = $this->db->query("SELECT count(*) AS tot,t1.jenis_simpanan FROM tb_tabungan AS t1 INNER JOIN tb_pembiayaan AS t2 ON t2.nomor_nasabah=t1.nomor_nasabah WHERE t2.nomor_rekening ='$nomor_rek' AND zakat='YA'");
    		$data = $query1->result_array();
    		if($data[0]["tot"] > 0) {
    			$query = $this->db->query("SELECT tab_zakat FROM master_tabungan WHERE kode_produk='".$data[0]["jenis_simpanan"]."'");
    			if($query->num_rows() > 0){
    				$rsl = $query->result_array();
    				$zakat = $rsl[0]["tab_zakat"] / 100;
	    			$nilaizakat = $nilai * $zakat;
	    			//masukkan ke tb_zakat
	    			$datenow = date("Y-m-d");
	    			$zakat1['zakat_rek'] = $nomor_rek;
	    			$zakat1['tanggal'] = $datenow;
	    			//$zakat1['start_date'] = $tglawal;
	    			//$zakat1['end_date'] = $tglakhir;
	    			$zakat1['zakat_value'] = $nilaizakat;
	    			$zakat1['create_by'] = $this->session->userdata('username');
	    			$this->master->simpan('tb_zakat',$zakat1);
    			}
    		}
    	}
    	// masukan ke transaksi
    	$hasil = $this->db->query("SELECT zakat_rek,zakat_value FROM tb_zakat")->result();
    	$query = $this->db->query("SELECT zakat_rek,zakat_value FROM tb_zakat");
    	if($query->num_rows() > 0){
	    	foreach ($hasil as $row){
	    		
	    		$data1['accounttrans_listid'] = "577";
	    		$data1['accounttrans_date'] = date('Y-m-d');
	    		$data1['accounttrans_code'] = "577 - 08";
	    		$data1['accounttrans_type'] = '01';
	    		$data1['accounttrans_value'] = $row->zakat_value;
	    		$data1['accounttrans_desc'] = "Zakat - ".$row->zakat_rek;
	    		$data1['accounttrans_user'] = $row->zakat_rek;
	    		$data1['create_date'] = date("Y-m-d H:i:s");
	    		$data1['create_by'] = $this->session->userdata('username');
	    		$data1['update_by'] = $this->session->userdata('username');
	    		$this->master->simpan('tb_accounttrans',$data1);
	    		
	    		$data2['accounttrans_listid'] = "203";
	    		$data2['accounttrans_date'] = date('Y-m-d');
	    		$data2['accounttrans_code'] = "08";
	    		$data2['accounttrans_type'] = '02';
	    		$data2['accounttrans_value'] = $row->zakat_value;
	    		$data2['accounttrans_desc'] = "Zakat - ".$row->zakat_rek;
	    		$data2['accounttrans_user'] = $row->zakat_rek;
	    		$data2['create_date'] = date("Y-m-d H:i:s");
	    		$data2['create_by'] = $this->session->userdata('username');
	    		$data2['update_by'] = $this->session->userdata('username');
	    		$this->master->simpan('tb_accounttrans',$data2);
	    	}
	    	
    	}
    	echo "1";
    }
    function adm(){
    	//$tglawal = $this->allfunct->revDate($this->input->post('tgl1'));
    	//$tglakhir = $this->allfunct->revDate($this->input->post('tgl2'));
    	$hasil = $this->db->query("SELECT nomor_rekening,jenis_simpanan FROM tb_tabungan WHERE administrasi='YA'")->result();
    		foreach ($hasil as $row){
	    		$query = $this->db->query("SELECT adm_lain_lain FROM master_tabungan WHERE kode_produk='".$row->jenis_simpanan."'");
	    		if($query->num_rows() > 0){
	    			$rsl = $query->result_array();
	    			$adm = $rsl[0]["adm_lain_lain"];
	    			//masukkan ke transaksi adm
	    			$data1['accounttrans_listid'] = "416";
	    			$data1['accounttrans_date'] = date('Y-m-d');
	    			$data1['accounttrans_code'] = "416 - 05";
	    			$data1['accounttrans_type'] = '01';
	    			$data1['accounttrans_value'] = $adm;
	    			$data1['accounttrans_desc'] = "Biaya administrasi - ".$row->nomor_rekening;
	    			$data1['accounttrans_user'] = $row->nomor_rekening;
	    			$data1['create_date'] = date("Y-m-d H:i:s");
	    			$data1['create_by'] = $this->session->userdata('username');
	    			$data1['update_by'] = $this->session->userdata('username');
	    			$this->master->simpan('tb_accounttrans',$data1);
	    			 
	    			$data2['accounttrans_listid'] = "203";
	    			$data2['accounttrans_date'] = date('Y-m-d');
	    			$data2['accounttrans_code'] = "05";
	    			$data2['accounttrans_type'] = '02';
	    			$data2['accounttrans_value'] = $adm;
	    			$data2['accounttrans_desc'] = "Biaya administrasi - ".$row->nomor_rekening;
	    			$data2['accounttrans_user'] = $row->nomor_rekening;
	    			$data2['create_date'] = date("Y-m-d H:i:s");
	    			$data2['create_by'] = $this->session->userdata('username');
	    			$data2['update_by'] = $this->session->userdata('username');
	    			$this->master->simpan('tb_accounttrans',$data2);
	    		}
    		}
    		echo "1";
    	
    }
    function pph(){
    	//$tglawal = $this->allfunct->revDate($this->input->post('tgl1'));
    	//$tglakhir = $this->allfunct->revDate($this->input->post('tgl2'));
    	$this->db->query("TRUNCATE TABLE `tb_pph`");
    	 
    	$hasil = $this->db->query("SELECT basilwadiah_value,basilwadiah_code,basilwadiah_rek FROM tb_basilwadiah")->result();
    	foreach ($hasil as $row)
    	{
    		$nomor_rek = $row->basilwadiah_rek;
    		$nilai = $row->basilwadiah_value;
    		//cari yg pph ya
    		$query1 = $this->db->query("SELECT count(*) AS tot,jenis_simpanan FROM tb_tabungan WHERE nomor_rekening ='$nomor_rek' AND pph='YA'");
    		$data = $query1->result_array();
    		if($data[0]["tot"] > 0) {
    			$query = $this->db->query("SELECT tab_pph FROM master_tabungan WHERE kode_produk='".$data[0]["jenis_simpanan"]."'");
    			if($query->num_rows() > 0){
    				$rsl = $query->result_array();
    				$pph = $rsl[0]["tab_pph"] / 100;
    				$nilaipph = $nilai * $pph;
    				//masukkan ke tb_pph
    				$datenow = date("Y-m-d");
    				$ipph['pph_rek'] = $nomor_rek;
    				$ipph['tanggal'] = $datenow;
    				$ipph['pph_value'] = $nilaipph;
    				$ipph['create_by'] = $this->session->userdata('username');
    				$this->master->simpan('tb_pph',$ipph);
    			}
    		}
    	}
    	 
    	$hasil1 = $this->db->query("SELECT basiltrans_value,kode_produk,basiltrans_rek FROM tb_basiltrans WHERE basiltrans_type=0")->result();
    	foreach ($hasil1 as $row)
    	{
    		$nomor_rek = $row->basiltrans_rek;
    		$nilai = $row->basiltrans_value;
    		$query1 = $this->db->query("SELECT count(*) AS tot,t1.jenis_simpanan FROM tb_tabungan AS t1 INNER JOIN tb_pembiayaan AS t2 ON t2.nomor_nasabah=t1.nomor_nasabah WHERE t2.nomor_rekening ='$nomor_rek' AND pph='YA'");
    		$data = $query1->result_array();
    		if($data[0]["tot"] > 0) {
    		$query = $this->db->query("SELECT tab_pph FROM master_tabungan WHERE kode_produk='".$data[0]["jenis_simpanan"]."'");
    			if($query->num_rows() > 0){
    				$rsl = $query->result_array();
    				$pph = $rsl[0]["tab_pph"] / 100;
    				$nilaipph = $nilai * $pph;
    				//masukkan ke tb_pph
    				$datenow = date("Y-m-d");
    				$ipph['pph_rek'] = $nomor_rek;
    				$ipph['tanggal'] = $datenow;
    				$ipph['pph_value'] = $nilaipph;
    				$ipph['create_by'] = $this->session->userdata('username');
    				$this->master->simpan('tb_pph',$ipph);
    			}
    		}
    	}
    	// masukan ke transaksi
    	$hasil = $this->db->query("SELECT pph_rek,pph_value FROM tb_pph")->result();
    	$query = $this->db->query("SELECT pph_rek,pph_value FROM tb_pph");
    	if($query->num_rows() > 0){
    		foreach ($hasil as $row){
    			 
    			$data1['accounttrans_listid'] = "244";
    			$data1['accounttrans_date'] = date('Y-m-d');
    			$data1['accounttrans_code'] = "244 - 09";
    			$data1['accounttrans_type'] = '01';
    			$data1['accounttrans_value'] = $row->pph_value;
    			$data1['accounttrans_desc'] = "PPH - ".$row->pph_rek;
    			$data1['accounttrans_user'] = $row->pph_rek;
    			$data1['create_date'] = date("Y-m-d H:i:s");
    			$data1['create_by'] = $this->session->userdata('username');
    			$data1['update_by'] = $this->session->userdata('username');
    			$this->master->simpan('tb_accounttrans',$data1);
    			 
    			$data2['accounttrans_listid'] = "203";
    			$data2['accounttrans_date'] = date('Y-m-d');
    			$data2['accounttrans_code'] = "09";
    			$data2['accounttrans_type'] = '02';
    			$data2['accounttrans_value'] = $row->pph_value;
    			$data2['accounttrans_desc'] = "PPH - ".$row->pph_rek;
    			$data2['accounttrans_user'] = $row->pph_rek;
    			$data2['create_date'] = date("Y-m-d H:i:s");
    			$data2['create_by'] = $this->session->userdata('username');
    			$data2['update_by'] = $this->session->userdata('username');
    			$this->master->simpan('tb_accounttrans',$data2);
    		}
    	
    	}
    	echo "1";
    }
    function proses()
    {
        echo "proses cronjob data otomatis";
        
        exit;
    }
    
    
}

/* End of file */