<!doctype html>
<html lang="en">
<head>
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
</head>
<body>
<?php
	error_reporting(0);
	session_start();
	if($kota == "KOTA TARAKAN"){
		date_default_timezone_set('Asia/Ujung_Pandang');
	}else{
		date_default_timezone_set('Asia/Jakarta');
	}
	include "config/helper_pasienrj.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$kodeppk = $_SESSION['kodeppk'];
	$kota = $_SESSION['kota'];
	$bulan = date('m');
	$tahun = date('Y');	
	$tbdiagnosapasien = 'tbdiagnosapasien_'.$bulan;
	$hariini = date('Y-m-d');
	$hariini2 = date('ymd');
	$hariini3 = date('ym');
	$keydate1 = date('Y-m-01', strtotime($hariini));
	$keydate2 = date('Y-m-t', strtotime($hariini));

	if($_GET['statuspasien'] != ""){		
		$statuspasien = " AND StatusPasien = '$_GET[statuspasien]'";
	}else{
		$statuspasien = "";
	}

	$kunj_hari = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj)AS Jumlah FROM `$tbpasienrj` WHERE date(TanggalRegistrasi) = curdate()".$statuspasien));
	$kunj_bulan = mysqli_num_rows(mysqli_query($koneksi, "SELECT DISTINCT `IdPasienrj` FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan'".$statuspasien));
	$kunj_tahun = mysqli_num_rows(mysqli_query($koneksi, "SELECT DISTINCT `IdPasienrj` FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun'".$statuspasien));
?>

