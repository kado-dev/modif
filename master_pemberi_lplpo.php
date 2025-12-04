<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DATA PEMBERI (SBBK)</b></h3>
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<form action="index.php?page=master_pemberi_lplpo_proses" method="post" class="forms">
					<div class="form">
						<div class="form-group col-md-12">
							<div class="row">
								<div class="form-group col-md-6">
									<label>Kasie Kefarmasian</label>
									<input name="namakasie" type="text" class="form-control form-control-sm" placeholder="Nama Kasie Kefarmasian" maxlength="40" required>
								</div>
								<div class="form-group col-md-3">
									<label>Nip</label>
									<input name="nipkasie" type="text" class="form-control form-control-sm" placeholder="Nip" maxlength="20" required>
								</div>
								<div class="form-group col-md-3">
									<label>Pangkat/Golongan</label>
									<input name="pangkatkasie" type="text" class="form-control form-control-sm" placeholder="Pangkat/Golongan" required>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-6">
									<label>Nama Pegawai (Yang Menyerahkan)</label>
									<input name="namapemberi" type="text" class="form-control form-control-sm" placeholder="Nama Pemberi" maxlength="40" required>
								</div>
								<div class="form-group col-md-3">
									<label>Nip</label>
									<input name="nippemberi" type="text" class="form-control form-control-sm" placeholder="Nip" maxlength="20" required>
								</div>
								<div class="form-group col-md-3">
									<label>Pangkat/Golongan</label>
									<input name="pangkatpemberi" type="text" class="form-control form-control-sm" placeholder="Pangkat/Golongan" required>
								</div>
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-round btn-success btnsimpan">SIMPAN</button>
				</form>
			</div>
		</div>
	</div>

	<?php	
		$str = "SELECT * FROM `tb_user_profil_sbbk`".$keys;
		// echo $str2;
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<tr>
							<th width="5%">No.</th>
							<th width="10%">Nip</th>
							<th width="20%">Nama Kasie</th>
							<th width="10%">Nip</th>
							<th width="20%">Nama Pemberi</th>
							<th width="5%">Aksi</th>
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
							<td align="center"><?php echo $data['nip_kasie'];?></td>
							<td align="left"><?php echo $data['nama_kasie'];?></td>
							<td align="center"><?php echo $data['nip_pemberi'];?></td>
							<td align="left"><?php echo $data['nama_pemberi'];?></td>
							<td align="center">
								<a href="?page=master_pemberi_lplpo_delete&nip=<?php echo $data['nip_kasie'];?>" class="btn btn-xs btn-danger" onClick="return confirm('Anda yakin data ingin didelete...?')">Hapus</a>
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