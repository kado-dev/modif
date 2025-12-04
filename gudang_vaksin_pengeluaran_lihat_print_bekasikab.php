<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$id = $_GET['id'];
	$nf = $_GET['nf'];
?>

<html lang="en">
<head>
	<title>SBBK</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
	<!--!font-->
	<link href="https://fonts.googleapis.com/css?family=Poppins|Ubuntu|Roboto+Condensed" rel="stylesheet">
	
	<style>
		body{
			font-family: "Roboto Condensed", Arial, sans-serif;	
		}	
		.logokab{
			width: 75px;
			height: 65px;
			margin-left: 40px;
			margin-bottom: -80px;
			display: none;
		}
		.page {
		  width: 21cm;
		  height: 25cm;
		  padding: 0.5cm;
		  margin: 1cm auto;
		  border: 1px #fff solid;
		}
		/*.page-footer-space {
			height: 220mm;
		}
		.footers{
			position:fixed;
			bottom:25mm;
			left:0;
			right:0;
		}*/	
		
		table.report-container {
		    page-break-after:always;
		}
		thead.report-header {
		    display:table-header-group;
		}
		tfoot.report-footer {
		    display:table-footer-group;
		} 
			
		@media print{
			.logokab{
				display:block;
			}
		}
	</style>
</head>

<div class="page">
<body onload="window.print()" onafterprint="document.location = 'index.php?page=gudang_vaksin_pengeluaran_lihat&id=<?php echo $id;?>&nf=<?php echo $nf;?>'">
	<?php
		$pengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbgfk_vaksin_pengeluaran` where `NoFaktur` = '$nf'"));
			
		// tb_user_profil_sbbk_penerima
		$dtpenerima = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tb_user_profil_sbbk_penerima` WHERE `NamaPegawai`='$pengeluaran[PetugasPenerima]'"));
	?>
	<img src="image/bekasikab.png" class="logokab">
	<div class="printheader" >
		<span class="font16" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br/>
		<span class="font24" style="margin:5px;"><b>UPTD FARMASI</b></span><br/>
		<span class="font12" style="margin:5px;"><?php echo $alamat;?></span><br/>
		<span class="font14" style="margin:5px;"><b>e-mail : laporangudangtambun@gmail.com Telp. </b><?php echo $telepon?></span>
		<hr style="margin:10px 5px 5px 5px; border:1px solid #000">
		<span class="font16" style="margin:50px;"><b>SURAT BUKTI BARANG KELUAR</b></span><br/>
		<span class="font14" style="margin:1px;">No.Faktur: <?php echo $nf;?></span><br/>
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
				<td style="padding:2px 4px;">Bulan </td>
				<td style="padding:2px 4px;"> : </td>
				<td style="padding:2px 4px;"> <?php echo nama_bulan(date("m", strtotime($pengeluaran['TanggalPengeluaran'])));?></td>
			</tr>
			<?php
			}
			?>
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
						<th width="12%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">TOTAL HARGA</th>
					</tr>
				</thead>
				<tbody style="font-size:13px;">
					<?php
					$total = 0;
					$jumlah = 0;
					$no = 0;
					$str = "SELECT * FROM `tbgfk_vaksin_pengeluarandetail` WHERE `Nofaktur`='$nf'";
					$query = mysqli_query($koneksi,$str);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$kdbrg = $data['KodeBarang'];
						$batch = $data['NoBatch'];						
						
						// tbgfk_vaksin_stok
						$dt_gfkstok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbgfk_vaksin_stok` WHERE `KodeBarang`='$kdbrg' AND `NoBatch`='$batch'"));
						$jumlah = $dt_gfkstok['HargaBeli'] * $data['Jumlah'];
						$total = $jumlah + $total;
					?>
						<tr style="border:1px solid #000;">
							<td align="right" style="border:1px solid #000; padding:3px;"><?php echo $no.".";?></td>
							<td align="left" style="border:1px solid #000; padding:3px;"><?php echo $dt_gfkstok['NamaBarang'];?></td>
							<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $dt_gfkstok['Satuan'];?></td>
							<td align="center" style="border:1px solid #000; padding:3px;"><?php echo date('d-m-Y', strtotime($dt_gfkstok['Expire']));?></td>
							<td align="center" style="border:1px solid #000; padding:3px;"><?php echo $data['NoBatch'];?></td>
							<td align="right" style="border:1px solid #000; padding:3px;"><?php echo rupiah($data['Jumlah']);?></td>
							<td align="right" style="border:1px solid #000; padding:3px;"><?php echo terbilang($data['Jumlah']);?></td>
							<td align="right" style="border:1px solid #000; padding:3px;"><?php echo "Rp. ".number_format($dt_gfkstok['HargaBeli'],2,",",".");?></td>
							<td align="right" style="border:1px solid #000; padding:3px;"><?php echo "Rp. ".number_format($jumlah,2,",",".");?></td>
						</tr>
					<?php
					}
					?>
					<tr style="font-weight: bold;border:0px solid #000;">
						<td colspan="8" style="text-align:center; border:0px solid #000; padding:3px;background-color:#eee">TOTAL</td>
						<td style="text-align:right; border:0px solid #000; padding:3px;background-color:#f9f9f9"><?php echo "Rp. ".number_format($total,2,",",".")?></td>
					</tr>
				</tbody>
				<tfoot style="border:0px">
					<table width="100%">
					<tr>
						<td class="report-footer-cell">
							<div class="footer-info">
								<center>
									<?php 
										$dt_penerima = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tb_user_profil_sbbk` WHERE `Periode`='3'"));
									?>
									<table width="100%">
										<tr style="font-size: 12px; font-family: 'Roboto Condensed', Arial, sans-serif;">
											<td style="text-align:center;">
												<p style="margin-top:15px;">Yang Menerima<br/>
												<span style="font-size: 12px;"><?php echo $pengeluaran['Penerima'];?></span>
												<br>
												<br>
												<br>
												<br>
												<p style="align:center;">
												<?php
													if($pengeluaran['PetugasPenerima'] == ""){
														echo "(____________________________)";
													}else{
														echo "<u><b>".$pengeluaran['PetugasPenerima']."</b></u><br/>";
														echo "Nip.".$dtpenerima['Nip'];
													}
												?>			
												</p>
											</td>	
											<td width="10%"></td>
											<td style="text-align:center;">
												<p>Mengetahui,<br/>
												Kepala UPTD Farmasi
												<br>
												<br>
												<br>
												<br>
												<br>
												<b><u><?php echo $dt_penerima['nama_kasie'];?></u></b><br/>
												<?php echo "NIP. ".$dt_penerima['nip_kasie'];?></p>
											</td>
											<td width="10%"></td>
											<td style="text-align:center;">
												<p><?php echo "Kabupaten Bekasi, ".date('d-m-Y', strtotime($pengeluaran['TanggalPengeluaran']));?><br/>
												Yang Menyerahkan Pengurus Barang
												<br>
												<br>
												<br>
												<br>
												<br>
												<b><u><?php echo $dt_penerima['nama_pemberi'];?></u></b><br/>
												<?php echo "NIP. ".$dt_penerima['nip_pemberi'];?></p>
											</td>
										</tr>
									</table>
								</center>
							</div>	
						</td>	
					</tr>	
					</table>
				</tfoot>
			</table>
		</div>
	</div>
</body>
</div>
</html>