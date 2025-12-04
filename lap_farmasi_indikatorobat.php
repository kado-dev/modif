<!--catatan
Catetan  : sengaja dibuatkan tbgudangpkmindikator, agar nyimpan data perbulan tidak usah realtime
-->

<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_report.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
?>

<div class="tableborderdiv">
	<div class="row search-page noprint" id="search-page-1">
		<div class="col-xs-12">
			<h3 class="judul">20 INDIKATOR OBAT</h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_indikatorobat"/>
						<div class="col-sm-2">
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
						<div class="col-sm-1" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_indikatorobat" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<!--<a href="javascript:print()" class="btn btn-sm btn-success"><span class="fa fa-print noprint"></span></a>-->
							<a href="lap_farmasi_indikatorobat_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	
	if(isset($bulan) and isset($tahun)){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN 20 INDIKATOR OBAT</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
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
	
	<div>	
		<table class="table-judul-laporan-min" width="100%">
			<thead>
				<tr>
					<th width="2%" rowspan="2">NO.</th>
					<th width="20%" rowspan="2">NAMA BARANG</th>
					<th width="5%" rowspan="2">SEDIA</th>
				</tr>
			</thead>
			<tbody>
				<?php
				// insert ke tbgudangpkmindikator, cek bulan dan tahun
				$cekindikator = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `tbgudangpkmindikator` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Bulan`='$bulan' AND `Tahun`='$tahun'"));
				if($cekindikator == 0){
					$str = "SELECT * FROM `ref_obatindikator`";				
					$query = mysqli_query($koneksi, $str);
					while($data = mysqli_fetch_assoc($query)){
						$idindikator = $data['id_indikator'];
						$kodebarang = $data['KodeBarang'];
						$namaindikator = $data['nama_indikator'];
						
						// cek dari distribusi dinas aja, karena klo dari gudang puskesmas petugas belum (approve data)
						$strgfkdistribusi = "SELECT * FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur
						WHERE a.`Kodebarang`='$kodebarang' AND b.`KodePenerima`='$kodepuskesmas'";
						$dtgfkdistribusi = mysqli_num_rows(mysqli_query($koneksi, $strgfkdistribusi));
						if($dtgfkdistribusi > 0){
							$sedia = "1";
						}else{
							$sedia = "0";
						}			
						
						$strindikator = "INSERT INTO `tbgudangpkmindikator`(`Bulan`,`Tahun`,`KodePuskesmas`,`IdIndikator`,`KodeBarang`,`NamaBarang`,`Sedia`)
						VALUES ('$bulan','$tahun','$kodepuskesmas','$idindikator','$kodebarang','$namaindikator','$sedia')";
						mysqli_query($koneksi,$strindikator);
					}
				}
				
				$str = "SELECT * FROM `tbgudangpkmindikator` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Bulan`='$bulan' AND `Tahun`='$tahun'";
				$str2 = $str." ORDER BY `NamaBarang` ASC";
							
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$idindikator = $data['IdIndikator'];
					$kodebarang = $data['KodeBarang'];
					$namaindikator = $data['NamaBarang'];
					
					// cek gfkstok
					$strgfkdistribusi = "SELECT * FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur
					WHERE a.`Kodebarang`='$kodebarang' AND b.`KodePenerima`='$kodepuskesmas'";
					// echo $strgfkdistribusi;
					$dtgfkdistribusi = mysqli_num_rows(mysqli_query($koneksi, $strgfkdistribusi));
					if($dtgfkdistribusi > 0){
						$sedia = "1";
					}else{
						$sedia = "0";
					}	
				?>
					<tr style="border:1px solid #000;">
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($namaindikator);?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $sedia;?></td>
					</tr>
				<?php
					}
				?>
			</tbody>
		</table>
	</div><br/>
	<div class="bawahtabel font10">
		<table width="100%">
			<tr>
				<td width="10%"></td>
				<td style="text-align:center;">
				Diterima Oleh
				<br>
				<br>
				<br>
				<br>
				(______________________)
				</td>
				
				
				<td width="10%"></td>
				<td style="text-align:center;">
				Diserahkan Oleh
				<br>
				<br>
				<br>
				<br>
				(______________________)
				</td>
			</tr>
		</table>
	</div>
	<?php
	}
	?>
</div>	