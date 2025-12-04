<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
	$bulan = date('m');
	$tahun = date('Y');
?>
<div class="widget-body">
	<div class="widget-main no-padding">
		<table class="table-judul">
			<thead class="thin-border-bottom">
				<tr>
					<th>Ruang Pelayanan (Poli)</th>
					<th>Jumlah</th>
					<th class="hidden-480">Opsi</th>
				</tr>
			</thead>
			
			<tbody>
				<?php
					// asalpasien puskesmas (10)
					$strpasien = "SELECT PoliPertama, COUNT(NoRegistrasi)AS JumlahBi FROM `$tbpasienrj`
					WHERE MONTH(TanggalRegistrasi)='$bulan' and YEAR(TanggalRegistrasi)='$tahun' AND `StatusPelayanan`='Antri' AND `AsalPasien`='10' GROUP BY PoliPertama";
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
						and StatusPelayanan='Antri' AND `AsalPasien`='10'";
						$query_blm = mysqli_query($koneksi,$str_blm);
						$data_pasien_blm = mysqli_fetch_assoc($query_blm);
					?>
					<td><b>Total Belum di Entry</b></td>
					<td align="right"><?php echo round($data_pasien_blm['Jumlah'],0)?></td>
				</tr>
				<tr>
					<?php
						$str_sdh ="SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbpasienrj`
						WHERE SUBSTRING(NoRegistrasi,1,11) ='$kodepuskesmas' and YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan'
						and StatusPelayanan='Sudah' AND `AsalPasien`='10'";
						$query_sdh = mysqli_query($koneksi,$str_sdh);
						$data_pasien_sdh = mysqli_fetch_assoc($query_sdh);
					?>
					<td><b>Total Sudah di Entry</b></td>
					<td align="right"><?php echo round($data_pasien_sdh['Jumlah'],0)?></td>
				</tr>				
			</tbody>
		</table>
	</div>
</div>