<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : libraries/message.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
include_once('xmpphp/Log.php');
include_once('xmpphp/XMPP.php');
class Message {

	var $CI = NULL;

	function conn($ejabberserver,$user){
		$conn = new XMPPHP_XMPP($ejabberserver, 5222, $user, $user, 'xmpphp', $ejabberserver, TRUE, XMPPHP_Log::LEVEL_INFO);
		return $conn;
	}
	
}

/* End of file */