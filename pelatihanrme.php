<?php
    include "config/koneksi.php";
	$kota = $_SESSION['kota'];
?>

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
		.user-box{
			font-size: 14px;
		}
    </style>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DATA PESERTA</b></h3>
			<table class="table-judul">
				<thead>
					<tr>
						<th width="5%">NO</th>
						<th width="50%">NAMA PESERTA</th>
						<th width="40%">PUSKESMAS</th>
						<th width="5%">#</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$query = mysqli_query($koneksi,"select * from `tbregistrasi_workshop` order by IdRegWorkshop");
					while($dtworkshop = mysqli_fetch_assoc($query)){
						$no = $no + 1;
					?>
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td><?php echo $dtworkshop['NamaPegawai'];?></td>
							<td><?php echo $dtworkshop['Puskesmas'];?></td>
							<td align="center">
								<a href="workshop/sukabumi/<?php echo $dtworkshop['Kwitansi'];?>" target="_blank" class="btn btn-round btn-sm btn-info">Kwitansi</a>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php
	if($_SESSION['otoritas'] == 'ADMINISTRATOR'){
?>

<!--Kolom Entry-->
<div class="row">	
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-bars"></i> Entry Asuransi</h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" action="index.php?page=master_asuransi_proses" method="post" role="form">
					<table class="table">
						<tr>
							<td class="col-sm-2">Asuransi</td>
							<td>:</td>
							<td class="col-sm-10">
								<input type="text" name="asuransi" style="text-transform: uppercase;" class="form-control" required>
							</td>
						</tr>
						<tr>
							<td>
							<td></td>
							<td><button type="submit" class="btn btn-round btn-md btn-success">Submit</button></td>
							</td>
						</tr>	
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
<?php 
}
?>
