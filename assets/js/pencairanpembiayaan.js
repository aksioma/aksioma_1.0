/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : pencairanpembiayaan.js
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
    $("#form_pencairanpembiayaan input[name='tgl_transaksi']").val(isitglskrg());
    $('input[name="jumlah"],input[name="biaya"],input[name="nomor_jurnal"]').inputInteger();
    isi = ajak('pencairanpembiayaan/isi_wilayah');
    $("#form_pencairanpembiayaan select[name='wilayah_id']").html(isi);
    var count = ajak('pencairanpembiayaan/run_code');
    $("#form_pencairanpembiayaan input[name='nomor_jurnal']").val(count);
    $('.searchact').click(function() {
        $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
        $('#tabs-1').removeClass('active').addClass('');
        $('#tabs-2').removeClass('').addClass('active');
        
        return false;
    });
    $("#form_pencairanpembiayaan input[name='jumlah']").keyup(function() {
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
     $("#form_pencairanpembiayaan input[name='biaya']").keyup(function() {
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
    //dialog login
    $('#dialog-login').dialog({autoOpen: false,width: 380,modal: true,
            buttons: {
                        "Ok": function() {
                            hasil = validform("form_login");
                            if (hasil['isi'] != "invalid") {
                            	num = $("#form_pencairanpembiayaan input[name='jumlah']").val();
                                respon = ajak("pencairanpembiayaan/login",$('#form_login').serialize());
                                if (respon == "valid") {
                                    respon = ajak("pencairanpembiayaan/savetunai",$('#form_pencairanpembiayaan').serialize());
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
                                         window.location.href = "/pencairanpembiayaan";
                                    } else {
                                        showinfo("Error : " + respon[0]);
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
    $('#savetarik').click(function() {
        hasil = validform("form_pencairanpembiayaan");
        if (hasil['isi'] != "invalid") {
            num = $("#form_pencairanpembiayaan input[name='jumlah']").val();
            jumlah = num.replace(/\s|\./g,'');
            limit = ajak('pencairanpembiayaan/limittarik','&nilai='+jumlah);
            if(limit == "no"){
                showinfo("Yang bisa Dropping adalah Teller atau yg di beri Otoritas");
                return false;
            }else if(limit == "0"){
                //alert("otoritas");
                $(".infonya").hide();
                $('#dialog-login').dialog('option', 'title',  'Otoritas' ).dialog('open');
                return false;
            }else{
                respon = ajak("pencairanpembiayaan/savetunai",$('#form_pencairanpembiayaan').serialize());
                respon = respon.split("#");
                if (respon[0] == "1") {
                    //alert("Dropping sebesar Rp "+ num + " Berhasil");
                	today = tglskrg();
                	jam = jamskrg();
                	$('#ctgl_valid',ctkframe.document).html(today+" "+ jam);
                	$('#nomortransaksi',ctkframe.document).html(respon[1]);
                	$('#nomorref',ctkframe.document).html(respon[2]);
                	$('#nilai',ctkframe.document).html("Rp "+ num );
                	$('#nomoraccount',ctkframe.document).html(respon[3]);
                    window.ctkframe.print();
                    window.location.replace("pencairanpembiayaan");
                } else {
                    showinfo("Error : " + respon[0]);
                }
            }
         } else {
            showinfo("Form dengan tanda * harus Diisi");
            hasil['focus'].focus();
            return false;
        }
    });
    
    //---- Tabel pembiayaan
    $("#table_datapembiayaan").mastertable({
        urlGet:"base/pembiayaan/get_pembiayaan",
        flook:"nomor_rekening"
    },
    function(hal,juml,json) {
        var isi="";
        var jenis="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "d" + json['alldata'][i].pembiayaan_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            jenis = ajak("pencairanpembiayaan/type","id="+ json['alldata'][i].jenis_pembiayaan 	);
            managejab = "<img  class=\"cadd\" title=\"Add\" src=\"assets/images/addicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nomor_rekening + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama + "</td>"
                + "<td align=\"left\">" + jenis + "</td>"
                + "<td align=\"right\">" + format_uang(json['alldata'][i].jumlah_pengajuan) + "</td>"
                + "<td align=\"center\">" + revDate(json['alldata'][i].tgl_dibuka,'-') + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].pembiayaan_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- 
        $('.cadd').click( function() {
            $(".infonya").hide();
            obj = jAmbil("d" + $(this).parent().next().text());
            $('.nav-tabs li:eq(1)').removeClass('active').addClass('');
            $('.nav-tabs li:eq(0)').removeClass('').addClass('active');
            $('#tabs-2').removeClass('active').addClass('');
            $('#tabs-1').removeClass('').addClass('active');
            
            jenis = ajak("pencairanpembiayaan/type","id="+ obj.jenis_pembiayaan);
            $("#iddrop").html(jenis);
            $("#form_pencairanpembiayaan input[name='nomor_rekening']").val(obj.nomor_rekening);
            $("#form_pencairanpembiayaan input[name='nama']").val(obj.nama);
            kec = ajak('base/nasabah/single_kecamatan','&kec='+obj.kecamatan);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+obj.kabupaten);
            var alamat = obj.alamat + " RT/RW " + obj.rtrw + " Kec. " + kec ;
            $("#form_pencairanpembiayaan input[name='alamat']").val(alamat);
            $("#form_pencairanpembiayaan input[name='kota']").val(kab + " / "+ obj.kode_pos);
            $("#form_pencairanpembiayaan input[name='nama']").val(obj.nama);
            var plafon = 0;
            var margin = 0;
            var nameproduk = ajak('base/pembiayaan/produk_name','id='+obj.jenis_pembiayaan);
            if(nameproduk == "MURABAHAH"){
                plafon = obj.harga_pokok;
                margin = obj.marjin;
            }else if(nameproduk == "MUDHARABAH"){
                plafon = obj.modal;
            }else if(nameproduk == "AL-QARDH"){
                plafon = obj.pinjaman;
            }else if(nameproduk == "MUSYARAKAH"){
                plafon = obj.modal;
            }
            $("#form_pencairanpembiayaan input[name='plafon']").val(format_uang(plafon));
            $("#form_pencairanpembiayaan input[name='margin']").val(format_uang(margin));
            $("#form_pencairanpembiayaan input[name='jenis_pembiayaan']").val(nameproduk);
            
            jurnal = ajak('pencairanpembiayaan/jurnal','&id='+obj.jenis_pembiayaan);
            $("#form_pencairanpembiayaan input[name='id_jurnal']").val(jurnal);
            
            sisaplafon = ajak("pencairanpembiayaan/sisaplafon","id="+ obj.nomor_rekening);
            sisaakhir = eval(plafon) - eval(sisaplafon);
            $("#form_pencairanpembiayaan input[name='sisa_plafon']").val(format_uang(sisaakhir));
            if(sisaakhir != 0){
                $("#form_pencairanpembiayaan input[name='jumlah']").val(plafon);
                $('.jumlahket').html('Rp ' + format_uang(plafon));
                num = plafon.replace(/\s|\./g,'');
                nilai = terbilang(num);
                $('#terbilang').html(nilai+" Rupiah");
                loadtrans(obj.nomor_rekening);
                $("#form_pencairanpembiayaan input[name='ket']").val("DROPPING "+ nameproduk + " ( "+ obj.nama + " - " + obj.nomor_rekening + ")");
            }
            return false;
        });
        warnatable();
    });
    function loadtrans(norekening){
       //---- Tabel cair
        $("#tb_view").html("");
        $.post("pencairanpembiayaan/get_transview","id="+ norekening,
            function(json){
                var isi ="";
                    for(i = 0; i < json['alldata'].length; i++) {
                        isi += "<tr>"
                            + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ json['alldata'][i].accounttrans_code +"</td>" 
                            + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ revDate(json['alldata'][i].accounttrans_date, '-') +"</td>" 
                            + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(json['alldata'][i].accounttrans_value) +"</td>" 
                            + "</tr>";
                    }  
                    $("#tb_view").html(isi);
                }, "json");
        return false;
    }
    
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
