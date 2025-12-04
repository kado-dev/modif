<?php
	include "config/helper_bpjs.php";
	include "config/helper_pasienrj.php";
	$tanggal = date('Y-m-d');
	$tahun = date('Y');
	$bulan = date('m');
?>
	
<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KINERJA PEGAWAI</b></h3>
			<div class="row">
				<div class="col-sm-12">
					<div class="formbg">
						<div style="margin-top: 20px;">
							<canvas id="GrafikKinerja" height="500px"></canvas>
						</div>	
					</div>
				</div><br/>
			</div>	
			<div class="text-center">
				<a href="#" class="btn btn-round btn-success btnsimpan btngrafikdetail">LIHAT DATA</i></a>
			</div><br/>

			<?php
			// tahap1, panggil data pegawai
			if($_SESSION['kodepuskesmas'] == '-'){
				$str_pegawai = "SELECT * FROM `tbpegawai`";
				$str_delete = "DELETE FROM `tbpasienperpegawaitracking` WHERE `Bulan`='$bulan' AND `Tahun`='$tahun'";
				$semuapegawai = "";
			}else{
				$str_pegawai = "SELECT * FROM `tbpegawai` WHERE `KodePuskesmas`='$kodepuskesmas'";
				$semuapegawai = "SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND";
			}	
					
			// hitung tracking tbpegawai
			mysqli_query($koneksi, "DELETE FROM `tbpasienperpegawaitracking` WHERE `KodePuskesmas`='$kodepuskesmas'");
			$query_pegawai = mysqli_query($koneksi,$str_pegawai);
			while($data_pegawai = mysqli_fetch_assoc($query_pegawai)){		
				$namapegawai = mysqli_real_escape_string($koneksi, $data_pegawai['NamaPegawai']);
				
				// pendaftaran
				$str_daftar = "SELECT COUNT(NoRegistrasi) as Jumlah FROM `$tbpasienperpegawai` WHERE ".$semuapegawai." YEAR(TanggalRegistrasi)='$tahun'	AND MONTH(TanggalRegistrasi)='$bulan' AND `Pendaftaran` = '$namapegawai'";
				$query_daftar = mysqli_query($koneksi,$str_daftar);
				$data_daftar = mysqli_fetch_assoc($query_daftar);
				
				// pelayanan
				$str_pelayanan = "SELECT COUNT(NoRegistrasi) as Jumlah FROM `$tbpasienperpegawai` WHERE ".$semuapegawai." YEAR(TanggalRegistrasi)='$tahun' AND MONTH(TanggalRegistrasi)='$bulan' AND ((`NamaPegawai1` = '$namapegawai' OR `NamaPegawai2` = '$namapegawai' OR `NamaPegawai3` = '$namapegawai' OR `Lab` = '$namapegawai' OR `Farmasi` = '$namapegawai'))";
				$query_pelayanan = mysqli_query($koneksi,$str_pelayanan);
				$data_pelayanan = mysqli_fetch_assoc($query_pelayanan);
				
				// insert tbpasienperpegawaitracking
				$jumlah_kinerja = $data_daftar['Jumlah'] + $data_pelayanan['Jumlah'];
				$str_input = "REPLACE INTO `tbpasienperpegawaitracking`(`Bulan`,`Tahun`,`NamaPegawai`, `Status`, `KodePuskesmas`, `JumlahDaftar`, `JumlahPelayanan`, `Jumlah`, `TanggalUpdate`) 
				VALUES ('$bulan','$tahun','$namapegawai','$data_pegawai[Status]','$data_pegawai[KodePuskesmas]','$data_daftar[Jumlah]','$data_pelayanan[Jumlah]','$jumlah_kinerja','$tanggal')";
				$query_input = mysqli_query($koneksi,$str_input);
			}		
			?>
			
	
			<div class="row grafikdetail hidden">	
				<div class="col-lg-12">
					<div class="table-responsive noprint">
						<table class="table-judul noprint">
							<thead>
								<tr>
									<th width="5%" rowspan="2">NO.</th>
									<th width="30%" rowspan="2">NAMA PEGAWAI</th>
									<th width="10%" rowspan="2">STATUS</th>
									<th colspan="2">JUMLAH ENTRY DATA</th>
									<th width="10%" rowspan="2">TOTAL</th>
									<th width="15%" rowspan="2">OPSI</th>
								</tr>
								<tr>
									<th width="10%">PENDAFTARAN</th>
									<th width="10%">PEMERIKSAAN</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$strall = "SELECT * FROM `tbpasienperpegawaitracking` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun' AND `Bulan`='$bulan' ORDER BY Jumlah DESC";	
								$query2 = mysqli_query($koneksi,$strall);
								while($data2=mysqli_fetch_assoc($query2)){
								$no = $no + 1;						
								?>
									<tr>
										<td align="center"><?php echo $no;?></td>
										<td align="left"><?php echo strtoupper($data2['NamaPegawai']);?></td>
										<td align="center"><?php echo $data2['Status'];?></td>
										<td align="right"><?php echo $data2['JumlahDaftar'];?></td>
										<td align="right"><?php echo $data2['JumlahPelayanan'];?></td>
										<td align="right"><?php echo $data2['Jumlah'];?></td>
										<td align="center">
											<a href="?page=lap_loket_tracking_pegawai_detail&namapgw=<?php echo $data2['NamaPegawai'];?>" class="btn btn-sm btn-round btn-info">Lihat</a>
										</td>
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
</div>	
	

<!--grafik 3D-->
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<!--end grafik 3D-->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/chartjsorg.js"></script>
<script>
<?php	
	$str = "SELECT * FROM `tbpasienperpegawaitracking` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun' AND `Bulan`='$bulan' ORDER BY Jumlah DESC LIMIT 20";			
?>
var ctx = document.getElementById("GrafikKinerja").getContext('2d');
var GrafikKinerja = new Chart(ctx, {
	type: 'horizontalBar',
	data: {
		labels: [
				<?php
					$query_kinerja= mysqli_query($koneksi,$str) or die(mysqli_error());
					while($ambil = mysqli_fetch_array($query_kinerja)){
						echo '"'.$ambil['NamaPegawai'].'", ';
					}
				?>
				],
		datasets: [{
			label: 'Top 20 Besar Kinerja Pegawai Bulan <?php echo nama_bulan($bulan);?>',
			data:[
				<?php
					$query_kinerja= mysqli_query($koneksi,$str) or die(mysqli_error());
					while($ambil = mysqli_fetch_array($query_kinerja)){
						echo '"'.$ambil['Jumlah'].'", ';
					}			
				?>
				],
				backgroundColor: [
				<?php
				for($i =0; $i < mysqli_num_rows($query_kinerja); $i++){
				?>
					'rgba(175, 238, 247, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i =0; $i < mysqli_num_rows($query_kinerja); $i++){
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

