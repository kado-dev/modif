<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>GEMA CERMAT</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="gudang_besar_gemacermat"/>
						<div class="col-sm-2">
							<select name="kategori" class="form-control kategori_bulan" required>
								<option value="">--Pilih--</option>
								<option value="Puskesmas" <?php if($_GET['kategori'] == 'Puskesmas'){echo "SELECTED";}?>>Puskesmas</option>
								<option value="TanggalPengeluaran" <?php if($_GET['kategori'] == 'TanggalPengeluaran'){echo "SELECTED";}?>>Bulan</option>
							</select>
						</div>
						<div class="col-sm-6 isi_bulan">
							<?php
							if($_GET['kategori'] == 'TanggalPengeluaran'){
								echo "<select class='form-control' name='key'>
										<option value='01'>Januari</option>
										<option value='02'>Februari</option>
										<option value='03'>Maret</option>
										<option value='04'>April</option>
										<option value='05'>Mei</option>
										<option value='06'>Juni</option>
										<option value='07'>Juli</option>
										<option value='08'>Agustus</option>
										<option value='09'>September</option>
										<option value='10'>Oktober</option>
										<option value='11'>November</option>
										<option value='12'>Desember</option>
									</select>";
							}else{
							?>
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" required>
							<?php
							}
							?>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-warning btn-white">Cari</button>
							<a href="?page=gudang_besar_gemacermat" class="btn btn-success btn-white">Refresh</a>
							<a href="?page=gudang_besar_gemacermat_tambah" class="btn btn-primary btn-white">Tambah Kegiatan</a>
						</div>
					</form>
				</div>	
			</div>
		</div>
	</div>
	<?php
		$jumlah_perpage = 20;
		if($_GET['h']==''){
			$mulai=0;
		}else{
			$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}
		
		$key = $_GET['key'];	
		$kategori = $_GET['kategori'];
		$bulan = $_GET['key'];
		$tahun = $_GET['keytahun'];

		if($kategori == "Puskesmas"){
			$kategori = " WHERE `Penyelenggara`='$key'";
		}elseif($kategori == "TanggalPengeluaran"){
			$kategori = " WHERE YEAR(`TanggalKegiatan`)='$tahun' AND MONTH(`TanggalKegiatan`)='$bulan'";
		}	
		
		$str = "SELECT * FROM `tbgfkgemacermat`".$kategori;
		$str2 = $str." ORDER BY `IdKegiatan` DESC LIMIT $mulai,$jumlah_perpage";
		// echo $str2;
		
		if($_GET['h'] == null || $_GET['h'] == 1){
			$no = 0;
		}else{
			$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}
	?>		
	<div class="row search-page" id="search-page-1">
		<div class="col-xs-12">
			<div class="row">
				<div class="col-xs-12 col-sm-12">
					<div class="search-area well well-sm">
						<div class="space-6"></div>
						<div class = "row">
							<div class="col-sm-12 table-responsive" style="font-size:12px">
								<table id="datatabless" class="table-judul-form">
									<thead>
										<tr>
											<th width="3%" rowspan="2">No.</th>
											<th width="8%" rowspan="2">Tanggal</th>
											<th width="10%" rowspan="2">Penyelenggara</th>
											<th width="10%" rowspan="2">Tempat</th>
											<th width="10%" rowspan="2">Sumber Dana</th>
											<th width="10%" rowspan="2">Peserta Pertemuan</th>
											<th width="20%" colspan="5">Jumlah Peserta</th>
											<th width="10%" rowspan="2">Hasil Pelaksanaan Kegiatan</th>
											<th width="10%" rowspan="2">Rencana Tindak Lanjut</th>
											<th width="15%" rowspan="2">Aksi</th>
										</tr>
										<tr>
											<th>Apoteker</th>
											<th>Nakes Lainnya</th>
											<th>Kader</th>
											<th>Masyarakat Umum</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
									<?php
									$query = mysqli_query($koneksi,$str2);
									while($data = mysqli_fetch_assoc($query)){
										$no = $no + 1;
									?>
										<tr>
											<td align="right"><?php echo $no;?></td>		
											<td align="center"><?php echo $data['TanggalKegiatan'];?></td>		
											<td align="left"><?php echo $data['Penyelenggara'];?></td>		
											<td align="left"><?php echo $data['Tempat'];?></td>		
											<td align="left"><?php echo $data['SumberDana'];?></td>		
											<td align="left"><?php echo $data['Peserta'];?></td>		
											<td align="left"><?php echo $data['JumlahApoteker'];?></td>		
											<td align="left"><?php echo $data['JumlahNakesLain'];?></td>		
											<td align="left"><?php echo $data['JumlahKader'];?></td>		
											<td align="left"><?php echo $data['JumlahMasyarakat'];?></td>		
											<td align="left"></td><!--total-->		
											<td align="left"><?php echo $data['HasilKegiatan'];?></td>		
											<td align="left"><?php echo $data['RencanaTindakLanjut'];?></td>	
											<td align="center">
												<a href="?page=gudang_besar_gemacermat_edit&id=<?php echo $data['IdKegiatan'];?>" class="btn btn-xs btn-success btn-white"> Edit</a>
												<a href="?page=gudang_besar_gemacermat_print&id=<?php echo $data['IdKegiatan'];?>&nf=<?php echo $data['NoFakturKegiatan'];?>" class="btn btn-xs btn-info btn-white"> Print</a>
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
			</div>
		</div>
	</div>

	<ul class="pagination">
		<?php
			$query2 = mysqli_query($koneksi,$str);
			$jumlah_query = mysqli_num_rows($query2);
			
			if(($jumlah_query % $jumlah_perpage) > 0){
				$jumlah = ($jumlah_query / $jumlah_perpage)+1;
			}else{
				$jumlah = $jumlah_query / $jumlah_perpage;
			}
			for ($i=1;$i<=$jumlah;$i++){
			$max = $_GET['h'] + 20;
			$min = $_GET['h'] - 19;
			
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=gudang_besar_gemacermat&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<div class="row">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<p><b>Keterangan : </b> <br/>
				- Menu hapus tampil jika status pengeluarannya ke Puskesmas & Puskesmas belum memvalidasi status penerimaan barang</p>	
			</div>
		</div>
	</div>
</div>	
