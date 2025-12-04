<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>PERMOHONAN USULAN VAKSIN</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_vaksin_permohonan"/>
						<div class="col-sm-2">
							<div class="input-group">
								<span class="input-group-addon tesdate">
									<span class="fa fa-calendar"></span>
								</span>
								<input type="text" name="tanggal_awal" class="form-control datepicker" value="<?php echo $_GET['tanggal_awal'];?>" placeholder="Tanggal Awal" required>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="input-group">
								<span class="input-group-addon tesdate">
									<span class="fa fa-calendar"></span>
								</span>
								<input type="text" name="tanggal_akhir" class="form-control datepicker" value="<?php echo $_GET['tanggal_akhir'];?>" placeholder="Tanggal Akhir" required>
							</div>
						</div>
						<div class="col-sm-3">
							<select name="namavaksin" class="form-control">
								<option value="SEMUA" <?php if($_GET['dosis'] == 'SEMUA'){echo "SELECTED";}?>>SEMUA</option>
								<option value="ASTRAZENECA" <?php if($_GET['namavaksin'] == 'ASTRAZENECA'){echo "SELECTED";}?>>ASTRAZENECA</option>
								<option value="MODERNA" <?php if($_GET['namavaksin'] == 'MODERNA'){echo "SELECTED";}?>>MODERNA</option>
								<option value="PFIZER" <?php if($_GET['namavaksin'] == 'PFIZER'){echo "SELECTED";}?>>PFIZER</option>
								<option value="SINOVAC" <?php if($_GET['namavaksin'] == 'SINOVAC'){echo "SELECTED";}?>>SINOVAC</option>
								<option value="SHINOFARM" <?php if($_GET['namavaksin'] == 'SHINOFARM'){echo "SELECTED";}?>>SHINOFARM</option>
								<option value="ALAT SUNTIK SEKALI PAKAI ADS 0.5 ML" <?php if($_GET['namavaksin'] == 'ALAT SUNTIK SEKALI PAKAI ADS 0.5 ML'){echo "SELECTED";}?>>ALAT SUNTIK SEKALI PAKAI ADS 0.5 ML</option>
								<option value="ALKOHOL SWAB" <?php if($_GET['namavaksin'] == 'ALKOHOL SWAB'){echo "SELECTED";}?>>ALKOHOL SWAB</option>
								<option value="SAFETY BOX" <?php if($_GET['namavaksin'] == 'SAFETY BOX'){echo "SELECTED";}?>>SAFETY BOX</option>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="dosis" class="form-control">
								<option value="SEMUA" <?php if($_GET['dosis'] == 'SEMUA'){echo "SELECTED";}?>>SEMUA</option>
								<option value="1" <?php if($_GET['dosis'] == '1'){echo "SELECTED";}?>>PERTAMA</option>
								<option value="2" <?php if($_GET['dosis'] == '2'){echo "SELECTED";}?>>KEDUA</option>
							</select>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-warning btn-white"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_vaksin_permohonan" class="btn btn-success btn-white"><span class="fa fa-refresh"></span></a>
							<a href="lap_farmasi_vaksin_permohonan_excel.php?tanggal_awal=<?php echo $_GET['tanggal_awal'];?>&tanggal_akhir=<?php echo $_GET['tanggal_akhir'];?>&namavaksin=<?php echo $_GET['namavaksin'];?>&dosis=<?php echo $_GET['dosis'];?>" class="btn btn-info btn-white"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-success btn-white"><span class="fa fa-print"></a>
						</div>
					</form>	
				</div>	
			</div>
		</div>
	</div>

	<?php
	$tanggal_awal = date('Y-m-d', strtotime($_GET['tanggal_awal']));
	$tanggal_akhir = date('Y-m-d', strtotime($_GET['tanggal_akhir']));
	$namavaksin = $_GET['namavaksin'];	
	$dosis = $_GET['dosis'];	

	if($tanggal_awal != null AND $tanggal_akhir != null){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>PERMOHONAN USULAN VAKSIN</b></span><br>
		<span class="font11" style="margin:1px;"><?php echo "Periode Laporan : ".date('d-m-Y', strtotime($tanggal_awal))." s/d ".date('d-m-Y', strtotime($tanggal_akhir));?></span>
	</div><br/>
	<div>
		<table class="table-judul-laporan-min" width="100%">
			<thead>
				<tr style="border:1px solid #000;">
					<th width="3%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
					<th width="12%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">TGL.KEGIATAN</th>
					<th width="20%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">UNIT PENERIMA</th>
					<th width="40%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">NAMA BARANG</th>
					<th width="10%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">DOSIS</th>
					<th width="10%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">JUMLAH</th>
					<th width="5%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">AKSI</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($dosis == 'SEMUA'){
					$dosis = " ";
				}else{
					$dosis = " AND `Dosis`='$dosis'";
				}

				if($namavaksin == 'SEMUA'){
					$namavaksin = " ";
				}else{
					$namavaksin = " AND `NamaVaksin`='$namavaksin'";
				}				
				
				// tahap1, tbgfk_vaksin_usulan
				$str = "SELECT * FROM `tbgfk_vaksin_usulan` 
				WHERE TanggalKegiatan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'".$namavaksin.$dosis;								
				$str2 = $str." ORDER BY `IdUsulan`";
				// echo $str2;
				
				$no = 0;
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
				?>
				
				<tr style="border:1px solid #000;">
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TanggalKegiatan'];?></td>
					<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['UnitPenerima'];?></td>
					<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaVaksin'];?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Dosis'];?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $data['JumlahUsulan'];?></td>
					<td style="text-align:right; border:1px solid #000; padding:3px;">
						<a onClick="return confirm('Data ingin di Hapus...?')" href="?page=lap_farmasi_vaksin_permohonan_hapus&id=<?php echo $data['IdUsulan'];?>&tgl1=<?php echo $tanggal_awal;?>&tgl2=<?php echo $tanggal_akhir;?>&namabrg=<?php echo $namavaksin;?>&dosis=<?php echo $_GET['dosis'];?>" class="btn btn-xs btn-danger">Hapus</a>
					</td>
				</tr>
				<?php
				} 
				?>
			</tbody>
		</table>
	</div>
	<?php
	}
	?>
</div>	