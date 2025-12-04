<?php
	// include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>LB1-PENYAKIT</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">	
						<input type="hidden" name="page" value="lap_lb1_penyakit_tarakan"/>
						<div class="col-xl-2 bulanformcari">
							<select name="bulan" class="form-control">
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
						<div class="col-xl-2 tahunformcari" style ="width:125px;">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_lb1_penyakit_tarakan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_lb1_penyakit_tarakan_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>	
				</form>
			</div>
		</div>
	</div>
	<?php
	$bulan = $_GET['bulan'];
	$bulanini = date('m');
	$tahun = $_GET['tahun'];
	$tahunini = date('Y');
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
		
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN LB1- PENYAKIT</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: 
			<?php 
				echo nama_bulan($bulan)." ".$tahun;
			?>
		</span><br/>
	</div>

	<div class="atastabel font11">
		<div style="float:left; width:35%; margin-bottom:10px;">	
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

	<div class="row ">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr>
							<th rowspan="3" width="3%">NO.</th>
							<th rowspan="3" width="7%">KODE</th>
							<th rowspan="3" width="20%">NAMA PENYAKIT</th>
							<th colspan="24">JUMLAH KASUS BARU MENURUT GOLONGAN UMUR</th>
							<th rowspan="2"  colspan="3">KASUS BARU</th>
							<th rowspan="2"  colspan="3">KASUS LAMA</th>
							<th rowspan="3">TOTAL KASUS</th>
						</tr>
						<tr>
							<th colspan="2">0-7HR</th>
							<th colspan="2">8-30HR</th>
							<th colspan="2"><1TH</th>
							<th colspan="2">1-4TH</th>
							<th colspan="2">5-9TH</th>
							<th colspan="2">10-14TH</th>
							<th colspan="2">15-19TH</th>
							<th colspan="2">20-44TH</th>
							<th colspan="2">45-54TH</th>
							<th colspan="2">55-59TH</th>
							<th colspan="2">60-69TH</th>
							<th colspan="2">>=70TH</th>
						</tr>
						<tr>
							<th>L</th><!--0-7Hr-->
							<th>P</th>
							<th>L</th><!--8-30Hr-->
							<th>P</th>
							<th>L</th><!--<1Th-->
							<th>P</th>
							<th>L</th><!--1-4Th-->
							<th>P</th>
							<th>L</th><!--5-9Th-->
							<th>P</th>
							<th>L</th><!--10-14Th-->
							<th>P</th>
							<th>L</th><!--15-19Th-->
							<th>P</th>
							<th>L</th><!--20-24Th-->
							<th>P</th>
							<th>L</th><!--45-54Th-->
							<th>P</th>
							<th>L</th><!--55-59Th-->
							<th>P</th>
							<th>L</th><!--60-69Th-->
							<th>P</th>
							<th>L</th><!--70Th-->
							<th>P</th>
							<th rowspan="2">L</th><!--Kasus Baru-->
							<th rowspan="2">P</th>
							<th rowspan="2">JML</th>
							<th rowspan="2">L</th><!--Kasus Lama-->
							<th rowspan="2">P</th>
							<th rowspan="2">JML</th>
						</tr>
					</thead>
					<tbody style="font-size:12px;">
						<?php
						$jumlah_perpage = 50;
						$waktu = "YEAR(TanggalRegistrasi) = '$tahun'";							
						// insert ke tbdiagnosapasien_bulan
						$strdiagnosabln = "SELECT * FROM `$tbdiagnosapasien` WHERE YEAR(`TanggalDiagnosa`)='$tahun' AND MONTH(`TanggalDiagnosa`)='$bulan'";
						$querydiagnosabln = mysqli_query($koneksi,$strdiagnosabln);
						mysqli_query($koneksi, "DELETE FROM `tbdiagnosapasien_bulan`");
						while($datalb = mysqli_fetch_assoc($querydiagnosabln)){
							$strdiagnosa = "INSERT INTO `tbdiagnosapasien_bulan`(`TanggalDiagnosa`, `NoCM`, `NoRegistrasi`, `KodeDiagnosa`, `Kasus`, `Kelompok`) VALUES 
							('$datalb[TanggalDiagnosa]','$datalb[NoCM]','$datalb[NoRegistrasi]','$datalb[KodeDiagnosa]','$datalb[Kasus]','$datalb[Kelompok]')";
							mysqli_query($koneksi, $strdiagnosa);
						}
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$str = "SELECT * FROM `tbdiagnosa`";
						$str2 = $str."order by `KodeDiagnosa` ASC limit $mulai,$jumlah_perpage";
											
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}				
										
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kodedgs = '%'.$data['KodeDiagnosaBPJS']."%";
							
							$umur17hrL= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur17hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '1' AND '7' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur1830hrL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur1830hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan = '0' AND a.UmurHari Between '8' AND '30' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur12blnL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur12blnP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun = '0' AND a.UmurBulan Between '2' AND '12' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur14L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur14P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '1' AND '4' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur59L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur59P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '5' AND '9' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur1014L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur1014P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '10' AND '14' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur1519L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur1519P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '15' AND '19' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur2044L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur2044P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '20' AND '44' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur4554L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							// echo "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'";
							$umur4554P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '45' AND '54' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur5559L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur5559P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '55' AND '59' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur6069L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur6069P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '60' AND '69' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
							$umur70100L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu  AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Baru'"));
							$umur70100P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu  AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '70' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Baru'"));
													
							// kasus lama
							$lama_l = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu  AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '0' AND '100' AND a.JenisKelamin = 'L' AND b.Kasus = 'Lama'"));
							$lama_p = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE $waktu  AND b.KodeDiagnosa like '$kodedgs' AND a.UmurTahun Between '0' AND '100' AND a.JenisKelamin = 'P' AND b.Kasus = 'Lama'"));
							$t_lama_l = $lama_l['Jml'];
							$t_lama_p = $lama_p['Jml'];
							$total_lama = $t_lama_l + $t_lama_p;
							
							// kasus baru
							$baru_l = $umur17hrL['Jml'] + $umur1830hrL['Jml'] + $umur12blnL['Jml'] + $umur14L['Jml'] + $umur59L['Jml']
								+ $umur1014L['Jml'] + $umur1519L['Jml'] + $umur2044L['Jml'] + $umur4554L['Jml'] + $umur5559L['Jml']
								+ $umur6069L['Jml'] + $umur70100L['Jml'];
							$baru_p = $umur17hrP['Jml'] + $umur1830hrP['Jml'] + $umur12blnP['Jml'] + $umur14P['Jml'] + $umur59P['Jml']
								+ $umur1014P['Jml'] + $umur1519P['Jml'] + $umur2044P['Jml'] + $umur4554P['Jml'] + $umur5559P['Jml']
								+ $umur6069P['Jml'] + $umur70100P['Jml'];
							$total_baru = $baru_l+ $baru_p;
							$total = $total_baru + $total_lama;
							
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['KodeDiagnosa'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($data['NamaDiagnosa']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur17hrL['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur17hrP['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1830hrL['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1830hrP['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur12blnL['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur12blnP['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur14L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur14P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur59L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur59P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1014L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1014P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1519L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1519P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur2044L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur2044P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4554L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4554P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur5559L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur5559P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur6069L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur6069P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur70100L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur70100P['Jml'];?></td>
								<!--kasus baru-->
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $baru_l;?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $baru_p;?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total_baru;?></td>
								<!--kasus lama-->
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $lama_l['Jml'];?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $lama_p['Jml'];?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total_lama;?></td>
								<!--total kasus baru + lama-->
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total;?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>

	<hr class="noprint"><!--css-->
	<ul class="pagination noprint">
		<?php
			$bulan = $_GET['bulan'];
			$tahun = $_GET['tahun'];
			$query2 = mysqli_query($koneksi,$str);
			$jumlah_query = mysqli_num_rows($query2);
			
			if(($jumlah_query % $jumlah_perpage) > 0){
				$jumlah = ($jumlah_query / $jumlah_perpage)+1;
			}else{
				$jumlah = $jumlah_query / $jumlah_perpage;
			}
			for ($i=1;$i<=$jumlah;$i++){
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=lap_lb1_penyakit_tarakan&keydate1=$keydate1&keydate2=$keydate2&bulan=$bulan&tahun=$tahun&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>