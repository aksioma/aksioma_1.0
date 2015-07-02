/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/deposito.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    $('.jclock').jclock({format: '%A, %d %B %Y - %H:%M:%S %P'});
    
    //---- Inisialisasi
    //$("#tab-utama").tabs();
    //---- Dialog Tambah Kode produk
    $('#idmudharabah').hide();
    $('#idalqardh').hide();
    $('#dialog-produk').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_produk");
                        if (hasil['isi'] != "invalid") {
                            if ($('#dialog-produk').dialog('option', 'title') == "Tambah Kode Produk") {
                                respon = ajak("param/deposito/saveproduk",$('#form_produk').serialize());
                            } else {
                                respon = ajak("param/deposito/editproduk",$('#form_produk').serialize() + "&id=" + jAmbil("idx"));
                            }
                            if (respon == "1") {
                                $(this).dialog("close");
                                $("#table_produk .reset").click();
                            } else if (respon == "1062") {
                                showinfo("Error : Kode produk sudah ada");
                            } else {
                                showinfo("Error : " + respon);
                            }
                        } else {
                            showinfo("Form dengan tanda * harus Diisi");
                            hasil['focus'].focus();
                        }
                    },
                    "Batal": function() {
                        $(this).dialog('close');
                    }
    			 }
     });
     $('#addproduk').click(function() {
        $(".infonya").hide();
        $('.inp').val('');
        $('#dialog-produk').dialog('option', 'title',  'Tambah Kode Produk' ).dialog('open');
        return false;
     });
     
     //---- Dialog Hapus
     $('#dialog-hapus-mutasi').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        respon = ajak("param/deposito/delmutasi","id=" + jAmbil("idx"));
                        if (respon == "1") {
                            $("#table_mutasi .reset").click();;
                            $(this).dialog('close');
                        } else if (respon == "1451") {
                            showinfo("Error : Kode Masih Digunakan");
                        } else {
                            showinfo("Error : " + respon);
                        }
                    },
                    "Batal": function() {
                        $(this).dialog('close');
                    }
				 }
     });
    isi = ajak('param/listakun/isi_akun');
    $("#form_mdeposito select[name='gl_produk']").html(isi);
    $("#form_mdeposito select[name='gl_bagihasil']").html(isi);
    $("#form_mdeposito select[name='gl_titipanbagihasil']").html(isi);
    $("#form_mdeposito select[name='gl_administrasi']").html(isi);
    $("#form_mdeposito select[name='gl_pajakpenghasilan']").html(isi);
    $("#form_mdeposito select[name='gl_zakat']").html(isi);
    $("#form_mdeposito select[name='gl_bonus']").html(isi);
    
     //---- Tabel group produk
    $("#table_produk").mastertable({
        urlGet:"param/deposito/get_produk",
        flook:"kode_produk"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "s" + json['alldata'][i].groupdeposito_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            managejab = "<img  class=\"cedte\" title=\"Edit\" src=\"assets/images/editicon.png\"/>&nbsp;&nbsp;&nbsp;<img  class=\"cset\" title=\"Setting\" src=\"assets/images/icontruechecklist.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].kode_produk + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].groupdeposito_nama + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].groupdeposito_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Edit
        $('.cedte').click( function() {
            $(".infonya").hide();
            obj = jAmbil("s" + $(this).parent().next().text());
            $('#form_produk input:eq(0)').val(obj.kode_produk);
            $('#form_produk input:eq(1)').val(obj.groupdeposito_nama);
            jSimpan("idx",obj.groupdeposito_id);
            $('#dialog-produk').dialog('option', 'title',  'Edit Kode Produk' ).dialog('open');
            return false;
        });
        //---- set
        $('.cset').click( function() {
            $(".infonya").hide();
            obj = jAmbil("s" + $(this).parent().next().text());
            
            $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
            $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
            $('#tabs-1').removeClass('active').addClass('');
            $('#tabs-2').removeClass('').addClass('active');
            loaddeposito(obj.kode_produk);
            return false;
        });
        $('#depositosave').click(function() {
            respon = ajak("param/deposito/editdeposito",$('#form_mdeposito').serialize());
        });
        
        function loaddeposito(id){
            $.post("param/deposito/get_depositoinfo","id="+ id,
                function(json){
                    var isi ="";
                    $('#form_mdeposito input:eq(0)').val(id);
                    for(i = 0; i < json['alldata'].length; i++) {
                        $('#form_mdeposito input:eq(1)').val(json['alldata'][i].biaya_administrasi);
                        $('#form_mdeposito input:eq(2)').val(json['alldata'][i].nominal);
                        $('#form_mdeposito input:eq(3)').val(json['alldata'][i].jangka_waktu);
                        $('#form_mdeposito input:eq(4)').val(json['alldata'][i].nisbah_bank);
                        $('#form_mdeposito input:eq(5)').val(json['alldata'][i].nisbah_nasabah);
                        
                        $("#form_mdeposito input[name='pph']").val(json['alldata'][i].pph);
                        $("#form_mdeposito input[name='zakat']").val(json['alldata'][i].zakat);
                        $("#form_mdeposito input[name='bonus']").val(json['alldata'][i].bonus);
                        
                        $("#form_mdeposito select[name='gl_produk']").val(json['alldata'][i].gl_produk);
                        $("#form_mdeposito select[name='gl_bagihasil']").val(json['alldata'][i].gl_bagihasil);
                        
                        $("#form_mdeposito select[name='gl_titipanbagihasil']").val(json['alldata'][i].gl_titipanbagihasil);
                        $("#form_mdeposito select[name='gl_administrasi']").val(json['alldata'][i].gl_administrasi);
                        $("#form_mdeposito select[name='gl_pajakpenghasilan']").val(json['alldata'][i].gl_pajakpenghasilan);
                        
                        $("#form_mdeposito select[name='gl_zakat']").val(json['alldata'][i].gl_zakat);
                        $("#form_mdeposito select[name='gl_bonus']").val(json['alldata'][i].gl_bonus);
                        
                    }
                    
                }, "json");
            return false;
        }
        warnatable();
    });
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
