<?php
	include "config/helper_pasienrj.php";
	$idpasienrj = $_GET['id'];	
	$pelayanan = $_GET['pelayanan'];	
	$stsukm = $_GET['sts'];	// jika luar gedung ditamdain pake ukm

	// tbpasienrj	
	$query = mysqli_query($koneksi, "SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj`='$idpasienrj'");
	$data = mysqli_fetch_assoc($query);
	$idps = $data['IdPasien'];
	$nocm = $data['NoCM'];
	$noregistrasi = $data['NoRegistrasi'];
	$nokartubpjs = $data['nokartu'];
	$klaster = $data['Klaster'];
	$siklushidup = $data['SiklusHidup'];

	// ref_siklushidup
	$dtsiklushidup = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_siklushidup` WHERE `Nama`='$siklushidup'"));
	
	// tbkk
	$datakk = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbkk` WHERE `NoIndex` = '$data[NoIndex]'"));

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
	$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `NoCM` = '$data[NoCM]'"));
	
	if($pelayanan == 'POLI ANAK'){
		$polis = 'tbpolianak';
	}else if($pelayanan == 'POLI BERSALIN'){
		$polis = 'tbpolibersalin';
	}else if($pelayanan == 'POLI GIGI'){
		$polis = 'tbpoligigi_'.str_replace(' ', '', $namapuskesmas);
	}else if($pelayanan == 'POLI GIZI'){
		$polis = 'tbpoligizi';
	}else if($pelayanan == 'POLI HIV'){
		$polis = 'tbpolihiv';	
	}else if($pelayanan == 'POLI IMUNISASI'){
		$polis = 'tbpoliimunisasi';
	}else if($pelayanan == 'POLI ISOLASI'){
		$polis = 'tbpoliisolasi';	
	}else if($pelayanan == 'POLI KB'){
		$polis = 'tbpolikb';
	}else if($pelayanan == 'POLI KIA'){
		$polis = 'tbpolikia_'.str_replace(' ', '', $namapuskesmas);
	}else if($pelayanan == 'POLI LANSIA'){
		$polis = "tbpolilansia_".str_replace(' ', '', $namapuskesmas);
	}else if($pelayanan == 'POLI MTBS'){
		$polis = 'tbpolimtbs_'.str_replace(' ', '', $namapuskesmas);
	}else if($pelayanan == 'POLI PDP'){
		$polis = 'tbpolipanduptm';
	}else if($pelayanan == 'POLI PROLANIS'){
		$polis = 'tbpoliprolanis';
	}else if($pelayanan == 'POLI INFEKSIUS'){
		$polis = 'tbpoliinfeksius';
	}else if($pelayanan == 'POLI SCREENING'){
		$polis = 'tbpoliscreening';		
	}else if($pelayanan == 'POLI SKD'){
		$polis = 'tbpoliskd';
	}else if($pelayanan == 'POLI TB DOTS' OR $pelayanan == 'POLI TB'){
		if($kota == 'KOTA TARAKAN'){
			$polis = 'tbpolitb';
		}else{
			$polis = 'tbpolitbdots';
		}
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
		$querypolisemua = mysqli_query($koneksi,"SELECT * FROM `tbpolikb_kunjunganulang` WHERE `NoPemeriksaan` = '$noregistrasi'");
		$polisemua = mysqli_fetch_assoc($querypolisemua);
	}else{
		$querypolisemua = mysqli_query($koneksi, "SELECT * FROM `".$polis."` WHERE `IdPasienrj` = '$idpasienrj'");
		$polisemua = mysqli_fetch_assoc($querypolisemua);
	}
		
	// bpjs
	if (strlen($nokartubpjs = $data['nokartu']) == 8){
		$nokartubpjs = "00000".$nokartubpjs;
	}else if (strlen($nokartubpjs = $data['nokartu']) == 9){
		$nokartubpjs = "0000".$nokartubpjs;	
	}else if (strlen($nokartubpjs = $data['nokartu']) == 10){
		$nokartubpjs = "000".$nokartubpjs;	
	}else if (strlen($nokartubpjs = $data['nokartu']) == 11){
		$nokartubpjs = "00".$nokartubpjs;
	}else if (strlen($nokartubpjs = $data['nokartu']) == 12){
		$nokartubpjs = "0".$nokartubpjs;			
	}else{
		$nokartubpjs = $data['nokartu'];
	}
	
	
	$tglKunjunganedit = 0;
	$noKunjunganbpjsedit = $data['NoKunjunganBpjs'];
	$nokunjunganbpjs = $data['NoKunjunganBpjs'];
	$kdprovider = $data['kdprovider'];
	$jeniskunjungan = $data['JenisKunjungan'];
