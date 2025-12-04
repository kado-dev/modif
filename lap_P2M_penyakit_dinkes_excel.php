<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	
	// get data
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kodediagnosa = $_GET['kodebpjs'];
	$kasus = $_GET['kasus'];
	$kodepuskesmas = $_GET['kodepuskesmas'];
	$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;	
	
	// datapuskesmas
	$dtpuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas`='$kodepuskesmas'"));
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_P2M_Tracking_Diagnosa (".$kodediagnosa.' '.$bulan.'-'.$tahun.").xls");
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
	<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b>DINAS KESEHATAN</b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN TRACKING DIAGNOSA</b></h4>
	<p style="margin:1px;">PERIODE LAPORAN : <?php echo nama_bulan($bulan)." ".$tahun;?></p>
	<p style="margin:1px;">PUSKESMAS : <?php echo $dtpuskesmas['NamaPuskesmas'];?></p>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr style="border:1px solid #000;">
					<th rowspan="2"width="3%">No.</th>
					<th rowspan="2" width="7%">Tgl.Registrasi</th>
					<th rowspan="2" width="7%">No.Index</th>
					<th rowspan="2" width="10%">Nama Pasien</th>
					<th colspan="2" width="10%">Kelamin</th>
					<th rowspan="2" width="15%">Alamat</th>
					<th rowspan="2" width="5%">Kunj.</th>
					<th rowspan="2" width="8%">Jaminan</th>
					<th rowspan="2" width="8%">Pelayanan</th>
					<th rowspan="2" width="10%">Anamnesa</th>
					<th rowspan="2" width="5%">Diagnosa</th>
					<th rowspan="2" width="5%">Kasus</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th>L</th>
					<th>P</th>
				</tr>
			</thead>
			<tbody>
				<?php
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
					$str2 = $str_diagnosa." GROUP BY NoRegistrasi ORDER BY IdDiagnosa ASC";
					// echo $str2;	
					
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
						$dt_kk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Alamat`,`RT`,`Kelurahan` FROM `$tbkk` WHERE NoIndex = '$noindex2'"));
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
							<td><?php echo $no;?></td>
							<td><?php echo $data_diagnosa['TanggalDiagnosa'];?></td>
							<td><?php echo substr($noindex,-10);?></td>
							<td><?php echo $data_rj['NamaPasien'];?></td>
							<td><?php echo $kelamin_l;?></td>
							<td><?php echo $kelamin_p;?></td>
							<td><?php echo strtoupper($alamat_kk);?></td>
							<td><?php echo $data_rj['StatusKunjungan'];?></td>
							<td><?php echo $data_rj['Asuransi'];?></td>
							<td><?php echo $data_rj['PoliPertama'];?></td>
							<td><?php echo $anamnesa;?></td>
							<td><?php echo $kodediagnosa;?></td>
							<td><?php echo $kasus;?></td>
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