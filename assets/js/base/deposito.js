/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : base/deposito.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    $('input[name="nominal"],input[name="nomor_ref"]').inputInteger();
/*
 *  --------------------- deposito -----------------------------------------
 */
    $('#button-previous ,#button-next').click(function() {
        $("html, body").animate({ scrollTop: 300 }, "slow");
        return false;
    });
    $('#form_deposito input').val('');
    $('#form_deposito select').val('');
    $('#form_deposito textarea').val('');
    var produkcode = ajak('base/deposito/produk_code');
    var count = ajak('base/deposito/run_code',"id="+ produkcode);
    var cab = ajak('base/deposito/cab_code');
    $("#form_deposito input[name='nomor_rekening']").val(produkcode+""+cab+""+count);
    $("#form_deposito input[name='tgl_dibuka']").val(isitglskrg());
    isi = ajak('base/deposito/isi_deposito');
    $("#form_deposito select[name='nama_produk']").html(isi);
    $("#form_deposito input[name='jatuh_tempo']").val(isitglnext(1));
    $("#form_deposito input[name='iddeposito']").val('0');
    $('#adddeposito').click(function() {
        $('#form_deposito input').val('');
        $('#form_deposito select').val('');
        $('#form_deposito textarea').val('');
        var cab = ajak('base/deposito/cab_code');
        var produkcode = ajak('base/deposito/produk_code');
        var count = ajak('base/deposito/run_code',"id="+ produkcode);
        $("#form_deposito input[name='nomor_rekening']").val(produkcode+""+cab+""+count);
        $("#form_deposito input[name='tgl_dibuka']").val(isitglskrg());
        $("#form_deposito input[name='jatuh_tempo']").val(isitglnext(1));
        $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
        $('#tabs-1').removeClass('active').addClass('');
        $('#tabs-2').removeClass('').addClass('active');
        //
        $("#form_deposito input[name='iddeposito']").val('0');
        return false;
    });
    
    $("#form_deposito select[name='nama_produk']").change(function() {
        var produk =  $("#form_deposito select[name='nama_produk']").val();
        if(produk == "11"){
            $("#form_deposito input[name='jatuh_tempo']").val(isitglnext(1));
            var count = ajak('base/deposito/run_code',"id="+ produk);
            var cab = ajak('base/deposito/cab_code');
            $("#form_deposito input[name='nomor_rekening']").val(produk+""+cab+""+count);
        }else if(produk == "12"){
            $("#form_deposito input[name='jatuh_tempo']").val(isitglnext(3));
            var count = ajak('base/deposito/run_code',"id="+ produk);
            var cab = ajak('base/deposito/cab_code');
            $("#form_deposito input[name='nomor_rekening']").val(produk+""+cab+""+count);
        }else if(produk == "13"){
            $("#form_deposito input[name='jatuh_tempo']").val(isitglnext(6));
            var count = ajak('base/deposito/run_code',"id="+ produk);
            var cab = ajak('base/deposito/cab_code');
            $("#form_deposito input[name='nomor_rekening']").val(produk+""+cab+""+count);
        }else if(produk == "14"){
            $("#form_deposito input[name='jatuh_tempo']").val(isitglnext(12));
            var count = ajak('base/deposito/run_code',"id="+ produk);
            var cab = ajak('base/deposito/cab_code');
            $("#form_deposito input[name='nomor_rekening']").val(produk+""+cab+""+count);
        }
        return false;
    });
    
    $('#savedata').click(function() {
        hasil = validform("form_deposito");
        if (hasil['isi'] != "invalid") {
            
            if($("#form_deposito input[name='iddeposito']").val() == "0"){
                respon = ajak("base/deposito/savedata",$('#form_deposito').serialize());
                if(respon == 1){
                    window.location.replace("base/deposito");
                }else{
                    showinfo("Error : " + respon);
                    return false;
                }
            }else{
                respon = ajak("base/deposito/editdata",$('#form_deposito').serialize());
                if(respon == 1){
                    window.location.replace("base/deposito");
                }else{
                    showinfo("Error : " + respon);
                    return false;
                }
            }
        } else {
            showinfo("Form dengan tanda * harus Diisi");
            hasil['focus'].focus();
            return false;
        }
        
    });
    
    $('.searchnasabah').click(function() {
        $('.nav-tabs li:eq(1)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(2)').removeClass('').addClass('active');
        $('#tabs-2').removeClass('active').addClass('');
        $('#tabs-3').removeClass('').addClass('active');
        return false;
    });
    
     //---- Tabel deposito
    $("#table_deposito").mastertable({
        urlGet:"base/deposito/get_data",
        flook:"nomor_rekening"
    },
    function(hal,juml,json) {
        var isi="";
        var jenis="";
        if(json['alldata'].length != 0){
            for(i = 0; i < json['alldata'].length; i++) {
                idx = "d" + json['alldata'][i].deposito_id;
                dtx = json['alldata'][i];
                jSimpan(idx,dtx);
                jenis = ajak('base/deposito/filter','&jenis='+json['alldata'][i].nama_produk);
                managejab = "<img  class=\"cedt\" title=\"Edit\" src=\"assets/images/editicon.png\"/>";
                isi += "<tr style=\"vertical-align:top;\">"
                    + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                    + "<td align=\"left\">" + json['alldata'][i].nomor_rekening + "</td>"
                    + "<td align=\"left\">" + json['alldata'][i].nama + "</td>"
                    + "<td align=\"left\">" + jenis + "</td>"
                    + "<td align=\"right\">" + format_uang(json['alldata'][i].nominal) + "</td>"
                    + "<td align=\"center\">" + revDate(json['alldata'][i].jatuh_tempo,'-') + "</td>"
                    + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                    + "<td align=\"center\">" + json['alldata'][i].deposito_id + "</td>"
                    + "</tr>";
            }
        }
        return isi;
    },
    function domIsi() {
        //---- Edit
        $('.cedt').click( function() {
            $(".infonya").hide();
            obj = jAmbil("d" + $(this).parent().next().text());
            $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
            $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
            $('#tabs-1').removeClass('active').addClass('');
            $('#tabs-2').removeClass('').addClass('active');
            
            $("#form_deposito input[name='iddeposito']").val(obj.deposito_id);
            $("#form_deposito input[name='tgl_dibuka']").val(revDate(obj.tgl_dibuka,'-'));
            $("#form_deposito input[name='nomor_rekening']").val(obj.nomor_rekening);
            $("#form_deposito input[name='nomor_ref']").val(obj.nomor_ref);
            
            nasabah = ajak('base/deposito/nasabah','&nasabah='+obj.nomor_nasabah);
            $("#form_deposito input[name='nama']").val(nasabah);
            $("#form_deposito input[name='nomor_nasabah']").val(obj.nomor_nasabah);
            $("#form_deposito input[name='alamat']").val(obj.alamat+" RT/RW "+obj.rtrw);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+obj.kabupaten);
            $("#form_deposito input[name='kota']").val(kab);
            
            isi = ajak('base/deposito/isi_deposito');
            $("#form_deposito select[name='nama_produk']").html(isi);
            $("#form_deposito select[name='nama_produk']").val(obj.nama_produk);
            
            $("#form_deposito input[name='nomor_bilyet']").val(obj.nomor_bilyet);
            $("#form_deposito input[name='nominal']").val(obj.nominal);
            $("#form_deposito input[name='jatuh_tempo']").val(revDate(obj.jatuh_tempo,'-'));
            $("#form_deposito input[name='sumber_dana']").val(obj.sumber_dana);
            $("#form_deposito select[name='administrasi']").val(obj.administrasi);
            $("#form_deposito select[name='pph']").val(obj.pph);
            $("#form_deposito select[name='dijaminkan']").val(obj.dijaminkan);
            $("#form_deposito select[name='zakat']").val(obj.zakat);
            $("#form_deposito input[name='nisbah_tambahan']").val(obj.nisbah_tambahan);
            $("#form_deposito input[name='rekening_basil']").val(obj.rekening_basil);
            namatab = ajak('base/deposito/tabungan','&tab='+obj.rekening_basil);
            $("#form_deposito input[name='namatab']").val(namatab);
            
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
            idx = "s" + json['alldata'][i].nasabah_id;
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
            obj = jAmbil("s" + $(this).parent().next().text());
            $('.nav-tabs li:eq(2)').removeClass('active').addClass('');
            $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
            $('#tabs-3').removeClass('active').addClass('');
            $('#tabs-2').removeClass('').addClass('active');
            
            $("#form_deposito input[name='nama']").val(obj.nama);
            $("#form_deposito input[name='nomor_nasabah']").val(obj.nomor_nasabah);
            $("#form_deposito input[name='alamat']").val(obj.alamat+" RT/RW "+obj.rtrw);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+obj.kabupaten);
            $("#form_deposito input[name='kota']").val(kab);
            
            return false;
        });
        warnatable();
    });
    
    $('.searchrekening').click(function() {
        $('.nav-tabs li:eq(1)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(3)').removeClass('').addClass('active');
        $('#tabs-2').removeClass('active').addClass('');
        $('#tabs-4').removeClass('').addClass('active');
        return false;
    });
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
            managejab = "<img class=\"caddt\" title=\"Add\" src=\"assets/images/addicon.png\"/>";
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
        //---- 
        $('.caddt').click( function() {
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            $('.nav-tabs li:eq(3)').removeClass('active').addClass('');
            $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
            $('#tabs-4').removeClass('active').addClass('');
            $('#tabs-2').removeClass('').addClass('active');
            
            $("#form_deposito input[name='namatab']").val(obj.nama);
            $("#form_deposito input[name='rekening_basil']").val(obj.nomor_rekening);
            return false;
        });
        warnatable();
    });
    
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
