<?php
	session_start();
	error_reporting(0);
	include "../config/koneksi.php";
	include "../config/helper.php";
	$kodepuskesmas = $_COOKIE['kodepuskesmas2'];
	$puskesmas = $_COOKIE['namapuskesmas2'];
	$kota = $_COOKIE['kota2'];
	$alamat = $_COOKIE['alamat2'];
	date_default_timezone_set('Asia/Jakarta');

	if($kodepuskesmas == null){
		header("location:loginpage.php");
		die();
	}
	//echo var_dump($kodepuskesmas);
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
    <link rel="icon" href="../image/pkmonlineicon.png" type="image/png" sizes="16x16">
    <title>pkmonline</title>

	 <!-- Bootstrap core CSS -->
    <link href="../assets/bootstrap-dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="../assets/css/jquery.autocomplete.css" rel="stylesheet">
	<!--<link href="https://fonts.googleapis.com/css?family=Big+Shoulders+Text|Ubuntu|Roboto+Condensed|Russo+One" rel="stylesheet">-->
	<link href="https://fonts.googleapis.com/css2?family=Maven+Pro:wght@500;600&family=Raleway:ital,wght@0,500;0,700;1,900&display=swap" rel="stylesheet">

    <!-- Custom styles for this template -->

	<style>
		body {
			padding-top: 0px;
			font-family: 'Roboto Condensed', sans-serif;
			background: #c4eeff;
			height:60vw;
			overflow: hidden;
			color:#393b3f !important;
		}
		.judul{
			font-family: "Roboto Condensed", Arial, sans-serif;
		}
		.header{
			background: transparent;
			padding: 10px;
			display: block;
			text-align: left;
			margin-bottom: 60px;
			font-size: 16px;
			color: #393b3f;
		}
		.menudepan{
			text-align:center;
			margin-bottom:2vh;
		}
		.menudepan img{
			width:250px;
			height:150px;
		}
		
		.menudepan a:hover{
			text-decoration:none;
		}
				
		.sidebars{
			background:#fff;
			border:1px solid #ddd;
			border-radius:5px;
			box-shadow:0px 0px 8px #ccc;
			padding:10px;
			display:block;
			color:#393b3f;
			text-align:left;
			margin-bottom:20px;
		}
	
		.container {
			margin-top: 30px;
			width: 80vw;
		}
		.sidebars h4{
			border-bottom:1px double #ddd;
		}		
		.sidebars p{
			font-size:14px;
		}
		.navbar-default{
			background: #031e49; 
			border-color: #393b3f; 
			border-radius:0px;
		}
		.navbar-default .navbar-brand,.navbar-default .navbar-brand:hover{
			color:#393b3f;
		}
		.navbar-brand img{
			width:25px;
		}
		hr{
			border:0.3px solid #bfbfbf;
		}
		.mainmenu{
			padding:0px;
			//box-shadow:0px 0px 10px #afaeae;
			border-radius:8px;
		}
		.carousel-inner>.item>img, .carousel-inner>.item>a>img{
			border-radius:8px;
		}
		.input-group{
			margin-bottom:8px;
		}
		.divgaris{
			position:fixed;
			bottom:0px;
			width:100%;
			border-bottom:4px solid transparent;
		}
		.imgfooter{
			background-image: url('../image/bg_header.png');
			width:100%;
			height:7px;
			position:absolute;
			top:50px;
		}
		.headinglogin{
			background:#3BAC9B;
			padding:10px 10px;
			color:#393b3f;
			text-align:center;
			border-radius:4px 4px 0px 0px;
			margin-top:-10px;
			margin-left:-10px;
			margin-right:-10px;
			margin-bottom:15px;
			font-family: Malgun Gothic;
			font-weight: bold;
			font-size: 16px;
		}		
		.pilihpoli2{
			background:#f7f7de !important;
		}
		.menubawah{
			background: #f5f5f5;
			border:1px solid #ddd;
			border-radius: 5px;
			padding:3px 8px 3px 8px;
			padding-top: 20px;
		}
		.alert{
			margin-top: 5px;
			margin-bottom: 5px
		}
		.alertmenu{
			background: #b9eac4;
		}
		.alertsubmenu{
			background: #bed8c4;
		}
		.clickpoli{
			display:block;
			color: #393b3f;		
			background: #fff;			
			box-shadow: 0 0 2rem rgba(130,128,128, 0.2)!important;
			text-align:left;
			/* height:16vh; */
			padding-top:2vh;
			border-radius: 0.4vw;margin:0.2vw 0vw;
		}
		.iconpoli{
			margin-left:2vh;margin-bottom:1vh;
		}
		.ketbawah{
			background:#79D2F6;color:#fff;padding:0.8vh;text-align:center;border-radius: 0 0 0.4vw 0.4vw;clear:both;margin-top:0.8vw;min-height:3.7vh
		}
		
		@media screen and (max-width: 442px) {
			.footer{
				margin-top:20px;
				position:relative;
			}
		}
		.btnmasuk{
			position:absolute;
			top:9px;
			right:10px;
			background:#f5f5f5;
			border:1px solid #ddd;
			padding:3px 15px;
			font-size:13px;
		}
		.btnmasuk:hover{
			text-decoration:none;
			background:yellow;
		}
		main{
			min-height:490px;
		}
		
		@media print{
			.noprint{
				display:none;
			}
		}
		.antrianshtml{
			background: transparent;
			padding: 1vw;
			margin-top: 1vw;
			margin-bottom: 1.3vw;
			min-height:30vw;
		}
		.logodinas{
			width:6vw;
			position:absolute;
			top:0vw;
			left:2vw;
		}
		.logopuskesmas{
			width:7.5vw;
			position:absolute;
			top:-0.4vw;
			right:2vw;
		}
		.btn{
			font-size: 1.6vw;
			padding: 0.8vw;
			
		}
		.btn_smal{
			font-size: 1vw;padding: 0.4vw;
		}

		.bgnavbar{
			background: #fff;border-radius: 0px;margin-bottom: 0px;
			box-shadow: 0px 8px 10px 0px rgba(91, 91, 91, 0.10);
		}
		.navbar-brand, .navbar-brand:hover, .navbar-brand:focus{
			font-size: 2.5vh;background:transparent;font-weight: bold;padding:2vh;
		}
		.navbar-brand img{
			height: 3.5vw;margin: 0px;margin-right: 0.3vw;width:auto;
		}
		.navbar-brand .text{
			padding-right: 1vw; padding-left: 0.5vw;color:#393b3f; 
		}
		.btnprimary, .btnprimary:hover{
			background:#347cd3;border-radius:35px;margin-top:20px;font-size:20px;color:#fff;padding:12px 35px;border:1px solid #347cd3;margin-right:20px;
			box-shadow: 0px 0px 12px 12px rgba(140, 182, 234, 0.2);
		}
		
		.btnoutlineprimary, .btnoutlineprimary:hover{
			background:#fff;border-radius:35px;margin-top:10px;font-size:20px;color:#347cd3;padding:12px 35px;border:1px solid #347cd3;margin-right:10px;
		}

		@media (orientation:landscape) {
			.btnoutlineprimary {
				display: block;
			}
		}

		@media (orientation:portrait) {
			.btnoutlineprimary {
				display: none;
			}
		}
	</style>
	<script src="../assets/js/qrcode.min.js?4"></script>
	<script src="../assets/js/JsBarcode.all.js"></script>
