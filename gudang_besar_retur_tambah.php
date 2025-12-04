<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?page=gudang_besar_retur" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>RETUR PUSKESMAS</b></h3>
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<div class = "row">
					<?php
						if($_GET['stsvalidasi'] != ''){
							echo "<div class='alert alert-danger'>".$_GET['stsvalidasi']."</div>";
						}
					?>
					<form action="?page=gudang_besar_retur_tambah_proses" method="post">
						<div class="table-responsive" style="overflow-x: hidden;">
							<table class="table">
								<tr>
									<td class="col-sm-2">Tgl.Retur</td>
									<td class="col-sm-10">
										<div class="input-group">
											<span class="input-group-addon tesdate">
												<span class="fa fa-calendar"></span>
											</span>
											<?php
												$tgle = explode("-",date ('Y-m-d'));
											?>
											<input type="text" name="tanggalretur" class="form-control datepicker" value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>" readonly><!--panggil clas dari halaman index.php-->
										</div>
									</td>
								</tr>
								<tr>
									<td>Status Retur</td>
									<td>
										<select name="statusretur" class="form-control statuspengeluaran_gb" required>
											<option value="">--Pilih--</option>											
											<option value="PUSKESMAS">PUSKESMAS</option>
											<option value="RUMAH SAKIT">RUMAH SAKIT</option>
											<option value="LAINNYA">LAINNYA</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Unit Penerima</td>
									<td class="col-sm-10 penerima_gb">
										<select name="penerima" class="form-control penerimacls" required>
											<option value="">--Pilih--</option>
											<option value="GUDANG PELAYANAN">GUDANG PELAYANAN</option>
										</select>	
									</td>
								</tr>
								<tr>
									<td>Keterangan</td>
									<td class="col-sm-4">
										<input  type="text" name="keterangan" class="form-control" placeholder="Silahkan isi keterangan tambahan atau Nomer SBBK">
									</td>
								</tr>
							</table><hr>
						</div>
						<button type="submit" class="btnsimpan">Simpan</button>
					</form>	
				</div>
			</div>	
		</div>	
	</div>
</div>
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>
	$(document).on("change", ".penerimacls", function () {
		var selectedText = $(".penerimacls option:selected").text();
		$(".penerimabarang").val(selectedText);
	});
</script>
