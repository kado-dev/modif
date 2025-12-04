<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>LB4-KUNJUNGAN</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_loket_lb4"/>
						<div class="col-sm-2">
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
						<div class="col-sm-1" style ="width:125px;">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_lb4" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_loket_lb4_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</form>
				</div>
			</div>	
		</div>
	</div>
	<?php
	$bulan = $_GET['bulan'];
	$bulanini = date('m');
	$tahun = $_GET['tahun'];
	$tahunini = date('Y');
	$tbpasienrj = "tbpasienrj_".$kodepuskesmas;
		
	if(isset($bulan) and isset($tahun)){
	?>
	<div class="row ">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr style="border:1px solid #000;">
							<th rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
							<th rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">VARIABEL</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">UMUM</th>
							<th rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">JML</th>
							<th colspan="6" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">BPJS</th>
							<th colspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">LAINNYA</th>
							<th rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">JML</th>
							<th rowspan="3" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">JUMLAH</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th rowspan="2" style="text-align:center;border:1px solid #000; padding:3px;">L</th><!--UMUM-->
							<th rowspan="2" style="text-align:center;border:1px solid #000; padding:3px;">P</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">NON PBI</th>
							<th rowspan="2" style="text-align:center;border:1px solid #000; padding:3px;">JUMLAH</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">PBI</th>
							<th rowspan="2" style="text-align:center;border:1px solid #000; padding:3px;">JUMLAH</th>
							<th rowspan="2" style="text-align:center;border:1px solid #000; padding:3px;">L</th><!--UMUM-->
							<th rowspan="2" style="text-align:center;border:1px solid #000; padding:3px;">P</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--NON PBI-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center; border:1px solid #000; padding:3px;">L</th><!--PBI-->
							<th style="text-align:center; border:1px solid #000; padding:3px;">P</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$str = "SELECT * FROM `ref_lb4_pendaftaran`";
						$str2 = $str."order by `Id` ASC";
												
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$variabel = $data['Variabel'];
							
							// tbpasienrj
							// umum
							$umum_l_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='UMUM' AND `StatusKunjungan` = 'Baru'"));
							$umum_p_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='UMUM' AND `StatusKunjungan` = 'Baru'"));
							$umum_jumlah_baru = $umum_l_baru['Jumlah'] + $umum_p_baru['Jumlah'];
							
							$umum_l_lama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='UMUM' AND `StatusKunjungan` = 'Lama'"));
							$umum_p_lama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='UMUM' AND `StatusKunjungan` = 'Lama'"));
							$umum_jumlah_lama = $umum_l_lama['Jumlah'] + $umum_p_lama['Jumlah'];
							
							$umum_l_bp = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='UMUM' AND `PoliPertama` = 'POLI UMUM'"));
							$umum_p_bp = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='UMUM' AND `PoliPertama` = 'POLI UMUM'"));
							$umum_jumlah_bp = $umum_l_bp['Jumlah'] + $umum_p_bp['Jumlah'];
							
							$umum_l_kia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='UMUM' AND `PoliPertama` = 'POLI KIA'"));
							$umum_p_kia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='UMUM' AND `PoliPertama` = 'POLI KIA'"));
							$umum_jumlah_kia = $umum_l_kia['Jumlah'] + $umum_p_kia['Jumlah'];
							
							$umum_l_kb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='UMUM' AND `PoliPertama` = 'POLI KB'"));
							$umum_p_kb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='UMUM' AND `PoliPertama` = 'POLI KB'"));
							$umum_jumlah_kb = $umum_l_kb['Jumlah'] + $umum_p_kb['Jumlah'];
							
							$umum_l_gigi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='UMUM' AND `PoliPertama` = 'POLI GIGI'"));
							$umum_p_gigi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='UMUM' AND `PoliPertama` = 'POLI GIGI'"));
							$umum_jumlah_gigi = $umum_l_gigi['Jumlah'] + $umum_p_gigi['Jumlah'];
							
							// nonpbi
							$nonpbi_l_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS NON PBI' AND `StatusKunjungan` = 'Baru'"));
							$nonpbi_p_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS NON PBI' AND `StatusKunjungan` = 'Baru'"));
							$nonpbi_jumlah_baru = $nonpbi_l_baru['Jumlah'] + $nonpbi_p_baru['Jumlah'];
							
							$nonpbi_l_lama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS NON PBI' AND `StatusKunjungan` = 'Lama'"));
							$nonpbi_p_lama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS NON PBI' AND `StatusKunjungan` = 'Lama'"));
							$nonpbi_jumlah_lama = $nonpbi_l_lama['Jumlah'] + $nonpbi_p_lama['Jumlah'];
							
							$nonpbi_l_bp = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS NON PBI' AND `PoliPertama` = 'POLI UMUM'"));
							$nonpbi_p_bp = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS NON PBI' AND `PoliPertama` = 'POLI UMUM'"));
							$nonpbi_jumlah_bp = $nonpbi_l_bp['Jumlah'] + $nonpbi_p_bp['Jumlah'];
							
							$nonpbi_l_kia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS NON PBI' AND `PoliPertama` = 'POLI KIA'"));
							$nonpbi_p_kia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS NON PBI' AND `PoliPertama` = 'POLI KIA'"));
							$nonpbi_jumlah_kia = $nonpbi_l_kia['Jumlah'] + $nonpbi_p_kia['Jumlah'];
							
							$nonpbi_l_kb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS NON PBI' AND `PoliPertama` = 'POLI KB'"));
							$nonpbi_p_kb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS NON PBI' AND `PoliPertama` = 'POLI KB'"));
							$nonpbi_jumlah_kb = $nonpbi_l_kb['Jumlah'] + $nonpbi_p_kb['Jumlah'];
							
							$nonpbi_l_gigi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS NON PBI' AND `PoliPertama` = 'POLI GIGI'"));
							$nonpbi_p_gigi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS NON PBI' AND `PoliPertama` = 'POLI GIGI'"));
							$nonpbi_jumlah_gigi = $nonpbi_l_gigi['Jumlah'] + $nonpbi_p_gigi['Jumlah'];
							
							// pbi
							$pbi_l_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS PBI' AND `StatusKunjungan` = 'Baru'"));
							$pbi_p_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS PBI' AND `StatusKunjungan` = 'Baru'"));
							$pbi_jumlah_baru = $pbi_l_baru['Jumlah'] + $pbi_p_baru['Jumlah'];
							
							$pbi_l_lama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS PBI' AND `StatusKunjungan` = 'Lama'"));
							$pbi_p_lama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS PBI' AND `StatusKunjungan` = 'Lama'"));
							$pbi_jumlah_lama = $pbi_l_lama['Jumlah'] + $pbi_p_lama['Jumlah'];
							
							$pbi_l_bp = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS PBI' AND `PoliPertama` = 'POLI UMUM'"));
							$pbi_p_bp = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS PBI' AND `PoliPertama` = 'POLI UMUM'"));
							$pbi_jumlah_bp = $pbi_l_bp['Jumlah'] + $pbi_p_bp['Jumlah'];
							
							$pbi_l_kia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS PBI' AND `PoliPertama` = 'POLI KIA'"));
							$pbi_p_kia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS PBI' AND `PoliPertama` = 'POLI KIA'"));
							$pbi_jumlah_kia = $pbi_l_kia['Jumlah'] + $pbi_p_kia['Jumlah'];
							
							$pbi_l_kb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS PBI' AND `PoliPertama` = 'POLI KB'"));
							$pbi_p_kb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS PBI' AND `PoliPertama` = 'POLI KB'"));
							$pbi_jumlah_kb = $pbi_l_kb['Jumlah'] + $pbi_p_kb['Jumlah'];
							
							$pbi_l_gigi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS PBI' AND `PoliPertama` = 'POLI GIGI'"));
							$pbi_p_gigi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS PBI' AND `PoliPertama` = 'POLI GIGI'"));
							$pbi_jumlah_gigi = $pbi_l_gigi['Jumlah'] + $pbi_p_gigi['Jumlah'];
							
							// lainnya
							$lainnya_l_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='LAINNYA' AND `StatusKunjungan` = 'Baru'"));
							$lainnya_p_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='LAINNYA' AND `StatusKunjungan` = 'Baru'"));
							$lainnya_jumlah_baru = $lainnya_l_baru['Jumlah'] + $lainnya_p_baru['Jumlah'];
							
							$lainnya_l_lama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='LAINNYA' AND `StatusKunjungan` = 'Lama'"));
							$lainnya_p_lama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='LAINNYA' AND `StatusKunjungan` = 'Lama'"));
							$lainnya_jumlah_lama = $lainnya_l_lama['Jumlah'] + $lainnya_p_lama['Jumlah'];
							
							$lainnya_l_bp = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='LAINNYA' AND `PoliPertama` = 'POLI UMUM'"));
							$lainnya_p_bp = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='LAINNYA' AND `PoliPertama` = 'POLI UMUM'"));
							$lainnya_jumlah_bp = $lainnya_l_bp['Jumlah'] + $lainnya_p_bp['Jumlah'];
							
							$lainnya_l_kia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='LAINNYA' AND `PoliPertama` = 'POLI KIA'"));
							$lainnya_p_kia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='LAINNYA' AND `PoliPertama` = 'POLI KIA'"));
							$lainnya_jumlah_kia = $lainnya_l_kia['Jumlah'] + $lainnya_p_kia['Jumlah'];
							
							$lainnya_l_kb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='LAINNYA' AND `PoliPertama` = 'POLI KB'"));
							$lainnya_p_kb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='LAINNYA' AND `PoliPertama` = 'POLI KB'"));
							$lainnya_jumlah_kb = $lainnya_l_kb['Jumlah'] + $lainnya_p_kb['Jumlah'];
							
							$lainnya_l_gigi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='LAINNYA' AND `PoliPertama` = 'POLI GIGI'"));
							$lainnya_p_gigi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='LAINNYA' AND `PoliPertama` = 'POLI GIGI'"));
							$lainnya_jumlah_gigi = $lainnya_l_gigi['Jumlah'] + $lainnya_p_gigi['Jumlah'];
							
							// total
							$total_baru = $umum_jumlah_baru + $nonpbi_jumlah_baru + $pbi_jumlah_baru + $lainnya_jumlah_baru;
							$total_lama = $umum_jumlah_lama + $nonpbi_jumlah_lama + $pbi_jumlah_lama + $lainnya_jumlah_lama;
							$total_bp = $umum_jumlah_bp + $nonpbi_jumlah_bp + $pbi_jumlah_bp + $lainnya_jumlah_bp;
							$total_kia = $umum_jumlah_kia + $nonpbi_jumlah_kia + $pbi_jumlah_kia + $lainnya_jumlah_kia;
							$total_kb = $umum_jumlah_kb + $nonpbi_jumlah_kb + $pbi_jumlah_kb + $lainnya_jumlah_kb;
							$total_gigi= $umum_jumlah_gigi + $nonpbi_jumlah_gigi + $pbi_jumlah_gigi + $lainnya_jumlah_gigi;
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['Variabel'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><!--UMUM L-->
								<?php 
									if($variabel == "Kunjungan Puskesmas (Baru)"){echo $umum_l_baru['Jumlah'];}
									if($variabel == "Kunjungan Puskesmas (Lama)"){echo $umum_l_lama['Jumlah'];}
									if($variabel == "Kunjungan Rawat Jalan BP"){echo $umum_l_bp['Jumlah'];}
									if($variabel == "Kunjungan Rawat Jalan KIA"){echo $umum_l_kia['Jumlah'];}
									if($variabel == "Kunjungan Rawat Jalan KB"){echo $umum_l_kb['Jumlah'];}
									if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $umum_l_gigi['Jumlah'];}
								?>
								</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><!--UMUM P-->
								<?php 
									if($variabel == "Kunjungan Puskesmas (Baru)"){echo $umum_p_baru['Jumlah'];}
									if($variabel == "Kunjungan Puskesmas (Lama)"){echo $umum_p_lama['Jumlah'];}
									if($variabel == "Kunjungan Rawat Jalan BP"){echo $umum_p_bp['Jumlah'];}
									if($variabel == "Kunjungan Rawat Jalan KIA"){echo $umum_p_kia['Jumlah'];}
									if($variabel == "Kunjungan Rawat Jalan KB"){echo $umum_p_kb['Jumlah'];}
									if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $umum_p_gigi['Jumlah'];}
								?>
								</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;">
									<?php 
										if($variabel == "Kunjungan Puskesmas (Baru)"){echo $umum_jumlah_baru;}
										if($variabel == "Kunjungan Puskesmas (Lama)"){echo $umum_jumlah_lama;}
										if($variabel == "Kunjungan Rawat Jalan BP"){echo $umum_jumlah_bp;}
										if($variabel == "Kunjungan Rawat Jalan KIA"){echo $umum_jumlah_kia;}
										if($variabel == "Kunjungan Rawat Jalan KB"){echo $umum_jumlah_kb;}
										if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $umum_jumlah_gigi;}
									?>
								</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><!--NON PBI L-->
									<?php 
										if($variabel == "Kunjungan Puskesmas (Baru)"){echo $nonpbi_l_baru['Jumlah'];}
										if($variabel == "Kunjungan Puskesmas (Lama)"){echo $nonpbi_l_lama['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan BP"){echo $nonpbi_l_bp['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan KIA"){echo $nonpbi_l_kia['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan KB"){echo $nonpbi_l_kb['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $nonpbi_l_gigi['Jumlah'];}
									?>
								</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><!--NON PBI P-->
									<?php 
										if($variabel == "Kunjungan Puskesmas (Baru)"){echo $nonpbi_p_baru['Jumlah'];}
										if($variabel == "Kunjungan Puskesmas (Lama)"){echo $nonpbi_p_lama['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan BP"){echo $nonpbi_p_bp['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan KIA"){echo $nonpbi_p_kia['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan KB"){echo $nonpbi_p_kb['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $nonpbi_p_gigi['Jumlah'];}
									?>
								</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;">
									<?php 
										if($variabel == "Kunjungan Puskesmas (Baru)"){echo $nonpbi_jumlah_baru;}
										if($variabel == "Kunjungan Puskesmas (Lama)"){echo $nonpbi_jumlah_lama;}
										if($variabel == "Kunjungan Rawat Jalan BP"){echo $nonpbi_jumlah_bp;}
										if($variabel == "Kunjungan Rawat Jalan KIA"){echo $nonpbi_jumlah_kia;}
										if($variabel == "Kunjungan Rawat Jalan KB"){echo $nonpbi_jumlah_kb;}
										if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $nonpbi_jumlah_kb;}
									?>
								</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><!--PBI L-->
									<?php 
										if($variabel == "Kunjungan Puskesmas (Baru)"){echo $pbi_l_baru['Jumlah'];}
										if($variabel == "Kunjungan Puskesmas (Lama)"){echo $pbi_l_lama['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan BP"){echo $pbi_l_bp['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan KIA"){echo $pbi_l_kia['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan KB"){echo $pbi_l_kb['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $pbi_l_gigi['Jumlah'];}
									?>
								</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><!--PBI P-->
									<?php 
										if($variabel == "Kunjungan Puskesmas (Baru)"){echo $pbi_p_baru['Jumlah'];}
										if($variabel == "Kunjungan Puskesmas (Lama)"){echo $pbi_p_lama['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan BP"){echo $pbi_p_bp['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan KIA"){echo $pbi_p_kia['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan KB"){echo $pbi_p_kb['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $pbi_p_gigi['Jumlah'];}
									?>
								</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;">
									<?php 
										if($variabel == "Kunjungan Puskesmas (Baru)"){echo $pbi_jumlah_baru;}
										if($variabel == "Kunjungan Puskesmas (Lama)"){echo $pbi_jumlah_lama;}
										if($variabel == "Kunjungan Rawat Jalan BP"){echo $pbi_jumlah_bp;}
										if($variabel == "Kunjungan Rawat Jalan KIA"){echo $pbi_jumlah_kia;}
										if($variabel == "Kunjungan Rawat Jalan KB"){echo $pbi_jumlah_kb;}
										if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $pbi_jumlah_gigi;}
									?>
								</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><!--LAINNYA L-->
									<?php 
										if($variabel == "Kunjungan Puskesmas (Baru)"){echo $lainnya_l_baru['Jumlah'];}
										if($variabel == "Kunjungan Puskesmas (Lama)"){echo $lainnya_l_lama['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan BP"){echo $lainnya_l_bp['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan KIA"){echo $lainnya_l_kia['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan KB"){echo $lainnya_l_kb['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $lainnya_l_gigi['Jumlah'];}
									?>
								</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><!--LAINNYA P-->
									<?php 
										if($variabel == "Kunjungan Puskesmas (Baru)"){echo $lainnya_p_baru['Jumlah'];}
										if($variabel == "Kunjungan Puskesmas (Lama)"){echo $lainnya_p_lama['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan BP"){echo $lainnya_p_bp['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan KIA"){echo $lainnya_p_kia['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan KB"){echo $lainnya_p_kb['Jumlah'];}
										if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $lainnya_p_gigi['Jumlah'];}
									?>
								</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;">
									<?php 
										if($variabel == "Kunjungan Puskesmas (Baru)"){echo $lainnya_jumlah_baru;}
										if($variabel == "Kunjungan Puskesmas (Lama)"){echo $lainnya_jumlah_lama;}
										if($variabel == "Kunjungan Rawat Jalan BP"){echo $lainnya_jumlah_bp;}
										if($variabel == "Kunjungan Rawat Jalan KIA"){echo $lainnya_jumlah_kia;}
										if($variabel == "Kunjungan Rawat Jalan KB"){echo $lainnya_jumlah_kb;}
										if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $lainnya_jumlah_gigi;}
									?>
								</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><!--TOTAL-->
									<?php 
										if($variabel == "Kunjungan Puskesmas (Baru)"){echo $total_baru;}
										if($variabel == "Kunjungan Puskesmas (Lama)"){echo $total_lama;}
										if($variabel == "Kunjungan Rawat Jalan BP"){echo $total_bp;}
										if($variabel == "Kunjungan Rawat Jalan KIA"){echo $total_kia;}
										if($variabel == "Kunjungan Rawat Jalan KB"){echo $total_kb;}
										if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $total_gigi;}
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
						echo "<li><a href='?page=lap_loket_lb4&keydate1=$keydate1&keydate2=$keydate2&opsiform=$opsiform&bulan=$bulan&tahun=$tahun&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>	

<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
$('.opsiform').change(function(){
	if($(this).val() == 'bulan'){
		$(".bulanformcari").show();
		$(".tanggalformcari").hide();
	}else if($(this).val() == 'tahun'){	
		$(".bulanformcari").hide();
		$(".tahunformcari").show();	
	}else{	
		$(".bulanformcari").hide();
		$(".tanggalformcari").show();
	}
});	
$(document).ready(function(){
	if($('.opsiform').val() == 'bulan'){
		$(".bulanformcari").show();
		$(".tanggalformcari").hide();
	}else{	
		$(".bulanformcari").hide();
		$(".tanggalformcari").show();
	}
});	
</script>