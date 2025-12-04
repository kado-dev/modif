<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DATA PENDIDIKAN</b></h3>
			<table class="table-judul">
				<thead>
					<tr>
						<th class="col-sm-11">PENDIDIKAN</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$query = mysqli_query($koneksi,"select * from `tbpendidikan` order by `Pendidikan`");
					while($data = mysqli_fetch_assoc($query)){
					?>
						<tr>
							<td class="nama"><?php echo $data['Pendidikan'];?></td>		
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>