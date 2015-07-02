/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : plugin/simulasiemas.js
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
$(document).ready(function(){
    //---- Inisialisasi
    $("#tab-utama").tabs();
    var adminouth = 0;
    $('.int').inputInteger();
    /*
    $("#col0_row1").blur(function(){
        if ($(this).val() != '') {
           $(this).val($(this).val());
           num = $(this).val().replace(/\s|\./g,'');
           loadrow1("1",num);
        }
    });
    $("#col0_row2").blur(function(){
        if ($(this).val() != '') {
           $(this).val($(this).val());
           num = $(this).val().replace(/\s|\./g,'');
           loadrow1("2",num);
        }
    });
    $("#col0_row3").blur(function(){
        if ($(this).val() != '') {
           $(this).val($(this).val());
           num = $(this).val().replace(/\s|\./g,'');
           loadrow1("3",num);
        }
    });
    */
    $("#hargaemas").val('483000');
    loadf();
    function loadf(){
    	hargaemas = $("#hargaemas").val().replace(/\s|\./g,'');
        num1 = eval(hargaemas) + 40000;
        num2 = eval(hargaemas * 5) + 55000;
        num3 = eval(hargaemas * 10) + 60000;
        num4 = eval(hargaemas * 25) + 75000;
        num5 = eval(hargaemas * 50) + 100000;
        num6 = eval(hargaemas * 100) + 150000;
        loadrow("1",num1);
        loadrow("2",num2);
        loadrow("3",num3);
        loadrow("4",num4);
        loadrow("5",num5);
        loadrow("6",num6);
        // arisan
        num7 = eval(hargaemas) + 40000;
        num8 = eval(hargaemas * 5) + 55000;
        num9 = eval(hargaemas * 10) + 60000;
        num10 = eval(hargaemas * 25) + 75000;
        num11 = eval(hargaemas * 50) + 100000;
        num12 = eval(hargaemas * 100) + 150000;
        loadrow1("7",num7);
        loadrow1("8",num8);
        loadrow1("9",num9);
        loadrow1("10",num10);
        loadrow1("11",num11);
        loadrow1("12",num12);
    }
    $("#hargaemas").blur(function(){
        if ($(this).val() != '') {
           $(this).val($(this).val());
           hargaemas = $(this).val().replace(/\s|\./g,'');
           num1 = eval(hargaemas) + 40000;
           num2 = eval(hargaemas * 5) + 55000;
           num3 = eval(hargaemas * 10) + 60000;
           num4 = eval(hargaemas * 25) + 75000;
           num5 = eval(hargaemas * 50) + 100000;
           num6 = eval(hargaemas * 100) + 150000;
           loadrow("1",num1);
           loadrow("2",num2);
           loadrow("3",num3);
           loadrow("4",num4);
           loadrow("5",num5);
           loadrow("6",num6);
           // arisan
           num7 = eval(hargaemas) + 40000;
           num8 = eval(hargaemas * 5) + 55000;
           num9 = eval(hargaemas * 10) + 60000;
           num10 = eval(hargaemas * 25) + 75000;
           num11 = eval(hargaemas * 50) + 100000;
           num12 = eval(hargaemas * 100) + 150000;
           loadrow1("7",num7);
           loadrow1("8",num8);
           loadrow1("9",num9);
           loadrow1("10",num10);
           loadrow1("11",num11);
           loadrow1("12",num12);
        }
    });
    
    function loadrow(n,num){
    	col1_row = eval(num) * 0.2;
        col1_row = Math.round(col1_row);
        col2_row = (eval(num) - (col1_row - 50000)) * (1 + eval(3.94/100)) / 3;
        col2_row = Math.round(col2_row);
        col3_row = (eval(num) - (col1_row - 50000)) * (1 + eval(6.96/100)) / 6;
        col3_row = Math.round(col3_row);
        col4_row = (eval(num) - (col1_row - 50000)) * (1 + eval(10.04/100)) / 9;
        col4_row = Math.round(col4_row);
        col5_row = (eval(num) - (col1_row - 50000)) * (1 + eval(13.18/100)) / 12;
        col5_row = Math.round(col5_row);
        col6_row = (eval(num) - (col1_row - 50000)) * (1 + eval(26.29/100)) / 24;
        col6_row = Math.round(col6_row);
        col7_row = (eval(num) - (col1_row - 50000)) * (1 + eval(40.29/100)) / 36;
        col7_row = Math.round(col7_row);
        $('.col0_row'+n).html('Rp. '+format_uang(num));
        $('.col1_row'+n).html('Rp. '+format_uang(col1_row));
        $('.col2_row'+n).html('Rp. '+format_uang(col2_row));
        $('.col3_row'+n).html('Rp. '+format_uang(col3_row));
        $('.col4_row'+n).html('Rp. '+format_uang(col4_row));
        $('.col5_row'+n).html('Rp. '+format_uang(col5_row));
        $('.col6_row'+n).html('Rp. '+format_uang(col6_row));
        $('.col7_row'+n).html('Rp. '+format_uang(col7_row));
    }
    function loadrow1(n,num){
    	col1_row = eval(num) * 0.15;
        col1_row = Math.round(col1_row);
        col2_row = ((((eval(num) - eval(col1_row)) * 6 ) + 50000) * (1 + eval(6.96/100))) / 6 / 6;
        col2_row = Math.round(col2_row);
        col3_row = ((((eval(num) - eval(col1_row)) * 6 ) + 50000) * (1 + eval(9.01/100))) / 8 / 8;
        col3_row = Math.round(col3_row);
        col4_row = ((((eval(num) - eval(col1_row)) * 6 ) + 50000) * (1 + eval(11.08/100))) / 10 / 10;
        col4_row = Math.round(col4_row);
        col5_row = ((((eval(num) - eval(col1_row)) * 6 ) + 50000) * (1 + eval(13.18/100))) / 12 / 12;
        col5_row = Math.round(col5_row);
        col6_row = ((((eval(num) - eval(col1_row)) * 6 ) + 50000) * (1 + eval(15.30/100))) / 14 / 14;
        col6_row = Math.round(col6_row);
        col7_row = ((((eval(num) - eval(col1_row)) * 6 ) + 50000) * (1 + eval(17.45/100))) / 16 / 16;
        col7_row = Math.round(col7_row);
        $('.col0_row'+n).html('Rp. '+format_uang(num));
        $('.col1_row'+n).html('Rp. '+format_uang(col1_row));
        $('.col2_row'+n).html('Rp. '+format_uang(col2_row));
        $('.col3_row'+n).html('Rp. '+format_uang(col3_row));
        $('.col4_row'+n).html('Rp. '+format_uang(col4_row));
        $('.col5_row'+n).html('Rp. '+format_uang(col5_row));
        $('.col6_row'+n).html('Rp. '+format_uang(col6_row));
        $('.col7_row'+n).html('Rp. '+format_uang(col7_row));
    }
/*
 *  ----------------------- RESET -------------------------------
 */
    $(".reset").click();
});
