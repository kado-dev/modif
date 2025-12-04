<?php
session_start();
include "../config/koneksi.php";
include "../config/helper.php";
date_default_timezone_set('Asia/Jakarta');
$kodepuskesmas = $_SESSION['kodepuskesmas'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">
    <title>Daftar Online</title>

	<!-- css baru 09 Maret 2023-->
	<!-- Fonts and icons -->
	<script src="../assets_atlantis/js/plugin/webfont/webfont.min.js"></script>
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
	<link rel="stylesheet" href="../assets_atlantis/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets_atlantis/css/atlantis.min.css">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="../assets_atlantis/css/demo.css">
	<!-- akhir css baru -->
	
	<!-- Bootstrap core CSS mas ginting-->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/jquery.autocomplete.css" rel="stylesheet">
    <link href="../assets/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
   
	<link href="../assets/bootstrapdatepicker/css/bootstrap-datepicker.min.css" rel="stylesheet"><!--ini css bootstrapdatepicker-->
	<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <!-- Custom styles for this template -->
	<script src="../assets/js/jquery.js"></script>
	<script src="../assets/js/qrcode.min.js"></script>
	<style>
		body {
			  padding-top: 0px;
			  padding-bottom: 0px;
			  font-family: 'Roboto Condensed', sans-serif;
			  font-size: 14px;
			  background: rgb(114,206,72);
			background: linear-gradient(180deg, rgba(114,206,72,1) 0%, rgba(54,178,34,1) 39%, rgba(22,138,4,1) 76%);
			background-repeat: no-repeat;
			min-height:100vh;
			overflow: hidden;
		}
		@media print{
			.noprint{
				display:none;
			}
		}		
		.main {
		  padding: 20px;
		}
		@media (min-width: 768px) {
		  .main {
			padding-right: 40px;
			padding-left: 40px;
		  }
		}
		.main .page-header {
		  margin-top: 0;
		}
		@media (max-width: 768px) {
			body {
			  padding-bottom: 140px;
			}
			.form-inline{
				width: 100%;
			}	
		}
		.pilihpoli2{
			background:#b5f3ff !important;
		}
		.clickpoli,.pilihpoli{
			cursor:pointer
		}
		.poliradio{
			visibility:hidden;
		}
		.header{
			background: transparent;width: 75vw;
			padding: 1vw;
			margin: auto;
			height: 7vw;
		}
		.header img{
			float:left;width: 5.5vw;margin-top:-0.5vw;
		}
		.header h2{
			color:#fff;font-size: 1.2vw;font-weight: bold;margin-left: 1vw;margin-top: 1.2vw;float:left;
		}
		.header a{
			color:#fff;font-size: 2.5vw;margin-top:1vw;margin-right:1vw;float:right;
		}
		.container-fluid{
			min-height:60vh;
			background: #fff;
			background-image: url('image/vektorpuskesmas.jpg');
			background-size: 100% 60%;
			background-position: bottom;
			background-repeat: no-repeat;
			width: 75vw;
			margin: auto;
			border-radius: 17px;
			box-shadow: 0px 0px 15px #545454;
			padding:2vw;
			font-size: 1.2vw;
		}
		.foots{
			text-align:center;padding:1vw;color: #fff;font-size:1vw;
		}
		.formnik{
			display: flex;justify-content: space-between;
		}
		.formnik input{
			border-radius: 10px;width:43vw !important;
			box-shadow: 0px 0px 12px #ccc;font-size: 1.2vw;height:3.3vw;
		}
		.formnik button{
			width:6vw;font-size: 1.2vw;padding:0.3vw;
		}
		.forminputs{
			border-radius: 10px;height:50px;font-size:17px
		}
		.btns{
			font-size: 1.4vw;font-weight: 400;padding:0.6vw;
		}
		.kolomkonten{
			background: #fff;padding:25px 25px;margin: auto;width: 50vw;border-radius: 12px;
			margin:auto;border: 1px solid #ccc;margin-top: 20px;margin-bottom: 10px;box-shadow: 0px 0px 12px #ccc;
		}
		.kolomkonten h3{
			font-size: 1.6vw;padding:0vw 0.7vw;
		}
		.kolomkonten2{
			width: 50vw;margin:auto;
		}	
		.kolomkonten3{
			width: 50vw;margin:auto;display: flex;flex-wrap: wrap;
			justify-content: flex-start;margin-bottom: 10px;
		}
		.kolomkonten3 label{
			background: #fff;padding:0.5vw 0.3vw; border-radius: 15px;text-align: center;box-shadow: 0px 0px 10px #bcbcbc;margin: 6px;font-size:1vw; font-weight: normal;
			width: 9vw;
		}
		.kolomkonten3 label input{
			visibility: hidden;margin:0px;width: 5px;margin-left: -5px;
		}
		.kolomkonten3 label img{
			width: 3.5vw;display:block;margin:auto;
		}	
		.kolomkonten3 label.active{
			background: #faffb7;
		}
		.table{
			margin-bottom: 0px
		}
		.table tbody tr td{
			padding:0.6vw;
		}	
		.dark tr th{
			background: #545454;color: #fff;
		}
		@media (max-width: 576px) {
			.header{
				width: 85vw;
				padding: 2vh 2vw;
				height: 110px;
			}
			.header img{
				width: 10vw;margin-top:0.5vw;margin-right: 1.5vw
			}
			.pentolajudan{
				width: 30vw !important;padding-top: 2vw
			}
			.backmenu{
				margin-top: 3vw !important;
			}
			.header h2{
				font-size: 2.2vw;margin-top: 4.2vw
			}
			.header a{
				font-size: 5.5vw;margin-top: 4.7vw;margin-right:0.5vw
			}
			.container-fluid{
				min-height:400px;
				width: 85vw;
				padding:20px 10px;
				font-size: 1.2vw;
				border-radius: 1.5vw;
				background-size: 100% 130px;
			}
			.kolomkonten{
				width: 75vw;padding:10px;
			}
			.kolomkonten2{
				width: 75vw;
			}
			.kolomkonten3{
				width: 75vw;
			}
			.table{
				font-size: 3.2vw
			}
			.table tbody tr td,.table thead tr th{
				padding: 2vw;font-size: 3.2vw
			}
			.formnik{
				flex-direction: column;
			}
			.formnik input{
				width:75vw !important;font-size: 3.5vw;border-radius: 1.7vw;height:43px;margin-bottom: 1vh;
			}
			.formnik button{
				width:75vw;font-size: 3.5vw;border-radius: 1.7vw;height:40px;padding:2vw;
			}
			.btns{
				font-size: 3.5vw;font-weight: 400;padding:2vw;height: 40px
			}
			.kolomkonten h3{
				font-size: 3.6vw;padding:0vw 0.7vw;
			}
			.kolomkonten3 label{
				background: #fff;padding:0.7vh 1vw;font-size:2.8vw; width: 20vw;border-radius: 2vw
			}
			.kolomkonten3 label input{
				visibility: hidden;margin:0px;width: 5px;margin-left: -5px;
			}
			.kolomkonten3 label img{
				width: 12vw;display:block;margin:auto;
			}
			.foots{
				padding:3vw;font-size:12px;margin-top: 10px
			}
		}
	</style>
		
</head>

<body>
	<div class="header noprint">
		<img src="../image/bandungkab.png">
		<h2>DINAS KESEHATAN <br/>KABUPATEN BANDUNG</h2>
		<img src="../image/pentolajudan.png" class="pentolajudan" style="width: 16vw; margin: 0.5vw 2vw;">
		<a href="?page=dashboard" class="backmenu"><i class='fa fa-arrow-circle-left'></i></a>
	</div><br/>
	<div class="container-fluid">
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
	<div class="foots">
		<?php 
			echo date('Y')." - Pendaftaran Online Puskesmas";
			
		?>
	</div>
</body>
<script src="../assets/js/jquery.js"></script>
	<script src="../assets/bootstrapdatepicker/js/bootstrap-datepicker.min.js"></script><!--ini js bootstrapdatepicker-->
    <script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/jquery.autocomplete.js"></script>
    <script type="text/javascript">
		$(document).ready(function() {
			$('.namakota').autocomplete({
				serviceUrl: 'get_kota.php',
				onSelect: function (suggestion) {
					$(this).val(suggestion.value);
					$(".kota").val(suggestion.kota);
				}
			});
			$('.puskesmas').autocomplete({
				serviceUrl: 'get_puskesmas.php',
				onSelect: function (suggestion) {
					$(this).val(suggestion.value);
					//$(this).parent().parent().find(".kodepuskesmas").val(suggestion.kodepuskesmas);
					//document.location.href='?page=cari&kode='+suggestion.kodepuskesmas+'&simpus='+suggestion.value;
				}
			});
			
			$(".tesdate").click(function(){
				$(this).parent().find(".datepicker").datepicker("show");
			});
			
			$('.datepicker').datepicker({
				format: 'dd-mm-yyyy',
			});

			
			
			$(".tglreg").change(function(){
				var tgl =$(this).val();
				var lokasinoreg = $(this).parent().parent().parent().parent().find(".noreg");
				var noreg = lokasinoreg.val();
				
				$.post( "get_noreg.php", { tgl: tgl, noreg: noreg })
				  .done(function( data ) {
					 lokasinoreg.val( data );
				});
			});
			
			$('#myModalxxx').modal('show');
			
			$(".lanjutkan").click(function(){
				var nik = $(this).parent().find(".nik").html();
				if(nik != '')
				{
				  window.location = $(this).attr("href");
				}else{
					alert("Silahkan masukan nik atau no Bpjs");
				}
				return false;
			});
			

			$(".clickpoli").click(function(){
				
				var target = $(this).find(".panel-heading");
				var targetremove = $(this).parent().parent().find('.pilihpoli2');
				
				targetremove.removeClass("pilihpoli2");
				target.addClass("pilihpoli2");
				$(this).find(".poliradio").prop("checked", true);
				
				var isi = $(this).find(".poliradio").val();
				
				$.post( "get_tarif.php", { jenis: isi })
				  .done(function( data ) {
					// alert(data);
					$( ".tarif" ).val( data );
				});
			});
		});
	</script>			
</html>