/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : monitor/cetaktabungan.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    var adminouth = 0;
    var tabactive = 0;
/*
 *  --------------------- cetak tabungan -----------------------------------------
 */
    
    $("#tgllap2").val(isitglskrg());
    $('.searchact').click(function() {
    	tabactive = 0;
        $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(2)').removeClass('').addClass('active');
        $('#tabs-1').removeClass('active').addClass('');
        $('#tabs-3').removeClass('').addClass('active');
        return false;
    });
    $("#table_datatabungan").mastertable({
        urlGet:"base/tabungan/get_tabungan",
        flook:"nomor_rekening"
    },
    function(hal,juml,json) {
        var isi="";
        var kec = "";
        var kab = "";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "j" + json['alldata'][i].tabungan_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            kec = ajak('base/nasabah/single_kecamatan','&kec='+json['alldata'][i].kecamatan);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+json['alldata'][i].kabupaten);
            //
            managejab = "<img class=\"cadd\" title=\"Add\" src=\"assets/images/addicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nomor_rekening + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].alamat + " RT/RW " + json['alldata'][i].rtrw + " Kec. " + kec + " Kode pos " + json['alldata'][i].kode_pos + "</td>"
                + "<td align=\"left\">" + kab + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].tabungan_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        $('.cadd').click( function() {
        	if(tabactive == 0){
	            $(".infonya").hide();
	            obj = jAmbil("j" + $(this).parent().next().text());
	            $('.nav-tabs li:eq(2)').removeClass('active').addClass('');
	            $('.nav-tabs li:eq(0)').removeClass('').addClass('active');
	            $('#tabs-3').removeClass('active').addClass('');
	            $('#tabs-1').removeClass('').addClass('active');
	            $("#form_setor input[name='nomor_rekening']").val(obj.nomor_rekening);
	            $("#form_setor input[name='nama']").val(obj.nama);
	            kec = ajak('base/nasabah/single_kecamatan','&kec='+obj.kecamatan);
	            kab = ajak('base/nasabah/single_kabupaten','&kab='+obj.kabupaten);
	            var alamat = obj.alamat + " RT/RW " + obj.rtrw + " Kec. " + kec ;
	            $("#form_setor input[name='alamat']").val(alamat);
	            $("#form_setor input[name='kota']").val(kab + " / "+ obj.kode_pos);
	            $("#form_setor input[name='nama']").val(obj.nama);
	            $("#tgllap1").val(revDate(obj.tgl_dibuka,"-"));
	            return false;
	        }else{
	        	$(".infonya").hide();
	            obj = jAmbil("j" + $(this).parent().next().text());
	            $('.nav-tabs li:eq(2)').removeClass('active').addClass('');
	            $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
	            $('#tabs-3').removeClass('active').addClass('');
	            $('#tabs-2').removeClass('').addClass('active');
	            $("#form_setor1 input[name='nomor_rekening1']").val(obj.nomor_rekening);
	            kec = ajak('base/nasabah/single_kecamatan','&kec='+obj.kecamatan);
	            kab = ajak('base/nasabah/single_kabupaten','&kab='+obj.kabupaten);
	            var alamat = obj.alamat + " RT/RW " + obj.rtrw + "<br>Kec. " + kec +"<br>"+kab +" "+ obj.kode_pos;
	            resp = ajak('param/bmt/get_info','&id='+obj.code_wilayah);
	            var isi = "";
	            isi += "<tr>"
                    + "<td>TAB WADIAH<br></td>"
                    + "</tr>";
	            isi += "<tr>"
                    + "<td>"+ obj.nama.toUpperCase() +"<br></td>"
                    + "</tr>";
	            isi += "<tr>"
                    + "<td width=\"20%\">No Rekening : "+ obj.nomor_rekening +"<br>"+ alamat +"</td>"
                    + "<td valign=\"top\">CABANG : "+ obj.code_wilayah +" - "+ resp +"<br> Tanggal Cetak : "+ tglskrg()+"</td>"
                    + "</tr>";
	            
	            $('#kopcetak tbody').html(isi);
	        }
        });
        
    });
    var itgl,ikode,idebet,ikredit,isaldo,ipetugas,ibatasatas = 0,ijlhbaris,itotal = 0;
    $.get("monitor/cetaktabungan/get_paramlayout","",
    		function(json){
    			itgl = json[0].set4;
    			ikode = json[0].set5;
    			idebet = json[0].set6;
    			ikredit = json[0].set7;
    			isaldo = json[0].set8;
    			ipetugas = json[0].set9;
    			ibatasatas = json[0].set10;
    			ijlhbaris = json[0].set11;
   	 			
	 }, "json");
    itotal = eval(itgl) + eval(itgl) + eval(ikode) + eval(idebet) + eval(ikredit) + eval(isaldo) + eval(ipetugas);
    
    $('#buatdaftar').click(function() {
    	var jlhbaris= $('#baris').val();
        var isitglawal =  revDate($('#tgllap1').val(),"-");
        var isitglakhir =  revDate($('#tgllap2').val(),"-");
        if (Date.parse(isitglawal) > Date.parse(isitglakhir)) {
            showinfo("Tanggal Awal Harus lebih kecil dari Tanggal Akhir");
            return false;
        }
        if(($('#tgllap2').val().substr(6, 4) - $('#tgllap1').val().substr(6, 4)) > 0) {
            selisihx = (($('#tgllap2').val().substr(3, 2)*1) + 12) - ($('#tgllap1').val().substr(3, 2)*1)
            if(selisihx > 11) {
                showinfo("Selisih Bulan Periode max 12 bulan");
                return false;
            }
        }
        var norekening = $('#nomor_rekening').val();
        $.post("monitor/cetaktabungan/get_cetaktrans","tglawal=" + $('#tgllap1').val() + "&tglakhir=" + $('#tgllap2').val() + "&id=" + norekening,
            function(obj){
                var isi = "";
                var saldotot = 0, mutasi = 0, kredit = 0, debet=0;
                for(n = 0;n < jlhbaris;n++){
                	isi += "<tr><td colspan='7'>&nbsp;</td></tr>";
                }
                var No = (eval(jlhbaris)) + 1;
                var barisN = obj['alldata'].length;
                if(barisN <= ijlhbaris){
                	barisN = barisN;
                }else{
                	barisN = ijlhbaris;
                }
                saldon = ajak('monitor/cetaktabungan/saldonow','&tglawal='+ $('#tgllap1').val() +"&id="+ norekening);
                saldoawal = saldon * 1;
                isi += "<tr>"
                    + "<td align=\"left\">" + No + "</td>"
                    + "<td align=\"center\">" + $('#tgllap1').val() + "</td>"
                    + "<td align=\"center\"> - </td>"
                    + "<td align=\"right\" style=\"margin-right:2px;\"> - </td>"
                    + "<td align=\"right\" style=\"margin-right:2px;\"> - </td>"
                    + "<td align=\"right\" style=\"margin-right:2px;\">" + format_uang(saldoawal)+ "</td>"
                    + "<td align=\"right\"> - </td>"
                    + "</tr>";
                saldotot = saldoawal;
                for(i = 0; i < barisN; i++) {
                    mutasi = eval(obj['alldata'][i].accounttrans_value);
                    No += 1;
                    if(obj['alldata'][i].accounttrans_type == "01"){
                        saldotot += mutasi;
                        kredit = eval(obj['alldata'][i].accounttrans_value);
                    }else{
                        saldotot -= mutasi;
                        debet = eval(obj['alldata'][i].accounttrans_value);
                    }
                    //var res1 = nval.split("."); 
                    isi += "<tr>"
                        + "<td align=\"left\">" + No + "</td>"
                        + "<td align=\"center\">" + revDate(obj['alldata'][i].accounttrans_date, "-") + "</td>"
                        + "<td align=\"center\">" + obj['alldata'][i].accounttrans_type + "</td>"
                        + "<td align=\"right\" style=\"margin-right:2px;\">" + format_uang(debet) + "</td>"
                        + "<td align=\"right\" style=\"margin-right:2px;\">" + format_uang(kredit) + "</td>"
                        + "<td align=\"right\" style=\"margin-right:2px;\">" + format_uang(saldotot)+ "</td>"
                        + "<td align=\"right\">" + obj['alldata'][i].create_by + "</td>"
                        + "</tr>";
                    //No++;
                }
                $('#tlapcetak tbody').html(isi);
                $('#tlapcetak tbody',ctkframe.document).html(isi);
            }, "json");
        
        return false;
    });
    
    $('.searchact1').click(function() {
    	tabactive = 1;
        $('.nav-tabs li:eq(1)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(2)').removeClass('').addClass('active');
        $('#tabs-2').removeClass('active').addClass('');
        $('#tabs-3').removeClass('').addClass('active');
        return false;
    });
    $('#table_lap1 button:eq(0)').click(function() {
        //cetak
        $('#wrap-top',ctkframe1.document).html($('#kopcetak').html());
        $('table',ctkframe1.document).css({"font-size":"12"});
        window.ctkframe1.print();
        return false;
    });
    $('#table_lap button:eq(1)').click(function() {
        //cetak
        //$('#wrap-top',ctkframe.document).html($('#tlapcetak').html());
        $('table',ctkframe.document).css({"font-size":"12"});
        window.ctkframe.print();
        return false;
    });
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
