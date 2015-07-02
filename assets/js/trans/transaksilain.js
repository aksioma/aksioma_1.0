/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : trans/transaksilain.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    var adminouth = 0;
/*
 *  --------------------- selisih kurang -----------------------------------------
 */
    isi = ajak('param/listakun/isi_akun1');
    $("#jurnal1").html(isi);
    
    $("#form_selisihkurang input[name='tgl_transaksi']").val(isitglskrg());
    $('input[name="jumlah"],input[name="biaya"],input[name="nomor_jurnal"]').inputInteger();
    $("#form_selisihkurang input[name='jumlah']").keyup(function() {
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
    $('#save_a').click(function() {
        hasil = validform("form_selisihkurang");
        if (hasil['isi'] != "invalid") {
            num = $("#form_selisihkurang input[name='jumlah']").val();
            jumlah = num.replace(/\s|\./g,'');
            respon = ajak("trans/transaksilain/selisih",$('#form_selisihkurang').serialize());
            if (respon == "1") {
                alert("Transaksi sebesar Rp "+ num + " Berhasil");
                window.location.href = "trans/selisihkurang";
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
