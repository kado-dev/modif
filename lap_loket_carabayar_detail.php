<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
	$tbgudangpkmstok = "tbgudangpkmstok_".str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>CARA BAYAR DETAIL</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_carabayar_detail"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal">
						</div>
						<div class="col-xl-2">
							<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir">
						</div>
						<div class="col-xl-2">
							<SELECT name="asuransi" class="form-control asuransi" required>
								<option value='semua' <?php if($_GET['asuransi'] == 'semua'){echo "SELECTED";}?>>SEMUA</option>
								<option value='semuabpjs' <?php if($_GET['asuransi'] == 'semuabpjs'){echo "SELECTED";}?>>SEMUA BPJS</option>
								<?php
								$query = mysqli_query($koneksi,"SELECT * FROM `tbasuransi` order by `Asuransi` ASC");
								while($data = mysqli_fetch_assoc($query)){
									if($_GET['asuransi'] == $data['Asuransi']){
									echo "<option value='$data[Asuransi]' SELECTED>$data[Asuransi]</option>";
									}else{
									echo "<option value='$data[Asuransi]'>$data[Asuransi]</option>";
									}
								}
								?>
							</SELECT>
						</div>
						<div class="col-xl-6">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_carabayar_detail" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_loket_carabayar_detail_excel.php?keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&asuransi=<?php echo $_GET['asuransi'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>	
			</div>	
		</div>
	</div>

	<?php
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$asuransi = $_GET['asuransi'];
	if(isset($keydate1) and isset($keydate2)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN CARA BAYAR (DETAIL)</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
		<br/>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th rowspan="2" width="3%">No.</th>
							<th rowspan="2" width="7%">Tanggal</th>
							<th rowspan="2" width="15%">Nama Pasien</th>
							<th rowspan="2" width="3%">L/P</th>
							<th rowspan="2" width="7%">Tgl.Lahir</th>
							<th rowspan="2" width="5%">Umur (Th)</th>
							<th rowspan="2" width="15%">Alamat</th>
							<th rowspan="2" width="5%">Pelayanan</th>
							<th rowspan="2" width="10%">Cara Bayar</th>
							<th rowspan="2" width="5%">Kunj.</th>
							<th rowspan="2" width="10%">Diagnosa</th>
							<th rowspan="2" width="15%">Therapy</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$jumlah_perpage = 100;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						if($asuransi == 'semua'){
							$asr = "";
						}elseif($asuransi == 'semuabpjs'){
							$asr = " AND `Asuransi` like '%BPJS%'";
						}else{
							$asr = " AND `Asuransi`='$asuransi'";
						}
						
						$waktu = " date(TanggalRegistrasi) BETWEEN '$keydate1' AND '$keydate2'";
						$str = "SELECT * FROM `$tbpasienrj` WHERE ".$waktu.$asr;
						$str2 = $str." GROUP BY NoRegistrasi ORDER BY `TanggalRegistrasi`ASC LIMIT $mulai,$jumlah_perpage";
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query = mysqli_query($koneksi, $str2);
						while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$noindex = $data['NoIndex'];
						$idpasien = $data['IdPasien'];
						$idpasienrj = $data['IdPasienrj'];
						$nocm = $data['NoCM'];
						$nik = $data['Nik'];
												
						// tbkk
						$strkk = "SELECT Alamat, RT, RW, Kelurahan FROM `$tbkk` WHERE NoIndex = '$noindex'";
						$querykk = mysqli_query($koneksi,$strkk);
						$datakk = mysqli_fetch_assoc($querykk);

						// ec_subdistricts
						$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$datakk[Kelurahan]'"));
						if($dt_subdis['subdis_name'] != ''){
							$kelurahan = $dt_subdis['subdis_name'];
						}else{
							$kelurahan = $datakk['Kelurahan'];
						}

						// ec_districts
						$dt_dis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `dis_name` FROM `ec_districts` WHERE `dis_id`='$datakk[Kecamatan]'"));
						if($dt_dis['dis_name'] != ''){
							$kecamatan = $dt_dis['dis_name'];
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

						if($datakk['Alamat'] != ''){
							$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
							strtoupper($kelurahan).", ".strtoupper($kecamatan).", ".strtoupper($kota);
						}else{
							$alamat = "Tidak ditemukan";
						}

						// tbpasien
						$strps = "SELECT `TanggalLahir`,`NoAsuransi` FROM `$tbpasien` WHERE `IdPasien` = '$idpasien'";
						$queryps = mysqli_query($koneksi, $strps);
						$dataps = mysqli_fetch_assoc($queryps);
						$nokartu = $dataps['NoAsuransi'];

						if($data['Asuransi'] == 'PKG PEMDA'){
							$nokartu = '0';
						}else{
							$nokartu = $nokartu;
						}

						 // diagnosa
						$str_diagnosa = "SELECT * FROM `$tbdiagnosapasien` WHERE `IdPasienrj`='$idpasienrj'";
						$query_diagnosa = mysqli_query($koneksi, $str_diagnosa);
						while($dt_diagnosa = mysqli_fetch_array($query_diagnosa)){
							$dtdiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `KodeDiagnosa`,`Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$dt_diagnosa[KodeDiagnosa]'"));
							$array_diagnosa[$no][] = $dtdiagnosa['KodeDiagnosa']." - ".$dtdiagnosa['Diagnosa'];
						}
						if ($array_diagnosa[$no] != ''){
							$diagnosaps = implode("<br/>", $array_diagnosa[$no]);
						}else{
							$diagnosaps = "-";
						}

						// therapy
						$str_therapy = "SELECT * FROM `$tbresepdetail` WHERE `IdPasienrj`='$idpasienrj'";
						$query_therapy = mysqli_query($koneksi, $str_therapy);
						while($dt_therapy = mysqli_fetch_array($query_therapy)){
							$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang` FROM `$tbapotikstok` WHERE `KodeBarang` = '$dt_therapy[KodeBarang]'"));
							$array_therapy[$no][] = $dtobat['NamaBarang'].", JML:".$dt_therapy['jumlahobat'].", (".$dt_therapy['AnjuranResep'].")";
						}
						if ($array_therapy[$no] != ''){
							$terapi = implode("<br/>", $array_therapy[$no]);
						}else{
							$terapi = "-";
						}
						
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo date('d-m-Y', strtotime($data['TanggalRegistrasi']));?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;">
									<?php 
										echo strtoupper($data['NamaPasien'])."<br/>".
										substr($noindex,-10)."<br/>".
										$nik;
									?>
								</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['JenisKelamin'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo date('d-m-Y', strtotime($dataps['TanggalLahir']));?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['UmurTahun'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($alamat);?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['PoliPertama'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;">
									<?php 
										echo $data['Asuransi']."<br/>".
										$nokartu;
									?>
								</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo strtoupper($data['StatusKunjungan']);?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $diagnosaps;?></td>		
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $terapi;?></td>		
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
			$query2 = mysqli_query($koneksi,$str);
			$jumlah_query = mysqli_num_rows($query2);
			
			if(($jumlah_query % $jumlah_perpage) > 0){
				$jumlah = ($jumlah_query / $jumlah_perpage)+1;
			}else{
				$jumlah = $jumlah_query / $jumlah_perpage;
			}
			for ($i=1;$i<=$jumlah;$i++){
			$max = $_GET['h'] + 10;
			$min = $_GET['h'] - 9;
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=lap_loket_carabayar_detail&keydate1=$keydate1&keydate2=$keydate2&asuransi=$asuransi&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>