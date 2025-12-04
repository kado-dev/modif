<?php
	include "otoritas.php";
	include "config/helper_report.php";
	// include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive noprint">
			<h3 class="judul"><b>ILI REGISTER</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_ili"/>
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
						<div class="col-xl-2">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="kasus" class="form-control">
								<option value="">semua</option>
								<option value="Baru" <?php if($_GET['kasus'] == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value="Lama" <?php if($_GET['kasus'] == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</select>
						</div>
						<div class="col-xl-2">
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
						<?php
						if($_SESSION['kodepuskesmas'] == '-'){
						?>
							<div class="col-xl-2">
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
							<a href="?page=lap_P2M_ili" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
							<a href="lap_P2M_ili_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kelurahan=<?php echo $_GET['kelurahan'];?>&kasus=<?php echo $_GET['kasus'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$bulanini = date('m');
	$tahun = $_GET['tahun'];
	$tahunini = date('Y');
	$kasus = $_GET['kasus'];
	$kelurahan = $_GET['kelurahan'];
	// $tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;

	if(isset($bulan) AND isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "UPT. PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b><?php echo "REGISTER ILI";?></b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></span>
		<br/>
	</div>

	<div class="atastabel noprint">
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
				<table class="table-judul-laporan" style="width: 2750px">
					<thead>
						<tr style="border:1px solid #000;">
							<th rowspan="2" width="3%">NO.</th>
							<th colspan="9" width="3%">UMUM</th>							
							<th colspan="13" width="3%">TANDA & GEJALA</th>							
							<th colspan="5" width="3%">RIWAYAT PENYAKIT & KONTAK</th>						
							<th colspan="6" width="3%">PENGAMBILAN & PENGIRIMAN SPESIMEN</th>						
						</tr>
						<tr>
							<th rowspan="2" width="5%">TGL.</th><!--Umum-->
							<th rowspan="2" width="5%">NO.INDEX</th>
							<th rowspan="2" width="5%">NIK</th>
							<th rowspan="2" width="10%">NAMA PASIEN</th>
							<th rowspan="2" width="10%">NAMA KK</th>							
							<th rowspan="2" width="5%">TGL.LAHIR</th>
							<th rowspan="2" width="3%">UMUR (TH)</th>
							<th rowspan="2" width="2%">L/P</th>
							<th rowspan="2" width="8%">ALAMAT</th>
							<th rowspan="2" width="8%">SUHU</th><!--Tanda & gejala-->
							<th rowspan="2" width="10%">LAMA DEMAM</th>
							<th rowspan="2" width="5%">MINUM OBAT<br/>DEMAM</th>
							<th rowspan="2" width="5%">BATUK</th>
							<th rowspan="2" width="5%">SAKIT<br/>TENGGOROKAN</th>
							<th rowspan="2" width="5%">FREKUENSI<br/>NAFAS</th>
							<th rowspan="2" width="5%">SESAK<br/>NAFAS</th>
							<th rowspan="2" width="5%">LAMA<br/>SESAK (HR)</th>
							<th rowspan="2" width="5%">NYERI OTOT</th>
							<th rowspan="2" width="5%">Pilik</th>
							<th rowspan="2" width="5%">ADA PENYAKIT<br/>KRONIS</th>
							<th rowspan="2" width="5%">HAMIL</th>
							<th rowspan="2" width="5%">JNS.PENYAKIT<br/>KRONIS</th>							
							<th rowspan="2" width="5%">ADA RIYATA ANGGOTA KK (DEMAM/BATUK/PILEK)</th><!--Riwayat Penyakit & Kontak-->
							<th rowspan="2" width="5%">RUMAH DEKET PETERNAKAN UNGGAS</th>
							<th rowspan="2" width="5%">VAKSINASI FLU 1<br/>TAHUN TERAKHIR</th>
							<th rowspan="2" width="5%">KONTAK DENGAN AYAM<br/>(SAKIT/MATI)</th>
							<th rowspan="2" width="5%">KONTAK DENGAN KASUS<br/>KONFIMRASI/PR<br/>OBABAEL</th>
							<th rowspan="2" width="5%">SWAB TENGGOROK</th><!--Pengambilan & Pengiriman Spesimen-->
							<th rowspan="2" width="5%">SWAB HIDUNG</th>
							<th rowspan="2" width="5%">TGL.PENGAMBILAN</th>
							<th rowspan="2" width="5%">TGL.PENGIRIMAN</th>
							<th rowspan="2" width="5%">SUHU PENGIRIMAN</th>
							<th rowspan="2" width="5%">HASIL PEMERIKSAAN<br/>RT & PCR</th>
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
						if($_GET['kasus'] != ''){
							$kasus = "AND Kasus = '$_GET[kasus]'";
							$kasus2 = "AND a.Kasus = '$_GET[kasus]'";
						}else{
							$kasus = "";
							$kasus2 = "";
						}
						
						// if($kelurahan == 'semua'){
							$str_diagnosa = "SELECT * FROM `$tbdiagnosapasien` 
							WHERE (KodeDiagnosa ='A93.8' OR KodeDiagnosa ='R50.9' OR KodeDiagnosa ='J06.9' OR KodeDiagnosa like '%J11%' OR KodeDiagnosa like '%J12%') ".$kasus." AND YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' GROUP BY IdPasienrj ";
						// }else{
						// 	$kelurahans = " AND c.Kelurahan = '$kelurahan'";
						// 	$str_diagnosa = "SELECT * FROM `$tbdiagnosapasien` a 
						// 	JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi
						// 	JOIN `$tbkk` c ON b.NoIndex = c.NoIndex
						// 	WHERE (KodeDiagnosa ='A93.8' OR KodeDiagnosa ='R50.9' OR KodeDiagnosa ='J06.9' OR KodeDiagnosa like '%J11%' OR KodeDiagnosa like '%J12%') ".$kasus2." AND YEAR(a.TanggalDiagnosa) = '$tahun'".$kelurahans." GROUP BY b.IdPasienrj ";
						// }
						
						$str2 = $str_diagnosa." ORDER BY TanggalDiagnosa LIMIT $mulai,$jumlah_perpage";
						// echo $str2;	
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query_diagnosa = mysqli_query($koneksi,$str2);
						while($dtdiagnosa = mysqli_fetch_assoc($query_diagnosa)){
							$no = $no + 1;
							$idpasienrj = $dtdiagnosa['IdPasienrj'];
							$noindex = $dtdiagnosa['NoIndex'];
							$noregistrasi = $dtdiagnosa['NoRegistrasi'];
							$kodediagnosa = $dtdiagnosa['KodeDiagnosa'];
							$kasus = $dtdiagnosa['Kasus'];
						
							// tbpasienrj 
							$data_rj = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj`='$idpasienrj'"));
													
							// tbpasien
							$dtpasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoIndex`,`Nik`,`TanggalLahir` FROM `$tbpasien` WHERE `NoIndex`='$noindex'"));
						
							// tbkk
							$dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaKK`,`Alamat`,`RT`,`Kelurahan` FROM `$tbkk` WHERE `NoIndex`='$noindex'"));
							if($dtkk['Alamat'] != ''){
								$alamat_kk = $dtkk['Alamat']." RT. ".$dtkk['RT'].", Kel.".$dtkk['Kelurahan'];
							}else{
								$alamat_kk = "Alamat Belum di Inputkan";
							}
						
							// tbpoliumum
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

							// vital sign
							$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idpasienrj'";
							$dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
							$dtsuhutubuh = $dtvs['SuhuTubuh'];
						
							// kelamin
							if($kelamin == 'L'){
								$kelamin_l = $data_rj['UmurTahun']."Th, ".$data_rj['UmurBulan']."Bl";
								$kelamin_p = '-';
							}else{
								$kelamin_p = $data_rj['UmurTahun']."Th, ".$data_rj['UmurBulan']."Bl";
								$kelamin_l = '-';
							}
						
						?>
							<tr style="border:1px solid #000;">
								<td align="center"><?php echo $no;?></td>
								<td><?php echo date('d-m-Y', strtotime($dtdiagnosa['TanggalDiagnosa']));?></td>
								<td><?php echo substr($data_rj['NoIndex'],-10);?></td>
								<td><?php echo $dtpasien['Nik'];?></td>
								<td><?php echo strtoupper($data_rj['NamaPasien']);?></td>
								<td><?php echo strtoupper($dtkk['NamaKK']);?></td>
								<td><?php echo date('d-m-Y', strtotime($dtpasien['TanggalLahir']));?></td>
								<td><?php echo $data_rj['UmurTahun'];?></td>
								<td><?php echo $data_rj['JenisKelamin'];?></td>
								<td><?php echo strtoupper($alamat_kk);?></td>
								<td align="center"><?php echo $dtsuhutubuh;?></td><!--Tanda & gejala-->
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td><!--Riwayat Penyakit & Kontak-->
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td><!--Pengambilan & Pengiriman Spesimen-->
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
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
				<a href="lap_P2M_ili_export.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kdpkm=<?php echo $kodepuskesmas;?>" class="btn btn-sm btn-info">Export > Diare</a>
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
						echo "<li><a href='?page=lap_P2M_ili&bulan=$bulan&tahun=$tahun&kasus=$_GET[kasus]&kelurahan=$_GET[kelurahan]&h=$i'>$i</a></li>";
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
				<p>Kategori Kode Penyakit :</b> A93.8, R50.9, J06.9, J11, J12</p>
			</div>
		</div>
	</div>
</div>	
