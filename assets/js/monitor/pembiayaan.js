/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : monitor/pembiayaan.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    var adminouth = 0;
    $.post("param/bmt/get_bmtinfo","id=1",
            function(obj){
               $('#bmttitle').html(obj['alldata'][0].nama+"<br>"+ obj['alldata'][0].kota +" - "+ obj['alldata'][0].namaProvinsi);
            }, "json");
/*
 *  --------------------- pembiayaan -----------------------------------------
 */
    
    $('.pcariDatadetail').click( function() {
    	//cetak
        $('#wrap-top',ctkframe.document).html($('#tbllapangsuran').html());
        $('table',ctkframe.document).css({ "width":"100%", "font-size":"12", "margin":"0" });
        window.ctkframe.print();
        return false;
    });
    $('.pcariData').click( function() {
    	//cetak
        $('#wrap-top',ctkframe.document).html($('#tlappembiayaan').html());
        $('table',ctkframe.document).css({ "width":"100%", "font-size":"12", "margin":"0" });
        window.ctkframe.print();
        return false;
    });
    $('.cariData').click( function() {
    	var isitglawal =  revDate($('#tgl1').val(),"-");
        var isitglakhir =  revDate($('#tgl2').val(),"-");
        if (Date.parse(isitglawal) > Date.parse(isitglakhir)) {
            showinfo("Tanggal Awal Harus lebih kecil dari Tanggal Akhir");
            return false;
        }
        if(($('#tgl2').val().substr(6, 4) - $('#tgl1').val().substr(6, 4)) > 0) {
            selisihx = (($('#tgl2').val().substr(3, 2)*1) + 12) - ($('#tgl1').val().substr(3, 2)*1)
            if(selisihx > 11) {
                showinfo("Selisih Bulan Periode max 12 bulan");
                return false;
            }
        }
        isitglperiode = cbulan($('#tgl1').val())+" s/d "+ cbulan($('#tgl2').val());
        $('#isitgl').html(isitglperiode);
        loaddataPembiayaan($("#tgl1").val(),$("#tgl2").val(),$("#f").val(),$("#if").val());
	});
    function loaddataPembiayaan(tgl1,tgl2,fv,ifv){
    	$("#tb_viewp").html("");
        $.post("monitor/pembiayaan/get_dataview","tgl1="+ tgl1 +"&tgl2="+ tgl2 +"&fv="+ fv +"&ifv="+ ifv,
             function(json){
                 var isi ="";
                 var pokok = 0,margin = 0, angsuranpokok = 0,angsuranmargin = 0,totalangs=0,total1=0,total2=0,total3=0,total4=0,total5=0,total6=0;
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
                	 var angsuran = ajak("monitor/pembiayaan/get_dataangsuran","id="+ json['alldata'][i].pembiayaan_id);
                	 var res = angsuran.split("#"); 
                	 totalangs = eval(res[0]) + eval(res[1]);
                	 isi += "<tr>"
                		 + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ json['alldata'][i].nomor_rekening +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"left\">"+ json['alldata'][i].nama +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"left\">"+ json['alldata'][i].nama_pegawai +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ revDate(json['alldata'][i].tgl_dibuka,'-') +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ revDate(json['alldata'][i].jatuh_tempo,'-') +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(pokok) +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(margin) +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(totalpm) +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ res[0] +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ res[1] +"</td>" 
                		 + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ totalangs +"</td>" 
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
            		 + "</tr>";
                 $("#tb_viewp").html(isi);
         }, "json");
         return false;
    }
    $('.searchact').click(function() {
        $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
        $('#tabs-1').removeClass('active').addClass('');
        $('#tabs-2').removeClass('').addClass('active');
        return false;
    });
    //---- Tabel pembiayaan
    $("#table_datapembiayaan").mastertable({
        urlGet:"base/pembiayaan/get_pembiayaan",
        flook:"nomor_rekening"
    },
    function(hal,juml,json) {
        var isi="";
        var jenis="";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "d" + json['alldata'][i].pembiayaan_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            jenis = ajak("pencairanpembiayaan/type","id="+ json['alldata'][i].jenis_pembiayaan);
            managejab = "<img  class=\"cadd\" title=\"Add\" src=\"assets/images/addicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nomor_rekening + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama + "</td>"
                + "<td align=\"left\">" + jenis + "</td>"
                + "<td align=\"right\">" + format_uang(json['alldata'][i].jumlah_pengajuan) + "</td>"
                + "<td align=\"center\">" + revDate(json['alldata'][i].tgl_dibuka,'-') + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].pembiayaan_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- 
        $('.cadd').click( function() {
            $(".infonya").hide();
            obj = jAmbil("d" + $(this).parent().next().text());
            $('.nav-tabs li:eq(1)').removeClass('active').addClass('');
            $('.nav-tabs li:eq(0)').removeClass('').addClass('active');
            $('#tabs-2').removeClass('active').addClass('');
            $('#tabs-1').removeClass('').addClass('active');
            
            $("#nasabah").html(obj.nomor_rekening+" / "+obj.nama);
            jenis = ajak("pencairanpembiayaan/type","id="+ obj.jenis_pembiayaan);
            $("#iddrop").html(jenis);
            $("#form_pembiayaan input[name='nomor_rekening']").val(obj.nomor_rekening);
            $("#form_pembiayaan input[name='nama']").val(obj.nama);
            kec = ajak('base/nasabah/single_kecamatan','&kec='+obj.kecamatan);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+obj.kabupaten);
            var alamat = obj.alamat + " RT/RW " + obj.rtrw + " Kec. " + kec ;
            $("#form_pembiayaan input[name='alamat']").val(alamat);
            $("#form_pembiayaan input[name='kota']").val(kab + " / "+ obj.kode_pos);
            $("#form_pembiayaan input[name='nama']").val(obj.nama);
            var plafon = 0;
            
            var nameproduk = ajak('base/pembiayaan/produk_name','id='+obj.jenis_pembiayaan);
            if(nameproduk == "MURABAHAH"){
                $("#form_pencairanpembiayaan input[name='plafon']").val(format_uang(obj.harga_pokok));
                plafon = obj.harga_pokok;
            }else if(nameproduk == "MUDHARABAH"){
                $("#form_pencairanpembiayaan input[name='plafon']").val(format_uang(obj.modal));
                plafon = obj.modal;
            }else if(nameproduk == "AL-QARDH"){
                $("#form_pencairanpembiayaan input[name='plafon']").val(format_uang(obj.pinjaman));
                plafon = obj.pinjaman;
            }else if(nameproduk == "MUSYARAKAH"){
                $("#form_pencairanpembiayaan input[name='plafon']").val(format_uang(obj.harga_pokok));
                plafon = obj.harga_pokok;
            }
            jurnal = ajak('pencairanpembiayaan/jurnal','&id='+obj.jenis_pembiayaan);
            $("#form_pembiayaan input[name='id_jurnal']").val(jurnal);
            
            sisaplafon = ajak("pencairanpembiayaan/sisaplafon","id="+ obj.nomor_rekening);
            sisaakhir = eval(plafon) - eval(sisaplafon);
            $("#form_pencairanpembiayaan input[name='sisa_plafon']").val(format_uang(sisaakhir));
            loadtrans(obj.nomor_rekening);
            loadsetoran(obj.nomor_rekening);
            loadjadwal(obj.nomor_rekening);
            return false;
        });
        warnatable();
    });
    function loadtrans(norekening){
       //---- Tabel cair
        $("#tb_view").html("");
        $.post("monitor/pembiayaan/get_transview","id="+ norekening,
            function(json){
                var isi ="";
                    for(i = 0; i < json['alldata'].length; i++) {
                        isi += "<tr>"
                            + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ json['alldata'][i].accounttrans_code +"</td>" 
                            + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ revDate(json['alldata'][i].accounttrans_date, '-') +"</td>" 
                            + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(json['alldata'][i].accounttrans_value) +"</td>" 
                            + "</tr>";
                    }  
                    $("#tb_view").html(isi);
                }, "json");
        return false;
    }
    function loadsetoran(norekening){
       //---- 
        $("#tlist2").html("");
        $.post("monitor/pembiayaan/get_setoranview","id="+ norekening,
            function(json){
                var isi ="";
                var nr = 1;
					 responouts = ajak("monitor/pembiayaan/get_outstanding","id="+ norekening);
					 var nilaitrans = 0,outstanding = 0;
                for(i = 0; i < json['alldata'].length; i++) {
	                nilaimargin = json['alldata'][i].jlh - json['alldata'][i].accounttrans_value;
	                pokok = json['alldata'][i].accounttrans_value - nilaimargin;
						 outstanding = responouts - nilaitrans;
	                isi += "<tr>"
                        + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ revDate(json['alldata'][i].accounttrans_date, '-') +"</td>" 
                        + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ json['alldata'][i].accounttrans_code +"</td>"
                        + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(outstanding) +"</td>" 
                        + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(pokok) +"</td>" 
                        + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(nilaimargin) +"</td>" 
                        + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(json['alldata'][i].accounttrans_value) +"</td>" 
                        + "</tr>";
                    nr++;
 						 nilaitrans += eval(pokok) + eval(nilaimargin);
                }  
                $("#tlist2").html(isi);
            }, "json");
        
        return false;
    }
    function loadjadwal(norekening){
       //---- 
        $("#tlist2").html("");
        $.post("monitor/pembiayaan/get_angsuranview","id="+ norekening,
            function(json){
                var isi ="";
                var nr = 1;
                for(i = 0; i < json['alldata'].length; i++) {
	                total = eval(json['alldata'][i].pokok) + eval(json['alldata'][i].margin);
	                isi += "<tr>"
                        + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ nr +"</td>" 
                        + "<td style=\"border-top:1px solid #000\" align=\"center\">"+ revDate(json['alldata'][i].tgl_angsuran, '-') +"</td>" 
                        + "<td style=\"border-top:1px solid #000\" align=\"right\">"+ format_uang(total) +"</td>" 
                        + "</tr>";
                    nr++;
                }  
                $("#tlist1").html(isi);
            }, "json");
        
        return false;
    }
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
