<?php
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>WABAH (W2)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_wabah"/>
						<div class="col-xl-4">
							<div class="tampilformdate">
								<input type="text" name="keydate1" value="<?php echo $_GET['keydate1'];?>" class="form-control datepicker2" style="width:150px;float:left;margin-right:10px;" placeholder = "Tanggal Awal" required> <input type="text" name="keydate2" value="<?php echo $_GET['keydate2'];?>" class="form-control datepicker2" style="width:150px;float:left;margin-right:10px;" placeholder = "Tanggal Akhir" required>
							</div>
						</div>	
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_wabah" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
							<a href="lap_P2M_wabah_excel.php?kodepuskesmas=<?php echo $kodepuskesmas;?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>	
			</div>	
		</div>
	</div>
	<?php
	$tgl1 = $_GET['keydate1'];
	$tgl2 = $_GET['keydate2'];
	if(isset($tgl1) and isset($tgl2)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "UPT. PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN WABAH (W2)</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo $tgl1." s/d ".$tgl2;?>
		</span><br/>
	</div>

	<div class="atastabel font11">
		<div style="float:left; width:35%; margin-bottom:10px;">	
			<table style="font-size:10px; width:300px;">
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
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead>
						<tr style="border:1px solid #000;">
							<th rowspan="2" width="7%">KODE SMS</th>
							<th rowspan="2" width="8%">KODE DIAGNOSA<br/>ICD X</th>
							<th rowspan="2" width="60%">NAMA DIAGNOSA</th>
							<th colspan="2">JUMLAH KASUS</th>
							<th rowspan="2" width="10%">TOTAL KASUS</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th width="5%">BARU</th>
							<th width="5%">LAMA</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$str = "SELECT * FROM `tbdiagnosaw2`";
						$str2 = $str."ORDER BY `KodeSms` ASC";
						$query = mysqli_query($koneksi, $str2);
						while($data = mysqli_fetch_assoc($query)){
							// kasus baru							
							$str_baru = "SELECT COUNT(KodeDiagnosa) AS Jumlah FROM `$tbdiagnosapasien` WHERE TanggalDiagnosa Between '$tgl1' and '$tgl2' AND (KodeDiagnosa like '%".$data['KodeDiagnosa']."%') AND `Kasus` = 'Baru'";
							$baru = mysqli_fetch_assoc(mysqli_query($koneksi,$str_baru));
							
							// kasus lama
							$str_lama = "SELECT COUNT(KodeDiagnosa) AS Jumlah FROM `$tbdiagnosapasien` WHERE TanggalDiagnosa Between '$tgl1' and '$tgl2' AND (KodeDiagnosa like '%".$data['KodeDiagnosa']."%') AND `Kasus` = 'Lama'";
							$lama = mysqli_fetch_assoc(mysqli_query($koneksi,$str_lama));
							
							// ngecek jika bulannya sama
							$jumlah_baru = $baru['Jumlah'];
							$jumlah_lama = $lama['Jumlah'];
						?>
							<tr style="border:1px solid #000;">
								<td align="center"><?php echo $data['KodeSms'];?></td>
								<td align="center"><?php echo $data['KodeDiagnosa'];?></td>
								<td align="left"><?php echo strtoupper($data['NamaDiagnosa']);?></td>
								<td align="right"><?php echo $jumlah_baru;?></td>
								<td align="right"><?php echo $jumlah_lama;?></td>
								<td align="right"><?php echo $jumlah_baru + $jumlah_lama;?></td>
							</tr>
						<?php
						}
						?>
							<tr style="border:1px solid #000; font-weight: bold;">
								<td></td>
								<td></td>
								<td>JUMLAH KUNJUNGAN PASIEN</td>
								<td colspan="3" align="right">
								<?php 
									$jmlkunjungan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj) AS Jml FROM `$tbpasienrj` WHERE date(TanggalRegistrasi) BETWEEN '$tgl1' AND '$tgl2'"));
									echo $jmlkunjungan['Jml'];
								?>
								</td>
							</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="bawahtabel">
		<table width="100%">
			<tr>
				<td width="5%"></td>
				<td style="text-align:center;">
					MENGETAHUI<br>
					<?php echo "KEPALA UPT ".$namapuskesmas;?>
					<br><br><br><br><br>
					<u><?php echo $datapuskesmas['KepalaPuskesmas'];?></u><br>
					<?php echo "NIP.".$datapuskesmas['Nip'];?>
				</td>
				<td width="10%"></td>
				<td style="text-align:center;">
					<?php echo $kota;?><br>
					PELAKSANA PROGRAM
					<br><br><br><br><br>
					(..........................................................)
				</td>
			</tr>
		</table>
	</div>
	<?php
	}
	?>
</div>	
