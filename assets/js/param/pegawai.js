/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/pegawai.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    $('.jclock').jclock({format: '%A, %d %B %Y - %H:%M:%S %P'});
    
//---- Inisialisasi
    $("#tab-utama").tabs();
    kelamin = new Array('Pria','Wanita');
    agama = new Array('Islam','Kristen','Budha','Hindu','Lainnya');
    statuss = new Array('Belum Menikah','Menikah','Duda','Janda');
//--------------------------- sub data picker ----------------------------------------//
	$('.tgl').mask("99-99-9999").datepicker({
         dateFormat: 'dd-mm-yy',
         yearRange: "-20:+10",
         buttonImage: 'assets/images/cal_icon.png',
         buttonImageOnly: true,
         showOn: 'button',
         changeMonth: true,
         changeYear: true,
         showButtonPanel: true
    });
/*
 *  --------------------- USERS -----------------------------------------
 */
   //---- Dialog Tambah User
    $('#dialog-user').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_user");
                        if (hasil['isi'] != "invalid") {
                            if ($("#form_user input:eq(1)").val() == $("#form_user input:eq(2)").val()) {
                                if ($('#dialog-user').dialog('option', 'title') == "Tambah User") {
                                    respon = ajak("param/user/saveUser",$('#form_user').serialize() + "&active=" + $("#CTBaktif:checked").length);
                                } else {
                                    respon = ajak("param/user/editUser",$('#form_user').serialize() + "&active=" + $("#CTBaktif:checked").length + "&id=" + jAmbil("idx"));
                                }
                                if (respon == "1062") {
                                    showinfo("Username telah ada");
                                } else if (respon == "1") {
                                    $("#table_user .reset").click();
                                    $(this).dialog('close');
                                } else {
                                    showinfo("Error : " + respon);
                                }
                            } else {
                                showinfo("Password tidak sama");
                                $("#form_user input:eq(1)").focus();
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

     $('#adduser').click(function() {
        $(".infonya").hide();
        $('#form_user input').val('');
        $('#form_user input:eq(1),#form_user input:eq(2)').parent().removeClass().addClass("fm-req");
        isi = ajak('param/user/isi_groups');
        $("#form_user select[name='id_group']").html(isi);
        $("#form_user input:eq(5)").attr('checked','checked');
        $("#form_user input:eq(0),#form_user input:eq(3),#form_user input:eq(4),#form_user select[name='id_group'],#form_user input:eq(5)").removeAttr('disabled');
        $('#dialog-user').dialog('option', 'title',  'Tambah User' ).dialog('open');
        return false;
     });

      //---- Dialog Hapus user
     $('#dialog-hapus-user').dialog({autoOpen: false,width: 500,modal: true,
        buttons: {
                    "Ok": function() {
                        respon = ajak("param/user/delUser","id=" + jAmbil("idx"));
                        if (respon == "1") {
                            $("#table_user .reset").click();;
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

     //---- Tabel user
    $("#table_user").mastertable({
        urlGet:"param/user/get_user",
        flook:"nip"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "u" + json['alldata'][i].user_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            img = (json['alldata'][i].active == '1') ? "<img class=\"cactive\" src=\"assets/images/starcolor.png\" />" : "<img class=\"cactive\" src=\"assets/images/starblack.png\" />";
            manageact = (idx != 'u1') ? img : "";
            manageusr = (idx != 'u1') ? "<img class=\"chpsu\" title=\"Hapus\" src=\"assets/images/remove-user.png\"/>&nbsp;" : "";
            isi += "<tr>"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].nip + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama_pegawai + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].username + "</td>"
                + "<td align=\"center\">" + manageact + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama_group + "</td>"
                + "<td align=\"center\"><span title=\"" + json['alldata'][i].from_host + "\"  class=\"toolTip\">" + json['alldata'][i].last_login + "</span></td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + manageusr + "<img  class=\"cedtu\" title=\"Edit\" src=\"assets/images/edit-user.png\"/></td>"
                + "<td align=\"center\">" + json['alldata'][i].user_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Hapus
        $('.chpsu').click( function() {
            obj = jAmbil("u" + $(this).parent().next().text());
            if (obj.username != 'admin') {
                $('.phps').html(obj.nama_pegawai);
                jSimpan("idx",obj.user_id);
                $('#dialog-hapus-user').dialog('option', 'title',  'Hapus User' ).dialog('open');
            }
            return false;
        });
        //---- Edit
        $('.cedtu').click( function() {
            $(".infonya").hide();
            obj = jAmbil("u" + $(this).parent().next().text());
            $('#form_user input:eq(0)').val(obj.username);
            $('#form_user input:eq(1),#form_user input:eq(2)').val("").parent().removeClass().addClass("fm-opt");
            $('#form_user input:eq(3)').val(obj.nip);
            $('#form_user input:eq(4)').val(obj.nama_pegawai);
            isi = ajak('param/user/isi_groups');
            $("#form_user select[name='id_group']").html(isi);
            $("#form_user select[name='id_group']").val(obj.id_group);
            $('#form_user input:eq(6)').val(obj.pegawai_id);
            if (obj.active == "0") {
                $('#form_user input:eq(5)').removeAttr('checked');
            } else {
                $('#form_user input:eq(5)').attr('checked','checked');
            }
            if (obj.username == 'admin'){
                $("#form_user input:eq(0),#form_user input:eq(3),#form_user input:eq(4),#form_user select[name='id_group'],#form_user input:eq(5)").attr('disabled','disabled');
            } else {
                $("#form_user input:eq(0),#form_user input:eq(3),#form_user input:eq(4),#form_user select[name='id_group'],#form_user input:eq(5)").removeAttr('disabled');
            }
            jSimpan("idx",obj.user_id);
            $('#dialog-user').dialog('option', 'title',  'Edit User' ).dialog('open');
            return false;
        });
        $('.cactive').click( function() {
            if ($(this).parent().prev().text() != 'admin') {
                act = ($(this).attr('src') == 'assets/images/starcolor.png') ? "0" : '1';
                respon = ajak("param/user/changeActive","act=" + act +"&id=" + $(this).parent().next().next().next().next().text());
                $("#table_user .reset").click();
            }
            return false;
        });
        warnatable();
        tool();
    });

    //---- Autocomplete NIP ----//
    $("#form_user input:eq(3)").autocomplete('param/user/search_nip', {
            multiple: false,
            parse: function(data) {
                return $.map(eval(data), function(row) {
                    return {
                        data: row,
                        value: row.nip,
                        result: row.nip
                    }
                });
            },
            formatItem: function(item) {
                return item.nip + '<br />' + item.nama_pegawai;
            }
     }).result(function(e, item) {
            $("#form_user input:eq(3)").val(item.nip);
            $("#form_user input:eq(4)").val(item.nama_pegawai);
            $("#form_user input:eq(6)").val(item.pegawai_id);
     });

     //---- Autocomplete NAMA PEGAWAI ----//
    $("#form_user input:eq(4)").autocomplete('param/user/search_namapeg', {
            multiple: false,
            parse: function(data) {
                return $.map(eval(data), function(row) {
                    return {
                        data: row,
                        value: row.nip,
                        result: row.nip
                    }
                });
            },
            formatItem: function(item) {
                return item.nip + '<br />' + item.nama_pegawai;
            }
     }).result(function(e, item) {
            $("#form_user input:eq(3)").val(item.nip);
            $("#form_user input:eq(4)").val(item.nama_pegawai);
            $("#form_user input:eq(6)").val(item.pegawai_id);
     });

     //---- Tooltip ----//
	function tool() {
		$('.toolTip').hover(
			function() {
			this.tip = this.title;
			$(this).append(
				'<div class="toolTipWrapper">'
					+'<span class="toolTipMid">'
						+this.tip
					+'</span>'
				+'</div>'
			);
			this.title = "";
			this.width = $(this).width();
			$(this).find('.toolTipWrapper').css({left:this.width - 20});
			$('.toolTipWrapper').fadeIn(300);
		},
		function() {
			$('.toolTipWrapper').fadeOut(100);
			$(this).children().remove();
				this.title = this.tip;
			}
		);
	}

/*
 *  --------------------- PEGAWAI -----------------------------------------
 */
    //---- Dialog Tambah Pegawai
    $('#dialog-pegawai').dialog({autoOpen: false,width: 500,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_pegawai");
                        if (hasil['isi'] != "invalid") {
                            if ($('#dialog-pegawai').dialog('option', 'title') == "Tambah Pegawai") {
                                respon = ajak("param/pegawai/savePegawai",$('#form_pegawai').serialize());
                            } else {
                                respon = ajak("param/pegawai/editPegawai",$('#form_pegawai').serialize() + "&id=" + jAmbil("idx"));
                            }
                            if (respon == "1") {
                                $(this).dialog("close");
                                $("#table_pegawai .reset").click();
                            } else if (respon == "1062") {
                                showinfo("Error : NIP atau Nama Panggilan telah ada");
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
     $('#addpeg').click(function() {
        $(".infonya").hide();
        isi = ajak('param/pegawai/isi_jabatan');
        $("select[name='id_jabatan']").html(isi);
        $('.inp').val('');
        $('select').val('1');
        $('#dialog-pegawai').dialog('option', 'title',  'Tambah Pegawai' ).dialog('open');
        return false;
     });

     //---- Dialog Hapus Pegawai
     $('#dialog-hapus-pegawai').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        respon = ajak("param/pegawai/delPegawai","id=" + jAmbil("idx"));
                        if (respon == "1") {
                            $("#table_pegawai .reset").click();;
                            $(this).dialog('close');
                        } else if (respon == "1451") {
                            showinfo("Error : Data Pegawai Masih Digunakan");
                        } else {
                            showinfo("Error : " + respon);
                        }
                    },
                    "Batal": function() {
                        $(this).dialog('close');
                    }
				 }
     });

     //---- Dialog Upload Foto Pegawai
     $('#dialog-upload').dialog({autoOpen: false,width: 450,modal: true,
        buttons: {
                    "Upload": function() {
                        if($('#userfile').val() == ""){
                            showinfo("Pilih file yang akan di upload");
                            return false;
                        }
                        $('#formUpload').submit();
                        $('#upload_target').load(function(){
                            isi = $('#upload_target').contents().find('body').html();
                            if (isi == "1") {
                                $("#foto_upload").attr("src","assets/images/fotopegawai/" + obj.nip + ".jpg?"+(new Date().getTime())).error(function() {
                                    $(this).attr("src","assets/images/fotopegawai/default.jpg?"+(new Date().getTime()));
                                });
                            } else {
                                showinfo("Error : " + isi );
                            }
                        });
                    },
                    "Batal": function() {
                        $(this).dialog('close');
                    }
				 }
     });

     //---- Dialog Detail Pegawai
     $('#dialog-detail').dialog({autoOpen: false,width: 500,modal: true,
        buttons: {
                    "Cetak": function() {
                        $('base',ctkframe.document).after("<link type=\"text/css\" href=\"assets/css/master_table.css\" rel=\"stylesheet\" />");
                        $('#wrap-top',ctkframe.document).html("<hr/>" + $('#dialog-detail').html());
                        window.ctkframe.print();
                    },
                    "Tutup": function() {
                        $(this).dialog('close');
                    }
				 }
     });

     //---- Tabel Pegawai
    $("#table_pegawai").mastertable({
        urlGet:"param/pegawai/get_pegawai",
        flook:"nip"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "e" + json['alldata'][i].pegawai_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            managepeg = (idx != 'e1') ? "<img class=\"chpspe\" title=\"Hapus\" src=\"assets/images/remove-user.png\"/>&nbsp;<img  class=\"cedtpe\" title=\"Edit\" src=\"assets/images/edit-user.png\"/>&nbsp;" : "";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].nip + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama_pegawai + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama_panggilan + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].tpt_lhr + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].tgl_lhr + "</td>"
                + "<td>" + json['alldata'][i].alamat + "<br />" + json['alldata'][i].kota + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].nama_jabatan + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\"><img class=\"cdetail\" title=\"Detail\" src=\"assets/images/usericon.png\"/>&nbsp;" + managepeg + "<img class=\"cupload\" title=\"Upload Foto\" src=\"assets/images/foto_icon.png\"/></td>"
                + "<td align=\"center\">" + json['alldata'][i].pegawai_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Hapus
        $('.chpspe').click( function() {
            $(".infonya").hide();
            obj = jAmbil("e" + $(this).parent().next().text());
            $('.phps').html(obj.nama_pegawai);
            jSimpan("idx",obj.pegawai_id);
            $('#dialog-hapus-pegawai').dialog('option', 'title',  'Hapus Pegawai' ).dialog('open');
            return false;
        });
        //---- Edit
        $('.cedtpe').click( function() {
            $(".infonya").hide();
            obj = jAmbil("e" + $(this).parent().next().text());
             $("#form_pegawai input[name='nip']").val(obj.nip);
             isi = ajak('param/pegawai/isi_jabatan');
             $("#form_pegawai select[name='id_jabatan']").html(isi);
             $("#form_pegawai select[name='id_jabatan']").val(obj.id_jabatan);
             $("#form_pegawai input[name='nama_pegawai']").val(obj.nama_pegawai);
             $("#form_pegawai input[name='nama_panggilan']").val(obj.nama_panggilan);
             $("#form_pegawai input[name='tpt_lhr']").val(obj.tpt_lhr);
             $("#form_pegawai input[name='tgl_lhr']").val(obj.tgl_lhr);
             $("#form_pegawai select[name='jns_klmn']").val(obj.jns_klmn);
             $("#form_pegawai select[name='agama']").val(obj.agama);
             $("#form_pegawai select[name='status']").val(obj.status);
             $("#form_pegawai textarea[name='alamat']").val(obj.alamat);
             $("#form_pegawai input[name='alamat']").val(obj.kota);
             $("#form_pegawai input[name='telepon']").val(obj.telepon);
             $("#form_pegawai input[name='pendidikan']").val(obj.pendidikan);
             $("#form_pegawai input[name='noktp']").val(obj.noktp);
             $("#form_pegawai textarea[name='keterangan']").val(obj.keterangan);
             jSimpan("idx",obj.pegawai_id);
            $('#dialog-pegawai').dialog('option', 'title',  'Edit Pegawai' ).dialog('open');
            return false;
        });
        //---- Upload
        $('.cupload').click( function() {
            $(".infonya").hide();
            obj = jAmbil("e" + $(this).parent().next().text());
            $('.napeg').html(obj.nama_pegawai);
            $('#userfile').val('');
            $('input[name="nipfoto"]').val(obj.nip);
            $("#foto_upload").attr("src","assets/images/fotopegawai/" + obj.nip + ".jpg?"+(new Date().getTime())).error(function() {
                $(this).attr("src","assets/images/fotopegawai/default.jpg?"+(new Date().getTime()));
            });
            $('#upload_target').remove();
            $("<iframe id=\"upload_target\" name=\"upload_target\" style=\"width:0;height:0;border:0px;\"></iframe>").appendTo("body");
            $('#dialog-upload').dialog('option', 'title',  'Upload Foto Pegawai' ).dialog('open');
            return false;
        });
        $('.cdetail').click( function() {
            obj = jAmbil("e" + $(this).parent().next().text());
            $('.dtl:eq(0)').html(obj.nip);
            $('.dtl:eq(1)').html(obj.nama_jabatan);
            $('.dtl:eq(2)').html(obj.nama_pegawai);
            $('.dtl:eq(3)').html(obj.nama_panggilan);
            $('.dtl:eq(4)').html(obj.tpt_lhr);
            $('.dtl:eq(5)').html(obj.tgl_lhr);
            $('.dtl:eq(6)').html(kelamin[parseInt(obj.jns_klmn) - 1]);
            $('.dtl:eq(7)').html(agama[parseInt(obj.agama) - 1]);
            $('.dtl:eq(8)').html(statuss[parseInt(obj.status) - 1]);
            $('.dtl:eq(9)').html(obj.alamat);
            $('.dtl:eq(10)').html(obj.kota);
            tlp = (obj.telepon != '') ? obj.telepon : '-';
            $('.dtl:eq(11)').html(tlp);
            pdk = (obj.pendidikan != '') ? obj.pendidikan : '-';
            $('.dtl:eq(12)').html(pdk);
            $('.dtl:eq(13)').html(obj.noktp);
            $('.dtl:eq(14)').html(obj.keterangan);
            $("#foto_pegawai").attr("src","assets/images/fotopegawai/" + obj.nip + ".jpg?" + (new Date().getTime())).error(function() {
                $(this).attr("src","assets/images/fotopegawai/default.jpg?"+(new Date().getTime()));
            });
            $('#dialog-detail').dialog('option', 'title',  'Detail Pegawai' ).dialog('open');
            return false;
        });
        warnatable();
    });
/*
 *  --------------------- jabatan -----------------------------------------
 */
    //---- Dialog Tambah jabatan
    $('#dialog-jabatan').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_jabatan");
                        if (hasil['isi'] != "invalid") {
                            if ($('#dialog-jabatan').dialog('option', 'title') == "Tambah jabatan") {
                                respon = ajak("param/pegawai/saveJabatan",$('#form_jabatan').serialize());
                            } else {
                                respon = ajak("param/pegawai/editJabatan",$('#form_jabatan').serialize() + "&id=" + jAmbil("idx"));
                            }
                            if (respon == "1") {
                                $(this).dialog("close");
                                $("#table_jabatan .reset").click();
                            } else if (respon == "1062") {
                                showinfo("Error : Nama Jabatan telah ada");
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
     $('#addjabatan').click(function() {
        $(".infonya").hide();
        $('.inp').val('');
        $('#dialog-jabatan').dialog('option', 'title',  'Tambah jabatan' ).dialog('open');
        return false;
     });

     //---- Dialog Hapus jabatan
     $('#dialog-hapus').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        respon = ajak("param/pegawai/delJabatan","id=" + jAmbil("idx"));
                        if (respon == "1") {
                            $("#table_jabatan .reset").click();;
                            $(this).dialog('close');
                        } else if (respon == "1451") {
                            showinfo("Error : Jabatan Masih Digunakan");
                        } else {
                            showinfo("Error : " + respon);
                        }
                    },
                    "Batal": function() {
                        $(this).dialog('close');
                    }
				 }
     });

     //---- Tabel jabatan
    $("#table_jabatan").mastertable({
        urlGet:"param/pegawai/get_jabatan",
        flook:"nama_jabatan"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "j" + json['alldata'][i].jabatan_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            managejab = (idx != 'j1') ? "<img class=\"chpsp\" title=\"Hapus\" src=\"assets/images/delicon.png\"/>&nbsp;<img  class=\"cedte\" title=\"Edit\" src=\"assets/images/editicon.png\"/>" : "";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama_jabatan + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].keterangan + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].jabatan_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Hapus
        $('.chpsp').click( function() {
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            $('.phps').html(obj.nama_jabatan);
            jSimpan("idx",obj.jabatan_id);
            $('#dialog-hapus').dialog('option', 'title',  'Hapus Jabatan' ).dialog('open');
            return false;
        });
        //---- Edit
        $('.cedte').click( function() {
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            $("#form_jabatan input[name='nama_jabatan']").val(obj.nama_jabatan);
            $("#form_jabatan textarea[name='keterangan']").val(obj.keterangan);
            jSimpan("idx",obj.jabatan_id);
            $('#dialog-jabatan').dialog('option', 'title',  'Edit Jabatan' ).dialog('open');
            return false;
        });
        warnatable();
    });
    
    //---- Dialog Tambah otoritas
    $('#dialog-otoritas').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_otoritas");
                        if (hasil['isi'] != "invalid") {
                            if ($('#dialog-otoritas').dialog('option', 'title') == "Tambah otoritas") {
                                respon = ajak("param/pegawai/saveotoritas",$('#form_otoritas').serialize());
                            } else {
                                respon = ajak("param/pegawai/editotoritas",$('#form_otoritas').serialize() + "&id=" + jAmbil("idx"));
                            }
                            if (respon == "1") {
                                $(this).dialog("close");
                                $("#table_otoritas .reset").click();
                            } else if (respon == "1062") {
                                showinfo("Error : Kode otoritas sudah ada");
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
     $('#addotoritas').click(function() {
        $(".infonya").hide();
        $('.inp').val('');
        isi = ajak('param/tabungan/isi_level');
        $("#form_otoritas select[name='level']").html(isi);
        $('#dialog-otoritas').dialog('option', 'title',  'Tambah otoritas' ).dialog('open');
        return false;
     });

     //---- Dialog Hapus
     $('#dialog-hapus-otoritas').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        respon = ajak("param/pegawai/delotoritas","id=" + jAmbil("idx"));
                        if (respon == "1") {
                            $("#table_otoritas .reset").click();;
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
     $("#table_otoritas").mastertable({
        urlGet:"param/pegawai/get_otoritas",
        flook:"kode"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "j" + json['alldata'][i].otoritas_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            managejab = "<img class=\"chps\" title=\"Hapus\" src=\"assets/images/delicon.png\"/>&nbsp;&nbsp;&nbsp;<img  class=\"cedt\" title=\"Edit\" src=\"assets/images/editicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].kode + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama_jabatan + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].otoritas_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Hapus
        $('.chps').click( function() {
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            $('.phps').html(obj.range_otoritas);
            jSimpan("idx",obj.otoritas_id);
            $('#dialog-hapus-otoritas').dialog('option', 'title',  'Hapus otoritas Pekerjaan' ).dialog('open');
            return false;
        });
        //---- Edit
        $('.cedt').click( function() {
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            $("#form_otoritas input[name='kode']").val(obj.kode);
            isi = ajak('param/tabungan/isi_level');
            $("#form_otoritas select[name='level']").html(isi);
            $("#form_otoritas select[name='level']").val(obj.level);
            jSimpan("idx",obj.otoritas_id);
            $('#dialog-otoritas').dialog('option', 'title',  'Edit otoritas Pekerjaan' ).dialog('open');
            return false;
        });
        warnatable();
    });
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
    
});