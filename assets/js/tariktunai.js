/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : tariktunai.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    $('.jclock').jclock({format: '%A, %d %B %Y - %H:%M:%S %P'});
    var adminouth = 0;
/*
 *  --------------------- setor tunai -----------------------------------------
 */
    $("#form_tariktunai input[name='tgl_transaksi']").val(isitglskrg());
    $('input[name="jumlah"],input[name="biaya"],input[name="nomor_jurnal"]').inputInteger();
    isi = ajak('tariktunai/isi_wilayah');
    $("#form_tariktunai select[name='wilayah_id']").html(isi);
    var count = ajak('tariktunai/run_code');
    $("#form_tariktunai input[name='nomor_jurnal']").val(count);
    $('.searchact').click(function() {
        $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
        $('#tabs-1').removeClass('active').addClass('');
        $('#tabs-2').removeClass('').addClass('active');
        
        return false;
    });
    $("#form_tariktunai input[name='jumlah']").keyup(function() {
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
            $(this).val($(this).val());
            num = $(this).val().replace(/\s|\./g,'');
            nilai = terbilang(num);
            $('#terbilang').html(nilai+" Rupiah");
         }
     });
     $("#form_tariktunai input[name='biaya']").keyup(function() {
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
            $(this).val($(this).val());
         }
     });
    //dialog login
    $('#dialog-login').dialog({autoOpen: false,width: 380,modal: true,
            buttons: {
                        "Ok": function() {
                            hasil = validform("form_login");
                            if (hasil['isi'] != "invalid") {
                            	num = $("#form_tariktunai input[name='jumlah']").val();
                                respon = ajak("base/tabungan/login",$('#form_login').serialize());
                                if (respon == "valid") {
                                    respon = ajak("tariktunai/savetunai",$('#form_tariktunai').serialize());
                                    respon = respon.split("#");
                                    if (respon[0] == "1") {
                                         $(this).dialog("close");
                                         today = tglskrg1();
                                     	jam = jamskrg();
                                     	$('#ctgl_valid',ctkframe.document).html(today+""+ jam);
                                     	$('#nomortransaksi',ctkframe.document).html(respon[1]);
                                     	$('#nomorref',ctkframe.document).html(respon[2]);
                                     	$('#nilai',ctkframe.document).html("Rp "+ num );
                                     	$('#nomoraccount',ctkframe.document).html(respon[3]);
                                         window.ctkframe.print();
                                         window.location.href = "/tariktunai";
                                    } else {
                                        showinfo("Error : " + respon[0]);
                                        return false;
                                    }
                                }else {
                                    showinfo("Error : " + respon);
                                    return false;
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
    $('#savetarik').click(function() {
        hasil = validform("form_tariktunai");
        if (hasil['isi'] != "invalid") {
            num = $("#form_tariktunai input[name='jumlah']").val();
            jumlah = num.replace(/\s|\./g,'');
            limit = ajak('tariktunai/limittarik','&nilai='+jumlah);
            saldo = ajak('tariktunai/saldoval','&id='+ $("#form_tariktunai input[name='nomor_rekening']").val()+'&id_jurnal='+$("#form_tariktunai input[name='id_jurnal']").val());
            saldo = saldo.replace(/\s|\./g,'');
            if(limit == "no"){
                showinfo("Yang bisa tarik tunai Teller atau yg di beri Otoritas");
                return false;
            }else if(eval(saldo) < eval(jumlah)){
                showinfo("Jumlah saldo tidak mencukupi");
                return false;
            }else if(limit == "0"){
                $(".infonya").hide();
                $('#dialog-login').dialog('option', 'title',  'Otoritas' ).dialog('open');
                return false;
            }else{
                respon = ajak("tariktunai/savetunai",$('#form_tariktunai').serialize());
                respon = respon.split("#");
                if (respon[0] == "1") {
                    alert("Tarik tunai sebesar Rp "+ num + " Berhasil");
                	today = tglskrg();
                	jam = jamskrg();
                	$('#ctgl_valid',ctkframe.document).html(today+" "+ jam);
                	$('#nomortransaksi',ctkframe.document).html(respon[1]);
                	$('#nomorref',ctkframe.document).html(respon[2]);
                	$('#nilai',ctkframe.document).html("Rp "+ num );
                	$('#nomoraccount',ctkframe.document).html(respon[3]);
                    window.ctkframe.print();
                    window.location.href = "/tariktunai";
                } else {
                    showinfo("Error : " + respon[0]);
                }
            }
            return false;
         } else {
            showinfo("Form dengan tanda * harus Diisi");
            hasil['focus'].focus();
            return false;
        }
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
            $('.nav-tabs li:eq(1)').removeClass('active').addClass('');
            $('.nav-tabs li:eq(0)').removeClass('').addClass('active');
            $('#tabs-2').removeClass('active').addClass('');
            $('#tabs-1').removeClass('').addClass('active');
            $("#form_tariktunai input[name='nomor_rekening']").val(obj.nomor_rekening);
            $("#form_tariktunai input[name='nama']").val(obj.nama);
            kec = ajak('base/nasabah/single_kecamatan','&kec='+obj.kecamatan);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+obj.kabupaten);
            var alamat = obj.alamat + " RT/RW " + obj.rtrw + " Kec. " + kec ;
            $("#form_tariktunai input[name='alamat']").val(alamat);
            $("#form_tariktunai input[name='kota']").val(kab + " / "+ obj.kode_pos);
            $("#form_tariktunai input[name='nama']").val(obj.nama);
            jurnal = ajak('setortunai/jurnal','&id='+obj.jenis_simpanan);
            //jurnal1 = ajak('setortunai/jurnalb','&id='+obj.jenis_simpanan);
            $("#form_tariktunai input[name='id_jurnal']").val(jurnal);
            //$("#form_tariktunai input[name='biaya_jurnal']").val(jurnal1);
            
            jumlah = ajak('tariktunai/saldo','&id='+obj.nomor_rekening +'&jurnal='+ jurnal);
            $("#form_tariktunai input[name='saldo']").val("Rp "+format_uang(jumlah));
            
            rata = ajak('setortunai/saldorata','&id='+obj.nomor_rekening +'&jurnal='+ jurnal);
            $("#form_tariktunai input[name='rata_rata']").val("Rp "+format_uang(rata));
            
            var ket = "Tarik Tunai "+obj.nama+ " ("+obj.nomor_rekening+")";
            $("#form_tariktunai input[name='ket']").val(ket);
            
            return false;
        });
        
    });
    warnatable();
    
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
