<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER DBD</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_DBD_Harian"/>
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
						<div class="col-xl-2">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="kasus" class="form-control">
								<option value="semua" <?php if($_GET['kasus'] == 'Semua'){echo "SELECTED";}?>>Semua</option>
								<option value="Baru" <?php if($_GET['kasus'] == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value="Lama" <?php if($_GET['kasus'] == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</select>
						</div>
						<div class="col-xl-6">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_DBD_Harian" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_P2M_DBD_Harian_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kasus=<?php echo $_GET['kasus'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>
			</div>	
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kasus = $_GET['kasus'];
	$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER HARIAN TIFOID</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: 
			<?php 
			if($opsiform == 'tanggal'){
				echo date('d-m-Y', strtotime($keydate1)) ." s/d ".date('d-m-Y', strtotime($keydate2));
			}else{
				echo nama_bulan($bulan)." ".$tahun;
			}
			?>
		</span>
		<br/><br/>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead>
						<tr>
							<th rowspan="2" width="3%">NO.</th>
							<th rowspan="2" width="5%">NO RM</th>
							<th rowspan="2">NAMA PASIEN</th>
							<th colspan="2" width="8%">UMUR</th>
							<th colspan="2" width="15%">ALAMAT</th>
							<th rowspan="2" width="8%">PUSKESMAS</th>
							<th rowspan="2" width="6%">TGL SAKIT</th>
							<th rowspan="2" width="6%">SUMBER DATA</th>
							<th rowspan="2" width="6%">DIRAWAT</th>
							<th rowspan="2" width="6%">DIAGNOSA</th>
							<th colspan="4" width="20%">TINDAK LANJUT</th>
							<th rowspan="2">KET.(%)</th>
						</tr>
						<tr>
							<!--tanggal kunjungan-->
							<th>L</th>
							<th>P</th>
							<!--alamat-->
							<th>ALAMAT LENGKAP</th>
							<th>DESA/KEL</th>
							<!--tindak lanjut-->
							<th>PE</th>
							<th>ABATISASI</th>
							<th>FOGGING</th>
							<th>RATA2 ABJ</th>
						</tr>
						<tr>
							<th>1</th>
							<th>2</th>
							<th>3</th>
							<th>4</th>
							<th>5</th>
							<th>6</th>
							<th>7</th>
							<th>8</th>
							<th>9</th>
							<th>10</th>
							<th>11</th>
							<th>12</th>
							<th>13</th>
							<th>14</th>
							<th>15</th>
							<th>16</th>
							<th>17</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$jumlah_perpage = 20;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						if($kasus == "semua"){
							$qkasus = " ";
						}else{
							$qkasus = " AND `Kasus`='$kasus'";
						}
						
						$str = "SELECT * FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa)='$bulan' AND YEAR(TanggalDiagnosa)='$tahun' AND (`KodeDiagnosa` like '%A90%' OR `KodeDiagnosa` like '%A91%')".$qkasus; 
						$str2 = $str." LIMIT $mulai,$jumlah_perpage";
						// echo $str;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query_ispa = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query_ispa)){
							$no = $no + 1;
							$noindex = $data['NoIndex'];
							$nocm = $data['NoCM'];
							$noregistrasi = $data['NoRegistrasi'];
							$tanggaldiagnosa = $data['TanggalDiagnosa'];
							$bulandiagnosa = date('m', strtotime($data['TanggalDiagnosa']));
							
							// tbkk
							$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Alamat`,`RT`,`No`,`Kelurahan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'"));
							$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", No.".$datakk['No'];
							$kelurahan = $datakk['Kelurahan'];
							
							// tbpasien
							$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `NoCM` = '$nocm'"));
							$norm = $datapasien['NoRM'];
							$nik = $datapasien['Nik'];
							$namapasien = $datapasien['NamaPasien'];
							$desa = $datapasien['Kelurahan'];
							
							// tbpasienrj
							$datapasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'"));
							$kunjungan = $datapasienrj['StatusKunjungan'];
							$jeniskelamin = $datapasienrj['JenisKelamin'];
							$umurtahun = $datapasienrj['UmurTahun'];
							$umurbulan= $datapasienrj['UmurBulan'];
							$sumberdata= $datapasienrj['PoliPertama'];
							
							if($umurtahun != '0'){
								$umur = $umurtahun."Th";
							}else{
								$umur = $umurbulan."Bl";
							}	
							
							if($jeniskelamin == 'L'){
								$umur_laki = $umur;
							}else{
								$umur_laki = "-";
							}
					
							if($jeniskelamin == 'P'){
								$umur_perempuan = $umur;
							}else{
								$umur_perempuan = "-";
							}														
													
							if($kunjungan == 'Baru'){
								$statuskunj_baru = '<span class="fa fa-check"></span>';
							}else{
								$statuskunj_baru = "-";
							}
							
							if($kunjungan == 'Lama'){
								$statuskunj_lama = '<span class="fa fa-check"></span>';
							}else{
								$statuskunj_lama = "-";
							}
														
							// cek diagnosa pasien
							$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
							$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
							
							while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
								$array_data[$no][] = $data_diagnosapsn['KodeDiagnosa'];
							}
							
							if ($array_data[$no] != ''){
								$data_dgs = implode(",", $array_data[$no]);
							}else{
								$data_dgs ="";
							}
							
							// konfirmasi lab
							if($data_dgs == 'A01'){
								$klinis = "POSITIF";
							}else{
								$klinis = "-";
							}	
							
							if($array_data[$no][0] == 'A01.0' || $array_data[$no][0]== 'A01.1'){
								$konfirmasilab = "POSITIF";
							}else{
								$konfirmasilab = "-";
							}							
							
						
						?>
							<tr>
								<td><?php echo $no;?></td>
								<td><?php echo substr($norm,-8);?></td>
								<td style="border:1px solid #000; padding:3px;"><?php echo $namapasien;?></td>
								<td><?php echo $umur_laki;?></td>
								<td><?php echo $umur_perempuan;?></td>
								<td style="border:1px solid #000; padding:3px;"><?php echo $alamat;?></td>
								<td style="border:1px solid #000; padding:3px;"><?php echo $desa;?></td>
								<td><?php echo $namapuskesmas;?></td>								
								<td><?php echo $tanggaldiagnosa;?></td>								
								<td><?php echo $sumberdata;?></td>							
								<td></td>								
								<td><?php echo $data_dgs;?></td>								
								<td><span class="fa fa-check"></span></td>
								<td><span class="fa fa-check"></span></td>
								<td>-</td>
								<td>-</td>
								<td></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br>
	<hr class="noprint">
	<ul class="pagination noprint">
		<?php
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
						echo "<li><a href='?page=lap_P2M_DBD_Harian&bulan=$bulan&tahun=$tahun&kasus=$kasus&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p><b>Kategori Kode Penyakit :</b><br>
				- DBD = A90, A91<br/>
				</p>
			</div>
		</div>
	</div>
</div>

<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
$('.opsiform').change(function(){
	if($(this).val() == 'bulan'){
		$(".bulanformcari").show();
		$(".tanggalformcari").hide();
	}else{	
		$(".bulanformcari").hide();
		$(".tanggalformcari").show();
	}
});	
$(document).ready(function(){
	if($(".opsiform").val() == 'bulan'){
		$(".bulanformcari").show();
		$(".tanggalformcari").hide();
	}else{	
		$(".bulanformcari").hide();
		$(".tanggalformcari").show();
	}
});	
</script>