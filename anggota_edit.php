<?php
	include "config/helper_pasienrj.php";
	$id = $_GET['id'];
	$noindex = $_GET['noindex'];
	$id = $_GET['id'];
	$strps = "SELECT * FROM `$tbpasien` WHERE `IdPasien` = '$id'";
	$queryps = mysqli_query($koneksi, $strps);
	$data = mysqli_fetch_assoc($queryps);
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=kk_detail&id=<?php echo $noindex;?>" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3><b>EDIT DATA PASIEN</b></h3><hr>	
			<div class="formbg">
				<form class="form-horizontal" action="anggota_edit_proses.php" method="post">
					<table class="table-judul">
						<tr>
							<td class="col-sm-2">No.Index</td>
							<td class="col-sm-10"><input type="text" name="noindex" class="form-control inputan" value="<?php echo $noindex;?>" readonly></td>
						</tr>
						<?php if($kota != 'KOTA TARAKAN'){ ?>
						<tr>
							<?php 
								if($_SESSION['kota'] == 'KABUPATEN BULUNGAN'){	
									$norm = substr($data['NoRM'],-6);
								}elseif($_SESSION['kota'] == 'KABUPATEN KUTAI KARTANEGARA'){
									$norm = substr($data['NoRM'],-8);
								}elseif($_SESSION['kota'] == 'KABUPATEN GARUT'){
									$norm = substr($data['NoRM'],-6);
								}else{
									$norm = substr($data['NoRM'],-11);
								}
							?>
							<td>No.RM</td>
							<td><input type="text" name="norm" class="form-control inputan" value="<?php echo $norm;?>" maxlength="11"></td>
						</tr>
						<?php } ?>
						<tr>
							<td>NIK</td>
							<td><input type="number" name="nik" class="form-control inputan" value="<?php echo $data['Nik'];?>" required></td>
						</tr>
						<tr>
							<td>Nama Lengkap</td>
							<td><input type="text" name="nama" style="text-transform: uppercase;" class="form-control inputan" value="<?php echo $data['NamaPasien'];?>" required></td>
						</tr>
						<tr>
							<td>Status Keluarga</td>
							<td>
								<select name="statuskeluarga" class="form-control inputan" required>
									<option value="">--Pilih--</option>
									<option value="KEPALA KELUARGA" <?php if($data['StatusKeluarga'] == 'KEPALA KELUARGA'){echo "SELECTED";}?>>KEPALA KELUARGA</option>
									<option value="ISTRI" <?php if($data['StatusKeluarga'] == 'ISTRI'){echo "SELECTED";}?>>ISTRI</option>
									<option value="ANAK 1" <?php if($data['StatusKeluarga'] == 'ANAK 1'){echo "SELECTED";}?>>ANAK 1</option>
									<option value="ANAK 2" <?php if($data['StatusKeluarga'] == 'ANAK 2'){echo "SELECTED";}?>>ANAK 2</option>
									<option value="ANAK 3" <?php if($data['StatusKeluarga'] == 'ANAK 3'){echo "SELECTED";}?>>ANAK 3</option>
									<option value="ANAK 4" <?php if($data['StatusKeluarga'] == 'ANAK 4'){echo "SELECTED";}?>>ANAK 4</option>
									<option value="ANAK 5" <?php if($data['StatusKeluarga'] == 'ANAK 5'){echo "SELECTED";}?>>ANAK 5</option>
									<option value="ANAK 6" <?php if($data['StatusKeluarga'] == 'ANAK 6'){echo "SELECTED";}?>>ANAK 6</option>
									<option value="ANAK 7" <?php if($data['StatusKeluarga'] == 'ANAK 7'){echo "SELECTED";}?>>ANAK 7</option>
									<option value="ANAK 8" <?php if($data['StatusKeluarga'] == 'ANAK 8'){echo "SELECTED";}?>>ANAK 8</option>
									<option value="ANAK 9" <?php if($data['StatusKeluarga'] == 'ANAK 9'){echo "SELECTED";}?>>ANAK 9</option>
									<option value="ANAK 10" <?php if($data['StatusKeluarga'] == 'ANAK 10'){echo "SELECTED";}?>>ANAK 10</option>
									<option value="ANAK 11" <?php if($data['StatusKeluarga'] == 'ANAK 11'){echo "SELECTED";}?>>ANAK 11</option>
									<option value="ANAK 12" <?php if($data['StatusKeluarga'] == 'ANAK 12'){echo "SELECTED";}?>>ANAK 12</option>
									<option value="ANAK 13" <?php if($data['StatusKeluarga'] == 'ANAK 13'){echo "SELECTED";}?>>ANAK 13</option>
									<option value="ANAK 14" <?php if($data['StatusKeluarga'] == 'ANAK 14'){echo "SELECTED";}?>>ANAK 14</option>
									<option value="ANAK 15" <?php if($data['StatusKeluarga'] == 'ANAK 15'){echo "SELECTED";}?>>ANAK 15</option>
									<option value="ANAK 16" <?php if($data['StatusKeluarga'] == 'ANAK 16'){echo "SELECTED";}?>>ANAK 16</option>
									<option value="ANAK 17" <?php if($data['StatusKeluarga'] == 'ANAK 17'){echo "SELECTED";}?>>ANAK 17</option>
									<option value="ANAK 18" <?php if($data['StatusKeluarga'] == 'ANAK 18'){echo "SELECTED";}?>>ANAK 18</option>
									<option value="ANAK 19" <?php if($data['StatusKeluarga'] == 'ANAK 19'){echo "SELECTED";}?>>ANAK 19</option>
									<option value="BAPAK" <?php if($data['StatusKeluarga'] == 'BAPAK'){echo "SELECTED";}?>>BAPAK</option>
									<option value="IBU" <?php if($data['StatusKeluarga'] == 'IBU'){echo "SELECTED";}?>>IBU</option>
									<option value="KAKEK" <?php if($data['StatusKeluarga'] == 'KAKEK'){echo "SELECTED";}?>>KAKEK</option>
									<option value="NENEK" <?php if($data['StatusKeluarga'] == 'NENEK'){echo "SELECTED";}?>>NENEK</option>
									<option value="CUCU" <?php if($data['StatusKeluarga'] == 'CUCU'){echo "SELECTED";}?>>CUCU</option>	
									<option value="MENANTU" <?php if($data['StatusKeluarga'] == 'MENANTU'){echo "SELECTED";}?>>MENANTU</option>
									<option value="MERTUA" <?php if($data['StatusKeluarga'] == 'MERTUA'){echo "SELECTED";}?>>MERTUA</option>
									<option value="SAUDARA KANDUNG" <?php if($data['StatusKeluarga'] == 'SAUDARA KANDUNG'){echo "SELECTED";}?>>SAUDARA KANDUNG</option>
									<option value="KEPONAKAN" <?php if($data['StatusKeluarga'] == 'KEPONAKAN'){echo "SELECTED";}?>>KEPONAKAN</option>
								</select>					
							</td>
						</tr>
						<tr>
							<td>Tanggal Lahir</td>
							<td>
								<div class="input-group">
									<span class="input-group-addon tesdate"><!--saat diklik tampil panggil class diindex.php-->
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
									<input type="text" name="tanggallahir" class="form-control inputan datepicker" value="<?php echo date('d-m-Y',strtotime($data['TanggalLahir']));?>">
								</div>
							</td>
						</tr>
						<tr>
							<td>Jenis Kelamin</td>
							<td>
								<div class="radio">
									<div class="radio">
										<label>
										<input type="radio" name="jeniskelamin" class="jkcls" value="0" <?php if($data['JenisKelamin'] == '0'){echo"checked";}?>>
										Tidak Diketahui
										</label>&nbsp&nbsp

										<label>
										<input type="radio" name="jeniskelamin" class="jkcls" value="L" <?php if($data['JenisKelamin'] == 'L'){echo"checked";}?>>
										Laki-laki
										</label>&nbsp&nbsp
									
										<label>
										<input type="radio" name="jeniskelamin" class="jkcls" value="P" <?php if($data['JenisKelamin'] == 'P'){echo"checked";}?>>
										Perempuan
										</label>&nbsp&nbsp

										<label>
										<input type="radio" name="jeniskelamin" class="jkcls" value="3" <?php if($data['JenisKelamin'] == '3'){echo"checked";}?>>
										Tidak Dapat Ditentukan
										</label>&nbsp&nbsp

										<label>
										<input type="radio" name="jeniskelamin" class="jkcls" value="4" <?php if($data['JenisKelamin'] == '4'){echo"checked";}?>>
										Tidak Mengisi
										</label>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>Agama</td>
							<td>
								<select name="agama" class="form-control inputan" required>
									<option value="">--Pilih--</option>
									<option value="ISLAM" <?php if($data['Agama'] == 'ISLAM'){echo "SELECTED";}?>>ISLAM</option>
									<option value="KRISTEN" <?php if($data['Agama'] == 'KRISTEN'){echo "SELECTED";}?>>KRISTEN</option>
									<option value="KATOLIK" <?php if($data['Agama'] == 'KATOLIK'){echo "SELECTED";}?>>KATOLIK</option>
									<option value="HINDU" <?php if($data['Agama'] == 'HINDU'){echo "SELECTED";}?>>HINDU</option>
									<option value="BUDHA" <?php if($data['Agama'] == 'BUDHA'){echo "SELECTED";}?>>BUDHA</option>
									<option value="KONGHUCU" <?php if($data['Agama'] == 'KONGHUCU'){echo "SELECTED";}?>>KONGHUCU</option>
									<option value="PENGHAYAT" <?php if($data['Agama'] == 'PENGHAYAT'){echo "SELECTED";}?>>PENGHAYAT</option>
									<option value="LAINNYA" <?php if($data['Agama'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
								</select>
							</td>	
						</tr>
						<tr>
							<td>Status Nikah</td>
							<td>	
								<select name="statusnikah" class="form-control inputan" required>
									<option value="">--Pilih--</option>
									<option value="BELUM KAWIN" <?php if($data['StatusNikah'] == 'BELUM KAWIN'){echo "SELECTED";}?>>BELUM KAWIN</option>
									<option value="KAWIN" <?php if($data['StatusNikah'] == 'KAWIN'){echo "SELECTED";}?>>KAWIN</option>
									<option value="CERAI HIDUP" <?php if($data['StatusNikah'] == 'CERAI HIDUP'){echo "SELECTED";}?>>CERAI HIDUP</option>
									<option value="CERAI MATI" <?php if($data['StatusNikah'] == 'CERAI MATI'){echo "SELECTED";}?>>CERAI MATI</option>
								</select>
							</td>	
						</tr>
						<tr>
							<td>Pendidikan</td>
							<td>
								<select name="pendidikan" class="form-control inputan" required>
									<option value="">--Pilih--</option>
									<option value="BELUM SEKOLAH" <?php if($data['Pendidikan'] == 'BELUM SEKOLAH'){echo "SELECTED";}?>>BELUM SEKOLAH</option>
									<option value="TK" <?php if($data['Pendidikan'] == 'TK'){echo "SELECTED";}?>>TK</option>
									<option value="SD" <?php if($data['Pendidikan'] == 'SD'){echo "SELECTED";}?>>SD</option>
									<option value="SLTP" <?php if($data['Pendidikan'] == 'SLTP'){echo "SELECTED";}?>>SLTP</option>
									<option value="SLTA" <?php if($data['Pendidikan'] == 'SLTA'){echo "SELECTED";}?>>SLTA</option>
									<option value="D1" <?php if($data['Pendidikan'] == 'D1'){echo "SELECTED";}?>>D1</option>
									<option value="D2" <?php if($data['Pendidikan'] == 'D2'){echo "SELECTED";}?>>D2</option>
									<option value="D3" <?php if($data['Pendidikan'] == 'D3'){echo "SELECTED";}?>>D3</option>
									<option value="S1" <?php if($data['Pendidikan'] == 'S1'){echo "SELECTED";}?>>S1</option>
									<option value="S2" <?php if($data['Pendidikan'] == 'S2'){echo "SELECTED";}?>>S2</option>
									<option value="S3" <?php if($data['Pendidikan'] == 'S3'){echo "SELECTED";}?>>S3</option>
									<option value="TIDAK SEKOLAH" <?php if($data['Pendidikan'] == 'TIDAK SEKOLAH'){echo "SELECTED";}?>>TIDAK SEKOLAH</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Pekerjaan</td>
							<td>
								<select name="pekerjaan" class="form-control inputan" required>
									<option value="">--Pilih--</option>
									<option value="BELUM BEKERJA" <?php if($data['Pekerjaan'] == 'BELUM BEKERJA'){echo "SELECTED";}?>>BELUM BEKERJA</option>
									<option value="BURUH" <?php if($data['Pekerjaan'] == 'BURUH'){echo "SELECTED";}?>>BURUH</option>
									<option value="GURU" <?php if($data['Pekerjaan'] == 'GURU'){echo "SELECTED";}?>>GURU</option>
									<option value="HONORER" <?php if($data['Pekerjaan'] == 'HONORER'){echo "SELECTED";}?>>HONORER</option>
									<option value="IRT" <?php if($data['Pekerjaan'] == 'IRT'){echo "SELECTED";}?>>IRT</option>
									<option value="MAHASISWA" <?php if($data['Pekerjaan'] == 'MAHASISWA'){echo "SELECTED";}?>>MAHASISWA</option>
									<option value="NELAYAN" <?php if($data['Pekerjaan'] == 'NELAYAN'){echo "SELECTED";}?>>NELAYAN</option>
									<option value="PEGAWAI SWASTA" <?php if($data['Pekerjaan'] == 'PEGAWAI SWASTA'){echo "SELECTED";}?>>PEGAWAI SWASTA</option>
									<option value="PELAJAR" <?php if($data['Pekerjaan'] == 'PELAJAR'){echo "SELECTED";}?>>PELAJAR</option>
									<option value="PENSIUN" <?php if($data['Pekerjaan'] == 'PENSIUN'){echo "SELECTED";}?>>PENSIUN</option>
									<option value="PETANI" <?php if($data['Pekerjaan'] == 'PETANI'){echo "SELECTED";}?>>PETANI</option>
									<option value="PNS" <?php if($data['Pekerjaan'] == 'PNS'){echo "SELECTED";}?>>PNS</option>
									<option value="POLRI" <?php if($data['Pekerjaan'] == 'POLRI'){echo "SELECTED";}?>>POLRI</option>
									<option value="TNI" <?php if($data['Pekerjaan'] == 'TNI'){echo "SELECTED";}?>>TNI</option>
									<option value="TKI" <?php if($data['Pekerjaan'] == 'TKI'){echo "SELECTED";}?>>TKI</option>
									<option value="WIRASWASTA" <?php if($data['Pekerjaan'] == 'WIRASWASTA'){echo "SELECTED";}?>>WIRASWASTA</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Asuransi</td>
							<td>
								<select name="asuransi" class="form-control inputan" required>
									<option value="">--Pilih--</option>
									<?php
									$queryasuransi = mysqli_query($koneksi,"SELECT * FROM `tbasuransi`");
										while($dataasuransi = mysqli_fetch_assoc($queryasuransi)){
											if($dataasuransi['Asuransi'] == $data['Asuransi']){
												echo "<option value='$dataasuransi[Asuransi]' SELECTED>$dataasuransi[Asuransi]</option>";
											}else{
												echo "<option value='$dataasuransi[Asuransi]'>$dataasuransi[Asuransi]</option>";
											}
										}
									?>
								</select>
							</td>	
						</tr>
						<tr>
							<td>Status</td>
							<td>
								<select name="statusasuransi" class="form-control inputan" required>
									<option value="">--Pilih--</option>
									<option value="PESERTA" <?php if($data['StatusAsuransi'] == 'PESERTA'){echo "SELECTED";}?>>PESERTA</option>
									<option value="ISTRI" <?php if($data['StatusAsuransi'] == 'ISTRI'){echo "SELECTED";}?>>ISTRI</option>
									<option value="SUAMI" <?php if($data['StatusAsuransi'] == 'SUAMI'){echo "SELECTED";}?>>SUAMI</option>
									<option value="ANAK 1" <?php if($data['StatusAsuransi'] == 'ANAK 1'){echo "SELECTED";}?>>ANAK 1</option>
									<option value="ANAK 2" <?php if($data['StatusAsuransi'] == 'ANAK 2'){echo "SELECTED";}?>>ANAK 2</option>
									<option value="ANAK 3" <?php if($data['StatusAsuransi'] == 'ANAK 3'){echo "SELECTED";}?>>ANAK 3</option>
									<option value="ANAK 4" <?php if($data['StatusAsuransi'] == 'ANAK 4'){echo "SELECTED";}?>>ANAK 4</option>
									<option value="ANAK >5" <?php if($data['StatusAsuransi'] == 'ANAK >5'){echo "SELECTED";}?>>ANAK >5</option>
								</select>
							</td>	
						</tr>
						<tr>
							<td class="col-sm-2">No.Asuransi</td>
							<td class="col-sm-10"><input type="number" name="noasuransi" class="form-control inputan" value="<?php echo $data['NoAsuransi'];?>" required></td>
						</tr>
						<tr>
							<td class="col-sm-2">No Telepon Selular (HP)</td>
							<td class="col-sm-10"><input type="number" name="telpon" class="form-control inputan" value="<?php echo $data['Telpon'];?>" required></td>
						</tr>
					</table><hr>
					<input type="hidden" name="idpasien" class="form-control inputan" value="<?php echo $id;?>">
					<button type="submit" class="btn btn-round btn-success btnsimpan">SIMPAN</button>
				</form>
			</div>		
		</div>	
	</div>
</div>