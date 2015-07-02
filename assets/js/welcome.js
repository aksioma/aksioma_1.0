/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : welcome.js
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
    
    $("#table_session").mastertable({
        urlGet:"welcome/get_session",
        flook:"last_login"
    },
    function(hal,juml,json) {
        var isi="";
        for(i = 0; i < json['alldata'].length; i++) {
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].username + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].from_host + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].last_login + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //----
        warnatable();
    });
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
