/* Indonesian initialisation for the jQuery UI date picker plugin. */
/* Written by Deden Fathurahman (dedenf@gmail.com). */
jQuery(function($){
	$.datepicker.regional['id'] = {
        clearText: 'Kosongkan',
        clearStatus: 'Bersihkan tanggal yang sekarang',
		closeText: 'Tutup',
        closeStatus: 'Tutup tanpa mengubah',
		prevText: '&lt;Lalu',
        prevStatus: 'Tampilkan bulan sebelumnya',
		nextText: 'Maju&gt;',
        nextStatus: 'Tampilkan bulan berikutnya',
		currentText: 'Hari ini',
        currentStatus: 'Tampilkan bulan sekarang',
		monthNamesShort: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'],
		monthNames: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agus','Sep','Okt','Nop','Des'],
		monthStatus: 'Tampilkan bulan yang berbeda',
        yearStatus: 'Tampilkan tahun yang berbeda',
		weekHeader: 'Mg',
        weekStatus: 'Minggu dalam tahun',
		dayNames: ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'],
		dayNamesShort: ['Min','Sen','Sel','Rab','Kam','Jum','Sab'],
		dayNamesMin: ['Mg','Sn','Sl','Rb','Km','Jm','Sb'],
		dayStatus: 'gunakan DD sebagai awal hari dalam minggu',
        dateStatus: 'pilih DD, MM d',
		dateFormat: 'dd-mm-yy',
        firstDay: 0,
		initStatus: 'Pilih Tanggal', 
        isRTL: false
    };
	$.datepicker.setDefaults($.datepicker.regional['id']);
});