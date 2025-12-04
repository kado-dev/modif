<?php
date_default_timezone_set('Asia/Jakarta');
//session_start();
include "../config/koneksi.php";
include "../config/helper.php";
$kodepuskesmas = $_COOKIE['kodepuskesmas2'];
$puskesmas = $_COOKIE['namapuskesmas2'];
$kota = $_COOKIE['kota2'];
$alamat = $_COOKIE['alamat2'];

$tbantrian_farmasi = "tbantrian_farmasi_".str_replace(' ', '', $puskesmas);

$cek_tbview_antrianfarmasi = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM tbantrian_farmasi_view where KodePuskesmas = '$kodepuskesmas'"));
if($cek_tbview_antrianfarmasi == 0){
	echo "<script>";
	echo "alert('Silahkan upgrade ke layanan custom');";
	echo "document.location.href='index.php?page=dashboard';";
	echo "</script>";
	die();
}

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
			height: 78vh;
			box-shadow: 0px 0px 10px #545454
		}
		.antrianutama h2{
			font-weight:bold;
			background:#287854;
			color:#fff;
			padding:1.2vw;
			margin-top: 0px;
			margin-bottom:20vh;
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
			background: #1c8200;border-radius: 0px;margin-bottom: 10px
		}
		.navbar-brand, .navbar-brand:hover, .navbar-brand:focus{
			color:#fff;font-size: 4vh;
		}

		.navbar-brand img{
			width: 50px
		}
	</style>
</head>

<body>
	<?php
		$datasetting = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbantrian_setting where KodePuskesmas = '$kodepuskesmas'"));
		$data_antrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbantrian_farmasi_view where KodePuskesmas = '$kodepuskesmas'"));
		$displayutama = $data_antrian['DisplayUtama'];
	?>
		<nav class="navbar navbar-light bgnavbar">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="#"><img src="../image/logo_puskesmas.png" class="logopuskesmas noprint"/> <?php echo "UPT PUSKESMAS ".$_COOKIE['namapuskesmas2'];?></a>
		  </div>
		</nav>
		

			<div class="kotakbesar">

					<div class="antrianutama">
						<h2>NOMOR ANTRIAN FARMASI</h2>
						<p style="font-size:5.5vw"><?php echo $displayutama;?></p>	
						<p style="font-size:4vw">RUANG FARMASI</p>	
					</div>

			</div>

			<div class="kotakkanan">
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
					<?php }?>				
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
	
	<!-- <script src='https://code.responsivevoice.org/responsivevoice.js'></script> -->
	<?php if($data_antrian['DisplayUtama'] != ''){?>
	<script>
		// plays('Suara/sound.wav');
				
		// setTimeout(function(){ 
		// 	responsiveVoice.speak("Nomor Antrian <?php //echo $displayutama;?> Ke Ruang Farmasi","Indonesian Female", {rate: 0.7});
		// }, 3000);

		// function plays(audiofiles){
		// 	var audioElement = document.createElement('audio');
		// 	audioElement.setAttribute('src', audiofiles);
		
		// 	audioElement.play();
		// }

	</script>	
		<?php
		
			$noantrian_angka = explode(" ",terbilang($displayutama));
			
			$array_suara[] = "'Suara/sound.wav'";
			$array_suara[] = "'Suara/Nomor_Antrian.wav'";
			foreach($noantrian_angka as $ars){
				$array_suara[] ="'Suara/".strtolower($ars).".wav'";
			}							
			$array_suara[] = "'Suara/keruang.wav'";
			$array_suara[] = "'Suara/farmasi.wav'";
			
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
		$.get( "cek_view_antrian_farmasi.php?dispu=<?php echo $data_antrian['Waktu'];?>").done(function( data ) {
			
			if(data == 0){
				setInterval(function(){
					$.get( "cek_view_antrian_farmasi.php?dispu=<?php echo $data_antrian['Waktu'];?>").done(function( data ) {
						
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
?>