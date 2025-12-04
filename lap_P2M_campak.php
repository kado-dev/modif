<?php
	include "otoritas.php";
	include "config/helper_pasienrj.php";
	$tanggal = date('Y-m-d');
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>CAMPAK (C1)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_campak"/>
						<div class="col-xl-3">
							<div class="tampilformdate">
								<input type="text" name="keydate1" class="form-control datepicker2" style="width:120px;float:left;margin-right:10px;" required> <input type="text" name="keydate2" class="form-control datepicker2" style="width:120px;float:left" required>
							</div>
						</div>
						<div class="col-xl-9">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_campak" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_P2M_campak_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $kodepuskesmas;?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
	<?php
	$tgl1 = $_GET['keydate1'];
	$tgl2 = $_GET['keydate2'];
	if(isset($tgl1) and isset($tgl2)){
	?>
	<div class="table-responsive noprint">
		<table class="table-judul-laporan-min">
			<thead>
				<tr style="border:1px solid #000;">
					<th rowspan="3" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">No.</th>
					<th rowspan="3" style="text-align:center;width:10%;vertical-align:middle; border:1px solid #000; padding:3px;">Nama Anak</th>
					<th rowspan="3" style="text-align:center;width:10%;vertical-align:middle; border:1px solid #000; padding:3px;">Nama Orang Tua</th>
					<th rowspan="3" style="text-align:center;width:10%;vertical-align:middle; border:1px solid #000; padding:3px;">Alamat</th>
					<th colspan="2" style="text-align:center;width:4%;border:1px solid #000; padding:3px;">Gender</th>
					<th colspan="2" style="text-align:center;width:10%;border:1px solid #000; padding:3px;">Vaksin Campak sblm Sakit</th>
					<th colspan="2" style="text-align:center;width:4%;border:1px solid #000; padding:3px;">Tgl.Timbul</th>
					<th colspan="2" style="text-align:center;width:4%;border:1px solid #000; padding:3px;">Tgl.diambil Spesimen</th>
					<th colspan="2" style="text-align:center;width:4%;border:1px solid #000; padding:3px;">Hasil Spesimen</th>
					<th colspan="1" style="text-align:center;width:3%;border:1px solid #000; padding:3px;">Diberi Vit.A</th>
					<th colspan="1" style="text-align:center;width:3%;border:1px solid #000; padding:3px;">Keadaan Akhir</th>
					<th colspan="5" style="text-align:center;width:3%;border:1px solid #000; padding:3px;">Klasifikasi Final</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th rowspan="2" style="text-align:center;width:2.5%;vertical-align:middle; border:1px solid #000; padding:3px;">L</th>
					<th rowspan="2" style="text-align:center;width:2.5%;vertical-align:middle; border:1px solid #000; padding:3px;">P</th>
					<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Berapa Kali</th>
					<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Tidak Tahu</th>
					<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Demam</th>
					<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Rash</th>
					<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Darah</th>
					<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Urin</th>
					<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Darah</th>
					<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Urin</th>
					<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">(Y/T)</th>
					<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">(H/M)</th>
					<th colspan="3" style="text-align:center;width:2.5%;vertical-align:middle; border:1px solid #000; padding:3px;">Campak</th>
					<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Rubela</th>
					<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:3px;">Bkn.Campak</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th style="text-align:center;width:2.5%; border:1px solid #000; padding:3px;">Lap(+)</th>
					<th style="text-align:center;width:2.5%; border:1px solid #000; padding:3px;">Epid</th>
					<th style="text-align:center;width:2.5%; border:1px solid #000; padding:3px;">Klinis</th>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
				<!--paging-->
				<?php
				$jumlah_perpage = 20;
				
				if($_GET['h']==''){
					$mulai=0;
				}else{
					$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}
				
				if($_GET['h'] == null || $_GET['h'] == 1){
					$no = 0;
				}else{
					$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}
				
				//tbdiagnosacampak
				$kasus = $_GET['kasus'];
				$str_campak = "SELECT * FROM `tbdiagnosacampak` WHERE `TanggalRegistrasi` BETWEEN  '$tgl1' AND '$tgl2' AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas'";
				$query_campak = mysqli_query($koneksi,$str_campak);
				while($data_campak = mysqli_fetch_assoc($query_campak)){
				$no = $no + 1;
				$noregistrasi = $data_campak['NoRegistrasi'];
				$kelamin = $data_campak['Kelamin'];
				$vaksincampak = $data_campak['VaksinCampak'];
				$klasifikasidetail = $data_campak['KlasifikasiDetail'];
				
				// tbpasienrj
				$dt_pasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoIndex` FROM $tbpasienrj WHERE NoRegistrasi = '$noregistrasi'"));
				
				//tbkk
				$strkk = "select `NamaKK`,`Alamat`,`RT`,`RW`,`Kelurahan` FROM `$tbkk` WHERE `NoIndex`='".$dt_pasienrj['NoIndex']."'";
				$querykk = mysqli_query($koneksi,$strkk);
				$datakk = mysqli_fetch_assoc($querykk);
				
				//kelamin
				if($kelamin == 'L'){
					$kelamin_l = '<span class="glyphicon glyphicon-ok"></span>';
					$kelamin_p = '-';
				}else{
					$kelamin_p = '<span class="glyphicon glyphicon-ok"></span>';
					$kelamin_l = '-';
				}
				
				//vaksincampak
				if($vaksincampak != '0'){
					$brpkali = '<span class="glyphicon glyphicon-ok"></span>';
					$tdktahu = '-';
				}else{
					$tdktahu = '<span class="glyphicon glyphicon-ok"></span>';
					$brpkali = '-';
				}
				
				//klasifikasidetail
				if($klasifikasidetail == 'Campak: Lab (+)'){
					$klasifikasidetail1 = '<span class="glyphicon glyphicon-ok"></span>';
					$klasifikasidetail2= '-';
					$klasifikasidetail3= '-';
					$klasifikasidetail4= '-';
					$klasifikasidetail5= '-';
				}elseif($klasifikasidetail == 'Campak: Epid'){
					$klasifikasidetail2= '<span class="glyphicon glyphicon-ok"></span>';
					$klasifikasidetail1 = '-';
					$klasifikasidetail3= '-';
					$klasifikasidetail4= '-';
					$klasifikasidetail5= '-';
				}elseif($klasifikasidetail == 'Campak: Klinis'){
					$klasifikasidetail3= '<span class="glyphicon glyphicon-ok"></span>';
					$klasifikasidetail1 = '-';
					$klasifikasidetail2= '-';
					$klasifikasidetail4= '-';
					$klasifikasidetail5= '-';
				}elseif($klasifikasidetail == 'Rubela Lab (+)'){
					$klasifikasidetail4= '<span class="glyphicon glyphicon-ok"></span>';
					$klasifikasidetail1 = '-';
					$klasifikasidetail2= '-';
					$klasifikasidetail3= '-';
					$klasifikasidetail5= '-';
				}elseif($klasifikasidetail == 'Bukan Campak/Rubela'){
					$klasifikasidetail5= '<span class="glyphicon glyphicon-ok"></span>';
					$klasifikasidetail1 = '-';
					$klasifikasidetail2= '-';
					$klasifikasidetail3= '-';
					$klasifikasidetail4= '-';
				}
				
				?>
					<tr style="border:1px solid #000;">
						<td style="border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="border:1px solid #000; padding:3px;"><?php echo $data_campak['NamaPasien'];?></td>
						<td style="border:1px solid #000; padding:3px;"><?php echo $datakk['NamaKK'];?></td>
						<td style="border:1px solid #000; padding:3px;"><?php echo $datakk['Alamat']." RT.".$datakk['RT']." RW.".$datakk['RW']." Ds/Kel.".$datakk['Kelurahan'];?></td>
						<td style="border:1px solid #000; padding:3px;"><?php echo $kelamin_l;?></td>
						<td style="border:1px solid #000; padding:3px;"><?php echo $kelamin_p;?></td>
						<td style="border:1px solid #000; padding:3px;"><?php echo $brpkali;?></td>
						<td style="border:1px solid #000; padding:3px;"><?php echo $tdktahu;?></td>
						<td style="border:1px solid #000; padding:3px;"><?php echo date("y/m/d", strtotime($data_campak['TanggalTimbulDemam']));?></td>
						<td style="border:1px solid #000; padding:3px;"><?php echo date("y/m/d", strtotime($data_campak['TanggalTimbulRash']));?></td>
						<td style="border:1px solid #000; padding:3px;"><?php echo date("y/m/d", strtotime($data_campak['TanggalSpesimenDarah']));?></td>
						<td style="border:1px solid #000; padding:3px;"><?php echo date("y/m/d", strtotime($data_campak['TanggalSpesimenUrin']));?></td>
						<td style="border:1px solid #000; padding:3px;"><?php echo $data_campak['HasilSpesimenDarah'];?></td>
						<td style="border:1px solid #000; padding:3px;"><?php echo $data_campak['HasilSpesimenUrin'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data_campak['VitaminA'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data_campak['KeadaanAkhir'];?></td>
						<td style="border:1px solid #000; padding:3px;"><?php echo $klasifikasidetail1;?></td>
						<td style="border:1px solid #000; padding:3px;"><?php echo $klasifikasidetail2;?></td>
						<td style="border:1px solid #000; padding:3px;"><?php echo $klasifikasidetail3;?></td>
						<td style="border:1px solid #000; padding:3px;"><?php echo $klasifikasidetail4;?></td>
						<td style="border:1px solid #000; padding:3px;"><?php echo $klasifikasidetail5;?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
	<br>
	<hr class="noprint">
	<ul class="pagination noprint">
		<?php
			$query2 = mysqli_query($koneksi,$str_campak);
			$jumlah_query = mysqli_num_rows($query2);
			
			if(($jumlah_query % $jumlah_perpage) > 0){
				$jumlah = ($jumlah_query / $jumlah_perpage)+1;
			}else{
				$jumlah = $jumlah_query / $jumlah_perpage;
			}
			for ($i=1;$i<=$jumlah;$i++){
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=lap_P2M_campak&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p><b>Kategori Kode Penyakit :</b><br>
				- Campak (B05.9)
				</p>
			</div>
		</div>
	</div>
</div>
