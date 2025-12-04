<?php
include "config/helper_pasienrj.php";
$otoritas = explode(',',$_SESSION['otoritas']);
$idpasienrj = $_GET['id'];
$idps = $_GET['idps'];
$pelayanan = $_GET['pelayanan'];

// tbpasienrj
// echo "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idpasienrj'";
$query = mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idpasienrj'");
$datapasienrj = mysqli_fetch_assoc($query);
$noregistrasi = $datapasienrj['NoRegistrasi'];
$jeniskunjungan = $datapasienrj['JenisKunjungan'];
$kdprovider = $datapasienrj['kdprovider'];
$klaster = $datapasienrj['Klaster'];
$siklushidup = $datapasienrj['SiklusHidup'];

// ref_siklushidup
// echo "SELECT * FROM `ref_siklushidup` WHERE `Nama`='$siklushidup'";
$dtsiklushidup = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_siklushidup` WHERE `Nama`='$siklushidup'"));

// tbkk
$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbkk` WHERE `NoIndex` = '$datapasienrj[NoIndex]'"));

// ec_subdistricts
$dt_subdis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `subdis_name` FROM `ec_subdistricts` WHERE `subdis_id`='$datakk[Kelurahan]'"));
if($dt_subdis['subdis_name'] != ''){
	$kelurahan = $dt_subdis['subdis_name'];
}else{
	$kelurahan = $datakk['Kelurahan'];
}

// ec_districts
$dt_dis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `dis_name` FROM `ec_districts` WHERE `dis_id`='$datakk[Kecamatan]'"));
if($dt_dis['dis_name'] != ''){
	$kecamatan = $dt_dis['dis_name'];
}else{
	$kecamatan = $datakk['Kecamatan'];
}

// ec_cities
$dt_citi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `city_name` FROM `ec_cities` WHERE `city_id`='$datakk[Kota]'"));
if($dt_citi['city_name'] != ''){
	$kota_ps = $dt_citi['city_name'];
}else{
	$kota_ps = $datakk['Kota'];
}

if($datakk['Alamat'] != ''){
	$alamat = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
	strtoupper($kelurahan).", ".strtoupper($kecamatan).", ".strtoupper($kota_ps);
}else{
	$alamat = "Tidak ditemukan";
}

// tbpasien
$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `NoCM` = '$datapasienrj[NoCM]'"));

// update waktu periksa awal
$info = getdate();
$date = $info['mday'];
$month = $info['mon'];
$year = $info['year'];
$hour = $info['hours'];
$min = $info['minutes'];
$sec = $info['seconds'];
$current_date = "$year-$month-$date $hour:$min:$sec";

// mysqli_query($koneksi, "UPDATE `$tbwaktupelayanan` SET `PemeriksaanAwal`=NOW() WHERE `NoRegistrasi` = '$noregistrasi'");
mysqli_query($koneksi, "UPDATE `$tbwaktupelayanan` SET `PemeriksaanAwal`='$current_date' WHERE `NoRegistrasi` = '$noregistrasi'");

// bpjs
$nokartubpjs = $datapasienrj['nokartu'];
$nokunjunganbpjs = $datapasienrj['NoKunjunganBpjs'];
$sts_resep = $_GET['sts_resep'];

// pelayanan
if($pelayanan == 'POLI ANAK'){ $polis = 'tbpolianak';
}else if($pelayanan == 'POLI BERSALIN'){ $polis = 'tbpolibersalin';
}else if($pelayanan == 'POLI GIGI'){ $polis = "tbpoligigi_".str_replace(' ', '', $namapuskesmas);
}else if($pelayanan == 'POLI GIZI'){ $polis = 'tbpoligizi';
}else if($pelayanan == 'POLI HIV'){ $polis = 'tbpolihiv';	
}else if($pelayanan == 'POLI IMUNISASI'){ $polis = 'tbpoliimunisasi';
}else if($pelayanan == 'POLI ISOLASI'){ $polis = 'tbpoliisolasi';	
}else if($pelayanan == 'POLI KB'){ $polis = 'tbpolikb';
}else if($pelayanan == 'POLI KIA'){ $polis = "tbpolikia_".str_replace(' ', '', $namapuskesmas);
}else if($pelayanan == 'POLI KIR'){ $polis = 'tbpolikir';
}else if($pelayanan == 'POLI LANSIA'){ $polis = "tbpolilansia_".str_replace(' ', '', $namapuskesmas);
}else if($pelayanan == 'POLI MTBS'){ $polis = "tbpolimtbs_".str_replace(' ', '', $namapuskesmas);
}else if($pelayanan == 'POLI PDP'){ $polis = 'tbpolipdp';
}else if($pelayanan == 'POLI PROLANIS'){ $polis = 'tbpoliprolanis';
}else if($pelayanan == 'POLI INFEKSIUS'){ $polis = 'tbpoliinfeksius';
}else if($pelayanan == 'POLI SCREENING'){ $polis = 'tbpoliscreening';		
}else if($pelayanan == 'POLI SKD'){ $polis = 'tbpoliskd';
}else if($pelayanan == 'POLI TB DOTS' OR $pelayanan == 'POLI TB'){
	if($kota == 'KOTA TARAKAN'){ $polis = 'tbpolitb'; }else{ $polis = 'tbpolitbdots'; }
}else if($pelayanan == 'POLI UGD' || $pelayanan == 'POLI TINDAKAN'){ $polis = 'tbpolitindakan';
}else if($pelayanan == 'POLI UMUM'){ $polis = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
}else if($pelayanan == 'RAWAT INAP'){ $polis = 'tbpolirawatinap';
}else if($pelayanan == 'POLI LABORATORIUM'){ $polis = 'tbpolilaboratorium';
}else if($pelayanan == 'NURSING CENTER'){ $polis = 'tbpolinursingcenter';	
}			

// select tbpoli
if ($pelayanan == 'POLI KB'){
	$querypolisemua = mysqli_query($koneksi,"SELECT * FROM `tbpolikb_kunjunganulang` WHERE `NoPemeriksaan` = '$noregistrasi'");
	$polisemua = mysqli_fetch_assoc($querypolisemua);
}else{
	$querypolisemua = mysqli_query($koneksi,"SELECT * FROM `".$polis."` WHERE `NoPemeriksaan` = '$noregistrasi'");
	$polisemua = mysqli_fetch_assoc($querypolisemua);
}

?>

<style>
	.tabel_isi{
		background: #fff;
		color: #000;
		padding: 5px 10px;
		text-align: center;
	}
	.autocomplete-suggestions {
		width: 500px !important;
	}
	.table-responsive{
		overflow: hidden;
	}
	.kotak_panels i{
		color: #f5f5f5;
		border:7px solid #f2f2f2;
		padding:10px 12px;
		/* border-radius: 50%; */
        margin: 15px !important;
	}
</style>

<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-3">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h3 class="text-white fw-bold">
					<i class="icon-people"></i> <?php echo str_replace('POLI ','PELAYANAN ',$pelayanan)." | ";?>
					<i class='fas fa-tags'></i> <?php echo " ".$klaster." - ".$siklushidup;?>
				</h3>
			</div>
			<div class="ml-md-auto py-2 py-md-0">
				<a href="index.php?page=poli" class="btn btn-primary btn-round">Kembali</a>
			</div>
		</div>
	</div>
