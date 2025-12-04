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
	$opsiform = $_GET['opsiform'];
	$triwulan = $_GET['triwulan'];
	
	if($triwulan == ""){
		echo "<script>";
		echo "alert('Silahkan pilih periode triwulan...');";
		echo "document.location.href='index.php?page=lap_farmasi_stok_opname_triwulan';";
		echo "</script>";
		die();
	}
?>

<html lang="en">
<head>
	<title>Stok Opname Triwulan</title>
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
<body onload="window.print()" onafterprint="document.location = 'index.php?page=lap_farmasi_stok_opname_triwulan&triwulan=<?php echo $_GET['triwulan'];?>&tahun=<?php echo $_GET['tahun'];?>'">
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN STOK OPNAME TRIWULAN</b></span><br>
		<span class="font11" style="margin:1px;">Triwulan: <?php echo $triwulan." - ".$tahun?></span>
	</div><br/>
	<div class="row font10">
		<div class="col-sm-12">
			<table class="table-judul-laporan-min">
				<thead style="font-size: 12px;">
					<tr>
						<th width="2%" rowspan="2">No.</th>
						<th width="5%" rowspan="2">Kode</th>
						<th width="12%" rowspan="2">Nama Barang</th>
						<th width="4%" rowspan="2">Satuan</th>
						<th width="8%" colspan="2">Harga Satuan</th>
						<th width="8%" colspan="2">Stok Awal <br/>
							<?php
								if($triwulan == "1"){
							?>
								(31 Des <?php echo $tahunlalu?>)
							<?php
								}elseif($triwulan == "2"){
							?>
								(April <?php echo $tahun?>)
							<?php
								}elseif($triwulan == "3"){
							?>
								(Juli <?php echo $tahun?>)
							<?php
								}elseif($triwulan == "4"){
							?>
								(Oktober <?php echo $tahun?>)
							<?php
								}
							?>
						</th>
						<th width="8%" colspan="2">Penerimaan</th>
						<th width="8%" colspan="2">Pemakaian</th>
						<th width="30%" colspan="7">Sisa Stok Per 
							<?php
								if($triwulan == "1"){
							?>
								(29 Maret <?php echo $tahun?>)
							<?php
								}elseif($triwulan == "2"){
							?>
								(Juni <?php echo $tahun?>)
							<?php
								}elseif($triwulan == "3"){
							?>
								(September <?php echo $tahun?>)
							<?php
								}elseif($triwulan == "4"){
							?>
								(Desember <?php echo $tahun?>)
							<?php
								}
							?>	
						</th>
						<th width="8%" colspan="2">Total Sisa Stok</th>
						<th width="8%" colspan="2">Total Rupiah</th>
					</tr>
					<tr>
						<th>APBD</th><!--Harga-->
						<th>JKN</th>
						<th>APBD</th><!--Stok Awal-->
						<th>JKN</th>
						<th>APBD</th><!--Penerimaan-->
						<th>JKN</th>
						<th>APBD</th><!--Penerimaan-->
						<th>JKN</th>
						<th>Gudang</th>
						<th>Depot</th>
						<th>Poli</th>
						<th>IGD</th>
						<th>Ranap</th>
						<th>Poned</th>
						<th>Pustu</th>
						<th>APBD</th><!--Total Sisa Stok-->
						<th>JKN</th>
						<th>APBD</th><!--Total Rupiah-->
						<th>JKN</th>
					</tr>									
				</thead>
				<tbody style="font-size: 12px;">
					<?php
					// ini buat insert pertama kali saja
					$cek = mysqli_num_rows(mysqli_query($koneksi, "SELECT KodeBarang FROM `tbstokopnam_puskesmas_detail` WHERE `Bulan`='$bulan' AND `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas'"));
					if ($cek == 0){			
						// $query1 = mysqli_query($koneksi, "SELECT * FROM `tbgudangpkmstok` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Stok` > '0'");
						$query1 = mysqli_query($koneksi, "SELECT * FROM `ref_obat_lplpo`");
						while($data = mysqli_fetch_assoc($query1)){
							//get stok gudangpkm
							$dtgudang = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(Stok) as Stok FROM `tbgudangpkmstok` WHERE KodeBarang = '$data[KodeBarang]' And KodePuskesmas = '$kodepuskesmas'"));
							//get stok depot
							$dtdepot = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(Stok) as Stok FROM `tbapotikstok` WHERE KodeBarang = '$data[KodeBarang]' And KodePuskesmas = '$kodepuskesmas'"));
							
							$str1 = "INSERT INTO `tbstokopnam_puskesmas_detail`(`NoFaktur`,`Bulan`,`Tahun`,`KodePuskesmas`,`KodeBarang`,`StokLaluGudang`,`StokLaluDepot`) 
							VALUES ('$nf','$bulan','$tahun','$kodepuskesmas','$data[KodeBarang]','$dtgudang[Stok]','$dtdepot[Stok]')";
							
							mysqli_query($koneksi, $str1);
						}
					}
					
					$str = "SELECT * FROM `ref_obat_lplpo` WHERE (NamaProgram = 'PKD' OR NamaProgram = 'BMHP' OR NamaProgram = 'LABORATORIUM')";
					$str2 = $str." ORDER BY IdLplpo, NamaBarang ASC";
					// echo $str2;
										
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){	
						if($namaprogram != $data['NamaProgram']){
							echo "<tr style='border:1px sollid #000; font-weight: bold;'><td colspan='23' style='text-align: left'>$data[NamaProgram]</td></tr>";
							$namaprogram = $data['NamaProgram'];
						}
						$no = $no + 1;
						$kodebarang = $data['KodeBarang'];
						$namabarang = $data['NamaBarang'];
						$stok = $data['Stok'];				

						if($data['SumberAnggaran'] == "APBD KAB/KOTA"){
							$sumber = "APBD";
						}else{
							$sumber = $data['SumberAnggaran'];
						}	

						// tbstokawal
						$dtstokopname = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokopnam_puskesmas_detail` WHERE `KodeBarang`='$kodebarang' AND `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun'"));
									
						// penerimaan
						if ($triwulan == "1"){
							$penerimaan_apbd = $dtstokopname['PenerimaanApbd_01'] + $dtstokopname['PenerimaanApbd_02'] + $dtstokopname['PenerimaanApbd_03'];
							$penerimaan_jkn = $dtstokopname['PenerimaanJkn_01'] + $dtstokopname['PenerimaanJkn_02'] + $dtstokopname['PenerimaanJkn_03'];
						}elseif($triwulan == "2"){
							$penerimaan_apbd = $dtstokopname['PenerimaanApbd_04'] + $dtstokopname['PenerimaanApbd_05'] + $dtstokopname['PenerimaanApbd_06'];
							$penerimaan_jkn = $dtstokopname['PenerimaanJkn_04'] + $dtstokopname['PenerimaanJkn_05'] + $dtstokopname['PenerimaanJkn_06'];
						}elseif($triwulan == "3"){
							$penerimaan_apbd = $dtstokopname['PenerimaanApbd_07'] + $dtstokopname['PenerimaanApbd_08'] + $dtstokopname['PenerimaanApbd_09'];
							$penerimaan_jkn = $dtstokopname['PenerimaanJkn_07'] + $dtstokopname['PenerimaanJkn_08'] + $dtstokopname['PenerimaanJkn_09'];
						}elseif($triwulan == "4"){
							$penerimaan_apbd = $dtstokopname['PenerimaanApbd_10'] + $dtstokopname['PenerimaanApbd_11'] + $dtstokopname['PenerimaanApbd_12'];
							$penerimaan_jkn = $dtstokopname['PenerimaanJkn_10'] + $dtstokopname['PenerimaanJkn_11'] + $dtstokopname['PenerimaanJkn_12'];
						}

						// pemakaian
						if ($triwulan == "1"){
							$pemakaian_apbd = $dtstokopname['PemakaianApbd_01'] + $dtstokopname['PemakaianApbd_02'] + $dtstokopname['PemakaianApbd_03'];
							$pemakaian_jkn = $dtstokopname['PemakaianJkn_01'] + $dtstokopname['PemakaianJkn_02'] + $dtstokopname['PemakaianJkn_03'];
						}elseif($triwulan == "2"){
							$pemakaian_apbd = $dtstokopname['PemakaianApbd_04'] + $dtstokopname['PemakaianApbd_05'] + $dtstokopname['PemakaianApbd_06'];
							$pemakaian_jkn = $dtstokopname['PemakaianJkn_04'] + $dtstokopname['PemakaianJkn_05'] + $dtstokopname['PemakaianJkn_06'];
						}elseif($triwulan == "3"){
							$pemakaian_apbd = $dtstokopname['PemakaianApbd_07'] + $dtstokopname['PemakaianApbd_08'] + $dtstokopname['PemakaianApbd_09'];
							$pemakaian_jkn = $dtstokopname['PemakaianJkn_07'] + $dtstokopname['PemakaianJkn_08'] + $dtstokopname['PemakaianJkn_09'];
						}elseif($triwulan == "4"){
							$pemakaian_apbd = $dtstokopname['PemakaianApbd_10'] + $dtstokopname['PemakaianApbd_11'] + $dtstokopname['PemakaianApbd_12'];
							$pemakaian_jkn = $dtstokopname['PemakaianJkn_10'] + $dtstokopname['PemakaianJkn_11'] + $dtstokopname['PemakaianJkn_12'];
						}		

						// total sisa stok
						$sisastok_apbd = $dtstokopname['StokAwalApbd'] + $penerimaan_apbd - $pemakaian_apbd;
						$sisastok_jkn = $dtstokopname['StokAwalJkn'] + $penerimaan_jkn - $pemakaian_jkn;
					
						// total rupiah
						$dtgudangpkm_apbd = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'"));
						$dtgudangpkm_jkn = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `HargaSatuan` FROM `tbgudangpkmstok` WHERE `KodeBarang`='$kodebarang' AND `SumberAnggaran`='JKN'"));
						$ttlrupiah_apbd = $sisastok_apbd * $dtgudangpkm_apbd['HargaBeli'];
						$ttlrupiah_jkn = $sisastok_jkn * $dtgudangpkm_jkn['HargaSatuan'];
					?>
					
						<tr style="border:1px solid #000;">
							<td style="text-align:right;"><?php echo $no;?></td>
							<td style="text-align:center;"><?php echo $data['KodeBarang'];?></td>
							<td style="text-align:left;"><?php echo $data['NamaBarang'];?></td>
							<td style="text-align:center;"><?php echo $data['Satuan'];?></td>
							
							<!--Harga-->
							<td style="text-align:right;" class="hargasatuan"><?php echo rupiah($dtgudangpkm_apbd['HargaBeli']);?></td>
							<td style="text-align:right;" class="hargasatuan"><?php echo rupiah($dtgudangpkm_jkn['HargaSatuan']);?></td>
							
							<!--Stok Awal-->
							<td style="text-align:right;">
								<?php 
									if($triwulan == "1"){
										$dtstokawal_apbd = $dtstokopname['StokAwalApbd'];
									}elseif($triwulan == "2"){
										$penerimaan_apbd = $dtstokopname['PenerimaanApbd_01'] + $dtstokopname['PenerimaanApbd_02'] + $dtstokopname['PenerimaanApbd_03'];
										$pemakaian_apbd = $dtstokopname['PemakaianApbd_01'] + $dtstokopname['PemakaianApbd_02'] + $dtstokopname['PemakaianApbd_03'];
										$dtstokawal_apbd = $dtstokopname['StokAwalApbd'] + $penerimaan_apbd - $pemakaian_apbd;
									}elseif($triwulan == "3"){
										$penerimaan_apbd = $dtstokopname['PenerimaanApbd_01'] + $dtstokopname['PenerimaanApbd_02'] + $dtstokopname['PenerimaanApbd_03'];
										$pemakaian_apbd = $dtstokopname['PemakaianApbd_01'] + $dtstokopname['PemakaianApbd_02'] + $dtstokopname['PemakaianApbd_03'];
										$dtstokopname_sementara = $dtstokopname['StokAwalApbd'] + $penerimaan_apbd - $pemakaian_apbd;	
										$penerimaan_apbd_3 = $dtstokopname['PenerimaanApbd_04'] + $dtstokopname['PenerimaanApbd_05'] + $dtstokopname['PenerimaanApbd_06'];
										$pemakaian_apbd_3 = $dtstokopname['PemakaianApbd_04'] + $dtstokopname['PemakaianApbd_05'] + $dtstokopname['PemakaianApbd_06'];
										$dtstokawal_apbd = $dtstokopname_sementara + $penerimaan_apbd_3 - $pemakaian_apbd_3;  
									}elseif($triwulan == "4"){
										$penerimaan_apbd = $dtstokopname['PenerimaanApbd_01'] + $dtstokopname['PenerimaanApbd_02'] + $dtstokopname['PenerimaanApbd_03'];
										$pemakaian_apbd = $dtstokopname['PemakaianApbd_01'] + $dtstokopname['PemakaianApbd_02'] + $dtstokopname['PemakaianApbd_03'];
										$dtstokopname_sementara = $dtstokopname['StokAwalApbd'] + $penerimaan_apbd - $pemakaian_apbd;	
										$penerimaan_apbd_3 = $dtstokopname['PenerimaanApbd_04'] + $dtstokopname['PenerimaanApbd_05'] + $dtstokopname['PenerimaanApbd_06'];
										$pemakaian_apbd_3 = $dtstokopname['PemakaianApbd_04'] + $dtstokopname['PemakaianApbd_05'] + $dtstokopname['PemakaianApbd_06'];
										$dtstokopname_sementara_3 = $dtstokopname_sementara + $penerimaan_apbd_3 - $pemakaian_apbd_3; 
										$penerimaan_apbd_4 = $dtstokopname['PenerimaanApbd_07'] + $dtstokopname['PenerimaanApbd_08'] + $dtstokopname['PenerimaanApbd_09'];
										$pemakaian_apbd_4 = $dtstokopname['PemakaianApbd_07'] + $dtstokopname['PemakaianApbd_08'] + $dtstokopname['PemakaianApbd_09'];
										$dtstokawal_apbd = $dtstokopname_sementara_3 + $penerimaan_apbd_4 - $pemakaian_apbd_4; 											
									}	
									echo rupiah($dtstokawal_apbd);
								?>
							</td>
							<td style="text-align:right;">
								<?php 
									if($triwulan == "1"){
										$dtstokawal_jkn = $dtstokopname['StokAwalJkn'];
									}elseif($triwulan == "2"){
										$penerimaan_jkn = $dtstokopname['PenerimaanJkn_01'] + $dtstokopname['PenerimaanJkn_02'] + $dtstokopname['PenerimaanJkn_03'];
										$pemakaian_jkn = $dtstokopname['PemakaianJkn_01'] + $dtstokopname['PemakaianJkn_02'] + $dtstokopname['PemakaianJkn_03'];
										$dtstokawal_jkn = $dtstokopname['StokAwalJkn'] + $penerimaan_jkn - $pemakaian_jkn;
									}elseif($triwulan == "3"){
										$penerimaan_jkn = $dtstokopname['PenerimaanJkn_01'] + $dtstokopname['PenerimaanJkn_02'] + $dtstokopname['PenerimaanJkn_03'];
										$pemakaian_jkn = $dtstokopname['PemakaianJkn_01'] + $dtstokopname['PemakaianJkn_02'] + $dtstokopname['PemakaianJkn_03'];
										$dtstokopname_sementara = $dtstokopname['StokAwalJkn'] + $penerimaan_jkn - $pemakaian_jkn;	
										$penerimaan_jkn_3 = $dtstokopname['PenerimaanJkn_04'] + $dtstokopname['PenerimaanJkn_05'] + $dtstokopname['PenerimaanJkn_06'];
										$pemakaian_jkn_3 = $dtstokopname['PemakaianJkn_04'] + $dtstokopname['PemakaianJkn_05'] + $dtstokopname['PemakaianJkn_06'];
										$dtstokawal_jkn =$dtstokopname_sementara + $penerimaan_jkn_3 - $pemakaian_jkn_3;
									}elseif($triwulan == "4"){
										$penerimaan_jkn = $dtstokopname['PenerimaanJkn_01'] + $dtstokopname['PenerimaanJkn_02'] + $dtstokopname['PenerimaanJkn_03'];
										$pemakaian_jkn = $dtstokopname['PemakaianJkn_01'] + $dtstokopname['PemakaianJkn_02'] + $dtstokopname['PemakaianJkn_03'];
										$dtstokopname_sementara = $dtstokopname['StokAwalJkn'] + $penerimaan_jkn - $pemakaian_jkn;	
										$penerimaan_jkn_3 = $dtstokopname['PenerimaanJkn_04'] + $dtstokopname['PenerimaanJkn_05'] + $dtstokopname['PenerimaanJkn_06'];
										$pemakaian_jkn_3 = $dtstokopname['PemakaianJkn_04'] + $dtstokopname['PemakaianJkn_05'] + $dtstokopname['PemakaianJkn_06'];
										$dtstokopname_sementara_3 =$dtstokopname_sementara + $penerimaan_jkn_3 - $pemakaian_jkn_3;
										$penerimaan_jkn_4 = $dtstokopname['PenerimaanJkn_07'] + $dtstokopname['PenerimaanJkn_08'] + $dtstokopname['PenerimaanJkn_09'];
										$pemakaian_jkn_4 = $dtstokopname['PemakaianJkn_07'] + $dtstokopname['PemakaianJkn_08'] + $dtstokopname['PemakaianJkn_09'];
										$dtstokawal_jkn =$dtstokopname_sementara_3 + $penerimaan_jkn_4 - $pemakaian_jkn_4;
									}
									echo rupiah($dtstokawal_jkn);
								?>
							</td>
							<!--Penerimaan-->
							<td style="text-align:right;">
								<?php
									if($triwulan == "1"){
										$penerimaan_apbd = $dtstokopname['PenerimaanApbd_01'] + $dtstokopname['PenerimaanApbd_02'] + $dtstokopname['PenerimaanApbd_03'];
									}elseif($triwulan == "2"){
										$penerimaan_apbd = $dtstokopname['PenerimaanApbd_04'] + $dtstokopname['PenerimaanApbd_05'] + $dtstokopname['PenerimaanApbd_06'];
									}elseif($triwulan == "3"){
										$penerimaan_apbd = $dtstokopname['PenerimaanApbd_07'] + $dtstokopname['PenerimaanApbd_08'] + $dtstokopname['PenerimaanApbd_09'];	
									}elseif($triwulan == "4"){
										$penerimaan_apbd = $dtstokopname['PenerimaanApbd_10'] + $dtstokopname['PenerimaanApbd_11'] + $dtstokopname['PenerimaanApbd_12'];
									}	
									echo rupiah($penerimaan_apbd);
								?>
							</td>
							<td style="text-align:right;">
								<?php
									if($triwulan == "1"){
										$penerimaan_jkn = $dtstokopname['PenerimaanJkn_01'] + $dtstokopname['PenerimaanJkn_02'] + $dtstokopname['PenerimaanJkn_03'];
									}elseif($triwulan == "2"){
										$penerimaan_jkn = $dtstokopname['PenerimaanJkn_04'] + $dtstokopname['PenerimaanJkn_05'] + $dtstokopname['PenerimaanJkn_06'];
									}elseif($triwulan == "3"){
										$penerimaan_jkn = $dtstokopname['PenerimaanJkn_07'] + $dtstokopname['PenerimaanJkn_08'] + $dtstokopname['PenerimaanJkn_09'];
									}elseif($triwulan == "4"){
										$penerimaan_jkn = $dtstokopname['PenerimaanJkn_10'] + $dtstokopname['PenerimaanJkn_11'] + $dtstokopname['PenerimaanJkn_12'];
									}	
									echo rupiah($penerimaan_jkn);
								?>
							</td>
							<!--Pemakaian-->
							<td style="text-align:right;">
								<?php
									if($triwulan == "1"){
										$pemakaian_apbd = $dtstokopname['PemakaianApbd_01'] + $dtstokopname['PemakaianApbd_02'] + $dtstokopname['PemakaianApbd_03'];
									}elseif($triwulan == "2"){
										$pemakaian_apbd = $dtstokopname['PemakaianApbd_04'] + $dtstokopname['PemakaianApbd_05'] + $dtstokopname['PemakaianApbd_06'];
									}elseif($triwulan == "3"){
										$pemakaian_apbd = $dtstokopname['PemakaianApbd_07'] + $dtstokopname['PemakaianApbd_08'] + $dtstokopname['PemakaianApbd_09'];
									}elseif($triwulan == "4"){
										$pemakaian_apbd = $dtstokopname['PemakaianApbd_10'] + $dtstokopname['PemakaianApbd_11'] + $dtstokopname['PemakaianApbd_12'];
									}	
									echo rupiah($pemakaian_apbd);	
								?>
							</td>
							<td style="text-align:right;">
								<?php
									if($triwulan == "1"){
										$pemakaian_jkn = $dtstokopname['PemakaianJkn_01'] + $dtstokopname['PemakaianJkn_02'] + $dtstokopname['PemakaianJkn_03'];
									}elseif($triwulan == "2"){
										$pemakaian_jkn = $dtstokopname['PemakaianJkn_04'] + $dtstokopname['PemakaianJkn_05'] + $dtstokopname['PemakaianJkn_06'];
									}elseif($triwulan == "3"){
										$pemakaian_jkn = $dtstokopname['PemakaianJkn_07'] + $dtstokopname['PemakaianJkn_08'] + $dtstokopname['PemakaianJkn_09'];
									}elseif($triwulan == "4"){
										$pemakaian_jkn = $dtstokopname['PemakaianJkn_10'] + $dtstokopname['PemakaianJkn_11'] + $dtstokopname['PemakaianJkn_12'];
									}	
									echo rupiah($pemakaian_jkn);	
								?>
							</td>							
							<!--sisa stok gudang-->
							<td style="text-align:right;" class="StokGudang jml-real" data-isi="<?php echo $dtstokpuskesmas['StokGudang'];?>">
								<?php
									if($dtstokpuskesmas['StokGudang'] != 0){
										echo rupiah($dtstokpuskesmas['StokGudang']);
									}else{
										echo "-";												
									}
								?>
							</td>
							<!--sisa stok depot-->
							<td style="text-align:right;" data-isi="<?php echo $dtstokpuskesmas['StokDepot'];?>" class="depot jml-real">
								<?php
									if($dtstokpuskesmas['StokDepot'] != 0){
										echo rupiah($dtstokpuskesmas['StokDepot']);
									}else{
										echo "-";												
									}
								?>
							</td>
							<!--sisa stok poli-->
							<td style="text-align:right;" data-isi="<?php echo $dtstokpuskesmas['StokPoli'];?>" class="poli jml-real">
								<?php
									if($dtstokpuskesmas['StokPoli'] != 0){
										echo rupiah($dtstokpuskesmas['StokPoli']);
									}else{
										echo "-";												
									}
								?>
							</td>
							<!--sisa stok igd-->
							<td style="text-align:right;" data-isi="<?php echo $dtstokpuskesmas['StokIgd'];?>" class="igd jml-real">
								<?php
									if($dtstokpuskesmas['StokIgd'] != 0){
										echo rupiah($dtstokpuskesmas['StokIgd']);
									}else{
										echo "-";												
									}
								?>
							</td>
							<!--sisa stok ranap-->
							<td style="text-align:right;" data-isi="<?php echo $dtstokpuskesmas['StokRanap'];?>" class="ranap jml-real">
								<?php
									if($dtstokpuskesmas['StokRanap'] != 0){
										echo rupiah($dtstokpuskesmas['StokRanap']);
									}else{
										echo "-";												
									}
								?>
							</td>
							<!--sisa stok poned-->
							<td style="text-align:right;" data-isi="<?php echo $dtstokpuskesmas['StokPoned'];?>" class="poned jml-real">
								<?php
									if($dtstokpuskesmas['StokPoned'] != 0){
										echo rupiah($dtstokpuskesmas['StokPoned']);
									}else{
										echo "-";												
									}
								?>
							</td>
							<!--sisa stok pustu-->
							<td style="text-align:right;" data-isi="<?php echo $dtstokpuskesmas['StokPustu'];?>" class="pustu jml-real">
								<?php
									if($dtstokpuskesmas['StokPustu'] != 0){
										echo rupiah($dtstokpuskesmas['StokPustu']);
									}else{
										echo "-";												
									}
								?>
							</td>
							<!--Total Sisa Stok-->
							<td style="text-align:right;" class="totalreal">
								<?php
									if($triwulan == "1"){
										// echo rupiah($dtstokawal_apbd);
									}elseif($triwulan == "2"){
										$penerimaan_apbd = $dtstokopname['PenerimaanApbd_01'] + $dtstokopname['PenerimaanApbd_02'] + $dtstokopname['PenerimaanApbd_03'];
										$pemakaian_apbd = $dtstokopname['PemakaianApbd_01'] + $dtstokopname['PemakaianApbd_02'] + $dtstokopname['PemakaianApbd_03'];
										$sisa_stok_sementara = $dtstokopname['StokAwalApbd'] + $penerimaan_apbd - $pemakaian_apbd;
										$penerimaan_apbd_2 = $dtstokopname['PenerimaanApbd_04'] + $dtstokopname['PenerimaanApbd_05'] + $dtstokopname['PenerimaanApbd_06'];
										$pemakaian_apbd_2 = $dtstokopname['PemakaianApbd_04'] + $dtstokopname['PemakaianApbd_05'] + $dtstokopname['PemakaianApbd_06'];
										$sisastok_apbd = $sisa_stok_sementara + $penerimaan_apbd_2 - $pemakaian_apbd_2;
									}elseif($triwulan == "3"){
										$penerimaan_apbd = $dtstokopname['PenerimaanApbd_01'] + $dtstokopname['PenerimaanApbd_02'] + $dtstokopname['PenerimaanApbd_03'];
										$pemakaian_apbd = $dtstokopname['PemakaianApbd_01'] + $dtstokopname['PemakaianApbd_02'] + $dtstokopname['PemakaianApbd_03'];
										$sisa_stok_sementara_2 = $dtstokopname['StokAwalApbd'] + $penerimaan_apbd - $pemakaian_apbd;
										$penerimaan_apbd_2 = $dtstokopname['PenerimaanApbd_04'] + $dtstokopname['PenerimaanApbd_05'] + $dtstokopname['PenerimaanApbd_06'];
										$pemakaian_apbd_2 = $dtstokopname['PemakaianApbd_04'] + $dtstokopname['PemakaianApbd_05'] + $dtstokopname['PemakaianApbd_06'];
										$sisa_stok_sementara_3 = $sisa_stok_sementara_2 + $penerimaan_apbd_2 - $pemakaian_apbd_2;
										$penerimaan_apbd_3 = $dtstokopname['PenerimaanApbd_07'] + $dtstokopname['PenerimaanApbd_08'] + $dtstokopname['PenerimaanApbd_09'];
										$pemakaian_apbd_3 = $dtstokopname['PemakaianApbd_07'] + $dtstokopname['PemakaianApbd_08'] + $dtstokopname['PemakaianApbd_09'];
										$sisastok_apbd = $sisa_stok_sementara_3 + $penerimaan_apbd_3 - $pemakaian_apbd_3;
									}elseif($triwulan == "4"){	
										$penerimaan_apbd = $dtstokopname['PenerimaanApbd_01'] + $dtstokopname['PenerimaanApbd_02'] + $dtstokopname['PenerimaanApbd_03'];
										$pemakaian_apbd = $dtstokopname['PemakaianApbd_01'] + $dtstokopname['PemakaianApbd_02'] + $dtstokopname['PemakaianApbd_03'];
										$sisa_stok_sementara_2 = $dtstokopname['StokAwalApbd'] + $penerimaan_apbd - $pemakaian_apbd;
										$penerimaan_apbd_2 = $dtstokopname['PenerimaanApbd_04'] + $dtstokopname['PenerimaanApbd_05'] + $dtstokopname['PenerimaanApbd_06'];
										$pemakaian_apbd_2 = $dtstokopname['PemakaianApbd_04'] + $dtstokopname['PemakaianApbd_05'] + $dtstokopname['PemakaianApbd_06'];
										$sisa_stok_sementara_3 = $sisa_stok_sementara_2 + $penerimaan_apbd_2 - $pemakaian_apbd_2;
										$penerimaan_apbd_3 = $dtstokopname['PenerimaanApbd_07'] + $dtstokopname['PenerimaanApbd_08'] + $dtstokopname['PenerimaanApbd_09'];
										$pemakaian_apbd_3 = $dtstokopname['PemakaianApbd_07'] + $dtstokopname['PemakaianApbd_08'] + $dtstokopname['PemakaianApbd_09'];
										$sisa_stok_sementara_4 = $sisa_stok_sementara_3 + $penerimaan_apbd_3 - $pemakaian_apbd_3;
										$penerimaan_apbd_4 = $dtstokopname['PenerimaanApbd_10'] + $dtstokopname['PenerimaanApbd_11'] + $dtstokopname['PenerimaanApbd_12'];
										$pemakaian_apbd_4 = $dtstokopname['PemakaianApbd_10'] + $dtstokopname['PemakaianApbd_11'] + $dtstokopname['PemakaianApbd_12'];
										$sisastok_apbd = $sisa_stok_sementara_4 + $penerimaan_apbd_4 - $pemakaian_apbd_4;
									}
									echo rupiah($sisastok_apbd);
								?>
							</td>
							<td style="text-align:right;" class="totalreal">
								<?php
									if($triwulan == "1"){
										// echo rupiah($dtstokawal_jkn);
									}elseif($triwulan == "2"){
										$penerimaan_jkn = $dtstokopname['PenerimaanJkn_01'] + $dtstokopname['PenerimaanJkn_02'] + $dtstokopname['PenerimaanJkn_03'];
										$pemakaian_jkn= $dtstokopname['PemakaianJkn_01'] + $dtstokopname['PemakaianJkn_02'] + $dtstokopname['PemakaianJkn_03'];
										$sisa_stok_sementara = $dtstokopname['StokAwalJkn'] + $penerimaan_jkn - $pemakaian_jkn;
										$penerimaan_jkn = $dtstokopname['PenerimaanJkn_04'] + $dtstokopname['PenerimaanJkn_05'] + $dtstokopname['PenerimaanJkn_06'];
										$pemakaian_jkn = $dtstokopname['PemakaianJkn_04'] + $dtstokopname['PemakaianJkn_05'] + $dtstokopname['PemakaianJkn_06'];
										$sisastok_jkn = $sisa_stok_sementara + $penerimaan_jkn - $pemakaian_jkn;
									}elseif($triwulan == "3"){
										$penerimaan_jkn = $dtstokopname['PenerimaanJkn_01'] + $dtstokopname['PenerimaanJkn_02'] + $dtstokopname['PenerimaanJkn_03'];
										$pemakaian_jkn= $dtstokopname['PemakaianJkn_01'] + $dtstokopname['PemakaianJkn_02'] + $dtstokopname['PemakaianJkn_03'];
										$sisa_stok_sementara_2 = $dtstokopname['StokAwalJkn'] + $penerimaan_jkn - $pemakaian_jkn;
										$penerimaan_jkn_2 = $dtstokopname['PenerimaanJkn_04'] + $dtstokopname['PenerimaanJkn_05'] + $dtstokopname['PenerimaanJkn_06'];
										$pemakaian_jkn_2 = $dtstokopname['PemakaianJkn_04'] + $dtstokopname['PemakaianJkn_05'] + $dtstokopname['PemakaianJkn_06'];
										$sisa_stok_sementara_3 = $sisa_stok_sementara_2 + $penerimaan_jkn_2 - $pemakaian_jkn_2;
										$penerimaan_jkn_3 = $dtstokopname['PenerimaanJkn_07'] + $dtstokopname['PenerimaanJkn_08'] + $dtstokopname['PenerimaanJkn_09'];
										$pemakaian_jkn_3 = $dtstokopname['PemakaianJkn_07'] + $dtstokopname['PemakaianJkn_08'] + $dtstokopname['PemakaianJkn_09'];
										$sisastok_jkn =$sisa_stok_sementara_3 + $penerimaan_jkn_3 - $pemakaian_jkn_3;
									}elseif($triwulan == "4"){	
										$penerimaan_jkn = $dtstokopname['PenerimaanJkn_01'] + $dtstokopname['PenerimaanJkn_02'] + $dtstokopname['PenerimaanJkn_03'];
										$pemakaian_jkn= $dtstokopname['PemakaianJkn_01'] + $dtstokopname['PemakaianJkn_02'] + $dtstokopname['PemakaianJkn_03'];
										$sisa_stok_sementara_2 = $dtstokopname['StokAwalJkn'] + $penerimaan_jkn - $pemakaian_jkn;
										$penerimaan_jkn_2 = $dtstokopname['PenerimaanJkn_04'] + $dtstokopname['PenerimaanJkn_05'] + $dtstokopname['PenerimaanJkn_06'];
										$pemakaian_jkn_2 = $dtstokopname['PemakaianJkn_04'] + $dtstokopname['PemakaianJkn_05'] + $dtstokopname['PemakaianJkn_06'];
										$sisa_stok_sementara_3 = $sisa_stok_sementara_2 + $penerimaan_jkn_2 - $pemakaian_jkn_2;
										$penerimaan_jkn_3 = $dtstokopname['PenerimaanJkn_07'] + $dtstokopname['PenerimaanJkn_08'] + $dtstokopname['PenerimaanJkn_09'];
										$pemakaian_jkn_3 = $dtstokopname['PemakaianJkn_07'] + $dtstokopname['PemakaianJkn_08'] + $dtstokopname['PemakaianJkn_09'];
										$sisa_stok_sementara_4 = $sisa_stok_sementara_3 + $penerimaan_jkn_3 - $pemakaian_jkn_3;
										$penerimaan_jkn_4 = $dtstokopname['PenerimaanJkn_10'] + $dtstokopname['PenerimaanJkn_11'] + $dtstokopname['PenerimaanJkn_12'];
										$pemakaian_jkn_4 = $dtstokopname['PemakaianJkn_10'] + $dtstokopname['PemakaianJkn_11'] + $dtstokopname['PemakaianJkn_12'];
										$sisastok_jkn =$sisa_stok_sementara_4 + $penerimaan_jkn_4 - $pemakaian_jkn_4;
									}
									echo rupiah($sisastok_jkn);
								?>
							</td>							
							<!--Total Rupiah-->
							<td style="text-align:right;" class="totalhargareal">
								<?php  
									if($ttlrupiah_apbd != 0){
										echo rupiah($ttlrupiah_apbd);
									}else{
										echo "0";												
									}
								?>
							</td>
							<td style="text-align:right;" class="totalhargareal">
								<?php  
									if($ttlrupiah_jkn != 0){
										echo rupiah($ttlrupiah_jkn);
									}else{
										echo "0";												
									}
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