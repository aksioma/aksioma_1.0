<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/tabungan.php
 * author : Edi Suwoto S.Komp
 * email  : edi.suwoto@gmail.com
 */
/*----------------------------------------------------------*/
?>
 <!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>BMT</title>
    <link rel="icon" href="../assets/images/favicon.jpg" type="image/jpg" />
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="../assets/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="../assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="../assets/css/style.css" rel="stylesheet" />
	<link href="../assets/css/style-responsive.css" rel="stylesheet" />
	<link href="../assets/css/themes/default.css" rel="stylesheet" id="style_color" />
	<link href="../assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
	<link href="../assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" rel="stylesheet" type="text/css" />
	<link href="../assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css" />
	<link href="../assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css" />
	<link href="../assets/plugins/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" type="text/css"  />
	<link href="../assets/plugins/jqvmap/jqvmap/jqvmap.css" media="screen" rel="stylesheet" type="text/css" />
    
    <script src="../assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script>	
	<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->	
	<script src="../assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>		
	<script src="../assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<!--[if lt IE 9]>
	<script src="../assets/plugins/excanvas.js"></script>
	<script src="../assets/plugins/respond.js"></script>	
	<![endif]-->	
	<script src="../assets/plugins/breakpoints/breakpoints.js" type="text/javascript"></script>	
	<script src="../assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="../assets/plugins/jquery.blockui.js" type="text/javascript"></script>	
	<script src="../assets/plugins/jquery.cookie.js" type="text/javascript"></script>
	<script src="../assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>	
	<script src="../assets/plugins/flot/jquery.flot.js" type="text/javascript"></script>
	<script src="../assets/plugins/flot/jquery.flot.resize.js" type="text/javascript"></script>
	<script src="../assets/plugins/jquery.peity.min.js" type="text/javascript"></script>	
	<script src="../assets/plugins/jquery-knob/js/jquery.knob.js" type="text/javascript"></script>	
    <script type="text/javascript" src="../assets/js/jq/jquery.jclock.js"></script>
    <script type="text/javascript" src="../assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>   
   
    <script src="../assets/scripts/app.js" type="text/javascript"></script>
	<script src="../assets/scripts/form-components.js"></script> 
	<script>
		jQuery(document).ready(function() {		
			App.init(); // initlayout and core plugins
			FormComponents.init();
		});
	</script>
    <?php $this -> load -> view( 'header' );?>
    <link rel="stylesheet" href="assets/css/autocomplete.css" type="text/css" media="screen" />
    <script type="text/javascript" src="assets/js/param/tabungan.js"></script>
    <script type="text/javascript" src="assets/js/jq/jquery.autocomplete.js"></script>
    
