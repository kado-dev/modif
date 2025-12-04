<?php
error_reporting(0);
session_start();
include "../config/koneksi.php";
include "../config/helper.php";
$kodepuskesmas = $_COOKIE['kodepuskesmas2'];
$tbantrian_pasien = "tbantrian_pasien_".$kodepuskesmas;
$puskesmas = $_COOKIE['namapuskesmas2'];
$kota = $_COOKIE['kota2'];
$alamat = $_COOKIE['alamat2'];
$lantai = $_GET['lantai'];

if($kota == "KOTA TARAKAN"){
	date_default_timezone_set('Asia/Ujung_Pandang');
}else{
	date_default_timezone_set('Asia/Jakarta');
}

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
	<link href="https://fonts.googleapis.com/css?family=Big+Shoulders+Text|Ubuntu|Roboto+Condensed|Russo+One" rel="stylesheet">
    <!-- Custom styles for this template -->
	<style>
		html{
			height: 100%;
		}
		body{
			height: 100%;
			padding: 0vw;
			font-family: 'Russo One', sans-serif;
			// background: #5CB358;
			background: linear-gradient(0deg, rgba(4, 96, 0, 0.8), rgba(6, 127, 0, 1)), url('../assets_login/images/bgpanel.jpg');
			overflow: hidden;
			color:#131e19;
		}
		/** ------------------------------------------------------- **/
		.kotakheader{
			width: 100vw;
			padding:2vw 1vw 0.1vw 1vw;
			float:left;
			margin-top: -1.5vw;
		}
		.kotakheader h2{
			border-radius: 0.5vw;
			font-weight:bold;
			background:#aee8cd;
			color:#131e19;
			padding:0.8vw;
			font-size: 1.4vw;
			font-weight: bold;
			font-family: 'Russo One', sans-serif;
			margin:0px;
		}
		.kotakheader span{
			background: #fff;border-radius: 0.7vw;padding:0.4vw 1.22vw;font-size: 1.1vw;font-weight: bold;float:right;
			margin-top: -0.2vw;
		}
		/** ------------------------------------------------------- **/
		.kotakbesar{
			padding:1vw 1vw 1vw 1vw;
			text-align:center;
			height:33vh;
			width: 50vw;
			float:left;
		}	
		.antrianutama{
			background: #fff;
			border-radius: 0.5vw;
			font-weight:bold;
			height:33vh;
			width:48vw;
			float:left;
			padding:0.8vh;
			box-shadow: 0px 4px 5px 0px rgba(0,0,0,0.50);
		}
		.antrianutama h2{
			background: transparent;
			color:#131e19;
			padding:0.6vh;			
			font-size: 2.2vw;
			font-family: 'Russo One', sans-serif;
			margin:0px;
			border-radius: 3vw;
			margin: auto;
			width: 24%;
		}
		.antrianutama p{
			font-size:6vw;
			padding: 5vh 0vh;
			// background: #eaf200;
			border-radius: 0.5vw;
			max-height:24.5vh;
			box-shadow: 0px 4px 5px 0px rgba(0,0,0,0.20);
			background: linear-gradient(0deg, rgba(9, 119, 0, 0.8), rgba(252, 252, 6, 1)), url('../assets_login/images/bgpanel2.jpg');
			margin-top: 10px;
		}

		/** ------------------------------------------------------- **/
		.kotakbawahbesar{
			width: 50vw;
			float:left;	
			padding:1.5vw 1vw;
		}
		.kotakbawahbesar video{
			background: transparent;
			border-radius: 0.5vw;
			
		}
		.carousel-inner>.item>img, .carousel-inner>.item>a>img {
			height:53vh;
			width:100vw;
			border-radius: 0.5vw;
		}
		.slide{
			background: transparent;
			border-radius: 0.5vw;
			height: auto;
			box-shadow: 0px 4px 5px 0px rgba(0,0,0,0.50);
		}


		/** ------------------------------------------------------- **/
		.kotakkanan{
			padding:1vw 1vw 1vw 1vw;
			text-align:center;
			height:45vh;
			width: 50vw;
			float:right;			
		}		
		.listpoli{
			background: #fff;
			border-radius: 0.4vw;
			margin-bottom: 1.5vh;
			padding:0.35vw;
			box-shadow: 0px 4px 5px 0px rgba(0,0,0,0.50);
		}
		.listruang{
			background: transparent;
			text-align: center;
			font-size: 4vh;
			padding:0.2vw;
		}		
		.listruangantrian{
			text-align: center;
			color:#131e19;
			font-size: 4vh;
			border-radius: 0.4vw;
			padding:0.2vw;
			background: #0c7f00;
			color: #fff;
			box-shadow: 0px 4px 5px 0px rgba(0,0,0,0.20);
		}

		
		/** ------------------------------------------------------- **/
		.jams{
			width: 11vw;
			height: 3.5vw;
			padding: 0.3vw;
			color: #fff;
			font-size: 2vw;
			text-align: center;
			position: absolute;
			right: 0px;
			top: 6px;
			z-index: 1000;
			border-radius: 3vw;
			margin: auto;
			margin-right: 5px;
			width: 12%;
			background: red;
		}
		.bgnavbar{
			background: #fff;border-radius: 0px;margin-bottom: 0px;
			box-shadow: 0px 4px 5px 0px rgba(0,0,0,0.50);
		}
		.navbar-brand, .navbar-brand:hover, .navbar-brand:focus{
			color:#000;font-size: 2.5vh;background:#fff;font-weight: bold;padding:3px;
		}
		.navbar-brand img{
			height: 6.5vh;margin: 0px;margin-right: 0.3vw;
		}
		.navbar-brand .text{
			padding-right: 1vw; padding-left: 0.5vw;
		}
	
	</style>
