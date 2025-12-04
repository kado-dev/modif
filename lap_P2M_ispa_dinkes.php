<?php
	session_start();
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>
<style type="text/css">
	.alert{
		margin-bottom: 0px;
	}
	.progress{
		height: 14px;
	}
</style>

<div class="tableborderdiv">
	<div class="row noprint">
        <div class="col-sm-12 table-responsive">
			<div class="aleret"></div>
			<div class="progress" style="background: transparent;">
				<div class="progress-bar progress-bar-striped bg-success active" id="myBar" role="progressbar" style="width: 1%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
			<h3 class="judul"><b>ISPA</b></h3>
			<div class="formbg">
                 <form role="form" id="formsx">
				    <div class = "row">
						<input type="hidden" name="page" value="lap_P2M_ispa_dinkes"/>
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
							<select name="bulan2" class="form-control">
								<option value="01" <?php if($_GET['bulan2'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulan2'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulan2'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulan2'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulan2'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulan2'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulan2'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulan2'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulan2'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulan2'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulan2'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulan2'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-xl-2" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-3">
							<select name="kodepuskesmas" class="form-control">
							<option value='semua'>Semua</option>
							<?php
							$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `Kota`='$kota' order by `NamaPuskesmas`");
							while($data3 = mysqli_fetch_assoc($queryp)){
								if($_GET['kodepuskesmas'] == $data3['KodePuskesmas']){
									echo "<option value='$data3[KodePuskesmas]' SELECTed>$data3[NamaPuskesmas]</option>";
								}else{
									echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
								}
							}
							?>
							</select>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_ispa_dinkes" class="btn btn-round btn-success"><span class="fa fa-refresh"></span></a>
							<a href="lap_P2M_ispa_dinkes_excel.php?bulan=<?php echo $_GET['bulan'];?>&bulan2=<?php echo $_GET['bulan2'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $_GET['kodepuskesmas'];?>" class="btn btn-round btn-info">Excel</a>
						</div>
				    </div>
                </form>
			</div>
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$bulan2 = $_GET['bulan2'];
	$tahun = $_GET['tahun'];
	$kodepkm = $_GET['kodepuskesmas'];
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN P2P (ISPA)</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?>
		</span><br/>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead>
						<tr>
						<th rowspan="3">NO.</th>
						<th rowspan="3" width="10%">NAMA PUSKESMAS</th>
						<th colspan="3" width="10%">DATA SASARAN</th>							
						<th colspan="4">PNEUMONIA</th>
						<th colspan="4">PNEUMONIA BERAT</th>
						<th colspan="7">JUMLAH</th>
						<th rowspan="3">%</th>
						<th colspan="5">BATUK BUKAN PNEUMONIA</th>
						<th colspan="6">JML KEMATIAN BALITA KRN PNEUMONIA</th>
						<th colspan="6">ISPA >5 TH</th>
						<th rowspan="3">DIRUJUK</th>
					</tr>
					<tr>
						<th rowspan="2">JML PDKK</th>
						<th rowspan="2">JML PDKK BALITA (10% PDKK)</th>
						<th rowspan="2">TARGET PENUMUAN PDKK PNEUMONIA</th>
						<th colspan="2"> < 1 TH </th><!--Pneumonia-->
						<th colspan="2">1-4 TH</th>
						<th colspan="2"> < 1 TH </th><!--Pneumonia Berat-->
						<th colspan="2">1-4 TH</th>
						<th colspan="2"> < 1 TH </th><!--Jumlah-->
						<th colspan="2">1-4 TH</th>
						<th colspan="2">SUB TOTAL</th>
						<th rowspan="2">TOTAL</th>
						<th colspan="2"> < 1 TH </th><!--Bukan Pneumonia-->
						<th colspan="2">1-4 TH</th>
						<th rowspan="2">TOTAL</th>
						<th colspan="2"> < 1 TH </th><!--Jml Kematian Balita Krn Penumonia-->
						<th colspan="2">1-4 TH</th>
						<th colspan="2">TOTAL</th>
						<th colspan="3">BKN PNEUMONIA</th>
						<th colspan="3">PNEUMONIA</th><!--ISPA >5 TH-->
					</tr>
						<tr style="border:1px dashed #000;">
							<th>L</th><!--Pneumonia-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--Pneumonia Berat-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--Jumlah-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--Bukan Pneumonia-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--Jml Kematian Balita Krn Penumonia-->
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th>
							<th>P</th>
							<th>L</th><!--Pneumonia-->
							<th>P</th>
							<th>T</th>
							<th>L</th><!--Bukan Pneumonia-->
							<th>P</th>
							<th>T</th>
							
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
						
						// tbpuskesmas
						if($kodepkm == 'semua'){
							$str = "SELECT * FROM `tbpuskesmas`";
						}else{
							$str = "SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepkm'";
						}
						$str2 = $str." ORDER BY `NamaPuskesmas` ASC limit $mulai,$jumlah_perpage";
											
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}				
										
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;						
							$kodepuskesmas = $data['KodePuskesmas'];
							$namapuskesmas = $data['NamaPuskesmas'];
                            $tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
							$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
							
							// pneumonia
							$ispa_0_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'L' AND UmurTahun = '0' AND KodeDiagnosa = 'J18.9'"));
							$ispa_0_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'P' AND UmurTahun = '0' AND KodeDiagnosa = 'J18.9'"));
							$ispa_1_4_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'L' AND UmurTahun BETWEEN '1' AND '4' AND KodeDiagnosa = 'J18.9'"));
							$ispa_1_4_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'P' AND UmurTahun BETWEEN '1' AND '4' AND KodeDiagnosa = 'J18.9'"));
							$ispa_0_Laki = $ispa_0_Laki_pneumonia['Jumlah'];
							$ispa_1_4_Laki =  $ispa_1_4_Laki_pneumonia['Jumlah'];
							$laki_pneumonia = $ispa_0_Laki + $ispa_1_4_Laki;
							$ispa_0_perempuan = $ispa_0_Perempuan_pneumonia['Jumlah'];
							$ispa_1_4_perempuan =  $ispa_1_4_Perempuan_pneumonia['Jumlah'];
							$perempuan_pneumonia = $ispa_0_perempuan + $ispa_1_4_perempuan;
							
							// pneumonia_berat
							$ispa_0_Laki_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'L' AND UmurTahun = '0' AND KodeDiagnosa = 'J18.0'"));
							$ispa_0_Perempuan_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'P' AND UmurTahun = '0' AND KodeDiagnosa = 'J18.0'"));
							$ispa_1_4_Laki_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'L' AND UmurTahun BETWEEN '1' AND '4' AND KodeDiagnosa = 'J18.0'"));
							$ispa_1_4_Perempuan_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'P' AND UmurTahun BETWEEN '1' AND '4' AND KodeDiagnosa = 'J18.0'"));
							$ispa_0_Laki_berat = $ispa_0_Laki_pneumonia_berat['Jumlah'];
							$ispa_1_4_Laki_berat =  $ispa_1_4_Laki_pneumonia_berat['Jumlah'];
							$laki_pneumonia_berat = $ispa_0_Laki_berat + $ispa_1_4_Laki_berat;			
							$ispa_0_perempuan_berat = $ispa_0_Perempuan_pneumonia_berat['Jumlah'];
							$ispa_1_4_perempuan_berat =  $ispa_1_4_Perempuan_pneumonia_berat['Jumlah'];
							$perempuan_pneumonia_berat = $ispa_0_perempuan_berat + $ispa_1_4_perempuan_berat;
							
							// sub total
							$jumlah_0_Laki = $ispa_1_4_Laki_pneumonia['Jumlah'];
							$jumlah_1_4_Laki = $ispa_1_4_Laki_pneumonia_berat['Jumlah'];
							$sublaki = $jumlah_0_Laki + $jumlah_1_4_Laki;			
							$jumlah_0_perempuan = $ispa_1_4_Perempuan_pneumonia['Jumlah'];
							$jumlah_1_4_perempuan = $ispa_1_4_Perempuan_pneumonia_berat['Jumlah'];
							$subperempuan = $jumlah_0_perempuan + $jumlah_1_4_perempuan;
						
							// total
							$total  = $sublaki + $subperempuan;
							
							// batuk bukan pneumonia
							$ispa_0_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'L' AND UmurTahun = '4' AND (KodeDiagnosa = 'J00' OR KodeDiagnosa like '%J06%')"));
							$ispa_0_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'L' AND UmurTahun = '4' AND (KodeDiagnosa = 'J00' OR KodeDiagnosa like '%J06%')"));
							$ispa_1_4_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'L' AND UmurTahun BETWEEN '1' AND '4' AND (KodeDiagnosa = 'J00' OR KodeDiagnosa like '%J06%')"));
							$ispa_1_4_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'P' AND UmurTahun BETWEEN '1' AND '4' AND (KodeDiagnosa = 'J00' OR KodeDiagnosa like '%J06%')"));
							$ttl_pneumonia_bukan = $ispa_0_Laki_pneumonia_bukan['Jumlah'] + $ispa_0_Perempuan_pneumonia_bukan['Jumlah'] + $ispa_1_4_Laki_pneumonia_bukan['Jumlah'] + $ispa_1_4_Perempuan_pneumonia_bukan['Jumlah'];
							
							// ispa > 5th bukan pneumonia
							$ispa_5_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'L' AND UmurTahun >= '5' AND (KodeDiagnosa = 'J00' OR KodeDiagnosa like '%J06%')"));
							$ispa_5_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'P' AND UmurTahun >= '5' AND (KodeDiagnosa = 'J00' OR KodeDiagnosa like '%J06%')"));
							$ttl_5_pneumonia_bukan = $ispa_5_Laki_pneumonia_bukan['Jumlah'] + $ispa_5_Perempuan_pneumonia_bukan['Jumlah'];
													
							// ispa > 5th pneumonia
							$ispa_5_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'L' AND UmurTahun >= '5' AND KodeDiagnosa like '%J18%'"));
							$ispa_5_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(NoRegistrasi)AS Jumlah FROM `$tbdiagnosapasien` WHERE MONTH(TanggalDiagnosa) BETWEEN '$bulan' AND '$bulan2' AND YEAR(TanggalDiagnosa)='$tahun' AND JenisKelamin = 'P' AND UmurTahun >= '5' AND KodeDiagnosa like '%J18%'"));
							$ttl_5_pneumonia = $ispa_5_Laki_pneumonia['Jumlah'] + $ispa_5_Perempuan_pneumonia['Jumlah'];
							
						?>
							<tr style="border:1px dashed #000;">
								<td><?php echo $no;?></td>
								<td><?php echo $data['NamaPuskesmas'];?></td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td><?php echo $ispa_0_Laki_pneumonia['Jumlah'];?></td>
								<td><?php echo $ispa_0_Perempuan_pneumonia['Jumlah'];?></td>
								<td><?php echo $ispa_1_4_Laki_pneumonia['Jumlah'];?></td>
								<td><?php echo $ispa_1_4_Perempuan_pneumonia['Jumlah'];?></td>
								<td><?php echo $ispa_0_Laki_pneumonia_berat['Jumlah'];?></td>
								<td><?php echo $ispa_0_Perempuan_pneumonia_berat['Jumlah'];?></td>
								<td><?php echo $ispa_1_4_Laki_pneumonia_berat['Jumlah'];?></td>
								<td><?php echo $ispa_1_4_Perempuan_pneumonia_berat['Jumlah'];?></td>
								<td><?php echo $laki_pneumonia;?></td>
								<td><?php echo $perempuan_pneumonia;?></td>
								<td><?php echo $laki_pneumonia_berat;?></td>
								<td><?php echo $perempuan_pneumonia_berat;?></td>
								<td><?php echo $sublaki;?></td>
								<td><?php echo $subperempuan;?></td>
								<td><?php echo $total;?></td>
								<td>0</td>
								<td><?php echo $ispa_0_Laki_pneumonia_bukan['Jumlah'];?></td>
								<td><?php echo $ispa_0_Perempuan_pneumonia_bukan['Jumlah'];?></td>
								<td><?php echo $ispa_1_4_Laki_pneumonia_bukan['Jumlah'];?></td>
								<td><?php echo $ispa_1_4_Perempuan_pneumonia_bukan['Jumlah'];?></td>
								<td><?php echo $ttl_pneumonia_bukan?></td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td><?php echo $ispa_5_Laki_pneumonia_bukan['Jumlah'];?></td><!--ispa >5 tahun-->
								<td><?php echo $ispa_5_Perempuan_pneumonia_bukan['Jumlah'];?></td>
								<td><?php echo $ttl_5_pneumonia_bukan;?></td>
								<td><?php echo $ispa_5_Laki_pneumonia['Jumlah'];?></td>
								<td><?php echo $ispa_5_Perempuan_pneumonia['Jumlah'];?></td>
								<td><?php echo $ttl_5_pneumonia;?></td>
								<td>-</td>
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
						echo "<li><a href='?page=lap_P2M_ispa_dinkes&bulan=$bulan&bulan2=$bulan2&tahun=$tahun&kodepuskesmas=$kodepkm&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
<?php
	}
