<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>PTM REGISTER</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_ptm"/>
						<div class="col-xl-2">
							<select name="bulan" class="form-control">
								<option value="01" <?php if($_GET['bulan'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulan'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulan'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulan'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulan'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulan'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulan'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulan'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulan'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulan'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulan'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulan'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-xl-2" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<?php
						if($_SESSION['kodepuskesmas'] == '-'){
						?>
							<div class="col-xl-3">
								<select name="kodepuskesmas" class="form-control">
								<option value='semua'>Semua</option>
								<?php
								$kota = $_SESSION['kota'];
								$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `Kota`='$kota' order by `NamaPuskesmas`");
								while($data3 = mysqli_fetch_assoc($queryp)){
									echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
								}
								?>
								</select>
							</div>
						<?php
						}
						?>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_ptm" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_P2M_ptm_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $kodepuskesmas;?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>	
			</div>	
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kodediagnosa = $_GET['kodebpjs'];
	$kasus = $_GET['kasus'];
	$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
	if(isset($bulan) AND isset($tahun)){
	?>
	
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive printini">
				<table class="table-judul-laporan-min" style="width:2500px">
					<thead>
						<tr style="border:1px solid #000;">
							<th width="2%" rowspan="2">NO.</th>
							<th rowspan="2">TGL.PERIKSA</th>
							<th colspan="11">IDENTITAS</th>
							<th width="20%" colspan="4">WAWANCARA</th>
							<th width="8%" colspan="2">IMT</th>
							<th width="4%" rowspan="2">LINGKAR PERUT</th>
							<th width="4%" colspan="2">TD</th>
							<th colspan="2">GULA DARAH</th>
							<th colspan="2">KOLESTEROL</th>
							<th rowspan="2">LDL</th>
							<th rowspan="2">HDL</th>
							<th rowspan="2">ARUS PUNCAK EKSPIRASI (APE)</th>
							<th rowspan="2">KADAR ALKOHOL PERNAFASAN</th>
							<th rowspan="2">TES AMFETAMIN URIN</th>
							<th rowspan="2">BENJOLAN ABNORMAL PAYUDARA</th>
							<th rowspan="2">PAP SMEAR</th>
							<th rowspan="2">HASIL PERIKSA IVA</th>
							<th rowspan="2">KRIOTERAPI</th>
							<th width="10%" rowspan="2">DIAGNOSA</th>
							<th width="4%" colspan="4">PEMERIKSAAN PENUNJANG</th>
							<th width="4%" rowspan="2">DIRUJUK</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th width="4%" rowspan="2">NO.INDEX</th>
							<th width="5%" rowspan="2">NO.KTP</th>
							<th width="8%" rowspan="2">NAMA PASIEN</th>
							<th width="2%" rowspan="2">L/P</th>
							<th width="4%" rowspan="2">TGL.LAHIR</th>
							<th width="4%" rowspan="2">UMUR</th>
							<th width="25%" rowspan="2">ALAMAT-TELP</th>
							<th width="2%" rowspan="2">GOL.DRH</th>
							<th width="4%" rowspan="2">STATUS</th>
							<th width="1%" rowspan="2">SUKU</th>
							<th width="4%" rowspan="2">PEKERJAAN</th>
							<th>MEROKOK</th>
							<th>KURANG AKTIVITAS FISIK</th>
							<th>KURANG MAKAN SAYUR</th>
							<th>KONSUMSI ALKOHOL</th>
							<th width="2%">TB</th>
							<th width="2%">BB</th>
							<th width="2%">SISTOL</th>
							<th width="2%">DIASTOL</th>
							<th>SEWAKTU</th>
							<th>PUASA</th>
							<th>KOLESTEROL TOTAL</th>
							<th>TRIGLISERIDA</th>
							<th>EKG</th>
							<th>RADIOLOGI</th>
							<th>DARAH LENGKAP</th>
							<th>URIN RUTIN & MIKROSKOPIK</th>
						</tr>
					</thead>
					<tbody style="font-size:10px;">
						<?php
						$jumlah_perpage = 20;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						// tbdiagnosadiare
						$str_diagnosa = "SELECT * FROM `tbdiagnosaptm` WHERE MONTH(TanggalRegistrasi) = '$bulan' 
						AND YEAR(TanggalRegistrasi) = '$tahun' AND substring(NoRegistrasi,1,11) = '$kodepuskesmas'";
						$str2 = $str_diagnosa."order by `TanggalRegistrasi` limit $mulai,$jumlah_perpage";
						// echo $str2;	
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query_diagnosa = mysqli_query($koneksi, $str2);
						while($data_diagnosa = mysqli_fetch_assoc($query_diagnosa)){
							$no = $no + 1;
							$noregistrasi = $data_diagnosa['NoRegistrasi'];
							$tglregistrasi = $data_diagnosa['TanggalRegistrasi'];
							$tinggibadan = $data_diagnosa['TB'];
							$beratbadan = $data_diagnosa['BB'];
							$lingkarperut = $data_diagnosa['LingkarPerut'];
							$sistole = $data_diagnosa['Sistole'];
							$diastole = $data_diagnosa['Diastole'];	
																
							// tbpasienrj
							$str_rj = "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'";
							$query_rj = mysqli_query($koneksi,$str_rj);
							$data_rj = mysqli_fetch_assoc($query_rj);
							$idpasienrj = $data_rj['IdPasienrj'];
							$idpasien = $data_rj['IdPasien'];
							$noindex = $data_rj['NoIndex'];
							$nocm = $data_rj['NoCM'];
							$poli = $data_rj['PoliPertama'];
							
							if(strlen($noindex) == 24){
								$noindex2 = substr($data_rj['NoIndex'],14);
							}else{
								$noindex2 = $data_rj['NoIndex'];
							}
							
							// tbkk
							$str_kk = "SELECT * FROM `$tbkk` WHERE NoIndex = '$noindex'";
							$query_kk = mysqli_query($koneksi,$str_kk);
							$datakk = mysqli_fetch_assoc($query_kk);

							// ec_subdistricts
							$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$datakk[Kelurahan]'"));
							if($dt_subdis['subdis_name'] != ''){
								$desa = $dt_subdis['subdis_name'];
							}else{
								$desa = $datakk['kelurahan'];	
							}

							// ec_districts
							$dt_districts = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `dis_name` FROM `ec_districts` WHERE `dis_name`='$datakk[Kecamatan]'"));
							if($dt_districts['dis_name'] != ''){
								$kecamatan = $dt_districts['dis_name'];
							}else{
								$kecamatan = $datakk['Kecamatan'];	
							}

							// ec_cities
							$dt_citi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `city_name` FROM `ec_cities` WHERE `city_id`='$datakk[Kota]'"));
							if($dt_citi['city_name'] != ''){
								$kota = $dt_citi['city_name'];
							}else{
								$kota = $datakk['Kota'];	
							}

							$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
							strtoupper($desa).", ".strtoupper($kecamatan).", ".strtoupper($kota);
							
							// tbpasien
							$data_pasien = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasien` WHERE `IdPasien` = '$idpasien'"));
							if($data_pasien['StatusKeluarga'] == "KEPALA KELUARGA") {
								$statusklg = "KK";
							}else{
								$statusklg = $data_pasien['StatusKeluarga'];
							}

							// tbdiagnosapasien							
							$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
							$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
							while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
								$array_data[$no][] = $data_diagnosapsn['KodeDiagnosa'];
							}
							if ($array_data[$no] != ''){
								$data_dgs = implode(", ", $array_data[$no]);
							}else{
								$data_dgs ="";
							}

							// vital sign
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

							if($dtsistole != ''){
								$dtsistole = $dtsistole;
								$dtdiastole = $dtdiastole;
								$dttinggiBadan = $dttinggiBadan;
								$dtberatBadan = $dtberatBadan;
								$dtLingkarPerut = $dtLingkarPerut;
							}else{
								if ($data_rj['PoliPertama'] == 'POLI UMUM'){
									$tbpoli = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
								}elseif($data_rj['PoliPertama'] == 'POLI ANAK'){
									$data_rj = 'tbpolianak';
								}elseif($data_rj['PoliPertama'] == 'POLI GIGI'){
									$tbpoli = 'tbpoligigi';
								}elseif($data_rj['PoliPertama'] == 'POLI GIZI'){
									$tbpoli = 'tbpoligizi';
								}elseif($data_rj['PoliPertama'] == 'POLI BERSALIN'){
									$tbpoli = 'tbpolibersalin';
								}elseif($data_rj['PoliPertama'] == 'POLI ISOLASI'){
									$tbpoli = 'tbpoliisolasi';	
								}elseif($data_rj['PoliPertama'] == 'POLI KB'){
									$tbpoli = 'tbpolikb';
								}elseif($data_rj['PoliPertama'] == 'POLI KIA'){
									$tbpoli = 'tbpolikia';
								}elseif($data_rj['PoliPertama'] == 'POLI LANSIA'){
									$tbpoli = 'tbpolilansia';
								}elseif($data_rj['PoliPertama'] == 'POLI MTBM'){
									$tbpoli = 'tbpolimtbm';
								}elseif($data_rj['PoliPertama'] == 'POLI MTBS'){
									$tbpoli = 'tbpolimtbs';
								}elseif($data_rj['PoliPertama'] == 'POLI PANDU PTM'){
									$tbpoli = 'tbpolipanduptm';	
								}elseif($data_rj['PoliPertama'] == 'POLI INFEKSIUS'){
									$tbpoli = 'tbpoliinfeksius';	
								}elseif($data_rj['PoliPertama'] == 'POLI SCREENING'){
									$tbpoli = 'tbpoliscreening';	
								}elseif($data_rj['PoliPertama'] == 'POLI SKD'){
									$tbpoli = 'tbpoliskd';
								}elseif($data_rj['PoliPertama'] == 'POLI TB DOTS'){
									$tbpoli = 'tbpolitb';
								}elseif($data_rj['PoliPertama'] == 'POLI UGD' || $data_rj['PoliPertama'] == 'POLI TINDAKAN'){
									$tbpoli = 'tbpolitindakan';
								}elseif($data_rj['PoliPertama'] == 'NURSING CENTER'){
									$tbpoli = 'tbpolinursingcenter';
								}

								// poli
								$poli = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpoli` WHERE `NoPemeriksaan` = '$noregistrasi' AND `NoCM`='$nocm'"));
								$dtsistole = $poli['Sistole'];
								$dtdiastole = $poli['Diastole'];
								$dttinggiBadan = $poli['TinggiBadan'];
								$dtberatBadan = $poli['BeratBadan'];
								$dtLingkarPerut = $poli['LingkarPerut'];
							}
						?>
							<tr style="border:1px solid #000;">
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo date('d-m-Y', strtotime($data_diagnosa['TanggalRegistrasi']));?></td>
								<td align="center"><?php echo $noindex2;?></td>
								<td align="center"><?php echo $data_pasien['Nik'];?></td><!--noktp-->
								<td align="left"><?php echo $data_rj['NamaPasien'];?></td>
								<td align="center"><?php echo $data_rj['JenisKelamin'];?></td>
								<td align="center"><?php echo $data_pasien['TanggalLahir'];?></td>
								<td><?php echo $data_rj['UmurTahun']." Th, ".$data_rj['UmurBulan']." Bl";?></td>
								<td><?php echo $alamat;?></td>
								<td><?php if ($data_diagnosa['Darah'] == ''){echo '-';}else{echo $data_diagnosa['Darah'];}?></td><!--gol darah-->
								<td align="center"><?php echo $statusklg;?></td><!--status-->
								<td><?php echo '-'?></td><!--suku-->
								<td><?php echo $data_pasien['Pekerjaan'];?></td><!--pekerjaan-->
								<td><?php if ($data_diagnosa['Merokok'] == 'Y'){echo "YA";}else{echo "TD";}?></td>
								<td><?php if ($data_diagnosa['AktifitasFisik'] == 'Y'){echo "YA";}else{echo "TD";}?></td>
								<td><?php if ($data_diagnosa['KuranMakanSayur'] == 'Y'){echo "YA";}else{echo "TD";}?></td>
								<td><?php if ($data_diagnosa['KonsumsiAlkohol'] == 'Y'){echo "YA";}else{echo "TD";}?></td>
								<td align="center"><?php echo $dttinggiBadan;?></td><!--tinggi badan-->
								<td align="center"><?php echo $dtberatBadan;?></td><!--berat badan-->
								<td align="center"><?php echo $dtLingkarPerut;?></td><!--lingkar perut-->
								<td align="center"><?php echo $dtsistole;?></td><!--sistol-->
								<td align="center"><?php echo $dtdiastole;?></td><!--diastol-->
								<td><?php echo ''?></td><!--gula darah sewaktu-->
								<td><?php echo ''?></td><!--gula darah puasa-->
								<td><?php echo ''?></td><!--kolestrol total-->
								<td><?php echo ''?></td><!--trigliserida-->
								<td><?php echo ''?></td><!--ldl-->
								<td><?php echo ''?></td><!--hdl-->
								<td><?php echo ''?></td><!--ape-->
								<td><?php echo ''?></td><!--kadar alkohol-->
								<td><?php echo ''?></td><!--urin-->
								<td><?php echo ''?></td><!--benjolan-->
								<td><?php echo ''?></td><!--pap smear-->
								<td><?php echo ''?></td><!--iva-->
								<td><?php echo ''?></td><!--krioterapi-->
								<td><?php echo $data_dgs;?></td><!--diagnosa-->
								<td><?php echo ''?></td><!--ekg-->
								<td><?php echo ''?></td><!--radiologi-->
								<td><?php echo ''?></td><!--darah lengkap-->
								<td><?php echo ''?></td><!--urin rutin-->
								<td><?php echo ''?></td><!--dirujuk-->
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
						echo "<li><a href='?page=lap_P2M_ptm&bulan=$bulan&tahun=$tahun&kodebpjs=$kodediagnosa&kasus=$kasus&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>