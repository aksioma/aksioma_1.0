/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : lapmutasi.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    $('.jclock').jclock({format: '%A, %d %B %Y - %H:%M:%S %P'});
    var adminouth = 0;
    //jSimpan("tlaptranstabungan", $('#tlaptranstabungan').html());
/*
 *  --------------------- mutasi tabungan -----------------------------------------
 */
    $('#table_laptab button:eq(0)').click(function() {
        var isitglawal =  revDate($('#tgllaptab1').val(),"-");
        var isitglakhir =  revDate($('#tgllaptab2').val(),"-");
        if (Date.parse(isitglawal) > Date.parse(isitglakhir)) {
            showinfo("Tanggal Awal Harus lebih kecil dari Tanggal Akhir");
            return false;
        }
        if(($('#tgllaptab2').val().substr(6, 4) - $('#tgllaptab1').val().substr(6, 4)) > 0) {
            selisihx = (($('#tgllaptab2').val().substr(3, 2)*1) + 12) - ($('#tgllaptab1').val().substr(3, 2)*1)
            if(selisihx > 11) {
                showinfo("Selisih Bulan Periode max 12 bulan");
                return false;
            }
        }
        $('#tlaptranstabungan').html(jAmbil("tlaptranstabungan"));
        $.post("lapmutasi/get_transaksitabungan","tglawal=" + $('#tgllaptab1').val() + "&tglakhir=" + $('#tgllaptab2').val(),
            function(obj){
                    var dtTAB ="", totsaldoawal=0, totmutasidebet=0, totmutasikredit=0, totsaldoakhir=0;
                    for(i = 0; i < obj['alldata'].length; i++) {
                        saldon = ajak('lapmutasi/saldonow','&tglawal='+ $('#tgllaptab1').val() +"&id="+ obj['alldata'][i].nomor_rekening);
                        saldoawal = saldon * 1;
                        mutasidebet = obj['alldata'][i].mutasi_debet * 1;
                        mutasikredit = obj['alldata'][i].mutasi_kredit * 1;
                        saldoakhir = (saldoawal + mutasikredit) - mutasidebet;
                        totsaldoawal += saldoawal;
                        totmutasidebet += mutasidebet;
                        totmutasikredit += mutasikredit;
                        totsaldoakhir += saldoakhir;
                        rc = (i%2 == 0) ? "#fff" : "#F2F2F2";
                        dtTAB += "<tr style=\"background:" + rc + ";\">"
                             + "<td align=\"center\">" + (i + 1) + "</td>"
                             + "<td align=\"center\">" + obj['alldata'][i].nomor_rekening + "</td>"
                             + "<td align=\"center\">" + obj['alldata'][i].nama + "</td>"
                             + "<td align=\"left\">" + obj['alldata'][i].grouptabungan_nama + "</td>"
                             + "<td align=\"right\">" + format_uang(saldoawal) + "</td>"
                             + "<td align=\"right\">" + format_uang(mutasidebet) + "</td>"
                             + "<td align=\"right\">" + format_uang(mutasikredit) + "</td>"
                             + "<td align=\"right\">" + format_uang(saldoakhir) + "</td>"
                             + "</tr>";
                    }
                    dtTAB += "<tr style=\"background:#EFF1F1\"><td colspan=\"4\" style=\"border-top:1px solid #000\" align=\"right\"><b>TOTAL</b></td><td align=\"right\" style=\"border-top:1px solid #000\"><b>" + format_uang(totsaldoawal) + "</b></td><td align=\"right\" style=\"border-top:1px solid #000\"><b>" + format_uang(totmutasidebet) + "</b></td><td align=\"right\" style=\"border-top:1px solid #000\"><b>" + format_uang(totmutasikredit) + "</b></td><td align=\"right\" style=\"border-top:1px solid #000\"><b>" + format_uang(totsaldoakhir) + "</b></td></tr>"
                    $('#tlaptranstabungan tbody').html(dtTAB);
                    
                }, "json");
        isitglperiode = ($('#tgllaptab1').val() == $('#tgllaptab2').val()) ? cbulan($('#tgllaptab1').val()) : cbulan($('#tgllaptab1').val()) + "&nbsp;&nbsp;s/d&nbsp;&nbsp;" + cbulan($('#tgllaptab2').val());
        $('#isitgltab').html(isitglperiode);
        
    });
    $('#table_laptab button:eq(1)').click(function() {
        //cetak
        $('#wrap-top',ctkframe.document).html($('#tlaptranstabungan').html());
        $('table',ctkframe.document).css({ "width":"99%", "font-size":"12", "margin":"0" });
        window.ctkframe.print();
        return false;
    });
