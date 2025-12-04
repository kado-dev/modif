<?php
	session_start();
	include "config/helper_css_laporan.php";
	include "config/helper_pasienrj.php";
	include "config/koneksi.php";
	
	$hariini = date('d-m-Y');
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$key = $_GET['key'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Register Imunisasi (".$hariini.").xls");
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
	font-size:24px;
	font-family: "Roboto Condensed", Arial, sans-serif;
}
.printheader p{
	font-size:24px;
	font-family: "Roboto Condensed", Arial, sans-serif;
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
	margin-bottom:100px;
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
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER IMUNISASI</b></span><br>
	<span class="font12" style="margin:15px 5px 5px 5px;">Periode Laporan: <?php echo $keydate1." s/d ".$keydate2;?></span><br>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="2%" rowspan="2">NO.</th>
					<th width="5%" rowspan="2">TANGGAL</th>
					<th width="10%" rowspan="2">NAMA PASIEN - KK</th>
					<th width="6%" colspan="2" >UMUR</th>
					<th width="8%" colspan="4">VITAL SIGN</th>
					<th width="2%" rowspan="2">KIPI</th>
					<th width="2%" rowspan="2">HB0</th>
					<th width="2%" rowspan="2">BCG</th>
					<th width="6%" colspan="3">DPT HB HIB</th>
					<th width="8%" colspan="4">POLIO</th>
					<th width="6%" colspan="3">PCV</th>
					<th width="2%" rowspan="2">IPV</th>
					<th width="2%" rowspan="2">MR</th>
					<th width="4%" rowspan="2">DPT<br/>HIB<br/>LANJUT</th>
					<th width="4%" rowspan="2">MR<br/>LANJUT</th>
					<th width="4%" rowspan="2">RUJUK<br/>R.ANAK</th>
					<th width="6%" colspan="3">ADS</th>
				</tr>
				<tr>
					<th>L</th>
					<th>P</th>
					<th>TD</th>
					<th>BB/TB</th>
					<th>SUHU</th>
					<th>HR/RR</th>
					<th>1</th><!--DPT HB HIB-->
					<th>2</th>
					<th>3</th>
					<th>1</th><!--DPT HB HIB-->
					<th>2</th>
					<th>3</th>
					<th>4</th>
					<th>1</th><!--PCV-->
					<th>2</th>
					<th>3</th>
					<th>0.05</th><!--ADS-->
					<th>0.5</th>
					<th>5</th>
				</tr>
			</thead>
			<tbody>
			<?php
				if($key != null){
					$namapasien = " AND (a.`NamaPasien` LIKE '%$key%')";
				}else{
					$namapasien = " ";
				}
				
				$waktu = "date(TanggalPeriksa) BETWEEN '$keydate1' AND '$keydate2' AND SUBSTRING(NoPemeriksaan,1,11) = '$kodepuskesmas'".$namapasien;					
				$str = "SELECT * FROM `tbpoliimunisasi` WHERE ".$waktu;
				$str2 = $str." GROUP BY NoCM ORDER BY `TanggalPeriksa` DESC, `NamaPasien` ASC";
				// echo ($str2);
				
				$no = 0;				
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
					$rujukinternal = $data['RujukInternal'];
					$ads005 = $data['Ads005'];
					$ads05 = $data['Ads05'];
					$ads5 = $data['Ads5'];
					
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
					$str_kk = "SELECT `NamaKK`, `Alamat`, `RT`, `RW`, `Kelurahan`, `Telepon` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$query_kk = mysqli_query($koneksi,$str_kk);
					$data_kk = mysqli_fetch_assoc($query_kk);
					$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", NO.".$data_kk['No'].", ".$data_kk['Kelurahan'];
					
					// tbpasien
					$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `NoCM` = '$data[NoCM]'"));
					
					// tbdiagnosapasien
					$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
					$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
					$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
					
					// cek umur kelamin
					if ($kelamin == 'L'){
						if( $data['UmurTahun'] == '0'){
							if( $data['UmurBulan'] == '0'){
								$umur_l = $data['UmurHari']." Hr";
							}else{
								$umur_l = $data['UmurBulan']." Bl";
							}	
						}else{
							$umur_l = $data['UmurTahun']." Th";
						}
						$umur_p = "-";
					}else{
						if( $data['UmurTahun'] == '0'){
							if( $data['UmurBulan'] == '0'){
								$umur_p = $data['UmurHari']." Hr";
							}else{
								$umur_p = $data['UmurBulan']." Bl";
							}
						}else{
							$umur_p = $data['UmurTahun']." Th";
						}
						$umur_l = "-";
					}
					
					// Riwayat Imunisasi Sebelumnya
					$str_imun = mysqli_query($koneksi,"SELECT RiwayatImunisasi
					FROM tbpoliimunisasi
					WHERE `NoCM` = '$data[NoCM]'");
					while($dtimun = mysqli_fetch_assoc($str_imun)){
						$dtaimunisasi[$no][] = $dtimun['RiwayatImunisasi'];
					}
					$dtimunisasi_gabung = implode(",",$dtaimunisasi[$no]);
					$dtimunisasi = explode(",",$dtimunisasi_gabung);
					
					// Imunisasi Sekarang
					$str_imun_2 = mysqli_query($koneksi,"SELECT ImunisasiSekarang
					FROM tbpoliimunisasi
					WHERE `NoCM` = '$data[NoCM]'");
					while($dtimun_2 = mysqli_fetch_assoc($str_imun_2)){
						$dtaimunisasi_2[$no][] = $dtimun_2['ImunisasiSekarang'];
					}
					$dtimunisasi_gabung_2 = implode(",",$dtaimunisasi_2[$no]);
					$dtimunisasi_2 = explode(",",$dtimunisasi_gabung_2);
												
					
				?>
					<tr>
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalPeriksa']));?></td>
						<td align="left">
							<?php 
								echo "<b>".strtoupper($data['NamaPasien']."</b><br/>".
								strtoupper($data_kk['NamaKK'])."<br/>".
								substr($noindex, -10)." <br/> ".$data_rj['Asuransi'])."<br/>".
								"TTL.".date('d-m-Y', strtotime($datapasien['TanggalLahir']))."<br/><br/>".
								"ALAMAT :<br/>";
								if($data_kk['Alamat'] == ''){
									echo $alamat = '<span style="color:red;">BELUM TERDAFTAR</span>';
								}else{
									echo strtoupper($alamat);
								}
							?>	
								
							<?php 
								if($data_kk['Telepon'] != ''){
									echo "Telp.".$data_kk['Telepon'];
								}else{
									if($datapasien['Telpon'] != ''){
										echo "Telp.".$datapasien['Telpon'];
									}else{
										echo "Telp. 0";
									}	
								}
							?>
							<br/><br/>
							<?php 	
								echo "PEMERIKSA : <br/>".
								$pemeriksa;
							?>
						</td>
						<td align="center"><?php echo $umur_l;?></td>
						<td align="center"><?php echo $umur_p;?></td>
						<td align="center"><?php echo $tensi;?></td>
						<td align="center"><?php echo $bbtb;?></td>
						<td align="center"><?php echo $suhu;?></td>
						<td align="center"><?php echo $hrrr;?></td>
						<td align="left"><?php echo strtoupper($data['Kipi']);?></td>
						<td align="left"><?php if(in_array('HBO',$dtimunisasi)){echo 'Y';}else{if(in_array('HBO',$dtimunisasi_2)){echo 'Y';}else{echo "-";}}?></td>
						<td align="left"><?php if(in_array('BCG',$dtimunisasi)){echo 'Y';}else{if(in_array('BCG',$dtimunisasi_2)){echo 'Y';}else{echo "-";}}?></td>
						<td align="left"><?php if(in_array('DPT HB HiB 1',$dtimunisasi)){echo 'Y';}else{if(in_array('DPT HB HiB 1',$dtimunisasi_2)){echo 'Y';}else{echo "-";}}?></td>
						<td align="left"><?php if(in_array('DPT HB HiB 2',$dtimunisasi)){echo 'Y';}else{if(in_array('DPT HB HiB 2',$dtimunisasi_2)){echo 'Y';}else{echo "-";}}?></td>
						<td align="left"><?php if(in_array('DPT HB HiB 3',$dtimunisasi)){echo 'Y';}else{if(in_array('DPT HB HiB 3',$dtimunisasi_2)){echo 'Y';}else{echo "-";}}?></td>
						<td align="left"><?php if(in_array('Polio 1',$dtimunisasi)){echo 'Y';}else{if(in_array('Polio 1',$dtimunisasi_2)){echo 'Y';}else{echo "-";}}?></td>
						<td align="left"><?php if(in_array('Polio 2',$dtimunisasi)){echo 'Y';}else{if(in_array('Polio 2',$dtimunisasi_2)){echo 'Y';}else{echo "-";}}?></td>
						<td align="left"><?php if(in_array('Polio 3',$dtimunisasi)){echo 'Y';}else{if(in_array('Polio 3',$dtimunisasi_2)){echo 'Y';}else{echo "-";}}?></td>
						<td align="left"><?php if(in_array('Polio 4',$dtimunisasi)){echo 'Y';}else{if(in_array('Polio 4',$dtimunisasi_2)){echo 'Y';}else{echo "-";}}?></td>
						<td align="left"><?php if(in_array('PCV 1',$dtimunisasi)){echo 'Y';}else{if(in_array('PCV 1',$dtimunisasi_2)){echo 'Y';}else{echo "-";}}?></td>
						<td align="left"><?php if(in_array('PCV 2',$dtimunisasi)){echo 'Y';}else{if(in_array('PCV 2',$dtimunisasi_2)){echo 'Y';}else{echo "-";}}?></td>
						<td align="left"><?php if(in_array('PCV 3',$dtimunisasi)){echo 'Y';}else{if(in_array('PCV 3',$dtimunisasi_2)){echo 'Y';}else{echo "-";}}?></td>
						<td align="left"><?php if(in_array('IPV',$dtimunisasi)){echo 'Y';}else{if(in_array('IPV',$dtimunisasi_2)){echo 'Y';}else{echo "-";}}?></td>
						<td align="left"><?php if(in_array('CAMPAK RUBELLA',$dtimunisasi)){echo 'Y';}else{if(in_array('CAMPAK RUBELLA',$dtimunisasi_2)){echo 'Y';}else{echo "-";}}?></td>
						<td align="left"><?php if(in_array('BOOSTER CAMPAK RUBELLA',$dtimunisasi)){echo 'Y';}else{if(in_array('BOOSTER CAMPAK RUBELLA',$dtimunisasi_2)){echo 'Y';}else{echo "-";}}?></td>
						<td align="left"><?php if(in_array('BOOSTER DPT HB HiB',$dtimunisasi)){echo 'Y';}else{if(in_array('BOOSTER DPT HB HiB',$dtimunisasi_2)){echo 'Y';}else{echo "-";}}?></td>
						<td align="left"><?php echo $rujukinternal;?></td>
						<td align="left"><?php echo $ads005;?></td>
						<td align="left"><?php echo $ads05;?></td>
						<td align="left"><?php echo $ads5;?></td>
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