</head>

<body onafterprint="document.location = 'index.php?page=<?php echo $_GET['page'];?>'" onLoad="noBack();" onpageshow="if (event.persisted) noBack();" onUnload="">
	<main role="main">
		<nav class="navbar navbar-light bgnavbar">
		  <div class="container" style="width:90vw;margin-top:0px">
			<a class="navbar-brand" href="#">
				<table width="100%">
					<tr>
						<td>
							<?php if($kota == "KOTA TARAKAN"){?>
							<img src="../image/tarakan.png"/>
							<?php }elseif($kota == "KABUPATEN BANDUNG"){?>
							<img src="../image/bandungkabnew.jpg"/>
							<?php }elseif($kota == "SUKABUMI"){?>
							<img src="../image/sukabumi.png"/>
							<?php }?>
							<img src="../image/logo_puskesmas_noshadow.png"/>
						</td>
						<td class="text">
							<?php echo "PUSKESMAS ".$_COOKIE['namapuskesmas2'];?>
						</td>
					</tr>
				</table>
			</a>
			<div style="float:right">
				<a href="index.php?page=dashboard" class="btn btnoutlineprimary" type="button">KEMBALI</a>
				<!-- <a href="#" class="btn btnprimary btnprosess" type="button">PRINT</a> -->
			</div>
		  </div>
		</nav>
		<div class="container" style= "min-width: 90vw;">
		   	<div class="row">
				<div class="img-responsive center-block">
					<div class="col-sm-12" style="margin-top: 2vh;">
			
						<?php
						if($kodepuskesmas == null){
							$hal = "login.php";
						}else{
							$hal = "pilih_poli.php";
						}
						
						$page=$_GET['page'];
						$nama_file=$page.".php";
						$cek=strlen($page);
						
						if($cek>70 || empty($page)){
							include ($hal);
						}else if(!file_exists($nama_file)){
							include ("error.php");
						}else{
							include ($nama_file);
						}
						?>

					</div>
				</div>
			</div>
			<p class="noprint" style="font-size:1.2vw;text-align: center;color: #393b3f;font-weight: normal; text-transform: uppercase;"><?php echo date('Y');?> | Dinas Kesehatan <?php echo $_COOKIE['kota2'];?></p>
		</div>
	</main>
 </body>


