<?php
	include "config/helper_bpjs_v4.php";
	include "config/helper_pasienrj.php";
	$idpasienrj = $_GET['idrj'];
	$datapasienrj = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE `IdPasienrj` = '$idpasienrj'"));
	$nokunjunganbpjs = $datapasienrj['NoKunjunganBpjs'];
	$noregistrasi = $datapasienrj['NoRegistrasi'];

?>

<style>

.logobpjs{
	float:left;
	width:60%;
}
.font12_bold{
	font-size:12px;
	font-weight: bold;
	float:right;
	width:40%;
}
.font_surat_rujukan{
	width:100%;
	font-size:16px;
	font-weight: bold;
	clear:both;
	margin-top:50px;
}
/* untuk mengukur ukuran kertas sesungguhnya */
.kotakluar{ 
	width:100%;
	margin-bottom:0px;
	margin-top:-100px;
	padding:10px;
	margin-top:-10px;
	visibility:visible;
	<!--border:1px solid #000;-->
}
.kotak{
	width:100%;
	margin-bottom:10px;
	border:1px solid #000;
	padding:10px;
	margin-top:0px;
	visibility:visible;
}
.kotakdalam1{
	margin:20px;
	border:1px solid #000;
	padding:10px;
	margin-top:5px;
}
.kotakdalam_noprint{
	margin:20px;
	padding:10px;
	margin-top:5px;
}
.kotakdalam2{
	<!--kpd yth-->
	width:90%;
	margin:20px;
	<!--border:1px solid #000;-->
	padding:10px;
	margin-top:-20px;
}
.kotakdalam3{
	width:90%;
	height:80px;
	margin:20px;
	<!--border:1px solid #000;-->
	padding:10px;
	margin-top:-10px;
}
.kotakdalam4{
	width:90%;
	margin:10px;
	<!--border:1px solid #000;-->
	padding:0px;
	margin-top:-60px;
}
.kotakrujukbalik1{
	width:100%;
	height:420px;
	margin:0px;
	border:1px solid #000;
	padding:10px;
	visibility:visible;
}
.kotakrujukbalik2{
	width:90%;
	height:110px;
	margin:130px;
	//border:1px solid #000;
	padding:10px;
	margin-top:-10px;
	line-height: 25px;
}
.kotakkecil1{
	width:40px;
	height:6px;
	margin:3px;
	margin-left:20px;
	border:1px solid #000;
	padding:10px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}
.red{
	color:rgb(234, 9, 9);
}
.print{
	display:none;
}
@media print{
	body{
		visibility:hidden;
	}
	.print{
		display:block;
	}
	.kotakdalam_noprint{
		display:none;
	}
	.noprint{
		display:none;
	}
	.printheader{
		display:block;
	}	
	.logobpjs{
		width:308px;
	}
	.tab-content{
		background:#fff;
	}

	.kotakluar{
		margin-bottom:-20px;
	}
}
</style>

