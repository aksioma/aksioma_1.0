/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/tabungan.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    //$("#tab-utama").tabs();
    $('.jclock').jclock({format: '%A, %d %B %Y - %H:%M:%S %P'});
    
    
    
    
    $('#idmudharabah').hide();
    
    
    //---- Dialog Tambah biaya
    $('#dialog-biaya').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_biaya");
                        if (hasil['isi'] != "invalid") {
                            if ($('#dialog-biaya').dialog('option', 'title') == "Tambah Biaya") {
                                respon = ajak("param/tabungan/savebiaya",$('#form_biaya').serialize());
                            } else {
                                respon = ajak("param/tabungan/editbiaya",$('#form_biaya').serialize() + "&id=" + jAmbil("idx"));
                            }
                            if (respon == "1") {
                                $(this).dialog("close");
                                $("#table_biaya .reset").click();
                            } else if (respon == "1062") {
                                showinfo("Error : Dana maximal sudah ada");
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
     $('#addbiaya').click(function() {
        $(".infonya").hide();
        $('.inp').val('');
        $('#dialog-biaya').dialog('option', 'title',  'Tambah Biaya' ).dialog('open');
        return false;
     });

     //---- Dialog Hapus
     $('#dialog-hapus-biaya').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        respon = ajak("param/tabungan/delbiaya","id=" + jAmbil("idx"));
                        if (respon == "1") {
                            $("#table_biaya .reset").click();;
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

     //---- Tabel Biaya
    $("#table_biaya").mastertable({
        urlGet:"param/tabungan/get_biaya",
        flook:"kode"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "b" + json['alldata'][i].biaya_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            managejab = "<img class=\"chps\" title=\"Hapus\" src=\"assets/images/delicon.png\"/>&nbsp;&nbsp;&nbsp;<img  class=\"cedt\" title=\"Edit\" src=\"assets/images/editicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"right\">" + format_uangkoma(json['alldata'][i].kode) + "</td>"
                + "<td align=\"right\">" + format_uangkoma(json['alldata'][i].nama) + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].biaya_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Hapus
        $('.chps').click( function() {
            $(".infonya").hide();
            obj = jAmbil("b" + $(this).parent().next().text());
            $('.phps').html(obj.nama);
            jSimpan("idx",obj.biaya_id);
            $('#dialog-hapus-biaya').dialog('option', 'title',  'Hapus Biaya' ).dialog('open');
            return false;
        });
        //---- Edit
        $('.cedt').click( function() {
            $(".infonya").hide();
            obj = jAmbil("b" + $(this).parent().next().text());
            $('#mask_currency3').val(obj.kode);
            $('#mask_currency4').val(obj.nama);
            jSimpan("idx",obj.biaya_id);
            $('#dialog-biaya').dialog('option', 'title',  'Edit Biaya' ).dialog('open');
            return false;
        });
        warnatable();
    });
    
    //---- Dialog Tambah Kode Mutasi
    $('#dialog-mutasi').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_mutasi");
                        if (hasil['isi'] != "invalid") {
                            if ($('#dialog-mutasi').dialog('option', 'title') == "Tambah Kode Mutasi") {
                                respon = ajak("param/tabungan/savemutasi",$('#form_mutasi').serialize());
                            } else {
                                respon = ajak("param/tabungan/editmutasi",$('#form_mutasi').serialize() + "&id=" + jAmbil("idx"));
                            }
                            if (respon == "1") {
                                $(this).dialog("close");
                                $("#table_mutasi .reset").click();
                            } else if (respon == "1062") {
                                showinfo("Error : Kode Mutasi sudah ada");
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
     $('#addmutasi').click(function() {
        $(".infonya").hide();
        $('.inp').val('');
        $('#dialog-mutasi').dialog('option', 'title',  'Tambah Kode Mutasi' ).dialog('open');
        return false;
     });
    
    //---- Dialog Tambah Kode produk
    $('#dialog-produk').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_produk");
                        if (hasil['isi'] != "invalid") {
                            if ($('#dialog-produk').dialog('option', 'title') == "Tambah Kode Produk") {
                                respon = ajak("param/tabungan/saveproduk",$('#form_produk').serialize());
                            } else {
                                respon = ajak("param/tabungan/editproduk",$('#form_produk').serialize() + "&id=" + jAmbil("idx"));
                            }
                            if (respon == "1") {
                                $(this).dialog("close");
                                $("#table_produk .reset").click();
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
     $('#addproduk').click(function() {
        $(".infonya").hide();
        $('.inp').val('');
        $('#dialog-produk').dialog('option', 'title',  'Tambah Kode Produk' ).dialog('open');
        return false;
     });
     
     //---- Dialog Hapus
     $('#dialog-hapus-mutasi').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        respon = ajak("param/tabungan/delmutasi","id=" + jAmbil("idx"));
                        if (respon == "1") {
                            $("#table_mutasi .reset").click();;
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

     //---- Tabel Kode Mutasi
    $("#table_mutasi").mastertable({
        urlGet:"param/tabungan/get_mutasi",
        flook:"kode"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "k" + json['alldata'][i].mutasi_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            managejab = "<img class=\"chpsm\" title=\"Hapus\" src=\"assets/images/delicon.png\"/>&nbsp;&nbsp;&nbsp;<img  class=\"cedtm\" title=\"Edit\" src=\"assets/images/editicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].kode + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].mutasi_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Hapus
        $('.chpsm').click( function() {
            $(".infonya").hide();
            obj = jAmbil("k" + $(this).parent().next().text());
            $('.phps').html(obj.nama);
            jSimpan("idx",obj.mutasi_id);
            $('#dialog-hapus-mutasi').dialog('option', 'title',  'Hapus Kode Mutasi' ).dialog('open');
            return false;
        });
        //---- Edit
        $('.cedtm').click( function() {
            $(".infonya").hide();
            obj = jAmbil("k" + $(this).parent().next().text());
            $("#form_mutasi input[name='kode']").val(obj.kode);
            $("#form_mutasi input[name='nama']").val(obj.nama);
            jSimpan("idx",obj.mutasi_id);
            $('#dialog-mutasi').dialog('option', 'title',  'Edit Kode Mutasi' ).dialog('open');
            return false;
        });
        warnatable();
    });
    
    isi = ajak('param/listakun/isi_akun');
    $("#form_mtabungan select[name='gl_produk']").html(isi);
    $("#form_mtabungan select[name='gl_bagihasil']").html(isi);
    $("#form_mtabungan select[name='gl_buka_tutup_rek']").html(isi);
    $("#form_mtabungan select[name='gl_bonus']").html(isi);
    $("#form_mtabungan select[name='gl_pemeliharaan']").html(isi);
    $("#form_mtabungan select[name='gl_zakat']").html(isi);
    $("#form_mtabungan select[name='gl_pajak']").html(isi);
    
     //---- Tabel group produk
    $("#table_produk").mastertable({
        urlGet:"param/tabungan/get_produk",
        flook:"kode_produk"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "s" + json['alldata'][i].grouptabungan_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            managejab = "<img  class=\"cedte\" title=\"Edit\" src=\"assets/images/editicon.png\"/>&nbsp;&nbsp;&nbsp;<img  class=\"cset\" title=\"Setting\" src=\"assets/images/icontruechecklist.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].kode_produk + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].grouptabungan_nama + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].grouptabungan_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Edit
        $('.cedte').click( function() {
            $(".infonya").hide();
            obj = jAmbil("s" + $(this).parent().next().text());
            $('#form_produk input:eq(0)').val(obj.kode_produk);
            $('#form_produk input:eq(1)').val(obj.grouptabungan_nama);
            jSimpan("idx",obj.grouptabungan_id);
            $('#dialog-produk').dialog('option', 'title',  'Edit Kode Produk' ).dialog('open');
            return false;
        });
        //---- set
        $('.cset').click( function() {
            $(".infonya").hide();
            obj = jAmbil("s" + $(this).parent().next().text());
            $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
            $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
            $('#tabs-1').removeClass('active').addClass('');
            $('#tabs-2').removeClass('').addClass('active');
            loadtabungan(obj.kode_produk);
            return false;
        });
        $('#tabungansave').click(function() {
            respon = ajak("param/tabungan/editMTabungan",$('#form_mtabungan').serialize());
            window.location.href = "param/tabungan";
        });
        
        function loadtabungan(id){
        	$('#form_mtabungan input:eq(0)').val("");
            $('#form_mtabungan input:eq(1)').val("");
            $('#form_mtabungan input:eq(2)').val("");
            $('#form_mtabungan input:eq(3)').val("");
            $("#form_mtabungan input[name='tab_pph']").val("");
            $("#form_mtabungan input[name='tab_zakat']").val("");
            $("#form_mtabungan select[name='gl_produk']").val("");
            $("#form_mtabungan select[name='gl_bagihasil']").val("");
            $("#form_mtabungan select[name='gl_buka_tutup_rek']").val("");
            $("#form_mtabungan select[name='gl_bonus']").val("");
            $("#form_mtabungan select[name='gl_pemeliharaan']").val("");
            $("#form_mtabungan select[name='gl_zakat']").val("");
            $("#form_mtabungan select[name='gl_pajak']").val("");
            
            $('#form_mtabungan input:eq(0)').val(id);
            
            $.post("param/tabungan/get_tabunganinfo","id="+ id,
                function(json){
                    var isi ="";
                    if(id == "21"){
                        $('#idmudharabah').show();
                    }else{
                        $('#idmudharabah').hide();
                    }
                    for(i = 0; i < json['alldata'].length; i++) {
                    	
                    	$("#form_mtabungan input[name='adm_lain_lain']").val(json['alldata'][i].adm_lain_lain);
                        $("#form_mtabungan input[name='tab_pph']").val(json['alldata'][i].tab_pph);
                        $("#form_mtabungan input[name='tab_zakat']").val(json['alldata'][i].tab_zakat);
                        isi = ajak('param/listakun/isi_akun');
                        $("#form_mtabungan select[name='gl_produk']").html(isi);
                        $("#form_mtabungan select[name='gl_bagihasil']").html(isi);
                        $("#form_mtabungan select[name='gl_buka_tutup_rek']").html(isi);
                        $("#form_mtabungan select[name='gl_bonus']").html(isi);
                        $("#form_mtabungan select[name='gl_pemeliharaan']").html(isi);
                        $("#form_mtabungan select[name='gl_zakat']").html(isi);
                        $("#form_mtabungan select[name='gl_pajak']").html(isi);
                        
                        $("#form_mtabungan select[name='gl_produk']").val(json['alldata'][i].gl_produk);
                        $("#form_mtabungan select[name='gl_bagihasil']").val(json['alldata'][i].gl_bagihasil);
                        $("#form_mtabungan select[name='gl_buka_tutup_rek']").val(json['alldata'][i].gl_buka_tutup_rek);
                        $("#form_mtabungan select[name='gl_bonus']").val(json['alldata'][i].gl_bonus);
                        $("#form_mtabungan select[name='gl_pemeliharaan']").val(json['alldata'][i].gl_pemeliharaan);
                        $("#form_mtabungan select[name='gl_zakat']").val(json['alldata'][i].gl_zakat);
                        $("#form_mtabungan select[name='gl_pajak']").val(json['alldata'][i].gl_pajak);
                        
                    }
                    
                }, "json");
            return false;
        }
        warnatable();
    });
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
