<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : plugin/install.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Install extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "plugin";
        $this->menuactsub = "install";
	}

    //---- Admin
	function index()
	{
		$data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $data['logo'] = $this->authlib->getLogo();
        $data['imgsrc'] = $this->authlib->getLogo();
        $this->load->view('plugin/install',$data);
	}
	function uploadplugin()
	{
		$config['upload_path'] = 'assets/plugin/';
		$config['allowed_types'] = 'zip|rar';
		$this->load->library('upload', $config);
		
		if (!$this->upload->do_upload()){
			echo  strip_tags($this->upload->display_errors());
		} else {
			$hasil = $this->upload->data();
			$fileasli = $hasil['full_path'];
			$this->load->library('unzip');
			// Optional: Only take out these files, anything else is ignored
			$this->unzip->allow(array('css', 'js', 'png', 'gif', 'jpeg', 'jpg', 'tpl', 'html', 'swf'));
			// Give it one parameter and it will extract to the same folder
			$this->unzip->extract($fileasli);
			
			// or specify a destination directory
			$this->unzip->extract($fileasli, 'assets/plugin/');
			if (file_exists($fileasli)){
				unlink($fileasli);
			}
			$data['name_plugin'] = $hasil['raw_name'];
			$data['desc'] = $hasil['raw_name'];
			$data['path'] = $hasil['file_path']."".$hasil['raw_name']."/";
			$data['status'] = 1;
			echo $this->master->simpan('plugin',$data); 
		}
	}
	function get_plugin()
	{
		$ff			= $this->input->post('ff'); // Jenis Filter
		$if			= $this->input->post('if'); // Value Filter
		$fd			= $this->input->post('fd'); // Field Sorting
		$adsc		= $this->input->post('adsc'); // Asc or Desc
		$hal		= $this->input->post('hal'); // Offset Limit
		$juml		= $this->input->post('juml'); // Jumlah Limit
		$awal 		= $juml * ($hal - 1);
		$alldata 	= $this->modelku->getAllPlugin($ff,$if,$fd,$adsc,$awal,$juml);
		$records 	= $alldata['numrow'];
		$page_num 	= ceil($records / $juml);
		if ($records > 0)
		{
			$hasil['total'] = $page_num;
			$hasil['alldata'] = $alldata['result'];
			echo json_encode($hasil);
		}else{
			$hasil['total'] = 0;
			echo json_encode($hasil);
		}
	}
	function toogleActive()
	{
		$data = array('status' => $this->input->post('val'));
		$where = array('plugin_id' => $this->input->post('id'));
		echo $this->master->update("plugin",$data,$where);
	}
	function delplugin()
	{
		$this->load->helper("file");
		$data = $this->allfunct->securePost();
		$id	= $data['id'];
		$this->delete_directory($data['path']);
		$where = array('plugin_id' => $id);
		echo $this->master->delete("plugin",$where);
	}
	function delete_directory($path)
	{
		$this->load->helper("file"); // load the helper
		delete_files($path, true); // delete all files/folders
		//rmdir($dirname);
		if(rmdir($path)){}
			else{}
		return true;
	}
	/// menu plugin
	function getMenu()
	{
		$this-> _loadMenuset('58');
		foreach($this->isi as $item)
		{
			echo $item;
		}
	}
	//---- Fungsi mengisi option menu plugin
	function isi_menuplugin()
	{
		$hasil = $this->db->query('SELECT name_plugin FROM plugin WHERE status=1')->result();
		$i=0;
		foreach ($hasil as $row)
		{
			$clr = (($i%2) == 0) ? '#fff' : '#EFF1F1';
			echo "<option style=\"background:".$clr."\" value=\"/plugin/view/main/".$row->name_plugin."\">".$row->name_plugin."</option>";
			$i++;
		}
	}
	//---- Fungsi mengisi option Parent pada form Menu
	function isi_parent()
	{
		$hasil = $this->db->query('SELECT menu_id,nama FROM menuapp WHERE menu_id=58')->result();
		$i=0;
		foreach ($hasil as $row)
		{
			$clr = (($i%2) == 0) ? '#fff' : '#EFF1F1';
			echo "<option style=\"background:".$clr."\" value=\"".$row->menu_id."\">[".$row->menu_id."] ".$row->nama."</option>";
			$i++;
		}
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
				if($item['menu_id'] == 59){	
					$this->isi[] = "<li id=\"".$item['menu_id']."\">[ ".$item['menu_id']."] ".$item['nama']." (Href :".$item['href']." Urutan : ".$item['urutan'].") <img class=\"medt\" src=\"assets/images/editsmall.png\" title=\"Edit\">";
				}else{
					$this->isi[] = "<li id=\"".$item['menu_id']."\">[ ".$item['menu_id']."] ".$item['nama']." (Href :".$item['href']." Urutan : ".$item['urutan'].") <img class=\"mact\" src=\"assets/images/".$act.".png\" title=\"Active/Non Active\">&nbsp;<img class=\"mhps\" src=\"assets/images/delsmall.png\" title=\"Hapus\">&nbsp;<img class=\"medt\" src=\"assets/images/editsmall.png\" title=\"Edit\">";
				}
				$this->_loadMenuset($item['menu_id']);
			}
			$this->isi[] = "</ul>";
		} else {
			$this->isi[] = "</li>";
		}
	}
	
}

/* End of file */