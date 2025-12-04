<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>PASIEN BPJS KUNJUNGAN</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_bpjs_kunjungan"/>
						<div class="col-sm-2">
							<select name="bulan" class="form-control">
								<option value="01" <?php if($_GET['bulan'] == '01'){echo "selectED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulan'] == '02'){echo "selectED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulan'] == '03'){echo "selectED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulan'] == '04'){echo "selectED";}?>>April</option>
								<option value="05" <?php if($_GET['bulan'] == '05'){echo "selectED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulan'] == '06'){echo "selectED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulan'] == '07'){echo "selectED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulan'] == '08'){echo "selectED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulan'] == '09'){echo "selectED";}?>>September</option>
								<option value="10" <?php if($_GET['bulan'] == '10'){echo "selectED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulan'] == '11'){echo "selectED";}?>>November</option>
								<option value="12" <?php if($_GET['bulan'] == '12'){echo "selectED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-sm-1" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "selectED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<?php
						if($_SESSION['kodepuskesmas'] == '-'){
						?>
							<div class="col-sm-2">
								<select name="kodepuskesmas" class="form-control">
								<option value='semua'>Semua</option>
								<?php
								$kota = $_SESSION['kota'];
								$queryp = mysqli_query($koneksi,"select * FROM `tbpuskesmas` WHERE `Kota`='$kota' order by `NamaPuskesmas`");
								while($data3 = mysqli_fetch_assoc($queryp)){
									echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
								}
								?>
								</select>
							</div>
						<?php
						}
						?>
						<div class="col-sm-2">
							<select name="sts_bpjs" class="form-control" style="width:150px;">
								<option value="semua" <?php if($_GET['sts_bpjs'] == 'semua'){echo "selectED";}?>>Semua</option>
								<option value="BPJS PBI" <?php if($_GET['sts_bpjs'] == 'BPJS PBI'){echo "selectED";}?>>BPJS PBI</option>
								<option value="BPJS NON PBI" <?php if($_GET['sts_bpjs'] == 'BPJS NON PBI'){echo "selectED";}?>>BPJS NON PBI</option>
							</select>
						</div>
						<div class="col-sm-5">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_bpjs_kunjungan" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="lap_bpjs_kunjungan_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&sts_bpjs=<?php echo $_GET['sts_bpjs'];?>" class="btn btn-sm btn-info">Excel</a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
	
	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$sts_bpjs = $_GET['sts_bpjs'];
		
	if($bulan != null AND $tahun != null){	
	?>

	<div class="table-responsive noprint">
		<table class="table table-condensed table-judul-laporan">
			<thead style="font-size:10px;">
				<tr style="border:1px solid #000;">
					<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
					<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tanggal</th>
					<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.index</th>
					<th rowspan="2" width="6%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.RM</th>
					<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Peserta</th>
					<th rowspan="2" width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Alamat</th>
					<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">L/P</th>
					<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Umur (Th)</th>
					<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Poli</th>
					<th colspan="2" width="15%"  style="text-align:center; border:1px solid #000; padding:3px;">Cara Bayar/Jaminan/Asuransi</th>
					<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kunj.</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th style="text-align:center; border:1px solid #000; padding:3px;">Jaminan</th>
					<th style="text-align:center; border:1px solid #000; padding:3px;">No.Jaminan</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$jumlah_perpage = 100;
				
				if($_GET['h']==''){
					$mulai=0;
				}else{
					$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}
				
				if ($sts_bpjs == 'semua'){
					$str = "SELECT * FROM `$tbpasienrj` WHERE SUBSTRING(Asuransi,1,4) = 'BPJS' AND YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND `StatusPelayanan` = 'Sudah' AND `kdprovider` = '$kodeppk' AND `NoUrutBpjs` != ''";
				}else{
					$str = "SELECT * FROM `$tbpasienrj` WHERE Asuransi = '$sts_bpjs' AND YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND `StatusPelayanan` = 'Sudah' AND `kdprovider` = '$kodeppk' AND `NoUrutBpjs` != ''";
				}
				$str2 = $str." ORDER BY Tanggalregistrasi, NamaPasien ASC limit $mulai,$jumlah_perpage";
				// echo $str2;	
				
				if($_GET['h'] == null || $_GET['h'] == 1){
					$no = 0;
				}else{
					$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}
				
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;	
					$noindex = $data['NoIndex'];
					$nocm = $data['NoCM'];
					$norm = $data['NoRM'];
					$asuransi = $data['Asuransi'];
					$noasuransi = $data['nokartu'];
								
					if(substr($asuransi,0,4) == 'BPJS'){
						$noasuransi = $data['nokartu'];
					}else{
						$noasuransi = "0";
					}
					
					// tbkk
					$dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Alamat, RT, RW, Kelurahan FROM `$tbkk` WHERE `NoIndex`='$noindex'"));
					if($dtkk['Alamat'] != ""){
						$alamat = $dtkk['Alamat'].", RT.".$dtkk['RT']." Kel.".$dtkk['Kelurahan'];
					}else{
						$alamat = "-";
					}		
				?>
					<tr style="border:1px solid #000;">
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TanggalRegistrasi'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($noindex,-5);?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($norm,-6);?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $alamat;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['JenisKelamin'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['UmurTahun']." Th";?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['PoliPertama'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Asuransi'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $noasuransi;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['StatusKunjungan'];?></td>		
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
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
						echo "<li><a href='?page=lap_bpjs_kunjungan&bulan=$bulan&tahun=$tahun&sts_bpjs=$sts_bpjs&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<div class="row noprint">
		<div class="alert alert-block alert-success fade in">
			<p><b>Keterangan :</b><br/> 
			Pasien berkunjung lebih dari 1 (satu) kunjungan, misal 3 kali maka dihitung 3 kali Kunjungan.</p>	
			</p>	
		</div>
	</div>
</div>
<?php
	}
?>