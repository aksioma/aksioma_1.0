/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : akunting/jurnal.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    var adminouth = 0;

    var allorder = new Array();
/*
 *  --------------------- jurnal -----------------------------------------
 */

    $('#jumlah').inputInteger();

    $("#form_jurnal input[name='accounttrans_date']").val(isitglskrg());

    isi = ajak('param/listakun/isi_akun1');

    $("#jurnal1").html(isi);

    $("#jurnal2").html(isi);

    var kredit = 0;

    var debet = 0;

    $('#addjurnalrow').click( function() {
        num = $("#jumlah").val();
        jumlah = num.replace(/\s|\./g,'');
        if(jumlah == 0){
            alert('Jumlah tidak boleh kosong');
            return false;

        }else if($("#jurnal1").val() == "----------"){
            alert('Kode Jurnal tidak boleh kosong');
            return false;
        }else{
            kredit = 0;
            debet = 0;
            var krediti = 0;
            var debeti = 0;
            var id = $('.viewadds').length;
            var i = 0;
            for(var i=0;i<=id;i++){
                var id1 = i;
            }
            var infdk = $("#accounttrans_code").val();
            var juml = $("#jumlah").val();
            
            if(infdk =="DEBET"){
                debeti = juml;
            }else if(infdk =="KREDIT"){
                krediti = juml;
            }
            var ketval = $("#ket").val();
            var account = $("#jurnal1").val();
            respon = ajak('akunting/jurnal/infoaccount', "id="+account);
            var accountket = respon;
            $("#jurnalval").val($("#jurnal1").val());
            var isi = '<tr class="viewadds">'
                        + '<td style="display:none;"><input type="text" name="accounttrans_codeval[]" value="'+ infdk +'" class="input-small accounttrans_codeval_'+id1 +'" readonly></td>'
                        + '<td align="left"><select class="input-xxlarge accounttrans_typeval_'+id1 +'" name="accounttrans_typeval[]" readonly><option value="'+ account +'">'+ accountket +'</option></select></td>'
                        + '<td align="right"><input id="ketval" name="ketval[]" value="'+ ketval +'" type="text" class="xlarge ketval_'+id1 +'" style="text-align: right;" readonly></td>'
                        + '<td style="display:none;"><input id="jumlahval" name="jumlahval[]" value="'+ juml +'" type="text" class="input-medium jumlahval_'+id1 +'" style="text-align: right;" readonly></td>'
                        + '<td align="right">'+ format_uang(debeti) +'</td>'
                        + '<td align="right">'+ format_uang(krediti) +'</td>'
                        + '<td style="display:none;">'+ infdk +'</td>'
                        + '<td style="display:none;">'+ juml +'</td>'
                        + '<td align="right"><img class="deljurnalrow" title="Delete" src="assets/images/deliconacc.png"></td>'
                        + '</tr>';
            $("#tbl_listjurnal").append(isi);
            update_jurnal();
            return false;

        }

    });

    function update_jurnal(){
        $('.deljurnalrow').click(function () {
            elm = $(this).parent().parent();
            idx = $('td:eq(0)',elm).text();
            allorder.splice(idx - 1 ,1);
            $(this).parent().parent().remove();
            var info1 = $(this).parent().prev().prev().text();
            var info2 = $(this).parent().prev().text();
            if(info1 == "KREDIT"){
                kredit = eval(kredit) - eval(info2);
            }else if(info1 == "DEBET"){
                debet = eval(debet) - eval(info2);
            }
            return false;

        });

        allorder.splice(0,allorder.length);
        var id3 = $('.viewadds').length;
        var b=0;
        while(b <= id3){
            var dk = $('.accounttrans_codeval_'+ b).val();
            var code = $('.accounttrans_typeval_'+ b).val();
            var ketval = $('.ketval_'+ b).val();
            if(dk == "KREDIT"){
                kredit += eval($('.jumlahval_'+ b).val());
                allorder.push(new orderan('01',code,ketval,eval($('.jumlahval_'+ b).val())));
            }else if(dk == "DEBET"){
                debet += eval($('.jumlahval_'+ b).val());
                allorder.push(new orderan('02',code,ketval,eval($('.jumlahval_'+ b).val())));
            }
            b++;
        }
        return false;

    }

    $('#save_a').click(function() {
        hasil = validform("form_jurnal");
        if (hasil['isi'] != "invalid") {
            if(kredit == debet){
                datao = {"accounttrans_date" : $('#accounttrans_date').val(),"accounttrans_code" : $('#code').val(),"accounttrans_desc" : $('#accounttrans_desc').val(),"orderan" : allorder };
                var dataString = JSON.stringify(datao);
                respon = ajak("akunting/jurnal/savejurnal","ord=" + dataString);
                if (respon == "1") {
                    window.location.href = "akunting/jurnal";
                } else {
                    showinfo("Error : " + respon);
                    return false;
                }
            }else{
                showinfo("Jumlah kredit dengan debit tidak sama");
                return false;
            }
         } else {
            showinfo("Form dengan tanda * harus Diisi");
            hasil['focus'].focus();
            return false;
        }

    });

    function orderan(dk,code,ketval,qty) {
        this.dk=dk;
        this.code=code;
        this.ketval=ketval;
        this.qty=qty;
    }
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
