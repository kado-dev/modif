<!doctype html>
<html lang="en">
<head>
	<style>	
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
	</style>
</head>
<body>
<?php
	error_reporting(0);
	session_start();
	date_default_timezone_set('Asia/Jakarta');
	include "config/helper_pasienrj.php";
	$bulan = date('m');
	$bulans = $bulan + 1;
	$tahun = date('Y');
	$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<a href="index.php?page=dashboard" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
	<h3 class="judul"><b>PASIEN BELUM ENTRY</b></h3>
	<div class="formbg">
		<div class="kolom_danger" style="cursor:pointer;"><i class="fa fa-arrow-down">&nbsp&nbsp</i>Bulan Ini</div>
		<div style="clear:both">
			<div class="table-responsive"><br/>
				<table class="table-judul" width="100%">
					<thead class="thead-dark">
						<tr>
							<th>RUANG PELAYANAN</th>
							<th>JUMLAH</th>
							<th class="hidden-480">#</th>
						</tr>
					</thead>
					<tbody>
						<?php
							// asalpasien puskesmas (10)
							$strpasien = "SELECT PoliPertama, COUNT(NoRegistrasi)AS JumlahBi FROM `$tbpasienrj`
							WHERE MONTH(TanggalRegistrasi)='$bulan' and YEAR(TanggalRegistrasi)='$tahun' AND `StatusPelayanan`='Antri' AND `AsalPasien`='10' AND `StatusPasien`='1' GROUP BY PoliPertama";
							$querypasien = mysqli_query($koneksi,$strpasien);
							while ($datapasien = mysqli_fetch_assoc($querypasien)){
						?>
						<tr>
							<td><?php echo $datapasien['PoliPertama']?></td>
							<td align="right"><?php echo round($datapasien['JumlahBi'],0)?></td>
							<td align="center">
								<!--<a href="?page=poli&pelayanan=<?php echo $datapasien['PoliPertama']?>&status=Antri&tptgl=Yes" class="btn btn-sm btn-white">Lihat</a>-->
								<a href="?page=poli&pelayanan=<?php echo $datapasien['PoliPertama']?>&status=Antri&tptgl=No" class="btn btn-sm btn-white">Lihat</a>
							</td>
						</tr>
						<?php
							}
						?>
						<tr>
							<?php
								$str_blm ="SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbpasienrj`
								WHERE SUBSTRING(NoRegistrasi,1,11) ='$kodepuskesmas' and YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan'
								and StatusPelayanan='Antri' AND `AsalPasien`='10' AND `StatusPasien`='1'";
								$query_blm = mysqli_query($koneksi,$str_blm);
								$data_pasien_blm = mysqli_fetch_assoc($query_blm);
							?>
							<td><b>Total Belum di Entry</b></td>
							<td align="right" colspan="2"><?php echo round($data_pasien_blm['Jumlah'],0)?></td>
						</tr>
						<tr>
							<?php
								$str_sdh ="SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbpasienrj`
								WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan'
								and StatusPelayanan='Sudah' AND `AsalPasien`='10' AND `StatusPasien`='1'";
								$query_sdh = mysqli_query($koneksi,$str_sdh);
								$data_pasien_sdh = mysqli_fetch_assoc($query_sdh);
							?>
							<td><b>Total Sudah di Entry</b></td>
							<td align="right" colspan="2"><?php echo round($data_pasien_sdh['Jumlah'],0)?></td>
						</tr>				
					</tbody>
				</table>
			</div>
		</div><br/>
		
		<div class="kolom_danger btndetail_bulan_lalu" style="cursor:pointer;"><i class="fa fa-arrow-down">&nbsp&nbsp</i>Bulan Lalu</div>
		<div class="detail_bulan_lalu" style="display:none;clear:both">
			<div class="table-responsive"><br/>
				<table class="table-judul" width="100%">
					<thead class="thead-dark">
						<tr>
							<th>Bulan</th>
							<th>Jumlah</th>
							<th class="hidden-480">Opsi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						for($i = 1; $i < $bulans; $i++){
						?>
							<tr>
								<?php
									if(strlen($i) == 1){
										$ib = "0".$i;
									}else{
										$ib = $i;
									}
									// echo $ib;
									// $tbpasienrj = 'tbpasienrj_'.$ib;
									$str = "SELECT * FROM `$tbpasienrj`
									WHERE MONTH(TanggalRegistrasi)='$ib' and YEAR(TanggalRegistrasi)='$tahun' and StatusPelayanan='Antri' AND `StatusPasien`='1';";
									// echo $str;
									$bulan = mysqli_num_rows(mysqli_query($koneksi,$str));
								?>
								<td><?php echo nama_bulan($i);?></td>
								<td align="right"><?php echo round($bulan,0)?></td>
								<td align="right">
									<a href="?page=poli_antri_bulan&bulan=<?php echo $ib;?>" class="btn btn-sm btn-white">Lihat</a>
								</td>
							</tr>
						<?php
						}
						?>	
						</tbody>
				</table>
			</div>
		</div><br/>
		
		<div class="kolom_danger btndetail_tahun" style="cursor:pointer;"><i class="fa fa-arrow-down">&nbsp&nbsp</i>Tahun <?php echo date('Y')?></div>
		<div class="detail_tahun" style="display:none;clear:both">
			<div class="table-responsive"><br/>
				<table class="table-judul" width="100%">
					<thead class="thead-dark">
						<tr>
							<th>Bulan</th>
							<th>Jumlah</th>
							<th class="hidden-480">Opsi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// for($i = 1; $i < $bulans; $i++){
						$mulai = 1;
						$selesai = 12;
						for($i = $mulai;$i <= $selesai; $i++){		
						?>
							<tr>
								<?php
									if(strlen($i) == 1){
										$ib = "0".$i;
									}else{
										$ib = $i;
									}
									// echo $ib;
									// $tbpasienrj = 'tbpasienrj_'.$ib;
									$str = "SELECT * FROM `$tbpasienrj`
									WHERE MONTH(TanggalRegistrasi)='$ib' and YEAR(TanggalRegistrasi)='$tahun' and StatusPelayanan='Antri' AND `StatusPasien`='1';";
									// echo $str;
									$bulan = mysqli_num_rows(mysqli_query($koneksi,$str));
								?>
								<td><?php echo nama_bulan($i);?></td>
								<td align="right"><?php echo round($bulan,0)?></td>
								<td align="right">
									<a href="?page=poli_antri_bulan&bulan=<?php echo $ib;?>" class="btn btn-sm btn-white">Lihat</a>
								</td>
							</tr>
						<?php
						}
						?>	
						</tbody>
				</table>
			</div>			
		</div><br/>

		<?php $tahunlalu = date('Y') - 1; ?>
		<div class="kolom_danger btndetail_tahun_lalu" style="cursor:pointer;"><i class="fa fa-arrow-down">&nbsp&nbsp</i>Tahun <?php echo $tahunlalu;?></div>
		<div class="detail_tahun_lalu" style="display:none;clear:both">
			<div class="table-responsive"><br/>
				<table class="table-judul" width="100%">
					<thead class="thead-dark">
						<tr>
							<th>Bulan</th>
							<th>Jumlah</th>
							<th class="hidden-480">Opsi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// for($i = 1; $i < $bulans; $i++){
						$mulai = 1;
						$selesai = 12;
						for($i = $mulai;$i <= $selesai; $i++){		
						?>
							<tr>
								<?php
									if(strlen($i) == 1){
										$ib = "0".$i;
									}else{
										$ib = $i;
									}
									// echo $ib;
									// $tbpasienrj = 'tbpasienrj_'.$ib;
									$str = "SELECT * FROM `$tbpasienrj`
									WHERE MONTH(TanggalRegistrasi)='$ib' and YEAR(TanggalRegistrasi)='$tahunlalu' and StatusPelayanan='Antri' AND `StatusPasien`='1';";
									// echo $str;
									$bulan = mysqli_num_rows(mysqli_query($koneksi,$str));
								?>
								<td><?php echo nama_bulan($i);?></td>
								<td align="right"><?php echo round($bulan,0)?></td>
								<td align="right">
									<a href="?page=poli_antri_tahun_lalu&bulan=<?php echo $ib;?>&tahunlalu=<?php echo $tahunlalu;?>" class="btn btn-sm btn-white">Lihat</a>
								</td>
							</tr>
						<?php
						}
						?>	
						</tbody>
				</table>
			</div>
		</div><br/>
	</div>
</div>

<script src="assets/js/jquery.js"></script>
<script>
	$(".btndetail_bulan_lalu").click(function(){
		if ( $( ".detail_bulan_lalu" ).is( ":hidden" ) ) {
			$(".detail_bulan_lalu").slideDown();
		}else{
			$(".detail_bulan_lalu").slideUp();
		}
	});
	$(".btndetail_tahun").click(function(){
		if ( $( ".detail_tahun" ).is( ":hidden" ) ) {
			$(".detail_tahun").slideDown();
		}else{
			$(".detail_tahun").slideUp();
		}
	});
	$(".btndetail_tahun_lalu").click(function(){
		if ( $( ".detail_tahun_lalu" ).is( ":hidden" ) ) {
			$(".detail_tahun_lalu").slideDown();
		}else{
			$(".detail_tahun_lalu").slideUp();
		}
	});
</script>
