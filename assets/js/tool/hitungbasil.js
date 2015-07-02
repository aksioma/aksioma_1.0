/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : tool/hitungbasil.js
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
    $('#hitung').click(function() {
        //alert($('#periode1').val());
        var isitglawal =  revDate($('#periode1').val(),"-");
        var isitglakhir =  revDate($('#periode2').val(),"-");
        if (($('#periode1').val() == "")||($('#periode2').val() == "")) {
            alert("Tanggal harus di isi");
            return false;
        }
        if (Date.parse(isitglawal) > Date.parse(isitglakhir)) {
            alert("Tanggal Awal Harus lebih kecil dari Tanggal Akhir");
            return false;
        }
        if(($('#periode2').val().substr(6, 4) - $('#periode1').val().substr(6, 4)) > 0) {
            selisihx = (($('#periode2').val().substr(3, 2)*1) + 12) - ($('#periode1').val().substr(3, 2)*1)
            if(selisihx > 11) {
                alert("Selisih Bulan Periode max 12 bulan");
                return false;
            }
        }
        respon = ajak("tool/hitungbasil/hitung","&tgl1="+ $('#periode1').val() +"&tgl2="+ $('#periode2').val());
        var item = respon.split("#");
        $('#saldoratahimpun').val(format_uang(item[0]));
        $('#saldoratapenyalur').val(format_uang(item[1]));
        
        $('.hitung').removeClass('btn-warning').addClass('');
        $('.hitung').removeClass('').addClass('disabled');
        
        return false;
    });
    $('#lihat_rincian').click(function() {
        var isitglawal =  revDate($('#periode1').val(),"-");
        var isitglakhir =  revDate($('#periode2').val(),"-");
        if (($('#periode1').val() == "")||($('#periode2').val() == "")) {
            alert("Tanggal harus di isi");
            return false;
        }
        if (Date.parse(isitglawal) > Date.parse(isitglakhir)) {
            alert("Tanggal Awal Harus lebih kecil dari Tanggal Akhir");
            return false;
        }
        if(($('#periode2').val().substr(6, 4) - $('#periode1').val().substr(6, 4)) > 0) {
            selisihx = (($('#periode2').val().substr(3, 2)*1) + 12) - ($('#periode1').val().substr(3, 2)*1)
            if(selisihx > 11) {
                alert("Selisih Bulan Periode max 12 bulan");
                return false;
            }
        }
        $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
        $('#tabs-1').removeClass('active').addClass('');
        $('#tabs-2').removeClass('').addClass('active');
        res1 = ajak("tool/hitungbasil/rinciansaldorata","&tgl1="+ $('#periode1').val() +"&tgl2="+ $('#periode2').val());
        $('#tblperhimpunan tbody').html(res1);
        return false;
    });
    $('#proses_hitung_basil').click(function() {
        var isitglawal =  revDate($('#periode1').val(),"-");
        var isitglakhir =  revDate($('#periode2').val(),"-");
        if (($('#periode1').val() == "")||($('#periode2').val() == "")) {
            alert("Tanggal harus di isi");
            return false;
        }
        if (Date.parse(isitglawal) > Date.parse(isitglakhir)) {
            alert("Tanggal Awal Harus lebih kecil dari Tanggal Akhir");
            return false;
        }
        if(($('#periode2').val().substr(6, 4) - $('#periode1').val().substr(6, 4)) > 0) {
            selisihx = (($('#periode2').val().substr(3, 2)*1) + 12) - ($('#periode1').val().substr(3, 2)*1)
            if(selisihx > 11) {
                alert("Selisih Bulan Periode max 12 bulan");
                return false;
            }
        }
        respon = ajak("tool/hitungbasil/hitungbasiltotol","&tgl1="+ $('#periode1').val() +"&tgl2="+ $('#periode2').val());
        //alert(respon);
        $('#totalbasil').val(format_uang(respon));
        $('.proses_hitung_basil').removeClass('btn-danger').addClass('');
        $('.proses_hitung_basil').removeClass('').addClass('disabled');
        return false;
    });
    $('#lihat_rincian_basil1').click(function() {
        var isitglawal =  revDate($('#periode1').val(),"-");
        var isitglakhir =  revDate($('#periode2').val(),"-");
        if (($('#periode1').val() == "")||($('#periode2').val() == "")) {
            alert("Tanggal harus di isi");
            return false;
        }
        if (Date.parse(isitglawal) > Date.parse(isitglakhir)) {
            alert("Tanggal Awal Harus lebih kecil dari Tanggal Akhir");
            return false;
        }
        if(($('#periode2').val().substr(6, 4) - $('#periode1').val().substr(6, 4)) > 0) {
            selisihx = (($('#periode2').val().substr(3, 2)*1) + 12) - ($('#periode1').val().substr(3, 2)*1)
            if(selisihx > 11) {
                alert("Selisih Bulan Periode max 12 bulan");
                return false;
            }
        }
        $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(2)').removeClass('').addClass('active');
        $('#tabs-1').removeClass('active').addClass('');
        $('#tabs-3').removeClass('').addClass('active');
        res1 = ajak("tool/hitungbasil/rincianbasil1","&tgl1="+ $('#periode1').val() +"&tgl2="+ $('#periode2').val());
        $('#tblrincianbasil1 tbody').html(res1);
        return false;
    });
    $('#lihat_rincian_basil2').click(function() {
        var isitglawal =  revDate($('#periode1').val(),"-");
        var isitglakhir =  revDate($('#periode2').val(),"-");
        if (($('#periode1').val() == "")||($('#periode2').val() == "")) {
            alert("Tanggal harus di isi");
            return false;
        }
        if (Date.parse(isitglawal) > Date.parse(isitglakhir)) {
            alert("Tanggal Awal Harus lebih kecil dari Tanggal Akhir");
            return false;
        }
        if(($('#periode2').val().substr(6, 4) - $('#periode1').val().substr(6, 4)) > 0) {
            selisihx = (($('#periode2').val().substr(3, 2)*1) + 12) - ($('#periode1').val().substr(3, 2)*1)
            if(selisihx > 11) {
                alert("Selisih Bulan Periode max 12 bulan");
                return false;
            }
        }
        $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(3)').removeClass('').addClass('active');
        $('#tabs-1').removeClass('active').addClass('');
        $('#tabs-4').removeClass('').addClass('active');
        res1 = ajak("tool/hitungbasil/rincianbasil2","&tgl1="+ $('#periode1').val() +"&tgl2="+ $('#periode2').val());
        $('#tblrincianbasil2 tbody').html(res1);
        return false;
    });
    $('#hitung_bonus_wadiah').click(function() {
        var isitglawal =  revDate($('#periode1').val(),"-");
        var isitglakhir =  revDate($('#periode2').val(),"-");
        if (($('#periode1').val() == "")||($('#periode2').val() == "")) {
            alert("Tanggal harus di isi");
            return false;
        }
        if (Date.parse(isitglawal) > Date.parse(isitglakhir)) {
            alert("Tanggal Awal Harus lebih kecil dari Tanggal Akhir");
            return false;
        }
        if(($('#periode2').val().substr(6, 4) - $('#periode1').val().substr(6, 4)) > 0) {
            selisihx = (($('#periode2').val().substr(3, 2)*1) + 12) - ($('#periode1').val().substr(3, 2)*1)
            if(selisihx > 11) {
                alert("Selisih Bulan Periode max 12 bulan");
                return false;
            }
        }
        respon = ajak("tool/hitungbasil/hitungbasilwadiah","&tgl1="+ $('#periode1').val() +"&tgl2="+ $('#periode2').val()+"&bonusdibagi="+ $('#bonusdibagi').val()+"&minsaldo="+ $('#minsaldo').val());
        //alert(respon);
        $('.hitung_bonus_wadiah').removeClass('btn-primary').addClass('');
        $('.hitung_bonus_wadiah').removeClass('').addClass('disabled');
        return false;
    });
    
    $('#distribusi_basil').click(function() {
        var isitglawal =  revDate($('#periode1').val(),"-");
        var isitglakhir =  revDate($('#periode2').val(),"-");
        if (($('#periode1').val() == "")||($('#periode2').val() == "")) {
            alert("Tanggal harus di isi");
            return false;
        }
        if (Date.parse(isitglawal) > Date.parse(isitglakhir)) {
            alert("Tanggal Awal Harus lebih kecil dari Tanggal Akhir");
            return false;
        }
        if(($('#periode2').val().substr(6, 4) - $('#periode1').val().substr(6, 4)) > 0) {
            selisihx = (($('#periode2').val().substr(3, 2)*1) + 12) - ($('#periode1').val().substr(3, 2)*1)
            if(selisihx > 11) {
                alert("Selisih Bulan Periode max 12 bulan");
                return false;
            }
        }
        respon = ajak("tool/hitungbasil/distribusiprofit","&tgl1="+ $('#periode1').val() +"&tgl2="+ $('#periode2').val());
        $('.distribusi_basil').removeClass('btn-success').addClass('');
        $('.distribusi_basil').removeClass('').addClass('disabled');
        return false;
    });
    
    $('.infoproses2').hide();
    $('.ok2').hide();
    $('.infoproses3').hide();
    $('.ok3').hide();
    $('.infoproses4').hide();
    $('.ok4').hide();
    
    $('#aZakat').click(function() {
    	$('.ok2').hide();
    	$('.infoproses2').show();
        respon = ajak("tool/cronjob/zakat");
        if(respon == "1"){
        	$('.ok2').show();
        	$('.infoproses2').hide();
        	$('.aZakat').removeClass('').addClass('disabled');
        }
        return false;
    });
    $('#aAdm').click(function() {
    	$('.ok3').hide();
    	$('.infoproses3').show();
        respon = ajak("tool/cronjob/adm");
        if(respon == "1"){
        	$('.ok3').show();
        	$('.infoproses3').hide();
        	$('.aAdm').removeClass('').addClass('disabled');
        }
        
        return false;
    });
    $('#aPph').click(function() {
    	$('.ok4').hide();
    	$('.infoproses4').show();
        respon = ajak("tool/cronjob/pph");
        if(respon == "1"){
        	$('.ok4').show();
        	$('.infoproses4').hide();
        	$('.aPph').removeClass('').addClass('disabled');
        }
        
        return false;
    });
});
