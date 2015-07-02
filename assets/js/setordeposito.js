/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : setordeposito.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    var adminouth = 0;
/*
 *  --------------------- setor tunai -----------------------------------------
 */
    $('#form_setordeposito input').val('');
    $('#form_setordeposito select').val('');
    $('#form_setordeposito textarea').val('');
    $('#form_setordeposito input[name="ket"]').val('SETORAN DEPOSITO');
    $("#form_setordeposito input[name='tgl_transaksi']").val(isitglskrg());
    $('input[name="jumlah"],input[name="biaya"],input[name="nomor_jurnal"]').inputInteger();
    isi = ajak('setortunai/isi_wilayah');
    $("#form_setordeposito select[name='wilayah_id']").html(isi);
    var count = ajak('setortunai/run_code');
    $("#form_setordeposito input[name='nomor_jurnal']").val(count);
    $('.searchact').click(function() {
        $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
        $('#tabs-1').removeClass('active').addClass('');
        $('#tabs-2').removeClass('').addClass('active');
        return false;
    });
    $("#form_setordeposito input[name='jumlah']").keyup(function() {
        $('#terbilang').html("");
         nilai = ($(this).val() * 1);
         if (nilai < 0) {
            $('.jumlahket').html('Rp 0');
         } else {
            $('.jumlahket').html('Rp ' + format_uang(nilai));
         }
     }).focus(function(){
         $(this).val($(this).val().replace(/\s|\./g,''));
     }).blur(function(){
         if ($(this).val() != '') {
            $(this).val(format_uang($(this).val()));
            num = $(this).val().replace(/\s|\./g,'');
            nilai = terbilang(num);
            $('#terbilang').html(nilai+" Rupiah");
         }
     });
     $("#form_setordeposito input[name='biaya']").keyup(function() {
         nilai = ($(this).val() * 1);
         if (nilai < 0) {
            $('.biayaket').html('Rp 0');
         } else {
            $('.biayaket').html('Rp ' + format_uang(nilai));
         }
     }).focus(function(){
         $(this).val($(this).val().replace(/\s|\./g,''));
     }).blur(function(){
         if ($(this).val() != '') {
            $(this).val(format_uang($(this).val()));
         }
     });
    $('#save').click(function() {
        hasil = validform("form_setordeposito");
        if (hasil['isi'] != "invalid") {
            num = $("#form_setordeposito input[name='jumlah']").val();
            jumlah = num.replace(/\s|\./g,'');
            num1 = $("#form_setordeposito input[name='saldot']").val();
            saldo = num1.replace(/\s|\./g,'') * 1;
            limit = ajak('tariktunai/limittarik','&nilai='+jumlah);
            if(limit == "no"){
                showinfo("Anda tidak diberi Otoritas");
                return false;
            }else{
                if((saldo == 0)&&($("#form_setordeposito input[name='nomor_rekeningt']").val() == "")){
                    respon = ajak("setordeposito/savetunai",$('#form_setordeposito').serialize());
                    respon = respon.split("#");
                    if (respon[0] == "1") {
                    	today = tglskrg();
                    	jam = jamskrg();
                    	$('#ctgl_valid',ctkframe.document).html(today+" "+ jam);
                    	$('#nomortransaksi',ctkframe.document).html(respon[1]);
                    	$('#nomorref',ctkframe.document).html(respon[2]);
                    	$('#nilai',ctkframe.document).html("Rp "+ num );
                    	$('#nomoraccount',ctkframe.document).html(respon[3]);
                        window.ctkframe.print();
                    	window.location.replace("deposito");
                    } else if (respon[0] == "1062"){
                        showinfo("No. Ref sudah ada");
                        return false;
                    }else {
                        showinfo("Error : " + respon[0]);
                        return false;
                    }
                }else{
                    if(jumlah < saldo){
                        respon = ajak("setordeposito/savetunai",$('#form_setordeposito').serialize());
                        respon = respon.split("#");
                        if (respon[0] == "1") {
                        	today = tglskrg();
                        	jam = jamskrg();
                        	$('#ctgl_valid',ctkframe.document).html(today+" "+ jam);
                        	$('#nomortransaksi',ctkframe.document).html(respon[1]);
                        	$('#nomorref',ctkframe.document).html(respon[2]);
                        	$('#nilai',ctkframe.document).html("Rp "+ num );
                        	$('#nomoraccount',ctkframe.document).html(respon[3]);
                            window.ctkframe.print();
                            window.location.replace("deposito");
                        } else {
                            showinfo("Error : " + respon[0]);
                            return false;
                        }
                    }else{
                        showinfo("Saldo tidak cukup untuk pindah buku");
                        return false;
                    }
                }
            }
         } else {
            showinfo("Form dengan tanda * harus Diisi");
            hasil['focus'].focus();
            return false;
        }
    });
    $("#table_datadeposito").mastertable({
        urlGet:"base/deposito/get_data",
        flook:"nomor_rekening"
    },
    function(hal,juml,json) {
        var isi="";
        var kec = "";
        var kab = "";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "d" + json['alldata'][i].deposito_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            kec = ajak('base/nasabah/single_kecamatan','&kec='+json['alldata'][i].kecamatan);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+json['alldata'][i].kabupaten);
            //
            managejab = "<img class=\"caddd\" title=\"Add\" src=\"assets/images/addicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nomor_rekening + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].alamat + " RT/RW " + json['alldata'][i].rtrw + " Kec. " + kec + " Kode pos " + json['alldata'][i].kode_pos + "</td>"
                + "<td align=\"left\">" + kab + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].deposito_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        $('.caddd').click( function() {
            $(".infonya").hide();
            obj = jAmbil("d" + $(this).parent().next().text());
            $('.nav-tabs li:eq(1)').removeClass('active').addClass('');
            $('.nav-tabs li:eq(0)').removeClass('').addClass('active');
            $('#tabs-2').removeClass('active').addClass('');
            $('#tabs-1').removeClass('').addClass('active');
            $("#form_setordeposito input[name='nomor_rekening']").val(obj.nomor_rekening);
            $("#form_setordeposito input[name='nama']").val(obj.nama);
            kec = ajak('base/nasabah/single_kecamatan','&kec='+obj.kecamatan);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+obj.kabupaten);
            var alamat = obj.alamat + " RT/RW " + obj.rtrw + " Kec. " + kec ;
            $("#form_setordeposito input[name='alamat']").val(alamat);
            $("#form_setordeposito input[name='kota']").val(kab + " / "+ obj.kode_pos);
            $("#form_setordeposito input[name='nama']").val(obj.nama);
            
            jurnal = ajak('setordeposito/jurnal','&id='+obj.nama_produk );
            $("#form_setordeposito input[name='id_jurnal']").val(jurnal);
            
            var num = obj.nominal.split(".");
            $("#form_setordeposito input[name='jumlah']").val(num[0]);
            $('#terbilang').html("");
             nilai = (num[0] * 1);
            if (nilai < 0) {
                $('.jumlahket').html('Rp 0');
            } else {
                $('.jumlahket').html('Rp ' + format_uang(nilai));
            }
            nilait = terbilang(nilai);
            $('#terbilang').html(nilait+" Rupiah");
            
            return false;
        });
        
    });
    $('.searchtab').click(function() {
        $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(2)').removeClass('').addClass('active');
        $('#tabs-1').removeClass('active').addClass('');
        $('#tabs-3').removeClass('').addClass('active');
        return false;
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
            idx = "t" + json['alldata'][i].tabungan_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            kec = ajak('base/nasabah/single_kecamatan','&kec='+json['alldata'][i].kecamatan);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+json['alldata'][i].kabupaten);
            //
            managejab1 = "<img class=\"caddt\" title=\"Add\" src=\"assets/images/addicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nomor_rekening + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].alamat + " RT/RW " + json['alldata'][i].rtrw + " Kec. " + kec + " Kode pos " + json['alldata'][i].kode_pos + "</td>"
                + "<td align=\"left\">" + kab + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab1 + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].tabungan_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        $('.caddt').click( function() {
            $(".infonya").hide();
            obj = jAmbil("t" + $(this).parent().next().text());
            $('.nav-tabs li:eq(2)').removeClass('active').addClass('');
            $('.nav-tabs li:eq(0)').removeClass('').addClass('active');
            $('#tabs-3').removeClass('active').addClass('');
            $('#tabs-1').removeClass('').addClass('active');
            
            $("#form_setordeposito input[name='nomor_rekeningt']").val(obj.nomor_rekening);
            $("#form_setordeposito input[name='namat']").val(obj.nama);
            kec = ajak('base/nasabah/single_kecamatan','&kec='+obj.kecamatan);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+obj.kabupaten);
            var alamat = obj.alamat + " RT/RW " + obj.rtrw + " Kec. " + kec ;
            $("#form_setordeposito input[name='alamatt']").val(alamat);
            $("#form_setordeposito input[name='kotat']").val(kab + " / "+ obj.kode_pos);
            
            jumlah = ajak('setortunai/saldo','&id='+obj.nomor_rekening);
            $("#form_setordeposito input[name='saldot']").val(jumlah);
            
            return false;
        });
        
    });
    warnatable();
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
