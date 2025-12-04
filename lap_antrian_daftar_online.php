<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DAFTAR ONLINE (BULANAN)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_antrian_daftar_online"/>
						<div class="col-xl-2 bulanformcari" style ="width:125px">
							<select name="tahun" class="form-control tahuncls">
								<?php
								$get_tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
								for($tahun = 2020 ; $tahun <= date('Y'); $tahun++){
								?>
								<option value="<?php echo $tahun;?>" <?php if($get_tahun == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-10">
							<button type="submit" class="btn btn-round btn-warning btncls"><span class="fa fa-search"></span></button>
							<a href="?page=lap_antrian_daftar_online" class="btn btn-round btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>

	<?php
	$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
	$tahun = isset($_GET['tahun']) ? mysqli_real_escape_string($koneksi, $_GET['tahun']) : '';
	if($tahun != ''){
	?>


	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN DAFTAR ONLINE (BULANAN)</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: Tahun <?php echo $tahun;?></span>
		<br/>
	</div>

	<div class="atastabel">
		<div style="float:left; width:35%; margin-bottom:10px;">	
			<table>
				<tr>
					<td style="padding:2px 4px;">Kelurahan/Desa</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo strtoupper($kelurahan);?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Kecamatan</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo strtoupper($kecamatan);?></td>
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
							<th width="3%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">NO.</th>
							<th width="10%" rowspan="2" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">BULAN</th>
							<?php
							for($d = 1; $d <= 31; $d++){	
							?>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $d;?></th>
							<?php } ?>
							<th width="8%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px solid #000; padding:3px;">TOTAL</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// OPTIMASI: Satu query untuk semua data tahun ini
						$tbantrian = "tbpasienonline_".$kodepuskesmas;
						$str_all = "SELECT MONTH(WaktuDaftar) as bln, DAY(WaktuDaftar) as tgl, COUNT(IdPasienOnline) as jumlah 
						FROM `$tbantrian` 
						WHERE YEAR(WaktuDaftar) = '$tahun'
						GROUP BY MONTH(WaktuDaftar), DAY(WaktuDaftar)";
						
						$query_all = mysqli_query($koneksi, $str_all);
						
						// Simpan ke array [bulan][tanggal] = jumlah
						$online_data = [];
						$total_per_hari = array_fill(1, 31, 0); // Total per tanggal (kolom)
						
						if($query_all){
							while($row = mysqli_fetch_assoc($query_all)){
								$bln = intval($row['bln']);
								$tgl = intval($row['tgl']);
								$jml = intval($row['jumlah']);
								
								if(!isset($online_data[$bln])){
									$online_data[$bln] = [];
								}
								$online_data[$bln][$tgl] = $jml;
								
								// Akumulasi total per hari
								$total_per_hari[$tgl] += $jml;
							}
						}
						
						$arraybulan = array(
							1 => "Januari", 2 => "Februari", 3 => "Maret", 4 => "April",
							5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Agustus",
							9 => "September", 10 => "Oktober", 11 => "November", 12 => "Desember"
						);
						
						$no = 0;
						$grand_total = 0;
						
						foreach($arraybulan as $kodebulan => $namabulan){
							$no++;
							$jml_bulan = 0;
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namabulan;?></td>
								<?php
								for($d = 1; $d <= 31; $d++){
									// Ambil dari array, default 0 jika tidak ada
									$count = isset($online_data[$kodebulan][$d]) ? $online_data[$kodebulan][$d] : 0;
									$jml_bulan += $count;
								?>	
									<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $count > 0 ? $count : '';?></td>
								<?php } ?>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jml_bulan;?></td>
							</tr>	
						<?php
							$grand_total += $jml_bulan;
						}						
						?>
							<tr style="border:1px solid #000; font-weight: bold;">
								<td style="text-align:right; border:1px solid #000; padding:3px;">#</td>
								<td style="text-align:center; border:1px solid #000; padding:3px;">TOTAL</td>
								<?php
								for($d = 1; $d <= 31; $d++){
									$jmls = $total_per_hari[$d];
								?>	
									<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $jmls > 0 ? $jmls : '';?></td>
								<?php } ?>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo number_format($grand_total, 0, ',', '.');?></td>
							</tr>	
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br>
	
	<?php
	}
	?>
</div>	

<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
	$('.btncls').click(function(){
		$( ".hasilpencarian" ).html( "<p style='text-align:center'><img src='assets/js/loader.gif' width='40px'></p>" );
		var tahun = $(this).parent().parent().find(".tahuncls").val()

		$.post( "lap_antrian_daftar_online.php?jqry=yes", { tahun: tahun })
		  .done(function( data ) {
			 $( ".hasilpencarian" ).html( data );
		});
	});
</script>
