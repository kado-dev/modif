<?php
	// include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>TRACKING DIAGNOSA</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_P2M_penyakit"/>
						<div class="col-sm-1">
							<select name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsiform'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tahun" <?php if($_GET['opsiform'] == 'tahun'){echo "SELECTED";}?>>Tahun</option>
							</select>	
						</div>
						<div class="col-sm-2 bulanformcari">
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
						<div class="col-sm-1 tahunformcari">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<td class="col-sm-7">
								<input type="text" class="form-control diagnosabpjs" value="<?php echo $_GET['kodebpjs'];?>">
								<input type="hidden" name="kodebpjs" class="form-control kodebpjs">
								<input type="hidden" class="form-control diagnosahiddenbpjs">
							</td>
						</div>
						<div class="col-sm-1">
							<select name="kasus" class="form-control">
								<option value="semua">semua</option>
								<option value="Baru" <?php if($_GET['kasus'] == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value="Lama" <?php if($_GET['kasus'] == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</select>
						</div>
						<div class="col-sm-2">
							<select type="text" name="kelurahan" class="form-control cari">
								<option value='semua'>Semua</option>
								<?php
								$qkel = mysqli_query($koneksi,"SELECT * FROM `tbkelurahan` WHERE (`KodePuskesmas`='$kodepuskesmas' OR `KodePuskesmas`='*')  ORDER BY `Kelurahan`");
								while($dtkel = mysqli_fetch_assoc($qkel)){
									if($dtkel['Kelurahan'] == $_GET['kelurahan']){
									echo "<option value='$dtkel[Kelurahan]' SELECTED>$dtkel[Kelurahan]</option>";
									}else{
									echo "<option value='$dtkel[Kelurahan]'>$dtkel[Kelurahan]</option>";
									}
								}
								?>
							</select>
						</div>
						<div class="col-sm-1">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<!--<a href="?page=lap_P2M_penyakit" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>-->
							<!--<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>-->
							<a href="lap_P2M_penyakit_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kodebpjs=<?php echo $_GET['kodebpjs'];?>&kasus=<?php echo $_GET['kasus'];?>&kelurahan=<?php echo $_GET['kelurahan'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>

	<?php
	$opsiform = $_GET['opsiform'];
	$bulan = $_GET['bulan'];
	$bulanini = date('m');
	$tahun = $_GET['tahun'];
	$tahunini = date('Y');
	$kodediagnosa = $_GET['kodebpjs'];
	$kasus = $_GET['kasus'];
	$kelurahan = $_GET['kelurahan'];
	$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);

	if(isset($bulan) AND isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "UPT. PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b><?php echo "REGISTER TRACKING DIAGNOSA (".$kodediagnosa.")";?></b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan:
			<?php 
			if($opsiform == 'tanggal'){
				echo date('d-m-Y', strtotime($keydate1)) ." s/d ".date('d-m-Y', strtotime($keydate2));
			}else{
				echo nama_bulan($bulan)." ".$tahun;
			}
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
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr style="border:1px solid #000;">
							<th rowspan="2"width="3%"  style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
							<th rowspan="2" width="7%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">TGL.</th>
							<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NIK</th>
							<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.BPJS</th>
							<th rowspan="2" width="7%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.INDEX</th>
							<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NAMA PASIEN</th>
							<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">TGL.LAHIR</th>
							<th colspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">UMUR</th>
							<th rowspan="2" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">ALAMAT</th>
							<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">KUNJ</th>
							<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">JAMINAN</th>
							<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">LAYANAN</th>
							<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">ANAMNESA</th>
							<th colspan="4" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">VITAL SIGN</th>
							<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">DIAGNOSA</th>
							<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">KASUS</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">TD</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">BB/TB</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">SUHU</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">HR/RR</th>
						</tr>
					</thead>
					<tbody>
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
												
						if($opsiform == 'bulan'){
							if($kelurahan == 'semua'){
								$str_diagnosa = "SELECT * FROM `$tbdiagnosapasien`
								WHERE KodeDiagnosa like '%$kodediagnosa%' ".$kasus." AND YEAR(TanggalDiagnosa) = '$tahun'";
							}else{
								$kelurahans = " AND c.Kelurahan = '$kelurahan'";
								$str_diagnosa = "SELECT * FROM `$tbdiagnosapasien` a 
								JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi
								JOIN `$tbkk` c ON b.NoIndex = c.NoIndex
								WHERE a.KodeDiagnosa like '%$kodediagnosa%' ".$kasus." AND YEAR(a.TanggalDiagnosa) = '$tahun'".$kelurahans;
							}
						}else{	
							if($kelurahan == 'semua'){
								$str_diagnosa = "SELECT * FROM `$tbdiagnosapasien` WHERE KodeDiagnosa like '%$kodediagnosa%' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' ".$kasus." AND YEAR(TanggalDiagnosa) = '$tahun'";
							}else{
								$kelurahans = " AND b.Kelurahan = '$kelurahan'";
								$str_diagnosa = "SELECT * FROM `$tbdiagnosapasien` LEFT JOIN `$tbkk` b ON a.NoIndex = b.NoIndex
								WHERE a.KodeDiagnosa like '%$kodediagnosa%' AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' ".$kasus." AND YEAR(a.TanggalDiagnosa) = '$tahun'".$kelurahans;
							}
						}
						$str2 = $str_diagnosa." order by TanggalDiagnosa limit $mulai,$jumlah_perpage";
						// echo $str2;	
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query_diagnosa = mysqli_query($koneksi,$str2);
						while($data_diagnosa = mysqli_fetch_assoc($query_diagnosa)){
							$no = $no + 1;
							$noregistrasi = $data_diagnosa['NoRegistrasi'];
							$kodediagnosa = $data_diagnosa['KodeDiagnosa'];
							$kasus = $data_diagnosa['Kasus'];
						
							// tbpasienrj 
							$str_rj = "SELECT * FROM `$tbpasienrj` WHERE NoRegistrasi = '$noregistrasi'";
							$query_rj = mysqli_query($koneksi,$str_rj);
							$data_rj = mysqli_fetch_assoc($query_rj);
							$noindex = $data_rj['NoIndex'];
							$kelamin = $data_rj['JenisKelamin'];
							$poli = $data_rj['PoliPertama'];
							$nokartu = $data_rj['nokartu'];
						
							// tbpasien
							if (strlen($data_rj['NoIndex']) == 24){
								$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Nik,NoIndex,TanggalLahir FROM `$tbpasien` WHERE `NoIndex`='$data_rj[NoIndex]'"));
							}else{
								$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Nik,NoIndex,TanggalLahir FROM `$tbpasien` WHERE `NoAsuransi`='$data_rj[NoIndex]'"));
							}
						
							// tbkk
							$dt_kk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Alamat`,`RT`,`RW`,`Kelurahan` FROM `$tbkk` WHERE NoIndex = '$noindex'"));
							if($dt_kk['Alamat'] != ''){
								$alamat_kk = $dt_kk['Alamat']." RT. ".$dt_kk['RT']." RW. ".$dt_kk['RW'].", Kel.".$dt_kk['Kelurahan'];
							}else{
								$alamat_kk = "Alamat Belum di Inputkan";
							}
						
							//tbpoliumum
							if ($poli == 'POLI UMUM'){
								$poliumum = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
								$str_umum = "SELECT * FROM `$poliumum` WHERE `NoPemeriksaan` = '$noregistrasi'";
								$query_umum = (mysqli_query($koneksi,$str_umum));
								$data_umum = mysqli_fetch_assoc($query_umum);
								$anamnesa = $data_umum['Anamnesa'];
								$sistole = $data_umum['Sistole'];
								$bbtb = $data_umum['BeratBadan']."/".$data_umum['TinggiBadan'];
								$suhu = $data_umum['SuhuTubuh'];
								$hrrr = $data_umum['DetakNadi']."/".$data_umum['RR'];
								if ($anamnesa != null){$anamnesa = $data_umum['Anamnesa'];}else{$anamnesa = "-";}
								if ($sistole != null){$sistole = $data_umum['Sistole']."/".$data_umum['Diastole'];}else{$sistole = "-";}
								if ($suhu != null){$suhu = $data_umum['SuhuTubuh'];}else{$suhu = "-";}
								if ($hrrr != null){$hrrr = $data_umum['DetakNadi']."/".$data_umum['RR'];}else{$hrrr = "-";}
							}else if ($poli == 'POLI GIZI'){
								$str_gizi= "SELECT * FROM `tbpoligizi` WHERE `NoPemeriksaan` = '$noregistrasi'";
								$query_gizi = (mysqli_query($koneksi,$str_gizi));
								$data_gizi = mysqli_fetch_assoc($query_gizi);
								$anamnesa = $data_gizi['Anamnesa'];
								$sistole = $data_gizi['Sistole'];
								$bbtb = $data_gizi['BeratBadan']."/".$data_gizi['TinggiBadan'];
								$suhu = $data_gizi['SuhuTubuh'];
								$hrrr = $data_gizi['DetakNadi']."/".$data_gizi['RR'];
								if ($anamnesa != null){$anamnesa = $data_gizi['Anamnesa'];}else{$anamnesa = "-";}
								if ($sistole != null){$sistole = $data_gizi['Sistole']."/".$data_gizi['Diastole'];}else{$sistole = "-";}
								if ($suhu != null){$suhu = $data_gizi['SuhuTubuh'];}else{$suhu = "-";}
								if ($hrrr != null){$hrrr = $data_gizi['DetakNadi']."/".$data_gizi['RR'];}else{$hrrr = "-";}
							}else if ($poli == 'POLI LANSIA'){
								$str_lansia = "SELECT * FROM `tbpolilansia` WHERE `NoPemeriksaan` = '$noregistrasi'";
								$query_lansia = (mysqli_query($koneksi,$str_lansia));
								$data_lansia = mysqli_fetch_assoc($query_lansia);
								$anamnesa = $data_lansia['Anamnesa'];
								$sistole = $data_lansia['Sistole'];
								$bbtb = $data_umum['BeratBadan']."/".$data_umum['TinggiBadan'];
								$suhu = $data_lansia['SuhuTubuh'];
								$hrrr = $data_lansia['DetakNadi']."/".$data_lansia['RR'];
								if ($anamnesa != null){$anamnesa = $data_lansia['Anamnesa'];}else{$anamnesa = "-";}
								if ($sistole != null){$sistole = $data_lansia['Sistole']."/".$data_lansia['Diastole'];}else{$sistole = "-";}
								if ($suhu != null){$suhu = $data_lansia['SuhuTubuh'];}else{$suhu = "-";}
								if ($hrrr != null){$hrrr = $data_lansia['DetakNadi']."/".$data_lansia['RR'];}else{$hrrr = "-";}
							}else if ($poli == 'POLI MTBS'){
								$str_mtbs = "SELECT * FROM `tbpolimtbs` WHERE `NoPemeriksaan` = '$noregistrasi'";
								$query_mtbs = (mysqli_query($koneksi,$str_mtbs));
								$data_mtbs = mysqli_fetch_assoc($query_mtbs);
								$anamnesa = $data_mtbs['Anamnesa'];
								$sistole = $data_mtbs['Sistole'];
								$bbtb = $data_umum['BeratBadan']."/".$data_umum['TinggiBadan'];
								$suhu = $data_mtbs['SuhuTubuh'];
								$hrrr = $data_mtbs['DetakNadi']."/".$data_mtbs['RR'];
								if ($anamnesa != null){$anamnesa = $data_mtbs['Anamnesa'];}else{$anamnesa = "-";}
								if ($sistole != null){$sistole = $data_mtbs['Sistole']."/".$data_mtbs['Diastole'];}else{$sistole = "-";}
								if ($suhu != null){$suhu = $data_mtbs['SuhuTubuh'];}else{$suhu = "-";}
								if ($hrrr != null){$hrrr = $data_mtbs['DetakNadi']."/".$data_mtbs['RR'];}else{$hrrr = "-";}
							}else if ($poli == 'POLI UGD'){
								$str_ugd = "SELECT * FROM `tbpolitindakan` WHERE `NoPemeriksaan` = '$noregistrasi'";
								$query_ugd = (mysqli_query($koneksi,$str_ugd));
								$data_ugd = mysqli_fetch_assoc($query_ugd);
								$anamnesa = $data_ugd['Anamnesa'];
								$sistole = $data_ugd['Sistole'];
								$bbtb = $data_umum['BeratBadan']."/".$data_umum['TinggiBadan'];
								$suhu = $data_ugd['SuhuTubuh'];
								$hrrr = $data_ugd['DetakNadi']."/".$data_ugd['RR'];
								if ($anamnesa != null){$anamnesa = $data_ugd['Anamnesa'];}else{$anamnesa = "-";}
								if ($sistole != null){$sistole = $data_ugd['Sistole']."/".$data_ugd['Diastole'];}else{$sistole = "-";}
								if ($suhu != null){$suhu = $data_ugd['SuhuTubuh'];}else{$suhu = "-";}
								if ($hrrr != null){$hrrr = $data_ugd['DetakNadi']."/".$data_ugd['RR'];}else{$hrrr = "-";}
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
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $dt_pasien['Nik'];?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $nokartu;?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo substr($noindex,-10);?></td>
								<td style="text-align:left;border:1px solid #000; padding:3px;"><?php echo $data_rj['NamaPasien'];?></td>
								<td style="text-align:left;border:1px solid #000; padding:3px;"><?php echo $dt_pasien['TanggalLahir'];?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $kelamin_l;?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $kelamin_p;?></td>
								<td style="text-align:left;border:1px solid #000; padding:3px;"><?php echo strtoupper($alamat_kk);?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo strtoupper($data_rj['StatusKunjungan']);?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $data_rj['Asuransi'];?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $data_rj['PoliPertama'];?></td>
								<td style="text-align:left;border:1px solid #000; padding:3px;"><?php echo $anamnesa;?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $sistole;?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $bbtb;?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $suhu;?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $hrrr;?></td>
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
						echo "<li><a href='?page=lap_P2M_penyakit&opsiform=$opsiform&bulan=$bulan&tahun=$tahun&kodebpjs=$kodediagnosa&kasus=$_GET[kasus]&kelurahan=$_GET[kelurahan]&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>
<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
$('.opsiform').change(function(){
	if($(this).val() == 'bulan'){
		$(".bulanformcari").show();
	}else if($(this).val() == 'tahun'){	
		$(".bulanformcari").hide();
		$(".tahunformcari").show();	
	}else{	
		$(".bulanformcari").hide();
	}
});	
$(document).ready(function(){
	if($('.opsiform').val() == 'bulan'){
		$(".bulanformcari").show();
	}else{	
		$(".bulanformcari").hide();
	}
});	
</script>