<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : cetak/validasi.php
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
<table style="width:8cm;font-size:10pt;font-family:verdana;">
    <tr>
        <td nowrap><?php if (isset($code_cabang)) echo $code_cabang;?>/<?php if (isset($teller)) echo $teller;?>/<span id="ctgl_valid"></span>/<span id="nomortransaksi"></span>/<span id="nomorref"></span>/<span id="nilai"></span></td>
    </tr>
    <tr>
        <td nowrap><span id="nomoraccount"></span></td>
    </tr>
</table>
</div>
</body>
</html>