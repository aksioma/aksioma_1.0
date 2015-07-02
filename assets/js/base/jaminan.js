/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : base/jaminan.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();

/*
 *  --------------------- jaminan -----------------------------------------
 */
    $('#button-previous ,#button-next').click(function() {
        $("html, body").animate({ scrollTop: 300 }, "slow");
        return false;
    });
    var count = ajak('base/jaminan/run_code');
    var cab = ajak('base/jaminan/cab_code');
    $("#form_jamin input[name='nomor_jaminan']").val(cab+""+count);
    $('#addjaminan').click(function() {
        $('#form_jamin input').val('');
        $('#form_jamin select').val('');
        $('#form_jamin textarea').val('');
        var count = ajak('base/jaminan/run_code');
        var cab = ajak('base/jaminan/cab_code');
        $("#form_jamin input[name='nomor_jaminan']").val(cab+""+count);
        $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
        $('#tabs-1').removeClass('active').addClass('');
        $('#tabs-2').removeClass('').addClass('active');
        return false;
    });
    
    $('.searchnasabah').click(function() {
        $('.nav-tabs li:eq(1)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(2)').removeClass('').addClass('active');
        $('#tabs-2').removeClass('active').addClass('');
        $('#tabs-3').removeClass('').addClass('active');
        return false;
    });
    $('.searchrek').click(function() {
    	
    	if($("#form_jamin select[name='Jenis_jaminan']").val() == "01"){
    		$('.nav-tabs li:eq(1)').removeClass('active').addClass('');
            $('.nav-tabs li:eq(3)').removeClass('').addClass('active');
            $('#tabs-2').removeClass('active').addClass('');
            $('#tabs-4').removeClass('').addClass('active');
    	}else{
    		$('.nav-tabs li:eq(1)').removeClass('active').addClass('');
            $('.nav-tabs li:eq(4)').removeClass('').addClass('active');
            $('#tabs-2').removeClass('active').addClass('');
            $('#tabs-5').removeClass('').addClass('active');
    	}
        
        return false;
    });
    /*
    //autocomplite nasabah
    $("#form_jamin input[name='nama']").autocomplete('base/jaminan/search_nasabah', {
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
            $("#form_jamin input[name='nama']").val(item.nama);
            $("#form_jamin input[name='nomor_nasabah']").val(item.nomor_nasabah);
            $("#form_jamin input[name='alamat']").val(item.alamat+" RT/RW "+item.rtrw);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+item.kabupaten);
            $("#form_jamin input[name='kota']").val(kab);
    });
    */
     //---- Tabel jaminan
    $("#table_datajaminan").mastertable({
        urlGet:"base/jaminan/get_jaminan",
        flook:"nomor_jaminan"
    },
    function(hal,juml,json) {
        var isi="";
        var jenis="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "j" + json['alldata'][i].jaminan_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            //<img class=\"chps\" title=\"Hapus\" src=\"assets/images/delicon.png\"/>&nbsp;
            if(json['alldata'][i].Jenis_jaminan == "01"){
                jenis = "KAS, TABUNGAN DEPOSITO";
            }else if(json['alldata'][i].Jenis_jaminan == "02"){
                jenis = "PERHIASAN EMAS DAN LOGAM MULIA";
            }else if(json['alldata'][i].Jenis_jaminan == "03"){
                jenis = "TANAH DAN BANGUNA";
            }else if(json['alldata'][i].Jenis_jaminan == "04"){
                jenis = "KENDARAAN BERMOTOR";
            }else if(json['alldata'][i].Jenis_jaminan == "05"){
                jenis = "LAIN - LAIN";
            }
            managejab = "<img  class=\"cedt\" title=\"Edit\" src=\"assets/images/editicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nomor_jaminan + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nomor_rekening + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama + "</td>"
                + "<td align=\"left\">" + jenis + "</td>"
                + "<td align=\"right\">Rp " + format_uang(json['alldata'][i].nilai_jaminan) + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].jaminan_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Edit
        $('.cedt').click( function() {
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
            $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
            $('#tabs-1').removeClass('active').addClass('');
            $('#tabs-2').removeClass('').addClass('active');
            
            $("#form_jamin input[name='nomor_jaminan']").val(obj.nomor_jaminan);
            $("#form_jamin input[name='nama']").val(obj.nama);
            $("#form_jamin input[name='nomor_nasabah']").val(obj.nomor_nasabah);
            $("#form_jamin input[name='alamat']").val(obj.alamat+" RT/RW "+obj.rtrw);
            $("#form_jamin select[name='Jenis_jaminan']").val(obj.Jenis_jaminan);
            $("#form_jamin input[name='pemilik']").val(obj.pemilik);
            $("#form_jamin input[name='nomor_rekening']").val(obj.nomor_rekening);
            $("#form_jamin input[name='rekening_tab_deposito']").val(obj.rekening_tab_deposito);
            $("#form_jamin input[name='no_rek_bpkb_sert']").val(obj.no_rek_bpkb_sert);
            $("#form_jamin input[name='stnk_hgb']").val(obj.stnk_hgb);
            $("#form_jamin input[name='luas_tanah']").val(obj.luas_tanah);
            $("#form_jamin input[name='nilai_jaminan']").val(obj.nilai_jaminan);
            $("#form_jamin input[name='inspeksi_terakhir']").val(revDate(obj.inspeksi_terakhir,'-'));
            $("#form_jamin input[name='inspeksi_oleh']").val(obj.inspeksi_oleh);
            $("#form_jamin textarea[name='keterangan']").val(obj.keterangan);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+obj.kabupaten);
            $("#form_jamin input[name='kota']").val(kab);
            return false;
        });
        warnatable();
    });
    
    //---- Tabel Nasabah
    $("#table_datanasabah").mastertable({
        urlGet:"base/jaminan/get_pembiayaan",
        flook:"nomor_rekening"
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
                + "<td align=\"left\">" + json['alldata'][i].nomor_rekening + "</td>"
                + "<td align=\"right\">" + format_uang(json['alldata'][i].harga_pokok) + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].alamat + " RT/RW " + json['alldata'][i].rtrw + " Kec. " + kec + " Kode pos " + json['alldata'][i].kode_pos + "</td>"
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
            $('.nav-tabs li:eq(2)').removeClass('active').addClass('');
            $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
            $('#tabs-3').removeClass('active').addClass('');
            $('#tabs-2').removeClass('').addClass('active');
            
            $("#form_jamin input[name='nama']").val(obj.nama);
            $("#form_jamin input[name='nomor_rekening']").val(obj.nomor_rekening);
            $("#form_jamin input[name='alamat']").val(obj.alamat+" RT/RW "+obj.rtrw);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+obj.kabupaten);
            $("#form_jamin input[name='kota']").val(kab);
            
            return false;
        });
        warnatable();
    });
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
            managejab = "<img class=\"cadd\" title=\"Add\" src=\"assets/images/addicon.png\"/>";
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
    	$('.cadd').click( function() {
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            $('.nav-tabs li:eq(3)').removeClass('active').addClass('');
            $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
            $('#tabs-4').removeClass('active').addClass('');
            $('#tabs-2').removeClass('').addClass('active');
            
            $("#form_jamin input[name='rekening_tab_deposito']").val(obj.nomor_rekening);
            
            return false;
        });
        warnatable();
    });
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
                managejab = "<img class=\"cadd\" title=\"Add\" src=\"assets/images/addicon.png\"/>";
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
    	$('.cadd').click( function() {
            $(".infonya").hide();
            obj = jAmbil("d" + $(this).parent().next().text());
            $('.nav-tabs li:eq(4)').removeClass('active').addClass('');
            $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
            $('#tabs-5').removeClass('active').addClass('');
            $('#tabs-2').removeClass('').addClass('active');
            
            $("#form_jamin input[name='rekening_tab_deposito']").val(obj.nomor_rekening);
            
            return false;
        });
        warnatable();
    });
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
