<div class="tableborderdiv">
	<h3 class="judul"><b>LPLPO PUSKESMAS</b></h3>
	<div class="formbg">
		<div class="row">
			<form role="form">
				<input type="hidden" name="page" value="dashboard_lplpo_bandungkab"/>
				<div class="col-sm-2">
					<select name="bulan" class="form-control">
						<option value="01" <?php if($_GET['bulan'] == '01'){echo "SELECTED";}?>>Januari</option>
						<option value="02" <?php if($_GET['bulan'] == '02'){echo "SELECTED";}?>>Februari</option>
						<option value="03" <?php if($_GET['bulan'] == '03'){echo "SELECTED";}?>>Maret</option>
						<option value="04" <?php if($_GET['bulan'] == '04'){echo "SELECTED";}?>>April</option>
						<option value="05" <?php if($_GET['bulan'] == '05'){echo "SELECTED";}?>>Mei</option>
						<option value="06" <?php if($_GET['bulan'] == '06'){echo "SELECTED";}?>>Juni</option>
						<option value="07" <?php if($_GET['bulan'] == '07'){echo "SELECTED";}?>>Juli</option>
						<option value="08" <?php if($_GET['bulan'] == '08'){echo "SELECTED";}?>>Agustus</option>
						<option value="09" <?php if($_GET['bulan'] == '09'){echo "SELECTED";}?>>September</option>
						<option value="10" <?php if($_GET['bulan'] == '10'){echo "SELECTED";}?>>Oktober</option>
						<option value="11" <?php if($_GET['bulan'] == '11'){echo "SELECTED";}?>>November</option>
						<option value="12" <?php if($_GET['bulan'] == '12'){echo "SELECTED";}?>>Desember</option>
					</select>
				</div>
				<div class="col-sm-1" style ="width:125px">
					<select name="tahun" class="form-control">
						<?php
							for($tahun = 2018 ; $tahun <= date('Y'); $tahun++){
							?>
							<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
						<?php }?>
					</select>
				</div>
				<div class="col-sm-8">
					<button type="submit" class="btn btn-warning btn-white"><span class="fa fa-search"></span></button>
					<a href="?page=dashboard_lplpo_bandungkab" class="btn btn-success btn-white"><span class="fa fa-refresh"></span></a>
					<a href="javascript:print()" class="btn btn-primary btn-white"><span class="fa fa-print noprint"></span></a>
				</div>
			</form>
		</div>
	</div>
	<?php
		$hariini = date('Y-m-d');
		$tahun = $_GET['tahun'];
		$bulan = $_GET['bulan'];		
		
		if(isset($bulan) and isset($tahun)){
	?>	
			
	<div class="row">
		<div class="col-lg-12">
			<div class="kotakgrafik">
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-striped table-condensed table-bordered table-judul">
							<thead>
								<tr>
									<th width='5%'>No.</td>
									<th width='10%'>Kode</td>
									<th width='25%'>Puskesmas</td>
									<th width='35%'>Apoteker</td>
									<th width='15%'>Kontak</td>
									<th width='10%'>Status Upload</td>
								</tr>
							</thead>
							<tbody>
								<?php
								$no = 0;
								$str_lplpo = "SELECT * FROM tbpuskesmas 
								WHERE (Namapuskesmas != 'UPTD FARMASI' AND Namapuskesmas != 'DINAS KESEHATAN' AND `Kota`='$kota') ORDER BY NamaPuskesmas";
								$query_rko = mysqli_query($koneksi,$str_lplpo);
								while($data_lplpo = mysqli_fetch_assoc($query_rko)){
									$no = $no + 1;
								?>
									<tr>
										<td style="text-align:right;"><?php echo $no;?></td>
										<td style="text-align:center;"><?php echo $data_lplpo['KodePuskesmas'];?></td>
										<td><?php echo $data_lplpo['NamaPuskesmas'];?></td>
										<td>
											<?php
												// data apoteker										
												$dtapoteker = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaPegawai`,`Telepon` FROM `tbpegawai` WHERE `status` = 'APOTEKER' AND `KodePuskesmas`='$data_lplpo[KodePuskesmas]'"));
												echo $dtapoteker['NamaPegawai'];
											?>
										</td>
										<td align="center"><?php echo $dtapoteker['Telepon'];?></td>
										<td align="center">
											<?php
												$tblplpomanual_bandungkab = "tblplpomanual_bandungkab_".$data_lplpo['KodePuskesmas'];
												$strlplpo = "SELECT COUNT(*) AS JumlahItem FROM `$tblplpomanual_bandungkab` 
												WHERE `KodePuskesmas` = '$data_lplpo[KodePuskesmas]' AND `Bulan`='$bulan' AND `Tahun`='$tahun' AND (StokAwal <> '' OR Pemakaian <> '');";
												// echo $strlplpo;
												$dtlplpo = mysqli_fetch_assoc(mysqli_query($koneksi, $strlplpo));
												if($dtlplpo['JumlahItem'] > 25){
											?>		
												<a href="?page=lap_farmasi_lplpo_puskesmas&kodepuskesmas=<?php echo $data_lplpo['KodePuskesmas'];?>&bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>&sumberanggaran=<?php echo "APBD KAB/KOTA";?>" target="_blank" class="btn btn-sm btn-success">Sudah</a>
											<?php
												}else{
											?>
												<a href="?page=lap_farmasi_lplpo_puskesmas&kodepuskesmas=<?php echo $data_lplpo['KodePuskesmas'];?>&bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>&sumberanggaran=<?php echo "APBD KAB/KOTA";?>" target="_blank" class="btn btn-sm btn-danger">Belum</a>
											<?php		
												}	
											?>
										</td>
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
	</div>
	<?php } ?>
</div>	

