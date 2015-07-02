/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : hapustransaksi.js
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
 *  --------------------- transaksi -----------------------------------------
 */
    //---- Tabel transaksi
    $("#table_trans").mastertable({
        urlGet:"hapustransaksi/get_trans",
        flook:"accounttrans_date",
        order: "desc"
    },
    function(hal,juml,json) {
        var isi="";
        var jenis="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "t" + json['alldata'][i].accounttrans_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            managejab = "<img  class=\"cdel\" title=\"Delete\" src=\"assets/images/delicon.png\"/>";
            var type;
            if(json['alldata'][i].accounttrans_type == "01"){
            	type = "K";
            }else{
            	type = "D";
            }
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].accounttrans_user + "</td>"
                + "<td align=\"center\">" + revDate(json['alldata'][i].accounttrans_date,'-') + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].accounttrans_type + "</td>"
                + "<td align=\"right\">" + format_uang(json['alldata'][i].accounttrans_value) + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].accounttrans_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- 
        $('.cdel').click( function() {
            $(".infonya").hide();
            obj = jAmbil("t" + $(this).parent().next().text());
            $('.phps').html(format_uang(obj.accounttrans_value));
            jSimpan("idx",obj.accounttrans_id);
            $('#dialog-hapus').dialog('option', 'title',  'Hapus Transaksi' ).dialog('open');
            return false;
        });
        warnatable();
    });
    $('#ffilter input[name="pawal"]').change(function() {
        //$('#ffilter input[name="pakhir"]').val($(this).val());
    });
    $('#dialog-hapus').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        respon = ajak("hapustransaksi/delTransaksi","id=" + jAmbil("idx"));
                        if (respon == "1") {
                            $("#table_trans .reset").click();;
                            $(this).dialog('close');
                        } else {
                            showinfo("Error : " + respon);
                        }
                    },
                    "Batal": function() {
                        $(this).dialog('close');
                    }
				 }
     });
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
