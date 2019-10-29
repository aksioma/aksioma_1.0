<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/setupmenu.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Setupmenu extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->authlib->cekcontr();
        $this->tema = $this->allfunct->getSetupapp('tema');
        $this->load->model('master_model','master');
        $this->load->model('admin_model','modelku');
	    $this->nama_group = $this->authlib->getGroup($this->encrypt->decode($this->session->userdata('id_group')));
        $this->menuact = "param";
        $this->menuactsub = "setupmenu";
	}

    //---- Admin Tema
	function index()
	{
        $data['idpeg'] = $this->session->userdata('username');
        $data['menunya'] = $this->authlib->loadMenu('0',$this->nama_group,$this->menuact,$this->menuactsub);
        $data['tema'] = $this->tema;
        $this->load->view('param/setupmenu',$data);
	}
    
/*
 *  --------------------- MENU -----------------------------------------
 */
    //---- Simpan Menu
    function saveMenu()
    {
        $data = $this->allfunct->securePost();
        $data['groups'] = serialize($data['groups']);
        echo $this->master->simpan("menuapp",$data);
    }

    //---- Edit Menu
    function editMenu()
    {
        $data = $this->allfunct->securePost();
        $id	= $data['id'];
		unset($data['id']);
        $data['groups'] = serialize($data['groups']);
        $where = array('menu_id' => $id);
        echo $this->master->update("menuapp",$data,$where);
    }

    //---- Hapus Menu
    function delMenu()
    {
        $where = array('menu_id' => $this->input->post('id'));
        echo  $this->master->delete("menuapp",$where);
    }

    //---- Load Menu
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
                $this->isi[] = "<li id=\"".$item['menu_id']."\">[ ".$item['menu_id']."] ".$item['nama']." (Href :".$item['href']." Urutan : ".$item['urutan'].") <img class=\"mact\" src=\"assets/images/".$act.".png\" title=\"Active/Non Active\">&nbsp;<img class=\"mhps\" src=\"assets/images/delsmall.png\" title=\"Hapus\">&nbsp;<img class=\"medt\" src=\"assets/images/editsmall.png\" title=\"Edit\">";
                $this->_loadMenuset($item['menu_id']);
            }
             $this->isi[] = "</ul>";
        } else {
            $this->isi[] = "</li>";
        }
    }

    function getMenu()
    {
        $this-> _loadMenuset('0');
        foreach($this->isi as $item)
        {
            echo $item;
        }
    }
    function getMenuapp()
    {
        $data = $this->allfunct->securePost();
        $menuact	= $data['menuact'];
        $menuactsub	= $data['menuactsub'];
        $hasil = $this->db->query("SELECT `menu_id`,`nama`,`href`,`icon`,`css`,`sub`,`urutan`,`parent`,`groups`
                                    FROM `menuapp`
                                    WHERE parent='0' AND `active` = '1'
                                    ORDER BY `urutan`")->result();
        $items = "";
        foreach ($hasil as $row)
		{
    		if ($menuact == $row->css){$status ='active';}
            else{$status ='';}
            if($row->menu_id == "1"){
                $items .= "<li class=\"start ".$status."\"><a href=\".\">".$row->icon." <span class=\"title\">".$row->nama."</span></a></li>";
            }else{
                $items .= "<li class=\"has-sub ".$status."\">
                        <a href=\"javascript:void(0);\">".$row->icon." <span class=\"title\">".$row->nama."</span><span class=\"arrow\"></span></a>";
                        $submenu = $this->db->query("SELECT `menu_id`,`nama`,`href`,`icon`,`css`,`parent`,`groups`
                                                    FROM `menuapp`
                                                    WHERE parent='".$row->menu_id."' AND `active` = '1'
                                                    ORDER BY `urutan`")->result();
                        $itemsc = "<ul class=\"sub\">";
                        foreach ($submenu as $rowm){
                            if ($menuactsub == $rowm->css){$statusc ='class="active"';}
                            else{$statusc ='';}
                            $itemsc .= "<li ".$statusc."><a href=\"".$rowm->href."\">".$rowm->nama."</a></li>";
                        }
                        $itemsc .= "</ul>";
                $items .= $itemsc;
                $items .= "</li>";
            }
		}
        echo $items;
    }
    //---- Mengambil Menu sesuai ID
    function getMenuById()
    {
        $hasil = $this->db->get_where('menuapp', array('menu_id' => $this->input->post('id')))->row_array();
        $hasil['groups'] = unserialize($hasil['groups']);
        echo json_encode($hasil);
    }

    //---- Fungsi mengisi option Parent pada form Menu
    function isi_parent()
    {
        $hasil = $this->db->select('menu_id,nama')->get('menuapp')->result();
		$i=0;
        foreach ($hasil as $row)
		{
    		$clr = (($i%2) == 0) ? '#fff' : '#EFF1F1';
            echo "<option style=\"background:".$clr."\" value=\"".$row->menu_id."\">[".$row->menu_id."] ".$row->nama."</option>";
            $i++;
		}
    }

    //---- Fungsi mengisi option Groups pada form Menu
    function isi_groups()
    {
        $hasil = $this->db->select('nama_group')->get('groups')->result();
		$i=0;
        foreach ($hasil as $row)
		{
    		$clr = (($i%2) == 0) ? '#fff' : '#EFF1F1';
            echo "<option style=\"background:".$clr."\" value=\"".$row->nama_group."\">".$row->nama_group."</option>";
            $i++;
		}
    }

    //---- Toogle Active
    function toogleActive()
    {
        $data = array('active' => $this->input->post('val'));
        $where = array('menu_id' => $this->input->post('id'));
        echo $this->master->update("menuapp",$data,$where);
    }
    
}

/* End of file */