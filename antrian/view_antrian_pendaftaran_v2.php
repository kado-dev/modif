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
			background: #b2c1ff;
			background-image: -webkit-linear-gradient(45deg, #1470e4 0%, #29DE52 100%);
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
			height:62vh;
			width: 100vw;
			float:left;
		}	
		.antrianutama{
			background: transparent;
			border-radius: 0.5vw;
			height:33vh;
			width:100vw;
			float:left;
			padding-top:8vh;
		}
		.antrianutama h2{
			background: transparent;
			color:#131e19;
			padding:0.6vh;	
			font-weight:bold;
			text-align:center;		
			font-size: 17vw;
			font-family: 'Russo One', sans-serif;
			
			border-radius: 3vw;
			margin: auto;
		}


		/** ------------------------------------------------------- **/
		.kotakbawah{
			padding:0;
			text-align:center;
			height:27vh;
			width: 100vw;
			float:right;	
			background:#fff;		
		}		
		.listpoli{
			background: #fff;
			margin-bottom: 0.5vh;
			padding:0.35vw;
		}
		.listruang{
			background: transparent;
			text-align: center;
			font-size: 2vh;
			padding:0;
		}		
		.listruangantrian{
			text-align: center;
			color:#131e19;
			font-size: 4.5vh;
			padding:0;
		}
		.kotakkananbawah{
			background:#d6defc;
			/*background-image: -webkit-linear-gradient(45deg, #1470e4 0%, #29DE52 100%);*/
			height:27vh;
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
			color:#fff;font-size: 2.5vh;background:transparent;font-weight: bold;padding:2vh;
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
		<div class="jams"><?php echo date('G:i:s');?></div>
	  </div>
	</nav>


	<?php
	$disangka = explode(" - ",$displayutama[0]);
	?>


	<div class="kotakbesar">
		<div class="antrianutama">
			<h2><?php echo $displayutama[0];?></h2>
		</div>
	</div>

	<div class="kotakbawah">
		<div class="row">
			<div class="col-sm-9" style="background:#fff;padding:6vh 1vw">
				<!-- <h3 style="text-align:left; font-weight:bold; padding-left:3vw;font-size:2vh;margin-bottom:1vh">SISA ANTRIAN PELAYANAN: </h3> -->
				<table width="100%">
					<tr>
					<?php
					$hariini = date('Y-m-d');
					$antrianpelayanan = mysqli_query($koneksi, "SELECT * FROM `tbantrian_pelayanan` WHERE KodePuskesmas = '$kodepuskesmas' ORDER BY KodePelayanan");
					while($dt = mysqli_fetch_assoc($antrianpelayanan)){
						$jumlah = mysqli_num_rows(mysqli_query($koneksi,"SELECT NomorAntrian FROM $tbantrian_pasien WHERE KodePuskesmas = '$kodepuskesmas' and PoliPertama = '$dt[Pelayanan]' AND StatusAntrian = 'Antri'  AND `WaktuAntrian` like '%$hariini%'")); //(StatusAntrian = 'Selesai' OR StatusAntrian = 'Pending')

						// if($dt['Pelayanan'] != 'IMUNISASI' AND $dt['Pelayanan'] != 'PROLANIS'){
						$clspoli = str_replace(" ", "_", $dt['Pelayanan']);
						?>
						
						<td>
							<div class="listpoli">
								<div class="row">
									<div class="col-sm-12 listruang">
										<?php echo $dt['Pelayanan'];?> (<?php echo $dt['KodePelayanan'];?>)
									</div>
									<div class="col-sm-12">
										<div class="listruangantrian">
										<?php echo $jumlah;?>
										</div>
									</div>
								</div>
							</div>
						</td>
					<?php
						// }
					}	
					?>
					</tr>
				</table>
			</div>
			<div class="col-sm-3 kotakkananbawah" style="">
				<h2 style="font-weight:bold;margin-top:7vh;font-size:45px">LOKET<br/> <?php echo strtoupper($lantai);?></h2>
			</div>
		</div>			
	</div>
	
	
 </body>
 
 <?php
 	if($lantai == null){
 ?>
  	<div class="modal show" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	            	Silahkan Pilih Loket
	            </div>
	            <div class="modal-body">
	            	<form action="view_antrian_pendaftaran_v2.php" method="get" class="form-inline">
	            		<select name="lantai" class="form-control">
	            			<option value="1">Loket 1</option>
	            			<option value="2">Loket 2</option>
	            			<option value="3">Loket 3</option>
	            			<option value="4">Loket 4</option>
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
		if ($kota == 'KABUPATEN BANDUNG' || $kota == 'KABUPATEN BULUNGAN' || $kota == 'KOTA TARAKAN'){
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

	<!--ini untuk detik jam, jangan dulu diaktifkan 27 februari 2025-->
	<!-- <script>
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
	</script> -->

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