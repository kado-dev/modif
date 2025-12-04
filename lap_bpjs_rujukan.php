<?php
	include "otoritas.php";
	include "config/helper_pasienrj.php";
	$kota = $_SESSION['kota'];
	$tanggal = date('Y-m-d');
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>RUJUKAN BPJS</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_bpjs_rujukan"/>
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
									for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
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
								$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `Kota`='$kota' order by `NamaPuskesmas`");
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
							<a href="?page=lap_bpjs_rujukan" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
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
		<table class="table table-condensed table-judul-laporan" width="100%">
			<thead style="font-size:10px;">
				<tr style="border:0.3px solid #000;">
					<th rowspan="2" width="3%">NO.</th>
					<th rowspan="2" width="6%">TGL</th>
					<th rowspan="2" width="15%">NAMA</th>
					<th rowspan="2" width="5%">UMUR</th>
					<th rowspan="2" width="8%">PISA</th>
					<th rowspan="2" width="15%">DIAGNOSA</th>
					<th rowspan="2" width="8%">PELAYANAN</th>
					<th rowspan="2" width="5%">DIRUJUK</th>
					<th rowspan="2" width="10%">ASURANSI</th>
					<th rowspan="2" width="10%">NOMOR KARTU</th>
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
				
				if ($sts_bpjs == 'semua'){
					$str = "SELECT * FROM `$tbpasienrj` WHERE SUBSTRING(NoRegistrasi,1,11) = '$kodepuskesmas' AND YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan'
					AND (Asuransi = 'BPJS PBI' OR Asuransi = 'BPJS NON PBI') AND StatusPulang = '4'";
				}else{
					$str = "SELECT * FROM `$tbpasienrj` WHERE SUBSTRING(NoRegistrasi,1,11) = '$kodepuskesmas' AND YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan'
					AND Asuransi = '$sts_bpjs' AND StatusPulang = '4'";
				}
				$str2 = $str."GROUP BY NoCM ORDER BY Tanggalregistrasi, NamaPasien limit $mulai,$jumlah_perpage";
				
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
					$asuransi = $data['Asuransi'];
					
					// tbpasien
					$tbpasien = "tbpasien_".substr($data['NoCM'],12,4);
					$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `NoCM`='$nocm'"));
					
					//tbpoli
					if($data['PoliPertama'] == 'POLI UMUM'){
						$strpoli = "SELECT Diagnosa from tbpoliumum where NoPemeriksaan = '$data[NoRegistrasi]'"; 
					}else if($data['PoliPertama'] == 'POLI GIGI'){
						$strpoli = "SELECT Diagnosa from tbpoligigi where NoPemeriksaan = '$data[NoRegistrasi]'"; 
					}else if($data['PoliPertama'] == 'POLI LANSIA'){
						$strpoli = "SELECT Diagnosa from tbpolilansia where NoPemeriksaan = '$data[NoRegistrasi]'"; 
					}else if($data['PoliPertama'] == 'POLI KIA'){
						$strpoli = "SELECT Diagnosa from tbpolikia where NoPemeriksaan = '$data[NoRegistrasi]'"; 
					}else if($data['PoliPertama'] == 'POLI KB'){
						$strpoli = "SELECT Diagnosa from tbpolikb where NoPemeriksaan = '$data[NoRegistrasi]'"; 
					}else{
						$strpoli = "";
					}
					if($strpoli == ""){
						$diagnosa = '-';
					}else{
						if(mysqli_num_rows(mysqli_query($koneksi,$strpoli))==0){
							$diagnosa = '-';
						}else{
							$datapoli = mysqli_fetch_assoc(mysqli_query($koneksi,$strpoli));
							if($datapoli['Diagnosa'] != 'null'){
								$diag = json_decode($datapoli['Diagnosa']);
								$diagnosa = implode(", ",$diag);
							}else{
								$diagnosa = '-';
							}
						}
					}
											
					//cek rujukan
					$rujukan = $data['StatusPulang'];
					if ($rujukan == '3'){
						$berobatjalan = '<span class="fa fa-check"></span>';
						$rujuklanjut = '-';
					}else if($rujukan == '4'){
						$rujuklanjut = '<span class="fa fa-check"></span>';
						$berobatjalan = '-';
					}
							
					?>
						<tr style="border:0.3px solid #000;">
							<td style="text-align:right; border:0.3px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:0.3px solid #000; padding:3px;"><?php echo $data['TanggalRegistrasi'];?></td>
							<td style="text-align:left; border:0.3px solid #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
							<td style="text-align:center; border:0.3px solid #000; padding:3px;"><?php echo $data['UmurTahun']." Th";?></td>
							<td style="text-align:center; border:0.3px solid #000; padding:3px;"><?php echo strtoupper($datapasien['StatusAsuransi']);?></td>
							<td style="text-align:left; border:0.3px solid #000; padding:3px;"><?php echo $diagnosa;?></td>
							<td style="text-align:center; border:0.3px solid #000; padding:3px;"><?php echo $data['PoliPertama'];?></td>
							<td style="text-align:center; border:0.3px solid #000; padding:3px;"><?php echo $rujuklanjut;?></td>
							<td style="text-align:center; border:0.3px solid #000; padding:3px;"><?php echo $data['Asuransi'];?></td>
							<td style="text-align:center; border:0.3px solid #000; padding:3px;"><?php echo $data['nokartu'];?></td>
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
						echo "<li><a href='?page=lap_bpjs_rujukan&bulan=$bulan&tahun=$tahun&sts_bpjs=$sts_bpjs&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>	
<?php
}
?>

