<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>MIGRASI</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="migrasitbdiagnosa"/>
						<div class="col-sm-2">
							<select name="bulan" class="form-control">
								<option value="Semua" <?php if($_GET['bulan'] == 'Semua'){echo "SELECTED";}?>>Semua</option>
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
						<div class="col-sm-1" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="puskesmas" class="form-control">
							<option value='Semua'>Semua</option>
							<?php
							$kota = $_SESSION['kota'];
							$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `Kota`='$kota' order by `NamaPuskesmas`");
							while($data3 = mysqli_fetch_assoc($queryp)){
								if($_GET['puskesmas'] == $data3['KodePuskesmas']){
									echo "<option value='$data3[KodePuskesmas]' SELECTed>$data3[NamaPuskesmas]</option>";
								}else{
									echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
								}
							}
							?>
							</select>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=migrasitbdiagnosa" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php
		$bulan = $_GET['bulan'];
		$tahun = $_GET['tahun'];
		$puskesmas = $_GET['puskesmas'];
	
		// $tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
		$strdiagnosabln = "SELECT * FROM `tbdiagnosapasien_12`";
		// echo $strdiagnosabln;
		// die();
		
		$querydiagnosabln = mysqli_query($koneksi, $strdiagnosabln);
		while($datalb = mysqli_fetch_assoc($querydiagnosabln)){
			$tbpsnrj = "tbpasienrj_".substr($datalb['NoRegistrasi'],0,11);
			$datapasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `UmurTahun`,`UmurBulan`,`UmurHari`,`JenisKelamin` FROM `$tbpsnrj` WHERE `NoRegistrasi`='$datalb[NoRegistrasi]'"));
			$strdiagnosa = "UPDATE `tbdiagnosapasien_12` SET `UmurTahun`='$datapasienrj[UmurTahun]',`UmurBulan`='$datapasienrj[UmurBulan]',`UmurHari`='$datapasienrj[UmurHari]',`JenisKelamin`='$datapasienrj[JenisKelamin]'";
			$query = mysqli_query($koneksi, $strdiagnosa);
		}
		
		if($query){	
			echo "<script>";
			echo "alert('Data berhasil disimpan...');";
			echo "document.location.href='index.php?page=migrasitbdiagnosa';";
			echo "</script>";
		
		} 
	?>
</div>