<?php
// echo $nokunjunganbpjs;
$alasanTacc='-';
if($nokunjunganbpjs != 0){
	$data_rujukan_bpjs = get_rujukan_bpjs($nokunjunganbpjs);
	$dtrujukanbpjs = json_decode($data_rujukan_bpjs,True);
	$code = $json_hasil_simpan_bpjs['metaData']['code'];
	// echo "Hasil : ".$data_rujukan_bpjs;

	if($code == '200'){
		$dtregional = $dtrujukanbpjs['response']['ppk']['kc']['kdKR']['nmKR'];
		$dtkantorcabang = $dtrujukanbpjs['response']['ppk']['kc']['nmKC'];
		$dtkodepuskesmas = $dtrujukanbpjs['response']['ppk']['kdPPK'];
		$dtpuskesmas = $dtrujukanbpjs['response']['ppk']['nmPPK'];
		$dtkodekota = $dtrujukanbpjs['response']['ppk']['kc']['kdKC'];
		$dtkota = $dtrujukanbpjs['response']['ppk']['kc']['nmKC'];
		$dtnobpjs = $dtrujukanbpjs['response']['nokaPst'];
		$dtpeserta = $dtrujukanbpjs['response']['nmPst'];
		$dtpisa = $dtrujukanbpjs['response']['pisa'];
		$dttanggallhr = $dtrujukanbpjs['response']['tglLahir'];
		$dtkelamin = $dtrujukanbpjs['response']['sex'];
		$dtdiagnosa = $dtrujukanbpjs['response']['diag1']['nmDiag']." ".$dtrujukanbpjs['response']['diag2']['nmDiag'];
		$dtdokter = $dtrujukanbpjs['response']['dokter']['nmDokter'];
		$nmTacc = $dtrujukanbpjs['response']['tacc']['nmTacc'];
		$alasanTacc = $dtrujukanbpjs['response']['tacc']['alasanTacc'];
		$dtpolirs = $dtrujukanbpjs['response']['poli']['nmPoli'];
		$dtnamars = $dtrujukanbpjs['response']['ppkRujuk']['nmPPK'];
	}elseif($code = '412'){
		alert_swal('gagal','Print di Pcare! Transaksi dikunci karena sudah ditagihkan atau data > 3 bulan atau sudah dilayani RS');
		// echo "<script>";
		// echo "document.location.href='index.php?page=poli_periksa_print&noreg=".$noregistrasi."&idrj=".$idpasienrj."';";
		// echo "</script>";
	}
	
	// $data_kunjungan_bpjs = get_kunjungan_edit($dtnobpjs);
	// $dtkunbpjs = json_decode($data_kunjungan_bpjs,true);
	// $dtpolirs = $dtkunbpjs['response']['list'][0]['poliRujukLanjut']['nmPoli'];
	// $dtnamars = $dtkunbpjs['response']['list'][0]['providerRujukLanjut']['nmProvider'];
	// echo $data_kunjungan_bpjs;	
	
	$tglla=explode("-",$dttanggallhr);
	$tgl_lahir=$tglla[0];
	$bln_lahir=$tglla[1];
	$thn_lahir=$tglla[2];

	$tanggal_today = date('d');
	$bulan_today=date('m');
	$tahun_today = date('Y');

	$harilahir=gregoriantojd($bln_lahir,$tgl_lahir,$thn_lahir); //menghitung jumlah hari sejak tahun 0 masehi
	$hariini=gregoriantojd($bulan_today,$tanggal_today,$tahun_today);//menghitung jumlah hari sejak tahun 0 masehi

	$umur=$hariini-$harilahir;//menghitung selisih hari antara tanggal sekarang dengan tanggal lahir

	$tahun=$umur/365;//menghitung usia tahun
	$sisa=$umur%365;//sisa pembagian dari tahun untuk menghitung bulan
	$bulan=$sisa/30;//menghitung usia bulan
	$hari=$sisa%30;//menghitung sisa hari	

	$tahun_umur = floor($tahun); // floor pembulatan
	$bulan_umur = floor($bulan);
	$hari_umur = $hari;	
	}
	
	// jika diagnosanya lebih dari 1 maka ambil di tabel lokal
	$tbdiagnosapasien_bln = "tbdiagnosapasien_".substr($noregistrasi,14,2);
	$datadiagnosapasiens = mysqli_query($koneksi,"SELECT * FROM `$tbdiagnosapasien_bln` a JOIN `tbdiagnosabpjs` b on a.KodeDiagnosa = b.KodeDiagnosa WHERE a.NoRegistrasi = '$noregistrasi'");
	while($dtdiags = mysqli_fetch_assoc($datadiagnosapasiens)){
		$dtdiagarr[] = $dtdiags['Diagnosa'];
	}
	if(count($dtdiagarr) > 1){	
		$datadiagnosapasien_lokal = implode(", ",$dtdiagarr);
	}else{
		$datadiagnosapasien_lokal = $dtdiagnosa;
	}
