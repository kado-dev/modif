<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=master_obat" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>TAMBAH DATA LPLPO </b></h3>
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<form class="form-horizontal" action="master_obat_tambah_proses.php" method="post" role="form">
					<div class = "row">
					<?php
						if($_GET['stsvalidasi'] != ''){
							echo "<div class='alert alert-danger'>".$_GET['stsvalidasi']."</div>";
						}
					?>				
					<div class="table-responsive" style="font-size:12px">
						<table class="table-judul" width="100%">
							<tr>
								<td width="10%">Nama Barang</td>
								<td width="50%">
									<input type="text" name="namabarang" class="form-control nama_barang_pornas" placeholder="Ketikan Nama Barang" required>
								</td>
							</tr>
							<tr>
								<td>Satuan</td>
								<td>
									<select name="satuan" class="form-control jarak" required>
										<option value="TABLET">TABLET</option>
										<?php
										$query = mysqli_query($koneksi,"SELECT * FROM `ref_obat_satuan` order by `satuan_obat`");
											while($data = mysqli_fetch_assoc($query)){
												echo "<option value='$data[satuan_obat]'>$data[satuan_obat]</option>";
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td width="10%">Program</td>
								<td width="50%">
									<select name="namaprogram" class="form-control golonganfungsi" required>
										<?php
										$query = mysqli_query($koneksi,"SELECT * FROM `ref_obatprogram` ORDER BY nama_program");
											while($data = mysqli_fetch_assoc($query)){
												echo "<option value='$data[nama_program]'>$data[nama_program]</option>";
											}
										?>
									</select>	
								</td>
							</tr>
							<tr>
								<td>Jenis Barang</td>
								<td>
									<select name="jenisbarang" class="form-control jenisbarang" required>
										<option value="GENERIK" SELECTED>GENERIK</option>
										<option value="NON GENERIK">NON GENERIK</option>
										<option value="LAINNYA">LAINNYA</option>
									</select>
								</td>
							</tr>
						</table><hr/>
						<button type="submit" class="btn btn-sound btn-success btnsimpan">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>