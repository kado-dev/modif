<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	error_reporting(0);
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$idpasien = $_GET['id'];
	$nocm = $_GET['nocm'];
	$stshal = $_GET['stshal'];

	// tbpasien
	$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `IdPasien`='$idpasien'"));
	$dtte = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbtte` WHERE IdPasien = '$idpasien'"));
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Persetujuan Pasien</title>
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

			.tablepoin{
				width: 100%;
				border-collapse: collapse;
				margin:0px;
				padding:0px;
				border:1px solid #111;
			}
			.tablepoin tr td,.tablepoin tr th{
				border:1px solid #111;padding:10px
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
	
	<?php if($stshal == 'registrasi'){ ?>
		<body onLoad = "window.print()" onafterprint="document.location = 'index.php?page=registrasi&idpasien=<?php echo $idpasien;?>'">
	<?php }else{ ?>
		<body onLoad = "window.print()" onafterprint="document.location = 'index.php?page=rekam_medis_klpcm'">
	<?php } ?>

		<div class="container" style="font-size:14px">
			<h1 align="center">
				PERSETUJUAN UMUM<br/>
				(GENERAL CONSENT)<br/>
				UNTUK MENERIMA PELAYANAN KESEHATAN
			</h1><br/>
			<table>
				<tr>
					<td width="15%">NAMA PASIEN</td>
					<td width="2%">:</td>
					<td width="83%"><?php echo $datapasien['NamaPasien'];?></td>
				</tr>
				<tr>
					<td>NIK</td>
					<td>:</td>
					<td><?php echo $datapasien['Nik'];?></td>
				</tr>
				<tr>
					<td>NO.RM</td>
					<td>:</td>
					<td><?php echo substr($datapasien['NoRM'],-10);?></td>
				</tr>
				<tr>
					<td>NO.INDEX</td>
					<td>:</td>
					<td><?php echo substr($datapasien['NoIndex'], -10);?></td>
				</tr>
			</table>

			<p>
				<p align="left">DENGAN MENANDATANGANI DOKUMEN INI <b>SAYA MENYATAKAN BAHWA :</b></p>
				<!-- <ol>
					<li>SAYA TELAH MENGETAHUI TENTANG HAK-HAK DAN KEWAJIBAN SAYA SEBAGAI PASIEN DI <?php echo "PUSKESMAS ".$namapuskesmas;?></li>
					<li>SAYA MEMBERIKAN KUASA KEPADA PIHAK <?php echo "PUSKESMAS ".$namapuskesmas;?> UNTUK MEMBERIKAN PERAWATAN, PEMERIKSAAN FISIK, PROSEDUR DIAGNOSTIK, DAN ATAU TERAPI.</li>
					<li>SAYA TIDAK DIPERKENANKAN MEMBAWA BARANG-BARANG BERHARGA YANG TIDAK DIPERLUKAN (SEPERTI PERHIASAN, BARANG ELEKTRONIK, DLL) DAN PUSKESMAS TIDAK BERTANGGUNG JAWAB ATAS KERUSAKAN ATAU KEHILANGAN BARANG-BARANG TERSEBUT.</li>
					<li>SAYA SETUJU UNTUK MENGIKUTI TATA CARA MENGAJUKAN KELUHAN SESUAI PROSEDUR YANG ADA.</li>
					<li>UNTUK PEMBIAYAAN PEMERIKSAAN *)
						<ol type="a">
							<li>SAYA MENYATAKAN SETUJU SEBAGAI PASIEN ATAU PENANGGUNG JAWAB PASIEN**) DENGAN STATUS UMUM UNTUK MEMBAYAR TOTAL BIAYA PERAWATAN YANG DIBERIKAN SESUAI RINCIAN BIAYA DAN KETENTUAN PUSKESMAS.</li>
							<li>SAYA MENYATAKAN SETUJU SEBAGAI PASIEN ATAU PENANGGUNG JAWAB PASIEN **)</li>
							<li>DENGAN BIAYA DITANGGUNG PENJAMIN UNTUK SEGERA MELENGKAPI PERSYARATAN ADMINISTRASI.</li>
						</ol>
					</li>
				</ol> -->
				<table class="tablepoin">
					<tr>
						<th>No</th>
						<th>Kelompok</th>
						<th>Penjelasan</th>
						<th>Status</th>
					</tr>
					<?php
						$getGkref = mysqli_query($koneksi,"SELECT * FROM `ref_general_konsen` ORDER BY IdgeneralkonsenRef ASC");
						$no = 0;
						while($n = mysqli_fetch_array($getGkref)){
							$no++;
							$idgenref = $n['IdgeneralkonsenRef'];

							$cek_table = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbgeneralkonsen` a JOIN `$tbgeneralkonsen_detail` b ON a.IdGenkonsen = b.IdGenkonsen WHERE a.IdPasien = '$idpasien' AND b.IdgeneralkonsenRef = '$idgenref'"));

							if($cek_table > 0){
								echo "<tr><td>".$no."</td><td>".strtoupper($n['kelompok'])."</td><td>".strtoupper($n['poin'])."</td><td>Ya</td></tr>";
							}else{
								echo "<tr><td>".$no."</td><td>".strtoupper($n['kelompok'])."</td><td>".strtoupper($n['poin'])."</td><td>Tidak</td></tr>";
							}
							
						}
					?>
				</table>

				<table width="100%">
					<tr>
						<td colspan="2" align="right">BANDUNG, ..............................</td>
					</tr>
					<tr>
						<td colspan="2" align="center">YANG MEMBUAT PERNYATAAN</td>
					</tr>
					<tr>
						<td align="center" width="50%">
							PASIEN/KELUARGA PASIEN
							<img src="<?php echo $dtte['Tte'];?>"/>
							<b><?php echo $datapasien['NamaPasien'];?></b>
						</td>
						<td align="center" width="50%">
							PETUGAS PUSKESMAS
							<br/>
							<br/>
							<br/>
							<br/>
							<br/>
							<b><?php echo $_SESSION['nama_petugas'];?></b>
						</td>
					</tr>
				</table>
			</p>
			<p style="text-align:center; margin-top: 50px;"><span style="border:1px solid #000; padding: 5px;">FORM-RM-1</span></p>
		</div>
	</body>
</html>