?>
<div class="hasilmodal"></div>

<style>
	.font_tabel{
		font-size:14px;
		font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
	}
	.tableborder tr{
		border-bottom:1px solid #dbdbdb;
	}
	.tabel_judul th{
		background: #80ba8b;
		border-collapse: separate;
		font-size: 12px;
		line-height: 20px;
		text-align:center;
		padding: 5px 10px;
		color:#fff;
	}	
	.tabel_isi{
		background:#edfcf4;
		color: #000;
		padding: 5px 10px;
		text-align:center;
	}
	.autocomplete-suggestions {
		width:500px !important;
	}
	.table-responsive{
		overflow: hidden;
	}

	a {color: white;}

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

<?php
	if($idpasienrj == ''){ ?>
	<div class="tableborderdiv">
		<div class="formbg mt-4">
			<p>
				<b>Info :</b><br/>
				Data tidak dapat diakses, karena pasien tersebut tidak ditemukan saat registrasi di pendaftaran (loket)<br/>
				Silahkan hubungi IT / Petugas pendaftaran utk cek kembali Datanya.
			</p>
		</div>
	</div>
<?php 
	die(); 
	} 
?>

<form action="poli_periksa_edit_proses.php" method="post">
	<input type="hidden" class="getpelayanan" value="<?php echo $_GET['pelayanan'];?>">
	<input type="hidden" class="idpsnrj" name="idpasienrj" value="<?php echo $data['IdPasienrj'];?>">
	<input type="hidden" class="lokasikota" value="<?php echo $kota;?>">
	<input type="hidden" name="kdprovider" value="<?php echo $kdprovider;?>">
	<input type="hidden" name="jeniskunjungan" value="<?php echo $data['JenisKunjungan'];?>">
	<input type="hidden" name="nokunjunganbpjs" value="<?php echo $noKunjunganbpjsedit;?>">
	<input type="hidden" name="stsukm" value="<?php echo $stsukm;?>">
	<div class="page-inner mt-1">	
		<div class="row">
			<div class="col-sm-8">
				<table class="table-judul" style="margin: auto;">
					<tr>
						<td class="nocm" style="display:none"><?php echo $data['NoCM'];?></td>
						<td class="noregistrasi" style="display:none"><?php echo $data['NoRegistrasi'];?></td>
						<td class="pelayanan" style="display:none"><?php echo $data['PoliPertama'];?></td>
					</tr>
				</table>
				<div class="card card-dark bg-primary-gradient">
					<div class="card-body skew-shadow">	
						<div class="row">
							<div class="col-12 pr-0">
								<h3 class="fw-bold mb-1">
									<?php echo strtoupper($data['NamaPasien']." / KK.".$datakk['NamaKK']);?>
									<span class="badge badge-success" style='padding: 6px; font-size: 14px;'><?php echo substr($data['NoIndex'],-10);?></span>
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
										$data['Asuransi']."<br/>".
										date('d-m-Y', strtotime($datapasien['TanggalLahir'])).", ".$data['UmurTahun']." Th ".$data['UmurBulan']." Bl ".$data['UmurHari']."<br/>".
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
		<input type="hidden" name="nopemeriksaan" value="<?php echo $data['NoRegistrasi'];?>">
		<input type="hidden" name="noregistrasi" class="noregistrasiclass" value="<?php echo $noregistrasi;?>">
		<input type="hidden" name="idpsnrj" class="idpsnrjclass" value="<?php echo $idpasienrj;?>">
		<input type="hidden" name="noindex" value="<?php echo $data['NoIndex'];?>">
		<input type="hidden" name="nocm" value="<?php echo $data['NoCM'];?>">
		<input type="hidden" name="umurtahun" value="<?php echo $data['UmurTahun'];?>">
		<input type="hidden" name="umurbulan" value="<?php echo $data['UmurBulan'];?>">
		<input type="hidden" name="asuransi" class="asuransicls" value="<?php echo $data['Asuransi'];?>">
		<input type="hidden" name="nokartubpjs" value="<?php echo $nokartubpjs;?>">
		<input type="hidden" name="pelayanan" value="<?php echo $pelayanan;?>">
		<input type="hidden" name="poli_bpjs" value="<?php echo $data['kdpoli'];?>">
		<input type="hidden" name="nikps" value="<?php echo $data['Nik'];?>">					

		<div class="mt-1">
			<div class="row">
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
											}else if($pelayanan == 'poli gigi' || $pelayanan == 'POLI GIZI'){
												include "poli_gizi.php";
											}else if($pelayanan == 'poli imunisasi' || $pelayanan == 'POLI IMUNISASI'){
												include "poli_imunisasi.php";
											}else if($pelayanan == 'poli isolasi' || $pelayanan == 'POLI ISOLASI'){
												include "poli_isolasi.php";	
											}else if($pelayanan == 'poli infeksius' || $pelayanan == 'POLI INFEKSIUS'){
												include "poli_infeksius.php";	
											}else if($pelayanan == 'poli kb' || $pelayanan == 'POLI KB'){
												include "poli_kb.php";
											}else if($pelayanan == 'poli kia' || $pelayanan == 'POLI KIA'){
												include "poli_kia.php";
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
											}else if($pelayanan == 'poli ugd' || $pelayanan == 'POLI UGD' || $pelayanan == 'POLI TINDAKAN'){
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
									<!--Pemeriksa-->
									<div class="table-responsive">
										<table class="table-judul" width="100%">
											<tr>
												<td class="col-sm-2">
													Kesadaran
													<?php if(substr($data['Asuransi'],0,4) == 'BPJS'){?>
														<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
															<img src='image/logo_bpjs_bulet.png' width="30px"/> 12
														</span>
													<?php } ?>
												</td>
												<td class="col-sm-10">
												<input type="hidden" name="nokunjbpjs" value="<?php echo $noKunjunganbpjsedit;?>">
												<input type="hidden" name="tglkunjbpjs" value="<?php echo $tglKunjunganedit;?>">
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
												<td class="col-sm-3">Status Pulang</td>
												<td class="col-sm-9">
													<select name="statuspulang" class="form-control statuspulang" required>
														<option value="">--Pilih--</option>		
														<option value="1" <?php if($polisemua['StatusPulang'] == '1'){echo "SELECTED";}?>>Meninggal</option>
														<option value="3" <?php if($polisemua['StatusPulang'] == '3'){echo "SELECTED";}?>>Berobat Jalan</option>
														<option value="4" <?php if($polisemua['StatusPulang'] == '4'){echo "SELECTED";}?>>Rujuk</option>
														<option value="5" <?php if($polisemua['StatusPulang'] == '5'){echo "SELECTED";}?>>Rujuk Internal</option>											
													</select>
												</td>
											</tr>	
											<?php
											$tbpasienperpegawai = 'tbpasienperpegawai_'.$kodepuskesmas;
											$querytm = mysqli_query($koneksi,"SELECT * FROM `$tbpasienperpegawai` WHERE `NoRegistrasi` = '$noregistrasi'");
											$tenagamedis = mysqli_fetch_assoc($querytm);
											
											// $kddokter = $dtkunbpjs['response']['list'][0]['dokter']['kdDokter'];
											// $data_tenagamedis = get_data_tenagamedis();
											// $dtenaga = json_decode($data_tenagamedis,True);
											?>
											<tr>
												<td class="col-sm-3">
													Tenaga Medis I (Hfis Pcare)
													<?php if(substr($data['Asuransi'],0,4) == 'BPJS'){?>
														<span class="badge badge-primary" style='padding: 6px; font-size: 14px;'>
															<img src='image/logo_bpjs_bulet.png' width="30px"/> 13
														</span>
													<?php } ?>
												</td>
												<td class="col-sm-9">
													<SELECT name="tenagamedis1" class="form-control tenagamedis1" >
														<option value="">--Pilih--</option>
														<?php 
															$qrypegawai = mysqli_query($koneksi,"SELECT * FROM `tbpegawaibpjs` WHERE `kdpuskesmas` = '$kodepuskesmas' order by nmDokter ASC");
															while($pegawai = mysqli_fetch_assoc($qrypegawai)){
																if($tenagamedis['NamaPegawai1'] == $pegawai['nmDokter']){
																echo "<option value='".$pegawai['kdDokter']."' SELECTED>".$pegawai['nmDokter']."</option>";
																}else{
																echo "<option value='".$pegawai['kdDokter']."'>".$pegawai['nmDokter']."</option>";
																}
															}
														?>
													</SELECT>
													<input type="hidden" name="tenagamedisbpjs" class="namadokterbpjs" value="<?php echo $tenagamedis['NamaPegawai1'];?>">
													<span class="labeltenagamedis1" style="color:red;"></span>
												</td>
											</tr>
											
											<tr>
												<td class="col-sm-3">Paramedis I</td>
												<td class="col-sm-9">
													<SELECT name="tenagamedis2" class="form-control tenagamedis2">
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
													</SELECT>
													<span class="labeltenagamedis2" style="color:red;"></span>
												</td>
											</tr>
											<tr>
												<td class="col-sm-3">Paramedis II</td>
												<td class="col-sm-9">
													<SELECT name="tenagamedis3" class="form-control tenagamedis3">
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
													</SELECT>
													<span class="labeltenagamedis3" style="color:red;"></span>
												</td>
											</tr>
											<tr>
												<td class="col-sm-3">Tenaga Lab</td>
												<td class="col-sm-9">
													<SELECT name="tenagalab" class="form-control tenagalab">
														<option value="">--Pilih--</option>
														<?php 
															$qrypegawai_lab = mysqli_query($koneksi,"SELECT * FROM tbpegawai WHERE KodePuskesmas = '$kodepuskesmas' order by NamaPegawai ASC");
															while($pegawai_lab = mysqli_fetch_assoc($qrypegawai_lab)){
																if($tenagamedis['Lab'] == $pegawai_lab['NamaPegawai']){
																echo "<option value='".$pegawai_lab['NamaPegawai']."' SELECTED>".$pegawai_lab['NamaPegawai']."</option>";
																}else{
																echo "<option value='".$pegawai_lab['NamaPegawai']."'>".$pegawai_lab['NamaPegawai']."</option>";
																}
															}
														?>
													</SELECT>
													<span class="labeltenagalab" style="color:red;"></span>
												</td>
											</tr>
											<tr>
												<td class="col-sm-3">Tenaga Farmasi</td>
												<td class="col-sm-9">
													<SELECT name="tenagafarmasi" class="form-control tenagafarmasi">
														<option value="">--Pilih--</option>
														<?php 
															$qrypegawai3 = mysqli_query($koneksi,"SELECT * FROM tbpegawai WHERE KodePuskesmas = '$kodepuskesmas' order by NamaPegawai ASC");
															while($pegawai3 = mysqli_fetch_assoc($qrypegawai3)){
																if($tenagamedis['Farmasi'] == $pegawai3['NamaPegawai']){
																echo "<option value='".$pegawai3['NamaPegawai']."' SELECTED>".$pegawai3['NamaPegawai']."</option>";
																}else{
																echo "<option value='".$pegawai3['NamaPegawai']."'>".$pegawai3['NamaPegawai']."</option>";
																}
															}
														?>
													</SELECT>
													<span class="labeltenagafarmasi" style="color:red;"></span>
												</td>
											</tr>
										</table>
										<table class="table statuspulangform"></table>
									</div>
								
									<?php
									}else{
										$dtlaboratorium = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolilaboratorium` WHERE `NoPemeriksaan`='$noregistrasi'"));
									?>
										<!--poli Laboratorium-->
										<div class="tab-pane active" id="laboratorium">
											<table class="table-judul">
												<thead>
													<tr>
														<th width="5%">NO.</th>
														<th width="5%">ID</th>
														<th width="40%">JENIS TINDAKAN</th>
														<th width="25%">KELOMPOK TINDAKAN</th>
														<th width="25%">HASIL</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$no = 0;
													$str_tindakan_detail = mysqli_query($koneksi, "SELECT * FROM `$tbtindakanpasien` WHERE `IdPasienrj`='$_GET[id]' AND (`KategoriTindakan`='Laboratorium' OR `KategoriTindakan`='Pengujian Kesehatan') ORDER BY IdTindakanPasienDetail");
													while($dt_tindd = mysqli_fetch_assoc($str_tindakan_detail)){
														// gettindatakan
														$gettindakan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbtindakan` WHERE `IdTindakan`='$dt_tindd[IdTindakan]'"))
													?>
													<tr>
														<td><?php echo $no = $no + 1;?></td>
														<td><?php echo $gettindakan['IdTindakan'];?></td>
														<td><?php echo $gettindakan['Tindakan'];?></td>
														<td><?php echo $dt_tindd['KategoriTindakan'];?></td>
														<td><input type="text" name="hasilkdtindakan[<?php echo $dt_tindd['IdTindakan'];?>]" value="<?php echo $dt_tindd['Keterangan'];?>" class="form-control"></td>
														<input type="hidden" name="jenistindakan[<?php echo $dt_tindd['IdTindakan'];?>]" value="<?php echo $gettindakan['Tindakan'];?>" class="form-control">
														<input type="hidden" name="kategoritindakan[<?php echo $dt_tindd['IdTindakan'];?>]" value="<?php echo $dt_tindd['KategoriTindakan'];?>" class="form-control">
													</tr>
													<?php
														$idtind[] = $dt_tindd['IdTindakan'];
													}

													// if(mysqli_num_rows($str_tindakan_detail) > 0 ){
													?>
													<!--<tr><td colspan="5"><a href="hapus_tbtindakanpoliperiksa.php?noreg=<?php //echo $_GET['no'];?>&pel=<?php //echo $_GET['pelayanan'];?>" class="btn btn-danger btn-block">Hapus</a></td></tr>-->
													<?php //} ?>
												</tbody>	
											</table>
											<input type="hidden" value="<?php echo implode(',',$idtind);?>" name="idtindakan"/>	
										</div><br/>
										
										<!--Pemeriksa-->
										<div class="tab-pane" id="pemeriksa">
											<div class="box border">
												<div class="box-body">
													<div class="table-responsive">
														<table class="table-judul" width="100%">
															<tr>
																<td>Tenaga Lab</td>
																<td>
																	<select name="tenagalab" class="form-control tenagalab">
																		<option value="">--Pilih--</option>
																		<?php 
																			$tbpasienperpegawai = 'tbpasienperpegawai_'.$kodepuskesmas;
																			$querytm = mysqli_query($koneksi,"SELECT * FROM `$tbpasienperpegawai` WHERE `NoRegistrasi` = '$noregistrasi'");
																			$tenagamedis = mysqli_fetch_assoc($querytm);
															
																			$qrypegawai_lab = mysqli_query($koneksi,"SELECT * FROM `tbpegawai` WHERE `KodePuskesmas` = '$kodepuskesmas' order by `NamaPegawai` ASC");
																			while($pegawai_lab = mysqli_fetch_assoc($qrypegawai_lab)){
																				if($tenagamedis['Lab'] == $pegawai_lab['NamaPegawai']){
																				echo "<option value='".$pegawai_lab['NamaPegawai']."' SELECTED>".$pegawai_lab['NamaPegawai']."</option>";
																				}else{
																				echo "<option value='".$pegawai_lab['NamaPegawai']."'>".$pegawai_lab['NamaPegawai']."</option>";
																				}
																			}
																		?>
																	</select>									
																	<span class="labeltenagalab" style="color:red;"></span>
																</td>
															</tr>
														</table><br/>
													</div>
												</div>
											</div>
										</div>
									<?php
									}
									?>
									<button type="submit" class="btn btn-round btn-success btnsimpan btnsimpanperiksa">SIMPAN PEMERIKSAAN</button>
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
							
							// $tbpasienrj, status pasien 1 Kunjungan sakit (update 05/04/2025)
							$str = "SELECT * FROM `$tbpasienrj` WHERE `IdPasien`='$data[IdPasien]' AND `StatusPasien`='1'";
							$str_riwayat = $str." ORDER BY IdPasienrj DESC LIMIT $mulai,$jumlah_perpage";
							// echo $str_riwayat;

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
																									
								// cek diagnosa
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
								?>
									
								<tr>
									<td align="center" class="noregistrasi" style="display:none"><?php echo $riwayat['NoRegistrasi'];?></td>
									<td class="nocm_riwayat" style="display:none"><?php echo $riwayat['NoCM'];?></td>
									<td align="left" class="poli_pertama" style="display:none"><?php echo $riwayat['PoliPertama'];?></td>
								</tr>

								<?php
									$pelayanan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Anamnesa`,`Keluhan` FROM `$polis` WHERE `IdPasienrj` = '$idprj'"));
							
									// vital sign                                                
									$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$idprj'";
									$cekvitaslsign = mysqli_num_rows(mysqli_query($koneksi, $strvs));
									$dtvs = mysqli_fetch_assoc(mysqli_query($koneksi, $strvs));

									if($dtvs['Keluhan'] != ''){
										$keluhan = $dtvs['Keluhan'];
									}else{
										$keluhan = $pelayanan['Keluhan'];
									}

									if($dtvs['Anamnesa'] != ''){
										$anamnesa = $dtvs['Anamnesa'];
									}else{
										$anamnesa = $pelayanan['Anamnesa'];
									}
								?>
								<div class="formbg_green">
									<p style="line-height: 16px; font-size:12px;">
									<b>Tgl.Registrasi :</b>
										<?php echo $riwayat['TanggalRegistrasi'];?><br/>
										<b>Pelayanan :</b>
										<?php echo $riwayat['PoliPertama'];?><br/>
										<b>Keluhan :</b>
										<?php echo strtoupper($keluhan);?><br/>
										<b>Anamnesa :</b>
										<?php echo strtoupper($anamnesa);?><br/>										
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
					<?php
					// }
					?>
				</div>
			</div>
		</div>
	</div>
</form>

<?php
	mysqli_close($koneksi);
?>

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

			var diagnosa = $(".kode-diagnosa-input",1).val();
			if(diagnosa == ''){
				$(".modalbody-alert").text('Silahkan isi Diagnosa terlebih dahulu...');
				$("#alert-modal").modal('show');
				$("#pemeriksaan1").click();
				$(".anamnesa").focus();
				return false;
			}

			var opsiterapi = $("input[name='opsiresep']:checked").val();
			if(opsiterapi == 'diberikan resep'){
				var kodeobatlokal = $(".kodeobatlokal-input",1).val();
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

			var frekuensinafas = $(".frekuensinafas").val();
			if(frekuensinafas == ''){
				$(".modalbody-alert").text('Silahkan isi Frekuensi Nafas pada form ISPA...');
				$("#alert-modal").modal('show');
				return false;
			}

			// var kodediagnosainput = $(".kode-diagnosa-input").val();
			// if(kodediagnosainput == ''){
				// alert('Silahkan isi diagnosa terlebih dahulu.');
				// $(".diagnosatab a").click();
				// return false;
			// }
		});

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
			serviceUrl: 'get_tindakan.php?asuransi=<?php echo $data['Asuransi'];?>&keyword=',
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
				$(this).parent().find(".idtindakanbpjs").val(suggestion.idtindakanbpjs);
				$(this).parent().find(".namatindakanbpjs").val(suggestion.namatindakanbpjs);
				
				var carabayar = '<?php echo $data['Asuransi'];?>';
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
			var noregistrasi = $(this).parent().parent().find(".noregistrasi_riwayat").html()
			var pelayanan = $(this).parent().parent().find(".poli_pertama").html()
			// alert(noregistrasi);
			// alert(nocm);
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
			// alert(nocm);
		});
		
		var isistatuspulang = $(".statuspulang").val();
		var nokunjunganbpjs = $("input[name=nokunjunganbpjs]").val();
		var noreg = $(".noregistrasiclass").val();
		var idpsnrj = $(".idpsnrjclass").val();
		var pelayanan = $(".getpelayanan").val();
		// alert(noreg);
		
		if(isistatuspulang == '4'){
		var jaminan = $(".asuransicls").val();
		function statusspesialis(){
			var yourArray = [];
			$( ".spesialis-diagnosa-input" ).each(function( index, element) {
				yourArray.push($(this).val());
			});
			return yourArray;
		}
		var tess = jQuery.inArray('true',statusspesialis());
		if (tess >= 0){
			var statusspesialis2 = 'true';
		}else{
			var statusspesialis2 = 'false';
		}

		// rujuk lanjut
		$.post( "get_rujuk_lanjut.php", { sts: statusspesialis2, jaminan: jaminan, nokunjunganbpjs: nokunjunganbpjs}) 
			.done(function( data ) {
			$(".statuspulangform").html(data);
		});	
		
		}else if(isistatuspulang == '5'){
		// rujuk internal		
			$.post( "get_rujuk_internal.php", { pelayanan: pelayanan, idpsnrj:idpsnrj })
			  .done(function( data ) {
				$(".statuspulangform").html(data);
			});			
		}else{
			$(".statuspulangform").html('');
		}

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

		var isi_sts_pemeriksaan_kia = $(".sts_pemeriksaan_kia").val();
		if(isi_sts_pemeriksaan_kia == 'Non Kehamilan'){
			$(".nonkehamilan_tmp").hide();
		}else{
			$(".nonkehamilan_tmp").show();
		}

		$(".sts_pemeriksaan_kia").change(function(){
			var isi = $(this).val();
			if(isi == 'Non Kehamilan'){
				$(".nonkehamilan_tmp").hide();
			}else{
				$(".nonkehamilan_tmp").show();
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

		// $(".antrianresep").click(function(){
			// var loket = '<?php echo $_SESSION['LoketPanggil'];?>';//$(".loketcls").val();
			// var view_antrian = $(this).parent().find(".viewnomorantrian").val();
			// var antrian = $(this).parent().find(".nomorantrian").val();
			// var idantrian = $(this).parent().find(".idanlist").val();
			
			// $(".viewantrian").text(view_antrian);
			// $(".idantrian").val(idantrian);
			// $(".noantriancls").text(antrian);
			// $.post( "apotik_pelayanan_resep_autoload.php?sts=insertdisplay", {noantrian:view_antrian,loket:loket}).done(function( data ) {
				// console.log(data);
			// });	
		// });	

		$(".tabs1").click(function(){
			var attrid = $(this).attr('id');

			$(".nav-pills2").find(".nav-link").removeClass('active');
			$(".nav-pills2").find("[id='" + attrid + "']").addClass('active');
			
		});

		$(".tabs2").click(function(){
			var attrid = $(this).attr('id');
			$(".nav-pills1").find(".nav-link").removeClass('active');
			$(".nav-pills1").find("[id='" + attrid + "']").addClass('active');			
		});
	});
</script>


