<!doctype html>
<html lang="en">
<body>
<style>	
.kotak_panels{
	padding: 25px 20px;
	border-radius: 6px;
	margin-bottom: 15px;
}
.kotak_panels i{
	color: #f5f5f5;
	border:7px solid #f2f2f2;
	padding:5px 8px;
	border-radius: 50%;
}
.kotak_panels .ket{
	font-size: 14px;color: #f9f9f9;
	position: absolute;
	top:65px;
	left:120px;
}
.greens{
	// background-image: -webkit-linear-gradient(90deg, #098c3d 0%, #29DE52 100%);
	background: linear-gradient(0deg, rgba(82, 201, 102, 0.9), rgba(82, 201, 102, 0.9)), url('image/bgpanel.jpg');
	background-repeat: no-repeat;
	background-size: 100%;
	background-position: center;
	box-shadow: 0 5px 10px -3px #7f7f7f;
}
.kotak_panel_detail{
	width: 100%;
	background: #fff;
	margin-top: 10px;	
}
.kotak_panel_detail tr td{
	padding: 4px 10px;font-size: 13px;
}
.kotak_panel_detail tr:first-child td{
	padding-top: 10px;
}
.kotak_panel_detail tr:last-child td{
	padding-bottom: 15px;
}
.kotak_panel_detail tr td:first-child{font-weight: bold;vertical-align: bottom; }
.kotak_panel_detail tr td:last-child{color: #454545;}
.kotak_panel_detail tr td p{
	text-align: right;
}
.fontpanel{
	font-size: 30px;
	position: absolute;
	top:10px;
	left:120px;
	color: #fff;
	font-weight: bold;
	margin-top: 15px;
}
.panel_update{
	padding:38px 20px;text-align: left;font-weight: normal;font-size: 22px;
	margin-bottom: 0px;border-radius: 10px 10px 0px 0px;margin-top: 20px;color: #fff;
	background: linear-gradient(0deg, rgba(49, 89, 253, 0.9), rgba(49, 89, 253, 0.9)), url('image/bg-title-01.jpg');
	background-repeat: no-repeat;
	background-size: 100%;
	background-position: center;
}
.update_list{
	border-bottom: 1px solid #eee;
	padding: 22px 30px;background: #fff;
}
.update_list:hover{
	background: #f9f9f9;
}
.update_list.biru{
	border-left:4px solid #009ac8;
}
.update_list.kuning{
	border-left:4px solid #ffe66b;
}
.update_list.merah{
	border-left:4px solid #ff6696;
}
.update_list.ijo{
	border-left:4px solid #40a05e;
}
.update_list p{
	margin-bottom: 0px;font-size: 14px;color:#545454;
}
.update_list span{
	font-size: 16px; font-weight: bold;
}
.widget-header{
	margin-bottom: 10px
}
.panel_informasi{
	padding:38px 20px;text-align: left;font-weight: normal;font-size: 22px;
	margin-bottom: 0px;border-radius: 10px 10px 0px 0px;margin-top: 20px;color: #fff;
	background: linear-gradient(0deg, rgba(219, 52, 55, 0.8), rgba(219, 52, 55, 0.8)), url('image/bg-title-02.jpg');
	background-repeat: no-repeat;
	background-size: 100%;
	background-position: center;
}
.panel_jadwal{
	padding:38px 20px;text-align: left;font-weight: normal;font-size: 22px;
	margin-bottom: 0px;border-radius: 10px 10px 0px 0px;margin-top: 20px;color: #fff;
	background: linear-gradient(0deg, rgba(77, 158, 55, 0.8), rgba(77, 158, 55, 0.8)), url('image/bg-title-02.jpg');
	background-repeat: no-repeat;
	background-size: 100%;
	background-position: center;
}
.kolom_warning{
	background: #edc9c9;
	border-radius: 8px;
	padding: 12px 12px;
	margin-bottom: 10px;
	font-size: 16px;
}
.kolom_danger{
	background: #fbff3f;
	border-radius: 8px;
	padding: 12px 12px;
	margin-bottom: 10px;
	font-size: 16px;
	-webkit-animation: myanimation 1s infinite;  /* Safari 4+ */
	  -moz-animation: myanimation 1s infinite;  /* Fx 5+ */
	  -o-animation: myanimation 1s infinite;  /* Opera 12+ */
	  animation: myanimation 1s infinite;
}
@-webkit-keyframes myanimation {
  0%, 49% {
	background: #fff;
  }
  50%, 100% {
	background: #fbff3f;
  }
}
</style>
<?php
	$bulan = date('m');
	$tahun = date('Y');	
	$hariini = date('Y-m-d');	
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbgudangpkmstok = "tbgudangpkmstok_".str_replace(' ', '', $namapuskesmas);
	$gudangobatpkm = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdBarangGdgPkm) As Jumlah FROM `$tbgudangpkmstok` WHERE Stok > '0'"));
	$obatexpire = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdBarangGdgPkm) As Jumlah FROM `$tbgudangpkmstok` WHERE `Expire` < '$hariini'"));
	

?>

<div class ="row">
	<div class="col-sm-6">
		<div class="kotak_panels greens">
			<div data-toggle="modal" data-target="#modalpenerimaan">
				<i class="fa fa-arrow-down fa-3x" style="margin-top: 0px;"></i>
				<div class="fontpanel"><?php echo rupiah($gudangobatpkm['Jumlah']);?></div>
				<div class="ket">Gudang Obat Puskesmas</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="kotak_panels greens">
			<div data-toggle="modal" data-target="#modalpenerimaan">
				<i class="fa fa-arrow-down fa-3x" style="margin-top: 0px;"></i>
				<div class="fontpanel"><?php echo $obatexpire['Jumlah'];?></div>
				<div class="ket">Obat Expire</div>
			</div>
		</div>
	</div>
