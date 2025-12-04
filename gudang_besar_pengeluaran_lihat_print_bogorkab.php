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
	width: 55px !important;
	height: 65px;
	margin-left: 40px;
	margin-bottom: -50px;
	display: none;
}
.page {
  width: 25cm;
  height: 15cm;
  padding: 0.5cm;
  margin: 1cm auto;
  border: 1px #fff solid;
}

.page-footer-space {
  height: 80mm;
}

.footers_a4{
	bottom:2.5cm;
	left:0;
	right:0;
	position:fixed;
}
.footers_a5{
	bottom:1cm;
	left:0;
	right:0;
	position:fixed;
}		
	
@media print{
	.logokab{
		display:block;
	}
}
</style>

<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>SBBK</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
</head>

<div class="page">
<body onload="window.print()" onafterprint="document.location = 'index.php?page=gudang_besar_pengeluaran_lihat&id=<?php echo $id;?>&nf=<?php echo $nf;?>'">
	<?php
		$pengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfkpengeluaran` where `NoFaktur` = '$nf'"));
	?>
	<img src="image/bogorkab.png" class="logokab">
	<div class="printheader" style="margin-top: 0;">
		<span class="font16" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br/>
		<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br/>
		<span class="font10" style="margin:5px;"><?php echo $alamat.", Telp.".$telepon.", Fax.".$fax;?></span>
		<hr style="margin:10px 5px 5px 5px; border:1px solid #000">
		<span class="font16" style="margin:50px;"><b>SURAT BUKTI BARANG KELUAR</b></span><br/>
		<span class="font16" style="margin:1px;">No.Faktur: <?php echo $nf;?></span><br/>
	</div>

	<?php  
	$tgl = explode("-",$pengeluaran['TanggalPengeluaran']);
	$tgllaporan = $tgl[1] - 1;
	$tglpermintaan = $tgl[1];
	?>	
	
	<?php $datakecamatan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `namapuskesmas` = '$pengeluaran[Penerima]'")); ?>
	<div style="float:left; width:65%; margin-bottom:10px; font-family: 'Arial Narrow'">
		<table style="font-size: 12px;">
			<tr>
				<td style="padding:2px 4px;">Penerima </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo $pengeluaran['Penerima'];?></td>
			</tr>
			<?php
			if($pengeluaran['StatusPengeluaran'] == 'PUSKESMAS'){
			?>
			<tr>
				<td style="padding:2px 4px;">Kecamatan </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo strtoupper($datakecamatan['Kecamatan']);?></td>
			</tr>
			<?php
			}
			?>
		</table>
	</div>
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table  style="font-size: 12px;">
			<tr>
				<td style="padding:2px 4px;">Pelaporan Bulan</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"><?php echo strtoupper(nama_bulan($tgllaporan))." ".$tgllaporan[0];?></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;">Permintaan Bulan</td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"><?php echo $pengeluaran['Keterangan']?></td>
			</tr>
		</table>
	</div>	
	
	<div class="row font10">
		<div class="col-sm-12">
			<table class="table table-condensed" style="border-collapse: collapse;">
				<thead style="font-size:12px;">
					<tr style="border:1px solid #000;">
						<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
						<th rowspan="2" width="20%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NAMA BARANG</th>
						<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">SATUAN</th>
						<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">EXPIRE</th>
						<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">BATCH</th>
						<th colspan="4" width="30%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">PEMBERIAN</th>
					</tr>
					<tr style="border:1px solid #000;">
						<th width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">JML</th>
						<th width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">TERBILANG</th>
						<th width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">HARGA SAT.</th>
						<th width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">TOTAL HARGA</th>
					</tr>
				</thead>
				<tbody style="font-size:13px;">
					<?php
					$total = 0;
					$jumlah = 0;
					$no = 0;
					// $str = "SELECT * FROM `tbgfkpengeluarandetail` WHERE `Nofaktur`='$nf'";
					$str = "SELECT a.Id, a.IdDistribusi, a.NoFaktur, a.KodeBarang, b.NamaBarang, a.NoBatch, b.Satuan, b.Expire, b.SumberAnggaran, b.TahunAnggaran, b.HargaBeli, a.Jumlah, a.StatusValidasi, a.NamaProgram
					FROM `tbgfkpengeluarandetail` a 
					LEFT JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang WHERE a.NoFaktur = '$nf' AND a.NoBatch = b.NoBatch GROUP BY a.Id ORDER BY NamaBarang ";
					
					
					$query = mysqli_query($koneksi,$str);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$kdbrg = $data['KodeBarang'];
						$batch = $data['NoBatch'];						
						$jumlah = $data['HargaBeli'] * $data['Jumlah'];
						$total = $jumlah + $total;
					?>
						<tr style="border:1px solid #000;">
							<td align="right" style="border:1px solid #000; padding:3px;"><?php echo $no.".";?></td>
							<td align="left" style="border:1px solid #000; padding:3px;"><?php echo strtoupper($data['NamaBarang']);?></td>
							<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
							<td align="center" style="border:1px solid #000; padding:3px;"><?php echo date('d-m-Y', strtotime($data['Expire']));?></td>
							<td align="center" style="border:1px solid #000; padding:3px;"><?php echo str_replace(",", ", ", $data['NoBatch']);?></td>
							<td align="right" style="border:1px solid #000; padding:3px;"><?php echo rupiah($data['Jumlah']);?></td>
							<td align="right" style="border:1px solid #000; padding:3px;"><?php echo terbilang($data['Jumlah']);?></td>
							<td align="right" style="border:1px solid #000; padding:3px;"><?php echo "Rp. ".rupiah($data['HargaBeli']);?></td>
							<td align="right" style="border:1px solid #000; padding:3px;"><?php echo "Rp. ".rupiah($jumlah);?></td>
						</tr>
					<?php
					}
					?>
					<tr style="font-weight: bold;border:0px solid #000;">
						<td colspan="8" style="text-align:center; border:0px solid #000; padding:3px;background-color:#eee">TOTAL</td>
						<td style="text-align:right; border:0px solid #000; padding:3px;background-color:#f9f9f9"><?php echo "Rp. ".rupiah($total)?></td>
					</tr>
				</tbody>
				
				<?php
					// ini buat cetak jika obatnya lebih dari 3 item tandatangan gak ngeblok (tampil dihalaman terakhir)
					$jmlitem = mysqli_num_rows(mysqli_query($koneksi, "SELECT `Id` FROM `tbgfkpengeluarandetail` WHERE `NoFaktur`='$nf'"));
					if($jmlitem > 5){
				?>
				<tfoot style="border:0px">
					  <tr style="border:0px">
						<td style="border:0px">
						  <div class="page-footer-space"></div>
						</td>
					  </tr>
				</tfoot>
				<?php } ?>
			</table>
		</div>
		
		<?php
			// ini buat cetak jika obatnya lebih dari 3 item tandatangan gak ngeblok (tampil dihalaman terakhir)
			$jmlitem = mysqli_num_rows(mysqli_query($koneksi, "SELECT `Id` FROM `tbgfkpengeluarandetail` WHERE `NoFaktur`='$nf'"));
			if($jmlitem > 5){
		?>
		<div class="font10 footers_a4">
		<?php }else{ ?>
		<div class="font10 footers_a5">
		<?php }?>
			<table width="100%">
				<?php 
					$dt_penerima = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tb_user_profil_sbbk`"));
				?>
				<tr style="font-size: 14px; font-family: 'Arial Narrow';">
					<td style="text-align:center;">
						<p style="margin-top:5px;">Yang Menerima<br/>
						<?php echo $pengeluaran['Penerima'];?><br/>
						<span style="font-size: 16px; font-weight: bold"><?php echo $nf;?></span>
						<br>
						<br>
						<br>
						<br>
						<?php
						if($pengeluaran['PetugasPenerima'] == ""){
							echo "(____________________________)";
						}else{
							echo "( ".$pengeluaran['PetugasPenerima']." )";
						}
						?>						
						<p style="margin-left:-150px">Nip.</p></p>
						</p>
					</td>	
					<td width="10%"></td>
					<td style="text-align:center;">
						<p style="margin-top:5px;">Mengetahui,<br/>
						Kasie Kefarmasian
						<br>
						<br>
						<br>
						<br>
						<b><u><?php echo $dt_penerima['nama_kasie'];?></u></b><br/>
						<?php echo "NIP. ".$dt_penerima['nip_kasie'];?></p>
					</td>
					<td width="10%"></td>
					<td style="text-align:center;">
						<p style="margin-top:5px;"><?php echo "Kabupaten Bogor, ".date('d-m-Y', strtotime($pengeluaran['TanggalPengeluaran']));?><br/>
						Yang Menyerahkan
						<br>
						<br>
						<br>
						<br>
						<b><u><?php echo $dt_penerima['nama_pemberi'];?></u></b><br/>
						<?php echo "NIP. ".$dt_penerima['nip_pemberi'];?></p>
					</td>
				</tr>
			</table>
		</div>
	</div>
</body>
</div>
</html>