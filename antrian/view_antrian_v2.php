<?php
if($_GET['sts'] == 'jam'){
	echo date('G:i:s');
}else{
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
	<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <!-- Custom styles for this template -->
	<style>
		body{
			font-family:'Ubuntu', sans-serif;
		}
		.kotakbesar{
			// border:1px solid #Ddd;
			padding:0px;
			text-align:center;
			font-size:43px;
			height:auto;
		}
		.antrianutama h2{
			font-weight:bold;
			background:#abecfc;
			margin-top:0px;
			padding:20px;
			margin-bottom:70px;
		}
		.kotak{
			background:#D7EFFC;
			padding:20px;
			text-align:center;
			height:180px;
			
		}	
		.tablekotak{
			font-family:'Ubuntu', sans-serif;
			width:100%;
			height:700px;
		}
		.tablekotak td{
			font-size:60px;
			font-weight:bold;
			background:#B3ECFD;
			padding-left:40px;
		}
		.tablekotak td:first-child{
			border-radius:40px 0px 0px 40px;
		}
		.tablekotak td:last-child{
			border-radius:0px 40px 40px 0px;
		}
		.tablekotak tr{
			border:10px solid #fff;
		}

		.kotak p{
			font-size:48px;
			font-weight:bold;
		}
		marquee{
			font-size:35px;
		}
		.carousel-inner>.item>img, .carousel-inner>.item>a>img {
			height:635px;
		}
		.antrianutama{
			font-weight:bold;
			position:fixed;
			top:70px;
			left:0px;
			right:0px;
			margin:auto;
			background:white;
			width:550px;
			height:450px;
			border:1px solid #ddd;
			box-shadow:0px 0px 10px #000;
			z-index:3;
		}
		.jams{
			background:Black;
			width:200px;
			padding:8.5px;
			color:white;
			font-size:35px;
			text-align:center;
			position:absolute;
			left:0px;
			bottom:0px;
			z-index:1000;
		}
		.textbar{
			font-weight:bold;
			/*position:absolute;*/
			position:fixed;
			left:0px;
			bottom:0px;
			background:#abecfc;
			padding:6px;
		}
		.header h3{
			font-family:'Ubuntu', sans-serif;
			font-weight:bold;
			margin-bottom:0px;
			font-size:23px;
		}
		.header h1{
			font-family:'Ubuntu', sans-serif;
			font-weight:bold;
			margin-top:0px;
			margin-bottom:0px;
			font-size:32px;
		}
		.header h4{
			font-family:'Ubuntu', sans-serif;
			margin-bottom:10px;
			margin-top:0px;
			font-size:15px;
		}
		.slide{
			margin : 5px 0px;
		}
		.footer h3{
			font-weight:bold;
			padding-top:0px;
			font-size:45px;
			text-transform: uppercase;
		}
		.logopuskesmas{
			position:absolute;
			top:25px;
			right:40px;
			width:90px;
		}
		.logokabbandung{
			position:absolute;
			top:25px;
			left:40px;
			width:110px;
		}
	</style>
</head>

<body>
	<?php
		$datasetting = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbantrian_setting where KodePuskesmas = '$kodepuskesmas'"));
		$data_antrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbantrian_view where KodePuskesmas = '$kodepuskesmas'"));
		$displayutama = explode("|",$data_antrian['DisplayUtama']);
	?>
	<main role="main">	
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-7 kotakbesar">
				<div class="row">
					<div class="col-lg-12 header">
						<?php 
							if ($kota == 'KABUPATEN BANDUNG'){
						?>
							<img src="../image/bandungkab.png" class="logokabbandung">
						<?php
							}else{	
						?>
							<img src="../image/bandung.png" class="logokabbandung">
						<?php	
							}
						?>
						<img src="../image/logo_puskesmas.png" class="logopuskesmas">
						<h3>
						PEMERINTAH <?php echo $kota;?><br/>
						DINAS KESEHATAN
						</h3>
						<h1>PUSKESMAS <?php echo $puskesmas;?></h1>
						<h4><?php echo $alamat;?> .v2</h4>
					</div>
					<div class="col-lg-12 slide">
						<?php if($datasetting['StatusSlide'] == 'video'){?>
						<video width="100%" height="450px" loop="true" autoplay="autoplay" controls="controls" id="vid" style="margin-top:20px">
							<source src="video/<?php echo $datasetting['Video1'];?>" type="video/mp4">
						</video>
					
						<?php }else{?>
						<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner" role="listbox">
								<div class="item active">
									<img src="image/<?php echo $datasetting['Image1'];?>" alt="Antrian Online 1" width="100%">
								</div>
								<?php
									if($datasetting['Image2'] != ''){
								?>
								<div class="item">
									<img src="image/<?php echo $datasetting['Image2'];?>" alt="Antrian Online 2" width="100%">
								</div>
								<?php
									} 
									if($datasetting['Image3'] != ''){
								?>
								<div class="item">
									<img src="image/<?php echo $datasetting['Image3'];?>" alt="Antrian Online 3" width="100%">
								</div>
								<?php
									} 
									if($datasetting['Image4'] != ''){
								?>
								<div class="item">
									<img src="image/<?php echo $datasetting['Image4'];?>" alt="Antrian Online 4" width="100%">
								</div>
								<?php
									} 
									if($datasetting['Image5'] != ''){
								?>
								<div class="item">
									<img src="image/<?php echo $datasetting['Image5'];?>" alt="Antrian Online 5" width="100%">
								</div>
								<?php
									} 
									if($datasetting['Image6'] != ''){
								?>
								<div class="item">
									<img src="image/<?php echo $datasetting['Image6'];?>" alt="Antrian Online 6" width="100%">
								</div>
								<?php
									} 
									if($datasetting['Image7'] != ''){
								?>
								<div class="item">
									<img src="image/<?php echo $datasetting['Image7'];?>" alt="Antrian Online 7" width="100%">
								</div>
								<?php
									} 
									if($datasetting['Image8'] != ''){
								?>
								<div class="item">
									<img src="image/<?php echo $datasetting['Image8'];?>" alt="Antrian Online 8" width="100%">
								</div>
								<?php
									} 
									if($datasetting['Image9'] != ''){
								?>
								<div class="item">
									<img src="image/<?php echo $datasetting['Image9'];?>" alt="Antrian Online 9" width="100%">
								</div>
								<?php
									} 
									if($datasetting['Image10'] != ''){
								?>
								<div class="item">
									<img src="image/<?php echo $datasetting['Image10'];?>" alt="Antrian Online 10" width="100%">
								</div>
								<?php }?>
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
						<?php }?>
				
						<?php if($displayutama[0] != ''){?>
						<div class="antrianutama">
							<h2>NOMOR ANTRIAN</h2>
							<p style="font-size:80px"><?php echo $displayutama[0];?></p>	
							<p style="font-size:60px"><?php echo strtoupper($displayutama[1]);?></p>	
						</div>
						<?php }?>
					</div>
					<!--<div class="col-lg-12 footer">
						<span style="font-size: 36px; font-weight: bold;"><?php echo hari_ini().", ".tgl_lengkap(date('Y-m-d'));?></span>
					</div>-->
				</div>
			</div>
			<div class="col-lg-5">
				<div class="row">
					<table class="tablekotak" >
						<?php
						// for($loket = 1;$loket<=4;$loket++){
						
						// if($loket == 1){
							// $noantrianloket = $data_antrian['DisplaySatu'];
						// }else if($loket == 2){
							// $noantrianloket = $data_antrian['DisplayDua'];
						// }else if($loket == 3){
							// $noantrianloket = $data_antrian['DisplayTiga'];
						// }else if($loket == 4){
							// $noantrianloket = $data_antrian['DisplayEmpat'];
						// }
							// if($noantrianloket != ''){
							
							$data_antrianbpjs = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbantrian_pasienv2 where KodePuskesmas = '$kodepuskesmas' AND CaraBayar = 'BPJS' AND StatusAntrian = 'Selesai' order by WaktuAntrian DESC limit 1"));
							$data_antrianumum = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbantrian_pasienv2 where KodePuskesmas = '$kodepuskesmas' AND CaraBayar = 'UMUM' AND StatusAntrian = 'Selesai' order by WaktuAntrian DESC limit 1"));
							$noantrianloket_umum = $data_antrianumum['NomorAntrian'];
							$noantrianloket_bpjs = $data_antrianbpjs['NomorAntrian'];
						?>
							<tr>
								<td width="70%">UMUM <?php //echo $loket;?></td>
								<td align="center" width="30%"><?php echo $noantrianloket_umum;?></td>
							</tr>
							<tr>
								<td width="70%">BPJS <?php //echo $loket;?></td>
								<td align="center" width="30%"><?php echo $noantrianloket_bpjs;?></td>
							</tr>
						<?php
							// }
						// }
						?>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-12 textbar">
		<div class="jams"><?php echo date('G:i:s');?></div><marquee behavior="scroll" direction="left">SELAMAT DATANG DI PUSKESMAS <?php echo $puskesmas;?><?php echo ", ".hari_ini()." ".tgl_lengkap(date('Y-m-d'));?></marquee>
	</div>
	</main>

 </body>
 
 <!-- Bootstrap core JavaScript
    ==================================================-->
	<script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/jquery.autocomplete.js"></script>
	
	<!--<script src='https://code.responsivevoice.org/responsivevoice.js'></script>-->
	<?php if($data_antrian['DisplayUtama'] != ''){?>
	<script>
		//responsiveVoice.speak("Nomor Antrian <?php echo str_replace(" - ", "", $displayutama[0]);?> Ke <?php echo $displayutama[1];?>","Indonesian Female", {rate: 0.7});
		<?php
		
		$noantrian_angka = explode(" ",terbilang($displayutama[0]));

		$lokets = explode(" ",$displayutama[1]);
		$loket_arr_terbilang = explode(" ",terbilang($lokets[1]));
		
		$array_suara[] = "'Suara/sound.wav'";
		$array_suara[] = "'Suara/Nomor_Antrian.wav'";
		foreach($noantrian_angka as $ars){
			$array_suara[] ="'Suara/".$ars.".wav'";
		}							
		$array_suara[] = "'Suara/dipersilahkan.wav'";
		foreach($loket_arr_terbilang as $ar){
			$array_suara[] ="'Suara/".$ar.".wav'";
		}
		$array_suara_implode = implode(", ",$array_suara);
		?>
		function plays(audiofiles,no){
			var playlist = audiofiles;
			var audioElement = document.createElement('audio');
			audioElement.setAttribute('src', playlist[no]);
			audioElement.addEventListener('ended', function() {
				if(no < (playlist.length - 1)){
					plays(playlist,no+1);
				}
			}, false);
			audioElement.play();
		}
		
		window.addEventListener('load', function() {
			var playlist = new Array(<?php echo $array_suara_implode;?>);
			plays(playlist,0);
		});
		
		var i = 0;
		setInterval(function(){
			i = i + 1;
			console.log(i);			
			if(i < 3){							
				var playlist = new Array(<?php echo $array_suara_implode;?>);
				plays(playlist,0);
			}else{
				$.get( "view_antrian_update.php");
			}
		}, 20000);
		
	</script>
	<?php }?>
	<script>
		
		setInterval(function(){
			$.get( "view_antrian.php?sts=jam").done(function( data ) {
				$(".jams").html(data);
			});
		}, 1000);
		
		
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
		
		$('.carousel').carousel({
		  interval: 6000
		})
	</script>

</html>
<?php
}
?>