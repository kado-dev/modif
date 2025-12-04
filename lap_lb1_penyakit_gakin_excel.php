<?php
	include_once('config/koneksi.php');
	session_start();
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$kelurahan = $_SESSION['kelurahan'];
	$kecamatan = $_SESSION['kecamatan'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_LB1_Penyakit (Gakin) (".$hariini.").xls");
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
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN LB1-PENYAKIT (GAKIN)</b></h4>
	<p style="margin:1px;">
		<?php if($opsiform == 'bulan'){ ?>
			<p style="margin:1px;">Periode Laporan: <?php echo $bulan." / ".$tahun;?></p>
		<?php }else{ ?>
			<p style="margin:1px;">Periode Laporan: <?php echo $keydate1." s/d ".$keydate2;?></p>
		<?php } ?>
	</p><br/>
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
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kelurahan/Desa</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo $kelurahan;?></h5 ></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kecamatan</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">:</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo $kecamatan;?></h5 ></td>
			</tr>
		</table>
	</div>
</div>
<br/>
<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:9.5px;">
				<tr>
					<th rowspan="3">No.</th>
					<th rowspan="3">Kode</th>
					<th rowspan="3">Nama Penyakit</th>
					<th colspan="24">Jumlah Kasus Baru Menurut Golongan Umur</th>
					<th rowspan="2" colspan="3">Kasus Baru</th>
					<th rowspan="2" colspan="3">Kasus Lama</th>
					<th rowspan="3">Total Kasus</th>
				</tr>
				<tr>
					<th colspan="2">0-7Hr</th>
					<th colspan="2">8-30Hr</th>
					<th colspan="2"><1Th</th>
					<th colspan="2">1-4Th</th>
					<th colspan="2">5-9Th</th>
					<th colspan="2">10-14Th</th>
					<th colspan="2">15-19Th</th>
					<th colspan="2">20-44Th</th>
					<th colspan="2">45-54Th</th>
					<th colspan="2">55-59Th</th>
					<th colspan="2">60-69Th</th>
					<th colspan="2">>=70Th</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th>L</th><!--0-7Hr-->
					<th>P</th>
					<th>L</th><!--8-30Hr-->
					<th>P</th>
					<th>L</th><!--<1Th-->
					<th>P</th>
					<th>L</th><!--1-4Th-->
					<th>P</th>
					<th>L</th><!--5-9Th-->
					<th>P</th>
					<th>L</th><!--10-14Th-->
					<th>P</th>
					<th>L</th><!--15-19Th-->
					<th>P</th>
					<th>L</th><!--20-24Th-->
					<th>P</th>
					<th>L</th><!--45-54Th-->
					<th>P</th>
					<th>L</th><!--55-59Th-->
					<th>P</th>
					<th>L</th><!--60-69Th-->
					<th>P</th>
					<th>L</th><!--70Th-->
					<th>P</th>
					<th>L</th><!--Kasus Baru-->
					<th>P</th>
					<th>Jml</th>
					<th>L</th><!--Kasus Lama-->
					<th>P</th>
					<th>Jml</th>
				</tr>
			</thead>			
			<tbody style="font-size:10px;">
				<?php				
				if($opsiform == 'bulan'){
					$waktu = "YEAR(TanggalRegistrasi) = '$tahun'";
					$tbpasienrj = 'tbpasienrj_'.$bulan;
					$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
					$semua = " AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' ";
				}else{
					$waktu1 = "TanggalRegistrasi >= '$keydate1'";
					$waktu2 = "TanggalRegistrasi <= '$keydate2'";
					$tbpasienrj_1 = 'tbpasienrj_'.date('m',strtotime($keydate1));
					$tbpasienrj_2 = 'tbpasienrj_'.date('m',strtotime($keydate2));
					$tbdiagnosapasien_1 = 'tbdiagnosapasien_'.date('m',strtotime($keydate1));
					$tbdiagnosapasien_2 = 'tbdiagnosapasien_'.date('m',strtotime($keydate2));
				}
								
				$str = "SELECT * FROM `tbdiagnosa`";
				$str2 = $str."order by `KodeDiagnosa` ASC";
					
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
				$no = $no + 1;
				$kodedgs = $data['KodeDiagnosaBPJS'];
				
				if($opsiform == 'bulan'){
					$umur17hrL= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur17hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1830hrL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1830hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur12blnL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur12blnP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur14L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur14P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur59L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur59P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1014L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1014P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1519L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1519P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur2044L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur2044P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur4554L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur4554P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur5559L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur5559P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur6069L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur6069P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur70100L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur70100P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
				
					// kasus lama
					$lama_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama' AND a.Asuransi like '%BPJS PBI%'"));
					$lama_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `$tbdiagnosapasien` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama' AND a.Asuransi like '%BPJS PBI%'"));
					$t_lama_l = $lama_l['Jml'];
					$t_lama_p = $lama_p['Jml'];
					$total_lama = $t_lama_l + $t_lama_p;
				}else{
					// umur17hr
					$umur17hrL_1= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur17hrL_2= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur17hrL['Jml']= $umur17hrL_1['Jml'] + $umur17hrL_2['Jml'];
					$umur17hrP_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur17hrP_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur17hrP['Jml']= $umur17hrP_1['Jml'] + $umur17hrP_2['Jml'];
					// umur1830hr
					$umur1830hrL_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1830hrL_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur1830hrL['Jml']= $umur1830hrL_1['Jml'] + $umur1830hrL_2['Jml'];
					$umur1830hrP_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1830hrP_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur1830hrP['Jml']= $umur1830hrP_1['Jml'] + $umur1830hrP_2['Jml'];	
					// umur12bln
					$umur12blnL_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur12blnL_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur12blnL['Jml']= $umur12blnL_1['Jml'] + $umur12blnL_2['Jml'];
					$umur12blnP_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur12blnP_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur12blnP['Jml']= $umur12blnP_1['Jml'] + $umur12blnP_2['Jml'];
					// umur12bln
					$umur12blnL_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur12blnL_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur12blnL['Jml']= $umur12blnL_1['Jml'] + $umur12blnL_2['Jml'];
					$umur12blnP_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur12blnP_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur12blnP['Jml']= $umur12blnP_1['Jml'] + $umur12blnP_2['Jml'];
					// umur14th
					$umur14L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur14L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur14L['Jml']= $umur14L_1['Jml'] + $umur14L_2['Jml'];
					$umur14P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur14P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur14P['Jml']= $umur14P_1['Jml'] + $umur14P_2['Jml'];
					// umur59th
					$umur59L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur59L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur59L['Jml']= $umur59L_1['Jml'] + $umur59L_2['Jml'];
					$umur59P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur59P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur59P['Jml']= $umur59P_1['Jml'] + $umur59P_2['Jml'];
					// umur1014th
					$umur1014L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1014L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur1014L['Jml']= $umur1014L_1['Jml'] + $umur1014L_2['Jml'];
					$umur1014P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1014P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur1014P['Jml']= $umur1014P_1['Jml'] + $umur1014P_2['Jml'];
					// umur1519th
					$umur1519L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1519L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur1519L['Jml']= $umur1519L_1['Jml'] + $umur1519L_2['Jml'];
					$umur1519P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur1519P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur1519P['Jml']= $umur1519P_1['Jml'] + $umur1519P_2['Jml'];
					// umur2044th
					$umur2044L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur2044L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur2044L['Jml']= $umur2044L_1['Jml'] + $umur2044L_2['Jml'];
					$umur2044P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur2044P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur2044P['Jml']= $umur2044P_1['Jml'] + $umur2044P_2['Jml'];
					// umur4554th
					$umur4554L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur4554L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur4554L['Jml']= $umur4554L_1['Jml'] + $umur4554L_2['Jml'];
					$umur4554P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur4554P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur4554P['Jml']= $umur4554P_1['Jml'] + $umur4554P_2['Jml'];
					// umur5559th
					$umur5559L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur5559L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur5559L['Jml']= $umur5559L_1['Jml'] + $umur5559L_2['Jml'];
					$umur5559P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur5559P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur5559P['Jml']= $umur5559P_1['Jml'] + $umur5559P_2['Jml'];
					// umur6069th
					$umur6069L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur6069L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur6069L['Jml']= $umur6069L_1['Jml'] + $umur6069L_2['Jml'];
					$umur6069P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur6069P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur6069P['Jml']= $umur6069P_1['Jml'] + $umur6069P_2['Jml'];
					// umur70100th
					$umur70100L_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur70100L_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur70100L['Jml']= $umur70100L_1['Jml'] + $umur70100L_2['Jml'];
					$umur70100P_1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
					$umur70100P_2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua."AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru' AND a.Asuransi like '%BPJS PBI%'"));
						$umur70100P['Jml']= $umur70100P_1['Jml'] + $umur70100P_2['Jml'];
					// kasus lama
					$lama_l1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua." AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama' AND a.Asuransi like '%BPJS PBI%'"));
					$lama_l2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua." AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama' AND a.Asuransi like '%BPJS PBI%'"));
						$lama_l['Jml'] = $lama_l1['Jml'] + $lama_l2['Jml'];
					$lama_p1 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_1` a join `$tbdiagnosapasien_1` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu1".$semua." AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama' AND a.Asuransi like '%BPJS PBI%'"));
					$lama_p2 = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj_2` a join `$tbdiagnosapasien_2` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu2".$semua." AND b.KodeDiagnosa = '$kodedgs' AND a.UmurTahun Between '1' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama' AND a.Asuransi like '%BPJS PBI%'"));
						$lama_p['Jml'] = $lama_p1['Jml'] + $lama_p2['Jml'];
					$t_lama_l = $lama_l['Jml'];
					$t_lama_p = $lama_p['Jml'];
					$total_lama = $t_lama_l + $t_lama_p;
				}	
					// kasus baru
					$baru_l = $umur17hrL['Jml'] + $umur1830hrL['Jml'] + $umur12blnL['Jml'] + $umur14L['Jml'] + $umur59L['Jml']
						+ $umur1014L['Jml'] + $umur1519L['Jml'] + $umur2044L['Jml'] + $umur4554L['Jml'] + $umur5559L['Jml']
						+ $umur6069L['Jml'] + $umur70100L['Jml'];
					$baru_p = $umur17hrP['Jml'] + $umur1830hrP['Jml'] + $umur12blnP['Jml'] + $umur14P['Jml'] + $umur59P['Jml']
						+ $umur1014P['Jml'] + $umur1519P['Jml'] + $umur2044P['Jml'] + $umur4554P['Jml'] + $umur5559P['Jml']
						+ $umur6069P['Jml'] + $umur70100P['Jml'];
					$total_baru = $baru_l+ $baru_p;
					$total = $total_baru + $total_lama;
					
				?>
					<tr style="border:1px solid #000;">
						<td><?php echo $no;?></td>
						<td><?php echo $data['KodeDiagnosa'];?></td>
						<td><?php echo $data['NamaDiagnosa'];?></td>
						<td><?php echo $umur17hrL['Jml'];?></td>
						<td><?php echo $umur17hrP['Jml'];?></td>
						<td><?php echo $umur1830hrL['Jml'];?></td>
						<td><?php echo $umur1830hrP['Jml'];?></td>
						<td><?php echo $umur12blnL['Jml'];?></td>
						<td><?php echo $umur12blnP['Jml'];?></td>
						<td><?php echo $umur14L['Jml'];?></td>
						<td><?php echo $umur14P['Jml'];?></td>
						<td><?php echo $umur59L['Jml'];?></td>
						<td><?php echo $umur59P['Jml'];?></td>
						<td><?php echo $umur1014L['Jml'];?></td>
						<td><?php echo $umur1014P['Jml'];?></td>
						<td><?php echo $umur1519L['Jml'];?></td>
						<td><?php echo $umur1519P['Jml'];?></td>
						<td><?php echo $umur2044L['Jml'];?></td>
						<td><?php echo $umur2044P['Jml'];?></td>
						<td><?php echo $umur4554L['Jml'];?></td>
						<td><?php echo $umur4554P['Jml'];?></td>
						<td><?php echo $umur5559L['Jml'];?></td>
						<td><?php echo $umur5559P['Jml'];?></td>
						<td><?php echo $umur6069L['Jml'];?></td>
						<td><?php echo $umur6069P['Jml'];?></td>
						<td><?php echo $umur70100L['Jml'];?></td>
						<td><?php echo $umur70100P['Jml'];?></td>
						<!--kasus baru-->
						<td><?php echo $baru_l;?></td>
						<td><?php echo $baru_p;?></td>
						<td><?php echo $total_baru;?></td>
						<!--kasus lama-->
						<td><?php echo $lama_l['Jml'];?></td>
						<td><?php echo $lama_p['Jml'];?></td>
						<td><?php echo $total_lama;?></td>
						<!--total kasus baru + lama-->
						<td><?php echo $total;?></td>
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