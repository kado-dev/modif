<style type="text/css">
	.bulanheader{
		border-right: 1px solid #ddd;
		text-align: center;
		padding-left:0px;
		padding-right:0px;
	}
	.bulanheader:last-child{
		border-right: 0px solid #ddd;
		padding-right:12px;
	}
	.bulanheader:first-child{
		padding-left:12px;
	}

	.bulanheader h4{
		padding: 4px;font-size: 14px;
	}
	.bulanheader p{
		padding: 8px;font-size: 17px;margin:0px;
	}
	.bulanheader p a{
		display: block;
	}
	.clr_terisi{
		background: #40aa8b;
	}
	.clr_kosong{
		background: #ff9e9e;
	}

	.bulanheader:last-child > .clr_terisi, .bulanheader:last-child > .clr_kosong{
		border-radius: 0px 0px 10px 0px;
	}

	.bulanheader:first-child > .clr_terisi, .bulanheader:first-child > .clr_kosong{
		border-radius: 0px 0px 0px 10px;
	}
</style>

<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
			
	$tahun = $_GET['tahun'];
	if($tahun == ''){
		$tahun = date('Y');
	}
		
	$bulandari = $_GET['bulandari'];
	if($bulandari == ''){
		$bulandari = date('m');
	}

	$bulansampai = $_GET['bulansampai'];
	if($bulansampai == ''){
		$bulansampai = date('m');
	}
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>LAPORAN SPM KESEHATAN</b></h3>
			<div class="formbg">
				<form role="form">
					<div class="row">
						<input type="hidden" name="page" value="lap_spm_indikator_laporan"/>
						<div class="col-sm-2">
							<select name="bulandari" class="form-control">
								<option value="">--Pilih Bulan--</option>
								<?php
									$bulan_arry = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
									foreach ($bulan_arry as $key => $val) {
								?>
								<option value="<?php echo $key;?>" <?php if ($bulandari == $key){echo 'SELECTED';}?>><?php echo $val;?></option>
								<?php
									}
								?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="bulansampai" class="form-control">
								<option value="">--Pilih Bulan--</option>
								<?php
									foreach ($bulan_arry as $key => $val) {
								?>
								<option value="<?php echo $key;?>" <?php if ($bulansampai == $key){echo 'SELECTED';}?>><?php echo $val;?></option>
								<?php
									}
								?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="tahun" class="form-control" required>
								<option value="">--Pilih Tahun--</option>
								<?php
									for($thn = date('Y'); $thn > (date('Y') - 3); $thn--){
								?>
								<option value="<?php echo $thn;?>" <?php if ($tahun == $thn){echo 'SELECTED';}?>><?php echo $thn;?></option>
								<?php
									}
								?>
							</select>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!--data-->
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<!-- <a href="?page=lap_spm_indikator_input&tahun=<?php echo $tahun;?>&bulan=<?php echo $bulan;?>" class="btn btn-info">Tambah</a><hr/>
			<?php //echo nama_bulan($bulan)." ".$tahun;?> -->
			<table class="table-judul" border="1">
				<thead>
					<tr>
						<th width="5%" rowspan="2">NO</th>
						<th width="50%" rowspan="2">INDIKATOR</th>
						<th width="15%" colspan="2">TARGET</th>
						<th width="15%" colspan="2">CAPAIAN</th>
						<th width="15%" colspan="2">KESENJANGAN</th>
					</tr>
					<tr>
						<th>SASARAN<br/>BULAN INI</th>
						<th>%</th>
						<th>TOTAL</th>
						<th>%</th>
						<th>CAPAIAN</th>
						<th>%</th>
					</tr>
				</thead>
				<tbody font="8">
					<?php					
					$str = "SELECT * FROM  `tbspmindikator` ORDER by idspmindikator ASC";
					$query = mysqli_query($koneksi,$str);
					$no = 0;
					while($data = mysqli_fetch_assoc($query)){
						$no++;
						if($bulandari == $bulansampai){
							$getvalue = mysqli_query($koneksi,"SELECT * FROM `tbspmindikator_laporan` WHERE `idspmindikator`= '$data[idspmindikator]' AND `KodePuskesmas` = '$kodepuskesmas' AND `tahun` = '$tahun' AND `bulan` = '$bulandari' ORDER by waktu DESC");
						}else{
							$getvalue = mysqli_query($koneksi,"SELECT SUM(jumlah_d) as jumlah_d, SUM(jumlah_s) as jumlah_s, SUM(cakupan) as cakupan FROM `tbspmindikator_laporan` WHERE `idspmindikator`= '$data[idspmindikator]' AND `KodePuskesmas` = '$kodepuskesmas' AND ((`bulan` >= '$bulandari' AND `tahun` = '$tahun') AND (`bulan` <= '$bulansampai' AND `tahun` = '$tahun')) ORDER by waktu DESC");
						}
						
						$jumlah_d = '';
						$jumlah_s = '';
						$capaian = '';
						$capaian_persen = '';
						$kesenjangan_persen = '';

						if(mysqli_num_rows($getvalue) > 0){
							$dtget = mysqli_fetch_assoc($getvalue);
							$jumlah_d = $dtget['jumlah_d'];
							$jumlah_s = $dtget['jumlah_s'];
							if($jumlah_d != '' || $jumlah_s != ''){
								$capaian = $jumlah_d - $jumlah_s;
								$capaian_persen = round(($jumlah_d / $jumlah_s) * 100,1)."%";
								$kesenjangan_persen = round(100 - (($jumlah_d / $jumlah_s) * 100),1)."%";
							}
						}
					?>
						<tr style="background: #b6e0d4">
							<td align="center"><?php echo $no;?></td>		
							<td align="left"><?php echo $data['indikator'];?></td>				
							<td align="center"><?php echo $jumlah_s;?></td>		
							<td align="center"><?php echo ($jumlah_s != '') ? '100%' : '';?></td>	
							<td align="center"><?php echo $jumlah_d;?></td>		
							<td align="center"><?php echo $capaian_persen;?></td>		
							<td align="center"><?php echo $capaian;?></td>	
							<td align="center"><?php echo $kesenjangan_persen;?></td>	
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
			<hr/>
			<div class="row noprint">
				<div class="col-sm-12">
					<div class="alert alert-block alert-success fade in">
						<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
						<p>
							<b>Rumus :</b><br/>
							1. Capaian (%), Total Capaian dibagi Total Target dikali 100<br/>
							2. Kesenjangan (%), Capaian (%) - Target (%)<br/>
						</p>
					</div>
				</div>
			</div>
			<hr/>
			<div class="kotakgrafik">
				<div class="au-card m-b-30">
					<div class="au-card-inner">
						<h3 class="title-2 m-b-40">Capaian Indikator Spm</h3>
						<canvas id="lineChart"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/Chart.bundle.min.js"></script>
 <script>
 //line chart
    var ctx = document.getElementById("lineChart");
    if (ctx) {
      ctx.height = 80;
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: [
				<?php
					$strlabel = "SELECT * FROM  `tbspmindikator` ORDER by idspmindikator ASC";
					$querylabel = mysqli_query($koneksi,$strlabel);
					while($dtlabel = mysqli_fetch_assoc($querylabel)){
						echo '"'.$dtlabel['indikator'].'", ';
					}
				?>
		  ],
          defaultFontFamily: "Malgun Gothic",
          datasets: [
            {
              label: "Target",
              borderColor: "rgba(234, 131, 93)",
              borderWidth: "2",
			  backgroundColor: "#ffac8c",
              data: [
			  <?php
					$querylabel = mysqli_query($koneksi,$strlabel);
					while($dtlabel = mysqli_fetch_assoc($querylabel)){
						if($bulandari == $bulansampai){
							$gettarget = mysqli_query($koneksi,"SELECT jumlah_s FROM `tbspmindikator_laporan` WHERE `idspmindikator`= '$dtlabel[idspmindikator]' AND `KodePuskesmas` = '$kodepuskesmas' AND `tahun` = '$tahun' AND `bulan` = '$bulandari' ORDER by waktu DESC");
						}else{
							$gettarget = mysqli_query($koneksi,"SELECT SUM(jumlah_s) as jumlah_s FROM `tbspmindikator_laporan` WHERE `idspmindikator`= '$dtlabel[idspmindikator]' AND `KodePuskesmas` = '$kodepuskesmas' AND ((`bulan` >= '$bulandari' AND `tahun` = '$tahun') AND (`bulan` <= '$bulansampai' AND `tahun` = '$tahun')) ORDER by waktu DESC");
						}
						$jml_target = 0;
						if(mysqli_num_rows($gettarget) > 0){
							$dtget = mysqli_fetch_assoc($gettarget);
							$jml_target = $dtget['jumlah_s'];
						}
						echo $jml_target.', ';
					}
				?>
			  ]
            },
            {
              label: "Capaian",
              borderColor: "rgba(26, 132, 100)",
              borderWidth: "2",
              backgroundColor: "#40aa8b",
              pointHighlightStroke: "rgba(26,179,148,1)",
              data: [
			  <?php
					$querylabel = mysqli_query($koneksi,$strlabel);
					while($dtlabel = mysqli_fetch_assoc($querylabel)){
						if($bulandari == $bulansampai){
							$getcapaian = mysqli_query($koneksi,"SELECT jumlah_d FROM `tbspmindikator_laporan` WHERE `idspmindikator`= '$dtlabel[idspmindikator]' AND `KodePuskesmas` = '$kodepuskesmas' AND `tahun` = '$tahun' AND `bulan` = '$bulandari' ORDER by waktu DESC");
						}else{
							$getcapaian = mysqli_query($koneksi,"SELECT SUM(jumlah_d) as jumlah_d FROM `tbspmindikator_laporan` WHERE `idspmindikator`= '$dtlabel[idspmindikator]' AND `KodePuskesmas` = '$kodepuskesmas' AND ((`bulan` >= '$bulandari' AND `tahun` = '$tahun') AND (`bulan` <= '$bulansampai' AND `tahun` = '$tahun')) ORDER by waktu DESC");
						}
						$jml_capaian = 0;
						if(mysqli_num_rows($getcapaian) > 0){
							$dtget = mysqli_fetch_assoc($getcapaian);
							$jml_capaian = $dtget['jumlah_d'];
						}
						echo $jml_capaian.', ';
					}		
				?>
			  ]
            }
          ]
        },
        options: {
          legend: {
            position: 'top',
            labels: {
              fontFamily: 'Malgun Gothic'
            }

          },
          responsive: true,
          tooltips: {
            mode: 'index',
            intersect: false
          },
          hover: {
            mode: 'nearest',
            intersect: true
          },
          scales: {
            xAxes: [{
              ticks: {
                fontFamily: "Malgun Gothic"

              }
            }],
            yAxes: [{
              ticks: {
                beginAtZero: true,
                fontFamily: "Malgun Gothic"
              }
            }]
          }

        }
      });
    }
 </script>