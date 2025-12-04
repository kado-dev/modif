	<?php
	//error_reporting(1);
		include "config/helper_covid.php";
		$data_covid = get_covid('https://api.kawalcorona.com/indonesia/');
		$dtcovid = json_decode($data_covid,True);


		$data_covid_prov = get_covid_prov('https://api.kawalcorona.com/indonesia/provinsi/');
		$dtcovidprov = json_decode($data_covid_prov,True);
		//echo $data_covid_prov ;

		//echo var_dump($data_covid);
		// $datanasional = $dtcovid['nasional'];
		// $dtnorderbyhari = array_sorting($datanasional, 'hari_ke', SORT_ASC);
		// $jmldtnorderbyhari = count($dtnorderbyhari) - 1;
		
		// $datawilayah = $dtcovid['wilayah'];
		// $databerita = array_filter_berita($dtcovid['berita']);

	?>
	<style type="text/css">
		.kotak_panel{
			padding:20px 20px;min-height: 130px
		}
		.kotak_panel2{
			padding:20px 20px;min-height: 100px; background: #fff;margin-bottom: 20px
		}
		.font30 span{
			font-size: 12px;
		}
		.fontket h3{
			color:#00aec5;padding:0px;margin:0px;font-size: 18px
		}
		.fontket span{
			font-size: 11px;
		}
	</style>
	
	<div class="tableborderdiv">
		<h3 class="judul"><b>Covid-19 Indonesia</b></h3>
		<div class="row" style="margin-top:0px;">
			<div class="col-sm-3">
				<div class="kotak_panel">
					<div class="font30"><?php echo $dtcovid[0]['positif'];?></div>
					<div class="fontket"><h3>Total Kasus</h3></div>
				</div>
			</div>
			<a href="#" style="cursor:pointer">
				<div class="col-sm-3">
					<div class="kotak_panel">
						<div class="font30">
							<?php echo $dtcovid[0]['dirawat'];?>
							<span>(<?php echo number_format((($dtcovid[0]['dirawat'] / $dtcovid[0]['positif']) * 100),2);?>% *)</span>
						</div>
						<div class="fontket">
							<h3>Dalam Perawatan</h3>
							<span>* Sedang dirawat / Total kasus</span>
						</div>
					</div>
				</div>
			</a>
			<div class="col-sm-3">
				<div class="kotak_panel">
					<div class="font30">
						<?php echo $dtcovid[0]['sembuh'];?>
						<span>(<?php echo number_format((($dtcovid[0]['sembuh'] / $dtcovid[0]['positif']) *100),2);?>% *)</span>		
					</div>
					<div class="fontket">
						<h3>Total Sembuh</h3>
						<span>* Sembuh / Total kasus</span>
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="kotak_panel">
					<div class="font30">
						<?php echo $dtcovid[0]['meninggal'];?>
						<span>(<?php echo number_format((($dtcovid[0]['meninggal'] / $dtcovid[0]['positif']) *100),2);?>% *)</span>			
					</div>
					<div class="fontket">
						<h3>Total Kematian</h3>
						<span>* Wafat / Total kasus</span>
					</div>
				</div>
			</div>
		</div>
		<br/>
		<?php
			if($kota == "KABUPATEN BANDUNG"){
		?>
		<?php 
		function bacaHTML($url){
				 // inisialisasi CURL
				 $data = curl_init();
				 // setting CURL
				 curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
				 curl_setopt($data, CURLOPT_URL, $url);
				 // menjalankan CURL untuk membaca isi file 
				 $hasil = curl_exec($data);
				 curl_close($data);
				 return $hasil;
			}
			 
			$kodeHTML =  bacaHTML('https://covid19.bandungkab.go.id/');
			 
			//echo "tes".$pecahLagi[0];
			$listgrab = explode('<h3 class="count-number">', $kodeHTML);
			$getodp = explode('</h3>', $listgrab[1]);
			$getpdp = explode('</h3>', $listgrab[2]);
			$getpositif = explode('</h3>', $listgrab[3]);

			$cor_odp = $getodp[0];
			$cor_pdp = $getpdp[0];
			$cor_positif = $getpositif[0];
			//die();
		?>

		<h3 class="judul"><b>Covid-19 Kabupaten Bandung</b></h3>
		<div class="row" style="margin-top:0px;">			
			<div class="col-sm-4">
				<div class="kotak_panel2">
					<div class="font30"><?php echo $cor_odp;?></div>
					<div class="fontket"><h3>ODP</h3></div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="kotak_panel2">
					<div class="font30"><?php echo $cor_pdp;?></div>
					<div class="fontket"><h3>PDP</h3></div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="kotak_panel2">
					<div class="font30"><?php echo $cor_positif;?></div>
					<div class="fontket"><h3>Positif</h3></div>
				</div>
			</div>	
		</div>
		<?php
			}
		?>

	<!--	
		<div class="row">
			<div class="col-xs-12">
				<div class="col-sm-12 kotakgrafik" style="margin-top: 0px">
					<canvas id="Grafik_Covid" height="300px"></canvas>
				</div>
			</div>	
		</div><br/>
	-->


		<div class="row">
			<div class="col-sm-12 table-responsive">
				<table id="datatabless" class="table-judul-form">
					<thead>
						<tr>
							<th width="5%">No.</th>
							<th width="50%">Provinsi</th>
							<th width="10%">Positif</th>
							<th width="10%">Sembuh</th>
							<th width="10%">Meninggal</th>
						</tr>
					</thead>
					<tbody>
						<?php
						for($i =0; $i < count($dtcovidprov); $i++){								
						?>
							<tr>
								<td align="center"><?php echo $i + 1;;?></td>
								<td align="left"><?php echo $dtcovidprov[$i]['attributes']['Provinsi'];?></td>
								<td align="center"><?php echo $dtcovidprov[$i]['attributes']['Kasus_Posi'];?></td>
								<td align="center"><?php echo $dtcovidprov[$i]['attributes']['Kasus_Semb'];?></td>
								<td align="center"><?php echo $dtcovidprov[$i]['attributes']['Kasus_Meni'];?></td>
							</tr>	
						<?php	
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>	


<!--
<script src="assets/js/jquery.js"></script>
<script src="assets/js/chartjsorg.js"></script>
<script type="text/javascript">
// var ctx = document.getElementById("Grafik_Covid").getContext('2d');
// var Grafik_Penyakit = new Chart(ctx, {
// 	type: 'bar',
// 	data: {
// 		labels: [
// 				<?php
// 					for($i =0; $i < count($dtnorderbyhari); $i++){
// 						echo '"'.$dtnorderbyhari[$i]['hari_ke'].'", ';
// 					}
// 				?>
// 				],
// 		datasets: [{
// 			label: 'Jumlah Pasien Positif Covid-19 di Indonesia',
// 			data:[
// 				<?php
// 					for($i =0; $i < count($dtnorderbyhari); $i++){
// 						echo '"'.$dtnorderbyhari[$i]['positif_kumulatif'].'", ';
// 					}			
// 				?>
// 				],
// 				backgroundColor: [
// 				<?php
// 				for($i =0; $i < count($dtnorderbyhari); $i++){
// 				?>
// 					'rgba(175, 238, 247, 0.3)',
// 				<?php
// 				}
// 				?>	
// 				],
// 			borderColor: [
// 			<?php
// 			for($i =0; $i < count($dtnorderbyhari); $i++){
// 			?>
// 				'rgba(114, 211, 224, 1)',
// 			<?php
// 			}
// 			?>
// 			],
// 			borderWidth: 1
// 		}]
// 	},
// 	options: {
// 		responsive: true,
// 		maintainAspectRatio: false,
// 		scales: {
// 			yAxes: [{
// 				ticks: {
// 					beginAtZero:true
// 				}
// 			}]
// 		}
// 	}
// });
</script>
-->