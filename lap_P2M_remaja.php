<?php
	// include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
?>

<style>
.tr, th{
	text-align:center;
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
.printbody{
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	display:none;
	margin-top:10px;
}
.bawahtabel{
	margin-top:10px;
	margin-bottom:10px;
	margin-left:-50px;
	margin-right:0px;
	display:none;
}
.font10{
	font-size:10px;
	font-family: "Tahoma";
}
.font11{
	font-size:11px;
	font-family: "Tahoma";
}
.font14{
	font-size:14px;
	font-family: "Tahoma";
}


@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
	}
	.printheader{
		display:block;
	}
	.printbody{
		display:block;
	}
	.atastabel{
		display:block;
	}
	.bawahtabel{
		display:block;
	}
}
</style>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER KESEHATAN REMAJA (USIA 10-18 TAHUN)</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_P2M_remaja"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal" required>
						</div>
						<div class="col-xl-2">
							<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir" required>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_remaja" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_P2M_remaja_excel.php?keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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

	if(isset($keydate1) and isset($keydate2)){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER KESEHATAN REMAJA</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2))?> <?php echo $tahun;?></span>
		<br/>
	</div>

	<!--data registrasi-->
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%"><!--style="width:1750px"-->
					<thead>
						<tr>
							<th width="3%" rowspan="2">NO.</th>
							<th width="7%" rowspan="2">TANGGAL</th>
							<th width="10%" rowspan="2">NAMA PASIEN</th>
							<th width="8%" colspan="2">UMUR</th>
							<th width="5%" rowspan="2">KUNJ.</th>
							<th width="8%" rowspan="2">ALAMAT</th>
							<th width="8%" rowspan="2">KLASIFIKASI<br/>DIAGNOSIS</th>
							<th width="8%" colspan="5">TATA LAKSANA</th>
							<th width="8%" colspan="3">ASAL KASUS</th>
							<th width="8%" rowspan="2">KET.</th>
						</tr>
						<tr>
							<th>L</th>
							<th>P</th>
							<th>MEDIS</th><!--Tatalaksana-->
							<th>KIE/<br/>PENYULUHAN</th>
							<th>PKHS</th>
							<th>KONSELING</th>
							<th>RUJUK</th>
							<th>DATANG SENDIRI</th><!--Asal Kasus-->
							<th>HASIL PENJARINGAN</th>
							<th>RUJUKAN</th>
						</tr>
					</thead>
					<tbody style="font-size: 12px;">
						<?php
						$jumlah_perpage = 50;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$waktu = "date(TanggalRegistrasi) BETWEEN '$keydate1' AND '$keydate2'";
						$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
						$tbpasienrj2 = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
						$tbpasienperpegawai='tbpasienperpegawai_'.$kodepuskesmas;
						$tbpasienperpegawai2='tbpasienperpegawai_'.$kodepuskesmas;
						
						$str = "SELECT * FROM `$tbpasienrj`
								WHERE ".$waktu." and `UmurTahun` BETWEEN '10' AND '18' AND `StatusPelayanan`='Sudah'";
						$str2 = $str." GROUP BY NoRegistrasi ORDER BY `TanggalRegistrasi` DESC LIMIT $mulai,$jumlah_perpage";
						// echo $str2;
						// die();
										
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$noregistrasi = $data['NoRegistrasi'];
							$noindex = $data['NoIndex'];
							$anamnesa = $data['Anamnesa'];
							$kelamin = $data['JenisKelamin'];
							
							// norm
							if($kota == "KABUPATEN GARUT"){
								$norm = $data['NoRM'];
							}else{
								$norm = $data['NoIndex'];
							}	
																			
							// tbkk
							$str_kk = "SELECT `NamaKK`, `Alamat`, `RT`, `No`, `Kelurahan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
							$query_kk = mysqli_query($koneksi,$str_kk);
							$data_kk = mysqli_fetch_assoc($query_kk);
							$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", NO.".$data_kk['No']." ".$data_kk['Kelurahan'];
							
							// tbdiagnosapasien
							$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
							$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregistrasi'";
							$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
							while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
								$data_diagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
								$array_diagnosa[$no][] = $data_diagnosapsn['KodeDiagnosa']; //."-".$data_diagnosa['Diagnosa']
							}
							if ($array_diagnosa[$no] != ''){
								$data_dgs = implode(",", $array_diagnosa[$no]);
							}else{
								$data_dgs ="";
							}
							
							// resep
							$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
							$str_resep = "SELECT `KodeBarang` FROM `$tbresepdetail` WHERE `NoResep` = '$noregistrasi'";
							$query_resepdetail = mysqli_query($koneksi,$str_resep);
							$tbgudangpkmstok = "tbgudangpkmstok_".str_replace(' ', '', $namapuskesmas);
							while($data_resep = mysqli_fetch_array($query_resepdetail)){
								$data_obat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbgudangpkmstok` WHERE `KodeBarang` = '$data_resep[KodeBarang]'"));
								$array_resep[$no][] = $data_obat['NamaBarang'];
							}
							if ($array_resep[$no] != ''){
								$data_rsp = implode("<br/>", $array_resep[$no]);
							}else{
								$data_rsp ="";
							}
							
							// cek umur kelamin
							if ($kelamin == 'L'){
								$umur_l = $data['UmurTahun']." TH";
								$umur_p = "-";
							}else{
								$umur_l = "-";
								$umur_p = $data['UmurTahun']." TH";
							}
							
							// cek rujukan
							$rujukan = $data['StatusPulang'];
							if ($rujukan == 3){
								$berobatjalan = '<span class="fa fa-check"></span>';
								$rujuklanjut = '-';
							}else if($rujukan == 4){
								$rujuklanjut = '<span class="fa fa-check"></span>';
								$berobatjalan = '-';
							}
							
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalRegistrasi']));?></td>
								<td align="left">
								<?php
									echo "<b>".strtoupper($data['NamaPasien']."</b><br/>".
									strtoupper($data_kk['NamaKK'])."<br/>".
									substr($norm,-10)."<br/>".
									$data['Asuransi']);
								?>
								</td>
								<td align="center"><?php echo $umur_l;?></td>
								<td align="center"><?php echo $umur_p;?></td>
								<td align="center"><?php echo strtoupper($data['StatusKunjungan']);?></td>
								<td align="left">
									<?php
										if($data_kk['Alamat'] == ''){
											echo $alamat = '<span style="color:red;">Belum Terdaftar di Puskesmas</span>';
										}else{
											echo $alamat;
										}
									?>
								</td>
								<td align="center"><?php echo strtoupper($data_dgs);?></td>
								<td align="left"><?php echo strtoupper($data_rsp);?></td>
								<td align="left"><span class="fa fa-check"></span></td>
								<td align="left"><span class="fa fa-check"></span></td>
								<td align="left"></td>
								<td align="left"></td>
								<td align="left"><span class="fa fa-check"></span></td>
								<td align="left"></td>
								<td align="left"></td>
								<td align="left"><?php echo str_replace('POLI','',$data['PoliPertama']);?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br/>
	<hr class="noprint">
	<ul class="pagination noprint">
		<?php
			$query2 = mysqli_query($koneksi,$str);
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
						echo "<li><a href='?page=lap_P2M_remaja&keydate1=$keydate1&keydate2=$keydate2&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>