<?php
date_default_timezone_set('Asia/Jakarta');
//session_start();
include "../config/koneksi.php";
include "../config/helper.php";
$kodepuskesmas = $_COOKIE['kodepuskesmas2'];
$tbantrian_pasien = "tbantrian_pasien_".$kodepuskesmas;
$tbpasien_online = "tbpasienonline_".$kodepuskesmas;
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
		html{
			height: 100%;
		}
		body{
			height: 100%;
			padding: 0;
			font-family: 'Fjalla One', sans-serif;
			background: rgb(57,143,138);
			background: linear-gradient(90deg, rgba(57,143,138,1) 0%, rgba(69,190,112,1) 50%, rgba(150,221,167,1) 100%);
		}
		
		.header{
			background: rgb(29,87,86);
			background: linear-gradient(90deg, rgba(29,87,86,1) 0%, rgba(49,145,83,1) 50%, rgba(91,187,114,1) 100%);
			color:#fff;
			padding:5px 0px;
			text-align: center;
			box-shadow: 0px 0px 12px #111;
			height: 22%;
		}
		.header h1{
			font-family: 'Fjalla One', sans-serif;
			margin-top:0px;
			margin-bottom:0px;
			font-size:2.8vw;
		}
		.header h3{
			font-family: 'Fjalla One', sans-serif;
			margin-bottom:0px;
			font-size:1.8vw;
		}
		.header h4{
			font-family: 'Fjalla One', sans-serif;
			margin-bottom:10px;
			margin-top:0px;
			font-size:1.3vw;
		}
		.logopuskesmas{
			position:absolute;
			top:10px;
			right:40px;
			width:8%;
		}
		.logokabbandung{
			position:absolute;
			top:5px;
			left:40px;
			width:8%;
		}

		.kotakbesar{
			padding:1vw;
			text-align:center;
			height:70%;
			width: 100vw;
			float:left;
			margin-bottom: 3.5vw;
		}		
	
		.tbjudul{
			width: 100%;
			height: 100%;
		}
		
		.tbjudul td{
			font-size: 2.5vw;
			font-weight: bold;
			padding: 0.3vw;
		}

		.listpoli{
			display: block;
			padding: 0.4vw;
			border-radius: 0.4vw;
			background: #287755;
			color: #fff;
		}
		.listpolipendaftaran{
			display: block;
			padding: 0.4vw;			
			border-radius: 0.4vw;
			background: #deefee;
		}
		
		.carousel-inner>.item>img, .carousel-inner>.item>a>img {
			height:100%;
		}
		.antrianutama{
			font-weight:bold;
			background:white;
			height:100%;
		}
		.antrianutama h2{
			font-weight:bold;
			background:#287854;
			color:#fff;
			padding:1.2vw;
			margin-top: 0;
			margin-bottom:2.5vw;
			font-size: 1.5vw;
		}
		.textbar{
			width: 100%;
			position:fixed;
			left:0px;
			bottom:0px;
			background-color: rgba(255, 255, 255, 0.6);
			color:#000;
			height: 3.5vw;
		}
		marquee{
			font-size: 2vw;
		}
		.jams{
			background: Black;
			width: 14vw;
			height: 3.5vw;
			padding: 0.3vw;
			color: #fff;
			font-size: 2vw;
			text-align: center;
			position: absolute;
			left: 0px;
			bottom: 0px;
			z-index: 1000;
		}
		
		.slide{
			margin : 5px 0px; height: auto;
		}

	
	</style>
</head>

