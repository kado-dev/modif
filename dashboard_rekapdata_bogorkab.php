<div class="tableborderdiv">
	<h3 class="judul"><b>REKAP DATA KETERSEDIAN OBAT & BMHP PUSKESMAS</b></h3>
	<div class="row">
		<div class="col-lg-12">
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-striped table-condensed table-bordered table-judul">
						<thead>
							<tr>
								<th width='5%'>NO.</td>
								<th width='10%'>KODE</td>
								<th width='40%'>PUSKESMAS</td>
								<th width='10%'>STATUS UPLOAD</td>
							</tr>
						</thead>
						<tbody>
							<?php
							$tahun = '2021';
							$hariini = date('Y-m-d');
							$no = 0;
							$str_rko = "SELECT * FROM tbpuskesmas 
							WHERE (Namapuskesmas != 'UPTD FARMASI' AND Namapuskesmas != 'DINAS KESEHATAN' AND `Kota`='$kota') ORDER BY NamaPuskesmas";
							$query_rko = mysqli_query($koneksi,$str_rko);
							while($data_rekapdata = mysqli_fetch_assoc($query_rko)){
								$no = $no + 1;
							?>
								<tr>
									<td style="text-align:right;"><?php echo $no;?></td>
									<td style="text-align:center;"><?php echo $data_rekapdata['KodePuskesmas'];?></td>
									<td><?php echo $data_rekapdata['NamaPuskesmas'];?></td>
									<td align="center"><a href="?page=lap_farmasi_importdata_dinas&kodepuskesmas=<?php echo $data_rekapdata['KodePuskesmas'];?>&namapuskesmas=<?php echo $data_rekapdata['NamaPuskesmas'];?>&tahun=<?php echo $tahun;?>" target="_blank" class="btn btn-sm btn-success">Lihat</a></td>
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

