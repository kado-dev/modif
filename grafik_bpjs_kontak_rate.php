<?php
	include "config/helper_bpjs.php";
	include "config/helper_pasienrj.php";
	$kodeppk = $_SESSION['kodeppk'];
	$bulan = date('m');
	$tahun = date('Y');
?>

<style>
.tr, th{
	text-align:center;
}
</style>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
		<h3 class="judul"><b>KONTAK RATE PESERTA BPJS</h3>
		<div class="formbg" style="padding: 50px 50px 50px 50px;">
			<div class="widget-box transparent">
				<div class="widget-body">
					<div id="container" style="min-width: 200px; height: 350px; margin: 0 auto"></div><br/>
					<div id="container_tahun" style="min-width: 200px; height: 350px; margin: 0 auto"></div>
				</div>
			</div>
		</div>
	</div>

	<!--grafik 3D-->
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/highcharts-3d.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<!--end grafik 3D-->
	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/plugins/morris/raphael.min.js"></script>
	<script src="assets/js/plugins/morris/morris.min.js"></script>
	<script>

	var chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container',
			type: 'column',
			options3d: {
				enabled: true,
				alpha: 15,
				beta: 15,
				depth: 50,
				viewDistance: 25
			}
		},
		title: {
			text: ''
		},
		subtitle: {
			text: 'JUMLAH PESERTA BPJS BULAN INI'
		},
		xAxis: {
			categories: ['Jenis Kunjungan']
		 },
		yAxis: {
			title: {
			   text: 'Jumlah Kunjungan'
			}
		 },
		plotOptions: {
			column: {
				depth: 25
			}
		},
		series: [
			<?php      
			$jmlpbi = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE MONTH(TanggalRegistrasi) = '$bulan' AND YEAR(TanggalRegistrasi) = '$tahun' AND substring(NoRegistrasi,1,11) = '$kodepuskesmas' AND Asuransi = 'BPJS PBI' AND `StatusPelayanan` = 'Sudah' AND `kdprovider` = '$kodeppk' GROUP BY NoCM"));
			$jmlnonbpi = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE MONTH(TanggalRegistrasi) = '$bulan' AND YEAR(TanggalRegistrasi) = '$tahun' AND substring(NoRegistrasi,1,11) = '$kodepuskesmas' AND Asuransi = 'BPJS NON PBI' AND `StatusPelayanan` = 'Sudah' AND `kdprovider` = '$kodeppk' GROUP BY NoCM"));

			?>
			  {
				  name: 'BPJS PBI',
				  data: [<?php echo $jmlpbi;?>]
			  },
			  {
				  name: 'BPJS NON PBI',
				  data: [<?php echo $jmlnonbpi;?>]
			  }
		]
	});

	var chart = new Highcharts.Chart({
		chart: {
			renderTo: 'container_tahun',
			type: 'column',
			options3d: {
				enabled: true,
				alpha: 10,
				beta: 10,
				depth: 70,
				viewDistance: 15
			}
		},
		title: {
			text: ''
		},
		subtitle: {
			text: 'JUMLAH KONTAK RATE PESERTA BPJS (PER-BULAN)'
		},
		xAxis: {
			categories: ['Bulan']
		 },
		yAxis: {
			title: {
				text: 'Jumlah Asset'
			}
		 },
		plotOptions: {
			column: {
				depth: 25
			}
		},
		series: [
			<?php   
			$array_bln = array(
				"Jan"=>"01",
				"Feb"=>"02",
				"Mar"=>"03",
				"Apr"=>"04",
				"Mei"=>"05",
				"Jun"=>"06",
				"Jul"=>"07",
				"Ags"=>"08",
				"Sep"=>"09",
				"Okt"=>"10",
				"Nov"=>"11",
				"Des"=>"12"
				);
			foreach($array_bln as $key => $val){
			if($val == $bulan){
				$val = $kodepuskesmas;
			}else{
				$val = $val;	
			}			
			// $tbpasienrj = 'tbpasienrj_'.$val;
			$jumlah_penjumlahan = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND (Asuransi like '%BPJS%') AND `StatusPelayanan` = 'Sudah' AND `kdprovider` = '$kodeppk' GROUP BY NoCM"));
						
			?>
			  {
				  name: '<?php echo $key;?>',
				  data: [<?php echo $jumlah_penjumlahan;?>]
			  },
			<?php 
			} 
			?>
		]
	});
	</script>

	
		<div class="col-lg-12">
			<div class="table-responsive noprint" style="font-size:12px">
				<table class="table-judul-laporan noprint">
					<thead>
						<tr>
							<th width="5%">No.</th>
							<th width="35%">Bulan</th>
							<th width="15%">Perkiraan Jml Peserta</th>
							<th width="15%">Target Capaian (15%)</th>
							<th width="10%">Dilayani</th>
							<th width="10%">Persentase (%)</th>
							<th width="10%">Status</th>
						</tr>
					</thead>
					<tbody font="8">
						<?php
						//error_reporting(0);
						$array_bulan = array("01"=>"Januari","02"=>"Februari","03"=>"Maret","04"=>"April","05"=>"Mei","06"=>"Juni","07"=>"Juli","08"=>"Agustus","09"=>"September","10"=>"Oktober","11"=>"November","12"=>"Desember");
						foreach($array_bulan as $key => $val){
							$no = $no + 1;
							// if($key == $bulan){
								// $key = $kodepuskesmas;
							// }else{
								$key = $key;	
							// }	
							$dilayani = mysqli_num_rows(mysqli_query($koneksi, "SELECT `NoRegistrasi` FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$key' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND (Asuransi like '%BPJS%') AND `StatusPelayanan` = 'Sudah' AND `kdprovider` = '$kodeppk' GROUP BY NoCM"));
							
							
							// hitung kontak rate
							if ($val=="Januari"){
								$jmlpeserta = "JumlahPeserta_01";
							}elseif ($val=="Februari"){
								$jmlpeserta = "JumlahPeserta_02";
							}elseif ($val=="Maret"){
								$jmlpeserta = "JumlahPeserta_03";
							}elseif ($val=="April"){
								$jmlpeserta = "JumlahPeserta_04";
							}elseif ($val=="Mei"){
								$jmlpeserta = "JumlahPeserta_05";
							}elseif ($val=="Juni"){
								$jmlpeserta = "JumlahPeserta_06";
							}elseif ($val=="Juli"){
								$jmlpeserta = "JumlahPeserta_07";
							}elseif ($val=="Agustus"){
								$jmlpeserta = "JumlahPeserta_08";
							}elseif ($val=="September"){
								$jmlpeserta = "JumlahPeserta_09";
							}elseif ($val=="Oktober"){
								$jmlpeserta = "JumlahPeserta_10";
							}elseif ($val=="November"){
								$jmlpeserta = "JumlahPeserta_11";
							}elseif ($val=="Desember"){
								$jmlpeserta = "JumlahPeserta_12";							
							}
							
							$dt_kr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT $jmlpeserta AS Jml FROM `tbpuskesmasdetail` WHERE `KodePuskesmas`='$kodepuskesmas'"));
							$jml_peserta = $dt_kr['JumlahPeserta'];
							
							// hitung kontak rate
							if ($val=="Januari"){
								$jmlpeserta_nilai = $dt_kr['Jml'];
							}elseif ($val=="Februari"){
								$jmlpeserta_nilai = $dt_kr['Jml'];
							}elseif ($val=="Maret"){
								$jmlpeserta_nilai = $dt_kr['Jml'];
							}elseif ($val=="April"){
								$jmlpeserta_nilai = $dt_kr['Jml'];
							}elseif ($val=="Mei"){
								$jmlpeserta_nilai = $dt_kr['Jml'];
							}elseif ($val=="Juni"){
								$jmlpeserta_nilai = $dt_kr['Jml'];
							}elseif ($val=="Juli"){
								$jmlpeserta_nilai = $dt_kr['Jml'];
							}elseif ($val=="Agustus"){
								$jmlpeserta_nilai = $dt_kr['Jml'];
							}elseif ($val=="September"){
								$jmlpeserta_nilai = $dt_kr['Jml'];
							}elseif ($val=="Oktober"){
								$jmlpeserta_nilai = $dt_kr['Jml'];
							}elseif ($val=="November"){
								$jmlpeserta_nilai = $dt_kr['Jml'];
							}elseif ($val=="Desember"){
								$jmlpeserta_nilai = $dt_kr['Jml'];								
							}
							
							$target = $jmlpeserta_nilai / 100 * 15;
							if($jmlpeserta_nilai > 0 and $dilayani > 0){
								$persentase = ($dilayani * 100) / $jmlpeserta_nilai;
							}else{
								$persentase = 0;
							}
							if($persentase <= 15){
								$status = 'Kurang';
							}else{
								$status = 'Terpenuhi';
							}
						?>
							<tr>
								<td style="text-align:center;"><?php echo $no;?></td>
								<td style="text-align:left;"><?php echo $val;?></td>
								<td style="text-align:right;"><?php echo rupiah($jmlpeserta_nilai);?></td>
								<td style="text-align:right;"><?php echo rupiah($target);?></td>
								<td style="text-align:right;"><?php echo rupiah($dilayani);?></td>
								<td style="text-align:right;"><?php echo substr($persentase,0,4)." %";?></td>
								<td style="text-align:center;"><?php echo $status;?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
</div>
