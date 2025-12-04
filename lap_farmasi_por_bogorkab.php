<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>INDIKATOR PERESEPAN</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_por_bogorkab"/>
						<div class="col-sm-2 bulanformcari">
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
						<div class="col-sm-1 bulanformcari" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-3">	
							<div class="input-group">
								<select name="triwulan" class="form-control" required>
									<option value="">--Pilih--</option>
									<option value="TRIWULAN 1" <?php if($_GET['triwulan'] == 'TRIWULAN 1'){echo "SELECTED";}?>>TRIWULAN 1</option>
									<option value="TRIWULAN 2" <?php if($_GET['triwulan'] == 'TRIWULAN 2'){echo "SELECTED";}?>>TRIWULAN 2</option>
									<option value="TRIWULAN 3" <?php if($_GET['triwulan'] == 'TRIWULAN 3'){echo "SELECTED";}?>>TRIWULAN 3</option>
									<option value="TRIWULAN 4" <?php if($_GET['triwulan'] == 'TRIWULAN 4'){echo "SELECTED";}?>>TRIWULAN 4</option>
								</select>
								<span class="input-group-addon">Pilih</span>
							</div>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-warning btn-white">Cari</button>
							<a href="?page=lap_farmasi_por_bogorkab" class="btn btn-success btn-white">Refresh</a>
							<a href="javascript:print()" class="btn btn-primary btn-white">Print</a>
						</div>
					</form>	
				</div>	
			</div>
		</div>
	</div>
	
	<?php		
		$bulan = $_GET['bulan'];
		$tahun = $_GET['tahun'];
		$diagnosa = $_GET['diagnosa'];
		if(isset($bulan) and isset($tahun)){
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr>
							<th width="3%" rowspan="2">No.</th>
							<th width="10%" rowspan="2">Nama Puskesmas</th>
							<th width="20%" colspan="4">Data Umum Puskesmas</th>
							<th width="20%" colspan="4">% Penggunaan Antibiotik Pada ISPA Non Pneumonia</th>
							<th width="20%" colspan="4">% Penggunaan Antibiotik Pada Diare Non Spesifik</th>
							<th width="20%" colspan="4">% Penggunaan Injeksi Pada Myalgia</th>
						</tr>
						<tr>
							<th rowspan="2">Jenis Puskesmas</th>
							<th rowspan="2">Jumlah Apoteker</th>
							<th rowspan="2">Jumlah AA</th>
							<th rowspan="2">Jumlah Dokter</th>
							<th rowspan="2">Januari</th><!--ISPA-->
							<th rowspan="2">Februari</th>
							<th rowspan="2">Maret</th>
							<th rowspan="2">Rata-Rata</th>
							<th rowspan="2">Januari</th><!--DIARE-->
							<th rowspan="2">Februari</th>
							<th rowspan="2">Maret</th>
							<th rowspan="2">Rata-Rata</th>
							<th rowspan="2">Januari</th><!--MYALGIA-->
							<th rowspan="2">Februari</th>
							<th rowspan="2">Maret</th>
							<th rowspan="2">Rata-Rata</th>
						</tr>
					</thead>
					<tbody style="font-size: 10px;">
					<?php					
					$str = "SELECT KodePuskesmas, NamaPuskesmas FROM `tbpuskesmas`";
					$str2 = $str." ORDER BY NamaPuskesmas ASC ";
					// echo $str2;					
					
					$no = 0;
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$kodepuskesmas = $data['KodePuskesmas'];
						$namapuskesmas = $data['NamaPuskesmas'];
						
						// jumlah item obat						
						$querydetail = mysqli_query($koneksi, "SELECT KodeBarang FROM `tbresepdetail` WHERE NoResep ='$noresep'");
						$querydetail2 = mysqli_query($koneksi, "SELECT signa1, signa2 FROM `tbresepdetail` WHERE NoResep ='$noresep'");
						$itemobat = mysqli_num_rows($querydetail);
					?>
						<tr>					
							<td align="center"><?php echo $no;?></td>									
							<td align="left"><?php echo $namapuskesmas;?></td>										
							<td align="right">0</td><!--data umum puskesmas-->										
							<td align="right">0</td>										
							<td align="right">0</td>										
							<td align="right">0</td>	
							<td align="right">0</td><!--ISPA-->										
							<td align="right">0</td>										
							<td align="right">0</td>										
							<td align="right">0</td>	
							<td align="right">0</td><!--DIARE-->										
							<td align="right">0</td>										
							<td align="right">0</td>										
							<td align="right">0</td>	
							<td align="right">0</td><!--MYALGYA-->										
							<td align="right">0</td>										
							<td align="right">0</td>										
							<td align="right">0</td>			
						</tr>
					<?php
					}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div><hr/>
	<?php
	}
	?>
</div>	