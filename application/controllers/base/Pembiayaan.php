<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
* Copyright (c) 2014
*
* file   : base/pembiayaan.php
* author : Edi Suwoto S.Komp
* email  : edi.suwoto@gmail.com
*/
/*----------------------------------------------------------*/
class Pembiayaan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "base";
        $this->menuactsub = "pembiayaan";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('base/pembiayaan',$data);
	}
    
    function run_code()
    {
        $id	= $this->input->post('id');
        $query = $this->db->query("SELECT count(*) AS jlh FROM tb_pembiayaan WHERE nomor_rekening LIKE '$id%'");
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
        $query = $this->db->query("SELECT kode_produk FROM master_grouppembiayaan");
        $data = $query->result_array();
        echo $data[0]["kode_produk"];
    }
    function produk_name()
    {
        $id = $this->input->post('id');
        $query = $this->db->query("SELECT grouppembiayaan_nama FROM master_grouppembiayaan WHERE kode_produk='$id'");
        $data = $query->result_array();
        echo strtoupper($data[0]["grouppembiayaan_nama"]);
    }
    // ---- Fungsi membantu Autocomplete
    function search_nasabah()
	{
        $nama = strtoupper($this->input->post('q'));
        $query = $this->db->select('nomor_nasabah,nama,alamat,rtrw,kabupaten')->like('nama', $nama)->limit(20)->get('tb_nasabah')->result();
        echo json_encode($query);
	}
    // ---- Fungsi membantu Autocomplete
    function search_ao()
	{
        $nama = strtoupper($this->input->post('q'));
        $query = $this->db->select('nip,nama_pegawai')->like('nama_pegawai', $nama)->limit(20)->get('pegawai')->result();
        echo json_encode($query);
	}
    // ---- Fungsi membantu Autocomplete
    function search_jaminan()
	{
        $nama = strtoupper($this->input->post('q'));
        $query = $this->db->select('nomor_jaminan,nilai_jaminan,pemilik')->like('nomor_jaminan', $nama)->limit(20)->get('tb_jaminan')->result();
        echo json_encode($query);
	}
    /// save new pembiayaan
    function savepembiayaan(){
        $data = $this->allfunct->securePost();
        if($data['tgl_dibuka'] !=""){
            $data['tgl_dibuka'] = $this->allfunct->revDate($data['tgl_dibuka']);
        }
        if($data['mulai_angsuran'] !=""){
            $data['mulai_angsuran'] = $this->allfunct->revDate($data['mulai_angsuran']);
        }
        $tgl_trans = time();
        $tanggal_mulai = $this->allfunct->revDate($data['mulai_angsuran']);
        if($data['type_angsuran'] =="HARI"){
            $tgljatuhtempo = $tgl_trans + (60 * 60 * 24 * $data['lama_angsuran']);
        }elseif($data['type_angsuran'] =="MINGGU"){
            $tgljatuhtempo = $tgl_trans + (60 * 60 * 24 * $data['lama_angsuran'] * 7);
        }elseif($data['type_angsuran'] =="BULAN"){
            $tgljatuhtempo = mktime(0,0,0,date('m')+ $data['lama_angsuran']);
        }
        $data['jatuh_tempo'] = date('Y-m-d', $tgljatuhtempo);
        unset($data['id']);
        unset($data['id_pemb']);
        unset($data['nomor_aoname']);
        unset($data['nama']);
        unset($data['alamat']);
        unset($data['kota']);
        unset($data['nilai_jaminan']);
        $data['create_by'] = $this->session->userdata('username');
        $data['update_by'] = $this->session->userdata('username');
        echo $this->master->simpan('tb_pembiayaan',$data);
        $id = $this->db->insert_id();
        $this->dataangsuran($id);
    }
    function editpembiayaan(){
        $data = $this->allfunct->securePost();
        $id	= $data['id_pemb'];
        unset($data['id_pemb']);
        unset($data['nomor_rekening']);
        unset($data['tgl_dibuka']);
        unset($data['nomor_aoname']);
        unset($data['nama']);
        unset($data['alamat']);
        unset($data['kota']);
        unset($data['nilai_jaminan']);
        if($data['tgl_akad'] !=""){
            $data['tgl_akad'] = $this->allfunct->revDate($data['tgl_akad']);
        }
        //if($data['jatuh_tempo'] !=""){
        //    $data['jatuh_tempo'] = $this->allfunct->revDate($data['jatuh_tempo']);
        //}
        if($data['mulai_angsuran'] !=""){
            $data['mulai_angsuran'] = $this->allfunct->revDate($data['mulai_angsuran']);
        }
        if($data['selesai_angsuran'] !=""){
            $data['selesai_angsuran'] = $this->allfunct->revDate($data['selesai_angsuran']);
        }
        $data['update_by'] = $this->session->userdata('username');
        $where = array('pembiayaan_id' => $id);
        echo $this->master->update("tb_pembiayaan",$data,$where);
        $this->dataangsuran($id);
		
    }
    function dataangsuran($id_pembiayaan){
        $where = array('id_pembiayaan' => $id_pembiayaan);
        $this->master->delete("tb_pembiayaandetail",$where);
        $query = $this->db->query("SELECT modal,nisbah_bank,nisbah_nasabah,pinjaman,harga_pokok,marjin,uang_muka,lama_angsuran,mulai_angsuran,type_angsuran FROM tb_pembiayaan WHERE pembiayaan_id=$id_pembiayaan");
        if($query->num_rows() > 0) {
            $data = $query->result_array();
            $minggu = 6;
            if(($data[0]['harga_pokok'] != 0)||($data[0]['harga_pokok'] != 0)){
                $pokok = $data[0]['harga_pokok'] / $data[0]['lama_angsuran'];
                $margin = $data[0]['marjin'] / $data[0]['lama_angsuran'];
                $jumlah = $pokok + $margin;
                for($i=0;$i < $data[0]['lama_angsuran'];$i++){
	                if($data[0]['type_angsuran'] == "HARI"){
		                $dateangs = $this->authlib->getNextBillDay($data[0]['mulai_angsuran'],$i);
	                }elseif($data[0]['type_angsuran'] == "MINGGU"){
		                $dateangs = $this->authlib->getNextBillMinggu($data[0]['mulai_angsuran'],$minggu);
		                $minggu += 7;
	                }elseif($data[0]['type_angsuran'] == "BULAN"){
		                $dateangs = $this->authlib->getNextBillDate($data[0]['mulai_angsuran'],$i);
	                }
                    $data1['id_pembiayaan'] = $id_pembiayaan;
                    $data1['tgl_angsuran'] = $dateangs;
                    $data1['pokok'] = $pokok;
                    $data1['margin'] = $margin;
                    $data1['jumlah'] = $jumlah;
                    $data1['create_by'] = $this->session->userdata('username');
                    $data1['update_by'] = $this->session->userdata('username');
                    $this->master->simpan('tb_pembiayaandetail',$data1);
                }
            }elseif(($data[0]['modal'] != 0)){
            	$nisbah_bank = $data[0]['nisbah_bank'];
                $nisbah_nasabah = $data[0]['nisbah_nasabah'];
                $modal = $data[0]['modal'];
                
                $pokok = $modal / $data[0]['lama_angsuran'];
                $margin = 0;
                $jumlah = $pokok + $margin;
                for($i=0;$i < $data[0]['lama_angsuran'];$i++){
	                if($data[0]['type_angsuran'] == "HARI"){
		                $dateangs = $this->authlib->getNextBillDay($data[0]['mulai_angsuran'],$i);
	                }elseif($data[0]['type_angsuran'] == "MINGGU"){
		                $dateangs = $this->authlib->getNextBillMinggu($data[0]['mulai_angsuran'],$minggu);
		                $minggu += 7;
	                }elseif($data[0]['type_angsuran'] == "BULAN"){
		                $dateangs = $this->authlib->getNextBillDate($data[0]['mulai_angsuran'],$i);
	                }
                    $data1['id_pembiayaan'] = $id_pembiayaan;
                    $data1['tgl_angsuran'] = $dateangs;
                    $data1['pokok'] = $pokok;
                    $data1['margin'] = $margin;
                    $data1['jumlah'] = $jumlah;
                    $data1['create_by'] = $this->session->userdata('username');
                    $data1['update_by'] = $this->session->userdata('username');
                    $this->master->simpan('tb_pembiayaandetail',$data1);
                }
            }
            
        }
        
    }
    function get_pembiayaan()
    {
        $ff			= $this->input->post('ff'); // Jenis Filter
		$if			= $this->input->post('if'); // Value Filter
		$fd			= $this->input->post('fd'); // Field Sorting
		$adsc		= $this->input->post('adsc'); // Asc or Desc
		$hal		= $this->input->post('hal'); // Offset Limit
		$juml		= $this->input->post('juml'); // Jumlah Limit
		$awal 		= $juml * ($hal - 1);
		$alldata 	= $this->modelku->getAllPembiayaan($ff,$if,$fd,$adsc,$awal,$juml);
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
    function get_jadwalview()
    {
        $objord = $this->input->post('id');
        $query = $this->db->query("SELECT accounttrans_code,accounttrans_date,accounttrans_value FROM tb_accounttrans WHERE accounttrans_user='".$objord."' AND accounttrans_type='15' order by accounttrans_date");
        $data = $query->result_array();
        //echo $data;
        $hasil['alldata'] = $data;
        echo json_encode($hasil);
    }
    //---- Fungsi mengisi option pembiayaan
    function isi_pembiayaan()
    {
        $hasil = $this->db->select('kode_produk,grouppembiayaan_nama')->get('master_grouppembiayaan')->result();
        $i=0;
        foreach ($hasil as $row)
		{
    		$clr = (($i%2) == 0) ? '#fff' : '#EFF1F1';
            echo "<option style=\"background:".$clr."\" value=\"".$row->kode_produk."\">".$row->grouppembiayaan_nama."</option>";
            $i++;
		}
    }
    function filterpembiayaan(){
        $data = $this->allfunct->securePost();
        $jenis	= $data['jenis'];
        $query = $this->db->query("SELECT grouppembiayaan_nama FROM master_grouppembiayaan WHERE kode_produk='".$jenis."'");
        $data = $query->result_array();
        if($query->num_rows() > 0) {
            $nama = $data[0]["grouppembiayaan_nama"];
            echo $nama;
        }else{
            echo "NULL";
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
    function single_jaminan()
    {
        $data = $this->allfunct->securePost();
        $id	= $data['id'];
        $query = $this->db->query("SELECT nilai_jaminan FROM tb_jaminan WHERE nomor_jaminan ='".$id."'");
        $data = $query->result_array();
        if($query->num_rows() > 0) {
            $ppeg = $data[0]["nilai_jaminan"];
            echo $ppeg;
        }else{
            echo "";
        }
    }
}

/* End of file */