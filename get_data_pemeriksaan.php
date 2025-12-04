<?php
	// update 09 mei 2025
    session_start();
    error_reporting(0);
	include "config/koneksi.php";
	include "config/helper_pasienrj.php";
	
    $tahun = date('Y');
	$bulan = date('m');
	$pel = $_GET['pelayanan'];
	$klaster = $_GET['klaster'];
	$petugas = $_GET['petugas'];
    $status = $_GET['status'];

    if($status == 'belumdilayani'){
?>

				<!--Belum  / Antri-->
				<div class="tmp_form_belum">
					<div class="table-responsive">
						<!-- <p style="font-size: 20px; font-weight: bold;" class="judul">Antri</p> -->
						<table class="table-judul">
							<thead>
								<tr>
									<th width="3%">No.</th>
									<th>Tanggal Daftar </a></th>
									<th>Antrian</th>
									<th width="22%">Nama Pasien </a></th>
									<th>L/P</th>
									<th>Umur</th>
									<th>Pelayanan</th>
									<th>Status</th>
									<th width="20%">Keterangan</th>
									<th class="noprint" width="10%">#</th>
								</tr>
							</thead>
							<tbody>
								<?php

									$jumlah_perpage = 10;									
					
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
				
									if($tgl != null){
										$tgls = date('Y-m-d',strtotime($tgl));
										$tgl_str = " date(TanggalRegistrasi) = '$tgls' ";
									}else{
										$tgl_str = "";
									}	
									
																	
									if($tanpatgl == 'Yes'){
										$tgl_str = " YEAR(TanggalRegistrasi) = '$tahun' ";
									}elseif($tanpatgl == 'No'){
										$tgl_str = " YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' ";
									}		
									
									if($nama != null){
										$nama_str = " AND NamaPasien like '%$nama%'";
									}else{
										$nama_str = "";
									}	
									
										if($pel == "POLI LABORATORIUM"){	
											$orderbys = "ORDER BY date(TanggalRegistrasi) ASC, IdPasienrj ASC"; 
										}else{
											$orderbys = "ORDER BY date(TanggalRegistrasi) ASC, IdPasienrj ASC";
                                        }

									if($pel==''){
										$pelayanans = "";
									}else{
										$pelayanans = " AND `PoliPertama`='$pel'";
									}

									if($klaster==''){
										$klasters = "";
									}else{
										$klasters = " AND `Klaster`='$klaster'";
									}

									if($petugas==''){
										$petugass = "";
									}else{
										$petugass = " AND `dokterBpjs`='$petugas'";
									}

									// tbasalpasien									
									$aslpsn = $_SESSION['namalayanan_dipilih'];
									$dtasalpasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tbasalpasien WHERE `AsalPasien`='$aslpsn'"));

									$str = "SELECT *
									FROM `$tbpasienrj`  
									WHERE ".$tgl_str." AND (StatusPelayanan = 'Antri' OR StatusPelayanan = 'Proses') AND `AsalPasien`='$dtasalpasien[Id]' AND `StatusPasien`='1'".$pelayanans.$klasters.$nama_str.$petugass;
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
										<td style="text-align:center;"><?php echo strtoupper($data['NoAntrianPoli']);?></td>
										<td style="text-align:left;" class="namakk">
											<?php  echo $data['NamaPasien']."<br/>"; ?>
											<!-- <p style="font-size: 12px; font-weight: bold;"><?php echo substr($data['NoIndex'],-10);?></p> -->
											<div><i class="fas fa-check-circle"></i> <?php echo substr($data['NoIndex'],-10);?></div>
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
										<td style="text-align:left;">
											<i class="icon-people"></i> <?php echo str_replace("POLI","PELAYANAN",$data['PoliPertama']);?><br/>
											<div><b><i class="fas fa-tags"></i> <?php echo $data['Klaster']." - ".$data['SiklusHidup'];?></b></div>
										</td>						
										<td style="text-align:left;">
											<?php if($data['StatusPelayanan'] == 'Antri'){ ?>
												<span class='badge badge-info'><?php echo $data['StatusPelayanan'];?></span>
											<?php }elseif($data['StatusPelayanan'] == 'Proses'){ ?>
												<span class='badge badge-warning'><?php echo $data['StatusPelayanan'];?></span>
											<?php } ?>
										</td>
										<?php if($pel == "POLI LABORATORIUM"){ ?>
										<td style="text-align:left;"><?php echo $data['PoliPertama'];?></td>
										<?php }else{ ?>
										<td style="text-align:left;">
											<?php 
												echo $data['dokterBpjs'];
											?>
										</td>
										<?php } ?>				
										<td style="text-align:center;">
											<?php
											$tglskrg = $_GET['tgl'];
											if($data['PoliRujukan'] != '' AND $data['StatusPulang'] == '5'){ // 5 itu rujuk internal
											?>
												<a href="?page=poli_periksa_edit&id=<?php echo $data['IdPasienrj'];?>&pelayanan=<?php echo $pel;?>" class="btn btn-sm btn-success"><i class="fa fa-user-md (alias) faicon"></i></a>
											<?php
											}else{
												if($data['StatusPelayanan'] == 'Sudah'){									
												?>
													<a href="?page=poli_periksa_edit&id=<?php echo $data['IdPasienrj'];?>&pelayanan=<?php echo $pel;?>" class="btn btn-sm btn-success"><i class="fa fa-user-md (alias) faicon"></i></a>
													<?php
													if($data['StatusPulang'] == 4){
													?>
													<a href="?page=cetak_rujukan_bpjs&idrj=<?php echo $data['IdPasienrj'];?>&pelayanan=<?php echo $pel;?>" class="btn btn-sm btn-info"> Cetak</a>
												<?php 
													}
												}else{ 
												?>	
													<a href="?page=poli_periksa&id=<?php echo $data['IdPasienrj'];?>&idps=<?php echo $data['IdPasien'];?>&pelayanan=<?php echo $data['PoliPertama'];?>&tptgl=<?php echo $tglskrg;?>&cb=<?php echo $data['Asuransi'];?>" class="btn btn-sm btn-success"><i class="fa fa-user-md (alias) faicon"></i></a>
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
											<a href="#" data-noantrian="<?php echo $data['NoAntrianPoli'];?>" data-stsantrian="<?php echo $data['StatusAntrianPoli'];?>" class="btn btn-sm btn-info panggilantrian"><i class='ace-icon fa fa-bullhorn'></i></a>
											<?php
												}
											}	
											?>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
						<ul class="pagination mt-4 noprint">
							<?php
							
								$query2 = mysqli_query($koneksi,$str);
								$jumlah_query = mysqli_num_rows($query2);
								
								if(($jumlah_query % $jumlah_perpage) > 0){
									$jumlah = ($jumlah_query / $jumlah_perpage)+1;
								}else{
									$jumlah = $jumlah_query / $jumlah_perpage;
								}
								
								for ($i=1;$i<=$jumlah;$i++){
									if($_GET['h'] == null || $_GET['h'] == ''){
										$hal = 1;
									}else{
										$hal = $_GET['h'];
									}									

									$max = $hal + 5;
									$min = $hal - 4;
									
									if($i <= $max && $i >= $min){
										if($hal == $i){
											echo "<li class='active'><span class='current'>$i</span></li>";
										}else{
											echo "<li><a href='#' data-hal='$i' class='page-a'>$i</a></li>";
										}
									}
								}
							?>	
						</ul>
					</div>
				</div>
<?php
    }else if($status == 'sudahdilayani'){
?>
				<!--Sudah-->	
				<div class="tmp_form_sudah" >
					<div class="table-responsive">
						<!-- <p style="font-size: 20px; font-weight: bold;" class="judul">Sudah Dilayani</p> -->
						<?php
						if($pel == ''){
						?>
						<div class='alert alert-info'>Silahkan pilih klaster / pelayanan terlebih dahulu...</div>
						<?php
						}
						?>
						<table class="table-judul">
							<thead>
								<tr>
									<th width="3%">No.</th>
									<th width="10%">Tanggal Dilayani</th>
									<th width="20%">Nama Pasien</th>
									<th width="15%">Anamnesa</th>
									<th width="20%">Diagnosa</th>
									<th width="15%">Therapy</th>
									<th width="12%">Keterangan</th>
									<th width="5%">Antrian</th>
									<th class="noprint">#</th>
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
									
									if($_GET['tgl'] == ''){
										$tgl = date('Y-m-d');
									}else{
										$tgl = $_GET['tgl'];
									}
									
									$nama = $_GET['nama'];	
									$tanpatgl = $_GET['tptgl'];
				
									if($tgl != null){
										$tgls = date('Y-m-d',strtotime($tgl));
										$tgl_str = " date(TanggalRegistrasi) = '$tgls' ";
									}else{
										$tgl_str = "";
									}										
																	
									if($tanpatgl == 'Yes'){
										$tgl_str = " YEAR(TanggalRegistrasi) = '$tahun' ";
									}elseif($tanpatgl == 'No'){
										$tgl_str = " YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' ";
									}		
									
									if($nama != null){
										$nama_str = " AND NamaPasien like '%$nama%'";
									}else{
										$nama_str = "";
									}	
									
									if($pel == "POLI LABORATORIUM"){	
										$orderbys = "ORDER BY date(TanggalRegistrasi) ASC, IdPasienrj ASC"; 
									}else{
										$orderbys = "ORDER BY date(TanggalRegistrasi) ASC, IdPasienrj ASC";
									}

									if($pel==''){
										$pelayanans = "";
									}else{
										$pelayanans = " AND `PoliPertama`='$pel'";
									}

									if($klaster==''){
										$klasters = "";
									}else{
										$klasters = " AND `Klaster`='$klaster'";
									}

									if($petugas==''){
										$petugass = "";
									}else{
										$petugass = " AND `dokterBpjs`='$petugas'";
									}

									// tbasalpasien									
									$aslpsn = $_SESSION['namalayanan_dipilih'];
									$dtasalpasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tbasalpasien WHERE `AsalPasien`='$aslpsn'"));

									$str = "SELECT *
									FROM `$tbpasienrj`  
									WHERE ".$tgl_str." AND `StatusPelayanan`='Sudah' AND `AsalPasien`='$dtasalpasien[Id]'".$pelayanans.$klasters.$nama_str.$petugass;
									$str2 = $str." ".$orderbys." limit $mulai,$jumlah_perpage";
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
										$polipertama = $datapel['PoliPertama'];
										
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
										// echo $strvs;
										$dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
										$anamnesa = $dtvs['Anamnesa'];
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
									<tr style="vertical-align: text-top;">
										<td align="center"><?php echo $no;?></td>
										<td align="center"><?php echo $datapel['TanggalRegistrasi'];?></td>
										<td align="left">
											<?php
												echo "<b>".$datapel['NamaPasien']."</b><br/>".
												"Gender : ".$jk."<br/>".
												"Pkr.Umur : ".$dtpasienrj['UmurTahun']."Th ".$dtpasienrj['UmurBulan']."Bl ".$dtpasienrj['UmurHari']."Hr "."<br/>".
												"No.Index : ".substr($noindex,-10)."<br/>".
												"Cara Bayar : ".$dtpasienrj['Asuransi']."<br/>".
												"Nik : ".$dtpasienrj['Nik']."<br/>";
											?>
											<?php 
												// cek rujuk internal
												$cekrujukinternal = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `tbrujukinternal` WHERE `NoRujukan`='$nopemeriksaan'"));
												if($cekrujukinternal > 0){
											?>
												<span class="btn btn-sm btn-round btn-info"><?php echo "Rujuk Internal";?></span>
											<?php 
												}
											?>
										</td>
										<td align="left">
											<?php 
												echo "Anamnesa : <br/>".
												"<b>".strtoupper($anamnesa)."</b><br/>";												
												echo "Tensi : ".$dtsistole."/".$dtdiastole."<br/>".
												"TB, BB : ".$dttinggiBadan.", ".$dtberatBadan."<br/>".
												"Suhu : ".$dtsuhutubuh."<br/>".
												"Nadi : ".$dtheartRate."<br/>".
												"RR : ".$dtrespRate."<br/>".
												"Lkr.Perut : ".$dtLingkarPerut."<br/>";
												"Imt : ".$imt;
											?>
											
										</td>
										<td align="left">
											<?php
												echo "Diagnosa : <br/>";
												// if($datapel['Diagnosa'] == "" OR $datapel['Diagnosa'] == 'null'){
												// 	echo "-";
												// }else{	
												// 	$diagnosa = strtoupper(str_replace(array('["','"]'),'', $datapel['Diagnosa']));
												// 	echo "<b>".str_replace('","','<br/>', $diagnosa)."</b><br/>";
												// }

												// diagnosa
												$str_diagnosa = "SELECT * FROM `$tbdiagnosapasien` WHERE `IdPasienrj`='$idpasienrj'";
												$query_diagnosa = mysqli_query($koneksi, $str_diagnosa);
												while($dt_diagnosa = mysqli_fetch_array($query_diagnosa)){
													$dtdiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `KodeDiagnosa`,`Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$dt_diagnosa[KodeDiagnosa]'"));
													$array_diagnosa[$no][] = $dtdiagnosa['KodeDiagnosa']." - ".$dtdiagnosa['Diagnosa'];
												}
												if ($array_diagnosa[$no] != ''){
													$diagnosaps = implode("<br/>", $array_diagnosa[$no]);
												}else{
													$diagnosaps ="";
												}
												echo "<b>".str_replace('","','<br/>', strtoupper($diagnosaps))."</b><br/>";
											?>	
												
											<?php
												echo "Tindakan : <br/>";
												
												// tindakan
												$str_tindakan = "SELECT * FROM `$tbtindakanpasien` WHERE `IdPasienrj`='$idpasienrj'";
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
										</td>
										<td align="left">
											<?php 
												// if($datapel['Terapi'] == "" OR $datapel['Terapi'] == 'null'){
													// therapy
													// if($idpasienrj !=''){
														// $str_therapy = "SELECT * FROM `$tbresepdetail` WHERE `IdPasienrj`='$idpasienrj' AND `Pelayanan`='$pel' GROUP BY NoResep, KodeBarang";
														$str_therapy = "SELECT * FROM `$tbresepdetail` WHERE `IdPasienrj`='$idpasienrj' AND `Pelayanan`='$polipertama'";
														// }else{
														// $str_therapy = "SELECT * FROM `$tbresepdetail` WHERE `NoResep`='$nopemeriksaan' AND `Pelayanan`='$pel' GROUP BY NoResep, KodeBarang";
														// $str_therapy = "SELECT * FROM `$tbresepdetail` WHERE `NoResep`='$nopemeriksaan' AND `Pelayanan`='$pel'";
													// }
													
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
												// }else{	
												// 	$terapi = strtoupper(str_replace(array('["','"]'),'', $datapel['Terapi']));
												// 	echo str_replace('","','<br/>', $terapi);
												// }
											?>
										</td>
										<td align="left"><?php echo $datapel['dokterBpjs'];?>
											<br/>
											<?php if(substr($dtpasienrj['Asuransi'],0,4) == 'BPJS'){ ?>
												<img src='image/logo_bpjs_bulet.png' width='32px' id='hide-option' title='$dtpasienrj[NoUrutBpjs]'/>&nbsp<?php echo $dtpasienrj['NoUrutBpjs'];?><br/>
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
													<a href='kirim_ulang_pemeriksaan_bpjs.php?idrj=<?php echo $idpasienrj;?>&hal=poli&tgl=<?php echo $_GET['tgl'];?>' class="btn btn-info btn-sm btn-round">Kirim Ulang</a>
												<?php
													}
												?>
											<?php } ?><br/>

											<!--encounter-->
											<img src='image/satusehat_encounter.png' width='32px' id='hide-option'/>
											<?php if($dtpasienrj['IdKunjunganSatuSehat'] !=''){ ?>
												<span class="badge badge-success"><?php echo substr($dtpasienrj['IdKunjunganSatuSehat'],0,6)."xxx";?></span>
											<?php }else{ ?>
												<a href="kirim_reg_encounter.php?idrj=<?php echo $dtpasienrj['IdPasienrj'];?>&nikps=<?php echo $dtpasienrj['Nik'];?>&tgl=<?php echo date('d-m-Y', strtotime($dtpasienrj['TanggalRegistrasi']));?>&page=poli&pelayanan=<?php echo $pel;?>" class="badge badge-info">Encounter</a>
											<?php } ?><br/>

											<!--observation-->
											<img src='image/satusehat_encounter.png' width='32px' id='hide-option'/>
											<?php if($dtpasienrj['IdObservationSatuSehat'] !=''){ ?>
												<span class="badge badge-success mt-2"><?php echo substr($dtpasienrj['IdObservationSatuSehat'],0,6)."xxx";?></span>
											<?php }else{ ?>
												<span class="badge badge-info mt-2"><?php echo "Observation";?></span>
											<?php } ?><br/>

											<!--codition-->
											<img src='image/satusehat_encounter.png' width='32px' id='hide-option'/>
											<?php if($dtpasienrj['IdConditionSatuSehat'] !=''){ ?>
												<span class="badge badge-success mt-2"><?php echo substr($dtpasienrj['IdConditionSatuSehat'],0,6)."xxx";?></span>
											<?php }else{ ?>
												<a href="kirim_reg_condition.php?idrj=<?php echo $dtpasienrj['IdPasienrj'];?>&nikps=<?php echo $dtpasienrj['Nik'];?>&tgl=<?php echo date('d-m-Y', strtotime($dtpasienrj['TanggalRegistrasi']));?>&page=poli&pelayanan=<?php echo $pel;?>" class="badge badge-info mt-2">Condition</a>
											<?php } ?><br/>
										</td>
										<td align="center"><?php echo strtoupper($dtpasienrj['NoAntrianPoli']);?></td>
										<td style="text-align:center;">
											<?php if($datapel['StatusPulang'] == 4){?>
												<a href="?page=cetak_rujukan_bpjs&idrj=<?php echo $datapel['IdPasienrj'];?>&pelayanan=<?php echo $pel;?>" class="btn btn-round btn-info"> CETAK</a>
											<?php } ?>
											<a href="?page=poli_periksa_edit&id=<?php echo $dtpasienrj['IdPasienrj'];?>&idpr=<?php echo $datapel['IdPemeriksaan']?>&idps=<?php echo $dtpasienrj['IdPasien'];?>&pelayanan=<?php echo $polipertama;?>&cb=<?php echo $dtpasienrj['Asuransi'];?>" class="btn btn-round btn-success"> EDIT</a>
										</td>
									</tr>
								<?php 
										} 
									// }
								?>
							</tbody>
						</table><hr/>
						<ul class="pagination mt-4 noprint">
							<?php
								$query2 = mysqli_query($koneksi,$str);
								$jumlah_query = mysqli_num_rows($query2);
								
								if(($jumlah_query % $jumlah_perpage) > 0){
									$jumlah = ($jumlah_query / $jumlah_perpage)+1;
								}else{
									$jumlah = $jumlah_query / $jumlah_perpage;
								}

								for ($i=1;$i<=$jumlah;$i++){

									if($_GET['h'] == null || $_GET['h'] == ''){
										$hal = 1;
									}else{
										$hal = $_GET['h'];
									}	

									$max = $hal + 5;
									$min = $hal - 4;
									if($i <= $max && $i >= $min){
										if($hal == $i){
											echo "<li class='active'><span class='current'>$i</span></li>";
										}else{
											echo "<li><a href='#' data-hal='$i' class='page-a'>$i</a></li>";
										}
									}
								}
							?>	
						</ul>
					</div>
				</div>
                <?php
    }else{
?>				
				<!--Rujuk Internal-->
				<div class="tmp_form_rujuk">
					<div class="table-responsive">
						<!-- <p style="font-size: 20px; font-weight: bold;" class="judul">Rujuk Internal</p> -->
						<table class="table-judul">
							<thead>
								<tr>
									<th width="3%">No.</th>
									<th width="15%">Tanggal Daftar</th>
									<th width="23%">Nama Pasien</th>
									<th width="5%">L/P</th>
									<th width="10%">Umur</th>
									<th width="10%">Cara Bayar</th>
									<th width="7%">Antrian</th>
									<th width="23%">Keterangan</th>
									<th width="5%">#</th>
								</tr>
							</thead>
							<tbody>
								<?php
									if($_GET['tgl'] != ''){
										$tglperiksa = date('Y-m-d', strtotime($_GET['tgl']));
									}else{
										$tglperiksa = date('Y-m-d');
									}

                                    $nama = $_GET['nama'];
									if($nama != null){
										$nama_str = " AND NamaPasien like '%$nama%'";
									}else{
										$nama_str = " ";
									}	

									$str = "SELECT *
									FROM `tbrujukinternal`  
									WHERE date(TanggalRujukan) = '$tglperiksa' AND SUBSTRING(NoRujukan,1,11) = '$kodepuskesmas' AND `StatusPemeriksaan`='Rujuk Internal'".$nama_str;
									$str2 = $str;
									// echo $str2;

									$query = mysqli_query($koneksi, $str2);
									while($data = mysqli_fetch_assoc($query)){
										$no = $no + 1;
										$noindex = $data['NoIndex'];
										$idpasienrj = $data['IdPasienrj'];
										$polirujukan = $data['PoliRujukan'];

										// tbpasienrj
										$datapasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj`='$idpasienrj' ORDER BY IdPasienrj"));
								?>		
									<tr class="btnprint" data-pel="<?php echo $data['PoliPertama'];?>" data-noreg="<?php echo $data['NoRegistrasi'];?>" data-idrj="<?php echo $data['IdPasienrj'];?>">
										<td style="text-align:right;"><?php echo $no;?></td>
										<td style="text-align:center;"><?php echo $data['TanggalRujukan'];?></td>
										<td style="text-align:left;">
											<?php echo $data['NamaPasien'];?>
											<span class="btn btn-sm btn-round btn-info"><?php echo $datapasienrj['PoliPertama'];?></span>
										</td>
										<td style="text-align:center;"><?php echo $datapasienrj['JenisKelamin'];?></td>
										<td style="text-align:left;">
											<?php
											if($data['UmurTahun'] > 0){
												echo $datapasienrj['UmurTahun']." th";
											}else{
												echo $datapasienrj['UmurBulan']." bl ".$datapasienrj['UmurHari']." hr";
											}
											?>
										</td>
										<td style="text-align:left;"><?php echo $datapasienrj['Asuransi'];?></td>							
										<td style="text-align:center;"><?php echo strtoupper($datapasienrj['NoAntrianPoli']);?></td>
										<?php if($pel == "POLI LABORATORIUM"){ ?>
										<td style="text-align:left;"><?php echo $datapasienrj['PoliPertama'];?></td>
										<?php }else{ ?>
										<td style="text-align:left;"><?php echo $datapasienrj['dokterBpjs'];?></td>
										<?php } ?>				
										<td style="text-align:center;">
											<a href="?page=poli_periksa_edit&id=<?php echo $datapasienrj['IdPasienrj'];?>&idps=<?php echo $datapasienrj['IdPasien'];?>&pelayanan=<?php echo $polirujukan;?>&cb=<?php echo $datapasienrj['Asuransi'];?>" class="btn btn-round btn-success"> <i class="fa fa-user-md (alias) faicon"></i></a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
<?php
    }
?>