?>
<div class="tableborderdiv">
	<div class="formbg">
		<div class="btn-group mb-4" role="group" aria-label="Basic example">
			<button type="button" class="btn btn-info btntabforms" data-ket="rujuklanjut">Rujuk Lanjut</button>
			<button type="button" class="btn btn-outline-secondary btntabforms" data-ket="rujukbalik">Rujuk Balik</button>
		</div>
		<div class="tmp_form_rujuklanjut">
			<h4 class="judul">Form Rujuk Lanjut</h4>
			<div class="kotakdalam_noprint">
				<table>
					<tr>
						<td width="200px">No.Rujukan</td>
						<td width="20px">:</td>
						<td><?php echo $datapasienrj['NoKunjunganBpjs'];?></td>
						
						<td colspan="3" rowspan="6" width="620px" align="right"><img id="barcode"/></td>
					</tr>
					<tr>
						<td width="200px">Poli</td>
						<td width="20px">:</td>
						<td><?php echo $dtpolirs ?></td>
					</tr>
					<tr>
						<td width="200px">Rumah Sakit</td>
						<td width="20px">:</td>
						<td><?php echo $dtnamars ?></td>
					</tr>
					<tr>
						<td width="200px">Nama Pasien</td>
						<td width="20px">:</td>
						<td width="200px"><?php echo $dtpeserta ?></td>
					</tr>	
					<tr>
						<td width="200px">Umur</td>
						<td width="20px">:</td>
						<td width="40px"><?php echo $tahun_umur;?> Tahun, <?php echo $dttanggallhr ?></td>
					</tr>	
					<tr>
						<td width="200px">No. Kartu BPJS</td>
						<td width="20px">:</td>
						<td width="200px"><?php echo $dtnobpjs ?></td>
					</tr>	
					
				</table>
			</div>
			<div class="print">	
				<div class="kotakluar">
					<div class="logobpjs"><img src="image/logo_bpjs.jpg" width="208px"  alt="logo_bpjs" /></div>
					<div class="font12_bold">
						<table>
							<tr>
								<td width="150px" style="margin-top:-50px">Divisi Regional</td>
								<td width="400px"><?php echo $dtregional ?></td>
							</tr>
							<tr>
								<td width="120px">Kantor Cabang</td>
								<td width="400px"><?php echo $dtkantorcabang ?></td>
							</tr>
						</table>
					</div>
					<div align="center" class="font_surat_rujukan" >Surat Rujukan FKTP<br/></div>
				</div>
				<br/>
				<div class="kotak">
					<div class="kotakdalam1">
						<table>
							<tr>
								<td width="110px">No.Rujukan</td>
								<td width="20px">:</td>
								<td width="220px"><?php echo $datapasienrj['NoKunjunganBpjs'];?></td>
								<td width="50px"></td>
								<td colspan="3" rowspan="3"><img id="barcode"/></td>
							</tr>
							<tr>
								<td>FKTP</td>
								<td>:</td>
								<td><?php echo $dtpuskesmas."-".$dtkodepuskesmas ?></td>
								<td ></td>
							</tr>
							<tr>
								<td>Kabupaten/Kota</td>
								<td>:</td>
								<td><?php echo $dtkota."-".$dtkodekota ?></td>
								<td ></td>
							</tr>
							
						</table>
					</div><br/>
					
					<div class="kotakdalam2">
						<table>
							<tr>
								<td width="200px">Kepada Yth. TS Dokter</td>
								<td width="20px">:</td>
								<td><?php echo $dtpolirs ?></td>
							</tr>
							<tr>
								<td width="200px">Di</td>
								<td width="20px">:</td>
								<td><?php echo $dtnamars ?></td>
							</tr>
						</table>
					</div>
					<div style="margin-left:20px; margin-bottom:15px;">Mohon pemeriksaan dan penanganan lebih lanjut penderita :</div>
					
					<div class="kotakdalam3">
						<table>
							<tr>
								<td width="180px">Nama</td>
								<td width="20px">:</td>
								<td width="200px"><?php echo $dtpeserta ?></td>
								<td width="50px">Umur</td>
								<td width="15px">:</td>
								<td width="40px"><?php echo $tahun_umur;?></td>
								<td width="150px">Tahun, <?php echo $dttanggallhr ?></td>
								<td></td>
							</tr>
							<tr>
								<td width="160px">No. Kartu BPJS</td>
								<td width="20px">:</td>
								<td width="200px"><?php echo $dtnobpjs ?></td>
								<td width="50px">Status</td>
								<td width="15px">:</td>
								<td width="40px"><?php echo $dtpisa?></td>
								<td width="150px">Utama/ Tanggungan</td>
								<td><?php echo $dtkelamin.'&nbsp&nbsp&nbsp&nbsp&nbsp(L/P)' ?></td>
							</tr>
							<tr>
								<td width="160px">Diagnosa</td>
								<td width="15px">:</td>
								<td width="200px" colspan="5"><?php echo $datadiagnosapasien_lokal;?></td>
							</tr>
							<tr>
								<td width="160px">Telah diberikan</td>
								<td width="20px">:</td>
								<td></td>
							</tr>
						</table>
					</div>
					<?php
					// $alasanTacc = $dtrujukanbpjs['response']['tacc']['alasanTacc'];
					// if($alasanTacc != null){
					?>
						<!-- <div style="margin-left:20px; margin-top:10px;" class="red"># Alasan Rujuk Diagnosa Non-Spesialistik : (<?php echo $nmTacc;?>) <?php echo $alasanTacc;?></div> -->
					<?php
						// }		
					?>
					
					<div class="kotakdalam4" style="margin-top:30px;">
						<table>
							<tr>
								<td width="500px">
									Demikian atas bantuannya, diucapkan banyak terima kasih
									<table width="100%" style="margin-top:20px;">
										<tr>
											<td>Tgl.Rencana Berkunjung</td>
											<td>:</td>
											<td><?php echo $dtrujukanbpjs['response']['tglEstRujuk'];?></td>
										</tr>
										<tr>
											<td>Jadwal Praktek</td>
											<td>:</td>
											<td><?php echo $dtrujukanbpjs['response']['jadwal'];?></td>
										</tr>
										<tr>
											<td colspan="3">Surat rujukan berlaku 1[satu] kali kunjungan, berlaku sampai <?php echo $dtrujukanbpjs['response']['tglAkhirRujuk'];?></td>
										</tr>
									</table>
								</td>
								<td width="100px"></td>
								<td width="200px" align="center">
									Salam sejawat, <br/><?php echo date("Y-M-d")?>
									<br/>
									<br/>
									<br/>
									<br/>
									<?php echo $dtdokter?>
								</td>
							</tr>
							
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="tmp_form_rujukbalik" style="display:none">
			<h4 class="judul">Form Rujuk Balik</h4>
			<div class="kotakdalam_noprint">
				<table>
					<tr>
						<td width="200px">No.Rujukan</td>
						<td width="20px">:</td>
						<td><?php echo $datapasienrj['NoKunjunganBpjs'];?></td>
						
						<td colspan="3" rowspan="6" width="620px" align="right"><img id="barcode"/></td>
					</tr>
					<tr>
						<td width="200px">Poli</td>
						<td width="20px">:</td>
						<td><?php echo $dtpolirs ?></td>
					</tr>
					<tr>
						<td width="200px">Rumah Sakit</td>
						<td width="20px">:</td>
						<td><?php echo $dtnamars ?></td>
					</tr>
					<tr>
						<td width="200px">Nama Pasien</td>
						<td width="20px">:</td>
						<td width="200px"><?php echo $dtpeserta ?></td>
					</tr>	
					<tr>
						<td width="200px">Umur</td>
						<td width="20px">:</td>
						<td width="40px"><?php echo $tahun_umur;?> Tahun, <?php echo $dttanggallhr ?></td>
					</tr>	
					<tr>
						<td width="200px">No. Kartu BPJS</td>
						<td width="20px">:</td>
						<td width="200px"><?php echo $dtnobpjs ?></td>
					</tr>	
					
				</table>
			</div>
			<div class="print">
				<div class="kotakluar">
					<div class="logobpjs"><img src="image/logo_bpjs.jpg" width="208px"  alt="logo_bpjs" /></div>
					<div class="font12_bold">
						<table>
							<tr>
								<td width="150px" style="margin-top:-50px">Divisi Regional</td>
								<td width="400px"><?php echo $dtregional ?></td>
							</tr>
							<tr>
								<td width="120px">Kantor Cabang</td>
								<td width="400px"><?php echo $dtkantorcabang ?></td>
							</tr>
						</table>
					</div>
					<div align="center" class="font_surat_rujukan" >Surat Rujukan FKTP<br/><br/></div>
				</div>
				<div class="kotak">
					<div class="kotakdalam1">
						<table>
							<tr>
								<td width="110px">No.Rujukan</td>
								<td width="20px">:</td>
								<td width="220px"><?php echo $datapasienrj['NoKunjunganBpjs'];?></td>
								<td width="50px"></td>
								<td colspan="3" rowspan="3"><img id="barcode"/></td>
							</tr>
							<tr>
								<td>FKTP</td>
								<td>:</td>
								<td><?php echo $dtpuskesmas."-".$dtkodepuskesmas ?></td>
								<td ></td>
							</tr>
							<tr>
								<td>Kabupaten/Kota</td>
								<td>:</td>
								<td><?php echo $dtkota."-".$dtkodekota ?></td>
								<td ></td>
							</tr>
							
						</table>
						<script>JsBarcode("#barcode", "<?php echo $datapasienrj['NoKunjunganBpjs'];?>",{width:2,height:35,displayValue: false});</script>
						
					</div><br/>
					
					<div class="kotakdalam2">
						<table>
							<tr>
								<td width="200px">Kepada Yth. TS dr. Poli</td>
								<td width="20px">:</td>
								<td><?php echo $dtpolirs ?></td>
							</tr>
							<tr>
								<td width="200px">Di RSU</td>
								<td width="20px">:</td>
								<td><?php echo $dtnamars ?></td>
							</tr>
						</table>
					</div>
					<div style="margin-left:20px; margin-bottom:15px;">Mohon pemeriksaan dan penanganan lebih lanjut penderita :</div>
					
					<div class="kotakdalam3">
						<table>
							<tr>
								<td width="160px">Nama</td>
								<td width="20px">:</td>
								<td width="200px"><?php echo $dtpeserta ?></td>
								<td width="50px">Umur</td>
								<td width="15px">:</td>
								<td width="40px"><?php echo $tahun_umur;?></td>
								<td width="150px">Tahun, <?php echo $dttanggallhr ?></td>
								<td></td>
							</tr>
							<tr>
								<td width="180px">No. Kartu BPJS</td>
								<td width="20px">:</td>
								<td width="200px"><?php echo $dtnobpjs ?></td>
								<td width="50px">Status</td>
								<td width="15px">:</td>
								<td width="40px"><?php echo $dtpisa?></td>
								<td width="150px">Utama/ Tanggungan</td>
								<td><?php echo $dtkelamin.'&nbsp&nbsp&nbsp&nbsp&nbsp(L/P)' ?></td>
							</tr>
							<tr>
								<td width="160px">Diagnosa</td>
								<td width="15px">:</td>
								<td width="200px" colspan="5"><?php echo $datadiagnosapasien_lokal;?></td>
							</tr>
							<tr>
								<td width="160px">Telah diberikan</td>
								<td width="20px">:</td>
								<td></td>
							</tr>
						</table>
					</div>
					<?php
					// $alasanTacc = $dtrujukanbpjs['response']['tacc']['alasanTacc'];
					// if($alasanTacc != null){
					?>
						<!-- <div style="margin-left:20px; margin-top:10px;" class="red"># Alasan Rujuk Diagnosa Non-Spesialistik : (<?php echo $nmTacc;?>) <?php echo $alasanTacc;?></div> -->
					<?php
						// }		
					?>
					<div class="kotakdalam4" style="margin-top:30px;">
						<table>
							<tr>
								<td width="500px">
									Demikian atas bantuannya, diucapkan banyak terima kasih
									<table width="100%" style="margin-top:20px;">
										<tr>
											<td>Tgl.Rencana Berkunjung</td>
											<td>:</td>
											<td><?php echo $dtrujukanbpjs['response']['tglEstRujuk'];?></td>
										</tr>
										<tr>
											<td>Jadwal Praktek</td>
											<td>:</td>
											<td><?php echo $dtrujukanbpjs['response']['jadwal'];?></td>
										</tr>
										<tr>
											<td colspan="3">Surat rujukan berlaku 1[satu] kali kunjungan, berlaku sampai <?php echo $dtrujukanbpjs['response']['tglAkhirRujuk'];?></td>
										</tr>
									</table>
								</td>
								<td width="100px"></td>
								<td width="200px" align="center">
								
									Salam sejawat, <?php echo date("Y-M-d")?>
									<br/>
									<br/>
									<br/>
									<br/>
									<?php echo $dtdokter?>
								</td>
							</tr>
							
						</table>
					</div>
				</div>
				<div class="kotakrujukbalik1">
					<div align="center" class="font_surat_rujukan" style="margin-top:5px;">SURAT RUJUKAN BALIK</div>
					<div style="margin-left:20px; margin-top:5px;">Teman Sejawat Yth.</div>
					<div style="margin-left:20px; margin-top:0px;">Mohon kontrol selanjutnya penderita :</div>
					<div class="kotakrujukbalik2">
						<table>
							<tr>
								<td width="160px">Nama</td>
								<td width="20px">:</td>
								<td width="200px"><?php echo $dtpeserta ?></td>
							</tr>
							<tr>
								<td width="160px">Diagnosa</td>
								<td width="20px">:</td>
								<td width="200px">...................................................................................................</td>
							</tr>
							<tr>
								<td width="160px">Terapi</td>
								<td width="15px">:</td>
								<td width="200px">...................................................................................................</td>
							</tr>
						</table>
					</div>
					<div style="margin-left:20px; margin-top:-150px; margin-bottom:10px">Tindak lanjut yang dianjurkan</div>
					<div style="line-height:0px;">
						<table style="line-height:0px;">
							<tr>
								<td><div class="kotakkecil1"></div></td>
								<td width="250px">Pengobatan dengan obat-obatan :</td>
								<td width="50px"></td>
								<td><div class="kotakkecil1"></div></td>
								<td width="250px">Perlu rawat inap</td>
							</tr>
							<tr>
								<td></td>
								<td width="250px">....................................................................</td>
								<td width="50px"></td>
								<td><div class="kotakkecil1"></div></td>
								<td width="250px">Konsultasi selesai</td>
							</tr>
							<tr>
								<td><div class="kotakkecil1"></div></td>
								<td width="250px">Kontrol kembali ke RS tanggal : ..........</td>
								<td width="50px"></td>
								<td><div class="kotakkecil1"></div></td>
								<td width="275px">......................................... tgl .........................................</td>
							</tr>
							<tr>
								<td><div class="kotakkecil1"></div></td>
								<td width="250px">Lain-lain : .................................................</td>
								<td width="50px"></td>
							</tr>
						</table>
					</div>
					
					<div class="kotakdalam4">
						<table>
							<tr style="margin-top:-10px;">
								<td width="300px"></td>
								<td width="300px"></td>
								<td width="150px" align="center" style="line-height:120px;">Dokter RS,</td>
							</tr>
							<tr>
								<td width="300px"></td>
								<td width="300px"></td>
								<td width="150px" align="center">(......................................................................)</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<a href="javascript:print()" class="btn btn-round btn-success noprint btnsimpan">Print</a>
			</div>
			<div class="col-sm-6">
				<a href="index.php?page=poli&pelayanan=<?php echo $_GET['pelayanan']?>&status=Antri" class="btn btn-round btn-info noprint btnsimpan">Kembali</a>
			</div>
		</div>
