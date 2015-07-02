/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : monitor/npf.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    $('.infoproses').hide();
    var adminouth = 0;
    $.post("param/bmt/get_bmtinfo","id=1",
            function(obj){
               $('#bmttitle').html(obj['alldata'][0].nama+"<br>"+ obj['alldata'][0].kota +" - "+ obj['alldata'][0].namaProvinsi);
            }, "json");
    
    $('.infoproses1').hide();
    $('.ok1').hide();
    $('#aPembiayaan').click(function() {
    	$('.ok1').hide();
    	$('.infoproses1').show();
        respon = ajak("tool/cronjob/pembiayaan");
        if(respon == "1"){
        	$('.ok1').show();
        	$('.infoproses1').hide();
        }
        return false;
    });
/*
 *  --------------------- pembiayaan -----------------------------------------
 */
    
    $('.cariData').click( function() {
    	//var isitglawal =  revDate($('#tgl1').val(),"-");
        var isitglakhir =  revDate($('#tgl2').val(),"-");
        /*if (Date.parse(isitglawal) > Date.parse(isitglakhir)) {
            showinfo("Tanggal Awal Harus lebih kecil dari Tanggal Akhir");
            return false;
        }
        if(($('#tgl2').val().substr(6, 4) - $('#tgl1').val().substr(6, 4)) > 0) {
            selisihx = (($('#tgl2').val().substr(3, 2)*1) + 12) - ($('#tgl1').val().substr(3, 2)*1)
            if(selisihx > 11) {
                showinfo("Selisih Bulan Periode max 12 bulan");
                return false;
            }
        }*/
        isitglperiode = cbulan($('#tgl2').val());
        $('#isitgl').html(isitglperiode);
        loaddataPembiayaan("",$("#tgl2").val(),$("#f").val(),$("#if").val());
	});
    function loaddataPembiayaan(tgl1,tgl2,fv,ifv){
    	$('.infoproses').show();
    	$("#tb_viewp").html("");
        $.post("monitor/npf/get_dataview","tgl1="+ tgl1 +"&tgl2="+ tgl2 +"&fv="+ fv +"&ifv="+ ifv,
             function(json){
                 var isi ="";
                 var isicol = "";
                 var col,coli;
                 var coli1="",coli2="",coli3="",coli4="",coli5="";
                 var col1="",col2="",col3="",col4="",col5="";
                 
                 var bisicol = "";
                 var bcol,bcoli;
                 var bcoli1="",bcoli2="",bcoli3="",bcoli4="",bcoli5="";
                 var bcol1="",bcol2="",bcol3="",bcol4="",bcol5="";
                 
                 var misicol = "";
                 var mcol,mcoli;
                 var mcoli1="",mcoli2="",mcoli3="",mcoli4="",mcoli5="";
                 var mcol1="",mcol2="",mcol3="",mcol4="",mcol5="";
                 
                 $.get("monitor/npf/get_paramcol","",
            			 function(json){
                	 		for(i = 0; i < json.length; i++) {
            	         		isicol += json[i].kode +" : "+ json[i].type_kolekbilitas+", ";
            	         		if(i==0){
            	         			col1   = json[i].parameter;
            	         			coli1 = json[i].kode;
            	         		}else if(i==1){
            	         			col2   = json[i].parameter;
            	         			coli2 = json[i].kode;
            	         		}else if(i==2){
            	         			col3   = json[i].parameter;
            	         			coli3 = json[i].kode;
            	         		}else if(i==3){
            	         			col4   = json[i].parameter;
            	         			coli4 = json[i].kode;
            	         		}else if(i==4){
            	         			col5   = json[i].parameter;
            	         			coli5 = json[i].kode;
            	         		}
            	         	}
            	 }, "json");
            	 $.get("monitor/npf/get_paramcol1","",
            			 function(json){
                	 		for(i = 0; i < json.length; i++) {
            	         		bisicol += json[i].kode +" : "+ json[i].type_kolekbilitas+", ";
            	         		if(i==0){
            	         			bcol1   = json[i].parameter;
            	         			bcoli1 = json[i].kode;
            	         		}else if(i==1){
            	         			bcol2   = json[i].parameter;
            	         			bcoli2 = json[i].kode;
            	         		}else if(i==2){
            	         			bcol3   = json[i].parameter;
            	         			bcoli3 = json[i].kode;
            	         		}else if(i==3){
            	         			bcol4   = json[i].parameter;
            	         			bcoli4 = json[i].kode;
            	         		}else if(i==4){
            	         			bcol5   = json[i].parameter;
            	         			bcoli5 = json[i].kode;
            	         		}
            	         	}
            	 }, "json");
            	 $.get("monitor/npf/get_paramcol2","",
            			 function(json){
                	 		for(i = 0; i < json.length; i++) {
            	         		misicol += json[i].kode +" : "+ json[i].type_kolekbilitas+", ";
            	         		if(i==0){
            	         			mcol1   = json[i].parameter;
            	         			mcoli1 = json[i].kode;
            	         		}else if(i==1){
            	         			mcol2   = json[i].parameter;
            	         			mcoli2 = json[i].kode;
            	         		}else if(i==2){
            	         			mcol3   = json[i].parameter;
            	         			mcoli3 = json[i].kode;
            	         		}else if(i==3){
            	         			mcol4   = json[i].parameter;
            	         			mcoli4 = json[i].kode;
            	         		}else if(i==4){
            	         			mcol5   = json[i].parameter;
            	         			mcoli5 = json[i].kode;
            	         		}
            	         	}
            	 }, "json");
                 var pokok = 0,margin = 0, angsuranpokok = 0,angsuranmargin = 0,totalangs=0,total1=0,total2=0,total3=0,total4=0,total5=0,total6=0;
                 var lancar = 0,kuranglancar = 0, diragukan = 0, macet = 0;
                 for(i = 0; i < json['alldata'].length; i++) {
                	 if(eval(json['alldata'][i].harga_pokok) != 0){
	                	 pokok = eval(json['alldata'][i].harga_pokok);
	                	 margin = eval(json['alldata'][i].marjin);
	                 }else if(eval(json['alldata'][i].modal)  != 0){
		             	pokok = eval(json['alldata'][i].modal) ; 
		             	 margin = json['alldata'][i].marjin;
		             }else if(eval(json['alldata'][i].pinjaman)  != 0){
		             	pokok = eval(json['alldata'][i].pinjaman) ; 
		             	margin = 0;
    				 }
                	 totalpm = eval(pokok) + eval(margin);
                	 var angsuran = ajak("monitor/npf/get_dataangsuran","id="+ json['alldata'][i].pembiayaan_id);
                	 var res = angsuran.split("#"); 
                	 totalangs = eval(res[0]) + eval(res[1]);
                	 //total angsuran
                	 var resp = ajak("monitor/npf/get_totalangsuran","id="+ json['alldata'][i].nomor_rekening + "&tgl2="+ tgl2);
                	 var items = resp.split("#"); 
                	 TotAngsuranPokok = eval(items[0]);
                	 TotAngsuranMargin = eval(items[1]);
                	 TotAngsuranReal = eval(TotAngsuranPokok) + eval(TotAngsuranMargin);
                	 //menghitung NPF
                	 // L  : Lancar = 0
                	 // KL : Kurang Lancar = 1 - 2
                	 // D  : Diragukan = 3
                	 // M  : Macet >= 4
                	 var coltrans = ajak("monitor/npf/get_coltrans","id="+ json['alldata'][i].nomor_rekening +"&tgl1="+ tgl1 +"&tgl2="+ tgl2);
                	 var coljadwal = ajak("monitor/npf/get_coljadwal","id="+ json['alldata'][i].pembiayaan_id +"&tgl1="+ tgl1 +"&tgl2="+ tgl2);
                	 var col = eval(coljadwal) - eval(coltrans);
                	 var colk;
                	 if(json['alldata'][i].type_angsuran == "HARI") {	
                	    var ncol2 = col2.split(' - ');
                	    if(col < col1){
                		    colk = coli1;
                		    lancar += eval(totalpm) - eval(TotAngsuranReal);
                	    }else if((col == ncol2[0])||(col == ncol2[1])){
                		    colk = coli2;
                		    kuranglancar += eval(totalpm) - eval(TotAngsuranReal);
                	    }else if(col == col3){
                		    colk = coli3;
                		    diragukan += eval(totalpm) - eval(TotAngsuranReal);
                	    }else if(col >= col4){
                		    colk = coli4; 
                		    macet += eval(totalpm) - eval(TotAngsuranReal);
                	    }
                	}else if(json['alldata'][i].type_angsuran == "BULAN") {	
                	    var ncol2 = bcol2.split(' - ');
                	    if(col < bcol1){
                		    colk = bcoli1;
                		    lancar += eval(totalpm) - eval(TotAngsuranReal);
                	    }else if((col == ncol2[0])||(col == ncol2[1])){
                		    colk = bcoli2; 
                		    kuranglancar += eval(totalpm) - eval(TotAngsuranReal);
                	    }else if(col == bcol3){
                		    colk = bcoli3; 
                		    diragukan += eval(totalpm) - eval(TotAngsuranReal);
                	    }else if(col >= bcol4){
                		    colk = bcoli4; 
                		    macet += eval(totalpm) - eval(TotAngsuranReal);
                	    }
                	}else if(json['alldata'][i].type_angsuran == "MINGGU") {	
                	    var ncol2 = mcol2.split(' - ');
                	    if(col < mcol1){
                		    colk = mcoli1;
                		    lancar += eval(totalpm) - eval(TotAngsuranReal);
                	    }else if((col == ncol2[0])||(col == ncol2[1])){
                		    colk = mcoli2; 
                		    kuranglancar += eval(totalpm) - eval(TotAngsuranReal);
                	    }else if(col == mcol3){
                		    colk = mcoli3; 
                		    diragukan += eval(totalpm) - eval(TotAngsuranReal);
                	    }else if(col >= mcol4){
                		    colk = mcoli4; 
                		    macet += eval(totalpm) - eval(TotAngsuranReal);
                	    }
                	}
						//outstanding = ajak("monitor/npf/get_outstanding","id="+ json['alldata'][i].nomor_rekening +"&tgl1="+ tgl1 +"&tgl2="+ tgl2 +"&id1="+ json['alldata'][i].pembiayaan_id);
                	 outstanding = eval(totalpm) - eval(TotAngsuranReal);
                	 isi += "<tr>"
                		 + "<td style=\"border-top:1px solid #000;border-right:1px solid #000\" align=\"center\">"+ json['alldata'][i].nomor_rekening +"</td>" 
                		 + "<td style=\"border-top:1px solid #000;border-right:1px solid #000\" align=\"left\">"+ json['alldata'][i].nama +"</td>" 
                		 + "<td style=\"border-top:1px solid #000;border-right:1px solid #000\" align=\"center\">"+ json['alldata'][i].nama_pegawai +"</td>" 
                		 + "<td style=\"border-top:1px solid #000;border-right:1px solid #000\" align=\"center\">"+ revDate(json['alldata'][i].tgl_dibuka,'-') +"</td>" 
                		 + "<td style=\"border-top:1px solid #000;border-right:1px solid #000\" align=\"center\">"+ revDate(json['alldata'][i].jatuh_tempo,'-') +"</td>" 
                		 + "<td style=\"border-top:1px solid #000;border-right:1px solid #000\" align=\"right\">"+ format_uang(pokok) +"</td>" 
                		 + "<td style=\"border-top:1px solid #000;border-right:1px solid #000\" align=\"right\">"+ format_uang(margin) +"</td>" 
                		 + "<td style=\"border-top:1px solid #000;border-right:1px solid #000\" align=\"right\">"+ format_uang(totalpm) +"</td>" 
                		 + "<td style=\"border-top:1px solid #000;border-right:1px solid #000\" align=\"right\">"+ format_uang(TotAngsuranPokok) +"</td>" 
                		 + "<td style=\"border-top:1px solid #000;border-right:1px solid #000\" align=\"right\">"+ format_uang(TotAngsuranMargin) +"</td>" 
                		 + "<td style=\"border-top:1px solid #000;border-right:1px solid #000\" align=\"right\">"+ format_uang(TotAngsuranReal) +"</td>" 
                		 + "<td style=\"border-top:1px solid #000;border-right:1px solid #000\" align=\"right\">"+ format_uang(outstanding) +"</td>" 
                		 + "<td style=\"border-top:1px solid #000;border-right:1px solid #000\" align=\"center\">"+ json['alldata'][i].type_angsuran +"</td>" 
                		 + "<td style=\"border-top:1px solid #000;border-right:1px solid #000\" align=\"center\">"+ coljadwal +"</td>" 
                		 + "<td style=\"border-top:1px solid #000;border-right:1px solid #000\" align=\"center\">"+ coltrans +"</td>" 
                		 + "<td style=\"border-top:1px solid #000;border-right:1px solid #000\" align=\"center\">"+ colk +"</td>" 
                		 + "</tr>";
                	 total1 += eval(pokok);
                	 total2 += eval(margin);
                	 total3 += eval(totalpm);
                	 total4 += eval(res[0]);
                	 total5 += eval(res[1]);
                	 total6 += totalangs;
                 }  
                 isi += "<tr>"
            		 + "<td style=\"border-top:1px solid #000;border-bottom:1px solid #000\" align=\"right\" colspan=\"5\">TOTAL</td>" 
            		 + "<td style=\"border-top:1px solid #000;border-bottom:1px solid #000\" align=\"right\">"+ format_uang(total1) +"</td>" 
            		 + "<td style=\"border-top:1px solid #000;border-bottom:1px solid #000\" align=\"right\">"+ format_uang(total2) +"</td>" 
            		 + "<td style=\"border-top:1px solid #000;border-bottom:1px solid #000\" align=\"right\">"+ format_uang(total3) +"</td>" 
            		 + "<td style=\"border-top:1px solid #000;border-bottom:1px solid #000\" align=\"right\">"+ format_uang(total4)+"</td>" 
            		 + "<td style=\"border-top:1px solid #000;border-bottom:1px solid #000\" align=\"right\">"+ format_uang(total5) +"</td>" 
            		 + "<td style=\"border-top:1px solid #000;border-bottom:1px solid #000\" align=\"right\">"+ format_uang(total6) +"</td>" 
            		 + "<td style=\"border-top:1px solid #000;border-bottom:1px solid #000\" align=\"right\"></td>" 
            		 + "<td style=\"border-top:1px solid #000;border-bottom:1px solid #000\" align=\"right\"></td>" 
            		 + "<td style=\"border-top:1px solid #000;border-bottom:1px solid #000\" align=\"right\"></td>" 
            		 + "<td style=\"border-top:1px solid #000;border-bottom:1px solid #000\" align=\"right\"></td>" 
            		 + "<td style=\"border-top:1px solid #000;border-bottom:1px solid #000\" align=\"right\"></td>" 
            		 + "</tr>";
                 isi += "<tr>"
            		 + "<td colspan=\"14\">"+ isicol +"</td>" 
            		 + "</tr>";
                 isi += "<tr>"
                	 + "<td></td>" 
                	 + "<td align='right'>Lancar<br>Kurang Lancar<br>Diragukan<br>Macet</td>" 
                	 + "<td colspan=\"10\">: Rp "+ format_uang(lancar) +"<br>: Rp "+ format_uang(kuranglancar) +"<br>: Rp "+ format_uang(diragukan) +"<br>: Rp "+ format_uang(macet) +"</td>" 
                	 + "</tr>";
                 $("#tb_viewp").html(isi);
                 $('.infoproses').hide();
         }, "json");
         return false;
    }
    $('.pcariData').click( function() {
    	//cetak
        $('#wrap-top',ctkframe.document).html($('#tlappembiayaan').html());
        $('table',ctkframe.document).css({ "width":"100%", "font-size":"12", "margin":"0" });
        window.ctkframe.print();
        return false;
    });
    $('.searchact').click(function() {
        $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
        $('#tabs-1').removeClass('active').addClass('');
        $('#tabs-2').removeClass('').addClass('active');
        return false;
    });
    
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
