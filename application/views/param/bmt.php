<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/bmt.php
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
    
    <script src="../assets/scripts/app.js" type="text/javascript"></script>
	
	<script>
		jQuery(document).ready(function() {		
			App.init(); // initlayout and core plugins
			
		});
	</script>
    <?php $this -> load -> view( 'header' );?>
    <link rel="stylesheet" href="assets/css/autocomplete.css" type="text/css" media="screen" />
    <script type="text/javascript" src="assets/js/param/bmt.js"></script>
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
                                   <li class="active"><a href="#tabs-1" data-toggle="tab">Tentang BMT</a></li>
                                   <li><a href="#tabs-2" data-toggle="tab">Wilayah Kerja</a></li>
                                   <li><a href="#tabs-3" data-toggle="tab">Tahun Buku</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tabs-1">
                                        <div class="widget box blue">
                                            <div class="widget-title">
                                               <h4><i class="icon-reorder"></i>Identitas BMT</h4>
                                            </div>
                                            <br>
                                            <div class="row-fluid">
                                                <form class="form-horizontal" id="form_bmtinfo" method="post">
                                                    <div class="control-group">
                                                        <label class="control-label">Nama</label>
                                                        <div class="controls">
                                                            <input type="text" class="input-large" name="nama">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Kode Cabang</label>
                                                        <div class="controls">
                                                            <input type="text" class="input-small" name="kode_cabang"> (2 digit)
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Alamat</label>
                                                        <div class="controls">
                                                            <input type="text" class="input-xlarge" name="alamat">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Kota / Kode Pos</label>
                                                        <div class="controls">
                                                            <input type="text" class="input-medium" name="kota"> <input type="text" class="input-small" name="kode_pos">
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Propinsi</label>
                                                        <div class="controls">
                                                            <select tabindex="5" class="input-large" name="propinsi">
                                                                <option value=""></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Wilayah kerja Kantor ini</label>
                                                        <div class="controls">
                                                            <select tabindex="5" class="input-large" name="wilayah_kerja">
                                                                <option value=""></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-actions">
                                                        <button class="btn btn-primary" id="bmtsave"><i class="icon-ok"></i> Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-2">
                                        <div class="widget box blue">
                                            <div class="widget-title">
                                               <h4><i class="icon-reorder"></i>Wilayah Kerja</h4>
                                            </div>
                                            <div id="table_bmt">
                                                <?php
                                                $bmt['option'][] = array("nama_wilayah","Nama Wilayah"); // value,title
                                                $bmt['tombol'] = '<button id="addwilayah" class="btn btn-success">Tambah Wilayah <i class="icon-plus"></i></button>';
                                                $bmt['tabel_head'][] = array("","3%","No"); // id,width,title
                                                $bmt['tabel_head'][] = array("","10%","Kode");
                                                $bmt['tabel_head'][] = array("nama_wilayah","25%","Nama Wilayah");
                                                $bmt['tabel_head'][] = array("","10%","Manage");
                                                $bmt['tabel_head'][] = array("bmt_id","5%","ID");
                                                $this -> load -> view( 'filter_layout',$bmt );
                                                $this -> load -> view( 'table_layout',$bmt );
                                                //$this -> load -> view( 'paging_layout',$bmt );
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-3">
                                        <div class="widget box blue">
                                            <div class="widget-title">
                                               <h4><i class="icon-reorder"></i>Tahun Buku</h4>
                                            </div>
                                            <div id="table_tahunbuku">
                                                <?php
                                                $thnbuku['option'][] = array("nama_tahun","Tahun Buku"); // value,title
                                                $thnbuku['tombol'] = '<button id="addtahunbuku" class="btn btn-success">Tambah Tahun Buku <i class="icon-plus"></i></button>';
                                                $thnbuku['tabel_head'][] = array("","3%","No"); // id,width,title
                                                $thnbuku['tabel_head'][] = array("nama_tahun","20%","Tahun");
                                                $thnbuku['tabel_head'][] = array("","20%","TGL Mulai");
                                                $thnbuku['tabel_head'][] = array("","20%","TGL Selesai");
                                                $thnbuku['tabel_head'][] = array("","5%","Status");
                                                $thnbuku['tabel_head'][] = array("","10%","Manage");
                                                $thnbuku['tabel_head'][] = array("tahunbuku_id","5%","ID");
                                                $this -> load -> view( 'filter_layout',$thnbuku );
                                                $this -> load -> view( 'table_layout',$thnbuku );
                                                //$this -> load -> view( 'paging_layout',$bmt );
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
<div id="dialog-bmt">
      <form id="form_bmt" method="post">
        <fieldset>
		    <div class="fm-req">
		      <label for="kode">Kode :</label>
		      <input class="inp" name="kode"  type="text" maxlength="20"/>
		    </div>
		    <div class="fm-req">
		      <label for="wilayah_kerja">Wilayah Kerja :</label>
		      <input class="inp" name="wilayah_kerja" type="text" maxlength="50" />
		    </div>
		    </fieldset>
		    <p class="infonya"></p>
    </form>
</div>
<div id="dialog-tahunbuku">
      <form id="form_tahunbuku" method="post">
        <fieldset>
		    <div class="fm-req">
		      <label for="kode">Tahun buku :</label>
		      <input class="inp" name="nama_tahun"  type="text" maxlength="20"/>
		    </div>
		    <div class="fm-req">
		      <label for="wilayah_kerja">Tgl Mulai :</label>
		      <input class="inp tgl" maxlength="10" name="tgl_mulai"  type="text" style="width:80px" />
		    </div>
		    <div class="fm-req">
		      <label for="wilayah_kerja">Tgl Selesai :</label>
		      <input class="inp tgl" maxlength="10" name="tgl_akhir"  type="text" style="width:80px" />
		    </div>
		    <div class="fm-opt">
		      <label for="active">Aktif :</label>
		      <input type="checkbox" id="CTBaktif" name="active"/>
		    </div>
		    </fieldset>
		    <p class="infonya"></p>
    </form>
</div>
<div id="dialog-hapus-bmt">
      <br /><h3><img src="assets/images/question.png">&nbsp;Anda yakin <span class="phps"></span> akan dihapus ?</h3>
</div>
<div id="dialog-hapus-tahunbuku">
      <br /><h3><img src="assets/images/question.png">&nbsp;Anda yakin <span class="phps"></span> akan dihapus ?</h3>
</div>
</body>
</html>
