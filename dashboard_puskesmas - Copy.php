<!doctype html>
<html lang="en">
<head>
	<style>	
	.kotak_panels{
		padding: 25px 20px;
		border-radius: 6px;
		margin-top: 5px;
	}
	.kotak_panels i{
		color: #f5f5f5;
		border:7px solid #f2f2f2;
		padding:5px 8px;
		border-radius: 50%;
	}
	.kotak_panels .ket{
		font-size: 14px;color: #f9f9f9;
		position: absolute;
		top:65px;
		left:120px;
	}
	.greens{
		background: rgb(55,124,55);
		background: linear-gradient(90deg, rgba(55,124,55,1) 0%, rgba(70,163,70,1) 50%, rgba(0,201,0,1) 100%);
	}
	
	.kotak_panel_detail{
		width: 100%;
		background: #fff;
		margin-top: 10px;		
	}
	.kotak_panel_detail tr td{
		padding: 4px 10px;font-size: 13px;
	}
	.kotak_panel_detail tr:first-child td{
		padding-top: 10px
	}
	.kotak_panel_detail tr:last-child td{
		padding-bottom: 15px
	}
	.kotak_panel_detail tr td:first-child{font-weight: bold;vertical-align: bottom; }
	.kotak_panel_detail tr td:last-child{color: #454545;}
	.kotak_panel_detail tr td p{
		text-align: right;
	}
	.fontpanel{
		font-size: 30px;
		position: absolute;
		top:10px;
		left:120px;
		color: #fff;
		font-weight: bold;
		margin-top: 15px;
	}
	</style>
</head>
<body>
<?php
	error_reporting(0);
	session_start();
	date_default_timezone_set('Asia/Jakarta');
	include "config/helper_pasienrj.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$kodeppk = $_SESSION['kodeppk'];
	$kota = $_SESSION['kota'];
	$bulan = date('m');
	$tahun = date('Y');	
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
	$hariini = date('Y-m-d');
	$hariini2 = date('ymd');
	$hariini3 = date('ym');

	$kunj_hari = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbpasienrj` WHERE TanggalRegistrasi=curdate() and SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'"));
	$kunj_bulan = mysqli_num_rows(mysqli_query($koneksi,"SELECT DISTINCT NoRegistrasi FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' and MONTH(TanggalRegistrasi) = '$bulan' and SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'"));
	$kunj_tahun = mysqli_num_rows(mysqli_query($koneksi,"SELECT DISTINCT NoRegistrasi FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' and SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'"));
	$dilayani = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' and MONTH(TanggalRegistrasi) = '$bulan' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' and (Asuransi like '%BPJS%') AND `StatusPelayanan` = 'Sudah' AND `kdprovider` = '$kodeppk' GROUP BY NoCM"));
			
	// hitung kontak rate
	if ($bulan=="01"){
		$jmlpeserta = "JumlahPeserta_01";
	}elseif ($bulan=="02"){
		$jmlpeserta = "JumlahPeserta_02";
	}elseif ($bulan=="03"){
		$jmlpeserta = "JumlahPeserta_03";
	}elseif ($bulan=="04"){
		$jmlpeserta = "JumlahPeserta_04";
	}elseif ($bulan=="05"){
		$jmlpeserta = "JumlahPeserta_05";
	}elseif ($bulan=="06"){
		$jmlpeserta = "JumlahPeserta_06";
	}elseif ($bulan=="07"){
		$jmlpeserta = "JumlahPeserta_07";
	}elseif ($bulan=="08"){
		$jmlpeserta = "JumlahPeserta_08";
	}elseif ($bulan=="09"){
		$jmlpeserta = "JumlahPeserta_09";
	}elseif ($bulan=="10"){
		$jmlpeserta = "JumlahPeserta_10";
	}elseif ($bulan=="11"){
		$jmlpeserta = "JumlahPeserta_11";
	}elseif ($bulan=="12"){
		$jmlpeserta = "JumlahPeserta_12";							
	}
	
	// kontakrate
	$dt_kr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT $jmlpeserta AS Jml FROM `tbpuskesmasdetail` WHERE `KodePuskesmas` = '$kodepuskesmas'"));
	$jml_peserta = $dt_kr['Jml'];
	$persentase = ($dilayani * 100)/$jml_peserta;
	
	// ngitung karcis
	$jmlkarcis_hr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(TarifKarcis) AS JumlahKarcis FROM `$tbpasienrj`
	WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi`=curdate() AND `Asuransi`='UMUM'"));
	$jmlkarcis_bl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(TarifKarcis) AS JumlahKarcis FROM `$tbpasienrj`
	WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(TanggalRegistrasi)='$tahun' AND `Asuransi`='UMUM'"));
	$tarif_hari = $jmlkarcis_hr['JumlahKarcis'];
	$tarif_bulan = $jmlkarcis_bl['JumlahKarcis'];	
	
	// ngitung kir
	$jmlkir_hr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(TarifKir) AS JumlahKir FROM `$tbpasienrj`
	WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRegistrasi`=curdate() AND `Kir`<>''"));
	$jmlkir_bl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(TarifKir) AS JumlahKir FROM `$tbpasienrj`
	WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(TanggalRegistrasi)='$tahun' AND `Kir`<>''"));
	$tarif_kir_hr = $jmlkir_hr['JumlahKir'];
	$tarif_kir_bl = $jmlkir_bl['JumlahKir'];
			
	// ngitung tindakan
	$jmltindakan_hari = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.Tarif) AS JumlahTindakan FROM tbtindakanpasiendetail a JOIN tbtindakan b ON a.KodeTindakan = b.KodeTindakan
	WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND SUBSTRING(a.NoRegistrasi,13,6)='$hariini2'"));
	$jmltindakan_bulan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.Tarif) AS JumlahTindakan FROM tbtindakanpasiendetail a JOIN tbtindakan b ON a.KodeTindakan = b.KodeTindakan
	WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND SUBSTRING(a.NoRegistrasi,13,4)='$hariini3'"));
	
	// notif jika ada data gagal bridging (StatusPasin(2) KunjunganSehat, Statuspulang(3) Berobat Jalan)
	$strbridging = "SELECT  COUNT(*) AS Jumlah FROM $tbpasienrj WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND `Asuransi` like '%BPJS%' AND `StatusPasien` <> '2' AND `StatusPelayanan`='Sudah' AND `StatusPulang`='3' AND (`NoKunjunganBpjs` = '' OR LENGTH(`NoKunjunganBpjs`) = '3' OR LENGTH(`NoKunjunganBpjs`) = '1' OR `NoKunjunganBpjs` = '0')";
	$dtbridging = mysqli_fetch_assoc(mysqli_query($koneksi, $strbridging));
?>
<!--<div class="alert alert-block alert-danger fade in" style="margin-top: 0px;">	
	<p><i class="fa fa-warning"></i>
		<?php //echo " Data Gagal Bridging Bulan Ini ".$dtbridging['Jumlah']." Pasien";?><a href="#" style="color: #B74635" class="btndetailbridging"><b>  >>Lihat data</b></a>
	</p>	
</div>-->
<div class="detailbridging " style="display:none; clear:both; margin-bottom:30px;">
	<div class="sidebars">
		<div class="table-responsive">
			<table class=" table-judul" width="100%">
				<thead>
					<tr>
						<th width='5%'>No.</td>
						<th width='15%'>Bulan</td>
						<th width='65%'>Pelayanan</td>
						<th width='5%'>Jumlah</td>
						<th width='10%'>#</td>
					</tr>
				</thead>
				<tbody>
					<?php
						$no = 0 ;
						$strbridgings = "SELECT PoliPertama, COUNT(NoRegistrasi) AS Jumlah FROM $tbpasienrj WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND `Asuransi` like '%BPJS%' AND `StatusPasien` <> '2' AND `StatusPelayanan`='Sudah' AND `StatusPulang`='3' AND (`NoKunjunganBpjs` = '' OR LENGTH(`NoKunjunganBpjs`) = '3' OR LENGTH(`NoKunjunganBpjs`) = '1' OR `NoKunjunganBpjs` = '0') GROUP BY PoliPertama";
						$query_bridging = mysqli_query($koneksi,$strbridgings);
						while($databridging = mysqli_fetch_assoc($query_bridging)){
							$no = $no +1;
							?>
							<tr>								
								<td style="text-align:right;"><?php echo $no;?></td>
								<td style="text-align:center;"><?php echo nama_bulan(date('m'))." ".date('Y');?></td>
								<td style="text-align:left;"><?php echo $databridging['PoliPertama'];?></td>
								<td style="text-align:center;"><span class="badge badge-danger"><?php echo $databridging['Jumlah'];?></span></td>
								<td style="text-align:center;"><a href="?page=poli_antri_bridging_bulan&plhbulan=<?php echo $bulan;?>&pelayanan=<?php echo $databridging['PoliPertama'];?>" class="btn btn-sm btn-white">Lihat</a></td>
							</tr>
							<?php
						}
					?>
				</tbody>
			</table>
		</div>
	</div>	
</div>	

<div class ="row">
	<div class="col-sm-6">
		<div class="kotak_panels greens">
			<div data-toggle="modal" data-target="#modalpenerimaan">
				<i class="fa fa-arrow-down fa-3x" style="margin-top: 0px;"></i>
				<div class="fontpanel"><?php echo $kunj_hari['Jumlah'];?></div>
				<div class="ket">Jumlah kunjungan hari ini</div>
			</div>
		</div>
		<div class="divscroll">
			<table class="kotak_panel_detail">
				<?php
				function progress_green($x,$tot){
					$persen = ($x * 100) / $tot;
					echo "<div class='progress'><div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='width: ".$persen."%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div></div>";
				}
		
				$str_obat = "SELECT * FROM `tbasuransi`";	
				$no = 0;
				$query_obat = mysqli_query($koneksi,$str_obat);
				while($data = mysqli_fetch_assoc($query_obat)){
					$no = $no +1;
					$kodeasuransi = $data['KodeAsuransi'];
					$asuransi = $data['Asuransi'];
					
					// jumlah kunjungan
					$jumlahkunjungan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE `TanggalRegistrasi`=curdate() AND `Asuransi`='$asuransi'"));				
				?>
				<tr>
					<td width="50%"><?php echo $asuransi;?></td>
					<td>
						<p><?php echo $jumlahkunjungan['Jumlah'];?></p>
						<?php progress_green($jumlahkunjungan['Jumlah'],$kunj_hari['Jumlah'])?>
					</td>
				</tr>
				<?php
					}
				?>	
			</table>
		</div>	
	</div>


	<div style="margin-top: 0px;">
		<div class="col-sm-3">
			<div class="kotak_panel">
				<div class="font30"><?php echo $kunj_hari['Jumlah'];?></div>
				<div class="fontket">
					<h3>Hari Ini</h3>
					<span>* Jumlah kunjungan pasien</span>
				</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="kotak_panel">
				<div class="font30"><?php echo rupiah($kunj_bulan);?></div>
				<div class="fontket">
					<h3><?php echo "Bulan ".nama_bulan(date('m'));?></h3>
					<span>* Jumlah kunjungan pasien</span>
				</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="kotak_panel">
				<div class="font30"><?php echo rupiah($kunj_tahun);?></div>
				<div class="fontket">
					<h3><?php echo "Tahun ".date('Y');?></h3>
					<span>* Jumlah kunjungan pasien</span>
				</div>
			</div>
		</div>
		<a href="index.php?page=grafik_bpjs_kontak_rate" style="cursor:pointer">
			<div class="col-sm-3">
				<div class="kotak_panel">
					<div class="font30">
						<?php echo rupiah($dilayani);?>
						<span><?php echo "(".substr($persentase,0,4)." %)";?></span>
					</div>				
					<div class="fontket">
						<h3>Kontak Rate Pasien BPJS</h3>
						<span>* Jumlah data peserta lihat di PCare</span>
					</div>
				</div>
			</div>
		</a>
	</div>

	<div class="col-sm-12" style="margin-top:0px">
		<div class="kotakgrafik">
			<canvas id="Grafik_Penyakit" height="300px"></canvas>
		</div>
		<button type="button" class="btndetailgrafik btn btn-white" style="text-decoration:none;margin:8px 0px 5px; float:right;cursor:pointer">Detail Diagnosa</button>
	</div>
	<div class="detailgrafik col-lg-12" style="display:none;clear:both">
		<div class="sidebars">
			<div class="table-responsive">
				<table class=" table-judul" width="100%">
					<thead>
						<tr>
							<th width='5%'>No.</td>
							<th width='10%'>Kode ICD X</td>
							<th>Nama Diagnosa</td>
							<th width='10%'>Jumlah</td>
						</tr>
					</thead>
					<tbody>
						<?php
							$no = 0 ;
							$str_penyakit = "SELECT TanggalDiagnosa, KodeDiagnosa, COUNT(KodeDiagnosa) as Jumlah 
								FROM `$tbdiagnosapasien` 
								WHERE SUBSTRING(NoRegistrasi,1,11) = '$kodepuskesmas' AND YEAR(TanggalDiagnosa)='$tahun' AND KodeDiagnosa <> 'Z00.0'
								GROUP BY KodeDiagnosa 
								ORDER BY Jumlah DESC 
								limit 0,10";
							$query_penyakit = mysqli_query($koneksi,$str_penyakit);
							while($dtpenyakit = mysqli_fetch_assoc($query_penyakit)){
								$no = $no +1;
								$kodediagnosa = $dtpenyakit['KodeDiagnosa'];
								$tbpenyakit = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Diagnosa, KodeDiagnosa
								FROM `tbdiagnosabpjs`
								WHERE `KodeDiagnosa`='$kodediagnosa'"));
								?>
								<tr>
									<td style="text-align:right;"><?php echo $no;?></td>
									<td style="text-align:center;"><?php echo $dtpenyakit['KodeDiagnosa'];?></td>
									<td><?php echo $tbpenyakit['Diagnosa'];?></td>
									<td style="text-align:right;"><?php echo $dtpenyakit['Jumlah'];?></td>
								</tr>
								<?php
							}
						?>
					</tbody>
				</table>
			</div>
		</div>	
	</div>	
</div>
<div class ="row">
	<div class="col-lg-6 col-md-6">
		<div class="kotakgrafik">
			<canvas id="Grafik_Kunjungan_Bl" height="250px"></canvas>
			<a href="?page=grafik_kunjungan_baru_lama" style="position:absolute;top:30px;right:25px" class="btn btn-white">Lihat</a>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="kotakgrafik">
			<canvas id="Grafik_Jaminan" height="250px"></canvas>
		</div>
		<a href="?page=grafik_kunjungan_carabayar_tahun" style="position:absolute;top:30px;right:25px" class="btn btn-white">Lihat</a>
	</div>
</div>
<div class ="row">
	<div class="col-sm-12">
		<div class="kotakgrafik" height="250px">
			<div id="mygraph" style="min-width: 200px; height: 350px; margin: 0 auto"></div>
		</div>
	</div>
</div>
<div class="space-6"></div>
<div class ="row">
	<div class="col-lg-4 col-md-4">
		<div class="widget-box transparent">
			<div class="widget-header widget-header-flat">
				<h4 class="widget-title lighter">
					<i class="ace-icon fa fa-user-md orange"></i>
					Pasien belum di entry bulan ini
				</h4>
				<div class="widget-toolbar">
					<a href="#" class="btn-dp-pb-e-bi" data-action="collapse">
						<i class="ace-icon fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="pasien_belum_entri_bi"></div>
		</div>
	</div>
	<div class="col-lg-4 col-md-4">
		<div class="widget-box transparent">
			<div class="widget-header widget-header-flat">
				<h4 class="widget-title lighter">
					<i class="ace-icon fa fa-user-md orange"></i>
					Pasien belum di entry bulan lalu
				</h4>
				<div class="widget-toolbar">
					<a href="#" class="btn-dp-pb-e-bl" data-action="collapse">
						<i class="ace-icon fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="pasien_belum_entri_bl"></div>
		</div>
	</div>
	<div class="col-lg-4 col-md-4">
		<div class="widget-box transparent">
			<div class="widget-header widget-header-flat">
				<h4 class="widget-title lighter">
					<i class="ace-icon fa fa-user-md orange"></i>
					Pasien belum di entry tahun lalu
				</h4>
				<div class="widget-toolbar">
					<a href="#" class="btn-dp-pb-e-th" data-action="collapse">
						<i class="ace-icon fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="pasien_belum_entri_th"></div>
		</div>
	</div>
</div>
</body>
</html>
<!--grafik 3D-->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<!--end grafik 3D-->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/chartjsorg.js"></script>

<script>
$(".btndetailgrafik").click(function(){
	if ( $( ".detailgrafik" ).is( ":hidden" ) ) {
		$(".detailgrafik").slideDown();
	}else{
		$(".detailgrafik").slideUp();
	}
});

$(".btndetailbridging").click(function(){
	if ( $( ".detailbridging" ).is( ":hidden" ) ) {
		$(".detailbridging").slideDown();
	}else{
		$(".detailbridging").slideUp();
	}
});

<!--Grafik Kunjungan Baru & Lama-->
<?php
	$sql_kunjungan_bl = "SELECT `StatusKunjungan`,COUNT(NoRegistrasi) AS Jumlah
	FROM `$tbpasienrj` 
	WHERE `TanggalRegistrasi` = '$hariini' AND substring(`NoRegistrasi`,1,11) = '$kodepuskesmas'
	GROUP BY StatusKunjungan";
?>
var ctx = document.getElementById("Grafik_Kunjungan_Bl").getContext('2d');
var Grafik_Kunjungan_Bl = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: ['Baru','Lama'
				<?php
					// $query_kunjungan_bl = mysqli_query($koneksi,$sql_kunjungan_bl); 
					// while($ambil_kunjungan_bl = mysqli_fetch_assoc($query_kunjungan_bl)){
						// echo $ambil_kunjungan_bl['StatusKunjungan'].', ';
					// }
				?>
				],
		datasets: [{
			label: 'Kunjungan Baru & Lama Hari Ini',
			data:[
				<?php
					$query_kunjungan_bl = mysqli_query($koneksi,$sql_kunjungan_bl); 
					while($ambil_kunjungan_bl = mysqli_fetch_assoc($query_kunjungan_bl)){
						echo $ambil_kunjungan_bl['Jumlah'].', ';
					}
				?>
				],
				backgroundColor: [
				<?php
				for($i =0; $i < mysqli_num_rows($query_kunjungan_bl); $i++){
				?>
					'rgba(175, 238, 247, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i =0; $i < mysqli_num_rows($query_kunjungan_bl); $i++){
			?>
				'rgba(114, 211, 224, 1)',
			<?php
			}
			?>
			],
			borderWidth: 2
		}]
	},
	options: {
		responsive: true,
		maintainAspectRatio: false,
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero:true
				}
			}]
		}
	}
});

<!--Grafik Jaminan-->
<?php
	$sql_jaminan = "SELECT Asuransi, COUNT(NoRegistrasi)AS Jumlah FROM `$tbpasienrj` 
		WHERE SUBSTRING(`NoRegistrasi`,1,11) = '$kodepuskesmas' AND `TanggalRegistrasi` = '$hariini' 
		GROUP BY Asuransi";		
?>
var ctx = document.getElementById("Grafik_Jaminan").getContext('2d');
var Grafik_Jaminan = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: [
				<?php   
					$query_jaminan = mysqli_query($koneksi, $sql_jaminan) or die(mysqli_error());         
					while($ambil_jaminan = mysqli_fetch_array($query_jaminan)){
						echo '"'.$ambil_jaminan['Asuransi'].'", ';
					} 
				?>
				],
		datasets: [{
			label: 'Jaminan Cara Bayar Hari Ini',
			data:[
				<?php 
					$query_jaminan = mysqli_query($koneksi, $sql_jaminan) or die(mysqli_error()); 
					while($ambil_jaminan = mysqli_fetch_array($query_jaminan)){
						echo $ambil_jaminan['Jumlah'].', ';
					} 
				?>
				],
				backgroundColor: [
				<?php
				for($i =0; $i < mysqli_num_rows($query_jaminan); $i++){
				?>
					'rgba(175, 238, 247, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i =0; $i < mysqli_num_rows($query_jaminan); $i++){
			?>
				'rgba(114, 211, 224, 1)',
			<?php
			}
			?>
			],
			borderWidth: 2
		}]
	},
	options: {
		responsive: true,
		maintainAspectRatio: false,
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero:true
				}
			}]
		}
	}
});

<!--Grafik Penyakit-->
<?php
	$str_penyakit = "SELECT `TanggalDiagnosa`, `KodeDiagnosa`, COUNT(`KodeDiagnosa`) as Jumlah 
	FROM `$tbdiagnosapasien` 
	WHERE SUBSTRING(`NoRegistrasi`,1,11) = '$kodepuskesmas' AND YEAR(`TanggalDiagnosa`)='$tahun' AND `KodeDiagnosa` <> 'Z00.0'
	GROUP BY KodeDiagnosa 
	ORDER BY Jumlah DESC 
	limit 0,10";
?>
var ctx = document.getElementById("Grafik_Penyakit").getContext('2d');
var Grafik_Penyakit = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: [
				<?php
					$query_penyakit= mysqli_query($koneksi,$str_penyakit) or die(mysqli_error());
					while($ambil = mysqli_fetch_array($query_penyakit)){
						$kodediagnosa = $ambil['KodeDiagnosa'];
						$str_diagnosa = "SELECT `KodeDiagnosa`,`Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$kodediagnosa'";
						$query_diagnosa = mysqli_query($koneksi, $str_diagnosa);
						$dt_diagnosa = mysqli_fetch_assoc($query_diagnosa);
						echo '"'.$dt_diagnosa['KodeDiagnosa'].'", ';
					}
				?>
				],
		datasets: [{
			label: '10 Penyakit Terbanyak Bulan <?php echo nama_bulan(date('m'));?>',
			data:[
				<?php
					$query_penyakit= mysqli_query($koneksi,$str_penyakit) or die(mysqli_error());
					while($ambil = mysqli_fetch_array($query_penyakit)){
						$kodediagnosa = $ambil['KodeDiagnosa'];
						$str_diagnosa = "SELECT `Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$kodediagnosa'";
						$query_diagnosa = mysqli_query($koneksi, $str_diagnosa);
						$dt_diagnosa = mysqli_fetch_assoc($query_diagnosa);
						echo '"'.$ambil['Jumlah'].'", ';
					}			
				?>
				],
				backgroundColor: [
				<?php
				for($i =0; $i < mysqli_num_rows($query_penyakit); $i++){
				?>
					'rgba(175, 238, 247, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i =0; $i < mysqli_num_rows($query_penyakit); $i++){
			?>
				'rgba(114, 211, 224, 1)',
			<?php
			}
			?>
			],
			borderWidth: 2
		}]
	},
	options: {
		responsive: true,
		maintainAspectRatio: false,
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero:true
				}
			}]
		}
	}
});

