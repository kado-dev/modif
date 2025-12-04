

<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DATA PENERIMA (SBBK)</b></h3>
			<div class="formbg">
				<form action="index.php?page=master_penerima_lplpo_proses" method="post" class="forms">
					<div class="form-row">
						<div class="form-group col-md-12">
							<div class="row">
								<div class="form-group col-md-6">
									<label>Status</label>
									<select name="status" class="form-control statuspengeluaran_gb" required>
										<option value="">--Pilih--</option>
										<?php if($_SESSION['kota'] == 'KABUPATEN BANDUNG'){?>
										<option value="GUDANG PELAYANAN">GUDANG PELAYANAN</option>
										<option value="RUMAH SAKIT">RUMAH SAKIT</option>
										<option value="PUSKESMAS">PUSKESMAS</option>
										<?php }else{?>
										<option value="PUSKESMAS">PUSKESMAS</option>
										<option value="RUMAH SAKIT">RUMAH SAKIT</option>
										<option value="LAINNYA">LAINNYA</option>
										<?php }?>
									</select>
								</div>
								<div class="form-group col-md-6">
									<label>Unit Penerima</label>
									<div class="penerima_gb">
									<select name="penerima" class="form-control penerimacls" required>
										<option value="">--Pilih--</option>
									</select>
									</div>
									<input type="hidden" name="namapenerima" class="namapenerima">
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-4">
									<label>Nama Penerima Barang</label>
									<input name="namapegawai" type="text" class="form-control form-control-sm" placeholder="Nama Lengkap" required>
								</div>
								<div class="form-group col-md-4">
									<label>Jabatan</label>
									<input name="jabatan" type="text" class="form-control form-control-sm" placeholder="Jabatan" required>
								</div>
								<div class="form-group col-md-4">
									<label>Nip</label>
									<input name="nip" type="text" class="form-control form-control-sm" placeholder="Nip" maxlength="20" required>
								</div>
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-round btn-success btnsimpan">Simpan</button>
				</form>
			</div>
		</div>
	</div>

	<?php	
		$str = "SELECT * FROM `tb_user_profil_sbbk_penerima` ORDER BY IdPenerima DESC";
		// echo $str2;
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<tr>
							<th width="5%">No.</th>
							<th width="10%">Kode</th>
							<th width="10%">Puskesmas</th>
							<th width="20%">Nama Penerima</th>
							<th width="10%">Nip</th>
							<th width="9%">Aksi</th>
						</tr>
					</thead>
					<tbody>
					<?php
					$query = mysqli_query($koneksi,$str);
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					?>
						<tr>
							<td align="right"><?php echo $no;?></td>
							<td align="center">
								<?php 
								if($data['StatusPenerima'] == 'LAINNYA'){
									echo "-";
								}else{
									echo $data['KodePuskesmas'];
								}	
								?>
							</td>
							<td align="left"><?php echo $data['NamaPuskesmas'];?></td>
							<td align="left"><?php echo $data['NamaPegawai'];?></td>
							<td align="left"><?php echo $data['Nip'];?></td>
							<td align="center">
								<a href="?page=master_penerima_lplpo_edit&id=<?php echo $data['IdPenerima'];?>" class="btn btn-xs btn-info" >Edit</a>
								<a href="?page=master_penerima_lplpo_delete&id=<?php echo $data['IdPenerima'];?>" class="btn btn-xs btn-danger" onClick="return confirm('Anda yakin data ingin didelete...?')">Hapus</a>
							</td>			
						</tr>
					<?php
					}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>		
	$(document).on("change", ".penerimacls", function () {
		
		var text = $(".penerimacls option:selected").text();
		$(".namapenerima").val(text);
	});
	

</script>	