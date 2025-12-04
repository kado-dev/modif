<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";	
	$hariini = date('d-m-Y');
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$opsiform = $_GET['opsiform'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Register Pelayanan KIA (".$hariini.").xls");
	if(isset($keydate1) and isset($keydate2)){
?>
<style>
.tr, th{
	text-align:center;
}
td {
	vertical-align: middle;
}
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
}
.printheader h4{
	font-size:14px;
	font-family: "Poppins", sans-serif;
}
.printheader p{
	font-size:14px;
	font-family: "Poppins", sans-serif;
}
.printbody{
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Poppins", sans-serif;
}
.atastabel{
	margin-top:10px;
}
.bawahtabel{
	margin-top:10px;
	margin-bottom:10px;
	margin-left:-50px;
	margin-right:0px;
	display:none;
}
.font10{
	font-size:10px;
	font-family: "Poppins", sans-serif;
}
.font11{
	font-size:11px;
	font-family: "Poppins", sans-serif;
}
.font14{
	font-size:14px;
	font-family: "Poppins", sans-serif;
}
.str{
	mso-number-format:\@; 
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
	.printbody{
		display:block;
	}
	.atastabel{
		display:block;
	}
	.bawahtabel{
		display:block;
	}
}
</style>

<div class="printheader">
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTRASI PASIEN PELAYANAN KIA</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2));?></p><br/>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr style="border:1px solid #000;">
					<th rowspan="2" width="3%">NO.</th>
					<th rowspan="2" width="7%">TGL.PERIKSA</th>
					<th rowspan="2" width="5%">NO.INDEX</th>
					<th rowspan="2" width="10%">NIK</th>
					<th rowspan="2" width="10%">NAMA PASIEN</th>
					<th rowspan="2">UMUR</th>
					<th rowspan="2" width="12%">ALAMAT</th>
					<th rowspan="2">G/P/A</th>
					<th rowspan="2">HPHT</th>
					<th colspan="4">HASIL PEMERIKSAAN</th>
					<th colspan="2">PEMBERIAN</th>
					<th rowspan="2">FAKTOR RESTI</th>
					<th rowspan="2" width="10%">ANAMNESA</th>
					<th rowspan="2">DIAGNOSA</th>
					<th rowspan="2" width="10%">THERAPY</th>
					<th colspan="2">RUJUK</th>
					<th rowspan="2">KET.</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th>BB</th>
					<th>TB</th>
					<th>TD</th>
					<th>LILA</th>
					<th>TT</th>
					<th>FE</th>
					<th>Ya</th>
					<th>Tidak</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($opsiform == 'bulan'){
					$waktu = "YEAR(TanggalPeriksa) = '$tahun' AND MONTH(TanggalPeriksa) = '$bulan'";
					$str = "SELECT * FROM `$tbpolikia`  
					WHERE ".$waktu." AND SUBSTRING(NoPemeriksaan,1,11) = '$kodepuskesmas'";
					$str2 = $str." ORDER BY `TanggalPeriksa` Desc";
				}else{
					$waktu = "TanggalPeriksa BETWEEN '$keydate1' AND '$keydate2'";
					$str = "SELECT * FROM `$tbpolikia`
							WHERE ".$waktu." AND SUBSTRING(NoPemeriksaan,1,11) = '$kodepuskesmas'";
					$str2 = $str." ORDER BY `NoPemeriksaan` Desc";
				}
				// echo $str2;
				// die();
				
				$query = mysqli_query($koneksi, $str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noregistrasi = $data['NoRegistrasi'];
					$nocm = $data['NoCM'];
					$noindex = $data['NoIndex'];
				
					// tbpasienperpegawai
					$dt_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienperpegawai` WHERE `NoRegistrasi`='$noregistrasi'"));
					if($dt_pegawai['NamaPegawai1']!=''){
						$pemeriksa = $dt_pegawai['NamaPegawai1'];
					}else{
						$pemeriksa = $dt_pegawai['NamaPegawai2'];
					}
					
					//tbpasienrj
					$str_rj = "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi`='$noregistrasi'";
					$query_rj = mysqli_query($koneksi, $str_rj);
					$data_rj = mysqli_fetch_assoc($query_rj);
					$kelamin = $data_rj['JenisKelamin'];

					// pasien
					$dt_pasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Nik FROM `$tbpasien` WHERE `NoCM` = '$nocm'"));
					$nik = $dt_pasien['Nik'];
					
					// tbkk
					$str_kk = "SELECT `NamaKK`, `Alamat`, `RT`, `RW`, `Kelurahan`, `Kecamatan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$query_kk = mysqli_query($koneksi,$str_kk);
					$datakk = mysqli_fetch_assoc($query_kk);
					
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

					$alamatpasien = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
					strtoupper($kelurahan).", ".strtoupper($kecamatan);
					
					// tbdiagnosapasien
					$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
					// echo $str_diagnosapsn;
					$query_diagnosapsn = mysqli_query($koneksi, $str_diagnosapsn);
					
					// cek umur kelamin
					$umur = $data_rj['UmurTahun']."th ";
															
					//cek rujukan
					$rujukan = $data_rj['StatusPulang'];
					if ($rujukan == 3){
						$berobatjalan = '<span class="fa fa-check"></span>';
						$rujuklanjut = '-';
					}else if($rujukan == 4){
						$rujuklanjut = '<span class="fa fa-check"></span>';
						$berobatjalan = '-';
					}
								
					//cek diagnosa pasien				
					while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
						$array_data[$data['NoRegistrasi']][] = $data_diagnosapsn['KodeDiagnosa'];
					}
					if ($array_data[$data['NoRegistrasi']] != ''){
						$data_dgs = implode(",", $array_data[$data['NoRegistrasi']]);
					}else{
						$data_dgs ="";
					}
					// echo $data_dgs;

					// therapy
					$str_therapy = "SELECT * FROM `$tbresepdetail` WHERE `NoResep` = '$noregistrasi'";
					$query_therapy = mysqli_query($koneksi, $str_therapy);
					while($dt_therapy = mysqli_fetch_array($query_therapy)){
						$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `NamaBarang` FROM `$tbgudangpkmstok` WHERE `KodeBarang` = '$dt_therapy[KodeBarang]'"));
						$array_therapy[$no][] = $dtobat['NamaBarang']." (".$dt_therapy['jumlahobat'].")";
					}
					if ($array_therapy[$no] != ''){
						$data_trp = implode("<br/>", $array_therapy[$no]);
					}else{
						$data_trp = "";
					}
				?>
					<tr style="border:1px solid #000;">
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo $data['TanggalPeriksa'];?></td>
						<td align="center"><?php echo substr($data['NoIndex'],14);?></td>
						<td align="center" class="str"><?php echo $nik;?></td>
						<td align="left"><?php echo $data['NamaPasien'];?></td>
						<td><?php echo $umur;?></td>
						<td align="left"><?php echo $alamatpasien;?></td>
						<td><?php echo $data['Gravida']."/".$data['Partus']."/".$data['Abortus'];?></td>
						<td><?php echo $data['Hpht'];?></td><!--hpht-->
						<td><?php echo $data['BeratBadan'];?></td><!--bb-->
						<td><?php echo $data['TinggiBadan'];?></td><!--tb-->
						<td><?php echo $data['Sistole']."/".$data['Diastole'];?></td><!--td-->
						<td><?php echo $data['Lila'];?></td><!--lila-->
						<td><?php echo $data['TT'];?></td><!--pemberian tt-->
						<td><?php echo $data['FE'];?></td><!--pemberian fe-->
						<td><?php echo $data['FaktorResiko'];?></td><!--faktor resti-->
						<td align="left"><?php echo $data['Anamnesa'];?></td>
						<td align="left"><?php echo $data_dgs;?></td><!--diagnosa-->
						<td align="left"><?php echo strtoupper($data_trp);?></td>
						<td align="center"><?php echo $rujuklanjut;?></td>
						<td align="center"><?php echo $berobatjalan;?></td>
						<td align="center"><?php echo $pemeriksa;?></td><!--ket-->
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