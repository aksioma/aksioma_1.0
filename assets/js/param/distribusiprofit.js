/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/distribusiprofit.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    $('.jclock').jclock({format: '%A, %d %B %Y - %H:%M:%S %P'});
    
    //---- Inisialisasi
    //$("#tab-utama").tabs();
    $('#dialog-perhimpunan').dialog({autoOpen: false,width: 450,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_perhimpunan");
                        if (hasil['isi'] != "invalid") {
                            if ($('#dialog-perhimpunan').dialog('option', 'title') == "Tambah perhimpunan dana") {
                                respon = ajak("param/distribusiprofit/saveperhimpunan",$('#form_perhimpunan').serialize());
                            } else {
                                respon = ajak("param/distribusiprofit/editperhimpunan",$('#form_perhimpunan').serialize() + "&id=" + jAmbil("idx"));
                            }
                            if (respon == "1") {
                                $(this).dialog("close");
                                $("#table_perhimpunan .reset").click();
                            } else if (respon == "1062") {
                                showinfo("Error : Jangka Waktu sudah ada");
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
     $('#addperhimpunan').click(function() {
        $(".infonya").hide();
        $('.inp').val('');
        isi = ajak('param/listakun/isi_akun1');
        $("#jurnal1").html(isi);
        $('#dialog-perhimpunan').dialog('option', 'title',  'Tambah perhimpunan dana' ).dialog('open');
        return false;
     });
    $('#dialog-hapus-perhimpunan').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        respon = ajak("param/distribusiprofit/delperhimpunan","id=" + jAmbil("idx"));
                        if (respon == "1") {
                            $("#table_perhimpunan .reset").click();;
                            $(this).dialog('close');
                        } else {
                            showinfo("Error : " + respon);
                        }
                    },
                    "Batal": function() {
                        $(this).dialog('close');
                    }
				 }
     });
    //---- Tabel 
    $("#table_perhimpunan").mastertable({
        urlGet:"param/distribusiprofit/get_perhimpunan",
        flook:"perhimpunan_id"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "h" + json['alldata'][i].perhimpunan_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            managejab = "<img class=\"chpsm\" title=\"Hapus\" src=\"assets/images/delicon.png\"/>&nbsp;&nbsp;&nbsp;<img  class=\"cedth1\" title=\"Edit\" src=\"assets/images/editicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].kelompok + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama_produk + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].listakun_code + " " + json['alldata'][i].listakun_name + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].perhimpunan_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Hapus
        $('.chpsm').click( function() {
            $(".infonya").hide();
            obj = jAmbil("h" + $(this).parent().next().text());
            $('.phps').html(obj.nama_produk);
            jSimpan("idx",obj.perhimpunan_id);
            $('#dialog-hapus-perhimpunan').dialog('option', 'title',  'Hapus perhimpunan dana' ).dialog('open');
            return false;
        });
        //---- Edit
        $('.cedth1').click( function() {
            $(".infonya").hide();
            obj = jAmbil("h" + $(this).parent().next().text());
            $('#form_perhimpunan .inp:eq(0)').val(obj.kelompok);
            $('#form_perhimpunan .inp:eq(1)').val(obj.nama_produk);
            isi = ajak('param/listakun/isi_akun1');
            $("#form_perhimpunan select[name='akun']").html(isi);
            $("#form_perhimpunan select[name='akun']").val(obj.akun);
            jSimpan("idx",obj.perhimpunan_id);
            $('#dialog-perhimpunan').dialog('option', 'title',  'Edit perhimpunan dana' ).dialog('open');
            return false;
        });
        warnatable();
    });
    //================ pendapatan
    $('#dialog-pendapatan').dialog({autoOpen: false,width: 450,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_pendapatan");
                        if (hasil['isi'] != "invalid") {
                            if ($('#dialog-pendapatan').dialog('option', 'title') == "Tambah pendapatan akun") {
                                respon = ajak("param/distribusiprofit/savependapatan",$('#form_pendapatan').serialize());
                            } else {
                                respon = ajak("param/distribusiprofit/editpendapatan",$('#form_pendapatan').serialize() + "&id=" + jAmbil("idx"));
                            }
                            if (respon == "1") {
                                $(this).dialog("close");
                                $("#table_pendapatan .reset").click();
                            } else if (respon == "1062") {
                                showinfo("Error : Kode produk sudah ada");
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
     $('#addpendapatan').click(function() {
        $(".infonya").hide();
        $('.inp').val('');
        isi = ajak('param/listakun/isi_akun1');
        $("#jurnal2").html(isi);
        $('#dialog-pendapatan').dialog('option', 'title',  'Tambah pendapatan akun' ).dialog('open');
        return false;
     });
    $('#dialog-hapus').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        respon = ajak("param/distribusiprofit/delpendapatan","id=" + jAmbil("idx"));
                        if (respon == "1") {
                            $("#table_pendapatan .reset").click();;
                            $(this).dialog('close');
                        } else {
                            showinfo("Error : " + respon);
                        }
                    },
                    "Batal": function() {
                        $(this).dialog('close');
                    }
				 }
     });
    //---- Tabel 
    $("#table_pendapatan").mastertable({
        urlGet:"param/distribusiprofit/get_pendapatan",
        flook:"akunpendapatan_id"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "p" + json['alldata'][i].akunpendapatan_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            managejab = "<img class=\"chpsm1\" title=\"Hapus\" src=\"assets/images/delicon.png\"/>&nbsp;&nbsp;&nbsp;<img  class=\"cedth\" title=\"Edit\" src=\"assets/images/editicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].kelompok + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama_produk + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].listakun_code + " " + json['alldata'][i].listakun_name + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].akunpendapatan_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Hapus
        $('.chpsm1').click( function() {
            $(".infonya").hide();
            obj = jAmbil("p" + $(this).parent().next().text());
            $('.phps').html(obj.nama_produk);
            jSimpan("idx",obj.akunpendapatan_id);
            $('#dialog-hapus').dialog('option', 'title',  'Hapus pendapatan akun' ).dialog('open');
            return false;
        });
        //---- Edit
        $('.cedth').click( function() {
            $(".infonya").hide();
            obj = jAmbil("p" + $(this).parent().next().text());
            $('#form_pendapatan .inp:eq(0)').val(obj.kelompok);
            $('#form_pendapatan .inp:eq(1)').val(obj.nama_produk);
            isi = ajak('param/listakun/isi_akun1');
            $("#form_pendapatan select[name='akun']").html(isi);
            $("#form_pendapatan select[name='akun']").val(obj.akun);
            jSimpan("idx",obj.akunpendapatan_id);
            $('#dialog-pendapatan').dialog('option', 'title',  'Edit pendapatan akun' ).dialog('open');
            return false;
        });
        warnatable();
    });
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
