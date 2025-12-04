<?php
error_reporting(0);
session_start();
if(isset($_SESSION['id_user'])){
include "config/koneksi.php";
include "config/helper.php";
include "config/helper_pasienrj.php";
$kota = $_SESSION['kota'];

if($kota == "KOTA TARAKAN"){
	date_default_timezone_set('Asia/Ujung_Pandang');
}else{
	date_default_timezone_set('Asia/Jakarta');
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="puskesmas online, pendaftaran online puskesmas, aplikasi puskesmas, simpus, sip, sik, sikda, puskesmas, sistem informasi kesehatan, rekam medis elektronik, rme, rekmed"/>
		<meta name="description" content="Puskesmas Online merupakan Aplikasi Rekam Medis Elektronik selain itu juga dikenal dengan Sistem Informasi Manajemen Puskesmas (SIMPUS) / Sistem Informasi Kesehatan (SIK), 
		aplikasi ini dikembangkan sejak tahun 2011, salahsatu fungsinya sebagai media pengolahan data informasi kesehatan yang ada di Puskesmas.">
		<meta name="author" content="Tommy Metrost">
		<meta name="language"content="id"/>
		<link rel="icon" href="image/piksiganesha.png" type="image/png" sizes="16x16">
		<title>PiksiGanesha</title>
		
		<!-- css baru 09 Maret 2023-->
		<!-- Fonts and icons -->
		<script src="assets_atlantis/js/plugin/webfont/webfont.min.js"></script>
		<script>
			WebFont.load({
				google: {"families":["Lato:300,400,700,900"]},
				custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['assets_atlantis/css/fonts.min.css']},
				active: function() {
					sessionStorage.fonts = true;
				}
			});
		</script>

		<!-- CSS Files -->
		<link rel="stylesheet" href="assets_atlantis/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets_atlantis/css/atlantis.min.css">

		<!-- CSS Just for demo purpose, don't include it in your project -->
		<link rel="stylesheet" href="assets_atlantis/css/demo.css">
		<!-- akhir css baru -->		
		
		<!-- bootstrap & fontawesome -->
		<!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css?3"/> hapus -->
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
		<!--<link rel="stylesheet" href="assets/css/ace.min.css?=2" class="ace-main-stylesheet" id="main-ace-style" /> hapus -->
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
		<link rel="stylesheet" type="text/css" href="assets/css/f_laporan.css?=3">
		<link rel="stylesheet" type="text/css" href="assets/css/laporan_print.css?=1">
		<link rel="stylesheet" type="text/css" href="assets/css/f_laporan_dinkes.css">
		<link rel="stylesheet" type="text/css" href="assets/css/f_panel_dashboard.css?=5">
		<link rel="stylesheet" type="text/css" href="assets/css/f_kotak_grafik.css?=2">
		<link rel="stylesheet" href="assets/css/bootstrap4-chosen.css" />
		
		<style>
		body{
			font-family: "Poppins", sans-serif;
		}
		.menu-text{
			font-family: "Poppins", sans-serif;
		}
		.nav-item{
			font-family: "Poppins", sans-serif;
		}
		.alert, .brand, .btn-simple, .h1, .h2, .h3, .h4, .h5, .h6, .navbar, .td-name, a, body, button.close, h1, h2, h3, h4, h5, h6, p, td {
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
			text-align: center;
			border-color:#000;
			font-size: 12px;
			font-family: "Poppins", sans-serif;			
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
			font-size: 13px;
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
			font-size: 10px;
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
			box-shadow: 0px 0px 10px #d6d6d6;
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
		.btndefault{
			display: block;
			width: 100%;
			background-color: #9e9e9e;
			border: none;
			color: #fff;
			padding: 12px 30px;
			cursor: pointer;
			font-size: 18px;
			border-radius: 5px;
			transition: all 0.2s;
			text-align: center;
		}
		.btndefault:hover{
			color:#fff;
			background-color:#5b5a5a;
		}
		.navbar{
			background-image: -webkit-linear-gradient(45deg, #2d6827 0%, #29DE52 100%);
		}
		/* .navbar-header{
			margin-top: 5px;		
		} */	
		.ace-nav>li.light-blue>a {
			background-color: #22be87;
		}
		.ace-nav>li.open.light-blue>a{
			background-color: #22be87;
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
			width: 400px;
			background-color:#ccffe6  ! important;
		}
		.kotak_panel{
			padding:20px 20px;
			min-height: 130px;
		}
		.font30 span{
			font-size: 12px;
		}
		.fontket h3{
			color:#00aec5;padding:0px;margin:0px;font-size: 18px
		}
		.fontket span{
			font-size: 11px;
		}
		.navbar-brand p{
			padding-top:15px;font-size: 15px; font-weight: bold;float:left;
		}	
		
		.logmobile{
			display: none !important;
		}
		.judulpuskesmas{
			font-size: 12px;
			font-weight: bold;
			color: #fff !important;
			margin-left:5px;
			margin-top:35px;
			line-height: 12px;
		}
		a {
			color: #FFF;
		}
		.notif-img{
			background: none !important;
			
		}
		.notif-box .notif-center a .notif-img img, .messages-notif-box .notif-center a .notif-img img {
			width: 100%;
			height: 100%;
			border-radius: 15%; 
		}
		.notif-box .notif-center a:hover, .messages-notif-box .notif-center a:hover {
			text-decoration: none;
			background: #a5e7ff;
			transition: all .2s; 
		}
		.badgepanel{
			background-color: #45D249;
			color: white;
			padding: 4px 8px;
			text-align: center;
			font-size: 12px;
			border-radius: 20px;
		}
		.badgeinfo{
			background-color: #1572E8;
			color: white;
			padding: 4px 8px;
			text-align: center;
			font-size: 12px;
			border-radius: 20px;
		}
		.user-box{
			font-size: 14px;
		}

		.inputan {
			border:0; 
			padding:10px; 
			font-size:1em; 
			color:#969696; 
			border:solid 2px #ccc;			
			width:100%;
			-moz-box-shadow: inset 0 0 4px rgba(0,0,0,0.2); 
			-webkit-box-shadow: inset 0 0 4px rgba(0, 0, 0, 0.2); 
			box-shadow: inner 0 0 4px rgba(0, 0, 0, 0.2);
			-webkit-border-radius: 3px; 
			-moz-border-radius: 3px; 
			border-radius: 3px;    
		}

		.inputan:focus { 
			outline: none !important;
			border-color: red !important;
			box-shadow: 0 0 10px red;
		}

		.logo-header[data-background-color=blue] {
			background: #5b06b5!important;
		}
		.navbar-header[data-background-color=blue2] {
			background: #5b06b5!important;
			background: -webkit-linear-gradient(legacy-direction(-45deg),#c570ff,#5b06b5)!important;
			background: linear-gradient(-45deg,#c570ff,#5b06b5)!important;
		}
		.sidebar.sidebar-style-2 .nav.nav-primary>.nav-item.active>a {
			background: #5b06b5!important;			
			box-shadow: 4px 4px 10px 0 rgba(0,0,0,.1),4px 4px 15px -5px rgba(21,114,232,.4)!important;
		}
		.bg-primary-gradient {
			background: #5b06b5!important;
			background: -webkit-linear-gradient(legacy-direction(-45deg),#c570ff,#5b06b5)!important;
			background: linear-gradient(-45deg,#c570ff,#5b06b5)!important;			
		}
			
		@media only screen and (max-width: 479px){
			.navbar:not(.navbar-collapse) .ace-nav>li {
				text-align: center;
			}	
			.navbar{
				height: 80px !important
			}
			.navbar-brand p{
				padding-top:5px;font-size: 15px; font-weight: bold;float:none;
			}
			.navbar-buttons{
				display: none;
			}
			.logmobile{
				display: block !important;
			}	
			.navbar-toggle{
				position: relative;top:-60px;right: 10px
			}
			.main-content-inner{	
				margin-top:-40px;
			}
			.font30 {
				font-size: 22px !important;
				position: absolute;
				top: 20px !important;
				left: 110px;
				color: #fff;
				font-weight: bold;
				margin-top: 15px;
			}
			.kotak_panel .ket {
				font-size: 12px !important;
				color: #f9f9f9;
				position: absolute;
				top: 60px !important;
				left: 120px;
			}
			.judulpuskesmas{
				display:none;
			}
			.judulkodepuskesmas{
				display: none;
			}			
		}

		@media only screen and (max-width: 768px){
			.judulpuskesmas{
				display:none;
			}
		}
		@media print{
			body{
				padding:0px;
			}
			.noprint{
				display:none;
			}
			.sidebar,.sidebar-wrapper{
				display:none;
			}
			.main-panel{
				position:absolute;
				width:100% !important;
			}
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
		.dropdown-toggle1{
			background: #058c20 !important;	
		}		
		.datepicker {
			padding: 10px;
			-webkit-border-radius: 4px;
			-moz-border-radius: 4px;
			border-radius: 4px;
			direction: ltr;
		}		
		.pagination>li>a,.pagination>li>span{
			position:relative;
			float:left;
			padding:6px 12px;
			line-height:1.42857143;
			text-decoration:none;
			color:#4EB94A;
			background-color:#fff;
			border:1px solid #ddd;
			margin-left:-1px}
			
		/* .pagination>li>a:focus,.pagination>li>a:hover,.pagination>li>span:focus,
		.pagination>li>span:hover{z-index:2;color:#23527c;background-color:#eee;border-color:#ddd}
		.pagination>.active>a,.pagination>.active>a:focus,.pagination>.active>a:hover,
		.pagination>.active>span,.pagination>.active>span:focus, */
		
		</style>
		
		<!--FONTS-->
		<link href="assets/css/jquery.autocomplete.css?6" rel="stylesheet">
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
		<div class="wrapper <?php echo ($_GET['page'] == 'nurse_station') ? 'sidebar_minimize' : '';?>">
			<div class="main-header noprint">
				<!-- Logo Header -->
				<div class="logo-header" data-background-color="blue">
					<a href="index.php" class="logo">
						<?php if($_SESSION['namapuskesmas'] != 'UPTD FARMASI' AND $_SESSION['namapuskesmas'] != 'DINAS KESEHATAN'){ ?>		
							<img src="image/piksiganesha.png" class="navbar-brand" width="40px"/>
						<?php }else{ ?>
							<img src="image/bandungkab.png" class="navbar-brand" width="40px"/>
						<?php }	?>
						
						<a class="judulpuskesmas logo">
							<?php
								if($_SESSION['namapuskesmas'] != 'UPTD FARMASI' AND $_SESSION['namapuskesmas'] != 'DINAS KESEHATAN'){
									echo $_SESSION['namapuskesmas']."<br/>".$_SESSION['kodepuskesmas'];
								}else{
									echo $_SESSION['namapuskesmas']."<br/>".$_SESSION['kota'];
								}	
							?>
						</a>
					</a>
					<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon">
							<i class="icon-menu"></i>
						</span>
					</button>
					<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
					<div class="nav-toggle">
						<button class="btn btn-toggle toggle-sidebar">
							<i class="icon-menu"></i>
						</button>
					</div>
				</div>
				<!-- End Logo Header -->

				<!-- Navbar Header -->
				<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
					<div class="container-fluid">
						<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
							<li class="nav-item dropdown hidden-caret">
								<a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									<i class="fa fa-bell"></i>
									<span class="notification">3</span>
								</a>
								<ul class="dropdown-menu notif-box" aria-labelledby="notifDropdown">
									<li>
										<div class="dropdown-title">Bridging Sistem</div>
									</li>
									<li>
										<div class="notif-center">
											<!-- <a href="#">
												<div class="notif-icon notif-primary"> <i class="fa fa-user-plus"></i> </div>
												<div class="notif-content">
													<span class="block">
														New user registered
													</span>
													<span class="time">5 minutes ago</span> 
												</div>
											</a>
											<a href="#">
												<div class="notif-icon notif-success"> <i class="fa fa-comment"></i> </div>
												<div class="notif-content">
													<span class="block">
														Rahmad commented on Admin
													</span>
													<span class="time">12 minutes ago</span> 
												</div>
											</a> -->
											<a href="#">
												<div class="notif-img"> 
													<img src="image/logo_bpjs_bulet.png" alt="Bridging Pcare">
												</div>
												<div class="notif-content">
													<span class="block">
														PCare V.4.0 <span class="badgepanel"><?php echo $_SESSION['bridgingpcare'];?></span>
													</span>
													<span class="time">Bpjs Kesehatan</span> 
													
												</div>
											</a>
											<a href="#">
												<div class="notif-img"> 
													<img src="image/logo_bpjs_bulet.png" alt="Bridging Mjkn">
												</div>
												<div class="notif-content">
													<span class="block">
														Antrol M-Jkn <span class="badgepanel"><?php echo $_SESSION['bridgingantrol'];?></span>
													</span>
													<span class="time">Bpjs Kesehatan</span> 
													
												</div>
											</a>
											<!-- <a href="https://satusehat-dataviz.kemkes.go.id/implementasi-satusehat-dashboard" target="_blank">
												<div class="notif-img"> 
													<img src="image/satusehat.png" alt="Bridging Satusehat">
												</div>
												<div class="notif-content">
													<span class="block">
														Satu Sehat
														<span class="badgepanel">
															<?php 
															// if($_SESSION['bridgingsatusehat'] == 'Sudah'){
															// 	echo "Terkoneksi";
															// }else{
															// 	echo "Belum Terkoneksi";
															// }
															?>
														</span>
													</span>
													<span class="time">Kementrian Kesehatan</span> 
												</div>
											</a> -->
										</div>
									</li>
									<!-- <li>
										<a class="see-all" href="javascript:void(0);">See all notifications<i class="fa fa-angle-right"></i> </a>
									</li> -->
								</ul>
							</li>

							<li class="nav-item dropdown hidden-caret">
								<a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
									<i class="icon-cloud-download"></i>
								</a>
								<div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
									<div class="quick-actions-header">
										<span class="title mb-1">Download</span>
									</div>
									<div class="quick-actions-scroll scrollbar-outer">
										<div class="quick-actions-items">
											<div class="row m-0">
												<a class="col-6 col-md-4 p-0" href="?page=adm_sertifikat">
													<div class="quick-actions-item">
														<i class="flaticon-file-1"></i>
														<span class="text">e-Sertifikat</span>
													</div>
												</a>
												<!-- <a class="col-6 col-md-4 p-0" href="#">
													<div class="quick-actions-item">
														<i class="flaticon-database"></i>
														<span class="text">Panduan</span>
													</div>
												</a> -->
												<a class="col-6 col-md-4 p-0" href="dok/form pengembangan simpus.docx">
													<div class="quick-actions-item">
														<i class="flaticon-file-1"></i>
														<span class="text">Masukan</span>
													</div>
												</a>
												<a class="col-6 col-md-4 p-0" href="dok/SURAT DINKES (WORKSHOP RME 2024).pdf">
													<div class="quick-actions-item">
														<i class="flaticon-file-1"></i>
														<span class="text">Surat WS RME</span>
													</div>
												</a>
											</div>
										</div>
									</div>
									<div class="quick-actions-header">
										<span class="title mb-1">Rekam Medis</span>
									</div>
									<div class="user-box">
										<a href="dok/Permenkes Nomor 46 Tahun 2014 (sik).pdf" target="_blank">
											<span class="text-muted"><i class="fa fa-check-circle mr-2"></i>Permenkes 46 Tahun 2014 (SIK)</span>
										</a>
									</div>
									<div class="user-box">
										<a href="dok/Permenkes Nomor 20 Tahun 2019 (telemedicine).pdf" target="_blank">
											<span class="text-muted"><i class="fa fa-check-circle mr-2"></i>Permenkes 20 Tahun 2019 (Telemedicine)</span>
										</a>
									</div>
									<div class="user-box">
										<a href="dok/permenkes 24 tahun 2022 (rekam medis).pdf" target="_blank">
											<span class="text-muted"><i class="fa fa-check-circle mr-2"></i>Permenkes 24 Tahun 2022 (Rme)</span>
										</a>
									</div>
									<div class="user-box">
										<a href="dok/Pedoman Variabel dan Meta Data 2022.pdf" target="_blank">
											<span class="text-muted"><i class="fa fa-check-circle mr-2"></i>Menkes Variabel Meta Data 2022</span>
										</a>
									</div>
									<div class="user-box">
										<a href="dok/Penyelenggaraan RME Fasyankes 2023.pdf" target="_blank">
											<span class="text-muted"><i class="fa fa-check-circle mr-2"></i>Menkes Penyelenggaraan Rme 2023</span>
										</a>
									</div>
									<div class="quick-actions-header">
										<span class="title mb-1">Pemerintahan Berbasis Elektronik</span>
									</div>
									<div class="user-box">
										<a href="dok/Perpres Nomor 132 Tahun 2022 (spbe).pdf" target="_blank">
											<span class="text-muted"><i class="fa fa-check-circle mr-2"></i>Perpres 132 Tahun 2022 (Spbe)</span>
										</a>
									</div>
									<div class="user-box">
										<a href="dok/Perpres Nomor 17 Tahun 2023 (kesehatan).pdf" target="_blank">
											<span class="text-muted"><i class="fa fa-check-circle mr-2"></i>Perpres 17 Tahun 2023 (Kesehatan)</span>
										</a>
									</div>
									<div class="user-box">
										<a href="dok/Perpres Nomor 82 Tahun 2023 (transformasi digital).pdf" target="_blank">
											<span class="text-muted"><i class="fa fa-check-circle mr-2"></i>Perpres 82 Tahun 2023 (Digitalisasi)</span>
										</a>
									</div>
									
								</div>
							</li>
							<li class="nav-item dropdown hidden-caret">
								<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
									<div class="avatar-sm">
										<img src="assets_atlantis/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
									</div>
								</a>
								<ul class="dropdown-menu dropdown-user animated fadeIn">
									<div class="dropdown-user-scroll scrollbar-outer">
										<li>
											<div class="user-box">
												<div class="avatar-lg"><img src="assets_atlantis/img/profile.jpg" alt="image profile" class="avatar-img rounded"></div>
												<div class="u-text">
													<h4><?php echo $_SESSION['nama_petugas'];?></h4>
													<p class="text-muted"><?php echo $_SESSION['id_user'];?></p>
												</div>
											</div>
										</li>
										<li>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="?page=update_profile_puskesmas">Data Puskesmas</a>
											<a class="dropdown-item" href="?page=update_profile">Data User</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="logout.php">Logout</a>
										</li>
									</div>
								</ul>
							</li>
						</ul>
					</div>
				</nav>
				<!-- End Navbar -->
			</div>
		
			<!-- Sidebar -->
			<div class="sidebar sidebar-style-2 noprint">			
				<div class="sidebar-wrapper scrollbar scrollbar-inner">
					<div class="sidebar-content">
						<div class="user">
							<div class="avatar-sm float-left mr-2">
								<img src="assets_atlantis/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
							</div>
							<div class="info">
								<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
									<span style="font-size: 12px; font-weight: bold; line-height: 10px; padding-top: 7px;">
										<?php 
										if(strpos($_SESSION['nama_petugas'],' ') > 3){
											echo substr($_SESSION['nama_petugas'],0,strpos($_SESSION['nama_petugas'],' '));
										}else{
											echo $_SESSION['nama_petugas'];
										}										
										?>
										<span class="user-level"><?php echo $_SESSION['status'];?></span>
										<span class="caret"></span>
									</span>
								</a>
								<div class="clearfix"></div>

								<div class="collapse in" id="collapseExample">
									<ul class="nav">
										<li>
											<a href="?page=update_profile">
												<span class="link-collapse">Profile</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<ul class="nav nav-primary">
							<?php
								if($_SESSION['kodepuskesmas'] == '-'){
									include "menu_dinas.php";
								}else if($_SESSION['namapuskesmas'] == 'UPTD FARMASI'){
									if($kota == "KABUPATEN BANDUNG"){
										include "menu_uptd_farmasi.php";
									}elseif($kota == "KABUPATEN BEKASI"){
										include "menu_uptd_farmasi_bekasikab.php";
									}elseif($kota == "KABUPATEN BOGOR"){
										include "menu_uptd_farmasi_bogorkab.php";
									}elseif($kota == "KOTA TARAKAN"){
										include "menu_uptd_farmasi_tarakan.php";
									}	
								}else{
									if($kota == "KABUPATEN BANDUNG"){
										include "menu_puskesmas.php";
									}elseif($kota == "KABUPATEN GARUT"){
										include "menu_puskesmas_garutkab.php";
									}elseif($kota == "KABUPATEN BOGOR"){
										include "menu_puskesmas_bogorkab.php";
									}elseif($kota == "SUKABUMI"){
										include "menu_puskesmas_sukabumikab.php";
									}elseif($kota == "KOTA TARAKAN"){
										include "menu_puskesmas_tarakan.php";
									}else{
										include "menu_puskesmas.php";
									}
								}
							?>
						</ul>
					</div>
				</div>
			</div>
			<!-- End Sidebar -->
			
			<div class="main-panel">
				<div class="content">
					<!--<div class="card-header">
						<div class="card-head-row">
							<div class="card-title">Judul</div>
							<div class="card-tools">
								<a href="#" class="btn btn-info btn-border btn-round btn-sm mr-2">
									<span class="btn-label">
										<i class="fa fa-pencil"></i>
									</span>
									Export
								</a>
								<a href="#" class="btn btn-info btn-border btn-round btn-sm">
									<span class="btn-label">
										<i class="fa fa-print"></i>
									</span>
									Print
								</a>
							</div>
						</div>
					</div>
					<div class="card-body">
						
					</div>-->
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
				<footer class="footer noprint">
					<div class="container-fluid">
						<div class="copyright ml-auto">
							<?php echo date('Y')." | SIMPUS DINAS KESEHATAN ".$kota;?>
						</div>				
					</div>
				</footer>
			</div>
		</div>

		<!-- modal notifikasi -->
		<div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<!-- <div class="modal-header">
					</div> -->
					<div class="modal-body">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-round btn-default" data-dismiss="modal">Tidak</button>
						<a href="" class="btn btn-round btn-danger btn-ok">Ya</a>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="alert-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content" style="text-align:center;padding:0px">
					
					<div class="modal-body ">
						<div style="background: #cc1e1e; padding: 20px; margin-bottom: 20px; color:#fff;">
							<i class="icon-close fa-6x"></i>
						</div>
						<div class="modalbody-alert"></div>
					
						<button type="button" class="btn btn-round btn-danger mt-4" data-dismiss="modal">Coba Lagi</button>
					</div>
				</div>
			</div>
		</div>
		
		<!--   js baru   -->
		<!--   Core JS Files   -->
		<script src="assets/js/jquery-2.1.4.min.js?14"></script>
		<!-- <script src="assets_atlantis/js/core/jquery.3.2.1.min.js"></script> -->
		<script src="assets_atlantis/js/core/popper.min.js"></script>
		<script src="assets_atlantis/js/core/bootstrap.min.js"></script>

		<!-- jQuery UI -->
		<script src="assets_atlantis/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
		<script src="assets_atlantis/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

		<!-- jQuery Scrollbar -->
		<script src="assets_atlantis/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>


		<!-- Chart JS -->
		<script src="assets_atlantis/js/plugin/chart.js/chart.min.js"></script>

		<!-- jQuery Sparkline -->
		<script src="assets_atlantis/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

		<!-- Chart Circle -->
		<script src="assets_atlantis/js/plugin/chart-circle/circles.min.js"></script>

		<!-- Datatables -->
		<script src="assets_atlantis/js/plugin/datatables/datatables.min.js"></script>

		

		<!-- Bootstrap Notify -->
		<script src="assets_atlantis/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
		<script src="assets_atlantis/js/plugin/sweetalert/sweetalert.min.js"></script>
		<script>
			<?php
				if($_SESSION['alert_ket'] != ''){
			?>	
				$.notify({
					icon: 'flaticon-chat',
					title: '<?php echo ($_SESSION['alert'] == 'sukses') ? 'Sukses' : 'Gagal';?>',
					message: '<?php echo $_SESSION['alert_ket'];?>'
				},{
					type: '<?php echo ($_SESSION['alert'] == 'sukses') ? 'success' : 'danger';?>',
				});
			<?php
				unset($_SESSION['alert_ket']);
				unset($_SESSION['alert']);				
				}
			?>

			<?php
				if($_SESSION['alert_swal_ket'] != ''){
			?>
				swal("<?php echo ($_SESSION['alert_swal'] == 'sukses') ? 'Sukses !' : 'Gagal !';?>", "<?php echo $_SESSION['alert_swal_ket'];?>", {
					icon : "<?php echo ($_SESSION['alert_swal'] == 'sukses') ? 'success' : 'error';?>",
					buttons: {
						confirm: {
							className : 'btn <?php echo ($_SESSION['alert_swal'] == 'sukses') ? 'btn-success' : 'btn-danger';?>'
						}
					},
				});
			<?php
				unset($_SESSION['alert_swal_ket']);
				unset($_SESSION['alert_swal']);				
				}
			?>
			
		</script>

		<!-- jQuery Vector Maps -->
		<!-- <script src="assets_atlantis/js/plugin/jqvmap/jquery.vmap.min.js"></script>
		<script src="assets_atlantis/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script> -->

		<!-- Sweet Alert -->
		

		<!-- Atlantis JS -->
		<script src="assets_atlantis/js/atlantis.min.js"></script>

		<!-- Atlantis DEMO methods, don't include it in your project! -->
		<!-- <script src="assets_atlantis/js/setting-demo.js"></script>
		<script src="assets_atlantis/js/demo.js"></script> -->
		
		<!--   akhir js baru   -->
		
		
		
		<!--[if !IE]> tooltips-->
		<!-- <script src="assets/js/jquery-2.1.4.min.js?14"></script> -->
		<!-- datatable -->
		<!-- <script src="assets/js/datatables/media/js/jquery.dataTables.min.js"></script> -->
		<script  type="text/javascript">
			$(document).ready(function() {
					$('#datatabless').DataTable();
				});
		</script>
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<!--DATE PICKER GINTING-->
		<script src="assets/bootstrapdatepicker/js/bootstrap-datepicker.min.js"></script>

<!-- 	sudah ada	<script src="assets/js/bootstrap.min.js"></script> 
	 	<script src="assets/js/jquery-ui.custom.min.js"></script> -->

		<!-- sudah ada<script src="assets/js/jquery.ui.touch-punch.min.js"></script> -->

		<script src="assets/js/jquery.easypiechart.min.js"></script>
		<script src="assets/js/jquery.sparkline.index.min.js"></script>
		<script src="assets/js/jquery.flot.min.js"></script>
		<script src="assets/js/jquery.flot.pie.min.js"></script>
		<script src="assets/js/jquery.flot.resize.min.js"></script> 

		<!--TOOLTIPS ANIMASI-->
		<!-- sudah ada <script src="assets/js/jquery-ui.min.js"></script> -->
		<!-- ace scripts -->
		
		<!-- sudah ada <script type="text/javascript" src="assets/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.min.js"></script>
		<script type="text/javascript" src="assets/js/jQuery-slimScroll-1.3.0/slimScrollHorizontal.min.js"></script>
 -->
		<!--COOKIE???-->
		<script type="text/javascript" src="assets/js/jQuery-Cookie/jquery.cookie.min.js"></script>
		<!--CUSTOM SCRIPT -->
		<script src="assets/js/jquery.autocomplete.js"></script>
		<script src="assets/js/chosen.js"></script>
		<script src="assets/js/source.js?193"></script>
		
		<!-- inline scripts related to this page -->
		<script type="text/javascript">
				$(".formsimpanproses").on("submit",function(e) {
					$(".btnsimpanproses").attr("type","button");
					$(".btnsimpanproses").addClass("btninfo");
					$(".btnsimpanproses").removeClass("btn-success");
					$(".btnsimpanproses").html("<i class='fas fa-spinner fa-spin'></i> Mohon Tunggu...");
				});

			$('.btnconfirm').click(function(event){
				event.preventDefault();
				var url = $(this).attr('href');
				var ket = $(this).data('ketconfirm');

				$(".btn-ok").attr('href',url);
				$(".modal-body").text(ket);

				$("#confirm-modal").modal('show');
			});

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
