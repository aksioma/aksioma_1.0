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
    $('.tgl').mask("99-99-9999").datepicker({
        dateFormat: 'dd-mm-yy',
        yearRange: "-20:+10",
        buttonImage: 'assets/images/cal_icon.png',
        buttonImageOnly: true,
        showOn: 'button',
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true
   });
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
    // tahun buku
    $("#table_tahunbuku").mastertable({
        urlGet:"param/bmt/get_tahunbuku",
        flook:"nama_tahun"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "t" + json['alldata'][i].tahunbuku_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            var status = (json['alldata'][i].active == '1') ? "ACTIVE" : "";
            managejab = "<img class=\"chpsa\" title=\"Hapus\" src=\"assets/images/delicon.png\"/>&nbsp;&nbsp;&nbsp;<img  class=\"cedta\" title=\"Edit\" src=\"assets/images/editicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].nama_tahun + "</td>"
                + "<td align=\"center\">" + revDate(json['alldata'][i].tgl_mulai,'-') + "</td>"
                + "<td align=\"center\">" + revDate(json['alldata'][i].tgl_akhir,'-') + "</td>"
                + "<td align=\"center\">" + status + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].tahunbuku_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Hapus
        $('.chpsa').click( function() {
            $(".infonya").hide();
            obj = jAmbil("t" + $(this).parent().next().text());
            $('.phps').html(obj.nama_tahun);
            jSimpan("idx",obj.tahunbuku_id);
            $('#dialog-hapus-tahunbuku').dialog('option', 'title',  'Hapus Tahun Buku' ).dialog('open');
            return false;
        });
        //---- Edit
        $('.cedta').click( function() {
            $(".infonya").hide();
            obj = jAmbil("t" + $(this).parent().next().text());
            $('#form_tahunbuku input:eq(0)').val(obj.nama_tahun);
            $('#form_tahunbuku input:eq(1)').val(revDate(obj.tgl_mulai,'-'));
            $('#form_tahunbuku input:eq(2)').val(revDate(obj.tgl_akhir,'-'));
            if (obj.active == "0") {
                $('#form_tahunbuku input:eq(3)').removeAttr('checked');
            } else {
                $('#form_tahunbuku input:eq(3)').attr('checked','checked');
            }
            jSimpan("idx",obj.tahunbuku_id);
            $('#dialog-tahunbuku').dialog('option', 'title',  'Edit Tahun Buku' ).dialog('open');
            return false;
        });
        warnatable();
    });
    $('#addtahunbuku').click(function() {
        $(".infonya").hide();
        $('.inp').val('');
        $('#dialog-tahunbuku').dialog('option', 'title',  'Tambah Tahun Buku' ).dialog('open');
        return false;
     });
    $('#dialog-tahunbuku').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_tahunbuku");
                        if (hasil['isi'] != "invalid") {
                            if ($('#dialog-tahunbuku').dialog('option', 'title') == "Tambah Tahun Buku") {
                                respon = ajak("param/bmt/saveTahunBuku",$('#form_tahunbuku').serialize() + "&active=" + $("#CTBaktif:checked").length);
                            } else {
                                respon = ajak("param/bmt/editTahunBuku",$('#form_tahunbuku').serialize() + "&active=" + $("#CTBaktif:checked").length + "&id=" + jAmbil("idx"));
                            }
                            if (respon == "1") {
                                $(this).dialog("close");
                                $("#table_tahunbuku .reset").click();
                            } else if (respon == "1062") {
                                showinfo("Error : Nama tahun sudah ada");
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
    $('#dialog-hapus-tahunbuku').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        respon = ajak("param/bmt/delTahunBuku","id=" + jAmbil("idx"));
                        if (respon == "1") {
                            $("#table_tahunbuku .reset").click();;
                            $(this).dialog('close');
                        } else if (respon == "1451") {
                            showinfo("Error : Tahun Buku Digunakan");
                        } else {
                            showinfo("Error : " + respon);
                        }
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
