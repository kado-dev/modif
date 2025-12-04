<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$kota = $_SESSION['kota'];
	$profinsi = $_SESSION['profinsi'];
	$tahun=date('Y');
?>

<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Data Dasar Puskesmas</h1>
		</div>
	</div>
</div>					

<!--Kolom Entry-->
<div class="row">	
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="panel-title"><i class="fa fa-pencil"></i> Karakteristik Puskesmas</h4>
			</div>
			<div class="widget-body">
				<div class = "row" style="margin:10px">
					<div class="widget-main no-padding">
						<form class="form-horizontal" action="index.php?page=master_puskesmas_data_dasar" method="post" role="form">
							<table class="table">
								<tr>
									<td class="col-sm-2">Luas Wilayah Kerja</td>
									<td>:</td>
									<td class="col-sm-10">
										<input type="text" name="luas_wilayah" value="<?php echo $norm;?>" class="form-control" placeholder="(m2)" required>
									</td>
								</tr>	
								<tr>
									<td class="col-sm-2">Letak Administratif</td>
									<td>:</td>
									<td class="col-sm-10">
										<select name="letak_administratif" class="form-control statuskeluargapilih" required>
											<option value="">--Pilih--</option>
											<option value="KOTA METROPOLITAN">KOTA METROPOLITAN</option>
											<option value="IBUKOTA PROPINSI">IBUKOTA PROPINSI</option>
											<option value="IBUKOTA KAB/KOTA">IBUKOTA KAB/KOTA</option>
											<option value="IBUKOTA KECAMATAN">IBUKOTA KECAMATAN</option>
											<option value="IBUKOTA PROPINSI">IBUKOTA PROPINSI</option>
										</select>
									</td>
								</tr>					
								<tr>
									<td class="col-sm-2">Letak Geografis</td>
									<td>:</td>
									<td class="col-sm-10">
										<select name="letak_geografis" class="form-control statuskeluargapilih" required>
											<option value="">--Pilih--</option>
											<option value="BERBUKIT">BERBUKIT</option>
											<option value="DATARAN RENDAH">DATARAN RENDAH</option>
											<option value="KEPULAUAN">KEPULAUAN</option>
											<option value="PANTAI">PANTAI</option>
											<option value="PEGUNUNGAN">PEGUNUNGAN</option>
											<option value="RAWA">RAWA</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Letak Strategis</td>
									<td>:</td>
									<td class="col-sm-10">
										<select name="letak_strategis" class="form-control statuskeluargapilih" required>
											<option value="">--Pilih--</option>
											<option value="PERBATASAN NEGARA">PERBATASAN NEGARA</option>
											<option value="PERBATASAN PROPINSI">ERBATASAN PROPINSI</option>
											<option value="TRANSMIGRASI">TRANSMIGRASI</option>
											<option value="TERPENCIL">TERPENCIL</option>
											<option value="TERTINGGAL">TERTINGGAL</option>
											<option value="DAERAH WISATA">AERAH WISATA</option>
											<option value="DAERAH INDUSTRI">DAERAH INDUSTRI</option>
											<option value="DAERAH RAWAN KECELAKAAN">DAERAH RAWAN KECELAKAAN</option>
											<option value="LAINNYA">LAINNYA</option>
										</select>
									</td>
								</tr>
							</table><hr>
							
							<table class="row">
								<tr><td class="col-sm-2"><b>Tanah Puskesmas</b></td></tr>
							</table><p>
								
							<table class="table">
								<tr>
									<td class="col-sm-2">Status Kepemilikan Tanah</td>
									<td>:</td>
									<td class="col-sm-10">
										<select name="status_kepemilikan" class="form-control" required>
											<option value="">--Pilih--</option>
											<option value="TANAH NEGARA">TANAH NEGARA</option>
											<option value="TANAH DEPKES">TANAH DEPKES</option>
											<option value="TANAH PEMPROP">TANAH PEMPROP</option>
											<option value="TANAH PEMKAB/PEMKOT">TANAH PEMKAB/PEMKOT</option>
											<option value="MILIK MASYARAKAT">MILIK MASYARAKAT</option>
											<option value="TIDAK JELAS">TIDAK JELAS</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Luas Tanah</td>
									<td>:</td>
									<td class="col-sm-10">
										<input type="Number" name="luas_tanah" class="form-control" placeholder="(m2)" required>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Sertifikat</td>
									<td>:</td>
									<td class="col-sm-10">
										<select name="sertifikat" class="form-control" required>
											<option value="">--Pilih--</option>
											<option value="ADA">ADA</option>
											<option value="TIDAK">TIDAK</option>
										</select>
									</td>
								</tr>
							</table><hr>
							
							<table class="row">
								<tr><td class="col-sm-2"><b>Bangunan Puskesmas</b></td></tr>
							</table><p>
								
							<table class="table">
								<tr>
									<td>Luas Bangunan</td>
									<td>:</td>
									<td><input type="text" name="luas_bangunan" class="form-control" placeholder="(m2)" required></td>
								</tr>
								<tr>
									<td>Tahun Pembangunan</td>
									<td>:</td>
									<td><input type="text" name="tahun_pembangunan" class="form-control" required></td>
								</tr>
								<tr>
									<td>Tahun Perbaikan Terakhir</td>
									<td>:</td>
									<td><input type="text" name="tahun_perbaikan" class="form-control" required></td>
								</tr>
								<tr>
									<td class="col-sm-2">Kondisi Sekarang</td>
									<td>:</td>
									<td class="col-sm-10">
									<select name="kondisi_sekarang" class="form-control" required>
										<option value="">--Pilih--</option>
										<option value="BAIK">BAIK</option>
										<option value="RUSAK RINGAN">RUSAK RINGAN</option>
										<option value="RUSAK SEDANG">RUSAK SEDANG</option>
										<option value="RUSAK BERAT">RUSAK BERAT</option>
										<option value="DALAM PROSES PEMBANGUNAN/PERBAIKAN">DALAM PROSES PEMBANGUNAN/PERBAIKAN</option>
										<option value="BELUM TERSEDIA">BELUM TERSEDIA</option>
									</select>
								</tr>
							</table><hr>
							
							<table class="row">
								<tr><td class="col-sm-2"><b>Bangunan Perawatan</b></td></tr>
							</table><p>
							
							<table class="table">
								<tr>
									<td>Luas Ruang Perawatan</td>
									<td>:</td>
									<td><input type="text" name="luas_ruang_prw" class="form-control" placeholder="(m2)" required></td>
								</tr>
								<tr>
									<td>Jumlah Tempat Tidur</td>
									<td>:</td>
									<td><input type="text" name="jml_tempat_tdr" class="form-control" placeholder="(m2)" required></td>
								</tr>
								<tr>
									<td>Tahun Pembangunan</td>
									<td>:</td>
									<td><input type="text" name="tahun_pembangunan_prw" class="form-control" required></td>
								</tr>
								<tr>
									<td>Tahun Perbaikan Terakhir</td>
									<td>:</td>
									<td><input type="text" name="tahun_perbaikan_prw" class="form-control" required></td>
								</tr>
								<tr>
									<td class="col-sm-2">Kondisi Terakhir</td>
									<td>:</td>
									<td class="col-sm-10">
									<select name="kondisi_terakhir_prw" class="form-control" required>
										<option value="">--Pilih--</option>
										<option value="BAIK">BAIK</option>
										<option value="RUSAK RINGAN">RUSAK RINGAN</option>
										<option value="RUSAK SEDANG">RUSAK SEDANG</option>
										<option value="RUSAK BERAT">RUSAK BERAT</option>
										<option value="DALAM PROSES PEMBANGUNAN/PERBAIKAN">DALAM PROSES PEMBANGUNAN/PERBAIKAN</option>
									</select>
								</tr>
								<tr>
									<td class="col-sm-2"></td>
									<td></td>
									<td class="col-sm-10">
										<input type="hidden" name="nocm" value = "<?php echo $nocm;?>" class="form-control" readonly>
										<button class="btn btn-lg btn-warning kembali_kk pull-right" style="margin-left:10px">Kembali</button>
										<button type="submit" class="btn btn-lg btn-success pull-right" >Simpan</button>
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>				
		</div>
	</div>
</div>