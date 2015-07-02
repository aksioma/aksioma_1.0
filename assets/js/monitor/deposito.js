/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : monitor/deposito.js
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
    
    $('.cariDataDep').click( function() {
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
        loaddataDep($("#tgl1").val(),$("#tgl2").val(),$("#f").val(),$("#if").val());
	});
    function loaddataDep(tgl1,tgl2,fv,ifv){
    	$("#tb_viewp").html("");
        $.post("monitor/deposito/get_dataview","tgl1="+ tgl1 +"&tgl2="+ tgl2 +"&fv="+ fv +"&ifv="+ ifv,
             function(json){
                 var isi ="";
                 var saldo = 0,total=0;
                 for(i = 0; i < json['alldata'].length; i++) {
                	 kab = ajak('base/nasabah/single_kabupaten','&kab='+json['alldata'][i].kabupaten);
                	 isi += "<tr>"
                		 + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ json['alldata'][i].nomor_rekening +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"left\">"+ json['alldata'][i].nama +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"left\">"+ json['alldata'][i].groupdeposito_nama +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ revDate(json['alldata'][i].tgl_dibuka,'-') +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ revDate(json['alldata'][i].jatuh_tempo,'-') +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"left\">"+ json['alldata'][i].alamat +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"left\">"+ kab +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(json['alldata'][i].nominal) +"</td>" 
                		 + "</tr>";
                	 total += eval(json['alldata'][i].nominal);
                 }  
                 isi += "<tr>"
            		 + "<td style=\"border-top:1px solid #000;border-bottom:1px solid #000\" align=\"right\" colspan=\"7\">TOTAL</td>" 
            		 + "<td style=\"border-top:1px solid #000;border-bottom:1px solid #000\" align=\"right\">"+ format_uang(total)+"</td>" 
            		 + "</tr>";
                 $("#tb_view1").html(isi);
         }, "json");
         return false;
    }
    $('.pdeData').click( function() {
    	//cetak
        $('#wrap-top',ctkframe.document).html($('#tlapdeposito').html());
        $('table',ctkframe.document).css({ "width":"100%", "font-size":"10", "margin":"0" });
        window.ctkframe.print();
        return false;
    });
    
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
