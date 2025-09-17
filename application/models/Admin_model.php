<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : models/admin_model.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
class Admin_model extends CI_Model {

	// ---- Constructor
	function __construct()
	{
		parent::__construct();
	}

/*

 *  --------------------- Fungsi list tahun buku -------------------------------

 */

    // --- Mendapatkan list tahun buku.

	function getAllListtahunbuku($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('master_tahunbuku');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT nama_tahun 

										   FROM `master_tahunbuku` 

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT *

										FROM `master_tahunbuku` 

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}

/*

 *  --------------------- Fungsi list akun -------------------------------

 */

    // --- Mendapatkan list akun.

	function getAllListakun($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('coa_listakun');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT listakun_code,listakun_name 

										   FROM `coa_listakun` 

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT *

										FROM `coa_listakun` 

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}

/*

 *  --------------------- Fungsi distribusi profit perhimpunan -------------------------------

 */

    // --- Mendapatkan perhimpunan.

	function getAllPerhimpunan($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('tb_akunperhimpunan');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT nama_produk

										   FROM `tb_akunperhimpunan` AS t1 

                                           INNER JOIN coa_listakun AS t2 ON t2.listakun_id=t1.akun

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT t1.*,t2.listakun_code,t2.listakun_name

										FROM `tb_akunperhimpunan` AS t1 

                                        INNER JOIN coa_listakun AS t2 ON t2.listakun_id=t1.akun

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}

/*

 *  --------------------- Fungsi distribusi profit pendapatan -------------------------------

 */

    // --- Mendapatkan pendapatan.

	function getAllPendapatanprofit($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('tb_akunpendapatan');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT nama_produk

										   FROM `tb_akunpendapatan` AS t1 

                                           INNER JOIN coa_listakun AS t2 ON t2.listakun_id=t1.akun

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT t1.*,t2.listakun_code,t2.listakun_name

										FROM `tb_akunpendapatan` AS t1 

                                        INNER JOIN coa_listakun AS t2 ON t2.listakun_id=t1.akun

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}

/*

 *  --------------------- Fungsi kjatuhtempo -------------------------------

 */

    // --- Mendapatkan kjatuhtempo.

	function getAllKjatuhtempo($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('kolekbilitas_jatuhtempo');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT jangka_waktu

										   FROM `kolekbilitas_jatuhtempo` 

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT *

										FROM `kolekbilitas_jatuhtempo` 

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}

/*

 *  --------------------- Fungsi kbulanan -------------------------------

 */

    // --- Mendapatkan kbulanan.

	function getAllKbulanan1($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('kolekbilitas_bulanan');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT jangka_waktu

										   FROM `kolekbilitas_bulanan` 

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT *

										FROM `kolekbilitas_bulanan` 

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}

/*

 *  --------------------- Fungsi kmingguan -------------------------------

 */

    // --- Mendapatkan kmingguan.

	function getAllKmingguan1($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('kolekbilitas_mingguan');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT jangka_waktu

										   FROM `kolekbilitas_mingguan` 

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT *

										FROM `kolekbilitas_mingguan` 

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}

/*

 *  --------------------- Fungsi kharian -------------------------------

 */

    // --- Mendapatkan kharian.

