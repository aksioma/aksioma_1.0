/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/umum.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    $('.jclock').jclock({format: '%A, %d %B %Y - %H:%M:%S %P'});
    
/*
 *  --------------------- jabatan -----------------------------------------
 */
    //---- Dialog Tambah jabatan
    $('#dialog-jabatan').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_jabatan");
                        if (hasil['isi'] != "invalid") {
                            if ($('#dialog-jabatan').dialog('option', 'title') == "Tambah jabatan") {
                                respon = ajak("param/umum/saveJabatan",$('#form_jabatan').serialize());
                            } else {
                                respon = ajak("param/umum/editJabatan",$('#form_jabatan').serialize() + "&id=" + jAmbil("idx"));
                            }
                            if (respon == "1") {
                                $(this).dialog("close");
                                $("#table_jabatan .reset").click();
                            } else if (respon == "1062") {
                                showinfo("Error : Nama Jabatan telah ada");
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
     $('#addjabatan').click(function() {
        $(".infonya").hide();
        $('.inp').val('');
        $('#dialog-jabatan').dialog('option', 'title',  'Tambah jabatan' ).dialog('open');
        return false;
     });

     //---- Dialog Hapus jabatan
     $('#dialog-hapus').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        respon = ajak("param/umum/delJabatan","id=" + jAmbil("idx"));
                        if (respon == "1") {
                            $("#table_jabatan .reset").click();;
                            $(this).dialog('close');
                        } else if (respon == "1451") {
                            showinfo("Error : Jabatan Masih Digunakan");
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
    $("#table_jabatan").mastertable({
        urlGet:"param/umum/get_jabatan",
        flook:"nama_jabatan"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "j" + json['alldata'][i].jabatan_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            managejab = (idx != 'j1') ? "<img class=\"chps\" title=\"Hapus\" src=\"assets/images/delicon.png\"/>&nbsp;<img  class=\"cedt\" title=\"Edit\" src=\"assets/images/editicon.png\"/>" : "";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].nama_jabatan + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].keterangan + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].jabatan_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Hapus
        $('.chps').click( function() {
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            $('.phps').html(obj.nama_jabatan);
            jSimpan("idx",obj.jabatan_id);
            $('#dialog-hapus').dialog('option', 'title',  'Hapus Jabatan' ).dialog('open');
            return false;
        });
        //---- Edit
        $('.cedt').click( function() {
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            $('.inp:eq(0)').val(obj.nama_jabatan);
            $('.inp:eq(1)').val(obj.keterangan);
            jSimpan("idx",obj.jabatan_id);
            $('#dialog-jabatan').dialog('option', 'title',  'Edit Jabatan' ).dialog('open');
            return false;
        });
        warnatable();
    });

/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
