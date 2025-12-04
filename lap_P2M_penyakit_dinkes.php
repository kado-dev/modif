<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>TRACKING DIAGNOSA</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_P2M_penyakit_dinkes"/>
						<div class="col-sm-2">
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
						<div class="col-sm-2">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<td class="col-sm-7">
								<input type="text" class="form-control diagnosabpjs" value="<?php echo $_GET['kodebpjs'];?>">
								<input type="hidden" name="kodebpjs" class="form-control kodebpjs" value="<?php echo $_GET['kodebpjs'];?>">
								<input type="hidden" class="form-control diagnosahiddenbpjs">
							</td>
						</div>
						<div class="col-sm-2">
							<select name="kasus" class="form-control">
								<option value="">semua</option>
								<option value="Baru" <?php if($_GET['kasus'] == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value="Lama" <?php if($_GET['kasus'] == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="kodepuskesmas" class="form-control">
								<option value='semua'>Semua</option>
								<?php
								$kota = $_SESSION['kota'];
								$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `Kota`='$kota' order by `NamaPuskesmas`");
								while($data3 = mysqli_fetch_assoc($queryp)){
									if($_GET['kodepuskesmas'] == $data3['KodePuskesmas']){
										echo "<option value='$data3[KodePuskesmas]' selected>$data3[NamaPuskesmas]</option>";
									}else{
										echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
									}
								}
								?>					
							</select>
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_penyakit_dinkes" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_P2M_penyakit_dinkes_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kodebpjs=<?php echo $_GET['kodebpjs'];?>&kasus=<?php echo $_GET['kasus'];?>&kodepuskesmas=<?php echo $_GET['kodepuskesmas'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$tahunini = date('Y');
	$kodediagnosa = $_GET['kodebpjs'];
	$kasus = $_GET['kasus'];
	$kodepuskesmas = $_GET['kodepuskesmas'];
	$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;

	if(isset($bulan) AND isset($tahun)){
	?>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr style="border:1px solid #000;">
							<th rowspan="2" width="3%"  style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tgl.Registrasi</th>
							<th rowspan="2" width="7%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.Index</th>
							<th rowspan="2" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Pasien</th>
							<th colspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kelamin</th>
							<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Alamat</th>
							<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kunj.</th>
							<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jaminan</th>
							<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Pelayanan</th>
							<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Anamnesa</th>
							<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Diagnosa</th>
							<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kasus</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$jumlah_perpage = 1000;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						// tbdiagnosapasien
						if($_GET['kasus'] != ''){
							$kasus = "AND Kasus = '$_GET[kasus]'";
							$kasus2 = "AND a.Kasus = '$_GET[kasus]'";
						}else{
							$kasus = "";
							$kasus2 = "";
						}
												
						if($kodepuskesmas == 'semua'){
							$kodepuskesmas = "";
						}else{
							$kodepuskesmas = " AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'";
						}			
						
					
						$str_diagnosa = "SELECT * FROM `$tbdiagnosapasien` 
						WHERE KodeDiagnosa = '$kodediagnosa'".$kodepuskesmas.$kasus." AND YEAR(TanggalDiagnosa) = '$tahun'";
						$str2 = $str_diagnosa." GROUP BY NoRegistrasi ORDER BY IdDiagnosa ASC LIMIT $mulai,$jumlah_perpage";
						// echo $str2;	
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query_diagnosa = mysqli_query($koneksi,$str2);
						while($data_diagnosa = mysqli_fetch_assoc($query_diagnosa)){
							$no = $no + 1;
							// $noindex = $data_diagnosa['NoIndex'];
							$noregistrasi = $data_diagnosa['NoRegistrasi'];
							$kodediagnosa = $data_diagnosa['KodeDiagnosa'];
							$kasus = $data_diagnosa['Kasus'];
						
							// tbpasienrj
							if($kodepuskesmas == ''){
								$str_rj = "SELECT * FROM `tbpasienrj` WHERE NoRegistrasi = '$noregistrasi'";
							}else{	
								$str_rj = "SELECT * FROM `$tbpasienrj` WHERE NoRegistrasi = '$noregistrasi'";
							}
							$query_rj = mysqli_query($koneksi,$str_rj);
							$data_rj = mysqli_fetch_assoc($query_rj);							
							$noreg = $data_rj['NoRegistrasi'];
							$noindex = $data_rj['NoIndex'];
							$kelamin = $data_rj['JenisKelamin'];
							$poli = $data_rj['PoliPertama'];
							
							// tbpasienrj_puskesmas
							$tbpasienrj = 'tbpasienrj_'.substr($noreg,0,11);
							$dt_rj_puskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi`='$noreg'"));
						
							// pasien
							if (strlen($data_rj['NoIndex']) == 24){
								$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `tbpasien` WHERE `NoIndex` = '$data_rj[NoIndex]'"));
							}else{
								$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex FROM `tbpasien` WHERE `NoAsuransi` = '$data_rj[NoIndex]'"));
							}
						
							// tbkk
							$dt_kk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Alamat`,`RT`,`Kelurahan` FROM `$tbkk` WHERE NoIndex = '$noindex'"));
							if($dt_kk['Alamat'] != ''){
								$alamat_kk = $dt_kk['Alamat']." RT. ".$dt_kk['RT'].", Kel.".$dt_kk['Kelurahan'];
							}else{
								$alamat_kk = "Alamat Belum di Inputkan";
							}
						
							//tbpoliumum
							if ($poli == 'POLI UMUM'){
								$poliumum = 'tbpoliumum_'.$bulan;
								$str_umum = "SELECT * FROM `$poliumum` WHERE `NoPemeriksaan` = '$noregistrasi'";
								$query_umum = (mysqli_query($koneksi,$str_umum));
								$data_umum = mysqli_fetch_assoc($query_umum);
								$anamnesa = $data_umum['Anamnesa'];
								$sistole = $data_umum['Sistole'];
								if ($anamnesa != null){$anamnesa = $data_umum['Anamnesa'];}else{$anamnesa = "-";}
								if ($sistole != null){$sistole = $data_umum['Sistole']."/".$data_umum['Diastole'];}else{$sistole = "-";}
							}else if ($poli == 'POLI UGD'){
								$str_ugd = "SELECT * FROM `tbpolitindakan` WHERE `NoPemeriksaan` = '$noregistrasi'";
								$query_ugd = (mysqli_query($koneksi,$str_ugd));
								$data_ugd = mysqli_fetch_assoc($query_ugd);
								$anamnesa = $data_ugd['Anamnesa'];
								$sistole = $data_ugd['Sistole'];
								if ($anamnesa != null){$anamnesa = $data_ugd['Anamnesa'];}else{$anamnesa = "-";}
								if ($sistole != null){$sistole = $data_ugd['Sistole']."/".$data_ugd['Diastole'];}else{$sistole = "-";}
							}else if ($poli == 'POLI LANSIA'){
								$str_lansia = "SELECT * FROM `tbpolilansia` WHERE `NoPemeriksaan` = '$noregistrasi'";
								$query_lansia = (mysqli_query($koneksi,$str_lansia));
								$data_lansia = mysqli_fetch_assoc($query_lansia);
								$anamnesa = $data_lansia['Anamnesa'];
								$sistole = $data_lansia['Sistole'];
								if ($anamnesa != null){$anamnesa = $data_lansia['Anamnesa'];}else{$anamnesa = "-";}
								if ($sistole != null){$sistole = $data_lansia['Sistole']."/".$data_lansia['Diastole'];}else{$sistole = "-";}
							}		
						
							// kelamin
							if($dt_rj_puskesmas['UmurTahun'] != '0'){
								$umur = $dt_rj_puskesmas['UmurTahun']."Th";
							}else{
								$umur = $dt_rj_puskesmas['UmurBulan']."Bl";
							}
							
							if($kelamin == 'L'){
								$kelamin_l = $umur;
								$kelamin_p = '-';
							}else{
								$kelamin_p = $umur;
								$kelamin_l = '-';
							}
						
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo date('d-m-Y', strtotime($data_diagnosa['TanggalDiagnosa']));?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo substr($noindex,-10);?></td>
								<td style="text-align:left;border:1px solid #000; padding:3px;"><?php echo $data_rj['NamaPasien'];?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $kelamin_l;?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $kelamin_p;?></td>
								<td style="text-align:left;border:1px solid #000; padding:3px;"><?php echo strtoupper($alamat_kk);?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $data_rj['StatusKunjungan'];?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $data_rj['Asuransi'];?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $data_rj['PoliPertama'];?></td>
								<td style="text-align:left;border:1px solid #000; padding:3px;"><?php echo $anamnesa;?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $kodediagnosa;?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $kasus;?></td>
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
						echo "<li><a href='?page=lap_P2M_penyakit_dinkes&bulan=$bulan&tahun=$tahun&kodebpjs=$kodediagnosa&kasus=$_GET[kasus]&kodepuskesmas=$_GET[kodepuskesmas]&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>	