</head>
<body class="fixed-top">
	<div id="header" class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="brand" href="."><img src="assets/img/logoc.png" alt="MES"/></a>
				<a class="btn btn-navbar collapsed" id="main_menu_trigger" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="arrow"></span>
				</a>          			
				<div class="top-nav">
					<span class="jclock"></span>				
					<ul class="nav pull-right" id="top_menu">
						<li class="divider-vertical hidden-phone hidden-tablet"></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-user"></i>
							<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li><a href="profile" class="logut"><i class="icon-user"></i> Profile</a></li>
								<li><a href="auth/logout" class="logut"><i class="icon-key"></i> Log Out</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div id="container" class="row-fluid">
		<div id="sidebar" class="nav-collapse collapse">
			<div class="sidebar-toggler hidden-phone"></div>     	
			<?php foreach($menunya as $item) {echo $item;}?>
		</div>
		<div id="body">
			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span12">		
						<h3 class="page-title">
							Parameter
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="..">Home</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li><a href="#">Parameter</a></li>
						</ul>
					</div>
				</div>
				<div id="page" class="dashboard">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="tabbable tabbable-custom boxless">
                                <ul class="nav nav-tabs">
                                   <li class="active"><a href="#tabs-1" data-toggle="tab">Produk Tabungan</a></li>
                                   <li><a href="#tabs-2" data-toggle="tab">Parameter Tabungan</a></li>
                                   <li><a href="#tabs-3" data-toggle="tab">Daftar kode mutasi tabungan</a></li>
                                   <li><a href="#tabs-4" data-toggle="tab">Daftar biaya pemeliharaan simpanan wadiah</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tabs-1">
                                        <div class="widget box blue">
                                            <div class="widget-title">
                                               <h4><i class="icon-reorder"></i>Produk Tabungan</h4>
                                            </div>
                                            <br>
                                            <div class="row-fluid">
                                                <div id="table_produk">
                                                    <?php
                                                    $produk['option'][] = array("kode","Kode"); // value,title
                                                    $produk['tombol'] = '<button id="addproduk" class="btn btn-success">Tambah Produk <i class="icon-plus"></i></button>';
                                                    $produk['tabel_head'][] = array("","3%","No"); // id,width,title
                                                    $produk['tabel_head'][] = array("","10%","Kode");
                                                    $produk['tabel_head'][] = array("nama","25%","Nama");
                                                    $produk['tabel_head'][] = array("","10%","Manage");
                                                    $produk['tabel_head'][] = array("grouptabungan_id","5%","ID");
                                                    $this -> load -> view( 'filter_layout',$produk );
                                                    $this -> load -> view( 'table_layout',$produk );
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-2">
                                        <div class="widget box blue">
                                            <div class="widget-title">
                                               <h4><i class="icon-reorder"></i>Parameter Tabungan</h4>
                                            </div>
                                            <br>
                                            <div class="row-fluid">
                                                <form class="form-horizontal" id="form_mtabungan" method="post">
                                                    <div class="control-group">
                                                        <label class="control-label1">Kode Produk</label>
                                                        <div class="controls">
                                                            <input type="text" class="input-small m-wrap" id="kode_produk" name="kode_produk" readonly>
                                                        </div>
                                                    </div>
                                                    <!--<div class="control-group">
                                                        <label class="control-label1">Biaya adm pembukaan rekening</label>
                                                        <div class="controls">
                                                            <input type="text" class="input-large m-wrap" name="adm_buka_rekening" style="text-align: right;">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label1">Biaya adm penutupan rekening</label>
                                                        <div class="controls">
                                                            <input type="text" class="input-large m-wrap" name="adm_tutup_rekening" style="text-align: right;">
                                                        </div>
                                                    </div>-->
                                                    <div class="control-group">
                                                        <label class="control-label1">Adm lain - lain</label>
                                                        <div class="controls">
                                                            <input type="text" class="input-large m-wrap" name="adm_lain_lain" style="text-align: right;"> / bulan
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label1">PPH</label>
                                                        <div class="controls">
                                                            <input type="text" class="input-small m-wrap" name="tab_pph" style="text-align: right;"> %
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label1">Zakat</label>
                                                        <div class="controls">
                                                            <input type="text" class="input-small m-wrap" name="tab_zakat" style="text-align: right;"> %
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label1">GL produk</label>
                                                        <div class="controls">
                                                            <select tabindex="5" class="input-large" name="gl_produk">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group" id="idmudharabah">
                                                        <label class="control-label1">GL Bagi Hasil / Bonus</label>
                                                        <div class="controls">
                                                            <select tabindex="5" class="input-large" name="gl_bagihasil">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="control-group">
                                                        <label class="control-label1">GL adm buka / tutup rekening</label>
                                                        <div class="controls">
                                                            <select tabindex="5" class="input-large" name="gl_buka_tutup_rek">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label1">GL Bonus Simpanan Wadiah</label>
                                                        <div class="controls">
                                                            <select tabindex="5" class="input-large" name="gl_bonus">
                                                            </select>
                                                        </div>
                                                    </div> -->
                                                    <div class="control-group">
                                                        <label class="control-label1">GL Pemeliharaan Simpanan Wadiah</label>
                                                        <div class="controls">
                                                            <select tabindex="5" class="input-large" name="gl_pemeliharaan">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label1">GL Zakat</label>
                                                        <div class="controls">
                                                            <select tabindex="5" class="input-large" name="gl_zakat">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label1">GL Pajak</label>
                                                        <div class="controls">
                                                            <select tabindex="5" class="input-large" name="gl_pajak">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-actions">
                                                        <button class="btn btn-primary" id="tabungansave"><i class="icon-ok"></i> Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-3">
                                        <div class="widget box blue">
                                            <div class="widget-title">
                                               <h4><i class="icon-reorder"></i>Daftar kode mutasi tabungan</h4>
                                            </div>
                                            <br>
                                            <div class="row-fluid">
                                                <div id="table_mutasi">
                                                <?php
                                                $mutasi['option'][] = array("kode","Kode"); // value,title
                                                $mutasi['tombol'] = '<button id="addmutasi" class="btn btn-success">Tambah Kode Mutasi <i class="icon-plus"></i></button>';
                                                $mutasi['tabel_head'][] = array("","3%","No"); // id,width,title
                                                $mutasi['tabel_head'][] = array("","10%","Kode");
                                                $mutasi['tabel_head'][] = array("nama","25%","Nama");
                                                $mutasi['tabel_head'][] = array("","10%","Manage");
                                                $mutasi['tabel_head'][] = array("mutasi_id","5%","ID");
                                                $this -> load -> view( 'filter_layout',$mutasi );
                                                $this -> load -> view( 'table_layout',$mutasi );
                                                $this -> load -> view( 'paging_layout',$mutasi );
                                                ?>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-4">
                                        <div class="widget box blue">
                                            <div class="widget-title">
                                               <h4><i class="icon-reorder"></i>Daftar biaya pemeliharaan simpanan wadiah</h4>
                                            </div>
                                            <br>
                                            <div id="table_biaya">
                                                <?php
                                                $biaya['option'][] = array("kode","Kode"); // value,title
                                                $biaya['tombol'] = '<button id="addbiaya" class="btn btn-success">Tambah Biaya <i class="icon-plus"></i></button>';
                                                $biaya['tabel_head'][] = array("","3%","No"); // id,width,title
                                                $biaya['tabel_head'][] = array("","10%","Dana maximal");
                                                $biaya['tabel_head'][] = array("nama","25%","Biaya penitipan");
                                                $biaya['tabel_head'][] = array("","10%","Manage");
                                                $biaya['tabel_head'][] = array("biaya_id","5%","ID");
                                                $this -> load -> view( 'filter_layout',$biaya );
                                                $this -> load -> view( 'table_layout',$biaya );
                                                ?>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                </div>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>
	<div id="footer">
		<br>AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0 ini dipersembahkan oleh <img src="assets/img/pegadaianc.png" alt="pegadaian" class="center" />
		<div class="span pull-right">
			<span class="go-top"><i class="icon-arrow-up"></i></span>
		</div>
	</div>
