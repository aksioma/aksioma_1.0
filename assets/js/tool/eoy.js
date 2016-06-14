/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : tool/eoy.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    var adminouth = 0;
    $('.infoproses3').hide();
    $('.ok3').hide();
    $('#proses_eoy').click(function() {
    	$('.ok3').hide();
    	$('.infoproses3').show();
        respon = ajak("tool/eoy/prosesEOY");
        if(respon == "1"){
        	$('.ok3').show();
        	$('.infoproses3').hide();
        	$('.proses_eoy').removeClass('').addClass('disabled');
        }
        return false;
    });
/*
 *  ---------------------  -----------------------------------------
 */
    
});
