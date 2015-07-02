/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/bmt.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    $('.jclock').jclock({format: '%A, %d %B %Y - %H:%M:%S %P'});
    
    //---- Inisialisasi
    $("#tab-utama").tabs();
    $('#bmtsave').click(function() {
        respon = ajak("param/bmt/editBMTInfo",$('#form_bmtinfo').serialize());
        loadbmt(1);
    });
    loadbmt(1);
    function loadbmt(id){
        $.post("param/bmt/get_bmtinfo","id="+ id,
            function(json){
                var isi ="";
                for(i = 0; i < json['alldata'].length; i++) {
                    $('.input-large:eq(0)').val(json['alldata'][i].nama);
                    $('.input-small:eq(0)').val(json['alldata'][i].kode_cabang);
                    $('.input-xlarge:eq(0)').val(json['alldata'][i].alamat);
                    $('.input-medium:eq(0)').val(json['alldata'][i].kota);
                    $('.input-small:eq(1)').val(json['alldata'][i].kode_pos);
                    isiprovinsi = ajak('param/bmt/isi_provinsi');
                    $("#form_bmtinfo select[name='propinsi']").html(isiprovinsi);
                    $("#form_bmtinfo select[name='propinsi']").val(json['alldata'][i].propinsi);
                    isiwilayah = ajak('param/bmt/isi_wilayah');
                    $("#form_bmtinfo select[name='wilayah_kerja']").html(isiwilayah);
                    $("#form_bmtinfo select[name='wilayah_kerja']").val(json['alldata'][i].wilayah_kerja);
                    $("#form_bmtinfo select[name='bmt_id']").val(json['alldata'][i].bmt_id);
                }
                
            }, "json");
        return false;
    }
    //---- Dialog Tambah jabatan
    $('#dialog-bmt').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_bmt");
                        if (hasil['isi'] != "invalid") {
                            if ($('#dialog-bmt').dialog('option', 'title') == "Tambah Wilayah") {
                                respon = ajak("param/bmt/saveBMT",$('#form_bmt').serialize());
                            } else {
                                respon = ajak("param/bmt/editBMT",$('#form_bmt').serialize() + "&id=" + jAmbil("idx"));
                            }
                            if (respon == "1") {
                                $(this).dialog("close");
                                $("#table_bmt .reset").click();
                            } else if (respon == "1062") {
                                showinfo("Error : Kode wilayah sudah ada");
                            } else {
                                showinfo("Error : " + respon);
                            }
                        } else {
                            showinfo("Form dengan tanda * harus Diisi");
                            hasil['focus'].focus();
                        }
                    },
                    "Batal": function() {
                        $(this).dialog('close');
                    }
    			 }
     });
     $('#addwilayah').click(function() {
        $(".infonya").hide();
        $('.inp').val('');
        $('#dialog-bmt').dialog('option', 'title',  'Tambah Wilayah' ).dialog('open');
        return false;
     });

     //---- Dialog Hapus jabatan
     $('#dialog-hapus-bmt').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        respon = ajak("param/bmt/delBMT","id=" + jAmbil("idx"));
                        if (respon == "1") {
                            $("#table_bmt .reset").click();;
                            $(this).dialog('close');
                        } else if (respon == "1451") {
                            showinfo("Error : Kode Masih Digunakan");
                        } else {
                            showinfo("Error : " + respon);
                        }
                    },
                    "Batal": function() {
                        $(this).dialog('close');
                    }
				 }
     });

     //---- Tabel jabatan
    $("#table_bmt").mastertable({
        urlGet:"param/bmt/get_bmt",
        flook:"kode"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "j" + json['alldata'][i].wilayah_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            managejab = "<img class=\"chps\" title=\"Hapus\" src=\"assets/images/delicon.png\"/>&nbsp;&nbsp;&nbsp;<img  class=\"cedt\" title=\"Edit\" src=\"assets/images/editicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].kode + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].wilayah_kerja + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].wilayah_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Hapus
        $('.chps').click( function() {
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            $('.phps').html(obj.wilayah_kerja);
            jSimpan("idx",obj.wilayah_id);
            $('#dialog-hapus-bmt').dialog('option', 'title',  'Hapus Wilayah' ).dialog('open');
            return false;
        });
        //---- Edit
        $('.cedt').click( function() {
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            $('.inp:eq(0)').val(obj.kode);
            $('.inp:eq(1)').val(obj.wilayah_kerja);
            jSimpan("idx",obj.wilayah_id);
            $('#dialog-bmt').dialog('option', 'title',  'Edit Wilayah' ).dialog('open');
            return false;
        });
        warnatable();
    });

/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
