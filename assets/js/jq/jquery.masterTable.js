/*
 * Master Table
 * author : Edi Suwoto S.Komp
 *
 * OPTIONS :
 * urlGet : <urltorequest>
 * flook  : <namafield>
 * order  : 'asc' / 'desc
 * dataTambahan : '&dt=datatambahan'
 * 
 */

//---- Master Table 
(function($){
    $.fn.extend({
        mastertable: function(options,isiTable,domIsi) {
            return this.each(function() {
                new $.Lakukan(this,options,isiTable,domIsi);
            });
        }
    });
    $.Lakukan = function(elm,options,isiTable,domIsi) {
        idTable = $(elm).attr("id");
        $(".tbl_head th[id]",elm).css("cursor","pointer");
        $(".reset",elm).click(function(){
            order = (options.order) ? options.order : 'asc';
            setdata(idTable,options.flook,order);
            $(".tbl_head > th > u",elm).parent().html($(".tbl_head > th > u",elm).text());
            $("#" + options.flook,elm).html("<u>" + $("#" + options.flook,elm).text() + "<img src=\"assets/images/sort_"+order+".png\"/></u>");
            $(".isi_filter",elm).val("");
            $(".pg_hal",elm).val("1");
            $(".pg_row option[value='10']",elm).attr("selected","selected");
            get_data($('#ffilter',elm).serialize(),options.flook,order,"1","10");
            return false;
        });
        //------ Filter Group ------------------------//
        $(".isi_filter",elm).keyup(function() {
            $(".pg_hal",elm).val("1");
            get_data($('#ffilter',elm).serialize(),getdata(idTable,"fi"),getdata(idTable,"ad"),$(".pg_hal",elm).val(),$(".pg_row",elm).val());
        });
        //------ Tabel Group Sorting ------------------------//
        $(".tbl_head th[id]",elm).click(function() {
            fd = $(this).attr("id");
            pid = getdata(idTable,"fi");
            get_data($('#ffilter',elm).serialize(),fd,tooglesort(idTable),$('.pg_hal',elm).val(),$(".pg_row",elm).val());
            $("#"+ pid,elm).text($("#"+pid,elm).text());
            $(this).html("<u>" + $(this).text() + "<img src=\"assets/images/sort_"+tooglesort(idTable)+".png\"/></u>");
            setdata(idTable,fd,tooglesort(idTable));
        });

        //------ Tombol Paging ----//
        $(".pg_first",elm).click(function(){
            get_data($('#ffilter',elm).serialize(),getdata(idTable,"fi"),getdata(idTable,"ad"),"1",$(".pg_row",elm).val());
            $('.pg_hal',elm).val('1');
        });
        $(".pg_pre",elm).click(function(){
            if (parseInt($(".pg_hal",elm).val()) > 1 ) {
                prev = parseInt($(".pg_hal",elm).val()) - 1;
                get_data($('#ffilter',elm).serialize(),getdata(idTable,"fi"),getdata(idTable,"ad"),prev,$(".pg_row",elm).val());
                $('.pg_hal',elm).val(prev);
            }
        });
        $(".pg_next",elm).click(function(){
            if (parseInt($('.pg_total',elm).html()) > parseInt($('.pg_hal',elm).val())) {
                next = parseInt($(".pg_hal",elm).val()) + 1;
                get_data($('#ffilter',elm).serialize(),getdata(idTable,"fi"),getdata(idTable,"ad"),next,$(".pg_row",elm).val());
                $('.pg_hal',elm).val(next);
            }
        });
        $(".pg_last",elm).click(function(){
            get_data($('#ffilter',elm).serialize(),getdata(idTable,"fi"),getdata(idTable,"ad"),$('.pg_total',elm).html(),$(".pg_row",elm).val());
            $('.pg_hal',elm).val($('.pg_total',elm).html());
        });
        $(".pg_hal",elm).keyup(function(){
            get_data($('#ffilter',elm).serialize(),getdata(idTable,"fi"),getdata(idTable,"ad"),$(".pg_hal",elm).val(),$(".pg_row",elm).val());
        }).inputInteger();
        $(".pg_row",elm).change(function(){
            $(".pg_hal",elm).val("1");
            get_data($('#ffilter',elm).serialize(),getdata(idTable,"fi"),getdata(idTable,"ad"),"1",$(this).val());
        });
        
        function get_data(filter,field,adsc,hal,juml) {
            datanya = filter + "&fd=" + field + "&adsc=" + adsc + "&hal=" + hal + "&juml=" + juml;
            if(options.dataTambahan){datanya += options.dataTambahan; }
            $.ajax({type: "POST",
                         url: options.urlGet,
                         data: datanya,
                         dataType: "json",
                         async : false,
                         success: function(json){
                                    $('.tbl_body',elm).html(isiTable(hal,juml,json));
                                    $('.pg_total',elm).html(json['total']);
                                    if(domIsi){domIsi();};
                                  },
                         error: function() {
                        			$('.tbl_body',elm).html("");
                        	   }
            });
        }

        //-----Fungsi Toogle Sort ----------------------------//
        function tooglesort(tab) {
            return($.data($("div",elm).get(0), tab).adsc == "asc" ? "desc" : "asc");
        }
        //-----Fungsi Set Data-------------------------------//
        function setdata(tab,fil,ad) {
            $.data($("div",elm).get(0), tab, { field: fil, adsc: ad });
        }
        //----Fungsi Get Data Temporary di JS----//
        function getdata(tab,nm) {
            return(( nm == "fi") ? $.data($("div",elm).get(0), tab).field : $.data($("div",elm).get(0), tab).adsc);
        }

        function cetak_data(filter,field,adsc) {
            datanya = filter + "&fd=" + field + "&adsc=" + adsc;
            if(options.dataTambahan){datanya += options.dataTambahan; }
            $.ajax({type: "POST",
                         url: options.urlGet,
                         data: datanya,
                         dataType: "json",
                         async : false,
                         success: function(json){
                                    $('.tbl_body',elm).html(isiTable(hal,juml,json));
                                    $('.pg_total',elm).html(json['total']);
                                    if(domIsi){domIsi();};
                                  },
                         error: function() {
                        			$('.tbl_body',elm).html("");
                        	   }
            });
        }

        //------Tombol Cetak Group -----------------------------//
        $(".pg_excel",elm).click(function() {
            window.location = "admin/user/cetak_excel/groups";
        });
        $(".pg_pdf",elm).click(function() {
            alert("Cetak Ke PDF");
        });
        $(".pg_printer",elm).click(function() {
            cetak_data($('#ffilter',elm).serialize(),getdata(idTable,"fi"),getdata(idTable,"ad"));
        });
        
        $(".go-top").click(function() {
          $("html, body").animate({ scrollTop: 0 }, "slow");
          return false;
        });
    }
})(jQuery);