/*
 *  --------------------- mutasi deposito -----------------------------------------
 */
    $('#table_lapdeposito button:eq(0)').click(function() {
        var isitglawal =  revDate($('#tgllapdep1').val(),"-");
        var isitglakhir =  revDate($('#tgllapdep2').val(),"-");
        if (Date.parse(isitglawal) > Date.parse(isitglakhir)) {
            showinfo("Tanggal Awal Harus lebih kecil dari Tanggal Akhir");
            return false;
        }
        if(($('#tgllapdep2').val().substr(6, 4) - $('#tgllapdep1').val().substr(6, 4)) > 0) {
            selisihx = (($('#tgllapdep2').val().substr(3, 2)*1) + 12) - ($('#tgllapdep1').val().substr(3, 2)*1)
            if(selisihx > 11) {
                showinfo("Selisih Bulan Periode max 12 bulan");
                return false;
            }
        }
        $('#tlaptransdeposito').html(jAmbil("tlaptransdeposito"));
        $.post("lapmutasi/get_transaksideposito","tglawal=" + $('#tgllapdep1').val() + "&tglakhir=" + $('#tgllapdep2').val(),
            function(obj){
                    var dtTAB ="", totsaldoawal=0, totmutasidebet=0, totmutasikredit=0, totsaldoakhir=0;
                    for(i = 0; i < obj['alldata'].length; i++) {
                        saldon = ajak('lapmutasi/saldonow','&tglawal='+ $('#tgllapdep1').val() +"&id="+ obj['alldata'][i].nomor_rekening);
                        saldoawal = saldon * 1;
                        mutasidebet = obj['alldata'][i].mutasi_debet * 1;
                        mutasikredit = obj['alldata'][i].mutasi_kredit * 1;
                        saldoakhir = (saldoawal + mutasikredit) - mutasidebet;
                        totsaldoawal += saldoawal;
                        totmutasidebet += mutasidebet;
                        totmutasikredit += mutasikredit;
                        totsaldoakhir += saldoakhir;
                        rc = (i%2 == 0) ? "#fff" : "#F2F2F2";
                        dtTAB += "<tr style=\"background:" + rc + ";\">"
                             + "<td align=\"center\">" + (i + 1) + "</td>"
                             + "<td align=\"center\">" + obj['alldata'][i].nomor_rekening + "</td>"
                             + "<td align=\"center\">" + obj['alldata'][i].nama + "</td>"
                             + "<td align=\"left\">" + obj['alldata'][i].groupdeposito_nama + "</td>"
                             + "<td align=\"right\">" + format_uang(saldoawal) + "</td>"
                             + "<td align=\"right\">" + format_uang(mutasidebet) + "</td>"
                             + "<td align=\"right\">" + format_uang(mutasikredit) + "</td>"
                             + "<td align=\"right\">" + format_uang(saldoakhir) + "</td>"
                             + "</tr>";
                    }
                    dtTAB += "<tr style=\"background:#EFF1F1\"><td colspan=\"4\" style=\"border-top:1px solid #000\" align=\"right\"><b>TOTAL</b></td><td align=\"right\" style=\"border-top:1px solid #000\"><b>" + format_uang(totsaldoawal) + "</b></td><td align=\"right\" style=\"border-top:1px solid #000\"><b>" + format_uang(totmutasidebet) + "</b></td><td align=\"right\" style=\"border-top:1px solid #000\"><b>" + format_uang(totmutasikredit) + "</b></td><td align=\"right\" style=\"border-top:1px solid #000\"><b>" + format_uang(totsaldoakhir) + "</b></td></tr>"
                    $('#tlaptransdeposito tbody').html(dtTAB);
                }, "json");
        isitglperiode = ($('#tgllapdep1').val() == $('#tgllapdep2').val()) ? cbulan($('#tgllapdep1').val()) : cbulan($('#tgllapdep1').val()) + "&nbsp;&nbsp;s/d&nbsp;&nbsp;" + cbulan($('#tgllapdep2').val());
        $('#isitgldep').html(isitglperiode);
        
    });
    $('#table_lapdeposito button:eq(1)').click(function() {
        //cetak
        $('#wrap-top',ctkframe.document).html($('#tlaptransdeposito').html());
        $('table',ctkframe.document).css({ "width":"99%", "font-size":"12", "margin":"0" });
        window.ctkframe.print();
        return false;
    });
