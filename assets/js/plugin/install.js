/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : plugin/install.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    
    $("#tab-utama").tabs();
    $('.infoproses').hide();
    $('#uploadplugin').click( function() {
        $("<iframe id=\"upload_target\" name=\"upload_target\" style=\"width:0;height:0;border:0px;\"></iframe>").appendTo("body");
        $('#dialog-upload').dialog('option', 'title',  'Upload Plugin' ).dialog('open');
        return false;
    });
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
                            	$(this).dialog('close');
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
    $('#dialog-hapus').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                    	respon = ajak("plugin/install/delplugin","id=" + jAmbil("idx") +"&path=" + jAmbil("pathx"));
                    	if (respon == "1") {
                            $("#table_plugin .reset").click();
                            $(this).dialog('close');
                        }else {
                            showinfo("Error : " + respon);
                        }
                    },
                    "Batal": function() {
                        $(this).dialog('close');
                    }
				 }
     });
    $("#table_plugin").mastertable({
        urlGet:"plugin/install/get_plugin",
        flook:"name_plugin"
    },
    function(hal,juml,json) {
        var isi="";
        if(json['total'] > 0){
        	for(i = 0; i < json['alldata'].length; i++) {
                idx = "j" + json['alldata'][i].plugin_id;
                dtx = json['alldata'][i];
                jSimpan(idx,dtx);
                var act = (json['alldata'][i].status == '1') ? "icontruechecklist" : "icontruechecklist1";
                managejab = "<img class=\"mact\" src=\"assets/images/"+ act +".png\" title=\"Active/Non Active\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img class=\"chps\" title=\"delete\" src=\"assets/images/delicon.png\"/>";
                isi += "<tr style=\"vertical-align:top;\">"
                    + "<td align=\"center\">" + json['alldata'][i].name_plugin + "</td>"
                    + "<td align=\"left\">" + json['alldata'][i].path + "</td>"
                    + "<td align=\"left\">" + json['alldata'][i].desc + "</td>"
                    + "<td nowrap=\"nowrap\" align=\"center\">"+managejab + "</td>"
                    + "<td align=\"center\">" + json['alldata'][i].plugin_id + "</td>"
                    + "</tr>";
            }
        }
        
        return isi;
    },
    function domIsi() {
        //---- Hapus
        $('.chps').click( function() {
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            $('.phps').html(obj.name_plugin);
            jSimpan("pathx",obj.path);
            jSimpan("idx",obj.plugin_id);
            $('#dialog-hapus').dialog('option', 'title',  'Hapus' ).dialog('open');
            return false;
        });
      //---- Hapus
        $('.mact').click( function() {
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            id = obj.plugin_id;
            val = ($(this).attr('src') == 'assets/images/icontruechecklist1.png') ? 1 : 0;
            respon = ajak("plugin/install/toogleActive","id=" + id + "&val=" + val);
            if (respon == "1") { $("#table_plugin .reset").click(); }
            return false;
        });
        warnatable();
    });
    $(".reset").click();
    //menu
    getmenu();
    function getmenu() {
	    respon = ajak("plugin/install/getMenu");
	    $('#imenu').html(respon);
	    $('.mhps,.medt').css('cursor','pointer');
	    //-- Toogle Active
        $('.mact').click(function(){
            id = $(this).parent().attr('id');
            val = ($(this).attr('src') == 'assets/images/starsmall.png') ? 0 : 1;
            respon = ajak("param/setupmenu/toogleActive","id=" + id + "&val=" + val);
            if (respon == "1") { getmenu(); }
        });
        //-- Hapus
        $('.mhps').click(function() {
            id = $(this).parent().attr('id');
            $('.phps').html(" ID menu [" + id + "] ");
            jSimpan("idx", id);
            $('#dialog-hapus-menu').dialog('option', 'title',  'Hapus Menu' ).dialog('open');
        });
        $('.medt').click(function() {
            $(".infonya").hide();
            id = $(this).parent().attr('id');
            jSimpan("idx", id);
            $.post("param/setupmenu/getMenuById", "id=" + id,
               function(obj){
            	isi = ajak('plugin/install/isi_parent');
                $('select[name="parent"]').html(isi);
                isi = ajak('param/setupmenu/isi_groups');
                $("select[name='groups[]']").html(isi);
                
                isi = ajak('plugin/install/isi_menuplugin');
                $("#form_menu select[name='href']").html("<option value=\"\">---------------</option>" +isi);
                 isi = ajak('param/setupmenu/isi_groups');
                 $("select[name='groups[]']").html(isi);
                 $(".inp:eq(0)").val(obj.nama);
                 $(".inp:eq(1)").val(obj.href);
                 $(".inp:eq(2)").val(obj.css);
                 $(".inp:eq(3)").val(obj.sub);
                 $('select[name="parent"]').val(obj.parent);
                 $(".inp:eq(4)").val(obj.urutan);
                 $("select[name='groups[]'] option").each(function(i) {
                    for ( ii in obj.groups ){
                        if ($(this).text() == obj.groups[ii]) {
                            $(this).attr("selected", "selected");
                        }
                    }
                  });
                 if (obj.active != "1") {
                        $('#active').removeAttr('checked');
                 } else {
                        $('#active').attr('checked','checked');
                 }
               }, "json");
            $('#dialog-menu').dialog('option', 'title',  'Edit Menu' ).dialog('open');
        });
    }
    $('#dialog-menu').dialog({autoOpen: false,width: 450,modal: true,
        buttons: {
            "Ok": function() {
                hasil = validform("form_menu");
                if (hasil['isi'] != "invalid" && ($("select[name='groups[]']").val() != null)) {
                    if ($('#dialog-menu').dialog('option', 'title') == "Tambah Menu") {
                        respon = ajak("param/setupmenu/saveMenu",$('#form_menu').serialize()+ "&active=" + $("#active:checked").length);
                    } else {
                        respon = ajak("param/setupmenu/editMenu",$('#form_menu').serialize()+ "&active=" + $("#active:checked").length + "&id=" + jAmbil("idx"));
                    }
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

    //---- Tambah Menu
    $('#addmenu').click(function() {
        $(".infonya").hide();
        $('.inp').val('');
        $('input[name="active"]').attr('checked','checked');
        isi = ajak('plugin/install/isi_parent');
        $('select[name="parent"]').html(isi);
        isi = ajak('param/setupmenu/isi_groups');
        $("select[name='groups[]']").html(isi);
        
        isi = ajak('plugin/install/isi_menuplugin');
        $("#form_menu select[name='href']").html("<option value=\"\">---------------</option>" +isi);
        
        $('#form_menu input[name="css"]').val('plugin');
        
        $('#dialog-menu').dialog('option', 'title',  'Tambah Menu' ).dialog('open');
        return false;
    });
    $('#form_menu select[name="href"]').change(function() {
        var id = $(this).val().split('/plugin/view/main/');
        $('#form_menu input[name="sub"]').val(id[1]);
        return false;
    });
  //--- Dialog Hapus Menu
    $('#dialog-hapus-menu').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        respon = ajak("param/setupmenu/delMenu","id=" + jAmbil("idx"));
                        if (respon == "1") {
                        	window.location = "plugin/install";
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
});
