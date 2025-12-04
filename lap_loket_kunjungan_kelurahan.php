<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KUNJUNGAN PASIEN BULAN (DESA/KELURAHAN)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_kunjungan_kelurahan"/>
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
						<div class="col-xl-2 bulanformcari">
							<select name="tahun" class="form-control tahuncls">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning btncls"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_kunjungan_kelurahan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
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
	$tahunini = date('Y');
	
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN KUNJUNGAN PASIEN (DESA/KELURAHAN)</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
		<br/>
	</div>

	<div class="atastabel font11">
		<div style="float:left; width:35%; margin-bottom:10px;">	
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
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr style="border:1px solid #000;">
							<th width="3%" rowspan="3">NO.</th>
							<th width="10%" rowspan="3">KELURAHAN / DESA</th>
							<th colspan="4">JUMLAH KUNJUNGAN</th>
							<th colspan="2">JUMLAH</th>
							<th width="8%" rowspan="3">TOTAL</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th colspan="2">LAKI-LAKI</th>
							<th colspan="2">PEREMPUAN</th>
							<th width="5%" rowspan="2">BARU</th>
							<th width="5%" rowspan="2">LAMA</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th width="5%">BARU</th>
							<th width="5%">LAMA</th>
							<th width="5%">BARU</th>
							<th width="5%">LAMA</th>
						</tr>
					</thead>
					<tbody>
						<?php
						
						// tahap 1, insert ke tbpasienrj_bulan
						// mysqli_query($koneksi, "DELETE FROM `$tbpasienrj`");
						// $strpasienrj = "SELECT * FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan'";
						// $querypasienrj = mysqli_query($koneksi, $strpasienrj);				
						// while($datapsrj= mysqli_fetch_assoc($querypasienrj)){
						// 	$str_kunj = "SELECT `NoRegistrasi` FROM `$tbpasienrj` WHERE `NoCM`='$datapsrj[NoCM]'";
						// 	$cek_kunj = mysqli_num_rows(mysqli_query($koneksi, $str_kunj));
						// 	if($cek_kunj > 1){
						// 		$stskunj = 'Baru';
						// 	}else{
						// 		$stskunj = 'Lama';
						// 	}

						// 	$strpasienrjbulan = "INSERT INTO `$tbpasienrj`(`TanggalRegistrasi`,`NoRegistrasi`,`NoIndex`,`NoCM`,`NoRM`,`NamaPasien`,`JenisKelamin`,
						// 	`UmurTahun`,`UmurBulan`,`UmurHari`,`JenisKunjungan`,`AsalPasien`,`StatusPasien`,`PoliPertama`,`Asuransi`,`StatusKunjungan`,`WaktuKunjungan`,`TarifKarcis`,
						// 	`TarifKir`,`TotalTarif`,`StatusPelayanan`,`StatusPulang`,`NamaPegawaiSimpan`,`NamaPegawaiEdit`,`TanggalEdit`,`NoKunjunganBpjs`,`NoUrutBpjs`,`kdprovider`,
						// 	`nokartu`,`kdpoli`,`Kir`) VALUES 
						// 	('$datapsrj[TanggalRegistrasi]','$datapsrj[NoRegistrasi]','$datapsrj[NoIndex]','$datapsrj[NoCM]','$datapsrj[NoRM]','$datapsrj[NamaPasien]',
						// 	'$datapsrj[JenisKelamin]','$datapsrj[UmurTahun]','$datapsrj[UmurBulan]','$datapsrj[UmurHari]','$datapsrj[JenisKunjungan]','$datapsrj[AsalPasien]',
						// 	'$datapsrj[StatusPasien]','$datapsrj[PoliPertama]','$datapsrj[Asuransi]','$stskunj','$datapsrj[WaktuKunjungan]','$datapsrj[TarifKarcis]',
						// 	'$datapsrj[TarifKir]','$datapsrj[TotalTarif]','$datapsrj[StatusPelayanan]','$datapsrj[StatusPulang]','$datapsrj[NamaPegawaiSimpan]','$datapsrj[NamaPegawaiEdit]'
						// 	,'$datapsrj[TanggalEdit]','$datapsrj[NoKunjunganBpjs]','$datapsrj[NoUrutBpjs]','$datapsrj[kdprovider]','$datapsrj[nokartu]','$datapsrj[kdpoli]',
						// 	'$datapsrj[Kir]')";
						// 	mysqli_query($koneksi, $strpasienrjbulan);
						// }
						
						// tahap 2, panggil tbkelurahan
						$str = "SELECT * FROM `tbkelurahan` WHERE `KodePuskesmas`='$kodepuskesmas' OR `KodePuskesmas` = '*'";
						// echo $str;
				
						$query = mysqli_query($koneksi, $str);					
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$kelurahan = $data['Kelurahan'];
							if ($kelurahan == 'Luar Wilayah'){
								$jml_l_baru = mysqli_num_rows(mysqli_query($koneksi,"SELECT a.`TanggalRegistrasi`, a.`NoIndex`, a.`JenisKelamin`, a.`StatusKunjungan`, b.`Kelurahan` FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.JenisKelamin = 'L' AND a.StatusKunjungan = 'Baru' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND b.Kelurahan != '$kelurahan';"));
								$jml_l_lama =mysqli_num_rows(mysqli_query($koneksi,"SELECT a.`TanggalRegistrasi`, a.`NoIndex`, a.`JenisKelamin`, a.`StatusKunjungan`, b.`Kelurahan` FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.JenisKelamin = 'L' AND a.StatusKunjungan = 'Lama' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND b.Kelurahan != '$kelurahan';"));
								$jml_p_baru = mysqli_num_rows(mysqli_query($koneksi,"SELECT a.`TanggalRegistrasi`, a.`NoIndex`, a.`JenisKelamin`, a.`StatusKunjungan`, b.`Kelurahan` FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.JenisKelamin = 'P' AND a.StatusKunjungan = 'Baru' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND b.Kelurahan != '$kelurahan';"));
								$jml_p_lama =mysqli_num_rows(mysqli_query($koneksi,"SELECT a.`TanggalRegistrasi`, a.`NoIndex`, a.`JenisKelamin`, a.`StatusKunjungan`, b.`Kelurahan` FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.JenisKelamin = 'P' AND a.StatusKunjungan = 'Lama' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND b.Kelurahan != '$kelurahan';"));
							}else{
								$jml_l_baru = mysqli_num_rows(mysqli_query($koneksi,"SELECT a.`TanggalRegistrasi`, a.`NoIndex`, a.`JenisKelamin`, a.`StatusKunjungan`, b.`Kelurahan` FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.JenisKelamin = 'L' AND a.StatusKunjungan = 'Baru' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND b.Kelurahan = '$kelurahan'"));
								$jml_l_lama =mysqli_num_rows(mysqli_query($koneksi,"SELECT a.`TanggalRegistrasi`, a.`NoIndex`, a.`JenisKelamin`, a.`StatusKunjungan`, b.`Kelurahan` FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.JenisKelamin = 'L' AND a.StatusKunjungan = 'Lama' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND b.Kelurahan = '$kelurahan'"));
								$jml_p_baru = mysqli_num_rows(mysqli_query($koneksi,"SELECT a.`TanggalRegistrasi`, a.`NoIndex`, a.`JenisKelamin`, a.`StatusKunjungan`, b.`Kelurahan` FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.JenisKelamin = 'P' AND a.StatusKunjungan = 'Baru' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND b.Kelurahan = '$kelurahan'"));
								$jml_p_lama =mysqli_num_rows(mysqli_query($koneksi,"SELECT a.`TanggalRegistrasi`, a.`NoIndex`, a.`JenisKelamin`, a.`StatusKunjungan`, b.`Kelurahan` FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.JenisKelamin = 'P' AND a.StatusKunjungan = 'Lama' AND YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' AND b.Kelurahan = '$kelurahan'"));
							}
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td><?php echo strtoupper($data['Kelurahan']);?></td>
								<td><?php echo rupiah($jml_l_baru);?></td>
								<td><?php echo rupiah($jml_l_lama);?></td>	
								<td><?php echo rupiah($jml_p_baru);?></td>		
								<td><?php echo rupiah($jml_p_lama);?></td>		
								<td>
									<?php
										$jml_baru = $jml_l_baru + $jml_p_baru;
										echo rupiah($jml_baru);
									?>
								</td>		
								<td>
									<?php
										$jml_lama = $jml_l_lama + $jml_p_lama;
										echo rupiah($jml_lama);
									?>
								</td>		
								<td>
									<?php 
										$jml_semua = $jml_l_baru + $jml_l_lama + $jml_p_baru + $jml_p_lama;								
										echo rupiah($jml_semua);								
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
	</div>
	
	<hr class="noprint">
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
						echo "<li><a href='?page=lap_loket_kunjungan_kelurahan&bulan=$bulan&tahun=$tahun&h=$i'>$i</a></li>";
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
	$('.btncls').click(function(){
		$( ".hasilpencarian" ).html( "<p style='text-align:center'><img src='assets/js/loader.gif' width='40px'></p>" );
		var tahun = $(this).parent().parent().find(".tahuncls").val()

		$.post( "lap_loket_kunjungan_kelurahan.php?jqry=yes", { tahun: tahun })
		  .done(function( data ) {
			 $( ".hasilpencarian" ).html( data );
		});
	});
</script>