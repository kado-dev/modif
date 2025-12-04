<?php
	// include "config/helper_pasienrj.php";
	$tahun = date('Y');	
	$bulan = date('m');	
	$hariini = date('Y-m-d');
	$hariini2 = date('ymd');
	$hariini3 = date('ym');
	$namapuskesmas = $_GET['namapuskesmas'];

	if($namapuskesmas == ''){
		$namapuskesmas = $_SESSION['namapuskesmas'];
		$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
	}else{
		$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
	}
	
	if($_GET['bulan'] == null){
		$bln = date('m');
	}else{
		$bln = $_GET['bulan'];
	}	

	// encounter
    $hariini = date('Y-m-d');
    $str_encounter = "SELECT count(*)AS Jml FROM `$tbpasienrj` WHERE date(TanggalRegistrasi) = '$hariini' AND `IdKunjunganSatuSehat`!=''";	
    $cek_jumlah_encounter = mysqli_fetch_assoc(mysqli_query($koneksi, $str_encounter));		

	// condition
    $str_condition = "SELECT count(*)AS Jml FROM `$tbpasienrj` WHERE date(TanggalRegistrasi) = '$hariini' AND `IdConditionSatuSehat`!=''";	
    $cek_jumlah_condition = mysqli_fetch_assoc(mysqli_query($koneksi, $str_condition));		

?>

<style>
	 /* Mengatur styling untuk tabel */
	 table {
		width: 96%; /* Lebar tabel */
		margin: 5px auto; /* Posisikan tabel di tengah */
		border-collapse: collapse; /* Menggabungkan border agar terlihat lebih bersih */
		box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Memberikan bayangan lembut */
	}

	/* Styling untuk border tabel */
	th, td {
		padding: 12px 15px; /* Ruang di dalam sel */
		text-align: left; /* Menata teks ke kiri */
		border: 1px solid #ddd; /* Border tipis dan ringan */
	}

	/* Warna strip pada baris ganjil */
	tr:nth-child(odd) {
		background-color: #f9f9f9; /* Warna latar belakang untuk baris ganjil */
	}

	/* Hover pada baris */
	tr:hover {
		background-color: #f1f1f1; /* Efek hover untuk baris */
	}

	/* Styling untuk header tabel */
	th {
		background-color: #deebfc; /* Warna latar belakang untuk header */
		color: Black; /* Warna teks header */
		/* text-transform: uppercase; Mengubah teks header menjadi kapital */
		font-weight: bold; /* Menebalkan teks header */
	}

	/* Styling untuk border bawah header */
	th, td {
		border-bottom: 2px solid #ddd;
	}

	/* Styling untuk border saat hover di header */
	th:hover {
		background-color: #f1f1f1; /* Warna header sedikit lebih gelap saat hover */
	}
	
	.kotak_panels{
		padding: 25px 20px;
		border-radius: 6px;
		margin-top: 15px;
		margin-bottom: 15px;
	}
	.bg{
		background: linear-gradient(0deg, rgba(178, 212, 255, 0.7), rgba(255, 255, 255, 0.9));
		background-repeat: no-repeat;
		background-size: 100%;
		background-position: center;
		box-shadow: 0 5px 10px -5px #848484;
	}
	.greens{
		background: linear-gradient(0deg, rgba(28, 126, 255, 0.9), rgba(0, 87, 201, 0.9));
		background-repeat: no-repeat;
		background-size: 100%;
		background-position: center;
		box-shadow: 0 5px 10px -5px #848484;
	}
	.fontpanel{
		font-size: 30px;
		color: #fff;
		font-weight: bold;
	}
	.fontpanel-min{
		font-size: 16px;
		color: #fff;
	}
</style>

<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-2">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white fw-bold mt-2"><i class="icon-people"></i> KIRIM DATA SATU SEHAT</h2>
			</div>
		</div>
	</div>
