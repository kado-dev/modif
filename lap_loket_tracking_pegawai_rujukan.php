<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>RUJUKAN PER-PEGAWAI</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_tracking_pegawai_rujukan"/>
						<div class="col-xl-2">
							<select name="bulan" class="form-control">
								<option value="01">Januari</option>
								<option value="02">Februari</option>
								<option value="03">Maret</option>
								<option value="04">April</option>
								<option value="05">Mei</option>
								<option value="06">Juni</option>
								<option value="07">Juli</option>
								<option value="08">Agustus</option>
								<option value="09">September</option>
								<option value="10">Oktober</option>
								<option value="11">November</option>
								<option value="12">Desember</option>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="tahun" class="form-control">
								<?php
								for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
								?>
								<option value="<?php echo $tahun;?>"><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_tracking_pegawai_rujukan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
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
	
	if($bulan != null AND $tahun != null){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:2px; border:1px solid #000">
		<span class="font12" style="margin:15px 5px 5px 5px;"><b>LAPORAN RUJUKAN PER-PEGAWAI</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)?> <?php echo $tahun;?></span>
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
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min">
					<thead>
						<tr style="border:1px solid #000;">
							<th style="text-align:center;width:1%;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
							<th style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">Nama Pegawai</th>
						<?php
							$bln = $_GET['bulan'];
							$thn = $_GET['tahun'];
						
							$mulai = 1;
							$selesai = 31;
							for($d = $mulai;$d <= $selesai; $d++){	

						?>
							<th style="text-align:center;width:1%;vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $d;?></th>
						<?php
							}
						?>
							<th style="text-align:center;width:1%;vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</th>
						</tr>
					</thead>
					
					<tbody style="font-size:10px;">
						<?php
						$str = "SELECT `NamaPegawai` FROM `tbpegawai`  WHERE `KodePuskesmas` = '$kodepuskesmas' AND `Status` = 'Dokter' ORDER BY `NamaPegawai` ASC";
						$query = mysqli_query($koneksi,$str);
						$tgl1 = 0;
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$namapegawai = strtoupper($data['NamaPegawai']);
						?>
						
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaPegawai'];?></td>	
								<?php
								$jml = 0;	
								for($d2= $mulai;$d2 <= $selesai; $d2++){	
								$tanggal = $thn."-".$bln."-".$d2;
								$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
								// $tbpasienrj = "tbpasienrj_".$bln;
								// pendaftaran
								$strs = "SELECT COUNT(a.NoRegistrasi) as jumlah FROM `$tbpasienperpegawai` a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi WHERE a.`TanggalRegistrasi` = '$tanggal' AND substring(a.NoRegistrasi,1,11)='$kodepuskesmas' AND b.StatusPulang = '4' AND (a.`Pendaftaran`='$namapegawai')";
										
								// pemeriksaan
								$strs2 = "SELECT COUNT(a.NoRegistrasi) as jumlah FROM `$tbpasienperpegawai` a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi	WHERE a.`TanggalRegistrasi` = '$tanggal' AND substring(a.NoRegistrasi,1,11)='$kodepuskesmas' AND b.StatusPulang = '4' AND (a.`NamaPegawai1`='$namapegawai' OR a.`NamaPegawai2` ='$namapegawai' OR a.`NamaPegawai3`='$namapegawai')";
								// echo $strs2;
								// die();
								$count = mysqli_fetch_assoc(mysqli_query($koneksi,$strs));
								$count2 = mysqli_fetch_assoc(mysqli_query($koneksi,$strs2));
								$jml = $jml + ($count['jumlah'] + $count2['jumlah']);
								?>	
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo ($count['jumlah'] + $count2['jumlah']);?></td>
								<?php
								}
								?>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jml;?></td>
							</tr>
						<?php
						}
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;">#</td>
								<td style="text-align:right; border:1px solid #000; padding:3px;">Total</td>
							<?php
								$jmls = 0;
								for($d3= $mulai;$d3 <= $selesai; $d3++){	
								$tanggal = $thn."-".$bln."-".$d3;
								$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
								// $tbpasienrj = "tbpasienrj_".$bln;
								$strs2 = "SELECT COUNT(a.NoRegistrasi) as jumlah FROM `$tbpasienperpegawai` a JOIN `$tbpasienrj` b ON a.NoRegistrasi = b.NoRegistrasi	WHERE a.`TanggalRegistrasi` = '$tanggal' AND substring(a.NoRegistrasi,1,11)='$kodepuskesmas' AND b.StatusPulang = '4'";
								// echo $strs2;
								$countall = mysqli_fetch_assoc(mysqli_query($koneksi,$strs2));		
								$jmls = $jmls + $countall['jumlah'];
							?>	
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $countall['jumlah'];?></td>
							<?php
								}
							?>	
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jmls;?></td>
							</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>	