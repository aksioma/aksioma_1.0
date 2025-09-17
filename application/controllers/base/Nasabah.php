<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
* Copyright (c) 2014
*
* file   : base/nasabah.php
* author : Edi Suwoto S.Komp
* email  : edi.suwoto@gmail.com
*/
/*----------------------------------------------------------*/
class Nasabah extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "base";
        $this->menuactsub = "nasabah";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $data['excel'] = true;
        $data['excelclass'] = "excel_nasabah";
        $this->load->view('base/nasabah',$data);
	}
	function cetak_excel(){
		$alldata 	= $this->modelku->getAllNasabah($ff,$if,$fd,$adsc,$awal,$juml);
		
		$data['hasi'] = $alldata;
		$data['filename'] = "data_nasabah";
		$this->load->view('spreadsheet_view',$data);
	}
    
    function run_code()
    {
        $query = $this->db->query("SELECT kode FROM bmt_wilayah AS t1 INNER JOIN bmt AS t2 ON t2.wilayah_kerja =t1.kode");
        $data = $query->result_array();
        $cabang = $data[0]["kode"];
        
        $num = $this->db->count_all_results('tb_nasabah') + 1;
        $paddedNum = sprintf("%03d", $num);
        
        echo  $cabang."".date('m')."".date('y')."".$paddedNum;
    }
    function cab_code()
    {
        $query = $this->db->query("SELECT kode FROM bmt_wilayah AS t1 INNER JOIN bmt AS t2 ON t2.wilayah_kerja =t1.kode");
        $data = $query->result_array();
        echo $data[0]["kode"];
    }
    /// save new Nasabah
    function saveNasabah(){
        $data = $this->allfunct->securePost();
        if($data['tgl_masuk'] !=""){
            $data['tgl_masuk'] = $this->allfunct->revDate($data['tgl_masuk']);
        }
        if($data['tanggal_lahir'] !=""){
            $data['tanggal_lahir'] = $this->allfunct->revDate($data['tanggal_lahir']);
        }
        if($data['berlaku_identitas_waris'] !=""){
        	$data['berlaku_identitas_waris'] = $this->allfunct->revDate($data['berlaku_identitas_waris']);
        }
        if($data['berlaku_identitas'] !=""){
        	$data['berlaku_identitas'] = $this->allfunct->revDate($data['berlaku_identitas']);
        }
        $data['create_by'] = $this->session->userdata('username');
        $data['update_by'] = $this->session->userdata('username');
        echo $this->master->simpan('tb_nasabah',$data);
    }
    function editNasabah(){
        $data = $this->allfunct->securePost();
        $id	= $data['nomor_nasabah'];
		unset($data['nomor_nasabah']);
        unset($data['tgl_masuk']);
        if($data['tanggal_lahir'] !=""){
            $data['tanggal_lahir'] = $this->allfunct->revDate($data['tanggal_lahir']);
            $data['berlaku_identitas'] = $this->allfunct->revDate($data['berlaku_identitas']);
            $data['berlaku_identitas_waris'] = $this->allfunct->revDate($data['berlaku_identitas_waris']);
        }
        $data['update_by'] = $this->session->userdata('username');
        $where = array('nomor_nasabah' => $id);
        echo $this->master->update("tb_nasabah",$data,$where);
    }
    function get_nasabah()
    {
        $ff			= $this->input->post('ff'); // Jenis Filter
		$if			= $this->input->post('if'); // Value Filter
		$fd			= $this->input->post('fd'); // Field Sorting
		$adsc		= $this->input->post('adsc'); // Asc or Desc
		$hal		= $this->input->post('hal'); // Offset Limit
		$juml		= $this->input->post('juml'); // Jumlah Limit
		$awal 		= $juml * ($hal - 1);
		$alldata 	= $this->modelku->getAllNasabah($ff,$if,$fd,$adsc,$awal,$juml);
		$records 	= $alldata['numrow'];
		$page_num 	= ceil($records / $juml);
		if ($records > 0)
        {
            
            $hasil['total'] = $page_num;
            $hasil['alldata'] = $alldata['result'];
        	echo json_encode($hasil);
		}
    }
    
    function isi_propinsi()
    {
        $hasil = $this->db->select('kodeBPS,namaProvinsi')->get('provinsi')->result();
        $i=0;
        $pTitle = "<option style=\"background:#EFF1F1\" value=\"0\">--------pilih propinsi-------</option>";
        foreach ($hasil as $row)
		{
    		$clr = (($i%2) == 0) ? '#fff' : '#EFF1F1';
            $pTitle .= "<option style=\"background:".$clr."\" value=\"".$row->kodeBPS."\">".$row->namaProvinsi."</option>";
            $i++;
		}
        echo $pTitle;
    }
    function isi_kabupaten()
    {
        $data = $this->allfunct->securePost();
        $prov	= $data['prov'];
        $hasil = $this->db->query("SELECT kodeBPS,namaKabupaten, case when substring(kodeBPS, 3, 1) = '7' then concat('KOTA ', namaKabupaten) else namaKabupaten end AS titlename 
                                    FROM kabupaten
                                    WHERE kodeProvinsi='".$prov."' order by namaKabupaten")->result();
        $i=0;
        $pTitle = "<option style=\"background:#EFF1F1\" value=\"0\">--------pilih kabupaten-------</option>";
        foreach ($hasil as $row)
		{
    		$clr = (($i%2) == 0) ? '#fff' : '#EFF1F1';
            $item = explode(' ', $row->titlename);
            if($item[0] == "KOTA"){
                $n1 = "KOTA";
                $n2 = $item[1];
            }else{
                $n1 = "KABUPATEN";
                $n2 = $row->titlename;
            }
            $pTitle .= "<option style=\"background:".$clr."\" value=\"".$row->kodeBPS."\">".$n1." ".$n2."</option>";
            $i++;
		}
        echo $pTitle;
    }
    function isi_kecamatan()
    {
        $data = $this->allfunct->securePost();
        $kab	= $data['kab'];
        $hasil = $this->db->query("SELECT kodeBps,namaKecamatan
                                    FROM kecamatan
                                    WHERE kodeKabupaten='".$kab."' order by namaKecamatan")->result();
        $i=0;
        $pTitle = "<option style=\"background:#EFF1F1\" value=\"0\">--------pilih kecamatan-------</option>";
        foreach ($hasil as $row)
		{
    		$clr = (($i%2) == 0) ? '#fff' : '#EFF1F1';
            $pTitle .= "<option style=\"background:".$clr."\" value=\"".$row->kodeBps."\">".$row->namaKecamatan."</option>";
            $i++;
		}
        echo $pTitle;
    }
    function single_kabupaten()
    {
        $data = $this->allfunct->securePost();
        $kab	= $data['kab'];
        $query = $this->db->query("SELECT namaKabupaten FROM kabupaten WHERE kodeBPS='".$kab."'");
        $data = $query->result_array();
        if($query->num_rows() > 0) {
            $pkab = $data[0]["namaKabupaten"];
            echo $pkab;
        }else{
            echo "";
        }
    }
    function single_kecamatan()
    {
        $data = $this->allfunct->securePost();
        $kec	= $data['kec'];
        $query = $this->db->query("SELECT namaKecamatan FROM kecamatan WHERE kodeBps='".$kec."'");
        $data = $query->result_array();
        if($query->num_rows() > 0) {
            $pkec = $data[0]["namaKecamatan"];
            echo $pkec;
        }else{
            echo "";
        }
    }
    
}

/* End of file */