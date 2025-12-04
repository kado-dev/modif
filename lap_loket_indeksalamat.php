<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>INDEKS ALAMAT</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_indeksalamat"/>
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
						<div class="col-xl-3">
							<select name="kelurahan" class="form-control" required>
								<option value='semua'>Pilih Desa/Kelurahan</option>
								<?php
								$kota = $_SESSION['kota'];
								if($_SESSION['kodepuskesmas'] == '-'){
									$query_kel = mysqli_query($koneksi,"SELECT * FROM `tbkelurahan` WHERE `Kota`='$kota' order by `Kelurahan`");
								}else{
									$query_kel = mysqli_query($koneksi,"SELECT * FROM `tbkelurahan` WHERE `Kota`='$kota' AND `KodePuskesmas`='$kodepuskesmas' order by `Kelurahan`");
								}
								while($data_kel = mysqli_fetch_assoc($query_kel)){
									if ($_GET['kelurahan'] == $data_kel['Kelurahan']){
										echo "<option value='$data_kel[Kelurahan]' SELECTed>$data_kel[Kelurahan]</option>";
									}else{
										echo "<option value='$data_kel[Kelurahan]'>$data_kel[Kelurahan]</option>";
									}
								}
								?>
							</select>
						</div>
						<div class="col-xl-5">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_indeksalamat" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
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
	$kelurahan = $_GET['kelurahan'];
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN INDEKS ALAMAT</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
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

	<div class="row font10">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min">
					<thead>
						<tr>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Tanggal</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">No.Index</th>
							<th rowspan="2" style="text-align:center;width:15%;vertical-align:middle; border:1px solid #000; padding:3px;">Nama Pasien</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">0-28Hr</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;"><1Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">1-4Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">5-14Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">15-24Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">25-44Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">45-64Th</th>
							<th colspan="2" style="text-align:center;border:1px solid #000; padding:3px;">>65Th</th>
							<th colspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Kunjungan</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--0-28Hr-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--<1Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--1-4Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--5-14Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--15-24Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--25-44Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--45-64Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">L</th><!--65Th-->
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">P</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">Baru</th>
							<th style="text-align:center;width:2%; border:1px solid #000; padding:3px;">Lama</th>
						</tr>
					</thead>
					
					<tbody style="font-size:10px;">
						<?php
						$jumlah_perpage = 100;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						$str = "SELECT a.TanggalRegistrasi, a.NoRegistrasi, a.NoIndex, a.NamaPasien, a.UmurTahun, a.UmurBulan,
						a.UmurHari, a.StatusKunjungan 
						FROM `$tbpasienrj` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex 
						WHERE YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan'".$semua;
						$str2 = $str." order by a.TanggalRegistrasi DESC limit $mulai,$jumlah_perpage";
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$noindex = $data['NoIndex'];
						$noregistrasi = $data['NoRegistrasi'];
											
						if(strlen($noindex) == 24){
							$noindex2 = substr($data['NoIndex'],14);
						}else{
							$noindex2 = $data['NoIndex'];
						}
						
						$umur128hrL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT a.UmurHari FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.Noregistrasi = '$noregistrasi' AND a.UmurTahun='0' AND a.UmurBulan='0' AND (a.UmurHari Between '0' AND '30') ".$semua."AND a.JenisKelamin = 'L'"));
						$umur128hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT a.UmurHari FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.Noregistrasi = '$noregistrasi' AND a.UmurTahun='0' AND a.UmurBulan='0' AND (a.UmurHari Between '0' AND '30') ".$semua."AND a.JenisKelamin = 'P'"));
						$umur1blL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT a.UmurBulan FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.Noregistrasi = '$noregistrasi' AND a.UmurTahun='0' AND a.UmurBulan between '1' AND '12' ".$semua."AND a.JenisKelamin = 'L'"));
						$umur1blP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT a.UmurBulan FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.Noregistrasi = '$noregistrasi' AND a.UmurTahun='0' AND a.UmurBulan between '1' AND '12' ".$semua."AND a.JenisKelamin = 'P'"));
						$umur14blL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT a.UmurTahun FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.Noregistrasi = '$noregistrasi' AND a.UmurTahun Between '1' AND '4' ".$semua."AND a.JenisKelamin = 'L'"));
						$umur14blP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT a.UmurTahun FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.Noregistrasi = '$noregistrasi' AND a.UmurTahun Between '1' AND '4' ".$semua."AND a.JenisKelamin = 'P'"));
						$umur514blL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT a.UmurTahun FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.Noregistrasi = '$noregistrasi' AND a.UmurTahun Between '5' AND '14' ".$semua."AND a.JenisKelamin = 'L'"));
						$umur514blP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT a.UmurTahun FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.Noregistrasi = '$noregistrasi' AND a.UmurTahun Between '5' AND '14' ".$semua."AND a.JenisKelamin = 'P'"));
						$umur1524blL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT a.UmurTahun FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.Noregistrasi = '$noregistrasi' AND a.UmurTahun Between '15' AND '24' ".$semua."AND a.JenisKelamin = 'L'"));
						$umur1524blP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT a.UmurTahun FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.Noregistrasi = '$noregistrasi' AND a.UmurTahun Between '15' AND '24' ".$semua."AND a.JenisKelamin = 'P'"));
						$umur2544blL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT a.UmurTahun FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.Noregistrasi = '$noregistrasi' AND a.UmurTahun Between '25' AND '44' ".$semua."AND a.JenisKelamin = 'L'"));
						$umur2544blP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT a.UmurTahun FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.Noregistrasi = '$noregistrasi' AND a.UmurTahun Between '25' AND '44' ".$semua."AND a.JenisKelamin = 'P'"));
						$umur4564blL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT a.UmurTahun FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.Noregistrasi = '$noregistrasi' AND a.UmurTahun Between '45' AND '64' ".$semua."AND a.JenisKelamin = 'L'"));
						$umur4564blP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT a.UmurTahun FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.Noregistrasi = '$noregistrasi' AND a.UmurTahun Between '45' AND '64' ".$semua."AND a.JenisKelamin = 'P'"));
						$umur65keatasL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT a.UmurTahun FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.Noregistrasi = '$noregistrasi' AND a.UmurTahun Between '65' AND '100' ".$semua."AND a.JenisKelamin = 'L'"));
						$umur65keatasP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT a.UmurTahun FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.Noregistrasi = '$noregistrasi' AND a.UmurTahun Between '65' AND '100' ".$semua."AND a.JenisKelamin = 'P'"));
						$kunjunganbaru = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT a.StatusKunjungan FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.Noregistrasi = '$noregistrasi' ".$semua."AND a.StatusKunjungan = 'BARU'"));
						$kunjunganlama = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT a.StatusKunjungan FROM `$tbpasienrj` a join `$tbkk` b on a.NoIndex = b.NoIndex WHERE a.Noregistrasi = '$noregistrasi' ".$semua."AND a.StatusKunjungan = 'LAMA'"));
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TanggalRegistrasi'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $noindex2;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur128hrL['UmurHari'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur128hrP['UmurHari'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1blL['UmurBulan'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1blP['UmurBulan'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur14blL['UmurTahun'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur14blP['UmurTahun'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur514blL['UmurTahun'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur514blP['UmurTahun'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1524blL['UmurTahun'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1524blP['UmurTahun'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur2544blL['UmurTahun'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur2544blP['UmurTahun'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4564blL['UmurTahun'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4564blP['UmurTahun'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur65keatasL['UmurTahun'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur65keatasP['UmurTahun'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $kunjunganbaru['StatusKunjungan'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $kunjunganlama['StatusKunjungan'];?></td>
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
						echo "<li><a href='?page=lap_loket_indeksalamat&kelurahan=$kelurahan&bulan=$bulan&tahun=$tahun&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>