<?php
	include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
	$tbpasienperpegawai = 'tbpasienperpegawai_'.str_replace(' ', '', $namapuskesmas);
	$tbtindakanpasien = 'tbtindakanpasien_'.str_replace(' ', '', $namapuskesmas);
	
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>TINDAKAN PASIEN</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_tindakan"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal">
						</div>
						<div class="col-xl-2">
							<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir">
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_tindakan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	if(isset($keydate1) AND isset($keydate2)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN RETRIBUSI TINDAKAN</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2))?> <?php echo $tahun;?></span>
		<br/>
	</div>

	<div class="atastabel font11">
		<div style="float:left; width:65%; margin-bottom:10px;">
			<table style="font-size:10px; width:300px;">
				<tr>
					<td style="padding:2px 4px;">Kode Puskesmas</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $kodepuskesmas;?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Puskesmas</td>
					<td style="padding:2px 4px;">:</td>
					<td style="padding:2px 4px;"><?php echo $namapuskesmas;?></td>
				</tr>
			</table><p/>
		</div>
	</div>
	
	<!--data registrasi-->
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th rowspan="2" width="3%">NO.</th>
							<th rowspan="2" width="7%">TGL.</th>
							<th rowspan="2" width="7%">NO.INDEX</th>
							<th rowspan="2" width="13%">NAMA PASIEN</th>
							<th colspan="2" width="6%">UMUR</th>
							<th rowspan="2" width="10%">ALAMAT</th>
							<th rowspan="2" width="6%">KUNJ</th>
							<th rowspan="2" width="5%">CARA BAYAR</th>
							<th rowspan="2" width="5%">PELAYANAN</th>
							<th rowspan="2" width="10%">ANAMNESA</th>
							<th rowspan="2" width="10%">DIAGNOSA</th>
							<th rowspan="2" width="10%">TINDAKAN</th>
							<th rowspan="2" width="5%">TARIF</th>
						</tr>
						<tr>
							<th>L</th>
							<th>P</th>
						</tr>
					</thead>
					<tbody style="font-size:10px;">
						<?php
						$jumlah_perpage = 50;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$waktu = "TanggalTindakan BETWEEN '$keydate1' AND '$keydate2'";
						$str_tindakan = "SELECT * FROM `$tbtindakanpasien` 
						WHERE ".$waktu;
						$str2 = $str_tindakan." GROUP BY NoRegistrasi LIMIT $mulai,$jumlah_perpage";
						// echo $str2;	
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						// untuk pagination (tadinya dibawah -> pindah keatas) untuk ambil $jumlah
						$query2 = mysqli_query($koneksi,$str_tindakan);
						$jumlah_query = mysqli_num_rows($query2);
						if(($jumlah_query % $jumlah_perpage) > 0){
							$jumlah = ($jumlah_query / $jumlah_perpage)+1;
						}else{
							$jumlah = $jumlah_query / $jumlah_perpage;
						}
						
						$query_tindakan = mysqli_query($koneksi,$str2);
						while($data_tindakan = mysqli_fetch_assoc($query_tindakan)){
							$no = $no + 1;
							$noindex = $data_tindakan['NoIndex'];
							$noregistrasi = $data_tindakan['NoRegistrasi'];
							$kodediagnosa = $data_tindakan['KodeDiagnosa'];
							$tgl_tindakan = $data_tindakan['TanggalTindakan'];
							$tarif = $data_tindakan['Tarif'];
							$idtindakan = $data_tindakan['IdTindakan'];
													
							// tbpasienrj
							$str_rj = "SELECT * FROM `$tbpasienrj` WHERE NoRegistrasi = '$noregistrasi'";
							$query_rj = mysqli_query($koneksi,$str_rj);
							$data_rj = mysqli_fetch_assoc($query_rj);
							$noindex = $data_rj['NoIndex'];
							$kelamin = $data_rj['JenisKelamin'];
							$pelayanan = $data_rj['PoliPertama'];
							
							// tbkk
							$dt_kk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Alamat`,`RT`,`RW`,`Kelurahan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'"));
							if($dt_kk['Alamat'] != ''){
								$alamat_kk = $dt_kk['Alamat']." RT.".$dt_kk['RT']." RW.".$dt_kk['RW'].", ".strtoupper($dt_kk['Kelurahan']);
							}else{
								$alamat_kk = "Alamat Belum di Inputkan";
							}
							
							// pelayanan
							if($pelayanan == "POLI UMUM"){
								$pelayanan = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
							}else{
								$pelayanan = "tb".strtolower(str_replace(' ', '', $datarujuk['PoliPertama']));
							}
							
							if($pelayanan != ''){
								$get_pemeriksaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$pelayanan` WHERE `NoPemeriksaan` = '$noregistrasi'"));
								$anamnesa = $get_pemeriksaan['Anamnesa'];
							}else{
								$anamnesa = '-';
							}
							
							// kelamin
							if($kelamin == 'L'){
								$kelamin_l = $data_rj['UmurTahun']." Th";
								$kelamin_p = '-';
							}else{
								$kelamin_p = $data_rj['UmurTahun']." Th";
								$kelamin_l = '-';
							}
							
							// cek diagnosa pasien
							$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
							$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
							while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
								$array_data[$no][] = $data_diagnosapsn['KodeDiagnosa'];
							}
							if ($array_data[$no] != ''){
								$data_dgs = implode(",", $array_data[$no]);
							}else{
								$data_dgs ="";
							}
							
							// cek tindakan
							$str_therapy = "SELECT * FROM `tbtindakan` WHERE `IdTindakan` = '$idtindakan'";
							$query_therapy = mysqli_query($koneksi, $str_therapy);
							while($dt_therapy = mysqli_fetch_array($query_therapy)){
								$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Tindakan` FROM `tbtindakan` WHERE `IdTindakan` = '$dt_therapy[IdTindakan]'"));
								$array_therapy[$no][] = $dtobat['Tindakan'];
							}
							if ($array_therapy[$no] != ''){
								$data_trp = implode(",", $array_therapy[$no]);
							}else{
								$data_trp ="";
							}
							
							?>
								<tr style="border:1px solid #000;">
									<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $no;?></td>
									<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $tgl_tindakan;?></td>
									<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo substr($noindex,-10);?></td>
									<td style="text-align:left;border:1px solid #000; padding:3px;"><?php echo $data_rj['NamaPasien'];?></td>
									<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $kelamin_l;?></td>
									<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $kelamin_p;?></td>
									<td style="text-align:left;border:1px solid #000; padding:3px;"><?php echo $alamat_kk;?></td>
									<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo strtoupper($data_rj['StatusKunjungan']);?></td>
									<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $data_rj['Asuransi'];?></td>
									<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo str_replace('POLI','',$pelayanan);?></td>
									<td style="text-align:left;border:1px solid #000; padding:3px;"><?php echo $anamnesa;?></td>
									<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $data_dgs;?></td>
									<td style="text-align:left;border:1px solid #000; padding:3px;"><?php echo strtoupper($data_trp);?></td>
									<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo rupiah($tarif);?></td>
								</tr>
								
						<?php } ?>
						<tr>
							<td colspan = "13" style="font-size:14px; font-weight: bold; text-align:center; border:1px solid #000; padding:3px;">TOTAL</td>
							<td style="font-size:14px; font-weight: bold; text-align:right; border:1px solid #000; padding:3px;">
								<?php
									$total_tdk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Tarif)AS Tarif
									FROM `$tbtindakanpasien` 
									WHERE TanggalTindakan BETWEEN '$keydate1' AND '$keydate2' AND
									(SUBSTRING(`CaraBayar`,1,4) <> 'BPJS' OR `CaraBayar` = 'PROGRAM')"));
									$total = $total_tdk['Tarif'];
									echo rupiah($total);
								?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br>
	<hr class="noprint">
	<ul class="pagination noprint">
		<?php
			//perhitungan jumlah dipindah keatas...
			for ($i=1;$i<=$jumlah;$i++){
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=lap_P2M_tindakan&bulan=$bulan&tahun=$tahun&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>	