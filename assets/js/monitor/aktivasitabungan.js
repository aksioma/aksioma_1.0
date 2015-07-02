/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : monitor/aktivasitabungan.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    var adminouth = 0;
/*
 *  --------------------- aktivasitabungan -----------------------------------------
 */
    
    $('.searchact').click(function() {
        $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
        $('#tabs-1').removeClass('active').addClass('');
        $('#tabs-2').removeClass('').addClass('active');
        return false;
    });
    $('#save').click(function() {
        hasil = validform("form_aktivasi");
        if (hasil['isi'] != "invalid") {
            respon = ajak("monitor/aktivasitabungan/saveaktivasi",$('#form_aktivasi').serialize() +"&active=" + $("#active:checked").length);
            if (respon == "1") {
                
            } else {
                showinfo("Error : " + respon);
            }
         } else {
            showinfo("Form dengan tanda * harus Diisi");
            hasil['focus'].focus();
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
            $("#form_aktivasi input[name='nomor_rekening']").val(obj.nomor_rekening);
            $("#form_aktivasi input[name='nama']").val(obj.nama);
            kec = ajak('base/nasabah/single_kecamatan','&kec='+obj.kecamatan);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+obj.kabupaten);
            var alamat = obj.alamat + " RT/RW " + obj.rtrw + " Kec. " + kec ;
            $("#form_aktivasi input[name='alamat']").val(alamat);
            $("#form_aktivasi input[name='kota']").val(kab + " / "+ obj.kode_pos);
            $("#form_aktivasi input[name='nama']").val(obj.nama);
            jumlah = ajak('setortunai/saldo','&id='+obj.nomor_rekening);
            $("#form_aktivasi input[name='saldo']").val("Rp "+format_uang(jumlah));
            loadriwayat(obj.nomor_rekening);
            
            return false;
        });
        
    });
    function loadriwayat(norekening){
       //---- Tabel cair
        $("#tb_view").html("");
        $.post("monitor/aktivasitabungan/get_riwayatview","id="+ norekening,
            function(json){
                var isi ="";
                    for(i = 0; i < json['alldata'].length; i++) {
                        isi += "<tr>"
                            + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ revDate(json['alldata'][i].tgl_proses, '-') +"</td>" 
                            + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ json['alldata'][i].nomor_ref +"</td>" 
                            + "<td style=\"border-top:1px solid #000\" align=\"left\">"+ json['alldata'][i].alasan +"</td>" 
                            + "</tr>";
                    }  
                    $("#tb_view").html(isi);
                }, "json");
        return false;
    }
    warnatable();
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
