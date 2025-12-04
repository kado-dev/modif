<div class="tableborderdiv">	
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?page=master_vaksin" class="backform" style="margin-top:15px"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>TAMBAH DATA VAKSIN </b></h3>
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<div class = "row">
					<?php
						if($_GET['stsvalidasi'] != ''){
							echo "<div class='alert alert-danger'>".$_GET['stsvalidasi']."</div>";
						}
					?>
					<form class="form-horizontal" action="index.php?page=master_vaksin_tambah_proses" method="post" role="form">
						<div class="table-responsive" style="font-size:12px">
							<table class="table table-striped table-condensed">
								<tr>
									<td width="10%">Nama Barang</td>
									<td width="50%">
										<input type="text" name="namabarang" class="form-control" placeholder="Ketikan Nama Barang" required>
									</td>
								</tr>
								<tr>
									<td width="10%">Satuan</td>
									<td width="50%">
										<select name="satuan" class="form-control" required>
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
										<input type="text" name="namaprogram" class="form-control" value="VAKSIN" readonly>
									</td>
								</tr>
							</table><hr>
							<button type="submit" class="btnsimpan">Simpan</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>