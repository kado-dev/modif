<?php
	include "config/helper_pasienrj.php";
	$bln = $_GET['bulan'];
	if($bln == null){
		$bln = date('m');
		if(strlen($bln) == 1){
			$bln = "0".$bln;
		}
	}
	$hari = date('Y-m-d');
	$bulan = date('M-Y');
	$bulannow = date('m');
	$tahun = date('Y');
?>

<div class="col-sm-12">
	<div class="widget-box transparent">
		<div class="widget-header widget-header-small">
			<h4 class="widget-title blue smaller">
				<i class="ace-icon fa fa-rss orange"></i>
				Grafik Kunjungan Sakit & Sehat
			</h4>
		</div>
		<div class="row" style="margin-top:10px;">
			<div class="col-xs-12 col-sm-12">
				<div class="search-area well well-sm">
					<div class = "row">
						<form role="form" class="submit">
							<input type="hidden" name="page" value="grafik_kunjungan_sakit_sehat"/>
							<div class=" col-sm-4">
								<select name="bulan" class="form-control">
									<option value="01" <?php if($bln == '01'){echo "SELECTED";}?>>Januari</option>
									<option value="02" <?php if($bln == '02'){echo "SELECTED";}?>>Februari</option>
									<option value="03" <?php if($bln == '03'){echo "SELECTED";}?>>Maret</option>
									<option value="04" <?php if($bln == '04'){echo "SELECTED";}?>>April</option>
									<option value="05" <?php if($bln == '05'){echo "SELECTED";}?>>Mei</option>
									<option value="06" <?php if($bln == '06'){echo "SELECTED";}?>>Juni</option>
									<option value="07" <?php if($bln == '07'){echo "SELECTED";}?>>Juli</option>
									<option value="08" <?php if($bln == '08'){echo "SELECTED";}?>>Agustus</option>
									<option value="09" <?php if($bln == '09'){echo "SELECTED";}?>>September</option>
									<option value="10" <?php if($bln == '10'){echo "SELECTED";}?>>Oktober</option>
									<option value="11" <?php if($bln == '11'){echo "SELECTED";}?>>November</option>
									<option value="12" <?php if($bln == '12'){echo "SELECTED";}?>>Desember</option>
								</select>
							</div>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-sm btn-warning">Cari</button>
								<a href="?page=grafik_kunjungan_sakit_sehat&bulan=<?php echo $bulannow;?>" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							</div>
						</form>	
					</div>
				</div>
			</div>
		</div>	
		<div class="col-sm-12">
			<div class="widget-body">
				<div class="infobox-container">
					<canvas id="Grafik_Sakit_Sehat" style="min-width: 200px; height: 350px; margin: 0 auto"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="assets/js/jquery.js"></script>
<script src="assets/js/chartjsorg.js"></script>
<script>
<?php
	$sql_sakit_sehat = "SELECT COUNT(NoRegistrasi) AS Jumlah, StatusPasien FROM `$tbpasienrj` WHERE 
			YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11) = '$kodepuskesmas' group by StatusPasien";
?>
var ctx = document.getElementById("Grafik_Sakit_Sehat").getContext('2d');
var Grafik_Sakit_Sehat = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: ['Sakit','Sehat'
				
				],
		datasets: [{
			label: 'Kunjungan Sakit & Sehat Bulan <?php echo nama_bulan($bln);?>',
			data:[
				<?php
					$query_sakit_sehat = mysqli_query($koneksi,$sql_sakit_sehat); 
					while($ambil_kunjungan_bl = mysqli_fetch_assoc($query_sakit_sehat)){
						echo $ambil_kunjungan_bl['Jumlah'].', ';
					}
				?>
				],
				backgroundColor: [
				<?php
				for($i =0; $i < mysqli_num_rows($query_sakit_sehat); $i++){
				?>
					'rgba(175, 238, 247, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i =0; $i < mysqli_num_rows($query_sakit_sehat); $i++){
			?>
				'rgba(114, 211, 224, 1)',
			<?php
			}
			?>
			],
			borderWidth: 1
		}]
	},
	options: {
		responsive: true,
		maintainAspectRatio: false,
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero:true
				}
			}]
		}
	}
});
</script>
