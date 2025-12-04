<?php
	error_reporting(0);
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	
	// get
	$opsiform = $_GET['opsiform'];
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$hariini = date('d-m-Y');
	$tbpasienrj = 'tbpasienrj_'.$bulan;
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;	
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Register_KIA (".$hariini.").xls");
	if(isset($bulan) and isset($tahun)){
?>

<style>
.tr, th{
	text-align:center;
}
.printheader{
	margin-top:-15px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
	display: none;
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
	margin-left:-10px;
	margin-right:-10px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	display:none;
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
.font12{
	font-size:12px;
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
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER KIA</b></span><br>
	<span style="margin:1px;">Periode Laporan:  <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
	<br/>
</div><br/>

<div class=" atastabel">
	<div style="float:left; width:100%; margin-top:0px;">
		<table style="width:300px;">
			<tr>
				<td colspan=2>Kelurahan/Desa</td>
				<td><?php echo ": ".$kelurahan?></td>
			</tr>
			<tr>
				<td colspan=2>Kecamatan</td>
				<td><?php echo ": ".$kecamatan;?></td>
			</tr>
		</table>
	</div>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:10px;">
				<tr style="border:1px solid #000;">
					<th rowspan="2" width="2%">No.</th>
					<th rowspan="2" width="3%">Tanggal</th>
					<th rowspan="2" width="3%">No.Index</th>
					<th rowspan="2" width="3%">No.Resti</th>
					<th rowspan="2" width="6%">Nama Ibu / Suami</th>					
					<th rowspan="2" width="6%">Alamat</th>
					<th rowspan="2" width="2%">Usia</th>
					<th rowspan="2" width="3%">Usia<br/>Kehamilan</th>
					<th rowspan="2" width="3%">G.P.A</th>
					<th rowspan="2" width="4%">Jenis<br/>Kunjungan</th>
					<th rowspan="2" width="2%">BB</th>
					<th rowspan="2" width="2%">TB</th>
					<th rowspan="2" width="2%">LILA</th>
					<th rowspan="2" width="2%">SF</th>
					<th rowspan="2" width="2%">TT</th>
					<th colspan="10">Laboratorium</th>
					<th rowspan="2" width="5%">Hasil<br/>Pemeriksaan</th>
					<th rowspan="2" width="5%">Keluhan</th>
					<th rowspan="2" width="3%">N/FR/R</th>
					<th rowspan="2" width="2%">B/L</th>
					<th rowspan="2" width="3%">Therapy</th>
					<th rowspan="2" width="3%">Ket</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th width="3%">PP Test</th>
					<th width="3%">HB</th>
					<th width="3%">Protein</th>
					<th width="3%">Gds</th>
					<th width="3%">HbsAg</th>
					<th width="3%">Hiv</th>
					<th width="3%">Sifilis</th>
					<th width="3%">Malaria</th>
					<th width="3%">Asam Urat</th>
					<th width="3%">Goldar</th>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
				<?php
				if($opsiform == 'bulan'){
					$waktu = "YEAR(TanggalPeriksa) = '$tahun' AND MONTH(TanggalPeriksa) = '$bulan'";
					$str = "SELECT * FROM `$tbpolikia` WHERE ".$waktu." and SUBSTRING(NoPemeriksaan,1,11) = '$kodepuskesmas'";
					$str2 = $str."ORDER BY `TanggalPeriksa` DESC";
				}else{
					$waktu = "a.TanggalPeriksa BETWEEN '$keydate1' AND '$keydate2'";
					$str = "SELECT * FROM `$tbpolikia` WHERE ".$waktu." and SUBSTRING(NoPemeriksaan,1,11) = '$kodepuskesmas'";
					$str2 = $str."ORDER BY `TanggalPeriksa` DESC";
				}
				// echo $str2;
				// die();
				
				$no = 0;
				$query = mysqli_query($koneksi,$str2);
				while($datakia = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noregistrasi = $datakia['NoPemeriksaan'];
					$noindex = $datakia['NoIndex'];
					
					// tbpasienrj
					$dtpasien_rj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `UmurTahun`,`StatusKunjungan` FROM $tbpasienrj WHERE `NoRegistrasi`='$noregistrasi'"));
					
					// tbkk
					$str_kk = "SELECT `NamaKK`,`Alamat`, `RT`, `RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$query_kk = mysqli_query($koneksi,$str_kk);
					$data_kk = mysqli_fetch_assoc($query_kk);
					$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'];					
					
					// tbpasienperpegawai
					$tbpasienperpegawai='tbpasienperpegawai_'.$kodepuskesmas;
					$dt_pegawai = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienperpegawai` where NoRegistrasi='$noregistrasi'"));
					if($dt_pegawai['NamaPegawai1']!=''){
						$pemeriksa = $dt_pegawai['NamaPegawai1'];
					}else{
						$pemeriksa = $dt_pegawai['NamaPegawai2'];
					}
					
					//cek rujukan
					$rujukan = $data['StatusPulang'];
					if ($rujukan == 3){
						$berobatjalan = '<span class="fa fa-check"></span>';
						$rujuklanjut = '-';
					}else if($rujukan == 4){
						$rujuklanjut = '<span class="fa fa-check"></span>';
						$berobatjalan = '-';
					}
					
					//cek diagnosa pasien
					if($opsiform == 'bulan'){
						$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
					}else{
						$str_diagnosapsn = "SELECT * from(
											SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'
											UNION
											SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien2` WHERE `NoRegistrasi` = '$noregistrasi'
											)a";
					}
					$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
					while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
						$array_data[$no][] = $data_diagnosapsn['KodeDiagnosa'];
					}
					if ($array_data[$no] != ''){
						$data_dgs = implode(",", $array_data[$no]);
					}else{
						$data_dgs ="";
					}
					
					// therapy
					$str_therapy = "SELECT * FROM `tbresepdetail` WHERE `NoResep` = '$noregistrasi'";
					$query_therapy = mysqli_query($koneksi, $str_therapy);
					while($dt_therapy = mysqli_fetch_array($query_therapy)){
						$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT NamaBarang FROM `tbgudangpkmstok` WHERE `KodeBarang` = '$dt_therapy[KodeBarang]'"));
						$array_therapy[$no][] = $dtobat['NamaBarang']." (".$dt_therapy['jumlahobat'].")";
					}
					if ($array_therapy[$no] != ''){
						$data_trp = implode(",", $array_therapy[$no]);
					}else{
						$data_trp ="-";
					}
					
				?>
					<tr style="border:1px solid #000;">
						<td><?php echo $no;?></td>
						<td><?php echo $datakia['TanggalPeriksa'];?></td>
						<td><?php echo substr($noindex,-10);?></td>
						<td></td>
						<td><?php echo strtoupper($datakia['NamaPasien'])." | ".strtoupper($data_kk['NamaKK']);?></td>
						<td><?php
								if($data_kk['Alamat'] == ''){
									echo $alamat = '<span style="color:red;">Belum Terdaftar di Puskesmas</span>';
								}else{
									echo $alamat;
								}
							?>
						</td>
						<td><?php echo $dtpasien_rj['UmurTahun']." Th";?></td>
						<td><?php echo $datakia['UsiaKehamilan'];?></td>
						<td>
						<?php 
							if($datakia['Gravida']!=""){
								echo $datakia['Gravida']."/".$datakia['Partus']."/".$datakia['Abortus'];
							}else{
								echo "-";
							}	
						?>
						</td>
						<td><?php echo $datakia['KunjunganKehamilan'];?></td>
						<td><?php echo $datakia['BeratBadan'];?></td>
						<td><?php echo $datakia['TinggiBadan'];?></td>
						<td><?php if($datakia['Lila']!=""){echo $datakia['Lila'];}else{ echo "-";}?></td>
						<td><?php if($datakia['FE']!=""){echo $datakia['FE'];}else{ echo "-";}?></td>
						<td><?php if($datakia['TT']!=""){echo $datakia['TT'];}else{ echo "-";}?></td>
						<td><?php if($datakia['Pptest']!=""){echo $datakia['Pptest'];}else{ echo "-";}?></td>
						<td><?php if($datakia['K1Hb']!=""){echo $datakia['K1Hb'];}else{ echo $datakia['K4Hb'];}?></td>
						<td><?php if($datakia['ProteinUrin']!=""){echo $datakia['ProteinUrin'];}else{ echo "-";}?></td>
						<td><?php if($datakia['GulaDarahSewaktu']!=""){echo $datakia['GulaDarahSewaktu'];}else{ echo "-";}?></td>
						<td><?php if($datakia['Hbsag']!=""){echo $datakia['Hbsag'];}else{ echo "-";}?></td>
						<td><?php if($datakia['Hiv']!=""){echo $datakia['Hiv'];}else{ echo "-";}?></td>
						<td><?php if($datakia['Sifilis']!=""){echo $datakia['Sifilis'];}else{ echo "-";}?></td>
						<td><?php if($datakia['Malaria']!=""){echo $datakia['Malaria'];}else{ echo "-";}?></td>
						<td><?php if($datakia['AsamUrat']!=""){echo $datakia['AsamUrat'];}else{ echo "-";}?></td>
						<td><?php if($datakia['GolonganDarah']!=""){echo $datakia['GolonganDarah'];}else{ echo "-";}?></td>
						<td>
							<?php
								echo "Tfu: ".$datakia['Tfu'].", Djj: ".$datakia['Djj'].", KepThd: ".$datakia['KepThd'].", Presentasi: ".$datakia['Presentasi'];
							?>
						</td>
						<td><?php echo $datakia['Anamnesa'];?></td>
						<td></td>
						<td><?php echo $dtpasien_rj['StatusKunjungan'];?></td>
						<td><?php echo $data_trp;?></td>
						<td><?php echo $pemeriksa;?></td>
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