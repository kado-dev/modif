<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KUNJUNGAN PELAYANAN (BULAN)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_poli_bulan"/>
						<div class="col-xl-2 bulanformcari" style ="width:125px">
							<select name="tahun" class="form-control tahuncls">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-10">
							<button type="submit" class="btn btn-round btn-warning btncls"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_poli_bulan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_loket_poli_bulan_excel.php?tahun=<?php echo $_GET['tahun'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>		
			</div>	
		</div>
	</div>

	<?php
	$tahun = $_GET['tahun'];
	if(isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>KUNJUNGAN PELAYANAN (BULAN)</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
		<br/>
	</div><br/>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="3%" rowspan="2">NO.</th>
							<th width="15%" rowspan="2">NAMA PELAYANAN</th>
							<th colspan="12">JUMLAH KUNJUNGAN</th>
							<th width="8%" rowspan="2">TOTAL</th>
						</tr>
						<tr>
							<?php
							for($bln = 1; $bln <= 12; $bln++){
								echo "<th style='text-align:center vertical-align:middle; padding:3px;'>".nama_bulan_singkat($bln)."</th>";
							}
							?>
						</tr>
					</thead>
					<tbody>
						<?php
							// ruang pendaftaran
							$dtlkt_01 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '01'"));
							$dtlkt_02 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '02'"));
							$dtlkt_03 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '03'"));
							$dtlkt_04 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '04'"));
							$dtlkt_05 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '05'"));
							$dtlkt_06 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '06'"));
							$dtlkt_07 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '07'"));
							$dtlkt_08 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '08'"));
							$dtlkt_09 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '09'"));
							$dtlkt_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '10'"));
							$dtlkt_11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '11'"));
							$dtlkt_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '12'"));
							$dtlkt_total = $dtlkt_01['Jumlah'] + $dtlkt_02['Jumlah'] + $dtlkt_03['Jumlah'] + $dtlkt_04['Jumlah'] + $dtlkt_05['Jumlah'] + $dtlkt_06['Jumlah'] + 
											$dtlkt_07['Jumlah'] + $dtlkt_08['Jumlah'] + $dtlkt_09['Jumlah'] + $dtlkt_10['Jumlah'] + $dtlkt_11['Jumlah'] + $dtlkt_12['Jumlah'];
						?>
						<tr>
							<td><?php echo "1";?></td>
							<td><?php echo "RUANG PENDAFTARAN";?></td>
							<td align="right"><?php echo rupiah($dtlkt_01['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtlkt_02['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtlkt_03['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtlkt_04['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtlkt_05['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtlkt_06['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtlkt_07['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtlkt_08['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtlkt_09['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtlkt_10['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtlkt_11['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtlkt_12['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtlkt_total);?></td>
						</tr>
						
						<?php
						$str = "SELECT * FROM `tbpelayanankesehatan` WHERE `JenisPelayanan`='KUNJUNGAN SAKIT'";
						$str2 = $str." ORDER BY Pelayanan";
						$no = 1;			
						$query = mysqli_query($koneksi, $str2);					
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$poli = $data['Pelayanan'];
							$dtrj1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '01' AND `PoliPertama` = '$poli'"));
							$dtrj2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '02'  AND `PoliPertama` = '$poli'"));
							$dtrj3 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '03'  AND `PoliPertama` = '$poli'"));
							$dtrj4 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '04'  AND `PoliPertama` = '$poli'"));
							$dtrj5 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '05'  AND `PoliPertama` = '$poli'"));
							$dtrj6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '06'  AND `PoliPertama` = '$poli'"));
							$dtrj7 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '07'  AND `PoliPertama` = '$poli'"));
							$dtrj8 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '08'  AND `PoliPertama` = '$poli'"));
							$dtrj9 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '09'  AND `PoliPertama` = '$poli'"));
							$dtrj10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '10'  AND `PoliPertama` = '$poli'"));
							$dtrj11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '11'  AND `PoliPertama` = '$poli'"));
							$dtrj12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '12'  AND `PoliPertama` = '$poli'"));
							$dtttl = $dtrj1['Jml'] + $dtrj2['Jml'] + $dtrj3['Jml'] + $dtrj4['Jml'] + $dtrj5['Jml'] + $dtrj6['Jml'] + $dtrj7['Jml'] + $dtrj8['Jml'] + $dtrj9['Jml'] + $dtrj10['Jml'] + $dtrj11['Jml'] + $dtrj12['Jml'];
						?>	
							
							<tr>
								<td><?php echo $no;?></td>
								<td><?php echo str_replace('POLI','RUANG', $poli);?></td>
								<td align="right"><?php echo rupiah($dtrj1['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj2['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj3['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj4['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj5['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj6['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj7['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj8['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj9['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj10['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj11['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj12['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtttl);?></td>	
							</tr>
						<?php
						}
						?>
						
						<?php
							// ruang farmasi
							$nofarmasi = $no + 1;
							$dtfarmasi_01 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdResep) AS Jumlah FROM `$tbresep` WHERE YEAR(`TanggalResep`)='$tahun' AND MONTH(`TanggalResep`) = '01'"));
							$dtfarmasi_02 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdResep) AS Jumlah FROM `$tbresep` WHERE YEAR(`TanggalResep`)='$tahun' AND MONTH(`TanggalResep`) = '02'"));
							$dtfarmasi_03 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdResep) AS Jumlah FROM `$tbresep` WHERE YEAR(`TanggalResep`)='$tahun' AND MONTH(`TanggalResep`) = '03'"));
							$dtfarmasi_04 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdResep) AS Jumlah FROM `$tbresep` WHERE YEAR(`TanggalResep`)='$tahun' AND MONTH(`TanggalResep`) = '04'"));
							$dtfarmasi_05 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdResep) AS Jumlah FROM `$tbresep` WHERE YEAR(`TanggalResep`)='$tahun' AND MONTH(`TanggalResep`) = '05'"));
							$dtfarmasi_06 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdResep) AS Jumlah FROM `$tbresep` WHERE YEAR(`TanggalResep`)='$tahun' AND MONTH(`TanggalResep`) = '06'"));
							$dtfarmasi_07 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdResep) AS Jumlah FROM `$tbresep` WHERE YEAR(`TanggalResep`)='$tahun' AND MONTH(`TanggalResep`) = '07'"));
							$dtfarmasi_08 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdResep) AS Jumlah FROM `$tbresep` WHERE YEAR(`TanggalResep`)='$tahun' AND MONTH(`TanggalResep`) = '08'"));
							$dtfarmasi_09 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdResep) AS Jumlah FROM `$tbresep` WHERE YEAR(`TanggalResep`)='$tahun' AND MONTH(`TanggalResep`) = '09'"));
							$dtfarmasi_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdResep) AS Jumlah FROM `$tbresep` WHERE YEAR(`TanggalResep`)='$tahun' AND MONTH(`TanggalResep`) = '10'"));
							$dtfarmasi_11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdResep) AS Jumlah FROM `$tbresep` WHERE YEAR(`TanggalResep`)='$tahun' AND MONTH(`TanggalResep`) = '11'"));
							$dtfarmasi_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdResep) AS Jumlah FROM `$tbresep` WHERE YEAR(`TanggalResep`)='$tahun' AND MONTH(`TanggalResep`) = '12'"));
							$dtfarmasi_total = $dtfarmasi_01['Jumlah'] + $dtfarmasi_02['Jumlah'] + $dtfarmasi_03['Jumlah'] + $dtfarmasi_04['Jumlah'] + $dtfarmasi_05['Jumlah'] + $dtfarmasi_06['Jumlah'] + 
											$dtfarmasi_07['Jumlah'] + $dtfarmasi_08['Jumlah'] + $dtfarmasi_09['Jumlah'] + $dtfarmasi_10['Jumlah'] + $dtfarmasi_11['Jumlah'] + $dtfarmasi_12['Jumlah'];
						?>
						<tr>
							<td><?php echo $nofarmasi;?></td>
							<td><?php echo "RUANG FARMASI";?></td>
							<td align="right"><?php echo rupiah($dtfarmasi_01['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtfarmasi_02['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtfarmasi_03['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtfarmasi_04['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtfarmasi_05['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtfarmasi_06['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtfarmasi_07['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtfarmasi_08['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtfarmasi_09['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtfarmasi_10['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtfarmasi_11['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtfarmasi_12['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtfarmasi_total);?></td>
						</tr>
						
						<?php
							// shift sore
							$noshiftsore = $nofarmasi + 1;
							$dtshiftsore_01 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '01' AND (time(TanggalRegistrasi) between '14:31' AND '21:30')"));
							$dtshiftsore_02 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '02' AND (time(TanggalRegistrasi) between '14:31' AND '21:30')"));
							$dtshiftsore_03 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '03' AND (time(TanggalRegistrasi) between '14:31' AND '21:30')"));
							$dtshiftsore_04 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '04' AND (time(TanggalRegistrasi) between '14:31' AND '21:30')"));
							$dtshiftsore_05 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '05' AND (time(TanggalRegistrasi) between '14:31' AND '21:30')"));
							$dtshiftsore_06 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '06' AND (time(TanggalRegistrasi) between '14:31' AND '21:30')"));
							$dtshiftsore_07 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '07' AND (time(TanggalRegistrasi) between '14:31' AND '21:30')"));
							$dtshiftsore_08 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '08' AND (time(TanggalRegistrasi) between '14:31' AND '21:30')"));
							$dtshiftsore_09 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '09' AND (time(TanggalRegistrasi) between '14:31' AND '21:30')"));
							$dtshiftsore_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '10' AND (time(TanggalRegistrasi) between '14:31' AND '21:30')"));
							$dtshiftsore_11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '11' AND (time(TanggalRegistrasi) between '14:31' AND '21:30')"));
							$dtshiftsore_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '12' AND (time(TanggalRegistrasi) between '14:31' AND '21:30')"));
							$dtshiftsore_12_total = $dtshiftsore_01['Jumlah'] + $dtshiftsore_02['Jumlah'] + $dtshiftsore_03['Jumlah'] + $dtshiftsore_04['Jumlah'] + $dtshiftsore_05['Jumlah'] + $dtshiftsore_06['Jumlah'] + 
											$dtshiftsore_07['Jumlah'] + $dtshiftsore_08['Jumlah'] + $dtshiftsore_09['Jumlah'] + $dtshiftsore_10['Jumlah'] + $dtshiftsore_11['Jumlah'] + $dtshiftsore_12['Jumlah'];
						?>
						<tr>
							<td><?php echo $noshiftsore;?></td>
							<td><?php echo "SHIFT SORE";?></td>
							<td align="right"><?php echo rupiah($dtshiftsore_01['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftsore_02['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftsore_03['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftsore_04['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftsore_05['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftsore_06['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftsore_07['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftsore_08['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftsore_09['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftsore_10['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftsore_11['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftsore_12['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftsore_12_total);?></td>
						</tr>
						
						<?php
							// shift malam
							$noshiftmalam = $noshiftsore + 1;
							$dtshiftmalam_01 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '01' AND (time(TanggalRegistrasi) between '21:31' AND '24:00' OR time(TanggalRegistrasi) between '01:00' AND '07:30')"));
							$dtshiftmalam_02 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '02' AND (time(TanggalRegistrasi) between '21:31' AND '24:00' OR time(TanggalRegistrasi) between '01:00' AND '07:30')"));
							$dtshiftmalam_03 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '03' AND (time(TanggalRegistrasi) between '21:31' AND '24:00' OR time(TanggalRegistrasi) between '01:00' AND '07:30')"));
							$dtshiftmalam_04 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '04' AND (time(TanggalRegistrasi) between '21:31' AND '24:00' OR time(TanggalRegistrasi) between '01:00' AND '07:30')"));
							$dtshiftmalam_05 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '05' AND (time(TanggalRegistrasi) between '21:31' AND '24:00' OR time(TanggalRegistrasi) between '01:00' AND '07:30')"));
							$dtshiftmalam_06 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '06' AND (time(TanggalRegistrasi) between '21:31' AND '24:00' OR time(TanggalRegistrasi) between '01:00' AND '07:30')"));
							$dtshiftmalam_07 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '07' AND (time(TanggalRegistrasi) between '21:31' AND '24:00' OR time(TanggalRegistrasi) between '01:00' AND '07:30')"));
							$dtshiftmalam_08 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '08' AND (time(TanggalRegistrasi) between '21:31' AND '24:00' OR time(TanggalRegistrasi) between '01:00' AND '07:30')"));
							$dtshiftmalam_09 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '09' AND (time(TanggalRegistrasi) between '21:31' AND '24:00' OR time(TanggalRegistrasi) between '01:00' AND '07:30')"));
							$dtshiftmalam_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '10' AND (time(TanggalRegistrasi) between '21:31' AND '24:00' OR time(TanggalRegistrasi) between '01:00' AND '07:30')"));
							$dtshiftmalam_11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '11' AND (time(TanggalRegistrasi) between '21:31' AND '24:00' OR time(TanggalRegistrasi) between '01:00' AND '07:30')"));
							$dtshiftmalam_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`) = '12' AND (time(TanggalRegistrasi) between '21:31' AND '24:00' OR time(TanggalRegistrasi) between '01:00' AND '07:30')"));
							$dtshiftmalam_12_total = $dtshiftmalam_01['Jumlah'] + $dtshiftmalam_02['Jumlah'] + $dtshiftmalam_03['Jumlah'] + $dtshiftmalam_04['Jumlah'] + $dtshiftmalam_05['Jumlah'] + $dtshiftmalam_06['Jumlah'] + 
											$dtshiftmalam_07['Jumlah'] + $dtshiftmalam_08['Jumlah'] + $dtshiftmalam_09['Jumlah'] + $dtshiftmalam_10['Jumlah'] + $dtshiftmalam_11['Jumlah'] + $dtshiftmalam_12['Jumlah'];
						?>
						<tr>
							<td><?php echo $noshiftmalam;?></td>
							<td><?php echo "SHIFT MALAM";?></td>
							<td align="right"><?php echo rupiah($dtshiftmalam_01['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftmalam_02['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftmalam_03['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftmalam_04['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftmalam_05['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftmalam_06['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftmalam_07['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftmalam_08['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftmalam_09['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftmalam_10['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftmalam_11['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftmalam_12['Jumlah']);?></td>
							<td align="right"><?php echo rupiah($dtshiftmalam_12_total);?></td>
						</tr>
						
						<?php
						// luar gedung
						?>
						<tr>
							<td colspan="15">LUAR GEDUNG</td>
						</tr>
						<?php
						$no = 0;
						$str = "SELECT * FROM `tbasalpasien` WHERE `AsalPasien` != 'PUSKESMAS' ORDER BY AsalPasien";
						$query = mysqli_query($koneksi, $str);					
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$poli_ks = $data['AsalPasien'];
							$dtrj1_ks = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '01' AND `AsalPasien` = '$poli_ks'"));
							$dtrj2_ks = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '02'  AND `AsalPasien` = '$poli_ks'"));
							$dtrj3_ks = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '03'  AND `AsalPasien` = '$poli_ks'"));
							$dtrj4_ks = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '04'  AND `AsalPasien` = '$poli_ks'"));
							$dtrj5_ks = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '05'  AND `AsalPasien` = '$poli_ks'"));
							$dtrj6_ks = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '06'  AND `AsalPasien` = '$poli_ks'"));
							$dtrj7_ks = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '07'  AND `AsalPasien` = '$poli_ks'"));
							$dtrj8_ks = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '08'  AND `AsalPasien` = '$poli_ks'"));
							$dtrj9_ks = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '09'  AND `AsalPasien` = '$poli_ks'"));
							$dtrj10_ks = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '10'  AND `AsalPasien` = '$poli_ks'"));
							$dtrj11_ks = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '11'  AND `AsalPasien` = '$poli_ks'"));
							$dtrj12_ks = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '12'  AND `AsalPasien` = '$poli_ks'"));
							$dtttl_ks = $dtrj1_ks['Jml'] + $dtrj2_ks['Jml'] + $dtrj3_ks['Jml'] + $dtrj4_ks['Jml'] + $dtrj5_ks['Jml'] + $dtrj6_ks['Jml'] + $dtrj7_ks['Jml'] + $dtrj8_ks['Jml'] + $dtrj9_ks['Jml'] + $dtrj10_ks['Jml'] + $dtrj11_ks['Jml'] + $dtrj12_ks['Jml'];
						?>	
							
							<tr>
								<td><?php echo $no;?></td>
								<td><?php echo $poli_ks;?></td>
								<td align="right"><?php echo rupiah($dtrj1_ks['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj2_ks['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj3_ks['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj4_ks['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj5_ks['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj6_ks['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj7_ks['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj8_ks['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj9_ks['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj10_ks['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj11_ks['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtrj12_ks['Jml']);?></td>
								<td align="right"><?php echo rupiah($dtttl_ks);?></td>	
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
	}
	?>
	<div class="row noprint mt-4">
		<div class="col-sm-12 table-responsive">
			<div class="formbg">
				<p>
					<b>Perhatikan :</b><br/>
					Shift Sore, dimulai dari pukul 14:31 s/d 21:30<br/>
					Shift Malam, dimulai dari pukul 21:31 07:30<br/>
					Untuk puskesmas yang tidak 24 jam maka abaikan perhitungan shift sore dan malam.
				</p>
			</div>
		</div>
	</div>
</div>



<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
	$('.btncls').click(function(){
		$( ".hasilpencarian" ).html( "<p style='text-align:center'><img src='assets/js/loader.gif' width='40px'></p>" );
		var tahun = $(this).parent().parent().find(".tahuncls").val()

		$.post( "lap_loket_poli_bulan.php?jqry=yes", { tahun: tahun })
		  .done(function( data ) {
			 $( ".hasilpencarian" ).html( data );
		});
	});
</script>