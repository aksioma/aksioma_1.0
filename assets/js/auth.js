/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : auth.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/

if (top.location!= self.location) {
	top.location = self.location.href;
}

$(document).ready(function(){
	//isi = ajak('auth/isi_cabang');
    //$("#cabang").html(isi);
    $('.inp:eq(0)').val('').focus();
	$(".inp").focus(function(e) {
        //domKey($(this).attr('name'));
	}).keypress(function (e) {
  		if (e.which == 13)
  		     $('#loginbtn').click();
    });
    $('#virkey').toggle(function() {
        $('#container').slideDown('fast');
        $('.inp:eq(0)').focus();
    },function() {
        $('#container').slideUp('fast');
    });
    $('#login > a').click(function() {
        $('.inp').val('');
        return false
    });
    $('#loginbtn').click(function() {
       if ($("#input-username").val() != "" && $("#input-password").val() != "") {
			resp = ajak("auth/login",$('form').serialize());
			if (resp == "nousername") {
                $('.infonya').html("Username Tidak Terdaftar");
                return false
			} else if (resp == "wrongpass") {
                $('.infonya').html("Password Anda Salah");
                return false
			} else if (resp == "noactive") {
                $('.infonya').html("Username Tidak Aktif");
                return false
			} else if (resp == "valid") {
				window.location = ".";
                //window.parent.window.location.href = 'http://koperasi-syariah.net';
			}else{
                window.location = ".";
                //window.parent.window.location.href = 'http://koperasi-syariah.net';
            }
		} else {
            $('.infonya').html("Form Harus Diisi");
            return false
        }
    });
	
    //---- Dialog Informasi
     $('#dialog-info').dialog({autoOpen: false,width: 400,modal: true,
        buttons: {
                    "Ok": function() {
                        $(this).dialog('close');
                    }
				 }
     });


	
});


