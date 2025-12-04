<?php
	include "otoritas.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER ISPA</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_Ispa_Harian"/>
						<div class="col-xl-2">
							<SELECT name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsiform'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tanggal" <?php if($_GET['opsiform'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
							</SELECT>	
						</div>
						<div class="col-xl-3 tanggalformcari" style="display:none">
							<div class="tampilformdate">
								<input type="text" name="keydate1" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" placeholder = "Tanggal Awal" value="<?php echo $_GET['keydate1'];?>"> <input type="text" name="keydate2" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" placeholder = "Tanggal Akhir" value="<?php echo $_GET['keydate2'];?>">
							</div>
						</div>	
						<div class="col-xl-2 bulanformcari">
							<SELECT name="bulan" class="form-control">
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
							</SELECT>
						</div>
						<div class="col-xl-2 bulanformcari">
							<SELECT name="tahun" class="form-control">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</SELECT>
						</div>
						<div class="col-xl-2">
							<SELECT name="kasus" class="form-control">
								<option value="Semua" <?php if($_GET['kasus'] == 'Semua'){echo "SELECTED";}?>>Semua</option>
								<option value="Baru" <?php if($_GET['kasus'] == 'Baru'){echo "SELECTED";}?>>Baru</option>
								<option value="Lama" <?php if($_GET['kasus'] == 'Lama'){echo "SELECTED";}?>>Lama</option>
							</SELECT>
						</div>
						<?php
						if($_SESSION['kodepuskesmas'] == '-'){
						?>
							<div class="col-sm-3">
								<select name="kodepuskesmas" class="form-control">
								<option value='semua'>Semua</option>
								<?php
								$kota = $_SESSION['kota'];
								$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `Kota`='$kota' order by `NamaPuskesmas`");
								while($data3 = mysqli_fetch_assoc($queryp)){
									echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
								}
								?>
							
								</select>
							</div>
						<?php
						}
						?>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_Ispa_Harian" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_P2M_Ispa_Harian_excel.php?opsiform=<?php echo $_GET['opsiform'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kasus=<?php echo $_GET['kasus'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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

	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<?php
		$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepuskesmas'"));
		if($kodepuskesmas == "-"){
		?>
			<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
			<span class="font14" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
			<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<?php
		}else{
		?>
			<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$datapuskesmas['Kota'];?></b></span><br>
			<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$datapuskesmas['NamaPuskesmas'];?></b></span><br>
			<span class="font10" style="margin:5px;"><?php echo $datapuskesmas['Alamat']?></span>
		<?php	
		}
		?>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>REGISTER HARIAN ISPA</b></span><br>
		<?php if($opsiform == 'bulan'){?>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
		<?php }else{ ?>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y',strtotime($keydate1))." s/d ".date('d-m-Y',strtotime($keydate2));?></span>
		<?php }?>
		<br/>
		<br/>
	</div>
	<!--data registrasi-->
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead style="font-size:11px;">
						<tr style="border:1px solid #000;">
							<th rowspan="2" width="3%">NO.</th>
							<th rowspan="2" width="7%">TANGGAL PERIKSA</th>
							<th rowspan="2" width="8%">NIK</th>
							<th rowspan="2" width="15%">NAMA PASIEN</th>
							<th rowspan="2" width="15%">ALAMAT</th>
							<th colspan="2">KUNJUNGAN</th>
							<th colspan="2">GENDER</th>
							<th rowspan="2">FREKUENSI NAFAS</th>
							<th colspan="3">KLASIFIKASI</th>
							<th colspan="2">TINDAK LANJUT</th>
							<th colspan="2">ANTIBIOTIK</th>
							<th colspan="3">KONDISI SAAT KUNJ.ULG</th>
							<th rowspan="2">KET.MENINGGAL</th>
							<th colspan="2">ISPA(>5 TH)</th>
							<th rowspan="2">KET</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th>B</th>
							<th>L</th>
							<!--Gender-->
							<th>L</th>
							<th>P</th>
							<!--Klasifikasi-->
							<th>BP</th>
							<th>P</th>
							<th>PB</th>
							<!--Tindak Lanjut-->
							<th>RJ</th>
							<th>Rujuk</th>
							<!--Antibiotik-->
							<th>YA</th>
							<th>TIDAK</th>
							<!--Kondisi Saat Kunj.Ulang-->
							<th>MEMBAIK</th>
							<th>TETAP</th>
							<th>MEMBURUK</th>
							<!--Kondisi Saat Kunj.Ulang--> 
							<th>BKN PNEUMONIA</th>
							<th>PNEUMONIA</th>
						</tr>
					</thead>
					<tbody style="font-size:11px;">
						<?php
						$jumlah_perpage = 50;
						
						if($kodepuskesmas != "-"){
							$kodepuskesmas = " WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'";
						}else{
							$kodepuskesmas = " ";
						}	
						
						if($opsiform == 'bulan'){
							$waktu = " AND YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan'";
							$tbdiagnosaispa = 'tbdiagnosaispa';
						}else{
							$waktu = " AND TanggalRegistrasi BETWEEN '$keydate1' AND '$keydate2'";
							$tbdiagnosaispa = 'tbdiagnosaispa';
						}
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						// tbdiagnosaispa
						$kasus = $_GET['kasus'];
						if($kasus != 'Semua'){
							$qkasus = " AND Kunjungan = '$kasus'";
						}else{
							$qkasus = " ";
						}
						
						$str_ispa = "SELECT * FROM `$tbdiagnosaispa`".$kodepuskesmas.$waktu.$qkasus;
						$str2 = $str_ispa."order by TanggalRegistrasi ASC , NamaPasien ASC limit $mulai,$jumlah_perpage";
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query_ispa = mysqli_query($koneksi,$str2);
						while($data_ispa = mysqli_fetch_assoc($query_ispa)){
							$no = $no + 1;
							$noregistrasi = $data_ispa['NoRegistrasi'];
							$noindex = $data_ispa['NoIndex'];
							$klasifikasi = $data_ispa['Klasifikasi'];
							$tindaklanjut = $data_ispa['TindakLanjut'];
							$antibiotik = $data_ispa['AntiBiotik'];
							$kondisi = $data_ispa['KondisiKujunganUlang'];
							$ispa = $data_ispa['Ispa5tahun'];
							$kelamin = $data_ispa['Kelamin'];
							
							// tbpasienrj
							
							// tbkk
							$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
							$strkk = "SELECT * FROM `$tbkk` WHERE `NoIndex`='$noindex'";
							$dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, $strkk));
							$alamatkk = strtoupper($dtkk['Alamat']).", RT.".strtoupper($dtkk['RT']).", ".strtoupper($dtkk['Kelurahan']);
							
							if($alamatkk !=''){
								$alamat = $alamatkk;
							}else{
								$alamat = "Belum diinputkan";
							}

							// kunjungan
							if($kunjungan == 'Baru'){
								$kunjungan_b = '<span class="glyphicon glyphicon-ok"></span>';
								$kunjungan_l = '-';
							}else{
								$kunjungan_l = '<span class="glyphicon glyphicon-ok"></span>';
								$kunjungan_b = '-';
							}
							
							// kelamin
							if($kelamin == 'L'){
								$kelamin_l = $data_ispa['UmurTahun'];
								$kelamin_p = '-';
							}else{
								$kelamin_p = $data_ispa['UmurTahun'];
								$kelamin_l = '-';
							}
							
							// klasifikasi
							if($klasifikasi == 'Bukan Pneumonia'){
								$klasifikasi_bp = '<span class="glyphicon glyphicon-ok"></span>';
								$klasifikasi_p = '-';
								$klasifikasi_pb = '-';
							}elseif($klasifikasi == 'Pneumonia'){
								$klasifikasi_p = '<span class="glyphicon glyphicon-ok"></span>';
								$klasifikasi_bp = '-';
								$klasifikasi_pb = '-';
							}elseif($klasifikasi == 'Pneumonia Berat'){
								$klasifikasi_pb = '<span class="glyphicon glyphicon-ok"></span>';
								$klasifikasi_bp = '-';
								$klasifikasi_p = '-';
							}
							
							// tindaklanjut
							if($tindaklanjut == 'Rawat Jalan'){
								$rawat_jalan = '<span class="glyphicon glyphicon-ok"></span>';
								$rujuk = '-';
							}elseif($tindaklanjut == 'Rujuk'){
								$rujuk = '<span class="glyphicon glyphicon-ok"></span>';
								$rawat_jalan = '-';
							}
							
							// antibiotik
							if($antibiotik == 'Ya'){
								$Ya = '<span class="glyphicon glyphicon-ok"></span>';
								$Tidak = '-';
							}elseif($antibiotik == 'Tidak'){
								$Tidak = '<span class="glyphicon glyphicon-ok"></span>';
								$Ya = '-';
							}
							
							// kondisikunjunganulang
							if($kondisi == 'Membaik'){
								$membaik = '<span class="glyphicon glyphicon-ok"></span>';
								$tetap = '-';
								$memburuk = '-';
							}elseif($kondisi == 'Tetap'){
								$tetap = '<span class="glyphicon glyphicon-ok"></span>';
								$membaik = '-';
								$memburuk = '-';
							}elseif($kondisi == 'Memburuk'){
								$memburuk = '<span class="glyphicon glyphicon-ok"></span>';
								$membaik = '-';
								$tetap = '-';
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
							
							// ispa
							if(strpos($data_dgs, "J18") !== false){
								$pneumoni = '<span class="glyphicon glyphicon-ok"></span>';
								$bukanpneumoni = '-';
							}else{
								$bukanpneumoni = '<span class="glyphicon glyphicon-ok"></span>';
								$pneumoni = '-';
							}

							// vitalsign
							$str_vitalsign = "SELECT * FROM $tbvitalsign WHERE `IdPasienrj`='$idpasienrj'";
						
						?>
							<tr style="border:1px solid #000;">
								<td><?php echo $no;?></td>
								<td><?php echo date('d-m-Y', strtotime($data_ispa['TanggalRegistrasi']));?></td>
								<td>
									<?php 
										// nik
										$tbpasien = 'tbpasien_'.str_replace(' ', '', $namapuskesmas);
										$dtreg = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoCM` FROM `$tbpasienrj` WHERE `NoRegistrasi`='$noregistrasi'"));
										$dtnik = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Nik` FROM `$tbpasien` WHERE `NoCM`='$dtreg[NoCM]'"));
										echo $dtnik['Nik'];
									?>
								</td>
								<td><?php echo $data_ispa['NamaPasien'];?></td>
								<td><?php echo $alamat;?></td>
								<td><?php echo $kunjungan_b;?></td>
								<td><?php echo $kunjungan_l;?></td>
								<td><?php echo $kelamin_l;?></td>
								<td><?php echo $kelamin_p;?></td>
								<td><?php echo $data_ispa['FrekuensiNafas'];?></td>
								<td><?php echo $klasifikasi_bp;?></td>
								<td><?php echo $klasifikasi_p;?></td>
								<td><?php echo $klasifikasi_pb;?></td>
								<td><?php echo $rawat_jalan;?></td>
								<td><?php echo $rujuk;?></td>
								<td><?php echo $Ya;?></td>
								<td><?php echo $Tidak;?></td>
								<td><?php echo $membaik;?></td>
								<td><?php echo $tetap;?></td>
								<td><?php echo $memburuk;?></td>
								<td><?php echo $data_ispa['KeteranganMeninggal'];?></td>
								<td><?php echo $bukanpneumoni;?></td>
								<td><?php echo $pneumoni;?></td>
								<td><?php echo $data_dgs;?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div><hr/>
	<ul class="pagination noprint">
		<?php
			$query2 = mysqli_query($koneksi,$str_ispa);
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
						if($_SESSION['kodepuskesmas'] == '-'){
							$kdpuskesmas = $_GET['kodepuskesmas'];
							echo "<li><a href='?page=lap_P2M_Ispa_Harian&kodepuskesmas=$kdpuskesmas&bulan=$bulan&tahun=$tahun&kasus=$kasus&h=$i'>$i</a></li>";
						}else{
							$kdpuskesmas = $_SESSION['kodepuskesmas'];
							echo "<li><a href='?page=lap_P2M_Ispa_Harian&opsiform=$opsiform&keydate1=$keydate1&keydate2=$keydate2&bulan=$bulan&tahun=$tahun&kasus=$kasus&h=$i'>$i</a></li>";
						}
						
					}
				}
			}
		?>
	</ul>
	<?php
	}
	?>
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<div class="formbg">
				<p>
					<b>Perhatikan :</b><br/>
					Pneumonia & Pneuminia Berat (J18)<br/>
					Bukan Pneumonia Selain (J18)<br/>
					Batuk Bukan Pneumonia (J00, J06,J11, J20, J21, J30, J39, J44, J45, J46, J47)<br>
					Nafas diambil dari RR Poli Anak, jika RR = 0 maka data tidak akan diambil<br>
					Perubahan klasifikasi kode ICD X silahkan konsultasi pemegang program di Puskesmas & Dinkes<br>
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