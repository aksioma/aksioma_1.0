/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : base/nasabah.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();

/*
 *  --------------------- nasabah -----------------------------------------
 */
    $(".excel_nasabah").click(function() {
        window.location = "base/nasabah/cetak_excel";
    });
    $('#button-previous ,#button-next').click(function() {
        $("html, body").animate({ scrollTop: 300 }, "slow");
        return false;
    });
    
    if($('#status_marital').val() == "2"){
        $('#infomarital').show();
    }else{
        $('#infomarital').hide();
    }
    $('#status_marital').change(function() {
        $('#infomarital').hide();
        if($('#status_marital').val() == "2"){
            $('#infomarital').show();
        }
        return false;
    });
    $("#form_sample_1 input[name='tgl_masuk']").val(isitglskrg());
    var count = ajak('base/nasabah/run_code');
    var cab = ajak('base/nasabah/cab_code');
    $("#form_sample_1 input[name='nomor_nasabah']").val(count);
    $("#form_sample_1 input[name='code_wilayah']").val(cab);
    $('#addnasabah').click(function() {
        $("#form_sample_1 input[name='tgl_masuk']").val(isitglskrg());
        var count = ajak('base/nasabah/run_code');
        var cab = ajak('base/nasabah/cab_code');
        $("#form_sample_1 input[name='nomor_nasabah']").val(count);
        $("#form_sample_1 input[name='code_wilayah']").val(cab);
        $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
        $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
        $('#tabs-1').removeClass('active').addClass('');
        $('#tabs-2').removeClass('').addClass('active');
        //
        isi = ajak('base/nasabah/isi_propinsi');
        $("#propinsi").html(isi);
        $("#propinsi_pekerjaan").html(isi);
        $("#propinsi_usaha").html(isi);
        $("#propinsi_kerabat").html(isi);
        return false;
    });
    $('#propinsi').change(function(){
        var prov = $('#propinsi').val();
        $("#kabupaten").html("");
        isikab = ajak('base/nasabah/isi_kabupaten','&prov='+prov);
        $("#kabupaten").html(isikab);
        return false;
    });
    $('#kabupaten').change(function(){
        var id = $('#kabupaten').val();
        $("#kecamatan").html("");
        isikec = ajak('base/nasabah/isi_kecamatan','&kab='+id);
        $("#kecamatan").html(isikec);
        return false;
    });
    $('#propinsi_pekerjaan').change(function(){
        var prov = $('#propinsi_pekerjaan').val();
        $("#kabupaten_pekerjaan").html("");
        isikab = ajak('base/nasabah/isi_kabupaten','&prov='+prov);
        $("#kabupaten_pekerjaan").html(isikab);
        return false;
    });
    $('#kabupaten_pekerjaan').change(function(){
        var id = $('#kabupaten_pekerjaan').val();
        $("#kecamatan_pekerjaan").html("");
        isikec = ajak('base/nasabah/isi_kecamatan','&kab='+id);
        $("#kecamatan_pekerjaan").html(isikec);
        return false;
    });
    $('#propinsi_usaha').change(function(){
        var prov = $('#propinsi_usaha').val();
        $("#kabupaten_usaha").html("");
        isikab = ajak('base/nasabah/isi_kabupaten','&prov='+prov);
        $("#kabupaten_usaha").html(isikab);
        return false;
    });
    $('#kabupaten_usaha').change(function(){
        var id = $('#kabupaten_usaha').val();
        $("#kecamatan_usaha").html("");
        isikec = ajak('base/nasabah/isi_kecamatan','&kab='+id);
        $("#kecamatan_usaha").html(isikec);
        return false;
    });
    $('#propinsi_kerabat').change(function(){
        var prov = $('#propinsi_kerabat').val();
        $("#kabupaten_kerabat").html("");
        isikab = ajak('base/nasabah/isi_kabupaten','&prov='+prov);
        $("#kabupaten_kerabat").html(isikab);
        return false;
    });
    $('#kabupaten_kerabat').change(function(){
        var id = $('#kabupaten_kerabat').val();
        $("#kecamatan_kerabat").html("");
        isikec = ajak('base/nasabah/isi_kecamatan','&kab='+id);
        $("#kecamatan_kerabat").html(isikec);
        return false;
    });
    
    
    
     //---- Tabel Nasabah
    $("#table_datanasabah").mastertable({
        urlGet:"base/nasabah/get_nasabah",
        flook:"nomor_nasabah"
    },
    function(hal,juml,json) {
        var isi="";
        var kec = "";
        var kab = "";
        var prov = "";
        for(i = 0; i < json['alldata'].length; i++) {
            idx = "j" + json['alldata'][i].nasabah_id;
            dtx = json['alldata'][i];
            jSimpan(idx,dtx);
            kec = ajak('base/nasabah/single_kecamatan','&kec='+json['alldata'][i].kecamatan);
            kab = ajak('base/nasabah/single_kabupaten','&kab='+json['alldata'][i].kabupaten);
            //<img class=\"chps\" title=\"Hapus\" src=\"assets/images/delicon.png\"/>&nbsp;
            managejab = "<img  class=\"cedt\" title=\"Edit\" src=\"assets/images/editicon.png\"/>";
            isi += "<tr style=\"vertical-align:top;\">"
                + "<td align=\"center\">" + (((hal - 1) * juml ) + (i + 1)) + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nomor_nasabah + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].nama + "</td>"
                + "<td align=\"left\">" + json['alldata'][i].alamat + " RT/RW " + json['alldata'][i].rtrw + " Kec. " + kec + " Kode pos " + json['alldata'][i].kode_pos + "</td>"
                + "<td align=\"left\">" + kab + "</td>"
                + "<td nowrap=\"nowrap\" align=\"center\">" + managejab + "</td>"
                + "<td align=\"center\">" + json['alldata'][i].nasabah_id + "</td>"
                + "</tr>";
        }
        return isi;
    },
    function domIsi() {
        //---- Edit
        $('.cedt').click( function() {
            $(".infonya").hide();
            obj = jAmbil("j" + $(this).parent().next().text());
            jSimpan("idx",obj.nasabah_id);
            
            $("#form_sample_1 input[name='code_wilayah']").val(obj.code_wilayah);
            $("#form_sample_1 input[name='tgl_masuk']").val(revDate(obj.tgl_masuk,'-'));
            $("#form_sample_1 input[name='nomor_nasabah']").val(obj.nomor_nasabah);
            var cab = ajak('base/nasabah/cab_code');
            $("#form_sample_1 input[name='code_wilayah']").val(cab);
            $('.nav-tabs li:eq(0)').removeClass('active').addClass('');
            $('.nav-tabs li:eq(1)').removeClass('').addClass('active');
            $('#tabs-1').removeClass('active').addClass('');
            $('#tabs-2').removeClass('').addClass('active');
            //
            isi = ajak('base/nasabah/isi_propinsi');
            $("#propinsi").html(isi);
            $("#form_sample_1 select[name='propinsi']").val(obj.propinsi);
            $("#propinsi_pekerjaan").html(isi);
            $("#form_sample_1 select[name='propinsi_pekerjaan']").val(obj.propinsi_pekerjaan);
            $("#propinsi_usaha").html(isi);
            $("#form_sample_1 select[name='propinsi_usaha']").val(obj.propinsi_usaha);
            $("#propinsi_kerabat").html(isi);
            $("#form_sample_1 select[name='propinsi_kerabat']").val(obj.propinsi_kerabat);
            
            $("#form_sample_1 input[name='nama']").val(obj.nama);
            $("#form_sample_1 input[name='nama_pangilan']").val(obj.nama_pangilan);
            $("#form_sample_1 input[name='tempat_lahir']").val(obj.tempat_lahir);
            $("#form_sample_1 input[name='tanggal_lahir']").val(revDate(obj.tanggal_lahir,'-'));
            $("#form_sample_1 select[name='jenis_kelamin']").val(obj.jenis_kelamin);
            $("#form_sample_1 select[name='agama']").val(obj.agama);
            $("#form_sample_1 select[name='pendidikan']").val(obj.pendidikan);
            $("#form_sample_1 input[name='nama_ibu_kandung']").val(obj.nama_ibu_kandung);
            $("#form_sample_1 select[name='status_marital']").val(obj.status_marital);
            $("#form_sample_1 input[name='nama_istri_suami']").val(obj.nama_istri_suami);
            $("#form_sample_1 input[name='jumlah_anak']").val(obj.jumlah_anak);
            $("#form_sample_1 select[name='jenis_identitas']").val(obj.jenis_identitas);
            $("#form_sample_1 input[name='nomor_identitas']").val(obj.nomor_identitas);
            $("#form_sample_1 input[name='berlaku_identitas']").val(obj.berlaku_identitas);
            $("#form_sample_1 input[name='warga_negara']").val(obj.warga_negara);
            $("#form_sample_1 input[name='nama_waris']").val(obj.nama_waris);
            $("#form_sample_1 select[name='hubungan_waris']").val(obj.hubungan_waris);
            $("#form_sample_1 select[name='jenis_identitas_waris']").val(obj.jenis_identitas_waris);
            $("#form_sample_1 input[name='nomor_identitas_waris']").val(obj.nomor_identitas_waris);
            $("#form_sample_1 input[name='berlaku_identitas_waris']").val(obj.berlaku_identitas_waris);
            $("#form_sample_1 input[name='alamat']").val(obj.alamat);
            return false;
        });
        warnatable();
    });

/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
function isitglskrg()
{
    var now = new Date();
    var date = ((now.getDate()<10) ? "0" : "")+ now.getDate();
    var mo = now.getMonth() + 1;
    var months = ((mo < 10) ? "0" : "")+ mo;
    return date + "-" + months + "-" + fourdigits(now.getYear());
}
function fourdigits(number) {return (number < 1000) ? number + 1900 : number;}

function revDate(datex,pemisah) {
		datexx = datex.split("-");
		datex = datexx[2] + pemisah + datexx[1] + pemisah + datexx[0];
		return datex;
}