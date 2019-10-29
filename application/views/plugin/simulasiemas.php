<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : plugin/simulasiemas.php
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
    <script type="text/javascript" src="assets/js/plugin/simulasiemas.js"></script>
</head>
<body class="fixed-top">
	<div id="header" class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="brand" href="."><img src="<?php echo $logo;?>" alt="MES"/></a>
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
							Plugin
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="..">Home</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li><a href="#">Simulasi Emas</a></li>
						</ul>
					</div>
				</div>
				<div id="page" class="dashboard">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="tabbable tabbable-custom boxless">
                                <ul class="nav nav-tabs">
                                   <li class="active"><a href="#tabs-1" data-toggle="tab">Simulasi pembelian Emas</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tabs-1">
                                    	<div class="well">
                                    		<form class="form-horizontal" action="#">
		                                       <div class="control-group">
		                                          <label class="control-label">Harga Emas</label>
		                                          <div class="controls">
		                                             <input type="text" class="input-small int" style="text-align: right;" id="hargaemas">
		                                          </div>
		                                       </div>
		                                       <p class="text-success">Silahkan ganti harga emas di atas sesuai harga emas terbaru</p>
                                       		</form>
                                       	</div>	
                              			<div class="widget">
                              				<div class="widget-title"><h4><i class="icon-reorder"></i>Angsuran Personal</h4></div>
					                        <div class="widget-body">
					                           <table class="table table-bordered">
					                              <thead>
					                                 <tr>
					                                    <th rowspan="2" width="10%">Jenis keping</th>
					                                    <th rowspan="2" width="12%">Harga dasar</th>
					                                    <th rowspan="2" width="13%">Uang muka minimal</th>
					                                    <th colspan="6" width="65%">Angsuran perbulan untuk jangka waktu</th>
					                                 </tr>
					                                 <tr>
					                                    <th>3 Bulan</th>
					                                    <th>6 Bulan</th>
					                                    <th>9 Bulan</th>
					                                    <th>12 Bulan</th>
					                                    <th>24 Bulan</th>
					                                    <th>36 Bulan</th>
					                                 </tr>
					                              </thead>
					                              <tbody>
					                                 <tr>
					                                    <td style="text-align:center;">1 gr</td>
					                                    <!--<td style="text-align:right;"><input type="text" class="input-medium int" id="col0_row1" style="text-align: right;"></td> -->
					                                    <td style="text-align:right;"><span class="col0_row1"></span></td>
					                                    <td style="text-align:right;"><span class="col1_row1"></span></td>
					                                    <td style="text-align:right;"><span class="col2_row1"></span></td>
					                                    <td style="text-align:right;"><span class="col3_row1"></span></td>
					                                    <td style="text-align:right;"><span class="col4_row1"></span></td>
					                                    <td style="text-align:right;"><span class="col5_row1"></span></td>
					                                    <td style="text-align:right;"><span class="col6_row1"></span></td>
					                                    <td style="text-align:right;"><span class="col7_row1"></span></td>
					                                 </tr>
					                                 <tr>
					                                    <td style="text-align:center;">5 gr</td>
					                                    <!--<td style="text-align:right;"><input type="text" class="input-medium int" id="col0_row2" style="text-align: right;"></td>  -->
					                                    <td style="text-align:right;"><span class="col0_row2"></span></td>
					                                    <td style="text-align:right;"><span class="col1_row2"></span></td>
					                                    <td style="text-align:right;"><span class="col2_row2"></span></td>
					                                    <td style="text-align:right;"><span class="col3_row2"></span></td>
					                                    <td style="text-align:right;"><span class="col4_row2"></span></td>
					                                    <td style="text-align:right;"><span class="col5_row2"></span></td>
					                                    <td style="text-align:right;"><span class="col6_row2"></span></td>
					                                    <td style="text-align:right;"><span class="col7_row2"></span></td>
					                                 </tr>
					                                 <tr>
					                                    <td style="text-align:center;">10 gr</td>
					                                    <!--<td style="text-align:right;"><input type="text" class="input-medium int" id="col0_row3" style="text-align: right;"></td>  -->
					                                    <td style="text-align:right;"><span class="col0_row3"></span></td>
					                                    <td style="text-align:right;"><span class="col1_row3"></span></td>
					                                    <td style="text-align:right;"><span class="col2_row3"></span></td>
					                                    <td style="text-align:right;"><span class="col3_row3"></span></td>
					                                    <td style="text-align:right;"><span class="col4_row3"></span></td>
					                                    <td style="text-align:right;"><span class="col5_row3"></span></td>
					                                    <td style="text-align:right;"><span class="col6_row3"></span></td>
					                                    <td style="text-align:right;"><span class="col7_row3"></span></td>
					                                 </tr>
					                                 <tr>
					                                    <td style="text-align:center;">25 gr</td>
					                                    <td style="text-align:right;"><span class="col0_row4"></span></td>
					                                    <td style="text-align:right;"><span class="col1_row4"></span></td>
					                                    <td style="text-align:right;"><span class="col2_row4"></span></td>
					                                    <td style="text-align:right;"><span class="col3_row4"></span></td>
					                                    <td style="text-align:right;"><span class="col4_row4"></span></td>
					                                    <td style="text-align:right;"><span class="col5_row4"></span></td>
					                                    <td style="text-align:right;"><span class="col6_row4"></span></td>
					                                    <td style="text-align:right;"><span class="col7_row4"></span></td>
					                                 </tr>
					                                 <tr>
					                                    <td style="text-align:center;">50 gr</td>
					                                    <td style="text-align:right;"><span class="col0_row5"></span></td>
					                                    <td style="text-align:right;"><span class="col1_row5"></span></td>
					                                    <td style="text-align:right;"><span class="col2_row5"></span></td>
					                                    <td style="text-align:right;"><span class="col3_row5"></span></td>
					                                    <td style="text-align:right;"><span class="col4_row5"></span></td>
					                                    <td style="text-align:right;"><span class="col5_row5"></span></td>
					                                    <td style="text-align:right;"><span class="col6_row5"></span></td>
					                                    <td style="text-align:right;"><span class="col7_row5"></span></td>
					                                 </tr>
					                                 <tr>
					                                    <td style="text-align:center;">100 gr</td>
					                                    <td style="text-align:right;"><span class="col0_row6"></span></td>
					                                    <td style="text-align:right;"><span class="col1_row6"></span></td>
					                                    <td style="text-align:right;"><span class="col2_row6"></span></td>
					                                    <td style="text-align:right;"><span class="col3_row6"></span></td>
					                                    <td style="text-align:right;"><span class="col4_row6"></span></td>
					                                    <td style="text-align:right;"><span class="col5_row6"></span></td>
					                                    <td style="text-align:right;"><span class="col6_row6"></span></td>
					                                    <td style="text-align:right;"><span class="col7_row6"></span></td>
					                                 </tr>
					                              </tbody>
					                           </table>
					                        </div>
					                     </div>
					                     <br>
					                     <div class="widget">
                              				<div class="widget-title"><h4><i class="icon-reorder"></i>Angsuran Arisan</h4></div>
					                        <div class="widget-body">
					                           <table class="table table-bordered">
					                              <thead>
					                                 <tr>
					                                    <th rowspan="2" width="10%">Jenis keping</th>
					                                    <th rowspan="2" width="12%">Harga dasar</th>
					                                    <th rowspan="2" width="13%">Uang muka perorang</th>
					                                    <th colspan="6" width="65%">Angsuran Perorang setiap bulan Untuk Jumlah Anggota</th>
					                                 </tr>
					                                 <tr>
					                                    <th>6 Orang</th>
					                                    <th>8 Orang</th>
					                                    <th>10 Orang</th>
					                                    <th>12 Orang</th>
					                                    <th>14 Orang</th>
					                                    <th>16 Orang</th>
					                                 </tr>
					                              </thead>
					                              <tbody>
					                                 <tr>
					                                    <td style="text-align:center;">1 gr</td>
					                                    <!--<td style="text-align:right;"><input type="text" class="input-medium int" id="col0_row1" style="text-align: right;"></td> -->
					                                    <td style="text-align:right;"><span class="col0_row7"></span></td>
					                                    <td style="text-align:right;"><span class="col1_row7"></span></td>
					                                    <td style="text-align:right;"><span class="col2_row7"></span></td>
					                                    <td style="text-align:right;"><span class="col3_row7"></span></td>
					                                    <td style="text-align:right;"><span class="col4_row7"></span></td>
					                                    <td style="text-align:right;"><span class="col5_row7"></span></td>
					                                    <td style="text-align:right;"><span class="col6_row7"></span></td>
					                                    <td style="text-align:right;"><span class="col7_row7"></span></td>
					                                 </tr>
					                                 <tr>
					                                    <td style="text-align:center;">5 gr</td>
					                                    <!--<td style="text-align:right;"><input type="text" class="input-medium int" id="col0_row2" style="text-align: right;"></td>  -->
					                                    <td style="text-align:right;"><span class="col0_row8"></span></td>
					                                    <td style="text-align:right;"><span class="col1_row8"></span></td>
					                                    <td style="text-align:right;"><span class="col2_row8"></span></td>
					                                    <td style="text-align:right;"><span class="col3_row8"></span></td>
					                                    <td style="text-align:right;"><span class="col4_row8"></span></td>
					                                    <td style="text-align:right;"><span class="col5_row8"></span></td>
					                                    <td style="text-align:right;"><span class="col6_row8"></span></td>
					                                    <td style="text-align:right;"><span class="col7_row8"></span></td>
					                                 </tr>
					                                 <tr>
					                                    <td style="text-align:center;">10 gr</td>
					                                    <!--<td style="text-align:right;"><input type="text" class="input-medium int" id="col0_row3" style="text-align: right;"></td>  -->
					                                    <td style="text-align:right;"><span class="col0_row9"></span></td>
					                                    <td style="text-align:right;"><span class="col1_row9"></span></td>
					                                    <td style="text-align:right;"><span class="col2_row9"></span></td>
					                                    <td style="text-align:right;"><span class="col3_row9"></span></td>
					                                    <td style="text-align:right;"><span class="col4_row9"></span></td>
					                                    <td style="text-align:right;"><span class="col5_row9"></span></td>
					                                    <td style="text-align:right;"><span class="col6_row9"></span></td>
					                                    <td style="text-align:right;"><span class="col7_row9"></span></td>
					                                 </tr>
					                                 <tr>
					                                    <td style="text-align:center;">25 gr</td>
					                                    <td style="text-align:right;"><span class="col0_row10"></span></td>
					                                    <td style="text-align:right;"><span class="col1_row10"></span></td>
					                                    <td style="text-align:right;"><span class="col2_row10"></span></td>
					                                    <td style="text-align:right;"><span class="col3_row10"></span></td>
					                                    <td style="text-align:right;"><span class="col4_row10"></span></td>
					                                    <td style="text-align:right;"><span class="col5_row10"></span></td>
					                                    <td style="text-align:right;"><span class="col6_row10"></span></td>
					                                    <td style="text-align:right;"><span class="col7_row10"></span></td>
					                                 </tr>
					                                 <tr>
					                                    <td style="text-align:center;">50 gr</td>
					                                    <td style="text-align:right;"><span class="col0_row11"></span></td>
					                                    <td style="text-align:right;"><span class="col1_row11"></span></td>
					                                    <td style="text-align:right;"><span class="col2_row11"></span></td>
					                                    <td style="text-align:right;"><span class="col3_row11"></span></td>
					                                    <td style="text-align:right;"><span class="col4_row11"></span></td>
					                                    <td style="text-align:right;"><span class="col5_row11"></span></td>
					                                    <td style="text-align:right;"><span class="col6_row11"></span></td>
					                                    <td style="text-align:right;"><span class="col7_row11"></span></td>
					                                 </tr>
					                                 <tr>
					                                    <td style="text-align:center;">100 gr</td>
					                                    <td style="text-align:right;"><span class="col0_row12"></span></td>
					                                    <td style="text-align:right;"><span class="col1_row12"></span></td>
					                                    <td style="text-align:right;"><span class="col2_row12"></span></td>
					                                    <td style="text-align:right;"><span class="col3_row12"></span></td>
					                                    <td style="text-align:right;"><span class="col4_row12"></span></td>
					                                    <td style="text-align:right;"><span class="col5_row12"></span></td>
					                                    <td style="text-align:right;"><span class="col6_row12"></span></td>
					                                    <td style="text-align:right;"><span class="col7_row12"></span></td>
					                                 </tr>
					                              </tbody>
					                           </table>
					                        </div>
					                     </div>
					                     <p><ul type="-">
					                     <li>Harga sesuai dengan hari transaksi</li>
					                     <li>Pembelian secara angsuran dilayani diseluruh Kantor Pegadaian</li>
					                     </ul>
					                     </p>
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
