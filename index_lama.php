<?php
error_reporting(0);
session_start();
if(isset($_SESSION['id_user'])){
include "config/koneksi.php";
include "config/helper.php";
date_default_timezone_set('Asia/Jakarta');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="puskesmas online, e-puskesmas, epuskesmas, aplikasi puskesmas, simpus, sip, sikda, puskesmas, kesehatan"/>
		<meta name="description" content="Puskesmas Online merupakan sebuah Aplikasi Manajemen Puskesmas, 
		aplikasi ini dikembangkan di kota Bandung sejak tahun 2011, fungsi dari Puskesmas Online salahsatunya sebagai media
		pengolahan data informasi yang ada di Puskesmas. Harapan kedepan dengan adanya aplikasi Puskesmas Online dapat membantu 
		memaksimalkan pelayanan kepada masyarakat dan mempermudah pekerjaan petugas yang ada di Puskesmas seluruh Indonesia">
		<meta name="author" content="Tommy Natalianto">
		<meta name="language"content="id"/>
		<link rel="icon" href="image/pkmonlineicon.png" type="image/png" sizes="16x16">
		<title>pkmonline</title>
		
		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css?3"/>
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
		<link href="assets/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
		<link href="assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
		
		<!-- Vendor CSS-->
		<link href="assets/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
		<link href="assets/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
		<link href="assets/vendor/wow/animate.css" rel="stylesheet" media="all">
		<link href="assets/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
		<link href="assets/vendor/slick/slick.css" rel="stylesheet" media="all">
		<link href="assets/vendor/select2/select2.min.css" rel="stylesheet" media="all">
		<link href="assets/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<!-- ace styles--> 
		<link rel="stylesheet" href="assets/css/ace.min.css?=2" class="ace-main-stylesheet" id="main-ace-style" />
		<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
				
		<!-- css datatable -->
		<link rel="stylesheet" href="assets/js/datatables/media/css/jquery.dataTables_themeroller.css" />

		<!-- ace settings handler -->
		<script src="assets/js/ace-extra.min.js"></script>

		<!--DATE PICKER GINTING-->
		<link href="assets/bootstrapdatepicker/css/bootstrap-datepicker.min.css" rel="stylesheet"><!--ini css bootstrapdatepicker-->
		<link rel="stylesheet" type="text/css" href="assets/js/jquery-todo/css/styles.css" />
		
		<!--!font-->
		<link href="https://fonts.googleapis.com/css?family=Poppins|Ubuntu|Roboto+Condensed" rel="stylesheet">
		
		<!--style custom pkmonline-->
		<link rel="stylesheet" type="text/css" href="assets/css/f_laporan.css?=6">
		<link rel="stylesheet" type="text/css" href="assets/css/laporan_print.css?=1">
		<link rel="stylesheet" type="text/css" href="assets/css/f_laporan_dinkes.css">
		<link rel="stylesheet" type="text/css" href="assets/css/f_panel_dashboard.css?=3">
		<link rel="stylesheet" type="text/css" href="assets/css/f_kotak_grafik.css?=1">
		<link rel="stylesheet" href="assets/css/bootstrap4-chosen.css" />
		
		<style>
		body{
			font-family: "Poppins", sans-serif;
		}
		.judul{
			margin-bottom:17px;
			border-bottom:1px solid #c9c9c9;
			padding-bottom:12px;
			font-family: "Poppins", sans-serif;
			font-weight: bold;
			margin-top: 0px;
		}
		.backform{
			float:right;
			font-size: 16px;
			padding-top: 0px;
			cursor: pointer;
			text-decoration: hide;
			color: #898686;	
			text-decoration:none
			outline:none;
			-moz-outline-style:none;
		}	
		.font_tabel{
			font-size:14px;
			font-family: "Poppins", sans-serif;
		}
		.table-responsive {
			min-height: .01%;
			overflow-x: auto;
		}
		.table{ 
			table-layout: fixed;
			width: 100%; 
		}			
		.table-judul-laporan{
			width:100%;
		}
		.table-judul{
			width:100%;
			border-collapse: collapse;
			border-radius: 5px;
			overflow: auto;
		}
	
		.table-judul>thead>tr>th {
			padding-top:15px;
			padding-bottom:15px;
			background:#424242;
			color:#fff;
			border-color:#000;
			font-size: 12px;
			font-family: "Poppins", sans-serif;
			text-align: center;
		}
		.table-judul>tbody>tr:nth-child(odd) {
		  background: #f5f5f5;
		}

		.table-judul>tbody>tr:nth-child(even) {
		  background: #fff;
		}
		
		.table-judul>tbody>tr>td {
			background:transparent;
			padding:5px;
			font-family: "Poppins", sans-serif;
			font-size: 14px;
			font-weight: normal;
		}
		
		.table-judul-laporan>thead>tr>th {
			padding-top:15px;
			padding-bottom:15px;
			background:#939393;
			color:#fff;
			text-align:center;
			vertical-align:middle;
			border:1px solid #000;
			font-size: 12px;
			font-family: "Roboto Condensed", Arial, sans-serif;
		}
		.table-judul-laporan-min>thead>tr>th {
			padding-top:10px;
			padding-bottom:10px;
			background:#939393;
			color:#fff;
			text-align:center;
			vertical-align:middle;
			border:1px solid #000;
			font-size: 12px;
			font-family: "Roboto Condensed", Arial, sans-serif;
		}
		.table-judul-laporan-dark>thead>tr>th {
			padding-top:15px;
			padding-bottom:15px;
			background:#000;
			color:#fff;
			text-align:center;
			vertical-align:middle;
			border:1px solid #000;
			font-size: 12px;
			font-family: "Roboto Condensed", Arial, sans-serif;
		}
		.table-judul-form>thead>tr>th{
			padding:15px 10px 0px 0px;
			padding-bottom:15px;
			background:#545454;
			color:#fff;
			text-align:center;
			vertical-align:middle;
			border:1px solid #000;
			font-size: 12px;
			font-family: "Roboto Condensed", Arial, sans-serif;
		}	
		.table-judul-form>tbody>tr>td {
			padding:5px;			
			border: 1px solid;  
			border-color:#000;
			font-family: "Roboto Condensed", Arial, sans-serif;
		}
		.table-judul-laporan>tbody>tr>td {
			background:#fff;
			padding:5px;			
			border: 1px solid;  
			border-color:#000;
			font-family: "Roboto Condensed", Arial, sans-serif;
		}
		.table-judul-laporan-min>tbody>tr>td {
			background:#fff;
			padding:2px;			
			border: 1px solid;  
			border-color:#000;
			font-family: "Roboto Condensed", Arial, sans-serif;
		}
		.table-judul-laporan-dark>tbody>tr>td {
			background:#fff;
			padding:5px;			
			border: 1px solid;  
			border-color:#E6E6E6;
			font-family: "Roboto Condensed", Arial, sans-serif;
		}
		.table>tbody>tr>td{
			border:none;
		}
		.tableborderdiv{
			background: #E6E6E6;
			padding: 15px 20px;
		}
		.no-skin .nav-list>li>a{
			border-color: #fff;
			background-color: #fff;
		}
		.page-content{
			background-color: #E6E6E6;
		}
		.formbg{
			background: #fff;
			padding: 30px 30px 30px 30px;
			box-shadow: 0px 0px 9px #8c8c8c;
			border-radius: 10px;
			margin: 1px;
			margin-bottom: 20px;
			font-size: 13px;
			font-family: "Poppins", sans-serif;
		}
		.footer{
			font-size: 12px;
			font-weight: bold;
			background-color: #E6E6E6;
			padding-top: 30px;
		}
		.sidebar~.footer .footer-inner{
			background-color: #E6E6E6;
			padding-bottom: 30px;
		}
		.main-content-inner{
			background-color: #E6E6E6;
			padding-bottom: 30px;
			
		}
		.main-container:before {
			background-color:#E6E6E6;
		}
		.btn{
			border-radius:3px;
		}
		.btnsimpan{
			display: block;
			width: 100%;
			background-color: #08c999;
			border: none;
			color: #fff;
			padding: 12px 30px;
			cursor: pointer;
			font-size: 18px;
			font-family: "Poppins", sans-serif;
			border-radius: 5px;
			transition: all 0.2s;
			text-align: center;
		}
		.btnsimpan:hover{
			color:#fff;
			background-color:#3ceabc;
		}
		.btninfo{
			display: block;
			width: 100%;
			background-color: #3fafcc;
			border: none;
			color: #fff;
			padding: 12px 30px;
			cursor: pointer;
			font-size: 18px;
			border-radius: 5px;
			transition: all 0.2s;
			text-align: center;
		}
		.btninfo:hover{
			color:#fff;
			background-color:#69d0ea;
		}
		.btndanger{
			display: block;
			width: 100%;
			background-color: #d34545;
			border: none;
			color: #fff;
			padding: 12px 30px;
			cursor: pointer;
			font-size: 18px;
			border-radius: 5px;
			transition: all 0.2s;
			text-align: center;
		}
		.btndanger:hover{
			color:#fff;
			background-color:#f26f6f;
		}
		.navbar{
			background: rgb(55,124,55);
			background: linear-gradient(90deg, rgba(55,124,55,1) 0%, rgba(70,163,70,1) 50%, rgba(0,201,0,1) 100%);
		}
		.navbar-header{
			margin-top: 5px;		
		}	
		.ace-nav>li.light-blue>a {
			background-color: #46a046;
		}
		.ace-nav>li.open.light-blue>a{
			background-color: #46a046;
		}
		.tab-content {
			background-color:#fff;
		}
		.ace-nav>li>a {
			margin-top: -5px;	
			border-radius: 5px;		
			height: 60px;
		}			
		.ace-nav .nav-user-photo {
			margin-top: 0px;
			height: 60px;	
		}
		.user-info {
			top: 10px;
		}	
		.ace-nav .nav-user-photo {
			margin-top: 0px;
			width: 70px;
			height: 50px;
		}
		.classfixed{
			position: absolute;
			width: 240px;
			background-color:#ccffe6  ! important;
		}
				
		@media only screen and (max-width: 479px)
		.navbar:not(.navbar-collapse) .ace-nav>li {
			text-align: center;
		}	
		.navbar-headers {
			margin-bottom: 15px;
			border-radius: 20px;			
		}	
		.alertpopup{
			background:transparent;width:35%;height:10px;position:fixed;top:0;left:0;bottom:0;right:0;margin:auto;margin-top: 15%;
			z-index: 100;
		}
		.alertpopup p{
			background: #ffd3d3;border: 7px solid #fff;border-radius: 5px;box-shadow: 0px 0px 4px #545454;font-size: 18px;
			text-align: center;padding:60px;color: #000;
		}
		.alertpopup i{
			position: absolute;top:-15px;right: -15px;background: #fff;padding: 5px 6px;border: 2px solid #ddd;border-radius: 50%;
		}
		.alertpopup i:hover{
			cursor: pointer;
		}	
		</style>
		
		<!--FONTS-->
		<link href="assets/css/jquery.autocomplete.css?4" rel="stylesheet">
		<script src="assets/js/qrcode.min.js"></script>
		<script src="assets/js/JsBarcode.all.js"></script>
		<script>
			Number.prototype.zeroPadding = function(){
				var ret = "" + this.valueOf();
				return ret.length == 1 ? "0" + ret : ret;
			};
		</script>  
		<!-- page specific plugin styles tooltips-->
		<link rel="stylesheet" href="assets/css/jquery-ui.min.css" />
	</head>
	<?php
		if($_GET['alerts'] != null){
			echo "<div class='alertpopup'><p>".$_GET['alerts']."</p><i class='fa fa-close'></i></div>";
		}
	?>
	<body class="no-skin">
		<div id="navbar" class="navbar navbar-default ace-save-state">
			<div class="navbar-container ace-save-state" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>
					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left">
					<a href="index.html" class="navbar-brand"><img class="nav-user-photo" src="image/logo_pkmonline_wht.png" width="180" style="margin: -4px 0px -10px -10px;"/></a>
				</div>
				
				<div class="navbar-buttons navbar-headers pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="light-blue dropdown-modal">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle" style="width: 200px; height: 50px; margin: 5px 5px;">
								<?php
									$gambar = $_SESSION['foto_petugas'];
									//if($_SESSION['foto_petugas'] == null){
									if(!file_exists("image/pegawai/".$gambar)){
								?>		
									<img class="nav-user-photo" src="assets/images/avatars/avatar6.png"/>
								<?php }else{ ?>
									<img class="nav-user-photo" src="image/pegawai/<?php echo $_SESSION['foto_petugas'];?>" alt="Photo" />
								<?php } ?>
								<span class="user-info">
									<small>Welcome,</small>
									<?php echo $_SESSION['nama_petugas'];?>
								</span>
								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li class="divider"></li>
								<li><a href="?page=update_profile_puskesmas"><i class="fa fa-home"></i> Data Puskesmas</a></li>
								<li><a href="?page=update_profile"><i class="fa fa-user"></i> Data User</a></li>
								<li><a href="logout.php"><i class="fa fa-power-off"></i> Log Out</a></li>
							</ul>
						</li>
					</ul>
				</div>
				
				<div class="navbar-buttons navbar-headers pull-right" role="navigation" style="margin-right: 5px;">
					<ul class="nav ace-nav">
						<li>
							<a style="width: 230px; height: 50px; margin-top:5px;">
							<?php
								//jumlah pegawai login
								$jumlahpegawai = mysqli_num_rows(mysqli_query($koneksi, "SELECT `IdPegawai` FROM `tbpegawai`"));
								$jumlahpegawailogin = mysqli_num_rows(mysqli_query($koneksi, "SELECT IdPegawai FROM tbpegawai where StatusLogin = '1'"));
								$jmlpgwpersen = ($jumlahpegawailogin * 100)/$jumlahpegawai;
								$ketOnlineUser = "Jumlah Online User : ".$jumlahpegawailogin." user dari ".$jumlahpegawai." total user (".round($jmlpgwpersen,2)."%)";
							?>		
								<p style="line-height:15px; padding-top: 10px; margin: 5px;">
								<?php 
									echo "Jumlah online : ".$jumlahpegawailogin." User <br/>".
									"Dari ".rupiah($jumlahpegawai)." user, pers (".round($jmlpgwpersen,2)."%)";
								?>								
								</p>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>
			<div id="sidebar" class="sidebar responsive ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>
				<ul class="nav nav-list">
					<?php
						if($_SESSION['kodepuskesmas'] == '-'){
							include "menu_dinas.php";
						}else if($_SESSION['namapuskesmas'] == 'UPTD FARMASI'){
							include "menu_uptd_farmasi.php";
						}else if($_SESSION['namapuskesmas'] == 'SARPRAS'){
							include "menu_sarpras.php";	
						}else{
							include "menu_puskesmas.php";
						}
					?>
				</ul>
				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>
			<div class="main-content">
				<div class="main-content-inner">
					<div class="breadcrumbs ace-save-state noprint" id="breadcrumbs">
						<ul class="breadcrumb">
							<li class="active">
							<?php
								echo $_SESSION['kodepuskesmas'].", ".$_SESSION['namapuskesmas'].", ".$_SESSION['kota'];
							?>
							</li>
						</ul>
					</div>
					<div class="page-content">
						<div class="row">
							<div class="col-xs-12">
								<div class="row">
									<?php
										$page=$_GET['page'];
										$nama_file=$page.".php";
										$cek=strlen($page);
										
										if($cek>70 || empty($page)){
											include ("dashboard.php");
										}else if(!file_exists($nama_file)){
											include ("error.php");
										}else{
											include ($nama_file);
										}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="footer noprint">
				<div class="footer-inner">
					<span><?php echo date('Y')." | DINAS KESEHATAN ".$_SESSION['kota'];?></span>
				</div>
			</div>
			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div>
		
		<!--[if !IE]> tooltips-->
		<script src="assets/js/jquery-2.1.4.min.js"></script>
		<!-- datatable -->
		<script src="assets/js/datatables/media/js/jquery.dataTables.min.js"></script>
		<script  type="text/javascript">
			$(document).ready(function() {
					$('#datatabless').DataTable();
				});
		</script>
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/jquery-ui.custom.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="assets/js/jquery.easypiechart.min.js"></script>
		<script src="assets/js/jquery.sparkline.index.min.js"></script>
		<script src="assets/js/jquery.flot.min.js"></script>
		<script src="assets/js/jquery.flot.pie.min.js"></script>
		<script src="assets/js/jquery.flot.resize.min.js"></script>
		<!--TOOLTIPS ANIMASI-->
		<script src="assets/js/jquery-ui.min.js"></script>
		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>
		<!--DATE PICKER GINTING-->
		<script src="assets/bootstrapdatepicker/js/bootstrap-datepicker.min.js"></script>
		<script type="text/javascript" src="assets/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.min.js"></script>
		<script type="text/javascript" src="assets/js/jQuery-slimScroll-1.3.0/slimScrollHorizontal.min.js"></script>
		<!--COOKIE???-->
		<script type="text/javascript" src="assets/js/jQuery-Cookie/jquery.cookie.min.js"></script>
		<!--CUSTOM SCRIPT -->
		<script src="assets/js/jquery.autocomplete.js?1"></script>
		<script src="assets/js/chosen.js"></script>
		<script src="assets/js/source.js?88"></script>
		
		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			$(".alertpopup i").click(function(){
				$(this).parent().hide();
			});	
			
			$('.chosenselect').chosen();
			$('.chosen-container').css({width: "100%"});
		
			<!--2. pneumonia-->
			$('.klasifikasi_mtbs_pneu').change(function(){
				var ini = $(this).val();
				if(ini == 'Pneumonia Berat'){
				$('.tindpneumonia').prop('checked',false);
					$('.tind_pneu_mtbs_1').prop('checked',true);
					$('.tind_pneu_mtbs_2').prop('checked',true);
				}else if(ini == 'Pneumonia'){
				$('.tindpneumonia').prop('checked',false);
					$('.tind_pneu_mtbs_1').prop('checked',true);
					$('.tind_pneu_mtbs_3').prop('checked',true);
					$('.tind_pneu_mtbs_4').prop('checked',true);
					$('.tind_pneu_mtbs_5').prop('checked',true);
					$('.tind_pneu_mtbs_6').prop('checked',true);
				}else if(ini == 'Batuk Bukan Pneumonia'){
				$('.tindpneumonia').prop('checked',false);
					$('.tind_pneu_mtbs_3').prop('checked',true);
					$('.tind_pneu_mtbs_4').prop('checked',true);
					$('.tind_pneu_mtbs_5').prop('checked',true);
					$('.tind_pneu_mtbs_7').prop('checked',true);
				}
				$.post( "get_diagnosa_mtbs.php", { nama: ini })
					.done(function( data ) {
					if(data != ''){
						$('.pernafasan').remove();
						$('.master-table-bpjs').before(data);
						addkelompok();
						add_new_form();
						//untuk hapus diagnosa
						$(".hapus-diagnosa-mtbs").click(function(){
							$(this).parent().parent().remove();
							$(".tindpneumonia").prop('checked',false);
							$('.form_tambahan').html("");
							$('.klasifikasi_mtbs_pneu').val('-');
						});
						
					}
				});	
			});
			<!--3. diare-->
			$('.klasifikasi_mtbs_diare').change(function(){
				var ini = $(this).val();
				if(ini == 'Dehidrasi Berat'){
				$('.tinddiare').prop('checked',false);
					$('.tind_diare_mtbs_1').prop('checked',true);
					$('.tind_diare_mtbs_2').prop('checked',true);
					$('.tind_diare_mtbs_3').prop('checked',true);
					$('.tind_diare_mtbs_4').prop('checked',true);
				}else if(ini == 'Dehidrasi Sedang atau Ringan'){
				$('.tinddiare').prop('checked',false);
					$('.tind_diare_mtbs_2').prop('checked',true);
					$('.tind_diare_mtbs_3').prop('checked',true);
					$('.tind_diare_mtbs_5').prop('checked',true);
					$('.tind_diare_mtbs_6').prop('checked',true);
					$('.tind_diare_mtbs_7').prop('checked',true);
				}else if(ini == 'Diare Tanpa Dehidrasi'){
				$('.tinddiare').prop('checked',false);
					$('.tind_diare_mtbs_6').prop('checked',true);
					$('.tind_diare_mtbs_7').prop('checked',true);
					$('.tind_diare_mtbs_8').prop('checked',true);
				}else if(ini == 'Diare Persisten Berat'){
				$('.tinddiare').prop('checked',false);
					$('.tind_diare_mtbs_2').prop('checked',true);
					$('.tind_diare_mtbs_9').prop('checked',true);
				}else if(ini == 'Diare Persisten'){
				$('.tinddiare').prop('checked',false);
					$('.tind_diare_mtbs_7').prop('checked',true);
					$('.tind_diare_mtbs_10').prop('checked',true);
				}else if(ini == 'Disentri'){
				$('.tinddiare').prop('checked',false);
					$('.tind_diare_mtbs_6').prop('checked',true);
					$('.tind_diare_mtbs_11').prop('checked',true);
					$('.tind_diare_mtbs_12').prop('checked',true);
				}
				$.post( "get_diagnosa_mtbs.php", { nama: ini })
					.done(function( data ) {
					if(data != ''){
						$('.diare').remove();
						$('.master-table-bpjs').before(data);
						addkelompok();
						add_new_form();
						$(".hapus-diagnosa-mtbs").click(function(){
							$(this).parent().parent().remove();
							$(".tinddiare").prop('checked',false);
							$('.form_tambahan').html("");
							$('.klasifikasi_mtbs_diare').val('-');
						});
					}
				});	
			});
			<!--4. demam-->
			$('.klasifikasi_mtbs_demam').change(function(){
				var ini = $(this).val();
				if(ini == 'Penyakit Berat Dengan Demam'){
				$('.tinddemam').prop('checked',false);
					$('.tind_demam_mtbs_1').prop('checked',true);
					$('.tind_demam_mtbs_2').prop('checked',true);
					$('.tind_demam_mtbs_3').prop('checked',true);
					$('.tind_demam_mtbs_4').prop('checked',true);
					$('.tind_demam_mtbs_5').prop('checked',true);
				}else if(ini == 'Penyakit Malaria'){
				$('.tinddemam').prop('checked',false);
					$('.tind_demam_mtbs_3').prop('checked',true);
					$('.tind_demam_mtbs_6').prop('checked',true);
					$('.tind_demam_mtbs_7').prop('checked',true);
					$('.tind_demam_mtbs_8').prop('checked',true);
				}else if(ini == 'Demam Mungkin Bukan Malaria'){
				$('.tinddemam').prop('checked',false);
					$('.tind_demam_mtbs_3').prop('checked',true);
					$('.tind_demam_mtbs_7').prop('checked',true);
					$('.tind_demam_mtbs_9').prop('checked',true);
					$('.tind_demam_mtbs_10').prop('checked',true);
					$('.tind_demam_mtbs_11').prop('checked',true);
				}else if(ini == 'Demam Bukan Malaria'){
				$('.tinddemam').prop('checked',false);
					$('.tind_demam_mtbs_3').prop('checked',true);
					$('.tind_demam_mtbs_7').prop('checked',true);
					$('.tind_demam_mtbs_9').prop('checked',true);
					$('.tind_demam_mtbs_10').prop('checked',true);
					$('.tind_demam_mtbs_11').prop('checked',true);
				}
				
				$.post( "get_diagnosa_mtbs.php", { nama: ini })
					.done(function( data ) {
					if(data != ''){
						$('.demam').remove();
						$('.master-table-bpjs').before(data);
						addkelompok();
						add_new_form();
						
						$(".hapus-diagnosa-mtbs").click(function(){
							$(this).parent().parent().remove();
							$('.tinddemam').prop('checked',false);
							$('.form_tambahan').html("");
							$('.klasifikasi_mtbs_demam').val('-');
						});
					}
				});	
			});
			
			<!--5. campak-->
			$('.klasifikasi_mtbs_campak').change(function(){
				var ini = $(this).val();
				if(ini == 'Penyakit Campak Dengan Komplikasi Berat'){
				$('.tindcampak').prop('checked',false);
					$('.tind_campak_mtbs_1').prop('checked',true);
					$('.tind_campak_mtbs_2').prop('checked',true);
					$('.tind_campak_mtbs_3').prop('checked',true);
					$('.tind_campak_mtbs_4').prop('checked',true);
					$('.tind_campak_mtbs_5').prop('checked',true);
				}else if(ini == 'Penyakit Campak Komplikasi Pada Mata/Mulut'){
				$('.tindcampak').prop('checked',false);
					$('.tind_campak_mtbs_1').prop('checked',true);
					$('.tind_campak_mtbs_3').prop('checked',true);
					$('.tind_campak_mtbs_6').prop('checked',true);
				}else if(ini == 'Penyakit Campak'){
				$('.tindcampak').prop('checked',false);
					$('.tind_campak_mtbs_1').prop('checked',true);
				}else if(ini == 'Tidak Ada'){
				$('.tindcampak').prop('checked',false);
				}
				$.post( "get_diagnosa_mtbs.php", { nama: ini })
					.done(function( data ) {
					if(data != ''){
						$('.campak').remove();
						$('.master-table-bpjs').before(data);
						addkelompok();
						add_new_form();
						$(".hapus-diagnosa-mtbs").click(function(){
							$(this).parent().parent().remove();
							$('.tindcampak').prop('checked',false);
							$('.form_tambahan').html("");
							$('.klasifikasi_mtbs_campak').val('-');
						});
					}
				});	
			});
			
			<!--6. dbd-->
			$('.klasifikasi_mtbs_dbd').change(function(){
				var ini = $(this).val();
				if(ini == 'Penyakit Demam Berdarah Dengue (DBD)'){
				$('.tinddbd').prop('checked',false);
					$('.tind_dbd_mtbs_1').prop('checked',true);
					$('.tind_dbd_mtbs_2').prop('checked',true);
					$('.tind_dbd_mtbs_3').prop('checked',true);
					$('.tind_dbd_mtbs_4').prop('checked',true);
					$('.tind_dbd_mtbs_5').prop('checked',true);
				}else if(ini == 'Penyakit Demam Mungkin DBD'){
				$('.tinddbd').prop('checked',false);
					$('.tind_dbd_mtbs_4').prop('checked',true);
					$('.tind_dbd_mtbs_6').prop('checked',true);
					$('.tind_dbd_mtbs_7').prop('checked',true);
					$('.tind_dbd_mtbs_8').prop('checked',true);
					$('.tind_dbd_mtbs_10').prop('checked',true);
				}else if(ini == 'Penyakit Demam Mungkin Bukan DBD'){
				$('.tinddbd').prop('checked',false);
					$('.tind_dbd_mtbs_4').prop('checked',true);
					$('.tind_dbd_mtbs_7').prop('checked',true);
					$('.tind_dbd_mtbs_9').prop('checked',true);
					$('.tind_dbd_mtbs_10').prop('checked',true);
				}
				$.post( "get_diagnosa_mtbs.php", { nama: ini })
					.done(function( data ) {
					if(data != ''){
						$('.dbd').remove();
						$('.master-table-bpjs').before(data);
						addkelompok();
						add_new_form();
						$(".hapus-diagnosa-mtbs").click(function(){
							$(this).parent().parent().remove();
							$('.tinddbd').prop('checked',false);
							$('.form_tambahan').html("");
							$('.klasifikasi_mtbs_dbd').val('-');
						});
					}
				});	
			});
			
			<!--7. telinga-->
			$('.klasifikasi_mtbs_telinga').change(function(){
				var ini = $(this).val();
				if(ini == 'Mastoiditis'){
				$('.tindtelinga').prop('checked',false);
					$('.tind_telinga_mtbs_1').prop('checked',true);
					$('.tind_telinga_mtbs_2').prop('checked',true);
					$('.tind_telinga_mtbs_3').prop('checked',true);
				}else if(ini == 'Infeksi Telinga Akut'){
				$('.tindtelinga').prop('checked',false);
					$('.tind_telinga_mtbs_1').prop('checked',true);
					$('.tind_telinga_mtbs_2').prop('checked',true);
					$('.tind_telinga_mtbs_5').prop('checked',true);
					$('.tind_telinga_mtbs_6').prop('checked',true);
				}else if(ini == 'Infeksi Telinga Kronis'){
				$('.tindtelinga').prop('checked',false);
					$('.tind_telinga_mtbs_5').prop('checked',true);
					$('.tind_telinga_mtbs_7').prop('checked',true);
					$('.tind_telinga_mtbs_8').prop('checked',true);
				}else if(ini == 'Tidak Ada Infeksi Telinga'){
				$('.tindtelinga').prop('checked',false);
					$('.tind_telinga_mtbs_9').prop('checked',true);
				}
				$.post( "get_diagnosa_mtbs.php", { nama: ini })
					.done(function( data ) {
					if(data != ''){
						$('.telinga').remove();
						$('.master-table-bpjs').before(data);
						addkelompok();
						add_new_form();
						$(".hapus-diagnosa-mtbs").click(function(){
							$(this).parent().parent().remove();
							$('.tindtelinga').prop('checked',false);
							$('.form_tambahan').html("");
							$('.klasifikasi_mtbs_telinga').val('-');
						});
					}
				});	
			});
			<!--8. Gizi-->
			$('.klasifikasi_mtbs_gizi').change(function(){
				var ini = $(this).val();
				if(ini == 'Gizi Buruk Dengan Komplikasi'){
				$('.tindgizi').prop('checked',false);
					$('.tind_gizi_mtbs_1').prop('checked',true);
					$('.tind_gizi_mtbs_2').prop('checked',true);
					$('.tind_gizi_mtbs_3').prop('checked',true);
					$('.tind_gizi_mtbs_4').prop('checked',true);
					$('.tind_gizi_mtbs_5').prop('checked',true);
				}else if(ini == 'Gizi Buruk Tanpa Komplikasi'){
				$('.tindgizi').prop('checked',false);
					$('.tind_gizi_mtbs_6').prop('checked',true);
					$('.tind_gizi_mtbs_2').prop('checked',true);
					$('.tind_gizi_mtbs_3').prop('checked',true);
					$('.tind_gizi_mtbs_4').prop('checked',true);
					$('.tind_gizi_mtbs_7').prop('checked',true);
					$('.tind_gizi_mtbs_8').prop('checked',true);
					$('.tind_gizi_mtbs_9').prop('checked',true);
				}else if(ini == 'Gizi Kurang'){
				$('.tindgizi').prop('checked',false);
					$('.tind_gizi_mtbs_11').prop('checked',true);
					$('.tind_gizi_mtbs_9').prop('checked',true);
					$('.tind_gizi_mtbs_7').prop('checked',true);
					$('.tind_gizi_mtbs_10').prop('checked',true);
				}else if(ini == 'Gizi Baik'){
				$('.tindgizi').prop('checked',false);
					$('.tind_gizi_mtbs_11').prop('checked',true);
					$('.tind_gizi_mtbs_9').prop('checked',true);
					$('.tind_gizi_mtbs_12').prop('checked',true);
				}
			});
			<!--9. Anemia-->
			$('.klasifikasi_mtbs_anemia').change(function(){
				var ini = $(this).val();
				if(ini == 'Anemia Berat'){
				$('.tindanemia').prop('checked',false);
					$('.tind_anemia_mtbs_1').prop('checked',true);
					$('.tind_anemia_mtbs_2').prop('checked',true);
				}else if(ini == 'Anemia'){
				$('.tindanemia').prop('checked',false);
					$('.tind_anemia_mtbs_3').prop('checked',true);
					$('.tind_anemia_mtbs_4').prop('checked',true);
					$('.tind_anemia_mtbs_5').prop('checked',true);
					$('.tind_anemia_mtbs_6').prop('checked',true);
					$('.tind_anemia_mtbs_7').prop('checked',true);
					$('.tind_anemia_mtbs_8').prop('checked',true);
				}else if(ini == 'Tidak Anemia'){
				$('.tindanemia').prop('checked',false);
					$('.tind_anemia_mtbs_9').prop('checked',true);
				}
			});
			<!--10. HIV-->
			$('.klasifikasi_mtbs_hiv').change(function(){
				var ini = $(this).val();
				if(ini == 'Infeksi HIV Terkonfirmasi'){
				$('.tindhiv').prop('checked',false);
					$('.tind_hiv_mtbs_1').prop('checked',true);
					$('.tind_hiv_mtbs_2').prop('checked',true);
				}else if(ini == 'Diduga Terinfeksi HIV'){
				$('.tindhiv').prop('checked',false);
					$('.tind_hiv_mtbs_1').prop('checked',true);
					$('.tind_hiv_mtbs_2').prop('checked',true);
				}else if(ini == 'Terpajan HIV'){
				$('.tindhiv').prop('checked',false);
					$('.tind_hiv_mtbs_1').prop('checked',true);
					$('.tind_hiv_mtbs_2').prop('checked',true);
				}else if(ini == 'Kemungkinan Bukan Inveksi HIV'){
				$('.tindhiv').prop('checked',false);
					$('.tind_hiv_mtbs_3').prop('checked',true);
				}
			});

			function addkelompok(){
				$('.newbaris').each(function(index){
					if(index == '0'){
						var kelompok = 'Primary';
						var kelompokvalue = '1';
					}else if(index == '1'){
						var kelompok = 'Sekunder 1';
						var kelompokvalue = '2';
					}else if(index == '2'){
						var kelompok = 'Sekunder 2';
						var kelompokvalue = '3';
					}
					$(this).find('.kelompok-html').html(kelompok);
					$(this).find('.kelompok-diagnosa-input').val(kelompokvalue);
				});
			};
			
			function add_new_form(){
				$('.newbaris').each(function(index){
					var kode = $(this).find('.kode-html').html();
					var noreg = '<?php echo $noregistrasi;?>';
					//alert(noreg);
					if(kode == 'A03.0' || kode == 'A06.0' || kode == 'A09'){
						$.post( "form_diare.php", { noreg: noreg })
						  .done(function( data ) {
							$('.form_tambahan').html(data);
						});
						//$('#formdiarehidden').removeClass('hidden');
						$('.ket_formdiarehidden').val('123');
					}else if(kode == 'J18.0' || kode == 'J18.9' || kode == 'J00' || kode == 'J06.9'){
						$.post( "form_ispa.php", { noreg: noreg })
						  .done(function( data ) {
							$('.form_tambahan').html(data);
						});
						//$('#formispahidden').removeClass('hidden');
						$('.ket_formispahidden').val('123');
					}else if(kode == 'B05.9'){
						$.post( "form_campak.php", { noreg: noreg })
						  .done(function( data ) {
							$('.form_tambahan').html(data);
						});
						//$('#formcampakhidden').removeClass('hidden');
						$('.ket_formcampakhidden').val('123');
					}else if(kode == 'I10' || kode == 'I23' || kode == 'I64' || kode == 'E14.0' || kode == 'C53.9'){
						$.post( "form_ptm.php", { noreg: noreg })
						  .done(function( data ) {
							$('.form_tambahan').html(data);
						});
						//$('#formptmhidden').removeClass('hidden');
						$('.ket_formptmhidden').val('123');
					}else{
						$('.form_tambahan').html("");
					}
				});
			}
			
				
			$(".kat_pencarian").change(function(){
				if($(this).val() == 'NamaPasien' || $(this).val() == 'NamaKK' || $(this).val() == 'TanggalLahir'){
					if($(this).val() == 'TanggalLahir'){
						$('.formtgllahir').removeClass('hidden');
						$('.formalamat').addClass('hidden');
						//var ket = "Tahun";
						//$('.formtgllahir').find('.cari').attr('placeholder',ket);
					}else{
						$('.formalamat').removeClass('hidden');
						$('.formtgllahir').addClass('hidden');
						// var ket = "Kelurahan / Desa";
						// $('.formalamat').find('.cari').attr('placeholder',ket);
					}
					$('.formkey').removeClass('col-sm-4');
					$('.formkey').addClass('col-sm-2');
					
					/*$('.formalamat').find('.cari').prop('required',true);*/
				}else{
					$('.formkey').removeClass('col-sm-2');
					$('.formkey').addClass('col-sm-4');
					$('.formalamat').addClass('hidden');
					$('.formtgllahir').addClass('hidden');
					/*$('.formalamat').find('.cari').prop('required',false);*/
				}
			});
			
			$(document).ready(function(){
				if($('.kat_pencarian').val() == 'NamaPasien' || $('.kat_pencarian').val() == 'NamaKK' || $(".kat_pencarian").val() == 'TanggalLahir'){
					if($(".kat_pencarian").val() == 'TanggalLahir'){
						$('.formtgllahir').removeClass('hidden');
						$('.formalamat').addClass('hidden');
						//var ket = "Tahun";
						//$('.formtgllahir').find('.cari').attr('placeholder',ket);
					}else{
						$('.formalamat').removeClass('hidden');
						$('.formtgllahir').addClass('hidden');
						// var ket = "Kelurahan / Desa";
						// $('.formalamat').find('.cari').attr('placeholder',ket);
					}
					$('.formkey').removeClass('col-sm-4');
					$('.formkey').addClass('col-sm-2');
				}else{
					$('.formkey').removeClass('col-sm-2');
					$('.formkey').addClass('col-sm-4');
					$('.formalamat').addClass('hidden');
				}
			});
			
			// table nama barang
			$( ".table-responsive" ).scroll(function() {
				var inleft = $(this).scrollLeft();
				if(inleft > 0){
					$(".namabarangcls").addClass('classfixed');
				}else{
					$(".namabarangcls").removeClass('classfixed');
				}
			});
			
			//log user, buat update status saat login atau logout
			$(document).ready(function() {
			         $.ajax({
			        type: 'POST',
			        url: 'log.php',
			        async:false,
			        data: {userlog:"online"}
			    });
			});

			//log user that is about to leave - window/tab will be closed.
			$(window).bind('beforeunload', function(){
			    $.ajax({
			        type: 'POST',
			        url: 'log.php',
			        async:false,
			        data: {userlog:"offline"}
			    });
			});
		
			jQuery(function($) {
				$('.easy-pie-chart.percentage').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
					var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
					var size = parseInt($(this).data('size')) || 50;
					$(this).easyPieChart({
						barColor: barColor,
						trackColor: trackColor,
						scaleColor: false,
						lineCap: 'butt',
						lineWidth: parseInt(size/10),
						animate: ace.vars['old_ie'] ? false : 1000,
						size: size
					});
				})
			
				$('.sparkline').each(function(){
					var $box = $(this).closest('.infobox');
					var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
					$(this).sparkline('html',
									 {
										tagValuesAttribute:'data-values',
										type: 'bar',
										barColor: barColor ,
										chartRangeMin:$(this).data('min') || 0
									 });
				});
			
			
			  //flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
			  //but sometimes it brings up errors with normal resize event handlers
			  $.resize.throttleWindow = false;
			
			  var placeholder = $('#piechart-placeholder').css({'width':'90%' , 'min-height':'150px'});
			  var data = [
				{ label: "social networks",  data: 38.7, color: "#68BC31"},
				{ label: "search engines",  data: 24.5, color: "#2091CF"},
				{ label: "ad campaigns",  data: 8.2, color: "#AF4E96"},
				{ label: "direct traffic",  data: 18.6, color: "#DA5430"},
				{ label: "other",  data: 10, color: "#FEE074"}
			  ]
			  function drawPieChart(placeholder, data, position) {
			 	  $.plot(placeholder, data, {
					series: {
						pie: {
							show: true,
							tilt:0.8,
							highlight: {
								opacity: 0.25
							},
							stroke: {
								color: '#fff',
								width: 2
							},
							startAngle: 2
						}
					},
					legend: {
						show: true,
						position: position || "ne", 
						labelBoxBorderColor: null,
						margin:[-30,15]
					}
					,
					grid: {
						hoverable: true,
						clickable: true
					}
				 })
			 }
			 drawPieChart(placeholder, data);
			
			 /**
			 we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
			 so that's not needed actually.
			 */
			 placeholder.data('chart', data);
			 placeholder.data('draw', drawPieChart);
			
			
			  //pie chart tooltip example
			  var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
			  var previousPoint = null;
			
			  placeholder.on('plothover', function (event, pos, item) {
				if(item) {
					if (previousPoint != item.seriesIndex) {
						previousPoint = item.seriesIndex;
						var tip = item.series['label'] + " : " + item.series['percent']+'%';
						$tooltip.show().children(0).text(tip);
					}
					$tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
				} else {
					$tooltip.hide();
					previousPoint = null;
				}
				
			 });
			
				/////////////////////////////////////
				$(document).one('ajaxloadstart.page', function(e) {
					$tooltip.remove();
				});
			
			
			
			
				var d1 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d1.push([i, Math.sin(i)]);
				}
			
				var d2 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.5) {
					d2.push([i, Math.cos(i)]);
				}
			
				var d3 = [];
				for (var i = 0; i < Math.PI * 2; i += 0.2) {
					d3.push([i, Math.tan(i)]);
				}
				
			
				var sales_charts = $('#sales-charts').css({'width':'100%' , 'height':'220px'});
				$.plot("#sales-charts", [
					{ label: "Domains", data: d1 },
					{ label: "Hosting", data: d2 },
					{ label: "Services", data: d3 }
				], {
					hoverable: true,
					shadowSize: 0,
					series: {
						lines: { show: true },
						points: { show: true }
					},
					xaxis: {
						tickLength: 0
					},
					yaxis: {
						ticks: 10,
						min: -2,
						max: 2,
						tickDecimals: 3
					},
					grid: {
						backgroundColor: { colors: [ "#fff", "#fff" ] },
						borderWidth: 1,
						borderColor:'#555'
					}
				});
			
			
				$('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('.tab-content')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					//var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			
			
				$('.dialogs,.comments').ace_scroll({
					size: 300
			    });
				
				
				//Android's default browser somehow is confused when tapping on label which will lead to dragging the task
				//so disable dragging when clicking on label
				var agent = navigator.userAgent.toLowerCase();
				if(ace.vars['touch'] && ace.vars['android']) {
				  $('#tasks').on('touchstart', function(e){
					var li = $(e.target).closest('#tasks li');
					if(li.length == 0)return;
					var label = li.find('label.inline').get(0);
					if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
				  });
				}
			
				$('#tasks').sortable({
					opacity:0.8,
					revert:true,
					forceHelperSize:true,
					placeholder: 'draggable-placeholder',
					forcePlaceholderSize:true,
					tolerance:'pointer',
					stop: function( event, ui ) {
						//just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
						$(ui.item).css('z-index', 'auto');
					}
					}
				);
				$('#tasks').disableSelection();
				$('#tasks input:checkbox').removeAttr('checked').on('click', function(){
					if(this.checked) $(this).closest('li').addClass('selected');
					else $(this).closest('li').removeClass('selected');
				});
			
			
				//show the dropdowns on top or bottom depending on window height and menu position
				$('#task-tab .dropdown-hover').on('mouseenter', function(e) {
					var offset = $(this).offset();
			
					var $w = $(window)
					if (offset.top > $w.scrollTop() + $w.innerHeight() - 100) 
						$(this).addClass('dropup');
					else $(this).removeClass('dropup');
				});
			
			})
			
			$( ".cari" ).keypress(function( event ) {
				if ( event.which == 13 ) {
					$('.btnsubmit').click();
				}
			});
			
			$( "#hide-option" ).tooltip({
				hide: {
					effect: "explode",
					delay: 250
				}
			});
			
			//jquery accordion tooltips
			$( "#accordion" ).accordion({
				collapsible: true ,
				heightStyle: "content",
				animate: 250,
				header: ".accordion-header"
			}).sortable({
				axis: "y",
				handle: ".accordion-header",
				stop: function( event, ui ) {
					ui.item.children( ".accordion-header" ).triggerHandler( "focusout" );
				}
			});
		</script>
	</body>
</html>
<?php
mysqli_close($koneksi);
}else{
		echo "<script type='text/javascript'>";
		echo "window.location='indexawal.php';";
		echo "</script>";
}
?>	
