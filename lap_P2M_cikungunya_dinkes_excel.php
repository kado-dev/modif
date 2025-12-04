<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper_pasienrj.php');
	include_once('config/helper_report.php');
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$bulanini = date('m');
	$tahun = $_GET['tahun'];
					
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan P2P CIKUNGUNYA (".$tahun.").xls");
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
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo $namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN P2P (CIKUNGUNYA)</b></h4>
	<p style="margin:1px;">
		<?php if($bulan == 'Semua'){ ?>
			<p style="margin:1px;">Periode Laporan: <?php echo $tahun;?></p>
		<?php }else{ ?>
			<p style="margin:1px;">Periode Laporan: <?php echo $bulan."/".$tahun;?></p>
		<?php } ?>
	</p><br/>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table-judul-laporan-min" width="100%">
			<thead>
                <tr style="border:1px solid #000;">
                    <th rowspan="3" width="3%">NO.</th>
                    <th rowspan="3" width="17%">NAMA PUSKESMAS</th>
                    <th colspan="24">JUMLAH KASUS BARU MENURUT GOLONGAN UMUR</th>
                    <th rowspan="2"  colspan="3">TOTAL</th>
                </tr>
                <tr style="border:1px solid #000;">
                    <th colspan="2">0-7HR</th>
                    <th colspan="2">8-30HR</th>
                    <th colspan="2"><1TH</th>
                    <th colspan="2">1-4TH</th>
                    <th colspan="2">5-9TH</th>
                    <th colspan="2">10-14TH</th>
                    <th colspan="2">15-19TH</th>
                    <th colspan="2">20-44TH</th>
                    <th colspan="2">45-54TH</th>
                    <th colspan="2">55-59TH</th>
                    <th colspan="2">60-69TH</th>
                    <th colspan="2">>=70TH</th>
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
                    <th>JML</th>
                </tr>
			</thead>
			<tbody>
            <?php
                if($bulan == 'Semua'){
                    $waktu = "YEAR(TanggalDiagnosa) = '$tahun'";
                }else{
                    $waktu = "YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan'";
                } 

                $str = "SELECT * FROM `tbpuskesmas` WHERE `NamaPuskesmas` != 'DINAS KESEHATAN' AND `NamaPuskesmas` != 'UPTD FARMASI'";
                $str2 = $str."order by `NamaPuskesmas` ASC";                     

                $kodedgs = " AND (`KodeDiagnosa` = 'A92.0')";
                
                $query = mysqli_query($koneksi, $str2);
                while($data = mysqli_fetch_assoc($query)){
                    $no = $no + 1;
                    $kodepuskesmas = $data['KodePuskesmas'];
                    $namapuskesmas = $data['NamaPuskesmas'];
                    $tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
                     // umur 1-7 Hari
                    $umur17hrL= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between 1 AND 7 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
                    $umur17hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between 1 AND 7 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
                    // umur 1-2 Bulan
                    $umur1830hrL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between 8 AND 30 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
                    $umur1830hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs  AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between 8 AND 30 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
                    // umur 1-2 Bulan
                    $umur12blnL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun = '0' AND UmurBulan Between 2 AND 12 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
                    $umur12blnP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun = '0' AND UmurBulan Between 2 AND 12 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
                    // umur 1-4 Tahun
                    $umur14L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 1 AND 4 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
                    $umur14P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 1 AND 4 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
                    // umur 5-8 Tahun
                    $umur59L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs  AND UmurTahun Between 5 AND 9 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
                    $umur59P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 5 AND 9 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
                    // umur 10-14 Tahun
                    $umur1014L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 10 AND 14 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
                    $umur1014P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 10 AND 14 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
                    // umur 15-19 Tahun
                    $umur1519L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 15 AND 19 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
                    $umur1519P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 15 AND 19 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
                    // umur 20-44 Tahun
                    $umur2044L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 20 AND 44 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
                    $umur2044P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 20 AND 44 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
                    // umur 45-54 Tahun
                    $umur4554L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 45 AND 54 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
                    $umur4554P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 45 AND 54 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
                    // umur 55-59 Tahun
                    $umur5559L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 55 AND 59 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
                    $umur5559P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 55 AND 59 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
                    // umur 60-69 Tahun
                    $umur6069L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 60 AND 69 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
                    $umur6069P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 60 AND 69 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
                    // umur 70-100 Tahun
                    $umur70100L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 70 AND 100 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
                    $umur70100P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 70 AND 100 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
                    
                    // total kasus
                    $total_l = $umur17hrL['Jml'] + $umur1830hrL['Jml'] + $umur12blnL['Jml'] + $umur14L['Jml'] + $umur59L['Jml']
                        + $umur1014L['Jml'] + $umur1519L['Jml'] + $umur2044L['Jml'] + $umur4554L['Jml'] + $umur5559L['Jml']
                        + $umur6069L['Jml'] + $umur70100L['Jml'];
                    $total_p = $umur17hrP['Jml'] + $umur1830hrP['Jml'] + $umur12blnP['Jml'] + $umur14P['Jml'] + $umur59P['Jml']
                        + $umur1014P['Jml'] + $umur1519P['Jml'] + $umur2044P['Jml'] + $umur4554P['Jml'] + $umur5559P['Jml']
                        + $umur6069P['Jml'] + $umur70100P['Jml'];
                    $total = $total_l+ $total_p;
                    
                ?>
                    <tr style="border:1px solid #000;">
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
                        <td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namapuskesmas;?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur17hrL['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur17hrP['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1830hrL['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1830hrP['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur12blnL['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur12blnP['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur14L['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur14P['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur59L['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur59P['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1014L['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1014P['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1519L['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1519P['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur2044L['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur2044P['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4554L['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4554P['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur5559L['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur5559P['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur6069L['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur6069P['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur70100L['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur70100P['Jml'];?></td>
                        <!--total kasus-->
                        <td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total_l;?></td>
                        <td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total_p;?></td>
                        <td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total;?></td>
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