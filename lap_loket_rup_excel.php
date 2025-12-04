<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	include_once('config/helper_pasienrj.php');
	$kota = $_SESSION['kota'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	// $asalpasien = $_GET['asalpasien'];
	// $statuspasien = $_GET['statuspasien'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Rup (".$hariini.").xls");
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
	font-family: "Trebuchet MS";
}
.printheader p{
	font-size:14px;
	font-family: "Trebuchet MS";
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTRASI UMUM PUSKESMAS</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo $bulan."/".$tahun;?></p><br/>
</div>

<div class="atastabel font14">
	<div style="float:left; width:65%; margin-bottom:0px;">
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5 style="margin:5px;">Kode Puskesmas</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo $kodepuskesmas;?></h5 ></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Puskesmas</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo $namapuskesmas;?></h5 ></td>
			</tr>
		</table>
	</div>
</div>
<br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr style="border:1px solid #000;">
					<th rowspan="3">TGL</th>
					<th rowspan="3">JML PASIEN</th>
					<th colspan="2">GENDER</th>
					<th colspan="24">GOLONGAN UMUR</th>
					<th colspan="8">PELAYANAN KESEHATAN</th>
					<th colspan="5">CARA BAYAR</th>
					<!-- <th colspan="6">WILAYAH</th> -->
				</tr>
				<tr style="border:1px solid #000;">
					<th rowspan="2">L</th>
					<th rowspan="2">P</th>
					<th colspan="2">0-7HR</th>
					<th colspan="2">8-30HR</th>
					<th colspan="2">1Bl-12BL</th>
					<th colspan="2">1-4TH</th>
					<th colspan="2">5-9TH</th>
					<th colspan="2">10-14TH</th>
					<th colspan="2">15-19TH</th>
					<th colspan="2">20-44TH</th>
					<th colspan="2">45-54TH</th>
					<th colspan="2">55-59TH</th>
					<th colspan="2">60-69TH</th>
					<th colspan="2">>70TH</th>
					<th rowspan="2">GIGI</th>
					<th rowspan="2">UGD</th>
					<th rowspan="2">KB</th>
					<th rowspan="2">KIA</th>
					<th rowspan="2">LANSIA</th>
					<th rowspan="2">MTBS</th>
					<th rowspan="2">TB</th>
					<th rowspan="2">UMUM</th>
					<th rowspan="2">BPJS <br/> NON PBI</th>
					<th rowspan="2">BPJS PBI</th>
					<th rowspan="2">GRATIS</th>
					<th rowspan="2">SKTM</th>
					<th rowspan="2">UMUM</th>
					<!-- <th colspan="3">DALAM</th>
					<th colspan="3">LUAR</th> -->
				</tr>
				<tr style="border:1px solid #000;">
					<th>B</th><!--0-7Hr-->
					<th>L</th>
					<th>B</th><!--8-30Hr-->
					<th>L</th>
					<th>B</th><!--1Bl-12Bl-->
					<th>L</th>
					<th>B</th><!--1-4Th-->
					<th>L</th>
					<th>B</th><!--5-9Th-->
					<th>L</th>
					<th>B</th><!--10-14Th-->
					<th>L</th>
					<th>B</th><!--15-19Th-->
					<th>L</th>
					<th>B</th><!--20-44Th-->
					<th>L</th>
					<th>B</th><!--45-54Th-->
					<th>L</th>
					<th>B</th><!--55-59Th-->
					<th>L</th>
					<th>B</th><!--60-69Th-->
					<th>L</th>
					<th>B</th><!--70Th-->
					<th>L</th>
					<!--<th>B</th>dalam wilayah
					<th>L</th>
					<th>JML</th>
					<th>B</th>luar wilayah
					<th>L</th>
					<th>JML</th>-->
				</tr>
			</thead>
			<tbody>
				<?php
				$tgl1 = $tahun.'-'.$bulan.'-01';
				$tgl2 = date('Y-m-t', strtotime($tgl1));
				$begin = new DateTime( $tgl1 );
				$end   = new DateTime( $tgl2 );
				for($i = $begin; $i <= $end; $i->modify('+1 day')){
					$tgl = $i->format("Y-m-d");						
					$jmlpsn = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl'"));
					$jmlpsn_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `JenisKelamin` = 'L'"));
					$jmlpsn_P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `JenisKelamin` = 'P'"));
					// golongan umur
					$jml07Hr_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` = '0' AND `UmurBulan`='0' AND `UmurHari` BETWEEN '0' AND '7' AND `StatusKunjungan`='Baru'"));
					$jml07Hr_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` = '0' AND `UmurBulan`='0' AND `UmurHari` BETWEEN '0' AND '7' AND `StatusKunjungan`='Lama'"));
					$jml0830Hr_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` = '0' AND `UmurBulan`='0' AND `UmurHari` BETWEEN '8' AND '30' AND `StatusKunjungan`='Baru'"));
					$jml0830Hr_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` = '0' AND `UmurBulan`='0' AND `UmurHari` BETWEEN '8' AND '30' AND `StatusKunjungan`='Lama'"));
					$jml0112Bl_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` = '0' AND `UmurBulan` BETWEEN '1' AND '12' AND `StatusKunjungan`='Baru'"));
					$jml0112Bl_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` = '0' AND `UmurBulan` BETWEEN '1' AND '12' AND `StatusKunjungan`='Lama'"));
					$jml14Th_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '1' AND '4' AND `StatusKunjungan`='Baru'"));
					$jml14Th_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '1' AND '4' AND `StatusKunjungan`='Lama'"));
					$jml59Th_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '5' AND '9' AND `StatusKunjungan`='Baru'"));
					$jml59Th_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '5' AND '9' AND `StatusKunjungan`='Lama'"));
					$jml1014Th_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '10' AND '14' AND `StatusKunjungan`='Baru'"));
					$jml1014Th_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '10' AND '14' AND `StatusKunjungan`='Lama'"));
					$jml1519Th_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '15' AND '19' AND `StatusKunjungan`='Baru'"));
					$jml1519Th_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '15' AND '19' AND `StatusKunjungan`='Lama'"));
					$jml2044Th_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '20' AND '44' AND `StatusKunjungan`='Baru'"));
					$jml2044Th_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '20' AND '44' AND `StatusKunjungan`='Lama'"));
					$jml4554Th_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '45' AND '54' AND `StatusKunjungan`='Baru'"));
					$jml4554Th_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '45' AND '54' AND `StatusKunjungan`='Lama'"));
					$jml5559Th_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '55' AND '59' AND `StatusKunjungan`='Baru'"));
					$jml5559Th_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '55' AND '59' AND `StatusKunjungan`='Lama'"));
					$jml6069Th_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '60' AND '69' AND `StatusKunjungan`='Baru'"));
					$jml6069Th_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '60' AND '69' AND `StatusKunjungan`='Lama'"));
					$jml70Th_B = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '70' AND '100' AND `StatusKunjungan`='Baru'"));
					$jml70Th_L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `UmurTahun` BETWEEN '70' AND '100' AND `StatusKunjungan`='Lama'"));
					// pelayanan kesehatan
					$p_gigi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI GIGI'"));
					$p_kb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI KB'"));
					$p_kia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI KIA'"));
					$p_lansia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI LANSIA'"));
					$p_mtbs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI MTBS'"));
					$p_tb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI TB DOTS'"));
					$p_ugd = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI UGD'"));
					$p_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tgl' AND `PoliPertama` = 'POLI UMUM'"));
					// cara bayar		
					$bpjs_nonpbi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj`
							WHERE date(TanggalRegistrasi)= '$tgl' and Asuransi = 'BPJS NON PBI'"));
					$bpjs_pbi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj`
							WHERE date(TanggalRegistrasi)= '$tgl' and (Asuransi like '%BPJS PBI%' OR Asuransi like '%BPJS%')"));
					$gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj`
							WHERE date(TanggalRegistrasi)= '$tgl' and Asuransi = 'GRATIS'"));
					$sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj`
							WHERE date(TanggalRegistrasi)= '$tgl' and Asuransi = 'SKTM'"));
					$umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj`
							WHERE date(TanggalRegistrasi)= '$tgl' and Asuransi = 'UMUM'"));
					// wilayah
					// $dalam_b = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.IdPasienrj) AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.Noindex = b.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.TanggalRegistrasi= '$tgl' and a.StatusKunjungan = 'Baru' and b.Wilayah = 'DALAM'"));
					// $dalam_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.IdPasienrj) AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.Noindex = b.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.TanggalRegistrasi= '$tgl' and a.StatusKunjungan = 'Lama' and b.Wilayah = 'DALAM'"));
					// $jml_dalam = $dalam_b['Jumlah'] + $dalam_l['Jumlah'];
					// $luar_b = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.IdPasienrj) AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.Noindex = b.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.TanggalRegistrasi= '$tgl' and a.StatusKunjungan = 'Baru' and b.Wilayah = 'LUAR'"));
					// $luar_l = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.IdPasienrj) AS Jumlah FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.Noindex = b.NoIndex WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' and a.TanggalRegistrasi= '$tgl' and a.StatusKunjungan = 'Lama' and b.Wilayah = 'LUAR'"));
					// $jml_luar = $luar_b['Jumlah'] + $luar_l['Jumlah'];
					// total					
					$totaljml_psn[] = $jmlpsn['Jumlah'];
					$totaljml_psn_L[] = $jmlpsn_L['Jumlah'];
					$totaljml_psn_P[] = $jmlpsn_P['Jumlah'];
					$totaljml_07Hr_B[] = $jml07Hr_B['Jumlah'];
					$totaljml_07Hr_L[] = $jml07Hr_L['Jumlah'];
					$totaljml_0830Hr_B[] = $jml0830Hr_B['Jumlah'];
					$totaljml_0830Hr_L[] = $jml0830Hr_L['Jumlah'];
					$totaljml_0112Bl_B[] = $jml0112Bl_B['Jumlah'];
					$totaljml_0112Bl_L[] = $jml0112Bl_L['Jumlah'];
					$totaljml_l14Th_B[] = $jml14Th_B['Jumlah'];
					$totaljml_l14Th_L[] = $jml14Th_L['Jumlah'];
					$totaljml_059Th_B[] = $jml59Th_B['Jumlah'];
					$totaljml_059Th_L[] = $jml59Th_L['Jumlah'];
					$totaljml_1014Th_B[] = $jml1014Th_B['Jumlah'];
					$totaljml_1014Th_L[] = $jml1014Th_L['Jumlah'];
					$totaljml_1519Th_B[] = $jml1519Th_B['Jumlah'];
					$totaljml_1519Th_L[] = $jml1519Th_L['Jumlah'];
					$totaljml_2044Th_B[] = $jml2044Th_B['Jumlah'];
					$totaljml_2044Th_L[] = $jml2044Th_L['Jumlah'];
					$totaljml_4554Th_B[] = $jml4554Th_B['Jumlah'];
					$totaljml_4554Th_L[] = $jml4554Th_L['Jumlah'];
					$totaljml_5559Th_B[] = $jml5559Th_B['Jumlah'];
					$totaljml_5559Th_L[] = $jml5559Th_L['Jumlah'];
					$totaljml_6069Th_B[] = $jml6069Th_B['Jumlah'];
					$totaljml_6069Th_L[] = $jml6069Th_L['Jumlah'];
					$totaljml_70Th_B[] = $jml70Th_B['Jumlah'];
					$totaljml_70Th_L[] = $jml70Th_L['Jumlah'];
					$totaljml_p_gigi[] = $p_gigi['Jumlah'];
					$totaljml_p_kb[] = $p_kb['Jumlah'];
					$totaljml_p_kia[] = $p_kia['Jumlah'];
					$totaljml_p_lansia[] = $p_lansia['Jumlah'];
					$totaljml_p_mtbs[] = $p_mtbs['Jumlah'];
					$totaljml_p_tb[] = $p_tb['Jumlah'];
					$totaljml_p_ugd[] = $p_ugd['Jumlah'];
					$totaljml_p_umum[] = $p_umum['Jumlah'];
					$totaljml_bpjs_nonpbi[] = $bpjs_nonpbi['Jumlah'];
					$totaljml_bpjs_pbi[] = $bpjs_pbi['Jumlah'];
					$totaljml_gratis[] = $gratis['Jumlah'];
					$totaljml_sktm[] = $sktm['Jumlah'];
					$totaljml_umum[] = $umum['Jumlah'];
					// $totaljml_dalam_b[] = $dalam_b['Jumlah'];
					// $totaljml_dalam_l[] = $dalam_l['Jumlah'];
					// $totaljml_jml_dalam[] = $jml_dalam;
					// $totaljml_luar_b[] = $luar_b['Jumlah'];
					// $totaljml_luar_l[] = $luar_l['Jumlah'];
					// $totaljml_jml_luar[] = $jml_luar;
				?>
					<tr style="border:1px solid #000;">
						<td><?php echo $i->format("d");?></td>	
						<td><?php echo $jmlpsn['Jumlah'];?></td>	
						<td><?php echo $jmlpsn_L['Jumlah'];?></td>	
						<td><?php echo $jmlpsn_P['Jumlah'];?></td>	
						<td><?php echo $jml07Hr_B['Jumlah'];?></td>	
						<td><?php echo $jml07Hr_L['Jumlah'];?></td>	
						<td><?php echo $jml0830Hr_B['Jumlah'];?></td>	
						<td><?php echo $jml0830Hr_L['Jumlah'];?></td>	
						<td><?php echo $jml0112Bl_B['Jumlah'];?></td>	
						<td><?php echo $jml0112Bl_L['Jumlah'];?></td>	
						<td><?php echo $jml14Th_B['Jumlah'];?></td>	
						<td><?php echo $jml14Th_L['Jumlah'];?></td>	
						<td><?php echo $jml59Th_B['Jumlah'];?></td>	
						<td><?php echo $jml59Th_L['Jumlah'];?></td>	
						<td><?php echo $jml1014Th_B['Jumlah'];?></td>	
						<td><?php echo $jml1014Th_L['Jumlah'];?></td>	
						<td><?php echo $jml1519Th_B['Jumlah'];?></td>	
						<td><?php echo $jml1519Th_L['Jumlah'];?></td>	
						<td><?php echo $jml2044Th_B['Jumlah'];?></td>	
						<td><?php echo $jml2044Th_L['Jumlah'];?></td>	
						<td><?php echo $jml4554Th_B['Jumlah'];?></td>	
						<td><?php echo $jml4554Th_L['Jumlah'];?></td>	
						<td><?php echo $jml5559Th_B['Jumlah'];?></td>	
						<td><?php echo $jml5559Th_L['Jumlah'];?></td>	
						<td><?php echo $jml6069Th_B['Jumlah'];?></td>	
						<td><?php echo $jml6069Th_L['Jumlah'];?></td>	
						<td><?php echo $jml70Th_B['Jumlah'];?></td>	
						<td><?php echo $jml70Th_L['Jumlah'];?></td>	
						<td><?php echo $p_gigi['Jumlah'];?></td>	
						<td><?php echo $p_ugd['Jumlah'];?></td>	
						<td><?php echo $p_kb['Jumlah'];?></td>	
						<td><?php echo $p_kia['Jumlah'];?></td>	
						<td><?php echo $p_lansia['Jumlah'];?></td>	
						<td><?php echo $p_mtbs['Jumlah'];?></td>	
						<td><?php echo $p_tb['Jumlah'];?></td>
						<td><?php echo $p_umum['Jumlah'];?></td>	
						<td><?php echo $bpjs_nonpbi['Jumlah'];?></td>	
						<td><?php echo $bpjs_pbi['Jumlah'];?></td>	
						<td><?php echo $gratis['Jumlah'];?></td>
						<td><?php echo $sktm['Jumlah'];?></td>
						<td><?php echo $umum['Jumlah'];?></td>	
						<!-- <td><?php echo $dalam_b['Jumlah'];?></td>	
						<td><?php echo $dalam_l['Jumlah'];?></td>	
						<td><?php echo $jml_dalam;?></td>	
						<td><?php echo $luar_b['Jumlah'];?></td>	
						<td><?php echo $luar_l['Jumlah'];?></td>	
						<td><?php echo $jml_luar;?></td>	 -->
					</tr>
				<?php
				}
				?>
				<tr style="border:1px solid #000;">
					<td></td>	
					<td><?php echo array_sum($totaljml_psn);?></td>	
					<td><?php echo array_sum($totaljml_psn_L);?></td>	
					<td><?php echo array_sum($totaljml_psn_P);?></td>	
					<td><?php echo array_sum($totaljml_07Hr_B);?></td>	
					<td><?php echo array_sum($totaljml_07Hr_L);?></td>	
					<td><?php echo array_sum($totaljml_0830Hr_B);?></td>
					<td><?php echo array_sum($totaljml_0830Hr_L);?></td>						
					<td><?php echo array_sum($totaljml_0112Bl_B);?></td>						
					<td><?php echo array_sum($totaljml_0112Bl_L);?></td>						
					<td><?php echo array_sum($totaljml_l14Th_B);?></td>						
					<td><?php echo array_sum($totaljml_l14Th_L);?></td>						
					<td><?php echo array_sum($totaljml_059Th_B);?></td>						
					<td><?php echo array_sum($totaljml_059Th_L);?></td>						
					<td><?php echo array_sum($totaljml_1014Th_B);?></td>						
					<td><?php echo array_sum($totaljml_1014Th_L);?></td>						
					<td><?php echo array_sum($totaljml_1519Th_B);?></td>						
					<td><?php echo array_sum($totaljml_1519Th_L);?></td>						
					<td><?php echo array_sum($totaljml_2044Th_B);?></td>						
					<td><?php echo array_sum($totaljml_2044Th_L);?></td>						
					<td><?php echo array_sum($totaljml_4554Th_B);?></td>						
					<td><?php echo array_sum($totaljml_4554Th_L);?></td>						
					<td><?php echo array_sum($totaljml_5559Th_B);?></td>						
					<td><?php echo array_sum($totaljml_5559Th_L);?></td>						
					<td><?php echo array_sum($totaljml_6069Th_B);?></td>						
					<td><?php echo array_sum($totaljml_6069Th_L);?></td>						
					<td><?php echo array_sum($totaljml_70Th_B);?></td>						
					<td><?php echo array_sum($totaljml_70Th_L);?></td>						
					<td><?php echo array_sum($totaljml_p_gigi);?></td>						
					<td><?php echo array_sum($totaljml_p_kb);?></td>						
					<td><?php echo array_sum($totaljml_p_kia);?></td>						
					<td><?php echo array_sum($totaljml_p_lansia);?></td>						
					<td><?php echo array_sum($totaljml_p_mtbs);?></td>	
					<td><?php echo array_sum($totaljml_p_tb);?></td>
					<td><?php echo array_sum($totaljml_p_ugd);?></td>					
					<td><?php echo array_sum($totaljml_p_umum);?></td>						
					<td><?php echo array_sum($totaljml_bpjs_nonpbi);?></td>						
					<td><?php echo array_sum($totaljml_bpjs_pbi);?></td>						
					<td><?php echo array_sum($totaljml_gratis);?></td>
					<td><?php echo array_sum($totaljml_sktm);?></td>				
					<td><?php echo array_sum($totaljml_umum);?></td>						
					<!-- <td><?php echo array_sum($totaljml_dalam_b);?></td>						
					<td><?php echo array_sum($totaljml_dalam_l);?></td>						
					<td><?php echo array_sum($totaljml_jml_dalam);?></td>						
					<td><?php echo array_sum($totaljml_luar_b);?></td>						
					<td><?php echo array_sum($totaljml_luar_l);?></td>						
					<td><?php echo array_sum($totaljml_jml_luar);?></td>						 -->
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php
}
?>