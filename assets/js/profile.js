/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : profile.js
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
    $('#save_a').click(function() {
        respon = ajak("profile/editprofile",$('#form_profile').serialize());
		  if(respon == 1){
		  		//window.location.replace("auth/logout");
		  }
		  //loadprofile();
    });
    loadprofile();
    function loadprofile(){
        $.post("profile/get_info","",
            function(json){
                var isi ="";
                for(i = 0; i < json['alldata'].length; i++) {
                    $('#username').val(json['alldata'][i].username);
                    $('#nama_pegawai').val(json['alldata'][i].nama_pegawai);
                    
                }
                
            }, "json");
        return false;
    }
    $(".reset").click();
});
