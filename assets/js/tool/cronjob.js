/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : tool/cronjob.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    var adminouth = 0;
/*
 *  ---------------------  -----------------------------------------
 */
    $('.infoproses1').hide();
    $('.ok1').hide();
    $('#aPembiayaan').click(function() {
    	$('.ok1').hide();
    	$('.infoproses1').show();
        respon = ajak("tool/cronjob/pembiayaan");
        if(respon == "1"){
        	$('.ok1').show();
        	$('.infoproses1').hide();
        }
        return false;
    });
    
    $('#aZakat').click(function() {
        var isitglawal =  revDate($('#tglzakat1').val(),"-");
        var isitglakhir =  revDate($('#tglzakat2').val(),"-");
        if (($('#tglzakat1').val() == "")||($('#tglzakat2').val() == "")) {
            alert("Tanggal harus di isi");
            return false;
        }
        if (Date.parse(isitglawal) > Date.parse(isitglakhir)) {
            alert("Tanggal Awal Harus lebih kecil dari Tanggal Akhir");
            return false;
        }
        if(($('#tglzakat2').val().substr(6, 4) - $('#tglzakat1').val().substr(6, 4)) > 0) {
            selisihx = (($('#tglzakat2').val().substr(3, 2)*1) + 12) - ($('#tglzakat1').val().substr(3, 2)*1)
            if(selisihx > 11) {
                alert("Selisih Bulan Periode max 12 bulan");
                return false;
            }
        }
        respon = ajak("tool/cronjob/zakat","&tgl1="+ $('#tglzakat1').val() +"&tgl2="+ $('#tglzakat2').val());
        
        alert(respon);
        return false;
    });
    $('#aAdm').click(function() {
        var isitglawal =  revDate($('#tgladm1').val(),"-");
        var isitglakhir =  revDate($('#tgladm2').val(),"-");
        if (($('#tgladm1').val() == "")||($('#tgladm2').val() == "")) {
            alert("Tanggal harus di isi");
            return false;
        }
        if (Date.parse(isitglawal) > Date.parse(isitglakhir)) {
            alert("Tanggal Awal Harus lebih kecil dari Tanggal Akhir");
            return false;
        }
        if(($('#tgladm2').val().substr(6, 4) - $('#tgladm1').val().substr(6, 4)) > 0) {
            selisihx = (($('#tgladm2').val().substr(3, 2)*1) + 12) - ($('#tgladm1').val().substr(3, 2)*1)
            if(selisihx > 11) {
                alert("Selisih Bulan Periode max 12 bulan");
                return false;
            }
        }
        respon = ajak("tool/crobjob/adm","&tgl1="+ $('#tgladm1').val() +"&tgl2="+ $('#tgladm2').val());
        
        
        return false;
    });
    $('#aAdm').click(function() {
        var isitglawal =  revDate($('#tglpph1').val(),"-");
        var isitglakhir =  revDate($('#tglpph2').val(),"-");
        if (($('#tglpph1').val() == "")||($('#tglpph2').val() == "")) {
            alert("Tanggal harus di isi");
            return false;
        }
        if (Date.parse(isitglawal) > Date.parse(isitglakhir)) {
            alert("Tanggal Awal Harus lebih kecil dari Tanggal Akhir");
            return false;
        }
        if(($('#tglpph2').val().substr(6, 4) - $('#tglpph1').val().substr(6, 4)) > 0) {
            selisihx = (($('#tglpph2').val().substr(3, 2)*1) + 12) - ($('#tglpph1').val().substr(3, 2)*1)
            if(selisihx > 11) {
                alert("Selisih Bulan Periode max 12 bulan");
                return false;
            }
        }
        respon = ajak("tool/crobjob/pph","&tgl1="+ $('#tglpph1').val() +"&tgl2="+ $('#tglpph2').val());
        
        
        return false;
    });
});
