<?php
	// include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DIAGNOSA P2P</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_sebengkok"/>
						<div class="col-xl-2">
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
						<div class="col-xl-2" style ="width:125px">
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
							<a href="?page=lap_P2M_sebengkok" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
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
	$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:1px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:1px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:1px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN DIAGNOSA</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
	</div><br/>
	
	<div class="row font10">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th rowspan="4" width="5%">NO.</th>
							<th rowspan="4" width="10%">KODE</th>
							<th rowspan="4" width="60%">DIADNOSA</th>
							<th rowspan="4" width="15%">JENIS PENYAKIT</th>
							<th rowspan="4" width="10%">JUMLAH KASUS</th>
						</tr>
					</thead>
					<tbody style="font-size:12px;">
						<?php
						$no = 0;
						
						// insert ke $tbdiagnosapasien
						$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
						$strdiagnosabln = "SELECT * FROM `$tbdiagnosapasien` WHERE YEAR(`TanggalDiagnosa`)='$tahun' AND MONTH(`TanggalDiagnosa`)='$bulan'";
						
						$querydiagnosabln = mysqli_query($koneksi,$strdiagnosabln);
						mysqli_query($koneksi, "DELETE FROM `tbdiagnosapasien_bulan`");
						while($datalb = mysqli_fetch_assoc($querydiagnosabln)){
							$strdiagnosa = "INSERT INTO `tbdiagnosapasien_bulan`(`TanggalDiagnosa`, `NoCM`, `NoRegistrasi`, `KodeDiagnosa`, `Kasus`, `Kelompok`) VALUES 
							('$datalb[TanggalDiagnosa]','$datalb[NoCM]','$datalb[NoRegistrasi]','$datalb[KodeDiagnosa]','$datalb[Kasus]','$datalb[Kelompok]')";
							mysqli_query($koneksi, $strdiagnosa);
						}
						
						$str = "SELECT * FROM `tbdiagnosasebengkok`";
						$str2 = $str." order by `JenisPenyakit`,`KodeDiagnosa`";
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kodedgs = $data['KodeDiagnosa'];
							if($bulan == "Semua"){
								$jumlah = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND b.KodeDiagnosa like '%$kodedgs%'"));
							}else{
								$jumlah = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jml FROM `$tbpasienrj` a join `tbdiagnosapasien_bulan` b on a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND b.KodeDiagnosa like '%$kodedgs%'"));
							}	
							// tbdiagnosabpjs
							$dtdiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa`='$kodedgs'"));
							?>
							<tr>
								<td align="center" width="3%"><?php echo $no;?></td>
								<td align="center" width="6%"><?php echo $data['KodeDiagnosa'];?></td>
								<td align="left" width="15%"><?php echo strtoupper($dtdiagnosa['Diagnosa']);?></td>
								<td align="center" width="15%"><?php echo strtoupper($data['JenisPenyakit']);?></td>
								<td align="right"><?php echo $jumlah['Jml'];?></td>
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