<?php
	session_start();
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DAFTAR ONLINE (REGISTER)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_antrian_daftar_online_register"/>
						<div class="col-xl-2">
							<select name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsiform'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tanggal" <?php if($_GET['opsiform'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
							</select>	
						</div>
						<div class="col-xl-4 tanggalformcari" style="display:none">
							<div class="tampilformdate">
								<input type="text" name="keydate1" class="form-control datepicker2" style="width:170px;float:left;margin-right:10px;" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal"> <input type="text" name="keydate2" class="form-control datepicker2" style="width:170px;float:left;margin-right:10px;" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir">
							</div>
						</div>	
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
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="asalpasien" class="form-control asuransi">
								<option value='semua_pasien'>Semua</option>
								<?php
								$query = mysqli_query($koneksi,"SELECT * FROM `tbasalpasien` order by `AsalPasien` ASC");
									while($data = mysqli_fetch_assoc($query)){
										if($_GET['asalpasien'] == $data['AsalPasien']){
											echo "<option value='$data[Id]' SELECTED>$data[AsalPasien]</option>";
										}else{
											echo "<option value='$data[Id]'>$data[AsalPasien]</option>";
										}
									}
								?>
							</select>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_antrian_daftar_online_register" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_antrian_daftar_online_register_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&asalpasien=<?php echo $_GET['asalpasien'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];
	$asalpasien = $_GET['asalpasien'];
	if(isset($bulan) and isset($tahun)){
	?>
	<div class="table-responsive printini" style="overflow: hidden;">
		<div class="row">
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table-judul-laporan" width="100%">
						<thead>
							<tr style="border:1px solid #000;">
								<th width="3%" rowspan="2">NO.</th>
								<th width="12%" rowspan="2">TGL.DAFTAR</th>
								<th width="10%" rowspan="2">NIK</th>
								<th width="20%" rowspan="2">NAMA PASIEN</th>
								<th width="30%" rowspan="2">ALAMAT</th>
								<th width="10%" rowspan="2">PELAYANAN</th>
								<th colspan="2" >CARA BAYAR</th>
								<th width="5%" rowspan="2">KET.</th>
							</tr>
							<tr style="border:1px solid #000;">
								<th width="5%">CARA BAYAR</th>
								<th width="5%">NOMOR</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$jumlah_perpage = 50;
							
							if($_GET['h']==''){
								$mulai=0;
							}else{
								$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							if($opsiform == 'bulan'){
								$waktu = "YEAR(WaktuDaftar) = '$tahun' AND MONTH(WaktuDaftar) = '$bulan'";			
								if ($asalpasien == 'semua_pasien'){
									$str = "SELECT * FROM `$tbpasienonline` WHERE ".$waktu;
								}else{
									$str = "SELECT * FROM `$tbpasienonline` WHERE ".$waktu;
								}	
								// echo $str;
							}else{
								$waktu = "date(`WaktuDaftar`) BETWEEN '$keydate1' AND '$keydate2'";
								
								if ($asalpasien == 'semua_pasien'){
									$str = "SELECT * FROM(
									SELECT * FROM `$tbpasienonline`
									WHERE ".$waktu."
									UNION
									SELECT * FROM `$tbpasienonline`
									WHERE ".$waktu."
									) tbalias";
								}else{
									$str = "SELECT * FROM(
									SELECT * FROM `$tbpasienonline`
									WHERE ".$waktu." and AsalPasien='$asalpasien'
									UNION
									SELECT * FROM `$tbpasienonline`
									WHERE ".$waktu." and AsalPasien='$asalpasien'
									) tbalias";
								}
							}
							$str2 = $str." ORDER BY WaktuDaftar DESC, NamaPasien ASC LIMIT $mulai,$jumlah_perpage";
							// echo $str2;
							
							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							$query = mysqli_query($koneksi,$str2);
							while($data = mysqli_fetch_assoc($query)){
								$no = $no + 1;
								$nik = $data['Nik'];

                                // tbpasien
								$strpasien = "SELECT * FROM `$tbpasien` WHERE `Nik` = '$nik'";
								$querypasien = mysqli_query($koneksi, $strpasien);
								$datapasien = mysqli_fetch_assoc($querypasien);								
																		
								// tbkk
								$strkk = "SELECT Alamat, RT, No, Kelurahan FROM `$tbkk` WHERE `NoIndex` = '$datapasien[NoIndex]'";
                                $querykk = mysqli_query($koneksi, $strkk);
								$datakk = mysqli_fetch_assoc($querykk);
								$alamat = $datakk['Alamat'];
								
								if($alamat != null){
									$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", NO.".$datakk['No'].", DS/KEL.".$datakk['Kelurahan'];
								}else{
									$alamat = "-";
								}
								
							?>
								<tr style="border:1px solid #000;">
									<td align="center"><?php echo $no;?></td>
									<td align="center"><?php echo date('d-m-Y G:i:s', strtotime($data['WaktuDaftar']));?></td>
									<td align="center"><?php echo $data['Nik'];?></td>
									<td align="left"><?php echo strtoupper($data['NamaPasien']);?></td>
									<td align="left">
										<?php 
											if ($alamat == ''){
												echo $alamat = '<span style="color:red;">Belum Terdaftar di Puskesmas</span>';
											}else{
												echo $alamat;
											}
										?>
									</td>
									<td align="center"><?php echo str_replace('POLI','',$data['PoliPertama']);?></td>
									<td align="center"><?php echo $data['Asuransi'];?></td>
									<td align="center"><?php echo $data['NoAsuransi'];?></td>	
									<td align="center">
										<?php 
											if($data['AsalPasien'] == "1"){
												echo "KELAS BALITA";
											}elseif($data['AsalPasien'] == "2"){
												echo "KELAS IBU";
											}elseif($data['AsalPasien'] == "3"){
												echo "PENYULUHAN KELOMPOK";
											}elseif($data['AsalPasien'] == "4"){
												echo "PENYULUHAN KELUARGA";
											}elseif($data['AsalPasien'] == "5"){
												echo "POLINDES";
											}elseif($data['AsalPasien'] == "6"){
												echo "POSBINDU";
											}elseif($data['AsalPasien'] == "7"){
												echo "POSKESDES";
											}elseif($data['AsalPasien'] == "8"){
												echo "POSYANDU";
											}elseif($data['AsalPasien'] == "9"){
												echo "PUSKEL";
											}elseif($data['AsalPasien'] == "10"){
												echo "PUSKESMAS";
											}elseif($data['AsalPasien'] == "11"){
												echo "PUSTU";
											}elseif($data['AsalPasien'] == "12"){
												echo "STBM";
											}elseif($data['AsalPasien'] == "13"){
												echo "PERKESMAS";
											}			
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
						echo "<li><a href='?page=lap_antrian_daftar_online_register&opsiform=$opsiform&keydate1=$keydate1&keydate2=$keydate2&bulan=$bulan&tahun=$tahun&asalpasien=$asalpasien&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	
	<div class="row noprint">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<p>
					<b>Perhatikan :</b><br/>
					Print laporan silahkan klik tombol Export
				</p>
			</div>
		</div>
	</div>
	
	<?php
	}
	?>
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