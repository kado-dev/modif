<style type="text/css">
	.kotak_panel{
		padding:20px 20px;
		min-height: 130px;
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

<?php
	include "config/helper_pasienrj.php";
	$bulan = date('m');	
	$tahun = date('Y');	
	$thn = substr($tahun,2,2);
	$hariini = date('Y-m-d');
	$hariini2 = date('ymd');
	$hariini3 = date('ym');
	
	if($_GET['bulan'] == null){
		$bln = date('m');
	}else{
		$bln = $_GET['bulan'];
	}	

	// karcis
	$jmlkarcis_hr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS JumlahKarcis FROM `$tbpasienrj` WHERE `TanggalRegistrasi`=curdate() AND `Asuransi`='UMUM'"));
	$jmlkarcis_bl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS JumlahKarcis FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND `Asuransi`='UMUM'"));
	$dtpelayanan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Tarif` FROM `tbpelayanankesehatan` WHERE `Pelayanan` = 'POLI UMUM'"));
	$tarif_hari = $jmlkarcis_hr['JumlahKarcis'] * $dtpelayanan['Tarif'];
	$tarif_bulan = $jmlkarcis_bl['JumlahKarcis'] * $dtpelayanan['Tarif'];		
	
	// kir
	$jmlkir_hr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(TarifKir) AS JumlahKir FROM `$tbpasienrj` WHERE `TanggalRegistrasi`=curdate() AND `Kir`<>''"));
	$jmlkir_bl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(TarifKir) AS JumlahKir FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND `Kir`<>''"));
	$tarif_kir_hr = $jmlkir_hr['JumlahKir'];
	$tarif_kir_bl = $jmlkir_bl['JumlahKir'];
	
	$jmlkir_hr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(TarifKir) AS JumlahKir FROM `$tbpasienrj` WHERE `TanggalRegistrasi`=curdate() AND `Kir`<>''"));
	$jmlkir_bl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(TarifKir) AS JumlahKir FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND `Kir`<>''"));
	$tarif_kir_hr = $jmlkir_hr['JumlahKir'];
	$tarif_kir_bl = $jmlkir_bl['JumlahKir'];	
			
	// tindakan
	$jmltindakan_hr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(b.Tarif) AS JumlahTindakan FROM tbtindakanpasiendetail a JOIN tbtindakan b ON a.KodeTindakan = b.KodeTindakan WHERE SUBSTRING(a.NoRegistrasi,13,6)='$hariini2'"));
	$jmltindakan_bl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(GrandTotal) AS JumlahTindakan FROM tbtindakanpasien WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '$bulan';"));
	
?>

<div class="tableborderdiv">
	<h3 class="judul"><b>RETRIBUSI</b></h3>
	<div class="row">
		<div class="col-sm-6">
			<div class="kotak_panel">
				<div class="font30"><?php echo rupiah($tarif_hari + $tarif_kir_hr + $jmltindakan_hr['JumlahTindakan']);?></div>
				<div class="fontket">
					<h3>Hari Ini</h3>
					<span>* Total Retribusi</span>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="kotak_panel">
				<div class="font30"><?php echo rupiah($tarif_bulan + $tarif_kir_bl + $jmltindakan_bl['JumlahTindakan']);?></div>
				<div class="fontket">
					<h3>Bulan Ini</h3>
					<span>* Total Retribusi</span>
				</div>
			</div>
		</div>
	
	<!--grafik kasir-->
	<div class="row" style="margin-top: -20px;">
		<div class="col-sm-12">
			<div class="kotakgrafik">
				<form class="form-inline formcari">
					<input type="hidden" name="page" value="dashboard_puskesmas_kasir"/>
					<select name="bulan" class="form-control" onchange="this.form.submit();" >
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
				</form>
				<div class="au-card m-b-30">
					<div class="au-card-inner">
						<canvas id="Grafik_Retribusi" height="270px"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--end grafik 3D-->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/chartjsorg.js"></script>
<script>

$(".btndetailretribusi_hari").click(function(){
	if ( $( ".detailretribusi_hari" ).is( ":hidden" ) ) {
		$(".detailretribusi_hari").slideDown();
	}else{
		$(".detailretribusi_hari").slideUp();
	}
});

$(".btndetailretribusi_bulan").click(function(){
	if ( $( ".detailretribusi_bulan" ).is( ":hidden" ) ) {
		$(".detailretribusi_bulan").slideDown();
	}else{
		$(".detailretribusi_bulan").slideUp();
	}
});

var ctx = document.getElementById("Grafik_Retribusi").getContext('2d');
var Grafik_Retribusi = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: [
				<?php
				$hari_ini = date('Y')."-".$bln."-01";
					$mulai = 1;
					$selesai = date('t', strtotime($hari_ini));
					for($d = $mulai; $d <= $selesai; $d++){	
						echo '"'.$d.'", ';
					}
				?>
				],
		datasets: [{
			label: 'Jumlah Retribusi',
			data:[
				<?php
					$jml = 0;		
									
					for($d = $mulai; $d <= $selesai; $d++){	
						$tanggal = $tahun."-".$bln."-".$d;
						$query_retribusi = mysqli_query($koneksi,"SELECT SUM(`TotalTarif`) AS JumlahTarif FROM `$tbpasienrj` WHERE `TanggalRegistrasi` = '$tanggal'");
						$jml = mysqli_fetch_assoc($query_retribusi);
						if ($jml['JumlahTarif'] == 0){
							$jml_retribusi =  $jml['JumlahTarif'];
						}else{
							$jml_retribusi =  $jml['JumlahTarif'] + $jmltindakan_hr['JumlahTindakan'];
						}
						echo '"'.$jml_retribusi.'", ';
					}		
				?>
				],
				backgroundColor: [
				<?php
				for($i = $mulai; $i <= $selesai; $i++){
				?>
					'rgba(175, 238, 247, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i = $mulai; $i <= $selesai; $i++){
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