<div class="tableborderdiv">
	<div class ="row">
		<?php
			// pasien belum dientry bulan ini
			$str_blm ="SELECT COUNT(IdPasienrj)AS Jumlah FROM `$tbpasienrj`
			WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan'
			and StatusPelayanan='Antri' AND `AsalPasien`='10' AND `StatusPasien`='1'";
			$query_blm = mysqli_query($koneksi, $str_blm);
			$data_pasien_blm = mysqli_fetch_assoc($query_blm);
			
			// notif jika ada data gagal bridging (StatusPasin(2) KunjunganSehat, Statuspulang(3) Berobat Jalan)
			$strbridging = "SELECT  COUNT(*) AS Jumlah FROM $tbpasienrj WHERE YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' 
			AND `Asuransi` LIKE '%BPJS%' AND `StatusPasien` <> '2' AND `StatusPelayanan`='Sudah' AND `StatusPulang`='3' 
			AND (`NoKunjunganBpjs` = '' OR LENGTH(`NoKunjunganBpjs`) = '3' OR LENGTH(`NoKunjunganBpjs`) = '1' OR `NoKunjunganBpjs` = '0') AND `PoliPertama` != 'POLI LABORATORIUM'";
			// echo $strbridging;
			$dtbridging = mysqli_fetch_assoc(mysqli_query($koneksi, $strbridging));
		
			if($data_pasien_blm['Jumlah'] > 0){
		?>
		<div class="col-sm-12">
			<a href="?page=pasien_belum_entry" style="color: #000;"><div class="kolom_danger" style="cursor:pointer;"><i class="fa fa-user">&nbsp&nbsp</i><?php echo round($data_pasien_blm['Jumlah'],0)." Pasien belum dientry dipemeriksaan"?></div></a>
		</div>
		<?php
			}
			if ($dtbridging['Jumlah'] > 0){
				if($kota != "KABUPATEN GARUT"){
		?>
		<div class="col-sm-12">
			<div class="kolom_warning">	
				<i class="fa fa-warning"></i>
				 <?php echo $dtbridging['Jumlah']." Data Gagal Bridging Pemeriksaan";?><a href="#" style="color: #B74635" class="btndetailbridging"><b>  >>Lihat data</b></a>
			</div>
		</div>
		<?php
				}
			}
		?>
		<div class="col-sm-12">
			<div class="detailbridging " style="display:none; clear:both; margin-bottom:30px;">
				<div class="sidebars">
					<div class="table-responsive">
						<table class=" table-judul" width="100%">
							<thead>
								<tr>
									<th width='5%'>NO.</td>
									<th width='15%'>BULAN</td>
									<th width='65%'>PELAYANAN</td>
									<th width='5%'>JUMLAH</td>
									<th width='10%'>#</td>
								</tr>
							</thead>
							<tbody>
								<?php
									$no = 0 ;
									$strbridgings = "SELECT PoliPertama, COUNT(NoRegistrasi) AS Jumlah FROM $tbpasienrj WHERE YEAR(TanggalRegistrasi)='$tahun' 
									AND MONTH(TanggalRegistrasi)='$bulan' AND `Asuransi` like '%BPJS%' AND `StatusPasien` <> '2' AND `StatusPelayanan`='Sudah' 
									AND `StatusPulang`='3' AND (`NoKunjunganBpjs` = '' OR LENGTH(`NoKunjunganBpjs`) != '19' OR LENGTH(`NoKunjunganBpjs`) = '1' 
									OR `NoKunjunganBpjs` = '0') AND `PoliPertama` != 'POLI LABORATORIUM' GROUP BY PoliPertama";
									// echo $strbridgings;
									$query_bridging = mysqli_query($koneksi,$strbridgings);
									while($databridging = mysqli_fetch_assoc($query_bridging)){
										$no = $no +1;
										?>
										<tr>								
											<td style="text-align:right;"><?php echo $no;?></td>
											<td style="text-align:center;"><?php echo nama_bulan(date('m'))." ".date('Y');?></td>
											<td style="text-align:left;"><?php echo $databridging['PoliPertama'];?></td>
											<td style="text-align:center;"><span class="badge badge-danger"><?php echo $databridging['Jumlah'];?></span></td>
											<td style="text-align:center;"><a href="?page=poli_antri_bridging_bulan_pemeriksaan&bulan=<?php echo $bulan;?>&tahun=<?php echo $tahun;?>&pelayanan=<?php echo $databridging['PoliPertama'];?>&statuspasien=semua" class="btn btn-sm btn-white" target="_blank">Lihat</a></td>
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


	<div class="space-4"></div>
	<div class ="row">
		<div class="col-sm-4">
			<div class="kotak_panels greens">
				<div data-toggle="modal" data-target="#modalpenerimaan">
					<i class="fa fa-arrow-down fa-3x" style="margin-top: 0px;"></i>
					<div class="fontpanel"><?php echo $kunj_hari['Jumlah'];?></div>
					<div class="ket">Kunjungan hari ini</div>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="kotak_panels greens">
				<div data-toggle="modal" data-target="#modalpenerimaan">
					<i class="fa fa-arrow-down fa-3x" style="margin-top: 0px;"></i>
					<div class="fontpanel"><?php echo rupiah($kunj_bulan);?></div>
					<div class="ket">Kunjungan bulan <?php echo nama_bulan(date('m'));?></div>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="kotak_panels greens">
				<div data-toggle="modal" data-target="#modalpenerimaan">
					<i class="fa fa-arrow-down fa-3x" style="margin-top: 0px;"></i>
					<div class="fontpanel"><?php echo rupiah($kunj_tahun);?></div>
					<div class="ket">Kunjungan tahun <?php echo date('Y');?></div>
				</div>
			</div>
		</div>
	</div>

	<div class ="row">
		<div class="col-sm-12">
			<div class="kotakgrafik" style="margin-top: 5px;">
				<form class="form-inline formcari">
					<?php
						if($_GET['bulan'] == null){
							$bln = date('m');
						}else{
							$bln = $_GET['bulan'];
						}	
					?>
					<input type="hidden" name="page" value="dashboard_puskesmas"/>
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
					
					<select name="statuspasien" class="form-control" onchange="this.form.submit();">
						<option value="">Semua</option>
						<option value="1" <?php if($_GET['statuspasien'] == '1'){echo "SELECTED";}?>>Kunjungan Sakit</option>
						<option value="2" <?php if($_GET['statuspasien'] == '2'){echo "SELECTED";}?>>Kunjungan Sehat</option>
					</select>
				</form>
				<div class="au-card m-b-30">
					<div class="au-card-inner">
						<canvas id="Grafik_Kunjungan" height="270px"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class ="row">
		<div class="col-lg-6 col-md-6 divuplist">
			<h4 class="panel_update"><i class="fa fa-calendar"></i> Update & Maintenance Simpus</h4>
			<?php
				$no = 0;
				$warna = array('merah','biru','kuning','ijo');
				$strberita = "SELECT * FROM `tbupdatesimpus`";
				$strberita2 = $strberita." order by `TanggalUpdate` DESC LIMIT 3";
				
				$queryberita = mysqli_query($koneksi, $strberita2);
				while($databerita = mysqli_fetch_assoc($queryberita)){
			?>
				<div class="update_list <?php echo $warna[$no];?>">
					<span style=""><?php echo strtoupper($databerita['Judul']).", V.".$databerita['Versi'];?></span>
					<p><?php echo "(".strtoupper($databerita['Kategori']).")";?></p>
					<p><?php echo $databerita['Deskripsi'];?></p>
					<p><?php echo date("d-m-Y", strtotime($databerita['TanggalUpdate']));?></p>
				</div>
			<?php
				$no = $no + 1;
				if($no == 4){
					$no = 0;
				}
			}
			?>
			<div class="update_list">
				<a href="?page=adm_update_simpus" class="btndefault" style="width:200px; margin:0 auto;">Detail</a>
			</div>
		</div>
		<!--<div class="col-lg-4 col-md-4 divuplist">
			<h4 class="panel_informasi"><i class="fa fa-calendar"></i> Informasi</h4>
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
		</div>-->
		<div class="col-lg-6 col-md-6 divuplist">
			<h4 class="panel_jadwal"><i class="fa fa-calendar"></i> Jadwal ke Puskesmas</h4>
			<div class="widget-box">
				<?php include "kalender.php"; ?>
			</div>
			<div class="update_list">
				<p>
					<b>Keterangan :</b><br/>
					Untuk jadwal evaluasi simpus di Puskesmas silahkan tentukan jadwal dan bersurat ke Sub Bagian Program, Informasi dan Humas (PIH) Dinas Kesehatan. <br/>
					>> <a href="dok/permohonan narasumber.pdf" target="_blank" style="color: #000;"><b>Download Contoh Surat</b></a> <<
				</p>
			</div>
		</div>
	</div>
</div>
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

<script>
$(".btndetailbridging").click(function(){
	if ( $( ".detailbridging" ).is( ":hidden" ) ) {
		$(".detailbridging").slideDown();
	}else{
		$(".detailbridging").slideUp();
	}
});
$(".tdkalender").click(function(){
	var isi = $(this).data('keterangan');
	var tgl = $(this).data('tgl');
	if(isi != ''){
		//alert(isi);
		$(".modalisi").html(isi+"<br/>"+tgl);
		$('#flashmodal').modal('show');
	}
});

var ctx = document.getElementById("Grafik_Kunjungan").getContext('2d');
var Grafik_Kunjungan = new Chart(ctx, {
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
			label: 'Jumlah Kunjungan Pasien',
			data:[
				<?php
					$jml = 0;		
									
					for($d = $mulai; $d <= $selesai; $d++){	
						$tanggal = $tahun."-".$bln."-".$d;
						$query_retribusi = mysqli_query($koneksi,"SELECT COUNT(`NoRegistrasi`) AS JumlahKunjungan FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tanggal'".$statuspasien);
						$jml = mysqli_fetch_assoc($query_retribusi);
						if ($jml['JumlahKunjungan'] != 0){
							$jml_kunj =  $jml['JumlahKunjungan'];
						}else{
							$jml_kunj = 0;
						}
						echo '"'.$jml_kunj.'", ';
					}		
				?>
				],
				backgroundColor: [
				<?php
				for($i = $mulai; $i <= $selesai; $i++){
				?>
					'rgba(14, 186, 46, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i = $mulai; $i <= $selesai; $i++){
			?>
				'rgba(0, 127, 23, 1)',
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

// $('.flashnewsbtn').click(function(){
// 	var isi = $(this).parent().find(".isinews").html();
// 	$(".modalisi").html(isi);
// 	$('#flashmodal').modal('show');
// });	
</script>

<div class="modal fade" id="flashmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"> Info</h4>
			</div>
			<div class="modal-body modalisi">
			
			</div>
		</div>
	</div>
</div>
