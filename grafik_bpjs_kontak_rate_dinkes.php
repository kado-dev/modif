<?php
	include "config/helper_bpjs.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$kodeppk = $_SESSION['kodeppk'];
	// $tahun = date('Y');
	// $bulan = date('m');
	// $tbpasienrj = 'tbpasienrj_'.date('m');
?>

<style>
.tr, th{
	text-align:center;
}
</style>

<div class="col-lg-12 col-md-12">
	<div class="widget-box transparent">
		<div class="widget-header widget-header-small">
			<h4 class="widget-title blue smaller">
				<i class="ace-icon fa fa-rss orange"></i>
				Kontak Rate Peserta BPJS
			</h4>
		</div><br/>
		
		<!--kolom pencarian-->
		<div class="row noprint">
			<div class="col-xs-12 col-sm-12">
				<div class="search-area well well-sm">
					<div class = "row">
						<form role="form">
							<input type="hidden" name="page" value="grafik_bpjs_kontak_rate_dinkes"/>
							<div class="col-sm-3">
								<select name="puskesmas" class="form-control">
								<option value='semua'>Semua</option>
								<?php
								$kota = $_SESSION['kota'];
								$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `Kota`='$kota' order by `NamaPuskesmas`");
								while($data3 = mysqli_fetch_assoc($queryp)){
									if($_GET['puskesmas'] == $data3['KodePuskesmas']){
										echo "<option value='$data3[KodePuskesmas]' SELECTED>$data3[NamaPuskesmas]</option>";
									}else{
										echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
									}
								}
								?>
								</select>
							</div>
							<div class="col-sm-2 bulanformcari">
								<select name="tahun" class="form-control">
									<?php
										for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
										?>
										<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
									<?php }?>
								</select>
							</div>
							<div class="col-sm-2">
								<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
								<a href="?page=lap_P2M_penyakit_terbanyak" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							</div>
						</form>	
					</div>
				</div>
			</div>
		</div>
		<?php if($_GET['tahun'] <> ''){?>
		<div class="widget-body">
			<div class="infobox-container">
				<div id="container_tahun" style="min-width: 200px; height: 350px; margin: 0 auto"></div>
			</div>
		</div>
		<?php }?>
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
		text: 'JUMLAH KONTAK RATE PESERTA BPJS'
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
			
		$tahun = $_GET['tahun'];
		$puskesmas = $_GET['puskesmas'];
		$tahunini = date('Y');
		
		if ($tahun == $tahunini){
			$tbpasienrj = 'tbpasienrj_'.$val;
		}else{
			$tbpasienrj = 'tbpasienrj_'.$val.'_bc';
		}

		if ($puskesmas == 'semua'){
			$namapuskesmas = "";
		}else{
			$namapuskesmas = "AND SUBSTRING(NoRegistrasi,1,11)='$puskesmas'";
		}		
		
		$jumlah_penjumlahan = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(Asuransi,1,4) = 'BPJS' AND `StatusPelayanan` = 'Sudah' ".$namapuskesmas." GROUP BY NoCM"));
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
<?php if($_GET['tahun'] <> ''){?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="panel-title">Kontak Rate Pertahun</h4>
			</div>
			<div class="box-body">
				<div class="table-responsive noprint" style="font-size:12px">
					<table class="table table-striped table-condensed table-bordered noprint">
						<thead>
							<tr>
								<th width="40%">Bulan</th>
								<th width="15%">Perkiraan Jml Peserta</th>
								<th width="15%">Target Capaian (15%)</th>
								<th width="10%">Dilayani</th>
								<th width="10%">Persentase (%)</th>
								<th width="10%">Status</th>
							</tr>
						</thead>
						<tbody font="8">
							<?php
							$array_bulan = array("01"=>"Januari","02"=>"Februari","03"=>"Maret","04"=>"April","05"=>"Mei","06"=>"Juni","07"=>"Juli","08"=>"Agustus","09"=>"September","10"=>"Oktober","11"=>"November","12"=>"Desember");
							foreach($array_bulan as $key => $val){
								$no = $no + 1;
								
								if ($tahun == $tahunini){
									$tbpasienrj = 'tbpasienrj_'.$key;
								}else{
									$tbpasienrj = 'tbpasienrj_'.$key.'_bc';
								}	
								
								if ($_GET['puskesmas'] == 'semua'){
									$namapuskesmas = "";
									$kr_puskesmas = "";
								}else{
									$namapuskesmas = "AND SUBSTRING(NoRegistrasi,1,11)='$puskesmas'";
									$kr_puskesmas = "WHERE KodePuskesmas='$_GET[puskesmas]'";
								}
								
								$dilayani = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(Asuransi,1,4) = 'BPJS' AND `StatusPelayanan` = 'Sudah' ".$namapuskesmas." GROUP BY NoCM"));
							
								// hitung kontak rate
								$dt_kr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(JumlahPeserta) AS JumlahPeserta FROM `tbpuskesmasdetail` ".$kr_puskesmas));
								$jml_peserta = $dt_kr['JumlahPeserta'];
								
								$target = $jml_peserta / 100 * 15;
								
								if($jml_peserta > 0 and $dilayani > 0){
									$persentase = ($dilayani * 100) / $jml_peserta;
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
									<td style="text-align:left;"><?php echo $val;?></td>
									<td style="text-align:right;"><?php echo rupiah($jml_peserta);?></td>
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
	</div>
</div>
<?php 
	if($_GET['puskesmas'] == 'semua'){
?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4 class="panel-title">Kontak Rate Per-Puskesmas</h4>
			</div>
			<div class="box-body">
				<div class="table-responsive noprint" style="font-size:12px">
					<table class="table table-striped table-condensed table-bordered noprint">
						<thead>
							<tr>
								<th width="3%">No.</th>
								<th width="25%">Puskesmas</th>
								<th width="10%">Perkiraan Peserta (Per-Bulan)</th>
								<th width="8%">Target Capaian (Per-Bulan)</th>
								<th width="10%">Perkiraan Peserta (Per-Tahun)</th>
								<th width="8%">Target Capaian (Per-Tahun)</th>
								<th width="10%">Dilayani</th>
								<th width="10%">Persentase (%)</th>
								<th width="10%">Status</th>
							</tr>
						</thead>
						<tbody font="8">
							<?php
							$jumlah_perpage = 10;
							
							if($_GET['h']==''){
								$mulai=0;
							}else{
								$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							$str = "SELECT * FROM `tbpuskesmasdetail`";
							$str2 = $str." ORDER BY `NamaPPK` LIMIT $mulai,$jumlah_perpage";
														
							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							$query = mysqli_query($koneksi,$str2);
							while($datapkm = mysqli_fetch_assoc($query)){
								$no = $no + 1;
								$kdpkm = $datapkm['KodePuskesmas'];
								$namapkm = $datapkm['NamaPPK'];
								
								$jmlpeserta = $datapkm['JumlahPeserta'];								
								$jmlpeserta_tahun = $datapkm['JumlahPeserta'] * 12;								
								$target = $jmlpeserta / 100 * 15;
								$target_tahun = $target * 12;
								
								// hitung selama 1 tahun
								if ($tahun == $tahunini){
									$jans = 'tbpasienrj_01';
									$febs = 'tbpasienrj_02';
									$mars = 'tbpasienrj_03';
									$aprs = 'tbpasienrj_04';
									$meis = 'tbpasienrj_05';
									$juns = 'tbpasienrj_06';
									$juls = 'tbpasienrj_07';
									$agus = 'tbpasienrj_08';
									$seps = 'tbpasienrj_09';
									$okts = 'tbpasienrj_10';
									$novs = 'tbpasienrj_11';
									$dess = 'tbpasienrj_12';
								}else{
									$jans = 'tbpasienrj_01_bc';
									$febs = 'tbpasienrj_02_bc';
									$mars = 'tbpasienrj_03_bc';
									$aprs = 'tbpasienrj_04_bc';
									$meis = 'tbpasienrj_05_bc';
									$juns = 'tbpasienrj_06_bc';
									$juls = 'tbpasienrj_07_bc';
									$agus = 'tbpasienrj_08_bc';
									$seps = 'tbpasienrj_09_bc';
									$okts = 'tbpasienrj_10_bc';
									$novs = 'tbpasienrj_11_bc';
									$dess = 'tbpasienrj_12_bc';
								}	
								
								$jan = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `$jans` WHERE YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(Asuransi,1,4) = 'BPJS' AND `StatusPelayanan` = 'Sudah' AND SUBSTRING(NoRegistrasi,1,11)='$kdpkm' GROUP BY NoCM"));
								$feb = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `$febs` WHERE YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(Asuransi,1,4) = 'BPJS' AND `StatusPelayanan` = 'Sudah' AND SUBSTRING(NoRegistrasi,1,11)='$kdpkm' GROUP BY NoCM"));
								$mar = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `$mars` WHERE YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(Asuransi,1,4) = 'BPJS' AND `StatusPelayanan` = 'Sudah' AND SUBSTRING(NoRegistrasi,1,11)='$kdpkm' GROUP BY NoCM"));
								$apr = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `$aprs` WHERE YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(Asuransi,1,4) = 'BPJS' AND `StatusPelayanan` = 'Sudah' AND SUBSTRING(NoRegistrasi,1,11)='$kdpkm' GROUP BY NoCM"));
								$mei = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `$meis` WHERE YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(Asuransi,1,4) = 'BPJS' AND `StatusPelayanan` = 'Sudah' AND SUBSTRING(NoRegistrasi,1,11)='$kdpkm' GROUP BY NoCM"));
								$jun = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `$juns` WHERE YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(Asuransi,1,4) = 'BPJS' AND `StatusPelayanan` = 'Sudah' AND SUBSTRING(NoRegistrasi,1,11)='$kdpkm' GROUP BY NoCM"));
								$jul = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `$juls` WHERE YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(Asuransi,1,4) = 'BPJS' AND `StatusPelayanan` = 'Sudah' AND SUBSTRING(NoRegistrasi,1,11)='$kdpkm' GROUP BY NoCM"));
								$agu = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `$agus` WHERE YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(Asuransi,1,4) = 'BPJS' AND `StatusPelayanan` = 'Sudah' AND SUBSTRING(NoRegistrasi,1,11)='$kdpkm' GROUP BY NoCM"));
								$sep = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `$seps` WHERE YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(Asuransi,1,4) = 'BPJS' AND `StatusPelayanan` = 'Sudah' AND SUBSTRING(NoRegistrasi,1,11)='$kdpkm' GROUP BY NoCM"));
								$okt = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `$okts` WHERE YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(Asuransi,1,4) = 'BPJS' AND `StatusPelayanan` = 'Sudah' AND SUBSTRING(NoRegistrasi,1,11)='$kdpkm' GROUP BY NoCM"));
								$nov = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `$novs` WHERE YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(Asuransi,1,4) = 'BPJS' AND `StatusPelayanan` = 'Sudah' AND SUBSTRING(NoRegistrasi,1,11)='$kdpkm' GROUP BY NoCM"));
								$des = mysqli_num_rows(mysqli_query($koneksi,"SELECT `NoRegistrasi` FROM `$dess` WHERE YEAR(TanggalRegistrasi)='$tahun' AND SUBSTRING(Asuransi,1,4) = 'BPJS' AND `StatusPelayanan` = 'Sudah' AND SUBSTRING(NoRegistrasi,1,11)='$kdpkm' GROUP BY NoCM"));
								$dilayani = $jan + $feb + $mar + $apr + $mei + $jun + $jul + $agu + $sep + $okt + $nov + $des;
								
								if($jmlpeserta_tahun > 0 and $dilayani > 0){
									$persentase = ($dilayani * 100) / $jmlpeserta_tahun;
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
									<td style="text-align:left;"><?php echo $namapkm;?></td>
									<td style="text-align:right;"><?php echo rupiah($jmlpeserta);?></td>
									<td style="text-align:right;"><?php echo rupiah($target);?></td>
									<td style="text-align:right;"><?php echo rupiah($jmlpeserta_tahun);?></td>
									<td style="text-align:right;"><?php echo rupiah($target_tahun);?></td>
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
		<ul class="pagination">
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
							echo "<li><a href='?page=grafik_bpjs_kontak_rate_dinkes&puskesmas=$puskesmas&tahun=$tahun&h=$i'>$i</a></li>";
						}
					}
				}
			?>	
		</ul>
	</div>
</div>
<?php 
	}
}
?>