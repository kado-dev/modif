<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$namapgw = $_GET['namapgw']; 
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$loketobat = $_GET['loketobat'];
	$namapuskesmas = $_SESSION['namapuskesmas'];	
	$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
?>
<html>
<head>
	<title>Laporan Pemakaian Obat Harian</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/f_laporan.css">
</head>
<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_farmasi_apotik_pemakaian_obat_harian'">
<?php
$bulan = $_GET['bulan'];
$tahun = $_GET['tahun'];
$tbpasienrj = 'tbpasienrj_'.$bulan;
?>

<div class="row printheader">
	<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
	<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
	<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font11" style="margin:15px 5px 5px 5px;"><b><?php echo "LAPORAN PEMAKAIAN OBAT HARIAN (".$loketobat.")";?></b></span><br>
	<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></span><br/>
</div>

<div class="atastabel font11">
	<div style="float:left; width:65%; margin-bottom:10px;">
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;">Kode Puskesmas</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo $kodepuskesmas;?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Puskesmas</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo $namapuskesmas;?></td>
			</tr>
		</table><p/>
	</div>
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;">Kelurahan/Desa</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo $kelurahan;?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Kecamatan</td>
				<td style="padding:2px 4px;">:</td>
				<td style="padding:2px 4px;"><?php echo $kecamatan;?></td>
			</tr>
		</table>
	</div>
</div>

<div class="row font10">
	<div class="col-sm-12">
		<table class="table table-condensed">
			<thead class="font10">
					<tr style="border:1px solid #000;">
					<th style="text-align:center;width:1%;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
					<th style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">Kode</th>
					<th style="text-align:center;width:15%;vertical-align:middle; border:1px solid #000; padding:3px;">Nama Barang</th>
					<th style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Satuan</th>
				<?php
					$bln = $_GET['bulan'];
					$thn = $_GET['tahun'];
				
					$mulai = 1;
					$selesai = 31;
					for($d = $mulai;$d <= $selesai; $d++){	

				?>
					<th style="text-align:center;width:1%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $d;?></th>
				<?php
					}
				?>
					<th style="text-align:center;width:1%;vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</th>
				</tr>
			</thead>
			<tbody class="font10">
				<?php			
				$str = "SELECT a.KodeBarang, b.NamaBarang, b.Satuan
				FROM `tbgudangpkmstok` a
				JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang where a.KodePuskesmas = '$kodepuskesmas'";
				$str2 = $str." order by `NamaBarang` ASC";
				// echo $str2;
								
				// if($loketobat == 'semua'){
					// $loketobats = "";
				// }elseif($loketobat == 'POLI LANSIA'){
					// $loketobats = " AND b.Pelayanan = 'POLI LANSIA'";
				// }else{
					// $loketobats = " AND b.Pelayanan <> 'POLI LANSIA'";
				// }
				
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
				$no = $no + 1;
				?>
					<tr style="border:1px solid #000;">
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['KodeBarang'];?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaBarang'];?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
							<?php
								$jml2 = 0;	
								for($d2= $mulai;$d2 <= $selesai; $d2++){	
								$tanggal = $thn."-".$bln."-".$d2;
								$strs = "SELECT SUM(a.jumlahobat) as jumlah 
								FROM `$tbresepdetail` a 
								JOIN `$tbresep` b ON a.NoResep = b.NoResep 
								WHERE a.KodeBarang = '$data[KodeBarang]' AND b.TanggalResep = '$tanggal' AND SUBSTRING(a.NoResep,1,11)='$kodepuskesmas'".$loketobats;
								$jml = mysqli_fetch_assoc(mysqli_query($koneksi,$strs));
								$jml2 = $jml2 + $jml['jumlah'];
							?>	
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo round($jml['jumlah'],0);?></td>
							<?php
								}
							?>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo round($jml2,0);?></td>
					</tr>
				<?php
				}
				?>
					<tr style="border:1px solid #000;">
						<td style="text-align:right; border:1px solid #000; padding:3px;">#</td>
						<td style="text-align:right; border:1px solid #000; padding:3px;" colspan="2">Total</td>
					<?php
						$jmls = 0;
						for($d3= $mulai;$d3 <= $selesai; $d3++){	
						$tanggal = $thn."-".$bln."-".$d3;
						$strs2 = "SELECT SUM(a.jumlahobat) as jumlah
						FROM `$tbresepdetail` a
						JOIN `$tbresep` b ON a.NoResep = b.NoResep
						WHERE b.TanggalResep = '$tanggal' AND SUBSTRING(a.NoResep,1,11)='$kodepuskesmas'".$loketobats;	
						$countall = mysqli_fetch_assoc(mysqli_query($koneksi,$strs2));		
						$jmls = $jmls + $countall['jumlah'];
					?>	
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo round($countall['jumlah'],0);?></td>
					<?php
						}
					?>	
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo round($jmls,0);?></td>
					</tr>
			</tbody>
		</table>
	</div>
</div>
</body>
</html>