// --- Fungsi Tambahan ---------------------------------------------------
//---- Fungsi AJAX ----//
	function ajak(urlnya,datanya) {
	  	var resp = $.ajax({type: "POST",
	                       url: urlnya,
	                       async : false,
	                       data: datanya
	                      }).responseText;
	    return resp;
	}

    //---- Fungsi Validasi Form ----
    function validform(formnya) {
        var hasil = new Array();
        hasil['isi'] = "";
        hasil['idx'] = "";
  		$('#' + formnya + ' .fm-req .inp').each( function (i) {
  			if ($(this).val() == "") {
  				hasil['isi'] = "invalid";
                hasil['focus'] = $("#" + formnya + " .fm-req .inp:eq("+ i +")");
  				return false;
  			}
  		});
        return hasil;
    }

    //---- Pesan Error ----//
	function showinfo(info) {
		$(".infonya").html("<img src=\"assets/images/warning_kecil.png\" />&nbsp;<span style=\"font-weight: bold;color: red\">" + info + "</span>");
		$(".infonya").show();
		setTimeout('$(".infonya").fadeOut("slow")', 3500);
	}

    //---- Efek pada tombol dan Thead
    function tombolcss() {
        //---- Hover buttton
        $('button').hover(
            function() { $(this).addClass('ui-state-hover'); },
            function() { $(this).removeClass('ui-state-hover'); }
        );
        //---- add hover states on the static widgets
         $('.ui-state-default:not(.ui-state-disabled, .ui-slider-range, .ui-progressbar-value), a.ui-datepicker-next, a.ui-datepicker-prev, .ui-dialog-titlebar-close, .ui-autocomplete-item a').hover(
                function(){ $(this).addClass('ui-state-highlight'); },
                function(){ $(this).removeClass('ui-state-highlight'); }
         );
    }

    //---- Warna Row Table
    function warnatable() {
        //---- Hover Row
         $('tbody tr').hover(
                function(){ $('td', this).addClass('rowhover');},
                function(){ $('td', this).removeClass('rowhover');}
         );
        //warna selang-seling
        $("tbody tr:even").css("background-color", "#FFF");
        $("tbody tr:odd").css("background-color", "#EFF1F1");

        tombolcss();
    }

    //---- Simpan, Ambil dan Hapus data Jquery
    function jSimpan(id,data){
        $.data($("div").get(0), id, data);
    }

    function jAmbil(id) {
        return $.data($("div").get(0), id);
    }

    function jHapus(id) {
        $.removeData($("div").get(0), id);
    }
    
    //---- CSS include by JS
    function includeCSS(p_file) {
        var v_css  = document.createElement('link');
        v_css.rel = 'stylesheet';
        v_css.type = 'text/css';
        v_css.href = p_file;
        document.getElementsByTagName('head')[0].appendChild(v_css);
    }
    includeCSS("assets/css/master_table.css");


