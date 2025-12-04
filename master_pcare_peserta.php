<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>JUMLAH PESERTA TERDAFTAR</b></h3>
			<form class="form-horizontal" action="master_pcare_peserta_proses.php" method="post" role="form">	
				<table class="table-judul">
					<thead>
						<tr>
							<th width="10%" rowspan="2">NAMA PUSKESMAS</th>
							<th colspan="12">JUMLAH PESERTA</th>
						</tr>
						<tr>
							<?php
							for($bln = 1; $bln <= 12;$bln++){
								echo "<th>".nama_bulan_singkat($bln)."</th>";
							}
							?>
						</tr>
					</thead>
					<tbody>
						<?php
						$str = "SELECT * FROM `tbpuskesmasdetail` WHERE `KodePuskesmas` = '$kodepuskesmas'";
						$query = mysqli_query($koneksi, $str);					
							while($data = mysqli_fetch_assoc($query)){
								
						?>		
						<tr>
							<td><?php echo $namapuskesmas;?></td>
							<td><input type="text" name="jumlah01" style="text-transform: uppercase;" class="form-control" value=<?php echo $data['JumlahPeserta_01'];?>></td>
							<td><input type="text" name="jumlah02" style="text-transform: uppercase;" class="form-control" value=<?php echo $data['JumlahPeserta_02'];?>></td>
							<td><input type="text" name="jumlah03" style="text-transform: uppercase;" class="form-control" value=<?php echo $data['JumlahPeserta_03'];?>></td>
							<td><input type="text" name="jumlah04" style="text-transform: uppercase;" class="form-control" value=<?php echo $data['JumlahPeserta_04'];?>></td>
							<td><input type="text" name="jumlah05" style="text-transform: uppercase;" class="form-control" value=<?php echo $data['JumlahPeserta_05'];?>></td>
							<td><input type="text" name="jumlah06" style="text-transform: uppercase;" class="form-control" value=<?php echo $data['JumlahPeserta_06'];?>></td>
							<td><input type="text" name="jumlah07" style="text-transform: uppercase;" class="form-control" value=<?php echo $data['JumlahPeserta_07'];?>></td>
							<td><input type="text" name="jumlah08" style="text-transform: uppercase;" class="form-control" value=<?php echo $data['JumlahPeserta_08'];?>></td>
							<td><input type="text" name="jumlah09" style="text-transform: uppercase;" class="form-control" value=<?php echo $data['JumlahPeserta_09'];?>></td>
							<td><input type="text" name="jumlah10" style="text-transform: uppercase;" class="form-control" value=<?php echo $data['JumlahPeserta_10'];?>></td>
							<td><input type="text" name="jumlah11" style="text-transform: uppercase;" class="form-control" value=<?php echo $data['JumlahPeserta_11'];?>></td>
							<td><input type="text" name="jumlah12" style="text-transform: uppercase;" class="form-control" value=<?php echo $data['JumlahPeserta_12'];?>></td>
							</tr>
						<?php
							}	
						?>	
					</tbody>
				</table><hr/>
				<button type="submit" class="btn btn-round btn-success btnsimpan">Simpan</button>
			</form>	
		</div>
	</div><br/>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<p>
					<b>Perhatikan :</b><br/>
					Silahkan isi jumlah Peserta BPJS lalu klik tombol Simpan<br/>
					Untuk mengetahui jumlah Peserta BPJS buka aplikasi PCare klik menu Lihat Data -> Peserta Terdaftar 
				</p>
			</div>
		</div>
	</div>
</div>
<div class="hasilmodal"></div>
	
