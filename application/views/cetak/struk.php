<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : cetak/struk.php
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
<body>
<div id="wrap-top">
<table style="width:7cm;font-size:10pt;font-family:verdana;">
    <tr>
        <td colspan="4">Tanggal : <span id="ctgl_valid"></span> <span id="nilai"></span></td>
    </tr>
    <tr>
        <td>Petugas : <?php if (isset($teller)) echo $teller;?></td>
    </tr>
</table>
</div>
</body>
</html>