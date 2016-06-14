/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : base/tabungan.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    var adminouth = 0;
/*
 *  --------------------- tabungan -----------------------------------------
 */
    $('#button-previous ,#button-next').click(function() {
        $("html, body").animate({ scrollTop: 300 }, "slow");
        return false;
    });
    var produkcode = ajak('base/tabungan/produk_code');
    var cab = ajak('base/tabungan/cab_code');
    var count = ajak('base/tabungan/run_code',"id="+produkcode +"&cab="+cab);
    //$("#form_tab input[name='nomor_rekening']").val(produkcode+""+cab+""+count);
    $("#form_tab input[name='nomor_rekening']").val(count);
    $("#form_tab input[name='tgl_dibuka']").val(isitglskrg());
    //$("#info_nisbah").hide();
    $('#tab2x').click(function() {
        $('#form_tab input').val('');
        $('#form_tab select').val('');
        //var produkcode = ajak('base/tabungan/produk_code');
        //var count = ajak('base/tabungan/run_code',"id="+produkcode);
        //var cab = ajak('base/tabungan/cab_code');
        $("#form_tab input[name='nomor_rekening']").val(count);
        $("#form_tab input[name='tgl_dibuka']").val(isitglskrg());
        $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
        $('.nav-tabs li:eq(2)').removeClass('active').addClass('');
        $('#tabs-1').removeClass('active').addClass('');
        $('#tabs-2').removeClass('').addClass('active');
        $('#tabs-3').removeClass('active').addClass('');
        //
        isi = ajak('base/tabungan/isi_propinsi');
        $("#propinsi").html(isi);
        $("#propinsi_pekerjaan").html(isi);
        $("#propinsi_usaha").html(isi);
        $("#propinsi_kerabat").html(isi);
        return false;
    });
    $('#addtabungan').click(function() {
        $('#form_tab input').val('');
        $('#form_tab select').val('');
        var produkcode = ajak('base/tabungan/produk_code');
        var cab = ajak('base/tabungan/cab_code');
        var count = ajak('base/tabungan/run_code',"id="+produkcode +"&cab="+cab);
        $("#form_tab input[name='nomor_rekening']").val(count);
        //$("#form_tab input[name='nomor_rekening']").val(produkcode+""+cab+""+count);
        $("#form_tab input[name='tgl_dibuka']").val(isitglskrg());
        $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
        $('#tabs-1').removeClass('active').addClass('');
        $('#tabs-2').removeClass('').addClass('active');
        //
        isi = ajak('base/tabungan/isi_propinsi');
        $("#propinsi").html(isi);
        $("#propinsi_pekerjaan").html(isi);
        $("#propinsi_usaha").html(isi);
        $("#propinsi_kerabat").html(isi);
        isi = ajak('base/tabungan/isi_tabungan');
        $("#form_tab select[name='jenis_simpanan']").html(isi);
        
        return false;
    });
    $("#form_tab select[name='jenis_simpanan']").change(function() {
        var cab = ajak('base/tabungan/cab_code');
        var produk =  $("#form_tab select[name='jenis_simpanan']").val();
        var count = ajak('base/tabungan/run_code',"id="+produk +"&cab="+cab);
    
        $("#form_tab input[name='nomor_rekening']").val(count);
        //$("#form_tab input[name='nomor_rekening']").val(produk+""+cab+""+count);
        return false;
    });
    
    $('.searchnasabah').click(function() {
        $('.nav-tabs li:eq(1)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(3)').removeClass('').addClass('active');
        $('#tabs-2').removeClass('active').addClass('');
        $('#tabs-4').removeClass('').addClass('active');
        return false;
    });
    //autocomplite nasabah
    /*$("#form_tab input[name='nama']").autocomplete('base/tabungan/search_nasabah', {
            multiple: false,
            parse: function(data) {
                return $.map(eval(data), function(row) {
                    return {
                        data: row,
                        value: row.nomor_nasabah,
                        result: row.nama
                    }
                });
            },
            formatItem: function(item) {
                return item.nomor_nasabah + ' - ' + item.nama;
            }
     }).result(function(e, item) {
            $("#form_tab input[name='nama']").val(item.nama);
            $("#form_tab input[name='nomor_nasabah']").val(item.nomor_nasabah);
            $("#form_tab input[name='alamat']").val(item.alamat+" RT/RW "+item.rtrw);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+item.kabupaten);
            $("#form_tab input[name='kota']").val(kab);
    });
    */
    $('.searchfo').click(function() {
        $('.nav-tabs li:eq(1)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(2)').removeClass('').addClass('active');
        $('#tabs-2').removeClass('active').addClass('');
        $('#tabs-3').removeClass('').addClass('active');
        return false;
    });
    /*
    
    //autocomplite fo
    $("#form_tab input[name='nomor_foname']").autocomplete('base/tabungan/search_fo', {
            multiple: false,
            parse: function(data) {
                return $.map(eval(data), function(row) {
                    return {
                        data: row,
                        value: row.nip,
                        result: row.nama_pegawai
                    }
                });
            },
            formatItem: function(item) {
                return item.nip + ' - ' + item.nama_pegawai;
            }
     }).result(function(e, item) {
            $("#form_tab input[name='nomor_fo']").val(item.nip);
            $("#form_tab input[name='nomor_foname']").val(item.nama_pegawai);
    });
    */
    //---- Tabel tabungan
    $("#table_datatabungan").mastertable({
        urlGet:"base/tabungan/get_tabungan",
        flook:"nomor_rekening"
    },
    function(hal,juml,json) {
        var isi="";
        var kec = "";
        var kab = "";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "j" + json['alldata'][i].tabungan_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            kec = ajak('base/nasabah/single_kecamatan','&kec='+json['alldata'][i].kecamatan);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+json['alldata'][i].kabupaten);
            //
            managejab = "<img  class=\"cedt\" title=\"Edit\" src=\"assets/images/editicon.png\"/>&nbsp;&nbsp;|&nbsp;&nbsp;<img class=\"chps\" title=\"Hapus\" src=\"assets/images/delicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nomor_rekening + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].alamat + " RT/RW " + json['alldata'][i].rtrw + " Kec. " + kec + " Kode pos " + json['alldata'][i].kode_pos + "</td>"
                + "<td align=\"left\">" + kab + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].tabungan_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Edit
        $('.cedt').click( function() {
            $(".infonya").hide();
            $('.inp').val('');
            $('#dialog-login-edit').dialog('option', 'title',  'Login' ).dialog('open');
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            $("#form_tab input[name='tgl_dibuka']").val(revDate(obj.tgl_dibuka,'-'));
            $("#form_tab input[name='nomor_rekening']").val(obj.nomor_rekening);
            peg = ajak('base/tabungan/single_pegawai','&peg='+obj.nomor_fo );
            $("#form_tab input[name='nomor_fo']").val(obj.nomor_fo);
            $("#form_tab input[name='nomor_foname']").val(peg);
            $("#form_tab input[name='nama']").val(obj.nama);
            $("#form_tab input[name='nomor_nasabah']").val(obj.nomor_nasabah);
            $("#form_tab input[name='alamat']").val(obj.alamat+" RT/RW "+obj.rtrw);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+obj.kabupaten);
            $("#form_tab input[name='kota']").val(kab);
            isi = ajak('base/tabungan/isi_tabungan');
            $("#form_tab select[name='jenis_simpanan']").html(isi);
        
            $("#form_tab select[name='jenis_simpanan']").val(obj.jenis_simpanan);
            $("#form_tab input[name='sumber_dana']").val(obj.sumber_dana);
            $("#form_tab input[name='tujuan_pembukaan']").val(obj.tujuan_pembukaan);
            $("#form_tab select[name='zakat']").val(obj.zakat);
            $("#form_tab input[name='nisbah']").val(obj.nisbah);
            $("#form_tab select[name='administrasi']").val(obj.administrasi);
            $("#form_tab select[name='pph']").val(obj.pph);
            $("#form_tab select[name='dijaminkan']").val(obj.dijaminkan);
            $("#form_tab select[name='blockir']").val(obj.blockir);
            $("#form_tab select[name='status']").val(obj.status);
            return false;
        });
        function editdata(){
            $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
            $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
            $('#tabs-1').removeClass('active').addClass('');
            $('#tabs-2').removeClass('').addClass('active');
            
            return false;
        }
        $('.chps').click( function() {
            //alert(1);
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            $('.phps').html(obj.nama);
            jSimpan("idx",obj.tabungan_id);
            $('#dialog-hapus').dialog('option', 'title',  'Hapus' ).dialog('open');
            return false;
        });
        //---- Dialog Hapus
        $('#dialog-hapus').dialog({autoOpen: false,width: 400,modal: true,
            buttons: {
                        "Ok": function() {
                            $(this).dialog("close");
                            $(".infonya").hide();
                            $('.inp').val('');
                            $('#dialog-login-hapus').dialog('option', 'title',  'Login' ).dialog('open');
                            return false;
                        },
                        "Batal": function() {
                            $(this).dialog('close');
                        }
                     }
        });
     
        $('#dialog-login-edit').dialog({autoOpen: false,width: 380,modal: true,
            buttons: {
                        "Ok": function() {
                            hasil = validform("form_login_edit");
                            if (hasil['isi'] != "invalid") {
                                respon = ajak("base/tabungan/login",$('#form_login_edit').serialize());
                                if (respon == "valid") {
                                    $(this).dialog("close");
                                    editdata();
                                }else {
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
         $('#dialog-login-hapus').dialog({autoOpen: false,width: 380,modal: true,
            buttons: {
                        "Ok": function() {
                            hasil = validform("form_login_hapus");
                            if (hasil['isi'] != "invalid") {
                                respon = ajak("base/tabungan/login",$('#form_login_hapus').serialize());
                                if (respon == "valid") {
                                    respon = ajak("base/tabungan/hapus","id=" + jAmbil("idx"));
                                    if (respon == "1") {
                                        $("#table_datatabungan .reset").click();
                                        $(this).dialog('close');
                                    } else {
                                        showinfo("Error : " + respon);
                                    }
                                }else {
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
        warnatable();
    });
    
    $("#table_pegawai").mastertable({
        urlGet:"param/pegawai/get_pegawai",
        flook:"nama_pegawai"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "p" + json['alldata'][i].pegawai_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            managejab = "<img class=\"cadd\" title=\"Add\" src=\"assets/images/addicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama_pegawai + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama_panggilan + "</td>"
                + "<td>" + json['alldata'][i].alamat + "<br />" + json['alldata'][i].kota + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].nama_jabatan + "</td>"
                + "<td align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].pegawai_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        $('.cadd').click( function() {
            $(".infonya").hide();
            obj = jAmbil("p" + $(this).parent().next().text());
            $('.nav-tabs li:eq(2)').removeClass('active').addClass('');
            $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
            $('#tabs-3').removeClass('active').addClass('');
            $('#tabs-2').removeClass('').addClass('active');
            $("#form_tab input[name='nomor_fo']").val(obj.nip);
            $("#form_tab input[name='nomor_foname']").val(obj.nama_pegawai);
            
            return false;
        });
        warnatable();
    });
    //---- Tabel Nasabah
    $("#table_datanasabah").mastertable({
        urlGet:"base/nasabah/get_nasabah",
        flook:"nomor_nasabah"
    },
    function(hal,juml,json) {
        var isi="";
        var kec = "";
        var kab = "";
        var prov = "";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "n" + json['alldata'][i].nasabah_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            kec = ajak('base/nasabah/single_kecamatan','&kec='+json['alldata'][i].kecamatan);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+json['alldata'][i].kabupaten);
            managejab = "<img class=\"cadd\" title=\"Add\" src=\"assets/images/addicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nomor_nasabah + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].alamat + " RT/RW " + json['alldata'][i].rtrw + " Kec. " + kec + " Kode pos " + json['alldata'][i].kode_pos + "</td>"
                + "<td align=\"left\">" + kab + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].nasabah_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        $('.cadd').click( function() {
            $(".infonya").hide();
            obj = jAmbil("n" + $(this).parent().next().text());
            $('.nav-tabs li:eq(3)').removeClass('active').addClass('');
            $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
            $('#tabs-4').removeClass('active').addClass('');
            $('#tabs-2').removeClass('').addClass('active');
            
            $("#form_tab input[name='nama']").val(obj.nama);
            $("#form_tab input[name='nomor_nasabah']").val(obj.nomor_nasabah);
            $("#form_tab input[name='alamat']").val(obj.alamat+" RT/RW "+obj.rtrw);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+obj.kabupaten);
            $("#form_tab input[name='kota']").val(kab);
            
            return false;
        });
        warnatable();
    });
    //---- Dialog Login
    
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