</head>

<body>
	<?php
		$datasetting = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbantrian_setting where KodePuskesmas = '$kodepuskesmas'"));
		$data_antrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbantrian_view1 where KodePuskesmas = '$kodepuskesmas' AND Lantai = '$lantai'"));
		// $jmlantrian = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM $tbantrian_pasien where KodePuskesmas = '$kodepuskesmas' AND DATE(`WaktuAntrian`) = CURDATE()"));
		$displayutama = explode("|",$data_antrian['DisplayUtama']);
	?>
	<nav class="navbar navbar-light bgnavbar">
	  <div class="container-fluid">
		<a class="navbar-brand" href="#">
			<table>
				<tr>
					<td>
						<?php if($kota == "KOTA TARAKAN"){?>
						<img src="../image/tarakan.png"/>
						<?php }elseif($kota == "KABUPATEN BANDUNG"){?>
						<img src="../image/bandungkabnew.jpg"/>
						<?php }?>
						<img src="../image/logo_puskesmas_noshadow.png"/>
					</td>
					<td class="text">
						<?php echo "PUSKESMAS <br/>".$_COOKIE['namapuskesmas2'];?>
					</td>
				</tr>
			</table>
		</a>
		<div class="jams"><?php echo date('G:i:s');?>
	  </div>
	</nav>


	<?php
	$disangka = explode(" - ",$displayutama[0]);
	?>

	<!--<div class="kotakheader">
		<h2>ANTRIAN PENDAFTARAN <span><?php echo $jmlantrian;?></span></h2>
	</div>-->
	<div class="kotakbesar">
		<div class="antrianutama">
			<h2><?php echo strtoupper($displayutama[1]);?></h2>
			<p><?php echo $displayutama[0];?></p>	
		</div>
	</div>

	<div class="kotakkanan">	
		<div class="row">
			<?php
			$hariini = date('Y-m-d');
			$antrianpelayanan = mysqli_query($koneksi, "SELECT * FROM `tbantrian_pelayanan` WHERE KodePuskesmas = '$kodepuskesmas' ORDER BY KodePelayanan");
			while($dt = mysqli_fetch_assoc($antrianpelayanan)){
				$jumlah = mysqli_num_rows(mysqli_query($koneksi,"SELECT NomorAntrian FROM $tbantrian_pasien WHERE KodePuskesmas = '$kodepuskesmas' and PoliPertama = '$dt[Pelayanan]' and (StatusAntrian = 'Selesai' OR StatusAntrian = 'Pending') AND `WaktuAntrian` like '%$hariini%'"));

				// if($dt['Pelayanan'] != 'IMUNISASI' AND $dt['Pelayanan'] != 'PROLANIS'){
				$clspoli = str_replace(" ", "_", $dt['Pelayanan']);
				?>
				
				<div class="col-sm-12">
					<div class="listpoli">
						<div class="row">
							<div class="col-sm-6 listruang">
								<?php echo $dt['Pelayanan'];?>
							</div>
							<div class="col-sm-6">
								<div class="listruangantrian">
								<?php echo $dt['KodePelayanan'];?><?php echo $jumlah;?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
				// }
			}	
			?>
		</div>			
	</div>
	
	<div class="kotakbawahbesar">
		<?php if($datasetting['StatusSlide'] == 'video'){?>
		<video width="100%" loop="true" style="background: transparent;padding:0px 1px" autoplay="autoplay" controls="controls" id="vid">
			<source src="video/<?php echo $datasetting['Video1'];?>" type="video/mp4">
		</video>
		<script>
        	window.onload = () => {
            	var vid = document.getElementById("vid");
	            if(localStorage.getItem("videoTime") !== null && localStorage.getItem("videoTime") !== undefined) {
	                vid.currentTime = localStorage.getItem("videoTime");
	            }
                setInterval(() => {localStorage.setItem("videoTime", vid.currentTime);},1000); 
            }
        </script>
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
						<img src="image/img1.jpg" alt="Antrian Online 2" width="100%">
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


				<?php
					if($datasetting['Image1'] == '' && $datasetting['Image3'] == '' && $datasetting['Image5'] == '' && $datasetting['Image7'] == '' && $datasetting['Image9'] == '' ){
				?>
				<div class="item">
					<img src="image/img1.jpg" alt="Antrian Online 10" width="100%">
				</div>
				<?php 
					}else if($datasetting['Image2'] == '' && $datasetting['Image4'] == '' && $datasetting['Image6'] == '' && $datasetting['Image8'] == '' && $datasetting['Image10'] == ''){
				?>		
					<div class="item">
						<img src="image/img2.jpg" alt="Antrian Online 10" width="100%">
					</div>
				<?php
					}
				?>
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
	</div>
 </body>
 
 <?php
 	if($lantai == null){
 ?>
  	<div class="modal show" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	            	Silahkan Pilih Lantai
	            </div>
	            <div class="modal-body">
	            	<form action="view_antrian_pendaftaran.php" method="get" class="form-inline">
	            		<select name="lantai" class="form-control">
	            			<option value="1">lantai 1</option>
	            			<option value="2">lantai 2</option>
	            			<option value="3">lantai 3</option>
	            			<option value="4">lantai 4</option>
	            		</select>
	            		<input type="submit" class="btn btn-round btn-info" value="Simpan"/>
	            	</form>
	            </div>
	            
	        </div>
	    </div>
	</div>

 <?php
	}
 ?>
 <!-- Bootstrap core JavaScript
    ==================================================-->
	<script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/jquery.autocomplete.js"></script>
	
	<script src='https://code.responsivevoice.org/responsivevoice.js'></script>
	<?php if($data_antrian['DisplayUtama'] != ''){?>
	<!-- <script>
		

		plays('Suara/sound_bandara.wav');
				
		setTimeout(function(){ 
			responsiveVoice.speak("Nomor Antrian <?php echo str_replace(" - ", " ", $displayutama[0]);?> Ke <?php echo $displayutama[1];?>","Indonesian Female", {rate: 0.7});
		}, 3000);

		function plays(audiofiles){
			var audioElement = document.createElement('audio');
			audioElement.setAttribute('src', audiofiles);
		
			audioElement.play();
		}

	</script>	 -->
		<?php
		if ($kota == 'KABUPATEN BANDUNG' || $kota == 'KABUPATEN BULUNGAN' || $kota == 'KOTA TARAKAN' || $kota == 'SUKABUMI' || $kota == 'BANDUNG'){
			$noantrians = explode(" - ",$displayutama[0]);
			$noantrian_angka = explode(" ",terbilang($noantrians[1]));
			$lokets = explode(" ",$displayutama[1]);
			$loket_arr_terbilang = explode(" ",terbilang($lokets[1]));
			
			$array_suara[] = "'Suara/sound_bandara.wav'";
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
		$.get( "cek_view_antrian.php?dispu=<?php echo $data_antrian['Waktu'];?>&lantai=<?php echo $lantai;?>").done(function( data ) {
			
			if(data == 0){
				setInterval(function(){
					$.get( "cek_view_antrian.php?dispu=<?php echo $data_antrian['Waktu'];?>&lantai=<?php echo $lantai;?>").done(function( data ) {
						
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