<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];
	$pelayanan = $_GET['pelayanan'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_LB1_Pelayanan (".$hariini.").xls");
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN LB1- DATA KESAKITAN POLI GIGI</b></h4>
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
					<th colspan="7">Kunjungan Kasus</th>
					<th colspan="18">Jumlah Kasus Baru Menurut olongan Umur</th>
					<th rowspan="2"  colspan="3">Total</th>
				</tr>
				<tr>
					<th colspan="2">Baru</th>
					<th colspan="2">Lama</th>
					<th colspan="3">Total</th>
					<th colspan="2">0-7Hr</th>
					<th colspan="2">8-30Hr</th>
					<th colspan="2"><1Th</th>
					<th colspan="2">1-4Th</th>
					<th colspan="2">5-14Th</th>
					<th colspan="2">15-44Th</th>
					<th colspan="2">45-54Th</th>
					<th colspan="2">55-64Th</th>
					<th colspan="2">>65</th>
				</tr>
				<tr style="border:1px dashed #000;">
					<th>L</th><!--Baru-->
					<th>P</th>
					<th>L</th><!--Lama-->
					<th>P</th>
					<th>L</th><!--Total-->
					<th>P</th>
					<th>Jml</th>
					<th>L</th><!--0-7Hr-->
					<th>P</th>
					<th>L</th><!--8-30Hr-->
					<th>P</th>
					<th>L</th><!--<1Th-->
					<th>P</th>
					<th>L</th><!--1-4Th-->
					<th>P</th>
					<th>L</th><!--5-14Th-->
					<th>P</th>
					<th>L</th><!--15-44Th-->
					<th>P</th>
					<th>L</th><!--45-54Th-->
					<th>P</th>
					<th>L</th><!--55-64Th-->
					<th>P</th>
					<th>L</th><!-- >65Th-->
					<th>P</th>
					<th>L</th><!--Total-->
					<th>P</th>
					<th>Jml</th>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
				<?php
					if($opsiform == 'bulan'){
						$waktu = "YEAR(TanggalRegistrasi) = '$tahun'";
						$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
						$semua = " AND SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND";
					}else{
						$waktu1 = "TanggalRegistrasi >= '$keydate1'";
						$waktu2 = "TanggalRegistrasi <= '$keydate2'";
						// $tbpasienrj_1 = 'tbpasienrj_'.date('m',strtotime($keydate1));
						// $tbpasienrj_2 = 'tbpasienrj_'.date('m',strtotime($keydate2));
						$tbpasienrj_1 = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
						$tbpasienrj_2 = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
						$tbdiagnosapasien_1 = 'tbdiagnosapasien_'.date('m',strtotime($keydate1));
						$tbdiagnosapasien_2 = 'tbdiagnosapasien_'.date('m',strtotime($keydate2));
					}
					
					if($pelayanan == 'POLI GIGI'){
						$str = "SELECT * FROM `tbdiagnosa` WHERE `KelompokDiagnosa` = 'Penyakit Sistem Pencernaan'";
					}else{
						$str = "SELECT * FROM `tbdiagnosa`";
					}
					$str2 = $str."order by `KodeDiagnosa`";
										
					if($pelayanan == 'Semua'){
						$ply = "";
					}else{
						$ply = " AND a.PoliPertama = '$pelayanan'";
					}	
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$kodedgs = '%'.$data['KodeDiagnosaBPJS']."%";
						// kasus
						$baru_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'".$ply));
						$baru_P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'".$ply));
						$lama_L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'".$ply));
						$lama_P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'".$ply));
						
						// total kasus
						$total_baru_l = $baru_L['Jml'] + $lama_L['Jml'];
						$total_baru_p = $baru_P['Jml'] + $lama_P['Jml'];
						$total_kasus = $total_baru_l + $total_baru_p;
						
						// umur17hr
						$umur17hrL= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'L'".$ply));
						$umur17hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'P'".$ply));
						$umur1830hrL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'L'".$ply));
						$umur1830hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'P'".$ply));
						$umur12blnL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L'".$ply));
						$umur12blnP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P'".$ply));
						$umur14L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'L'".$ply));
						$umur14P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'P'".$ply));
						$umur514L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '5' AND '14' AND a.JenisKelamin = 'L'".$ply));
						$umur514P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '5' AND '14' AND a.JenisKelamin = 'P'".$ply));
						$umur1544L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '15' AND '44' AND a.JenisKelamin = 'L'".$ply));
						$umur1544P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '15' AND '44' AND a.JenisKelamin = 'P'".$ply));
						$umur4554L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L'".$ply));
						$umur4554P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P'".$ply));
						$umur5564L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '55' AND '64' AND a.JenisKelamin = 'L'".$ply));
						$umur5564P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE ".$waktu.$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '55' AND '64' AND a.JenisKelamin = 'P'".$ply));
						$umur65100L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '65' AND '100' AND a.JenisKelamin = 'L'".$ply));
						$umur65100P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu".$semua." b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '65' AND '100' AND a.JenisKelamin = 'P'".$ply));
						
						// total
						$t_lama_l = $umur17hrL['Jml'] + $umur1830hrL['Jml'] + $umur12blnL['Jml'] + $umur14L['Jml'] + $umur514L['Jml'] + $umur1544L['Jml'] + $umur4554L['Jml'] + $umur5564L['Jml'] + $umur65100L['Jml'];
						$t_lama_p = $umur17hrP['Jml'] + $umur1830hrP['Jml'] + $umur12blnP['Jml'] + $umur14P['Jml'] + $umur514P['Jml'] + $umur1544P['Jml'] + $umur4554P['Jml'] + $umur5564P['Jml'] + $umur65100P['Jml'];
						$total = $t_lama_l + $t_lama_p;
				?>
					<tr style="border:1px dashed #000;">
						<td><?php echo $no;?></td>
						<td><?php echo $data['KodeDiagnosa'];?></td>
						<td><?php echo $data['NamaDiagnosa'];?></td>
						<td><?php echo $baru_L['Jml'];?></td>
						<td><?php echo $baru_P['Jml'];?></td>
						<td><?php echo $lama_L['Jml'];?></td>
						<td><?php echo $lama_P['Jml'];?></td>
						<td><?php echo $total_baru_l;?></td>
						<td><?php echo $total_baru_p;?></td>
						<td><?php echo $total_kasus;?></td>
						<td><?php echo $umur17hrL['Jml'];?></td>
						<td><?php echo $umur17hrP['Jml'];?></td>
						<td><?php echo $umur1830hrL['Jml'];?></td>
						<td><?php echo $umur1830hrP['Jml'];?></td>
						<td><?php echo $umur12blnL['Jml'];?></td>
						<td><?php echo $umur12blnP['Jml'];?></td>
						<td><?php echo $umur14L['Jml'];?></td>
						<td><?php echo $umur14P['Jml'];?></td>
						<td><?php echo $umur514L['Jml'];?></td>
						<td><?php echo $umur514P['Jml'];?></td>
						<td><?php echo $umur1544L['Jml'];?></td>
						<td><?php echo $umur1544P['Jml'];?></td>
						<td><?php echo $umur4554L['Jml'];?></td>
						<td><?php echo $umur4554P['Jml'];?></td>
						<td><?php echo $umur5564L['Jml'];?></td>
						<td><?php echo $umur5564P['Jml'];?></td>
						<td><?php echo $umur65100L['Jml'];?></td>
						<td><?php echo $umur65100P['Jml'];?></td>
						<td><?php echo $t_lama_l;?></td>
						<td><?php echo $t_lama_p;?></td>
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