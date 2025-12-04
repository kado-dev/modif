<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
							
	$tahun = $_GET['tahun'];
	if($tahun == ''){
		$tahun = date('Y');
	}

	$bulan = $_GET['bulan'];
	if($bulan == ''){
		$bulan = date('m');
	}
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?page=lap_spm_indikator" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>INPUT LAP SPM 12 INDIKATOR</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_spm_indikator_input"/>
						<div class="col-sm-2">
							<select name="tahun" class="form-control" required>
								<option value="">Tahun</option>
								<?php
									for($thn = date('Y'); $thn > (date('Y') - 2); $thn--){
								?>
								<option value="<?php echo $thn;?>" <?php if ($tahun == $thn){echo 'SELECTED';}?>><?php echo $thn;?></option>
								<?php
									}
								?>
							</select>
						</div>
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
						<div class="col-sm-8">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>

	<!--data-->
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<form action="?page=lap_spm_indikator_input_proses" method="post">				
				<table class="table-judul" border="1">
					<thead>
						<tr>
							<th width="5%">NO</th>
							<th width="70%">URAIAN</th>
							<th width="15%">JUMLAH</th>
							<th width="15%">CAKUPAN(%)</th>
						</tr>
					</thead>
					<tbody font="8">
						<?php
						$tahun = $_GET['tahun'];
						$bulan = $_GET['bulan'];
						$str = "SELECT * FROM  `tbspmindikator` ORDER by idspmindikator ASC";
						$query = mysqli_query($koneksi,$str);
						$no = 0;
						while($data = mysqli_fetch_assoc($query)){
							$no++;
							$getvalue = mysqli_query($koneksi, "SELECT * FROM `tbspmindikator_laporan` WHERE `idspmindikator`= '$data[idspmindikator]' AND `KodePuskesmas` = '$kodepuskesmas' AND `tahun` = '$tahun' AND `bulan` = '$bulan' ORDER by waktu DESC");
							// echo "SELECT * FROM `tbspmindikator_laporan` WHERE `idspmindikator`= '$data[idspmindikator]' AND `KodePuskesmas` = '$kodepuskesmas' AND `tahun` = '$tahun' AND `bulan` = '$bulan' ORDER by waktu DESC";
							$jumlah_d = '';
							$jumlah_s = '';
							$cakupan = '';

							if(mysqli_num_rows($getvalue) > 0){
								$dtget = mysqli_fetch_assoc($getvalue);
								$jumlah_d = $dtget['jumlah_d'];
								$jumlah_s = $dtget['jumlah_s'];
								$cakupan = $dtget['cakupan'];
							}
						?>
							<input type="hidden" name="idspmindikator[]" value="<?php echo $data['idspmindikator'];?>"/>
							<tr style="background: #b6e0d4">
								<td align="center"><?php echo $no;?></td>		
								<td align="left" colspan="3"><?php echo $data['indikator'];?></td>		
							</tr>
							<tr>
								<td align="center">C</td>		
								<td align="left"><?php echo $data['detail_d'];?></td>		
								<td align="center"><input type="text" name="jumd[<?php echo $data['idspmindikator'];?>]" class="jumd" value="<?php echo $jumlah_d;?>"/></td>		
								<td align="center" valign="middle" rowspan="2">
									<?php echo $cakupan;?>%
								</td>		
							</tr>
							<tr>
								<td align="center">T</td>		
								<td align="left"><?php echo $data['detail_s'];?></td>		
								<td align="center"><input type="text" name="jums[<?php echo $data['idspmindikator'];?>]" class="jums" value="<?php echo $jumlah_s;?>"/></td>	
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
				<br/>
				<input type="hidden" name="bulan" value="<?php echo $bulan;?>"/>
				<input type="hidden" name="tahun" value="<?php echo $tahun;?>"/>
				<input type="submit" value="SIMPAN" class="btnsimpan"/>
			</form>
		</div>
	</div>
</div>