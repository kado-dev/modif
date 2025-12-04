<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<style>
.tr, th{
	text-align:center;
}
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
	display: none;
	
}
.printheader h4{
	font-size:18px;
	font-family: "Trebuchet MS";
}
.printheader p{
	font-size:18px;
	font-family: "Trebuchet MS";
}
.printbody{
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	display:none;
	margin-top:10px;
}
.bawahtabel{
	margin-top:10px;
	margin-bottom:10px;
	margin-left:-50px;
	margin-right:0px;
	display:none;
}
.font10{
	font-size:10px;
	font-family: "Tahoma";
}
.font11{
	font-size:11px;
	font-family: "Tahoma";
}
.font14{
	font-size:14px;
	font-family: "Tahoma";
}


@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
	}
	.printheader{
		display:block;
	}
	.printbody{
		display:block;
	}
	.atastabel{
		display:block;
	}
	.bawahtabel{
		display:block;
	}
}
</style>

<div class="tableborderdiv">
	<div class = "row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>LAPORAN CARA BAYAR</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_carabayar"/>
						<div class="col-xl-2" >
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
							<SELECT name="tahun" class="form-control">
								<?php
									for($tahun = 2022 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</SELECT>
						</div>
						<div class="col-sm-2">
							<select name="asalpasien" class="form-control asuransi">
								<option value='semua'>Semua</option>
								<?php
								$query = mysqli_query($koneksi,"SELECT * FROM `tbasalpasien` ORDER BY `AsalPasien` ASC");
									while($data = mysqli_fetch_assoc($query)){
										if($_GET['asalpasien'] == $data['Id']){
											echo "<option value='$data[Id]' SELECTED>$data[AsalPasien]</option>";
										}else{
											echo "<option value='$data[Id]'>$data[AsalPasien]</option>";
										}
									}
								?>
							</select>
						</div>
						<div class="col-sm-2">
							<SELECT name="statuspasien" class="form-control">
								<option value="semua">Semua</option>
								<option value="1" <?php if($_GET['statuspasien'] == '1'){echo "SELECTED";}?>>Kunjungan Sakit</option>
								<option value="2" <?php if($_GET['statuspasien'] == '2'){echo "SELECTED";}?>>Kunjungan Sehat</option>
							</SELECT>
						</div>
						<div class="col-xl-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_carabayar" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_loket_carabayar_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&asalpasien=<?php echo $_GET['asalpasien'];?>&statuspasien=<?php echo $_GET['statuspasien'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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
	$asalpasien = $_GET['asalpasien'];
	$statuspasien = $_GET['statuspasien'];
	if($bulan != null AND $tahun != null){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN CARA BAYAR PASIEN</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span><br>
		<span class="font11" style="margin:1px;">Asal Pasien: <?php echo $asalpasien;?></span>
	</div><br/>
	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead>
						<tr style="border:1px solid #000;">
							<th style="text-align:center;width:1%;vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
							<th style="text-align:center;width:5%;vertical-align:middle; border:1px solid #000; padding:3px;">CARA BAYAR</th>
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
							<th style="text-align:center;width:1%;vertical-align:middle; border:1px solid #000; padding:3px;">JUMLAH</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$str = "SELECT * FROM `tbasuransi` ORDER BY `Asuransi` ASC";
						$query = mysqli_query($koneksi,$str);
						
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$asuransi = $data['Asuransi'];

							if ($asalpasien == 'semua'){
								$asalpasien1 = "";
							}else{
								$asalpasien1 = " AND `AsalPasien`='$asalpasien'";
							}
							
							if ($statuspasien == 'semua'){
								$statuspasien1 = "";
							}else{
								$statuspasien1 = " AND `StatusPasien`='$statuspasien'";
							}							
									
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['Asuransi'];?></td>	
								<?php
								$jml = 0;	
								for($d2= $mulai;$d2 <= $selesai; $d2++){	
									$tanggal = $thn."-".$bln."-".$d2;
									$strs = "SELECT COUNT(NoRegistrasi) as Jml from `$tbpasienrj` where date(`TanggalRegistrasi`) = '$tanggal' AND `Asuransi` = '$asuransi'".$asalpasien1.$statuspasien1;
									$count = mysqli_fetch_assoc(mysqli_query($koneksi, $strs));

									// dari daftar online (status asuransi hanya BPJS tidak dibedankan PBI atau NON PBI)
									$strs_2 = "SELECT COUNT(NoRegistrasi) as Jml from `$tbpasienrj` where date(`TanggalRegistrasi`) = '$tanggal' AND `Asuransi` = 'BPJS'".$asalpasien1.$statuspasien1;
									$count_2 = mysqli_fetch_assoc(mysqli_query($koneksi, $strs_2));

									if($data['Asuransi'] == 'BPJS PBI'){
										$jml_hari = $count['Jml'] + $count_2['Jml'];
										$jml = $jml + $count['Jml'] + $count_2['Jml'];
									}else{
										$jml_hari = $count['Jml'];
										$jml = $jml + $count['Jml'];
									}

									
								?>	
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jml_hari;?></td>
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
								<td style="text-align:right; border:1px solid #000; padding:3px;">TOTAL</td>
							<?php
								$jmls = 0;
								for($d3= $mulai;$d3 <= $selesai; $d3++){	
								$tanggal = $thn."-".$bln."-".$d3;
								$strs2 = "SELECT COUNT(NoRegistrasi) as jumlah FROM `$tbpasienrj` where date(`TanggalRegistrasi`) = '$tanggal'".$asalpasien1.$statuspasien1;
								$countall = mysqli_fetch_assoc(mysqli_query($koneksi, $strs2));
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
	</div><br/>
	<?php
	}
	?>
</div>	