</div>

<div class="hasilmodal"></div>

<form action="poli_periksa_proses.php" method="post">
	<div class="mt-1">	
		<input type="hidden" class="getpelayanan" value="<?php echo $_GET['pelayanan'];?>">
		<div class="row" style="padding: 30px;">	
			<div class="col-sm-8">
				<table class="table-judul" style="margin: auto;">
					<tr>
						<td class="nocm" style="display:none"><?php echo $datapasienrj['NoCM'];?></td>
						<td class="noregistrasi" style="display:none"><?php echo $datapasienrj['NoRegistrasi'];?></td>
						<td class="pelayanan" style="display:none"><?php echo $datapasienrj['PoliPertama'];?></td>
					</tr>
				</table>
				<div class="card card-dark bg-primary-gradient">
					<div class="card-body skew-shadow">									
						<div class="row">
							<div class="col-12 pr-0">
								<h3 class="fw-bold mb-1">
									<?php echo strtoupper($datapasienrj['NamaPasien']." / KK.".$datakk['NamaKK']);?>
									<span class="badge badge-success" style='padding: 6px; font-size: 14px;'><?php echo substr($datapasienrj['NoIndex'],-10);?></span>
								</h3>
								<div class="text-medium text-uppercase fw-bold op-8">
									<?php 
										if($datapasien['NoAsuransi'] == null || $datapasien['NoAsuransi'] == 0){ 
											$noasuransi = "<span style='color:yellow;font-weight:bold'>Belum Terdaftar</span>";
										}else{ 
											$noasuransi = $datapasien['NoAsuransi'];
										}

										if($datakk['Telepon'] != ''){
											$telp = $datakk['Telepon'];
										}else{
											if($datapasien['Telpon'] != ''){
												$telp = $datapasien['Telpon'];
											}else{
												$telp = "<span style='color:yellow;font-weight:bold'>Belum Diinputkan</span>";
											}	
										}	

										echo $datapasien['Nik']."<br/>".
										$noasuransi."<br/>".
										$datapasienrj['Asuransi']."<br/>".
										date('d-m-Y', strtotime($datapasien['TanggalLahir'])).", ".$datapasienrj['UmurTahun']." Th ".$datapasienrj['UmurBulan']." Bl ".$datapasienrj['UmurHari']."<br/>".
										$alamat."<br/>".
										$telp;
									?>
								</div>
							</div>
						</div>
					</div>
				</div>				
			</div>

			<div class="col-sm-2">
				<a href='?page=suratketerangan&idrj=<?php echo $idpasienrj;?>' target="_blank" style="color:blue !important; text-decoration:none;">
					<div class="card card-dark bg-info-gradient">
						<div class="card-body skew-shadow">
							<div class="kotak_panels greens" align="center">
								<i class="fas fa-print fa-5x" style="margin-top: 0px;"></i>
								<div class="text-medium text-uppercase fw-bold op-8">Kir Sehat</div>
                            </div>
						</div>
					</div>	
				</a>			
			</div>

			<div class="col-sm-2">
				<a href='?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $dtsiklushidup['IdSiklusHidup'];?>' target="_blank" style="color:blue !important; text-decoration:none;">						
					<div class="card card-dark bg-info-gradient">
						<div class="card-body skew-shadow">
							<div class="kotak_panels greens" align="center">
								<i class="fas fa-random fa-5x" style="margin-top: 0px;"></i>
								<div class="text-medium text-uppercase fw-bold op-8">0/<?php echo $jmlformulir['JmlFoormulir']," Skrining";?></div>
                            </div>	
						</div>
					</div>
				</a>			
			</div>
		</div>
		<input type="hidden" class="lokasikota" value="<?php echo $kota;?>"><!-- untuk source getformtambahan-->
		<input type="hidden" name="status2" value="<?php echo $_GET['status'];?>">
		<input type="hidden" name="tptgl" value="<?php echo $_GET['tptgl'];?>">
		<input type="hidden" name="sts_resep" value="<?php echo $sts_resep;?>">
		<input type="hidden" name="kdprovider" value="<?php echo $kdprovider;?>">
		<input type="hidden" name="idpasien" value="<?php echo $datapasienrj['IdPasien'];?>">
		<input type="hidden" class="idpsnrj" name="idpasienrj" value="<?php echo $idpasienrj;?>">
		<input type="hidden" name="jeniskunjungan" value="<?php echo $datapasienrj['JenisKunjungan'];?>">
		<input type="hidden" name="nopemeriksaan" value="<?php echo $datapasienrj['NoRegistrasi'];?>">
		<input type="hidden" name="noregistrasi" class="noregistrasiclass" value="<?php echo $noregistrasi;?>">
		<input type="hidden" name="noindex" value="<?php echo $datapasienrj['NoIndex'];?>">
		<input type="hidden" name="nocm" value="<?php echo $datapasienrj['NoCM'];?>">
		<input type="hidden" name="umurtahun" value="<?php echo $datapasienrj['UmurTahun'];?>">
		<input type="hidden" name="umurbulan" value="<?php echo $datapasienrj['UmurBulan'];?>">
		<input type="hidden" name="asuransi" class="asuransicls" value="<?php echo $datapasienrj['Asuransi'];?>">
		<input type="hidden" name="nokartubpjs" value="<?php echo $nokartubpjs;?>">
		<input type="hidden" name="nokunjunganbpjs" class="nokunjunganbpjs" value="<?php echo $nokunjunganbpjs;?>">
		<input type="hidden" name="pelayanan" value="<?php echo $pelayanan;?>">
		<input type="hidden" name="poli_bpjs" value="<?php echo $datapasienrj['kdpoli'];?>">						
		<input type="hidden" name="nikps" value="<?php echo $datapasien['Nik'];?>">	

		<!-- 	
		<div class="alert alert-danger" style="display:none;">
			<strong></strong>
		</div> 
		-->

		<div class="mt--5">
			<div class="row" style="padding: 30px;">				
				<div class="col-md-8">					
					<ul class="nav nav-pills nav-secondary nav-pills1 nav-pills-no-bd nav-pills-icons justify-content-left noprint" id="pills-tab-with-icon" role="tablist">
						<li class="nav-item">
							<a class="nav-link active tabs1" id="pemeriksaan1" data-toggle="pill" href="#pemeriksaan_satu" role="tab" aria-controls="pemeriksaan_satu" aria-selected="true">
								Assesmen
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link tabs1" id="pemeriksaanvital" data-toggle="pill" href="#pemeriksaan_vital" role="tab" aria-controls="pemeriksaan_vital" aria-selected="true">
								Tanda Vital
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link tabs1" id="pemeriksaandiagnosa" data-toggle="pill" href="#pemeriksaan_diagnosa" role="tab" aria-controls="pemeriksaan_diagnosa" aria-selected="false">
								Diagnosa
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link tabs1" id="pemeriksaantherapy" data-toggle="pill" href="#pemeriksaan_therapy" role="tab" aria-controls="pemeriksaan_therapy" aria-selected="false">
								Therapy
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link tabs1" id="pemeriksaantindakan" data-toggle="pill" href="#pemeriksaan_tindakan" role="tab" aria-controls="pemeriksaan_tindakan" aria-selected="false">
								Tindakan
							</a>
						</li>

						<?php if($pelayanan == 'POLI KIA'){ ?>
						<li class="nav-item">
							<a class="nav-link tabs1" id="pemeriksaan5" data-toggle="pill" href="#pemeriksaan_lima" role="tab" aria-controls="pemeriksaan_lima" aria-selected="true">
								Nifas
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link tabs1" id="pemeriksaan6" data-toggle="pill" href="#pemeriksaan_enam" role="tab" aria-controls="pemeriksaan_enam" aria-selected="true">
								Catin
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link tabs1" id="pemeriksaan_persalinan" data-toggle="pill" href="#pemeriksaan_kia" role="tab" aria-controls="pemeriksaan_kia" aria-selected="false">
								Persalinan
							</a>
						</li>
						<?php } ?>	

						<li class="nav-item">
							<a class="nav-link tabs1" id="pemeriksaan3" data-toggle="pill" href="#pemeriksaan_tiga" role="tab" aria-controls="pemeriksaan_tiga" aria-selected="false">
								Simpan
							</a>
						</li>
					</ul>
					<br/>
					<div class="card">
						<div class="card-body">							
							<div class="tab-content mt-2 mb-3 noprint" id="pills-with-icon-tabContent">
								<div class="tab-pane fade show active" id="pemeriksaan_satu" role="tabpanel" aria-labelledby="pemeriksaan1">
									<h3 class="judul"><b>Anamnesa (Subjektive)</b></h3>
									<?php if($pelayanan != 'POLI LABORATORIUM'){ ?>
									<?php
										if($pelayanan == 'poli anak' || $pelayanan == 'POLI ANAK'){
											include "poli_anak.php";
										}else if($pelayanan == 'poli bersalin' || $pelayanan == 'POLI BERSALIN'){
											include "poli_bersalin.php";
										}else if($pelayanan == 'poli gigi' || $pelayanan == 'POLI GIGI'){
											include "poli_gigi.php";
										}else if($pelayanan == 'poli gizi' || $pelayanan == 'POLI GIZI'){
											include "poli_gizi.php";
										}else if($pelayanan == 'poli imunisasi' || $pelayanan == 'POLI IMUNISASI'){
											include "poli_imunisasi.php";
										}else if($pelayanan == 'poli isolasi' || $pelayanan == 'POLI ISOLASI'){
											include "poli_isolasi.php";	
										}else if($pelayanan == 'poli hiv' || $pelayanan == 'POLI HIV'){
											include "poli_hiv.php";	
										}else if($pelayanan == 'poli kb' || $pelayanan == 'POLI KB'){
											include "poli_kb.php";
										}else if($pelayanan == 'poli kia' || $pelayanan == 'POLI KIA'){
											include "poli_kia.php";
										}else if($pelayanan == 'poli kir' || $pelayanan == 'POLI KIR'){
											include "poli_kir.php";									
										}else if($pelayanan == 'poli lansia' || $pelayanan == 'POLI LANSIA'){
											include "poli_lansia.php";
										}else if($pelayanan == 'poli mtbs' || $pelayanan == 'POLI MTBS'){
											include "poli_mtbs.php";
										}else if($pelayanan == 'poli pdp' || $pelayanan == 'POLI PDP'){
											include "poli_pdp.php";
										}else if($pelayanan == 'poli prolanis' || $pelayanan == 'POLI PROLANIS'){
											include "poli_prolanis.php";
										}else if($pelayanan == 'poli infeksius' || $pelayanan == 'POLI INFEKSIUS'){
											include "poli_infeksius.php";
										}else if($pelayanan == 'poli screening' || $pelayanan == 'POLI SCREENING'){
											include "poli_screening.php";							
										}else if($pelayanan == 'poli skd' || $pelayanan == 'POLI SKD'){
											include "poli_skd.php";
										}else if($pelayanan == 'poli tb dots' || $pelayanan == 'POLI TB DOTS' || $pelayanan == 'POLI tb' || $pelayanan == 'POLI TB'){
											include "poli_tb.php";
										}else if($pelayanan == 'poli ugd' || $pelayanan == 'POLI UGD' || $pelayanan == 'poli tindakan' || $pelayanan == 'POLI TINDAKAN'){
											include "poli_tindakan.php";
										}else if($pelayanan == 'poli umum' || $pelayanan == 'POLI UMUM'){
											include "poli_umum.php";
										}else if($pelayanan == 'rawat inap' || $pelayanan == 'RAWAT INAP'){
											include "poli_rawat_inap.php";
										}else if($pelayanan == 'nursing center' || $pelayanan == 'NURSING CENTER'){
											include "poli_nursing_center.php";
										}
									?>
								</div>	
								
								<div class="tab-pane fade" id="pemeriksaan_vital" role="tabpanel" aria-labelledby="pemeriksaanvital">
									<?php include "pemeriksaan_vital.php";?>
								</div>

								<div class="tab-pane fade" id="pemeriksaan_diagnosa" role="tabpanel" aria-labelledby="pemeriksaandiagnosa">
									<?php include "pemeriksaan_diagnosa.php";?>
								</div>

								<div class="tab-pane fade" id="pemeriksaan_therapy" role="tabpanel" aria-labelledby="pemeriksaantherapy">
									<?php include "pemeriksaan_therapy.php";?>									
								</div>

								<div class="tab-pane fade" id="pemeriksaan_tindakan" role="tabpanel" aria-labelledby="pemeriksaantindakan">
									<?php include "pemeriksaan_tindakan.php";?>
								</div>

								<!--Pemeriksa-->
								<div class="tab-pane fade" id="pemeriksaan_tiga" role="tabpanel" aria-labelledby="pemeriksaan3">
									<h3 class="judul"><b>Pemeriksa / Tenaga Kesehatan</b></h3>
										<div class="table-responsive">
											<table class="table-judul" width="100%">
												<tr>
													<td class="col-sm-3">
														Kesadaran
														<?php if(substr($datapasienrj['Asuransi'],0,4) == 'BPJS'){?>
															<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
																<img src='image/logo_bpjs_bulet.png' width="30px"/> 12
															</span>
														<?php } ?>
													</td>
													<td class="col-sm-9">
														<select name="kesadaran" class="form-control inputan kesadarancls" required>
															<option value="">--Pilih--</option>
															<option value="01" <?php if($polisemua['Kesadaran'] == '01'){echo "SELECTED";}?>>Compos mentis</option>
															<option value="02" <?php if($polisemua['Kesadaran'] == '02'){echo "SELECTED";}?>>Somnolence</option>
															<option value="03" <?php if($polisemua['Kesadaran'] == '03'){echo "SELECTED";}?>>Sopor</option>
															<option value="04" <?php if($polisemua['Kesadaran'] == '04'){echo "SELECTED";}?>>Coma</option>
														</select>
													</td>
												</tr>
													<?php
													if($jeniskunjungan == 'Rawat Jalan'){
														$stskunjungan = 'false';
													}else{
														$stskunjungan = 'true';
													}
													?>
												<tr>
													<td>Status Pulang</td>
													<td>
														<select name="statuspulang" class="form-control inputan statuspulang" required>
															<option value="">--Pilih--</option>
															<option value="3" <?php if($polisemua['StatusPulang'] == '3'){echo "SELECTED";}?>>Berobat Jalan</option>
															<option value="2" <?php if($polisemua['StatusPulang'] == '2'){echo "SELECTED";}?>>Pulang Paksa</option>
															<option value="1" <?php if($polisemua['StatusPulang'] == '1'){echo "SELECTED";}?>>Meninggal</option>
															<option value="4" <?php if($polisemua['StatusPulang'] == '4'){echo "SELECTED";}?>>Rujuk</option>
															<option value="5" <?php if($polisemua['StatusPulang'] == '5'){echo "SELECTED";}?>>Rujuk Internal</option>
															<option value="0" <?php if($polisemua['StatusPulang'] == '0'){echo "SELECTED";}?>>Sembuh</option>
															<option value="9" <?php if($polisemua['StatusPulang'] == '9'){echo "SELECTED";}?>>Lain-lain</option>
														</select>
													</td>
												</tr>
												<tr>
													<td>
														Tenaga Medis I (Hfis Pcare)
														<?php if(substr($datapasienrj['Asuransi'],0,4) == 'BPJS'){?>
															<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
																<img src='image/logo_bpjs_bulet.png' width="30px"/> 13
															</span>
														<?php } ?>
													</td>
													<td>
														<select name="tenagamedis1" class="form-control inputan tenagamedis1" >
															<option value="">--Pilih--</option>
															<?php 
																$kodepuskesmas = $_SESSION['kodepuskesmas'];
																$tbpasienperpegawai = 'tbpasienperpegawai_'.$kodepuskesmas;
																$querytm = mysqli_query($koneksi,"SELECT * FROM `$tbpasienperpegawai` WHERE `NoRegistrasi` = '$noregistrasi'");
																$tenagamedis = mysqli_fetch_assoc($querytm);

																$qrypegawai = mysqli_query($koneksi, "SELECT * FROM `tbpegawaibpjs` WHERE `kdpuskesmas` = '$kodepuskesmas' order by nmDokter ASC");
																while($pegawai = mysqli_fetch_assoc($qrypegawai)){
																	if($tenagamedis['NamaPegawai1'] == $pegawai['nmDokter']){
																	echo "<option value='".$pegawai['kdDokter']."' SELECTED>".$pegawai['nmDokter']."</option>";
																	}else{
																	echo "<option value='".$pegawai['kdDokter']."'>".$pegawai['nmDokter']."</option>";
																	}
																}
															?>
														</select>
														<input type="hidden" name="tenagamedisbpjs" class="namadokterbpjs" value="<?php echo $tenagamedis['NamaPegawai1'];?>">
														<span class="labeltenagamedis1" style="color:red;"></span>
													</td>
												</tr>
												<tr>
													<td>Paramedis I</td>
													<td>
														<select name="tenagamedis2" class="form-control inputan tenagamedis2">
															<option value="">--Pilih--</option>
															<?php
															$qrypegawai = mysqli_query($koneksi,"SELECT * FROM tbpegawai WHERE KodePuskesmas = '$kodepuskesmas' order by NamaPegawai ASC");
															while($pegawai = mysqli_fetch_assoc($qrypegawai)){
																if($tenagamedis['NamaPegawai2'] == $pegawai['NamaPegawai']){
																echo "<option value='".$pegawai['NamaPegawai']."' SELECTED>".$pegawai['NamaPegawai']."</option>";
																}else{
																echo "<option value='".$pegawai['NamaPegawai']."'>".$pegawai['NamaPegawai']."</option>";
																}
															}
															?>
														</select>

														<span class="labeltenagamedis2" style="color:red;"></span>
													</td>
												</tr>
												<tr>
													<td>Paramedis II</td>
													<td>
														<select name="tenagamedis3" class="form-control inputan tenagamedis3">
															<option value="">--Pilih--</option>
															<?php 
																$qrypegawai2 = mysqli_query($koneksi,"SELECT * FROM tbpegawai WHERE KodePuskesmas = '$kodepuskesmas' order by NamaPegawai ASC");
																while($pegawai2 = mysqli_fetch_assoc($qrypegawai2)){
																	if($tenagamedis['NamaPegawai3'] == $pegawai2['NamaPegawai']){
																	echo "<option value='".$pegawai2['NamaPegawai']."' SELECTED>".$pegawai2['NamaPegawai']."</option>";
																	}else{
																	echo "<option value='".$pegawai2['NamaPegawai']."'>".$pegawai2['NamaPegawai']."</option>";
																	}
																}
															?>
														</select>
														<span class="labeltenagamedis3" style="color:red;"></span>
													</td>
												</tr>
											</table><hr/>
											<table class="table statuspulangform"></table>
										</div>
									<?php
									}else{
									?>
										<!--Poli Laboratorium-->
										<table class="table-judul" width="100%">
											<thead>
												<tr>
													<th width="5%">No.</th>
													<th width="5%">Id.</th>
													<th width="40%">Jenis Tindakan</th>
													<th width="20%">Kelompok Tindakan</th>
													<th width="20%">Hasil</th>
												</tr>
											</thead>
											<tbody id="labpil">
											<?php
											$no = 0;
											$str_tindakan_detail = mysqli_query($koneksi,"SELECT * FROM `$tbtindakanpasien` WHERE `NoRegistrasi`='$_GET[no]'");
											while($dt_tindd = mysqli_fetch_assoc($str_tindakan_detail)){
												?>
												<tr>
													<td><?php echo $no = $no + 1;?></td>
													<td><?php echo $dt_tindd['IdTindakan'];?></td>
													<td><?php echo $dt_tindd['JenisTindakan'];?></td>
													<td><?php echo $dt_tindd['KelompokTindakan'];?></td>
													<td><input type="text" name="hasilkdtindakan[<?php echo $dt_tindd['IdTindakan'];?>]" value="<?php echo $dt_tindd['Keterangan'];?>" class="form-control"></td>
													<input type="hidden" name="jenistindakan[<?php echo $dt_tindd['IdTindakan'];?>]" value="<?php echo $dt_tindd['JenisTindakan'];?>" class="form-control">
													<input type="hidden" name="kelompoktindakan[<?php echo $dt_tindd['IdTindakan'];?>]" value="<?php echo $dt_tindd['KelompokTindakan'];?>" class="form-control">
												</tr>
												<?php
												$idtind[] = $dt_tindd['IdTindakan'];
											}
											?>
											<input type="hidden" value="<?php echo implode(',',$idtind);?>" name="idtindakan"/>
											</tbody>
										</table>

										<?php
										$str_kesadaran = "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idpasienrj'";
										$str_kesadaran_dtl = mysqli_query($koneksi, $str_kesadaran);
										$dt_kesadaran = mysqli_fetch_assoc($str_kesadaran_dtl);
										?>
										<!--Pemeriksa-->
										<div class="tab-pane" id="pemeriksa">
											<div class="box border">
												<div class="box-body">
													<div class="table-responsive">
														<table class="table-judul" width="100%">
															<tr>
																<td class="col-sm-2">Kesadaran</td>
																<td class="col-sm-10">
																	<select name="kesadaran" class="form-control" required>
																		<option value="">--Pilih--</option>
																		<option value="01" <?php if($dt_kesadaran['StatusPasien'] == '01'){echo "SELECTED";}?>>Compos mentis</option>
																		<option value="02" <?php if($dt_kesadaran['StatusPasien'] == '02'){echo "SELECTED";}?>>Somnolence</option>
																		<option value="03" <?php if($dt_kesadaran['StatusPasien'] == '03'){echo "SELECTED";}?>>Sopor</option>
																		<option value="04" <?php if($dt_kesadaran['StatusPasien'] == '04'){echo "SELECTED";}?>>Coma</option>
																	</select>
																</td>
															</tr>
															<tr>
																<td>Status Pulang</td>
																<td>
																	<select name="statuspulang" class="form-control statuspulang" required>
																		<option value="">--Pilih--</option>
																		<option value="1" <?php if($dt_kesadaran['StatusPulang'] == '1'){echo "SELECTED";}?>>Meninggal</option>
																		<option value="3" <?php if($dt_kesadaran['StatusPulang'] == '3'){echo "SELECTED";}?>>Berobat Jalan</option>
																		<option value="4" <?php if($dt_kesadaran['StatusPulang'] == '4'){echo "SELECTED";}?>>Rujuk</option>
																		<option value="5" <?php if($dt_kesadaran['StatusPulang'] == '5'){echo "SELECTED";}?>>Rujuk Internal</option>
																	</select>
																</td>
															</tr>
															<tr>
																<td>Tenaga Lab.</td>
																<td>
																	<select name="tenagalab" class="form-control tenagalab">
																		<?php
																		$kdpuskesmas = $_SESSION['kodepuskesmas'];
																		$qrypegawai_lab = mysqli_query($koneksi,"SELECT * FROM `tbpegawai` WHERE `KodePuskesmas` = '$kdpuskesmas'");
																		while($pegawai_lab = mysqli_fetch_assoc($qrypegawai_lab)){
																			echo "<option value='".$pegawai_lab['NamaPegawai']."'>".$pegawai_lab['NamaPegawai']."</option>";
																		}
																		?>
																	</select>
																	<span class="labeltenagalab" style="color:red;"></span>
																</td>
															</tr>
														</table>
														<table class="table statuspulangform"></table>
													</div>
												</div>
											</div>
										</div>
									<?php
									}
									?>
									<button type="submit" class="btn btn-round btn-success btnsimpan btnsimpanperiksa">Simpan Pemeriksaan</button>
								</div>

								<!-- <div class="tab-pane fade" id="pemeriksaan_lima" role="tabpanel" aria-labelledby="pemeriksaan5">
									<h3 class="judul"><b>Pemeriksaan Nifas</b></h3>
									<?php //include "poli_periksa_nifas.php";?>
								</div>

								<div class="tab-pane fade" id="pemeriksaan_enam" role="tabpanel" aria-labelledby="pemeriksaan6">
									<h3 class="judul"><b>Pemeriksaan Catin</b></h3>
									<?php //include "poli_periksa_catin.php";?>							
								</div>

								<div class="tab-pane fade" id="pemeriksaan_kia" role="tabpanel" aria-labelledby="pemeriksaan_persalinan">
									<h3 class="judul"><b>Riwayat Persalinan</b></h3>
									<?php //include "poli_periksa_persalinan.php";?>														
								</div> -->
							</div>	
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<a href="?page=rekam_medis_pasien_detail&idprj=<?php echo $idpasienrj;?>&idps=<?php echo $idps;?>&ply=<?php echo $pelayanan;?>&sts=Antri&tptgl=" class="btn btn-sm btn-success" style="float:right;" target="_blank">Lihat Semua</a>
					<h3 class="judul"><b>Riwayat Kesehatan Pasien</b></h3>				
					<div class="table-responsive">
						<table class="table-judul" width="100%">
							<?php
							$jumlah_perpage = 5;
		
							if($_GET['h']==''){
								$mulai=0;
							}else{
								$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}

							$no = 0;
								
							if($datapasienrj['IdPasien'] == '0'){
								// $tbpasienrj, status pasien 1 Kunjungan sakit (update 11/01/2024)
								$str = "SELECT * FROM `$tbpasienrj` WHERE `nokartu`='$datapasienrj[nokartu]' AND `StatusPasien`='1'";
								$str_riwayat = $str." ORDER BY IdPasienrj DESC LIMIT $mulai,$jumlah_perpage";
							}else{
								// $tbpasienrj, status pasien 1 Kunjungan sakit (update 10/09/2023)
								$str = "SELECT * FROM `$tbpasienrj` WHERE `IdPasien`='$datapasienrj[IdPasien]' AND `StatusPasien`='1'";
								$str_riwayat = $str." ORDER BY IdPasienrj DESC LIMIT $mulai,$jumlah_perpage";
							}
							// echo $str;

							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}

							$queryriwayat = mysqli_query($koneksi, $str_riwayat);
							while($riwayat = mysqli_fetch_assoc($queryriwayat)){
								$no = $no + 1;
								$idprj = $riwayat['IdPasienrj'];
								$noregs = $riwayat['NoRegistrasi'];
								$noidx = $riwayat['NoIndex'];
								$pelayanan = $riwayat['PoliPertama'];
								
								// cek status pulang
								if ($riwayat['StatusPulang'] == '3'){$statusplg='Berobat Jalan';}else{$statusplg='Rujuk Lanjut';}
																	
								// cek diagnosa pasien
								$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `IdPasienrj` = '$idprj'";
								$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
								while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
									$dtdiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
									$array_data[$noregs][] = "<b>".$data_diagnosapsn['KodeDiagnosa']."</b> ".$dtdiagnosa['Diagnosa'];
								}
								if ($array_data[$noregs] != ''){
									$data_dgs = implode("<br/>", $array_data[$noregs]);
								}else{
									$data_dgs = "";
								}

								// cek therapy
								$str_therapy = "SELECT * FROM `$tbresepdetail` WHERE `IdPasienrj`='$idprj'";
								$query_therapy = mysqli_query($koneksi, $str_therapy);
								while($dt_therapy = mysqli_fetch_array($query_therapy)){
									$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaBarang` FROM `$tbapotikstok` WHERE `KodeBarang` = '$dt_therapy[KodeBarang]'"));
									$array_therapy[$no][] = $dtobat['NamaBarang'].", JML:".$dt_therapy['jumlahobat'].", (".$dt_therapy['AnjuranResep'].")";
								}
								if ($array_therapy[$no] != ''){
									$terapi = implode("<br/>", $array_therapy[$no]);
								}else{
									$terapi = "";
								}

								// cek pelayanan
								if($pelayanan == 'POLI ANAK'){
									$tbpoli = 'tbpolianak';
								}else if($pelayanan == 'POLI BERSALIN'){
									$tbpoli = 'tbpolibersalin';
								}else if($pelayanan == 'POLI GIGI'){
									$tbpoli = "tbpoligigi_".str_replace(' ', '', $namapuskesmas);
								}else if($pelayanan == 'POLI GIZI'){
									$tbpoli = 'tbpoligizi';
								}else if($pelayanan == 'POLI HIV'){
									$tbpoli = 'tbpolihiv';	
								}else if($pelayanan == 'POLI IMUNISASI'){
									$tbpoli = 'tbpoliimunisasi';
								}else if($pelayanan == 'POLI ISOLASI'){
									$tbpoli = 'tbpoliisolasi';
								}else if($pelayanan == 'POLI KIR'){
									$tbpoli = 'tbpolikir';
								}else if($pelayanan == 'POLI KB'){
									$tbpoli = 'tbpolikb';
								}else if($pelayanan == 'POLI KIA'){
									$tbpoli = "tbpolikia_".str_replace(' ', '', $namapuskesmas);
								}else if($pelayanan == 'POLI LANSIA'){
									$tbpoli = "tbpolilansia_".str_replace(' ', '', $namapuskesmas);
								}else if($pelayanan == 'POLI MTBS'){
									$tbpoli = "tbpolimtbs_".str_replace(' ', '', $namapuskesmas);
								}else if($pelayanan == 'POLI PANDU PTM'){
									$tbpoli = 'tbpolipanduptm';
								}else if($pelayanan == 'POLI PROLANIS'){
									$tbpoli = 'tbpoliprolanis';
								}else if($pelayanan == 'POLI INFEKSIUS'){
									$tbpoli = 'tbpoliinfeksius';
								}else if($pelayanan == 'POLI SCREENING'){
									$tbpoli = 'tbpoliscreening';		
								}else if($pelayanan == 'POLI SKD'){
									$tbpoli = 'tbpoliskd';
								}else if($pelayanan == 'POLI TB DOTS'){
									$tbpoli = 'tbpolitb';
								}else if($pelayanan == 'POLI UGD' || $pelayanan == 'POLI TINDAKAN'){
									$tbpoli = 'tbpolitindakan';
								}else if($pelayanan == 'POLI UMUM'){
									$tbpoli = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
								}else if($pelayanan == 'RAWAT INAP'){
									$tbpoli = 'tbpolirawatinap';
								}else if($pelayanan == 'POLI LABORATORIUM'){
									$tbpoli = 'tbpolilaboratorium';
								}else if($pelayanan == 'NURSING CENTER'){
									$tbpoli = 'tbpolinursingcenter';	
								}
								$pelayanan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Anamnesa`,`Keluhan` FROM `$tbpoli` WHERE `IdPasienrj` = '$idprj'"));
							
								// vital sign
								$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idprj'";
								$dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
							?>
									
								<tr>
									<td align="center" class="noregistrasi" style="display:none"><?php echo $riwayat['NoRegistrasi'];?></td>
									<td class="nocm_riwayat" style="display:none"><?php echo $riwayat['NoCM'];?></td>
									<td align="left" class="poli_pertama" style="display:none"><?php echo $riwayat['PoliPertama'];?></td>
								</tr>

								<div class="formbg_green">
									<p style="line-height: 16px; font-size:12px;">
									<b>Tgl.Registrasi :</b>
										<?php echo $riwayat['TanggalRegistrasi'];?><br/>
										<b>Pelayanan :</b>
										<?php echo $riwayat['PoliPertama'];?><br/>
										<b>Keluhan :</b>
										<?php echo $dtvs['Keluhan'];?><br/>
										<b>Anamnesa :</b>
										<?php echo $dtvs['Anamnesa'];?><br/>										
										<b>Vitalsign</b><br/>
										<?php 
											// vital sign                                                
											$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idprj'";
											$cekvitaslsign = mysqli_num_rows(mysqli_query($koneksi, $strvs));
											if($cekvitaslsign > 0){
												$dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
												echo "<b>Tensi : </b>".$dtvs['Sistole']." / ".$dtvs['Diastole']."<br/>".
												"<b>Suhu Tubuh : </b>".$dtvs['SuhuTubuh']."<br/>".
												"<b>Tinggi Badan : </b>".$dtvs['TinggiBadan']."<br/>".
												"<b>Berat Badan : </b>".$dtvs['BeratBadan']."<br/>".
												"<b>HeartRate : </b>".$dtvs['HeartRate']."<br/>".
												"<b>RespiratoryRate : </b>".$dtvs['RespiratoryRate']."<br/>".
												"<b>LingkarPerut : </b>".$dtvs['LingkarPerut'];
											}else{
												echo "-";
											}
										?><br/>
										<b>Status Pulang :</b>
										<?php echo $statusplg;?><br/>
										<b>Diagnosa :</b>
										<?php if($data_dgs == ''){?>		
											<span class='badge badge-warning' style='font-style: italic; padding: 8px;'>Belum Diinputkan</span>
										<?php		
											}else{
												echo $data_dgs;	
											}
										?><br/>
										<b>Therapy :</b>
										<?php if($terapi == ''){?>		
											<span class='badge badge-warning' style='font-style: italic; padding: 8px;'>Belum Diinputkan</span>
										<?php		
											}else{
												echo $terapi;	
											}
										?>
									</p>
								</div>
							<?php
							}
							?>
						</table>
					</div><hr/>
					<ul class="pagination">
						<?php
							$query2 = mysqli_query($koneksi, $str);
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
										echo "<li><a href='?page=poli_periksa&id=$idpasienrj&pelayanan=$pelayanan&status=Antri&tptgl=&h=$i'>$i</a></li>";
									}
								}
							}
						?>	
					</ul>
				</div>
			</div>
		</div>
	</div>		
