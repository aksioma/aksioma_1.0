<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : setordeposito.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Setordeposito extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
        $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "transaksiumum";
        $this->menuactsub = "setordeposito";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('setordeposito',$data);
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
        $query = $this->db->query("SELECT gl_produk FROM master_deposito WHERE kode_produk='".$id."'");
        $data = $query->result_array();
        echo $data[0]["gl_produk"];
    }
    
    function savetunai(){
        $data = $this->allfunct->securePost();
        $data1['accounttrans_listid'] = "19";
        $data1['accounttrans_date'] = $this->allfunct->revDate($data['tgl_transaksi']);
        $data1['accounttrans_code'] = $data['nomor_ref']." - 19";
        $data1['accounttrans_type'] = '02';
        $data1['accounttrans_value'] = $data['jumlah'];
        $data1['accounttrans_desc'] = $data['ket']." - ".$data['nomor_rekening']."( ".$data['nama']." )";
        $data1['accounttrans_user'] = $data['nomor_rekening'];
        $data1['accounttrans_direct'] = $data['wilayah_id'];
        $data1['accounttrans_ref'] = $data['nomor_rekeningt'];
        $data1['create_date'] = date("Y-m-d H:i:s");
        $data1['create_by'] = $this->session->userdata('username');
        $data1['update_by'] = $this->session->userdata('username');
        //$data1['accounttrans_curency'] = $this->session->userdata('cbg');
        
        $data2['accounttrans_listid'] = $data['id_jurnal'];
        $data2['accounttrans_date'] = $this->allfunct->revDate($data['tgl_transaksi']);
        $data2['accounttrans_code'] = $data['nomor_ref']." - ".$data['id_jurnal'];
        $data2['accounttrans_type'] = '01';
        $data2['accounttrans_value'] = $data['jumlah'];
        $data2['accounttrans_desc'] = $data['ket']." - ".$data['nomor_rekening']."( ".$data['nama']." )";
        $data2['accounttrans_user'] = $data['nomor_rekening'];
        $data2['accounttrans_direct'] = $data['wilayah_id'];
        $data2['accounttrans_ref'] = $data['nomor_rekeningt'];
        $data2['create_date'] = date("Y-m-d H:i:s");
        $data2['create_by'] = $this->session->userdata('username');
        $data2['update_by'] = $this->session->userdata('username');
        //$data2['accounttrans_curency'] = $this->session->userdata('cbg');
        
        $id_jurnal= $data['id_jurnal'];
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
        $this->master->simpan('tb_accounttrans',$data2);
        $this->master->simpan('tb_accounttrans',$data1);
        $data2['accounttrans_posted'] = '1';
        $data1['accounttrans_posted'] = '1';
        $this->master->simpan('tb_accounttemp',$data1);
        echo $this->master->simpan('tb_accounttemp',$data2)."#".$id_jurnal."#".$nomor_ref."#".$nomor_rekening." ".$nama;
        
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