/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/pembiayaan.js
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
                                respon = ajak("param/pembiayaan/saveproduk",$('#form_produk').serialize());
                            } else {
                                respon = ajak("param/pembiayaan/editproduk",$('#form_produk').serialize() + "&id=" + jAmbil("idx"));
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
                        respon = ajak("param/pembiayaan/delmutasi","id=" + jAmbil("idx"));
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
    $("#form_mpembiayaan select[name='gl_produk']").html(isi);
    $("#form_mpembiayaan select[name='gl_administrasi']").html(isi);
    $("#form_mpembiayaan select[name='gl_marginditangguhkan']").html(isi);
    $("#form_mpembiayaan select[name='gl_pendapatanmargin']").html(isi);
    $("#form_mpembiayaan select[name='gl_diskon']").html(isi);
    $("#form_mpembiayaan select[name='gl_pendapatanbagihasil']").html(isi);
    $("#form_mpembiayaan select[name='gl_bonusalqardh']").html(isi);
    $("#form_mpembiayaan select[name='gl_pendapatanbagihasilmusy']").html(isi);
    $("#form_mpembiayaan select[name='gl_activaijarah']").html(isi);
    $("#form_mpembiayaan select[name='gl_pendapatanijarah']").html(isi);
    $("#form_mpembiayaan select[name='gl_asetistishna']").html(isi);
    $("#form_mpembiayaan select[name='gl_pendapatanmarjinistishna']").html(isi);
    $("#form_mpembiayaan select[name='gl_diskonistishna']").html(isi);
    $("#form_mpembiayaan select[name='gl_pendapatankeuntungansalam']").html(isi);
    
     //---- Tabel group produk
    $("#table_produk").mastertable({
        urlGet:"param/pembiayaan/get_produk",
        flook:"kode_produk"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "s" + json['alldata'][i].grouppembiayaan_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            managejab = "<img  class=\"cedte\" title=\"Edit\" src=\"assets/images/editicon.png\"/>&nbsp;&nbsp;&nbsp;<img  class=\"cset\" title=\"Setting\" src=\"assets/images/icontruechecklist.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].kode_produk + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].grouppembiayaan_nama + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].grouppembiayaan_id + "</td>"
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
            $('#form_produk input:eq(1)').val(obj.grouppembiayaan_nama);
            jSimpan("idx",obj.grouppembiayaan_id);
            $('#dialog-produk').dialog('option', 'title',  'Edit Kode Produk' ).dialog('open');
            return false;
        });
        //---- set
        $('.cset').click( function() {
            $(".infonya").hide();
            obj = jAmbil("s" + $(this).parent().next().text());
            
            var nameproduk = ajak('base/pembiayaan/produk_name','id='+obj.kode_produk);
            if(nameproduk == "MURABAHAH"){
                $('#idmudharabah').hide();
                $('#idalqardh').hide();
                $('#idmusyarokah').hide();
                $('#idijarah').hide();
                $('#idistishna').hide();
                $('#idsalam').hide();
                $('#idmurabahah').show();
            }else if(nameproduk == "MUDHARABAH"){
                $('#idmurabahah').hide();
                $('#idalqardh').hide();
                $('#idmusyarokah').hide();
                $('#idijarah').hide();
                $('#idistishna').hide();
                $('#idsalam').hide();
                $('#idmudharabah').show();
            }else if(nameproduk == "AL-QARDH"){
                $('#idmurabahah').hide();
                $('#idmudharabah').hide();
                $('#idmusyarokah').hide();
                $('#idijarah').hide();
                $('#idistishna').hide();
                $('#idsalam').hide();
                $('#idalqardh').show();
            }else if(nameproduk == "MUSYARAKAH"){
                $('#idmurabahah').hide();
                $('#idmudharabah').hide();
                $('#idalqardh').hide();
                $('#idijarah').hide();
                $('#idistishna').hide();
                $('#idsalam').hide();
                $('#idmusyarokah').show();
            }else if(nameproduk == "IJARAH"){
                $('#idmurabahah').hide();
                $('#idmudharabah').hide();
                $('#idalqardh').hide();
                $('#idmusyarokah').hide();
                $('#idistishna').hide();
                $('#idsalam').hide();
                $('#idijarah').show();
            }else if(nameproduk == "ISTISHNA"){
                $('#idmurabahah').hide();
                $('#idmudharabah').hide();
                $('#idalqardh').hide();
                $('#idmusyarokah').hide();
                $('#idijarah').hide();
                $('#idsalam').hide();
                $('#idistishna').show();
            }else if(nameproduk == "SALAM"){
                $('#idmurabahah').hide();
                $('#idmudharabah').hide();
                $('#idalqardh').hide();
                $('#idmusyarokah').hide();
                $('#idijarah').hide();
                $('#idistishna').hide();
                $('#idsalam').show();
            }
            
            $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
            $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
            $('#tabs-1').removeClass('active').addClass('');
            $('#tabs-2').removeClass('').addClass('active');
            loadpembiayaan(obj.kode_produk);
            return false;
        });
        $('#pembiayaansave').click(function() {
            respon = ajak("param/pembiayaan/editPembiayaan",$('#form_mpembiayaan').serialize());
            alert(respon);
            return false;
            window.location.href = "param/pembiayaan";
        });
        
        function loadpembiayaan(id){
            $.post("param/pembiayaan/get_pembiayaaninfo","id="+ id,
                function(json){
                    var isi ="";
                    $('#form_mpembiayaan input:eq(0)').val(id);
                    for(i = 0; i < json['alldata'].length; i++) {
                        $('#form_mpembiayaan input:eq(1)').val(json['alldata'][i].biaya_administrasi);
                        $('#form_mpembiayaan input:eq(2)').val(json['alldata'][i].gl_produk);
                        $('#form_mpembiayaan input:eq(3)').val(json['alldata'][i].gl_administrasi);
                        $('#form_mpembiayaan input:eq(4)').val(json['alldata'][i].gl_marginditangguhkan);
                        
                        $("#form_mpembiayaan select[name='gl_produk']").val(json['alldata'][i].gl_produk);
                        $("#form_mpembiayaan select[name='gl_administrasi']").val(json['alldata'][i].gl_administrasi);
                        $("#form_mpembiayaan select[name='gl_marginditangguhkan']").val(json['alldata'][i].gl_marginditangguhkan);
                        $("#form_mpembiayaan select[name='gl_pendapatanmargin']").val(json['alldata'][i].gl_pendapatanmargin);
                        $("#form_mpembiayaan select[name='gl_diskon']").val(json['alldata'][i].gl_diskon);
                        
                        $("#form_mpembiayaan select[name='gl_pendapatanbagihasil']").val(json['alldata'][i].gl_pendapatanbagihasil);
                        $("#form_mpembiayaan select[name='gl_bonusalqardh']").val(json['alldata'][i].gl_bonusalqardh);
                        
                        $("#form_mpembiayaan select[name='gl_pendapatanbagihasilmusy']").val(json['alldata'][i].gl_pendapatanbagihasilmusy);
                        
                        $("#form_mpembiayaan select[name='gl_activaijarah']").val(json['alldata'][i].gl_activaijarah);
                        $("#form_mpembiayaan select[name='gl_pendapatanijarah']").val(json['alldata'][i].gl_pendapatanijarah);
                        
                        $("#form_mpembiayaan select[name='gl_asetistishna']").val(json['alldata'][i].gl_asetistishna);
                        $("#form_mpembiayaan select[name='gl_pendapatanmarjinistishna']").val(json['alldata'][i].gl_pendapatanmarjinistishna);
                        $("#form_mpembiayaan select[name='gl_diskonistishna']").val(json['alldata'][i].gl_diskonistishna);
                        
                        $("#form_mpembiayaan select[name='gl_pendapatankeuntungansalam']").val(json['alldata'][i].gl_pendapatankeuntungansalam);
                        
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
