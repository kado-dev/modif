<?php
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
	$tbdiagnosapasien = "tbdiagnosapasien_".str_replace(' ', '', $namapuskesmas);
	$tbtindakanpasien = "tbtindakanpasien_".str_replace(' ', '', $namapuskesmas);
	$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
?>

<div class="tableborderdiv">
	<div class = "row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>REGISTER KASIR</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="kasir_laporan"/>
						<div class="col-xl-2">
							<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal">
						</div>
						<div class="col-xl-2">
							<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir">
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=kasir_laporan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="kasir_laporan_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $kodepuskesmas;?>&keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
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
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN REGISTER KASIR</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2))?> <?php echo $tahun;?></span>
		<br/>
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="3%" rowspan="2">NO.</th>
							<!--<th width="7%" rowspan="2">TGL.DAFTAR</th>-->
							<th width="8%" rowspan="2">NO.REGISTRASI</th>
							<th width="15%" rowspan="2">NAMA PASIEN</th>
							<th width="15%" rowspan="2">ALAMAT</th>
							<th width="8%" rowspan="2">PELAYANAN</th>
							<th width="15%" rowspan="2">JENIS TINDAKAN</th>
							<th width="8%" rowspan="2">CARA BAYAR</th>
							<th width="15%" colspan="3">TARIF</th>
							<th width="5%" rowspan="2">TOTAL</th>
						</tr>
						<tr>
							<th>KASIR</th>
							<th>KIR</th>
							<th>TINDAKAN</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$jumlah_perpage = 50;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$str = "SELECT * FROM `$tbpasienrj`
						WHERE date(TanggalRegistrasi) BETWEEN '$keydate1' AND '$keydate2' AND (`TarifKarcis` != '0' OR `TarifKir` != '0' OR `TarifTindakan` != '0')";
						$str2 = $str." GROUP BY date(TanggalRegistrasi), NamaPasien ORDER BY date(`TanggalRegistrasi`) DESC, `NamaPasien` ASC LIMIT $mulai,$jumlah_perpage";
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						$hariini = '';
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$tglreg = date('Y-m-d', strtotime($data['TanggalRegistrasi']));
							if($hariini != $tglreg){
								echo "<tr style='border:1px dashed #7a7a7a; font-weight: bold;'><td colspan='12'>$tglreg</td></tr>";
								$hariini = date('Y-m-d', strtotime($data['TanggalRegistrasi']));
							}	
							$no = $no + 1;
							$noregistrasi = $data['NoRegistrasi'];
							$noindex = $data['NoIndex'];
							$kelamin = $data['JenisKelamin'];
							$pelayanan = $data['PoliPertama'];
							$carabayar = $data['Asuransi'];						
							$tarifkarcis = $data['TarifKarcis'];						
							$tarifkir = $data['TarifKir'];
							$tariftindakan = $data['TarifTindakan'];
							$tariftotal	= $tarifkarcis + $tarifkir + $tariftindakan;
							
							// tbtindakanpasien
							$str_tindakan = "SELECT * FROM `$tbtindakanpasien` WHERE `NoRegistrasi`='$noregistrasi'";
							$query_tindakan = mysqli_query($koneksi, $str_tindakan);
							while($dt_tindakan = mysqli_fetch_array($query_tindakan)){
								// tbtindakan
								$datatindakan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Tindakan`,`Tarif` FROM `tbtindakan` WHERE `IdTindakan`='$dt_tindakan[IdTindakan]'"));
								$array_tindakan[$no][] = $datatindakan['Tindakan'];
							}
							if ($array_tindakan[$no] != ''){
								$data_tindakan = implode("<br/>", $array_tindakan[$no]);
							}else{
								$data_tindakan ="";
							}	
							
							// tbkk
							$str_kk = "SELECT `NamaKK`, `Alamat`, `RT`, `RW`, `Kelurahan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
							$query_kk = mysqli_query($koneksi,$str_kk);
							$data_kk = mysqli_fetch_assoc($query_kk);
							$alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", NO.".$data_kk['No'].", ".$data_kk['Kelurahan'];
							
							// cek umur kelamin
							if ($kelamin == 'L'){
								$umur_l = $data['UmurTahun']." Th";
								$umur_p = "-";
							}else{
								$umur_l = "-";
								$umur_p = $data['UmurTahun']." Th";
							}
							
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<!--<td align="center"><?php //echo date('d-m-Y', strtotime($data['TanggalRegistrasi']));?></td>-->
								<td align="center"><?php echo substr($data['NoRegistrasi'],-10);?></td>
								<td align="left"><?php echo strtoupper($data['NamaPasien']);?></td>
								<td align="left"><?php echo $alamat;?></td>
								<td align="left"><?php echo str_replace('POLI ','',$pelayanan);?></td>
								<td align="left">
									<?php 
										if($data_tindakan != ''){
											echo strtoupper($data_tindakan);
										}else{
											if($carabayar == "UMUM"){
												echo "RETRIBUSI PENDAFTARAN";
											}else{
												echo "RETRIBUSI KIR";
											}	
										}	
									?>
								</td>
								<td align="left"><?php echo $carabayar;?></td>
								<td align="right"><?php echo rupiah($tarifkarcis);?></td>
								<td align="right"><?php echo rupiah($tarifkir);?></td>
								<td align="right"><?php echo rupiah($tariftindakan);?></td>
								<td align="right"><?php echo rupiah($tariftotal);?></td>
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
						echo "<li><a href='?page=kasir_laporan&keydate1=$keydate1&keydate2=$keydate2&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>

