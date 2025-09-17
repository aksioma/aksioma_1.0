<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : pencairanpembiayaan.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Pencairanpembiayaan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
        $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "transaksiumum";
        $this->menuactsub = "pencairanpembiayaan";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('pencairanpembiayaan',$data);
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
    function type()
    {
        $data           = $this->allfunct->securePost();
        $jenis	= $data['id'];
        $query = $this->db->query("SELECT grouppembiayaan_nama FROM master_grouppembiayaan WHERE kode_produk='".$jenis."'");
        $data = $query->result_array();
        if($query->num_rows() > 0) {
            echo $data[0]["grouppembiayaan_nama"];
        }else{
            echo "";
        }
    }
    function sisaplafon()
    {
        $data           = $this->allfunct->securePost();
        $id	= $data['id'];
        $query = $this->db->query("SELECT sum(accounttrans_value) AS jlh FROM tb_accounttrans WHERE accounttrans_user='".$id."' AND accounttrans_type='15'");
        $data = $query->result_array();
        if($query->num_rows() > 0) {
            echo $data[0]["jlh"];
        }else{
            echo 0;
        }
    }
    function jurnal()
    {
        $data           = $this->allfunct->securePost();
        $id	= $data['id'];
        $query = $this->db->query("SELECT gl_produk FROM master_pembiayaan WHERE kode_produk='".$id."'");
        $data = $query->result_array();
        echo $data[0]["gl_produk"];
    }
    function savetunai(){
        $data = $this->allfunct->securePost();
        $pokok = preg_replace('/\./','',$data['plafon']);
        $margin = preg_replace('/\./','',$data['margin']);
        $pokokmargin = $pokok + $margin;
        $data1['accounttrans_listid'] = $data['id_jurnal'];
        $data1['accounttrans_date'] = $this->allfunct->revDate($data['tgl_transaksi']);
        $data1['accounttrans_code'] = $data['nomor_ref']." - ".$data['nomor_jurnal'];
        $data1['accounttrans_desc'] = $data['ket']." - ".$data['nomor_rekening']."( ".$data['nama']." )";
        $data1['accounttrans_user'] = $data['nomor_rekening'];
        $data1['create_date'] = date("Y-m-d H:i:s");
        $data1['create_by'] = $this->session->userdata('username');
        $data1['update_by'] = $this->session->userdata('username');
        //$data1['accounttrans_curency'] = $this->session->userdata('cbg');
        
        $data2['accounttrans_date'] = $this->allfunct->revDate($data['tgl_transaksi']);
        $data2['accounttrans_code'] = $data['nomor_ref']." - ".$data['nomor_jurnal'];
        $data2['accounttrans_desc'] = $data['ket']." - ".$data['nomor_rekening']."( ".$data['nama']." )";
        $data2['accounttrans_user'] = $data['nomor_rekening'];
        $data2['create_date'] = date("Y-m-d H:i:s");
        $data2['create_by'] = $this->session->userdata('username');
        $data2['update_by'] = $this->session->userdata('username');
        //$data2['accounttrans_curency'] = $this->session->userdata('cbg');
        
        $data3['accounttrans_date'] = $this->allfunct->revDate($data['tgl_transaksi']);
        $data3['accounttrans_code'] = $data['nomor_ref']." - ".$data['nomor_jurnal'];
        $data3['accounttrans_desc'] = $data['ket']." - ".$data['nomor_rekening']."( ".$data['nama']." )";
        $data3['accounttrans_user'] = $data['nomor_rekening'];
        $data3['create_date'] = date("Y-m-d H:i:s");
        $data3['create_by'] = $this->session->userdata('username');
        $data3['update_by'] = $this->session->userdata('username');
        //$data3['accounttrans_curency'] = $this->session->userdata('cbg');
        
        if($data['jenis_pembiayaan'] == "MURABAHAH"){
            //$data1['accounttrans_type'] = '01';
            $data1['accounttrans_type'] = '02';
            $data1['accounttrans_value'] = $pokokmargin;
            $data1['accounttrans_ref'] = '1';
            
            $data2['accounttrans_listid'] = "118";
            $data2['accounttrans_type'] = '01';
            $data2['accounttrans_value'] = $pokok;
            
            $data3['accounttrans_listid'] = "44";
            $data3['accounttrans_type'] = '01';
            $data3['accounttrans_value'] = $margin;
            $this->master->simpan('tb_accounttrans',$data3);
            
        }elseif(($data['jenis_pembiayaan'] == "MUDHARABAH")||($data['jenis_pembiayaan'] == "MUSYARAKAH")){
            $data1['accounttrans_type'] = '01';
            $data1['accounttrans_value'] = $pokokmargin;
            
            $data2['accounttrans_listid'] = "19";
            $data2['accounttrans_type'] = '02';
            $data2['accounttrans_value'] = $pokokmargin;
            
        }elseif($data['jenis_pembiayaan'] == "AL-QARDH"){
            $data1['accounttrans_type'] = '02';
            $data1['accounttrans_value'] = $pokokmargin;
            
            $data2['accounttrans_listid'] = "19";
            $data2['accounttrans_type'] = '01';
            $data2['accounttrans_value'] = $pokokmargin;
        }
        
        $this->master->simpan('tb_accounttrans',$data1);
        $this->master->simpan('tb_accounttrans',$data2);
        
        $data1['accounttrans_posted'] = '1';
        $data2['accounttrans_posted'] = '1';
        $data3['accounttrans_posted'] = '1';
        
        //$this->master->simpan('tb_accounttemp',$data2);
        //$this->master->simpan('tb_accounttemp',$data3);
        
        $id_jurnal= $data['nomor_jurnal'];
        $nomor_ref= $data['nomor_ref'];
        $nomor_rekening= $data['nomor_rekening'];
        $nama= $data['nama'];
        
        echo $this->master->simpan('tb_accounttemp',$data1)."#".$id_jurnal."#".$nomor_ref."#".$nomor_rekening." ".$nama;
    }
    function limittarik(){
        $data = $this->allfunct->securePost();
        $nilai	= $data['nilai'];
        $userlevel = $this->authlib->levellogin($this->session->userdata('username'));
        if($userlevel != 1){
            $query = $this->db->query("SELECT kode FROM master_otoritas WHERE level='".$userlevel."'");
            $data = $query->result_array();
            if($query->num_rows() > 0) {
                $kode = $data[0]["kode"];
                if($kode >= $nilai){
                    echo "1";
                }else{
                    echo "0";
                }
            }else{
                echo "no";
            }
        }else{
            echo "no";
        }
    }
    function get_transview()
    {
        $objord = $this->input->post('id');
        $query = $this->db->query("SELECT accounttrans_code,accounttrans_date,accounttrans_value FROM tb_accounttrans WHERE accounttrans_user='".$objord."' AND accounttrans_type='02' AND accounttrans_ref=1 order by accounttrans_date");
        $data = $query->result_array();
        //echo $data;
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
    function login()
	{
		$data = $this->allfunct->securePost();
        $login = array($data['username'], $data['password']);
		$resp = $this->authlib->login1($login);
		echo $resp;
	}
    
}

/* End of file */