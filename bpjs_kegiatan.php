<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KEGIATAN</b></h3>
			<?php echo $_COOKIE['alert'];?>
			<table class="table-judul">
				<thead>
					<tr>
						<th width="10%">KODE</th>
						<th width="90%">KEGIATAN</th>
					</tr>
				</thead>
				<tbody font="8">
					<?php
					$kodepuskesmas = $_SESSION['kodepuskesmas'];
					$query = mysqli_query($koneksi,"SELECT * FROM `tbbpjs_kegiatan` ORDER BY `kdProgram`");
					$no = 0;
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					?>
						<tr>
							<td style="text-align:center;"><?php echo $data['kdProgram'];?></td>
							<td><?php echo $data['nmProgram'];?></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div><br/>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p>
					<b>Perhatikan :</b><br/>
					Untuk Kode dan Nama Program, mengikuti data dari Web Service PCare.<br/>
					Tidak dapat dilakukan import data karena penambahan variabel dilakukan secara manual.<br/>
					Jika ada pembaharuan data, dapat ditambahkan melalui database simpus (Admin Dinkes / IT).
				</p>
			</div>
		</div>
	</div>
	<div class="row">
		<!--<div class="col-sm-12">
			<a href="import_pegawai_bpjs.php" class="btnsimpan">Update Data</a>
		</div>
		<div class="col-sm-6">
			<a href="javascript:print()" class="btninfo">Print</a>	
		</div>-->
	</div>
</div>
