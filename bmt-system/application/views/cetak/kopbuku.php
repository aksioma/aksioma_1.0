<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : cetak/kopbuku.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
?>
<html>
<head>
<title></title>
<base href="<?php echo base_url();?>" />
<style>
@media print {
  	* { background: transparent !important; color: black !important; text-shadow: none !important; filter:none !important; -ms-filter: none !important; }
  	@page{ 
  		<?php if (isset($margin)) echo $margin;?> 
  	}
  	
}
</style>
</head>
<body>
<div id="wrap-top">
</div>
</body>
</html>