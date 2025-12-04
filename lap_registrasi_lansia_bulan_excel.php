<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Bulanan_Lansia (".$namapuskesmas.").xls");
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN BULANAN LANSIA</b></h4>
	<p style="margin:1px;">
		<?php if($opsiform == 'bulan'){ ?>
			<p style="margin:1px;">Periode Laporan: <?php echo $bulan."/".$tahun;?></p>
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
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".$kodepuskesmas;?></h5 ></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Puskesmas</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".$namapuskesmas;?></h5 ></td>
			</tr>
		</table>
	</div>
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kelurahan/Desa</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".$kelurahan;?></h5 ></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kecamatan</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".$kecamatan;?></h5 ></td>
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
					<th rowspan="3" width="5%">No.</th>
					<th rowspan="3" width="35%">Kegiatan</th>
					<th colspan="8"  width="60%">Kelompok Umur</th>
				</tr>
				<tr>
					<th colspan="2">45-59Th</th>
					<th colspan="2">60-69Th</th>
					<th colspan="2">>70Th</th>
					<th colspan="2">Total</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th>L</th><!--45-59Th-->
					<th>P</th>
					<th>L</th><!--60-69Th-->
					<th>P</th>
					<th>L</th><!--70th-->
					<th>P</th>
					<th>L</th><!--Total-->
					<th>P</th>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
				<?php					
				if($opsiform == 'bulan'){
					$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
				}else{
					$waktu1 = "TanggalRegistrasi >= '$keydate1'";
					$waktu2 = "TanggalRegistrasi <= '$keydate2'";
				}
									
				$str = "SELECT * FROM `tbkegiatanlblansia` order by `NoUrut`";
				$query = mysqli_query($koneksi,$str);
				while($data = mysqli_fetch_assoc($query)){
					$kodekegiatan = $data['KodeKegiatan'];
					$kegiatan = $data['Kegiatan'];
				
					if($data['KodeKelompok'] == '8' || $data['KodeKelompok'] == '9' || $data['KodeKelompok'] == '10' || $data['KodeKelompok'] == '11' || $data['KodeKelompok'] == '12' || $data['KodeKelompok'] == '13' || $data['KodeKelompok'] == '14'){
						echo "<tr style='border:1px solid #000;'><td style='text-align:right; border:1px solid #000; padding:3px;'>$data[KodeKelompok]</td>
							<td colspan='9' style='text-align:left; border:1px solid #000; padding:3px;'>$data[Kelompok]</td></tr>";
					}
				?>
						
					<tr style="border:1px solid #000;">
						<td><?php echo $kodekegiatan;?></td>
						<td><?php echo $kegiatan;?></td>
						<?php
							$umur4559_L= 0;
							$umur4559_P= 0;
							$umur6069_L= 0;
							$umur6069_P= 0;
							$umur70_L= 0;
							$umur70_P= 0;
							if($opsiform == 'bulan'){
								if($kegiatan == 'Jumlah semua lansia yg ada diwilayah posbindu / kelompok (s)'){
									
								}elseif($kegiatan == 'Jumlah Lansia yang terdaftar & dibina'){
									
								}elseif($kegiatan == 'Jumlah Lansia yang mempunyai KMS'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.MempunyaiKms = 'YA' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.MempunyaiKms = 'YA' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.MempunyaiKms = 'YA' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.MempunyaiKms = 'YA' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.MempunyaiKms = 'YA' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.MempunyaiKms = 'YA' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'Jumlah Lansia yang datang / diperiksa'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoRegistrasi FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoRegistrasi,1,11)='$kodepuskesmas' AND PoliPertama='POLI LANSIA' AND UmurTahun Between '45' AND '59' AND JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoRegistrasi FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoRegistrasi,1,11)='$kodepuskesmas' AND PoliPertama='POLI LANSIA' AND UmurTahun Between '45' AND '59' AND JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoRegistrasi FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoRegistrasi,1,11)='$kodepuskesmas' AND PoliPertama='POLI LANSIA' AND UmurTahun Between '60' AND '69' AND JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoRegistrasi FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoRegistrasi,1,11)='$kodepuskesmas' AND PoliPertama='POLI LANSIA' AND UmurTahun Between '60' AND '69' AND JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoRegistrasi FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoRegistrasi,1,11)='$kodepuskesmas' AND PoliPertama='POLI LANSIA' AND UmurTahun Between '70' AND '100' AND JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoRegistrasi FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoRegistrasi,1,11)='$kodepuskesmas' AND PoliPertama='POLI LANSIA' AND UmurTahun Between '70' AND '100' AND JenisKelamin = 'P'"));
								}elseif($kegiatan == 'Jumlah Lansia yang normal / sehat'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'Jumlah Lansia yang dirujuk ke Rumah Sakit'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusPulang = '4' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusPulang = '4' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusPulang = '4' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusPulang = '4' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusPulang = '4' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusPulang = '4' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'A. Kategori A'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'A' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'A' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'A' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'A' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'A' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'A' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'B. Kategori B'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'B' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'B' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'B' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'B' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'B' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'B' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'C. Kategori C'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'C' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'C' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'C' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'C' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'C' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.Kemandirian = 'C' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'A. Emosional Ada'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'YA' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'YA' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'YA' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'YA' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'YA' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'YA' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'B. Emosional Tidak ada'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'TIDAK' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'TIDAK' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'TIDAK' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'TIDAK' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'TIDAK' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.GangguanEmosional = 'TIDAK' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'A. IMT Lebih'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'L' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'L' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'L' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'L' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'L' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'L' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'B. IMT Normal'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'N' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'N' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'N' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'N' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'N' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'N' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'C. IMT Kurang'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'K' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'K' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'K' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'K' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'K' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.IMT = 'K' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'A. TD Tinggi'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'T' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'T' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'T' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'T' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'T' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'T' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'B. TD Normal'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'N' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}elseif($kegiatan == 'C. TD Rendah'){
									$umur4559_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'R' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'L'"));
									$umur4559_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'R' AND b.UmurTahun Between '45' AND '59' AND b.JenisKelamin = 'P'"));
									$umur6069_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'R' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'L'"));
									$umur6069_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'R' AND b.UmurTahun Between '60' AND '69' AND b.JenisKelamin = 'P'"));
									$umur70_L= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'R' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'L'"));
									$umur70_P= mysqli_num_rows(mysqli_query($koneksi,"SELECT NoPemeriksaan FROM `$tbpolilansia` a JOIN `$tbpasienrj` b on a.NoPemeriksaan = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND Substring(NoPemeriksaan,1,11)='$kodepuskesmas' AND a.StatusTekananDarah = 'R' AND b.UmurTahun Between '70' AND '100' AND b.JenisKelamin = 'P'"));
								}
								$total_L = $umur4559_L + $umur6069_L + $umur70_L;
								$total_P = $umur4559_P + $umur6069_P + $umur70_P;
							}else{
								
							}
						?>
						<td><?php echo $umur4559_L;?></td>
						<td><?php echo $umur4559_P;?></td>
						<td><?php echo $umur6069_L;?></td>
						<td><?php echo $umur6069_P;?></td>
						<td><?php echo $umur70_L;?></td>
						<td><?php echo $umur70_P;?></td>
						<td><?php echo $total_L;?></td>
						<td><?php echo $total_P;?></td>
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