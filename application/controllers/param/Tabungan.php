<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/tabungan.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Tabungan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "param";
        $this->menuactsub = "tabungan";
	}

    //---- Pameter Nasabah
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('param/tabungan',$data);
	}
    
    //---- Edit Tabungan info
    function editMTabungan()
    {
        $data = $this->allfunct->securePost();
        $data1['kode_produk'] =  $data['kode_produk'];
        $this->master->simpan("master_tabungan",$data1);
       	$id	= $data['kode_produk'];
		unset($data['kode_produk']);
        $where = array('kode_produk' => $id);
        echo $this->master->update("master_tabungan",$data,$where);
        
    }
    function get_tabunganinfo()
    {
        $objord = $this->input->post('id');
        $query = $this->db->query("SELECT * FROM master_tabungan WHERE kode_produk='".$objord."'");
        $data = $query->result_array();
        $hasil['alldata'] = $data;
        echo json_encode($hasil);
    }


/*
 *  --------------------- biaya -----------------------------------------
 */
    //---- Simpan biaya
    function savebiaya()
    {
        $data = $this->allfunct->securePost();
        $data['kode'] = $data['kode'];
        $data['nama'] = $data['nama'];
        echo $this->master->simpan('master_biaya',$data);
    }

    //---- Edit biaya
    function editbiaya()
    {
        $data = $this->allfunct->securePost();
        $data['kode'] = $data['kode'];
        $data['nama'] = $data['nama'];
        $id	= $data['id'];
		unset($data['id']);
        $where = array('biaya_id' => $id);
        echo $this->master->update("master_biaya",$data,$where);
    }

    //---- Hapus biaya
    function delbiaya()
    {
        $where = array('biaya_id' => $this->input->post('id'));
        echo  $this->master->delete("master_biaya",$where);
    }

    function get_biaya()
    {
        $ff			= $this->input->post('ff'); // Jenis Filter
		$if			= $this->input->post('if'); // Value Filter
		$fd			= $this->input->post('fd'); // Field Sorting
		$adsc		= $this->input->post('adsc'); // Asc or Desc
		$hal		= $this->input->post('hal'); // Offset Limit
		$juml		= $this->input->post('juml'); // Jumlah Limit
		$awal 		= $juml * ($hal - 1);
		$alldata 	= $this->modelku->getAllBiaya($ff,$if,$fd,$adsc,$awal,$juml);
		$records 	= $alldata['numrow'];
		$page_num 	= ceil($records / $juml);
		if ($records > 0)
        {
            $hasil['total'] = $page_num;
            $hasil['alldata'] = $alldata['result'];
        	echo json_encode($hasil);
		}
    }

/*
 *  --------------------- Kode Mutasi -----------------------------------------
 */
    //---- Simpan mutasi
    function savemutasi()
    {
        $this->master->simpan('master_kodemutasi',$this->allfunct->securePost());
        $resp = $this->allfunct->securePost();
        $data1['kode_produk'] = $resp['kode_produk'];
        echo $this->master->simpan('master_tabungan',$data1);
    }

    //---- Edit mutasi
    function editmutasi()
    {
        $data = $this->allfunct->securePost();
        $id	= $data['id'];
		unset($data['id']);
        $where = array('mutasi_id' => $id);
        echo $this->master->update("master_kodemutasi",$data,$where);
    }

    //---- Hapus mutasi
    function delmutasi()
    {
        $where = array('mutasi_id' => $this->input->post('id'));
        echo  $this->master->delete("master_kodemutasi",$where);
    }

    function get_mutasi()
    {
        $ff			= $this->input->post('ff'); // Jenis Filter
		$if			= $this->input->post('if'); // Value Filter
		$fd			= $this->input->post('fd'); // Field Sorting
		$adsc		= $this->input->post('adsc'); // Asc or Desc
		$hal		= $this->input->post('hal'); // Offset Limit
		$juml		= $this->input->post('juml'); // Jumlah Limit
		$awal 		= $juml * ($hal - 1);
		$alldata 	= $this->modelku->getAllKodeMutasi($ff,$if,$fd,$adsc,$awal,$juml);
		$records 	= $alldata['numrow'];
		$page_num 	= ceil($records / $juml);
		if ($records > 0)
        {
            $hasil['total'] = $page_num;
            $hasil['alldata'] = $alldata['result'];
        	echo json_encode($hasil);
		}
    }
    //---- Fungsi level otorisasi
    function isi_level()
    {
        $hasil = $this->db->select('jabatan_id,nama_jabatan')->get('jabatan')->result();
        $i=0;
        foreach ($hasil as $row)
		{
    		$clr = (($i%2) == 0) ? '#fff' : '#EFF1F1';
            echo "<option style=\"background:".$clr."\" value=\"".$row->jabatan_id."\">".$row->nama_jabatan."</option>";
            $i++;
		}
    }
    //
    //---- Simpan produk
    function saveproduk()
    {
        echo $this->master->simpan('master_grouptabungan',$this->allfunct->securePost());
        
    }

    //---- Edit produk
    function editproduk()
    {
        $data = $this->allfunct->securePost();
        $id	= $data['id'];
		unset($data['id']);
        $where = array('grouptabungan_id' => $id);
        echo $this->master->update("master_grouptabungan",$data,$where);
    }
    function get_produk()
    {
        $ff			= $this->input->post('ff'); // Jenis Filter
		$if			= $this->input->post('if'); // Value Filter
		$fd			= $this->input->post('fd'); // Field Sorting
		$adsc		= $this->input->post('adsc'); // Asc or Desc
		$hal		= $this->input->post('hal'); // Offset Limit
		$juml		= $this->input->post('juml'); // Jumlah Limit
		$awal 		= $juml * ($hal - 1);
		$alldata 	= $this->modelku->getAllTabunganProduk($ff,$if,$fd,$adsc,$awal,$juml);
		$records 	= $alldata['numrow'];
		$page_num 	= ceil($records / $juml);
		if ($records > 0)
        {
            $hasil['total'] = $page_num;
            $hasil['alldata'] = $alldata['result'];
        	echo json_encode($hasil);
		}
    }
}

/* End of file */