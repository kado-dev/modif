<?php
	//session_start();
	include "../config/koneksi.php";
	include "../config/helper.php";
	$kodepuskesmas = $_COOKIE['kodepuskesmas2'];
	$puskesmas = $_COOKIE['namapuskesmas2'];
	
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

    <!-- Custom styles for this template -->
	<style>

		.kotakbesar{
			// border:1px solid #Ddd;
			padding:0px;
			text-align:center;
			font-size:43px;
			height:auto;
		}
		.kotakbesar h2{
			background:#D7EFFC;
			margin-top:0px;
			padding:20px;
		}
		.kotak{
			// border:1px solid #Ddd;
			background:#D7EFFC;
			padding:20px;
			text-align:center;
			height:120px;
		}	
		.kotak span{
			font-size:20px;
		}
		.kotak p{
			font-size:32px;
			font-weight:bold;
		}
		marquee{
			font-size:20px;
		}
		.carousel-inner>.item>img, .carousel-inner>.item>a>img {
			height:600px;
		}
	</style>
</head>

<body>
	<?php
		$data_antrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * from tbantrian_view where KodePuskesmas = '$kodepuskesmas'"));
		$displayutama = explode("|",$data_antrian['DisplayUtama']);
	?>
	<main role="main">	
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-8 kotakbesar">
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
						<li data-target="#carousel-example-generic" data-slide-to="1"></li>
						<li data-target="#carousel-example-generic" data-slide-to="2"></li>
					</ol>
					<!-- Wrapper for slides -->
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<img src="sistemantrian.jpg" alt="puskesmas sabilulungan" width="100%">
						</div>
						<div class="item">
							<img src="sistemantrian.jpg" alt="puskesmas sabilulungan" width="100%">
						</div>
						<div class="item">
							<img src="sistemantrian.jpg" alt="puskesmas sabilulungan" width="100%">
						</div>
					</div>
					<!-- Controls -->
					<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>
			<div class="col-lg-4 kotakbesar">
				<h2>Nomor Antrian</h2>
				<p><?php echo $displayutama[0];?></p>	
				<p><?php echo strtoupper($displayutama[1]);?></p>	
			</div>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-3 kotak">
				<span>LOKET 1</span>
				<p><?php echo $data_antrian['DisplaySatu'];?></p>	
			</div>
			<div class="col-lg-3 kotak">
				<span>LOKET 2</span>
				<p><?php echo $data_antrian['DisplayDua'];?></p>	
			</div>
			<div class="col-lg-3 kotak">
				<span>LOKET 3</span>
				<p><?php echo $data_antrian['DisplayTiga'];?></p>	
			</div>
			<div class="col-lg-3 kotak">
				<span>LOKET 4</span>
				<p><?php echo $data_antrian['DisplayEmpat'];?></p>	
			</div>
			<div class="col-lg-12">
				<marquee behavior="scroll" direction="left">ANTRIAN PUSKESMAS <?php echo $puskesmas;?>, TANGGAL: <?php echo tgl_lengkap(date('Y-m-d'));?></marquee>
			</div>
		</div>
	</div>
	</main>
 </body>
 
 <!-- Bootstrap core JavaScript
    ==================================================-->
	<script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/jquery.autocomplete.js"></script>
	<script>
		$('.carousel').carousel({
		  interval: 3000
		})
		
		$.get( "cek_view_antrian.php?dispu=<?php echo $data_antrian['DisplayUtama'];?>").done(function( data ) {
			if(data == 0){
				setInterval(function(){
					$.get( "cek_view_antrian.php?dispu=<?php echo $data_antrian['DisplayUtama'];?>").done(function( data ) {
						if(data == 1){
							//alert(data);
							window.location.reload(true);
						}
					});
				}, 3000);
			}
		});
	</script>
</html>

