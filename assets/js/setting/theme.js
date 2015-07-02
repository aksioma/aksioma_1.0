/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : setting/theme.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    
    loadsetting(1);
    function loadsetting(id){
        $.post("setting/sampultab/get_info","id="+ id,
            function(json){
                var isi ="";
                for(i = 0; i < json['alldata'].length; i++) {
                	$('.input-small:eq(0)').val(json['alldata'][i].set1);
                	$('.input-small:eq(1)').val(json['alldata'][i].set2);
                	$('.input-small:eq(2)').val(json['alldata'][i].set3);
                	
                }
                
            }, "json");
        return false;
    }
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
