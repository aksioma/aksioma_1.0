<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : tool/hitungbasil.php
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
    
    <link rel="stylesheet" type="text/css" href="../assets/plugins/chosen-bootstrap/chosen/chosen.css" />
    
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
    
   <script type="text/javascript" src="../assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
   <script type="text/javascript" src="../assets/plugins/select2/select2.min.js"></script>
   <script type="text/javascript" src="../assets/plugins/jquery-tags-input/jquery.tagsinput.min.js"></script>
   <script type="text/javascript" src="../assets/plugins/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
   <script type="text/javascript" src="../assets/plugins/clockface/js/clockface.js"></script>
   <script type="text/javascript" src="../assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>   
   <script type="text/javascript" src="../assets/plugins/jquery.input-ip-address-control-1.0.min.js"></script>
   
   <script type="text/javascript" src="../assets/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
   <script type="text/javascript" src="../assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
   <script type="text/javascript" src="../assets/plugins/jquery.pulsate.min.js"></script>
	<script type="text/javascript" src="../assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
   <script type="text/javascript" src="../assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
   
    <script src="../assets/scripts/app.js" type="text/javascript"></script>
	<script src="../assets/scripts/form-components.js"></script>     
   <script src="../assets/scripts/form-wizard.js"></script> 
   <script src="../assets/scripts/ui-general.js"></script>
   <script src="../assets/scripts/form-validationtabungan.js"></script> 
	<script>
		jQuery(document).ready(function() {		
			App.init(); // initlayout and core plugins
            FormComponents.init();
            FormWizard.init();
            UIGeneral.init();
            FormValidation.init();
		});
	</script>
    <?php $this -> load -> view( 'header' );?>
    <link rel="stylesheet" href="assets/css/autocomplete.css" type="text/css" media="screen" />
    <script type="text/javascript" src="assets/js/tool/hitungbasil.js"></script>
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
							Tool
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="..">Home</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li><a href="#">Tool</a></li>
						</ul>
					</div>
				</div>
				<div id="page" class="dashboard">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="tabbable tabbable-custom boxless">
                                <ul class="nav nav-tabs">
                                   <li class="active"><a href="#tabs-1" data-toggle="tab">Data Perhitugan Utama</a></li>
                                   <li><a href="#tabs-2" data-toggle="tab">Rincian Saldo rata-rata</a></li>
                                   <li><a href="#tabs-3" data-toggle="tab">Rincian Bagi Hasil per Produk</a></li>
                                   <li><a href="#tabs-4" data-toggle="tab">Rincian Bagi Hasil per Nasabah</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tabs-1">
                                        <div class="span12">
                                            <table class="table table-hover">
                                                <tbody>
                                                    <tr>
                                                        <td>Periode</td>
                                                        <td>
                                                            <input name="periode1" id="periode1" type="text" size="10" class="inp m-wrap m-ctrl-medium date-picker input-small"> s/d 
                                                            <input name="periode2" id="periode2" type="text" size="10" class="inp m-wrap m-ctrl-medium date-picker input-small">
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" align="center"><b>Hitung saldo rata-rata penghimpunan</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Saldo rata-rata penghimpunan</td>
                                                        <td><input id="saldoratahimpun" name="saldoratahimpun" type="text" size="10" class="input-medium" style="text-align: right;"></td>
                                                        <td align="right"><button class="btn btn-warning hitung" id="hitung"><i class="icon-ok"></i> Hitung saldo rata - rata</button></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Saldo pendapatan</td>
                                                        <td><input id="saldoratapenyalur" name="saldoratapenyalur" type="text" size="10" class="input-medium" style="text-align: right;"></td>
                                                        <td align="right"><button class="btn" id="lihat_rincian"><i class="icon-eye-open"></i> Lihat rincian saldo rata - rata</button></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" align="center"><b>Hitung bagi hasil</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Bagi Hasil</td>
                                                        <td><input id="totalbasil" name="totalbasil" type="text" size="10" class="input-medium" style="text-align: right;"></td>
                                                        <td align="right">
	                                                        <button class="btn btn-danger proses_hitung_basil" id="proses_hitung_basil"><i class="icon-plus icon-white"></i> Proses hitung bagi hasil</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Bonus wadiah yang dibagikan</td>
                                                        <td><input id="bonusdibagi" name="bonusdibagi" type="text" size="10" class="input-medium">
	                                                        Minimal saldo rata-rata<input id="minsaldo" name="minsaldo" type="text" size="10" class="input-medium">
	                                                    </td>
                                                        <td align="right"><button class="btn btn-primary hitung_bonus_wadiah" id="hitung_bonus_wadiah"><i class="icon-money"></i> Proses hitung bonus wadiah</button><br><br>
	                                                        <button class="btn" id="lihat_rincian_basil1"><i class="icon-eye-open"></i> Lihat rincian bagi hasil per produk.....</button><br>
	                                                        <button class="btn" id="lihat_rincian_basil2"><i class="icon-eye-open"></i> Lihat rincian bagi hasil per nasabah...</button></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" colspan="3"><button class="btn btn-success distribusi_basil" id="distribusi_basil"> <i class="icon-star-empty"></i> <i class="icon-star-empty"></i> <i class="icon-star-empty"></i> Distribusi bagi hasil</button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Zakat</td>
                                                        <td><span class="infoproses2"><img src="assets/images/loading.gif"> Proses...</span> <span class="ok2"><img src="assets/images/icontruechecklist.png"> OK</span></td>
                                                         <td align="right"><button class="btn btn-inverse aZakat" id="aZakat"><i class="icon-ok"></i> Proses</button></td>
                                                    </tr>
                                                    <tr>
                                                        <td>PPH</td>
                                                        <td><span class="infoproses4"><img src="assets/images/loading.gif"> Proses...</span> <span class="ok4"><img src="assets/images/icontruechecklist.png"> OK</span></td>
                                                         <td align="right"><button class="btn btn-info aPph" id="aPph"><i class="icon-ok"></i> Proses</button></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td><b>Administrasi</b><br>Untuk proses ini dijalankan satu bulan sekali</td>
                                                        <td><span class="infoproses3"><img src="assets/images/loading.gif"> Proses...</span> <span class="ok3"><img src="assets/images/icontruechecklist.png"> OK</span></td>
                                                         <td align="right"><button class="btn btn-danger aAdm" id="aAdm"><i class="icon-plus icon-white"></i> Proses</button></td>
                                                    </tr>
                                                    
                                                    
                                                <tr>
                                                </tbody>
                                            </table>
                                            
                                            
                                        </div>
                                        
                                    </div>
                                    <div class="tab-pane" id="tabs-2">
                                        <div class="span12">
                                            <div class="widget">
                                                <div class="widget-title">
                                                    <h4><i class="icon-reorder"></i>Perhimpunan dana</h4>
                                                </div>
                                            </div>
                                            <div class="widget-body" id="tblperhimpunan">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama sumber dana</th>
                                                            <th>Akun</th>
                                                            <th>Saldo rata-rata</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-3">
                                        <div class="span12">
                                            <div class="widget">
                                                <div class="widget-title">
                                                    <h4><i class="icon-reorder"></i>Rincian bagi hasil per Produk</h4>
                                                </div>
                                            </div>
                                            <div class="widget-body" id="tblrincianbasil1">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama sumber dana</th>
                                                            <th>Akun</th>
                                                            <th>Bagi hasil / Bonus</th>
                                                            <th>Pendapatan bank</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-4">
                                        <div class="span12">
                                            <div class="widget">
                                                <div class="widget-title">
                                                    <h4><i class="icon-reorder"></i>Rincian bagi hasil per Nasabah</h4>
                                                </div>
                                            </div>
                                            <div class="widget-body" id="tblrincianbasil2">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nomor rekening</th>
                                                            <th>Nama</th>
                                                            <th>Mulai</th>
                                                            <th>Sampai</th>
                                                            <th>Saldo rata-rata</th>
                                                            <th>Basil/Bonus</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
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
	</div>
	<div id="footer">
		<br>AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0 ini dipersembahkan oleh <img src="assets/img/pegadaianc.png" alt="pegadaian" class="center" />
		<div class="span pull-right">
			<span class="go-top"><i class="icon-arrow-up"></i></span>
		</div>
	</div>
    <!-- Dialog Area -->
</body>
</html>
