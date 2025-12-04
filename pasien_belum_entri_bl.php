<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$bulan = date('m');
	$bulans = $bulan + 1;
	$tahun = date('Y');		
?>
<div class="widget-body">
	<div class="widget-main no-padding">
		<table class="table-judul">
			<thead class="thin-border-bottom">
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
						WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' and MONTH(TanggalRegistrasi)='$ib' and YEAR(TanggalRegistrasi)='$tahun' and StatusPelayanan='Antri';";
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
</div>