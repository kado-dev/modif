<?php
	session_start();
	include "config/helper_css_laporan.php";
	include "config/helper_pasienrj.php";
	include "config/koneksi.php";
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Register KIA (".$keydate1.").xls");
	if(isset($keydate1) and isset($keydate2)){
?>

<style>
.tr, th{
	text-align:center;
}
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
}
.printheader h4{
	font-size:14px;
	font-family: "Trebuchet MS";
}
.printheader p{
	font-size:14px;
	font-family: "Trebuchet MS";
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	margin-top:10px;
}
.font14{
	font-size:14px;
	font-family: "Tahoma";
}


@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
	}
	.printheader{
		display:block;
	}
	.atastabel{
		display:block;
	}
}
</style>

<div class="printheader">
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER KIA</b></h4>
	<p style="margin:1px; font-size: 16px;">
		<p style="margin:1px;">Periode Laporan: <?php echo $keydate1." s/d ".$keydate2;?></p>
	</p><br/>
</div>

<div class="atastabel font14">
	<div style="float:left; width:65%; margin-bottom:0px;">
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5 style="margin:5px;">Kode Puskesmas</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".$kodepuskesmas;?></h5 ></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Puskesmas</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".$namapuskesmas;?></h5 ></td>
			</tr>
		</table>
	</div>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
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
				$waktu = "TanggalPeriksa BETWEEN '$keydate1' AND '$keydate2'";					
				$str = "SELECT * FROM `$tbpolikia` WHERE ".$waktu;
				$str2 = $str." ORDER BY `TanggalPeriksa` DESC, `NamaPasien` ASC";
				// echo ($str2);
								
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
						$berobatjalan = 'Y';
						$rujuklanjut = '-';
					}else if($rujukan == 4){
						$rujuklanjut = 'Y';
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
<?php
}
?>