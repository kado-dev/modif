<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$id = $_GET['id'];
	$nf = $_GET['nf'];
	$telepon = $_SESSION['telepon'];
	$fax = $_SESSION['fax'];
	
?>

<style>
body{
	font-family: "Arial Narrow";
	
}	
.logokab{
	width: 60px!important;
	height: 65px;
	margin-left: 40px;
	// margin-bottom: -70px;
	display: none;
}
.page {
  width: 25cm;
  height: 15cm;
  padding: 0.5cm;
  margin: 0.5cm auto;
  border: 1px #fff solid;
}

.page-footer-space {
  // height: 76mm;
}

.footers{
	position:fixed;
	bottom:10mm;
	left:0;
	right:0;
}	
	
@media print{
	.logokab{
		display:block;
	}
}
</style>

<html lang="en">
<head>
	<title>BAST</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<div class="page">
	<body onload="window.print()" onafterprint="document.location = 'index.php?page=gudang_vaksin_pengeluaran_lihat&id=<?php echo $_GET['id'];?>&nf=<?php echo $_GET['nf'];?>'">
	<img src="image/bogorkab.png" class="logokab">
	<div class="printheader">
		<span class="font16" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font16" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:10px; border:1px solid #000">
		<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN PENERIMAAN VAKSIN PUSKESMAS</b></span><br>
		<span class="font14" style="margin:15px 5px 5px 5px;"><i>(VACCINE ARRIVAL REPORT / VAR)</i></span><br>
	</div>

	<?php  
		$pengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfk_vaksin_pengeluaran` WHERE `NoFaktur` = '$nf'"));
		$tgl = explode("-",$pengeluaran['TanggalPengeluaran']);
		$tgllaporan = $tgl[1] - 1;
		$tglpermintaan = $tgl[1];
	?>
		
	<?php $datakecamatan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `namapuskesmas` = '$pengeluaran[Penerima]'")); ?>
	<div style="float:left; width:65%; margin-bottom:10px; font-family: 'Arial Narrow'">
		<table style="font-size: 12px;">
			<tr>
				<td style="padding:2px 4px;">PENERIMA </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $pengeluaran['Penerima'];?></td>
			</tr>
			<?php
			if($pengeluaran['StatusPengeluaran'] == 'PUSKESMAS'){
			?>
			<tr>
				<td style="padding:2px 4px;">TGL. PPENGELUARAN </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo date("d-m-Y", strtotime($pengeluaran['TanggalPengeluaran']));?></td>
			</tr>
			<?php
			}
			?>
		</table>
	</div>	
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table  style="font-size: 12px;">
			<tr>
				<td style="padding:2px 4px;">Nomor Faktur</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"><?php echo $nf;?></td>
			</tr>
		</table>
	</div>	
	<div class="row">
		<div class="col-sm-12">
			<table class="table table-condensed">
				<thead style="font-size:12px;">
					<tr style="border:1px solid #000;">
						<th rowspan="3" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
						<th rowspan="3" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NAMA BARANG</th>
						<th rowspan="3" width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">SATUAN</th>
						<th rowspan="3" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">JML</th>
						<th rowspan="3" width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">EXPIRE</th>
						<th rowspan="3" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">BATCH</th>
						<th colspan="9" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">SAAT DIKIRIM DARI KABUPATEN / KOTA</th>
						<th colspan="9" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">SAAT DITERIMA DI PUSKESMAS</th>
					</tr>
					<tr style="border:1px solid #000;">
						<!--Dikirim-->
						<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">KONDISI FREEZE TAG * (Y/T)</th>
						<th colspan="4" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">KONDISI VVM**</th>
						<th colspan="4" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">KONDISI VCCM**<br/>(WARNA BIRU)</th>
						<!--Diterima-->
						<th rowspan="2" width="4%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">KONDISI FREEZE TAG * (Y/T)</th>
						<th colspan="4" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">KONDISI VVM**</th>
						<th colspan="4" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">KONDISI VCCM**<br/>(WARNA BIRU)</th>
					</tr>
					<tr style="border:1px solid #000;">
						<!--Dikirim-->
						<th width="1%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">A</th><!--vvm-->
						<th width="1%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">B</th>
						<th width="1%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">C</th>
						<th width="1%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">D</th>
						<th width="1%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">A</th><!--vccm-->
						<th width="1%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">B</th>
						<th width="1%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">C</th>
						<th width="1%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">D</th>
						<!--Diterima-->
						<th width="1%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">A</th><!--vvm-->
						<th width="1%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">B</th>
						<th width="1%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">C</th>
						<th width="1%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">D</th>
						<th width="1%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">A</th><!--vccm-->
						<th width="1%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">B</th>
						<th width="1%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">C</th>
						<th width="1%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">D</th>
					</tr>
				</thead>
				<tbody style="font-size:13px;">
					<?php
					$qty = 0;
					$total = 0;
					$no = 0;
					$str = "SELECT * FROM `tbgfk_vaksin_pengeluarandetail` WHERE `Nofaktur`='$nf'";
					$query = mysqli_query($koneksi,$str);
					while($data = mysqli_fetch_assoc($query)){
						
						$kdbrg = $data['KodeBarang'];
						$batch = $data['NoBatch'];	
						
						// tbgfk_vaksin_stok
						$dt_gfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kdbrg' AND `NoBatch`='$batch'"));
						$jumlah = $dt_gfkstok['HargaBeli'] * $data['Jumlah'];
						$total = $jumlah + $total;
						
						if($data['IsiKemasan'] != 0){
							$qty = $data['Jumlah'] / $data['IsiKemasan'];
						}else{
							$qty = "-";
						}
						if($dt_gfkstok['NamaBarang'] != null){
							$no = $no + 1;
					?>
						<tr>
							<td align="center" style="border:1px solid #000; padding:0px;"><?php echo $no.".";?></td>
							<td align="left" style="border:1px solid #000; padding:0px;"><?php echo $dt_gfkstok['NamaBarang'];?></td>
							<td align="center" style="border:1px solid #000; padding:0px;"><?php echo $dt_gfkstok['Satuan'];?></td>
							<td align="center" style="border:1px solid #000; padding:0px;"><?php echo rupiah($data['Jumlah']);?></td>
							<td align="center" style="border:1px solid #000; padding:0px;"><?php echo tgl_singkat($dt_gfkstok['Expire']);?></td>
							<td align="center" style="border:1px solid #000; padding:0px;"><?php echo $data['NoBatch'];?></td>
							<!--Dikirim-->
							<td align="center" style="border:1px solid #000; padding:0px;"><?php echo $data['Freeze'];?></td>
							<td align="center" style="border:1px solid #000; padding:0px;"><?php if($data['Vvm']=="A"){ echo "A"; }else{ echo "-"; }?></td>
							<td align="center" style="border:1px solid #000; padding:0px;"><?php if($data['Vvm']=="B"){ echo "B"; }else{ echo "-"; }?></td>
							<td align="center" style="border:1px solid #000; padding:0px;"><?php if($data['Vvm']=="C"){ echo "C"; }else{ echo "-"; }?></td>
							<td align="center" style="border:1px solid #000; padding:0px;"><?php if($data['Vvm']=="D"){ echo "D"; }else{ echo "-"; }?></td>
							<td align="center" style="border:1px solid #000; padding:0px;"><?php if($data['Vccm']=="A"){ echo "A"; }else{ echo "-"; }?></td>
							<td align="center" style="border:1px solid #000; padding:0px;"><?php if($data['Vccm']=="B"){ echo "B"; }else{ echo "-"; }?></td>
							<td align="center" style="border:1px solid #000; padding:0px;"><?php if($data['Vccm']=="C"){ echo "C"; }else{ echo "-"; }?></td>
							<td align="center" style="border:1px solid #000; padding:0px;"><?php if($data['Vccm']=="D"){ echo "D"; }else{ echo "-"; }?></td>
							<!--Diterima-->
							<td align="center" style="border:1px solid #000; padding:0px;"></td>
							<td align="center" style="border:1px solid #000; padding:0px;"></td>
							<td align="center" style="border:1px solid #000; padding:0px;"></td>
							<td align="center" style="border:1px solid #000; padding:0px;"></td>
							<td align="center" style="border:1px solid #000; padding:0px;"></td>
							<td align="center" style="border:1px solid #000; padding:0px;"></td>
							<td align="center" style="border:1px solid #000; padding:0px;"></td>
							<td align="center" style="border:1px solid #000; padding:0px;"></td>
							<td align="center" style="border:1px solid #000; padding:0px;"></td>
						</tr>
					<?php
						}
					}
					?>
				</tbody>
			</table>
			<table width="50%" style="font-size: 12px;">
				<tr>
					<td colspan="3"><b>URAIAN KEDATANGAN</b></td>
				</tr>
				<tr>
					<td width="55%">NOMOR KENDARAAN / NOPOL</td>
					<td width="5%">:</td>
					<td width="40%"></td>
				</tr>
				<tr>
					<td>NOMOR INSTANSI / PERUSAHAAN PENGANTAR</td>
					<td>:</td>
					<td></td>
				</tr>
			</table><br/>
		</div>
		<div class="font10 footers">
			<table width="100%">
				<tr style="font-size: 14px;">
					<td style="text-align:center;">
					KEPALA PUSKESMAS
					<br>
					<br>
					<br>
					(_______________________)
					</td>
					<td width="10%"></td>
					<td style="text-align:center;">
					DITERIMA OLEH,
					<br>
					<br>
					<br>
					<?php echo strtoupper($pengeluaran['PetugasPenerima']);?>
					</td>
					<td width="10%"></td>
					<td style="text-align:center;">
						<p><?php echo "Kabupaten Bogor, ".date('d-m-Y', strtotime($pengeluaran['TanggalPengeluaran']));?><br/>
						Yang Menyerahkan
						<br>
						<br>
						<br>
						<b><u>Rizki Aji Nugraha, A.md.Farm</u></b><br/>
						199511302019021002</p>
					</td>
				</tr>
			</table>
		</div>
	</div>
	</body>
</div>
</html>