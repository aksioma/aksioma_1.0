<?php
/*
* Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
* Copyright (c) 2014
*
* file   : base/deposito.php
* author : Edi Suwoto S.Komp
* email  : edi.suwoto@gmail.com
*/
/*----------------------------------------------------------*/
class Deposito extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "base";
        $this->menuactsub = "deposito";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('base/deposito',$data);
	}
    
    function run_code()
    {
        $id	= $this->input->post('id');
        $query = $this->db->query("SELECT count(*) AS jlh FROM tb_deposito WHERE nomor_rekening LIKE '$id%'");
        $data = $query->result_array();
        $num = $data[0]["jlh"] + 1;
        $paddedNum = sprintf("%05d", $num);
        echo  $paddedNum;
    }
    function cab_code()
    {
        $query = $this->db->query("SELECT kode FROM bmt_wilayah AS t1 INNER JOIN bmt AS t2 ON t2.wilayah_kerja =t1.kode");
        $data = $query->result_array();
        echo $data[0]["kode"];
    }
    function produk_code()
    {
        $query = $this->db->query("SELECT kode_produk FROM master_groupdeposito");
        $data = $query->result_array();
        echo $data[0]["kode_produk"];
    }
    function produk_name()
    {
        $id = $this->input->post('id');
        $query = $this->db->query("SELECT groupdeposito_nama FROM master_groupdeposito WHERE kode_produk='$id'");
        $data = $query->result_array();
        echo strtoupper($data[0]["groupdeposito_nama"]);
    }
    /// save new 
    function savedata(){
        $data = $this->allfunct->securePost();
        $data['tgl_dibuka'] = $this->allfunct->revDate($data['tgl_dibuka']);
        $data['jatuh_tempo'] = $this->allfunct->revDate($data['jatuh_tempo']);
        $data['nominal'] = $this->allfunct->uangDB($data['nominal']);
        unset($data['iddeposito']);
        unset($data['nama']);
        unset($data['namatab']);
        unset($data['alamat']);
        unset($data['kota']);
        $data['create_by'] = $this->session->userdata('username');
        $data['update_by'] = $this->session->userdata('username');
        echo $this->master->simpan('tb_deposito',$data);
    }
    function editdata(){
        $data = $this->allfunct->securePost();
        $data['jatuh_tempo'] = $this->allfunct->revDate($data['jatuh_tempo']);
        $id	= $data['iddeposito'];
		unset($data['iddeposito']);
        unset($data['nomor_rekening']);
        unset($data['tgl_dibuka']);
        unset($data['nama']);
        unset($data['alamat']);
        unset($data['kota']);
        unset($data['namatab']);
        $data['update_by'] = $this->session->userdata('username');
        $where = array('deposito_id' => $id);
        echo $this->master->update("tb_deposito",$data,$where);
    }
    function get_data()
    {
        $ff			= $this->input->post('ff'); // Jenis Filter
		$if			= $this->input->post('if'); // Value Filter
		$fd			= $this->input->post('fd'); // Field Sorting
		$adsc		= $this->input->post('adsc'); // Asc or Desc
		$hal		= $this->input->post('hal'); // Offset Limit
		$juml		= $this->input->post('juml'); // Jumlah Limit
		$awal 		= $juml * ($hal - 1);
		$alldata 	= $this->modelku->getAllDeposito($ff,$if,$fd,$adsc,$awal,$juml);
		$records 	= $alldata['numrow'];
		$page_num 	= ceil($records / $juml);
		if ($records > 0)
        {
            $hasil['total'] = $page_num;
            $hasil['alldata'] = $alldata['result'];
        	echo json_encode($hasil);
		}else{
            $hasil['alldata'] = 0;
            echo $hasil;
        }
    }
    //---- Fungsi mengisi option
    function isi_deposito()
    {
        $hasil = $this->db->select('kode_produk,groupdeposito_nama')->get('master_groupdeposito')->result();
        $i=0;
        foreach ($hasil as $row)
		{
    		$clr = (($i%2) == 0) ? '#fff' : '#EFF1F1';
            echo "<option style=\"background:".$clr."\" value=\"".$row->kode_produk."\">".$row->groupdeposito_nama."</option>";
            $i++;
		}
    }
    function filter(){
        $data = $this->allfunct->securePost();
        $jenis	= $data['jenis'];
        $query = $this->db->query("SELECT groupdeposito_nama FROM master_groupdeposito WHERE kode_produk='".$jenis."'");
        $data = $query->result_array();
        if($query->num_rows() > 0) {
            $nama = $data[0]["groupdeposito_nama"];
            echo $nama;
        }else{
            echo "NULL";
        }
    }
    function nasabah()
    {
        $data = $this->allfunct->securePost();
        $nasabah	= $data['nasabah'];
        $query = $this->db->query("SELECT nama FROM tb_nasabah WHERE nomor_nasabah='".$nasabah."'");
        $data = $query->result_array();
        if($query->num_rows() > 0) {
            $nama = $data[0]["nama"];
            echo $nama;
        }else{
            echo "";
        }
    }
    function tabungan()
    {
        $data = $this->allfunct->securePost();
        $tab	= $data['tab'];
        $query = $this->db->query("SELECT nama FROM tb_tabungan AS t1 INNER JOIN tb_nasabah AS t2 ON t2.nomor_nasabah=t1.nomor_nasabah WHERE nomor_rekening ='".$tab."'");
        $data = $query->result_array();
        if($query->num_rows() > 0) {
            $nama = $data[0]["nama"];
            echo $nama;
        }else{
            echo "";
        }
    }
}

/* End of file */