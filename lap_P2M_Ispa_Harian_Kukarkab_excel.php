<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$tanggal = date('Y-m-d');
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;	
	// filterdata
	$kasus = $_GET['kasus'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Register_P2M_ISPA (".$namapuskesmas." ".$bulan." ".$tahun.").xls");
	if(isset($bulan) and isset($tahun)){
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
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printbody{
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
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
	font-family: "Tahoma";
}
.font11{
	font-size:11px;
	font-family: "Tahoma";
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
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER ISPA</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo $bulan." ".$tahun;?></p><br/>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr style="border:1px solid #000;">
					<th rowspan="2" width="3%">No.</th>
					<th rowspan="2" width="5%">Tgl.Periksa</th>
					<th rowspan="2" width="5%">NoRM</th>
					<th rowspan="2">Nama Pasien</th>
					<th rowspan="2">Alamat</th>
					<th colspan="2">Kunjungan</th>
					<th colspan="2">Kelamin</th>
					<th rowspan="2">Frekuensi Nafas</th>
					<th colspan="3">Klasifikasi</th>
					<th colspan="2">Tindak Lanjut</th>
					<th colspan="2">Antibiotik</th>
					<th colspan="3">Kondisi Saat Kunj.Ulang</th>
					<th rowspan="2">Ket. Meninggal</th>
					<th colspan="2">ISPA(>5 thn)</th>
					<th rowspan="2">Ket</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th>B</th>
					<th>L</th>
					<!--kelamin-->
					<th>L</th>
					<th>P</th>
					<!--Klasifikasi-->
					<th>BBP</th>
					<th>P</th>
					<th>PB</th>
					<!--Tindak Lanjut-->
					<th>RJ</th>
					<th>Rujuk</th>
					<!--Antibiotik-->
					<th>Ya</th>
					<th>Tidak</th>
					<!--Kondisi Saat Kunj.Ulang-->
					<th>Membaik</th>
					<th>Tetap</th>
					<th>Memburuk</th>
					<!--Kondisi Saat Kunj.Ulang--> 
					<th>Bkn Pneumonia</th>
					<th>Pneumonia</th>
				</tr>
				<tr>
					<th>1</th>
					<th>2</th>
					<th>3</th>
					<th>4</th>
					<th>5</th>
					<th colspan="2">6</th>
					<th colspan="2">7</th>
					<th>8</th>
					<th colspan="3">9</th>
					<th colspan="2">10</th>
					<th colspan="2">11</th>
					<th colspan="3">12</th>
					<th>13</th>
					<th colspan="2">14</th>
					<th>15</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 0;
				
				if($kasus == "semua"){
					$qkasus = " ";
				}else{
					$qkasus = " AND `Kasus`='$kasus'";
				}
				
				$str = "SELECT * FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa)='$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND (`KodeDiagnosa`='J00' OR `KodeDiagnosa`='J02.9' OR `KodeDiagnosa`='J03.9' OR `KodeDiagnosa`='J11.0' OR `KodeDiagnosa`=' J15.9' OR `KodeDiagnosa`='J18.9' OR `KodeDiagnosa`='J06.0' OR `KodeDiagnosa`='J04.0' OR `KodeDiagnosa`='J20.9' OR `KodeDiagnosa`='J39.8' OR `KodeDiagnosa`='J39.9')".$qkasus; 
				$str2 = $str;
				// echo $str2;
								
				$query_ispa = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query_ispa)){
					$no = $no + 1;
					$nocm = $data['NoCM'];
					$noregistrasi = $data['NoRegistrasi'];
					$tanggaldiagnosa = $data['TanggalDiagnosa'];
					
					// tbpasien
					$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpasien` WHERE `NoCM` = '$nocm'"));
					$norm = $datapasien['NoRM'];
					$namapasien = $datapasien['NamaPasien'];
					$alamat = $datapasien['Alamat'].", ".$datapasien['Kelurahan'];
					
					// tbpasienrj
					$datapasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'"));
					$kunjungan = $datapasienrj['StatusKunjungan'];
					$jeniskelamin = $datapasienrj['JenisKelamin'];
					$umurtahun = $datapasienrj['UmurTahun'];
					$umurbulan= $datapasienrj['UmurBulan'];
											
					if($kunjungan == 'Baru'){
						$statuskunj_baru = 'Y';
					}else{
						$statuskunj_baru = "-";
					}
					
					if($kunjungan == 'Lama'){
						$statuskunj_lama = 'Y';
					}else{
						$statuskunj_lama = "-";
					}
					
					if($jeniskelamin == 'L'){
						if($umurtahun != '0'){
							$kelamin_l = $umurtahun."Th";
							$kelamin_p = "-";
						}
					}else{
						if($umurtahun != '0'){
							$kelamin_p = $umurtahun."Th";
							$kelamin_l = "-";
						}
					}
					
					// tbdiagnosaispa
					$data_ispa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbdiagnosaispa` WHERE `NoRegistrasi` = '$noregistrasi'"));
					$klasifikasi = $data_ispa['Klasifikasi'];
					$ispa = $data_ispa['Ispa5tahun'];
					$frekuensinapas = $data_ispa['FrekuensiNafas'];						
					if ($frekuensinapas == ""){
						$frekuensinapas = '0';
					}else{
						$frekuensinapas = $frekuensinapas;
					}
					
					$klasifikasi = $data_ispa['Klasifikasi'];
					if ($klasifikasi == "Bukan Pneumonia"){
						$klasifikasi_bp = 'Y';
					}elseif($klasifikasi == "Pneumonia"){
						$klasifikasi_p = 'Y';
					}elseif($klasifikasi == "Pneumonia Berat"){
						$klasifikasi_pb = 'Y';
					}else{
						$klasifikasi_bp = '-';
						$klasifikasi_p = '-';
						$klasifikasi_pb = '-';
					}
					
					$tindaklanjut = $data_ispa['TindakLanjut'];
					if ($tindaklanjut == "Rawat Jalan"){
						$rawat_jalan = 'Y';
					}elseif($klasifikasi == "Rujuk"){
						$rujuk = 'Y';
					}else{
						$rawat_jalan = '-';
						$rujuk = '-';
					}
					
					$antibiotik = $data_ispa['AntiBiotik'];
					if($antibiotik == 'Ya'){
						$antibiotik_ya = 'Y';
					}elseif($antibiotik == 'Tidak'){
						$antibiotik_tidak = 'Y';
					}else{
						$antibiotik_ya = "-";
						$antibiotik_tidak = "-";
					}
					
					$kondisi = $data_ispa['KondisiKujunganUlang'];
					if($kondisi == 'Membaik'){
						$membaik = 'Y';
					}elseif($kondisi == 'Tetap'){
						$tetap = 'Y';
					}elseif($kondisi == 'Memburuk'){
						$memburuk = 'Y';
					}else{
						$membaik = "-";
						$tetap = "-";
						$memburuk = "-";
					}
					
					$ketmeninggal = $data_ispa['KeteranganMeninggal'];
					if($ketmeninggal == ''){
						$ketmeninggal = "-";
					}else{
						$ketmeninggal = $data_ispa['KeteranganMeninggal'];
					}
					
					$ispa = $data_ispa['Ispa5tahun'];
					if($ispa == 'Pneumonia'){
						$pneumoni = 'Y';
						$bukanpneumoni = '-';
					}elseif($ispa == 'Bukan Pneumonia'){
						$bukanpneumoni = 'Y';
						$pneumoni = '-';
					}
					
					//cek diagnosa pasien
					$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
					$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
					
					while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
						$array_data[$no][] = $data_diagnosapsn['KodeDiagnosa'];
					}
					if ($array_data[$no] != ''){
						$data_dgs = implode(",", $array_data[$no]);
					}else{
						$data_dgs ="";
					}
					
				
				?>
					<tr style="border:1px solid #000;">
						<td><?php echo $no;?></td>
						<td><?php echo $tanggaldiagnosa;?></td>
						<td><?php echo substr($norm,-8);?></td>
						<td><?php echo $namapasien;?></td>
						<td><?php echo $alamat;?></td>
						<td><?php echo $statuskunj_baru;?></td>
						<td><?php echo $statuskunj_lama;?></td>
						<td><?php echo $kelamin_l;?></td>
						<td><?php echo $kelamin_p;?></td>
						<td><?php echo $frekuensinapas?></td>
						<td><?php echo $klasifikasi_bp;?></td>
						<td><?php echo $klasifikasi_p;?></td>
						<td><?php echo $klasifikasi_pb;?></td>
						<td><?php echo $rawat_jalan;?></td>
						<td><?php echo $rujuk;?></td>
						<td><?php echo $antibiotik_ya;?></td>
						<td><?php echo $antibiotik_tidak;?></td>
						<td><?php echo $membaik;?></td>
						<td><?php echo $tetap;?></td>
						<td><?php echo $memburuk;?></td>
						<td><?php echo $ketmeninggal;?></td>
						<td><?php echo $pneumoni;?></td>
						<td><?php echo $bukanpneumoni;?></td>
						<td><?php echo $data_dgs;?></td>
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