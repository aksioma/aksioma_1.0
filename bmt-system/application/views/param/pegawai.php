<?php
/*
 * Aplikasi AKSIOMA (Aplikasi Keuangan Mikro Masyarakat Ekonomi Syariah) ver. 1.0
 * Copyright (c) 2014
 *
 * file   : param/pegawai.php
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
    <script type="text/javascript" src="assets/js/param/pegawai.js"></script>
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
                                   <li class="active"><a href="#tabs-1" data-toggle="tab">Users</a></li>
                                   <li ><a href="#tabs-2" data-toggle="tab">Pegawai</a></li>
                                   <li><a href="#tabs-3" data-toggle="tab">Jabatan</a></li>
                                   <li><a href="#tabs-4" data-toggle="tab">Otoritas penarikan tunai</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tabs-1">
                                        <div class="widget box blue">
                                            <div class="widget-title">
                                               <h4><i class="icon-reorder"></i>Users</h4>
                                            </div>
                                            <div id="table_user">
                                                <?php
                                                $user['option'][] = array("nama_pegawai","Nama"); // value,title
                                                $user['option'][] = array("username","Username");
                                                $user['tombol'] = '<button id="adduser" class="fg-button ui-state-default ui-corner-all">Tambah User <i class="icon-plus"></i></button>';
                                                $user['tabel_head'][] = array("","3%","No"); // id,width,title
                                                $user['tabel_head'][] = array("nip","7%","NIP");
                                                $user['tabel_head'][] = array("nama_pegawai","25%","Nama");
                                                $user['tabel_head'][] = array("username","15%","Username");
                                                $user['tabel_head'][] = array("active","5%","Aktif");
                                                $user['tabel_head'][] = array("nama_group","15%","Group wewenang");
                                                $user['tabel_head'][] = array("last_login","15%","Login Terakhir");
                                                $user['tabel_head'][] = array("","10%","Manage");
                                                $user['tabel_head'][] = array("user_id","30px","ID");
                                                $this -> load -> view( 'filter_layout',$user );
                                                $this -> load -> view( 'table_layout',$user );
                                                $this -> load -> view( 'paging_layout',$user );
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-2">
                                        <div class="widget box blue">
                                            <div class="widget-title">
                                               <h4><i class="icon-reorder"></i>Pegawai</h4>
                                            </div>
                                            <div id="table_pegawai">
                                                <?php
                                                //$pegawai['jumrow'] = 2;
                                                $pegawai['option'][] = array("nama_pegawai","Nama Pegawai"); // value,title
                                                $pegawai['option'][] = array("nip","NIP");
                                                $pegawai['option'][] = array("nama_jabatan","Jabatan");
                                                $pegawai['option'][] = array("nama_panggilan","Panggilan");
                                                $pegawai['tombol'] = '<button id="addpeg" class="fg-button ui-state-default ui-corner-all"><img src="assets/images/addicon.png" />Tambah Pegawai</button>';
                                                $pegawai['tabel_head'][] = array("","5%","No","1","rowspan='1'"); // id,width,title
                                                $pegawai['tabel_head'][] = array("nip","8%","NIP","1","rowspan='1'");
                                                $pegawai['tabel_head'][] = array("nama_pegawai","10%","Nama","1","rowspan='1'");
                                                $pegawai['tabel_head'][] = array("nama_panggilan","7%","Panggilan","1","rowspan='1'");
                                                $pegawai['tabel_head'][] = array("tpt_lhr","5%","Tempat","1","");
                                                $pegawai['tabel_head'][] = array("tgl_lhr","5%","Tanggal","1","");
                                                $pegawai['tabel_head'][] = array("","20%","Alamat","1","rowspan='1'");
                                                $pegawai['tabel_head'][] = array("nama_jabatan","10%","Jabatan","1","rowspan='1'");
                                                $pegawai['tabel_head'][] = array("","7%","Manage","1","rowspan='1'");
                                                $pegawai['tabel_head'][] = array("pegawai_id","5%","ID","1","rowspan='1'");
                                                $this -> load -> view( 'filter_layout',$pegawai );
                                                $this -> load -> view( 'table_layout',$pegawai );
                                                $this -> load -> view( 'paging_layout',$pegawai );
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-3">
                                        <div class="widget box blue">
                                            <div class="widget-title">
                                               <h4><i class="icon-reorder"></i>Jabatan</h4>
                                            </div>
                                            <div id="table_jabatan">
                                                <?php
                                                $jabatan['option'][] = array("nama_jabatan","Nama jabatan");
                                                $jabatan['tombol'] = '<button id="addjabatan" class="fg-button ui-state-default ui-corner-all"><img src="assets/images/addicon.png" />Tambah Jabatan</button>';
                                                $jabatan['tabel_head'][] = array("","5%","No"); // id,width,title
                                                $jabatan['tabel_head'][] = array("nama_jabatan","20%","Nama jabatan");
                                                $jabatan['tabel_head'][] = array("","15%","Keterangan");
                                                $jabatan['tabel_head'][] = array("","5%","Manage");
                                                $jabatan['tabel_head'][] = array("jabatan_id","5%","ID");
                                                $this -> load -> view( 'filter_layout',$jabatan );
                                                $this -> load -> view( 'table_layout',$jabatan );
                                                $this -> load -> view( 'paging_layout',$jabatan );
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabs-4">
                                       <div class="widget box blue">
                                            <div class="widget-title">
                                               <h4><i class="icon-reorder"></i>Otoritas penarikan tunai</h4>
                                            </div>
                                            <br>
                                            <div id="table_otoritas">
                                                <?php
                                                $otoritas['option'][] = array("kode","Kode"); // value,title
                                                $otoritas['tombol'] = '<button id="addotoritas" class="fg-button ui-state-default ui-corner-all"><img src="assets/images/addicon.png" />Tambah Otoritas</button>';
                                                $otoritas['tabel_head'][] = array("","3%","No"); // id,width,title
                                                $otoritas['tabel_head'][] = array("","10%","Dana maximal");
                                                $otoritas['tabel_head'][] = array("nama","25%","otoritas Level");
                                                $otoritas['tabel_head'][] = array("","10%","Manage");
                                                $otoritas['tabel_head'][] = array("otoritas_id","5%","ID");
                                                $this -> load -> view( 'filter_layout',$otoritas );
                                                $this -> load -> view( 'table_layout',$otoritas );
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
<div id="dialog-pegawai">
      <form id="form_pegawai" method="post">
        <fieldset>
            <div class="fm-req">
              <label>NIP :</label>
              <input class="inp" maxlength="20" name="nip"  type="text" />
            </div>
            <div class="fm-req">
              <label>Jabatan :</label>
              <select name="id_jabatan"></select>
            </div>
            <div class="fm-req">
              <label>Nama :</label>
              <input class="inp" maxlength="50" name="nama_pegawai"  type="text" />
            </div>
            <div class="fm-req">
              <label>Nama Panggilan :</label>
              <input class="inp" maxlength="10" name="nama_panggilan"  type="text" />
            </div>
            <div class="fm-req">
              <label>Tempat Lahir :</label>
              <input class="inp" maxlength="50" name="tpt_lhr"  type="text" />
            </div>
            <div class="fm-req">
              <label>Tanggal Lahir :</label>
              <input class="inp tgl" maxlength="10" name="tgl_lhr"  type="text" style="width:70px" />
            </div>
            <div class="fm-req">
              <label>Jenis Kelamin :</label>
              <select name="jns_klmn">
                <option value="1">Pria</option>
                <option value="2">Wanita</option>
              </select>
            </div>
            <div class="fm-req">
              <label>Agama :</label>
              <select name="agama">
                <option value="1">Islam</option>
                <option value="2">Keristen</option>
                <option value="3">Budha</option>
                <option value="4">Hindu</option>
                <option value="5">Lainnya</option>
              </select>
            </div>
            <div class="fm-req">
              <label>Status :</label>
              <select name="status">
                <option value="1">Belum Menikah</option>
                <option value="2">Menikah</option>
                <option value="3">Duda</option>
                <option value="4">Janda</option>
              </select>
            </div>
            <div class="fm-req">
              <label>Alamat :</label>
              <textarea class="inp" name="alamat"></textarea>
            </div>
            <div class="fm-req">
              <label>Kota :</label>
              <input class="inp" maxlength="50" name="kota"  type="text" />
            </div>
            <div class="fm-opt">
              <label>Telp :</label>
              <input class="inp" maxlength="20" name="telepon"  type="text" />
            </div>
            <div class="fm-opt">
              <label>Pendidikan :</label>
              <input class="inp" maxlength="20" name="pendidikan"  type="text" />
            </div>
            <div class="fm-req">
              <label>No KTP :</label>
              <input class="inp" maxlength="20" name="noktp"  type="text" />
            </div>
            <div class="fm-opt">
		      <label>Keterangan :</label>
              <textarea class="inp" name="keterangan"></textarea>
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
<div id="dialog-hapus-pegawai">
      <br /><h3><img src="assets/images/question.png">&nbsp;Anda yakin <span class="phps"></span> akan dihapus ?</h3>
</div>
<div id="dialog-hapus-otoritas">
      <br /><h3><img src="assets/images/question.png">&nbsp;Anda yakin <span class="phps"></span> akan dihapus ?</h3>
</div>
<div id="dialog-jabatan">
      <form id="form_jabatan" method="post">
        <fieldset>
            <div class="fm-req">
              <label>Nama jabatan :</label>
              <input class="inp" maxlength="255" name="nama_jabatan"  type="text" />
            </div>
            <div class="fm-opt">
		      <label>Keterangan :</label>
              <textarea class="inp" name="keterangan"></textarea>
		    </div>
        </fieldset>
        <p class="infonya"></p>
    </form>
</div>
<div id="dialog-hapus">
      <br /><h3><img src="assets/images/question.png">&nbsp;Anda yakin <span class="phps"></span> akan dihapus ?</h3>
      <p class="infonya"></p>
</div>
<div id="dialog-upload">
      <fieldset>
        <img id="foto_upload" style="width:100px;border:1px solid;float:left;margin-left:-10px;" src="assets/images/fotopegawai/default.jpg"/>
        <div style="margin-left:100px;">
            <h3>Pegawai : <span class="napeg"></span></h3>
            <form enctype="multipart/form-data" method="post" action="param/pegawai/uploadfoto" id="formUpload" name="formUpload" target="upload_target">
                <input type="file" id="userfile" name="userfile" size="40" />
                <input type="hidden" name="nipfoto" />
            </form>
        </div>
        <p class="infonya"></p>
      </fieldset>
</div>
<div id="dialog-detail">
        <div style="float:right;position:relative;right:50px;top:10px"><img style="width:100px;border:1px solid;" id="foto_pegawai" src="" /></div>
        <fieldset>
            <div class="fm-opt">
              <label>NIP :</label>
              <div class="dtl"></div>
            </div>
            <div class="fm-opt">
              <label>Jabatan :</label>
              <div class="dtl"></div>
            </div>
            <div class="fm-opt">
              <label>Nama :</label>
              <div class="dtl"></div>
            </div>
            <div class="fm-opt">
              <label>Nama Panggilan :</label>
              <div class="dtl"></div>
            </div>
            <div class="fm-opt">
              <label>Tempat Lahir :</label>
              <div class="dtl"></div>
            </div>
            <div class="fm-opt">
              <label>Tanggal Lahir :</label>
              <div class="dtl"></div>
            </div>
            <div class="fm-opt">
              <label>Jenis Kelamin :</label>
              <div class="dtl"></div>
            </div>
            <div class="fm-opt">
              <label>Agama :</label>
              <div class="dtl"></div>
            </div>
            <div class="fm-opt">
              <label>Status :</label>
              <div class="dtl"></div>
            </div>
            <div class="fm-opt">
              <label>Alamat :</label>
              <div class="dtl"></div>
            </div>
            <div class="fm-opt">
              <label>Kota :</label>
              <div class="dtl"></div>
            </div>
            <div class="fm-opt">
              <label>Telp :</label>
              <div class="dtl"></div>
            </div>
            <div class="fm-opt">
              <label>Pendidikan :</label>
              <div class="dtl"></div>
            </div>
            <div class="fm-opt">
              <label>No KTP :</label>
              <div class="dtl"></div>
            </div>
            <div class="fm-opt">
		      <label>Keterangan :</label>
              <div class="dtl"></div>
		    </div>
     </fieldset>
</div>
<iframe name="ctkframe" id="ctkframe" style="width:0px;height:0px;border:0;display:none;" src="param/pegawai/cetakDetail"></iframe>
</body>
</html>
