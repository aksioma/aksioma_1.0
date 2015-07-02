/* * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0 * Copyright (c) 2014 * * file   : fungsi.js * author : Edi Suwoto S.Komp * email  : edi.suwoto@gmail.com *//*----------------------------------------------------------*/
function show(target){
    document.getElementById(target).style.display = 'block';
    return false;
}
function hide(target){
    document.getElementById(target).style.display = 'none';
    return false;
}
function periodedeposito(datex) {
    datexx = datex.split("-");
	var now = new Date();
    var date = ((now.getDate()<10) ? "0" : "")+ now.getDate();
    var mo = now.getMonth() + 1;
    var months = ((mo < 10) ? "0" : "")+ mo;
    var yearn = fourdigits(now.getYear());
    var nilai = "0";
    if((datexx[0] <= yearn)&&(datexx[1] > months)){
        nilai = "no";
    }
    return nilai;
}function revDate(datex,pemisah) {		datexx = datex.split("-");		datex = datexx[2] + pemisah + datexx[1] + pemisah + datexx[0];		return datex;}
function hrtgl(obj)
{
    var days = new Array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
    return days[obj.getDay()];
}

function isitglskrg()
{
    var now = new Date();
    var date = ((now.getDate()<10) ? "0" : "")+ now.getDate();
    var mo = now.getMonth() + 1;
    var months = ((mo < 10) ? "0" : "")+ mo;
    return date + "-" + months + "-" + fourdigits(now.getYear());
}
function isiminggunextvalue(datex,n){
	datexx = datex.split("-");
    hri = datexx[0];
    bln = datexx[1];
    tahun = datexx[2];
    var dateStr = tahun+""+bln+""+hri;
	var d = new Date(dateStr.replace(/(\d{4})(\d{2})(\d{2})/, '$1/$2/$3'));
	d.setDate(d.getDate() + eval(n));
	var day = d.getDate();
	var days = ((day < 10) ? "0" : "")+ day;
	var month = d.getMonth() + 1;
	var months = ((month < 10) ? "0" : "")+ month;
	var year = d.getFullYear();

    return days+"-"+months+"-"+year; 
}
function isiharinextvalue(datex,n){
	datexx = datex.split("-");
    hri = datexx[0];
    bln = datexx[1];
    tahun = datexx[2];
    var dateStr = tahun+""+bln+""+hri;
	var d = new Date(dateStr.replace(/(\d{4})(\d{2})(\d{2})/, '$1/$2/$3'));
	d.setDate(d.getDate() + eval(n));
	var day = d.getDate();
	var days = ((day < 10) ? "0" : "")+ day;
	var month = d.getMonth() + 1;
	var months = ((month < 10) ? "0" : "")+ month;
	var year = d.getFullYear();

    return days+"-"+months+"-"+year; 
}
function isitglnextvalue(datex,n)
{
    datexx = datex.split("-");
    hri = eval(datexx[0]);
    bln = fourdigits(datexx[1]);
    tahun = eval(datexx[2]) + eval(n);
    if (bln == 11) {
        var current = new Date(tahun, 0, 1);
    } else {
        var current = new Date(datexx[2], eval(datexx[1]) + eval(n), 1);
    }
    var mo = current.getMonth() + 1;
    var months = ((mo < 10) ? "0" : "")+ mo;
    var date;
    if((mo == 1)||(mo == 3)||(mo == 5)||(mo == 7)||(mo == 8)||(mo == 10)||(mo == 12)){
        date = datexx[0];
    }else if((mo == 2)){
        if(hri <= 29){
            date = datexx[0];
        }else{
            date = 29;
        }
    }if((mo == 4)||(mo == 6)||(mo == 9)||(mo == 11)){
        if(hri > 30){
            date = 30;
        }else{
            date = datexx[0];
        }
    }
    
    return date + "-" + months + "-" + fourdigits(current.getYear());
}
function isitglnext(n)
{
    var now = new Date();
    if (now.getMonth() == 11) {
        var current = new Date(now.getFullYear() + n, 0, 1);
    } else {
        var current = new Date(now.getFullYear(), now.getMonth() + n, 1);
    }
    var date = ((current.getDate()<10) ? "0" : "")+ current.getDate();
    var mo = current.getMonth() + 1;
    var months = ((mo < 10) ? "0" : "")+ mo;
    return date + "-" + months + "-" + fourdigits(current.getYear());
}

