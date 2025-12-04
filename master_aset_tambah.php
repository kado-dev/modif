<div class="tableborderdiv">	
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?page=master_aset" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>TAMBAH DATA ASET</b></h3>
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<div class = "row">
					<?php
						if($_GET['stsvalidasi'] != ''){
							echo "<div class='alert alert-danger'>".$_GET['stsvalidasi']."</div>";
						}
					?>
					<form class="form-horizontal" action="index.php?page=master_aset_tambah_proses" method="post" role="form">
						<div class="table-responsive" style="font-size:12px">
							<table class="table-judul" width="100%">
								<tr>
									<td width="10%">Nama Barang</td>
									<td width="50%">
										<input type="text" name="namabarang" class="form-control" placeholder="Ketikan Nama Barang" required>
									</td>
								</tr>
								<tr>
									<td>Satuan</td>
									<td>
										<div class="row">
											<div class="col-sm-12">	
												<select name="satuan" class="form-control">
													<option value="BUAH">BUAH</option>
													<option value="BOTOL">BOTOL</option>
													<option value="KOTAK">KOTAK</option>
													<option value="PAKET">PAKET</option>
													<option value="PCS">PCS</option>
													<option value="RIM">RIM</option>
													<option value="UNIT">UNIT</option>
													<option value="LAINNYA">LAINNYA</option>
												</select>
											</div>
										</div>	
									</td>
								</tr>
							</table><hr/>
							<button type="submit" class="btnsimpan">SIMPAN</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>