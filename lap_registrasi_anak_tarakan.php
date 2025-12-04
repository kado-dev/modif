<?php
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER ANAK</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_registrasi_anak_tarakan"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal" required>
						</div>
						<div class="col-xl-2">
							 <input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir" required>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_anak_tarakan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_registrasi_anak_tarakan_excel.php?kd=<?php echo $kodepuskesmas;?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>	
	</div>
	<?php
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	if(isset($keydate1) and isset($keydate2)){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER PELAYANAN ANAK</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2))?> <?php echo $tahun;?></span>
		<br/>
	</div>

	<div class="atastabel font11">
		<div style="float:left; width:65%; margin-bottom:10px;">
			<table style="font-size:10px; width:300px;">
				<tr>
					<td style="padding:2px 4px;">Kode Puskesmas</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $kodepuskesmas;?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Puskesmas</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $namapuskesmas;?></td>
				</tr>
			</table><p/>
		</div>
	</div>
	
	<!--data registrasi-->
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="3%" rowspan="2">NO.</th>
							<th width="7%" rowspan="2">TANGGAL</th>
							<th width="20%" rowspan="2">NAMA PASIEN - KK</th>
							<th width="3%" rowspan="2">L/P</th>
							<th width="15%" rowspan="2">ALAMAT</th>
							<th width="6%" colspan="2">UMUR THN</th>
							<th width="10%" colspan="4">VITAL SIGN</th>
							<th width="15%" rowspan="2">ANAMNESA</th>
							<th width="15%" rowspan="2">DIAGNOSA</th>
							<th width="15%" rowspan="2">THERAPY</th>
							<th width="5%" colspan="2">RUJUK</th>
							<th width="10%" rowspan="2">KET.</th>
						</tr>
						<tr>
							<th>0-4</th>
							<th>5-14</th>
							<th>TD</th>
							<th>BB/TB</th>
							<th>SUHU</th>
							<th>HR/RR</th>
							<th>YA</th>
							<th>TDK</th>
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
						
						$waktu = "a.TanggalPeriksa BETWEEN '$keydate1' AND '$keydate2' AND substring(a.NoPemeriksaan,1,11) = '$kodepuskesmas'";					
						$str = "SELECT * FROM `tbpolianak` a JOIN `$tbpasienrj` b ON a.NoPemeriksaan = b.NoRegistrasi
						WHERE ".$waktu;
						$str2 = $str." ORDER BY a.`TanggalPeriksa` DESC, a.`NamaPasien` ASC LIMIT $mulai,$jumlah_perpage";
						// echo ($str);
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$noregistrasi = $data['NoPemeriksaan'];
							$noindex = $data['NoIndex'];
							$anamnesa = $data['Anamnesa'];
							$kelamin = $data['JenisKelamin'];
							$kunjungan = $data['StatusKunjungan'];
							$tensi = $data['Sistole']."/".$data['Diastole'];
							$bbtb = $data['BeratBadan']."/".$data['TinggiBadan'];
							$suhu = $data['SuhuTubuh'];
							$hrrr = $data['DetakNadi']."/".$data['RR'];
							$therapy = $data['Terapi'];
							
							// tbpasienperpegawai
							$tbpasienperpegawai='tbpasienperpegawai_'.$kodepuskesmas;
							$dt_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienperpegawai` where NoRegistrasi='$noregistrasi'"));
							if($dt_pegawai['NamaPegawai1']!=''){
								$pemeriksa = $dt_pegawai['NamaPegawai1'];
							}else{
								$pemeriksa = $dt_pegawai['NamaPegawai2'];
							}
														
							// tbpasienrj
							$str_rj = "SELECT JenisKelamin, UmurTahun, PoliPertama, StatusPulang, Asuransi FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'";
							$query_rj = mysqli_query($koneksi,$str_rj);
							$data_rj = mysqli_fetch_assoc($query_rj);
							$kelamin = $data_rj['JenisKelamin'];
							
							// tbkk
							$str_kk = "SELECT `NamaKK`, `Alamat`, `RT`, `RW`, `Kelurahan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
							$query_kk = mysqli_query($koneksi,$str_kk);
							$data_kk = mysqli_fetch_assoc($query_kk);
							$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", NO.".$data_kk['No'].", ".$data_kk['Kelurahan'];
							
							// tbdiagnosapasien
							$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
							$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
							$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
							
							// resep
							$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
							$str_resep = "SELECT `KodeBarang` FROM `$tbresepdetail` WHERE `NoResep` = '$noregistrasi'";
							$query_resepdetail = mysqli_query($koneksi,$str_resep);
							
							// cek umur kelamin
							if($data_rj['UmurTahun'] < 5){
								$umur1 = $data_rj['UmurTahun']." TH";
							}else{
								$umur1 = "-";
							}	
							
							if($data_rj['UmurTahun'] >= 5){
								$umur2 = $data_rj['UmurTahun']." TH";
							}else{
								$umur2 = "-";
							}
														
							// cek rujukan
							$rujukan = $data_rj['StatusPulang'];
							if ($rujukan == 3){
								$berobatjalan = '<span class="fa fa-check"></span>';
								$rujuklanjut = '-';
							}else if($rujukan == 4){
								$rujuklanjut = '<span class="fa fa-check"></span>';
								$berobatjalan = '-';
							}
							
							// cek diagnosa pasien
							while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
								$data_diagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
								$array_diagnosa[$no][] = $data_diagnosapsn['KodeDiagnosa']."-".$data_diagnosa['Diagnosa'];
							}
							if ($array_diagnosa[$no] != ''){
								$data_dgs = implode(",", $array_diagnosa[$no]);
							}else{
								$data_dgs ="";
							}
							
							// cek resep
							$tbgudangpkmstok = "tbgudangpkmstok_".str_replace(' ', '', $namapuskesmas);
							while($data_resep = mysqli_fetch_array($query_resepdetail)){
								$data_obat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbgudangpkmstok` WHERE `KodeBarang` = '$data_resep[KodeBarang]'"));
								$array_resep[$no][] = $data_obat['NamaBarang'];
							}
							if ($array_resep[$no] != ''){
								$data_rsp = implode(",", $array_resep[$no]);
							}else{
								$data_rsp ="";
							}
							
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalPeriksa']));?></td>
								<td align="left">
									<?php 
										echo "<b>".strtoupper($data['NamaPasien']."</b><br/>".
										strtoupper($data_kk['NamaKK'])."<br/>".
										substr($noindex, -10)." - ".$data_rj['Asuransi']);
									?>
								</td>
								<td align="center"><?php echo $kelamin;?></td>
								<td align="left">
									<?php
										if($data_kk['Alamat'] == ''){
											echo $alamat = '<span style="color:red;">BELUM TERDAFTAR</span>';
										}else{
											echo strtoupper($alamat);
										}
									?>
								</td>
								<td align="left"><?php echo $umur1;?></td>
								<td align="left"><?php echo $umur2;?></td>
								<td align="center"><?php echo $tensi;?></td>
								<td align="center"><?php echo $bbtb;?></td>
								<td align="center"><?php echo $suhu;?></td>
								<td align="center"><?php echo $hrrr;?></td>
								<td align="left"><?php echo strtoupper($anamnesa);?></td>
								<td align="left"><?php echo strtoupper($data_dgs);?></td>
								<td align="left"><?php echo strtoupper($data_rsp);?></td>
								<td align="center"><?php echo $rujuklanjut;?></td>
								<td align="center"><?php echo $berobatjalan;?></td>
								<td align="left"><?php echo $pemeriksa;?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br/>
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
						echo "<li><a href='?page=lap_registrasi_anak_tarakan&keydate1=$keydate1&keydate2=$keydate2&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	mysqli_close($koneksi);
	?>
</div>	
