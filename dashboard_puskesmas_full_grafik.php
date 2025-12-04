
<style>
.tr, th{
	text-align:center;
}
.tabel_judul th{
	background: #80ba8b;
	border-collapse: separate;
	font-size: 12px;
	line-height: 20px;
	text-align:center;
	padding: 5px 10px;
	color:#fff;
}

.headinglogin{
	background:#3BAC9B;
	padding:10px 10px;
	color:#fff;
	text-align:center;
	border-radius:4px 4px 0px 0px;
	margin-top:-20px;
	margin-left:-10px;
	margin-right:-10px;
	margin-bottom:15px;
	font-family: Malgun Gothic;
	font-weight: bold;
	font-size: 13px;
}

.sidebars{
	background:#fff;
	border:1px solid #ddd;
	border-radius:5px;
	box-shadow:0px 0px 10px #bbb;
	padding:9px;
	display:block;
	color:#111;
	text-align:left;
	margin: 15px 0px;
}

.kotak_retribusi{
   	background: #c6efe8;
    padding: 10px 15px;	
    margin: 5px 0px;
	font-family: Sans-Serif;
	text-align:center;
	color:#3BAC9B;
	border-radius:5px;
}

.kotakgrafik{
	margin-top:20px;
	background:#fff;
	padding:15px 10px;
	border:1px solid #ccc;
	border-radius:5px 5px 0px 0px;
}
.kotakgrafik h2{
	font-size:14px;
	background:#f9f9f9;
	padding:20px 10px 15px;
	border-bottom:1px solid #ccc;
	border-radius:5px 5px 0px 0px;
	margin:-15px -10px 10px -10px;
}
.font14{
	font-size: 14px;
}

.font32_bold{
	font-family: Sans-Serif;
	font-size: 32px;
	font-weight: bold;
	text-align: center;
	color:#3BAC9B;
}

@media screen and (max-width: 992px) {
	.kotak_retribusi{
		width: 100%;
		margin-bottom:15px;
	}
	.sidebars{
		margin-bottom:20px;
	}
}
</style>

