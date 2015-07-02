/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : setting/logo.js
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
    $('.cupload').click( function() {
    	$("#foto_upload").attr("src","assets/img/logo.png?"+(new Date().getTime())).error(function() {
            $(this).attr("src","assets/img/logo.png?"+(new Date().getTime()));
        });
        $('#upload_target').remove();
        $("<iframe id=\"upload_target\" name=\"upload_target\" style=\"width:0;height:0;border:0px;\"></iframe>").appendTo("body");
        $('#dialog-upload').dialog('option', 'title',  'Upload Logo' ).dialog('open');
        return false;
    });
    $('#dialog-upload').dialog({autoOpen: false,width: 450,modal: true,
        buttons: {
                    "Upload": function() {
                        if($('#userfile').val() == ""){
                            showinfo("Pilih file yang akan di upload");
                            return false;
                        }
                        $('#formUpload').submit();
                        $('#upload_target').load(function(){
                            isi = $('#upload_target').contents().find('body').html();
                            if (isi == "1") {
                            	$(this).dialog('close');
                            } else {
                                showinfo("Error : " + isi );
                            }
                        });
                    },
                    "Batal": function() {
                        $(this).dialog('close');
                    }
				 }
     });
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
