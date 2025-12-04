<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";

	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$namapgw = $_GET['namapgw'];
	$kinerja = $_GET['kinerja'];
	$namapgw = $_GET['namapgw'];

	// select tbpasienrj_retensi
	if($tahun == $tahunini){
		$tbpasienrj = $tbpasienrj;
	}else{
		$tbpasienrj = $tbpasienrj."_RETENSI";
	}
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Tracking Kinerja Pegawai (".$bulan.'-'.$tahun.").xls");
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN TRACKING KINERJA PEGAWAI</b></h4>
	<h4 style="margin:15px 5px 5px 5px;"><b><?php echo $namapgw;?></b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan : <?php echo $bulan."/".$tahun;?></p></p><br/>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr style="border:1px bordered #000;">
					<th width="3%">NO.</th>
					<th width="7%">TGL.PERIKSA</th>
					<th width="8%">NO.INDEX</th>
					<th width="15%">NAMA PASIEN</th>
					<th width="3%">L/P</th>
					<th width="7%">UMUR</th>
					<th width="10%">PELAYANAN</th>
					<th width="10%">CARA BAYAR</th>
					<th width="10%">ANAMNESA</th>
					<th width="8%">DIAGNOSA</th>
					<th width="13%">THERAPY</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($_GET['bulan']==''){
					$bulan= date('m');
				}else{
					$bulan= $_GET['bulan'];
				}
				
				if($_GET['tahun']==''){
					$tahun= date('Y');
				}else{
					$tahun= $_GET['tahun'];
				}
				
				if($_GET['kinerja']=='Semua'){
					$kinerja1= "`Pendaftaran` = '$namapgw' or `NamaPegawai1` = '$namapgw' or `NamaPegawai2` = '$namapgw' or `NamaPegawai3` = '$namapgw' or `Farmasi`='$namapgw'";
				}else if($_GET['kinerja']=='Daftar'){
					$kinerja1= "`Pendaftaran` = '$namapgw'";
				}else if($_GET['kinerja']=='Pelayanan'){
					$kinerja1= "`NamaPegawai1` = '$namapgw' or `NamaPegawai2` = '$namapgw' or `NamaPegawai3` = '$namapgw' or `Farmasi`='$namapgw'";
				}
				
				$strpasien = "SELECT * FROM `$tbpasienperpegawai` a WHERE (".$kinerja1.") AND MONTH(TanggalRegistrasi) = '$bulan' AND YEAR(TanggalRegistrasi) = '$tahun'";
				$str2 = $strpasien." order by `TanggalRegistrasi` Desc";
				// echo $strpasien;
								
				$querypasien = mysqli_query($koneksi,$str2);
				while($dtpasien = mysqli_fetch_assoc($querypasien)){
					$no = $no + 1;
					$dtpasienrj = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE NoRegistrasi='$dtpasien[NoRegistrasi]'"));
					
					if($dtpasienrj['PoliPertama'] == 'POLI GIGI'){
						$dtpasienpoli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpoligigi` WHERE NoPemeriksaan='$dtpasien[NoRegistrasi]'"));
						$anamnesa = $dtpasienpoli['Anamnesa'];
						$terapi = $dtpasienpoli['Terapi'];
						$diagnosa = json_decode($dtpasienpoli['Diagnosa']);
					}elseif($dtpasienrj['PoliPertama'] == 'POLI IMUNISASI'){
						$dtpasienpoli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpoliimunisasi` WHERE NoPemeriksaan='$dtpasien[NoRegistrasi]'"));
						$anamnesa = $dtpasienpoli['Anamnesa'];
						$terapi = $dtpasienpoli['Terapi'];
						$diagnosa = json_decode($dtpasienpoli['Diagnosa']);
					}elseif($dtpasienrj['PoliPertama'] == 'POLI KB'){
						$dtpasienpoli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpolikb` WHERE NoPemeriksaan='$dtpasien[NoRegistrasi]'"));
						$anamnesa = $dtpasienpoli['Anamnesa'];
						$terapi = $dtpasienpoli['Terapi'];
						$diagnosa = json_decode($dtpasienpoli['Diagnosa']);
					}elseif($dtpasienrj['PoliPertama'] == 'POLI KIA'){
						$dtpasienpoli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpolikia` WHERE NoPemeriksaan='$dtpasien[NoRegistrasi]'"));
						$anamnesa = $dtpasienpoli['Anamnesa'];
						$terapi = $dtpasienpoli['Terapi'];
						$diagnosa = json_decode($dtpasienpoli['Diagnosa']);
					}elseif($dtpasienrj['PoliPertama'] == 'POLI LANSIA'){
						$dtpasienpoli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpolilansia` WHERE NoPemeriksaan='$dtpasien[NoRegistrasi]'"));
						$anamnesa = $dtpasienpoli['Anamnesa'];
						$terapi = $dtpasienpoli['Terapi'];
						$diagnosa = json_decode($dtpasienpoli['Diagnosa']);
					}elseif($dtpasienrj['PoliPertama'] == 'POLI MTBS'){
						$dtpasienpoli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpolimtbs` WHERE NoPemeriksaan='$dtpasien[NoRegistrasi]'"));
						$anamnesa = $dtpasienpoli['Anamnesa'];
						$terapi = $dtpasienpoli['Terapi'];
						$diagnosa = json_decode($dtpasienpoli['Diagnosa']);
					}elseif($dtpasienrj['PoliPertama'] == 'POLI UMUM'){
						$tbpoliumum = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
						$dtpasienpoli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpoliumum` WHERE NoPemeriksaan='$dtpasien[NoRegistrasi]'"));
						$anamnesa = $dtpasienpoli['Anamnesa'];
						$terapi = $dtpasienpoli['Terapi'];
						$diagnosa = json_decode($dtpasienpoli['Diagnosa']);
					}elseif($dtpasienrj['PoliPertama'] == 'POLI UGD'){
						$dtpasienpoli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpolitindakan` WHERE NoPemeriksaan='$dtpasien[NoRegistrasi]'"));
						$anamnesa = $dtpasienpoli['Anamnesa'];
						$terapi = $dtpasienpoli['Terapi'];
						$diagnosa = json_decode($dtpasienpoli['Diagnosa']);
					}else{
						$anamnesa = '-';
						$terapi = '-';
						$diagnosa = '-';
					}
					
					// tbdiagnosapasien
					$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
					$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$dtpasien[NoRegistrasi]'";
					$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
					while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
						$array_data[$no][] = $data_diagnosapsn['KodeDiagnosa'];
					}
					if ($array_data[$no] != ''){
						$data_dgs = implode(",", $array_data[$no]);
					}else{
						$data_dgs ="";
					}
								
					$noindex = $dtpasienrj['NoIndex'];
					if(strlen($noindex) == 24){
						$noindex2 = substr($dtpasienrj['NoIndex'],14);
					}else{
						$noindex2 = $dtpasienrj['NoIndex'];
					} 
					
				?>
				
				<tr>
					<td style="text-align:center; border:1px bordered #000; padding:3px;"><?php echo $no;?></td>
					<td style="text-align:center; border:1px bordered #000; padding:3px;"><?php echo $dtpasien['TanggalRegistrasi'];?></td>
					<td style="text-align:center; border:1px bordered #000; padding:3px;"><?php echo $noindex2;?></td>
					<td style="text-align:left; border:1px bordered #000; padding:3px;"><?php echo $dtpasienrj['NamaPasien'];?></td>
					<td style="text-align:center; border:1px bordered #000; padding:3px;"><?php echo $dtpasienrj['JenisKelamin'];?></td>
					<td style="text-align:left; border:1px bordered #000; padding:3px;"><?php echo $dtpasienrj['UmurTahun']."Th ".$dtpasienrj['UmurBulan']."Bl";?></td>
					<td style="text-align:center; border:1px bordered #000; padding:3px;"><?php echo str_replace('POLI','', $dtpasienrj['PoliPertama']);?></td>
					<td style="text-align:center; border:1px bordered #000; padding:3px;"><?php echo $dtpasienrj['Asuransi'];?></td>
					<td style="text-align:left; border:1px bordered #000; padding:3px;"><?php echo $anamnesa;?></td>
					<td style="text-align:center; border:1px bordered #000; padding:3px;"><?php echo $data_dgs;?></td>
					<td style="text-align:left; border:1px bordered #000; padding:3px;">
						<?php
						if($dtpasienrj['PoliPertama'] == 'POLI IMUNISASI'){
							$terapi = '-';
						}else{
							// therapy
							$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
							$tbgudangpkmstok = "tbgudangpkmstok_".str_replace(' ', '', $namapuskesmas);
							$str_therapy = "SELECT * FROM `$tbresepdetail` WHERE `NoResep` = '$dtpasien[NoRegistrasi]' GROUP BY NoResep, KodeBarang";
							$query_therapy = mysqli_query($koneksi, $str_therapy);
							while($dt_therapy = mysqli_fetch_array($query_therapy)){
								$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT NamaBarang FROM `$tbgudangpkmstok` WHERE `KodeBarang` = '$dt_therapy[KodeBarang]'"));
								$array_therapy[$no][] = $dtobat['NamaBarang']." (".$dt_therapy['jumlahobat'].")";
							}
							if ($array_therapy[$no] != ''){
								$data_trp = implode(",", $array_therapy[$no]);
							}else{
								$data_trp ="";
							}
						}
						echo $data_trp;
						?>
					</td>
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