<?php
	error_reporting(0);
	date_default_timezone_set('Asia/Jakarta');
	include "config/helper_pasienrj.php";
	
	$bulan = date('m');
	$tahun = date('Y');	
	$hariini = date('Y-m-d');
	$hariini2 = date('ymd');
	$hariini3 = date('ym');

	$kunj_hari = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT count(IdPasienrj)AS Jumlah FROM `$tbpasienrj` WHERE TanggalRegistrasi=curdate()"));
	$kunj_bulan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT count(IdPasienrj)AS Jumlah FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun'"));
	$kunj_tahun = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT count(IdPasienrj)AS Jumlah FROM `tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' and SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'"));
	$kinerja_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT count(Nip)AS Jumlah FROM `tbpegawai` WHERE KodePuskesmas = '$kodepuskesmas' "));
	$dilayani = mysqli_num_rows(mysqli_query($koneksi,"SELECT `IdPasienrj` FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND (Asuransi like '%BPJS%') AND `StatusPelayanan` = 'Sudah' AND `kdprovider` = '$kodeppk' GROUP BY NoCM"));
	
	// hitung kontak rate
	$dt_kr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `JumlahPeserta` FROM `tbpuskesmasdetail` WHERE `KodePuskesmas` = '$kodepuskesmas'"));
	$jml_peserta = $dt_kr['JumlahPeserta'];
	$persentase = ($dilayani * 100)/$jml_peserta;
	
	// ngitung karcis
	$jmlkarcis_hr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(TarifKarcis) AS JumlahKarcis FROM `$tbpasienrj` WHERE `TanggalRegistrasi`=curdate() AND `Asuransi`='UMUM'"));
	$jmlkarcis_bl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(TarifKarcis) AS JumlahKarcis FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND `Asuransi`='UMUM'"));
	$tarif_hari = $jmlkarcis_hr['JumlahKarcis'];
	$tarif_bulan = $jmlkarcis_bl['JumlahKarcis'];	
	
	// ngitung kir
	$jmlkir_hr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(TarifKir) AS JumlahKir FROM `$tbpasienrj` WHERE `TanggalRegistrasi`=curdate() AND `Kir`<>''"));
	$jmlkir_bl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(TarifKir) AS JumlahKir FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND `Kir`<>''"));
	$tarif_kir_hr = $jmlkir_hr['JumlahKir'];
	$tarif_kir_bl = $jmlkir_bl['JumlahKir'];
			
	// ngitung tindakan
	$jmltindakan_hari = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.Tarif) AS JumlahTindakan FROM tbtindakanpasiendetail a JOIN tbtindakan b ON a.KodeTindakan = b.KodeTindakan	WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND SUBSTRING(a.NoRegistrasi,13,6)='$hariini2'"));
	$jmltindakan_bulan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.Tarif) AS JumlahTindakan FROM tbtindakanpasiendetail a JOIN tbtindakan b ON a.KodeTindakan = b.KodeTindakan WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND SUBSTRING(a.NoRegistrasi,13,4)='$hariini3'"));	
?>

<div class="row">
	<div class="col-sm-3">
		<div class="sidebars"><div class="headinglogin">Kunjungan Pasien Hari Ini</div>
		<div class="font32_bold"><?php echo $kunj_hari['Jumlah'];?></div></div>
	</div>
	<div class="col-sm-3">
		<div class="sidebars"><div class="headinglogin">Kunjungan Pasien Bulan <?php echo nama_bulan(date('m'));?></div>
		<div class="font32_bold"><?php echo rupiah($kunj_bulan['Jumlah']);?></div></div>
	</div>
	<div class="col-sm-3">
		<div class="sidebars"><div class="headinglogin">Kunjungan Pasien Tahun <?php echo date('Y');?></div>
		<div class="font32_bold"><?php echo rupiah($kunj_tahun['Jumlah']);?></div></div>
	</div>
	<a href="index.php?page=grafik_bpjs_kontak_rate" style="cursor:pointer">
		<div class="col-sm-3">
			<div class="sidebars"><div class="headinglogin">Kontak Rate BPJS</div>
			<div class="font32_bold"><?php echo rupiah($dilayani)." (".substr($persentase,0,4)." %)";?></div></div>
		</div>
	</a>
</div>
<div class="row">
	<a href="index.php?page=grafik_tracking_pegawai">
	<div class="col-sm-4">
		<div class="kotak_retribusi">
			<div>Jumlah Pegawai (Kinerja)</div>
			<div class="font32_bold"><?php echo $kinerja_pegawai['Jumlah'];?></div>
		</div>
	</div>
	</a>
	<a href="#" style="cursor:pointer" class="btndetailretribusi_hari">
	<div class="col-sm-4">
		<div class="kotak_retribusi"><div>Jumlah Retribusi Hari Ini</div>
		<div class="font32_bold"><?php echo rupiah($tarif_hari + $tarif_kir_hr + $jmltindakan_hari['JumlahTindakan']);?></div></div>
	</div>
	</a>
	<a href="#" style="cursor:pointer" class="btndetailretribusi_bulan">
	<div class="col-sm-4">
		<?php if($kota == 'KABUPATEN KUTAI KARTANEGARA') { ?>
			<div class="kotak_retribusi"><div>Pendapatan BLUD Bulan <?php echo nama_bulan(date('m'));?></div>
		<?php }else{ ?>
			<div class="kotak_retribusi"><div>Jml.Retribusi Bulan <?php echo nama_bulan(date('m'));?></div>
		<?php } ?>
		<div class="font32_bold"><?php echo rupiah($tarif_bulan + $tarif_kir_bl + $jmltindakan_bulan['JumlahTindakan']);?></div></div>
	</div>
	</a>
	<!--menghitung retribusi harian-->
	<div class="detailretribusi_hari col-lg-12" style="display:none;clear:both">
		<div class="sidebars">
			<div class="table-responsive">
				<table class=" table-striped table-condensed table-bordered" width="100%">
					<thead>
						<tr>
							<th width='5%'>No.</td>
							<th>Retribusi Hari Ini</td>
							<th width='10%'>Tarif</td>
						</tr>
					</thead>
					<tbody>
							<tr>
								<td>1</td>
								<td>Karcis</td>
								<td style="text-align:right;"><?php echo rupiah($tarif_hari);?></td>
							</tr>
							<tr>
								<td>2</td>
								<td>KIR</td>
								<td style="text-align:right;"><?php echo rupiah($tarif_kir_hr);?></td>
							</tr>
							<tr>
								<td>3</td>
								<td>Tindakan</td>
								<td style="text-align:right;"><?php echo rupiah($jmltindakan_hari['JumlahTindakan']);?></td>
							</tr>
							<tr>
								<td colspan="2" align="center">Total</td>
								<td style="text-align:right;"><?php echo rupiah($tarif_hari + $tarif_kir_hr + $jmltindakan_hari['JumlahTindakan']);?></td>
							</tr>
					</tbody>
				</table>
			</div>
		</div>	
	</div>
	<!--menghitung retribusi bulan-->
	<div class="detailretribusi_bulan col-lg-12" style="display:none;clear:both">
		<div class="sidebars">
			<div class="table-responsive">
				<table class=" table-striped table-condensed table-bordered" width="100%">
					<thead>
						<tr>
							<th width='5%'>No.</td>
							<th>Retribusi Bulan <?php echo nama_bulan(date('m'));?></td>
							<th width='10%'>Tarif</td>
						</tr>
					</thead>
					<tbody>
							<tr>
								<td>1</td>
								<td>Karcis</td>
								<td style="text-align:right;"><?php echo rupiah($tarif_bulan);?></td>
							</tr>
							<tr>
								<td>2</td>
								<td>KIR</td>
								<td style="text-align:right;"><?php echo rupiah($tarif_kir_bl);?></td>
							</tr>
							<tr>
								<td>3</td>
								<td>Tindakan</td>
								<td style="text-align:right;"><?php echo rupiah($jmltindakan_bulan['JumlahTindakan']);?></td>
							</tr>
							<tr>
								<td colspan="2" align="center">Total</td>
								<td style="text-align:right;"><?php echo rupiah($tarif_bulan + $tarif_kir_bl + $jmltindakan_bulan['JumlahTindakan']);?></td>
							</tr>
					</tbody>
				</table>
			</div>
		</div>	
	</div>
</div>

<!--<div class="col-sm-12">
	<div class="space-2"></div>
	<div class="infobox-container">
		<a class="btn btn-warning btn-icon input-block-level" href="index.php?page=grafik_kunjungan_pasien_tahun_puskesmas" style="width:170px; margin:6px;">
			<i class="fa fa-hospital-o fa-2x"></i>
			<div>Kunj.Pasien</div>
			<span class="label label-right label-danger"></span>
		</a>
		<a class="btn btn-pink btn-icon input-block-level" href="?page=grafik_kunjungan_baru_lama" style="width:170px; margin:6px;">
			<i class="fa fa-bar-chart-o fa-2x"></i>
			<div>Kunj.Baru-Lama</div>
			<span class="label label-right label-danger"></span>
		</a>
		<a class="btn btn-grey btn-icon input-block-level" href="?page=grafik_penyakit_terbanyak" style="width:170px; margin:6px;">
			<i class="fa fa-bar-chart-o fa-2x"></i>
			<div>Penyakit Terbanyak</div>
			<span class="label label-right label-danger"></span>
		</a>
	</div>
</div>-->

<div class ="row">
	<div class="col-sm-12">
		<div class="kotakgrafik">
			<canvas id="Grafik_Penyakit" height="300px"></canvas>
		</div>
		<button type="button" class="btndetailgrafik btn btn-link" style="margin:8px 0px 5px; float:right;cursor:pointer">Detail Diagnosa</button>
	</div>
	<div class="detailgrafik col-lg-12" style="display:none;clear:both">
		<div class="sidebars">
			<div class="table-responsive">
				<table class=" table-striped table-condensed table-bordered" width="100%">
					<thead>
						<tr>
							<th width='5%'>No.</td>
							<th width='10%'>Kode</td>
							<th>Nama Diagnosa</td>
							<th width='10%'>Jumlah</td>
						</tr>
					</thead>
					<tbody>
						<?php
							$str_penyakit = "SELECT TanggalDiagnosa, KodeDiagnosa, COUNT(KodeDiagnosa) as Jumlah 
								FROM `$tbdiagnosapasien` 
								WHERE YEAR(TanggalDiagnosa)='$tahun' 
								GROUP BY KodeDiagnosa 
								ORDER BY Jumlah DESC 
								LIMIT 0,10";
							$query_penyakit = mysqli_query($koneksi,$str_penyakit);
							$no = 0 ;
						while($dtpenyakit = mysqli_fetch_assoc($query_penyakit)){
							$no = $no +1;
							$kodediagnosa = $dtpenyakit['KodeDiagnosa'];
							$tbpenyakit = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT Diagnosa, KodeDiagnosa from tbdiagnosabpjs where KodeDiagnosa = '$kodediagnosa'"));
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
			<a href="?page=grafik_kunjungan_baru_lama" style="position:absolute;top:30px;right:25px" class="hidden-xs">lihat</a>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="kotakgrafik">
			<canvas id="Grafik_Jaminan" height="250px"></canvas>
		</div>
		<a href="?page=grafik_kunjungan_carabayar_tahun" style="position:absolute;top:30px;right:25px" class="hidden-xs">Lihat</a>
	</div>
</div>
<div class ="row">
	<div class="col-sm-6">
		<div class="kotakgrafik">
			<canvas id="Grafik_Sakit_Sehat" height="250px"></canvas>
		</div>
		<a href="?page=grafik_kunjungan_sakit_sehat" style="position:absolute;top:30px;right:25px" class="hidden-xs">Lihat</a>
	</div>
	<div class="col-lg-6 col-md-6">
		<div class="kotakgrafik">
			<canvas id="Grafik_Kunjungan" height="250px"></canvas>
		</div>
		<a href="?page=grafik_kunjungan_ukp" style="position:absolute;top:30px;right:25px" class="hidden-xs">Lihat</a>
	</div>
</div>
<div class ="row">
	<div class="col-sm-12">
		<div class="kotakgrafik">
			<div id="mygraph" style="min-width: 200px; height: 350px; margin: 0 auto"></div>
		</div>
	</div>
</div>
<div class="space-6"></div>
<div class ="row">
	<div class="col-lg-6 col-md-6">
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
	<div class="col-lg-6 col-md-6">
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
</div>

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

$(".btndetailretribusi_hari").click(function(){
	if ( $( ".detailretribusi_hari" ).is( ":hidden" ) ) {
		$(".detailretribusi_hari").slideDown();
	}else{
		$(".detailretribusi_hari").slideUp();
	}
});

$(".btndetailretribusi_bulan").click(function(){
	if ( $( ".detailretribusi_bulan" ).is( ":hidden" ) ) {
		$(".detailretribusi_bulan").slideDown();
	}else{
		$(".detailretribusi_bulan").slideUp();
	}
});

// Grafik Kunjungan Baru & Lama
<?php
	$sql_kunjungan_bl = "SELECT StatusKunjungan, COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$hariini' GROUP BY StatusKunjungan";
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
			borderWidth: 1
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


<!--Grafik UKP & UKM-->
<?php
	$sql = "SELECT COUNT(IdPasienrj)AS Jumlah, AsalPasien FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' GROUP BY AsalPasien";
?>
var ctx = document.getElementById("Grafik_Kunjungan").getContext('2d');
var Grafik_Kunjungan = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: [
				<?php   
					$query = mysqli_query($koneksi,$sql) or die(mysqli_error());         
					while($ambil = mysqli_fetch_array($query)){
						$sql_aslps = "SELECT * FROM tbasalpasien WHERE Id = '$ambil[AsalPasien]'";
						$query_aslps = mysqli_query($koneksi, $sql_aslps);
						$dt = mysqli_fetch_assoc($query_aslps);
						echo "'".$dt['AsalPasien']."', ";
					} 
				?>
				],
		datasets: [{
			label: 'Kunjungan UKP & UKM Bulan <?php echo nama_bulan(date('m'));?>',
			data:[
				<?php   
					$query = mysqli_query($koneksi,$sql) or die(mysqli_error());         
					while($ambil = mysqli_fetch_array($query)){
						echo $ambil['Jumlah'].', ';
					} 
				?>
				],
				backgroundColor: [
				<?php
				for($i =0; $i < mysqli_num_rows($query); $i++){
				?>
					'rgba(175, 238, 247, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i =0; $i < mysqli_num_rows($query_aslps); $i++){
			?>
				'rgba(114, 211, 224, 1)',
			<?php
			}
			?>
			],
			borderWidth: 1
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
	$sql_jaminan = "SELECT Asuransi, COUNT(IdPasienrj)AS Jumlah FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$hariini' GROUP BY Asuransi";
		
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
			borderWidth: 1
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
<!--Grafik Sakit & Sehat-->
<?php
	$sql_sakit_sehat = "SELECT COUNT(IdPasienrj) AS Jumlah, StatusPasien FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$hariini' GROUP BY StatusPasien";
?>
var ctx = document.getElementById("Grafik_Sakit_Sehat").getContext('2d');
var Grafik_Sakit_Sehat = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: ['Sakit','Sehat'				
				],
		datasets: [{
			label: 'Kunjungan Sakit & Sehat Hari Ini',
			data:[
				<?php   
					$query_sakit_sehat = mysqli_query($koneksi,$sql_sakit_sehat) or die(mysqli_error());         
					while($ambil = mysqli_fetch_array($query_sakit_sehat)){
						echo $ambil['Jumlah'].', ';
					} 
				?>
				],
				backgroundColor: [
				<?php
				for($i =0; $i < mysqli_num_rows($query_sakit_sehat); $i++){
				?>
					'rgba(175, 238, 247, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i =0; $i < mysqli_num_rows($query_sakit_sehat); $i++){
			?>
				'rgba(114, 211, 224, 1)',
			<?php
			}
			?>
			],
			borderWidth: 1
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
	WHERE YEAR(`TanggalDiagnosa`)='$tahun' AND `KodeDiagnosa` <> 'Z00.0'
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
			borderWidth: 1
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
						$sql_poli = mysqli_query($koneksi,"SELECT COUNT(IdPasienrj)AS Jml, PoliPertama FROM `$tbpasienrj` WHERE TanggalRegistrasi = curdate() AND StatusPasien = '1' group by PoliPertama");
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
	

