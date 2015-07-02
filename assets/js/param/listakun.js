/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/listakun.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    $('.jclock').jclock({format: '%A, %d %B %Y - %H:%M:%S %P'});
    
    //---- Inisialisasi
    $("#tab-utama").tabs();
    $('#dialog-akun').dialog({autoOpen: false,width: 450,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_akun");
                        if (hasil['isi'] != "invalid") {
                            if ($('#dialog-akun').dialog('option', 'title') == "Tambah CoA") {
                                respon = ajak("param/listakun/saveakun",$('#form_akun').serialize() + "&listakun_folder=" + $("#CTBfolder:checked").length);
                            } else {
                                respon = ajak("param/listakun/editakun",$('#form_akun').serialize() + "&id=" + jAmbil("idx") + "&listakun_folder=" + $("#CTBfolder:checked").length);
                            }
                            if (respon == "1") {
                                $(this).dialog("close");
                                $("#table_listakun .reset").click();
                            } else if (respon == "1062") {
                                showinfo("Error : Kode Akun sudah ada");
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
     $('#addakun').click(function() {
        $(".infonya").hide();
        $('.inp').val('');
        isi = ajak('param/listakun/isi_akun');
        $("#form_akun select[name='listakun_parent']").html(isi);
        $('#dialog-akun').dialog('option', 'title',  'Tambah CoA' ).dialog('open');
        return false;
     });
     $('#addtbuku').click(function() {
        $(".infonya").hide();
        $('.inp').val('');
        $('#dialog-tahunbuku').dialog('option', 'title',  'Tahun buku' ).dialog('open');
        return false;
     });
     $('#dialog-tahunbuku').dialog({autoOpen: false,width: 450,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_tahunbuku");
                        if (hasil['isi'] != "invalid") {
                            if ($('#dialog-tahunbuku').dialog('option', 'title') == "Tahun buku") {
                                respon = ajak("param/listakun/saveTahunbuku",$('#form_tahunbuku').serialize()+ "&active=" + $("#active:checked").length);
                            } else {
                                respon = ajak("param/listakun/editTahunbuku",$('#form_tahunbuku').serialize()+ "&active=" + $("#active:checked").length + "&id=" + jAmbil("idx"));
                            }
                            if (respon == "1") {
                                $("#table_listtahunbuku .reset").click();
                                $(this).dialog('close');
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
     $("#table_listtahunbuku").mastertable({
        urlGet:"param/listakun/get_tahunbuku",
        flook:"nama_tahun"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "t" + json['alldata'][i].tahunbuku_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            var managestar = "<img  class=\"mact\" title=\"Active\" src=\"assets/images/starblack.png\"/>";
            if(json['alldata'][i].active == 1){
                 managestar = "<img  class=\"mact\" title=\"Active\" src=\"assets/images/starcolor.png\"/>";
            }
            managejab = "<img  class=\"cedtt\" title=\"Edit\" src=\"assets/images/editicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].nama_tahun + "</td>"
                + "<td align=\"center\">" + revDate(json['alldata'][i].tgl_mulai,"-") + "</td>"
                + "<td align=\"center\">" + revDate(json['alldata'][i].tgl_akhir,"-") + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managestar +" | "+managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].tahunbuku_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Edit
        $('.cedtt').click( function() {
            $(".infonya").hide();
            obj = jAmbil("t" + $(this).parent().next().text());
            $('#form_tahunbuku .inp:eq(0)').val(obj.nama_tahun);
            $('#form_tahunbuku .inp:eq(1)').val(revDate(obj.tgl_mulai,"-"));
            $('#form_tahunbuku .inp:eq(2)').val(revDate(obj.tgl_akhir,"-"));
            if (obj.active != "1") {
                $('#active').removeAttr('checked');
            } else {
                $('#active').attr('checked','checked');
            }
            jSimpan("idx",obj.tahunbuku_id);
            $('#dialog-tahunbuku').dialog('option', 'title',  'Edit tahun buku' ).dialog('open');
            return false;
        });
        $('.mact').click(function(){
            obj = jAmbil("t" + $(this).parent().next().text());
            id = obj.tahunbuku_id;
            val = ($(this).attr('src') == 'assets/images/starcolor.png') ? 0 : 1;
            respon = ajak("param/listakun/toogleActive","id=" + id + "&val=" + val);
            $("#table_listtahunbuku .reset").click();
        });
        warnatable();
    });
    $("#table_listakun").mastertable({
        urlGet:"param/listakun/get_akun",
        flook:"listakun_code"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "a" + json['alldata'][i].listakun_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            managejab = "<img  class=\"cedt\" title=\"Edit\" src=\"assets/images/editicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].listakun_code + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].listakun_name + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].listakun_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Edit
        $('.cedt').click( function() {
            $(".infonya").hide();
            obj = jAmbil("a" + $(this).parent().next().text());
            $('#form_akun .inp:eq(0)').val(obj.listakun_code);
            $('#form_akun .inp:eq(1)').val(obj.listakun_name);
            $('#form_akun .inp:eq(2)').val(obj.listakun_alias);
            isi = ajak('param/listakun/isi_akun');
            $("#form_akun select[name='listakun_parent']").html(isi);
            $("#form_akun select[name='listakun_parent']").val(obj.listakun_parent);
            /*if (obj.listakun_folder == "0") {
                $('#form_akun .inp:eq(3)').removeAttr('checked');
            } else {
                $('#form_akun .inp:eq(3)').attr('checked','checked');
            }*/
            jSimpan("idx",obj.listakun_id);
            $('#dialog-akun').dialog('option', 'title',  'Edit CoA' ).dialog('open');
            return false;
        });
        $('#CTBfolder').click( function() {
            if ($(this).parent().prev().text() != 'admin') {
                act = ($(this).attr('src') == 'assets/images/starcolor.png') ? "0" : '1';
                respon = ajak("param/listakun/changeFolder","act=" + act +"&id=" + $(this).parent().next().next().next().next().text());
                $("#table_listakun .reset").click();
            }
            return false;
        });
        warnatable();
    });
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
    getTreeCOA();
    function getTreeCOA()
    {
        respon = ajak("param/listakun/getTreeCOA");
        $('#isitree').html(respon);
    }
});