function isithnskrg()
{
    var now = new Date();
    return fourdigits(now.getYear());
}

function cbulan(tgl)
{
    var blnx = parseInt(tgl.substr(3,2),10) - 1;
    var months = new Array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
    tglx = tgl.replace(/-.*-/g, " "+months[blnx]+" ");
    return tglx;
}

function fourdigitsfloor(number) {
    return Math.floor(number);
}
function fourdigits(number) {
    return (number < 1000) ? number + 1900 : number;
}
function jamskrg(){	var currentdate = new Date();	var jam = currentdate.getHours() + ":"+ currentdate.getMinutes() + ":" + currentdate.getSeconds();	return jam;}
function tglskrg()
{
    var now = new Date();
    var days = new Array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
    var months = new Array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
    var date = ((now.getDate()<10) ? "0" : "")+ now.getDate();
    return days[now.getDay()] + ", " + date + " " + months[now.getMonth()] + " " + (fourdigits(now.getYear()));
}function tglskrg1(){    var now = new Date();    var days = new Array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');    var date = ((now.getDate()<10) ? "0" : "")+ now.getDate();    return days[now.getDay()] + "" + date + "" + now.getMonth() + "" + (fourdigits(now.getYear()));}
function format_uang(number)
{
        if (isNaN(number)) return "";
        number = parseInt(number);
        var str = new String(number);
        var result = "" ,len = str.length;
        for(var i=len-1;i>=0;i--)
        {
            if ((i+1)%3 == 0 && i+1!= len) result += ".";
            result += str.charAt(len-1-i);
        }
        return result;
}
function format_uangkoma(num)
{
        nux = num.split(".");
        number = nux[0];
        if (isNaN(number)) return "";
        number = parseInt(number);
        var str = new String(number);
        var result = "" ,len = str.length;
        for(var i=len-1;i>=0;i--)
        {
            if ((i+1)%3 == 0 && i+1!= len) result += ".";
            result += str.charAt(len-1-i);
        }
        return result+","+nux[1];
}

function terbilang(bilangan) {
  bilangan    = String(bilangan);
  var angka   = new Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
  var kata    = new Array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
  var tingkat = new Array('','Ribu','Juta','Milyar','Triliun');

  var panjang_bilangan = bilangan.length;

  /* pengujian panjang bilangan */
  if (panjang_bilangan > 15) {
    kaLimat = "Diluar Batas";
    return kaLimat;
  }

  /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
  for (i = 1; i <= panjang_bilangan; i++) {
    angka[i] = bilangan.substr(-(i),1);
  }

  i = 1;
  j = 0;
  kaLimat = "";


  /* mulai proses iterasi terhadap array angka */
  while (i <= panjang_bilangan) {

    subkaLimat = "";
    kata1 = "";
    kata2 = "";
    kata3 = "";

    /* untuk Ratusan */
    if (angka[i+2] != "0") {
      if (angka[i+2] == "1") {
        kata1 = "Seratus";
      } else {
        kata1 = kata[angka[i+2]] + " Ratus";
      }
    }

    /* untuk Puluhan atau Belasan */
    if (angka[i+1] != "0") {
      if (angka[i+1] == "1") {
        if (angka[i] == "0") {
          kata2 = "Sepuluh";
        } else if (angka[i] == "1") {
          kata2 = "Sebelas";
        } else {
          kata2 = kata[angka[i]] + " Belas";
        }
      } else {
        kata2 = kata[angka[i+1]] + " Puluh";
      }
    }

    /* untuk Satuan */
    if (angka[i] != "0") {
      if (angka[i+1] != "1") {
        kata3 = kata[angka[i]];
      }
    }

    /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
    if ((angka[i] != "0") || (angka[i+1] != "0") || (angka[i+2] != "0")) {
      subkaLimat = kata1+" "+kata2+" "+kata3+" "+tingkat[j]+" ";
    }

    /* gabungkan variabe sub kaLimat (untuk Satu blok 3 angka) ke variabel kaLimat */
    kaLimat = subkaLimat + kaLimat;
    i = i + 3;
    j = j + 1;

  }

  /* mengganti Satu Ribu jadi Seribu jika diperlukan */
  if ((angka[5] == "0") && (angka[6] == "0")) {
    kaLimat = kaLimat.replace("Satu Ribu","Seribu");
  }

//  return kaLimat + "Rupiah";
  return kaLimat;
}

