<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>MONITORING INDIKATOR SPM (DIABETES)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_ptm_spm_diabet"/>
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
							<a href="?page=lap_P2M_ptm_spm_diabet" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>
			</div>	
		</div>
	</div>

	<?php
	$tahun = $_GET['tahun'];
	$tahunini = date('Y');
	if(isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>MONITORING PENCAPAIAN KINERJA UKM DENGAN INDIKATOR SPM (DIABETES)</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
		<br/>
	</div>

	<div class="atastabel font11">
		<div style="float:left; width:65%; margin-bottom:10px;">
			<table style="font-size:10px; width:300px;">
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
			<div class="table-responsive">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr style="border:1px solid #000;">
							<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th colspan="3" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Standar Pelayanan Minimal</th>
							<th colspan="12" width="70%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Setiap penderita diabetes melitus mendapatkan pelayanan kesehatan sesuai standar</th>
							<th colspan="2" width="12%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">Total</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kelurahan</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Sasaran</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Target (100%)</th>
							<?php
							for($bln = 1; $bln <= 12;$bln++){
								echo "<th style='text-align:center vertical-align:middle; border:1px solid #000; padding:3px;'>".nama_bulan_singkat($bln)."</th>";
							}
							?>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jml</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">%</th>
						</tr>
					</thead>
					<tbody style="font-size:10px;">
						<?php
						if($kodepuskesmas == '-'){
							$semua = " ";
						}else{
							$semua = " AND `KodePuskesmas` = '$kodepuskesmas' OR `KodePuskesmas` = '*'";
						}
						
						$str = "SELECT * FROM `tbkelurahan` WHERE `Kota` = '$kota'".$semua;
						$str2 = $str." ORDER BY Kelurahan";
						// echo $str2;
						
						$query = mysqli_query($koneksi, $str2);					
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kelurahan = $data['Kelurahan'];
						
							if ($kelurahan == 'Luar Wilayah'){
								$bulan_01 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_01` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '01' AND b.`Kelurahan` <> '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_02 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_02` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '02' AND b.`Kelurahan` <> '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_03 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_03` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '03' AND b.`Kelurahan` <> '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_04 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_04` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '04' AND b.`Kelurahan` <> '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_05 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_05` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '05' AND b.`Kelurahan` <> '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_06 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_06` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '06' AND b.`Kelurahan` <> '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_07 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_07` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '07' AND b.`Kelurahan` <> '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_08 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_08` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '08' AND b.`Kelurahan` <> '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_09 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_09` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '09' AND b.`Kelurahan` <> '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_10` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '10' AND b.`Kelurahan` <> '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_11` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '11' AND b.`Kelurahan` <> '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_12` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '12' AND b.`Kelurahan` <> '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
							}else{
								$bulan_01 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_01` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '01' AND b.`Kelurahan` = '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_02 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_02` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '02' AND b.`Kelurahan` = '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_03 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_03` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '03' AND b.`Kelurahan` = '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_04 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_04` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '04' AND b.`Kelurahan` = '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_05 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_05` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '05' AND b.`Kelurahan` = '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_06 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_06` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '06' AND b.`Kelurahan` = '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_07 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_07` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '07' AND b.`Kelurahan` = '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_08 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_08` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '08' AND b.`Kelurahan` = '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_09 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_09` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '09' AND b.`Kelurahan` = '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_10` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '10' AND b.`Kelurahan` = '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_11` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '11' AND b.`Kelurahan` = '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
								$bulan_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.`NoPemeriksaan`)AS Jml FROM `tbpolilansia` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex JOIN `tbdiagnosapasien_12` c ON a.NoPemeriksaan = c.NoRegistrasi WHERE SUBSTRING(a.`NoPemeriksaan`,1,11) = '$kodepuskesmas' AND YEAR(a.TanggalPeriksa) = '$tahun' AND MONTH(a.TanggalPeriksa) = '12' AND b.`Kelurahan` = '$kelurahan' AND c.KodeDiagnosa like '%E11%'"));
							}
							$jml = $bulan_01['Jml'] + $bulan_02['Jml'] + $bulan_03['Jml'] + $bulan_04['Jml'] + $bulan_05['Jml'] + $bulan_06['Jml'] + $bulan_07['Jml'] +
									$bulan_08['Jml'] + $bulan_09['Jml'] + $bulan_10['Jml'] + $bulan_11['Jml'] + $bulan_12['Jml'];
						
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $kelurahan;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;">-</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;">100</td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($bulan_01['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($bulan_02['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($bulan_03['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($bulan_04['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($bulan_05['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($bulan_06['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($bulan_07['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($bulan_08['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($bulan_09['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($bulan_10['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($bulan_11['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($bulan_12['Jml']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($jml);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"></td>	
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>
	<?php
	}
	?>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p><b>Kategori Kode Penyakit :</b> E11.0 s/d E11.9<br>
				Data diambil dari Pelayanan Lansia<br>
				Kelurahan dambil berdasar kasus/kejadian</p>
			</div>
		</div>
	</div>
</div>

<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
	$('.btncls').click(function(){
		$( ".hasilpencarian" ).html( "<p style='text-align:center'><img src='assets/js/loader.gif' width='40px'></p>" );
		var tahun = $(this).parent().parent().find(".tahuncls").val()

		$.post( "lap_P2M_ptm_spm_diabet.php?jqry=yes", { tahun: tahun })
		  .done(function( data ) {
			 $( ".hasilpencarian" ).html( data );
		});
	});
</script>