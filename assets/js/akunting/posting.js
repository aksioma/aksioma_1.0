/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : akunting/posting.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    var adminouth = 0;
/*
*  --------------------- koreksi -----------------------------------------
*/
	$('.cariKoreksi').click( function() {
		loadkoreksi($("#tgl1").val(),$("#tgl2").val());
	});
	function loadkoreksi(tgltrans1,tgltrans2){
	    $("#tb_view1").html("");
	    $.post("akunting/posting/get_koreksiview","tgl1="+ tgltrans1 + "&tgl2="+ tgltrans2,
	        function(json){
	            var isi ="";
	            var totkredit = 0, totdebet = 0;
	            for(i = 0; i < json['alldata'].length; i++) {
	                idx = "t" + json['alldata'][i].accounttrans_id;
	                dtx = json['alldata'][i];
	                jSimpan(idx,dtx);
	                var account,kredit = 0,debet =0;
	                if(json['alldata'][i].accounttrans_listid != 0){ 	
	                    account = json['alldata'][i].accounttrans_listid;
	                    if(json['alldata'][i].accounttrans_type == "01"){
	                        kredit = json['alldata'][i].accounttrans_value;
	                    }else{
	                        debet = json['alldata'][i].accounttrans_value;
	                    }
	                }else{
	                    if((json['alldata'][i].accounttrans_ref == 0)&&(json['alldata'][i].accounttrans_direct != 0)){
	                        account = json['alldata'][i].accounttrans_direct;
	                        kredit = json['alldata'][i].accounttrans_value;
	                    }else{
	                        account = json['alldata'][i].accounttrans_ref;
	                        debet = json['alldata'][i].accounttrans_value;
	                    }
	                }
	                respon = ajak('akunting/jurnal/infoaccount', "id="+account);
	                ck = "<input type=\"checkbox\" class=\"case1\" name=\"case1[]\" value=\""+ json['alldata'][i].accounttrans_id +"\">";
	                isi += "<tr>"
	                    + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ ck +"</td>"
	                    + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ json['alldata'][i].accounttrans_date +"</td>"
	                    + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ json['alldata'][i].accounttrans_code +"</td>"
	                    + "<td style=\"border-top:1px solid #000\" align=\"left\">"+ json['alldata'][i].accounttrans_desc +"</td>"
	                    + "<td style=\"border-top:1px solid #000\" align=\"left\">"+ respon +"</td>"
	                    + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(debet) +"</td>"
	                    + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(kredit) +"</td>"
	                    + "</tr>";
	                totkredit += eval(kredit);
	                totdebet += eval(debet);
	            }
	            isi += "<tr>"
	                    + "<td colspan=\"5\" style=\"border-top:1px solid #000\" align=\"right\">TOTAL</td>"
	                    + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(totdebet) +"</td>"
	                    + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(totkredit) +"</td>"
	                    + "</tr>";
	            $("#tb_view1").html(isi);
	        }, "json");
	    return false;
	}
	$("#selectall1").click(function () {
		  $('.case1').attr('checked', this.checked);
	});
	$(".case1").click(function(){
		if($(".case1").length == $(".case1:checked").length) {
			$("#selectall1").attr("checked", "checked");
		} else {
			$("#selectall1").removeAttr("checked");
		}
	});
	$('.delKoreksi').click( function() {
        var val = [];
        $(':checkbox:checked').each(function(i){
            val[i] = $(this).val();
        });
        respon = ajak("akunting/posting/delkoreksi","&val=" + val);
        loadkoreksi($("#tgl1").val(),$("#tgl2").val());
    });
/*
 *  --------------------- posting -----------------------------------------
 */
    $('.cariTrans').click( function() {
        loadtrans($("#tgltrans1").val(),$("#tgltrans2").val());
    });
    function loadtrans(tgltrans1,tgltrans2){
        $("#tb_view").html("");
        $.post("akunting/posting/get_transaksiview","tgl1="+ tgltrans1 + "&tgl2="+ tgltrans2,
            function(json){
                var isi ="";
                var totkredit = 0, totdebet = 0;
                for(i = 0; i < json['alldata'].length; i++) {
                    idx = "t" + json['alldata'][i].accounttrans_id;
                    dtx = json['alldata'][i];
                    jSimpan(idx,dtx);
                    var account,kredit = 0,debet =0;
                    if(json['alldata'][i].accounttrans_listid != 0){ 	
                        account = json['alldata'][i].accounttrans_listid;
                        if(json['alldata'][i].accounttrans_type == "01"){
                            kredit = json['alldata'][i].accounttrans_value;
                        }else{
                            debet = json['alldata'][i].accounttrans_value;
                        }
                    }else{
                        if((json['alldata'][i].accounttrans_ref == 0)&&(json['alldata'][i].accounttrans_direct != 0)){
                            account = json['alldata'][i].accounttrans_direct;
                            kredit = json['alldata'][i].accounttrans_value;
                        }else{
                            account = json['alldata'][i].accounttrans_ref;
                            debet = json['alldata'][i].accounttrans_value;
                        }
                    }
                    respon = ajak('akunting/jurnal/infoaccount', "id="+account);
                    ck = "<input type=\"checkbox\" class=\"case\" name=\"case[]\" value=\""+ json['alldata'][i].accounttrans_id +"\">";
                    isi += "<tr>"
                        + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ ck +"</td>"
                        + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ json['alldata'][i].accounttrans_date +"</td>"
                        + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ json['alldata'][i].accounttrans_code +"</td>"
                        + "<td style=\"border-top:1px solid #000\" align=\"left\">"+ json['alldata'][i].accounttrans_desc +"</td>"
                        + "<td style=\"border-top:1px solid #000\" align=\"left\">"+ respon +"</td>"
                        + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(debet) +"</td>"
                        + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(kredit) +"</td>"
                        + "</tr>";
                    totkredit += eval(kredit);
                    totdebet += eval(debet);
                }
                isi += "<tr>"
                        + "<td colspan=\"5\" style=\"border-top:1px solid #000\" align=\"right\">TOTAL</td>"
                        + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(totdebet) +"</td>"
                        + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(totkredit) +"</td>"
                        + "</tr>";
                $("#tb_view").html(isi);
            }, "json");
        return false;
    }
    $("#selectall").click(function () {
		  $('.case').attr('checked', this.checked);
	});
    $(".case").click(function(){
		if($(".case").length == $(".case:checked").length) {
			$("#selectall").attr("checked", "checked");
		} else {
			$("#selectall").removeAttr("checked");
		}
	});
    
    $('.postingTrans').click( function() {
        var val = [];
        $(':checkbox:checked').each(function(i){
            val[i] = $(this).val();
        });
        respon = ajak("akunting/posting/updatepost","&val=" + val);
        loadtrans($("#tgltrans1").val(),$("#tgltrans2").val());
    });
    $('.delTrans').click( function() {
        var val = [];
        $(':checkbox:checked').each(function(i){
            val[i] = $(this).val();
        });
        respon = ajak("akunting/posting/delpost","&val=" + val);
        loadtrans($("#tgltrans1").val(),$("#tgltrans2").val());
    });
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
