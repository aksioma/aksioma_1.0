/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : plugin/migrasidata.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    
    $("#tab-utama").tabs();
    $('.infoproses1').hide();
    $('#files').change(function() {
        var files = $(this).val();
        $(".name").html(files);
        return false;
    });
    
});
