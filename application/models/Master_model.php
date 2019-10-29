<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : models/master_model.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Master_model extends CI_Model {

	// ---- Constructor
	function __construct()
	{
		parent::__construct();
	}
/*
 *  --------------------- Fungsi Utama -------------------------------
 */
    //--- Simpan 
	function simpan($table,$data)
    {
		return ($this->db->insert($table, $data)) ? TRUE : $this->db->_error_number();
	}

	//--- Update 
	function update($table,$data,$where)
    {
		return ($this->db->where($where)->update($table, $data)) ? TRUE : $this->db->_error_number();
	}

	//--- Hapus 
	function delete($table,$where)
    {
		return ($this->db->delete($table,$where)) ? TRUE : $this->db->_error_number();
	}
 
    //--- Get Menu untuk Setup
	function getSetupMenu($parent) {
        $query = $this -> db -> query( "SELECT *
                                        FROM `menuapp`
                                        WHERE parent='$parent'
                                        ORDER BY `urutan`" );
        return ($query -> num_rows() > 0) ? $query->result_array() : FALSE;
	}
}