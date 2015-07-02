/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/setupmenu.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
if (top.location!= self.location) {
	top.location = self.location.href;
}
$(document).ready(function(){
    //---- Inisialisasi
    $('.jclock').jclock({format: '%A, %d %B %Y - %H:%M:%S %P'});
    
    $("#tab-utama").tabs();
    getmenu();

/*
 *  --------------------- MENU -----------------------------------------
 */
    //---- Get Menu
    function getmenu() {
        respon = ajak("param/setupmenu/getMenu");
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
            $('#dialog-hapus').dialog('option', 'title',  'Hapus Menu' ).dialog('open');
        });
        //-- Edit
        $('.medt').click(function() {
            $(".infonya").hide();
            id = $(this).parent().attr('id');
            jSimpan("idx", id);
            $.post("param/setupmenu/getMenuById", "id=" + id,
               function(obj){
                 isi = ajak('param/setupmenu/isi_parent');
                 $('select[name="parent"]').html("<option value=\"0\">[0] Root</option>" + isi);
                 isi = ajak('param/setupmenu/isi_groups');
                 $("select[name='groups[]']").html(isi);
                 $(".inp:eq(0)").val(obj.nama);
                 $(".inp:eq(1)").val(obj.href);
                 $(".inp:eq(2)").val(obj.icon);
                 $(".inp:eq(3)").val(obj.css);
                 $(".inp:eq(4)").val(obj.sub);
                 //valsel = $('select[name="parent"] option[value="'+obj.parent+'"]').text();
                 $('select[name="parent"]').val(obj.parent);
                 $(".inp:eq(6)").val(obj.urutan);
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

    //---- Dialog tambah menu
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
        isi = ajak('param/setupmenu/isi_parent');
        $('select[name="parent"]').html("<option value=\"0\">[0] Root</option>" + isi);
        isi = ajak('param/setupmenu/isi_groups');
        $("select[name='groups[]']").html(isi);
        $('#dialog-menu').dialog('option', 'title',  'Tambah Menu' ).dialog('open');
        return false;
    });

    //--- Dialog Hapus Menu
    $('#dialog-hapus').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        respon = ajak("param/setupmenu/delMenu","id=" + jAmbil("idx"));
                        if (respon == "1") {
                            getmenu();
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