/*
 *  --------------------- mutasi pembiayaan -----------------------------------------
 */
    $('#table_lappemb button:eq(0)').click(function() {
        var isitglawal =  revDate($('#tgllappemb1').val(),"-");
        var isitglakhir =  revDate($('#tgllappemb2').val(),"-");
        if (Date.parse(isitglawal) > Date.parse(isitglakhir)) {
            showinfo("Tanggal Awal Harus lebih kecil dari Tanggal Akhir");
            return false;
        }
        if(($('#tgllappemb2').val().substr(6, 4) - $('#tgllappemb1').val().substr(6, 4)) > 0) {
            selisihx = (($('#tgllappemb2').val().substr(3, 2)*1) + 12) - ($('#tgllappemb1').val().substr(3, 2)*1)
            if(selisihx > 11) {
                showinfo("Selisih Bulan Periode max 12 bulan");
                return false;
            }
        }
        $('#tlaptranspemb').html(jAmbil("tlaptranspemb"));
        $.post("lapmutasi/get_transaksipembiayaan","tglawal=" + $('#tgllappemb1').val() + "&tglakhir=" + $('#tgllappemb2').val(),
            function(obj){
                    var dtTAB ="", totsaldoawal=0, totmutasidebet=0, totmutasikredit=0, totsaldoakhir=0;
                    for(i = 0; i < obj['alldata'].length; i++) {
                        saldon = ajak('lapmutasi/saldonow','&tglawal='+ $('#tgllappemb1').val() +"&id="+ obj['alldata'][i].nomor_rekening);
                        saldoawal = saldon * 1;
                        mutasidebet = obj['alldata'][i].mutasi_debet * 1;
                        mutasikredit = obj['alldata'][i].mutasi_kredit * 1;
                        saldoakhir = (saldoawal + mutasidebet) - mutasikredit;
                        totsaldoawal += saldoawal;
                        totmutasidebet += mutasidebet;
                        totmutasikredit += mutasikredit;
                        totsaldoakhir += saldoakhir;
                        rc = (i%2 == 0) ? "#fff" : "#F2F2F2";
                        dtTAB += "<tr style=\"background:" + rc + ";\">"
                             + "<td align=\"center\">" + (i + 1) + "</td>"
                             + "<td align=\"center\">" + obj['alldata'][i].nomor_rekening + "</td>"
                             + "<td align=\"left\">" + obj['alldata'][i].nama + "</td>"
                             + "<td align=\"left\">" + obj['alldata'][i].grouppembiayaan_nama + "</td>"
                             + "<td align=\"right\">" + format_uang(saldoawal) + "</td>"
                             + "<td align=\"right\">" + format_uang(mutasidebet) + "</td>"
                             + "<td align=\"right\">" + format_uang(mutasikredit) + "</td>"
                             + "<td align=\"right\">" + format_uang(saldoakhir) + "</td>"
                             + "</tr>";
                    }
                    dtTAB += "<tr style=\"background:#EFF1F1\"><td colspan=\"4\" style=\"border-top:1px solid #000\" align=\"right\"><b>TOTAL</b></td><td align=\"right\" style=\"border-top:1px solid #000\"><b>" + format_uang(totsaldoawal) + "</b></td><td align=\"right\" style=\"border-top:1px solid #000\"><b>" + format_uang(totmutasidebet) + "</b></td><td align=\"right\" style=\"border-top:1px solid #000\"><b>" + format_uang(totmutasikredit) + "</b></td><td align=\"right\" style=\"border-top:1px solid #000\"><b>" + format_uang(totsaldoakhir) + "</b></td></tr>"
                    $('#tlaptranspemb tbody').html(dtTAB);
                }, "json");
        isitglperiode = ($('#tgllappemb1').val() == $('#tgllappemb2').val()) ? cbulan($('#tgllappemb1').val()) : cbulan($('#tgllappemb1').val()) + "&nbsp;&nbsp;s/d&nbsp;&nbsp;" + cbulan($('#tgllappemb2').val());
        $('#isitglpemb').html(isitglperiode);
        
    });
    $('#tlaptranspemb button:eq(1)').click(function() {
        //cetak
        $('#wrap-top',ctkframe.document).html($('#tlaptranspemb').html());
        $('table',ctkframe.document).css({ "width":"99%", "font-size":"12", "margin":"0" });
        window.ctkframe.print();
        return false;
    });
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