var chart; 
	$(document).ready(function() {
		  chart = new Highcharts.Chart(
		  {
			 chart: {
				renderTo: 'mygraph',
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false
			 },   
			title: {
				text: ''
			},
			 subtitle: {
				text: 'Jumlah Kunjungan Poli'
			 },
			 tooltip: {
				format: '<b>{point.name}</b>: {point.y} Rs.',
			 },
			 
			 plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						color: '#000000',
						connectorColor: 'green',
						formatter: function() 
						{
							return '<b>' + this.point.name + '</b>: ' + Highcharts.numberFormat(this.percentage, 0) + ' %';
						}
					}
				}
			 },
				series: [{
				type: 'pie',
				name: 'Jumlah Kunjungan',
					data: [
					<?php
					
						$sql_poli = mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml, `PoliPertama`
						FROM `$tbpasienrj`
						WHERE SUBSTRING(NoRegistrasi,1,11) = '$kodepuskesmas' and TanggalRegistrasi = curdate() AND StatusPasien = '1'
						GROUP BY PoliPertama");
						while ($row = mysqli_fetch_array($sql_poli)) {
							$poli = $row['PoliPertama'];
							$jumlah = $row['Jml'];
					?>
							[ 
								'<?php echo $poli;?>', 
								<?php echo $jumlah;?>
							],
							<?php
						}
						?>
					]
				}]
		  });
}); 

$('.flashnewsbtn').click(function(){
	var isi = $(this).parent().find(".isinews").html();
	$(".modalisi").html(isi);
	$('#flashmodal').modal('show');
});	
</script>

<div class="modal fade" id="flashmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"> Flash News</h4>
			</div>
			<div class="modal-body modalisi">
			
			</div>
		</div>
	</div>
</div>