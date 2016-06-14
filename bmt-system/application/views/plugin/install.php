<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : plugin/install.php
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
    <link rel="stylesheet" type="text/css" href="../assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css"/>
    
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
		});
	</script>
    <?php $this -> load -> view( 'header' );?>
    <link rel="stylesheet" href="assets/css/autocomplete.css" type="text/css" media="screen" />
    <script type="text/javascript" src="assets/js/plugin/install.js"></script>
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
							<li><a href="#">Setting Plugin</a></li>
						</ul>
					</div>
				</div>
				<div id="page" class="dashboard">
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="tabbable tabbable-custom boxless">
		                        <ul class="nav nav-tabs">
		                           <li class="active"><a href="#tab_1" data-toggle="tab">Daftar Plugin</a></li>
		                           <li><a href="#tab_2" data-toggle="tab">Menu Plugin Otoritas</a></li>
		                        </ul>
		                        <div class="tab-content">
		                           <div class="tab-pane active" id="tab_1">
		                           		<blockquote>
			                              <p style="font-size:14px"><br>Setting plugin adalah module custome tambahan buat aplikasi AKSIOMA <br>
			                              Aplikasi yang bisa di tambah di sini tergantung dari kebutuhan dari BMT atau pengembang aplikasi, bebas menambah atau mengubah.<br></p>
			                           	</blockquote>
		                              	<div class="row-fluid">
                                                <div id="table_plugin">
                                                    <?php
                                                    $plugin['option'][] = array("name","Name"); // value,title
                                                    $plugin['tombol'] = '<button id="uploadplugin" class="btn btn-success">Upload plugin <i class="icon-plus"></i></button>';
                                                    $plugin['tabel_head'][] = array("name","10%","Name");
                                                    $plugin['tabel_head'][] = array("","20%","Path File");
                                                    $plugin['tabel_head'][] = array("","25%","Description");
                                                    $plugin['tabel_head'][] = array("","5%","Manage");
                                                    $plugin['tabel_head'][] = array("plugin_id","5%","ID");
                                                    $this -> load -> view( 'filter_layout',$plugin );
                                                    $this -> load -> view( 'table_layout',$plugin );
                                                    $this -> load -> view( 'paging_layout',$plugin );
                                                    ?>
                                                </div>
                                            </div>
		                           </div>
		                           <div class="tab-pane " id="tab_2">
		                              <div class="widget box blue">
                                            <div class="widget-title">
                                               <h4><i class="icon-reorder"></i>Menu Plugins</h4>
                                            </div>
                                            <br>
                                            <div class="row-fluid">
                                                <div style="padding:3px" class="ui-widget-content ui-corner-all"><button id="addmenu" class="fg-button ui-state-default ui-corner-all"><img src="assets/images/addicon.png">Tambah Menu</button></div>
                                               <h3>Daftar Menu plugin :</h3>
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
<div id="dialog-hapus">
      <br /><h3><img src="assets/images/question.png">&nbsp;Anda yakin <span class="phps"></span> akan dihapus ?</h3>
</div>
<div id="dialog-upload">
      <fieldset>
        <div style="margin-left:100px;">
            <h3>Plugin Upload</h3>
            <p>file yang di upload harus bertipe .zip</p>
            <form enctype="multipart/form-data" method="post" action="plugin/install/uploadplugin" id="formUpload" name="formUpload" target="upload_target">
                <input type="file" id="userfile" name="userfile" size="40" />
            </form>
        </div>
        <p class="infonya"></p>
      </fieldset>
</div>
<div id="dialog-menu">
    <form id="form_menu" method="post">
        <fieldset>
            <div class="fm-req">
              <label>Nama :</label>
              <input class="inp" maxlength="50" name="nama"  type="text" />
            </div>
            <div class="fm-req">
              <label>Href :</label>
              <select class="inp" name="href"></select>
            </div>
            <div class="fm-opt">
              <label>Css :</label>
              <input class="inp" maxlength="50" name="css"  type="text"/>
            </div>
            <div class="fm-opt">
              <label>Sub :</label>
              <input class="inp" maxlength="50" name="sub"  type="text" />
            </div>
            <div class="fm-req">
              <label>Parent :</label>
              <select class="inp" name="parent"></select>
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
            <div class="fm-opt">
              <label>Active :</label>
              <input id="active" type="checkbox" checked="checked" />
            </div>
        </fieldset>
        <p class="infonya"></p>
    </form>
</div>
<div id="dialog-hapus-menu">
      <br /><h3><img src="assets/images/question.png">&nbsp;Anda yakin <span class="phps"></span> akan dihapus ?</h3>
</div>
</body>
</html>