<body>
	<?php
		$datasetting = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbantrian_setting where KodePuskesmas = '$kodepuskesmas'"));
		$data_antrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbantrian_view_jkn where KodePuskesmas = '$kodepuskesmas'"));
		$displayutama = explode("|",$data_antrian['DisplayUtama']);
	?>

			<div class="header">
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
				<h3>ANTRIAN MOBILE JKN</h3>
				<h1>UPT PUSKESMAS <?php echo $puskesmas;?></h1>
				<h4><?php echo $alamat;?></h4>
			</div>
			<div class="kotakbesar">
			<div class="row" style="padding: 20px;margin-top:20px">
				<div class="col-sm-7">
					<table class="table table-bordered" style="background: #fff;">	
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Pasien</th>
								<th>Poli</th>														
							</tr>	
						</thead>
						<tbody>											
						<?php
						$antrianpelayanan = mysqli_query($koneksi,"select  a.`NomorAntrianPoli`, a.`PoliPertama`, b.`NamaPasien` from `$tbantrian_pasien` a JOIN `$tbpasien_online` b ON a.IdPasienOnline = b.IdPasienOnline WHERE date(a.WaktuAntrian) = curdate() AND a.`StatusAntrian` = 'Selesai' AND a.`StatusBpjs` = 'Proses' order by a.NomorAntrian");
						while($dt = mysqli_fetch_assoc($antrianpelayanan)){
							$cekkodepoli = mysqli_query($koneksi,"SELECT KodePelayanan, Jumlah FROM `tbantrian_pelayanan` WHERE KodePuskesmas = '$kodepuskesmas' AND  Pelayanan = '$dt[PoliPertama]'");
								if(mysqli_num_rows($cekkodepoli) == 0){
									$kdpoli = '';
								}else{
									$dtkodepoli = mysqli_fetch_assoc($cekkodepoli);
									$kdpoli = $dtkodepoli['KodePelayanan'];
								}
							?>
								<tr>
									<td><?php echo $kdpoli.$dt['NomorAntrianPoli'];?></td>
									<td><?php echo $dt['NamaPasien'];?></td>
									<td><?php echo $dt['PoliPertama'];?></td>								
								</tr>
						<?php						
						}	
						?>	
						</tbody>
					</table>	
				</div>
				<div class="col-sm-5">
					<table class="table table-bordered" style="background: #fff;">	
						<thead>
							<tr>
								<th>Selesai</th>													
							</tr>	
						</thead>
						<tbody>											
						<?php
						$antrianpelayanan = mysqli_query($koneksi,"select  a.`NomorAntrianPoli`, a.`PoliPertama`, b.`NamaPasien` from `$tbantrian_pasien` a JOIN `$tbpasien_online` b ON a.IdPasienOnline = b.IdPasienOnline WHERE date(a.WaktuAntrian) = curdate() AND a.`StatusAntrian` = 'Selesai' AND a.`StatusBpjs` = 'Selesai' order by a.NomorAntrian");
						while($dt = mysqli_fetch_assoc($antrianpelayanan)){
							$cekkodepoli = mysqli_query($koneksi,"SELECT KodePelayanan, Jumlah FROM `tbantrian_pelayanan` WHERE KodePuskesmas = '$kodepuskesmas' AND  Pelayanan = '$dt[PoliPertama]'");
								if(mysqli_num_rows($cekkodepoli) == 0){
									$kdpoli = '';
								}else{
									$dtkodepoli = mysqli_fetch_assoc($cekkodepoli);
									$kdpoli = $dtkodepoli['KodePelayanan'];
								}
							?>
								<tr>
									<td><?php echo $kdpoli.$dt['NomorAntrianPoli'];?> - 
									<?php echo $dt['NamaPasien'];?></td>								
								</tr>
						<?php						
						}	
						?>	
						</tbody>
					</table>
				</div>
			</div>
			</div>

			<div class="textbar">
				<div class="jams"><?php echo date('G:i:s');?></div><marquee behavior="scroll" direction="left"><?php echo $datasetting['RunningText'];?></marquee>
			</div>	

 </body>
 
 <!-- Bootstrap core JavaScript
    ==================================================-->
	<script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/jquery.autocomplete.js"></script>
	
	<script src='https://code.responsivevoice.org/responsivevoice.js'></script>
	<?php if($data_antrian['DisplayUtama'] != ''){?>
	<script>
		// plays('Suara/sound.wav');
				
		// setTimeout(function(){ 
		// 	responsiveVoice.speak("Nomor Antrian <?php echo str_replace(" - ", " ", $displayutama[0]);?> Ke <?php echo $displayutama[1];?>","Indonesian Female", {rate: 0.7});
		// }, 3000);

		// function plays(audiofiles){
		// 	var audioElement = document.createElement('audio');
		// 	audioElement.setAttribute('src', audiofiles);
		
		// 	audioElement.play();
		// }

	</script>	
		<?php
		if ($kota == 'KABUPATEN BANDUNG'){
			$noantrians = explode(" - ",$displayutama[0]);
			$noantrian_angka = explode(" ",terbilang($noantrians[1]));
			$lokets = explode(" ",$displayutama[1]);
			$loket_arr_terbilang = explode(" ",terbilang($lokets[1]));
			
			$array_suara[] = "'Suara/sound.wav'";
			$array_suara[] = "'Suara/Nomor_Antrian.wav'";
			$array_suara[] = "'Suara/".$noantrians[0].".wav'";//untuk A,B,C antrian
			foreach($noantrian_angka as $ars){
				$array_suara[] ="'Suara/".strtolower($ars).".wav'";
			}							
			$array_suara[] = "'Suara/dipersilahkan.wav'";
			foreach($loket_arr_terbilang as $ar){
				$array_suara[] ="'Suara/".strtolower($ar).".wav'";
			}
			$array_suara_implode = implode(", ",$array_suara);
		}else{
			//suara dengan rekaman manual
			$noantrians = explode(" - ",$displayutama[0]);
			$noantrian_angka = explode(" ",terbilang($noantrians[1]));
			$lokets = explode(" ",$displayutama[1]);
			$loket_arr_terbilang = explode(" ",terbilang($lokets[1]));
			
			$array_suara[] = "'http://127.0.0.1:8887/sound.wav'";
			$array_suara[] = "'http://127.0.0.1:8887/Nomor_Antrian.wav'";
			$array_suara[] = "'http://127.0.0.1:8887/".$noantrians[0].".wav'";//untuk A,B,C antrian
			foreach($noantrian_angka as $ars){
				$array_suara[] ="'http://127.0.0.1:8887/".$ars.".wav'";
			}							
			$array_suara[] = "'http://127.0.0.1:8887/dipersilahkan.wav'";
			foreach($loket_arr_terbilang as $ar){
				$array_suara[] ="'http://127.0.0.1:8887/".$ar.".wav'";
			}
			$array_suara_implode = implode(", ",$array_suara);
		}
		?>
		<script type="text/javascript">
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
		</script>


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
		// ini pakai sse
		// if(window.EventSource){
			// var source = new EventSource("cek_view_antrian.php?dispu=<?php echo strtotime($data_antrian['Waktu']);?>");
			// source.onmessage = function(event){
				// console.log(event.data);	
				// alert(event.data); dikomen aja
				// if(event.data == "1"){
					// window.document.location.reload(true);
				// }
				
			// };
		// } else {
			// alert("Maaf, browser anda tidak suport server-sent events...");
		// }
		
		// ini pakai interval
		$.get( "cek_view_antrian_jkn.php?dispu=<?php echo $data_antrian['Waktu'];?>").done(function( data ) {
			
			if(data == 0){
				setInterval(function(){
					$.get( "cek_view_antrian_jkn.php?dispu=<?php echo $data_antrian['Waktu'];?>").done(function( data ) {
						
						if(data == 1){
							
							window.location.reload(true);
							
						}
					});
				}, 3000);
			}
		});
		
		
	</script>
</html>
<?php
}
}
?>