</div>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="kotak_panels bg">
				<form class="form">
					<div class = "row">
						<div class="col-sm-12">
							<input type="hidden" name="page" value="dashboard_satusehat"/>
							<select name="namapuskesmas" class="form-control" onchange="this.form.submit();">
								<option value="">--Pilih Puskesmas--</option>
								<?php 
									$query_puskesmas = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmasdetail` ORDER BY NamaPPK ASC");
									while($dtpuskesmas = mysqli_fetch_assoc($query_puskesmas)){
										if($dtpuskesmas['NamaPPK'] == $_GET['namapuskesmas']){
											echo "<option value='$dtpuskesmas[NamaPPK]' SELECTED>$dtpuskesmas[NamaPPK]</option>";
										}else{
											echo "<option value='$dtpuskesmas[NamaPPK]'>$dtpuskesmas[NamaPPK]</option>";
										}
									}
								?>
							</select>							
						</div><br/>						
						<!-- <div class="col-sm-6">
							<input type="text" name="keydate1" class="form-control datepicker2" style="width:170px;float:left;margin-right:10px;" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal"> <input type="text" name="keydate2" class="form-control datepicker2" style="width:170px;float:left;margin-right:10px;" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
						</div>	 -->
					</div>	
					<!-- <div class="row noprint">
						<div class="col-sm-6">
							<a href="#" style="cursor:pointer; text-decoration: none;" class="btndetail_encounter">
								<div class="kotak_panel greens">
									<div class="fontpanel"><?php //echo rupiah($cek_jumlah_encounter['Jml']);?></div>
									<div class="fontpanel-min">Jumlah Encounter Hari Ini</div>
								</div>
							</a>
						</div>
						<div class="col-sm-6">
							<a href="#" style="cursor:pointer; text-decoration: none;" class="btndetail_condition">
								<div class="kotak_panel greens">				
									<div class="fontpanel"><?php //echo rupiah($cek_jumlah_condition['Jml']);?></div>
									<div class="fontpanel-min">Jumlah Condition Hari Ini</div>
								</div>
							</a>
						</div>
					</div><br/> -->
					
					<!--tabel encounter-->
					<!-- <div class="detail_encounter col-lg-12" style="<?php //if($_GET['tglreg1'] == null){echo 'display:none;';}?>clear:both">
						<div class="row">
							<div class="table-responsive">
								<table class="table-judul" width="100%">
									<thead>
										<tr>
											<th width="5%">NO.</th>
											<th width="10%">KODE</th>
											<th width="80%">NAMA PUSKESMAS</th>
											<th width="5%">#</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										// if($_GET['tglreg1']==''){
										// 	$caritanggal = " AND date(TanggalRegistrasi) = curdate()"; 
										// }else{
										// 	$caritanggal = " AND date(TanggalRegistrasi)= '$_GET[tglreg1]'";
										// }	
										
										// $str = "SELECT `KodePuskesmas`,`NamaPPK` FROM `tbpuskesmasdetail`";
										// $str2 = $str." ORDER BY `NamaPPK`";
																
										// $query = mysqli_query($koneksi, $str2);
										// while($datapkm = mysqli_fetch_assoc($query)){
										// 	$no = $no + 1;
										// 	$kodepuskesmas = $datapkm['KodePuskesmas'];
										// 	$namapuskesmas = $datapkm['NamaPPK'];
										// ?>	
										<tr>
											<td align="center"><?php //echo $no;?></td>
											<td align="left"><?php //echo $kodepuskesmas;?></td>
											<td align="left"><?php //echo $namapuskesmas;?></td>
											<td align="center">
												<button class="btn btn-round btn-info btnaksi" data-noreg="<?php //echo $noregistrasi;?>" data-pkm="<?php echo $namapuskesmas;?>"  data-sts="dskasir">LIHAT</button>
											</td>
										</tr>
										<?php
										//}						
										?>
									</tbody>
								</table><br/>	
							</div>
						</div>
					</div> -->
					
					<!--menghitung condition-->
					<!-- <div class="detail_condition col-lg-12" style="<?php //if($_GET['tglreg'] == null){echo 'display:none;';}?>clear:both">
						<div class="row"><br/>
							<div class="table-responsive">
								<table class="table-judul" width="100%">
									<thead>
										<tr>
											<th width="5%">NO.</th>
											<th width="10%">KODE</th>
											<th width="80%">NAMA PUSKESMAS</th>
											<th width="5%">#</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										// $jumlah_perpage = 10;
										// $tglreg1 = $_GET['tglreg1'];
										// if($_GET['h']==''){
										// 	$mulai=0;
										// }else{
										// 	$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
										// }
										
										// if($_GET['tglreg1']==''){
										// 	$caritanggal = " AND date(TanggalRegistrasi) = curdate()"; 
										// }else{
										// 	$caritanggal = " AND date(TanggalRegistrasi)= '$_GET[tglreg1]'";
										// }	
										
										// $str = "SELECT `KodePuskesmas`,`NamaPPK` FROM `tbpuskesmasdetail`";
										// $str2 = $str."ORDER BY `NamaPPK` LIMIT $mulai,$jumlah_perpage";
										// echo $str2;					
										// if($_GET['h'] == null || $_GET['h'] == 1){
										// 	$no = 0;
										// }else{
										// 	$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
										// }
										
										// $query = mysqli_query($koneksi, $str2);
										// while($datapkm = mysqli_fetch_assoc($query)){
										// 	$no = $no + 1;
										// 	$kodepuskesmas = $datapkm['KodePuskesmas'];
										// 	$namapuskesmas = $datapkm['NamaPPK'];
										?>	
										<tr>
											<td align="center"><?php //echo $no;?></td>
											<td align="left"><?php //echo $kodepuskesmas;?></td>
											<td align="left"><?php //echo $namapuskesmas;?></td>
											<td align="center">
												<button class="btn btn-round btn-info btnaksi" data-noreg="<?php //echo $noregistrasi;?>" data-pkm="<?php echo $namapuskesmas;?>"  data-sts="dskasir">LIHAT</button>
												<a class="btn btn-round btn-info" href="index.php?page=satusehat_condition_export&namapuskesmas=<?php echo $namapuskesmas;?>" target="_blank">LIHAT</a>
											</td>
										</tr>
										<?php
										//}						
										?>
									</tbody>
								</table>
							</div>
						</div><br/>
					</div> -->

					<!--tabel lihat data-->
					<div class="row">
						<?php	
						date_default_timezone_set('Asia/Jakarta'); // Set timezone ke Jakarta

						// Fungsi untuk menghitung minggu dalam bulan
						function mingguDalamBulan($tahun, $bulan) {
							$tanggalPertamaBulan = strtotime("$tahun-$bulan-01"); // Mendapatkan timestamp tanggal pertama bulan
							$jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); // Jumlah hari dalam bulan tersebut
							
							$minggu = [];
							$mingguKe = 1; // Mulai dari minggu pertama
						
							// Loop untuk membagi hari menjadi minggu
							for ($hari = 1; $hari <= $jumlahHari; $hari++) {
								$tanggal = strtotime("$tahun-$bulan-$hari");
								
								// Tentukan hari dalam minggu (0 = Minggu, 1 = Senin, ..., 6 = Sabtu)
								$hariDalamMinggu = date("w", $tanggal);
								
								// Tentukan tanggal pertama dan terakhir dalam minggu
								if ($hariDalamMinggu == 0) { // Jika hari Minggu
									$tanggalAkhirMinggu = date("Y-m-d", strtotime("+7 days", $tanggal));
									$tanggalAwalMinggu = date("Y-m-d", strtotime("1 days", $tanggal));
									$minggu[$mingguKe] = [
										'minggu_ke' => $mingguKe,
										'awal' => $tanggalAwalMinggu,
										'akhir' => $tanggalAkhirMinggu
									];
									$mingguKe++; // Pindah ke minggu berikutnya
								}
							}
						
							return $minggu;
						}
						
						// Mendapatkan minggu dalam bulan Desember 2024
						$tahun = date('Y');
						$bulan = date('m'); // Bulan saat ini
						$minggu = mingguDalamBulan($tahun, $bulan);

						// Tampilkan hasil dalam tabel HTML
						echo "<table border='1'>";
						echo "<tr><th>Minggu</th><th>Mulai</th><th>Selesai</th><th>Encounter</th><th>Condition</th></tr>";

						$no = 1;
						foreach ($minggu as $data) {
							// Batasi hanya sampai minggu ke-4
							if ($no > 4) break;

							// tbpasienrajal
							$dt_encounter = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj)AS Jumlah FROM `$tbpasienrj` WHERE date(TanggalRegistrasi) BETWEEN '$data[awal]' AND '$data[akhir]' AND `IdKunjunganSatuSehat` != ''"));
							$dt_condition = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj)AS Jumlah FROM `$tbpasienrj` WHERE date(TanggalRegistrasi) BETWEEN '$data[awal]' AND '$data[akhir]' AND `IdConditionSatuSehat` != ''"));

							echo "<tr>";
							echo "<td>Minggu ke-$no</td>";
							echo "<td>" . $data['awal'] . "</td>";
							echo "<td>" . $data['akhir'] . "</td>";
							echo "<td>" . $dt_encounter['Jumlah'] . "</td>";
							echo "<td>" . $dt_condition['Jumlah'] . "</td>";
							echo "</tr>";

				
							$no++;
						}

						echo "</table>";
						?>
					</div>
					<div class="au-card m-b-30">					
						<div class="au-card-inner">
							<canvas id="Grafik_Kujungan_Bulan" height="270px"></canvas>
						</div>
					</div>
				</form>
			</div>
		</div>		
	</div>
	
	
	<!--grafik bulan-->
	<div class="row noprint" style="margin-top: -20px;">
		<div class="col-sm-12">
			<div class="kotak_panels bg">
				<div class="au-card m-b-30">
					<div class="au-card-inner">
						<canvas id="Grafik_Kujungan_Tahun" height="270px"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="formbg">
		<p>
			<b>Informasi :</b><br/>
			Dashboard Pemantauan Aliran Data SATUSEHAT (Detail Perhitungan) <a href="https://satusehat.kemkes.go.id/data/dashboard/615eb4d6-dda8-4c00-9468-fdac23812eae" style='color:#005184;font-weight:bold'>Lihat</a>
		</p>
	</div>
</div>



<!--end grafik 3D-->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/chartjsorg.js"></script>
<script>

$(".btndetail_encounter").click(function(){
	$( ".detail_condition" ).hide();
	if ( $( ".detail_encounter" ).is( ":hidden" ) ) {
		$(".detail_encounter").slideDown();
	}else{
		$(".detail_encounter").slideUp();
	}
});

$(".btndetail_condition").click(function(){
	$( ".detail_encounter" ).hide();
	if ( $( ".detail_condition" ).is( ":hidden" ) ) {
		$(".detail_condition").slideDown();
	}else{
		$(".detail_condition").slideUp();
	}
});

var ctx = document.getElementById("Grafik_Kujungan_Bulan").getContext('2d');
var Grafik_Kujungan_Bulan = new Chart(ctx, {
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

			
		datasets: [
			{
				label: 'Jumlah Kunjungan (Encounter)',
				data:[
					<?php
						$jml = 0;		
										
						for($d = $mulai; $d <= $selesai; $d++){	
							$tanggal = $tahun."-".$bln."-".$d;
							$query_retribusi = mysqli_query($koneksi,"SELECT COUNT(`IdPasienrj`) AS Jml FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tanggal' AND `IdKunjunganSatuSehat`!=''");
							$jml = mysqli_fetch_assoc($query_retribusi);
							if ($jml['Jml'] == 0){
								$jml_encounter =  $jml['Jml'];
							}else{
								$jml_encounter =  $jml['Jml'];
							}
							echo '"'.$jml_encounter.'", ';
						}		
					?>
					],
				backgroundColor: [ <?php for($i = $mulai; $i <= $selesai; $i++){ ?> 'rgba(98, 165, 247, 0.9)', <?php } ?> ],
				borderColor: [ <?php for($i = $mulai; $i <= $selesai; $i++){ ?> 'rgba(0, 103, 206, 1)', <?php } ?> ],
				borderWidth: 3
			},

			{
				label: 'Jumlah Diagnosa (Condition)',
				data:[
					<?php
						$jml = 0;		
										
						for($d = $mulai; $d <= $selesai; $d++){	
							$tanggal = $tahun."-".$bln."-".$d;
							$query_retribusi = mysqli_query($koneksi,"SELECT COUNT(`IdPasienrj`) AS Jml FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`) = '$tanggal' AND `IdConditionSatuSehat`!=''");
							$jml = mysqli_fetch_assoc($query_retribusi);
							if ($jml['Jml'] == 0){
								$jml_encounter =  $jml['Jml'];
							}else{
								$jml_encounter =  $jml['Jml'];
							}
							echo '"'.$jml_encounter.'", ';
						}		
					?>
					],
				backgroundColor: [ <?php for($i = $mulai; $i <= $selesai; $i++){ ?> 'rgba(29, 214, 42, 0.9)', <?php } ?> ],
				borderColor: [ <?php for($i = $mulai; $i <= $selesai; $i++){ ?> 'rgba(0, 147, 9, 1)', <?php } ?> ],
				borderWidth: 3
			}
		]		
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

