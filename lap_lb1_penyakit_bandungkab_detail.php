<?php
include "config/helper_pasienrj.php";
$bulan = $_GET['bln'];
$tahun = $_GET['thn'];
$tahunini = date('Y');
$kodediagnosa = $_GET['kddgs'];

?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DETAIL DIAGNOSA</b></h3>
			<div class="formbg">
				<div class = "row">
					<table class="table-judul">
						<thead>
							<tr>
								<th width="5%">NO.</th>
								<th width="10%">TGL.REGISTRASI</th>
								<th width="10%">NO.REGISTRASI</th>
								<th width="55%">NAMA PASIEN</th>
								<th width="20%">LAYANAN</th>
							</tr>
						</thead>
						<tbody>
						<?php
							$no = 0;
							if($bulan == "Semua"){
								$str = "SELECT * FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND `KodeDiagnosa` LIKE '%$kodediagnosa%'";
							}else{
								$str = "SELECT * FROM `$tbdiagnosapasien` WHERE YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND `KodeDiagnosa` LIKE '%$kodediagnosa%'";
							}	
							$str2 = $str." GROUP BY `NoRegistrasi` ORDER BY `TanggalDiagnosa` ASC";
							// echo $str2;
							// die();
							
							// baca pasienrj tahun sekarang atau tahun lalu
							if ($tahun == $tahunini){
								$tbpasienrj = $tbpasienrj;
							}else{
								$tbpasienrj = $tbpasienrj_retensi;
							}

							$query = mysqli_query($koneksi, $str2);
							while($data = mysqli_fetch_assoc($query)){
								$no = $no + 1;
								$idpasienrj = $data['IdPasienrj'];
								
								// tbpasienrj
								$dtpasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaPasien`,`PoliPertama` FROM `$tbpasienrj` WHERE `IdPasienrj`='$idpasienrj'"));
							?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo $data['TanggalDiagnosa'];?></td>
								<td align="center"><?php echo $data['NoRegistrasi'];?></td>
								<td align="left"><?php echo $dtpasienrj['NamaPasien'];?></td>
								<td align="center"><?php echo str_replace('POLI','', $dtpasienrj['PoliPertama']);?></td>
							</tr>
						<?php
							}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>	
	</div>	
</div>	