</div>	

<div class="row" style="margin-top: -20px;">
	<div class="col-lg-12 col-md-12">
		<div class="kotakgrafik" style="padding-bottom: 55px; margin-top: 0px;">
			<!--<canvas id="Grafik_Penerimaan_Obat" height="350px"></canvas>-->
		</div>
	</div>
</div>
<?php if($kota != 'KOTA TARAKAN'){ ?>
<div class="row">
	<div class="col-lg-12 col-md-12 divuplist">
		<h4 class="panel_informasi"><i class="fa fa-calendar"></i> Pengumuman</h4>
		<div class="widget-box">
			<div class="widget-body">
				<div class="widget-main no-padding">
					<div class="dialogs ace-scroll">
						<div class="scroll-track scroll-active" style="display: block; height: 300px;">
							<div class="scroll-bar" style="height: 234px; top: 0px;"></div>
						</div>
						<div class="scroll-content" style="max-height: 300px;">
							<?php
								$strberita = "SELECT * FROM `tbflashnews`";
								$strberita2 = $strberita." order by `TglPosting` DESC LIMIT 3";
								
								$queryberita = mysqli_query($koneksi,$strberita2);
								while($databerita = mysqli_fetch_assoc($queryberita)){
							?>
							<div class="itemdiv dialogdiv">
								<div class="user">
									<img alt="Admin" src="assets/images/avatars/avatar6.png">
								</div>
								<div class="body">
									<div class="time">
										<i class="ace-icon fa fa-clock-o"></i>
										<span class="green"><?php echo date("d-m-Y", strtotime($databerita['TglPosting']));?></span>
									</div>
									<div class="name">
										<label>Admin</label>
									</div>
									<div class="text" style="font-size: 14px;"><b><?php echo "Judul : ".$databerita['Judul'];?></b></div>
									<div class="text"><?php echo $databerita['Isi'];?></div>
									<div class="tools">
										<a href="#" class="btn btn-minier btn-info">
											<i class="icon-only ace-icon fa fa-download"></i>
										</a>
									</div>
								</div>
							</div>
							<?php
								}
							?>	
						</div>	
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>

</body>
</html>	
<!--grafik 3D-->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<!--end grafik 3D-->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/chartjsorg.js"></script>

<!--<script>
<?php
	// $kota = $_SESSION['kota'];
	// $namapuskesmas = $_SESSION['namapuskesmas'];
	// $tbgudangpkmstok = "tbgudangpkmstok_".$namapuskesmas;
			
	// if($kota == 'KOTA TARAKAN'){
		// $str_data = "SELECT NamaBarang, Stok AS Jumlah FROM `$tbgudangpkmstok`
		// ORDER BY Stok DESC LIMIT 10";
	// }else{
		// $str_data = "SELECT a.KodeBarang, a.NoBatch, c.NamaBarang, SUM(a.Jumlah) AS Jumlah FROM tbgfkpengeluarandetail a
		// JOIN tbgfkpengeluaran b ON a.Nofaktur = b.Nofaktur
		// JOIN ref_obat_lplpo c ON a.KodeBarang = c.KodeBarang
		// WHERE YEAR(b.TanggalPengeluaran) = '$tahun' AND MONTH(b.TanggalPengeluaran) = '$bulan'
		// AND b.KodePenerima = '$kodepuskesmas'
		// GROUP BY KodeBarang ORDER BY Jumlah DESC LIMIT 15";
	// }	
	// echo $str_data;
?>
var ctx = document.getElementById("Grafik_Penerimaan_Obat").getContext('2d');
var Grafik_Penerimaan_Obat = new Chart(ctx, {
	type: 'horizontalBar',
	data: {
		labels: [
				<?php   
					// $query_data = mysqli_query($koneksi, $str_data) or die(mysqli_error());       
					// while($ambil_data = mysqli_fetch_array($query_data)){
						// echo '"'.strtoupper($ambil_data['NamaBarang']).'", ';
					// } 
				?>
				],
		datasets: [{
			label: 'Data Stok Gudang Obat Puskesmas',
			data:[
				<?php
					// $query_data = mysqli_query($koneksi, $str_data) or die(mysqli_error());
					// while($ambil_data = mysqli_fetch_array($query_data)){
						// echo $ambil_data['Jumlah'].', ';
					// } 
				?>
				],
				backgroundColor: [
				<?php
				// for($i =0; $i < mysqli_num_rows($query_data); $i++){
				?>
					'rgba(14, 186, 46, 0.3)',
				<?php
				// }
				?>	
				],
			borderColor: [
			<?php
			// for($i =0; $i < mysqli_num_rows($query_data); $i++){
			?>
				'rgba(0, 127, 23, 0.6)',
			<?php
			// }
			?>
			],
			borderWidth: 2
		}]
	},
	options: {
		responsive: true,
		maintainAspectRatio: false,
		tooltips: {
		   mode: 'label',
		   label: 'mylabel',
		   callbacks: {
			   label: function(tooltipItem, data) {
				   return tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); }, },
		},
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero:true
				}
			}]
		}
	}
});

</script>-->
