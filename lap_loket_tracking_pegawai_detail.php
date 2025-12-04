<?php
	include "otoritas.php";
	include "config/helper_pasiennrj.php";
	$namapgw = $_GET['namapgw'];
	$alamat = $_SESSION['alamat'];
	$kota = $_SESSION['kota'];
	$kecamatan = $_SESSION['kecamatan'];
	$kelurahan = $_SESSION['kelurahan'];
?>

<div class="tableborderdiv">
	<div class="row noprint">	
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>KINERJA PEGAWAI DETAIL</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_loket_tracking_pegawai_detail"/>
						<div class="col-xl-2">
							<select name="bulan" class="form-control">
								<option value="01" <?php if($_GET['bulan'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulan'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulan'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulan'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulan'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulan'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulan'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulan'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulan'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulan'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulan'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulan'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-xl-2">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-3">
							<input type="text" name="namapgw" class="form-control pegawaipuskesmas" value="<?php echo $_GET['namapgw'];?>" placeholder="Nama Pegawai" required>
						</div>
						<div class="col-xl-2">
							<select name="kinerja" class="form-control">
								<option value="Semua" <?php if($_GET['kinerja'] == 'Semua'){echo "SELECTED";}?>>Semua</option>
								<option value="Daftar" <?php if($_GET['kinerja'] == 'Daftar'){echo "SELECTED";}?>>Daftar</option>
								<option value="Pelayanan" <?php if($_GET['kinerja'] == 'Pelayanan'){echo "SELECTED";}?>>Pelayanan</option>
							</select>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_loket_tracking_pegawai_detail" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="lap_loket_tracking_pegawai_detail_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&namapgw=<?php echo $_GET['namapgw'];?>&kinerja=<?php echo $_GET['kinerja'];?>&namapgw<?php echo $_GET['namapgw'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$kinerja = $_GET['kinerja'];

	// select tbpasienrj_retensi
	if($tahun == $tahunini){
		$tbpasienrj = $tbpasienrj;
	}else{
		$tbpasienrj = $tbpasienrj."_RETENSI";
	}

	if($bulan != null AND $tahun != null){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN TRACKING PEGAWAI DETAIL</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
		<br/>
	</div>

	<div class="table-responsive">
		<table class="table-judul-laporan">
			<thead>
				<tr>
					<th width="3%">NO.</th>
					<th width="7%">TGL.PERIKSA</th>
					<th width="8%">NO.INDEX</th>
					<th width="15%">NAMA PASIEN</th>
					<th width="3%">L/P</th>
					<th width="7%">UMUR</th>
					<th width="10%">PELAYANAN</th>
					<th width="10%">CARA BAYAR</th>
					<th width="10%">ANAMNESA</th>
					<th width="8%">DIAGNOSA</th>
					<th width="13%">THERAPY</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$jumlah_perpage = 20;
			
			if($_GET['h']==''){
				$mulai=0;
			}else{
				$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			if($_GET['bulan']==''){
				$bulan= date('m');
			}else{
				$bulan= $_GET['bulan'];
			}
			
			if($_GET['tahun']==''){
				$tahun= date('Y');
			}else{
				$tahun= $_GET['tahun'];
			}
			
			if($_GET['kinerja']=='Semua'){
				$kinerja1= "`Pendaftaran` = '$namapgw' or `NamaPegawai1` = '$namapgw' or `NamaPegawai2` = '$namapgw' or `NamaPegawai3` = '$namapgw' or `Farmasi`='$namapgw'";
			}else if($_GET['kinerja']=='Daftar'){
				$kinerja1= "`Pendaftaran` = '$namapgw'";
			}else if($_GET['kinerja']=='Pelayanan'){
				$kinerja1= "`NamaPegawai1` = '$namapgw' or `NamaPegawai2` = '$namapgw' or `NamaPegawai3` = '$namapgw' or `Farmasi`='$namapgw'";
			}
			
			$strpasien = "SELECT * FROM `$tbpasienperpegawai` a WHERE (".$kinerja1.") AND MONTH(TanggalRegistrasi) = '$bulan' AND YEAR(TanggalRegistrasi) = '$tahun'";
			$str2 = $strpasien." order by `TanggalRegistrasi` Desc LIMIT $mulai,$jumlah_perpage";
			// echo $strpasien;
			
			if($_GET['h'] == null || $_GET['h'] == 1){
				$no = 0;
			}else{
				$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$querypasien = mysqli_query($koneksi, $str2);
			while($dtpasien = mysqli_fetch_assoc($querypasien)){
				$no = $no + 1;
				$dtpasienrj = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE NoRegistrasi='$dtpasien[NoRegistrasi]'"));
				
				if($dtpasienrj['PoliPertama'] == 'POLI ANAK'){
					$dtpasienpoli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpolianak` WHERE NoPemeriksaan='$dtpasien[NoRegistrasi]'"));
					$anamnesa = $dtpasienpoli['Anamnesa'];
					$terapi = $dtpasienpoli['Terapi'];
					$diagnosa = json_decode($dtpasienpoli['Diagnosa']);
				}elseif($dtpasienrj['PoliPertama'] == 'POLI GIGI'){
					$dtpasienpoli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpoligigi` WHERE NoPemeriksaan='$dtpasien[NoRegistrasi]'"));
					$anamnesa = $dtpasienpoli['Anamnesa'];
					$terapi = $dtpasienpoli['Terapi'];
					$diagnosa = json_decode($dtpasienpoli['Diagnosa']);
				}elseif($dtpasienrj['PoliPertama'] == 'POLI IMUNISASI'){
					$dtpasienpoli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpoliimunisasi` WHERE NoPemeriksaan='$dtpasien[NoRegistrasi]'"));
					$anamnesa = $dtpasienpoli['Anamnesa'];
					$terapi = $dtpasienpoli['Terapi'];
					$diagnosa = json_decode($dtpasienpoli['Diagnosa']);
				}elseif($dtpasienrj['PoliPertama'] == 'POLI KB'){
					$dtpasienpoli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpolikb` WHERE NoPemeriksaan='$dtpasien[NoRegistrasi]'"));
					$anamnesa = $dtpasienpoli['Anamnesa'];
					$terapi = $dtpasienpoli['Terapi'];
					$diagnosa = json_decode($dtpasienpoli['Diagnosa']);
				}elseif($dtpasienrj['PoliPertama'] == 'POLI KIA'){
					$dtpasienpoli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpolikia` WHERE NoPemeriksaan='$dtpasien[NoRegistrasi]'"));
					$anamnesa = $dtpasienpoli['Anamnesa'];
					$terapi = $dtpasienpoli['Terapi'];
					$diagnosa = json_decode($dtpasienpoli['Diagnosa']);
				}elseif($dtpasienrj['PoliPertama'] == 'POLI LANSIA'){
					$dtpasienpoli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpolilansia` WHERE NoPemeriksaan='$dtpasien[NoRegistrasi]'"));
					$anamnesa = $dtpasienpoli['Anamnesa'];
					$terapi = $dtpasienpoli['Terapi'];
					$diagnosa = json_decode($dtpasienpoli['Diagnosa']);
				}elseif($dtpasienrj['PoliPertama'] == 'POLI MTBS'){
					$dtpasienpoli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpolimtbs` WHERE NoPemeriksaan='$dtpasien[NoRegistrasi]'"));
					$anamnesa = $dtpasienpoli['Anamnesa'];
					$terapi = $dtpasienpoli['Terapi'];
					$diagnosa = json_decode($dtpasienpoli['Diagnosa']);
				}elseif($dtpasienrj['PoliPertama'] == 'POLI UMUM'){
					$tbpoliumum = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
					$dtpasienpoli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpoliumum` WHERE NoPemeriksaan='$dtpasien[NoRegistrasi]'"));
					$anamnesa = $dtpasienpoli['Anamnesa'];
					$terapi = $dtpasienpoli['Terapi'];
					$diagnosa = json_decode($dtpasienpoli['Diagnosa']);
				}elseif($dtpasienrj['PoliPertama'] == 'POLI UGD'){
					$dtpasienpoli = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpolitindakan` WHERE NoPemeriksaan='$dtpasien[NoRegistrasi]'"));
					$anamnesa = $dtpasienpoli['Anamnesa'];
					$terapi = $dtpasienpoli['Terapi'];
					$diagnosa = json_decode($dtpasienpoli['Diagnosa']);
				}else{
					$anamnesa = '-';
					$terapi = '-';
					$diagnosa = '-';
				}
				
				// tbdiagnosapasien
				$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
				$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$dtpasien[NoRegistrasi]'";
				$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
				while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
					$array_data[$no][] = $data_diagnosapsn['KodeDiagnosa'];
				}
				if ($array_data[$no] != ''){
					$data_dgs = implode(",", $array_data[$no]);
				}else{
					$data_dgs ="";
				}
							
				$noindex = $dtpasienrj['NoIndex'];
				if(strlen($noindex) == 24){
					$noindex2 = substr($dtpasienrj['NoIndex'],14);
				}else{
					$noindex2 = $dtpasienrj['NoIndex'];
				} 
				
			?>
			
			<tr>
				<td style="text-align:center; border:1px bordered #000; padding:3px;"><?php echo $no;?></td>
				<td style="text-align:center; border:1px bordered #000; padding:3px;"><?php echo $dtpasien['TanggalRegistrasi'];?></td>
				<td style="text-align:center; border:1px bordered #000; padding:3px;"><?php echo $noindex2;?></td>
				<td style="text-align:left; border:1px bordered #000; padding:3px;"><?php echo $dtpasienrj['NamaPasien'];?></td>
				<td style="text-align:center; border:1px bordered #000; padding:3px;"><?php echo $dtpasienrj['JenisKelamin'];?></td>
				<td style="text-align:left; border:1px bordered #000; padding:3px;"><?php echo $dtpasienrj['UmurTahun']."Th ".$dtpasienrj['UmurBulan']."Bl";?></td>
				<td style="text-align:center; border:1px bordered #000; padding:3px;"><?php echo str_replace('POLI','', $dtpasienrj['PoliPertama']);?></td>
				<td style="text-align:center; border:1px bordered #000; padding:3px;"><?php echo $dtpasienrj['Asuransi'];?></td>
				<td style="text-align:left; border:1px bordered #000; padding:3px;"><?php echo $anamnesa;?></td>
				<td style="text-align:center; border:1px bordered #000; padding:3px;"><?php echo $data_dgs;?></td>
				<td style="text-align:left; border:1px bordered #000; padding:3px;">
					<?php
					if($dtpasienrj['PoliPertama'] == 'POLI IMUNISASI'){
						$terapi = '-';
					}else{
						// therapy
						$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
						$tbgudangpkmstok = "tbgudangpkmstok_".str_replace(' ', '', $namapuskesmas);
						$str_therapy = "SELECT * FROM `$tbresepdetail` WHERE `NoResep` = '$dtpasien[NoRegistrasi]' GROUP BY NoResep, KodeBarang";
						$query_therapy = mysqli_query($koneksi, $str_therapy);
						while($dt_therapy = mysqli_fetch_array($query_therapy)){
							$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT NamaBarang FROM `$tbgudangpkmstok` WHERE `KodeBarang` = '$dt_therapy[KodeBarang]'"));
							$array_therapy[$no][] = $dtobat['NamaBarang']." (".$dt_therapy['jumlahobat'].")";
						}
						if ($array_therapy[$no] != ''){
							$data_trp = implode(",", $array_therapy[$no]);
						}else{
							$data_trp ="";
						}
					}
					echo $data_trp;
					?>
				</td>
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
			$query2 = mysqli_query($koneksi,$strpasien);//?
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
						echo "<li><a href='?page=lap_loket_tracking_pegawai_detail&bulan=$bulan&tahun=$tahun&namapgw=$namapgw&kinerja=$kinerja&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>	