var ctx = document.getElementById("Grafik_Kujungan_Tahun").getContext('2d');
var Grafik_Kujungan_Tahun = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: [
				<?php
					$hariini = date('Y-m-d');
					$strpuskesmas = "SELECT * FROM `tbpuskesmasdetail` ORDER BY `NamaPPK`";
					$querypuskesmas = mysqli_query($koneksi, $strpuskesmas);
					while($datapuskesmas = mysqli_fetch_assoc($querypuskesmas)){					
						echo '"'.$datapuskesmas['NamaPPK'].'", ';					
					}
				?>
				],
		datasets: [
			{
				label: 'Kunjungan (Encounter) Bulan Ini',
				data: [<?php
				$hariini = date('Y-m-d');
				$strpuskesmas = "SELECT * FROM `tbpuskesmasdetail` ORDER BY `NamaPPK`";
				$querypuskesmas = mysqli_query($koneksi, $strpuskesmas);
				while($datapuskesmas = mysqli_fetch_assoc($querypuskesmas)){					
					// tbpasienrj
					$namapuskesmas = $datapuskesmas['NamaPPK'];
					$tbpasienrj = 'tbpasienrj_'.str_replace(' ', '', $namapuskesmas);
					$dtpasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT count(IdPasienrj) AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND  MONTH(TanggalRegistrasi)='$bulan' AND `IdKunjunganSatuSehat`!=''"));
					echo $dtpasienrj['Jml'].', ';
				}
				?>],
				backgroundColor: [ <?php for($i = $mulai; $i <= $selesai; $i++){ ?> 'rgba(98, 165, 247, 0.9)', <?php } ?> ],
				borderColor: [ <?php for($i = $mulai; $i <= $selesai; $i++){ ?> 'rgba(0, 103, 206, 1)', <?php } ?> ],
				borderWidth: 3
			},
			
			{
				label: 'Diagnosa (Condition) Bulan Ini',
				data: [<?php
				$hariini = date('Y-m-d');
				$strpuskesmas = "SELECT * FROM `tbpuskesmasdetail` ORDER BY `NamaPPK`";
				$querypuskesmas = mysqli_query($koneksi, $strpuskesmas);
				while($datapuskesmas = mysqli_fetch_assoc($querypuskesmas)){					
					// tbpasienrj
					$namapuskesmas = $datapuskesmas['NamaPPK'];
					$tbpasienrj = 'tbpasienrj_'.str_replace(' ', '', $namapuskesmas);
					$dtpasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT count(IdPasienrj) AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi)='$tahun' AND  MONTH(TanggalRegistrasi)='$bulan' AND `IdConditionSatuSehat`!=''"));
					echo $dtpasienrj['Jml'].', ';
				}
				?>],
				backgroundColor: [ <?php for($i = $mulai; $i <= $selesai; $i++){ ?> 'rgba(29, 214, 42, 0.9)', <?php } ?> ],
				borderColor: [ <?php for($i = $mulai; $i <= $selesai; $i++){ ?> 'rgba(0, 147, 9, 1)', <?php } ?> ],
				borderWidth: 3
			}
		]
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