?>

	<div class = "row noprint">
        <div class="col-sm-12 table-responsive">
            <div class="formbg">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p><b>Perhatian :</b><br/>
				Pneumonia (J18.9)<br/>
				Pneumonia Berat (J18.0)<br/>
				Batuk Bukan Pneumonia (J06.0)
            </div>
        </div>
    </div>
</div>

<script src="assets/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript">
$('body').on("click",".btnsimpans", function(event) {
    $('html,body').scrollTop(0);
    $(".aleret").html("");
    
      var urlaction = $("#formsx").attr('action');
      var datak = $("#formsx").serializeArray();
      var fd = new FormData();
      $('.filex').each(function(index,val){
	      const x_x = val.files[0];
	      var attr_name = $(this).attr('name');
	      if(typeof x_x !== 'undefined'){
	        fd.append(attr_name,x_x,x_x.name);        
	      }
	    });
      $.each(datak,function(key,input){
        fd.append(input.name,input.value);
      });

      $.ajax({      
        url:urlaction,
        data: fd,
        contentType: false,
        processData: false,  
        type:"POST",      
        xhr: function () {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    percentComplete = parseInt(percentComplete * 100);
                    var elem = document.getElementById("myBar");
		            elem.style.width =percentComplete+"%";
                }
            }, false);
            return xhr;
        },
        success: function(data){
          var elem = document.getElementById("myBar");
          elem.style.display = "none";
        }
      });
   
});

</script>

