<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/listakun.php
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
    <link href="../assets/plugins/bootstrap-tree/bootstrap-tree/css/bootstrap-tree.css" rel="stylesheet" type="text/css"/>
    
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
    <script src="../assets/plugins/bootstrap-tree/bootstrap-tree/js/bootstrap-tree.js"></script>
    <script type="text/javascript" src="../assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>   
   
    <script src="../assets/scripts/app.js" type="text/javascript"></script>
	<script src="../assets/scripts/ui-tree.js" type="text/javascript"></script>
	<script src="../assets/scripts/form-components.js"></script>
    
	<script>
		jQuery(document).ready(function() {		
			App.init(); // initlayout and core plugins
			UITree.init();
            FormComponents.init();
		});
	</script>
    <?php $this -> load -> view( 'header' );?>
    <link rel="stylesheet" href="assets/css/autocomplete.css" type="text/css" media="screen" />
    <script type="text/javascript" src="assets/js/param/listakun.js"></script>
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
                                   <!--<li class="active"><a href="#tabs-1" data-toggle="tab">Tahun buku</a></li>-->
                                   <li class="active"><a href="#tabs-1" data-toggle="tab">List listakun</a></li>
                                   <li><a href="#tabs-2" data-toggle="tab">Daftar Akun / Chart of Account</a></li>
                                </ul>
                                <div class="tab-content">
                                    <!--<div class="tab-pane active" id="tabs-1">
                                        <div class="widget box blue">
                                            <div class="widget-title">
                                               <h4><i class="icon-reorder"></i>Tahun buku</h4>
                                            </div>
                                            <div id="table_listtahunbuku">  	
                                                <?php
                                                /*$tahunbuku['option'][] = array("nama_tahun","Tahun"); // value,title
                                                $tahunbuku['tombol'] = '<button id="addtbuku" class="fg-button ui-state-default ui-corner-all"><img src="assets/images/addicon.png" />Tambah Tahun buku</button>';
                                                $tahunbuku['tabel_head'][] = array("","5%","No"); // id,width,title
                                                $tahunbuku['tabel_head'][] = array("nama_tahun","25%","Nama tahun buku");
                                                $tahunbuku['tabel_head'][] = array("","20%","Tgl Mulai");
                                                $tahunbuku['tabel_head'][] = array("","20%","Tgl Selesai");
                                                $tahunbuku['tabel_head'][] = array("","5%","Manage");
                                                $tahunbuku['tabel_head'][] = array("tahunbuku_id","5%","ID");
                                                $this -> load -> view( 'filter_layout',$tahunbuku );
                                                $this -> load -> view( 'table_layout',$tahunbuku );
                                                $this -> load -> view( 'paging_layout',$tahunbuku );
                                                */
                                                ?>
                                            </div>
                                        </div>
                                    </div>-->
                                    <div class="tab-pane active" id="tabs-1">
                                        <div class="widget box blue">
                                            <div class="widget-title">
                                               <h4><i class="icon-reorder"></i>Form List listakun</h4>
                                            </div>
                                            <div id="table_listakun">  	
                                                <?php
                                                $listakun['option'][] = array("listakun_code","Kode CoA"); // value,title
                                                $listakun['option'][] = array("listakun_name","Nama Akun"); // value,title
                                                $listakun['tombol'] = '<button id="addakun" class="fg-button ui-state-default ui-corner-all"><img src="assets/images/addicon.png" />Tambah Akun</button>';
                                                $listakun['tabel_head'][] = array("","5%","No"); // id,width,title
                                                $listakun['tabel_head'][] = array("listakun_code","25%","Kode CoA");
                                                $listakun['tabel_head'][] = array("","40%","Nama Akun");
                                                $listakun['tabel_head'][] = array("","5%","Manage");
                                                $listakun['tabel_head'][] = array("listakun_id","5%","ID");
                                                $this -> load -> view( 'filter_layout',$listakun );
                                                $this -> load -> view( 'table_layout',$listakun );
                                                $this -> load -> view( 'paging_layout',$listakun );
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-2">
                                        <div class="widget box blue">
                                            <div class="widget">
                                                <div class="widget-title">
                                                   <h4><i class="icon-sitemap"></i>Daftar Akun / Chart of Account</h4>
                                                </div>
                                                <div class="widget-body" id="isitree"></div>
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
    <div id="dialog-akun">
          <form id="form_akun" method="post">
            <fieldset>
                <div class="fm-req">
                  <label for="listakun_code">Kode Akun :</label>
                  <input class="inp" name="listakun_code" type="text"/>
                </div>
                <div class="fm-req">
                  <label for="listakun_name">Nama Akun :</label>
                  <input class="inp" name="listakun_name" type="text" />
                </div>
                <div class="fm-opt">
                  <label>Kode Tambahan :</label>
                  <input class="inp" name="listakun_alias" type="text"/>
                </div>
                <!--<div class="fm-opt">
                  <label for="listakun_folder"> :</label>
                  <input type="checkbox" id="CTBfolder" name="listakun_folder"/> Folder akun lain
                </div>-->
                <div class="fm-opt">
                  <label>Anak dari :</label>
                  <select name="listakun_parent"></select>
                </div>
                </fieldset>
                <p class="infonya"></p>
        </form>
    </div>
        <div id="dialog-tahunbuku">
          <form id="form_tahunbuku" method="post">
            <fieldset>
                <div class="fm-req">
                  <label for="listakun_code">Nama tahun buku :</label>
                  <input class="inp" name="nama_tahun" type="text"/>
                </div>
                <div class="fm-req">
                  <label>Tanggal Mulai :</label>
                  <input class="inp tgl input-small date-picker" maxlength="12" name="tgl_mulai"  type="text" style="width:75px" />
                </div>
                <div class="fm-req">
                  <label>Tanggal Selesai :</label>
                  <input class="inp tgl input-small date-picker" maxlength="12" name="tgl_akhir"  type="text" style="width:75px" />
                </div>
                <div class="fm-opt">
                  <label>Active :</label>
                  <input id="active" type="checkbox" checked="checked" />
                </div>
                </fieldset>
                <p class="infonya"></p>
        </form>
    </div>

</body>
</html>
