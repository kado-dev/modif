<?php
	include "otoritas.php";
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul">STOK AWAL <small>Loket Obat</small></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_apotik_stok_awal"/>
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
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_apotik_stok_awal" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
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

	<div class="row noprint">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead class="font10">
						<tr style="border:1px solid #000;">
							<th width="5%">No.</th>
							<th width="35%">Nama Barang</th>
							<th width="8%">Satuan</th>
							<th width="10%">No.Batch</th>
							<th width="8%">Expire</th>
							<th width="10%">Sumber</th>
							<th width="8%">Tahun</th>
							<th width="10%">Jumlah</th>
						</tr>
					</thead>
					
					<tbody class="font10">
						<?php
						$str = "SELECT * FROM `tbstokbulananapotik`	WHERE `Bulan`= '$bulan' AND `Tahun`='$tahun' AND `KodePuskesmas`='$kodepuskesmas'";
						$query = mysqli_query($koneksi,$str);
						// echo $str;
						
						while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						?>
							<tr style="border:1px solid #000;">
								<td><?php echo $no;?></td>
								<td><?php echo $data['NamaBarang'];?></td>	
								<td><?php echo $data['Satuan'];?></td>
								<td><?php echo $data['NoBatch'];?></td>
								<td><?php echo $data['Expire'];?></td>
								<td><?php echo $data['SumberAnggaran'];?></td>
								<td><?php echo $data['TahunAnggaran'];?></td>
								<td><?php echo $data['Stok'];?></td>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>	
		</div>	
	</div>
	<?php
	}
	?>
</div>