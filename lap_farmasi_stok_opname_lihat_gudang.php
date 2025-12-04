<?php
	session_start();
	include "config/helper_report.php";
	include "config/koneksi.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$nf = $_GET['nf'];
	$unit = $_GET['unit'];
	$bulan = $_GET['bl'];
	$tahun = $_GET['th'];
?>

<div class="tableborderdiv noprint">
	<div class="row">
		<div class="col-xs-12">
			<a href="index.php?page=lap_farmasi_stok_opname" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>CEK FISIK</b></h3>
			<!--dikomen dulu, suatu saat akan diperlukan kembali-->
			<!--<form class="form-inline" method="post" enctype="multipart/form-data" action="lap_farmasi_stok_opname_lihat_gudang_import.php">
				<table width="100%" style="margin-bottom: 10px;">	
					<tr>
						<td width="12%">
							Upload data (Excel): 
						</td>
						<td width="12%">
							<input type="hidden" name="link" value="nf=<?php echo $nf;?>&bl=<?php echo $bulan;?>&th=<?php echo $tahun;?>">
							<input name="fileexcel" type="file" required="required"> 
						</td>
						<td>
							<input name="upload" type="submit" value="Import">
						</td>
					</tr>
				</table>
			</form>-->
			<div class="table-responsive">
				<table class="table-judul" width="100%">
					<thead>
						<tr>
							<th width="20%">No.Faktur</th>
							<th width="20%">Bulan</th>
							<th width="10%">Tahun</th>
							<th width="20%" colspan="2">Opsi</th>
						</tr>
					</thead>
					<tbody>
						<tr style="font-size: 18px; font-weight: bold;">
							<td align="center" class="nofakturcls"><?php echo $nf;?></td>
							<td align="center"><?php echo nama_bulan($bulan);?></td>
							<td align="center"><?php echo $tahun;?></td>
							<td align="center"><a href="lap_farmasi_stok_opname_lihat_gudang_excel.php?nf=<?php echo $nf?>&bl=<?php echo $_GET['bl']?>&th=<?php echo $_GET['th']?>&sa=<?php echo $_GET['sa']?>&unit=<?php echo $unit;?>" class="btnsimpan">Download Excel</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>	
	
	<!--search-->
	<div class="row">
		<div class="col-xs-12">
			<div class="formbg" style="padding: 15px;">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_stok_opname_lihat_gudang"/>
						<div class="col-sm-3">
							<div class="input-group">
								<select name="namaprg" class="form-control">
									<option value=''>Semua</option>
									<?php if($kota=="KABUPATEN BOGOR"){?>	
									<option value='JKN'>JKN</option>
									<?php
									}
									$queryp = mysqli_query($koneksi,"SELECT * FROM `ref_obatprogram` order by `nama_program`");
									while($data3 = mysqli_fetch_assoc($queryp)){
										if($_GET['namaprg'] == $data3['nama_program']){
											echo "<option value='$data3[nama_program]' SELECTED>$data3[nama_program]</option>";
										}else{
											echo "<option value='$data3[nama_program]'>$data3[nama_program]</option>";
										}
									}
									?>
								</select>
								<span class="input-group-addon">Program</span>
							</div>
						</div>	
						<div class="col-sm-7">
							<input type="hidden" name="nf" class="form-control key" value="<?php echo $_GET['nf'];?>">
							<input type="hidden" name="bl" class="form-control key" value="<?php echo $_GET['bl'];?>">
							<input type="hidden" name="th" class="form-control key" value="<?php echo $_GET['th'];?>">
							<input type="text" name="key" class="form-control key" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama / Kode / Batch Barang">
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_stok_opname_lihat_gudang&nf=<?php echo $nf;?>&bl=<?php echo $bulan;?>&th=<?php echo $tahun;?>&namaprg=<?php echo $namaprg;?>" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
						</div>
					</form>	
				</div>			
			</div>
		</div>
	</div>
	
	<div class="row">
		<form action="lap_farmasi_stok_opname_lihat_gudang_simpan.php" method="post">
			<input type="hidden" name="bulan" value="<?php echo $_GET['bl'];?>"/>
			<input type="hidden" name="tahun" value="<?php echo $_GET['th'];?>"/>
			<input type="hidden" name="nofaktur" value="<?php echo $_GET['nf'];?>"/>
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table-judul-laporan-min"style="width:1800px">
						<thead>
							<tr>
								<th width="3%" rowspan="3">No.</th>
								<th width="5%" rowspan="3">Kode</th>
								<th width="20%" rowspan="3">Nama Barang</th>
								<th width="8%" rowspan="3">Batch</th>
								<th width="40%" colspan="16">Sisa Stok</th>
								<th width="5%" rowspan="3">Total<br/> Stok</th>
								<th width="6%" rowspan="3">Total<br/> Harga</th>
							</tr>
							<tr>
								<th colspan="2">Gudang<br/> Obat</th>
								<th colspan="2">Depot<br/> Obat</th>
								<th colspan="2">IGD</th>
								<th colspan="2">Ranap</th>
								<th colspan="2">Poned</th>
								<th colspan="2">Pustu</th>
								<th colspan="2">Pusling</th>
								<th colspan="2">Poli</th>
							</tr>
							<tr>
								<th>Sistem</th><!--gudang-->
								<th>Fisik</th>
								<th>Sistem</th><!--depot-->
								<th>Fisik</th>
								<th>Sistem</th><!--igd-->
								<th>Fisik</th>
								<th>Sistem</th><!--ranap-->
								<th>Fisik</th>
								<th>Sistem</th><!--poned-->
								<th>Fisik</th>
								<th>Sistem</th><!--pustu-->
								<th>Fisik</th>
								<th>Sistem</th><!--pusling-->
								<th>Fisik</th>
								<th>Sistem</th><!--poli-->
								<th>Fisik</th>
							</tr>	
						</thead>								
						<tbody>
							<?php
							// setiap load, hapus dl untuk memperbaharui datanya
							$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT `KodeBarang` FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `Bulan`='$bulan' AND `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas'"));
							if ($cek == 0){	
								// jangan menggunakan ref_obat_lplpo, mengantisipasi jika ada item obat sama beda batch
								$query1 = mysqli_query($koneksi, "SELECT * FROM `tbgudangpkmstok` WHERE `KodePuskesmas`='$kodepuskesmas'");
								while($data = mysqli_fetch_assoc($query1)){
									// stok gudangpkm
									$dtgudang= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbgudangpkmstok` WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]' AND KodePuskesmas = '$kodepuskesmas'"));
									// stok depot
									$dtdepot = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbapotikstok` WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]' AND KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='LOKET OBAT'"));
									$dtdepot_igd = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbapotikstok` WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]' AND KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='POLI IGD'"));
									$dtdepot_ranap = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbapotikstok` WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]' AND KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='RAWAT INAP'"));
									$dtdepot_poned = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbapotikstok` WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]' AND KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='PONED'"));
									$dtdepot_pustu = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbapotikstok` WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]' AND KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='PUSTU'"));
									$dtdepot_pusling = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbapotikstok` WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]' AND KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='PUSLING'"));
									$dtdepot_poli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbapotikstok` WHERE `KodeBarang`='$data[KodeBarang]' AND `NoBatch`='$data[NoBatch]' AND KodePuskesmas = '$kodepuskesmas' AND `StatusBarang`='POLI LANSIA'"));
									// insert
									$str1 = "INSERT INTO `tbstokopnam_puskesmas_detail_fisik`(`Bulan`,`Tahun`,`KodePuskesmas`,`KodeBarang`,`NamaBarang`,`Satuan`,`NoBatch`,`Expire`,`HargaSatuan`,`IdProgram`,`NamaProgram`,`StokGudang_Sistem`,`StokDepot_Sistem`,`StokIgd_Sistem`,`StokRanap_Sistem`,`StokPoned_Sistem`,`StokPustu_Sistem`,`StokPusling_Sistem`,`StokPoli_Sistem`) 
									VALUES ('$bulan','$tahun','$kodepuskesmas','$data[KodeBarang]','$data[NamaBarang]','$data[Satuan]','$data[NoBatch]','$data[Expire]','$data[HargaSatuan]','$data[IdProgram]','$data[NamaProgram]','$dtgudang[Stok]','$dtdepot[Stok]','$dtdepot_poli[Stok]','$dtdepot_igd[Stok]','$dtdepot_ranap[Stok]','$dtdepot_poned[Stok]','$dtdepot_pustu[Stok]','$dtdepot_pusling[Stok]')";	
									mysqli_query($koneksi, $str1);
								}
							}else{
								$cek2 = "SELECT * FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `Bulan`='$bulan' AND `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas'";
								$query2 = mysqli_query($koneksi, $cek2);
								while($data2 = mysqli_fetch_assoc($query2)){
									// stok gudangpkm
									$dtgudang= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbgudangpkmstok` WHERE `KodeBarang`='$data2[KodeBarang]' AND `NoBatch`='$data2[NoBatch]' AND `Expire`='$data2[Expire]' AND `HargaSatuan`='$data2[HargaSatuan]' AND `KodePuskesmas`='$kodepuskesmas'"));
									
									// update 
									$str2 = "UPDATE `tbstokopnam_puskesmas_detail_fisik` SET `StokGudang_Sistem`='$dtgudang[Stok]' WHERE `IdStokBulan`='$data2[IdStokBulan]'";
									mysqli_query($koneksi, $str2);
								}	
							}	
							
							$jumlah_perpage = 50;
							if($_GET['h']==''){
								$mulai=0;
							}else{
								$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							$key = $_GET['key'];
							$namaprg = $_GET['namaprg'];
							
							if($key !=''){
								$strcari = " AND (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%')";
							}else{
								$strcari = " ";
							}
							
							if($namaprg != ''){
								$namaprg = " AND `NamaProgram` = '$namaprg'";
							}else{
								$namaprg = " ";
							}
							
							// syaratnya gudang, depot <> 0, jika salahsatunya ada isi maka obat tetap ditampilkan
							$str = "SELECT * FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Bulan`='$bulan' AND `Tahun`='$tahun'
							AND (StokGudang_Sistem <> '0' OR StokDepot_Sistem <> '0' OR StokIgd_Sistem <> '0' OR StokRanap_Sistem <> '0' OR StokPoned_Sistem <> '0' 
							OR StokPustu_Sistem <> '0' OR StokPoli_Sistem <> '0')".$strcari.$namaprg;
							$str2 = $str." ORDER BY `IdProgram`,`NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";
							// echo $str2;
							
							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							$query = mysqli_query($koneksi,$str2);
							while($data = mysqli_fetch_assoc($query)){	
								if($namaprogram != $data['NamaProgram']){
									echo "<tr style='border:1px sollid #000; font-weight: bold;'><td colspan='23'>$data[NamaProgram]</td></tr>";
									$namaprogram = $data['NamaProgram'];
								}	
								$no = $no + 1;
								$IdBarangPkm = $data['IdStokBulan'];
								$kodebarang = $data['KodeBarang'];
								$namabarang = $data['NamaBarang'];
								$nobatch = $data['NoBatch'];						
								$harga = $data['HargaSatuan'];
								$expire = $data['Expire'];
								
								if($data['SumberAnggaran'] == "APBD KAB/KOTA"){
									$sumber = "APBD";
								}else{
									$sumber = $data['SumberAnggaran'];
								}			
								
								// tbstokopnam_puskesmas_detail_fisik
								$dtgudang= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `KodePuskesmas`='$kodepuskesmas' AND `Bulan`='$bulan' AND `Tahun`='$tahun'"));
								
								// total stok
								$ttl_stok = $dtgudang['StokGudang_Sistem'] + $dtgudang['StokDepot'] + $dtgudang['StokPoli'] + $dtgudang['StokIgd'] + $dtgudang['StokRanap'] + $dtgudang['StokPoned'] + $dtgudang['StokPustu'];
								$ttl_rupiah = $ttl_stok * $harga;
								
								// tbgfk_vaksin 
								$dtgfkstok_vaksin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kodebarang'"));
							?>
							
								<tr style="border:1px solid #000;">
									<td align="center"><?php echo $no;?></td>
									<td align="center" class="kodebarangcls">
										<input type="hidden" name="kodebarang[<?php echo $IdBarangPkm;?>]" value="<?php echo $data['KodeBarang'];?>"/>
										<input type="hidden" name="idbarang[<?php echo $IdBarangPkm;?>]" value="<?php echo $data['IdStokBulan'];?>"/>
										<input type="hidden" name="namabarang[<?php echo $IdBarangPkm;?>]" value="<?php echo $data['NamaBarang'];?>"/>
										<input type="hidden" name="expire[<?php echo $IdBarangPkm;?>]" value="<?php echo $data['Expire'];?>"/>
										<input type="hidden" name="hargasatuan[<?php echo $IdBarangPkm;?>]" value="<?php echo $data['HargaSatuan'];?>"/>
										<input type="hidden" name="idprogram[<?php echo $IdBarangPkm;?>]" value="<?php echo $data['IdProgram'];?>"/>
										<input type="hidden" name="namaprogram[<?php echo $IdBarangPkm;?>]" value="<?php echo $data['NamaProgram'];?>"/>
										<?php echo $kodebarang;?>
									</td>
									<td align="left" class="namabarangcls"><?php echo $namabarang;?></td>
									<td align="center">
										<input type="hidden" name="nobatch[<?php echo $IdBarangPkm;?>]" value="<?php echo $data['NoBatch'];?>"/>
										<?php echo str_replace(",", ", ", $nobatch);?>
									</td>
									
									<!--sisa stok gudang-->
									<td align="center">
										<?php 
											$dtgudang= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StokGudang_Sistem`,`StokGudang_Fisik` FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `IdStokBulan`='$IdBarangPkm'"));
										?>
										<input type="number" class="ipt" name="gudangobat_sistem[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;; text-align:right;" value="<?php echo $dtgudang['StokGudang_Sistem'];?>"/>
									</td>
									<td align="center"  style="background-color:#dbf7ff;">
										<input type="number" name="gudangobat_fisik[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;; text-align:right;" value="<?php echo $dtgudang['StokGudang_Fisik'];?>"/>
									</td>
									
									<!--sisa stok depot-->
									<td align="center">
										<?php
											$dtdepot= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StokDepot_Sistem`,`StokDepot_Fisik` FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `KodePuskesmas`='$kodepuskesmas' AND `Bulan`='$bulan' AND `Tahun`='$tahun'"));
										?>
										<input type="number" class="ipt" name="depotobat_sistem[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;" value="<?php echo $dtdepot['StokDepot_Sistem'];?>"/>
									</td>
									<td align="center"  style="background-color:#dbf7ff;">
										<input type="number" name="depotobat_fisik[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;; text-align:right;" value="<?php echo $dtdepot['StokDepot_Fisik'];?>"/>
									</td>
									
									<!--sisa stok igd-->
									<td align="center">
										<?php
											$dtigd= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StokIgd_Sistem`,`StokIgd_Fisik` FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `KodePuskesmas`='$kodepuskesmas' AND `Bulan`='$bulan' AND `Tahun`='$tahun'"));
										?>
										<input type="number" class="ipt" name="depotigd_sistem[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;" value="<?php echo $dtigd['StokIgd_Sistem'];?>"/>
									</td>
									<td align="center"  style="background-color:#dbf7ff;">
										<input type="number" name="depotigd_fisik[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;; text-align:right;" value="<?php echo $dtigd['StokIgd_Fisik'];?>"/>
									</td>
									
									<!--sisa stok ranap-->
									<td align="center">
										<?php
											$dtranap= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StokRanap_Sistem`,`StokRanap_Fisik` FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `KodePuskesmas`='$kodepuskesmas' AND `Bulan`='$bulan' AND `Tahun`='$tahun'"));
										?>
										<input type="number" class="ipt" name="depotranap_sistem[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;" value="<?php echo $dtranap['StokRanap_Sistem'];?>"/>
									</td>
									<td align="center"  style="background-color:#dbf7ff;">
										<input type="number" name="depotranap_fisik[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;; text-align:right;" value="<?php echo $dtranap['StokRanap_Fisik'];?>"/>
									</td>
									
									<!--sisa stok poned-->
									<td align="center">
										<?php
											$dtponed= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StokPoned_Sistem`,`StokPoned_Fisik` FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `KodePuskesmas`='$kodepuskesmas' AND `Bulan`='$bulan' AND `Tahun`='$tahun'"));
										?>
										<input type="number" class="ipt" name="depotponed_sistem[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;" value="<?php echo $dtponed['StokPoned_Sistem'];?>"/>
									</td>
									<td align="center"  style="background-color:#dbf7ff;">
										<input type="number" name="depotponed_fisik[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;; text-align:right;" value="<?php echo $dtponed['StokPoned_Fisik'];?>"/>
									</td>
									
									<!--sisa stok pustu-->
									<td align="center">
										<?php
											$dtpustu= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StokPustu_Sistem`,`StokPustu_Fisik` FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `KodePuskesmas`='$kodepuskesmas' AND `Bulan`='$bulan' AND `Tahun`='$tahun'"));
										?>
										<input type="number" class="ipt" name="depotpustu_sistem[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;" value="<?php echo $dtpustu['StokPustu_Sistem'];?>"/>
									</td>
									<td align="center"  style="background-color:#dbf7ff;">
										<input type="number" name="depotpustu_fisik[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;; text-align:right;" value="<?php echo $dtpustu['StokPustu_Fisik'];?>"/>
									</td>
									
									<!--sisa stok pusling-->
									<td align="center">
										<?php
											$dtpusling= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StokPusling_Sistem`,`StokPusling_Fisik` FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `KodePuskesmas`='$kodepuskesmas' AND `Bulan`='$bulan' AND `Tahun`='$tahun'"));
										?>
										<input type="number" class="ipt" name="depotpusling_sistem[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;" value="<?php echo $dtpusling['StokPusling_Sistem'];?>"/>
									</td>
									<td align="center"  style="background-color:#dbf7ff;">
										<input type="number" name="depotpusling_fisik[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;; text-align:right;" value="<?php echo $dtpusling['StokPusling_Fisik'];?>"/>
									</td>
									
									<!--sisa stok poli-->
									<td align="center">
										<?php
											$dtpoli= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `StokPoli_Sistem`,`StokPoli_Fisik` FROM `tbstokopnam_puskesmas_detail_fisik` WHERE `KodeBarang`='$kodebarang' AND `NoBatch`='$nobatch' AND `KodePuskesmas`='$kodepuskesmas' AND `Bulan`='$bulan' AND `Tahun`='$tahun'"));
										?>
										<input type="number" class="ipt" name="depotpoli_sistem[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;" value="<?php echo $dtpoli['StokPoli_Sistem'];?>"/>
									</td>
									<td align="center"  style="background-color:#dbf7ff;">
										<input type="number" name="depotpoli_fisik[<?php echo $IdBarangPkm;?>]" style="width:70px; text-align:right;; text-align:right;" value="<?php echo $dtpoli['StokPoli_Fisik'];?>"/>
									</td>
									
									<!--total-->
									<td align="right"><?php echo rupiah($ttl_stok);?></td>
									
									<!--total harga-->
									<td align="right">
										<?php
											// cek jika ada koma
											$cekkoma = strpos($ttl_rupiah,".");
											if ($cekkoma > 1){;
												echo number_format($ttl_rupiah,2,",",".");
											}else{
												echo rupiah($ttl_rupiah);
											}
										?>
									</td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table><br/>
					<input type="submit" class="btnsimpan" style="padding: 10px" value="Simpan">
				</div>
			</div>
		</form>	
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
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=lap_farmasi_stok_opname_lihat_gudang&nf=$nf&bl=$bulan&th=$tahun&namaprg=$_GET[namaprg]&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p>
					<b>Perhatikan :</b><br/>
					- Silahkan isi sisa stok pada kolom fisik(biru)<br/>	
				</p>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript">
	$( ".ipt" ).each(function( index ) {
	  var ini = $(this).val();
		if(ini == 0){
			$(this).prop('readonly', true);
		}
	});
</script>