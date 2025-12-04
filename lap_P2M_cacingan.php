<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
	$tbgudangpkmstok = "tbgudangpkmstok_".str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER CACINGAN</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_cacingan"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" style="float:left;margin-right:10px;" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal" required> 
						</div>
						<div  class="col-xl-2">
							<input type="text" name="keydate2" class="form-control datepicker2" style="float:left;margin-right:10px;" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir" required>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_cacingan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_P2M_cacingan_excel.php?keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>
			</div>	
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
	if(isset($keydate1) and isset($keydate2)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER CACINGAN</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: 
			<?php echo date('d-m-Y', strtotime($keydate1)) ." s/d ".date('d-m-Y', strtotime($keydate2));?>
		</span>
		<br/><br/>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead>
						<tr style="border:1px solid #000;">
							<th width="3%" rowspan="2">NO.</th>
							<th width="7%" rowspan="2">TGL.PERIKSA</th>
							<th width="10%" rowspan="2">NAMA PASIEN</th>
							<th width="10%" rowspan="2">KEPALA KELUARGA</th>
							<th width="5%" colspan="2">UMUR<br/>PASIEN</th>
							<th width="15%" rowspan="2">ALAMAT</th>
							<th width="8%" rowspan="2">TELP.</th>
							<th width="10%" rowspan="2">THERAPY</th>
							<th width="15%" colspan="3">PEMERIKSAAN TINJA</th>
							<th width="10%" colspan="2">PENGOBATAN (ALBENDAZOLE)</th>
							<th width="5%" rowspan="2">KET.</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th>L</th>
							<th>P</th>
							<th>TANGGAL</th>
							<th>HASIL</th>
							<th>JUMLAH</th>
							<th>DOSIS</th>
							<th>JUMLAH</th>
						</tr>
						<tr>
							<th>1</th>
							<th>2</th>
							<th>3</th>
							<th>4</th>
							<th>5</th>
							<th>6</th>
							<th>7</th>
							<th>8</th>
							<th>9</th>
							<th>10</th>
							<th>11</th>
							<th>12</th>
							<th>13</th>
							<th>14</th>
							<th>15</th>
						</tr>
					</thead>
					<tbody style="font-size:12px;">
						<?php
						$jumlah_perpage = 20;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$waktu = " date(TanggalDiagnosa) BETWEEN '$keydate1' AND '$keydate2'";						
						$str = "SELECT * FROM `$tbdiagnosapasien` WHERE ".$waktu." AND (`KodeDiagnosa` LIKE '%B83%' OR `KodeDiagnosa` like '%B77%' OR `KodeDiagnosa` = 'B83.0' OR `KodeDiagnosa` = 'T37.4' OR `KodeDiagnosa` LIKE '%B76%' OR `KodeDiagnosa` LIKE '%B80%')";
						$str2 = $str." LIMIT $mulai,$jumlah_perpage";
						// echo $str;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query_ispa = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query_ispa)){
							$no = $no + 1;
							$noindex = $data['NoIndex'];
							$nocm = $data['NoCM'];
							$noregistrasi = $data['NoRegistrasi'];
							$tanggaldiagnosa = $data['TanggalDiagnosa'];
							
							// tbkk
							$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaKK`,`Alamat`,`RT`,`No`,`Kelurahan`,`Telepon` FROM `$tbkk` WHERE `NoIndex` = '$noindex'"));
							$namakk = $datakk['NamaKK'];
							$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", NO.".$datakk['No'].", ".$datakk['Kelurahan'];
							
							// tbpasien
							$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `NoCM` = '$nocm'"));
							$nik = $datapasien['Nik'];
							$namapasien = $datapasien['NamaPasien'];
							
							// tbpasienrj
							$datapasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'"));
							$jeniskelamin = $datapasienrj['JenisKelamin'];
							$umurtahun = $datapasienrj['UmurTahun'];
							$umurbulan= $datapasienrj['UmurBulan'];
							
							// therapy
							$str_therapy = "SELECT * FROM `$tbresepdetail` WHERE `NoResep` = '$noregistrasi'";
							$query_therapy = mysqli_query($koneksi, $str_therapy);
							while($dt_therapy = mysqli_fetch_array($query_therapy)){
								$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `NamaBarang` FROM `$tbgudangpkmstok` WHERE `KodeBarang` = '$dt_therapy[KodeBarang]'"));
								$array_therapy[$no][] = $dtobat['NamaBarang']." (".$dt_therapy['jumlahobat'].")";
							}
							if ($array_therapy[$no] != ''){
								$data_trp = implode("<br/>", $array_therapy[$no]);
							}else{
								$data_trp ="";
							}
							
							if($umurtahun != '0'){
								$umur = $umurtahun."Th";
							}else{
								$umur = $umurbulan."Bl";
							}	
							
							if($jeniskelamin == 'L'){
								$umur_laki = $umur;
							}else{
								$umur_laki = "-";
							}
					
							if($jeniskelamin == 'P'){
								$umur_perempuan = $umur;
							}else{
								$umur_perempuan = "-";
							}
				
						
						?>
							<tr style="border:1px solid #000;">
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo date('d-m-Y', strtotime($tanggaldiagnosa));?></td>
								<td align="left"><?php echo $namapasien;?></td>
								<td align="left"><?php echo $namakk;?></td>
								<td align="center"><?php echo $umur_laki;?></td>
								<td align="center"><?php echo $umur_perempuan;?></td>
								<td align="left"><?php echo $alamat;?></td>											
								<td align="center">
									<?php 
										if($datakk['Telepon'] != ''){
											echo $datakk['Telepon'];
										}else{
											if($datapasien['Telpon'] != ''){
												echo $datapasien['Telpon'];
											}else{
												echo "BELUM DIINPUTKAN";
											}	
										}	
									?>
								</td>							
								<td align="left"><?php echo strtoupper($data_trp);?></td>
								<td align="left"></td>
								<td align="left"></td>
								<td align="left"></td>
								<td align="left"></td>
								<td align="left"></td>
								<td align="left"><?php echo strtoupper($data['KodeDiagnosa']);?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br>
	<hr class="noprint">
	<ul class="pagination noprint">
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
						echo "<li><a href='?page=lap_P2M_cacingan&bulan=$bulan&tahun=$tahun&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p><b>Kategori Kode Penyakit :</b><br>
				- Kode ICD x = B83.0, B77, B83.0, T37.4, B76, B80<br/>
				</p>
			</div>
		</div>
	</div>
</div>