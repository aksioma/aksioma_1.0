/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : setting/cetaktabungan.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    var adminouth = 0;
    $('#bmtsave').click(function() {
        respon = ajak("setting/cetaktabungan/editInfo",$('#form_setbuku').serialize());
        loadsetting(1);
    });
    loadsetting(1);
    function loadsetting(id){
        $.post("setting/cetaktabungan/get_info","id="+ id,
            function(json){
                var isi ="";
                for(i = 0; i < json['alldata'].length; i++) {
                	$('.input-small:eq(0)').val(json['alldata'][i].set4);
                	$('.input-small:eq(1)').val(json['alldata'][i].set5);
                	$('.input-small:eq(2)').val(json['alldata'][i].set6);
                	$('.input-small:eq(3)').val(json['alldata'][i].set7);
                	$('.input-small:eq(4)').val(json['alldata'][i].set8);
                	$('.input-small:eq(5)').val(json['alldata'][i].set9);
                	$('.input-small:eq(6)').val(json['alldata'][i].set10);
                	$('.input-small:eq(7)').val(json['alldata'][i].set11);
                	$('.input-small:eq(8)').val(json['alldata'][i].set12);
                }
                
            }, "json");
        return false;
    }
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
