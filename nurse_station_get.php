<?php
session_start();
error_reporting(1);
include "config/koneksi.php";
include "config/helper_pasienrj.php";
$otoritas = explode(',',$_SESSION['otoritas']);
$idpasienrj = $_GET['id'];

if($kota == "KOTA TARAKAN"){
	include "config/helper_bpjs_v4.php";	
}else{
	include "config/helper_bpjs.php";
}

// tbpasienrj
$query = mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idpasienrj'");
if(mysqli_num_rows($query ) > 0){
	$data = mysqli_fetch_assoc($query);
	$idpasien = $data['IdPasien'];
	$nocm = $data['NoCM'];
	$noindex = $data['NoIndex'];
	$noregistrasi = $data['NoRegistrasi'];
	$jeniskunjungan = $data['JenisKunjungan'];
	$kdprovider = $data['kdprovider'];
	$pelayanan = $data['PoliPertama'];
	$klaster = $data['Klaster'];
	$siklushidup = $data['SiklusHidup'];

	// ref_siklushidup
	$dtsiklushidup = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_siklushidup` WHERE `Nama`='$siklushidup'"));

	if($pelayanan == 'POLI ANAK'){
		$polis = 'tbpolianak';
	}else if($pelayanan == 'POLI BERSALIN'){
		$polis = 'tbpolibersalin';
	}else if($pelayanan == 'POLI GIGI'){
		$polis = "tbpoligigi_".str_replace(' ', '', $namapuskesmas);
	}else if($pelayanan == 'POLI GIZI'){
		$polis = 'tbpoligizi';
	}else if($pelayanan == 'POLI HIV'){
		$polis = 'tbpolihiv';	
	}else if($pelayanan == 'POLI IMUNISASI'){
		$polis = 'tbpoliimunisasi';
	}else if($pelayanan == 'POLI ISOLASI'){
		$polis = 'tbpoliisolasi';
	}else if($pelayanan == 'POLI KIR'){
		$polis = 'tbpolikir';
	}else if($pelayanan == 'POLI KB'){
		$polis = 'tbpolikb';
	}else if($pelayanan == 'POLI KIA'){
		$polis = "tbpolikia_".str_replace(' ', '', $namapuskesmas);
	}else if($pelayanan == 'POLI LANSIA'){
		$polis = "tbpolilansia_".str_replace(' ', '', $namapuskesmas);
	}else if($pelayanan == 'POLI MTBS'){
		$polis = "tbpolimtbs_".str_replace(' ', '', $namapuskesmas);
	}else if($pelayanan == 'POLI PANDU PTM'){
		$polis = 'tbpolipanduptm';
	}else if($pelayanan == 'POLI PROLANIS'){
		$polis = 'tbpoliprolanis';
	}else if($pelayanan == 'POLI INFEKSIUS'){
		$polis = 'tbpoliinfeksius';
	}else if($pelayanan == 'POLI SCREENING'){
		$polis = 'tbpoliscreening';		
	}else if($pelayanan == 'POLI SKD'){
		$polis = 'tbpoliskd';
	}else if($pelayanan == 'POLI TB DOTS'){
		$polis = 'tbpolitb';
	}else if($pelayanan == 'POLI UGD' || $pelayanan == 'POLI TINDAKAN'){
		$polis = 'tbpolitindakan';
	}else if($pelayanan == 'POLI UMUM'){
		$polis = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
	}else if($pelayanan == 'RAWAT INAP'){
		$polis = 'tbpolirawatinap';
	}else if($pelayanan == 'POLI LABORATORIUM'){
		$polis = 'tbpolilaboratorium';
	}else if($pelayanan == 'NURSING CENTER'){
		$polis = 'tbpolinursingcenter';	
	}			
	
	// select tbpoli
	if ($pelayanan == 'POLI KB'){
		$querypolisemua = mysqli_query($koneksi,"SELECT * FROM `tbpolikb_kunjunganulang` WHERE `IdPasienrj` = '$idpasienrj'");
		$polisemua = mysqli_fetch_assoc($querypolisemua);
	}else{
		$querypolisemua = mysqli_query($koneksi,"SELECT * FROM `".$polis."` WHERE `IdPasienrj` = '$idpasienrj'");
		$polisemua = mysqli_fetch_assoc($querypolisemua);
	}

	// tbkk
	$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbkk` WHERE `NoIndex` = '$noindex'"));

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
		$kota = $dt_citi['city_name'];
	}else{
		$kota = $datakk['Kota'];
	}

	if($datakk['Alamat'] != ''){
		$alamat_pasien = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
		strtoupper($kelurahan).", ".strtoupper($kecamatan).", ".strtoupper($kota);
		// echo $alamat_pasien;
	}else{
		$dtresep = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Alamat FROM `$tbresep` WHERE NoResep='$data_resep[NoResep]'"));
		$alamat_pasien = $dtresep['Alamat'];
		// echo $alamat_pasien;
	}

	// tbpasien
	$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `IdPasien` = '$idpasien'"));

	// update waktu periksa awal
	mysqli_query($koneksi,"UPDATE `$tbwaktupelayanan` SET `PemeriksaanAwal`=NOW() WHERE `NoRegistrasi` = '$noregistrasi'");

	// bpjs
	$nokartubpjs = $data['nokartu'];
	$nokunjunganbpjs = $data['NoKunjunganBpjs'];
	$sts_resep = $_GET['sts_resep'];
	$status = 'Antri';
	$tptgl = $_GET['tptgl'];
	?>

	<style>
		.font_tabel{
			font-size: 14px;
			font-family: "Poppins", sans-serif;
		}
		.tableborder tr{
			border-bottom: 1px solid #dbdbdb;
		}
		.tabel_judul th{
			background: #3bac9b;
			border-collapse: separate;
			font-size: 12px;
			line-height: 20px;
			text-align: center;
			padding: 5px 10px;
			color: #fff;
		}
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
	</style>

	<div class="hasilmodal"></div>

	<form action="nurse_station_periksa_proses.php" method="post" id="forminputhasil">
		<div class="mt-1">	
			<div class="row">
				<div class="col-sm-6">
					<table class="table-judul" style="margin: auto;">
						<tr>
							<td class="nocm" style="display:none"><?php echo $data['NoCM'];?></td>
							<td class="noregistrasi" style="display:none"><?php echo $data['NoRegistrasi'];?></td>
							<td class="pelayanan" style="display:none"><?php echo $data['PoliPertama'];?></td>
						</tr>
					</table>
					<div class="card card-dark bg-info-gradient">
						<div class="card-body skew-shadow">									
							<div class="row">
								<div class="col-12 pr-0">
									<h3 class="fw-bold mb-1"><?php echo strtoupper($data['NamaPasien']." / KK.".$datakk['NamaKK']);?></h3>
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
											$data['Asuransi']."<br/>".
											date('d-m-Y', strtotime($datapasien['TanggalLahir'])).", ".$data['UmurTahun']." Th ".$data['UmurBulan']." Bl ".$data['UmurHari']."<br/>".
											$alamat_pasien."<br/>".
											$telp;
										?>
									</div>
								</div>
							</div>
						</div>
					</div>				
				</div>

				<div class="col-sm-3">
					<a href='?page=suratketerangan&idrj=<?php echo $idpasienrj;?>' target="_blank" style="color:blue !important; text-decoration:none;">
						<div class="card card-dark bg-primary-gradient">
							<div class="card-body skew-shadow">
								<h3 class="py-2 mb-0">SURAT KETERANGAN <br/> KESEHATAN</h2>										
								<div class="row">
									<div class="col-12 pr-0">
										<div class="text-medium text-lowercase fw-bold op-8">6 Formulir</div>
									</div>
								</div>
								<br/>
								<button type="button" class="btn btn-round btn-xs btn-info btninfo" style="font-size: 12px; margin-top: -5px;"> Tampilkan Formulir</button>
							</div>
						</div>	
					</a>			
				</div>

				<div class="col-sm-3">
					<a href='?page=skrining&idrj=<?php echo $idpasienrj;?>&idsh=<?php echo $dtsiklushidup['IdSiklusHidup'];?>' target="_blank" style="color:blue !important; text-decoration:none;">						
						<div class="card card-dark bg-success-gradient">
							<div class="card-body skew-shadow">
								<h3 class="py-2 mb-0"><?php echo strtoupper($klaster." <br/> ".$siklushidup);?></h2>										
								<div class="row">
									<div class="col-12 pr-0">
										<div class="text-medium text-lowercase fw-bold op-8">0/<?php echo $jmlformulir['JmlFoormulir']," Skrining";?></div>
									</div>
								</div>
								<br/>
								<div class="btn btn-round btn-xs btn-success btnsimpan" style="font-size: 12px; margin-top: -5px;">Tampilkan Formulir</div>
							</div>
						</div>
					</a>			
				</div>
			</div>
		</div>
		<input type="hidden" class="lokasikota" value="<?php echo $kota;?>"><!-- untuk source getformtambahan-->
		<input type="hidden" name="status2" value="<?php echo $status;?>">
		<input type="hidden" name="tptgl" value="<?php echo $tptgl;?>">
		<input type="hidden" name="sts_resep" value="<?php echo $sts_resep;?>">
		<input type="hidden" name="kdprovider" value="<?php echo $kdprovider;?>">
		<input type="hidden" name="idpasien" value="<?php echo $data['IdPasien'];?>">
		<input type="hidden" name="idpasienrj" value="<?php echo $idpasienrj;?>">
		<input type="hidden" name="jeniskunjungan" value="<?php echo $data['JenisKunjungan'];?>">
		<input type="hidden" name="nopemeriksaan" value="<?php echo $data['NoRegistrasi'];?>">
		<input type="hidden" name="noregistrasi" class="noregistrasiclass" value="<?php echo $noregistrasi;?>">
		<input type="hidden" name="noindex" value="<?php echo $data['NoIndex'];?>">
		<input type="hidden" name="nocm" value="<?php echo $data['NoCM'];?>">
		<input type="hidden" name="umurtahun" value="<?php echo $data['UmurTahun'];?>">
		<input type="hidden" name="umurbulan" value="<?php echo $data['UmurBulan'];?>">
		<input type="hidden" name="asuransi" class="asuransicls" value="<?php echo $data['Asuransi'];?>">
		<input type="hidden" name="nokartubpjs" value="<?php echo $nokartubpjs;?>">
		<input type="hidden" name="nokunjunganbpjs" class="nokunjunganbpjs" value="<?php echo $nokunjunganbpjs;?>">
		<input type="hidden" name="pelayanan" value="<?php echo $pelayanan;?>">
		<input type="hidden" name="poli_bpjs" value="<?php echo $data['kdpoli'];?>">	

		<!-- 	
		<div class="alert alert-danger" style="display:none;">
			<strong></strong>
		</div> 
		-->

		<div class="mt-2">
			<div class="row">
				<div class="col-md-8">
					<div class="card">
						<div class="card-body">
							<ul class="nav nav-pills nav-secondary  nav-pills-no-bd nav-pills-icons justify-content-left noprint" id="pills-tab-with-icon" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="pemeriksaan1" data-toggle="pill" href="#pemeriksaan_satu" role="tab" aria-controls="pemeriksaan_satu" aria-selected="true">
										<i class="icon-layers"></i>
										Soap
									</a>
								</li>							
								<li class="nav-item">
									<a class="nav-link" id="pemeriksaan2" data-toggle="pill" href="#pemeriksaan_dua" role="tab" aria-controls="pemeriksaan_dua" aria-selected="false">
										<i class="icon-user-following"></i>
										Askep
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pemeriksaan3" data-toggle="pill" href="#pemeriksaan_tiga" role="tab" aria-controls="pemeriksaan_tiga" aria-selected="false">
										<i class="icon-people"></i>
										Pemeriksa
									</a>
								</li>
							</ul><br/>

							<div class="tab-content mt-2 mb-3 noprint" id="pills-with-icon-tabContent">
								<div class="tab-pane fade show active" id="pemeriksaan_satu" role="tabpanel" aria-labelledby="pemeriksaan1">
									<h3 class="judul"><b>Anamnesa (Subjektive)</b></h3>
									<?php										
										include "nurse_station_periksa.php";
									?>
								</div>	

								<div class="tab-pane fade" id="pemeriksaan_dua" role="tabpanel" aria-labelledby="pemeriksaan2">
									<h3 class="judul"><b>Asuhan Keperawatan</b></h3>
									<!--askep-->
									<div class="formbg">
										<div class="table-responsive">
											<table class="table-judul" width="100%">
												<tr>
													<td class="col-sm-11">
														<input type="text" class="form-control diagnosakeperawatan" placeholder="Ketikan Kode / Nama Diagnosa">
														<input type="hidden" class="form-control kodeaskep">
														<input type="hidden" class="form-control diagnosaaskep">
													</td>
													<td class="col-sm-1"><a type="button" class="btn btn-round btn-success tambah-diagnosa-keperawatan">SIMPAN</a></td>
												</tr>
											</table>
										</div><br/>
										<div class="table-responsive">
											<table class="table-judul">
												<thead>
													<tr>
														<th width="5%">KODE</th>
														<th width="30%">DIAGNOSA KEPERAWATAN</th>
														<th width="60%">TINDAKAN</th>
														<th width="5%">#</th>
													</tr>
												</thead>	
												<tbody>	
													<tr class="master-table-diagnosaaskep" style="display:none">
														<input type="hidden" class="kode-askep-diagnosa-input">
														<input type="hidden" class="nama-askep-diagnosa-input">
														<td class="kode-askep-html" align="center"></td>
														<td class="diagnosa-askep-html"></td>
														<td class="form_tambahan_askep"></td>
														<td align="center">
															<a class="btn btn-round btn-danger hapus-diagnosa-askep">HAPUS</a>
														</td>
													</tr>
													<?php
														$tbdiagnosaaskep = 'tbdiagnosaaskep_'.str_replace(' ', '', $namapuskesmas);
														$straskep = "SELECT * 
														FROM `$tbdiagnosaaskep` a JOIN `tbdiagnosakeperawatan` b ON a.KodeDiagnosa = b.KodeDiagnosa
														WHERE a.`NoRegistrasi`= '$noregistrasi' AND a.`NoCM`= '$nocm'";
														$queryaskep = mysqli_query($koneksi,$straskep);
														while($dtdiagnosaaskep = mysqli_fetch_assoc($queryaskep)){								
														
														// array kode diagnosa
														$arraykodediagnosa[] = $dtdiagnosaaskep['KodeDiagnosa'];
													?>
													<tr class="newbaris <?php echo $class;?>">
														<input type="hidden" class="kode-askep-diagnosa-input" name="kodediagnosaaskep[]" value="<?php echo $dtdiagnosaaskep['KodeDiagnosa'];?>">
														<input type="hidden" class="nama-askep-diagnosa-input" name="namadiagnosaaskep[]" value="<?php echo $dtdiagnosaaskep['NamaDiagnosa'];?>">
														<td align="center" class="kode-askep-html"><?php echo $dtdiagnosaaskep['KodeDiagnosa'];?></td>
														<td align="left" class="diagnosa-askep-html"><?php echo strtoupper($dtdiagnosaaskep['NamaDiagnosa']);//get_nama_diagnosa($dtdiagnosaaskep['KodeDiagnosa']);?></td>
														<td align="left" class="tindakan-askep-html"><?php echo $dtdiagnosaaskep['TindakanKeperawatan'];?></td>
														<td align="center">
															<a class="btn btn-round btn-danger hapus-diagnosa-edit">HAPUS</a>
														</td>
													</tr>
													<?php
														}
													?>
												</tbody>
											</table>
										</div><hr/>
										<div class="table-responsive">
											<table class="table">
												<tr>
													<td>Tindakan Keperawatan</td>
												</tr>
												<tr>
													<td><textarea name="tindakanaskep" class="form-control" placeholder="Tindakan Keperawatan"></textarea></td>
												</tr>
											</table>
										</div>
									</div>
								</div>	
								
								<div class="tab-pane fade" id="pemeriksaan_tiga" role="tabpanel" aria-labelledby="pemeriksaan3">
									<h3 class="judul"><b>Pemeriksa / Tenaga Kesehatan</b></h3>
										<!--Pemeriksa-->
										<div class="table-responsive">
											<table class="table-judul" width="100%">
												<tr>
													<td class="col-sm-3">
														Kesadaran
														<?php 
															if(substr($asuransi,0,4) == 'BPJS'){?>
															<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
																<img src='image/logo_bpjs_bulet.png' width="30px"/> 8 
															</span>
														<?php } ?>
													</td>
													<td class="col-sm-9">
														<select name="kesadaran" class="form-control" required>
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
														<select name="statuspulang" class="form-control statuspulang" required>
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
														<?php 
															if(substr($asuransi,0,4) == 'BPJS'){?>
															<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
																<img src='image/logo_bpjs_bulet.png' width="30px"/> 9 
															</span>
														<?php } ?>
													</td>
													<td>
														<select name="tenagamedis1" class="form-control tenagamedis1" >
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
														<input type="text" name="tenagamedisbpjs" class="namadokterbpjs">
														<span class="labeltenagamedis1" style="color:red;"></span>
													</td>
												</tr>
												<tr>
													<td>Paramedis I</td>
													<td>
														<select name="tenagamedis2" class="form-control tenagamedis2">
															<option value="">--Pilih--</option>
															<?php
															$kdpuskesmas = $_SESSION['kodepuskesmas'];
															$qrypegawai = mysqli_query($koneksi,"SELECT * FROM tbpegawai WHERE KodePuskesmas = '$kdpuskesmas' order by NamaPegawai ASC");
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
														<select name="tenagamedis3" class="form-control tenagamedis3">
															<option value="">--Pilih--</option>
															<?php
															$qrypegawai2 = mysqli_query($koneksi,"SELECT * FROM tbpegawai WHERE KodePuskesmas = '$kdpuskesmas' order by NamaPegawai ASC");
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
									<button type="button" class="btn btn-round btn-success btnsimpan btnsimpanperiksa2">SIMPAN PEMERIKSAAN</button>
								</div>
							</div>	
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<h3 class="judul"><b>Riwayat Kesehatan Pasien</b></h3>
					<?php
						// ctatus pasien 1 (Kunjungan Sakit)
						$str_riwayat = "SELECT * FROM `$tbpasienrj` WHERE `IdPasien`='$idpasien' AND `StatusPasien`='1' ORDER BY IdPasienrj DESC LIMIT 5";
						if($idpasien != 0){ // maksudnya bukan pasien yang daftar via onlen yang belum didaftarkan sebagai pasien baru
					?>					
					<div class="table-responsive">
						<table class="table-judul" width="100%">
							<?php
							$no = 0;
							$queryriwayat = mysqli_query($koneksi, $str_riwayat);
							while($riwayat = mysqli_fetch_assoc($queryriwayat)){
								$no = $no + 1;
								$idpasienrj_riwayat = $riwayat['IdPasienrj'];
								$pel = $riwayat['PoliPertama'];
								
								// menentukan status pulang
								if ($riwayat['StatusPulang'] == '3'){$statusplg='Berobat Jalan';}else{$statusplg='Rujuk Lanjut';}

								// vital sign
								$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idpasienrj_riwayat'";
								$cekvitaslsign = mysqli_num_rows(mysqli_query($koneksi, $strvs));
								$dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));
							?>
								
								<tr>
									<td align="center" class="noregistrasi" style="display:none;"><?php echo $riwayat['NoRegistrasi'];?></td>
									<td class="nocm_riwayat" style="display:none;"><?php echo $riwayat['NoCM'];?></td>
									<td class="poli_pertama" style="display:none;"><?php echo $riwayat['PoliPertama'];?></td>
								</tr>

								<div class="formbg" style="background: #ffe1bc;">
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
											if($cekvitaslsign > 0){
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
										<b>Status Pulang</b><br/>
										<?php echo $statusplg;?><br/>
									</p> 
									<!-- <a href="#" class="btn btn-sm btn-warning btn-block btnmodalriwayat">Lihat</a> -->
								</div>  
							<?php
							}
							?>
						</table>
					</div>
					<?php
					}
					?>										
				</div>
			</div>
		</div>
	</form>

	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/jquery.autocomplete.js"></script>
	<script src="assets_atlantis/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
	<script type="text/javascript">

		$(document).ready(function() {	


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

			$('.diagnosakeperawatan').autocomplete({
				serviceUrl: 'get_diagnosa_keperawatan.php?keyword=',
				onSelect: function (suggestion) {
					$(this).val(suggestion.value);
					$(this).parent().find(".kodeaskep").val(suggestion.kodeaskep);
					$(this).parent().find(".diagnosaaskep").val(suggestion.diagnosaaskep);
				}
			});
			$(".tambah-diagnosa-keperawatan").click(function(){
				var kode = $(".kodeaskep").val();
				var diagnosa = $(".diagnosaaskep").val();
				
				if(diagnosa == ''){
					alert("Diagnosa askep masih kosong...");
					return false;
				}
				if(kode == ''){
					alert("Kode diagnosa askep tidak valid...");
					return false;
				}
			
				var cl = $(".master-table-diagnosaaskep").clone(); // untuk mengcopy class master-table
				cl.removeAttr("style"); // untuk menghapus style di class master-table
				cl.removeClass("master-table-diagnosaaskep");
				cl.addClass("newbaris");
				
				// count click
				countdgclick = $(".newbaris").length + 1;
				if(countdgclick == '6'){
					alert("Sudah melebihi diagnosa yang boleh diinputkan...");
					$(".kodeaskep").val("");
					$(".diagnosaaskep").val("");
					return false;
				}
		
				// add text html
				cl.find(".kode-askep-html").html(kode); // untuk mengisi tr class kode-html
				cl.find(".diagnosa-askep-html").html(diagnosa);
				
				// add value
				var kodeinput = cl.find(".kode-askep-diagnosa-input");
				kodeinput.attr({name:"kodediagnosaaskep[]"});
				kodeinput.val(kode);
				
				var namadiagnosainput = cl.find(".nama-askep-diagnosa-input");
				namadiagnosainput.attr({name:"namadiagnosaaskep[]"});
				namadiagnosainput.val(diagnosa);
				
				// di create setelah form satu
				$(".master-table-diagnosaaskep").before(cl);
				$(".diagnosakeperawatan").val("");
				$(".kodeaskep").val("");
				$(".diagnosaaskep").val("");
				
				// fungsi hapus
				$(".hapus-diagnosa-askep").click(function(){
					$(this).parent().parent().remove();
				});
				
				if(kode == 'D0001'){
					// alert(diagnosa);
					$.post( "form_askep.php", {kode:kode, diagnosa:diagnosa})
					.done(function( data ) {
						cl.find('.form_tambahan_askep').html(data);
					});
				}
				if(kode == 'D0002'){
					$.post( "form_askep.php", {kode:kode, diagnosa:diagnosa})
					.done(function( data ) {
						cl.find('.form_tambahan_askep').html(data);
					});
				}	
			});	

			
		});
	</script>
<?php
}
?>