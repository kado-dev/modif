<?php
	include "config/helper_pasienrj.php";
	$kota = $_SESSION['kota'];
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
	
	if($kodepuskesmas != "-"){
		$kodepuskesmas = "AND SUBSTRING(NoRegistrasi,1,11) = '$kodepuskesmas'";
		$sql = "SELECT COUNT(NoRegistrasi)AS Jumlah, AsalPasien 
		FROM `$tbpasienrj`
		WHERE YEAR(TanggalRegistrasi) = '$tahuns'".$kodepuskesmas."
		GROUP BY AsalPasien";
		// echo $sql;
	}else{
		$kodepuskesmas = "";
		$sql = "SELECT COUNT(NoRegistrasi)AS Jumlah, AsalPasien 
		FROM `tbpasienrj`
		WHERE YEAR(TanggalRegistrasi) = '$tahuns'".$kodepuskesmas."
		GROUP BY AsalPasien";
		// echo $sql;
	}	
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KUNJUNGAN UKP & UKM</b></h3>
			<div class="formbg">
				<form role="form" class="submit">
					<div class = "row">
						<input type="hidden" name="page" value="grafik_kunjungan_ukp"/>
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
							<a href="?page=grafik_kunjungan_ukp&bulan=<?php echo $bln;?>&tahun=<?php echo $tahuns;?>" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
	<div class="col-sm-12 kotakgrafik" style="margin-top: 0px">
		<canvas id="Grafik_Kunjungan" style="min-width: 200px; height: 300px; margin: 0 auto"></canvas>
	</div>
	<div class="row col-sm-12" style="margin-top: 20px;">
		<div class="alert alert-block alert-success fade in">
			<p><b>Perhatian :</b><br/>Jumlah kunjungan UKP & UKM adalah rekapan dari pasien cara bayar (Umum, Gratis & BPJS)</p>
		</div>
	</div>
</div>

<script src="assets/js/jquery.js"></script>
<script src="assets/js/chartjsorg.js"></script>
<script>
var ctx = document.getElementById("Grafik_Kunjungan").getContext('2d');
var Grafik_Kunjungan = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: [
				<?php   
					$query = mysqli_query($koneksi,$sql) or die(mysqli_error());         
					while($ambil = mysqli_fetch_array($query)){
						$sql_aslps = "SELECT * FROM tbasalpasien WHERE Id = '$ambil[AsalPasien]'";
						$query_aslps = mysqli_query($koneksi, $sql_aslps);
						$dt = mysqli_fetch_assoc($query_aslps);
						echo "'".$dt['AsalPasien']."', ";
					} 
				?>
				],
		datasets: [{
			label: 'Kunjungan UKP & UKM Bulan <?php echo nama_bulan($bln);?>',
			data:[
				<?php   
					$query = mysqli_query($koneksi,$sql) or die(mysqli_error());         
					while($ambil = mysqli_fetch_array($query)){
						echo $ambil['Jumlah'].', ';
					} 
				?>
				],
				backgroundColor: [
				<?php
				for($i =0; $i < mysqli_num_rows($query); $i++){
				?>
					'rgba(175, 238, 247, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i =0; $i < mysqli_num_rows($query); $i++){
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
