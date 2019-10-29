<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : monitor/cetaktabungan.php
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
    <script type="text/javascript" src="assets/js/monitor/cetaktabungan.js"></script>
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
							Monitor
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="..">Home</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li><a href="#">Monitor</a></li>
						</ul>
					</div>
				</div>
				<div id="page" class="dashboard">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="tabbable tabbable-custom boxless">
                                <ul class="nav nav-tabs">
                                   <li class="active"><a href="#tabs-1" data-toggle="tab">Transaksi rekening tabungan</a></li>
                                   <li><a href="#tabs-2" data-toggle="tab">Cetak Sampul Tabungan</a></li>
                                   <li><a href="#tabs-3" data-toggle="tab">Cari rekening tabungan</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tabs-1">
                                        <div id="table_lap">
                                            <form class="form-horizontal" id="form_setor" method="post">
                                            <div>
                                                <div class="control-group fm-req">
                                                    <label class="control-label">No. Rekening</label>
                                                    <div class="controls">
                                                        <input id="nomor_rekening" name="nomor_rekening" tabindex="4" type="text" class="inp input-large"> <a class="btn searchact"><i class="icon-search"></i></a>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Nama</label>
                                                    <div class="controls">
                                                        <input name="nama" tabindex="5" type="text" class="input-large">
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Alamat</label>
                                                    <div class="controls">
                                                        <input name="alamat" tabindex="6" type="text" class="input-xlarge">
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Kota / Kode pos</label>
                                                    <div class="controls">
                                                        <input name="kota" tabindex="7" type="text" class="input-large">
                                                    </div>
                                                </div>
                                                Baris ke: <input name="baris" id="baris" type="text" class="input-small" value="0"> Tanggal :  <input class="tgl m-wrap m-ctrl-medium date-picker input-small" size="10" id="tgllap1"/>  s/d  <input class="tgl m-wrap m-ctrl-medium date-picker input-small" size="10" id="tgllap2"/>
                                                <button class="btn ui-state-default ui-corner-all" id="buatdaftar">Buat daftar</button>
                                                <p class="infonya"></p>
                                            </div>
                                            </form>
                                            <div style="width:100%;background:#fff">
                                                <table style="margin-left:2px;width:100%;color:#000">
                                                    <thead>
                                                        <tr>
                                                            <td style="text-align:left;border-bottom:1px solid #000" align="center">NO</td>
                                                            <td style="text-align:left;border-bottom:1px solid #000" align="center">Tanggal</td>
                                                            <td style="text-align:left;border-bottom:1px solid #000" align="center">Sandi</td>
                                                            <td style="text-align:left;border-bottom:1px solid #000" align="center">Debet</td>
                                                            <td style="text-align:left;border-bottom:1px solid #000" align="center">Kredit</td>
                                                            <td style="text-align:left;border-bottom:1px solid #000" align="center">Saldo</td>
                                                            <td style="text-align:left;border-bottom:1px solid #000" align="center">Petugas</td>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                <div id="tlapcetak">
                                                    <table style="margin-left:2px;width:100%;color:#000">
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                                <br/><br/>
                                                <div class="ui-grid-footer ui-widget-header ui-corner-bottom" align="right"><button class="ui-state-default ui-corner-all"><img src="assets/images/printer.png"> Cetak</button></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-2">
                                    	<div id="table_lap1">
                                            <form class="form-horizontal" id="form_setor1" method="post">
                                            <div>
                                                <div class="control-group fm-req">
                                                    <label class="control-label">No. Rekening</label>
                                                    <div class="controls">
                                                        <input id="nomor_rekening1" name="nomor_rekening1" tabindex="4" type="text" class="inp input-large"> <a class="btn searchact1"><i class="icon-search"></i></a>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                            </form>
                                            <div style="width:100%;background:#fff">
                                                <div id="kopcetak">
                                                    <table style="margin-left:2px;width:100%;color:#000">
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                                <br><br>
                                                <div class="ui-grid-footer ui-widget-header ui-corner-bottom" align="right"><button class="ui-state-default ui-corner-all"><img src="assets/images/printer.png"> Cetak</button></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-3">
                                        <div class="widget box blue">
                                            <div class="widget-title">
                                               <h4><i class="icon-reorder"></i> Data Tabungan</h4>
                                            </div>
                                            <div id="table_datatabungan">
                                                <?php
                                                $nasabah['option'][] = array("t2.nama","Nama Nasabah"); // value,title
                                                $nasabah['option'][] = array("t2.nomor_rekening","Nomor Rekening"); // value,title
                                                $nasabah['tabel_head'][] = array("","5%","No"); // id,width,title
                                                $nasabah['tabel_head'][] = array("nomor_nasabah","12%","Nomor Rekening");
                                                $nasabah['tabel_head'][] = array("","20%","Nama nasabah");
                                                $nasabah['tabel_head'][] = array("","25%","Alamat");
                                                $nasabah['tabel_head'][] = array("","10%","Kota");
                                                $nasabah['tabel_head'][] = array("","5%","Manage");
                                                $nasabah['tabel_head'][] = array("nasabah_id","5%","ID");
                                                $this -> load -> view( 'filter_layout',$nasabah );
                                                $this -> load -> view( 'table_layout',$nasabah );
                                                $this -> load -> view( 'paging_layout',$nasabah );
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
    <iframe name="ctkframe" id="ctkframe" style="width:0px;height:0px;border:0" src="monitor/cetaktabungan/cetak"></iframe>
    <iframe name="ctkframe1" id="ctkframe1" style="width:0px;height:0px;border:0" src="monitor/cetaktabungan/cetakkop"></iframe>
</body>
</html>
