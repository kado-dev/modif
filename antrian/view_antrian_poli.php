<?php
error_reporting(0);
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
			background: #fff;
		}
		
		.kotakbesar{
			padding:0.3vw 1vw;
			text-align:center;
			height:70%;
			width: 50%;
			float:left;
			margin-bottom: 3.5vw;
		}	
		.kotakbesar video{
			height: 78vh
		}	
		.kotakkanan{
			padding:0vw 1.2vw;
			text-align:center;
			height:70%;
			width: 50%;
			float:right;
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
			background: linear-gradient(0deg, rgba(82, 201, 102, 0.9), rgba(82, 201, 102, 0.9)), url('../image/bgpanel.jpg');
			background-repeat: no-repeat;
			background-size: 100%;
			background-position: center;
			box-shadow: 0 5px 10px -3px #7f7f7f;
			padding:1.2vw 1.5vw;text-align: left;
			border-radius: 0.4vw;color:#fff;
			margin-top: 0.8vh;
			margin-bottom: 2vh;
			font-size: 5vh;
			min-height: 24vh
		}
		.listpolipendaftaran{
			display: block;
			padding: 0.3vw 2vw;			
			border-radius: 0vw;
			background: #82e082;font-size: 7vh;
			text-align: center;
		}
		
		.carousel-inner>.item>img, .carousel-inner>.item>a>img {
			height:100%;
		}
		
		.antrianutama{
			font-weight:bold;
			background:white;
			background-image: -webkit-linear-gradient(45deg, #1470e4 0%, #29DE52 100%);
			height: 78vh;
			box-shadow: 0px 0px 10px #545454
		}
		.antrianutama h2{
			font-weight:bold;
			background: transparent;
			color: #fff;
			padding: 4vh;
			margin-top: 0px;
			margin-bottom: 10vh;
			font-size: 1.5vw;
		}
		.textbar{
			width: 100%;
			position:fixed;
			left:0px;
			bottom:0px;
			background-color: #deefee;
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
			padding-right: 1vw; padding-left: 0.5vw;font-weight: bold;line-height:2.5vh
		}

	</style>
</head>

<body>
	<?php
		$datasetting = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbantrian_setting where KodePuskesmas = '$kodepuskesmas'"));
		$data_antrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbantrian_view where KodePuskesmas = '$kodepuskesmas'"));
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
	  </div>
	</nav>
	<div class="kotakbesar">
		<?php
		// get displayutama ->waktu terkahir
		$displayutama_antrianpelayanan = mysqli_query($koneksi,"SELECT Pelayanan, Display, dokterBpjs FROM tbantrian_pelayanan WHERE KodePuskesmas = '$kodepuskesmas' AND DATE(Waktu) = CURDATE() order by Waktu DESC limit 1");
		if(mysqli_num_rows($displayutama_antrianpelayanan) > 0){
			$dt_disp = mysqli_fetch_assoc($displayutama_antrianpelayanan);
		?>
			<div class="antrianutama">
				<h2 style="font-size: 2vw">ANTRIAN PELAYANAN</h2>
				<p style="font-size:5.5vw"><?php echo $dt_disp['Display'];?></p>
				<p style="font-size:5vw">RUANG <?php echo strtoupper($dt_disp['Pelayanan']);?></p>		
				<p style="font-size:2.2vw">Dokter <?php echo $dt_disp['dokterBpjs'];?></p>
			</div>
		<?php
			}else{
		?>	

		<?php if($datasetting['StatusSlide'] == 'video'){?>
		<video width="100%" loop="true" style="background: black;padding:0px 1px" autoplay="autoplay" controls="controls" id="vid">
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
		<?php 
			}
		}
		?>

	</div>
	<div class="kotakkanan">
		<div class="row">
			<?php
			$hariini = date('Y-m-d');
			$antrianpelayanan = mysqli_query($koneksi,"SELECT * FROM tbantrian_pelayanan WHERE KodePuskesmas = '$kodepuskesmas' order by KodePelayanan");
			while($dt = mysqli_fetch_assoc($antrianpelayanan)){
				//$jumlah = mysqli_num_rows(mysqli_query($koneksi,"SELECT NomorAntrian FROM $tbantrian_pasien WHERE KodePuskesmas = '$kodepuskesmas' and PoliPertama = '$dt[Pelayanan]' and (StatusAntrian = 'Selesai' OR StatusAntrian = 'Pending') AND `WaktuAntrian` like '%$hariini%'"));

				if($dt['Pelayanan'] != 'IMUNISASI' AND $dt['Pelayanan'] != 'PROLANIS'){
				$clspoli = str_replace(" ", "_", $dt['Pelayanan']);
				?>
					<div class="col-sm-6">
						<div class="listpoli">
							<?php echo $dt['Pelayanan'];?>
							<span style="color: yellow; float: right;padding-right: 1vw"><?php echo $dt['KodePelayanan'];?></span>
							<input type="hidden" class="wkt<?php echo $clspoli;?>" value="<?php echo $dt['Waktu'];?>"/>
							<span class="<?php if ($dt['Display'] != '') {echo 'listpolipendaftaran';}?> <?php echo $clspoli;?>"><?php echo $dt['Display'];?></span>		
						</div>
					</div>	
			
				
			<?php
				}
			}	
			?>	
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
	<?php 
		$displayutama_antrianpelayanan2 = mysqli_query($koneksi,"SELECT Pelayanan, Display FROM tbantrian_pelayanan WHERE KodePuskesmas = '$kodepuskesmas' AND DATE(Waktu) = CURDATE() order by Waktu DESC limit 1");
		if(mysqli_num_rows($displayutama_antrianpelayanan2) > 0){
			$dt_disp = mysqli_fetch_assoc($displayutama_antrianpelayanan2);
	?>

		<?php
		//suara dengan rekaman manual
			$noantrians = $dt_disp['Display'];
			$noantrian_huruf = substr($noantrians, 0,1);
			$noantrian_angka = substr($noantrians, 1);
			$pelayanan = $dt_disp['Pelayanan'];
			$noantrian_arr_terbilang = explode(" ",terbilang($noantrian_angka));
			
			$array_suara[] = "'Suara/sound.wav'";
			$array_suara[] = "'Suara/Nomor_Antrian.wav'";
			$array_suara[] = "'Suara/".$noantrian_huruf.".wav'";//untuk A,B,C antrian
			foreach($noantrian_arr_terbilang as $ars){
				$array_suara[] ="'Suara/".strtolower($ars).".wav'";
			}							
			$array_suara[] = "'Suara/keruang.wav'";
			$array_suara[] = "'Suara/".strtolower($pelayanan).".wav'";
			
			$array_suara_implode = implode(", ",$array_suara);

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


		  //pemeriksaan
		  var source2 = new EventSource("cek_view_antrian_poli.php?time=<?php echo date('Y-m-d G:i:s');?>");
		  source2.onmessage = function(event) {
		  	var dt = JSON.parse(event.data);
		  	
			jQuery.each(dt, function(i, val) {
		  		var is = $("." + i).text();
		  		var wkt = $(".wkt"+i).val();
		  		var split = val.split("|");
		  		
		  		//if(is != split[0]){
			  	if(wkt != split[1]){	
			  		$(".wkt" + i).val(split[1]);//set waktu di inputan	
					$("." + i).text(split[0]);// set display
					if(split[0] != ''){	
					var poli = i.replace("_", " ");
					window.location.reload(true);
					
					
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