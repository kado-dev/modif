<?php
	include "config/helper_pasienrj.php";
	$pel = $_GET['pelayanan'];
	$tahun = date('Y');
	$bulan = date('m');
?>

<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white fw-bold">	
					<?php 
						echo str_replace('POLI','LAYANAN',$pel);
						$dt_antri = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND PoliPertama = '$pel' AND StatusPelayanan='Antri'")); 
					?>
				</h2>
				<h5 class="text-white op-7">SILAHKAN CARI DATA PASIEN</h5>
			</div>
			<div class="ml-md-auto py-2 py-md-0">
				<a href="index.php?page=poli&pelayanan=<?php echo $pel?>&status=Antri&tptgl=No" class="btn btn-danger btn-round"><?php echo "Belum di entry bulan ini : ".$dt_antri['Jml']." Pasien";?></a>
			</div>
		</div>
	</div>
</div>
<div class="page-inner mt--5">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<form role="form" class="submit">
						<div class="row">	
							<input type="hidden" name="page" value="poli"/>
							<input type="hidden" name="pelayanan" value="<?php echo $pel;?>"/>
							<div class="col-xl-2">
								<input type="text" name="tgl" class="form-control datepicker" value="<?php echo $_GET['tgl'];?>" placeholder = "Pilih Tanggal">
							</div>
							<div class="col-xl-3">
								<input type="text" name="nama" class="form-control" value="<?php echo $_GET['nama'];?>" placeholder = "Masukan Nama Pasien">
							</div>
							<div class="col-xl-2">
								<select name="status" class="form-control">
									<option value="Antri" <?php if($_GET['status'] == 'Antri'){echo "SELECTED";}?>>Belum</option>
									<option value="Sudah" <?php if($_GET['status'] == 'Sudah'){echo "SELECTED";}?>>Sudah</option>
								</select>
							</div>
							<div class="col-xl-3">
								<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
								<a href="?page=poli&pelayanan=<?php echo $pel;?>&status=Antri" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
								<?php if ($_GET['status'] == 'Antri'){ ?>
								<a href="?page=lap_loket_pasien_belum_entry&pelayanan=<?php echo $pel;?>&tgl=<?php echo $_GET['tgl']?>&nama=<?php echo $_GET['nama']?>&status=Antri&tptgl=No" class="btn btn-round btn-success"><span class="fa fa-print noprint"></span></a>
								<?php } ?>
							</div>
						</div>	
					</form>	
				</div>
			</div>
		</div>
	</div>
</div>	

<?php
	if($_GET['sort'] == 'ASC'){
		$sorts = 'DESC';
	}else{
		$sorts = 'ASC';
	}
?>

