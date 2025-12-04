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
$pelayanan = $_GET['poli'];
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
			padding: 0vw;
			font-family: 'Russo One', sans-serif;
			background:#ffffff;
			/*background: linear-gradient(0deg, rgba(4, 96, 0, 0.8), rgba(6, 127, 0, 1)), url('../assets_login/images/bgpanel.jpg');*/
			overflow: hidden;
			color:#000000;
		}
		
		.kotakkanan{
			padding:0vw 1.2vw;
			text-align:center;
			height:70%;
			width: 100%;
			float:right;
			margin-bottom: 3.5vw;
		}


		.listpoli{
			/* background-image: -webkit-linear-gradient(45deg, #2d6827 0%, #29DE52 100%); */
			background-image: -webkit-linear-gradient(45deg, #1470e4 0%, #29DE52 100%);
			box-shadow: 0 5px 10px -3px #7f7f7f;
			padding:1.2vw 1.5vw;text-align: left;
			border-radius: 0.4vw;color:#fff;
			margin-top: 2.2vh;
			margin-bottom: 2vh;
			font-size: 5vh;
			min-height: 54vh;text-align:center;
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
			padding-right: 1vw; padding-left: 0.5vw;font-weight: bold;line-height:2.5vh
		}
		.iconlistuser{
			width:35px;height:35px;margin-right:15px;margin-top:-6px;
			background:#f5f5f5;padding:5px;border:1px solid #ccc;border-radius:25px;
		}
	</style>
</head>
<?php
$pelayanan_get = $_GET['poli'];
$hariini = date('Y-m-d');
$antrianpelayanan = mysqli_query($koneksi,"SELECT * FROM tbantrian_pelayanan WHERE KodePuskesmas = '$kodepuskesmas' AND `Pelayanan` = '$pelayanan_get'");
$dtpelayanan = mysqli_fetch_assoc($antrianpelayanan);
$kodepel = $dtpelayanan['KodePelayanan'];
?>
<body style="overflow:hidden">
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
	
	<div class="kotakkanan">
		<div class="row">
			<div class="col-sm-12">
				<div class="listpoli"><br/>
					<?php
					// get displayutama ->waktu terkahir
					$displayutama_antrianpelayanan = mysqli_query($koneksi,"SELECT Pelayanan, Display, Waktu FROM tbantrian_pelayanan WHERE KodePuskesmas = '$kodepuskesmas' AND KodePelayanan = '$kodepel' AND DATE(Waktu) = CURDATE() order by Waktu DESC limit 1");
					if(mysqli_num_rows($displayutama_antrianpelayanan) > 0){
						$dt_disp = mysqli_fetch_assoc($displayutama_antrianpelayanan);
						$noantrian_panggil = $dt_disp['Display'];
						$noantrian_waktu = $dt_disp['Waktu'];
					?>
						<p style="font-size: 2vw">ANTRIAN PELAYANAN</p>
						<p style="font-size:10vw"><?php echo $noantrian_panggil;?></p>
					<?php
						}else{
						$noantrian_panggil = '';
						$noantrian_waktu = '';
					?>
						<p style="font-size: 2vw">ANTRIAN PELAYANAN</p>
						<p style="font-size:10vw"><?php echo $kodepel;?>-</p>
					<?php
						}
					?>
				</div>
			</div>	
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-4">
						<div style="height:32vh; overflow-y:auto; background:#ddd; font-size:1.4vw;">
							<table class="table table-striped " width="100%">
								<!-- <tr>
									<th align="center" width="15%">NO</th>
									<th align="center" width="85%">NAMA PASIEN</th>
								</tr> -->
								<?php
								$tbpasienrj = "tbpasienrj_".$kodepuskesmas;
								$get_pasien = mysqli_query($koneksi, "SELECT `IdPasienrj`, `TanggalRegistrasi`, `NamaPasien`, `NoAntrianPoli`, `StatusAntrianPoli` FROM `$tbpasienrj` WHERE (StatusPelayanan = 'Antri' OR StatusPelayanan = 'Proses' OR StatusPelayanan = 'Rujuk') AND `PoliPertama` like '%$pelayanan%' AND `StatusAntrianPoli` = 'N' AND DATE(TanggalRegistrasi) = CURDATE() order by TanggalRegistrasi ASC");//

									if(mysqli_num_rows($get_pasien) > 0){
										$no = 0;
									while($dt = mysqli_fetch_assoc($get_pasien)){
										$no++;
								?>
								<tr>
									<!-- <td align="left"><?php //echo $no;?></td> -->
									<td align="left"><img class="iconlistuser" src="../image/pasien.jpeg"/> </i><?php echo $dt['NamaPasien'];?></td>
								</tr>
								<?php
									}
									}
								?>
							</table>
						</div>
					</div>
					<div class="col-sm-8">
						<div style="height:32vh; overflow-y:auto; background:#eded00; color: #000000;"><br/>
						<?php
						$noantrian_panggil_ja = $noantrian_panggil;
							$get_pasien_panggil = mysqli_query($koneksi,"SELECT `IdPasienrj`, `TanggalRegistrasi`, `NamaPasien`, `NoAntrianPoli`, `StatusAntrianPoli` FROM `$tbpasienrj` WHERE DATE(TanggalRegistrasi) = CURDATE() AND `NoAntrianPoli` = '$noantrian_panggil_ja'");
							if(mysqli_num_rows($get_pasien_panggil) > 0){
								$dt_disp_oanggil = mysqli_fetch_assoc($get_pasien_panggil);
						?>
							<p style="font-size: 2vw" class="mt-2">NAMA PASIEN:</p>
							<p style="font-size:6.5vw"><?php echo $dt_disp_oanggil['NamaPasien'];?></p>
						<?php
							}
						?>
						</div>
					</div>
				</div>
			</div>
		</div>						
	</div>
	<!--<div class="textbar">
		<marquee behavior="scroll" direction="left"><?php //echo $datasetting['RunningText'];?></marquee>
	</div>
	-->

 </body>
 
 <!-- Bootstrap core JavaScript
    ==================================================-->
	<script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
	<script src="../assets/js/jquery.autocomplete.js"></script>
	
	<script src='https://code.responsivevoice.org/responsivevoice.js'></script>
	<?php 
		$displayutama_antrianpelayanan2 = mysqli_query($koneksi,"SELECT Pelayanan, Display FROM tbantrian_pelayanan WHERE KodePuskesmas = '$kodepuskesmas' AND KodePelayanan = '$kodepel' AND DATE(Waktu) = CURDATE() order by Waktu DESC limit 1");
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
		  var source2 = new EventSource("cek_view_antrian_poli_v2.php?time=<?php echo $noantrian_waktu;?>&kodepel=<?php echo $kodepel;?>");
		  source2.onmessage = function(event) {
			if(event.data == 1){
				  window.location.reload(true);
			  }	
			console.log(event.data);
		  };
		} else {
		  document.getElementById("result").innerHTML = "Maaf, browser anda tidak suport server-sent events...";
		}
	</script>
</html>