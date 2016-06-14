/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : monitor/listtabungan.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    var adminouth = 0;
    $.post("param/bmt/get_bmtinfo","id=1",
            function(obj){
               $('#bmttitle').html(obj['alldata'][0].nama+"<br>"+ obj['alldata'][0].kota +" - "+ obj['alldata'][0].namaProvinsi);
            }, "json");
    $('.searchact').click(function() {
        $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
        $('#tabs-1').removeClass('active').addClass('');
        $('#tabs-2').removeClass('').addClass('active');
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
            $("#form_tabungan input[name='nomor_rekening']").val(obj.nomor_rekening);
            $("#form_tabungan input[name='nama']").val(obj.nama);
            kec = ajak('base/nasabah/single_kecamatan','&kec='+obj.kecamatan);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+obj.kabupaten);
            var alamat = obj.alamat + " RT/RW " + obj.rtrw + " Kec. " + kec ;
            $("#form_tabungan input[name='alamat']").val(alamat);
            $("#form_tabungan input[name='kota']").val(kab + " / "+ obj.kode_pos);
            $("#form_tabungan input[name='nama']").val(obj.nama);
            $("#nasabah").html(obj.nomor_rekening+" / "+obj.nama);
            loaddatatabungan(obj.nomor_rekening);
            return false;
        });
        
    });
    function loaddatatabungan(norekening){
        //---- Tabel cair
         $("#tb_view").html("");
         $.post("monitor/listtabungan/get_transview","id="+ norekening,
             function(json){
                 var isi ="";
                 var debet = 0,kredit=0,saldo=0;
                     for(i = 0; i < json['alldata'].length; i++) {
                    	 if(json['alldata'][i].accounttrans_type == "02"){
                    		 debet = eval(json['alldata'][i].accounttrans_value);
                    		 kredit = 0;
                    		 saldo -= debet;
                    	 }else if(json['alldata'][i].accounttrans_type == "01"){
                    		 kredit = eval(json['alldata'][i].accounttrans_value);
                    		 debet = 0;
                    		 saldo += kredit;
                    	 }
                         isi += "<tr>"
                             + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ revDate(json['alldata'][i].accounttrans_date, '-') +"</td>" 
                             + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ json['alldata'][i].accounttrans_code +"</td>" 
                             + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(debet) +"</td>" 
                             + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(kredit) +"</td>" 
                             + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(saldo) +"</td>" 
                             + "</tr>";
                     }  
                     $("#tb_view").html(isi);
                 }, "json");
         return false;
     }
    $('.ptabDatadetail').click( function() {
    	//cetak
        $('#wrap-top',ctkframe.document).html($('#tbllaptabdetail').html());
        $('table',ctkframe.document).css({ "width":"100%", "font-size":"12", "margin":"0" });
        window.ctkframe.print();
        return false;
    });
    $('.cariDataTab').click( function() {
    	var isitglawal =  revDate($('#tgl1').val(),"-");
        var isitglakhir =  revDate($('#tgl2').val(),"-");
        if (Date.parse(isitglawal) > Date.parse(isitglakhir)) {
            showinfo("Tanggal Awal Harus lebih kecil dari Tanggal Akhir");
            return false;
        }
        if(($('#tgl2').val().substr(6, 4) - $('#tgl1').val().substr(6, 4)) > 0) {
            selisihx = (($('#tgl2').val().substr(3, 2)*1) + 12) - ($('#tgl1').val().substr(3, 2)*1)
            if(selisihx > 11) {
                showinfo("Selisih Bulan Periode max 12 bulan");
                return false;
            }
        }
        isitglperiode = cbulan($('#tgl1').val())+" s/d "+ cbulan($('#tgl2').val());
        $('#isitgl').html(isitglperiode);
        loaddataTab($("#tgl1").val(),$("#tgl2").val(),$("#f").val(),$("#if").val());
	});
    function loaddataTab(tgl1,tgl2,fv,ifv){
    	$("#tb_viewp").html("");
        $.post("monitor/listtabungan/get_dataview","tgl1="+ tgl1 +"&tgl2="+ tgl2 +"&fv="+ fv +"&ifv="+ ifv,
             function(json){
                 var isi ="";
                 var saldo = 0,total=0;
                 for(i = 0; i < json['alldata'].length; i++) {
                	 saldo = eval(json['alldata'][i].kredit) - eval(json['alldata'][i].debet);
                	 kab = ajak('base/nasabah/single_kabupaten','&kab='+json['alldata'][i].kabupaten);
                	 isi += "<tr>"
                		 + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ json['alldata'][i].nomor_rekening +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"left\">"+ json['alldata'][i].nama +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"left\">"+ json['alldata'][i].grouptabungan_nama +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"left\">"+ json['alldata'][i].nama_pegawai +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ revDate(json['alldata'][i].tgl_dibuka,'-') +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"left\">"+ json['alldata'][i].alamat +" "+ json['alldata'][i].rtrw +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"left\">"+ kab +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(saldo) +"</td>" 
                		 + "</tr>";
                	 total += eval(saldo);
                 }  
                 isi += "<tr>"
            		 + "<td style=\"border-top:1px solid #000;border-bottom:1px solid #000\" align=\"right\" colspan=\"7\">TOTAL</td>" 
            		 + "<td style=\"border-top:1px solid #000;border-bottom:1px solid #000\" align=\"right\">"+ format_uang(total)+"</td>" 
            		 + "</tr>";
                 $("#tb_view1").html(isi);
         }, "json");
         return false;
    }
    $('.ptabData').click( function() {
    	//cetak
        $('#wrap-top',ctkframe.document).html($('#tlaptabungan').html());
        $('table',ctkframe.document).css({ "width":"100%", "font-size":"12", "margin":"0" });
        window.ctkframe.print();
        return false;
    });
    
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
