<?php
date_default_timezone_set('Asia/Jakarta');
//session_start();
include "../config/koneksi.php";
include "../config/helper.php";
$kodepuskesmas = $_COOKIE['kodepuskesmas2'];
$tbantrian_pasien = "tbantrian_pasien_".$kodepuskesmas;
$puskesmas = $_COOKIE['namapuskesmas2'];
$kota = $_COOKIE['kota2'];
$alamat = $_COOKIE['alamat2'];
$datasetting = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * from tbantrian_setting WHERE KodePuskesmas = '$kodepuskesmas'"));
if($datasetting['versi_antrian'] == 'versi2'){
	include "view_antrian_v2.php";
}else{

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
	<link href="https://fonts.googleapis.com/css?family=Big+Shoulders+Text|Ubuntu|Roboto+Condensed|Fjalla+One" rel="stylesheet">
    <!-- Custom styles for this template -->
	<style>
		body{
			font-family: 'Fjalla One', sans-serif;
			background: rgb(57,143,138);
			background: linear-gradient(90deg, rgba(57,143,138,1) 0%, rgba(69,190,112,1) 50%, rgba(150,221,167,1) 100%);
		}
		.kotakbesar{
			padding:10px 10px;
			text-align:center;
			font-size:43px;
			height:auto;
		}
		.antrianutama h2{
			font-weight:bold;
			background:#287854;
			color:#fff;
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
		.listpel{			
			padding:0px 15px;
		}
		.listpel p{
			background: #fff;
			color: green;
			padding:10px 10px;
			text-align: center;
			font-size: 40px;
			border-radius: 6px;
		}
		.listpoli{
			
			display: block;
			padding:2px 20px;
			border-radius: 8px;
			background: #287755;
			color: #fff;
		}

		.listpoliperiksa{
			min-height: 62px;
			display: block;
			padding:2px 20px;
			border-radius: 8px;
			background: #deefee;
		}
		.listpolipendaftaran{
			min-height: 62px;
			display: block;
			padding:2px 20px;
			border-radius: 8px;
			background: #deefee;
		}
		
		.tbjudul{
			width: 97%;
			margin-top: 5px;
			margin-bottom: 20px;
		}
		.tbjudul th{
			font-size: 30px;
			font-weight: bold;
			padding: 10px;
		}
		.tbjudul td{
			font-size: 40px;
			font-weight: bold;
			padding: 3px;
		}

		.kotak p{
			font-size:48px;
		}
		marquee{
			font-size: 30px;margin-top:5px;
		}
		.carousel-inner>.item>img, .carousel-inner>.item>a>img {
			height:450px;
		}
		.antrianutama{
			font-weight:bold;
			margin:auto;
			background:white;
			height: 450px;	
		}
		.jams{
			background: Black;
			width: 200px;
			padding: 3px;
			color: #fff;
			font-size: 33px;
			text-align: center;
			position: absolute;
			left: 0px;
			bottom: 0px;
			z-index: 1000;
		}
		.textbar{
			position:fixed;
			left:0px;
			bottom:0px;
			background-color: rgba(255, 255, 255, 0.6);
			padding:0px;
			color:#000;
		}
		.header{
			background: rgb(29,87,86);
			background: linear-gradient(90deg, rgba(29,87,86,1) 0%, rgba(49,145,83,1) 50%, rgba(91,187,114,1) 100%);
			color:#fff;
			padding:5px 0px;
			text-align: center;
			box-shadow: 0px 0px 12px #111;
		}
		.header h1{
			font-family: 'Fjalla One', sans-serif;
			margin-top:0px;
			margin-bottom:0px;
			font-size:38px;
		}
		.header h3{
			font-family: 'Fjalla One', sans-serif;
			margin-bottom:0px;
			font-size:24px;
		}
		.header h4{
			font-family: 'Fjalla One', sans-serif;
			margin-bottom:10px;
			margin-top:0px;
			font-size:16px;
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
			top:10px;
			right:40px;
			width:90px;
		}
		.logokabbandung{
			position:absolute;
			top:5px;
			left:40px;
			width:100px;
		}
	</style>
</head>

<body>
	<?php
		$datasetting = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbantrian_setting where KodePuskesmas = '$kodepuskesmas'"));
		$data_antrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbantrian_view1 where KodePuskesmas = '$kodepuskesmas'"));
		$displayutama = explode("|",$data_antrian['DisplayUtama']);

	?>
	<main role="main">	
	<div class="col-lg-12">
		<div class="row">
			<div class="col-lg-12">
				<div class="row header">
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
					<h3>DINAS KESEHATAN <?php echo $kota;?></h3>
					<h1>UPT PUSKESMAS <?php echo $puskesmas;?></h1>
					<h4><?php echo $alamat;?></h4>
				</div>
			</div>
			<div class="col-lg-6 kotakbesar">
				<div class="row">
					<div class="col-lg-12 slide">

						<?php if($displayutama[0] != ''){?>
						<div class="antrianutama">
							<h2>NOMOR ANTRIAN</h2>
							<p style="font-size:80px"><?php echo $displayutama[0];?></p>	
							<p style="font-size:80px"><?php echo strtoupper($displayutama[1]);?></p>	
						</div>
						<?php }else{?>

						<?php if($datasetting['StatusSlide'] == 'video'){?>
						<video width="100%" height="450px" loop="true" autoplay="autoplay" controls="controls" id="vid" style="margin-top:20px">
							<source src="video/<?php echo $datasetting['Video1'];?>" type="video/mp4">
						</video>
					
						<?php }else{?>
						<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner" role="listbox">
								<?php
									if($datasetting['Image1'] != ''){
								?>
								<div class="item active">
									<img src="image/<?php echo $datasetting['Image1'];?>" alt="Antrian Online 1" width="100%">
								</div>
								<?php
									}else{
								?>
									<div class="item active">
										<img src="image/addimage.jpg" alt="Antrian Online 2" width="100%">
									</div>
								<?php
									}
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
					<?php }?>
					</div>
					<!--<div class="col-lg-12 footer">
						<span style="font-size: 36px; font-weight: bold;"><?php echo hari_ini().", ".tgl_lengkap(date('Y-m-d'));?></span>
					</div>-->
				</div>
			</div>
			<div class="col-lg-6">
				<div class="row" style="">
					<table class="tbjudul">
						<tr>
							<th width="50%" style="text-align: center" colspan="2">PELAYANAN</th>
							<th width="25%" style="text-align: center">R.DAFTAR</th>
							<th width="25%" style="text-align: center">R.PERIKSA</th>
						</tr>
						<?php
						$hariini = date('Y-m-d');
						$antrianpelayanan = mysqli_query($koneksi,"SELECT * FROM tbantrian_pelayanan WHERE KodePuskesmas = '$kodepuskesmas' order by KodePelayanan");
						while($dt = mysqli_fetch_assoc($antrianpelayanan)){
							$jumlah = mysqli_num_rows(mysqli_query($koneksi,"SELECT NomorAntrian FROM $tbantrian_pasien WHERE KodePuskesmas = '$kodepuskesmas' and PoliPertama = '$dt[Pelayanan]' and (StatusAntrian = 'Selesai' OR StatusAntrian = 'Pending') AND `WaktuAntrian` like '%$hariini%'"));

							if($dt['Pelayanan'] != 'IMUNISASI' AND $dt['Pelayanan'] != 'PROLANIS'){
							$clspoli = str_replace(" ", "_", $dt['Pelayanan']);
							?>
							
						
									<tr>
										<td width="10%" style="padding-left: 20px"><span style="color: yellow;"><?php echo $dt['KodePelayanan'];?></span></td>
										<td width="40%"><span class="listpoli"><?php echo $dt['Pelayanan'];?></span></td>
										<td align="center" width="20%"><span class="listpolipendaftaran"><?php echo $jumlah;?></span></td>
										<td align="center" width="20%">
											<input type="hidden" class="wkt<?php echo $clspoli;?>" value="<?php echo $dt['Waktu'];?>"/>
											<span class="listpoliperiksa <?php echo $clspoli;?>"><?php echo $dt['Display'];?></span>
										</td>
									</tr>
							
						<?php
							}
						}	
						?>	
					</table>					
				</div>
			</div>
			
		</div>
	</div>
	<div class="col-lg-12 textbar">
		<div class="jams"><?php echo date('G:i:s');?></div><marquee behavior="scroll" direction="left"><?php echo $datasetting['RunningText'];?></marquee>
	</div>
	</main>

 </body>
 
 <!-- Bootstrap core JavaScript
    ==================================================-->
	<script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/jquery.autocomplete.js"></script>
	
	<script src='https://code.responsivevoice.org/responsivevoice.js'></script>
	<?php if($data_antrian['DisplayUtama'] != ''){?>
	<script>
		plays('Suara/sound.wav');
				
		setTimeout(function(){ 
			responsiveVoice.speak("Nomor Antrian <?php echo str_replace(" - ", " ", $displayutama[0]);?> Ke <?php echo $displayutama[1];?>","Indonesian Female", {rate: 0.7});
		}, 3000);

		function plays(audiofiles){
			var audioElement = document.createElement('audio');
			audioElement.setAttribute('src', audiofiles);
		
			audioElement.play();
		}
	</script>	
		<?php
		//suara dengan rekaman manual
			// $noantrians = explode(" - ",$displayutama[0]);
			// $noantrian_angka = explode(" ",terbilang($noantrians[1]));
			// $lokets = explode(" ",$displayutama[1]);
			// $loket_arr_terbilang = explode(" ",terbilang($lokets[1]));
			
			// $array_suara[] = "'Suara/sound.wav'";
			// $array_suara[] = "'Suara/Nomor_Antrian.wav'";
			// $array_suara[] = "'Suara/".$noantrians[0].".wav'";//untuk A,B,C antrian
			// foreach($noantrian_angka as $ars){
				// $array_suara[] ="'Suara/".$ars.".wav'";
			// }							
			// $array_suara[] = "'Suara/dipersilahkan.wav'";
			// foreach($loket_arr_terbilang as $ar){
				// $array_suara[] ="'Suara/".$ar.".wav'";
			// }
			// $array_suara_implode = implode(", ",$array_suara);
		?>
		<!--<script type="text/javascript">
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
				var playlist = new Array(<?php //echo $array_suara_implode;?>);
				plays(playlist,0);
			});
		</script>-->
	<?php }?>

	<script>
		function playsuara(audiofiles){
			var audioElement = document.createElement('audio');
			audioElement.setAttribute('src', audiofiles);
		
			audioElement.play();
		}
		setInterval(function(){
			$.get( "view_antrian.php?sts=jam").done(function( data ) {
				$(".jams").html(data);
			});
		}, 1000);

		
		$('.carousel').carousel({
		  interval: 10000
		})
	</script>
	<script>
		if(typeof(EventSource) !== "undefined") {

		// var sourcejam = new EventSource("get_jam.php");
		//   sourcejam.onmessage = function(event) {
		// 	 $(".jams").html(event.data);
		// 	console.log(event.data);
		//   };	

			//Pendaftaran
		  var source = new EventSource("cek_view_antrian.php?dispu=<?php echo $data_antrian['Waktu'];?>");
		  source.onmessage = function(event) {
			  if(event.data == 1){
				  window.location.reload(true);
			  }	
			console.log(event.data);
			
		  };

		  //pemeriksaan
		  var source2 = new EventSource("cek_view_antrian_poli.php?time=<?php echo date('Y-m-d G:i:s');?>");
		  source2.onmessage = function(event) {
		  	var dt = JSON.parse(event.data);
		  	
			jQuery.each(dt, function(i, val) {
		  		var is = $("." + i).text();
		  		var wkt = $(".wkt"+i).val();
		  		var split = val.split("|");
		  		
		  		//console.log(val);
		  	
		  		//if(is != split[0]){
		  	if(wkt != split[1]){	
		  		$(".wkt" + i).val(split[1]);//set waktu di inputan	
				$("." + i).text(split[0]);// set display
				if(split[0] != ''){	
				var poli = i.replace("_", " ");
				playsuara('Suara/sound.wav');

				setTimeout(function(){ 
					responsiveVoice.speak("Nomor Antrian "+split[0]+" Ke RUANG "+poli,"Indonesian Female", {rate: 0.7});
				}, 2000);
				
				}
			}
				
				
			});
		
		  	//console.log(dt.PoliGigi);
			//console.log(event.data);
		  };
		} else {
		  document.getElementById("result").innerHTML = "Maaf, browser anda tidak suport server-sent events...";
		}
	</script>
</html>
<?php
}
}
?>