<script type="text/javascript">
        window.history.forward();
        function noBack()
        {
            window.history.forward();
        }
</script>
 <!-- Bootstrap core JavaScript
    ==================================================-->
	<script src="../assets/js/jquery.js"></script>
    <script src="../assets/bootstrap-dist/js/bootstrap.min.js"></script>
	<script src="../assets/js/jquery.autocomplete.js"></script>
    <script type="text/javascript">
		$(document).ready(function() {
			$("#qrcode").find("img").css("display","relative");

			$(".clickpoli").click(function(){
				var target = $(this);
				var targetremove = $(this).parent().parent().find('.pilihpoli2');
				
				targetremove.removeClass("pilihpoli2");
				target.addClass("pilihpoli2");
			});
			$(".lanjutjaminan").click(function(){
				if(!$('.nomorjaminan').val()){
					alert('Silahkan masukan no jaminan');
				}
			});			
			$(".lanjut").click(function(){
				if(!$('.poliradio:checked').val()){
					alert('Silahkan pilih poli');
				}
			});
			
			$('.puskesmas').autocomplete({
				serviceUrl: '../get_puskesmas.php',
				onSelect: function (suggestion){
					$(this).val(suggestion.value);
					$(".kodepuskesmas").val(suggestion.kodepuskesmas);
					$(".puskesmas").val(puskesmas.kota);
				}
			});
		});	
		
		$(document).ready(function() {
			function plays(audiofiles,no){
				var playlist = audiofiles;
				var audioElement = document.createElement('audio');
				//audioElement.setAttribute('src', 'Suara/Nomor_Antrian_A.wav');
				audioElement.setAttribute('src', playlist[no]);
				audioElement.addEventListener('ended', function() {
					//audioElement.stop();
					if(no < (playlist.length - 1)){
						plays(playlist,no+1);
					}
				}, false);
				audioElement.play();
			}
			
			$('.playSound').click(function() {
				var playlist = new Array('Suara/sound.wav', 'Suara/Nomor_Antrian.wav', 'Suara/delapan.wav', 'Suara/puluh.wav', 'Suara/tiga.wav', 'Suara/dipersilahkan.wav', 'Suara/satu.wav');
				plays(playlist,0);
			});
		});
	</script>	  
</html>