</div>

	
<!-- <div class="row">
	<div class="col-lg-12">
		<?php
			// $data_rujukan_bpjs = get_rujukan_bpjs($nokunjunganbpjs);
			// $dbpjs = json_decode($data_rujukan_bpjs,true);
			// if ($dbpjs['metaData']['code'] == 500 || $dbpjs['metaData']['code'] == 401 || $dbpjs['metaData']['code'] == 408 || $dbpjs['metaData']['code'] == 424){
		?>
		<div class="alert alert-block alert-danger fade in">
			<strong><i class="ace-icon fa fa-times"></i> Data tidak ditemukan!</strong> terjadi ganguan koneksi pada Web Service BPJS.<br/>
		</div>
		<?php
			// die();
			// }else{
		?>
			<div class="alert alert-block alert-info fade in">
				<p>Jika No.Rujukan tidak tampil, coba edit data pemeriksaan lalu simpan/kirim ulang.</p>
			</div>	
		<?php
			// }
		?>
	</div>
</div> -->

<script src="assets/js/jquery.js"></script>
<script>
	$('.btntabforms').click(function(){
		var ket = $(this).data("ket");
		if(ket == 'rujuklanjut'){
			$(".tmp_form_rujuklanjut").show();
			$(".tmp_form_rujukbalik").hide();
		}else{
			$(".tmp_form_rujuklanjut").hide();
			$(".tmp_form_rujukbalik").show();
		}
	});
</script>	
			
				
			