/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/user.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    $('.jclock').jclock({format: '%A, %d %B %Y - %H:%M:%S %P'});
    
 //---- Inisialisasi
    $("#tab-utama").tabs();
    getmenu();
    function getmenu() {
        respon = ajak("param/user/getMenu");
        $('#imenu').html(respon);
        $('.macte,.medte').css('cursor','pointer');
            //-- Toogle Active
        $('.macte').click(function(){
            id = $(this).parent().attr('id');
            val = ($(this).attr('src') == 'assets/images/starsmall.png') ? 0 : 1;
            respon = ajak("param/setupmenu/toogleActive","id=" + id + "&val=" + val);
            if (respon == "1") { getmenu(); }
        });
        //-- Edit
        $('.medte').click(function() {
            $(".infonya").hide();
            id = $(this).parent().attr('id');
            jSimpan("idx", id);
            $.post("param/user/getMenuById", "id=" + id,
                function(obj){
                    $("#form_menu input[name='nama']").val(obj.nama);
                    $("#form_menu input[name='urutan']").val(obj.urutan);
                    isi = ajak('param/setupmenu/isi_groups');
                    $("select[name='groups[]']").html(isi);
                    $("select[name='groups[]'] option").each(function(i) {
                        for ( ii in obj.groups ){
                            if ($(this).text() == obj.groups[ii]) {
                                $(this).attr("selected", "selected");
                            }
                        }
                    });
                     
                }, "json");
            $('#dialog-menu').dialog('option', 'title',  'Edit Menu' ).dialog('open');
        });
    }
    //---- Dialog Tambah otoritas
    $('#dialog-otoritas').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_otoritas");
                        if (hasil['isi'] != "invalid") {
                            if ($('#dialog-otoritas').dialog('option', 'title') == "Tambah otoritas") {
                                respon = ajak("param/user/saveotoritas",$('#form_otoritas').serialize());
                            } else {
                                respon = ajak("param/user/editotoritas",$('#form_otoritas').serialize() + "&id=" + jAmbil("idx"));
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
        isi = ajak('param/user/isi_level');
        $("#form_otoritas select[name='level']").html(isi);
        $('#dialog-otoritas').dialog('option', 'title',  'Tambah otoritas' ).dialog('open');
        return false;
     });

     //---- Dialog Hapus
     $('#dialog-hapus-otoritas').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        respon = ajak("param/user/delotoritas","id=" + jAmbil("idx"));
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

     //---- Tabel otoritas pekerjaan
    $("#table_otoritas").mastertable({
        urlGet:"param/user/get_otoritas",
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
            $('#form_otoritas .inp:eq(0)').val(obj.kode);
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
        flook:"nama_pegawai"
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
                + "<td align=\"center\">" + json['alldata'][i].nama_pegawai + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].username + "</td>"
                + "<td align=\"center\">" + manageact + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].nama_group + "</td>"
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
            $("#form_user select[name='id_group']").val(obj.nama_group);
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
 *  --------------------- GROUP -----------------------------------------
 */
   //---- Dialog Tambah group
    $('#dialog-group').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        hasil = validform("form_group");
                        if (hasil['isi'] != "invalid" && ($('#form_group .slct').val() != null)) {
                            if ($('#dialog-group').dialog('option', 'title') == "Tambah Group") {
                                respon = ajak("param/user/saveGroup",$('#form_group').serialize());
                            } else {
                                respon = ajak("param/user/editGroup",$('#form_group').serialize() + "&id=" + jAmbil("idx"));
                            }
                            if (respon == "1") {
                                $(this).dialog("close");
                                $("#table_group .reset").click();
                            } else if (respon == "1062") {
                                showinfo("Error : Nama Group telah ada");
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

     $('#addgroup').click(function() {
        $(".infonya").hide();
        $('#form_group .inp,#form_group .slct').val('');
        $('#form_group .inp').removeAttr('disabled');
        $('#dialog-group').dialog('option', 'title',  'Tambah Group' ).dialog('open');
        return false;
     });

      //---- Dialog Hapus group
     $('#dialog-hapus-group').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        respon = ajak("param/user/delGroup","id=" + jAmbil("idx"));
                        if (respon == "1") {
                            $("#table_group .reset").click();;
                            $(this).dialog('close');
                         } else if (respon == "1451") {
                            showinfo("Error : Group Masih Digunakan");
                         } else {
                            showinfo("Error : " + respon);
                        }
                    },
                    "Batal": function() {
                        $(this).dialog('close');
                    }
				 }
     });

     //---- Jika Select Controller di pilih
     $('#form_group option').click(function() {
          if($(this).parent().attr("label") == 'Admin') {
              $('#form_group select').find("option:[value='param/main'],option:[value='param/welcome']").attr("selected", "selected");
          }
     });

     //---- Tabel group
    $("#table_group").mastertable({
        urlGet:"param/user/get_group",
        flook:"nama_group"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "g" + json['alldata'][i].group_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            managegrp = (json['alldata'][i].nama_group != 'Admin') ? "<img class=\"chpsg\" title=\"Hapus\" src=\"assets/images/delicon.png\"/>&nbsp;" : "";
            isi += "<tr>"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].nama_group + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].controller + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managegrp + "<img  class=\"cedtg\" title=\"Edit\" src=\"assets/images/editicon.png\"/></td>"
                + "<td align=\"center\">" + json['alldata'][i].group_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Hapus
        $('.chpsg').click( function() {
            $(".infonya").hide();
            obj = jAmbil("g" + $(this).parent().next().text());
            $('.phps').html(obj.nama_group);
            jSimpan("idx",obj.group_id);
            $('#dialog-hapus-group').dialog('option', 'title',  'Hapus Group' ).dialog('open');
            return false;
        });
        //---- Edit
        $('.cedtg').click( function() {
            $(".infonya").hide();
            obj = jAmbil("g" + $(this).parent().next().text());
            $('#form_group .inp').val(obj.nama_group);
            if (obj.nama_group == 'Admin'){
                $('#form_group .inp').attr('disabled','disabled');
            } else {
                $('#form_group .inp').removeAttr('disabled');
            }
            contr = $(this).parent().prev().html();
            temp = contr.split("<br>");
            $('#form_group option').each(function() {
                $(this).removeAttr("selected");
                for ( ii in temp ){
                    if ($(this).val() == temp[ii]) {
                        $(this).attr("selected", "selected");
                    }
                }
             });
            jSimpan("idx",obj.group_id);
            $('#dialog-group').dialog('option', 'title',  'Edit Group' ).dialog('open');
            return false;
        });
        warnatable();
    });
    
    //---- Dialog tambah menu
    $('#dialog-menu').dialog({autoOpen: false,width: 450,modal: true,
        buttons: {
            "Ok": function() {
                hasil = validform("form_menu");
                if (hasil['isi'] != "invalid" && ($("select[name='groups[]']").val() != null)) {
                    respon = ajak("param/setupmenu/editMenu",$('#form_menu').serialize()+ "&active=1" + "&id=" + jAmbil("idx"));
                    if (respon == "1") {
                        getmenu();
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
    
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();

});
