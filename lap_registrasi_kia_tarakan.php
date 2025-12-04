<?php
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER KIA</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_registrasi_kia_tarakan"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal">
						</div>
						<div class="col-xl-2">
							<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir">
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_registrasi_kia_tarakan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_registrasi_kia_tarakan_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $kodepuskesmas;?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER PELAYANAN KIA</b></span><br>
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
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr>
							<th rowspan="2" width="3%">NO.</th>
							<th rowspan="2" width="7%">TGL.PERIKSA</th>
							<th rowspan="2" width="10%">NAMA PASIEN</th>
							<th rowspan="2" width="3%">UMUR</th>
							<th rowspan="2" width="2%">KUNJ.</th>
							<th colspan="4" width="8%">VITAL SIGN</th>
							<th colspan="10" width="20%">PEMERIKSAAN KEHAMILAN</th>
							<th rowspan="2" width="5%">ANAMNESA</th>
							<th rowspan="2" width="5%">DIAGNOSA</th>
							<th rowspan="2" width="5%">THERAPY</th>
							<th colspan="2" width="5%">RUJUK</th>
						</tr>
						<tr>
							<th>TD</th><!--Vital Sign-->
							<th>BB/TB</th>
							<th>SUHU</th>
							<th>HR/RR</th>
							<th>HPHT</th><!--Pemeriksaan Kehamilan-->
							<th>GPA</th>
							<th>F.RESTI</th>
							<th>LILA</th>
							<th>TFU</th>
							<th>L.JANIN</th>
							<th>DJJ</th>
							<th>TT</th>
							<th>FE</th>
							<th>KH</th>
							<th>YA</th>
							<th>TDK</th>
						</tr>
					</thead>
					<tbody style="font-size: 12px;">
						<?php
						$jumlah_perpage = 20;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$waktu = "TanggalPeriksa BETWEEN '$keydate1' AND '$keydate2'";					
						$str = "SELECT * FROM `$tbpolikia` WHERE ".$waktu;
						$str2 = $str." ORDER BY `TanggalPeriksa` DESC, `NamaPasien` ASC LIMIT $mulai,$jumlah_perpage";
						// echo ($str2);
						
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
							$hpht = $data['Hpht'];
							$gpa = $data['Gravida']."/".$data['Partus']."/".$data['Abortus'];
							$resti = strtoupper($data['FaktorResiko']);
							$lila = strtoupper($data['Lila']);
							$tfu = strtoupper($data['Tfu']);
							$janin = strtoupper($data['KepThd']);
							$djj = strtoupper($data['Djj']);
							$imuntt = strtoupper($data['TT']);
							$fe = strtoupper($data['FE']);
							$kh = strtoupper($data['KunjunganKehamilan']);
							$therapy = $data['Terapi'];
							$nokohort = $data['NoKohort'];
							
							// tbpasienperpegawai
							$tbpasienperpegawai='tbpasienperpegawai_'.$kodepuskesmas;
							$dt_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienperpegawai` WHERE `NoRegistrasi`='$noregistrasi'"));
							if($dt_pegawai['NamaPegawai1']!=''){
								$pemeriksa = $dt_pegawai['NamaPegawai1'];
							}else{
								$pemeriksa = $dt_pegawai['NamaPegawai2'];
							}
							
							// tbkk
							$str_kk = "SELECT `NamaKK`, `Alamat`, `RT`, `RW`, `Kelurahan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
							$query_kk = mysqli_query($koneksi,$str_kk);
							$data_kk = mysqli_fetch_assoc($query_kk);
							$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", NO.".$data_kk['No'].", ".$data_kk['Kelurahan'];
							
							// tbpasien
							$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `NoCM` = '$data[NoCM]'"));
							
							// tbdiagnosapasien
							$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
							$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
							$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
							
							// resep
							$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
							$str_resep = "SELECT `KodeBarang` FROM `$tbresepdetail` WHERE `NoResep` = '$noregistrasi'";
							$query_resepdetail = mysqli_query($koneksi,$str_resep);
														
							// cek rujukan
							$rujukan = $data['StatusPulang'];
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
							
							// therapy
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
								<td align="left" >
									<?php 
										echo "<b>".strtoupper($data['NamaPasien'])."</b><br/>".
										strtoupper($data_kk['NamaKK'])."<br/>".
										substr($noindex, -10)." <br/> TTL.".date('d-m-Y', strtotime($datapasien['TanggalLahir']))."<br/>".
										"ALAMAT :<br/>";
										if($data_kk['Alamat'] == ''){
											echo $alamat = '<span style="color:red;">BELUM TERDAFTAR</span>';
										}else{
											echo "<b>".strtoupper($alamat)."</b>";
										}
										
										if($data_kk['Telepon'] != ''){
											echo "<br/><b>TELP.".$data_kk['Telepon']."</b>";
										}else{
											if($datapasien['Telpon'] != ''){
												echo "<br/><b>TELP.".$datapasien['Telpon']."</b>";
											}	
										}
									?>	
									
									<br/><br/>
									<?php 	
										echo "PEMERIKSA : <br/><b>".$pemeriksa."</b>";
									?>
								</td>
								<td align="center"><?php echo $data['UmurTahun']." Th";?></td>
								<td align="center"><?php echo strtoupper($kunjungan);?></td>
								<td align="center"><?php echo $tensi;?></td>
								<td align="center"><?php echo $bbtb;?></td>
								<td align="center"><?php echo $suhu;?></td>
								<td align="center"><?php echo $hrrr;?></td>
								<td align="center"><?php echo $hpht;?></td>
								<td align="center"><?php echo $gpa;?></td>
								<td align="center"><?php echo $resti;?></td>
								<td align="center"><?php echo $lila;?></td>
								<td align="center"><?php echo $tfu;?></td>
								<td align="center"><?php echo $janin;?></td>
								<td align="center"><?php echo $djj;?></td>
								<td align="center"><?php echo $imuntt;?></td>
								<td align="center"><?php echo $fe;?></td>
								<td align="center"><?php echo $kh;?></td>
								<td align="left"><?php echo $anamnesa;?></td>
								<td align="left"><?php echo $data_dgs;?></td>
								<td align="left"><?php echo $data_rsp;?></td>
								<td align="center"><?php echo $rujuklanjut;?></td>
								<td align="center"><?php echo $berobatjalan;?></td>
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
						echo "<li><a href='?page=lap_registrasi_kia_tarakan&keydate1=$keydate1&keydate2=$keydate2&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>

