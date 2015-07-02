/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : akunting/neraca.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    var adminouth = 0;
    $.post("param/bmt/get_bmtinfo","id=1",
        function(obj){
           $('#bmttitle').html(obj['alldata'][0].nama+"<br>"+ obj['alldata'][0].kota +" - "+ obj['alldata'][0].namaProvinsi);
           $('#bmttitle',ctkframe.document).html(obj['alldata'][0].nama+"<br>"+ obj['alldata'][0].kota +" - "+ obj['alldata'][0].namaProvinsi);
       	}, "json");
/*
 *  --------------------- NERACA -----------------------------------------
 */
    $('#table_lapneraca button:eq(0)').click(function() {
        var isitglawal =  revDate($('#tgllap1').val(),"-");
        $('#tlapneraca').html(jAmbil("tlapneraca"));
        $('#tlapneraca1').html(jAmbil("tlapneraca1"));
        $('#tlapneraca2').html(jAmbil("tlapneraca2"));
        if($('#type').val() == "1"){
            res1 = ajak("akunting/neraca/getCOAjurnal",'&id=1&tglawal='+ $('#tgllap1').val());
            res2 = ajak("akunting/neraca/getCOAjurnal",'&id=2,3,4&tglawal='+ $('#tgllap1').val());
        }else{
            rowres = ajak("akunting/neraca/rowtotal",'&id1=1&id2=2,3,4');
            res1 = ajak("akunting/neraca/getCOAjurnaldetail",'&id=1&tglawal='+ $('#tgllap1').val());
            res2 = ajak("akunting/neraca/getCOAjurnaldetail",'&id=2,3,4&tglawal='+ $('#tgllap1').val() +'&row='+rowres);
        }
        $('#tlapneraca1').html(res1);
        $('#tlapneraca2').html(res2);
        $('#tlapneraca1',ctkframe.document).html(res1);
    	$('#tlapneraca2',ctkframe.document).html(res2);
        
        isitglperiode = cbulan($('#tgllap1').val());
        $('#isitgl').html(isitglperiode);
        $('#isitgl',ctkframe.document).html(isitglperiode);
    	
    });
    $('#table_lapneraca button:eq(1)').click(function() {
        //cetak
        //$('#wrap-print',ctkframe.document).html($('#tlapneraca').html());
        $('table',ctkframe.document).css({ "width":"100%", "font-size":"10"});
    	window.ctkframe.print();
        return false;
    });
    
    
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
