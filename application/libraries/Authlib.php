<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : libraries/authlib.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Authlib {

	var $CI = NULL;

	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('session');
		$this->CI->load->database();
		$this->CI->load->helper('url');
		$this->CI->load->library('encrypt');
		
	}
	function getAllMenu($parent)
	{
		$query = $this->CI->db->query( "SELECT `menu_id`,`nama`,`href`,`icon`,`parent`,`groups`,`css`,`sub`
				FROM `menuapp`
				WHERE parent='$parent' AND `active` = '1'
				ORDER BY `urutan`" );
				return ($query -> num_rows() > 0) ? $query->result_array() : FALSE;
	}
	function loadMenu($parent,$namagroup,$menuact,$menuactsub){
		$hasil = $this->getAllMenu($parent);
		if ($hasil)
		{
			$isi[] = "<ul>";
			foreach($hasil as $item)
			{
				$groupx = unserialize($item['groups']);
				if (in_array($namagroup, $groupx))
				{
					if($menuact == $item['css']){$active = "active";}else{$active = "";}
					if($item['href'] == "."){
						$isi[] = "<li class=\"start $active\"><a href=\".\"><i class=\"icon-home\"></i> <span class=\"title\">Dashboard</span></a>";
					}else{
						$isi[] = "<li class=\"has-sub $active\"><a href=\"javascript:;\">".$item['icon']."<span class=\"title\"> ".$item['nama']."</span><span class=\"arrow\"></span></a>";
					}
					$submenu = $this->getAllMenu($item['menu_id']);
					if ($submenu)
					{
						$isi[] = "<ul class=\"sub\">";
						foreach($submenu as $item1)
						{
							$groupx = unserialize($item['groups']);
							if (in_array($namagroup, $groupx))
							{
								if($menuactsub == $item1['sub']){$activesub = "class='active'";}else{$activesub = "";}
								$isi[] = "<li $activesub> <a href=\"".$item1['href']."\">".$item1['nama']."</a></li>";
							}
						}
						$isi[] = "</ul>";
					}
				}
			}
			$isi[] = "</ul>";
		} else {
			$isi[] = "</li>";
		}
		return $isi;
	}
	//---- next minggu
	function getNextBillMinggu($start_date,$n){
		$maxTS = strtotime($start_date.' + '.$n.' day');
        return date('Y-m-d', $maxTS);
	}
	//---- next hari
	function getNextBillDay($start_date,$n){
		$maxTS = strtotime($start_date.' + '.$n.' day');
        return date('Y-m-d', $maxTS);
	}
    //--- next bln
    function getNextBillDate($start_date,$n) {
        $maxTS = strtotime($start_date.' + '.$n.' months');
        return date('Y-m-d', $maxTS);
    }
    //--- logo
    function getLogo(){
    	$query = $this->CI->db->query("SELECT logo FROM setting");
    	if ($query->num_rows() == 1) {
    		$hasil = $query->result();
   			return $hasil[0]->logo;
   		}  	
    }
	//--- group menu
    function getGroup($group_id)
	{$dbname =  $this->CI->db->database;
		if(($group_id != "0")||($group_id != "")){
            $query = $this->CI->db->query("SELECT nama_group FROM $dbname.groups WHERE group_id = '$group_id'");
            if ($query->num_rows() == 1) {
                $hasil = $query->result();
                return $hasil[0]->nama_group;
            }
        }
	}
	//---- Fungsi Login
    function login($login = NULL)
	{
		if(!isset($login))
			return FALSE;
		if(count($login) != 2)
			return FALSE;
		$username = $login[0];
		$pass = $login[1];
		//$cbg = $login[2];
		$resp = $this->cekpass($username,$pass);
		if (!is_object($resp)) 
		{
			return $resp;			
		} else {
			//$this->CI->session->set_userdata('cbg', $cbg);
			$this->CI->session->set_userdata('user_id', $resp->user_id);
			$this->CI->session->set_userdata('username', $resp->username);
            $this->CI->session->set_userdata('idpeg', $resp->pegawai_id);
            $this->CI->session->set_userdata('namapeg', $resp->nama_pegawai);
			$this->CI->session->set_userdata('pass', $resp->password);
			$this->CI->session->set_userdata('last_login', $resp->last_login);
			$this->CI->session->set_userdata('from_host', $resp->from_host);
			$this->CI->session->set_userdata('id_group', $this->CI->encrypt->encode($resp->id_group));
			$ipaddr = $_SERVER["REMOTE_ADDR"];
			$host = gethostbyaddr($ipaddr);
			$data = array("last_login" => date("Y-m-d H:i:s"),"from_host" => $host);
			$this->CI->db->where('user_id', $resp->user_id);
    		$this->CI->db->update("users", $data);
			return "valid";
		}
	}
    //---- Fungsi Login1
    function login1($login = NULL)
	{
		if(!isset($login))
			return FALSE;
		if(count($login) != 2)
			return FALSE;
		$username = $login[0];
		$pass = $login[1];
		$resp = $this->cekpass1($username,$pass);
        if ($resp == 1) 
		{
			return "valid";			
		} else {
			return $resp;
		}
	}
/*
 * Fungsi Logout / Hapus Cookie 
 */	
	function logout() 
	{
    	$this->CI->session->sess_destroy();
		redirect('auth');
	}
/*
 * Fungsi Cek pada halaman main menu
 */
	function cekmain()
	{
		
		$username = $this->CI->session->userdata('username');
		if (!empty($username)) {
			$pass = $this->CI->encrypt->decode($this->CI->session->userdata('pass'));
			$resp = $this->cekpass($username,$pass);
			if (!is_object($resp)) 
			{
				redirect('auth');
			}
		} else {
			redirect('auth');
		}
	}
/*
 * Fungsi cek level group sesuai controller
 */	
	function cekcontr()
	{
		        $username = $this->CI->session->userdata('username');
		if (!empty($username)) 
		{
			$pass = $this->CI->encrypt->decode($this->CI->session->userdata('pass'));
			$group_id = $this->CI->encrypt->decode($this->CI->session->userdata('id_group'));
			$resp = $this->cekpass($username,$pass);
			if (is_object($resp)) 
			{
				$contr = $this->getContr($group_id);
                $urix = (strtolower($this->CI->uri->segment(1)) == 'param') ? $this->CI->uri->segment(1)."/".$this->CI->uri->segment(2) : $this->CI->uri->segment(1);
                $urixf = (strtolower($this->CI->uri->segment(1)) == 'base') ? $this->CI->uri->segment(1)."/".$this->CI->uri->segment(2) : $this->CI->uri->segment(1);
                $urixf1 = (strtolower($this->CI->uri->segment(1)) == 'akunting') ? $this->CI->uri->segment(1)."/".$this->CI->uri->segment(2) : $this->CI->uri->segment(1);
                $urixf2 = (strtolower($this->CI->uri->segment(1)) == 'monitor') ? $this->CI->uri->segment(1)."/".$this->CI->uri->segment(2) : $this->CI->uri->segment(1);
                $urixf3 = (strtolower($this->CI->uri->segment(1)) == 'tool') ? $this->CI->uri->segment(1)."/".$this->CI->uri->segment(2) : $this->CI->uri->segment(1);
                $urixf4 = (strtolower($this->CI->uri->segment(1)) == 'trans') ? $this->CI->uri->segment(1)."/".$this->CI->uri->segment(2) : $this->CI->uri->segment(1);
                $urixf6 = (strtolower($this->CI->uri->segment(1)) == 'setting') ? $this->CI->uri->segment(1)."/".$this->CI->uri->segment(2) : $this->CI->uri->segment(1);
                $urixf7 = (strtolower($this->CI->uri->segment(1)) == 'plugin') ? $this->CI->uri->segment(1)."/".$this->CI->uri->segment(2) : $this->CI->uri->segment(1);
                if(strtolower($this->CI->uri->segment(1)) == 'param'){
                    $urix = $urix;
                }elseif(strtolower($this->CI->uri->segment(1)) == 'base'){
                    $urix = $urixf;
                }elseif(strtolower($this->CI->uri->segment(1)) == 'akunting'){
                    $urix = $urixf1;
                }elseif(strtolower($this->CI->uri->segment(1)) == 'trans'){
                    $urix = $urixf4;
                }elseif(strtolower($this->CI->uri->segment(1)) == 'monitor'){
                    $urix = $urixf2;
                }elseif(strtolower($this->CI->uri->segment(1)) == 'tool'){
                    $urix = $urixf3;
                }elseif(strtolower($this->CI->uri->segment(1)) == 'setting'){
                    $urix = $urixf6;
                }elseif(strtolower($this->CI->uri->segment(1)) == 'plugin'){
                    $urix = $urixf7;
                }
                if (!in_array($urix, $contr)) {
                    redirect("auth/denied");	
				}
                
			} else {
				redirect("auth");	
			}
		} else {
			redirect("auth");
		}
	}
    
/*
 * Cek pada halaman auth
 */
	function logged()
	{
		$username = $this->CI->session->userdata('username');
		if (!empty($username)) {
			$pass = $this->CI->encrypt->decode($this->CI->session->userdata('pass'));
			$resp = $this->cekpass($username,$pass);
			if (is_object($resp)) 
			{
				redirect('.');
			}
		}
	}
/*
 * Cek Username,Password dan Aktifasi di Database
 */
	function cekpass($username,$pass)
	{
		$query = $this->CI->db->query("SELECT t1.*,DATE_FORMAT(t1.last_login,'%d-%m-%Y %h:%i:%s') as last_login,t2.pegawai_id,t2.nama_pegawai
                                       FROM users as t1
                                       INNER JOIN pegawai as t2
                                       ON t1.id_pegawai = t2.pegawai_id
                                       WHERE username = '$username'
                                      ");
		if ($query->num_rows() == 1) {
            $hasil = $query->result();
			//$this->CI->db->query("INSERT INTO `test` ( `pwd1` , `pwd2` ) VALUES ('".$this->CI->encrypt->decode($hasil[0]->password)."', '".$this->CI->encrypt->encode($pass)."');");
			/*log_message('error',$pass);
			log_message('error',$this->CI->encrypt->encode($pass));
			log_message('error',json_encode($hasil[0]->password));
			*/
			if ($this->CI->encrypt->decode($hasil[0]->password) == $pass)
            {
				if ($hasil[0]->active == "1") {
	      			return $hasil[0];
				} else {
					return "noactive";
				}
			} else {
				return "wrongpass";
			}
		} else {
			return "nousername";
		}
	}
	function cekpass1($username,$pass)
	{
		$query = $this->CI->db->query("SELECT t1.*,DATE_FORMAT(t1.last_login,'%d-%m-%Y %h:%i:%s') as last_login,t2.pegawai_id,t2.nama_pegawai
                                       FROM users as t1
                                       INNER JOIN pegawai as t2
                                       ON t1.id_pegawai = t2.pegawai_id
                                       WHERE username = '$username'
                                      ");
		if ($query->num_rows() == 1) {
            $hasil = $query->result();
            if ($this->CI->encrypt->decode($hasil[0]->password) == $pass)
            {
				if ($hasil[0]->active == "1") {
	      			return $hasil[0]->id_group;
				} else {
					return "noactive";
				}
			} else {
				return "wrongpass";
			}
		} else {
			return "nousername";
		}
	}
    function levellogin($username)
	{
		$query = $this->CI->db->query("SELECT t1.id_pegawai AS id
                                       FROM users as t1
                                       INNER JOIN pegawai as t2
                                       ON t1.id_pegawai = t2.pegawai_id
                                       WHERE username = '$username'
                                      ");
		if ($query->num_rows() == 1) {
            $hasil = $query->result();
            return $hasil[0]->id;
		} else {
			return "0";
		}
	}
	function getContr($group_id)
	{
		$query = $this->CI->db->where('group_id', $group_id)->get('groups');
		$hasil = $query->result();
		return unserialize($hasil[0]->controller);
	}
	//--- Tahun Buku
	function TahunBuku()
	{
		$query = $this->CI->db->query("SELECT nama_tahun FROM master_tahunbuku WHERE `active` = '1'");
			if ($query->num_rows() == 1) {
				$hasil = $query->result();
				return $hasil[0]->nama_tahun;
			}
	}
	
}

/* End of file */
