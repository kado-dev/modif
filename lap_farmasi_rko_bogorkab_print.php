<?php
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_report.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$namaprogram = $_GET['namaprogram'];
	$triwulan = $_GET['triwulan'];
	
	if($triwulan == ""){
		echo "<script>";
		echo "alert('Silahkan pilih periode triwulan...');";
		echo "document.location.href='index.php?page=lap_farmasi_rko_bogorkab&tahun=$tahun&namaprogram=$namaprogram';";
		echo "</script>";
		die();
	}
?>

<html lang="en">
<head>
	<title>Rko Program</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="assets/css/laporan_print.css" />
	
	<style>
		thead,th, td{
			text-align:center;border:1px solid #000; padding:3px;
		}
	</style>	
</head>

<!--<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_registrasi_umum&opsiform=<?php echo $_GET['opsiform'];?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>'">-->
<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_farmasi_rko_bogorkab&tahun=<?php echo $_GET['tahun'];?>&namaprogram=<?php echo $_GET['namaprogram'];?>'">
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN RKO (APBD & JKN)</b></span><br>
		<span class="font11" style="margin:1px;">Periode: <?php echo $bulan." - ".$tahun?></span>
	</div><br/>
	<div class="row font10">
		<div class="col-sm-12">
			<table class="table-judul-laporan-min">
				<thead style="font-size: 12px;">
					<tr style="border:1px sollid #000;">
						<th width="2%" rowspan="3">No</th>
						<th width="5%" rowspan="3">Kode</th>
						<th width="10%" rowspan="3">Nama Barang</th>
						<th width="4%" rowspan="3">Satuan</th>
						<th width="4%" rowspan="2">Harga Satuan</th>
						<th width="6%" colspan="2">Stok Awal <br/> <?php echo "Januari ".$tahun1?></th>
						<th width="6%" colspan="2">Penerimaan <br/> <?php echo $tahun1?></th>
						<th width="6%" rowspan="2">Total <br/>Persediaan <?php echo $tahun1?></th>
						<th width="6%" colspan="2">Pemakaian Rata2 <?php echo $tahun1?></th>
						<th width="6%" colspan="2">Sisa Stok <?php echo $tahun1?></th>
						<th width="6%" rowspan="2">Tingkat <br/>Kecukupan <?php echo $tahun?></th>
						<th width="6%" colspan="2">Total Kebutuhan <?php echo $tahun1?></th>
						<th width="6%" rowspan="2">Total <br/>Kebutuhan <?php echo $tahun1?></th>
						<th width="6%" rowspan="2">Rencana Pengadaan (Setelah Koreksi) <?php echo $tahun2?></th>
						<th width="6%" colspan="2">Rencana <br/>Pengadaan <?php echo $tahun2?></th>
						<th width="6%" colspan="2">Total Rupiah <br/>Pengadaan <?php echo $tahun2?></th>
					</tr>
					<tr style="border:1px sollid #000;">
						<th>APBD</th><!--Stok Awal-->
						<th>JKN</th>
						<th>APBD</th><!--Penerimaan-->
						<th>JKN</th>
						<th>APBD</th><!--Pemakaian rata-rata-->
						<th>JKN</th>
						<th>APBD</th><!--Sisa Stok-->
						<th>JKN</th>
						<th>APBD</th><!--Total Kebutuhan-->
						<th>JKN</th>
						<th>APBD</th><!--Rencana Pengadaan-->
						<th>JKN</th>
						<th>APBD</th><!--Total Rupiah Pengadaan-->
						<th>JKN</th>
					</tr>					
				</thead>
				<tbody style="font-size: 12px;">
					<?php
						$no = 0;
						
						if($namaprogram == "PKD"){
							$program = "PKD";
						}else if($namaprogram == "BMHP"){
							$program = "BMHP";
						}else if($namaprogram == "LABORATORIUM"){
							$program = "LABORATORIUM";	
						}
		
						$str = "SELECT * FROM `ref_obat_lplpo` WHERE `NamaProgram`='$program'";
						$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC";
						
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							if($namaprograms != $data['NamaProgram']){
								echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='23' style='text-align: left'>$data[NamaProgram]</td></tr>";
								$namaprograms = $data['NamaProgram'];
							}
							
							$no = $no + 1;
							$kodebarang = $data['KodeBarang'];
							$namabarang = $data['NamaBarang'];
							
							// tbstokawal
							$dtstokopname = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokopnam_puskesmas_detail` WHERE `KodeBarang`='$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
												
							?>
							<tr>
								<td style="text-align:right;"><?php echo $no;?></td>
								<td style="text-align:center;"><?php echo $kodebarang;?></td>
								<td style="text-align:left;" class="namabarangcls"><?php echo $namabarang;?></td>
								<td style="text-align:center;"><?php echo $data['Satuan'];?></td>
								<td style="text-align:right;"><?php echo rupiah($dtgfkstok['HargaBeli']);?></td>
								<td style="text-align:right;"><!--Stokawal-->
									<?php 
										if($dtstokopname['StokAwalApbd'] != 0){
											echo rupiah($dtstokopname['StokAwalApbd']);
										}else{
											echo "0";
										}
									?>
								</td>
								<td style="text-align:right;">
									<?php 
										if($dtstokopname['StokAwalJkn'] != 0){
											echo rupiah($dtstokopname['StokAwalJkn']);
										}else{
											echo "0";
										}
									?>
								</td>
								<td style="text-align:right;"><!--Penerimaan-->
									<?php 
										if($dtstokopname['PenerimaanApbd_total'] != 0){
											echo rupiah($dtstokopname['PenerimaanApbd_total']);
										}else{
											echo "0";
										}
									?>
								</td>
								<td style="text-align:right;">
									<?php 
										if($dtstokopname['PenerimaanJkn_total'] != 0){
											echo rupiah($dtstokopname['PenerimaanJkn_total']);
										}else{
											echo "0";
										}
									?>
								</td>
								<td style="text-align:right;"><!--Total Persediaan-->
									<?php 
										if($dtstokopname['Penerimaan_total'] != 0){
											echo rupiah($dtstokopname['Penerimaan_total']);
										}else{
											echo "0";
										}
									?>
								</td>
								<td style="text-align:right;"><!--Pemakaian rata-rata-->
									<?php 
										if($dtstokopname['PemakaianApbd_total'] != 0){
											echo rupiah($dtstokopname['PemakaianApbd_total'] / 12);
										}else{
											echo "0";
										}
									?>
								</td>
								<td style="text-align:right;">
									<?php 
										if($dtstokopname['PemakaianJkn_total'] != 0){
											echo rupiah($dtstokopname['PemakaianJkn_total'] / 12);
										}else{
											echo "0";
										}
									?>
								</td>
								<td style="text-align:right;"><!--Sisa Stok-->
									<?php 
										if($dtstokopname['SisaStokApbd_12'] != 0){
											echo rupiah($dtstokopname['SisaStokApbd_12']);
										}else{
											echo "0";
										}
									?>
								</td>
								<td style="text-align:right;">
									<?php 
										if($dtstokopname['SisaStokJkn_12'] != 0){
											echo rupiah($dtstokopname['SisaStokJkn_12']);
										}else{
											echo "0";
										}
									?>	
								</td>
								<td style="text-align:right;"><!--Tingkat Kecukupan-->
									<?php 
										
										$ttlsisastok = $dtstokopname['SisaStokApbd_12'] + $dtstokopname['SisaStokJkn_12'];
										$ttlpemakaian = $dtstokopname['PemakaianApbd_total'] / 12 + $dtstokopname['PemakaianJkn_total'] / 12;
										$kecukupan = @($ttlsisastok / $ttlpemakaian);
										
										if($ttlsisastok != 0 or $ttlpemakaian != 0){
											echo number_format($kecukupan,2);
										}else{
											echo 0;
										}								
												
									?>	
								</td>
								<td style="text-align:right;"><!--Total Kebutuhan-->
									<?php 
										$tkb1 = ($dtstokopname['PemakaianApbd_total'] / 12) * 18;
										$tkb2 = $dtstokopname['SisaStokApbd_12'];
										$ttlkebutuhan_Apbd = $tkb1 - $tkb2;									
										if($tkb1 != 0 or $tkb2 != 0){
											echo $ttlkebutuhan_Apbd;
										}else{
											echo 0;
										}	
									?>	
								</td>
								<td style="text-align:right;">
									<?php 
										$tkb1 = ($dtstokopname['PemakaianJkn_total'] / 12) * 18;
										$tkb2 = $dtstokopname['SisaStokJkn_12'];
										$ttlkebutuhan_Jkn = $tkb1 - $tkb2;									
										if($tkb1 != 0 or $tkb2 != 0){
											echo $ttlkebutuhan_Jkn;
										}else{
											echo 0;
										}
									?>	
								</td>
								<td style="text-align:right;"><!--Total Kebutuhan Apbd + Jkn-->
									<?php 
										echo $ttlkebutuhan_Apbd + $ttlkebutuhan_Jkn;	
									?>	
								</td>
								<td style="text-align:right; background-color:#dbf7ff;"><!--Rencana Pengadaan-->
									<?php 
										if($dtstokopname['RencanaPengadaanTerkoreksi'] != 0){
											echo rupiah($dtstokopname['RencanaPengadaanTerkoreksi']);
										}else{
											echo "0";
										}
									?>	
								</td>
								<td style="text-align:right;"><!--Rencana Pengadaan Apbd + Jkn-->
									<?php 
										echo "0";
									?>	
								</td>
								<td style="text-align:right;">
									<?php 
										echo "0";
									?>	
								</td>
								<td style="text-align:right;"><!--Total Rupiah Pengadaan-->
									<?php 
										echo "0";
									?>	
								</td>
								<td style="text-align:right;">
									<?php 
										echo "0";
									?>	
								</td>
							</tr>
					<?php
					}
					?>			
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>