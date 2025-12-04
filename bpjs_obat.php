<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>OBAT</b></h3>
			<?php echo $_COOKIE['alert'];?>
			<table class="table-judul">
				<thead>
					<tr>
						<th width="10%">KODE</th>
						<th width="90%">NAMA OBAT</th>
					</tr>
				</thead>
				<tbody font="8">
					<?php
					$no = 0;
					$query = mysqli_query($koneksi,"SELECT * FROM `tbbpjs_obat` ORDER BY `nmObat`");
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					?>
						<tr>
							<td style="text-align:center;"><?php echo $data['kdObat'];?></td>
							<td><?php echo $data['nmObat'];?></td>
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
			<a href="import_obat_bpjs.php" class="btnsimpan">UPDATE DATA</a>
		</div>
		<!--<div class="col-sm-6">
			<a href="javascript:print()" class="btninfo">Print</a>	
		</div>-->
	</div>
</div>