<!-- Dialog Area -->
<div id="dialog-biaya">
      <form id="form_biaya" method="post">
        <fieldset>
		    <div class="fm-req">
		      <label for="kode">Dana maximal :</label>
		      <input class="inp" name="kode" type="text" id="mask_currency3" maxlength="20"/>
		    </div>
		    <div class="fm-req">
		      <label for="nama">Biaya penitipan :</label>
		      <input class="inp" name="nama" type="text" id="mask_currency4" maxlength="50" />
		    </div>
		    </fieldset>
		    <p class="infonya"></p>
    </form>
</div>
<div id="dialog-mutasi">
      <form id="form_mutasi" method="post">
        <fieldset>
		    <div class="fm-req">
		      <label for="kode">Kode :</label>
		      <input class="inp" name="kode"  type="text" maxlength="20"/>
		    </div>
		    <div class="fm-req">
		      <label for="nama">Nama :</label>
		      <input class="inp" name="nama" type="text" maxlength="50" />
		    </div>
		    </fieldset>
		    <p class="infonya"></p>
    </form>
</div>
<div id="dialog-produk">
      <form id="form_produk" method="post">
        <fieldset>
		    <div class="fm-req">
		      <label for="kode_produk">Kode :</label>
		      <input class="inp" name="kode_produk"  type="text" maxlength="20"/>
		    </div>
		    <div class="fm-req">
		      <label for="grouptabungan_nama">Nama :</label>
		      <input class="inp" name="grouptabungan_nama" type="text" maxlength="50" />
		    </div>
		    </fieldset>
		    <p class="infonya"></p>
    </form>
</div>


<div id="dialog-hapus-mutasi">
      <br /><h3><img src="assets/images/question.png">&nbsp;Anda yakin <span class="phps"></span> akan dihapus ?</h3>
</div>
<div id="dialog-hapus-biaya">
      <br /><h3><img src="assets/images/question.png">&nbsp;Anda yakin <span class="phps"></span> akan dihapus ?</h3>
</div>
</body>
</html>
