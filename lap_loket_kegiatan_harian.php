<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KEGIATAN HARIAN TENAGA KESEHATAN</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_kegiatan_harian"/>
						<div class="col-xl-2">
							<SELECT name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsi'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tanggal" <?php if($_GET['opsi'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
							</SELECT>	
						</div>
						<div class="col-xl-3 tanggalformcari" style="display:none">
							<div class="tampilformdate">
								<input type="text" name="keydate1" class="form-control datepicker2" style="width:100px;float:left;margin-right:10px;" placeholder = "Tanggal Awal"> <input type="text" name="keydate2" class="form-control datepicker2" style="width:100px;float:left;margin-right:10px;" placeholder = "Tanggal Akhir">
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
									for($tahun = 2017; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						
						<?php
						if($_SESSION['kodepuskesmas'] == '-'){
						?>
							<div class="col-xl-2">
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
						<?php
						}
						?>
						<div class="col-xl-3">
							<select name="namapegawai" class="form-control" style="width:250px;">
								<option value='semua_pasien'>Semua</option>
								<?php
								$query = mysqli_query($koneksi,"SELECT * FROM `tbpegawai` WHERE SUBSTRING(KodePuskesmas,1,11)='$kodepuskesmas' order by `NamaPegawai` ASC");
									while($data = mysqli_fetch_assoc($query)){
										if($_GET['namapegawai'] == $data['NamaPegawai']){
											echo "<option value='$data[NamaPegawai]' SELECTed>$data[NamaPegawai]</option>";
										}else{
											echo "<option value='$data[NamaPegawai]'>$data[NamaPegawai]</option>";
										}
									}
								?>
							</select>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_kegiatan_harian" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_loket_kegiatan_harian_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $kodepuskesmas;?>&pg=<?php echo $_GET['namapegawai'];?>&op=<?php echo $_GET['opsiform'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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
	$pegawai = $_GET['namapegawai'];

	if(isset($bulan) and isset($tahun)){
	?>

	<div class="row noprint">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead>
						<tr>
							<th rowspan="3" style="text-align:center;width:3%; vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th rowspan="3" style="text-align:center;width:3%; vertical-align:middle; border:1px solid #000; padding:3px;">No.Index</th>
							<th rowspan="3" style="text-align:center;width:10%; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Pasien</th>
							<th rowspan="3" style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">Umur</th>
							<th colspan="17" style="text-align:center; vertical-align:middle;  border:1px solid #000; padding:3px;">Isi salah satu kolom dengan tanda <i class="ace-icon glyphicon glyphicon-ok"></i></th>
						</tr>
						<tr style="border:1px solid #000;">
							<th rowspan="2" style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">Rawat Jalan TK I</th>
							<th rowspan="2" style="text-align:center;width:6%; vertical-align:middle; border:1px solid #000; padding:3px;">Konsul Pertama</th>
							<th colspan="2" style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">Tindakan Khusus</th>
							<th colspan="2" style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">Tindakan P3K</th>
							<th rowspan="2" style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">Visit Pasien R.Inap</th>
							<th rowspan="2" style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">Pemulihan Mental/Fisik</th>
							<th colspan="4" style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">Pemeliharaan Kesehatan</th>
							<th rowspan="2" style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">Pelayanan KB</th>
							<th rowspan="2" style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">Pelayanan Imunisasi</th>
							<th rowspan="2" style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">Menerima Konsultasi</th>
							<th rowspan="2" style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">Menguji Kesehatan</th>
							<th rowspan="2" style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">Lain-lain (Visum, Saksi Ahli, dll)</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">Sederhana</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">Sedang</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">Sederhana</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">Sedang</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">KK</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">Ibu</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">Bayi/Balita</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">Anak</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">1</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">2</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">3</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">4</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">5</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">6</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">7</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">8</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">9</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">10</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">11</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">12</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">13</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">14</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">15</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">16</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">17</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">18</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">19</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">20</th>
							<th style="text-align:center;width:2%; vertical-align:middle; border:1px solid #000; padding:3px;">21</th>
						</tr>
					</thead>
					
					<tbody>
						<?php
						$jumlah_perpage = 20;

						if ($tahun == $tahunini){
							$tbpasienrj = $tbpasienrj;
						}else{
							$tbpasienrj = 'tbpasienrj_'.str_replace(' ', '', $namapuskesmas)."_RETENSI";
						}
						
						if($opsiform == 'bulan'){
							$waktu = "YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan'";
							$tbpasienperpegawai = 'tbpasienperpegawai_'.$kodepuskesmas;
						}else{
							$waktu = "TanggalRegistrasi BETWEEN '$keydate1' AND '$keydate2'";
							$tbpasienperpegawai = 'tbpasienperpegawai_'.$kodepuskesmas;
						}
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$str = "SELECT * FROM `$tbpasienperpegawai` WHERE $waktu AND (`Pendaftaran`='$pegawai' 
						OR `NamaPegawai1`='$pegawai'
						OR `NamaPegawai2`='$pegawai'
						OR `NamaPegawai3`='$pegawai'
						OR `NamaPegawai4`='$pegawai'
						OR `NamaPegawai5`='$pegawai'
						OR `Lab`='$pegawai'
						OR `Farmasi`='$pegawai')";
						$str2 = $str." order by Tanggalregistrasi, NoRegistrasi limit $mulai,$jumlah_perpage";
						// echo $str2;
						// die();
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query = mysqli_query($koneksi, $str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;							
							$noregistrasi = $data['NoRegistrasi'];
							// $tbpasienrj
							$data_rj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$data[NoRegistrasi]'"));
							$noindex = $data_rj['NoIndex'];
						?>
							<tr>
								<td><?php echo $no;?></td>
								<td><?php echo substr($noindex,-10);?></td>
								<td><?php echo $data_rj['NamaPasien'];?></td>
								<td><?php echo $data_rj['UmurTahun'];?></td>
								<td><?php if ($data_rj['JenisKunjungan'] == '1'){?><span class="fa fa-check"></span><?php }else{echo "-";}?></td>
								<td><?php echo $data_rj['PoliPertama'];?></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>
									<?php 
										if ($data_rj['JenisKelamin'] == 'L'){
											if ($data_rj['UmurTahun'] >= '17'){ ?>
												<span class="fa fa-check"></span> 
											<?php
											}else{
												echo "-";
											}
											?>
									<?php
										}else{
											echo "-";
										}
									?>
								</td>
								<td>
									<?php 
										if ($data_rj['JenisKelamin'] == 'P'){
											if ($data_rj['UmurTahun'] >= '17'){ ?>
												<span class="fa fa-check"></span>
											<?php
											}else{
												echo "-";
											}
											?>
									<?php
										}else{
											echo "-";
										}
									?>
								</td>
								<td>
									<?php 
										if ($data_rj['UmurTahun'] <= '5'){ ?>
											<span class="fa fa-check"></span>
										<?php
										}else{
											echo "-";
										}
									?>
								</td>
								<td>
									<?php 
										if ($data_rj['UmurTahun'] >= '6' AND $data_rj['UmurTahun'] <= '16'){ ?>
											<span class="fa fa-check"></span>
										<?php
										}else{
											echo "-";
										}
									?>
								</td>
								<td><?php echo $umur1830hrL['Jml'];?></td>
								<td><?php echo $umur1830hrL['Jml'];?></td>
								<td><?php echo $umur1830hrL['Jml'];?></td>
								<td><?php echo $umur1830hrL['Jml'];?></td>
								<td><?php echo $umur1830hrL['Jml'];?></td>
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
						echo "<li><a href='?page=lap_loket_kegiatan_harian&keydate1=$keydate1&keydate2=$keydate2&opsiform=$opsiform&bulan=$bulan&tahun=$tahun&namapegawai=$pegawai&h=$i'>$i</a></li>";
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
$('.opsiform').change(function(){
	if($(this).val() == 'bulan'){
		$(".bulanformcari").show();
		$(".tanggalformcari").hide();
	}else{	
		$(".bulanformcari").hide();
		$(".tanggalformcari").show();
	}
});	
</script>