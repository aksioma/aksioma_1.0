<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : cetak/lapneraca.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
?>
<html>
<head>
<title></title>
<base href="<?php echo base_url();?>" />
</head>
<style>
@media print {
  	* { background: transparent !important; color: black !important; text-shadow: none !important; filter:none !important; -ms-filter: none !important; }
  	@page{ 
  		<?php if (isset($margin)) echo $margin;?>  
  	}
}
</style>
<body>
<div id="tlapcetak">
	<table style="font-size:<?php if (isset($ft)) echo $ft;?>pt;font-family:verdana;" width="<?php if (isset($wth)) echo $wth;?>">
		<thead>
			<?php if (isset($sizetop)) echo $sizetop;?>
		</thead>
		<tbody></tbody>
	</table>
</div>
</body>
</html>