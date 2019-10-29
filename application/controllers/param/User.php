<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/user.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class User extends CI_Controller {
    private $rootControllerPath = APPPATH.'/controllers/';
	function __construct()
	{
		parent::__construct();
        //$this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
        $this->load->library('encrypt');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "param";
        $this->menuactsub = "user";
	}
	
	//---- Halaman Setup User
    function index()
	{
        $data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $data['layanancontr'] =  array('' => 'Welcome','setortunai' => 'Setor Tunai','tariktunai' => 'Tarik Tunai','setordeposito' => 'Setor Deposito','pencairandeposito' => 'Pencairan Deposito','pencairanpembiayaan' => 'Pencairan Pembiayaan','angsuran' => 'Setor angsuran','lapmutasi' => 'Laporan mutasi','hapustransaksi' => 'Hapus Transaksi','help' => 'Help','profile' => 'Profile');
        $data['paramcontr'] = $this->_scanControllerParam();
        $data['basecontr'] = $this->_scanControllerBase();
        $data['accountingcontr'] = $this->_scanControllerAccounting();
        $data['transaksicontr'] = $this->_scanControllerTransaksi();
        $data['monitorcontr'] = $this->_scanControllerMonitor();
        $data['setting'] = $this->_scanControllerSetting();
        $data['toolcontr'] = $this->_scanControllerTool();
        $this->load->view('param/user',$data);
	}
    function _loadMenuset($parent)
    {
        $hasil = $this->master->getSetupMenu($parent);
        if ($hasil)
        {
            $this->isi[] = "<ul>";
            foreach($hasil as $item)
            {
                $icon = ($item['icon'] != "") ? "<img src=\"".$item['icon']."\" style=\"border:none;\"> " : "";
                $act = ($item['active'] == '1') ? "starsmall" : "starblacksmall";
                $this->isi[] = "<li id=\"".$item['menu_id']."\">[ ".$item['menu_id']."] ".$item['nama']." (Href :".$item['href']." Urutan : ".$item['urutan'].") <img class=\"macte\" src=\"assets/images/".$act.".png\" title=\"Active/Non Active\">&nbsp;<img class=\"medte\" src=\"assets/images/editsmall.png\" title=\"Edit\">";
                $this->_loadMenuset($item['menu_id']);
            }
             $this->isi[] = "</ul>";
        } else {
            $this->isi[] = "</li>";
        }
    }
    //---- Mengambil Menu sesuai ID
    function getMenuById()
    {
        $hasil = $this->db->get_where('menuapp', array('menu_id' => $this->input->post('id')))->row_array();
        $hasil['groups'] = unserialize($hasil['groups']);
        echo json_encode($hasil);
    }
    function getMenu()
    {
        $this-> _loadMenuset('0');
        foreach($this->isi as $item)
        {
            echo $item;
        }
    }
    
    /*
 *  --------------------- otoritas -----------------------------------------
 */
    //---- Simpan otoritas
    function saveotoritas()
    {
        echo $this->master->simpan('master_otoritas',$this->allfunct->securePost());
    }

    //---- Edit otoritas
    function editotoritas()
    {
        $data = $this->allfunct->securePost();
        $id	= $data['id'];
		unset($data['id']);
        $where = array('otoritas_id' => $id);
        echo $this->master->update("master_otoritas",$data,$where);
    }

    //---- Hapus otoritas
    function delotoritas()
    {
        $where = array('otoritas_id' => $this->input->post('id'));
        echo  $this->master->delete("master_otoritas",$where);
    }

    function get_otoritas()
    {
        $ff			= $this->input->post('ff');
		$if			= $this->input->post('if');
		$fd			= $this->input->post('fd');
		$adsc		= $this->input->post('adsc');
		$hal		= $this->input->post('hal');
		$juml		= $this->input->post('juml');
		$awal 		= $juml * ($hal - 1);
		$alldata 	= $this->modelku->getAllOtoritas($ff,$if,$fd,$adsc,$awal,$juml);
		$records 	= $alldata['numrow'];
		$page_num 	= ceil($records / $juml);
		if ($records > 0)
        {
            $hasil['total'] = $page_num;
            $hasil['alldata'] = $alldata['result'];
        	echo json_encode($hasil);
		}
    }
    // ---- Fungsi mendapatkan nama controller di param
	function _scanControllerParam()
	{
        //$root = (APPPATH.'/controllers/param/');
        $root = $this->rootControllerPath.'param/';
		$hasil = scandir($root);
		foreach($hasil as $val)
		{
			if((is_file($root.$val) == TRUE) AND (!preg_match('/^\.|html$/',$val)))
			{
                $ky = preg_replace('/.php$/', '', $val);
                $contr['param/'.$ky] = ucfirst($ky);
			}
		}
        return $contr;
	}
    // ---- Fungsi mendapatkan nama controller di base
	function _scanControllerBase()
	{
        //$root = ('./bmt-system/application/controllers/base/');
        $root = $this->rootControllerPath.'base/';
		$hasil = scandir($root);
		foreach($hasil as $val)
		{
			if((is_file($root.$val) == TRUE) AND (!preg_match('/^\.|html$/',$val)))
			{
                $ky = preg_replace('/.php$/', '', $val);
                $contr['base/'.$ky] = ucfirst($ky);
			}
		}
        return $contr;
	}
    // ---- Fungsi mendapatkan nama controller di akunting
	function _scanControllerAccounting()
	{
        //$root = ('./bmt-system/application/controllers/akunting/');
        $root = $this->rootControllerPath.'akunting/';
		$hasil = scandir($root);
		foreach($hasil as $val)
		{
			if((is_file($root.$val) == TRUE) AND (!preg_match('/^\.|html$/',$val)))
			{
                $ky = preg_replace('/.php$/', '', $val);
                $contr['akunting/'.$ky] = ucfirst($ky);
			}
		}
        return $contr;
	}
    // ---- Fungsi mendapatkan nama controller di trans
	function _scanControllerTransaksi()
	{
        //$root = ('./bmt-system/application/controllers/trans/');
        $root = $this->rootControllerPath.'trans/';
		$hasil = scandir($root);
		foreach($hasil as $val)
		{
			if((is_file($root.$val) == TRUE) AND (!preg_match('/^\.|html$/',$val)))
			{
                $ky = preg_replace('/.php$/', '', $val);
                $contr['trans/'.$ky] = ucfirst($ky);
			}
		}
        return $contr;
	}
    // ---- Fungsi mendapatkan nama controller di Monitor
	function _scanControllerMonitor()
	{
        //$root = ('./bmt-system/application/controllers/monitor/');
        $root = $this->rootControllerPath.'monitor/';
		$hasil = scandir($root);
		foreach($hasil as $val)
		{
			if((is_file($root.$val) == TRUE) AND (!preg_match('/^\.|html$/',$val)))
			{
                $ky = preg_replace('/.php$/', '', $val);
                $contr['monitor/'.$ky] = ucfirst($ky);
			}
		}
        return $contr;
	}
    // ---- Fungsi mendapatkan nama controller di Tool
	function _scanControllerTool()
	{
        //$root = ('./bmt-system/application/controllers/tool/');
        $root = $this->rootControllerPath.'tool/';
		$hasil = scandir($root);
		foreach($hasil as $val)
		{
			if((is_file($root.$val) == TRUE) AND (!preg_match('/^\.|html$/',$val)))
			{
                $ky = preg_replace('/.php$/', '', $val);
                $contr['tool/'.$ky] = ucfirst($ky);
			}
		}
        return $contr;
	}
	// ---- Fungsi mendapatkan nama controller di setting
	function _scanControllerSetting()
	{
        //$root = ('./bmt-system/application/controllers/setting/');
        $root = $this->rootControllerPath.'setting/';
		$hasil = scandir($root);
		foreach($hasil as $val)
		{
			if((is_file($root.$val) == TRUE) AND (!preg_match('/^\.|html$/',$val)))
			{
				$ky = preg_replace('/.php$/', '', $val);
				$contr['setting/'.$ky] = ucfirst($ky);
			}
		}
		return $contr;
	}
/*
 *  --------------------- USER -----------------------------------------
 */
    //---- Simpan User
    function saveUser()
    {
        $data = $this->allfunct->securePost();
        $data['terdaftar'] = date('Y-m-d H:i:s');
        $data['last_login'] = '0000-00-00 00:00:00';
        $data['from_host'] = '-';
        $data['password'] = $this->encrypt->encode($this->input->post('password'));
        echo $this->master->simpan('users',$data);
    }

    //---- Edit User
    function editUser()
    {
        $data = $this->allfunct->securePost();
        $id	= $data['id'];
		unset($data['id']);
        if ($this->input->post('password') != "")
        {
            $data['password'] = $this->encrypt->encode($this->input->post('password'));
        } else {
            unset($data['password']);
        }
        $where = array('user_id' => $id);
        echo $this->master->update("users",$data,$where);
    }

    //---- Hapus User
    function delUser()
    {
        $where = array('user_id' => $this->input->post('id'));
        echo  $this->master->delete("users",$where);
    }

    function get_user()
    {
        $ff			= $this->input->post('ff'); // Jenis Filter
		$if			= $this->input->post('if'); // Value Filter
		$fd			= $this->input->post('fd'); // Field Sorting
		$adsc		= $this->input->post('adsc'); // Asc or Desc
		$hal		= $this->input->post('hal'); // Offset Limit
		$juml		= $this->input->post('juml'); // Jumlah Limit
		$awal 		= $juml * ($hal - 1);
		$alldata 	= $this->modelku->getAllUser($ff,$if,$fd,$adsc,$awal,$juml);
		$records 	= $alldata['numrow'];
		$page_num 	= ceil($records / $juml);
		if ($records > 0)
        {
            $hasil['total'] = $page_num;
            $hasil['alldata'] = $alldata['result'];
        	echo json_encode($hasil);
		}
    }

    // ---- Fungsi membantu Autocomplete
    function search_nip()
	{
        $nip = strtolower($this->input->post('q'));
        $query = $this->db->select('pegawai_id, nip, nama_pegawai')->like('nip', $nip)->limit(6)->get('pegawai')->result();
        echo json_encode($query);
	}

    function search_namapeg()
	{
        $nama = strtolower($this->input->post('q'));
        $query = $this->db->select('pegawai_id, nip, nama_pegawai')->like('nama_pegawai', $nama)->limit(6)->get('pegawai')->result();
        echo json_encode($query);
	}

    //---- Fungsi Merubah Aktive
    function changeActive()
    {
         $data  = array("active" => $this->input->post('act'));
         $where = array('user_id' => $this->input->post('id'));
         echo $this->master->update("users",$data,$where);
    }

/*
 *  --------------------- GROUPS -----------------------------------------
 */
    //---- Simpan Group
    function saveGroup()
    {
        $data = $this->allfunct->securePost();
        $data['controller'] = serialize($data['controller']);
        echo $this->master->simpan('groups',$data);
    }

    //---- Edit Group
    function editGroup()
    {
        $data = $this->allfunct->securePost();
        $id	= $data['id'];
		unset($data['id']);
        $where = array('group_id' => $id);
        $data['controller'] = serialize($data['controller']);
        echo $this->master->update("groups",$data,$where);
    }

    //---- Hapus group
    function delGroup()
    {
        $where = array('group_id' => $this->input->post('id'));
        echo  $this->master->delete("groups",$where);
    }

    function get_group()
    {
        $ff			= $this->input->post('ff'); // Jenis Filter
		$if			= $this->input->post('if'); // Value Filter
		$fd			= $this->input->post('fd'); // Field Sorting
		$adsc		= $this->input->post('adsc'); // Asc or Desc
		$hal		= $this->input->post('hal'); // Offset Limit
		$juml		= $this->input->post('juml'); // Jumlah Limit
		$awal 		= $juml * ($hal - 1);
		$alldata 	= $this->modelku->getAllGroup($ff,$if,$fd,$adsc,$awal,$juml);
		$records 	= $alldata['numrow'];
		$page_num 	= ceil($records / $juml);
        if ($records > 0)
        {
			foreach ($alldata['result'] as $row) {
				$mod = unserialize($row["controller"]);
				$row["controller"] = implode("<br>",$mod);
				$json[] = $row;
           	}
            $hasil['total'] = $page_num;
            $hasil['alldata'] = $json;
        	echo json_encode($hasil);
		}
    }

    //---- Fungsi mengisi option Groups pada form User
    function isi_groups()
    {
        $hasil = $this->db->select('group_id,nama_group')->get('groups')->result();
        $i=0;
        foreach ($hasil as $row)
		{
    		$clr = (($i%2) == 0) ? '#fff' : '#EFF1F1';
            echo "<option style=\"background:".$clr."\" value=\"".$row->group_id."\">".$row->nama_group."</option>";
            $i++;
		}
    }

}

/* End of file */