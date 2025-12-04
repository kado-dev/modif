<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12 col-sm-12">
			<h3 class="judul"><b>PENYAKIT TIDAK MEULAR (PTM)</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_P2M_ptm_kasus_dinkes"/>
						<div class="col-sm-1" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-5">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_ptm_kasus_dinkes" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="lap_P2M_ptm_kasus_dinkes_excel.php?tahun=<?php echo $_GET['tahun'];?>" class="btn btn-sm btn-info">Excel</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php
	$tahun = $_GET['tahun'];
	if(isset($tahun)){
	?>

	<div class="row font10">
		<div class="col-sm-12">
			<div class="table-responsive font10">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr>
							<th width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">No.</th>
							<th width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Kode</th>
							<th width="50%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Penyakit Tidak Menular</th>
							<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:10px;">Total</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$str = "SELECT * FROM `tbdiagnosaptmkode`";
						$str2 = $str." order by `KodeKelompok`,`IdDiagnosa`";
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kodedgs = $data['KodeDiagnosa'];
							$jan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_01` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
							$feb= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_02` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
							$mar = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_03` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
							$apr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_04` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
							$mei = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_05` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
							$jun = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_06` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
							$jul = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_07` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
							$agu = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_08` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
							$sep = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_09` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
							$okt = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_10` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
							$nov = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_11` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
							$des = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jml FROM `tbdiagnosapasien_12` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND KodeDiagnosa like '%$kodedgs%'"));
							$total = $jan['Jml'] + $feb['Jml'] + $mar['Jml'] + $apr['Jml'] + $mei['Jml'] + $jun['Jml'] + $jul['Jml'] +
									$agu['Jml'] + $sep['Jml'] + $okt['Jml'] + $nov['Jml'] + $des['Jml'] + $jul['Jml'];
							if($data['IdDiagnosa'] == '01'){
								echo "<tr style='border:1px solid #000;'><td style='text-align:center; border:1px solid #000; padding:3px; font-weight:bold'>$data[KodeKelompok]</td><td colspan='25' style='text-align:left; font-weight:bold; border:1px solid #000; padding:3px;'>$data[Kelompok]</td></tr>";
							}
						?>
							<tr style="border:1px solid #000;">
								<td align="center"><?php echo $data['IdDiagnosa'];?></td>
								<td align="center"><?php echo $data['KodeDiagnosa'];?></td>
								<td align="left"><?php echo $data['NamaDiagnosa'];?></td>
								<td align="right"><b><?php echo rupiah($total);?></b></td>
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