</form>

<script src="assets/js/jquery.js"></script>
<script src="assets/js/jquery.autocomplete.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
	
		$(".onfocusoutvalidation").focusout(function(){
			var ini = $(this).val();
			//alert(ini);
			if(ini == ''){
				$(this).css({
				border: "2px solid red"
				})
			}else{
				$(this).css({
				border: "2px solid #2fb72f"
				})
			}
		});

		$(".kesadaranlabpil").change(function(){
			var ini = $(this).val();
			//alert(ini);
			if(ini == 'Positif'){
				$.post( "get_pil_lab.php")
					.done(function( data ) {
						//alert(data);
						$( "#labpil" ).html( data );
					});
			}else{
				$("#labpil").html("");
			}
		});

		// Tindakan BPJS
		$(".status_racikan_bpjs").change(function(){
			$(".anjuranterapi").val("");
			$(".formanjuranlainnya").hide();
			var isi = $(this).val();
			if(isi == 'true'){
				$(".ket_racikantr").show();
				$(".shows").hide();
			}else{
				$(".ket_racikantr").hide();
				$(".shows").show();
			}
		});

		// therapy BPJS
		$('.therapybpjs').autocomplete({
			// serviceUrl: 'get_therapy.php/<?php echo str_replace(" ","-",$_GET['pelayanan']);?>/?keyword=',
			serviceUrl: 'get_therapy.php?keyword=',
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
				$(this).parent().find(".kodeobatbpjs").val(suggestion.kodeobatbpjs);
				$(this).parent().find(".kodeobatlokal").val(suggestion.kodeobatlokal);
				$(this).parent().find(".nobatch").val(suggestion.nobatch);
				$(this).parent().find(".namaobatbpjs").val(suggestion.namaobatbpjs);
				$(this).parent().find(".sediaobatbpjs").val(suggestion.sediaobatbpjs);
			}
		});

		$('.tindakanbpjs').autocomplete({
			serviceUrl: 'get_tindakan.php?asuransi=<?php echo $datapasienrj['Asuransi'];?>&keyword=',
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
				$(this).parent().find(".idtindakanbpjs").val(suggestion.idtindakanbpjs);
				$(this).parent().find(".namatindakanbpjs").val(suggestion.namatindakanbpjs);

				var carabayar = '<?php echo $datapasienrj['Asuransi'];?>';
				if(carabayar == 'BPJS PBI' || carabayar == 'BPJS NON PBI'){
					$(this).parent().parent().parent().find(".tariftindakanbpjs").val('0');
					$(this).parent().parent().parent().find(".keteranganbpjs").val(carabayar);
				}else{
					$(this).parent().parent().parent().find(".tariftindakanbpjs").val(suggestion.tariftindakanbpjs);
					$(this).parent().parent().parent().find(".keteranganbpjs").val('');
				}				
			}
		});

		$(".tenagamedis1").change(function(){
			var tenagamedis1 = $('.tenagamedis1 option:selected').html()
			$(".namadokterbpjs").val(tenagamedis1);
			var tenagamedis2 = $(".tenagamedis2").val();
			var tenagamedis3 = $(".tenagamedis3").val();
			var tenagafarmasi = $(".tenagafarmasi").val();
			if(tenagamedis1 == tenagamedis2 || tenagamedis1 == tenagamedis3 || tenagamedis1 == tenagafarmasi){
				$(".labeltenagamedis1").html("Tenaga medis tidak boleh lebih dari satu");
				$(this).val("");
			}else{
				$(".labeltenagamedis1").html("");
			}
		});
		$(".tenagamedis2").change(function(){
			var tenagamedis1 = $(".tenagamedis1").val();
			var tenagamedis2 = $(this).val();
			var tenagamedis3 = $(".tenagamedis3").val();
			var tenagafarmasi = $(".tenagafarmasi").val();
			if(tenagamedis2 == tenagafarmasi || tenagamedis2 == tenagamedis3 || tenagamedis2 == tenagamedis1){
				$(".labeltenagamedis2").html("Tenaga medis tidak boleh lebih dari satu");
				$(this).val("");
			}else{
				$(".labeltenagamedis2").html("");
			}
		});
		$(".tenagamedis3").change(function(){
			var tenagamedis1 = $(".tenagamedis1").val();
			var tenagamedis2 = $(".tenagamedis2").val();
			var tenagamedis3 = $(this).val();
			var tenagafarmasi = $(".tenagafarmasi").val();
			if(tenagamedis3 == tenagafarmasi || tenagamedis3 == tenagamedis2 || tenagamedis3 == tenagamedis1){
				$(".labeltenagamedis3").html("Tenaga medis tidak boleh lebih dari satu");
				$(this).val("");
			}else{
				$(".labeltenagamedis3").html("");
			}
		});
		$(".tenagafarmasi").change(function(){
			var tenagamedis1 = $(".tenagamedis1").val();
			var tenagamedis2 = $(".tenagamedis2").val();
			var tenagamedis3 = $(".tenagamedis3").val();
			var tenagafarmasi = $(this).val();
			if(tenagafarmasi == tenagamedis3 || tenagafarmasi == tenagamedis2 || tenagafarmasi == tenagamedis1){
				$(".labeltenagafarmasi").html("Tenaga medis tidak boleh lebih dari satu");
				$(this).val("");
			}else{
				$(".labeltenagafarmasi").html("");
			}
		});
		$('.btnmodalriwayat').click(function(){
			var nocm = $(this).parent().parent().find(".nocm_riwayat").html()
			var noregistrasi = $(this).parent().parent().find(".noregistrasi").html()
			var pelayanan = $(this).parent().parent().find(".poli_pertama").html()
			// alert(noregistrasi);
			$.post( "get_modal_riwayat.php", { no: noregistrasi, pel: pelayanan, cm: nocm})
			.done(function( data ) {
				$( ".hasilmodal" ).html( data );
				$('#ModalRiwayat').modal('show');
			});
		});
		$('.btnmodalpasien').click(function(){
			var nocm = $(this).parent().parent().find(".nocm").html()
			var noregistrasi = $(this).parent().parent().find(".noregistrasi").html()
			var pelayanan = $(this).parent().parent().find(".poli_pertama").html()
			// alert(nocm);
			$.post( "get_modal_pasien.php", { no: nocm, noreg: noregistrasi, pel: pelayanan})
			.done(function( data ) {
				$( ".hasilmodal" ).html( data );
				$('#ModalPasien').modal('show');

				$('.datepicker').datepicker({
					format: 'dd-mm-yyyy',
				});

				$('.kelurahan').autocomplete({
					serviceUrl: 'get_kelurahan.php',
					onSelect: function (suggestion){
						$(this).val(suggestion.value);
					}
				});
			});
		});
	
		$(".btnsimpanperiksa").click(function(){

			var keluhan = $(".keluhan").val();
			if(keluhan == ''){
				$(".modalbody-alert").text('Silahkan isi Keluhan terlebih dahulu...');
				$("#alert-modal").modal('show');
				$("#pemeriksaan1").click();
				$(".keluhan").focus();
				return false;
			}

			if(keluhan.length < 10){
				$(".modalbody-alert").text('Silahkan isi Keluhan minimal 10 karakter');
				$("#alert-modal").modal('show');
				$("#pemeriksaan1").click();
				$(".keluhan").focus();
				return false;
			}

			var anamnesa = $(".anamnesa").val();
			if(anamnesa == ''){
				$(".modalbody-alert").text('Silahkan isi Anamnesa terlebih dahulu...');
				$("#alert-modal").modal('show');
				$("#pemeriksaan1").click();
				$(".anamnesa").focus();
				return false;
			}

			if(anamnesa.length < 10){
				$(".modalbody-alert").text('Silahkan isi Anamnesa minimal 10 karakter');
				$("#alert-modal").modal('show');
				$("#pemeriksaan1").click();
				$(".anamnesa").focus();
				return false;
			}

			var diagnosa = $(".kode-diagnosa-input").val();
			if(diagnosa == ''){
				$(".modalbody-alert").text('Silahkan isi Diagnosa terlebih dahulu...');
				$("#alert-modal").modal('show');
				$("#pemeriksaan1").click();
				$(".anamnesa").focus();
				return false;
			}

			var opsiterapi = $("input[name='opsiresep']:checked").val();
			if(opsiterapi == 'diberikan resep'){
				var kodeobatlokal = $(".kodeobatlokal-input").val();
				if(kodeobatlokal == ''){
					$(".modalbody-alert").text('Silahkan isi Therapy terlebih dahulu...');
					$("#alert-modal").modal('show');
					$("#pemeriksaan1").click();
					$(".anamnesa").focus();
					return false;
				}
			}else if(opsiterapi == 'resep luar'){
				var terapi_luar_text = $(".terapi_luar_text").val();
				if(terapi_luar_text == ''){
					$(".modalbody-alert").text('Silahkan isi Therapy, Keterangan Resep Luar terlebih dahulu...');
					$("#alert-modal").modal('show');
					$("#pemeriksaan1").click();
					$(".anamnesa").focus();
					return false;
				}
			}		

			var sistole = $(".sistole").val();
			if(sistole == ''){
				$(".modalbody-alert").text('Sistole belum diisi, jangan isi angka 0 tidak akan bridging ke PCare..');
				$("#alert-modal").modal('show');
				$("#pemeriksaan1").click();
				return false;
			}
			if(sistole < 40){
				$(".modalbody-alert").text('Kriteria input Sistole : 40 - 250, silahkan edit...');
				$("#alert-modal").modal('show');
				$("#pemeriksaan1").click();
				return false;
			}

			var diastole = $(".diastole").val();
			if(diastole == ''){
				$(".modalbody-alert").text('Diastole belum diisi, jangan isi angka 0 tidak akan bridging ke PCare..');
				$("#alert-modal").modal('show');
				$("#pemeriksaan1").click();
				return false;
			}

			var suhutubuh = $(".suhutubuh").val();
			if(suhutubuh == ''){
				$(".modalbody-alert").text('Suhu Tubuh belum diisi, jangan isi angka 0 tidak akan bridging ke PCare..');
				$("#alert-modal").modal('show');
				$("#pemeriksaan1").click();
				return false;
			}

			var tinggibadan = $(".tinggibadan").val();
			if(tinggibadan == ''){
				$(".modalbody-alert").text('Tinggi Badan belum diisi, jangan isi angka 0 tidak akan bridging ke PCare..');
				$("#alert-modal").modal('show');
				$("#pemeriksaan1").click();
				return false;
			}

			var beratbadan = $(".beratbadan").val();
			if(beratbadan == ''){
				$(".modalbody-alert").text('Berat Badan belum diisi, jangan isi angka 0 tidak akan bridging ke PCare..');
				$("#alert-modal").modal('show');
				$("#pemeriksaan1").click();
				return false;
			}

			var heartrate = $(".heartrate").val();
			$(".alert-danger strong").html('');
			if(heartrate == ''){
				$(".modalbody-alert").text('Heartrate belum diisi, jangan isi angka 0 tidak akan bridging ke PCare..');
				$("#alert-modal").modal('show');
				$("#pemeriksaan1").click();
				return false;
			}else if(heartrate <= 30){
				$(".modalbody-alert").text('Gagal Simpan! Kriteria input Heart Rate : 30-160');
				$("#alert-modal").modal('show');
				$("#pemeriksaan1").click();
				return false;
			}else if(heartrate >= 160){
				$(".modalbody-alert").text('Gagal Simpan! Kriteria input Heart Rate : 30-160');
				$("#alert-modal").modal('show');
				$("#pemeriksaan1").click();
				return false;	
			}

			var resprate = $(".resprate").val();
			$(".alert-danger strong").html('');
			if(resprate == ''){
				$(".modalbody-alert").text('Resprate belum diisi, jangan isi angka 0 tidak akan bridging ke PCare...');
				$("#alert-modal").modal('show');
				$("#pemeriksaan1").click();
				return false;
			}else if(resprate <= 5){
				$(".modalbody-alert").text('Gagal Simpan! Kriteria input Resp. Rate : 5-80');
				$("#alert-modal").modal('show');
				$("#pemeriksaan1").click();
				return false;
			}else if(resprate >= 80){
				$(".modalbody-alert").text('Gagal Simpan! Kriteria input Resp. Rate : 5-80');
				$("#alert-modal").modal('show');
				$("#pemeriksaan1").click();
				return false;
			}

			var kunjungangigi = $(".kunjungangigi").val();
			if(kunjungangigi == ''){
				$(".modalbody-alert").text('Silahkan isi kunjungan gigi terlebih dahulu...');
				$("#alert-modal").modal('show');
				$("#pemeriksaan1").click();
				return false;
			}
			
			/*var sts_pemeriksaan_kia = $(".sts_pemeriksaan_kia").val();			
			if(sts_pemeriksaan_kia == 'Kehamilan'){
				var tt_kia = $(".tt_kia").val();
				if(tt_kia == ''){
					$(".alert-danger").removeAttr('style');
					$(".alert-danger strong").append('Silahkan isi Status TT terlebih dahulu...');
					$(".pemeriksaandasar a").click();
					return false;
				}
				
				var fe_kia = $(".fe_kia").val();
				if(fe_kia == ''){
					$(".alert-danger").removeAttr('style');
					$(".alert-danger strong").append('Silahkan isi Status FE terlebih dahulu...');
					$(".pemeriksaandasar a").click();
					return false;
				}
				
				var kunjungan_kehamilan = $(".kunjungan_kehamilan").val();
				if(kunjungan_kehamilan == ''){
					$(".alert-danger").removeAttr('style');
					$(".alert-danger strong").append('Silahkan isi Status Kunjungan Kehamilan terlebih dahulu...');
					$(".pemeriksaandasar a").click();
					return false;
				}
			}*/

			var frekuensinafas = $(".frekuensinafas").val();
			if(frekuensinafas == ''){
				$(".modalbody-alert").text('Silahkan isi Frekuensi Nafas pada form ISPA...');
				$("#alert-modal").modal('show');
				return false;
			}
		});

		$(".imt").focusout(function(){
			var isi = $(this).val();
			if(parseInt(isi) < 19){
				$(".statusimt").val("K");
			}else if(parseInt(isi) < 23){
				$(".statusimt").val("N");
			}else{
				$(".statusimt").val("L");
			}
		});

		$(".tinggibadancls, .beratbadancls, .imtcls").focusout(function(){
			var bb = $(".beratbadancls").val();
			var tb = $(".tinggibadancls").val();
			hitung_imt(bb,tb);
		});

		function hitung_imt(bb,tb){
			var tbs = parseInt(tb) / 100;
			if(bb == '' || tb == ''){
				$(".imtcls").val("");
			}else{
				var imt = parseInt(bb) / (tbs * tbs);
				$(".imtcls").val(imt.toFixed(2));
			}
		}

		$('.diagnosabpjs').autocomplete({
			serviceUrl: 'get_diagnosa_bpjs.php?keyword=',
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
				$(this).parent().find(".kodebpjs").val(suggestion.kode);
				$(this).parent().find(".diagnosahiddenbpjs").val(suggestion.diagnosa);
				$(this).parent().find(".spesialisbpjs").val(suggestion.spesialis);
			}
		});
		

		$(".sts_pemeriksaan_kia").change(function(){
			var isi = $(this).val();
			if(isi == 'Non Kehamilan'){
				$(".nonkehamilan_tmp").hide();
				$(".persalinan_tmp").hide();
				$(".nifas_tmp").hide();
				$(".catin_tmp").hide();
			}else{
				$(".nonkehamilan_tmp").show();
			}
			
			if(isi == 'Persalinan'){
				$(".nonkehamilan_tmp").hide();
				$(".persalinan_tmp").show();
				$(".nifas_tmp").hide();
				$(".catin_tmp").hide();
			}
			
			if(isi == 'Nifas'){
				$(".nonkehamilan_tmp").hide();
				$(".persalinan_tmp").hide();
				$(".nifas_tmp").show();
				$(".catin_tmp").hide();
			}
			
			if(isi == 'Catin'){
				$(".nonkehamilan_tmp").hide();
				$(".persalinan_tmp").hide();
				$(".nifas_tmp").hide();
				$(".catin_tmp").show();
			}			
		});

		$(".opsiterapi").change(function(){
			var isi = $(this).val();
			if(isi == 'konseling'){
				$(".terapi_luar_text").hide();
				$(".terapi_konseling_div").hide();
			}else if(isi == 'resep luar'){
				$(".terapi_konseling_div").hide();
				$(".terapi_luar_text").show();
			}else{
				$(".terapi_konseling_div").show();
				$(".terapi_luar_text").hide();
			}		
		});

		$(".tabs1").click(function(){
			var attrid = $(this).attr('id');
			$(".nav-pills2").find(".nav-link").removeClass('active');
			$(".nav-pills2").find("[id='" + attrid + "']").addClass('active');			
		});		
	});
</script>