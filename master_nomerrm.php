<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive" style="font-size:12px">
			<h3 class="judul"><b>NOMOR REKAM MEDIS</b></h3>
			<form class="form-horizontal" action="master_nomerrm_proses.php" method="post" role="form">	
				<table class="table-judul">
					<thead>
						<tr>
							<th width="5%">NO.</th>
							<th width="80%">DESA/KELURAHAN</th>
							<th colspan="15%">KODE DESA</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$str = "SELECT * FROM `tbkelurahan` WHERE `KodePuskesmas` = '$kodepuskesmas'";
						$query = mysqli_query($koneksi, $str);					
							while($data = mysqli_fetch_assoc($query)){
								$no = $no + 1;
								$kelurahan = $data["Kelurahan"]; 
						?>		
						<tr>
							<td><?php echo $no;?></td>
							<td><?php echo $kelurahan;?></td>
							<td>
								<input type="hidden" name="kodedesa[]" value="<?php echo $data['Kode'];?>"/>
								<input type="text" name="koderm[<?php echo $data['Kode'];?>]" style="text-transform: uppercase;" class="form-control kode_rm" value="<?php echo $data['KodeRM'];?>" maxlength="10">
							</td>
						</tr>
						<?php
							}	
						?>
						<tr>
							<td></td>
							<td>Apakah Nomer Index ingin meneruskan nomer yang sudah ada</td>
							<td>
								<?php
									$dtrm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstatusnomerrm`"));
								?>
								<select name="statusnomerrm" class="form-control" required>
									<option value="Y" <?php if($dtrm['StatusIndex'] == 'Y'){echo "SELECTED";}?>>YA</option>
									<option value="N" <?php if($dtrm['StatusIndex'] == 'N'){echo "SELECTED";}?>>TIDAK</option>
								</select>	
							</td>
						</tr>
					</tbody>
				</table>
				<hr/>
				<button type="submit" class="btn btn-round brn-success btnsimpan">Simpan</button>
			</form>	
		</div>
	</div><br/>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<p>
					<b>Perhatikan :</b><br/>
					Kode Desa, silahkan isi sesuai dengan penomeran (urutan) masing masing desa<br/>
					Misal : 01, 02, 03...dst, kode ini akan digunakan sebagai inisial penomeran rekam medis
				</p>
			</div>
		</div>
	</div>
</div>
<div class="hasilmodal"></div>
	
