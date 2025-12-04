<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul">PENYAKIT & PEMAKAIAN OBAT TERBANYAK</h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_farmasi_pemakaianobat_terbanyak"/>
						<div class="col-xl-2">
							<select name="bulan" class="form-control">
								<option value="semua" <?php if($bln == 'semua'){echo "SELECTED";}?>>Semua</option>
								<option value="01" <?php if($_GET['bulan'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulan'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulan'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulan'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulan'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulan'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulan'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulan'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulan'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulan'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulan'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulan'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-2">
							<input type="number" class="form-control" name="limit" value="10">
						</div>
						<div class="col-xl-6">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_penyakit_terbanyak" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
		
	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$thn = substr($tahun,2,2);
	$limit = $_GET['limit'];
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;

	if($bulan != null AND $tahun != null){
	?>

	<div class="table-responsive printini" style="overflow: hidden;">
		<div class="printheader">
			<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
			<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
			<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
			<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
			<hr style="margin:3px; border:1px solid #000">
			<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN PENYAKIT & PEMAKAIAN OBAT TERBANYAK</b></span><br>
			<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
			<br/>
		</div>

		<div class="atastabel font11">
			<div style="float:left; width:65%; margin-bottom:10px;">
				<table style="width:300px;">
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
				<table>
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

		<div class="row">
			<div class="col-sm-12">
				<p><b>PENYAKIT TERBANYAK</b><p>
				<table class="table-judul-laporan">
					<thead>
						<tr style="border:1px solid #000;">
							<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">KODE</th>
							<th width="30%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NAMA PENYAKIT Penyakit</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">JUMLAH</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if(isset($_GET['limit'])){
							$jumlah_perpage = $_GET['limit'];
						}else{
							$jumlah_perpage = 10;
						}
						
						$mulai=0;
						$kasus = $_GET['kasus'];
						
						if($_GET['bulan'] == 'semua'){
							for($i = 1; $i<=12; $i++){
								if(strlen($i) == 2){
									$nn = $i;
								}else{
									$nn = "0".$i;
								}
								$tbdiagnosapasiens = 'tbdiagnosapasien_'.$nn;
								$strarr[] = "(SELECT `TanggalDiagnosa`, `KodeDiagnosa`, COUNT(`KodeDiagnosa`) as `Jumlahs` FROM `$tbdiagnosapasiens` 
										WHERE SUBSTRING(`NoRegistrasi`,1,11) = '$kodepuskesmas' AND YEAR(`TanggalDiagnosa`)='$tahun' AND `KodeDiagnosa` <> 'Z00.0'
										GROUP BY KodeDiagnosa)";
							}		
							$str = "SELECT `TanggalDiagnosa`, `KodeDiagnosa`, SUM(`Jumlahs`) as Jumlah FROM(".implode(" union all ",$strarr).") t_unions GROUP BY KodeDiagnosa ORDER BY Jumlah DESC limit 0,10";
						}else{
							$str = "SELECT a.KodeDiagnosa, a.Kasus as Kasus, COUNT(a.KodeDiagnosa) AS Jumlah 
								FROM `$tbdiagnosapasien` a 
								LEFT JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi
								WHERE SUBSTRING(a.NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(a.TanggalDiagnosa) = '$tahun' AND a.KodeDiagnosa <> 'Z00.0'".$polipertamas."
								GROUP BY KodeDiagnosa 
								ORDER BY Jumlah DESC
								LIMIT $mulai,$jumlah_perpage";			
						}							
						// echo $str;
						
						$query = mysqli_query($koneksi,$str);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kodediagnosa = $data['KodeDiagnosa'];
							
							// diagnosa
							$dtdiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa`='$kodediagnosa'"));
							
							if($_SESSION['kodepuskesmas'] == '-'){
								$jml_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jumlah 
										FROM `$tbdiagnosapasien` a 
										LEFT JOIN `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi
										WHERE ".$kodepuskesmas." YEAR(a.TanggalDiagnosa)='$tahun' and MONTH(a.TanggalDiagnosa)='$bulan'
										and a.KodeDiagnosa = '$kodediagnosa' and b.JenisKelamin = 'L'".$polipertamas));
								$jml_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jumlah 
										FROM `$tbdiagnosapasien` a 
										LEFT JOIN `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi
										WHERE ".$kodepuskesmas." YEAR(a.TanggalDiagnosa)='$tahun' and MONTH(a.TanggalDiagnosa)='$bulan'
										and a.KodeDiagnosa = '$kodediagnosa' and b.JenisKelamin = 'P'".$polipertamas));
							}else{
								if($_GET['bulan'] == 'semua'){
									// $strarr_laki = "";
									for($i = 1; $i<=12; $i++){
										if(strlen($i) == 2){
											$nn = $i;
										}else{
											$nn = "0".$i;
										}
										$tbdiagnosapasiens = 'tbdiagnosapasien_'.$nn;
										
										// $tbpasienrj = 'tbpasienrj_'.$nn;
										$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
										$strarr_laki[$kodediagnosa][] = "(SELECT COUNT(a.NoRegistrasi) as `Jumlah` 
												FROM `$tbdiagnosapasiens` a 
												LEFT JOIN `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi
												WHERE SUBSTRING(a.`NoRegistrasi`,1,11) = '$kodepuskesmas' AND YEAR(a.`TanggalDiagnosa`)='$tahun' AND 
												a.`KodeDiagnosa`='$kodediagnosa' AND b.JenisKelamin = 'L')";
										$strarr_perempuan[$kodediagnosa][] = "(SELECT COUNT(a.NoRegistrasi) as `Jumlah` 
												FROM `$tbdiagnosapasiens` a 
												LEFT JOIN `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi
												WHERE SUBSTRING(a.`NoRegistrasi`,1,11) = '$kodepuskesmas' AND YEAR(a.`TanggalDiagnosa`)='$tahun' AND 
												a.`KodeDiagnosa`='$kodediagnosa' AND b.JenisKelamin = 'P')";		
									}		
									$jml_laki = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(Jumlah) AS Jumlah FROM(".implode(" union all ",$strarr_laki[$kodediagnosa]).") t_unions ORDER BY Jumlah DESC limit 0,10"));
									$jml_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(Jumlah) AS Jumlah FROM(".implode(" union all ",$strarr_perempuan[$kodediagnosa]).") t_unions ORDER BY Jumlah DESC limit 0,10"));
									//echo $jml_laki;
								}else{	
									$jml_laki = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jumlah 
											FROM `$tbdiagnosapasien` a 
											LEFT JOIN `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi
											WHERE SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalDiagnosa)='$tahun' and MONTH(a.TanggalDiagnosa)='$bulan'
											and a.KodeDiagnosa = '$kodediagnosa' and b.JenisKelamin = 'L'".$polipertamas)); 
									$jml_perempuan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jumlah 
											FROM `$tbdiagnosapasien` a 
											LEFT JOIN `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi
											WHERE SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalDiagnosa)='$tahun' and MONTH(a.TanggalDiagnosa)='$bulan'
											and a.KodeDiagnosa = '$kodediagnosa' and b.JenisKelamin = 'P'".$polipertamas));
								}
							}
							$total = $jml_laki['Jumlah'] + $jml_perempuan['Jumlah'];
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $kodediagnosa;?></td>
								<td style="text-align:left;border:1px solid #000; padding:3px;"><?php echo $dtdiagnosa['Diagnosa'];?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $jml_laki['Jumlah'];?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $jml_perempuan['Jumlah'];?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total;?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table><br/>
			</div>
			
			<div class="col-sm-12">
				<p><b>PEMAKAIAN OBAT TERBANYAK</b><p>
				<table class="table-judul-laporan">
					<thead>
						<tr style="border:1px solid #000;">
							<th width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
							<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">KODE</th>
							<th width="40%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NAMA OBAT</th>
							<th width="20%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">JUMLAH PEMAKAIAN</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if(isset($_GET['limit'])){
							$jumlah_perpage = $_GET['limit'];
						}else{
							$jumlah_perpage = 10;
						}
						
						$mulai = 0;
						$no = 0;
						$str_obat = "SELECT a.NoResep, a.KodeBarang, SUM(a.jumlahobat) AS Jml, b.NamaBarang
						FROM `$tbresepdetail` a JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang
						WHERE SUBSTRING(a.NoResep,15,2) = '$bulan' AND SUBSTRING(a.NoResep,13,2) = '$thn'
						GROUP BY a.KodeBarang
						ORDER BY Jml DESC
						limit $mulai,$jumlah_perpage";
						// echo $str_obat;
						// die();
						
						$query_obat = mysqli_query($koneksi,$str_obat);
						while($data_obat = mysqli_fetch_assoc($query_obat)){
							$no = $no + 1;
							$kodebarang = $data_obat['KodeBarang'];
							$namabarang = $data_obat['NamaBarang'];
							$jml_pemakaian = $data_obat['Jml'];
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $kodebarang;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namabarang;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($data_obat['Jml']);?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>

		<div class="row bawahtabel">
			<table class="table table-condensed">
				<tr>
					<td style="text-align:center;" width="50%">
					Mengetahui :<br>
					KEPALA PUSKESMAS <?php echo $namapuskesmas;?>
					<br>
					<br>
					<br>
					(..............................)
					</td>
					
					
					<td style="text-align:center;" width="50%">
					Yang Melaporkan :<br>
					APOTEKER UPT YANKES <?php echo strtoupper($kecamatan);?>
					<br>
					<br>
					<br>
					(..............................)
					</td>
				</tr>
			</table>
		</div>
	</div>
	<?php
	}
	?>
</div>	