<style>
.tr, th{
	text-align:center;
}
.tabel_judul th{
	background: #80ba8b;
	border-collapse: separate;
	font-size: 12px;
	line-height: 20px;
	text-align:center;
	padding: 5px 10px;
	color:#fff;
}

.headinglogin{
	background:#3BAC9B;
	padding:10px 10px;
	color:#fff;
	text-align:center;
	border-radius:4px 4px 0px 0px;
	margin-top:-20px;
	margin-left:-10px;
	margin-right:-10px;
	margin-bottom:15px;
	font-family: Malgun Gothic;
	font-weight: bold;
	font-size: 14px;
}

.sidebars{
	background:#fff;
	border:1px solid #ddd;
	border-radius:5px;
	box-shadow:0px 0px 10px #bbb;
	padding:9px;
	display:block;
	color:#111;
	text-align:left;
	margin: 15px 0px;
}

.kotak_retribusi{
   	background: #92e8df;
    padding: 10px 15px;	
    margin: 5px 0px;
	font-family: Sans-Serif;
	text-align:center;
	color:#00897e;
	border-radius:5px;
}

.kotak_retribusi_medium{
   	background: #e1f4f2;
    padding: 10px 15px;	
    margin: 5px 0px;
	font-family: Sans-Serif;
	text-align:center;
	color:#00897e;
	border-radius:5px;
}

.kotakgrafik{
	margin-top:20px;
	background:#fff;
	padding:15px 10px;
	border:1px solid #ccc;
	border-radius:5px 5px 0px 0px;
}
.kotakgrafik h2{
	font-size:14px;
	background:#f9f9f9;
	padding:20px 10px 15px;
	border-bottom:1px solid #ccc;
	border-radius:5px 5px 0px 0px;
	margin:-15px -10px 10px -10px;
}
.font14{
	font-size: 14px;
}

.font32_bold{
	font-family: Sans-Serif;
	font-size: 32px;
	font-weight: bold;
	text-align: center;
	color:#00897e;
}
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
	display: none;
}
.printheader h4{
	font-size:18px;
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:18px;
	font-family: "Bookman Old Style";
}
@media print {
	@page{
		size:  portrait;   /* auto is the initial value */
		margin: 0mm;  /* this affects the margin in the printer settings */
	}

	html{
		background-color: #FFFFFF; 
		margin: 0px;  /* this affects the margin on the html before sending to printer */
	}
	body{
		visibility:hidden;
		padding:0px;
		margin:0px;
	}
	.printheader{
		display:block;
		margin-bottom:20px;
	}			
	.printini{
		position:fixed;
		top:0cm;
		left:50px;
		right:50px;
		z-index:10;
		visibility:visible;
		margin:20px;
	}
	.table{
		border-color:black !important;
	}
	.noprint{
		display:none;
	}
}
.formcari{
	position:absolute;
	top:25px;
	left:20px;
}
</style>

<?php
include "config/helper_pasienrj.php";
if($_GET['bulan'] == null){
	$bln = date('m');
}else{
	$bln = $_GET['bulan'];
}
	date_default_timezone_set('Asia/Jakarta');
	$tahun = date('Y');	
	$thn = substr($tahun,2,2);
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KUNJUNGAN PASIEN HARIAN</b></h3>
			<div class="row">
				<div class="col-sm-12">
					<form class="form-inline formcari">
						<input type="hidden" name="page" value="grafik_kunjungan_pasien_hari_puskesmas"/>
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
					<div class="formbg">
						<div class = "row" style="margin-top: 20px;">
							<canvas id="Grafik_Retribusi" height="300px"></canvas>
						</div>	
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
			label: 'Jumlah Kunjungan',
			data:[
				<?php
					$jml = 0;				
					for($d = $mulai; $d <= $selesai; $d++){	
						$tanggal = $tahun."-".$bln."-".$d;
						$query_retribusi = mysqli_query($koneksi,"SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE SUBSTRING(NoRegistrasi,1,11) = '$kodepuskesmas' AND `TanggalRegistrasi` = '$tanggal'");
						$jml = mysqli_fetch_assoc($query_retribusi);
						$jml_retribusi = $jml['Jumlah'];
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