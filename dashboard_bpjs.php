<!doctype html>
<html lang="en">
<head>
	<style>	
	.kotak_panels{
		padding: 25px 20px;
		border-radius: 6px;
		margin-top: 15px;
		margin-bottom: 15px;
	}
	.bg{
		background: linear-gradient(0deg, rgba(178, 212, 255, 0.7), rgba(255, 255, 255, 0.9));
		background-repeat: no-repeat;
		background-size: 100%;
		background-position: center;
		box-shadow: 0 5px 10px -5px #848484;
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
		background: linear-gradient(0deg, rgba(28, 126, 255, 0.9), rgba(0, 87, 201, 0.9));
		background-repeat: no-repeat;
		background-size: 100%;
		background-position: center;
		box-shadow: 0 5px 10px -5px #848484;
	}
	.divscroll{
		background: #f3f3f3;
		margin: 10px 4px;
		box-shadow:0px 0px 12px #9e9e9e;
		overflow: auto;
	}
	.kotak_panel_detail{
		width: 100%;
		background: #fff;
		margin-top: 0px;	
	}
	.kotak_panel_detail tr td{
		padding: 4px 10px;font-size: 13px;
	}
	.kotak_panel_detail tr:first-child td{
		padding-top: 10px;
	}
	.kotak_panel_detail tr:last-child td{
		padding-bottom: 15px;
	}
	.kotak_panel_detail tr td:first-child{font-weight: bold;vertical-align: bottom; }
	.kotak_panel_detail tr td:last-child{color: #454545;}
	.kotak_panel_detail tr td p{
		text-align: right;
	}
	.progress{
		margin-bottom: 0px;height: 12px
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
	.panel_update{
		padding:38px 20px;text-align: left;font-weight: normal;font-size: 22px;
		margin-bottom: 0px;border-radius: 10px 10px 0px 0px;margin-top: 20px;color: #fff;
		background: linear-gradient(0deg, rgba(49, 89, 253, 0.9), rgba(49, 89, 253, 0.9)), url('image/bg-title-01.jpg');
		background-repeat: no-repeat;
		background-size: 100%;
		background-position: center;
	}
	.update_list{
		border-bottom: 1px solid #eee;
		padding: 22px 30px;background: #fff;
	}
	.update_list:hover{
		background: #f9f9f9;
	}
	.update_list.biru{
		border-left:4px solid #009ac8;
	}
	.update_list.kuning{
		border-left:4px solid #ffe66b;
	}
	.update_list.merah{
		border-left:4px solid #ff6696;
	}
	.update_list.ijo{
		border-left:4px solid #40a05e;
	}
	.update_list p{
		margin-bottom: 0px;font-size: 14px;color:#545454;
	}
	.update_list span{
		font-size: 16px; font-weight: bold;
	}
	.widget-header{
		margin-bottom: 10px
	}
	.panel_informasi{
		padding:38px 20px;text-align: left;font-weight: normal;font-size: 22px;
		margin-bottom: 0px;border-radius: 10px 10px 0px 0px;margin-top: 20px;color: #fff;
		background: linear-gradient(0deg, rgba(219, 52, 55, 0.8), rgba(219, 52, 55, 0.8)), url('image/bg-title-02.jpg');
		background-repeat: no-repeat;
		background-size: 100%;
		background-position: center;
	}
	.panel_jadwal{
		padding:38px 20px;text-align: left;font-weight: normal;font-size: 22px;
		margin-bottom: 0px;border-radius: 10px 10px 0px 0px;margin-top: 20px;color: #fff;
		background: linear-gradient(0deg, rgba(77, 158, 55, 0.8), rgba(77, 158, 55, 0.8)), url('image/bg-title-02.jpg');
		background-repeat: no-repeat;
		background-size: 100%;
		background-position: center;
	}
	.kolom_warning{
		background: #edc9c9;
		border-radius: 8px;
		padding: 12px 12px;
		margin-bottom: 10px;
		font-size: 16px;
	}
	.kolom_danger{
		background: #fbff3f;
		border-radius: 8px;
		padding: 12px 12px;
		margin-bottom: 10px;
		font-size: 16px;
		-webkit-animation: myanimation 1s infinite;  /* Safari 4+ */
		  -moz-animation: myanimation 1s infinite;  /* Fx 5+ */
		  -o-animation: myanimation 1s infinite;  /* Opera 12+ */
		  animation: myanimation 1s infinite;
	}
	@-webkit-keyframes myanimation {
	  0%, 49% {
	    background: #fff;
	  }
	  50%, 100% {
	    background: #fbff3f;
	  }
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
	$hariini = date('Y-m-d');
	$hariini2 = date('ymd');
	$hariini3 = date('ym');
	
	if($_GET['bulan'] == null){
		$bln = date('m');
	}else{
		$bln = $_GET['bulan'];
	}	
	
	function progress_green($x,$tot){
		$persen = ($x * 100) / $tot;
		echo "<div class='progress'><div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='width: ".$persen."%' aria-valuenow='25' aria-valuemin='0' aria-valuemax='100'></div></div>";
	}	
	
	// kunjungan hari
	$kunj_hari = mysqli_num_rows(mysqli_query($koneksi, "SELECT `IdPasienrj` FROM `$tbpasienrj` WHERE date(TanggalRegistrasi) = curdate() AND (Asuransi like 'BPJS%') AND `StatusPelayanan` = 'Sudah' AND `NoUrutBpjs` != ''"));
	$sakit_hari = mysqli_num_rows(mysqli_query($koneksi, "SELECT `IdPasienrj` FROM `$tbpasienrj` WHERE date(TanggalRegistrasi) = curdate() AND (Asuransi like 'BPJS%') AND `StatusPelayanan` = 'Sudah' AND `NoUrutBpjs` != '' AND StatusPasien = '1'"));
	$sehat_hari = mysqli_num_rows(mysqli_query($koneksi, "SELECT `IdPasienrj` FROM `$tbpasienrj` WHERE date(TanggalRegistrasi) = curdate() AND (Asuransi like 'BPJS%') AND `StatusPelayanan` = 'Antri' AND `NoUrutBpjs` != '' AND StatusPasien = '2'"));
	
	// kunjungan bulan
	$kunj_bulan = mysqli_num_rows(mysqli_query($koneksi, "SELECT `IdPasienrj` FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bln' AND (Asuransi like 'BPJS%') AND `NoUrutBpjs` != ''"));
	$sakit_bulan = mysqli_num_rows(mysqli_query($koneksi, "SELECT `IdPasienrj` FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bln' AND (Asuransi like 'BPJS%') AND `StatusPelayanan` = 'Sudah' AND `NoUrutBpjs` != '' AND StatusPasien = '1'"));
	$sehat_bulan = mysqli_num_rows(mysqli_query($koneksi, "SELECT `IdPasienrj` FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bln' AND (Asuransi like 'BPJS%') AND `StatusPelayanan` = 'Antri' AND `NoUrutBpjs` != '' AND StatusPasien = '2'"));
	
?>

<div class="tableborderdiv">
	<!--grafik kasir-->
	<div class="row noprint" style="margin-top: -20px;">
		<div class="col-sm-12">
			<div class="kotak_panels bg">
				<div class="row noprint">
					<div class="col-sm-4">
						<div class="kotak_panels greens">
							<div data-toggle="modal" data-target="#modalpenerimaan">
								<i class="fa fa-arrow-down fa-3x" style="margin-top: 0px;"></i>
								<div class="fontpanel"><?php echo ($sakit_hari + $sehat_hari);?></div>
								<div class="ket">Kunjungan Peserta BPJS <br/> Hari ini Per-Kunjungan</div>
							</div>
						</div>
						<div class="divscroll">
							<table class="kotak_panel_detail">
								<tr>
									<td width="50%">KUNJUNGAN SAKIT</td>
									<td>
										<p><?php echo rupiah($sakit_hari);?></p>
										<?php progress_green($sakit_hari,$kunj_bulan)?>
									</td>
								</tr>
								<tr>
									<td width="50%">KUNJUNGAN SEHAT</td>
									<td>
										<p><?php echo rupiah($sehat_hari);?></p>
										<?php progress_green($sehat_hari,$kunj_bulan)?>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="kotak_panels greens">
							<div data-toggle="modal" data-target="#modalpenerimaan">
								<i class="fa fa-arrow-down fa-3x" style="margin-top: 0px;"></i>
								<div class="fontpanel"><?php echo rupiah($sakit_bulan + $sehat_bulan);?></div>
								<div class="ket"><?php echo "Kunjungan Peserta BPJS <br/> Bulan ".nama_bulan($bln);?> Per-Kunjungan</div>
							</div>
						</div>
						<div class="divscroll">
							<table class="kotak_panel_detail">
								<tr>
									<td width="50%">KUNJUNGAN SAKIT</td>
									<td>
										<p><?php echo rupiah($sakit_bulan);?></p>
										<?php progress_green($sakit_bulan,$kunj_bulan)?>
									</td>
								</tr>
								<tr>
									<td width="50%">KUNJUNGAN SEHAT</td>
									<td>
										<p><?php echo rupiah($sehat_bulan);?></p>
										<?php progress_green($sehat_bulan,$kunj_bulan)?>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="kotak_panels greens">
							<a href="?page=master_pcare_peserta" style="cursor:pointer">
								<i class="fa fa-arrow-down fa-3x" style="margin-top: 0px;"></i>
								<div class="fontpanel">
									<?php 
										$dilayani = mysqli_num_rows(mysqli_query($koneksi, "SELECT `IdPasienrj` FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' and MONTH(TanggalRegistrasi) = '$bln' AND (Asuransi like 'BPJS%') AND `NoUrutBpjs` != '' AND (StatusPasien = '1' OR StatusPasien = '2') GROUP BY noKartu, StatusPasien"));
										$sakit = mysqli_num_rows(mysqli_query($koneksi, "SELECT `IdPasienrj` FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' and MONTH(TanggalRegistrasi) = '$bln' AND (Asuransi like 'BPJS%') AND `StatusPelayanan` = 'Sudah' AND `NoUrutBpjs` != '' AND StatusPasien = '1' GROUP BY noKartu"));
										$sehat = mysqli_num_rows(mysqli_query($koneksi, "SELECT `IdPasienrj` FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' and MONTH(TanggalRegistrasi) = '$bln' AND (Asuransi like 'BPJS%') AND `NoUrutBpjs` != '' AND StatusPasien = '2' GROUP BY noKartu"));
									?>
									<span>
									<?php 
										// kontakrate
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
										$dt_kr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT $jmlpeserta AS Jml FROM `tbpuskesmasdetail` WHERE `KodePuskesmas` = '$kodepuskesmas'"));
										$jml_peserta = $dt_kr['Jml'];
										$persentase = ($dilayani * 100)/$jml_peserta;
										echo "(".substr($persentase,0,4)." %)";
									?>
									</span>
								</div>
								<div class="ket">Kontak Rate Pasien BPJS Per-Jiwa</div>
							</a>
						</div>
						<div class="divscroll">			
							<table class="kotak_panel_detail">
								<tr>
									<td width="50%">KUNJUNGAN SAKIT</td>
									<td>
										<p><?php echo rupiah($sakit);?></p>
										<?php progress_green($sakit,$dilayani)?>
									</td>
								</tr>
								<tr>
									<td width="50%">KUNJUNGAN SEHAT</td>
									<td>
										<p><?php echo rupiah($sehat);?></p>
										<?php progress_green($sehat,$dilayani)?>
									</td>
								</tr>
							</table>
						</div>	
					</div>

					<div class="col-sm-12 mt-5">		
						<form class="form-inline formcari">
							<input type="hidden" name="page" value="dashboard_bpjs"/>
							<select name="bulan" class="form-control" onchange="this.form.submit();" >
								<option value="01" <?php if($bln == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($bln == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($bln == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($bln == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($bln == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($bln == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($bln == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($bln == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($bln == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($bln == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($bln == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($bln == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</form>
					</div>
					<div class="col-sm-12">
						<div class="kotakgrafik" style="margin-top: 5px;">
							<div class="au-card m-b-30">
								<div class="au-card-inner">
									<canvas id="Grafik_Kunjungan" height="270px"></canvas>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="kotakgrafik" style="margin-top: 5px;">
							<div class="au-card m-b-30">
								<div class="au-card-inner">
									<canvas id="Grafik_Pelayanan_Bulan" height="370px"></canvas>
								</div>
							</div>
						</div>
					</div>			
				</div>
			</div>										
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
$(".tdkalender").click(function(){
	var isi = $(this).data('keterangan');
	var tgl = $(this).data('tgl');
	if(isi != ''){
		// alert(isi);
		$(".modalisi").html(isi+"<br/>"+tgl);
		$('#flashmodal').modal('show');
	}
});

var ctx = document.getElementById("Grafik_Kunjungan").getContext('2d');
var Grafik_Kunjungan = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: [
				<?php
					$hari_ini = date('Y')."-".$bln."-01";
					$mulai = 1;
					$selesai = date('t', strtotime($hari_ini));
					for($d = $mulai; $d <= $selesai; $d++){	
						echo '"'.$d.'", ';
					}
				?>
				],
		datasets: [{
			label: 'Jumlah Kunjungan Pasien BPJS <?php echo nama_bulan($bln);?>',
			data:[
				<?php
					$jml = 0;
					for($d = $mulai; $d <= $selesai; $d++){	
						$tanggal = $tahun."-".$bln."-".$d;
						$query_retribusi = mysqli_query($koneksi,"SELECT COUNT(`IdPasienrj`) AS JumlahKunjungan FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tanggal' AND `Asuransi` like 'BPJS%'");
						$jml = mysqli_fetch_assoc($query_retribusi);
						if ($jml['JumlahKunjungan'] != 0){
							$jml_kunj =  $jml['JumlahKunjungan'];
						}else{
							$jml_kunj = 0;
						}
						echo '"'.$jml_kunj.'", ';
					}		
				?>
				],
				backgroundColor: [
				<?php
				for($i = $mulai; $i <= $selesai; $i++){
				?>
					'rgba(14, 186, 46, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i = $mulai; $i <= $selesai; $i++){
			?>
				'rgba(0, 127, 23, 1)',
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

<!--Grafik Kunjungan Pelayanan Bulan-->
<?php
	$str_jaminan = "SELECT `PoliPertama`, COUNT(IdPasienrj)AS Jumlah
	FROM `$tbpasienrj` 
	WHERE YEAR(`TanggalRegistrasi`) = '$tahun' AND MONTH(`TanggalRegistrasi`) = '$bln'
	GROUP BY PoliPertama ORDER BY Jumlah DESC";
?>
var ctx = document.getElementById("Grafik_Pelayanan_Bulan").getContext('2d');
var Grafik_Pelayanan_Bulan = new Chart(ctx, {
	type: 'horizontalBar',
	data: {
		labels: [
				<?php   
					$query_jaminan = mysqli_query($koneksi, $str_jaminan) or die(mysqli_error());       
					while($ambil_jaminan = mysqli_fetch_array($query_jaminan)){
						echo '"'.$ambil_jaminan['PoliPertama'].'", ';
					} 
				?>
				],
		datasets: [{
			label: 'Jumlah Kunjungan Peserta BPJS Bulan <?php echo nama_bulan($bln);?>',
			data:[
				<?php
					$query_jaminan = mysqli_query($koneksi, $str_jaminan) or die(mysqli_error());
					while($ambil_jaminan = mysqli_fetch_array($query_jaminan)){
						echo $ambil_jaminan['Jumlah'].', ';
					} 
				?>
				],
				backgroundColor: [
				<?php
				for($i =0; $i < mysqli_num_rows($query_jaminan); $i++){
				?>
					'rgba(14, 186, 46, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i =0; $i < mysqli_num_rows($query_jaminan); $i++){
			?>
				'rgba(0, 127, 23, 0.6)',
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
</script>

<div class="modal fade" id="flashmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"> Info</h4>
			</div>
			<div class="modal-body modalisi">
			
			</div>
		</div>
	</div>
</div>
