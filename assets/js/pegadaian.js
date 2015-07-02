/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : pegadaian.js
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
    
    
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
