<?php
	include "config/helper_pasienrj.php";
	$tahuns = $_GET['tahun'];
	$bln = $_GET['bulan'];
	
	if($tahuns == null){
		$tahuns = date('Y');
	}
	
	if($bln == null){
		$bln = date('m');
		if(strlen($bln) == 1){
			$bln = "0".$bln;
		}
	}
	
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KUNJUNGAN BARU & LAMA</b></h3>
			<div class="formbg">
				<form role="form" class="submit">
					<div class="row">
						<input type="hidden" name="page" value="grafik_kunjungan_baru_lama"/>
						<div class=" col-sm-4">
							<select name="bulan" class="form-control">
								<option value="semua" <?php if($bln == 'semua'){echo "SELECTED";}?>>Semua</option>
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
						<div class="col-sm-1 bulanformcari" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2017 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($tahuns == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-6">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=grafik_kunjungan_baru_lama&bulan=<?php echo $bln;?>&tahun=<?php echo $tahuns;?>" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
						</div>
					</div>
				</form>		
			</div>
		</div>
	</div>
	<div class="col-sm-12 kotakgrafik" style="margin-top: 0px">
		<canvas id="Grafik_Kunjungan_Bl" style="min-width: 200px; height: 300px; margin: 0 auto"></canvas>
	</div>
</div>

<script src="assets/js/jquery.js"></script>
<script src="assets/js/chartjsorg.js"></script>
<script>
<?php
	if($kodepuskesmas == '-'){
		if($bln == 'semua'){
			for($i = 1; $i<=12; $i++){
				if(strlen($i) == 2){
					$nn = $i;
				}else{
					$nn = "0".$i;
				}
				// $tbpsrj = 'tbpasienrj_'.$nn;
				$tbpsrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
				$strarr[] = "(SELECT `StatusKunjungan`, COUNT(`NoRegistrasi`) as `Jumlahs` 
						FROM `$tbpsrj` 
						WHERE YEAR(`TanggalRegistrasi`)='$tahuns'
						GROUP BY StatusKunjungan)";
			}		
			$sql_kunjungan_bl = "SELECT `StatusKunjungan`, SUM(`Jumlahs`) as Jumlah FROM(".implode(" union all ",$strarr).") t_unions GROUP BY StatusKunjungan";
		}else{
			$sql_kunjungan_bl = "SELECT StatusKunjungan, COUNT(NoRegistrasi)AS Jumlah
			FROM `$tbpasienrj` 
			WHERE YEAR(`TanggalRegistrasi`)='$tahuns'
			GROUP BY StatusKunjungan";
		}
	}else{
		if($bln == 'semua'){
			for($i = 1; $i<=12; $i++){
				if(strlen($i) == 2){
					$nn = $i;
				}else{
					$nn = "0".$i;
				}
				// $tbpsrj = 'tbpasienrj_'.$nn;
				$tbpsrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
				$strarr[] = "(SELECT `StatusKunjungan`, COUNT(`NoRegistrasi`) as `Jumlahs` 
						FROM `$tbpsrj` 
						WHERE AND substring(`NoRegistrasi`,1,11) = '$kodepuskesmas' AND YEAR(`TanggalRegistrasi`)='$tahuns'
						GROUP BY StatusKunjungan)";
			}		
			$sql_kunjungan_bl = "SELECT `StatusKunjungan`, SUM(`Jumlahs`) as Jumlah FROM(".implode(" union all ",$strarr).") t_unions GROUP BY StatusKunjungan";
		}else{
			$sql_kunjungan_bl = "SELECT StatusKunjungan, COUNT(NoRegistrasi)AS Jumlah FROM `$tbpasienrj` 
			WHERE YEAR(`TanggalRegistrasi`)='$tahuns' AND substring(`NoRegistrasi`,1,11) = '$kodepuskesmas'
			GROUP BY StatusKunjungan";
		}
	}
?>
var ctx = document.getElementById("Grafik_Kunjungan_Bl").getContext('2d');
var Grafik_Kunjungan_Bl = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: ['Baru','Lama'
				
				],
		datasets: [{
			label: 'Kunjungan Baru & Lama Bulan <?php echo nama_bulan($bln);?>',
			data:[
				<?php
					$query_kunjungan_bl = mysqli_query($koneksi,$sql_kunjungan_bl); 
					while($ambil_kunjungan_bl = mysqli_fetch_assoc($query_kunjungan_bl)){
						echo $ambil_kunjungan_bl['Jumlah'].', ';
					}
				?>
				],
				backgroundColor: [
				<?php
				for($i =0; $i < mysqli_num_rows($query_kunjungan_bl); $i++){
				?>
					'rgba(175, 238, 247, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i =0; $i < mysqli_num_rows($query_kunjungan_bl); $i++){
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
