<?php
	include "config/helper_pasienrj.php";
	$tahuns = $_GET['tahun'];
	$bln = $_GET['bulan'];
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	
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
			<h3 class="judul"><b>JAMINAN / CARA BAYAR</b></h3>
			<div class="formbg">
				<form role="form" class="submit">
					<div class="row">
						<input type="hidden" name="page" value="grafik_kunjungan_carabayar_tahun"/>
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
						<div class="col-sm-2 bulanformcari">
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
							<a href="?page=grafik_kunjungan_carabayar_tahun&bulan=<?php echo $bln;?>&tahun=<?php echo $tahuns;?>" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
						</div>
						<?php
							if($kodepuskesmas == '-'){
								if($bln == 'semua'){
									for($i = 1; $i<=12; $i++){
										if(strlen($i) == 2){
											$nn = $i;
										}else{
											$nn = "0".$i;
										}
										// $tbpasienrj = 'tbpasienrj_'.$nn;
										$tbpasienrj = "tbpasienrj";
										$strarr[] = "(SELECT Asuransi, COUNT(NoRegistrasi)AS Jumlahs 
													FROM `$tbpasienrj`
													WHERE YEAR(`TanggalRegistrasi`)='$tahuns' GROUP BY Asuransi)";
									}		
									$str_jaminan = "SELECT `Asuransi`, SUM(`Jumlahs`) as Jumlah FROM(".implode(" union all ",$strarr).") t_unions 
													GROUP BY Asuransi";
								}else{
									$str_jaminan = "SELECT Asuransi, COUNT(NoRegistrasi)AS Jumlah 
									FROM `tbpasienrj` 
									WHERE YEAR(`TanggalRegistrasi`) = '$tahuns'
									GROUP BY Asuransi";
								}	
								// echo $str_jaminan;
							}else{
								if($bln == 'semua'){
									for($i = 1; $i<=12; $i++){
										if(strlen($i) == 2){
											$nn = $i;
										}else{
											$nn = "0".$i;
										}
										// $tbpasienrj = 'tbpasienrj_'.$nn;
										$tbpasienrj = "tbpasienrj_".$kodepuskesmas;
										$strarr[] = "(SELECT Asuransi, COUNT(NoRegistrasi)AS Jumlahs
													FROM `$tbpasienrj`
													WHERE SUBSTRING(`NoRegistrasi`,1,11) = '$kodepuskesmas' AND YEAR(`TanggalRegistrasi`)='$tahuns' 
													GROUP BY Asuransi)";
									}		
									$str_jaminan = "SELECT `Asuransi`, SUM(`Jumlahs`) as Jumlah FROM(".implode(" union all ",$strarr).") t_unions GROUP BY Asuransi";
								}else{
									$str_jaminan = "SELECT Asuransi, COUNT(NoRegistrasi)AS Jumlah
									FROM `$tbpasienrj` 
									WHERE YEAR(`TanggalRegistrasi`) = '$tahuns' AND SUBSTRING(`NoRegistrasi`,1,11) = '$kodepuskesmas'
									GROUP BY Asuransi";
								}
								// echo $str_jaminan;
							}
						?>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-sm-12 kotakgrafik" style="margin-top: 0px">
		<canvas id="Grafik_Jaminan" style="min-width: 200px; height: 300px; margin: 0 auto"></canvas>
	</div>
</div>

<script src="assets/js/jquery.js"></script>
<script src="assets/js/chartjsorg.js"></script>
<script>

var ctx = document.getElementById("Grafik_Jaminan").getContext('2d');
var Grafik_Jaminan = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: [
				<?php   
					$query_jaminan = mysqli_query($koneksi, $str_jaminan) or die(mysqli_error());       
					while($ambil_jaminan = mysqli_fetch_array($query_jaminan)){
						echo '"'.$ambil_jaminan['Asuransi'].'", ';
					} 
				?>
				],
		datasets: [{
			label: 'Jaminan Cara Bayar Bulan <?php echo nama_bulan($bulan);?>',
			data:[
				<?php
					$query_jaminan = mysqli_query($koneksi, $str_jaminan) or die(mysqli_error());
					while($ambil_jaminan = mysqli_fetch_array($query_jaminan)){
						echo $ambil_jaminan['Jumlah'].', ';
					} 
				?>
				],
				backgroundColor: [
				<?php
				for($i =0; $i < mysqli_num_rows($query_jaminan); $i++){
				?>
					'rgba(175, 238, 247, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i =0; $i < mysqli_num_rows($query_jaminan); $i++){
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
