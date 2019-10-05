<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/listakun.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Listakun extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "param";
        $this->menuactsub = "listakun";
	}

    //---- Admin jabatan
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('param/listakun',$data);
	}
    
    function get_akun()
    {
        $ff			= $this->input->post('ff'); // Jenis Filter
		$if			= $this->input->post('if'); // Value Filter
		$fd			= $this->input->post('fd'); // Field Sorting
		$adsc		= $this->input->post('adsc'); // Asc or Desc
		$hal		= $this->input->post('hal'); // Offset Limit
		$juml		= $this->input->post('juml'); // Jumlah Limit
		$awal 		= $juml * ($hal - 1);
		$alldata 	= $this->modelku->getAllListakun($ff,$if,$fd,$adsc,$awal,$juml);
		$records 	= $alldata['numrow'];
		$page_num 	= ceil($records / $juml);
		if ($records > 0)
        {
            $hasil['total'] = $page_num;
            $hasil['alldata'] = $alldata['result'];
        	echo json_encode($hasil);
		}
    }
    function get_tahunbuku()
    {
        $ff			= $this->input->post('ff'); // Jenis Filter
		$if			= $this->input->post('if'); // Value Filter
		$fd			= $this->input->post('fd'); // Field Sorting
		$adsc		= $this->input->post('adsc'); // Asc or Desc
		$hal		= $this->input->post('hal'); // Offset Limit
		$juml		= $this->input->post('juml'); // Jumlah Limit
		$awal 		= $juml * ($hal - 1);
		$alldata 	= $this->modelku->getAllListtahunbuku($ff,$if,$fd,$adsc,$awal,$juml);
		$records 	= $alldata['numrow'];
		$page_num 	= ceil($records / $juml);
		if ($records > 0)
        {
            $hasil['total'] = $page_num;
            $hasil['alldata'] = $alldata['result'];
        	echo json_encode($hasil);
		}
    }
    //---- Toogle Active
    function toogleActive()
    {
        $data = array('active' => "0");
        $where = array('active' => "1");
        $this->master->update("master_tahunbuku",$data,$where);
        
        $data = array('active' => $this->input->post('val'));
        $where = array('tahunbuku_id' => $this->input->post('id'));
        echo $this->master->update("master_tahunbuku",$data,$where);
    }
    //---- Simpan tahun buku
    function saveTahunbuku()
    {
        $data = $this->allfunct->securePost();
        $data['tgl_mulai'] = $this->allfunct->revDate($data['tgl_mulai']);
        $data['tgl_akhir'] = $this->allfunct->revDate($data['tgl_akhir']);
        echo $this->master->simpan("master_tahunbuku",$data);
    }
    //---- Edit tahun buku
    function editTahunbuku()
    {
        $data = $this->allfunct->securePost();
        $data['tgl_mulai'] = $this->allfunct->revDate($data['tgl_mulai']);
        $data['tgl_akhir'] = $this->allfunct->revDate($data['tgl_akhir']);
        $id	= $data['id'];
		unset($data['id']);
        $where = array('tahunbuku_id' => $id);
        echo $this->master->update("master_tahunbuku",$data,$where);
    }
    function saveakun()
    {
    	$data = $this->allfunct->securePost();
        $query = $this->db->query("SELECT listakun_pattern FROM coa_listakun WHERE listakun_id ='".$data['listakun_parent']."'");
    	$data1 = $query->result_array();
    	$data['listakun_pattern'] = $data1[0]["listakun_pattern"]."*".$data['listakun_parent'];
    	$data['listakun_active'] = "1";
    	$data['listakun_sign'] = "-1";
        echo $this->master->simpan('coa_listakun',$data);
    }
    function editakun()
    {
        $data = $this->allfunct->securePost();
        $id	= $data['id'];
		unset($data['id']);
        $where = array('listakun_id' => $id);
        echo $this->master->update("coa_listakun",$data,$where);
    }
    //---- Fungsi list akun
    function isi_akun1()
    {
        $hasil = $this->db->query("SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun WHERE  `listakun_name` NOT LIKE 'KAS TELLER%' ORDER BY listakun_code")->result();
        $i=0;
        echo "<option>----------</option>";
        foreach ($hasil as $row)
		{
    		$clr = (($i%2) == 0) ? '#fff' : '#EFF1F1';
            echo "<option style=\"background:".$clr."\" value=\"".$row->listakun_id."\">".$row->listakun_code." ".$row->listakun_name."</option>";
            $i++;
		}
    }
    //---- Fungsi list akun
    function isi_akun()
    {
        $hasil = $this->db->query('SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun ORDER BY listakun_code')->result();
        $i=0;
        echo "<option>----------</option>";
        foreach ($hasil as $row)
		{
    		$clr = (($i%2) == 0) ? '#fff' : '#EFF1F1';
            echo "<option style=\"background:".$clr."\" value=\"".$row->listakun_id."\">".$row->listakun_code." ".$row->listakun_name."</option>";
            $i++;
		}
    }
    //--- Fungsi di Tree View
    function getTreeCOA()
    {
        $hasil = $this->db->query("SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun WHERE listakun_parent = '0'")->result();
        $isi = "<ul class=\"tree\" id=\"tree_1\">";
		foreach ($hasil as $row)
		{
    		$isi .= "<li><a href=\"#\" data-role=\"branch\" class=\"tree-toggle closed\" data-toggle=\"branch\" data-value=\"".$row->listakun_name."\">[".$row->listakun_code."] ".$row->listakun_name."</a>";
            $isi .= "<ul class=\"branch\">";
            $hasill = $this->db->query("SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun WHERE listakun_parent = '".$row->listakun_id."'")->result();
            foreach ($hasill as $val) 
            {
                $isi .= "<li><a href=\"#\" class=\"tree-toggle closed\" data-toggle=\"branch\" data-value=\"".$row->listakun_name."\" id=\"nut1\">[".$val->listakun_code."] ".$val->listakun_name."</a>";
                $isi .= "<ul class=\"branch\">";
                $hasilll = $this->db->query("SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun WHERE listakun_parent = '".$val->listakun_id."'")->result();
                foreach ($hasilll as $val1) 
                {
                    $isi .= "<li><a href=\"#\" class=\"tree-toggle closed\" data-toggle=\"branch\" data-value=\"".$row->listakun_name."\" id=\"nut2\">[".$val1->listakun_code."] ".$val1->listakun_name."</a>";
                    $isi .= "<ul class=\"branch\">";
                    $hasillll = $this->db->query("SELECT listakun_id,listakun_code,listakun_name FROM coa_listakun WHERE listakun_parent = '".$val1->listakun_id."'")->result();
                    foreach ($hasillll as $val2) 
                    {
                        $isi .= "<li><a href=\"#\" data-role=\"leaf\">[".$val2->listakun_code."] ".$val2->listakun_name."</a></li>";
                    }
                    $isi .= "</ul>";
                    $isi .= "</li>";
                }
                $isi .= "</ul>";
                $isi .= "</li>";
            }
            $isi .= "</ul>";
            $isi .= "</li>";
		}
        echo $isi."</ul>";
    }

}

/* End of file */