<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12 col-sm-12">
			<h3 class="judul"><b>ISPA (BULANAN)</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_P2M_Ispa_Bulanan_Dinkes"/>
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
						<div class="col-sm-1" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-3">
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
						<div class="col-sm-2">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_Ispa_Bulanan_Dinkes" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="lap_P2M_Ispa_Bulanan_Dinkes_Excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $_GET['kodepuskesmas'];?>" class="btn btn-sm btn-info">Excel</a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kodepkm = $_GET['kodepuskesmas'];
	$tbpasienrj = 'tbpasienrj_'.$bulan;
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min">
					<thead style="font-size:9px;">
						<tr style="border:1px dashed #000;">
							<th rowspan="4">No.</th>
							<th rowspan="4" width="10%">Nama Puskesmas</th>
							<th colspan="3" width="10%">Data Sasaran</th>							
							<th colspan="4">Pneumonia</th>
							<th colspan="4">Pneumonia Berat</th>
							<th colspan="7">Jumlah</th>
							<th rowspan="4">%</th>
							<th colspan="5">Batuk Bukan Pneumonia</th>
							<th colspan="6">Jml Kematian Balita Krn Penumonia</th>
							<th colspan="6">ISPA >5 Thn</th>
							<th rowspan="4">Dirujuk</th>
						</tr>
						<tr style="border:1px dashed #000;">
							<th rowspan="3">Jml Pdkk</th>
							<th rowspan="3">Jml Pdkk Balita (10% pddk)</th>
							<th rowspan="3">Target Penemuan Pdkk Pneumonia</th>
							<th colspan="2"><1 Thn</th><!--Pneumonia-->
							<th colspan="2">1-4 Thn</th>
							<th colspan="2"><1 Thn</th><!--Pneumonia Berat-->
							<th colspan="2">1-4 Thn</th>
							<th colspan="2"><1 Thn</th><!--Jumlah-->
							<th colspan="2">1-4 Thn</th>
							<th colspan="2">SubTotal</th>
							<th rowspan="2">Total</th>
							<th colspan="2"><1 Thn</th><!--Bukan Pneumonia-->
							<th colspan="2">1-4 Thn</th>
							<th rowspan="2">Total</th>
							<th colspan="2"><1 Thn</th><!--Jml Kematian Balita Krn Penumonia-->
							<th colspan="2">1-4 Thn</th>
							<th colspan="2">Total</th>
							<th colspan="3">Bkn Pneumonia</th>
							<th colspan="3">Pneumonia</th><!--ISPA >5 Thn-->
						
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
					<tbody style="font-size:10px;">
						<?php
						$jumlah_perpage = 10;					
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						// insert ke tbdiagnosapasien_bulan
						$strdiagnosabln = "SELECT * FROM `$tbdiagnosapasien` WHERE YEAR(`TanggalDiagnosa`)='$tahun'";
						$querydiagnosabln = mysqli_query($koneksi,$strdiagnosabln);
						mysqli_query($koneksi, "DELETE FROM `tbdiagnosapasien_bulan`");
						while($datalb = mysqli_fetch_assoc($querydiagnosabln)){
							$strdiagnosa = "INSERT INTO `tbdiagnosapasien_bulan`(`TanggalDiagnosa`, `NoCM`, `NoRegistrasi`, `KodeDiagnosa`, `Kasus`, `Kelompok`) VALUES 
							('$datalb[TanggalDiagnosa]','$datalb[NoCM]','$datalb[NoRegistrasi]','$datalb[KodeDiagnosa]','$datalb[Kasus]','$datalb[Kelompok]')";
							mysqli_query($koneksi, $strdiagnosa);
						}
						
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
							$kodepuskesmas2 = "AND SUBSTRING(a.NoRegistrasi,1,11)="."'$data[KodePuskesmas]'";						
							
							// pneumonia
							$ispa_0_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun = '0' AND b.KodeDiagnosa = 'J18.9'"));
							$ispa_0_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'P' AND a.UmurTahun = '0' AND b.KodeDiagnosa = 'J18.9'"));
							$ispa_1_4_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND b.KodeDiagnosa = 'J18.9'"));
							$ispa_1_4_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND b.KodeDiagnosa = 'J18.9'"));
							$ispa_0_Laki = $ispa_0_Laki_pneumonia['Jumlah'];
							$ispa_1_4_Laki =  $ispa_1_4_Laki_pneumonia['Jumlah'];
							$laki_pneumonia = $ispa_0_Laki + $ispa_1_4_Laki;
							$ispa_0_perempuan = $ispa_0_Perempuan_pneumonia['Jumlah'];
							$ispa_1_4_perempuan =  $ispa_1_4_Perempuan_pneumonia['Jumlah'];
							$perempuan_pneumonia = $ispa_0_perempuan + $ispa_1_4_perempuan;
							
							// pneumonia_berat
							$ispa_0_Laki_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun = '0' AND b.KodeDiagnosa = 'J18.0'"));
							$ispa_0_Perempuan_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'P' AND a.UmurTahun = '0' AND b.KodeDiagnosa = 'J18.0'"));
							$ispa_1_4_Laki_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND b.KodeDiagnosa = 'J18.0'"));
							$ispa_1_4_Perempuan_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND b.KodeDiagnosa = 'J18.0'"));
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
							$ispa_0_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun = '4' AND (b.KodeDiagnosa = 'J00' OR b.KodeDiagnosa like '%J06%')"));
							$ispa_0_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun = '4' AND (b.KodeDiagnosa = 'J00' OR b.KodeDiagnosa like '%J06%')"));
							$ispa_1_4_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND (b.KodeDiagnosa = 'J00' OR b.KodeDiagnosa like '%J06%')"));
							$ispa_1_4_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND (b.KodeDiagnosa = 'J00' OR b.KodeDiagnosa like '%J06%')"));
							$ttl_pneumonia_bukan = $ispa_0_Laki_pneumonia_bukan['Jumlah'] + $ispa_0_Perempuan_pneumonia_bukan['Jumlah'] + $ispa_1_4_Laki_pneumonia_bukan['Jumlah'] + $ispa_1_4_Perempuan_pneumonia_bukan['Jumlah'];
							
							// ispa > 5th bukan pneumonia
							$ispa_5_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun >= '5' AND (b.KodeDiagnosa = 'J00' OR b.KodeDiagnosa like '%J06%')"));
							$ispa_5_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'P' AND a.UmurTahun >= '5' AND (b.KodeDiagnosa = 'J00' OR b.KodeDiagnosa like '%J06%')"));
							$ttl_5_pneumonia_bukan = $ispa_5_Laki_pneumonia_bukan['Jumlah'] + $ispa_5_Perempuan_pneumonia_bukan['Jumlah'];
													
							// ispa > 5th pneumonia
							$ispa_5_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'L' AND a.UmurTahun >= '5' AND b.KodeDiagnosa like '%J18%'"));
							$ispa_5_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi)AS Jumlah FROM `$tbpasienrj` a JOIN `tbdiagnosapasien_bulan` b ON a.NoRegistrasi = b.NoRegistrasi WHERE YEAR(a.TanggalRegistrasi)='$tahun' ".$kodepuskesmas2." AND a.JenisKelamin = 'P' AND a.UmurTahun >= '5' AND b.KodeDiagnosa like '%J18%'"));
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
	</div>
	<br/>
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
						echo "<li><a href='?page=lap_P2M_Ispa_Bulanan_Dinkes&bulan=$bulan&tahun=$tahun&kodepuskesmas=$kodepkm&h=$i'>$i</a></li>";
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
				<p><b>Perhatian :</b><br/>
				Pneumonia (J18.9)<br/>
				Pneumonia Berat (J18.0)<br/>
				Batuk Bukan Pneumonia (J06.0)
				</p>
			</div>
		</div>
	</div>
<div class="tableborderdiv">	