	function getAllKharian($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('kolekbilitas_harian');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT parameter

										   FROM `kolekbilitas_harian` 

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT *

										FROM `kolekbilitas_harian` 

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}
/*
 *  --------------------- Fungsi kbulanan -------------------------------
 */
    // --- Mendapatkan kbulanan.
	function getAllKbulanan($ff,$isf,$fd,$ADsc,$awal,$jum)
    {
		if ($isf == "") {
			$whr = "WHERE 1";
			$alldata['numrow'] = $this->db->count_all_results('kolekbilitas_bulanan');
		} else {
			$whr = "WHERE $ff LIKE '%$isf%'";
			$query = $this-> db -> query( "SELECT parameter
										   FROM `kolekbilitas_bulanan` 
                                   		   $whr" );
        	$alldata['numrow'] = $query -> num_rows();
		}
		$query = $this -> db -> query( "SELECT *
										FROM `kolekbilitas_bulanan` 
                                   		$whr
                                   		ORDER BY `$fd` $ADsc
                                   		LIMIT $awal,$jum" );
        $alldata['result'] = $query -> result_array();
      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;
	}
/*
 *  --------------------- Fungsi kmingguan -------------------------------
 */
    // --- Mendapatkan kmingguan.
	function getAllKmingguan($ff,$isf,$fd,$ADsc,$awal,$jum)
    {
		if ($isf == "") {
			$whr = "WHERE 1";
			$alldata['numrow'] = $this->db->count_all_results('kolekbilitas_mingguan');
		} else {
			$whr = "WHERE $ff LIKE '%$isf%'";
			$query = $this-> db -> query( "SELECT parameter
										   FROM `kolekbilitas_mingguan` 
                                   		   $whr" );
        	$alldata['numrow'] = $query -> num_rows();
		}
		$query = $this -> db -> query( "SELECT *
										FROM `kolekbilitas_mingguan` 
                                   		$whr
                                   		ORDER BY `$fd` $ADsc
                                   		LIMIT $awal,$jum" );
        $alldata['result'] = $query -> result_array();
      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;
	}
/*

 *  --------------------- Fungsi Otoritas -------------------------------

 */

    // --- Mendapatkan Otoritas.

	function getAllOtoritas($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('master_otoritas');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT kode,t2.nama_jabatan

										   FROM `master_otoritas` AS t1 

                                           INNER JOIN `jabatan` AS t2

                                           ON t1.level = t2.jabatan_id

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT t1.*,t2.nama_jabatan

										FROM `master_otoritas` AS t1 

                                        INNER JOIN `jabatan` AS t2

                                        ON t1.level = t2.jabatan_id

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}

/*

 *  --------------------- Fungsi Session-------------------------------

 */

    // --- Mendapatkan Session.

	function getAllSession($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		$whr = "WHERE 1";

        $alldata['numrow'] = $this->db->count_all_results('users');

		$query = $this -> db -> query( "SELECT *

										FROM `users`

                                   		ORDER BY `last_login` DESC

                                   		LIMIT 0,5" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}



/*

 *  --------------------- Fungsi Biaya-------------------------------

 */

    // --- Mendapatkan Biaya.

	function getAllBiaya($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('master_biaya');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT kode

										   FROM `master_biaya`

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT *

										FROM `master_biaya`

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}



/*

 *  --------------------- Fungsi Kode Mutasi -------------------------------

 */

    // --- Mendapatkan Kode Mutasi.

	function getAllKodeMutasi($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('master_kodemutasi');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT kode

										   FROM `master_kodemutasi`

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT *

										FROM `master_kodemutasi`

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}

/*

 *  --------------------- Fungsi group tabungan -------------------------------

 */

    // --- Mendapatkan Kode produk.

	function getAllTabunganProduk($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('master_grouptabungan');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT kode_produk

										   FROM `master_grouptabungan`

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT *

										FROM `master_grouptabungan`

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}

/*

 *  --------------------- Fungsi group pembiayaan -------------------------------

 */

    // --- Mendapatkan Kode produk.

	function getAllPembiayaanProduk($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('master_grouppembiayaan');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT kode_produk

										   FROM `master_grouppembiayaan`

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT *

										FROM `master_grouppembiayaan`

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}



/*

 *  --------------------- Fungsi group deposito -------------------------------

 */

    // --- Mendapatkan Kode produk.

	function getAlldepositoProduk($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('master_groupdeposito');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT kode_produk

										   FROM `master_groupdeposito`

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT *

										FROM `master_groupdeposito`

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}



/*

 *  --------------------- Fungsi Pendapatan-------------------------------

 */

    // --- Mendapatkan Sektor pekerjaan.

	function getAllPendapatan($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('pendapatan');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT kode

										   FROM `pendapatan`

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT *

										FROM `pendapatan`

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}





/*

 *  --------------------- Fungsi Status pekerjaan-------------------------------

 */

    // --- Mendapatkan Sektor pekerjaan.

	function getAllStatusPekerjaan($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('status_pekerjaan');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT kode

										   FROM `status_pekerjaan`

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT *

										FROM `status_pekerjaan`

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}





/*

 *  --------------------- Fungsi Sektor pekerjaan-------------------------------

 */

    // --- Mendapatkan Sektor pekerjaan.

	function getAllSektorPekerjaan($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('sektor_pekerjaan');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT kode

										   FROM `sektor_pekerjaan`

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT *

										FROM `sektor_pekerjaan`

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}



/*

 *  --------------------- Fungsi Wilayah kerja -------------------------------

 */

    // --- Mendapatkan Wilayah kerja.

	function getAllBMT($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('bmt_wilayah');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT wilayah_kerja

										   FROM `bmt_wilayah`

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT *

										FROM `bmt_wilayah`

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}


	/*
	
	*  --------------------- Fungsi tahun buku -------------------------------
	*/
	// --- Mendapatkan tahun buku.
	function getTahunBuku($ff,$isf,$fd,$ADsc,$awal,$jum)
	{
		if ($isf == "") {
			$whr = "WHERE 1";
			$alldata['numrow'] = $this->db->count_all_results('master_tahunbuku');
		} else {
			$whr = "WHERE $ff LIKE '%$isf%'";
			$query = $this-> db -> query( "SELECT nama_tahun
					FROM `master_tahunbuku`
					$whr" );
					$alldata['numrow'] = $query -> num_rows();
		}
		$query = $this -> db -> query( "SELECT *
			FROM `master_tahunbuku`
			$whr
			ORDER BY `$fd` $ADsc
			LIMIT $awal,$jum" );
			$alldata['result'] = $query -> result_array();
			return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;
	}
	
/*
 *  --------------------- Fungsi Jabatan -------------------------------
 */
    // --- Mendapatkan Jabatan.
	function getAllJabatan($ff,$isf,$fd,$ADsc,$awal,$jum)
    {
		if ($isf == "") {
			$whr = "WHERE 1";
			$alldata['numrow'] = $this->db->count_all_results('jabatan');
		} else {
			$whr = "WHERE $ff LIKE '%$isf%'";
			$query = $this-> db -> query( "SELECT nama_jabatan
										   FROM `jabatan`
                                   		   $whr" );
        	$alldata['numrow'] = $query -> num_rows();
		}
		$query = $this -> db -> query( "SELECT *
										FROM `jabatan`
                                   		$whr
                                   		ORDER BY `$fd` $ADsc
                                   		LIMIT $awal,$jum" );
        $alldata['result'] = $query -> result_array();
      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;
	}
	/*
	 *  --------------------- Fungsi plugin -------------------------------
	*/
	// --- Mendapatkan plugin.
	function getAllPlugin($ff,$isf,$fd,$ADsc,$awal,$jum)
	{
		if ($isf == "") {
			$whr = "WHERE 1";
			$alldata['numrow'] = $this->db->count_all_results('plugin');
		} else {
			$whr = "WHERE $ff LIKE '%$isf%'";
			$query = $this-> db -> query( "SELECT name_plugin 
					FROM `plugin` $whr" );
					$alldata['numrow'] = $query -> num_rows();
		}
		$query = $this -> db -> query( "SELECT *
		FROM `plugin` 
		$whr
		ORDER BY `$fd` $ADsc
		LIMIT $awal,$jum" );
		$alldata['result'] = $query -> result_array();
		return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;
	}
/*
 *  --------------------- Fungsi Pegawai -------------------------------
 */
    // --- Mendapatkan Pegawai.
	function getAllPegawai($ff,$isf,$fd,$ADsc,$awal,$jum)
    {
		if ($isf == "") {
			$whr = "WHERE 1";
			$alldata['numrow'] = $this->db->count_all_results('pegawai');
		} else {
			$whr = "WHERE $ff LIKE '%$isf%'";
			$query = $this-> db -> query( "SELECT t1.nama_pegawai,t1.nip,t2.nama_jabatan
										   FROM `pegawai` AS t1
                                           INNER JOIN `jabatan` AS t2
                                           ON t1.id_jabatan = t2.jabatan_id
                                   		   $whr" );
        	$alldata['numrow'] = $query -> num_rows();
		}
		$query = $this -> db -> query( "SELECT t1.*,t2.nama_jabatan
										FROM `pegawai` AS t1
                                        INNER JOIN `jabatan` AS t2
                                        ON t1.id_jabatan = t2.jabatan_id
                                   		$whr
                                   		ORDER BY `$fd` $ADsc
                                   		LIMIT $awal,$jum" );
        $alldata['result'] = $query -> result_array();
      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;
	}

/*
 *  --------------------- Fungsi User & Group -------------------------------
 */
    // --- Mendapatkan User.
	function getAllUser($ff,$isf,$fd,$ADsc,$awal,$jum)
    {
		if ($isf == "") {
			$whr = "WHERE 1";
			$alldata['numrow'] = $this->db->count_all_results('users');
		} else {
			$whr = "WHERE $ff LIKE '%$isf%'";
			$query = $this-> db -> query( "SELECT t1.username,t2.nama_pegawai,t3.nama_group
										   FROM `users` AS t1
                                           INNER JOIN `pegawai` AS t2
                                           ON t1.id_pegawai = t2.pegawai_id
                                           INNER JOIN `groups` AS t3
                                           ON t1.id_group = t3.group_id
                                   		   $whr" );
        	$alldata['numrow'] = $query -> num_rows();
		}
		$query = $this -> db -> query( "SELECT t1.id_group,t1.user_id,t1.username,t1.last_login,t1.from_host,t1.active,t2.pegawai_id,t2.nip,t2.nama_pegawai,t3.nama_group
										FROM `users` AS t1
                                        INNER JOIN `pegawai` AS t2
                                        ON t1.id_pegawai = t2.pegawai_id
                                        INNER JOIN `groups` AS t3
                                        ON t1.id_group = t3.group_id
                                   		$whr
                                   		ORDER BY `$fd` $ADsc
                                   		LIMIT $awal,$jum" );
        $alldata['result'] = $query -> result_array();
      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;
	}

    // --- Mendapatkan User.
	function getAllGroup($ff,$isf,$fd,$ADsc,$awal,$jum)
    {
		if ($isf == "") {
			$whr = "WHERE 1";
			$alldata['numrow'] = $this->db->count_all_results('groups');
		} else {
			$whr = "WHERE $ff LIKE '%$isf%'";
			$query = $this-> db -> query( "SELECT nama_group
										   FROM `groups`
                                   		   $whr" );
        	$alldata['numrow'] = $query -> num_rows();
		}
		$query = $this -> db -> query( "SELECT *
										FROM `groups`
                                   		$whr
                                   		ORDER BY `$fd` $ADsc
                                   		LIMIT $awal,$jum" );
        $alldata['result'] = $query -> result_array();
      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;
	}

/*
 *  --------------------- Fungsi Chart of Account -------------------------------
 */
    // --- Mendapatkan Akun.
	function getAllAkun($ff,$isf,$fd,$ADsc,$awal,$jum)
    {
		if ($isf == "") {
			$whr = "WHERE 1";
			$alldata['numrow'] = $this->db->count_all_results('coa');
		} else {
			$whr = "WHERE $ff LIKE '%$isf%'";
			$query = $this-> db -> query( "SELECT kode_akun,nama_akun,t2.nama_klascoa
										   FROM `coa` AS t1
                                           INNER JOIN `klascoa` AS t2
                                           ON t1.id_klascoa = t2.klascoa_id
                                   		   $whr" );
        	$alldata['numrow'] = $query -> num_rows();
		}
		$query = $this -> db -> query( "SELECT t1.*,t2.nama_klascoa
										FROM `coa` AS t1
                                        INNER JOIN `klascoa` AS t2
                                        ON t1.id_klascoa = t2.klascoa_id
                                   		$whr
                                   		ORDER BY `$fd` $ADsc
                                   		LIMIT $awal,$jum" );
        $alldata['result'] = $query -> result_array();
      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;
	}
/*

 *  --------------------- Fungsi Nasabah -------------------------------

 */

    // --- Mendapatkan Nasabah.

	function getAllNasabah($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('tb_nasabah');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT nomor_nasabah

										   FROM `tb_nasabah`

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT *

										FROM `tb_nasabah`

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}
	
/*

 *  --------------------- Fungsi Tabungan -------------------------------

 */

    // --- Mendapatkan Tabungan.

	function getAllTabungan($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('tb_tabungan');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT nomor_rekening

										   FROM `tb_tabungan` AS t1 

                                           INNER JOIN tb_nasabah AS t2 ON t2.nomor_nasabah=t1.nomor_nasabah 

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT t1.*,nama,alamat,rtrw,kecamatan,kabupaten,kode_pos,t2.code_wilayah

										FROM `tb_tabungan` AS t1 

                                        INNER JOIN tb_nasabah AS t2 ON t2.nomor_nasabah=t1.nomor_nasabah

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}

/*

 *  --------------------- Fungsi Jaminan -------------------------------

 */

    // --- Mendapatkan Jaminan.

	function getAllJaminan($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('tb_jaminan');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT nomor_jaminan

										   FROM `tb_jaminan` AS t1 

                                           INNER JOIN tb_pembiayaan AS t2 ON t2.nomor_rekening = t1.nomor_rekening 
										   INNER JOIN tb_nasabah AS t3 ON t3.nomor_nasabah=t2.nomor_nasabah 

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT t1.*,nama,alamat,rtrw,kecamatan,kabupaten,kode_pos

										FROM `tb_jaminan` AS t1 

                                        INNER JOIN tb_pembiayaan AS t2 ON t2.nomor_rekening = t1.nomor_rekening 
										INNER JOIN tb_nasabah AS t3 ON t3.nomor_nasabah=t2.nomor_nasabah 

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}
	
	/*
	*  --------------------- Fungsi Pembiayaan jaminan -------------------------------
	*/
	// --- Mendapatkan Pembiayaan jaminan.
	
	function getAllJaminanPembiayaan($ff,$isf,$fd,$ADsc,$awal,$jum)
	
	{
	
		if ($isf == "") {
			$whr = "WHERE 1";
			$alldata['numrow'] = $this->db->count_all_results('tb_pembiayaan');
		} else {
	
			$whr = "WHERE $ff LIKE '%$isf%'";
	
			$query = $this-> db -> query( "SELECT t1.nomor_rekening,t1.harga_pokok,t2.nama
	
					FROM `tb_pembiayaan` AS t1
					INNER JOIN tb_nasabah AS t2 ON t2.nomor_nasabah=t1.nomor_nasabah
					$whr" );
	
					$alldata['numrow'] = $query -> num_rows();
	
		}
	
		$query = $this -> db -> query( "SELECT t1.nomor_rekening,t1.harga_pokok,t2.*
	
		FROM `tb_pembiayaan` AS t1
		INNER JOIN tb_nasabah AS t2 ON t2.nomor_nasabah=t1.nomor_nasabah
	
		$whr
	
		ORDER BY `$fd` $ADsc
	
		LIMIT $awal,$jum" );
	
		$alldata['result'] = $query -> result_array();
	
		return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;
	
	}
/*

 *  --------------------- Fungsi Pembiayaan -------------------------------

 */

    // --- Mendapatkan Pembiayaan.

	function getAllPembiayaan($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('tb_pembiayaan');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT nomor_jaminan

										   FROM `tb_pembiayaan` AS t1 

                                           INNER JOIN tb_nasabah AS t2 ON t2.nomor_nasabah=t1.nomor_nasabah 

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT t1.*,nama,alamat,rtrw,kecamatan,kabupaten,kode_pos

										FROM `tb_pembiayaan` AS t1 

                                        INNER JOIN tb_nasabah AS t2 ON t2.nomor_nasabah=t1.nomor_nasabah

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}

    // --- Mendapatkan Deposito.

	function getAllDeposito($ff,$isf,$fd,$ADsc,$awal,$jum)

    {

		if ($isf == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('tb_deposito');

		} else {

			$whr = "WHERE $ff LIKE '%$isf%'";

			$query = $this-> db -> query( "SELECT nomor_rekening

										   FROM `tb_deposito` AS t1 

                                           INNER JOIN tb_nasabah AS t2 ON t2.nomor_nasabah=t1.nomor_nasabah 

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT t1.*,nama,alamat,rtrw,kecamatan,kabupaten,kode_pos

										FROM `tb_deposito` AS t1 

                                        INNER JOIN tb_nasabah AS t2 ON t2.nomor_nasabah=t1.nomor_nasabah

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}

/*

 *  --------------------- Fungsi transaksi -------------------------------

 */

	function getAllTransaksi($ff,$isf,$fd,$ADsc,$awal,$jum,$pawal,$pakhir)

    {

		if ($pawal == "") {

			$whr = "WHERE 1";

			$alldata['numrow'] = $this->db->count_all_results('tb_accounttrans');

		} else {

			$whr = "WHERE accounttrans_date BETWEEN '$pawal' AND '$pakhir'";

			$query = $this-> db -> query( "SELECT accounttrans_user

										   FROM `tb_accounttrans`

                                   		   $whr" );

        	$alldata['numrow'] = $query -> num_rows();

		}

		$query = $this -> db -> query( "SELECT *

										FROM `tb_accounttrans`

                                   		$whr

                                   		ORDER BY `$fd` $ADsc

                                   		LIMIT $awal,$jum" );

        $alldata['result'] = $query -> result_array();

      	return ( $query -> num_rows() > 0 ) ? $alldata : FALSE;

	}
}