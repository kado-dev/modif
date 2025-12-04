<?php
	include "config/helper_pasienrj.php";
	$tanggal = date('Y-m-d');
	$tahunini = date('Y');
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>ANALISA KELENGKAPAN CATATAN MEDIS (KLPCM)</b></h3>
			<div class="formbg">
				<form role="form" class="submit">
					<div class = "row">
						<input type="hidden" name="page" value="rekam_medis_klpcm"/>
						<div class="col-xl-2">
							<input type="text" name="tglawal" class="form-control datepicker" value="<?php echo $_GET['tglawal'];?>" placeholder = "Tanggal Awal">
						</div>
						<div class="col-xl-2">
							<input type="text" name="tglakhir" class="form-control datepicker" value="<?php echo $_GET['tglakhir'];?>" placeholder = "Tanggal Akhir">
						</div>
						<div class="col-xl-3">
							<input type="text" name="key" class="form-control key barcodefocus" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama Pasien / NoIndex / RM">
						</div>
						<div class="col-xl-2">
							<select name="pelayanan" class="form-control">
								<option value="semua">Semua</option>
								<?php
									$query = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` WHERE `JenisPelayanan`='KUNJUNGAN SAKIT' ORDER BY `Pelayanan`");
									while($data = mysqli_fetch_assoc($query)){
										if($data['Pelayanan'] == $_GET['pelayanan']){
											echo "<option value='$data[Pelayanan]' SELECTED>$data[Pelayanan]</option>";
										}else{
											echo "<option value='$data[Pelayanan]'>$data[Pelayanan]</option>";
										}	
									}
								?>
							</select>
						</div>
						<div class="col-xl-3">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=rekam_medis_klpcm" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="rekam_medis_klpcm_excel.php?tglawal=<?php echo $_GET['tglawal'];?>&tglakhir=<?php echo $_GET['tglakhir'];?>" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
		
	<div class="table-responsive">
		<form action="index.php?page=rekam_medis_proses" method="post">
			<table class="table-judul">
				<thead>
					<tr>
						<th width="3%" rowspan="2">NO.</th>
						<th width="20%" rowspan="2">NAMA PASIEN</th>
						<th width="17%" colspan="2">SELESAI ENTRY DATA</th>
						<th colspan="3">KELENGKAPAN CATATAN MEDIS</th>
						<th width="15%" rowspan="2">#</th>
					</tr>
					<tr>
						<th>PENDAFTARAN</th>
						<th>PEMERIKSAAN</th>
						<th width="15%" >ANAMNESA</th>
						<th width="15%" >DIAGNOSA</th>
						<th width="15%" >THERAPY</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$jumlah_perpage = 25;
				
					if($_GET['h']==''){
						$mulai=0;
					}else{
						$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$key = $_GET['key'];	
					$tglawal = $_GET['tglawal'];
					$tglakhir = $_GET['tglakhir'];
					$pelayanan = $_GET['pelayanan'];	
					
					if($tglawal != null){
						$tglawal = date('Y-m-d',strtotime($tglawal));
						$tglakhir = date('Y-m-d',strtotime($tglakhir));
						$tgl_str = " date(TanggalRegistrasi) BETWEEN '$tglawal' AND '$tglakhir' AND ";
					}else{
						$tgl_str = " date(TanggalRegistrasi) = '".date('Y-m-d')."' AND ";
					}
													
					if($key !=''){
						$strcari = " AND (`NamaPasien` like '%$key%' OR `NoIndex` like '%$key%' OR `NoRM` like '%$key%')";
					}else{
						$strcari = " ";
					}
										
					if($pelayanan == 'semua' || $pelayanan == ''){
						$ply = " ";
					}else{
						$ply = " AND `PoliPertama`='$pelayanan'";
					}
					
					// kunjungan sehat tidak ditampilkan
					$str = "SELECT * FROM `$tbpasienrj`
					WHERE ".$tgl_str." StatusPasien = '1'".$strcari.$ply;		
					$str2 = $str." order by NoRegistrasi DESC LIMIT $mulai,$jumlah_perpage";
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
						$idpasienrj = $data['IdPasienrj'];
						$noindex = $data['NoIndex'];
						$nocm = $data['NoCM'];
						$nik = $data['Nik'];
						$noregistrasi = $data['NoRegistrasi'];
						$kunjungan = $data['StatusKunjungan'];
						$noasurasi = $data['nokartu'];
						if($kunjungan == 'Baru' AND substr($noindex,14,4) == $tahunini){
							$stylewarna = "style='background:#b3ecfd'";
						}else{
							$stylewarna = "";
						}
						
						// cek anamnesa
						$namapkm = str_replace(' ','',strtoupper($namapuskesmas));
						if ($data['PoliPertama'] == "POLI GIGI" OR $data['PoliPertama'] == "POLI KIA" OR $data['PoliPertama'] == "POLI LANSIA" OR $data['PoliPertama'] == "POLI MTBS" OR $data['PoliPertama'] == "POLI UMUM" OR $data['PoliPertama'] == "POLI BERSALIN"){
							$pelayanan = "tb".str_replace(' ','',strtolower($data['PoliPertama']))."_$namapkm";	
						}else{
							$pelayanan = "tb".str_replace(' ','',strtolower($data['PoliPertama']));
						}

						if($data['PoliPertama'] == "POLI KB"){
							$datakb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpolikb_kunjunganulang` WHERE `NoPemeriksaan`='$data[NoRegistrasi]'"));
							$anamnesapsn = $datakb['Anamnesa'];
						}else{
							$stranamnesa = "SELECT * FROM `$pelayanan` WHERE `NoPemeriksaan`='$data[NoRegistrasi]'";
							$queryanamnesa = mysqli_query($koneksi, $stranamnesa);
							$dtanamnesa = mysqli_fetch_assoc($queryanamnesa);
							$anamnesapsn = $dtanamnesa['Anamnesa'];
						}

						// jika melakukan edit nama dokter
						if ($dtanamnesa['NamaPegawaiEdit'] != null){
							$namapegawai = $dtanamnesa['NamaPegawaiEdit'];
						}else{
							$namapegawai = $dtanamnesa['NamaPegawaiSimpan'];
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

						// tbkk
						$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaKK`,`Alamat`,`RT`,`RW`,`Kelurahan`,`Kecamatan`,`Kota`,`Telepon` FROM `$tbkk` WHERE `NoIndex`='$noindex'"));
						
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

						
					?>
						<tr <?php echo $stylewarna;?>>
							<td align="center"><?php echo $no;?></td>
							<td align="left">
								<?php echo "<b>".$data['NamaPasien']."</b>"?>
								<span class="badge badge-success" style='font-style: italic; padding: 8px;'><?php echo substr($data['NoIndex'],-10);?></span><br/>
								<?php 
									echo "Usia : ".$data['UmurTahun']." Th ".$data['UmurBulan']." Bl"."<br/>".									
									"Nik : ".$nik."<br/>".
									"NoKartu : ".$noasurasi."<br/>".
									"Cara Bayar : ".str_replace('POLI','', $data['Asuransi'])."<br/>".
									"Pelayanan : ".str_replace('POLI','', $data['PoliPertama'])."<br/><br/>".

									"<b>Alamat :</b><br/>";
									if($datakk['Alamat'] != ''){
										$alamat_pasien = $datakk['Alamat'].", RT.".$datakk['RT'].", RW.".$datakk['RW'].", ".
										strtoupper($kelurahan).", ".strtoupper($kecamatan).", ".strtoupper($kota);
										echo $alamat_pasien;
									}else{
										$dtresep = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT Alamat FROM `$tbresep` WHERE NoResep='$data_resep[NoResep]'"));
										$alamat_pasien = $dtresep['Alamat'];
										echo $alamat_pasien;
									}									
								?>
							</td>
							<td align="center"><?php echo $data['TanggalRegistrasi'];?></td>
							<td align="center">
								<?php if($data['JamKembaliRM'] != ""){ ?>
									<?php echo $data['JamKembaliRM'];?>
								<?php }else{ ?>
									<span class='badge badge-warning' style='font-style: italic; padding: 8px;'>Belum Diperiksa</span>
								<?php } ?>
							</td>
							<td align="left">
								<?php
									if ($anamnesapsn != ''){
										echo "<b>Anamnesa : </b><br/>".
										$anamnesapsn."<br/>".
										"<b>Vitalsign : </b><br/>".
										"Sistole/Diastole : ".$dtsistole."/".$dtdiastole."<br/>".
										"BB/TB : ".$dtberatBadan."/".$dttinggiBadan."<br/>".
										"Suhu : ".$dtsuhutubuh.", HR : ".$dtheartRate.", RR : ".$dtrespRate;
									}else{
								?>
									<span class='badge badge-danger' style='padding: 4px;'><i class='icon-close fa-3x'></i></span>
								<?php } ?>	
							</td>
							<td align="center">
								<?php
									// tbdiagnosa
									$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
									$qrdata_kd_diagnosa = mysqli_query($koneksi, "SELECT * FROM `$tbdiagnosapasien` WHERE `IdPasienrj` = '$idpasienrj' GROUP BY `KodeDiagnosa`");
									while($data_diagnosapsn = mysqli_fetch_array($qrdata_kd_diagnosa)){
										$data_diagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
										$array_diagnosa[$no][] = $data_diagnosa['Diagnosa'];
										$array_kode_diagnosa[$no][] = $data_diagnosapsn['KodeDiagnosa'];
									}
									
									if ($array_kode_diagnosa[$no] != ''){
										$data_dgs = implode(", ", $array_kode_diagnosa[$no]);
										echo $data_dgs;
									}else{
								?>
										<span class='badge badge-danger' style='padding: 4px;'><i class='icon-close fa-3x'></i></span>
								<?php } ?>
							</td>
							<td align="center">
								<?php
									// therapy
									$qrdata_therapy = mysqli_query($koneksi, "SELECT * FROM `$tbresepdetail` WHERE `NoResep`='$data[NoRegistrasi]' AND DATE(TanggalResep) IS NOT NULL GROUP BY NoResep, KodeBarang, Pelayanan");
									while($data_therapy = mysqli_fetch_array($qrdata_therapy)){
										$data_obat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbapotikstok` WHERE `KodeBarang` = '$data_therapy[KodeBarang]' GROUP BY KodeBarang"));
										$array_obat[$no][] = $data_obat['NamaBarang'];
									}
									
									if ($array_obat[$no] != ''){
										$data_obt = implode(", ", $array_obat[$no]);
										echo $data_obt;
									}else{
										// tbresep
										$str_resep = "SELECT * FROM `$tbresep` WHERE `NoResep`='$data[NoRegistrasi]' AND `Pelayanan`='$data[PoliPertama]'";
										$query_resep = mysqli_query($koneksi, $str_resep);
										$data_resep = mysqli_fetch_assoc($query_resep);
										if ($data_resep['OpsiResep'] == 'konseling'){
											echo strtoupper($data_resep['OpsiResep']);
										}else{
											echo strtoupper($data_resep['OpsiResep']."<br/>".$data_resep['KetResepLuar']);
										}
									}
								?>		
									<!-- <span class='badge badge-danger' style='padding: 4px;'><i class='icon-close fa-3x'></i></span> -->
								<?php //} ?>	
							</td>
							<td align="center">
								<button data-toggle="dropdown" class="btn btn-round btn-primary dropdown-toggle" aria-expanded="true">OPSI<span class="ace-icon icon-on-right"></span></button>
								<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(303px, 43px, 0px); top: 0px; left: 0px; will-change: transform;">
									<a class="dropdown-item" href="rekam_medis_blangko_persetujuan.php?id=<?php echo $data['IdPasien'];?>&cm=<?php echo $data['NoCM'];?>&idrj=<?php echo $data['IdPasienrj'];?>&stshal=klpcm">(Form-1) - Persetujuan Pasien</a>
									<a class="dropdown-item" href="rekam_medis_blangko_hakkewajiban.php?id=<?php echo $data['IdPasien'];?>&cm=<?php echo $data['NoCM'];?>&idrj=<?php echo $data['IdPasienrj'];?>">(Form-2) - Hak & Kewajiban Pasien</a>
									<a class="dropdown-item" href="rekam_medis_blangko_identitas.php?id=<?php echo $data['IdPasien'];?>&cm=<?php echo $data['NoCM'];?>&idrj=<?php echo $data['IdPasienrj'];?>">(Form-3) - Identitas Pasien</a>
									<a class="dropdown-item" href="rekam_medis_blangko_kajianawal.php?id=<?php echo $data['IdPasien'];?>&cm=<?php echo $data['NoCM'];?>&idrj=<?php echo $data['IdPasienrj'];?>">(Form-4) - Kajian Awal</a>
									<a class="dropdown-item" href="rekam_medis_blangko_bandungkab.php?id=<?php echo $data['IdPasien'];?>&cm=<?php echo $data['NoCM'];?>&idrj=<?php echo $data['IdPasienrj'];?>">(Form-5) - Kajian Ulang</a>
									<a class="dropdown-item" href="rekam_medis_blangko_asuhankeperawatan.php?id=<?php echo $data['IdPasien'];?>&cm=<?php echo $data['NoCM'];?>&idrj=<?php echo $data['IdPasienrj'];?>">(Form-6) - Asuhan Keperawatan</a>
									<a class="dropdown-item" href="?page=rekam_medis_icare_bpjs&idpasien=<?php echo $data['IdPasien'];?>&kddokter=<?php echo $data['IdPasien'];?>">(Form-7) - iCare BPJS</a>
								</div>
								<?php if($data['StatusPelayanan'] == "Sudah"){ ?>
									<a href="?page=poli_periksa_edit&id=<?php echo $data['IdPasienrj'];?>&pelayanan=<?php echo $data['PoliPertama'];?>" target="_blank" class="btn btn-round btn-success"><i class="fa fa-user-md (alias) faicon"></i></a>
								<?php }else{ ?>
									<a href="?page=poli_periksa&id=<?php echo $data['IdPasienrj'];?>&pelayanan=<?php echo $data['PoliPertama'];?>&status=<?php echo $data['StatusPelayanan'];?>" target="_blank" class="btn btn-round btn-success"><i class="fa fa-user-md (alias) faicon"></i></a>
								<?php } ?>
							</td>		
						</tr>
					<?php
					}
					?>
				</tbody>
			</table><hr/>
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
								echo "<li><a href='?page=rekam_medis_klpcm&tglawal=$tglawal&tglakhir=$tglakhir&key=$key&pelayanan=$_GET[pelayanan]&h=$i'>$i</a></li>";
							}
						}
					}
				?>	
			</ul>
			<!--<input type="submit" value="APPROVE" onClick="return confirm('Anda yakin data sudah benar dan ingin disimpan...?')" class="btn btn-round btn-success btnsimpan">-->
		</form>
	</div>
		
	<!--modal-->
	<div class="panel-default hasilmodal"></div>

	<div class="row">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<p>Klik tombol In, jika berkas rekam medis telah dikembalikan	
				</p>	
			</div>
		</div>
	</div>
</div>