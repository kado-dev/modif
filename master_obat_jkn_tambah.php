<div class="tableborderdiv">	
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=master_obat_jkn" class="backform" style="padding-top: 0px;"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>TAMBAH DATA JKN / BLUD</b></h3>
			<div class="formbg">
				<form class="form-horizontal" action="index.php?page=master_obat_jkn_tambah_proses" method="post" role="form">
					<div class = "row">
						<?php
							if($_GET['stsvalidasi'] != ''){
								echo "<div class='alert alert-danger'>".$_GET['stsvalidasi']."</div>";
							}
						?>
						<div class="table-responsive">
							<table class="table-judul">
								<tr>
									<td width="10%">Nama Barang</td>
									<td width="50%">
										<input type="text" name="namabarang" class="form-control nama_barang_pornas" placeholder="Ketikan Nama Barang" required>
									</td>
								</tr>
							</table><hr>
							<button type="submit" class="btn btn-round btn-success btnsimpan">Simpan</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>