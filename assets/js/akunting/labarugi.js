/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : akunting/labarugi.js
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
/*
 *  --------------------- labarugi -----------------------------------------
 */
    $('#table_laplaba button:eq(0)').click(function() {
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
        isitglperiode = ($('#tgllap1').val() == $('#tgllap2').val()) ? cbulan($('#tgllap1').val()) : cbulan($('#tgllap1').val()) + "&nbsp;&nbsp;s/d&nbsp;&nbsp;" + cbulan($('#tgllap2').val());
        $('#isitgl').html(isitglperiode);
        $('#tlaplaba').html(jAmbil("tlaplaba"));
        if($('#type').val() == "1"){
            res1 = ajak("akunting/labarugi/getCOAjurnal",'&id=5,6,7&tglawal='+ $('#tgllap1').val() +'&tglakhir='+ $('#tgllap2').val());
        }else{
            res1 = ajak("akunting/labarugi/getCOAjurnaldetail",'&id=5,6,7&tglawal='+ $('#tgllap1').val() +'&tglakhir='+ $('#tgllap2').val());
        }
        $('#tlaplaba tbody').html(res1);
    });
    $('#table_laplaba button:eq(1)').click(function() {
        //cetak
        $('#wrap-top',ctkframe.document).html($('#tlaplaba').html());
        $('table',ctkframe.document).css({ "width":"99%", "font-size":"12", "margin":"0" });
        window.ctkframe.print();
        return false;
    });
    
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
