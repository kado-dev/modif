<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>TRACKING DIAGONOSA</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_penyakit"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal" required>
						</div>
						<div class="col-xl-2">
							<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir" required>
						</div>
						<div class="col-xl-4">
							<td class="col-sm-7">
								<input type="text" class="form-control diagnosabpjs" name="keywords" value="<?php echo $_GET['keywords'];?>">
								<input type="hidden" name="kodebpjs" class="form-control kodebpjs" value="<?php echo $_GET['kodebpjs'];?>">
								<input type="hidden" class="form-control diagnosahiddenbpjs">
							</td>
						</div>
						<div class="col-xl-2">
							<select name="kasus" class="form-control">
								<option value="semua">semua</option>
								<option value="Baru" <?php if($_GET['kasus'] == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value="Lama" <?php if($_GET['kasus'] == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</select>
						</div>
						<div class="col-xl-2">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<!--<a href="?page=lap_P2M_penyakit" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>-->
							<!--<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>-->
							<a href="lap_P2M_penyakit_excel.php?keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&kodebpjs=<?php echo $_GET['kodebpjs'];?>&kasus=<?php echo $_GET['kasus'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>	
				</form>
			</div>
		</div>
	</div>

	<?php
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$kodediagnosa = $_GET['kodebpjs'];
	$kasus = $_GET['kasus'];
	$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);

	if(isset($keydate1) AND isset($keydate2)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "UPT. PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b><?php echo "REGISTER TRACKING DIAGNOSA (".$kodediagnosa.")";?></b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan:
			<?php 
				echo date('d-m-Y', strtotime($keydate1)) ." s/d ".date('d-m-Y', strtotime($keydate2));
			?>
		</span>
		<br/>
	</div>

	<div class="atastabel font11">
		<div style="float:left; width:35%; margin-bottom:10px;">	
			<table>
				<tr>
					<td style="padding:2px 4px;">Kelurahan/Desa</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $kelurahan;?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Kecamatan</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $kecamatan;?></td>
				</tr>
			</table>
		</div>	
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th rowspan="2"width="3%">NO.</th>
							<th rowspan="2" width="7%">TGL.PERIKSA</th>
							<th rowspan="2" width="10%">NAMA PASIEN</th>
							<th rowspan="2" width="5%">TGL.LAHIR</th>
							<th colspan="2" width="5%">UMUR</th>
							<th rowspan="2" width="10%">ALAMAT</th>
							<th rowspan="2" width="5%">KUNJ</th>
							<th rowspan="2" width="10%">JAMINAN</th>
							<th rowspan="2" width="5%">LAYANAN</th>
							<th rowspan="2" width="15%">ANAMNESA</th>
							<th colspan="4" width="10%">VITAL SIGN</th>
							<th rowspan="2" width="5%">DIAGNOSA</th>
							<th rowspan="2" width="5%">KASUS</th>
						</tr>
						<tr>
							<th>L</th>
							<th>P</th>
							<th>TD</th>
							<th>BB/TB</th>
							<th>SUHU</th>
							<th>HR/RR</th>
						</tr>
					</thead>
					<tbody style="font-size: 12px;">
						<?php
						$jumlah_perpage = 50;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						// tbdiagnosapasien
						if($_GET['kasus'] == 'semua'){
							$kasus = "";
						}else{
							$kasus = "AND `Kasus` = '$_GET[kasus]'";
						}
						
						$waktu = "TanggalDiagnosa BETWEEN '$keydate1' AND '$keydate2'";
						$str_diagnosa = "SELECT * FROM `$tbdiagnosapasien` WHERE ".$waktu." AND `KodeDiagnosa` LIKE '%$kodediagnosa%' ".$kasus;
						$str2 = $str_diagnosa." ORDER BY TanggalDiagnosa limit $mulai,$jumlah_perpage";
						// echo $str2;	
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query_diagnosa = mysqli_query($koneksi,$str2);
						while($data_diagnosa = mysqli_fetch_assoc($query_diagnosa)){
							$no = $no + 1;
							$idpasienrj = $data_diagnosa['IdPasienrj'];
							$noregistrasi = $data_diagnosa['NoRegistrasi'];
							$kodediagnosa = $data_diagnosa['KodeDiagnosa'];
							$kasus = $data_diagnosa['Kasus'];

							$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idpasienrj'";
							$dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
							$dtsistole = $dtvs['Sistole'];
							$dtdiastole = $dtvs['Diastole'];
							$dtsuhutubuh = $dtvs['SuhuTubuh'];
							$dttinggiBadan = $dtvs['TinggiBadan'];
							$dtberatBadan = $dtvs['BeratBadan'];
							$dtheartRate = $dtvs['HeartRate'];
							$dtrespRate = $dtvs['RespiratoryRate'];
							$dtLingkarPerut = $dtvs['LingkarPerut'];
							$imt = $dtvs['IMT'];
						
							// tbpasienrj 
							$str_rj = "SELECT * FROM `$tbpasienrj` WHERE NoRegistrasi = '$noregistrasi'";
							$query_rj = mysqli_query($koneksi,$str_rj);
							$data_rj = mysqli_fetch_assoc($query_rj);
							$noindex = $data_rj['NoIndex'];
							$kelamin = $data_rj['JenisKelamin'];
							$poli = $data_rj['PoliPertama'];
							$nokartu = $data_rj['nokartu'];
						
							// tbpasien
							$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Nik,NoIndex,TanggalLahir FROM `$tbpasien` WHERE `NoCM`='$data_rj[NoCM]'"));
							
							// tbkk
							$dt_kk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Alamat`,`RT`,`RW`,`Kelurahan` FROM `$tbkk` WHERE NoIndex = '$noindex'"));
													
							// ec_subdistricts
							$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$dt_kk[Kelurahan]'"));
										
							// ec_cities
							$dt_citi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `city_name` FROM `ec_cities` WHERE `city_id`='$dt_kk[Kota]'"));
							
							if($dt_kk['Alamat'] != ''){
								$alamat_kk = $dt_kk['Alamat']." RT. ".$dt_kk['RT']." ".$dt_subdis['subdis_name'];
							}else{
								$alamat_kk = "Alamat Belum di Inputkan";
							}

							//tbpoliumum
							if ($poli == 'POLI UMUM'){
								if($kota == "KABUPATEN BANDUNG"){
									$poliumum = "tbpoliumum";
								}else{
									$poliumum = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
								}
								$str_umum = "SELECT * FROM `$poliumum` WHERE `NoPemeriksaan` = '$noregistrasi'";
								$query_umum = (mysqli_query($koneksi,$str_umum));
								$data_umum = mysqli_fetch_assoc($query_umum);
								$anamnesa = $data_umum['Anamnesa'];
							}else if ($poli == 'POLI GIZI'){
								$str_gizi= "SELECT * FROM `tbpoligizi` WHERE `NoPemeriksaan` = '$noregistrasi'";
								$query_gizi = (mysqli_query($koneksi,$str_gizi));
								$data_gizi = mysqli_fetch_assoc($query_gizi);
								$anamnesa = $data_gizi['Anamnesa'];
							}else if ($poli == 'POLI LANSIA'){
								$str_lansia = "SELECT * FROM `tbpolilansia` WHERE `NoPemeriksaan` = '$noregistrasi'";
								$query_lansia = (mysqli_query($koneksi,$str_lansia));
								$data_lansia = mysqli_fetch_assoc($query_lansia);
								$anamnesa = $data_lansia['Anamnesa'];
							}else if ($poli == 'POLI MTBS'){
								$str_mtbs = "SELECT * FROM `tbpolimtbs` WHERE `NoPemeriksaan` = '$noregistrasi'";
								$query_mtbs = (mysqli_query($koneksi,$str_mtbs));
								$data_mtbs = mysqli_fetch_assoc($query_mtbs);
								$anamnesa = $data_mtbs['Anamnesa'];
							}else if ($poli == 'POLI UGD'){
								$str_ugd = "SELECT * FROM `tbpolitindakan` WHERE `NoPemeriksaan` = '$noregistrasi'";
								$query_ugd = (mysqli_query($koneksi,$str_ugd));
								$data_ugd = mysqli_fetch_assoc($query_ugd);
								$anamnesa = $data_ugd['Anamnesa'];
							}		
						
							// kelamin
							if($kelamin == 'L'){
								if($data_rj['UmurTahun'] != '0'){
									$kelamin_l = $data_rj['UmurTahun']."Th";
								}else{
									$kelamin_l = $data_rj['UmurBulan']."Bl";
								}	
								$kelamin_p = '-';
							}else{
								if($data_rj['UmurTahun'] != '0'){
									$kelamin_p = $data_rj['UmurTahun']."Th";
								}else{
									$kelamin_p = $data_rj['UmurBulan']."Bl";
								}	
								$kelamin_l = '-';
							}
						
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo date('d-m-Y', strtotime($data_diagnosa['TanggalDiagnosa']));?></td>
								<td style="text-align:left;border:1px solid #000; padding:3px;">
									<?php 
										echo "<b>".$data_rj['NamaPasien']."</b><br/>";
										echo substr($noindex,-10)."<br/>".
										$dt_pasien['Nik'];
									?>
								</td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo date('d-m-Y', strtotime($dt_pasien['TanggalLahir']));?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $kelamin_l;?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $kelamin_p;?></td>
								<td style="text-align:left;border:1px solid #000; padding:3px;"><?php echo strtoupper($alamat_kk);?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo strtoupper($data_rj['StatusKunjungan']);?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;">
									<?php 
										echo $data_rj['Asuransi']."<br/>";
										if (substr($data_rj['Asuransi'],0,4) == "BPJS"){
											echo $nokartu;
										}
									?>
								</td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo str_replace('POLI','',$data_rj['PoliPertama']);?></td>
								<td style="text-align:left;border:1px solid #000; padding:3px;"><?php echo $anamnesa;?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $dtsistole." / ".$dtdiastole;?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $dtberatBadan." / ".$dttinggiBadan;?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $dtsuhutubuh;?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $dtheartRate." / ".$dtrespRate;?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $kodediagnosa;?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo strtoupper($kasus);?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table><br/>
				
				<?php
					if ($noregistrasi != ''){
						if($kodediagnosa == 'A03.0' OR $kodediagnosa == 'A06.0' OR $kodediagnosa == 'A09'){
				?>
				<a href="lap_P2M_penyakit_export.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kodedgs=<?php echo $_GET['kodebpjs'];?>&kdpkm=<?php echo $kodepuskesmas;?>" class="btn btn-sm btn-info">Export > Diare</a>
				<?php
						}
					}
				?>
			</div>
		</div>
	</div>
	<br>
	<hr class="noprint"><!--css-->
	<ul class="pagination noprint">
		<?php
			$query2 = mysqli_query($koneksi,$str_diagnosa);
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
						echo "<li><a href='?page=lap_P2M_penyakit&keydate1=$keydate1&keydate2=$keydate2&kodebpjs=$kodediagnosa&kasus=$_GET[kasus]&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>