<div class="page-inner mt--5">
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<?php if($_GET['status'] == 'Antri'){ ?>
						<tr>
							<th width="3%">NO.</th>
							<th><a href="?page=poli&pelayanan=<?php echo $pel;?>&tgl=<?php echo $_GET['tgl'];?>&nama=<?php echo $_GET['nama'];?>&status=<?php echo $_GET['status'];?>&tptgl=<?php echo $_GET['tptgl'];?>&orderby=a.IdPasienrj&sort=<?php echo $sorts;?>&h=<?php echo $_GET['h'];?>">TGL.DAFTAR <?php echo iconsort("a.IdPasienrj",$sorts);?></a></th>
							<th>NO.INDEX</th>
							<th><a href="?page=poli&pelayanan=<?php echo $pel;?>&tgl=<?php echo $_GET['tgl'];?>&nama=<?php echo $_GET['nama'];?>&status=<?php echo $_GET['status'];?>&tptgl=<?php echo $_GET['tptgl'];?>&orderby=a.NamaPasien&sort=<?php echo $sorts;?>&h=<?php echo $_GET['h'];?>">NAMA PASIEN <?php echo iconsort("a.NamaPasien",$sorts);?></a></th>
							<th>L/P</th>
							<th>UMUR</th>
							<th>CARA BAYAR</th>
							<th>STATUS</th>
							<th>ANTRIAN</th>
							<th>KET.</th>
							<th class="noprint">#</th>
						</tr>
						<?php 
							}else{ 
						?>	
						<tr>
							<th width="3%">NO.</th>
							<th width="12%">TGL.PERIKSA</th>
							<th width="15%">NAMA PASIEN</th>
							<th width="10%">VITAL SIGN</th>
							<th width="20%">ANAMNESA</th>
							<th width="15%">THERAPY</th>
							<th width="15%">KET.</th>
							<th width="5%">ANTRIAN</th>
							<th class="noprint">#</th>
						</tr>
						<?php } ?>	
					</thead>
					<tbody>
					<?php
					$jumlah_perpage = 20;
					
					if($_GET['h']==''){
						$mulai=0;
					}else{
						$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					if($_GET['tgl'] == ''){
						$tgl = date('Y-m-d');
					}else{
						$tgl = $_GET['tgl'];
					}
					
					$nama = $_GET['nama'];	
					$tanpatgl = $_GET['tptgl'];
					$status = $_GET['status'];	

					if($tgl != null){
						$tgls = date('Y-m-d',strtotime($tgl));
						$tgl_str = " date(a.TanggalRegistrasi) = '$tgls' ";
					}	
					
					if($nama != null AND $tgl != null){
						$tgl_str = " date(a.TanggalRegistrasi) = '$tgls' ";
					}	
					
					if($tanpatgl == 'Yes'){
						$tgl_str = " YEAR(a.TanggalRegistrasi) = '$tahun' ";
					}elseif($tanpatgl == 'No'){
						$tgl_str = " YEAR(a.TanggalRegistrasi) = '$tahun' AND MONTH(a.TanggalRegistrasi) = '$bulan' ";
					}		
					
					if($nama != null){
						if($status != null){
							$nama_str = " AND a.NamaPasien like '%$nama%'";
						}else{
							$nama_str = " AND a.NamaPasien like '%$nama%'";
						}
					}else{
						$nama_str = " ";
					}	
					
					if($_GET['orderby'] == '' or $_GET['sort'] == ''){
						if($pel == "POLI LABORATORIUM"){	
							$orderbys = "GROUP BY NoRegistrasi ORDER BY date(a.TanggalRegistrasi) ASC, IdPasienrj ASC"; 
						}else{
							$orderbys = "GROUP BY NoRegistrasi ORDER BY date(a.TanggalRegistrasi) ASC, IdPasienrj ASC";
						}	
					}else{
						$orderbys = "GROUP BY NoRegistrasi ORDER BY ".$_GET['orderby']." ".$_GET['sort']; 
					}

					if($status == 'Antri'){		
						$str = "SELECT a.IdPasienrj, a.IdPasien, a.TanggalRegistrasi, a.NoRegistrasi, a.NoIndex, a.NamaPasien, a.JenisKelamin, a.UmurTahun, a.UmurBulan,
						a.UmurHari, a.Asuransi, a.StatusPelayanan, a.PoliPertama, a.NoKunjunganBpjs, a.NoAntrianPoli, a.StatusAntrianPoli, a.AsalPasien, 
						a.StatusPulang, a.dokterBpjs, b.PoliRujukan, b.PoliRujukan2, b.PoliRujukan3, b.StatusPemeriksaan
						FROM `$tbpasienrj` a LEFT JOIN `tbrujukinternal` b on a.NoRegistrasi = b.NoRujukan 
						WHERE ".$tgl_str." AND (a.StatusPelayanan = 'Antri' OR a.StatusPelayanan = 'Proses' OR a.StatusPelayanan = 'Rujuk') AND `AsalPasien`='10' AND (a.PoliPertama='$pel' or b.PoliRujukan='$pel' or b.PoliRujukan2='$pel' or b.PoliRujukan3='$pel')".$nama_str;
						$str2 = $str." ".$orderbys." limit $mulai,$jumlah_perpage";
						// echo $str2;

						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query = mysqli_query($koneksi, $str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$noindex = $data['NoIndex'];
					?>
						<tr class="btnprint" data-pel="<?php echo $data['PoliPertama'];?>" data-noreg="<?php echo $data['NoRegistrasi'];?>" data-idrj="<?php echo $data['IdPasienrj'];?>">
							<td style="text-align:right;"><?php echo $no;?></td>
							<td style="text-align:center;"><?php echo $data['TanggalRegistrasi'];?></td>
							<td style="text-align:center;"><?php echo substr($data['NoIndex'],14);?></td>
							<td style="text-align:left;" class="namakk">
								<?php 
									echo $data['NamaPasien']."<br/>";
								?>
							</td>
							<td style="text-align:center;"><?php echo $data['JenisKelamin'];?></td>
							<td style="text-align:left;">
								<?php
								if($data['UmurTahun'] > 0){
									echo $data['UmurTahun']." th";
								}else{
									echo $data['UmurBulan']." bl ".$data['UmurHari']." hr";
								}
								?>
							</td>
							<td style="text-align:left;"><?php echo $data['Asuransi'];?></td>
							<td style="text-align:center;"><?php echo $data['StatusPelayanan'];?></td>							
							<td style="text-align:center;"><?php echo strtoupper($data['NoAntrianPoli']);?></td>
							<?php if($pel == "POLI LABORATORIUM"){ ?>
							<td style="text-align:left;"><?php echo $data['PoliPertama'];?></td>
							<?php }else{ ?>
							<td style="text-align:left;">
								<?php 
									echo $data['dokterBpjs'];
								?>
							</td>
							<?php } ?>				
							<td style="text-align:left;">
								<?php
								$tglskrg = $_GET['tgl'];
								if($data['PoliRujukan'] != '' AND $data['StatusPulang'] == '5'){ // 5 itu rujuk internal
								?>
									<!--<a href="?page=poli_periksa&id=<?php echo $data['IdPasienrj'];?>&pelayanan=<?php echo $pel;?>&status=<?php echo $status;?>&tptgl=<?php echo $tglskrg;?>" class="btn btn-sm btn-info btn-white"> Periksa</a>-->
									<a href="?page=poli_periksa_edit&id=<?php echo $data['IdPasienrj'];?>&pelayanan=<?php echo $pel;?>" class="btn btn-round btn-success"><i class="fa fa-user-md (alias) faicon"></i></a>
								<?php
								}else{
									if($data['StatusPelayanan'] == 'Sudah'){									
									?>
										<a href="?page=poli_periksa_edit&id=<?php echo $data['IdPasienrj'];?>&pelayanan=<?php echo $pel;?>" class="btn btn-round btn-success"><i class="fa fa-user-md (alias) faicon"></i></a>
										<?php
										if($data['StatusPulang'] == 4){
										?>
										<a href="?page=cetak_rujukan_bpjs&id=<?php echo $data['IdPasienrj'];?>&pelayanan=<?php echo $pel;?>" class="btn btn-round btn-info"> CETAK</a>
									<?php 
										}
									}else{ 
									?>	
										<a href="?page=poli_periksa&id=<?php echo $data['IdPasienrj'];?>&idps=<?php echo $data['IdPasien'];?>&pelayanan=<?php echo $pel;?>&status=<?php echo $status;?>&tptgl=<?php echo $tglskrg;?>&cb=<?php echo $data['Asuransi'];?>" class="btn btn-round btn-success"><i class="fa fa-user-md (alias) faicon"></i></a>
									<?php 
									}
									?>	
									<?php
								}
								?>

								<?php
								if($data['NoAntrianPoli'] != ''){
									if($data['StatusAntrianPoli'] == 'N'){
								?>
								<a href="#" data-noantrian="<?php echo $data['NoAntrianPoli'];?>" data-stsantrian="<?php echo $data['StatusAntrianPoli'];?>" class="btn btn-round btn-info panggilantrian"><i class='ace-icon fa fa-bullhorn'></i></a>
								<?php
									}
								}	
								?>
							</td>
						</tr>
					<?php 
						} // akhir antri
					?>
					
					<?php
					}else{
						$jumlah_perpage = 20;
					
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						// cek pelayanan
						if($pel == 'POLI GIGI'){
							$tbpelayanan = "tbpoligigi_".str_replace(' ', '', $namapuskesmas);
						}elseif($pel == 'POLI KIA'){
							$tbpelayanan = "tbpolikia_".str_replace(' ', '', $namapuskesmas);
						}elseif($pel == 'POLI LANSIA'){
							$tbpelayanan = "tbpolilansia_".str_replace(' ', '', $namapuskesmas);
						}elseif($pel == 'POLI MTBS'){
							$tbpelayanan = "tbpolimtbs_".str_replace(' ', '', $namapuskesmas);
						}elseif($pel == 'POLI UMUM'){
							$tbpelayanan = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
						}elseif($pel == 'POLI UGD'){
							$tbpelayanan = "tbpolitindakan";
						}else{
							$tbpelayanan = "tb".strtolower(str_replace(' ','', $pel));
						}
						
						if($_GET['tgl'] != ''){
							$tglperiksa = date('Y-m-d', strtotime($_GET['tgl']));
						}else{
							$tglperiksa = date('Y-m-d');
						}
						
						if($nama != null){
							if($status != null){
								$nama_str = " AND NamaPasien like '%$nama%'";
							}else{
								$nama_str = " AND NamaPasien like '%$nama%'";
							}
						}else{
							$nama_str = " ";
						}	
						
						$str = "SELECT * FROM `$tbpelayanan`
						WHERE SUBSTRING(NoPemeriksaan,1,11) = '$kodepuskesmas' AND date(TanggalPeriksa) = '$tglperiksa'".$nama_str;
						$str2 = $str." ORDER BY `NoPemeriksaan` DESC limit $mulai,$jumlah_perpage";
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$querypel = mysqli_query($koneksi, $str2);
						while($datapel = mysqli_fetch_assoc($querypel)){
							$no = $no + 1;
							$noindex = $datapel['NoIndex'];
							$nopemeriksaan = $datapel['NoPemeriksaan'];
							$idprj = $datapel['IdPasienrj'];
							
							// tbpasienrj
							$dtpasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idprj'"));
							$idpasienrj = $dtpasienrj['IdPasienrj'];

							if($dtpasienrj['JenisKelamin'] == "L"){
								$jk = "Laki-laki";
							}else{
								$jk = "Perempuan";	
							}

							// vital sign
							$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idpasienrj'";
							$dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
							$dtsistole = $dtvs['Sistole'];
							$dtdiastole = $dtvs['Diastole'];
							$dtsuhutubuh = $dtvs['SuhuTubuh'];
							$dttinggiBadan = $dtvs['TinggiBadan'];
							$dtberatBadan = $dtvs['BeratBadan'];
							$dtheartRate = $dtvs['HeartRate'];
							$dtrespRate = $dtvs['RespiratoryRate'];
							$dtLingkarPerut = $dtvs['LingkarPerut'];
							$imt = $dtvs['IMT'];
					?>
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="center"><?php echo date('d-m-Y', strtotime($datapel['TanggalPeriksa'])).", ".$datapel['JamPeriksa'];?></td>
							<td align="left">
								<?php
									echo "<b>".$datapel['NamaPasien']."</b><br/>".
									"Gender : ".$jk."<br/>".
									"Pkr.Umur : ".$dtpasienrj['UmurTahun']."Th ".$dtpasienrj['UmurBulan']."Bl ".$dtpasienrj['UmurHari']."Hr "."<br/>".
									"No.Index : ".substr($noindex,-10)."<br/>".
									"Cara Bayar : ".$dtpasienrj['Asuransi']."<br/>";
									
									// cek tindakan
									$tbtindakanpasien = "tbtindakanpasien_".str_replace(' ', '', $namapuskesmas);
									$cektindakan = mysqli_num_rows(mysqli_query($koneksi, "SELECT `IdTindakanPasienDetail` FROM `$tbtindakanpasien` WHERE `NoRegistrasi`='$nopemeriksaan'"));
									if($cektindakan > 0){
								?>
									<span class="badge badge-warning" style='font-size:12px; font-style: italic; padding: 6px;'><?php echo "Tindakan";?></span>
								<?php 
									}
									
									// cek rujuk internal
									$cekrujukinternal = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `tbrujukinternal` WHERE `NoRujukan`='$nopemeriksaan'"));
									if($cekrujukinternal > 0){
								?>
									<span class="badge badge-info" style='font-size:12px; font-style: italic; padding: 6px;'><?php echo "Rujuk Internal";?></span>
								<?php 
									}
								?>
							</td>
							<td align="left">
								<?php 
									echo "Tensi : ".$dtsistole."/".$dtdiastole."<br/>".
									"TB, BB : ".$dttinggiBadan.", ".$dtberatBadan."<br/>".
									"Suhu : ".$dtsuhutubuh."<br/>".
									"Nadi : ".$dtheartRate."<br/>".
									"RR : ".$dtrespRate."<br/>".
									"Lkr.Perut : ".$dtLingkarPerut."<br/>";
									"Imt : ".$imt;
								?>
								<span class="badge badge-info" style='font-size:12px; font-style: italic; padding: 6px;'><?php echo substr($dtpasienrj['IdObservationSatuSehat'],0,8);?></span><!--.($dtpasienrj['IdObservationSatuSehat'] == '') ? '':'xxx'-->
							</td>
							<td align="left">
								<?php
									
									if($pel == "POLI KB"){
										$datakb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolikb_kunjunganulang` WHERE `NoPemeriksaan`='$nopemeriksaan'"));
										echo "Anamnesa : <br/>".
										"<b>".strtoupper($datakb['Anamnesa'])."</b><br/>";
									}else{
										echo "Anamnesa : <br/>".
										"<b>".strtoupper($datapel['Anamnesa'])."</b><br/>";
									}
									echo "Diagnosa : <br/>";
									if($datapel['Diagnosa'] == "" OR $datapel['Diagnosa'] == 'null'){
										echo "-";
									}else{	
										$diagnosa = strtoupper(str_replace(array('["','"]'),'', $datapel['Diagnosa']));
										echo "<b>".str_replace('","','<br/>', $diagnosa)."</b><br/>";
									}
									echo "Tindakan : <br/>";
									
									// tindakan
									$str_tindakan = "SELECT * FROM `$tbtindakanpasien` WHERE `NoRegistrasi`='$nopemeriksaan'";
									$query_tindakan = mysqli_query($koneksi, $str_tindakan);
									while($dt_tindakan = mysqli_fetch_array($query_tindakan)){
										$dttindakan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Tindakan` FROM `tbtindakan` WHERE `IdTindakan` = '$dt_tindakan[IdTindakan]'"));
										$array_tindakan[$no][] = $dttindakan['Tindakan'];
									}
									if ($array_tindakan[$no] != ''){
										$tindakan = implode("<br/>", $array_tindakan[$no]);
									}else{
										$tindakan ="";
									}
									echo "<b>".str_replace('","','<br/>', strtoupper($tindakan))."</b><br/>";
								?>
								<span class="badge badge-info" style='font-size:12px; font-style: italic; padding: 6px;'><?php echo substr($dtpasienrj['IdConditionSatuSehat'],0,8);?></span><!--.($dtpasienrj['IdConditionSatuSehat'] == '') ? '':'xxx'-->
							</td>
							<td align="left">
								<?php 
									if($datapel['Terapi'] == "" OR $datapel['Terapi'] == 'null'){
										// therapy
										if($idpasienrj !=''){
											$str_therapy = "SELECT * FROM `$tbresepdetail` WHERE `IdPasienrj`='$idpasienrj' AND `Pelayanan`='$pel' GROUP BY NoResep, KodeBarang";
										}else{
											$str_therapy = "SELECT * FROM `$tbresepdetail` WHERE `NoResep`='$nopemeriksaan' AND `Pelayanan`='$pel' GROUP BY NoResep, KodeBarang";
										}
										
										// echo $str_therapy;
										$query_therapy = mysqli_query($koneksi, $str_therapy);
										while($dt_therapy = mysqli_fetch_array($query_therapy)){
											$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang` FROM `$tbapotikstok` WHERE `KodeBarang` = '$dt_therapy[KodeBarang]'"));
											$array_therapy[$no][] = $dtobat['NamaBarang'];
										}
										if ($array_therapy[$no] != ''){
											$terapi = implode("<br/>", $array_therapy[$no]);
											echo strtoupper($terapi);
										}else{
								?>	

										<!--jika therapy kosong-->
										<!-- <div class="text-center"><span class='badge badge-danger' style='padding: 4px; vertical-align:middle'><i class='icon-close fa-3x'></i></span></div> -->
										<?php
											// tbresep
											$str_resep = "SELECT * FROM `$tbresep` WHERE `NoResep`='$nopemeriksaan' AND `Pelayanan`='$pel'";
											$query_resep = mysqli_query($koneksi, $str_resep);
											$data_resep = mysqli_fetch_assoc($query_resep);
											if ($data_resep['OpsiResep'] == 'konseling'){
												echo strtoupper($data_resep['OpsiResep']);
											}else{
												echo strtoupper($data_resep['OpsiResep']."<br/>".$data_resep['KetResepLuar']);
											}
										?>
								
								<?php
										}
									}else{	
										$terapi = strtoupper(str_replace(array('["','"]'),'', $datapel['Terapi']));
										echo str_replace('","','<br/>', $terapi);
									}
								?>
							</td>
							<td align="center">
								<?php
									if($datapel['NamaPegawaiSimpan'] != ''){
										echo $datapel['NamaPegawaiSimpan'];
									}else{
										echo $datapel['NamaPegawaiEdit'];
									}
								?><br/>
								<?php if(substr($dtpasienrj['Asuransi'],0,4) == 'BPJS'){ ?>
									<img src='image/bpjs.png' id='hide-option' title='$dtpasienrj[NoUrutBpjs]'/>&nbsp<?php echo $dtpasienrj['NoUrutBpjs'];?><br/>
									<i class="icon-user"></i>&nbsp<?php echo $dtpasienrj['nokartu'];?><br/>
									
									<?php if(strlen($dtpasienrj['NoKunjunganBpjs']) == 19){ ?>
										<span class="badge badge-success" style='padding: 8px;'><?php echo $dtpasienrj['NoKunjunganBpjs'];?></span>
									<?php
										}else{
											$getlogsapi = mysqli_query($koneksi, "SELECT `LogPcarePemeriksaan` FROM `tblogs_api` WHERE `IdPasienrj` = '$idpasienrj' AND `Puskesmas`='$namapuskesmas'");
											if(mysqli_num_rows($getlogsapi) > 0){
												$dtlogsapi = mysqli_fetch_array($getlogsapi);
												$ketb = ($dtlogsapi['LogPcarePemeriksaan'] == '') ? 'Bridging Gagal' : $dtlogsapi['LogPcarePemeriksaan'];
												echo "<span class='badge badge-danger'>".str_replace(str_split('!-,.'), '<br/>',$ketb)."</span>";
											}
									?>
										<a href='kirim_ulang_pemeriksaan_bpjs.php?idrj=<?php echo $idpasienrj;?>&hal=poli&tgl=<?php echo $_GET['tgl'];?>&status=<?php echo $_GET['status'];?>' class="btn btn-info btn-sm btn-round">Kirim Ulang</a>
									<?php
										}
									?>
								<?php } ?>
							</td>
							<td align="center"><?php echo strtoupper($dtpasienrj['NoAntrianPoli']);?></td>
							<td style="text-align:center;">
								<?php if($datapel['StatusPulang'] == 4){?>
									<a href="?page=cetak_rujukan_bpjs&no=<?php echo $datapel['NoRegistrasi'];?>&pelayanan=<?php echo $pel;?>" class="btn btn-round btn-info"> CETAK</a>
								<?php } ?>
								<a href="?page=poli_periksa_edit&id=<?php echo $dtpasienrj['IdPasienrj'];?>&idpr=<?php echo $datapel['IdPemeriksaan']?>&idps=<?php echo $dtpasienrj['IdPasien'];?>&pelayanan=<?php echo $pel;?>&cb=<?php echo $dtpasienrj['Asuransi'];?>" class="btn btn-round btn-success"> EDIT</a>
							</td>
						</tr>
					<?php
						}
					}
					?>
					</tbody>
				</table>
			</div>
		</div>			
	</div><hr/>
	<ul class="pagination noprint">
		<?php
			$tptgl = $_GET['tptgl'];
			$orderbys = $_GET['orderby'];
			$sorts = $_GET['sort'];
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
						if($_GET['status'] == 'Antri'){
							if($tptgl == ''){
								echo "<li><a href='?page=poli&pelayanan=$pel&status=$status&tgl=$tglskrg&h=$i&orderby=$orderbys&sort=$sorts'>$i</a></li>";
							}else{	
								echo "<li><a href='?page=poli&pelayanan=$pel&status=$status&tgl=$tglskrg&h=$i&tptgl=$tptgl&orderby=$orderbys&sort=$sorts'>$i</a></li>";
							}
						}else{
							echo "<li><a href='?page=poli&pelayanan=$pel&tgl=$tgl&nama=$nama&status=Sudah&h=$i&tptgl=$tptgl&orderby=$orderbys&sort=$sorts'>$i</a></li>";
						}
					}
				}
			}
		?>	
	</ul>
</div>

<script src="assets/js/jquery.js"></script>
<script>
	$(".btnprint").dblclick(function(){
		var idpasienrj = $(this).data("idrj");
		var noregistrasi = $(this).data("noreg");
		var pelayanan = $(this).data('pel');		
		document.location.href='index.php?page=poli_periksa_print&noreg='+noregistrasi+'&idrj='+idpasienrj+'&pelayanan='+pelayanan;
	});
	$(".panggilantrian").click(function(){
		var noantrian = $(this).data('noantrian'); 
		var sts = $(this).data('stsantrian');
		var poli = "<?php echo $_GET['pelayanan'];?>";
		$.get( "get_modal_panggil_antrian_poli.php?noa="+noantrian+"&poli="+poli).done(function( data ) {
			$(".modaltampil").html(data);
			$('#Modalantrian').modal('show');
		});
	});	
</script>
<?php
function iconsort($nmkolom,$sorttype){
	$sorticon = "<i class='fa fa-sort'></i>";
	$downs = "<i class='fa fa-sort-down'></i>";
	$ups = "<i class='fa fa-sort-up'></i>";
	if(isset($_GET["sort"])){
		if($nmkolom == $_GET['orderby']){
			if($sorttype == 'ASC'){
				$h = $downs;
			}else{
				$h = $ups;
			}
		}else{
			$h = $sorticon;
		}
	}else{
		$h = $sorticon;
	}
	return $h;
}
?>
<div class="modaltampil"></div>