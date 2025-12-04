<?php
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>BANK DATA PASIEN</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="rm_bankdata"/>
						<div class="col-xl-2">
							<select name="tahun" class="form-control">
								<option value="semua">Semua</option>
								<?php
									for($tahun = 2013 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-3">
							<select name="orderby" class="form-control">
								<option value="NoIndex" <?php if($_GET['orderby'] == 'NoIndex'){echo "SELECTED";}?>>Order by NoIndex</option>
								<option value="NamaPasien" <?php if($_GET['orderby'] == 'NamaPasien'){echo "SELECTED";}?>>Order by Nama Pasien</option>
							</select>
						</div>
						<div class="col-xl-3">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Cari Nama Pasien / No.Index">
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=rm_bankdata" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="rm_bankdata_excel.php?orderby=<?php echo $_GET['orderby'];?>&tahun=<?php echo $_GET['tahun'];?>&key=<?php echo $_GET['key'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>			
						</div>
					</div>
				</form>		
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

	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<table class="table-judul">
				<thead>
					<tr style="border:1px solid #000;">
						<th width="3%">NO.</th>
						<th width="5%">TGL DAFTAR</th>
						<th width="10%">NIK & No.BPJS</th>
						<th width="15%">NAMA PASIEN</th>
						<th width="25%">ALAMAT</th>
						<th width="5%">#</th>
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

					if($tahun == "semua"){
						$thn = " ";	
					}else{
						$thn = " AND YEAR(TanggalDaftar)= '$tahun'";
					}
										
					$str = "SELECT * FROM `$tbpasien` 
					WHERE (`NamaPasien` like '%$key%' OR `NoIndex` like '%$key%' OR `NoAsuransi` like '%$key%')".$thn;
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
						$idpasien = $data['IdPasien'];
						$noindex = $data['NoIndex'];
						$nocm = $data['NoCM'];
						$noasuransi = $data['NoAsuransi'];
					
						// tbkk
						$strkk = "SELECT `NamaKK`,`Alamat`,`RT`,`RW`,`Kelurahan`,`Kota`,`Telepon` FROM `$tbkk` WHERE `NoIndex`= '$noindex'";
						$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, $strkk));

						// ec_subdistricts
						$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$datakk[Kelurahan]'"));
						
						// ec_cities
						$dt_citi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `city_name` FROM `ec_cities` WHERE `city_id`='$datakk[Kota]'"));
						
						$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
						strtoupper($dt_subdis['subdis_name']).", ".$dt_citi['city_name'];
						
					?>
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="center"><?php echo date('d/m/Y', strtotime($data['TanggalDaftar']));?></td>
							<td align="center"><?php echo $data['Nik']."<br/>".$noasuransi;?></td>
							<td align="left" class="nama">
								<?php echo "<span style='font-weight: bold; font-style: italic; font-size: 16px;'>".$data['NamaPasien']."</span>";?>
								<span class="badge badge-success" style='font-style: italic; padding: 8px;'><?php echo substr($data['NoIndex'],-10);?></span><br/>
								<?php echo "KK. ".$datakk['NamaKK'];?>
							</td>
							<td align="left"><?php echo strtoupper($alamat);?></td>
							<td align="center">
								<a href="?page=rm_bankdata_detail&id=<?php echo $idpasien;?>&th=<?php echo $tahun;?>&od=<?php echo $orderby;?>&key=<?php echo $data['NamaPasien'];?>" class="btn btn-round btn-info">Pindah KK</a>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
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
					echo "<li><a href='?page=rm_bankdata&tahun=$tahun&&orderby=$orderby&h=$i'>$i</a></li>";
				}
			}
		}
	?>	
</ul>
	<?php
	}
	?>
</div>	
	