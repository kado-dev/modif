<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=gudang_besar_opnam" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>STOK OPNAME</b></h3>
			<div class="formbg">
				<?php
					if($_GET['stsvalidasi'] != ''){
						echo "<div class='alert alert-danger'>".$_GET['stsvalidasi']."</div>";
					}
				?>
				<form action="?page=gudang_besar_opnam_tambah_proses" method="post">
					<div class = "row">
						<div class="table-responsive" style="overflow-x: hidden;">
							<table class="table-judul" width="100%">
								<tr>
									<td width="20%">Tgl.Stok Opnam</td>
									<td width="80%">
										<?php $tgle = explode("-",date ('Y-m-d'));?>
										<input type="text" name="tanggalso" class="form-control datepicker" value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>" readonly><!--panggil clas dari halaman index.php-->
									</td>
								</tr>
								<tr>
									<td>Keterangan</td>
									<td>
										<textarea name="keteranganso" class="form-control puyer" maxlength ="100" placeholder="Silahkan isi keterangan tambahan atau catatan" required></textarea>
									</td>
								</tr>
							</table><hr>
						</div>
						<button type="submit" class="btn btn-round btn-success btnsimpan">Simpan</button>
					</div>
				</form>	
			</div>	
		</div>	
	</div>
</div>
