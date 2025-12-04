<style type="text/css">
	.bulanheader{
		border-right: 1px solid #ddd;
		text-align: center;
		padding-left:0px;
		padding-right:0px;
	}
	.bulanheader:last-child{
		border-right: 0px solid #ddd;
		padding-right:15px;
	}
	.bulanheader:first-child{
		padding-left:15px;
	}

	.bulanheader h4{
		padding: 8px;font-size: 14px;
	}
	.bulanheader p{
		padding: 8px;font-size: 17px;margin:0px;
	}
	.bulanheader p a{
		display: block;
	}
	.clr_terisi{
		background: #4bc440;
	}
	.clr_kosong{
		background: #ff8e8e;
	}

	.bulanheader:last-child > .clr_terisi, .bulanheader:last-child > .clr_kosong{
		border-radius: 0px 0px 10px 0px;
	}

	.bulanheader:first-child > .clr_terisi, .bulanheader:first-child > .clr_kosong{
		border-radius: 0px 0px 0px 10px;
	}
</style>

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
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>INPUT SPM KESEHATAN</b></h3>
			<div class="formbg" style="padding:0px">
				<div class = "row">
					<!-- <form role="form">
						<input type="hidden" name="page" value="lap_spm_indikator"/>
						<div class="col-sm-9">
							<input type="text" name="tahun" class="form-control" placeholder="tahun" value="<?php //echo $_GET['tahun'];?>">
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-warning btn-white">Cari</button>
							<a href="?page=lap_spm_indikator_input" class="btn btn-info btn-white">Tambah</a>
						</div>
					</form>	 -->
					<?php
						$bulan_arry = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
						foreach ($bulan_arry as $key => $val) {
							$cekvalue = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `tbspmindikator_laporan` WHERE `KodePuskesmas` = '$kodepuskesmas' AND `tahun` = '$tahun' AND `bulan` = '$key'"));
					?>	
						<div class='col-sm-1 bulanheader'>
							<h4><?php echo $val;?></h4>
							<p class="<?php echo ($cekvalue == 0) ? 'clr_kosong' : 'clr_terisi';?>">
								<a href="?page=lap_spm_indikator_input&tahun=<?php echo date('Y');?>&bulan=<?php echo $key;?>">
									<?php
										if($cekvalue == 0){
											echo '<i class="fas fa-times-circle"></i>';
										}else{
											echo '<i class="fas fa-check-circle"></i>';
										}
									?>
								</a>
							</p>
						</div>
					<?php
						}
					?>
				</div>
			</div>
		</div>
	</div>

	<!--data-->
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<!-- <a href="?page=lap_spm_indikator_input&tahun=<?php echo $tahun;?>&bulan=<?php echo $bulan;?>" class="btn btn-info">Tambah</a><hr/>
			<?php //echo nama_bulan($bulan)." ".$tahun;?> -->
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
					
					$str = "SELECT * FROM  `tbspmindikator` ORDER by idspmindikator ASC";
					$query = mysqli_query($koneksi,$str);
					$no = 0;
					while($data = mysqli_fetch_assoc($query)){
						$no++;
						$getvalue = mysqli_query($koneksi,"SELECT * FROM `tbspmindikator_laporan` WHERE `idspmindikator`= '$data[idspmindikator]' AND `KodePuskesmas` = '$kodepuskesmas' AND `tahun` = '$tahun' AND `bulan` = '$bulan' ORDER by waktu DESC");
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
						<tr style="background: #b6e0d4">
							<td align="center"><?php echo $no;?></td>		
							<td align="left" colspan="3"><?php echo $data['indikator'];?></td>		
						</tr>
						<tr>
							<td align="center">C</td>		
							<td align="left"><?php echo $data['detail_d'];?></td>		
							<td align="center"><?php echo $jumlah_d;?></td>		
							<td align="center" valign="middle" rowspan="2"><?php echo $cakupan;?>%</td>		
						</tr>
						<tr>
							<td align="center">T</td>		
							<td align="left"><?php echo $data['detail_s'];?></td>		
							<td align="center"><?php echo $jumlah_s;?></td>	
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		
		</div>
	</div>
</div>