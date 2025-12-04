<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DIAGNOSA</b></h3>
			<?php echo $_COOKIE['alert'];?>
			<table class="table-judul">
				<thead>
					<tr>
						<th width="5%">NO.</th>
						<th width="5%">KODE</th>
						<th width="80%">DIAGNOSA</th>
						<th width="10%">STATUS</th>
					</tr>
				</thead>
				<tbody font="8">
					<?php
					$no = 0;
					$query = mysqli_query($koneksi, "SELECT * FROM `tbdiagnosabpjs` ORDER BY `KodeDiagnosa`");
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					?>
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="center"><?php echo $data['KodeDiagnosa'];?></td>
							<td align="left" class="nama"><?php echo $data['Diagnosa'];?></td>
							<td align="left"><?php echo $data['NonSpesialis'];?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<a href="import_diagnosa_bpjs.php" class="btnsimpan">UPDATE DATA</a>
		</div>
		<!--<div class="col-sm-6">
			<a href="javascript:print()" class="btninfo">Print</a>	
		</div>-->
	</div>
</div>