<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>DATA ENTRY SBBK</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_kinerjapegawai"/>
						<div class="col-sm-2" >
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
						<div class="col-sm-1">
							<SELECT name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</SELECT>
						</div>
						<div class="col-sm-9">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_kinerjapegawai" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
							<a href="lap_farmasi_kinerjapegawai_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-sm btn-info">Excel</a>
						</div>
					</form>
				</div>
			</div>	
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$tahunini = date('Y');
	if($bulan != null AND $tahun != null){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN HASIL ENTRY SBBK</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span><br>
		<br/>
	</div>

	<div class="row font10">
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
								$selesai = date('t',strtotime("01-".$bln."-".$thn));
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
						$str = "SELECT * FROM `tbgfkpengeluaran` WHERE YEAR(TanggalPengeluaran)='$tahun' AND MONTH(TanggalPengeluaran)='$bulan' GROUP BY NamaPegawaiSimpan order by NamaPegawaiSimpan ASC";
						$query = mysqli_query($koneksi,$str);						
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$namapegawai = $data['NamaPegawaiSimpan'];							
							
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namapegawai;?></td>	
								<?php
								$jml = 0;	
								for($d2= $mulai;$d2 <= $selesai; $d2++){	
									$tanggal = $thn."-".$bln."-".$d2;
									$strs = "SELECT COUNT(IdDistribusi) as jumlah FROM `tbgfkpengeluaran` WHERE `TanggalPengeluaran`='$tanggal' AND `NamaPegawaiSimpan`='$namapegawai'";
									$count = mysqli_fetch_assoc(mysqli_query($koneksi,$strs));
									$jml = $jml + $count['jumlah'];
								?>	
									<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $count['jumlah'];?></td>
								<?php } ?>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jml;?></td>
							</tr>
						<?php
						}
						?>
							<tr style="border:1px solid #000; font-weight: bold;">
								<td style="text-align:right; border:1px solid #000; padding:3px;">#</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;">Total</td>
							<?php
								$jmls = 0;
								for($d3= $mulai;$d3 <= $selesai; $d3++){	
								$tanggal = $thn."-".$bln."-".$d3;
								$strs2 = "select COUNT(IdDistribusi) as jumlah from `tbgfkpengeluaran` where `TanggalPengeluaran` = '$tanggal'";
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
	</div><br/>
	<?php
	}
	?>
	<div class="alert alert-block alert-success fade in noprint">
		<p>Jumlah dihitung berdasarkan hasil entry SBBK</p>	
	</div>
</div>	

