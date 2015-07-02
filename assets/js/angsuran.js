/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : angsuran.js
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
 *  --------------------- setor angsuran -----------------------------------------
 */
    $("#form_angsuran input[name='tgl_transaksi']").val(isitglskrg());
    $('input[name="biaya"],input[name="nomor_jurnal"]').inputInteger();
    isi = ajak('pencairanpembiayaan/isi_wilayah');
    $("#form_angsuran select[name='wilayah_id']").html(isi);
    var count = ajak('pencairanpembiayaan/run_code');
    $("#form_angsuran input[name='nomor_jurnal']").val(count);
    $('.searchact').click(function() {
        $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
        $('#tabs-1').removeClass('active').addClass('');
        $('#tabs-2').removeClass('').addClass('active');
        
        return false;
    });
    $("#form_angsuran input[name='jumlah']").keyup(function() {
        $('#terbilang').html("");
         nilai = ($(this).val() * 1);
         var res = $(this).val().split(".");
         if (nilai < 0) {
            $('.jumlahket').html('Rp 0');
         } else {
        	 var nkoma;
        	 if(isNaN(res[1])){
        		 nkoma = "00";
        	 }else{
        		 nkoma = res[1];
        	 }
             $('.jumlahket').html('Rp ' + format_uang(res[0])+","+nkoma);
         }
     }).focus(function(){
         $(this).val($(this).val());
         
     }).blur(function(){
         if ($(this).val() != '') {
            //$(this).val(format_uang($(this).val()));
            //num = $(this).val().replace(/\s|\./g,'');
            num = $(this).val();
            var res = num.split("."); 
            nilai = terbilang(res[0]);
            nilai1 = terbilang(res[1]);
            var nkoma;
            if(isNaN(res[1])){
            	$('#terbilang').html(nilai+" "+"Rupiah");
            	nkoma = "00";
       	 	}else{
       	 		$('#terbilang').html(nilai+" koma "+ nilai1 +"Rupiah");
       	 		nkoma = res[1];
       	 	}
            $('.jumlahket').html('Rp ' + format_uang(res[0])+","+nkoma);
            
            totangs = eval($("#pokok").val()) + eval($("#margin").val());
            //pokok = Math.floor(eval(num) / eval(totangs) * eval($("#pokok").val()));
            //margin = Math.floor(eval(num) / eval(totangs) * eval($("#margin").val()));
            pokok = eval(num) / eval(totangs) * eval($("#pokok").val());
            margin = eval(num) / eval(totangs) * eval($("#margin").val());
            margin = margin.toFixed(2);
            pokok = pokok.toFixed(2);
            $("#pokokinfo").val(pokok);
            $("#margininfo").val(margin);
         }else{
        	 $("#pokokinfo").val(0);
             $("#margininfo").val(0);
         }
     });
     $("#form_angsuran input[name='biaya']").keyup(function() {
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
    
    $('#save_a').click(function() {
        hasil = validform("form_angsuran");
        if (hasil['isi'] != "invalid") {
        	num = $("#form_angsuran input[name='jumlah']").val();
            respon = ajak("angsuran/savetunai",$('#form_angsuran').serialize());
            respon = respon.split("#");
            if (respon[0] == "1") {
            	today = tglskrg1();
            	jam = jamskrg();
            	$('#ctgl_valid',ctkframe.document).html(today+""+ jam);
            	$('#nomortransaksi',ctkframe.document).html(respon[1]);
            	$('#nomorref',ctkframe.document).html($('#nomor_ref').val());
            	$('#nilai',ctkframe.document).html("Rp "+ num );
            	var nomoraccount = $('#nomor_rekening').val()+" "+$('#nama').val();
            	$('#nomoraccount',ctkframe.document).html(nomoraccount);
            	window.ctkframe.print();
            	window.location.href = "/angsuran";
            }else {
                showinfo("Error : " + respon[0]);
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
            jenis = ajak("pencairanpembiayaan/type","id="+ json['alldata'][i].jenis_pembiayaan);
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
            $("#form_angsuran input[name='nomor_rekening']").val(obj.nomor_rekening);
            $("#form_angsuran input[name='nama']").val(obj.nama);
            kec = ajak('base/nasabah/single_kecamatan','&kec='+obj.kecamatan);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+obj.kabupaten);
            var alamat = obj.alamat + " RT/RW " + obj.rtrw + " Kec. " + kec ;
            $("#form_angsuran input[name='alamat']").val(alamat);
            $("#form_angsuran input[name='kota']").val(kab + " / "+ obj.kode_pos);
            $("#form_angsuran input[name='nama']").val(obj.nama);
            
            var nameproduk = ajak('base/pembiayaan/produk_name','id='+obj.jenis_pembiayaan);
            $("#form_angsuran input[name='jenis_pembiayaan']").val(nameproduk);
            
            $.post("angsuran/jurnalall","id="+ obj.jenis_pembiayaan,
                function(json){
                    if(json['alldata'].length != 0){
                        for(i = 0; i < 1; i++) {
                            $("#form_angsuran input[name='id_jurnal']").val(json['alldata'][i].gl_produk);
                            $("#form_angsuran input[name='gl_administrasi']").val(json['alldata'][i].gl_administrasi);
                            $("#form_angsuran input[name='gl_marginditangguhkan']").val(json['alldata'][i].gl_marginditangguhkan);
                            $("#form_angsuran input[name='gl_pendapatanmargin']").val(json['alldata'][i].gl_pendapatanmargin);
                            $("#form_angsuran input[name='gl_diskon']").val(json['alldata'][i].gl_diskon);
                            $("#form_angsuran input[name='gl_pendapatanbagihasil']").val(json['alldata'][i].gl_pendapatanbagihasil);
                            $("#form_angsuran input[name='gl_bonusalqardh']").val(json['alldata'][i].gl_bonusalqardh);
                            $("#form_angsuran input[name='gl_pendapatanbagihasilmusy']").val(json['alldata'][i].gl_pendapatanbagihasilmusy);
                            $("#form_angsuran input[name='gl_activaijarah']").val(json['alldata'][i].gl_activaijarah);
                            $("#form_angsuran input[name='gl_pendapatanijarah']").val(json['alldata'][i].gl_pendapatanijarah);
                            $("#form_angsuran input[name='gl_asetistishna']").val(json['alldata'][i].gl_asetistishna);
                            $("#form_angsuran input[name='gl_pendapatanmarjinistishna']").val(json['alldata'][i].gl_pendapatanmarjinistishna);
                            $("#form_angsuran input[name='gl_diskonistishna']").val(json['alldata'][i].gl_diskonistishna);
                            $("#form_angsuran input[name='gl_pendapatankeuntungansalam']").val(json['alldata'][i].gl_pendapatankeuntungansalam);
                        }
                    }
                }, "json");
            $.post("angsuran/jumlahangsuran","id="+ obj.pembiayaan_id,
                function(json){
                    if(json['alldata'].length != 0){
                        for(i = 0; i < 1; i++) {
                            var jumlah = json['alldata'][i].jumlah;
                            var pokok = json['alldata'][i].pokok;
                            var margin = json['alldata'][i].margin;
                            $("#form_angsuran input[name='jumlah']").val(jumlah);
                            $("#form_angsuran input[name='pokok']").val(pokok);
                            $("#form_angsuran input[name='margin']").val(margin);
                            $("#form_angsuran input[name='pokokinfo']").val(pokok);
                            $("#form_angsuran input[name='margininfo']").val(margin);
                            $("#form_angsuran input[name='pembiayaandetail_id']").val(json['alldata'][i].pembiayaandetail_id);
                            //num = jumlah.replace(/\s|\./g,'');
                            var res = jumlah.split("."); 
                            nilai = terbilang(res[0]);
                            nilai1 = terbilang(res[1]);
                            $('.jumlahket').html('Rp ' + format_uang(res[0])+","+res[1]);
                            $('#terbilang').html(nilai+" koma "+ nilai1 +"Rupiah");
                            $("#form_angsuran input[name='ket']").val("ANGSURAN "+ nameproduk + " ( "+ obj.nama + " - " + obj.nomor_rekening + ")");
                            if(nameproduk == "MURABAHAH"){
                            	$("#pokokinfo").attr('readonly', 'readonly');
                                $("#margininfo").attr('readonly', 'readonly');
                            }else{
                            	$("#pokokinfo").removeAttr('readonly');
                                $("#margininfo").removeAttr('readonly');
                            }
                            
                            
                            
                        }
                    }
                }, "json");
            loadtrans(obj.nomor_rekening,$("#form_angsuran input[name='id_jurnal']").val());
            return false;
        });
        warnatable();
    });
    function loadtrans(norekening,idproduk){
       //---- Tabel trans
        $("#tb_view").html("");
        $.post("angsuran/get_transview","id="+ norekening +"&idproduk="+ idproduk,
            function(json){
                var isi ="";
                    for(i = 0; i < json['alldata'].length; i++) {
                        var jumlah = json['alldata'][i].accounttrans_value;
                        var res = jumlah.split("."); 
                        isi += "<tr>"
                            + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ json['alldata'][i].accounttrans_code +"</td>" 
                            + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ revDate(json['alldata'][i].accounttrans_date, '-') +"</td>" 
                            + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(res[0])+"."+res[1] +"</td>" 
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
