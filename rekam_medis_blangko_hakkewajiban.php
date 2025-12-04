<?php
	$nocm = $_GET['nocm'];
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Blangko Hak dan Kewajiban</title>
		<link href="https://fonts.googleapis.com/css?family=Barlow|Big+Shoulders+Text|Muli|Saira+Condensed&display=swap" rel="stylesheet">
		<style>	
			body{
				background: #f5f5f5;
				font-family: 'Barlow', sans-serif;
				font-size : 14px;
			}
			.container{
				width:800px;
				margin:auto;
				background:#fff;
				padding:100px;
			}
			table{
				width: 100%;
				border-collapse: collapse;
				margin:0px;
				padding:0px;
			}
			.judul{
				font-size : 16px;
				font-family: 'Barlow', sans-serif;
				line-height : 10px; 
			}		
			
			.logopuskesmas{
				filter: grayscale(100%);
				width:70px;
			}
			.logokabupaten{
				filter: grayscale(100%);
				width:80px;
			}
			
			.kotakpanjang{
				width:98%;
				height:25px;
				margin:0px 4px;
				border:1px solid #000;
			}
		
			@media print{
				.btn{
					display:none;
				}
			
			}
		</style>	
	</head>
	
	<?php if($_GET['sts'] == 'registrasi'){ ?>
		<body onload="window.print()" onafterprint="document.location = 'index.php?page=registrasi&nocm=<?php echo $nocm;?>'">
	<?php }else{ ?>
		<body onload="window.print()" onafterprint="document.location = 'index.php?page=rekam_medis_klpcm'">
	<?php } ?>
		<div class="container">
			<h1 align="center">HAK DAN KEWAJIBAN PASIEN</h1>			
			<p>
				<h3 align="left">HAK PASIEN DAN KELUARGA</h3>
				<ol>
					<li>Berhak memperoleh informasi mengenai tata tertib dan peraturan yang berlaku di Puskesmas;</li>
					<li>Berhak memperoleh informasi tentang hak dan kewajiban pasien;</li>
					<li>Berhak mengajukan pengaduan atas kualitas pelayanan yang di dapat;</li>
					<li>Berhak memperoleh layanan kesehatan yang bermutu, efektif dan efesien sesuai dengan standar profesi dan standar prosedur operasional;</li>
					<li>Berhak meminta konsultasi tentang penyakit yang diderita kepada dokter lain yang mempunyai Surat Ijin Praktek (SIP) baik di dalam maupun di luar Puskesmas;</li>
					<li>Berhak mendapat privasi dan kerahasiaan penyakit yang diderita termasuk data medisnya;</li>
					<li>Berhak mendapat informasi yang meliputi diagnosa dan tata cara tindakan medis, tujuan tindakan medis, alternatif tindakan, resiko dan komplikasi yang mungkin terjadi, prognosis terhadap tindakan yang dilakukan serta perkiraan biaya pengobatan;</li>
					<li>Berhak memberikan persetujuan atau menolak atas tindakan yang akan dilakukan oleh tenaga kesehatan terhadap penyakit yang dideritanya;</li>
					<li>Berhak memperoleh keamanan atas keselamatan dirinya selama dalam perawatan di Puskesmas;</li>
					<li>Berhak mengajukan usul, saran, perbaikan atas pelayanan Puskesmas terhadap dirinya melalui kotak saran atau Unit Pengaduan Puskesmas.</li>

				</ol>
				<h3 align="left">KEWAJIBAN PASIEN</h3>
				<ol>
					<li>Berkewajiban mematuhi peraturan yang berlaku di Puskesmas;</li>
					<li>Berkewajiban menggunakan fasilitas Puskesmas secara bertanggung jawab;</li>
					<li>Berkewajiban menghormati hak-hak pasien lain, pengunjung dan hak tenaga kesehatan serta petugas lainnya yang berkerja di Puskesmas;</li>
					<li>Berkewajiban memberikan informasi yang jujur, lengkap dan akurat sesuai kemampuan dan pengetahuannya tentang masalah kesehatan termasuk mengenai kemampuan;</li>
					<li>Berkewajiban mematuhi rencana terapi yang direkomendasikan oleh tenaga kesehatan di Puskesmas dan disetujui oleh pasien yang bersangkutan setelah mendapatkan penjelasan;</li>
					<li>Berkewajiban menerima segala konsekuensi atas putusan pribadinya untuk menolak rencana terapi yang direkomendasikan oleh tenaga kesehatan;</li>
					<li>Berkewajiban memberikan imbalan jasa pelayanan yang diterima/retribusi (Sesuai peraturan yang berlaku).</li>

				</ol>
			</p>
			<p style="text-align:center; margin-top: 50px;"><span style="border:1px solid #000; padding: 5px;">FORM-RM-2</span></p>
		</div>
	</body>
</html>
