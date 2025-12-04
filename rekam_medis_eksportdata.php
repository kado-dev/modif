<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>EKSPORT DATA PASIEN</b></h3>
			<div class="formbg">
				<form class="form-horizontal" action="rekam_medis_eksportdata_proses.php" method="post" role="form">
					<table class="table-judul" width="100%">					
						<tr>
							<td>Opsi</td>
							<td>
								<!-- <div class="input-group"> -->
									<select name="tblopsi" class="form-control tblopsicls">
										<option value="tbpasien">Tabel Pasien</option>
										<option value="tbkk">Tabel KK</option>
									</select>
									<!-- <div class="input-group-append">
										<span class="input-group-text">Pilih</span>
									</div>
								</div>	 -->
							</td>
						</tr>
						<tr class="tmpthn">
							<td>Tahun</td>
							<td>
								<?php
									$totaldata_tujuan_sum = 0;
									$tbtujuan = "tbpasien_".str_replace(' ', '', $namapuskesmas);
									for($th = 2013; $th <= date('Y'); $th++){
										$tbasaltahun = "tbpasien_".$th;
										if(mysqli_num_rows(mysqli_query($koneksi,"SHOW TABLES LIKE '$tbasaltahun'")) > 0){
											$totaldata = mysqli_num_rows(mysqli_query($koneksi,"SELECT NoCM FROM $tbasaltahun WHERE SUBSTRING(`NoCM`,1,11) = '$kodepuskesmas' AND YEAR(TanggalDaftar) = '$th'"));

											$totaldata_tujuan = mysqli_num_rows(mysqli_query($koneksi,"SELECT NoCM FROM $tbtujuan WHERE YEAR(TanggalDaftar) = '$th'"));
											$totaldata_tujuan_sum = $totaldata_tujuan_sum + $totaldata_tujuan;
								?>
								  <input class="form-check-input" type="checkbox" name="tahun[]" value="<?php echo $th ?>" id="tahun_<?php echo $th ?>" <?php if($totaldata_tujuan >= $totaldata){echo "checked";}?>>
								  <label class="form-check-label" for="tahun_<?php echo $th ?>">
								    Tahun <?php echo $th ?> (Data Tujuan: <?php echo $totaldata_tujuan;?>)
								  </label><br/>
								<?php
										}
									}
								?>
							</td>
						</tr>
						<tr class="tmpthn">
							<td>Jumlah Data</td>
							<td>
								<?php echo $totaldata_tujuan_sum;?>
							</td>
						</tr>
						<tr class="tmptbkk" style="display:none">
							<td>Keterangan</td>
							<td>
								<?php 
								$tbkk = "tbkk_".str_replace(' ', '', $namapuskesmas);
								$totaldata_tbkk = mysqli_num_rows(mysqli_query($koneksi,"SELECT NoIndex FROM tbkk WHERE SUBSTRING(`NoIndex`,3,11) = '$kodepuskesmas'"));
								$totaldata_tujuan_tbkk = mysqli_num_rows(mysqli_query($koneksi,"SELECT NoIndex FROM $tbkk WHERE SUBSTRING(`NoIndex`,3,11) = '$kodepuskesmas'"));
								?>
								tbkk (Data Asal: <?php echo $totaldata_tbkk;?>), (Data Tujuan: <?php echo $totaldata_tujuan_tbkk;?>)
							</td>
						</tr>
						<tr class="tmptbkk" style="display:none">
							<td>Jumlah Data</td>
							<td>
								<?php 
								$tbkk = "tbkk_".str_replace(' ', '', $namapuskesmas);
								$totaldata_tujuan_tbkk = mysqli_num_rows(mysqli_query($koneksi,"SELECT NoIndex FROM $tbkk WHERE SUBSTRING(`NoIndex`,3,11) = '$kodepuskesmas'"));
								echo $totaldata_tujuan_tbkk;
								?>
							</td>
						</tr>
					</table><hr>
					<button type="submit" class="btn btn-round btn-success btnsimpan">SIMPAN</button>
				</form>
			</div>	
		</div>
	</div>
</div>
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>
	$(".tblopsicls").change(function(){
		var is = $(this).val();
		if(is == 'tbkk'){
			$(".tmpthn").hide();
			$(".tmptbkk").show();
		}else{
			$(".tmpthn").show();
			$(".tmptbkk").hide();
		}
	});
</script>