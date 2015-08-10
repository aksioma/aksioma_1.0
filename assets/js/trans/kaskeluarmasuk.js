/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : trans/kaskeluarmasuk.js
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
 *  --------------------- kas keluar -----------------------------------------
 */
    $("#form_kaskeluar input[name='tgl_transaksi']").val(isitglskrg());
    $('input[name="jumlah"],input[name="biaya"],input[name="nomor_jurnal"]').inputInteger();
    $("#form_kaskeluar input[name='jumlah']").keyup(function() {
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
    $('#save_ab').click(function() {
        hasil = validform("form_kaskeluar");
        if (hasil['isi'] != "invalid") {
            num = $("#form_kaskeluar input[name='jumlah']").val();
            jumlah = num.replace(/\s|\./g,'');
            respon = ajak("trans/kaskeluarmasuk/tarikkas",$('#form_kaskeluar').serialize());
            if (respon == "1") {
                alert("Selisih Kas Rp "+ num + " Berhasil");
                window.location.href = "trans/kaskeluarmasuk";
            } else if(respon == "1062") {
                showinfo("No. Ref sudah ada");
                return false;
            }else {
                showinfo("Error : " + respon);
                return false;
            }
         } else {
            showinfo("Form dengan tanda * harus Diisi");
            hasil['focus'].focus();
            return false;
        }
    });
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
