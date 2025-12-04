<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>ALERGI MAKANAN</b></h3>
			<?php echo $_COOKIE['alert'];?>
			<table class="table-judul">
				<thead>
					<tr>
						<th width="10%">KODE</th>
						<th width="60%">NAMA ALERGI</th>
					</tr>
				</thead>
				<tbody font="8">
					<?php
					$query = mysqli_query($koneksi,"SELECT * FROM `tbbpjs_alegi_makanan` order by `KodeAlergi`");
					$no = 0;
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					?>
						<tr>
							<td style="text-align:center;"><?php echo $data['KodeAlergi'];?></td>
							<td><?php echo $data['NamaAlergi'];?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div><br/>
	<div class="row">
		<div class="col-sm-12">
			<a href="import_bpjs_alergi_makan.php" class="btnsimpan">UPDATE DATA</a>
		</div>
	</div>
</div>
