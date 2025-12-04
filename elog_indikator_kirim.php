<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KIRIM INDIKATOR OBAT </b><small>Elogistics</small></h3>
			<div class="formbg">				
				<form action="elog_indikator_kirim_proses.php" method="post">
					<div class = "row">
						<table class="table-judul" width="100%">
							<tr>
								<td width="10%">Area</td>
								<td width="2%">:</td>
								<td>
									<select name="kodearea" class="col-sm-4">
										<option value="semua">Semua</option>
										<?php
										if($kodepuskesmas == '3204' or $kodepuskesmas == '3201' or $kodepuskesmas == '3216' or $kodepuskesmas == '-'){
											$kota = $_SESSION['kota'];
												$strtbpuskesmas = mysqli_query($koneksi,"SELECT * from tbpuskesmas Where Kota = '$kota' order by NamaPuskesmas");
												while($tbpus = mysqli_fetch_assoc($strtbpuskesmas)){
											?>
												<option value="<?php echo $tbpus['KodePuskesmas'];?>"><?php echo $tbpus['NamaPuskesmas'];?></option>
											<?php 
											}
										}else{
											echo "<option value='$kodepuskesmas'>$_SESSION[namapuskesmas]</option>";
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>Periode</td>
								<td>:</td>
								<td>
									<select name="bln" class="col-sm-1" style="margin-right: 10px;">
										<?php
										for($bln = 1;$bln<=12; $bln ++){
											$j = strlen($bln);
											if($j == 1){
												$bln = "0".$bln;
											}
											if($bln == date('m')){
												echo "<option value='$bln' SELECTED>$bln</option>";
											}else{
												echo "<option value='$bln'>$bln</option>";
											}
										}
										?>
						
									</select>
									<select name="thn" class="col-sm-1">
										<?php
											for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
											if($tahun == date('Y')){
										?>
											<option value="<?php echo $tahun;?>" SELECTED><?php echo $tahun;?></option>
										<?php }else{?>	
											<option value="<?php echo $tahun;?>"><?php echo $tahun;?></option>
										<?php 
											}
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>Type</td>
								<td>:</td>
								<td><?php echo "Obat Indikator Puskesmas";?></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td>
									<input type="submit" class="btn btn-round btn-info" value="Kirim">
								</td>
							</tr>
						</table>
					</div>	
				</form>
			</div>
			<!--<table class="table table-bordered table-condensed">
				<tr>
					<th>No</th>
					<th>ID Indikator</th>
					<th>Nama Indikator</th>
					<th>Sedia</th>
				</tr>
			<?php
			/**
				$query = mysqli_query($koneksi,"SELECT * FROM ref_obatindikator ORDER BY id_indikator ");
				$no = 0;
				foreach($query as $ti){
				$no = $no + 1;
				$id_indikator = $ti['id_indikator'];
					echo "<tr>";
					echo "<td>".$no."</td>";	
					echo "<td>".$ti['id_indikator']."</td>";	
					echo "<td>".$ti['nama_indikator']."</td>";	
					
					$str_gfk = "SELECT KodeBarang FROM tbgfkstok WHERE id_indikator = '$id_indikator'";
					// $str_gfk = "SELECT a.KodeBarang FROM `tbgudangpkmstok` a
					// JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang
					// WHERE b.id_indikator = '$id_indikator' AND a.KodePuskesmas = '$kodepuskesmas'";
					// echo $str_gfk;
					// die();
					$query_gfk = mysqli_query($koneksi,$str_gfk);
					$dt_gfk = mysqli_num_rows($query_gfk );
					if ($dt_gfk != 0){
						$status = 1;
					}else{
						$status = 0;
					}
					echo "<td>".$status."</td>";	
					echo "</tr>";
				}
				**/
			?>
			</table>-->
		</div>
	</div>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p>
					<a href="http://bankdataelog.kemkes.go.id/apps/" target="_blank" style="color: #000; font-weight: bold;">>> Lihat Bank Data Elogistik</a>
				</p>
			</div>
		</div>
	</div>
</div>


