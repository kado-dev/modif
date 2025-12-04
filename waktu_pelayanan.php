<?php
	// include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";

	if($_GET['tanggal1'] == null OR $_GET['tanggal2'] == null){
		$tanggal1 = date('Y-m-d');
		$tanggal2 = date('Y-m-d');
	}else{
		$tanggal1 = $_GET['tanggal1'];
		$tanggal2 = $_GET['tanggal2'];
	}
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>WAKTU PELAYANAN & TUNGGU</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="waktu_pelayanan"/>
						<div class="col-xl-2">
							<input type="text" name="tanggal1" class="form-control datepicker2" value="<?php echo $tanggal1;?>" placeholder = "Tanggal Awal">
						</div>
						<div class="col-xl-2">
							<input type="text" name="tanggal2" class="form-control datepicker2" value="<?php echo $tanggal2;?>" placeholder = "Tanggal Akhir">
						</div>
						<div class="col-sm-2">
							<select name="namapelayanan" class="form-control asuransi">
								<option value='semua'>Semua</option>
								<?php
								$query = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` WHERE `JenisPelayanan`='KUNJUNGAN SAKIT' ORDER BY `Pelayanan` ASC");
									while($data = mysqli_fetch_assoc($query)){
										if($_GET['namapelayanan'] == $data['Pelayanan']){
											echo "<option value='$data[Pelayanan]' SELECTED>$data[Pelayanan]</option>";
										}else{
											echo "<option value='$data[Pelayanan]'>$data[Pelayanan]</option>";
										}
									}
								?>
							</select>
						</div>
						<div class="col-xl-6">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=waktu_pelayanan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="waktu_pelayanan_excel.php?tanggal1=<?php echo $_GET['tanggal1'];?>&tanggal2=<?php echo $_GET['tanggal2'];?>&namapelayanan=<?php echo $_GET['namapelayanan'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php	
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$tbwaktupelayanan = "tbwaktupelayanan_".$kodepuskesmas;
	
	// if(isset($bulan) and isset($tahun)){
	?>
	<div class="table-responsive printini" style="overflow: hidden;">
		<div class="row">
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table-judul-laporan-min" width="100%">
						<thead>
							<tr>
								<th rowspan="2" width="3%">NO</th>
								<th rowspan="2" width="12%">NAMA PASIEN</th>
								<th rowspan="2" width="5%">STATUS DAFTAR</th>
								<th rowspan="2" width="7%">PELAYANAN</th>
								<th colspan="3">PENDAFTARAN</th>
								<th colspan="2">PEMERIKSAAN</th>
								<th colspan="2">FARMASI</th>
								<th colspan="3">HASIL WAKTU PELAYANAN</th>
								<th colspan="3">HASIL WAKTU TUNGGU</th>
							</tr>
							<tr>
								<th width="5%">AMBIL ANTRIAN</th>
								<th width="5%">PANGGIL PENDAFTARAN</th>
								<th width="5%">SELESAI PENDAFTARAN</th>
								<th width="5%">PANGGIL PEMERIKSAAN</th>
								<th width="5%">SELESAI PEMERIKSAAN</th>
								<th width="5%">PENERIMAAN OBAT</th>
								<th width="5%">PEMBERIAN OBAT</th>
								<th width="5%">PENDAFTARAN</th>
								<th width="5%">PEMERIKSAAN</th>
								<th width="5%">FARMASI</th>
								<th width="5%">PENDAFTARAN</th>
								<th width="5%">PEMERIKSAAN</th>
								<th width="5%">FARMASI</th>
							</tr>
						</thead>
						<tbody style="font-size:11px;">
							<?php
							$jumlah_perpage = 50;
							$namapelayanan = str_replace('POLI ','',$_GET['namapelayanan']);
			
							if($_GET['h']==''){
								$mulai=0;
							}else{
								$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}

							if($tanggal1 != null){
								$tgl_str = " WHERE DATE(SelesaiPendaftaran) BETWEEN '$tanggal1' AND '$tanggal2' AND `NamaPasien` != '' AND `PoliPertama` != 'KONSELING' "; // AND `NomorAntrianPoli` != '0'
							}else{
								$tgl_str = " WHERE DATE(SelesaiPendaftaran) = DATE(CURDATE()) AND `NamaPasien` != '' AND `PoliPertama` != 'KONSELING' "; //  AND `NomorAntrianPoli` != '0'
							}

							if($namapelayanan != 'semua'){
								$pelayanan = " AND `PoliPertama`='$namapelayanan'";
							}else{
								$pelayanan = " ";
							}

							$str = "SELECT * FROM `$tbwaktupelayanan`".$tgl_str.$pelayanan." GROUP BY `NamaPasien`";
							$str2 = $str." ORDER BY SelesaiPendaftaran, PoliPertama , NomorAntrianPoli ASC LIMIT $mulai,$jumlah_perpage";
							// echo $str2;
							
							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}

							$panggilantrian = '';							
							$query = mysqli_query($koneksi, $str2);
							while ($data = mysqli_fetch_assoc($query)) {
								if($panggilantrian != date('d-m-Y', strtotime($data['SelesaiPendaftaran']))){									
									$waktuawal = date('d-m-Y', strtotime($data['SelesaiPendaftaran']));
									echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='17'>$waktuawal</td></tr>";
								}
								$panggilantrian = date('d-m-Y', strtotime($data['SelesaiPendaftaran']));
								$no = $no + 1;		
							?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td><?php echo $data['NamaPasien'];?></td>
								<td align="center">
									<?php 
									// tbantrian_pasien
									$strantrian = "SELECT * FROM $tbantrianpasien WHERE date(WaktuAntrian) = '$tanggal1' AND NomorAntrianPoli = '$data[NomorAntrianPoli]' AND PoliPertama = '$data[PoliPertama]'";
									$dtantrian = mysqli_fetch_assoc(mysqli_query($koneksi, $strantrian));
									echo $dtantrian['StatusDaftar'];
									?>
								</td>
								<td align="center">
									<?php
										$dtlayanan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `KodePelayanan` FROM `tbantrian_pelayanan` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Pelayanan`='$data[PoliPertama]'"));
										echo $data['PoliPertama']." - ".$dtlayanan['KodePelayanan'].$data['NomorAntrianPoli'];
									?>
								</td>
								<td align="center">
									<?php 
										if ($data['AmbilAntrian'] == '0000-00-00 00:00:00'){
											echo "Tidak";
										}else{
											echo date('H:i:s',strtotime($data['AmbilAntrian']));
										}
									?>
								</td>
								<td align="center">
									<?php 
										if ($data['PanggilAntrian'] == '0000-00-00 00:00:00'){
											echo "Tidak";
										}else{
											echo date('H:i:s',strtotime($data['PanggilAntrian']));
										}
									?>
								</td>
								<td align="center"><?php echo date('H:i:s',strtotime($data['SelesaiPendaftaran']));?></td>
								<td align="center">
									<?php 
										if ($data['PemeriksaanAwal'] == '0000-00-00 00:00:00'){
											echo "Antri";
										}else{
											echo date('H:i:s',strtotime($data['PemeriksaanAwal']));
										}
									?>
								</td>
								<td align="center">
									<?php 
									if ($data['PemeriksaanAkhir'] == '0000-00-00 00:00:00'){
										echo "Antri";
									}else{
										echo date('H:i:s',strtotime($data['PemeriksaanAkhir']));
									}
									?>
								</td>
								<td align="center">
									<?php
									if ($data['FarmasiAwal'] == '0000-00-00 00:00:00'){
										echo "Tidak";
									}else{
										echo date('H:i:s',strtotime($data['FarmasiAwal']));
									}
									?>
								</td>
								<td align="center">
									<?php 
									if ($data['FarmasiAkhir'] == '0000-00-00 00:00:00'){
										echo "Tidak";
									}else{
										echo date('H:i:s',strtotime($data['FarmasiAkhir']));
									}
									?>
								</td>
								<td align="right"><?php echo hitung_menit($data['PanggilAntrian'],$data['SelesaiPendaftaran']);?></td>
								<td align="right">
									<?php
										if ($data['PemeriksaanAkhir'] == '0000-00-00 00:00:00'){
											echo "Antri";
										}else{
											echo hitung_menit($data['PemeriksaanAwal'],$data['PemeriksaanAkhir']);
										}
									?>
								</td>
								<td align="right">
									<?php 
									if ($data['FarmasiAwal'] == '0000-00-00 00:00:00'){
										echo "0 menit";
									}else{
										echo hitung_menit($data['FarmasiAwal'],$data['FarmasiAkhir']);
									}
									?>
								</td>
								<td align="right"><?php echo hitung_menit($data['AmbilAntrian'],$data['SelesaiPendaftaran']);?></td>
								<td align="right">
									<?php
										if ($data['PemeriksaanAkhir'] == '0000-00-00 00:00:00'){
											echo "Antri";
										}else{
											echo hitung_menit($data['SelesaiPendaftaran'],$data['PemeriksaanAkhir']);
										}
									?>
								</td>
								<td align="right">
									<?php 
									if ($data['FarmasiAwal'] == '0000-00-00 00:00:00'){
										echo "0 menit";
									}else{
										echo hitung_menit($data['PemeriksaanAkhir'],$data['FarmasiAkhir']);
									}
									?>
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
	<hr class="noprint"><!--css-->
	<ul class="pagination noprint">
		<?php
			$bulan = $_GET['bulan'];
			$tahun = $_GET['tahun'];
			$query2 = mysqli_query($koneksi,$str);
			$jumlah_query = mysqli_num_rows($query2);
			
			if(($jumlah_query % $jumlah_perpage) > 0){
				$jumlah = ($jumlah_query / $jumlah_perpage)+1;
			}else{
				$jumlah = $jumlah_query / $jumlah_perpage;
			}
			for ($i=1;$i<=$jumlah;$i++){
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=waktu_pelayanan&tanggal1=$tanggal1&tanggal2=$tanggal2&namapelayanan=$namapelayanan&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>	
	<?php
	//}
	?>

	<div class = "row noprint">
		<div class="col-sm-12 table-responsive">
			<div class="formbg">
				<p>
					<b>Keterangan :</b><br/><br/>
					1. Waktu Pelayanan<br/>
					- Pendaftaran = Selesai Pendaftaran - Panggil Antrian<br/>
					- Pemeriksaan = Selesai Pemeriksaan - Panggil Pemeriksaann<br/>
					- Farmasi = Pemberian Obat - penerimaan resep<br/><br/>
					2. Waktu Tunggu<br/>
					- Pendaftaran = Selesai Pendaftaran - Ambil antrian<br/>
					- Pemeriksaan = Selesai Pemeriksaan - Selesai Pendaftaran<br/>
					- Farmasi = Pemberian Obat - Selesai Pemeriksaan<br/><br/>
					3. Ambil Antrian, pengambilan nomer antrian (mesin antrian)<br/>
					4. Panggil Antrian, saat klik tombol selesai saat panggil antrian (registrasi)<br>
					5. Selesai Pendaftaran, saat simpan registrasi (registrasi)<br>
					6. Panggil Pemeriksan, saat klik tombol periksa (pemeriksaan)<br>
					7. Selesai Pemeriksan, saat klik tombol simpan pemeriksaan (pemeriksaan)<br>
					8. Penerimaan Obat, saat klik tombol lihat (pelayanan resep)<br>
					9. Pemberian Obat, saat klik tombol print (pelayanan resep)
				</p>
			</div>
		</div>
	</div>
</div>
	
	