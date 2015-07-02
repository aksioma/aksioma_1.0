/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/kolektibilitas.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){

    $('.jclock').jclock({format: '%A, %d %B %Y - %H:%M:%S %P'});

    
    //---- Inisialisasi
    //$("#tab-utama").tabs();
    //---- Dialog kolekbilitas
    $('#dialog-kmingguan').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_kmingguan");
                        if (hasil['isi'] != "invalid") {
                            if ($('#dialog-kmingguan').dialog('option', 'title') == "Tambah Kolekbilitas Mingguan") {
                                respon = ajak("param/kolektibilitas/savekmingguan",$('#form_kmingguan').serialize());
                            } else {
                                respon = ajak("param/kolektibilitas/editkmingguan",$('#form_kmingguan').serialize() + "&id=" + jAmbil("idx"));
                            }
                            if (respon == "1") {
                                $(this).dialog("close");
                                $("#table_mingguan .reset").click();
                            } else if (respon == "1062") {
                                showinfo("Error : Jangka Waktu sudah ada");
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
    //---- Dialog kolekbilitas
    $('#dialog-kbulanan').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_kbulanan");
                        if (hasil['isi'] != "invalid") {
                            if ($('#dialog-kbulanan').dialog('option', 'title') == "Tambah Kolekbilitas Bulanan") {
                                respon = ajak("param/kolektibilitas/savekbulanan",$('#form_kbulanan').serialize());
                            } else {
                                respon = ajak("param/kolektibilitas/editkbulanan",$('#form_kbulanan').serialize() + "&id=" + jAmbil("idx"));
                            }
                            if (respon == "1") {
                                $(this).dialog("close");
                                $("#table_bulanan .reset").click();
                            } else if (respon == "1062") {
                                showinfo("Error : Jangka Waktu sudah ada");
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

    //---- Dialog kolekbilitas

    $('#dialog-kharian').dialog({autoOpen: false,width: 400,modal: true,

        buttons: {

                    "Ok": function() {

                        hasil = validform("form_kharian");

                        if (hasil['isi'] != "invalid") {

                            if ($('#dialog-kharian').dialog('option', 'title') == "Tambah Kolekbilitas Harian") {

                                respon = ajak("param/kolektibilitas/savekharian",$('#form_kharian').serialize());

                            } else {

                                respon = ajak("param/kolektibilitas/editkharian",$('#form_kharian').serialize() + "&id=" + jAmbil("idx"));

                            }

                            if (respon == "1") {

                                $(this).dialog("close");

                                $("#table_harian .reset").click();

                            } else if (respon == "1062") {

                                showinfo("Error : Jangka Waktu sudah ada");

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

     $('#addharian').click(function() {

        $(".infonya").hide();

        $('.inp').val('');

        $('#dialog-kharian').dialog('option', 'title',  'Tambah Kolekbilitas Harian' ).dialog('open');

        return false;

     });



    //---- Tabel kharian

    $("#table_harian").mastertable({

        urlGet:"param/kolektibilitas/get_kharian",

        flook:"kharian_id"

    },

    function(hal,juml,json) {

        var isi="";

        for(i = 0; i < json['alldata'].length; i++) {

            idx = "h" + json['alldata'][i].kharian_id;

            dtx = json['alldata'][i];

            jSimpan(idx,dtx);

            managejab = "<img  class=\"cedth\" title=\"Edit\" src=\"assets/images/editicon.png\"/>";

            isi += "<tr style=\"vertical-align:top;\">"

                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"

                + "<td align=\"left\">" + json['alldata'][i].type_kolekbilitas + "</td>"

                + "<td align=\"center\">" + json['alldata'][i].parameter + "</td>"

                + "<td align=\"center\">" + json['alldata'][i].kode + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"

                + "<td align=\"center\">" + json['alldata'][i].kharian_id + "</td>"

                + "</tr>";

        }

        return isi;

    },

    function domIsi() {

        //---- Edit

        $('.cedth').click( function() {

            $(".infonya").hide();

            obj = jAmbil("h" + $(this).parent().next().text());

            $('#form_kharian .inp:eq(0)').val(obj.type_kolekbilitas);

            $('#form_kharian .inp:eq(1)').val(obj.parameter);

            $('#form_kharian .inp:eq(2)').val(obj.kode);
            jSimpan("idx",obj.kharian_id);

            $('#dialog-kharian').dialog('option', 'title',  'Edit Kolekbilitas Harian' ).dialog('open');

            return false;

        });

        warnatable();

    });

  //---- Tabel kbulanan
    $("#table_bulanan").mastertable({
        urlGet:"param/kolektibilitas/get_kbulanan",
        flook:"kbulanan_id"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "b" + json['alldata'][i].kbulanan_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            managejab = "<img  class=\"cedtb\" title=\"Edit\" src=\"assets/images/editicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].type_kolekbilitas + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].parameter + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].kode + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].kbulanan_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Edit
        $('.cedtb').click( function() {
            $(".infonya").hide();
            obj = jAmbil("b" + $(this).parent().next().text());
            $('#form_kbulanan .inp:eq(0)').val(obj.type_kolekbilitas);
            $('#form_kbulanan .inp:eq(1)').val(obj.parameter);
            $('#form_kbulanan .inp:eq(2)').val(obj.kode);
            jSimpan("idx",obj.kbulanan_id);
            $('#dialog-kbulanan').dialog('option', 'title',  'Edit Kolekbilitas Bulanan' ).dialog('open');
            return false;
        });
        warnatable();
    });
    
//---- Tabel kmingguan
    $("#table_mingguan").mastertable({
        urlGet:"param/kolektibilitas/get_kmingguan",
        flook:"kmingguan_id"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "m" + json['alldata'][i].kmingguan_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            managejab = "<img  class=\"cedtm\" title=\"Edit\" src=\"assets/images/editicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].type_kolekbilitas + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].parameter + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].kode + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].kmingguan_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Edit
        $('.cedtm').click( function() {
            $(".infonya").hide();
            obj = jAmbil("b" + $(this).parent().next().text());
            $('#form_kmingguan .inp:eq(0)').val(obj.type_kolekbilitas);
            $('#form_kmingguan .inp:eq(1)').val(obj.parameter);
            $('#form_kmingguan .inp:eq(2)').val(obj.kode);
            jSimpan("idx",obj.kmingguan_id);
            $('#dialog-kmingguan').dialog('option', 'title',  'Edit Kolekbilitas Mingguan' ).dialog('open');
            return false;
        });
        warnatable();
    });
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
