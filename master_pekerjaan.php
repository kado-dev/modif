<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DATA PEKERJAAN </b></h3>
			<table class="table-judul">
				<thead>
					<tr>
						<th class="col-sm-10">PEKERJAAN</th>
					</tr>
				</thead>
				<tbody font="8">
					<?php
					$query = mysqli_query($koneksi,"select * from `tbpekerjaan` order by `Pekerjaan`");
					while($data = mysqli_fetch_assoc($query)){
					?>
						<tr>
							<td class="nama"><?php echo $data['Pekerjaan'];?></td>		
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>	
	</div>
</div>