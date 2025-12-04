<?php
	session_start();
	include "config/koneksi.php";
	// include "otoritas.php";
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KUNJUNGAN PASIEN (CARA BAYAR)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">	
						<input type="hidden" name="page" value="lap_loket_carabayar_dinkes"/>
						<div class="col-xl-2 bulanformcari" style ="width:125px">
							<select name="tahun" class="form-control tahuncls">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-10">
							<button type="submit" class="btn btn-round btn-warning btncls"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_carabayar_dinkes" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_loket_carabayar_dinkes_excel.php?tahun=<?php echo $_GET['tahun'];?>" class="btn btn-round btn-success">Excel</a>
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

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead style="font-size:10px;">
						<tr style="border:1px solid #000;">
							<th width="3%" rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th width="10%" rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Puskesmas</th>
							<th colspan="48" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Kunjungan</th>
							<th width="8%" rowspan="3" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Total</th>
						</tr>
						<tr style="border:1px solid #000;">
							<?php
							for($bln = 1; $bln <= 12;$bln++){
								echo "<th colspan='4' style='text-align:center vertical-align:middle; border:1px solid #000; padding:3px;'>".nama_bulan_singkat($bln)."</th>";
							}
							?>
						</tr>
						<tr style="border:1px solid #000;">
							<?php
							for($bln = 1; $bln <= 12;$bln++){
							?>	
							<th width="3%" rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">UMUM</th>
							<th width="3%" rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">BPJS</th>
							<th width="3%" rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">GRATIS</th>
							<th width="3%" rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">SKTM</th>
							<?php
							}
							?>
						</tr>
					</thead>
					<tbody style="font-size:10px;">
						<?php						
						$str = "SELECT * FROM `tbpuskesmas` WHERE `Kota` = '$kota'";
						$str2 = $str." ORDER BY `NamaPuskesmas`";
						// echo $str2;
				
						$query = mysqli_query($koneksi, $str2);					
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kdpuskesmas = $data['KodePuskesmas'];
							$namapuskesmas = $data['NamaPuskesmas'];						
							$tbpasienrj = 'tbpasienrj_'.str_replace(' ', '', $namapuskesmas);
							$dtrj1_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '01' AND `Asuransi`='UMUM'"));
							$dtrj1_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '01' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
							$dtrj1_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '01' AND `Asuransi`='GRATIS'"));
							$dtrj1_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '01' AND `Asuransi`='SKTM'"));
							$dtrj2_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '02' AND `Asuransi`='UMUM'"));
							$dtrj2_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '02' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
							$dtrj2_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '02' AND `Asuransi`='GRATIS'"));
							$dtrj2_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '02' AND `Asuransi`='SKTM'"));
							$dtrj3_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '03' AND `Asuransi`='UMUM'"));
							$dtrj3_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '03' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
							$dtrj3_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '03' AND `Asuransi`='GRATIS'"));
							$dtrj3_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '03' AND `Asuransi`='SKTM'"));
							$dtrj4_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '04' AND `Asuransi`='UMUM'"));
							$dtrj4_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '04' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
							$dtrj4_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '04' AND `Asuransi`='GRATIS'"));
							$dtrj4_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '04' AND `Asuransi`='SKTM'"));
							$dtrj5_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '05' AND `Asuransi`='UMUM'"));
							$dtrj5_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '05' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
							$dtrj5_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '05' AND `Asuransi`='GRATIS'"));
							$dtrj5_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '05' AND `Asuransi`='SKTM'"));
							$dtrj6_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '06' AND `Asuransi`='UMUM'"));
							$dtrj6_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '06' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
							$dtrj6_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '06' AND `Asuransi`='GRATIS'"));
							$dtrj6_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '06' AND `Asuransi`='SKTM'"));
							$dtrj7_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '07' AND `Asuransi`='UMUM'"));
							$dtrj7_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '07' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
							$dtrj7_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '07' AND `Asuransi`='GRATIS'"));
							$dtrj7_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '07' AND `Asuransi`='SKTM'"));
							$dtrj8_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '08' AND `Asuransi`='UMUM'"));
							$dtrj8_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '08' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
							$dtrj8_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '08' AND `Asuransi`='GRATIS'"));
							$dtrj8_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '08' AND `Asuransi`='SKTM'"));
							$dtrj9_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '09' AND `Asuransi`='UMUM'"));
							$dtrj9_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '09' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
							$dtrj9_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '09' AND `Asuransi`='GRATIS'"));
							$dtrj9_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '09' AND `Asuransi`='SKTM'"));
							$dtrj10_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '10' AND `Asuransi`='UMUM'"));
							$dtrj10_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '10' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
							$dtrj10_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '10' AND `Asuransi`='GRATIS'"));
							$dtrj10_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '10' AND `Asuransi`='SKTM'"));
							$dtrj11_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '11' AND `Asuransi`='UMUM'"));
							$dtrj11_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '11' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
							$dtrj11_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '11' AND `Asuransi`='GRATIS'"));
							$dtrj11_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '11' AND `Asuransi`='SKTM'"));
							$dtrj12_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '12' AND `Asuransi`='UMUM'"));
							$dtrj12_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '12' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
							$dtrj12_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '12' AND `Asuransi`='GRATIS'"));
							$dtrj12_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '12' AND `Asuransi`='SKTM'"));
							$dtttl_umum = $dtrj1_umum['Jml'] + $dtrj2_umum['Jml'] + $dtrj3_umum['Jml'] + $dtrj4_umum['Jml'] + $dtrj5_umum['Jml'] + $dtrj6_umum['Jml'] + $dtrj7_umum['Jml'] + $dtrj8_umum['Jml'] + $dtrj9_umum['Jml'] + $dtrj10_umum['Jml'] + $dtrj11_umum['Jml'] + $dtrj12_umum['Jml'];
							$dtttl_bpjs = $dtrj1_bpjs['Jml'] + $dtrj2_bpjs['Jml'] + $dtrj3_bpjs['Jml'] + $dtrj4_bpjs['Jml'] + $dtrj5_bpjs['Jml'] + $dtrj6_bpjs['Jml'] + $dtrj7_bpjs['Jml'] + $dtrj8_bpjs['Jml'] + $dtrj9_bpjs['Jml'] + $dtrj10_bpjs['Jml'] + $dtrj11_bpjs['Jml'] + $dtrj12_bpjs['Jml'];
							$dtttl_gratis = $dtrj1_gratis['Jml'] + $dtrj2_gratis['Jml'] + $dtrj3_gratis['Jml'] + $dtrj4_gratis['Jml'] + $dtrj5_gratis['Jml'] + $dtrj6_gratis['Jml'] + $dtrj7_gratis['Jml'] + $dtrj8_gratis['Jml'] + $dtrj9_gratis['Jml'] + $dtrj10_gratis['Jml'] + $dtrj11_gratis['Jml'] + $dtrj12_gratis['Jml'];
							$dtttl_sktm = $dtrj1_sktm['Jml'] + $dtrj2_sktm['Jml'] + $dtrj3_sktm['Jml'] + $dtrj4_sktm['Jml'] + $dtrj5_sktm['Jml'] + $dtrj6_sktm['Jml'] + $dtrj7_sktm['Jml'] + $dtrj8_sktm['Jml'] + $dtrj9_sktm['Jml'] + $dtrj10_sktm['Jml'] + $dtrj11_sktm['Jml'] + $dtrj12_sktm['Jml'];
							$dtttl = $dtttl_umum + $dtttl_bpjs + $dtttl_gratis;
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namapuskesmas;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj1_umum['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj1_bpjs['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj1_gratis['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj1_sktm['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj2_umum['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj2_bpjs['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj2_gratis['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj2_sktm['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj3_umum['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj3_bpjs['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj3_gratis['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj3_sktm['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj4_umum['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj4_bpjs['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj4_gratis['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj4_sktm['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj5_umum['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj5_bpjs['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj5_gratis['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj5_sktm['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj6_umum['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj6_bpjs['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj6_gratis['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj6_sktm['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj7_umum['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj7_bpjs['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj7_gratis['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj7_sktm['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj8_umum['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj8_bpjs['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj8_gratis['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj8_sktm['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj9_umum['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj9_bpjs['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj9_gratis['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj9_sktm['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj10_umum['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj10_bpjs['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj10_gratis['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj10_sktm['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj11_umum['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj11_bpjs['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj11_gratis['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj11_sktm['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj12_umum['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj12_bpjs['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj12_gratis['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtrj12_sktm['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dtttl);?></td>	
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
</div>	

<!-- <script src="assets/js/jquery.js"></script>
<script type="text/javascript">
	$('.btncls').click(function(){
		$( ".hasilpencarian" ).html( "<p style='text-align:center'><img src='assets/js/loader.gif' width='40px'></p>" );
		var tahun = $(this).parent().parent().find(".tahuncls").val()

		$.post( "lap_loket_carabayar_dinkes.php?jqry=yes", { tahun: tahun })
		  .done(function( data ) {
			 $( ".hasilpencarian" ).html( data );
		});
	});
</script> -->