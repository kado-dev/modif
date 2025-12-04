<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
	<div class="col-xs-12">
		<h3 class="judul"><b>BANK DATA PASIEN</b></h3>
		<div class="formbg">
			<div class = "row">
				<form role="form">
					<input type="hidden" name="page" value="lap_loket_data_kk"/>
					<div class="col-sm-1">
						<select name="tahun" class="form-control">
							<?php
								for($tahun = 2013 ; $tahun <= date('Y'); $tahun++){
								?>
								<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
							<?php }?>
						</select>
					</div>
					<div class="col-sm-2">
						<select name="orderby" class="form-control">
							<option value="NoIndex" <?php if($_GET['orderby'] == 'NoIndex'){echo "SELECTED";}?>>Order by NoIndex</option>
							<option value="NamaPasien" <?php if($_GET['orderby'] == 'NamaPasien'){echo "SELECTED";}?>>Order by Nama Pasien</option>
						</select>
					</div>
					<div class="col-sm-3">
						<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Nama Pasien / No.Index">
					</div>
					<div class="col-sm-3">
						<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
						<a href="?page=lap_loket_data_kk" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
						<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
						<a href="lap_loket_data_kk_excel.php?orderby=<?php echo $_GET['orderby'];?>&tahun=<?php echo $_GET['tahun'];?>&key=<?php echo $_GET['key'];?>" class="btn btn-sm btn-success">Excel</a>
					</div>
				</form>	
			</div>
		</div>
	</div>
</div>
<?php
$tahun = $_GET['tahun'];
$orderby = $_GET['orderby'];
$key = $_GET['key'];
if(isset($tahun)){
?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>BANK DATA PASIEN</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo $tahun;?></span>
		<br/>
	</div>

	<div class="atastabel">
		<div style="float:left; width:35%; margin-bottom:10px;">	
			<table>
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
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr style="border:1px solid #000;">
							<th width="3%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
							<th width="7%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">TGL.DAFTAR</th>
							<th width="7%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">NO.INDEX</th>
							<th width="7%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">NO.RM</th>
							<th width="10%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">NIK</th>
							<th width="10%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">NO.BPJS</th>
							<th width="15%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">NAMA PASIEN</th>
							<th width="7%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">TGL.LAHIR</th>
							<th width="15%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">NAMA KK</th>
							<th width="25%" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">ALAMAT</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$jumlah_perpage = 50;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						if($key == ""){
							$key = " ";	
						}else{
							$key = " AND (`NamaPasien` like '%$key%' OR `NoIndex` like '%$key%' OR `NoAsuransi` like '%$key%')";
						}
						
						$str = "SELECT * FROM `tbpasien` 
						WHERE SUBSTRING(NoIndex,15,4)= '$tahun' AND SUBSTRING(NoIndex,3,11)='$kodepuskesmas'".$key;
						$str2 = $str." ORDER BY ".$orderby." DESC LIMIT $mulai,$jumlah_perpage";
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$noindex = $data['NoIndex'];
							$nocm = $data['NoCM'];
						
							// tbkk
							$strkk = "SELECT `TanggalDaftar`,`NamaKK`,`Alamat`,`RT`,`RW`,`Kelurahan`,`Kecamatan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
							$dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, $strkk));
							
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $dtkk['TanggalDaftar'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($data['NoIndex'],-10);?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo substr($data['NoRM'],-6);?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Nik'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['NoAsuransi'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NamaPasien'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['TanggalLahir'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $dtkk['NamaKK'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $dtkk['Alamat'].", RT.".$dtkk['RT']."/".$dtkk['RW'].", ".$dtkk['Kelurahan'].", ".$dtkk['Kelurahan'];?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>
	<hr class="noprint">
	<ul class="pagination noprint">
		<?php
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
						echo "<li><a href='?page=lap_loket_data_kk&tahun=$tahun&&orderby=$orderby&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>