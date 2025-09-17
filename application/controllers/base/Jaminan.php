<?php
/*
* Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
* Copyright (c) 2014
*
* file   : base/jaminan.php
* author : Edi Suwoto S.Komp
* email  : edi.suwoto@gmail.com
*/
/*----------------------------------------------------------*/
class Jaminan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "base";
        $this->menuactsub = "jaminan";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('base/jaminan',$data);
	}
    
    function run_code()
    {
        $num = $this->db->count_all_results('tb_jaminan') + 1;
        $paddedNum = sprintf("%06d", $num);
        echo  $paddedNum;
    }
    function cab_code()
    {
        $query = $this->db->query("SELECT kode FROM bmt_wilayah AS t1 INNER JOIN bmt AS t2 ON t2.wilayah_kerja =t1.kode");
        $data = $query->result_array();
        echo $data[0]["kode"];
    }
    // ---- Fungsi membantu Autocomplete
    function search_nasabah()
	{
        $nama = strtoupper($this->input->post('q'));
        $query = $this->db->select('nomor_nasabah,nama,alamat,rtrw,kabupaten')->like('nama', $nama)->limit(20)->get('tb_nasabah')->result();
        echo json_encode($query);
	}
    
    /// save new jaminan
    function savejaminan(){
        $data = $this->allfunct->securePost();
        if($data['inspeksi_terakhir'] !=""){
            $data['inspeksi_terakhir'] = $this->allfunct->revDate($data['inspeksi_terakhir']);
        }
        unset($data['nama']);
        unset($data['alamat']);
        unset($data['kota']);
        $data['create_by'] = $this->session->userdata('username');
        $data['update_by'] = $this->session->userdata('username');
        echo $this->master->simpan('tb_jaminan',$data);
    }
    function editjaminan(){
        $data = $this->allfunct->securePost();
        if($data['inspeksi_terakhir'] !=""){
            $data['inspeksi_terakhir'] = $this->allfunct->revDate($data['inspeksi_terakhir']);
        }
        $id	= $data['nomor_jaminan'];
		unset($data['nomor_jaminan']);
        unset($data['tgl_dibuka']);
        unset($data['nama']);
        unset($data['alamat']);
        unset($data['kota']);
        $data['update_by'] = $this->session->userdata('username');
        $where = array('nomor_jaminan' => $id);
        echo $this->master->update("tb_jaminan",$data,$where);
    }
    function get_jaminan()
    {
        $ff			= $this->input->post('ff'); // Jenis Filter
		$if			= $this->input->post('if'); // Value Filter
		$fd			= $this->input->post('fd'); // Field Sorting
		$adsc		= $this->input->post('adsc'); // Asc or Desc
		$hal		= $this->input->post('hal'); // Offset Limit
		$juml		= $this->input->post('juml'); // Jumlah Limit
		$awal 		= $juml * ($hal - 1);
		$alldata 	= $this->modelku->getAllJaminan($ff,$if,$fd,$adsc,$awal,$juml);
		$records 	= $alldata['numrow'];
		$page_num 	= ceil($records / $juml);
		if ($records > 0)
        {
            
            $hasil['total'] = $page_num;
            $hasil['alldata'] = $alldata['result'];
        	echo json_encode($hasil);
		}
    }
    function get_pembiayaan(){
    	$ff			= $this->input->post('ff'); // Jenis Filter
    	$if			= $this->input->post('if'); // Value Filter
    	$fd			= $this->input->post('fd'); // Field Sorting
    	$adsc		= $this->input->post('adsc'); // Asc or Desc
    	$hal		= $this->input->post('hal'); // Offset Limit
    	$juml		= $this->input->post('juml'); // Jumlah Limit
    	$awal 		= $juml * ($hal - 1);
    	$alldata 	= $this->modelku->getAllJaminanPembiayaan($ff,$if,$fd,$adsc,$awal,$juml);
    	$records 	= $alldata['numrow'];
    	$page_num 	= ceil($records / $juml);
    	if ($records > 0)
    	{
    	
    		$hasil['total'] = $page_num;
    		$hasil['alldata'] = $alldata['result'];
    		echo json_encode($hasil);
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
}

/* End of file */