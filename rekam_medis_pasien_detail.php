<?php
	include "config/helper_pasienrj.php";
	$tanggal = date('Y-m-d');
	$tahunini = date('Y');
	$idprj = $_GET['idprj'];
	$idps = $_GET['idps'];
	$pelayanan = $_GET['ply'];
	$sts = $_GET['sts'];

	// tbpasien
	$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Nik`,`NamaPasien`,`Telpon`,`TanggalLahir` FROM $tbpasien WHERE `IdPasien`='$idps'"));
	
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<?php if ($sts == 'edit'){?>
				<a href="index.php?page=poli_periksa_edit&id=<?php echo $idprj;?>&idps=<?php echo $idps;?>&pelayanan=<?php echo $pelayanan;?>" class="btn btn-round btn-info mt-0" style="float:right;">KEMBALI</a>
			<?php }else{ ?>	
				<a href="index.php?page=poli_periksa&id=<?php echo $idprj;?>&idps=<?php echo $idps;?>&pelayanan=<?php echo $pelayanan;?>&status=Antri&tptgl=" class="btn btn-round btn-info mt-0" style="float:right;">KEMBALI</a>
			<?php } ?>
			<h3 class="judul mt-3"><b>Riwayat Kesehatan Pasien</b></h3>
		</div>
	</div>

	<div class = "row">
		<div class="col-sm-12 table-responsive">			
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<table class="table-judul" style="margin: auto;">
							<tr>
								<td class="col-sm-2">Nama Pasien</td>
								<td class="col-sm-10"><b><?php echo ": ".$datapasien['NamaPasien'];?></b></td>
							</tr>
							<tr>
								<td>Nik</td>
								<td><b><?php echo ": ".$datapasien['Nik'];?></b></td>
							</tr>
							<tr>
								<td>Tanggal Lahir</td>
								<td><b><?php echo ": ".date('d-m-Y', strtotime($datapasien['TanggalLahir']));?></b></td>
							</tr>
							<tr>
								<td>Telp.</td>
								<td><b>
									<?php
										if($datapasien['Telpon'] != ''){
											echo ": ".$datapasien['Telpon'];
										}else{
											echo "<span style='color:red;font-weight:bold'>Belum Diinputkan</span>";
										}
									?></b>
								</td>
							</tr>
						</table>
					</div>
				</form>		
			</div>
		</div>
	</div>
	
	<div class="table-responsive">
		<table class="table-judul table-bordered">
			<thead>
				<tr>
					<th width="3%">No.</th>
					<th width="17%">Keterangan</th>
					<th width="25%">Subjektive</th>
					<th width="15%">Objektive</th>
					<th width="20%">Assesment</th>
					<th width="20%">Planning</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$jumlah_perpage = 5;
				
				if($_GET['h']==''){
					$mulai=0;
				}else{
					$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}
				
				$str = "SELECT * FROM `$tbpasienrj` WHERE `IdPasien` = '$idps' AND `StatusPasien`='1'";		
				$str2 = $str." ORDER BY IdPasienrj DESC LIMIT $mulai,$jumlah_perpage";
				// echo $str2;

				if($_GET['h'] == null || $_GET['h'] == 1){
					$no = 0;
				}else{
					$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}

				$query = mysqli_query($koneksi, $str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$idpasienrj = $data['IdPasienrj'];
					$noreg = $data['NoRegistrasi'];
					
					if($data['PoliPertama'] == 'POLI Anak'){
						$tbpoliks = 'tbpolianak';	
					}elseif($data['PoliPertama'] == 'POLI GIZI'){
						$tbpoliks = 'tbpoligizi';
					}elseif($data['PoliPertama'] == 'POLI GIGI'){
						$tbpoliks = "tbpoligigi_".str_replace(' ', '', $namapuskesmas);
					}elseif($data['PoliPertama'] == 'POLI IMUNISASI'){
						$tbpoliks = 'tbpoliimunisasi';	
					}elseif($data['PoliPertama'] == 'POLI ISOLASI'){
						$tbpoliks = 'tbpoliisolasi';		
					}elseif($data['PoliPertama'] == 'POLI KB'){
						$tbpoliks = 'tbpolikb';
					}elseif($data['PoliPertama'] == 'POLI KIA'){
						$tbpoliks = "tbpolikia_".str_replace(' ', '', $namapuskesmas);
					}elseif($data['PoliPertama'] == 'POLI LABORATORIUM'){
						$tbpoliks = 'tbpolilaboratorium';
					}elseif($data['PoliPertama'] == 'POLI LANSIA'){
						$tbpoliks = "tbpolilansia_".str_replace(' ', '', $namapuskesmas);
					}elseif($data['PoliPertama'] == 'POLI MTBS'){
						$tbpoliks = "tbpolimtbs_".str_replace(' ', '', $namapuskesmas);
					}elseif($data['PoliPertama'] == 'POLI PANDU PTM'){
						$tbpoliks = 'tbpolipanduptm';	
					}elseif($data['PoliPertama'] == 'POLI INFEKSIUS'){
						$tbpoliks = 'tbpoliinfeksius';
					}elseif($data['PoliPertama'] == 'POLI SCREENING'){
						$tbpoliks = 'tbpoliscreening';	
					}elseif($data['PoliPertama'] == 'POLI SKD'){
						$tbpoliks = 'tbpoliskd';		
					}elseif($data['PoliPertama'] == 'POLI TB DOTS'){
						$tbpoliks = 'tbpolitbdots';	
					}elseif($data['PoliPertama'] == 'POLI UMUM'){
						$tbpoliks = "tbpoliumum_".str_replace(' ', '', $namapuskesmas);
					}

					$queryks = mysqli_query($koneksi, "SELECT * FROM `$tbpoliks` WHERE `IdPasienrj`='$data[IdPasienrj]'");
					$dtks = mysqli_fetch_assoc($queryks);

					// vitalsign
					$strvs = "SELECT * FROM `$tbvitalsign` WHERE `IdPasienrj`='$data[IdPasienrj]'";
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
					
					if($dtsistole != ''){$dtsistole = $dtsistole;}else{$dtsistole = $dtks['Sistole'];}
					if($dtdiastole != ''){$dtdiastole = $dtdiastole;}else{$dtdiastole = $dtks['Diastole'];}
					if($dtsuhutubuh != ''){$dtsuhutubuh = $dtsuhutubuh;}else{$dtsuhutubuh = $dtks['SuhuTubuh'];}
					if($dttinggiBadan != ''){$dttinggiBadan = $dttinggiBadan;}else{$dttinggiBadan = $dtks['TinggiBadan'];}
					if($dtberatBadan != ''){$dtberatBadan = $dtberatBadan;}else{$dtberatBadan = $dtks['BeratBadan'];}
					if($dtheartRate != ''){$dtheartRate = $dtheartRate;}else{$dtheartRate = $dtks['DetakNadi'];}
					if($dtrespRate != ''){$dtrespRate = $dtrespRate;}else{$dtrespRate = $dtks['RR'];}
					if($dtLingkarPerut != ''){$dtLingkarPerut = $dtLingkarPerut;}else{$dtLingkarPerut = $dtks['LingkarPerut'];}
					if($imt != ''){$imt = $imt;}else{$imt = $dtks['Imt'];}
					
					// tbpasienperpegawai
					$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
					$dtpspegawai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienperpegawai` WHERE NoRegistrasi='$noreg'"));
					if($dttherapy['KodeBarang'] != ""){
						$trp = $dttherapy['KodeBarang'];
					}else{
						$trp = "-";
					}				
			?>
					<tr>
						<td align="center" style="vertical-align: top;"><?php echo $no;?></td>
						<td align="left" style="vertical-align: top;">
							<?php 
								if($dtpspegawai['NamaPegawai1'] != ""){
									$pgw = strtoupper($dtpspegawai['NamaPegawai1']);
								}else{
									$pgw = strtoupper($dtpspegawai['NamaPegawai2']);
								}
								echo	
								'<i class="icon-calendar"></i>&nbsp'.strtoupper($data['TanggalRegistrasi'])."<br/>".
								'<i class="icon-home"></i>&nbsp'.str_replace('POLI','PELAYANAN',$data['PoliPertama'])."<br/>".
								'<i class="icon-user"></i>&nbsp'.$pgw."<br/><br/>";
							?>
						</td>
						<td align="left" style="vertical-align: top;">
							<?php  if($dtks['Anamnesa'] !=''){ ?>
								<?php 
									// alergi makan
									if ($dtks['RiwayatAlergiMakanan'] == '00'){
										$alergimakan = "Tidak Ada";
									}elseif($dtks['RiwayatAlergiMakanan'] == '01'){
										$alergimakan = "Seafood";		
									}elseif($dtks['RiwayatAlergiMakanan'] == '02'){
										$alergimakan = "Gandum";
									}elseif($dtks['RiwayatAlergiMakanan'] == '03'){
										$alergimakan = "Susu Sapi";
									}elseif($dtks['RiwayatAlergiMakanan'] == '04'){
										$alergimakan = "Kacang-Kacangan";
									}elseif($dtks['RiwayatAlergiMakanan'] == '05'){
										$alergimakan = "Makanan Lain";
									}

									// alergi udara
									if ($dtks['RiwayatAlergiUdara'] == '00'){
										$alergiudara = "Tidak Ada";
									}elseif($dtks['RiwayatAlergiUdara'] == '01'){
										$alergiudara = "Udara Panas";		
									}elseif($dtks['RiwayatAlergiUdara'] == '02'){
										$alergiudara = "Udara Dingin";
									}elseif($dtks['RiwayatAlergiUdara'] == '03'){
										$alergiudara = "Udara Kotor";
									}

									// alergi obat
									if ($dtks['RiwayatAlergiObat'] == '00'){
										$alergiobat = "Tidak Ada";
									}elseif($dtks['RiwayatAlergiObat'] == '01'){
										$alergiobat = "Antibiotik";		
									}elseif($dtks['RiwayatAlergiObat'] == '02'){
										$alergiobat = "Antiinflamasi";
									}elseif($dtks['RiwayatAlergiObat'] == '03'){
										$alergiobat = "Non Steroid";
									}elseif($dtks['RiwayatAlergiObat'] == '04'){
										$alergiobat = "Aspirin";
									}elseif($dtks['RiwayatAlergiObat'] == '05'){
										$alergiobat = "Kortikosteroid";
									}elseif($dtks['RiwayatAlergiObat'] == '06'){
										$alergiobat = "Insulin";
									}elseif($dtks['RiwayatAlergiObat'] == '07'){
										$alergiobat = "Obat-Obatan Lain";
									}

									// prognosa
									if ($dtks['Prognosis'] == '01'){
										$prognosa = "Sanam (Sembuh)";
									}elseif($dtks['Prognosis'] == '02'){
										$prognosa = "Bonam (Baik)";		
									}elseif($dtks['Prognosis'] == '03'){
										$prognosa = "Malam (Buruk/Jelek)";
									}elseif($dtks['Prognosis'] == '04'){
										$prognosa = "Dubia Ad Sanam/Bolam (Tidak tentu/Ragu-ragu, Cenderung Sembuh/Baik)";
									}elseif($dtks['Prognosis'] == '05'){
										$prognosa = "Dubia Ad Malam (Tidak tentu/Ragu-ragu, Cenderung Sembuh/Baik)";
									}

									echo
									"<b>Anamnesa</b>".
									"<br/>".$dtks['Anamnesa'].
									"<br/><b>Rw.Alergi Makan : </b>".$alergimakan.
									"<br/><b>Rw.Alergi Udara : </b>".$alergiudara.
									"<br/><b>Rw.Alergi Obat : </b>".$alergiobat.
									"<br/><b>Prognosa : </b>".$prognosa.
									"<br/><b>Rw.Penyakit Sekarang : </b>".$dtks['RiwayatPenyakitSekarang'].
									"<br/><b>Rw.Penyakit Terdahulu : </b>".$dtks['RiwayatPenyakitDulu'].
									"<br/><b>Rw.Penyakit Keluarga : </b>".$dtks['RiwayatPenyakitKeluarga'].
									"<br/><b>Anjuran : </b>".$dtks['Anjuran'];
								?>				
							<?php
								if ($dtks['PemeriksaanHasilLab'] != ''){
									$hasillab = $dtks['PemeriksaanHasilLab'];
								}else{
									$hasillab = "Tidak ada pemeriksaan";
								}
								
								if ($data['PoliPertama'] == 'POLI UMUM' OR $data['PoliPertama'] == 'POLI LANSIA'){
									echo									
									"<br/><br/><b>Hasil Lab : </b>".
									"<br/>Hasil Pemeriksaan :".$hasillab;
								}elseif($data['PoliPertama'] == 'POLI GIGI'){
									echo
									"<br/><b>Pemeriksaan Penunjang : </b>".
									"<br/> Rencana Therapy : ".$dtks['RencanaTerapi'].
									"<br/> Tindakan : ".$dtks['Tindakan'].
									"<br/> Informed Consent : ".$dtks['InformedConsent'].
									"<br/> Tindak Lanjut ke-1 : ".$dtks['TindakLanjut1'].
									"<br/> Tindak Lanjut ke-2 : ".$dtks['TindakLanjut2'].
									"<br/> Anjuran Kunj.Ulang : ".$dtks['KunjunganUlang'].
									"<br/> Kunjungan Gigi : ".$dtks['KunjunganGigi'].
									"<br/> Terima Rujukan : ".$dtks['TerimaRujukan'].
									
									"<br/><br/><b>Pemeriksaan Ekstra Oral : </b>".
									"<br/> Palpasi : <b>".$dtks['Palpasi']."</b>".
									"<br/> Suhu Kulit : <b>".$dtks['SuhuKulit']."</b>".
									"<br/> Bibir : <b>".$dtks['Bibir']."</b>".
									"<br/> Kelenjar Linfe : <b>".$dtks['KelenjarLinfe']."</b>".
									"<br/> TMJ : <b>".$dtks['Tmj']."</b>".
									"<br/> Trismus : <b>".$dtks['Trismus']."</b>".

									"<br/><br/><b>Pemeriksaan Intra Oral : </b>".
									"<br/> Karies Gigi : <b>".$dtks['KariesGigi']."</b>".
									"<br/> Sondase : <b>".$dtks['Sondase']."</b>".
									"<br/> Perkusi : <b>".$dtks['Perkusi']."</b>".
									"<br/> Tekanan : <b>".$dtks['Tekanan']."</b>".
									"<br/> Goyang : <b>".$dtks['Goyang']."</b>".
									"<br/> Warna Gusi : <b>".$dtks['WarnaGusi']."</b>".
									"<br/> Konstensi : <b>".$dtks['Konstensi']."</b>".
									"<br/> Bengkak : <b>".$dtks['Bengkak']."</b>";
								}
								
								if ($data['PoliPertama'] == 'POLI LANSIA'){
									"<br/><br/><b>Hasil Lab : </b>".
									"<br/> Gdp :".$dtks['GdpLab'].	
									"<br/> Gds :".$dtks['GdsLab'].
									"<br/> Koles :".$dtks['KolesLab'].
									"<br/> Au :".$dtks['AuLab'].
									"<br/> Hb :".$dtks['HbLab'].
									"<br/> Prot :".$dtks['ProtLab'];
								}else{
									"<br/><br/><b>Hasil Lab : </b>".
									"<br/>Hasil Pemeriksaan :".$hasillab;
								}
								
								}else{
							?>
								<span class='badge badge-warning' style='font-style: italic; padding: 8px;'>Belum Diinputkan</span>
							<?php } ?>
						</td>
						<td align="left" style="vertical-align: top;">							
							<?php 
								echo
								"<b>Tanda Vital</b>".
								"<br/><b>Tensi : </b>".$dtsistole." / ".$dtdiastole.
								"<br/><b>Suhu Tubuh : </b>".$dtsuhutubuh.
								"<br/><b>BB / TB : </b>".$dtberatBadan." Kg / ".$dttinggiBadan." Cm".
								"<br/><b>HR / RR : </b>".$dtheartRate." / ".$dtrespRate.
								"<br/><b>Lingkar Perut : </b>".$dtLingkarPerut.
								"<br/><b>Imt : </b>".$imt;
							?>
						</td>
						<td align="left" style="vertical-align: top;">
							<?php
								// diagnosa
								$str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `IdPasienrj` = '$idpasienrj'";
								$query_diagnosapsn = mysqli_query($koneksi,$str_diagnosapsn);
								while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
									$dtdiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
									$array_data[$no][] = "<b>".$data_diagnosapsn['KodeDiagnosa']."</b> ".$dtdiagnosa['Diagnosa'];
								}
								if ($array_data[$no] != ''){
									$data_dgs = implode("<br/>", $array_data[$no]);
									echo $data_dgs;
								}else{
							?>
									<span class='badge badge-danger' style='padding: 4px;'><i class='icon-close fa-3x'></i></span>
							<?php 
								} 
							?>
						</td>
						<td align="left" style="vertical-align: top;">
							<?php
								// therapy
								$str_therapy = "SELECT * FROM `$tbresepdetail` WHERE `IdPasienrj` = '$idpasienrj'";
								$query_therapy = mysqli_query($koneksi, $str_therapy);
								while($dt_therapy = mysqli_fetch_array($query_therapy)){
									$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `NamaBarang` FROM `$tbapotikstok` WHERE `KodeBarang` = '$dt_therapy[KodeBarang]'"));
									$array_therapy[$no][] = $dtobat['NamaBarang']." (".$dt_therapy['jumlahobat'].")";
								}
								if ($array_therapy[$no] != ''){
									$data_trp = implode("<br/>", $array_therapy[$no]);
									echo $data_trp;
								}else{
							?>		
								<span class='badge badge-danger' style='padding: 4px;'><i class='icon-close fa-3x'></i></span>
							<?php		
								}
							?>
						</td>
					</tr>
					
					
				<?php
				}
				?>
			</tbody>
		</table>
	</div><hr/>
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
						echo "<li><a href='?page=rekam_medis_pasien_detail&idprj=$idprj&idps=$idps&ply=$pelayanan&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>	
</div>