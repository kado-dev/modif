<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$kecamatan = $_SESSION['kecamatan'];
	$kelurahan = $_SESSION['kelurahan'];
	$alamat = $_SESSION['alamat'];
	$tanggal = date('Y-m-d');
	// $tbpasienrj = 'tbpasienrj_'.$bulan;
	// $tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;	
	
	// filterdata
	$keydate = $_GET['keydate'];
	$opsiform = $_GET['opsiform'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Register_Poli_Gizi (".$hariini.").xls");
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
	<span class="font14" style="margin:1px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
	<span class="font14" style="margin:1px;"><b>DINAS KESEHATAN</b></span><br>
	<span class="font14" style="margin:1px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font10" style="margin:1px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER PASIEN POLI GIZI</b></span><br>
	<?php if($opsiform == 'bulan'){ ?>
	<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
	<?php }else{ ?>
	<span class="font11" style="margin:1px;">Periode Laporan: <?php echo $keydate;?></span>
	<?php } ?>
	<br/>
</div>

<div class=" atastabel font11">
	<div style="float:left; width:100%; margin-top:0px;">
		<table style="font-size:12px; width:300px;">
			<tr>
				<td colspan=2>Kode Puskesmas</td>
				<td><?php echo ": ".$kodepuskesmas;?></td>
			</tr>
			<tr>
				<td colspan=2>Puskesmas</td>
				<td><?php echo ": ".$namapuskesmas;?></td>
			</tr>
			<tr>
				<td colspan=2>Kelurahan/Desa</td>
				<td><?php echo ": ".strtoupper($kelurahan);?></td>
			</tr>
			<tr>
				<td colspan=2>Kecamatan</td>
				<td><?php echo ": ".strtoupper($kecamatan);?></td>
			</tr>
		</table>
	</div>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:10px;">
				<tr style="border:1px dashed #000;">
					<th rowspan="2" width="3%">No.</th>
					<th rowspan="2" width="6%">Tanggal</th>
					<th rowspan="2" width="5%">No.RM</th>
					<th rowspan="2" width="9%">Nama Anak</th>
					<th colspan="2" width="6%">Umur</th>
					<th rowspan="2" width="6%">Tgl.Lahir</th>
					<th rowspan="2" width="9%">Nama Ortu</th>
					<th rowspan="2" width="12%">Alamat</th>
					<th rowspan="2" width="6%">Tindakan</th>
					<th rowspan="2" width="4%">BB</th>
					<th rowspan="2" width="4%">TB</th>
					<th rowspan="2" width="4%">Temp</th>
					<th rowspan="2" width="4%">NTOB</th>
					<th colspan="3" width="12%">Status Gizi</th>
					<th rowspan="2" width="4%">ASI</th>
					<th rowspan="2" width="10%">Ket.</th>
				</tr>
				<tr style="border:1px dashed #000;">
					<th>L</th>
					<th>P</th>
					<th>BB/U</th>
					<th>BB/TB</th>
					<th>TB/U</th>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
				<?php
				if ($opsiform == 'bulan'){
					$tbpasienperpegawai = 'tbpasienperpegawai_'.$bulan;
					$tbpasienrj = 'tbpasienrj_'.$bulan;
					$tahun = $_GET['tahun'];
				}else{
					$tbpasienperpegawai = 'tbpasienperpegawai_'.date('m', strtotime($keydate));
					$tbpasienrj = 'tbpasienrj_'.date('m', strtotime($keydate));
					$tahun = date('Y', strtotime($keydate));
				}
				
				// insert ke tbpasienperpegawai_bulan
				$strpasienperpegawai = "SELECT * FROM `$tbpasienperpegawai` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(`TanggalRegistrasi`)='$tahun'";
				$querypasienperpegawai = mysqli_query($koneksi, $strpasienperpegawai);
				mysqli_query($koneksi, "DELETE FROM `tbpasienperpegawai_bulan` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'");
				while($datapspg = mysqli_fetch_assoc($querypasienperpegawai)){
					$strpasienperpegawaibulan = "INSERT INTO `tbpasienperpegawai_bulan`(`TanggalRegistrasi`,`NoRegistrasi`,`Pendaftaran`,`NamaPegawai1`,`NamaPegawai2`,`NamaPegawai3`,`NamaPegawai4`,`NamaPegawai5`,`Lab`,`Farmasi`) VALUES 
					('$datapspg[TanggalRegistrasi]','$datapspg[NoRegistrasi]','$datapspg[Pendaftaran]','$datapspg[NamaPegawai1]','$datapspg[NamaPegawai2]','$datapspg[NamaPegawai3]','$datapspg[NamaPegawai4]','$datapspg[NamaPegawai5]','$datapspg[Lab]','$datapspg[Farmasi]')";
					mysqli_query($koneksi, $strpasienperpegawaibulan);
				}
				
				// insert ke tbpasienrj_bulan
				$strpasienrj = "SELECT * FROM `$tbpasienrj` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(`TanggalRegistrasi`)='$tahun'";
				$querypasienrj = mysqli_query($koneksi, $strpasienrj);
				mysqli_query($koneksi, "DELETE FROM `tbpasienrj_bulan` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'");
				while($datapsrj= mysqli_fetch_assoc($querypasienrj)){
					$strpasienrjbulan = "INSERT INTO `tbpasienrj_bulan`(`TanggalRegistrasi`,`NoRegistrasi`,`NoIndex`,`NoCM`,`NamaPasien`,`JenisKelamin`,
					`UmurTahun`,`UmurBulan`,`UmurHari`,`JenisKunjungan`,`AsalPasien`,`StatusPasien`,`PoliPertama`,`Asuransi`,`StatusKunjungan`,`WaktuKunjungan`,`TarifKarcis`,
					`TarifKir`,`TotalTarif`,`StatusPelayanan`,`StatusPulang`,`NamaPegawaiSimpan`,`NamaPegawaiEdit`,`TanggalEdit`,`NoKunjunganBpjs`,`NoUrutBpjs`,`kdprovider`,
					`nokartu`,`kdpoli`,`Kir`) VALUES 
					('$datapsrj[TanggalRegistrasi]','$datapsrj[NoRegistrasi]','$datapsrj[NoIndex]','$datapsrj[NoCM]','$datapsrj[NamaPasien]',
					'$datapsrj[JenisKelamin]','$datapsrj[UmurTahun]','$datapsrj[UmurBulan]','$datapsrj[UmurHari]','$datapsrj[JenisKunjungan]','$datapsrj[AsalPasien]',
					'$datapsrj[StatusPasien]','$datapsrj[PoliPertama]','$datapsrj[Asuransi]','$datapsrj[StatusKunjungan]','$datapsrj[WaktuKunjungan]','$datapsrj[TarifKarcis]',
					'$datapsrj[TarifKir]','$datapsrj[TotalTarif]','$datapsrj[StatusPelayanan]','$datapsrj[StatusPulang]','$datapsrj[NamaPegawaiSimpan]','$datapsrj[NamaPegawaiEdit]'
					,'$datapsrj[TanggalEdit]','$datapsrj[NoKunjunganBpjs]','$datapsrj[NoUrutBpjs]','$datapsrj[kdprovider]','$datapsrj[nokartu]','$datapsrj[kdpoli]',
					'$datapsrj[Kir]')";
					mysqli_query($koneksi, $strpasienrjbulan);
				}
				
				if ($opsiform == 'bulan'){
					$str = "SELECT *
					FROM `tbpoligizi` WHERE SUBSTRING(NoPemeriksaan,1,11) = '$kodepuskesmas' AND MONTH(TanggalPeriksa) = '$bulan' AND
					YEAR(TanggalPeriksa) = '$tahun'";
				}else{
					$str = "SELECT * FROM `tbpoligizi` WHERE SUBSTRING(NoPemeriksaan,1,11) = '$kodepuskesmas' AND TanggalPeriksa = '$keydate'";
				}
				$str2 = $str." ORDER BY `TanggalPeriksa` DESC";
				// echo ($str2);
				// die();
				
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$noregistrasi = $data['NoPemeriksaan'];
					$noindex = $data['NoIndex'];
					$nocm = $data['NoCM'];
					$anamnesa = $data['Anamnesa'];
					$tindakan = $data['TindakanGizi'];
					
					// tbpasienrj
					$dt_pasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `UmurTahun`,`UmurBulan`,`NoRM`
					FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'"));
					if($dt_pasienrj['UmurTahun'] != '0'){
						$umur = $dt_pasienrj['UmurTahun']."Th";
					}else{
						$umur = $dt_pasienrj['UmurBulan']."Bl";
					}
					
					if ($dt_pasienrj['JenisKelamin'] == 'L'){
						$umur_l = $umur;
						$umur_p = "-";
					}else{
						$umur_l = "-";
						$umur_p = $umur;
					}
					
					// tbpasien, tanggal lahir
					$tbpasien = 'tbpasien_'.substr($noindex,14,4);
					$str_tlahir = "SELECT * FROM `$tbpasien` WHERE `NoCM`='$nocm'";
					$query_tlahir = mysqli_query($koneksi,$str_tlahir);
					$data_tlahir = mysqli_fetch_assoc($query_tlahir);
									
					// tbkk
					$str_kk = "SELECT `NamaKK`,`Alamat`,`RT`,`RW` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
					$query_kk = mysqli_query($koneksi,$str_kk);
					$data_kk = mysqli_fetch_assoc($query_kk);
					$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'];
					$telepon = $data_kk['Telepon'];
					
					// tbpasienperpegawai
					$dt_pasien_prpg = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaPegawai1`,`NamaPegawai2`
					FROM `tbpasienperpegawai_bulan` WHERE `NoRegistrasi` = '$noregistrasi'"));				
					if($dt_pasien_prpg['NamaPegawai1']!=''){
						$pemeriksa = $dt_pasien_prpg['NamaPegawai1'];
					}else{
						$pemeriksa = $dt_pasien_prpg['NamaPegawai2'];
					}
					
				?>
					<tr style="border:1px dashed #000;">
						<td><?php echo $no;?></td>
						<td><?php echo $data['TanggalPeriksa'];?></td>
						<td><?php echo substr($dt_pasienrj['NoRM'],-6);?></td>
						<td><?php echo $data['NamaPasien'];?></td>
						<td><?php echo $umur_l;?></td>
						<td><?php echo $umur_p;?></td>
						<td><?php echo $data_tlahir['TanggalLahir'];?></td>
						<td><?php echo $data_kk['NamaKK'];?></td>
						<td><?php echo $data_kk['Alamat'].", RT.".$data_kk['RT'].", RW.".$data_kk['RW'].", Telp.".$data_kk['Telepon'];?></td>
						<td><?php echo $tindakan;?></td>
						<td><?php echo $data['BeratBadan'];?></td>
						<td><?php echo $data['TinggiBadan'];?></td>
						<td><?php echo $data['SuhuTubuh'];?></td>
						<td><?php echo $data['Ntob'];?></td>
						<td><?php echo $data['Bbu'];?></td>
						<td><?php echo $data['Bbtb'];?></td>
						<td><?php echo $data['Tbu'];?></td>
						<td><?php echo $data['Asi'];?></td>
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