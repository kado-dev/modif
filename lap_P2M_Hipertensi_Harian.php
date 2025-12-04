<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$tbdiagnosapasien = "tbdiagnosapasien_".str_replace(' ', '', $namapuskesmas);
	$tbkk = "tbkk_".str_replace(' ', '', $namapuskesmas);
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class = "row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER HIPERTENSI & DM</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_Hipertensi_Harian"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal" required>
						</div>
						<div class="col-xl-2">
							 <input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir" required>
						</div>
						<div class="col-xl-2">
							<SELECT name="kasus" class="form-control">
								<option value="Semua" <?php if($_GET['kasus'] == 'Semua'){echo "SELECTED";}?>>Kasus</option>
								<option value="Baru" <?php if($_GET['kasus'] == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value="Lama" <?php if($_GET['kasus'] == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</SELECT>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_Hipertensi_Harian" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_P2M_Hipertensi_Harian_excel.php?keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&kasus=<?php echo $_GET['kasus'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	if(isset($keydate1) and isset($keydate2)){
	?>
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER DIARE</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2))?> <?php echo $tahun;?></span>
		<br/>
	</div>

	<!--data registrasi-->
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" width="100%">
					<thead style="font-size:12px;">
						<tr>
							<th rowspan="2" width="3%">NO.</th>
							<th rowspan="2" width="7%">TANGGAL</th>
							<th rowspan="2" width="17%">NAMA PASIEN-KK</th>
							<th colspan="2" width="8%">UMUR</th>
							<th rowspan="2" width="5%">KUNJ.</th>
							<th colspan="4" width="8%">VITAL SIGN</th>
							<th rowspan="2" width="10%">ANAMNESA</th>
							<th rowspan="2" width="5%">DIAGNOSA</th>
							<th rowspan="2" width="12%">THERAPY</th>
							<th colspan="2" width="5%">RUJUK</th>
							<th rowspan="2" width="5%">KET.</th>
						</tr>
						<tr>
							<th>L</th>
							<th>P</th>
							<th>TD</th>
							<th>BB/TB</th>
							<th>SUHU</th>
							<th>HR/RR</th>
							<th>YA</th>
							<th>TDK</th>
						</tr>
					</thead>
					<tbody style="font-size:12px;">
						<?php
						$jumlah_perpage = 20;
						
						$waktu = "TanggalRegistrasi BETWEEN '$keydate1' AND '$keydate2'";
						$tbdiagnosadiare = 'tbdiagnosadiare';
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						// tbdiagnosadiare
						$kasus = $_GET['kasus'];
						if($kasus != 'Semua'){
							$qkasus = " AND Kunjungan = '$kasus' ";
						}else{
							$qkasus = " ";
						}
						
						// tbdiagnosa_bulan
						$str_diare = "SELECT * FROM `$tbdiagnosapasien` WHERE TanggalDiagnosa BETWEEN '$keydate1' AND '$keydate2' AND (`KodeDiagnosa` like '%I10%' OR `KodeDiagnosa` like '%I15%' OR `KodeDiagnosa` like '%E10%' OR `KodeDiagnosa` like '%E11%' OR `KodeDiagnosa` like '%E14%')";
						$str2 = $str_diare."order by `TanggalDiagnosa` LIMIT $mulai,$jumlah_perpage";
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query_diare = mysqli_query($koneksi,$str2);
						while($data_diare = mysqli_fetch_assoc($query_diare)){
							$no = $no + 1;
							$noreg = $data_diare['NoRegistrasi'];
							$noindex = $data_diare['NoIndex'];
							$nocm = $data_diare['NoCM'];

							// tbkk
							$dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaKK`,`Alamat`,`RT`,`RW`,`Kelurahan`,`Telepon` FROM `$tbkk` WHERE `NoIndex`='$noindex'"));
							$alamat = strtoupper($dtkk['Alamat']).", RT.".$dtkk['RT'].", NO.".$dtkk['No']." ".strtoupper($dtkk['Kelurahan']);
							
							// tbpasien
							$dtpasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `TanggalLahir`,`Nik`,`Telpon` FROM `$tbpasien` WHERE `NoCM`='$nocm'"));
							
							// tbpasienrj
							$dt_pasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaPasien`,`JenisKelamin`,`UmurTahun`,`UmurBulan`,`UmurHari`,`PoliPertama`,`StatusKunjungan`,`Asuransi`
							FROM $tbpasienrj WHERE `NoRegistrasi`='$noreg'"));
							$kelamin = $dt_pasienrj['JenisKelamin'];
							$kunjungan = strtoupper($dt_pasienrj['StatusKunjungan']);
							$pelayanan = $dt_pasienrj['PoliPertama'];
							
							// cek umur kelamin
							if ($kelamin == 'L'){
								if($dt_pasienrj['UmurTahun'] != 0){
									$umur_l = $dt_pasienrj['UmurTahun']." TH";
								}else{
									if($dt_pasienrj['UmurBulan'] == 0){
										$umur_l = $dt_pasienrj['UmurBulan']." BL";
									}else{
										$umur_l = $dt_pasienrj['UmurHari']." HR";
									}	
								}	
								$umur_p = "-";
							}else{
								$umur_l = "-";
								if($dt_pasienrj['UmurTahun'] != 0){
									$umur_p = $dt_pasienrj['UmurTahun']." TH";
								}else{
									if($dt_pasienrj['UmurBulan'] == 0){
										$umur_p = $dt_pasienrj['UmurBulan']." BL";
									}else{
										$umur_p = $dt_pasienrj['UmurHari']." HR";
									}
								}
							}
							
							// poli
							if($pelayanan == 'POLI UMUM'){
								$pelayanan = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
								$datapoli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Anamnesa`,`Sistole`,`Diastole`,`BeratBadan`,`TinggiBadan`,`SuhuTubuh`,`DetakNadi`,`RR`,`StatusPulang` FROM $pelayanan WHERE `NoPemeriksaan`='$noreg'"));
							}else{
								$pelayanan = "tb".strtolower(str_replace(' ', '', $dt_pasienrj['PoliPertama']));
								$datapoli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Anamnesa`,`Sistole`,`Diastole`,`BeratBadan`,`TinggiBadan`,`SuhuTubuh`,`DetakNadi`,`RR`,`StatusPulang` FROM $pelayanan WHERE `NoPemeriksaan`='$noreg'"));
							}
							
							$tensi = $datapoli['Sistole']."/".$datapoli['Diastole'];
							$bbtb = $datapoli['BeratBadan']."/".$datapoli['TinggiBadan'];
							$suhu = $datapoli['SuhuTubuh'];
							$hrrr = $datapoli['DetakNadi']."/".$datapoli['RR'];	

							// cek rujukan
							$rujukan = $datapoli['StatusPulang'];
							if ($rujukan == 3){
								$berobatjalan = '<span class="fa fa-check"></span>';
								$rujuklanjut = '-';
							}else if($rujukan == 4){
								$rujuklanjut = '<span class="fa fa-check"></span>';
								$berobatjalan = '-';
							}							
							
							// tbdiagnosadiare
							$dtdiare = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbdiagnosadiare` WHERE `NoRegistrasi`='$noreg'"));
							$tindakan = $dtdiare['TindakanPengobatan'];	
														
							// tindakan pengobatan
							$pecah = explode(",",$tindakan);
														
							if($pecah[0] == 'Oralit' || $pecah[0] = 'Infus' || $pecah[0] = 'Zinc'){
								$oralit = '<span class="glyphicon glyphicon-ok"></span>';
								$antibiotik = '-';
							}elseif($pecah[1] == 'Oralit' || $pecah[1] == 'Oralit' and $pecah[1] == 'Oralit'){
								$oralit = '<span class="glyphicon glyphicon-ok"></span>';
								$antibiotik = '-';
							}elseif($pecah[2] == 'Antibiotik' || $pecah[2] == 'Antibiotik' and $pecah[2] == 'Antibiotik'){
								$oralit = '-';
								$antibiotik = '<span class="glyphicon glyphicon-ok"></span>';	
							}
							
							// tbpasienperpegawai
							$tbpasienperpegawai='tbpasienperpegawai_'.$kodepuskesmas;
							$dt_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienperpegawai` WHERE `NoRegistrasi`='$noreg'"));
							if($dt_pegawai['NamaPegawai1']!=''){
								$pemeriksa = $dt_pegawai['NamaPegawai1'];
							}else{
								$pemeriksa = $dt_pegawai['NamaPegawai2'];
							}
						
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo date('d/m/y', strtotime($data_diare['TanggalDiagnosa']));?></td>
								<td align="left">
									<?php 
										echo "<b>".strtoupper($dt_pasienrj['NamaPasien']."</b><br/>".
										"NIK : ".$dtpasien['Nik']."</b><br/>".
										"TGL.LAHIR : ".$dtpasien['TanggalLahir']."<br/><br/>".
										"<b>".strtoupper($dtkk['NamaKK'])."</b><br/>".
										"No.Index : ".substr($noindex, -10)."<br/>".
										"CARA BAYAR : ".$dt_pasienrj['Asuransi']."<br/>".
										"PELAYANAN : ".str_replace('POLI','', $dt_pasienrj['PoliPertama'])."<br/>".
										"ALAMAT : ".$dtkk['Alamat'].", ".$dtkk['RT'].", ".$dtkk['Kelurahan'])."<br/>";
										
										if($dtkk['Telepon'] != ''){
											echo "TELP. : ".$dtkk['Telepon'];
										}else{
											if($dtpasien['Telpon'] != ''){
												echo "TELP. : ".$dtpasien['Telpon'];
											}else{
												echo "TELP. 0";
											}	
										}
										
									?>
								</td>
								<td align="center"><?php echo $umur_l;?></td>
								<td align="center"><?php echo $umur_p;?></td>
								<td align="center"><?php echo $kunjungan;?></td>
								<td align="center">
									<?php 
										if($datapoli['Sistole'] != ""){
											echo $tensi;
										}else{
											echo "0";
										}	
									?>
								</td>
								<td align="center"><?php echo $bbtb;?></td>
								<td align="center">
									<?php 
										if($datapoli['SuhuTubuh'] != ""){
											echo $suhu;
										}else{
											echo "0";
										}
									?>
								</td>
								<td align="center">
									<?php 
										if($datapoli['DetakNadi'] != ""){
											echo $hrrr;
										}else{
											echo "0";
										}
									?>
								</td>
								<td align="left"><?php echo $datapoli['Anamnesa'];?></td>
								<td align="center">
									<?php
										// tbdiagnosapasien
										$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noreg'";
										$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
										while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
											$array_data[$no][] = $data_diagnosapsn['KodeDiagnosa'];
										}

										if ($array_data[$no] != ''){
											$data_dgs = implode("<br/>", $array_data[$no]);
											echo $data_dgs;
										}else{
										?>
											<span class='badge badge-danger' style='padding: 4px;'><i class='icon-close fa-3x'></i></span>
										<?php 
										}
									 ?>
								</td>
								<td align="center">
									<?php
										// therapy
										$qrdata_therapy = mysqli_query($koneksi, "SELECT * FROM `$tbresepdetail` WHERE `NoResep`='$data_diare[NoRegistrasi]' AND DATE(TanggalResep) IS NOT NULL GROUP BY NoResep, KodeBarang, Pelayanan");
										while($data_therapy = mysqli_fetch_array($qrdata_therapy)){
											$data_obat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbapotikstok` WHERE `KodeBarang` = '$data_therapy[KodeBarang]' GROUP BY KodeBarang"));
											$array_obat[$no][] = $data_obat['NamaBarang'];
										}
										
										if ($array_obat[$no] != ''){
											$data_obt = implode(", ", $array_obat[$no]);
											echo $data_obt;
										}else{
									?>
										<span class='badge badge-danger' style='padding: 4px;'><i class='icon-close fa-3x'></i></span>
									<?php } ?>	
								</td>
								<td align="left"><?php echo $rujuklanjut;?></td>
								<td align="left"><?php echo $berobatjalan;?></td>
								<td align="left"><?php echo strtoupper($pemeriksa);?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>
	<br/>
	<hr class="noprint">
	<ul class="pagination noprint">
		<?php
			$query2 = mysqli_query($koneksi,$str_diare);
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
						echo "<li><a href='?page=lap_P2M_Hipertensi_Harian&keydate1=$keydate1&keydate2=$keydate2&kasus=$kasus&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
	<div class = "row noprint">
		<div class="col-sm-12 table-responsive">
			<div class="formbg">
				<p>
					<b>Perhatikan :</b><br/>
					- Klasifikasi Hipertensi (I10, I15)<br/>
					- Klasifikasi DM (E10, E11, E14)
				</p>
			</div>
		</div>
	</div>
</div>