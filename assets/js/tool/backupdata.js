/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : tool/backupdata.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    var adminouth = 0;
/*
 *  --------------------- jurnal -----------------------------------------
 */
    
    $('#dobackup').click(function (){
        window.location = 'tool/backupdata/dobackup';
   });
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
