/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : trans/reportteller.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    var adminouth = 0;
    $('.infoproses').hide();
/*
 *  --------------------- reportsemuateller -----------------------------------------
 */
    saldo = ajak('trans/reportteller/saldokhasanah');
    $("#info").val(format_uang(saldo));
    isi = ajak('trans/reportteller/isi_user');
    $("#form_reportteller select[name='user']").html(isi);
    $("#tgllap1").val(isitglskrg());
    $("#tgllap2").val(isitglskrg());
    $('#showlap').click(function() {
    	$('.infoproses').show();
        var isitglawal =  revDate($('#tgllap1').val(),"-");
        var isitglakhir =  revDate($('#tgllap2').val(),"-");
        if (Date.parse(isitglawal) > Date.parse(isitglakhir)) {
            showinfo("Tanggal Awal Harus lebih kecil dari Tanggal Akhir");
            return false;
        }
        if(($('#tgllap2').val().substr(6, 4) - $('#tgllap1').val().substr(6, 4)) > 0) {
            selisihx = (($('#tgllap2').val().substr(3, 2)*1) + 12) - ($('#tgllap1').val().substr(3, 2)*1)
            if(selisihx > 11) {
                showinfo("Selisih Bulan Periode max 12 bulan");
                return false;
            }
        }
        $('#tlaptransteller').html(jAmbil("tlaptransteller"));
        respon = ajak('trans/reportteller/viewtransaksihead',"tglawal=" + $('#tgllap1').val() + "&tglakhir=" + $('#tgllap2').val());
        hsl = respon.split("**");
        $.post("trans/reportteller/viewtransaksi","tglawal=" + $('#tgllap1').val() + "&tglakhir=" + $('#tgllap2').val(),
            function(obj){
                    var title ="",totmutasidebet=0, totmutasikredit=0,totmutasisaldo=0,titleh="", ptitle="";
                    title += hsl[1];
                    totmutasisaldo = eval(hsl[0]) * 1;
                    for(i = 0; i < obj['alldata'].length; i++) {
                        mutasidebet = obj['alldata'][i].mutasi_debet * 1;
                        mutasikredit = obj['alldata'][i].mutasi_kredit * 1;
                        totmutasidebet += mutasidebet;
                        totmutasikredit += mutasikredit;
                        if(mutasidebet != null){
                        	totmutasisaldo -= mutasidebet;
                        }else if(mutasikredit != null){
                        	totmutasisaldo += mutasikredit;
                        }
                        
                        rc = (i%2 == 0) ? "#fff" : "#F2F2F2";
                        title += "<tr style=\"background:" + rc + ";\">"
                             + "<td align=\"center\">" + obj['alldata'][i].accounttrans_code + "</td>"
                             + "<td align=\"center\">" + obj['alldata'][i].accounttrans_user + "</td>"
                             + "<td align=\"center\">" + revDate(obj['alldata'][i].accounttrans_date,"-") + "</td>"
                             + "<td align=\"left\">" + obj['alldata'][i].accounttrans_desc + "</td>"
                             + "<td align=\"right\">" + format_uang(mutasikredit) + ",-</td>"
                             + "<td align=\"right\">" + format_uang(mutasidebet) + ",-</td>"
                             + "<td align=\"right\">" + format_uang(totmutasisaldo) + ",-</td>"
                             + "</tr>";
                    }
                    title += "<tr style=\"background:#EFF1F1\"><td colspan=\"4\" style=\"border-top:1px solid #000\" align=\"right\"><b>TOTAL</b></td><td align=\"right\" style=\"border-top:1px solid #000\"><b>" + format_uang(totmutasikredit) + ",-</b></td><td align=\"right\" style=\"border-top:1px solid #000\"><b>" + format_uang(totmutasidebet) + ",-</b></td><td align=\"right\" style=\"border-top:1px solid #000\"><b>" + format_uang(totmutasisaldo) + ",-</b></td></tr>"
                    $('#tlaptransteller tbody').html(title);
                    $('.infoproses').hide();
                }, "json");
                
        isitglperiode = ($('#isitgllap').val() == $('#tgllap2').val()) ? cbulan($('#tgllap1').val()) : cbulan($('#tgllap1').val()) + "&nbsp;&nbsp;s/d&nbsp;&nbsp;" + cbulan($('#tgllap2').val());
        $('#isitgllap').html(isitglperiode);
       return false;
    });
    
/*
 *  ----------------------- RESET -------------------------------
 */ 
    $('#table_lapteller button:eq(1)').click(function() {
        //cetak
        $('#wrap-top',ctkframe.document).html($('#tlaptransteller').html());
        $('table',ctkframe.document).css({ "width":"99%", "font-size":"12", "margin":"0" });
        window.ctkframe.print();
        return false;
    });
    $(".reset").click();
});
