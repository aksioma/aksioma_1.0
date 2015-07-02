/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/nasabah.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    $('.jclock').jclock({format: '%A, %d %B %Y - %H:%M:%S %P'});
    
    //---- Inisialisasi
    $("#tab-utama").tabs();
    
    //---- Dialog Tambah pendapatan
    $('#dialog-pendapatan').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_pendapatan");
                        if (hasil['isi'] != "invalid") {
                            if ($('#dialog-pendapatan').dialog('option', 'title') == "Tambah Pendapatan") {
                                respon = ajak("param/nasabah/savependapatan",$('#form_pendapatan').serialize());
                            } else {
                                respon = ajak("param/nasabah/editpendapatan",$('#form_pendapatan').serialize() + "&id=" + jAmbil("idx"));
                            }
                            if (respon == "1") {
                                $(this).dialog("close");
                                $("#table_pendapatan .reset").click();
                            } else if (respon == "1062") {
                                showinfo("Error : Kode Pendapatan sudah ada");
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
     $('#addpendapatan').click(function() {
        $(".infonya").hide();
        $('.inp').val('');
        $('#dialog-pendapatan').dialog('option', 'title',  'Tambah Pendapatan' ).dialog('open');
        return false;
     });

     //---- Dialog Hapus
     $('#dialog-hapus-pendapatan').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        respon = ajak("param/nasabah/delpendapatan","id=" + jAmbil("idx"));
                        if (respon == "1") {
                            $("#table_pendapatan .reset").click();;
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

     //---- Tabel pendapatan pekerjaan
    $("#table_pendapatan").mastertable({
        urlGet:"param/nasabah/get_pendapatan",
        flook:"kode"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "j" + json['alldata'][i].pendapatan_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            managejab = "<img class=\"chps\" title=\"Hapus\" src=\"assets/images/delicon.png\"/>&nbsp;&nbsp;&nbsp;<img  class=\"cedt1\" title=\"Edit\" src=\"assets/images/editicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].kode + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].range_pendapatan + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].pendapatan_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Hapus
        $('.chps').click( function() {
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            $('.phps').html(obj.range_pendapatan);
            jSimpan("idx",obj.pendapatan_id);
            $('#dialog-hapus-pendapatan').dialog('option', 'title',  'Hapus pendapatan Pekerjaan' ).dialog('open');
            return false;
        });
        //---- Edit
        $('.cedt1').click( function() {
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            $('.inp:eq(0)').val(obj.kode);
            $('.inp:eq(1)').val(obj.range_pendapatan);
            jSimpan("idx",obj.pendapatan_id);
            $('#dialog-pendapatan').dialog('option', 'title',  'Edit pendapatan Pekerjaan' ).dialog('open');
            return false;
        });
        warnatable();
    });
    
    //---- Dialog Tambah status Pekerjaan
    $('#dialog-status').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_status");
                        if (hasil['isi'] != "invalid") {
                            if ($('#dialog-status').dialog('option', 'title') == "Tambah Status Pekerjaan") {
                                respon = ajak("param/nasabah/savestatus",$('#form_status').serialize());
                            } else {
                                respon = ajak("param/nasabah/editstatus",$('#form_status').serialize() + "&id=" + jAmbil("idx"));
                            }
                            if (respon == "1") {
                                $(this).dialog("close");
                                $("#table_status .reset").click();
                            } else if (respon == "1062") {
                                showinfo("Error : Kode Status Pekerjaan sudah ada");
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
     $('#addstatus').click(function() {
        $(".infonya").hide();
        $('.inp').val('');
        $('#dialog-status').dialog('option', 'title',  'Tambah Status Pekerjaan' ).dialog('open');
        return false;
     });

     //---- Dialog Hapus
     $('#dialog-hapus-status').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        respon = ajak("param/nasabah/delstatus","id=" + jAmbil("idx"));
                        if (respon == "1") {
                            $("#table_status .reset").click();;
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

     //---- Tabel Status pekerjaan
    $("#table_status").mastertable({
        urlGet:"param/nasabah/get_status",
        flook:"kode"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "j" + json['alldata'][i].status_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            managejab = "<img class=\"chps\" title=\"Hapus\" src=\"assets/images/delicon.png\"/>&nbsp;&nbsp;&nbsp;<img  class=\"cedt2\" title=\"Edit\" src=\"assets/images/editicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].kode + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].status_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Hapus
        $('.chps').click( function() {
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            $('.phps').html(obj.nama);
            jSimpan("idx",obj.status_id);
            $('#dialog-hapus-status').dialog('option', 'title',  'Hapus Status Pekerjaan' ).dialog('open');
            return false;
        });
        //---- Edit
        $('.cedt2').click( function() {
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            $('.inp:eq(0)').val(obj.kode);
            $('.inp:eq(1)').val(obj.nama);
            jSimpan("idx",obj.status_id);
            $('#dialog-status').dialog('option', 'title',  'Edit Status Pekerjaan' ).dialog('open');
            return false;
        });
        warnatable();
    });
    
    //---- Dialog Tambah Sektor Pekerjaan
    $('#dialog-pekerjaan').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_pekerjaan");
                        if (hasil['isi'] != "invalid") {
                            if ($('#dialog-pekerjaan').dialog('option', 'title') == "Tambah Sektor Pekerjaan") {
                                respon = ajak("param/nasabah/savepekerjaan",$('#form_pekerjaan').serialize());
                            } else {
                                respon = ajak("param/nasabah/editpekerjaan",$('#form_pekerjaan').serialize() + "&id=" + jAmbil("idx"));
                            }
                            if (respon == "1") {
                                $(this).dialog("close");
                                $("#table_pekerjaan .reset").click();
                            } else if (respon == "1062") {
                                showinfo("Error : Kode Sektor Pekerjaan sudah ada");
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
     $('#addpekerjaan').click(function() {
        $(".infonya").hide();
        $('.inp').val('');
        $('#dialog-pekerjaan').dialog('option', 'title',  'Tambah Sektor Pekerjaan' ).dialog('open');
        return false;
     });

     //---- Dialog Hapus
     $('#dialog-hapus-pekerjaan').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        respon = ajak("param/nasabah/delpekerjaan","id=" + jAmbil("idx"));
                        if (respon == "1") {
                            $("#table_pekerjaan .reset").click();;
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

     //---- Tabel Sektor pekerjaan
    $("#table_pekerjaan").mastertable({
        urlGet:"param/nasabah/get_pekerjaan",
        flook:"kode"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "j" + json['alldata'][i].pekerjaan_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            managejab = "<img class=\"chps\" title=\"Hapus\" src=\"assets/images/delicon.png\"/>&nbsp;&nbsp;&nbsp;<img  class=\"cedt3\" title=\"Edit\" src=\"assets/images/editicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].kode + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].pekerjaan_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Hapus
        $('.chps').click( function() {
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            $('.phps').html(obj.nama);
            jSimpan("idx",obj.pekerjaan_id);
            $('#dialog-hapus-pekerjaan').dialog('option', 'title',  'Hapus Sektor Pekerjaan' ).dialog('open');
            return false;
        });
        //---- Edit
        $('.cedt3').click( function() {
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            $('.inp:eq(0)').val(obj.kode);
            $('.inp:eq(1)').val(obj.nama);
            jSimpan("idx",obj.pekerjaan_id);
            $('#dialog-pekerjaan').dialog('option', 'title',  'Edit Sektor Pekerjaan' ).dialog('open');
            return false;
        });
        warnatable();
    });

/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
