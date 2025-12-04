<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper_pasienrj.php');
	include_once('config/helper_report.php');
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
    $bulan2 = $_GET['bulan2'];
	$bulanini = date('m');
	$tahun = $_GET['tahun'];
    $kodepkm = $_GET['kd'];
					
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan P2P ISPA (".$tahun.").xls");
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN P2P (ISPA)</b></h4>
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
		<table class="table-judul-laporan-min" width="100%" border="1">
            <thead>
                <tr>
                    <th rowspan="3">NO.</th>
                    <th rowspan="3" width="10%">NAMA PUSKESMAS</th>
                    <th colspan="3" width="10%">DATA SASARAN</th>							
                    <th colspan="4">PNEUMONIA</th>
                    <th colspan="4">PNEUMONIA BERAT</th>
                    <th colspan="7">JUMLAH</th>
                    <th rowspan="3">%</th>
                    <th colspan="5">BATUK BUKAN PNEUMONIA</th>
                    <th colspan="6">JML KEMATIAN BALITA KRN PNEUMONIA</th>
                    <th colspan="6">ISPA >5 TH</th>
                    <th rowspan="3">DIRUJUK</th>
                </tr>
                <tr>
                    <th rowspan="2">JML PDKK</th>
                    <th rowspan="2">JML PDKK BALITA (10% PDKK)</th>
                    <th rowspan="2">TARGET PENUMUAN PDKK PNEUMONIA</th>
                    <th colspan="2"> < 1 TH </th><!--Pneumonia-->
                    <th colspan="2">1-4 TH</th>
                    <th colspan="2"> < 1 TH </th><!--Pneumonia Berat-->
                    <th colspan="2">1-4 TH</th>
                    <th colspan="2"> < 1 TH </th><!--Jumlah-->
                    <th colspan="2">1-4 TH</th>
                    <th colspan="2">SUB TOTAL</th>
                    <th rowspan="2">TOTAL</th>
                    <th colspan="2"> < 1 TH </th><!--Bukan Pneumonia-->
                    <th colspan="2">1-4 TH</th>
                    <th rowspan="2">TOTAL</th>
                    <th colspan="2"> < 1 TH </th><!--Jml Kematian Balita Krn Penumonia-->
                    <th colspan="2">1-4 TH</th>
                    <th colspan="2">TOTAL</th>
                    <th colspan="3">BKN PNEUMONIA</th>
                    <th colspan="3">PNEUMONIA</th><!--ISPA >5 TH-->
                
                </tr>
                <tr style="border:1px dashed #000;">
                    <th>L</th><!--Pneumonia-->
                    <th>P</th>
                    <th>L</th>
                    <th>P</th>
                    <th>L</th><!--Pneumonia Berat-->
                    <th>P</th>
                    <th>L</th>
                    <th>P</th>
                    <th>L</th><!--Jumlah-->
                    <th>P</th>
                    <th>L</th>
                    <th>P</th>
                    <th>L</th>
                    <th>P</th>
                    <th>L</th><!--Bukan Pneumonia-->
                    <th>P</th>
                    <th>L</th>
                    <th>P</th>
                    <th>L</th><!--Jml Kematian Balita Krn Penumonia-->
                    <th>P</th>
                    <th>L</th>
                    <th>P</th>
                    <th>L</th>
                    <th>P</th>
                    <th>L</th><!--Pneumonia-->
                    <th>P</th>
                    <th>T</th>
                    <th>L</th><!--Bukan Pneumonia-->
                    <th>P</th>
                    <th>T</th>
                    
                </tr>
            </thead>
			<tbody>
                <?php
                // tbpuskesmas
                if($kodepkm == 'semua'){
                    $str = "SELECT * FROM `tbpuskesmas`";
                }else{
                    $str = "SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepkm'";
                }
                $str2 = $str." ORDER BY `NamaPuskesmas` ASC";
                                        
                $query = mysqli_query($koneksi,$str2);
                while($data = mysqli_fetch_assoc($query)){
                    $no = $no + 1;						
                    $kodepuskesmas = $data['KodePuskesmas'];
                    $namapuskesmas = $data['NamaPuskesmas'];
                    $tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
                    $tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
                    
                    // pneumonia
                    $ispa_0_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'L' AND UmurTahun = '0' AND KodeDiagnosa = 'J18.9'"));
                    $ispa_0_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'P' AND UmurTahun = '0' AND KodeDiagnosa = 'J18.9'"));
                    $ispa_1_4_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'L' AND UmurTahun BETWEEN '1' AND '4' AND KodeDiagnosa = 'J18.9'"));
                    $ispa_1_4_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'P' AND UmurTahun BETWEEN '1' AND '4' AND KodeDiagnosa = 'J18.9'"));
                    $ispa_0_Laki = $ispa_0_Laki_pneumonia['Jumlah'];
                    $ispa_1_4_Laki =  $ispa_1_4_Laki_pneumonia['Jumlah'];
                    $laki_pneumonia = $ispa_0_Laki + $ispa_1_4_Laki;
                    $ispa_0_perempuan = $ispa_0_Perempuan_pneumonia['Jumlah'];
                    $ispa_1_4_perempuan =  $ispa_1_4_Perempuan_pneumonia['Jumlah'];
                    $perempuan_pneumonia = $ispa_0_perempuan + $ispa_1_4_perempuan;
                    
                    // pneumonia_berat
                    $ispa_0_Laki_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'L' AND UmurTahun = '0' AND KodeDiagnosa = 'J18.0'"));
                    $ispa_0_Perempuan_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'P' AND UmurTahun = '0' AND KodeDiagnosa = 'J18.0'"));
                    $ispa_1_4_Laki_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'L' AND UmurTahun BETWEEN '1' AND '4' AND KodeDiagnosa = 'J18.0'"));
                    $ispa_1_4_Perempuan_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'P' AND UmurTahun BETWEEN '1' AND '4' AND KodeDiagnosa = 'J18.0'"));
                    $ispa_0_Laki_berat = $ispa_0_Laki_pneumonia_berat['Jumlah'];
                    $ispa_1_4_Laki_berat =  $ispa_1_4_Laki_pneumonia_berat['Jumlah'];
                    $laki_pneumonia_berat = $ispa_0_Laki_berat + $ispa_1_4_Laki_berat;			
                    $ispa_0_perempuan_berat = $ispa_0_Perempuan_pneumonia_berat['Jumlah'];
                    $ispa_1_4_perempuan_berat =  $ispa_1_4_Perempuan_pneumonia_berat['Jumlah'];
                    $perempuan_pneumonia_berat = $ispa_0_perempuan_berat + $ispa_1_4_perempuan_berat;
                    
                    // sub total
                    $jumlah_0_Laki = $ispa_1_4_Laki_pneumonia['Jumlah'];
                    $jumlah_1_4_Laki = $ispa_1_4_Laki_pneumonia_berat['Jumlah'];
                    $sublaki = $jumlah_0_Laki + $jumlah_1_4_Laki;			
                    $jumlah_0_perempuan = $ispa_1_4_Perempuan_pneumonia['Jumlah'];
                    $jumlah_1_4_perempuan = $ispa_1_4_Perempuan_pneumonia_berat['Jumlah'];
                    $subperempuan = $jumlah_0_perempuan + $jumlah_1_4_perempuan;
                
                    // total
                    $total  = $sublaki + $subperempuan;
                    
                    // batuk bukan pneumonia
                    $ispa_0_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'L' AND UmurTahun = '4' AND (KodeDiagnosa = 'J00' OR KodeDiagnosa like '%J06%')"));
                    $ispa_0_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'L' AND UmurTahun = '4' AND (KodeDiagnosa = 'J00' OR KodeDiagnosa like '%J06%')"));
                    $ispa_1_4_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'L' AND UmurTahun BETWEEN '1' AND '4' AND (KodeDiagnosa = 'J00' OR KodeDiagnosa like '%J06%')"));
                    $ispa_1_4_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'P' AND UmurTahun BETWEEN '1' AND '4' AND (KodeDiagnosa = 'J00' OR KodeDiagnosa like '%J06%')"));
                    $ttl_pneumonia_bukan = $ispa_0_Laki_pneumonia_bukan['Jumlah'] + $ispa_0_Perempuan_pneumonia_bukan['Jumlah'] + $ispa_1_4_Laki_pneumonia_bukan['Jumlah'] + $ispa_1_4_Perempuan_pneumonia_bukan['Jumlah'];
                    
                    // ispa > 5th bukan pneumonia
                    $ispa_5_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'L' AND UmurTahun >= '5' AND (KodeDiagnosa = 'J00' OR KodeDiagnosa like '%J06%')"));
                    $ispa_5_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'P' AND UmurTahun >= '5' AND (KodeDiagnosa = 'J00' OR KodeDiagnosa like '%J06%')"));
                    $ttl_5_pneumonia_bukan = $ispa_5_Laki_pneumonia_bukan['Jumlah'] + $ispa_5_Perempuan_pneumonia_bukan['Jumlah'];
                                            
                    // ispa > 5th pneumonia
                    $ispa_5_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'L' AND UmurTahun >= '5' AND KodeDiagnosa like '%J18%'"));
                    $ispa_5_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'P' AND UmurTahun >= '5' AND KodeDiagnosa like '%J18%'"));
                    $ttl_5_pneumonia = $ispa_5_Laki_pneumonia['Jumlah'] + $ispa_5_Perempuan_pneumonia['Jumlah'];
                    
                ?>
                    <tr style="border:1px dashed #000;">
                        <td><?php echo $no;?></td>
                        <td><?php echo $data['NamaPuskesmas'];?></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td><?php echo $ispa_0_Laki_pneumonia['Jumlah'];?></td>
                        <td><?php echo $ispa_0_Perempuan_pneumonia['Jumlah'];?></td>
                        <td><?php echo $ispa_1_4_Laki_pneumonia['Jumlah'];?></td>
                        <td><?php echo $ispa_1_4_Perempuan_pneumonia['Jumlah'];?></td>
                        <td><?php echo $ispa_0_Laki_pneumonia_berat['Jumlah'];?></td>
                        <td><?php echo $ispa_0_Perempuan_pneumonia_berat['Jumlah'];?></td>
                        <td><?php echo $ispa_1_4_Laki_pneumonia_berat['Jumlah'];?></td>
                        <td><?php echo $ispa_1_4_Perempuan_pneumonia_berat['Jumlah'];?></td>
                        <td><?php echo $laki_pneumonia;?></td>
                        <td><?php echo $perempuan_pneumonia;?></td>
                        <td><?php echo $laki_pneumonia_berat;?></td>
                        <td><?php echo $perempuan_pneumonia_berat;?></td>
                        <td><?php echo $sublaki;?></td>
                        <td><?php echo $subperempuan;?></td>
                        <td><?php echo $total;?></td>
                        <td>0</td>
                        <td><?php echo $ispa_0_Laki_pneumonia_bukan['Jumlah'];?></td>
                        <td><?php echo $ispa_0_Perempuan_pneumonia_bukan['Jumlah'];?></td>
                        <td><?php echo $ispa_1_4_Laki_pneumonia_bukan['Jumlah'];?></td>
                        <td><?php echo $ispa_1_4_Perempuan_pneumonia_bukan['Jumlah'];?></td>
                        <td><?php echo $ttl_pneumonia_bukan?></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td><?php echo $ispa_5_Laki_pneumonia_bukan['Jumlah'];?></td><!--ispa >5 tahun-->
                        <td><?php echo $ispa_5_Perempuan_pneumonia_bukan['Jumlah'];?></td>
                        <td><?php echo $ttl_5_pneumonia_bukan;?></td>
                        <td><?php echo $ispa_5_Laki_pneumonia['Jumlah'];?></td>
                        <td><?php echo $ispa_5_Perempuan_pneumonia['Jumlah'];?></td>
                        <td><?php echo $ttl_5_pneumonia;?></td>
                        <td>-</td>
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