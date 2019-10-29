<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/user.php
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
	<title>AKSIOMA</title>
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
    <script type="text/javascript" src="assets/js/param/user.js"></script>
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
                                   <li class="active"><a href="#tabs-1" data-toggle="tab">Groups wewenang</a></li>
                                   <li><a href="#tabs-2" data-toggle="tab">Menu otoritas</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tabs-1">
                                        <div class="widget box blue">
                                            <div class="widget-title">
                                               <h4><i class="icon-reorder"></i>Groups wewenang</h4>
                                            </div>
                                            <div id="table_group">
                                                <?php
                                                $group['option'][] = array("nama_group","Nama Group"); // value,title
                                                $group['tombol'] = '<button id="addgroup" class="btn btn-success">Tambah Group <i class="icon-plus"></i></button>';
                                                $group['tabel_head'][] = array("","3%","No"); // id,width,title
                                                $group['tabel_head'][] = array("nama_group","25%","Nama Group");
                                                $group['tabel_head'][] = array("","25%","Controller");
                                                $group['tabel_head'][] = array("","10%","Manage");
                                                $group['tabel_head'][] = array("group_id","5%","ID");
                                                $this -> load -> view( 'filter_layout',$group );
                                                $this -> load -> view( 'table_layout',$group );
                                                $this -> load -> view( 'paging_layout',$group );
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane " id="tabs-2">
                                        <div class="widget box blue">
                                            <div class="widget-title">
                                               <h4><i class="icon-reorder"></i>Menu otoritas</h4>
                                            </div>
                                            <br>
                                            <div class="row-fluid">
                                                <h3>Daftar Menu :</h3>
                                               <div id="imenu"></div>
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
<div id="dialog-user">
      <form id="form_user" method="post">
        <fieldset>
		    <div class="fm-req">
		      <label for="username">Username :</label>
		      <input class="inp" name="username"  type="text" maxlength="20"/>
		    </div>
		    <div class="fm-req">
		      <label for="password">Password :</label>
		      <input class="inp" name="password" type="password" maxlength="20"/>
		    </div>
		    <div class="fm-req">
		      <label for="password2">Ulangi Password :</label>
		      <input class="inp" type="password" maxlength="20"/>
		    </div>
		    <div class="fm-req">
		      <label for="nip">NIP :</label>
		      <input class="inp" type="text" maxlength="20"/>
		    </div>
		    <div class="fm-req">
		      <label for="nama">Nama Pegawai :</label>
		      <input class="inp" type="text" maxlength="50" />
		    </div>
		    <div class="fm-req">
		      <label for="group">Group :</label>
		      <select name="id_group" class="input-small">
			  </select>
		    </div>
		    <div class="fm-opt">
		      <label for="active">Aktif :</label>
		      <input type="checkbox" id="CTBaktif" name="active"/>
		    </div>
            <input type="hidden" name="id_pegawai" maxlength="20"/>
		  </fieldset>
		    <p class="infonya"></p>
    </form>
</div>
<div id="dialog-menu">
    <form id="form_menu" method="post">
        <fieldset>
            <div class="fm-req">
              <label>Nama :</label>
              <input class="inp" maxlength="50" name="nama"  readonly type="text" />
            </div>
            <div class="fm-req">
              <label>Urutan :</label>
              <input class="inp" maxlength="4" name="urutan"  type="text" />
            </div>
            <div class="fm-req">
		      <label>Groups :</label>
		      <select class="inp" size="8" multiple="multiple" name="groups[]" style="width:150px">
			  </select>
		    </div>
        </fieldset>
        <p class="infonya"></p>
    </form>
</div>
<div id="dialog-hapus-user">
      <br /><h3><img src="assets/images/question.png">&nbsp;Anda yakin <span class="phps"></span> akan dihapus ?</h3>
</div>
<div id="dialog-group">
      <form id="form_group" method="post">
        <fieldset>
            <div class="fm-req">
              <label>Nama Group :</label>
              <input class="inp" maxlength="20" name="nama_group"  type="text" />
            </div>
            <div class="fm-req">
              <label>Controller :</label>
              <select size="15" class="slct" multiple="multiple" name="controller[]">
                 <optgroup label="Transaksi">
                 <?php foreach($layanancontr as $key => $item):?>
                    <option value="<?php echo $key;?>"><?php echo $item;?></option>
                 <?php endforeach;?>
                 </optgroup>
                 <optgroup label="Parameter">
                 <?php foreach($paramcontr as $key => $item):?>
                    <option value="<?php echo $key;?>"><?php echo $item;?></option>
                 <?php endforeach;?>
                 </optgroup>
                 <optgroup label="Base">
                 <?php foreach($basecontr as $key => $item):?>
                    <option value="<?php echo $key;?>"><?php echo $item;?></option>
                 <?php endforeach;?>
                 </optgroup>
                 <optgroup label="Akunting">
                 <?php foreach($accountingcontr as $key => $item):?>
                    <option value="<?php echo $key;?>"><?php echo $item;?></option>
                 <?php endforeach;?>
                 </optgroup>
                 <optgroup label="Transaksi">
                 <?php foreach($transaksicontr as $key => $item):?>
                    <option value="<?php echo $key;?>"><?php echo $item;?></option>
                 <?php endforeach;?>
                 </optgroup>
                 <optgroup label="Monitor">
                 <?php foreach($monitorcontr as $key => $item):?>
                    <option value="<?php echo $key;?>"><?php echo $item;?></option>
                 <?php endforeach;?>
                 </optgroup>
                 <optgroup label="Tool">
                 <?php foreach($toolcontr as $key => $item):?>
                    <option value="<?php echo $key;?>"><?php echo $item;?></option>
                 <?php endforeach;?>
                 </optgroup>
                 <optgroup label="Setting">
                 <?php foreach($setting as $key => $item):?>
                    <option value="<?php echo $key;?>"><?php echo $item;?></option>
                 <?php endforeach;?>
                 </optgroup>
              </select>
            </div>
        </fieldset>
        <p class="infonya"></p>
    </form>
</div>
<div id="dialog-otoritas">
      <form id="form_otoritas" method="post">
        <fieldset>
		    <div class="fm-req">
		      <label for="kode">Dana Maksimal :</label>
		      <input class="inp" name="kode"  type="text" maxlength="20"/>
		    </div>
		    <div class="fm-req">
		      <label for="level">Level Otoritas :</label>
		      <select name="level" class="input-medium">
			  </select>
		    </div>
		    </fieldset>
		    <p class="infonya"></p>
    </form>
</div>
<div id="dialog-hapus-otoritas">
      <br /><h3><img src="assets/images/question.png">&nbsp;Anda yakin <span class="phps"></span> akan dihapus ?</h3>
</div>
<div id="dialog-hapus-group">
      <br /><h3><img src="assets/images/question.png">&nbsp;Anda yakin <span class="phps"></span> akan dihapus ?</h3>
      <p class="infonya"></p>
</div>
</body>
</html>
