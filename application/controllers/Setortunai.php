<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : setortunai.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Setortunai extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
        $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "transaksiumum";
        $this->menuactsub = "setortunai";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('setortunai',$data);
	}
    
    //---- Fungsi mengisi option Wilayah
    function isi_wilayah()
    {
        $hasil = $this->db->select('wilayah_id,kode,wilayah_kerja')->get('bmt_wilayah')->result();
        $i=0;
        foreach ($hasil as $row)
		{
    		$clr = (($i%2) == 0) ? '#fff' : '#EFF1F1';
            echo "<option style=\"background:".$clr."\" value=\"".$row->wilayah_id."\">".$row->kode." - ".$row->wilayah_kerja."</option>";
            $i++;
		}
    }
    function run_code()
    {
        $num = $this->db->count_all_results('tb_accounttrans') + 1;
        $paddedNum = sprintf("%05d", $num);
        echo  date('m')."".date('y')."".$paddedNum;
    }
    function jurnal()
    {
        $data = $this->allfunct->securePost();
        $id	= $data['id'];
        $query = $this->db->query("SELECT gl_produk FROM master_tabungan WHERE kode_produk='".$id."'");
        $data = $query->result_array();
        echo $data[0]["gl_produk"];
    }
    function jurnalb()
    {
        $data           = $this->allfunct->securePost();
        $id	= $data['id'];
        $query = $this->db->query("SELECT gl_pemeliharaan FROM master_tabungan WHERE kode_produk='".$id."'");
        $data = $query->result_array();
        echo $data[0]["gl_pemeliharaan"];
    }
    function saldo()
    {
        $data           = $this->allfunct->securePost();
        $no_rekening	= $data['id'];
        $query = $this->db->query("SELECT sum(accounttrans_value) as jlh FROM tb_accounttrans WHERE accounttrans_user='".$no_rekening."' and accounttrans_type='01'");
        $data = $query->result_array();
        if($query->num_rows() > 0) {
            $query1 = $this->db->query("SELECT sum(accounttrans_value) as jlh FROM tb_accounttrans WHERE accounttrans_user='".$no_rekening."' and accounttrans_type='02'");
            $data1 = $query1->result_array();
            $jlh = $data[0]["jlh"] - $data1[0]["jlh"];
            echo $jlh;
        }else{
            echo "0";
        }
    }
    function saldorata()
    {
        $data           = $this->allfunct->securePost();
        $no_rekening	= $data['id'];
        $jurnal	    = $data['jurnal'];
        $query1 = $this->db->query("SELECT accounttrans_date FROM tb_accounttrans WHERE accounttrans_listid=$jurnal AND accounttrans_user='".$no_rekening."'");
        $data1 = $query1->result_array();
        
        $startdate = $data1[0]['accounttrans_date'];
		$enddate   = date("Y-m-d");
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
                                        WHERE accounttrans_listid=203  AND accounttrans_user='".$no_rekening."'
                                        AND accounttrans_date ='$datenext' 
                                        GROUP BY accounttrans_user,`accounttrans_date`");
            $data1 = $query1->result_array();
            if($query1->num_rows() > 0) {
                $saldo += ($data1[0]["jlh1"] - $data1[0]["jlh2"]) * 1;
                $saldor += $saldo;
                $saldorr = floor($saldor / $i);
                $ptitle .= $no_rekening." = ".number_format($saldo,0)." = ".number_format($saldor,0)." / ".$a." ".$i." : ".number_format($saldorr,0)."<br>";
                $saldo_rata = $saldorr;
                $i++;
            }else{
                $saldor += $saldo;
                $saldorr = floor($saldor / $i);
                $ptitle .= $no_rekening." = ".number_format($saldo,0)." = ".number_format($saldor,0)." / ".$a." ".$i." : ".number_format($saldorr,0)."<br>";
                $saldo_rata = $saldorr;
                if($saldo !=0){
                    $i++;
                }
            }
		}
		echo $saldo_rata;
    }
    function savetunai(){
        $data = $this->allfunct->securePost();
        //
        $query = $this->db->query("SELECT blockir FROM tb_tabungan WHERE nomor_rekening='".$data['nomor_rekening']."'");
        $datar = $query->result_array();
        $blockir = $datar[0]["blockir"];
        if(($blockir == "Block Kredit")||($blockir == "Block Debet-Kredit")){
        	echo "Maaf Tabungan anda di blokir silahkan hubungi administrator";
        }else{
	        $data3['accounttrans_listid'] = "19";
	        $data3['accounttrans_date'] = $this->allfunct->revDate($data['tgl_transaksi']);
	        $data3['accounttrans_code'] = $data['nomor_ref']." - 19";
	        $data3['accounttrans_type'] = '02';
	        $data3['accounttrans_value'] = $data['jumlah'];
	        $data3['accounttrans_desc'] = $data['ket']." - ".$data['nomor_rekening']."( ".$data['nama']." )";
	        $data3['accounttrans_user'] = $data['nomor_rekening'];
	        $data3['create_date'] = date("Y-m-d H:i:s");
	        $data3['create_by'] = $this->session->userdata('username');
	        $data3['update_by'] = $this->session->userdata('username');
	        
	        //
	        $data2['accounttrans_listid'] = $data['id_jurnal'];
	        $data2['accounttrans_date'] = $this->allfunct->revDate($data['tgl_transaksi']);
	        $data2['accounttrans_code'] = $data['nomor_ref']." - ".$data['id_jurnal'];
	        $data2['accounttrans_type'] = '01';
	        $data2['accounttrans_value'] = $data['jumlah'];
	        $data2['accounttrans_desc'] = $data['ket']." - ".$data['nomor_rekening']."( ".$data['nama']." )";
	        $data2['accounttrans_user'] = $data['nomor_rekening'];
	        $data2['create_date'] = date("Y-m-d H:i:s");
	        $data2['create_by'] = $this->session->userdata('username');
	        $data2['update_by'] = $this->session->userdata('username');
	        //$data2['accounttrans_curency'] = $this->session->userdata('cbg');
	        
	        $nomor_jurnal= $data['nomor_jurnal'];
	        $nomor_ref= $data['nomor_ref'];
	        $nomor_rekening= $data['nomor_rekening'];
	        $nama= $data['nama'];
	        unset($data['id_jurnal']);
	        unset($data['biaya_jurnal']);
	        unset($data['tgl_transaksi']);
	        unset($data['nomor_ref']);
	        unset($data['jumlah']);
	        unset($data['biaya']);
	        unset($data['nama']);
	        unset($data['alamat']);
	        unset($data['kota']);
	        unset($data['saldo']);
	        unset($data['rata_rata']);
	        unset($data['nomor_rekening']);
	        unset($data['rata_rata']);
	        unset($data['ket']);
	        
	        echo $this->master->simpan('tb_accounttrans',$data2)."#".$nomor_jurnal."#".$nomor_ref."#".$nomor_rekening." ".$nama;
	        $this->master->simpan('tb_accounttrans',$data3);
	        $data2['accounttrans_posted'] = '1';
	        $data3['accounttrans_posted'] = '1';
	        $this->master->simpan('tb_accounttemp',$data2);
	        $this->master->simpan('tb_accounttemp',$data3);
        }
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
    function cetakValidasi()
    {
    	$query = $this->db->query("SELECT wilayah_kerja FROM bmt WHERE bmt_id =1");
    	$data = $query->result_array();
    	$data1['code_cabang'] = $data[0]["wilayah_kerja"];
    	$data1['teller'] = $this->session->userdata('username');
    	$this->load->view('cetak/validasi',$data1);
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