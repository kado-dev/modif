<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>PEMULKES</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_P2M_penyakit_terbanyak_pemulkes"/>
						<div class="col-sm-2">
							<SELECT name="opsiform" class="form-control opsiform">
								<option value="bulan" <?php if($_GET['opsi'] == 'bulan'){echo "SELECTED";}?>>Bulan</option>
								<option value="tanggal" <?php if($_GET['opsi'] == 'tanggal'){echo "SELECTED";}?>>Tanggal</option>
							</SELECT>	
						</div>
						<div class="col-sm-3 tanggalformcari" style="display:none">
							<div class="tampilformdate">
								<input type="text" name="keydate1" class="form-control datepicker2" style="width:100px;float:left;margin-right:10px;" placeholder = "Tanggal Awal"> <input type="text" name="keydate2" class="form-control datepicker2" style="width:100px;float:left;margin-right:10px;" placeholder = "Tanggal Akhir">
							</div>
						</div>	
						<div class="col-sm-2 bulanformcari">
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
						<div class="col-sm-1 bulanformcari" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-1">
							<input type="number" class="form-control" style="width:60px" name="limit" value="10">
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_penyakit_terbanyak_pemulkes" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</form>	
				</div>
			</div>	
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$limit = $_GET['limit'];
	if($bulan != null AND $tahun != null){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:1px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:1px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:1px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font12" style="margin:15px 5px 5px 5px;"><b>PROGRAM PENGOBATAN DAN PEMULIHAN KESEHATAN</b></span><br>
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

	<div class="row font10">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<tr>
						<?php
						$qrydtasuransi = mysqli_query($koneksi,"SELECT `Asuransi` FROM `tbasuransi` ORDER BY Asuransi");
						while($dtasuransi = mysqli_fetch_assoc($qrydtasuransi)){
						?>
						<td valign="top">
							<table class="table-judul-laporan" width="100%">
								<thead>
									<tr>
										<th colspan="7"><?php echo $dtasuransi['Asuransi'];?></th>
									</tr>
									<tr>
										<th rowspan="3" width="3%">NO.</th>
										<th rowspan="3" width="5%">KODE</th>
										<th rowspan="3" width="15%">PENYAKIT</th>
										<th colspan="4" width="10%">JUMLAH KUNJUNGAN KASUS</th>
									</tr>
									<tr>
										<th colspan="2">LAMA</th>
										<th colspan="2">BARU</th>
									</tr>
									<tr>
										<th>L</th>
										<th>P</th>
										<th>L</th>
										<th>P</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 0;
									$asuransis = $dtasuransi['Asuransi'];
									$str2 = "SELECT a.KodeDiagnosa, b.Diagnosa, a.Kasus as Kasus, COUNT(a.KodeDiagnosa) AS Jumlah 
											FROM `$tbdiagnosapasien` a 
											LEFT JOIN `tbdiagnosabpjs` b ON a.KodeDiagnosa = b.KodeDiagnosa 
											LEFT JOIN `$tbpasienrj` c on a.NoRegistrasi = c.NoRegistrasi
											WHERE MONTH(a.TanggalDiagnosa) = '$bulan' AND YEAR(a.TanggalDiagnosa) = '$tahun' 
											AND c.Asuransi = '".$asuransis."'
											GROUP BY KodeDiagnosa
											ORDER BY Jumlah Desc Limit ".$limit;
									// echo $str2;		
									$query2 = mysqli_query($koneksi,$str2);
									while($data2 = mysqli_fetch_assoc($query2)){
										$no = $no + 1;
										$kodediagnosa2 = $data2['KodeDiagnosa'];
										$diagnosa2 = $data2['Diagnosa'];
										$jml_laki_lama_bpjsnonpbi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jumlah 
												FROM `$tbdiagnosapasien` a 
												LEFT JOIN `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi
												WHERE YEAR(a.TanggalDiagnosa)='$tahun' and MONTH(a.TanggalDiagnosa)='$bulan' AND a.KodeDiagnosa = '$kodediagnosa2' and a.Kasus = 'LAMA' and b.JenisKelamin = 'L' and b.Asuransi = '".$asuransis."'"));
										$jml_laki_baru_bpjsnonpbi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jumlah 
												FROM `$tbdiagnosapasien` a 
												LEFT JOIN `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi
												WHERE YEAR(a.TanggalDiagnosa)='$tahun' and MONTH(a.TanggalDiagnosa)='$bulan' AND a.KodeDiagnosa = '$kodediagnosa2' and a.Kasus = 'BARU' and b.JenisKelamin = 'L' and b.Asuransi = '".$asuransis."'")); 							
										$jml_perempuan_lama_bpjsnonpbi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jumlah 
												FROM `$tbdiagnosapasien` a 
												LEFT JOIN `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi
												WHERE YEAR(a.TanggalDiagnosa)='$tahun' and MONTH(a.TanggalDiagnosa)='$bulan' AND a.KodeDiagnosa = '$kodediagnosa2' and a.Kasus = 'LAMA' and b.JenisKelamin = 'P' and b.Asuransi = '".$asuransis."'"));
										$jml_perempuan_baru_bpjsnonpbi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(a.NoRegistrasi)AS Jumlah 
												FROM `$tbdiagnosapasien` a 
												LEFT JOIN `$tbpasienrj` b on a.NoRegistrasi = b.NoRegistrasi
												WHERE YEAR(a.TanggalDiagnosa)='$tahun' and MONTH(a.TanggalDiagnosa)='$bulan' AND a.KodeDiagnosa = '$kodediagnosa2' and a.Kasus = 'BARU' and b.JenisKelamin = 'P' and b.Asuransi = '".$asuransis."'"));
									?>
										<tr>
											<td align="center"><?php echo $no;?></td>
											<td align="center"><?php echo $kodediagnosa2;?></td>
											<td align="left"><?php echo $diagnosa2;?></td>
											<td align="right"><?php echo $jml_laki_lama_bpjsnonpbi['Jumlah'];?></td>
											<td align="right"><?php echo $jml_laki_baru_bpjsnonpbi['Jumlah'];?></td>
											<td align="right"><?php echo $jml_perempuan_lama_bpjsnonpbi['Jumlah'];?></td>
											<td align="right"><?php echo $jml_perempuan_baru_bpjsnonpbi['Jumlah'];?></td>
										</tr>
									<?php
									}
									?>
								</tbody>
							</table>
						</td>
						<?php
						}
						?>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>	