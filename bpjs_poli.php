<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>PELAYANAN</b></h3>
			<?php echo $_COOKIE['alert'];?>
			<table class="table-judul">
				<thead>
					<tr>
						<th width="10%">KODE</th>
						<th width="70%">PELAYANAN</th>
						<th width="20%">STATUS</th>
					</tr>
				</thead>
				<tbody font="8">
					<?php
					$no = 0;
					$query = mysqli_query($koneksi,"SELECT * FROM `tbbpjs_poli` ORDER BY `nmPoli`");
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					?>
						<tr>
							<td style="text-align:center;"><?php echo $data['kdPoli'];?></td>
							<td><?php echo $data['nmPoli'];?></td>
							<td><?php echo $data['poliSakit'];?></td>
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
			<a href="import_poli_bpjs.php" class="btnsimpan">UPDATE DATA</a>
		</div>
		<!--<div class="col-sm-6">
			<a href="javascript:print()" class="btninfo">Print</a>	
		</div>-->
	</div>
</div>
