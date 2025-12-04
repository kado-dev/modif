<div class="tableborderdiv">
	<h3 class="judul"><b>RKO PUSKESMAS</b></h3>
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
									<th width='40%'>Puskesmas</td>
									<th width='35%'>Apoteker</td>
									<th width='10%'>Status RKO</td>
								</tr>
							</thead>
							<tbody>
								<?php
								$hariini = date('Y-m-d');
								$no = 0;
								$str_rko = "SELECT * FROM tbpuskesmas 
								WHERE (Namapuskesmas != 'UPTD FARMASI' AND Namapuskesmas != 'DINAS KESEHATAN' AND `Kota`='$kota') ORDER BY NamaPuskesmas";
								$query_rko = mysqli_query($koneksi,$str_rko);
								while($data_rko = mysqli_fetch_assoc($query_rko)){
									$no = $no + 1;
								?>
									<tr>
										<td style="text-align:right;"><?php echo $no;?></td>
										<td style="text-align:center;"><?php echo $data_rko['KodePuskesmas'];?></td>
										<td><?php echo $data_rko['NamaPuskesmas'];?></td>
										<td>
											<?php
												// data apoteker										
												$dtapoteker = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaPegawai` FROM `tbpegawai` WHERE `status` = 'APOTEKER' AND `KodePuskesmas`='$data_rko[KodePuskesmas]'"));
												echo $dtapoteker['NamaPegawai'];
											?>
										</td>
										<td align="center">
											<?php 
												$tahunrko = date('Y');
												$dtrko = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS JumlahItem FROM `tbrkobandungkab` WHERE `KodePuskesmas` = '$data_rko[KodePuskesmas]' and (StokAwal <> '' OR PemakaianRata <> '');"));
												if($dtrko['JumlahItem'] > 50){
											?>		
												<a href="?page=lap_farmasi_rko_dinkes&kodepuskesmas=<?php echo $data_rko['KodePuskesmas'];?>&tahun=<?php echo $tahunrko;?>&sumberanggaran=<?php echo "APBD KAB/KOTA";?>" target="_blank" class="btn btn-sm btn-success">Sudah</a>
											<?php
												}else{
											?>
												<a href="?page=lap_farmasi_rko_dinkes&kodepuskesmas=<?php echo $data_rko['KodePuskesmas'];?>&tahun=<?php echo $tahunrko;?>&sumberanggaran=<?php echo "APBD KAB/KOTA";?>" target="_blank" class="btn btn-sm btn-danger">Belum</a>
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

