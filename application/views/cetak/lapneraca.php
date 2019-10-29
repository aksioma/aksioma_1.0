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
  	@page { 
  		margin: 0.5cm; 
  		font-size : 9px;
  	}
  	
}
</style>
<body>
<table>
	<thead>
                                                        <tr>
                                                            <td colspan="3" align="center" style="font-size: 18px;"><b>Laporan Neraca <br><span id="bmttitle" style="font-size: 18px;"></b></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" style="text-align:left;border-bottom:1px solid #000"><b>Posisi Tanggal : <span id="isitgl"></span></b></td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td valign="top">
                                                                <div id="tlapneraca1">
                                                                    <table border="0">
                                                                        <tbody></tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                            <td width="1%">&nbsp;</td>
                                                            <td valign="top">
                                                                <div id="tlapneraca2">
                                                                    <table border="0">
                                                                        <tbody></tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        <tr>
                                                        </tbody>
</table>
</body>
</html>