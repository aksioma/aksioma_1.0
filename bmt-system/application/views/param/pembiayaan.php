<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/pembiayaan.php
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
    <script type="text/javascript" src="assets/js/param/pembiayaan.js"></script>
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
                                   <li class="active"><a href="#tabs-1" data-toggle="tab">Produk Pembiayaan</a></li>
                                   <li><a href="#tabs-2" data-toggle="tab">Parameter Pembiayaan</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tabs-1">
                                        <div class="widget box blue">
                                            <div class="widget-title">
                                               <h4><i class="icon-reorder"></i>Produk Pembiayaan</h4>
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
                                               <h4><i class="icon-reorder"></i>Parameter Pembiayaan</h4>
                                            </div>
                                            <br>
                                            <div class="row-fluid">
                                                <form class="form-horizontal" id="form_mpembiayaan" method="post">
                                                    <div class="control-group">
                                                        <label class="control-label1">Kode Produk</label>
                                                        <div class="controls">
                                                            <input type="text" class="input-small m-wrap" id="kode_produk" name="kode_produk" readonly>
                                                        </div>
                                                    </div>
                                                    <!--<div class="control-group">
                                                        <label class="control-label1">Biaya Administrasi</label>
                                                        <div class="controls">
                                                            <input type="text" class="input-large m-wrap" name="biaya_administrasi" style="text-align: right;">
                                                        </div>
                                                    </div>  -->
                                                    <div class="control-group">
                                                        <label class="control-label1">GL Produk</label>
                                                        <div class="controls">
                                                            <select tabindex="5" class="input-xlarge" name="gl_produk">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!--<div class="control-group">
                                                        <label class="control-label1">GL Administrasi</label>
                                                        <div class="controls">
                                                            <select tabindex="5" class="input-xlarge" name="gl_administrasi">
                                                            </select>
                                                        </div>
                                                    </div>-->
                                                    <div id="idmurabahah">
                                                        <div class="control-group">
                                                            <label class="control-label1">Margin Ditangguhkan</label>
                                                            <div class="controls">
                                                                <select tabindex="5" class="input-xlarge" name="gl_marginditangguhkan">
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label1">Pendapatan Margin</label>
                                                            <div class="controls">
                                                                <select tabindex="5" class="input-xlarge" name="gl_pendapatanmargin">
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="control-group">
                                                            <label class="control-label1">Diskon</label>
                                                            <div class="controls">
                                                                <select tabindex="5" class="input-xlarge" name="gl_diskon">
                                                                </select>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <div id="idmudharabah">
                                                        <div class="control-group">
                                                            <label class="control-label1">Pendapatan bagi hasil</label>
                                                            <div class="controls">
                                                                <select tabindex="5" class="input-xlarge" name="gl_pendapatanbagihasil">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="idalqardh">
                                                        <div class="control-group">
                                                            <label class="control-label1">Bonus Al-Qordh</label>
                                                            <div class="controls">
                                                                <select tabindex="5" class="input-xlarge" name="gl_bonusalqardh">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="idmusyarokah">
                                                        <div class="control-group">
                                                            <label class="control-label1">Pendapatan bagi hasil</label>
                                                            <div class="controls">
                                                                <select tabindex="5" class="input-xlarge" name="gl_pendapatanbagihasilmusy">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="idijarah">
                                                        <div class="control-group">
                                                            <label class="control-label1">Aktiva ijarah</label>
                                                            <div class="controls">
                                                                <select tabindex="5" class="input-xlarge" name="gl_activaijarah">
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label1">Pendapatan ijarah</label>
                                                            <div class="controls">
                                                                <select tabindex="5" class="input-xlarge" name="gl_pendapatanijarah">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="idistishna">
                                                        <div class="control-group">
                                                            <label class="control-label1">Aset dalam penyelesaian</label>
                                                            <div class="controls">
                                                                <select tabindex="5" class="input-xlarge" name="gl_asetistishna">
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label1">Pendapatan marjin</label>
                                                            <div class="controls">
                                                                <select tabindex="5" class="input-xlarge" name="gl_pendapatanmarjinistishna">
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label1">Diskon</label>
                                                            <div class="controls">
                                                                <select tabindex="5" class="input-xlarge" name="gl_diskonistishna">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="idsalam">
                                                        <div class="control-group">
                                                            <label class="control-label1">Pendapatan keuntungan</label>
                                                            <div class="controls">
                                                                <select tabindex="5" class="input-xlarge" name="gl_pendapatankeuntungansalam">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-actions">
                                                        <button class="btn btn-primary" id="pembiayaansave"><i class="icon-ok"></i> Save</button>
                                                    </div>
                                                </form>
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

<div id="dialog-produk">
      <form id="form_produk" method="post">
        <fieldset>
		    <div class="fm-req">
		      <label for="kode_produk">Kode :</label>
		      <input class="inp" name="kode_produk"  type="text" maxlength="20"/>
		    </div>
		    <div class="fm-req">
		      <label for="grouppembiayaan_nama">Nama :</label>
		      <input class="inp" name="grouppembiayaan_nama" type="text" maxlength="50" />
		    </div>
		    </fieldset>
		    <p class="infonya"></p>
    </form>
</div>

</body>
</html>
