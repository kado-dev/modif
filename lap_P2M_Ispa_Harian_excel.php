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
	$opsiform = $_GET['opsiform'];
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
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER ISPA</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></p><br/>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th rowspan="2" width="3%">NO.</th>
					<th rowspan="2" width="5%">TANGGAL PERIKSA</th>
					<th rowspan="2" width="5%">NIK</th>
					<th rowspan="2">NAMA PASIEN</th>
					<th rowspan="2">ALAMAT</th>
					<th colspan="2">KUNJUNGAN</th>
					<th colspan="2">KELAMIN</th>
					<th rowspan="2">FREKUENSI NAFAS</th>
					<th colspan="3">KLASIFIKASI</th>
					<th colspan="2">TINDAK LANJUT</th>
					<th colspan="2">ANTIBIOTIK</th>
					<th colspan="3">KONDISI SAAT KUNJ.ULG</th>
					<th rowspan="2">KET. MENINGGAL</th>
					<th colspan="2">ISPA(>5 TH)</th>
					<th rowspan="2">KET</th>
				</tr>
				<tr>
					<th>B</th>
					<th>L</th>
					<!--kelamin-->
					<th>L</th>
					<th>P</th>
					<!--Klasifikasi-->
					<th>BP</th>
					<th>P</th>
					<th>PB</th>
					<!--Tindak Lanjut-->
					<th>RJ</th>
					<th>Rujuk</th>
					<!--Antibiotik-->
					<th>YA</th>
					<th>TIDAK</th>
					<!--Kondisi Saat Kunj.Ulang-->
					<th>MAMBAIK</th>
					<th>TETAP</th>
					<th>MEMBURUK</th>
					<!--Kondisi Saat Kunj.Ulang--> 
					<th>BKN PNEUMONIA</th>
					<th>PNEUMONIA</th>
				</tr>
			</thead>
			<tbody>
				<?php						
				if($kodepuskesmas != "-"){
					$kodepuskesmas = " WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'";
				}else{
					$kodepuskesmas = " ";
				}	
				
				if($opsiform == 'bulan'){
					$waktu = " AND YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan'";
					$tbdiagnosaispa = 'tbdiagnosaispa';
				}else{
					$waktu = " AND TanggalRegistrasi BETWEEN '$keydate1' AND '$keydate2'";
					$tbdiagnosaispa = 'tbdiagnosaispa';
				}
								
				// tbdiagnosaispa
				$kasus = $_GET['kasus'];
				if($kasus != 'Semua'){
					$qkasus = " AND Kunjungan = '$kasus'";
				}else{
					$qkasus = " ";
				}
				
				$str_ispa = "SELECT * FROM `$tbdiagnosaispa`".$kodepuskesmas.$waktu.$qkasus;
				$str2 = $str_ispa."order by TanggalRegistrasi ASC , NamaPasien ASC";
				// echo $str2;
				
				$query_ispa = mysqli_query($koneksi,$str2);
				while($data_ispa = mysqli_fetch_assoc($query_ispa)){
					$no = $no + 1;
					$noregistrasi = $data_ispa['NoRegistrasi'];
					$noindex = $data_ispa['NoIndex'];
					$klasifikasi = $data_ispa['Klasifikasi'];
					$tindaklanjut = $data_ispa['TindakLanjut'];
					$antibiotik = $data_ispa['AntiBiotik'];
					$kondisi = $data_ispa['KondisiKujunganUlang'];
					$ispa = $data_ispa['Ispa5tahun'];
					$kelamin = $data_ispa['Kelamin'];
					
					// tbkk
					$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
					$dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbkk` WHERE `NoIndex`='$noindex'"));
					$alamat = strtoupper($dtkk['Alamat']).", RT.".strtoupper($dtkk['RT']).", ".strtoupper($dtkk['Kelurahan']);
					
					// kunjungan
					if($kunjungan == 'Baru'){
						$kunjungan_b = 'Ya';
						$kunjungan_l = '-';
					}else{
						$kunjungan_l = 'Ya';
						$kunjungan_b = '-';
					}
					
					// kelamin
					if($kelamin == 'L'){
						$kelamin_l = $data_ispa['UmurTahun'];
						$kelamin_p = '-';
					}else{
						$kelamin_p = $data_ispa['UmurTahun'];
						$kelamin_l = '-';
					}
					
					// klasifikasi
					if($klasifikasi == 'Bukan Pneumonia'){
						$klasifikasi_bp = 'Ya';
						$klasifikasi_p = '-';
						$klasifikasi_pb = '-';
					}elseif($klasifikasi == 'Pneumonia'){
						$klasifikasi_p = 'Ya';
						$klasifikasi_bp = '-';
						$klasifikasi_pb = '-';
					}elseif($klasifikasi == 'Pneumonia Berat'){
						$klasifikasi_pb = 'Ya';
						$klasifikasi_bp = '-';
						$klasifikasi_p = '-';
					}
					
					// tindaklanjut
					if($tindaklanjut == 'Rawat Jalan'){
						$rawat_jalan = 'Ya';
						$rujuk = '-';
					}elseif($tindaklanjut == 'Rujuk'){
						$rujuk = 'Ya';
						$rawat_jalan = '-';
					}
					
					// antibiotik
					if($antibiotik == 'Ya'){
						$Ya = 'Ya';
						$Tidak = '-';
					}elseif($antibiotik == 'Tidak'){
						$Tidak = 'Ya';
						$Ya = '-';
					}
					
					// kondisikunjunganulang
					if($kondisi == 'Membaik'){
						$membaik = 'Ya';
						$tetap = '-';
						$memburuk = '-';
					}elseif($kondisi == 'Tetap'){
						$tetap = 'Ya';
						$membaik = '-';
						$memburuk = '-';
					}elseif($kondisi == 'Memburuk'){
						$memburuk = 'Ya';
						$membaik = '-';
						$tetap = '-';
					}
					
					// cek diagnosa pasien
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
					
					// ispa
					if(strpos($data_dgs, "J18") !== false){
						$pneumoni = 'Ya';
						$bukanpneumoni = '-';
					}else{
						$bukanpneumoni = 'Ya';
						$pneumoni = '-';
					}
				
				?>
					<tr style="border:1px solid #000;">
						<td><?php echo $no;?></td>
						<td><?php echo $data_ispa['TanggalRegistrasi'];?></td>
						<td class="str">
							<?php 
								// nik
								$tbpasienrj = "tbpasienrj_".$_SESSION['kodepuskesmas'];
								$dtreg = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoCM` FROM `$tbpasienrj` WHERE `NoRegistrasi`='$noregistrasi'"));
								$dtnik = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Nik` FROM `tbpasien` WHERE `NoCM`='$dtreg[NoCM]'"));
								echo $dtnik['Nik']." ";
							?>
						</td>
						<td><?php echo $data_ispa['NamaPasien'];?></td>
						<td><?php echo $alamat;?></td>
						<td><?php echo $kunjungan_b;?></td>
						<td><?php echo $kunjungan_l;?></td>
						<td><?php echo $kelamin_l;?></td>
						<td><?php echo $kelamin_p;?></td>
						<td><?php echo $data_ispa['FrekuensiNafas'];?></td>
						<td><?php echo $klasifikasi_bp;?></td>
						<td><?php echo $klasifikasi_p;?></td>
						<td><?php echo $klasifikasi_pb;?></td>
						<td><?php echo $rawat_jalan;?></td>
						<td><?php echo $rujuk;?></td>
						<td><?php echo $Ya;?></td>
						<td><?php echo $Tidak;?></td>
						<td><?php echo $membaik;?></td>
						<td><?php echo $tetap;?></td>
						<td><?php echo $memburuk;?></td>
						<td><?php echo $data_ispa['KeteranganMeninggal'];?></td>
						<td><?php echo $bukanpneumoni;?></td>
						<td><?php echo $pneumoni;?></td>
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