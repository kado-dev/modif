<div class="tableborderdiv">
	<h3 class="judul"><b>RKO PUSKESMAS</b></h3>
	<div class="row">
		<div class="col-sm-12 table responsiive">
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="dashboard_rko_bandungkab"/>
						<div class="col-sm-2">
							<select name="tahun" class="form-control">
								<option value="2021" <?php if($_GET['tahun'] == '2021'){echo "SELECTED";}?>>2021</option>
								<option value="2022" <?php if($_GET['tahun'] == '2022'){echo "SELECTED";}?>>2022</option>
								<option value="2023" <?php if($_GET['tahun'] == '2023'){echo "SELECTED";}?>>2023</option>
								<option value="2024" <?php if($_GET['tahun'] == '2024'){echo "SELECTED";}?>>2024</option>
								<option value="2025" <?php if($_GET['tahun'] == '2025'){echo "SELECTED";}?>>2025</option>
							</select>	
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=dashboard_rko_bandungkab" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="dashboard_rko_bandungkab_excel.php?tahun=<?php echo $_GET['tahun'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>
			</div>
			
			<div class="kotakgrafik">
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-striped table-condensed table-bordered table-judul">
							<thead>
								<tr>
									<th width='5%'>NO.</td>
									<th width='10%'>KODE</td>
									<th width='35%'>PUSKESMAS</td>
									<th width='30%'>APOTEKER</td>
									<th width='10%'>TAHUN</td>
									<th width='10%'>STATUS RKO</td>
								</tr>
							</thead>
							<tbody>
								<?php
								$tahunrko = date('Y');	
								$hariini = date('Y-m-d');
								$no = 0;
								$str_rko = "SELECT * FROM tbpuskesmas 
								WHERE (Namapuskesmas != 'UPTD FARMASI' AND Namapuskesmas != 'DINAS KESEHATAN' AND `Kota`='$kota') ORDER BY NamaPuskesmas";
								$query_rko = mysqli_query($koneksi,$str_rko);
								while($data_rko = mysqli_fetch_assoc($query_rko)){
									$no = $no + 1;
								?>
									<tr>
										<td align = "right"><?php echo $no;?></td>
										<td align = "center"><?php echo $data_rko['KodePuskesmas'];?></td>
										<td><?php echo $data_rko['NamaPuskesmas'];?></td>
										<td>
											<?php
												// data apoteker										
												$dtapoteker = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaPegawai` FROM `tbpegawai` WHERE `status` = 'APOTEKER' AND `KodePuskesmas`='$data_rko[KodePuskesmas]'"));
												echo $dtapoteker['NamaPegawai'];
											?>
										</td>
										<td align = "center">
											<?php 
												if($_GET['tahun'] != ''){
													echo $_GET['tahun'];
												}else{												
													echo $tahunrko;
												}	
											?>
										</td>
										<td align="center">
											<?php 
												if($_GET['tahun'] != ''){
													$tahunrko = $_GET['tahun'];
												}else{												
													$tahunrko = $tahunrko;
												}	
												$dtrko = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS JumlahItem FROM `tbrkobandungkab` WHERE `KodePuskesmas` = '$data_rko[KodePuskesmas]' and (StokAwal <> '' OR PemakaianRata <> '') and `Tahun`='$tahunrko';"));
												if($dtrko['JumlahItem'] > 50){
											?>		
												<a href="?page=lap_farmasi_rko_dinkes&kodepuskesmas=<?php echo $data_rko['KodePuskesmas'];?>&tahun=<?php echo $tahunrko;?>&sumberanggaran=<?php echo "APBD KAB/KOTA";?>" target="_blank" class="btn btn-round btn-sm btn-success">Sudah</a>
											<?php
												}else{
											?>
												<a href="?page=lap_farmasi_rko_dinkes&kodepuskesmas=<?php echo $data_rko['KodePuskesmas'];?>&tahun=<?php echo $tahunrko;?>&sumberanggaran=<?php echo "APBD KAB/KOTA";?>" target="_blank" class="btn btn-round btn-sm btn-danger">Belum</a>
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
</div>	

