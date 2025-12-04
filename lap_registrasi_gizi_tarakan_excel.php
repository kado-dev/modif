<?php
	include "config/helper_css_laporan.php";
	include "config/helper_pasienrj.php";
	include_once('config/koneksi.php');
	session_start();
	$hariini = date('d-m-Y');
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Register Gizi (".$hariini.").xls");
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER GIZI</b></h4>
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
					<th width="3%" rowspan="2">NO.</th>
					<th width="6%" rowspan="2">TANGGAL</th>
					<th width="10%" rowspan="2">NAMA PASIEN - KK</th>
					<th width="6%" colspan="2">UMUR</th>
					<th width="5%" rowspan="2">KUNJ.</th>
					<th width="20%" colspan="12">PEMERIKSAAN STATUS GIZI</th>
					<th width="6%" rowspan="2">TERAPI<br/>DIET</th>
					<th width="8%" colspan="4">TOTAL KEBUTUHAN<br/>PASIEN PERHARI</th>
					<th width="8%" colspan="4">HASIL RECALL<br/>24 JAM</th>
					<th width="6%" rowspan="2">ANAMNESA<br/>THERAPY</th>
					<th width="6%" rowspan="2">RUJUK<br/>INTERNAL</th>
					
				</tr>
				<tr>
					<th>L</th>
					<th>P</th>
					<th>BB</th>
					<th>TB</th>
					<th>BBI</th>
					<th>IMT</th>
					<th>NTOB</th>
					<th>ASI</th>
					<th>BUKU KIA</th>
					<th>BBU</th>
					<th>BBTB</th>
					<th>TBU</th>
					<th>BGM</th>
					<th>IMTU</th>
					<th>E</th><!--total kebutuhan pasien perhari-->
					<th>P</th>
					<th>L</th>
					<th>K</th>
					<th>E</th><!--hasil recall 24 jam-->
					<th>P</th>
					<th>L</th>
					<th>K</th>
				</tr>
			</thead>
			<tbody style="font-size: 10px;">
				<?php
				$waktu = "a.TanggalPeriksa BETWEEN '$keydate1' AND '$keydate2' AND substring(a.NoPemeriksaan,1,11) = '$kodepuskesmas'";				
				$str = "SELECT a.TanggalPeriksa, b.NoCM, b.NamaPasien, a.Anamnesa, a.NoPemeriksaan, a.NoIndex, a.BeratBadan, a.BBI, a.Imt,
				a.Ntob, a.Asi, a.Bbu, a.Bbtb, a.Tbu, a.Bgm, a.Imtu, a.TinggiBadan, a.RujukInternal, a.TerapiDiet, a.Energi, a.Protein, a.Lemak,
				a.Karbohidrat, a.EnergiRecall, a.ProteinRecall, a.LemakRecall, a.KarbohidratRecall, b.UmurTahun, b.JenisKelamin, b.StatusPulang,
				b.Asuransi, b.StatusKunjungan
				FROM `tbpoligizi` a LEFT JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi
				WHERE ".$waktu;
				$str2 = $str." ORDER BY a.`TanggalPeriksa` DESC, a.`NamaPasien` ASC";
				// echo ($str2);
				// die();
					
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noregistrasi = $data['NoPemeriksaan'];
					$noindex = $data['NoIndex'];
					$nocm = $data['NoCM'];
					$anamnesa = $data['Anamnesa'];
					$kelamin = $data['JenisKelamin'];
					$kunjungan = $data['StatusKunjungan'];
					$tensi = $data['Sistole']."/".$data['Diastole'];
					$bbtb = $data['BeratBadan']."/".$data['TinggiBadan'];
					$suhu = $data['SuhuTubuh'];
					$hrrr = $data['DetakNadi']."/".$data['RR'];
					$therapy = $data['Terapi'];
					$asuransi = $data['Asuransi'];
					
					// tbpasienperpegawai
					if($data['NamaPegawai1']!=''){
						$pemeriksa = $data['NamaPegawai1'];
					}else{
						$pemeriksa = $data['NamaPegawai2'];
					}
										
					// tbkk
					$str_kk = "SELECT `NamaKK`, `Alamat`, `RT`, `No` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$query_kk = mysqli_query($koneksi,$str_kk);
					$data_kk = mysqli_fetch_assoc($query_kk);
					$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", NO.".$data_kk['No'];
					
					// tbpasien
					$data_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `NoCM` = '$nocm'"));
					
					// tbdiagnosapasien
					$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
					$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
					$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
					while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
						$data_diagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
						$array_diagnosa[$no][] = $data_diagnosapsn['KodeDiagnosa']."-".$data_diagnosa['Diagnosa'];
					}
					if ($array_diagnosa[$no] != ''){
						$data_dgs = implode(",", $array_diagnosa[$no]);
					}else{
						$data_dgs ="";
					}
					
					// resep
					$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
					$str_resep = "SELECT `KodeBarang` FROM `$tbresepdetail` WHERE `NoResep` = '$noregistrasi'";
					$query_resepdetail = mysqli_query($koneksi,$str_resep);
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
					
					// cek umur kelamin
					if ($kelamin == 'L'){
						$umur_l = $data['UmurTahun']." TH";
						$umur_p = "-";
					}else{
						$umur_l = "-";
						$umur_p = $data['UmurTahun']." TH";
					}
					
					// cek rujukan
					$rujukan = $data['StatusPulang'];
					if ($rujukan == 3){
						$berobatjalan = '<span class="fa fa-check"></span>';
						$rujuklanjut = '-';
					}else if($rujukan == 4){
						$rujuklanjut = '<span class="fa fa-check"></span>';
						$berobatjalan = '-';
					}
					
				?>
					<tr>
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalPeriksa']));?></td>
						<td align="left">
							<?php 
								echo "<b>".strtoupper($data['NamaPasien']."</b><br/>".
								strtoupper($data_kk['NamaKK'])."<br/>".
								substr($noindex, -10)." <br/> ".$asuransi)."<br/>".
								"TL.".$data_pasien['TanggalLahir']."<br/><br/>";
								
								if($data_kk['Alamat'] == ''){
									echo $alamat = '<span style="color:red;">BELUM TERDAFTAR</span>';
								}else{
									echo strtoupper($alamat);
								}
							?>
						</td>
						<td align="center"><?php echo $umur_l;?></td>
						<td align="center"><?php echo $umur_p;?></td>
						<td align="center"><?php echo strtoupper($data['StatusKunjungan']);?></td>
						<td align="left"><?php echo $data['BeratBadan'];?></td>
						<td align="left"><?php echo $data['TinggiBadan'];?></td>
						<td align="left"><?php echo $data['BBI'];?></td>
						<td align="left"><?php echo $data['Imt'];?></td>
						<td align="left"><?php echo $data['Ntob'];?></td>
						<td align="left"><?php echo $data['Asi'];?></td>
						<td align="left">-</td>
						<td align="center"><?php echo strtoupper($data['Bbu']);?></td>
						<td align="center"><?php echo strtoupper($data['Bbtb']);?></td>
						<td align="center"><?php echo strtoupper($data['Tbu']);?></td>
						<td align="center"><?php echo strtoupper($data['Bgm']);?></td>
						<td align="center"><?php echo strtoupper($data['Imtu']);?></td>
						<td align="center"><?php echo strtoupper($data['TerapiDiet']);?></td>
						<td align="center"><?php echo strtoupper($data['Energi']);?></td>
						<td align="center"><?php echo strtoupper($data['Protein']);?></td>
						<td align="center"><?php echo strtoupper($data['Lemak']);?></td>
						<td align="center"><?php echo strtoupper($data['Karbohidrat']);?></td>
						<td align="center"><?php echo strtoupper($data['EnergiRecall']);?></td>
						<td align="center"><?php echo strtoupper($data['ProteinRecall']);?></td>
						<td align="center"><?php echo strtoupper($data['LemakRecall']);?></td>
						<td align="left"><?php echo strtoupper($data['KarbohidratRecall']);?></td>
						<td align="left">
							<?php 
								echo "ANAMNESA <br/><b>".
								$anamnesa."</b><br/><br/>".
								"THERAPY <br/><b>".
								strtoupper($data_rsp)."</b>";
							?>
						</td>
						<td align="center"><?php echo str_replace('POLI','', $data['RujukInternal']);?></td>
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