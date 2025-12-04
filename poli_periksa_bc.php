<?php
	include "config/helper_bpjs.php";
	$noregistrasi = $_GET['no'];
	$pelayanan = $_GET['pelayanan'];
	$tbpasienrj = 'tbpasienrj_'.substr($noregistrasi,14,2);	
	$query = mysqli_query($koneksi,"SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'");
	$data = mysqli_fetch_assoc($query);
	$jeniskunjungan = $data['JenisKunjungan'];
	$kota = $_SESSION['kota'];
	$otoritas = explode(',',$_SESSION['otoritas']);
	$kdprovider = $data['kdprovider'];
			
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
	
	$sts_resep = $_GET['sts_resep'];
	
	// $data_provider = get_data_provider();
	// $dprovider = json_decode($data_provider,True);
	// echo $data_provider;
	
	// $data_polirs = get_data_polirs();
	// $dprovider = json_decode($data_polirs,True);
	// echo $data_polirs;
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
	background: #3bac9b;
	border-collapse: separate;
	font-size: 12px;
	line-height: 20px;
	text-align:center;
	padding: 5px 10px;
	color:#fff;
}	
.tabel_isi{
	background:#fff;
	color: #000;
	padding: 5px 10px;
	text-align:center;
}
.autocomplete-suggestions {
	width:500px !important;
}
</style>

<div class="tableborderdiv">
	<a href="index.php?page=poli&pelayanan=<?php echo $pelayanan;?>" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
	<h3 class="judul"><b><?php echo $pelayanan;?></b></h3>
	<form action="poli_periksa_proses.php" method="post">
	<div class="row search-page noprint" id="search-page-1">
		<input type="hidden" class="lokasikota" value="<?php echo $kota;?>"><!-- untuk source getformtambahan-->
		<input type="hidden" name="status2" value="<?php echo $_GET['status'];?>">
		<input type="hidden" name="tptgl" value="<?php echo $_GET['tptgl'];?>">
		<input type="hidden" name="sts_resep" value="<?php echo $sts_resep;?>">
		<input type="hidden" name="kdprovider" value="<?php echo $kdprovider;?>">
		<input type="hidden" name="jeniskunjungan" value="<?php echo $data['JenisKunjungan'];?>">
		<div class="col-xs-12">
			<div class="row">
				<div class="col-xs-12 col-sm-12">
					<div class="formbg">
						<div class="table-responsive">
							<div class="col-sm-6">
								<table class="table table-condensed table-striped">
									<tr>
										<td class="nocm" style="display:none"><?php echo $data['NoCM'];?></td>
										<td class="noregistrasi" style="display:none"><?php echo $data['NoRegistrasi'];?></td>
										<td class="pelayanan" style="display:none"><?php echo $data['PoliPertama'];?></td>
										<td class="col-sm-3">Nama Pasien</td>
										<td class="col-sm-9"><b><?php echo $data['NamaPasien'];?></b></td>
									</tr>
									<tr>
										<td>Umur</td>
										<td><?php echo $data['UmurTahun'];?> thn, <?php echo $data['UmurBulan'];?> Bln, <?php echo $data['UmurHari'];?> Hri</td>
									</tr>
									<tr>
										<td>Jaminan</td>
										<td><?php echo $data['Asuransi'];?></td>
									</tr>
								</table>
									<a href="#" class="btnmodalpasien"> [ Edit Data ]</a>
							</div>
							<div class="col-sm-6">
								<table class="table table-condensed table-striped">
									<tr>
										<td class="col-sm-3">No.Pemeriksaan</td>
										<td class="col-sm-9"><?php echo $data['NoRegistrasi'];?></td>
									</tr>
									<tr>
										<td>No.BPJS</td>
										<td><?php if($nokartubpjs == null || $nokartubpjs == 0){ echo "<span style='color:red;font-weight:bold'>Belum Terdaftar</span>";}else{ echo $nokartubpjs;}?></td>
									</tr>									
									<tr>
										<td>Kode Provider</td>
										<td>
										<?php 
										if($kdprovider == null || $kdprovider == '0'){ 
											echo "<span style='color:red;font-weight:bold'>Belum Terdaftar</span>";
										}else{ 
											echo $kdprovider;
										}?>
										</td>
									</tr>	
								</table>
							</div>	
						</div>
						<input type="hidden" name="nopemeriksaan" value="<?php echo $data['NoRegistrasi'];?>">
						<input type="hidden" name="noregistrasi" class="noregistrasiclass" value="<?php echo $noregistrasi;?>">
						<input type="hidden" name="noindex" value="<?php echo $data['NoIndex'];?>">
						<input type="hidden" name="nocm" value="<?php echo $data['NoCM'];?>">
						<input type="hidden" name="umurtahun" value="<?php echo $data['UmurTahun'];?>">
						<input type="hidden" name="umurbulan" value="<?php echo $data['UmurBulan'];?>">
						<input type="hidden" name="asuransi" class="asuransicls" value="<?php echo $data['Asuransi'];?>">
						<input type="hidden" name="nokartubpjs" value="<?php echo $nokartubpjs;?>">
						<input type="hidden" name="pelayanan" value="<?php echo $pelayanan;?>">
						<input type="hidden" name="poli_bpjs" value="<?php echo $data['kdpoli'];?>">
					</div>
				</div>
			</div>
		</div>
		<!--riwayat pasien-->
		<?php
		$str_riwayat = "SELECT NoRegistrasi FROM tbpasienrj WHERE NoCM='$data[NoCM]' ORDER BY TanggalRegistrasi DESC LIMIT 5";
		$cek_riwayat = mysqli_num_rows(mysqli_query($koneksi,$str_riwayat));
		if($cek_riwayat > 0){
		?>
		<div class="box border black">
			<div class="col-lg-12"  style="margin-top:-20px;">
				<div class="widget-box transparent">
					<h3 class="judul"><b>RIWAYAT PASIEN</b></h3>
					<div class="table-responsive">
						<table class="table-judul-laporan" width="100%">
							<thead>
								<tr>
									<th width="10%">Tanggal</th>
									<th width="10%">Poli</th>
									<th width="10%">Umur</th>
									<th width="10%">Jaminan</th>
									<th width="10%">Status Pulang</th>
									<th width="30%">Diagnosa</th>
									<?php
										if (in_array("POLI GIGI", $otoritas) || in_array("POLI KB", $otoritas) || in_array("POLI KIA", $otoritas) ||
										in_array("POLI MTBS", $otoritas) || in_array("POLI MTBM", $otoritas) || in_array("POLI LANSIA", $otoritas) ||
										in_array("POLI LABORATORIUM", $otoritas) || in_array("POLI UMUM", $otoritas) || in_array("APOTEK", $otoritas) ||
										in_array("OPERATOR", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){
									?>
									<th width="6%">Opsi</th>
									<?php }?>
								</tr>
							</thead>
							<tbody class="tabel_isi">
								<?php
								$queryriwayat = mysqli_query($koneksi,$str_riwayat);
								while($riwayat = mysqli_fetch_assoc($queryriwayat)){
									$noregs = $riwayat['NoRegistrasi'];
									$tbpasienrj = 'tbpasienrj_'.substr($noregs,14,2);	
									$sss = "SELECT * FROM $tbpasienrj WHERE NoRegistrasi = '$noregs'";
									$detailriwayat = mysqli_fetch_assoc(mysqli_query($koneksi,$sss));
								if ($detailriwayat['StatusPulang'] == '3'){$statusplg='Berobat Jalan';}else{$statusplg='Rujuk Lanjut';}	
									if ($detailriwayat['PoliPertama'] == 'POLI UMUM'){
										$tbpoli = 'tbpoliumum_'.substr($noregs,14,2);
									}elseif($detailriwayat['PoliPertama'] == 'POLI ANAK'){
										$tbpoli = 'tbpolianak';
									}elseif($detailriwayat['PoliPertama'] == 'POLI BERSALIN'){
										$tbpoli = 'tbpolibersalin';
									}elseif($detailriwayat['PoliPertama'] == 'POLI GIGI'){
										$tbpoli = 'tbpoligigi';
									}elseif($detailriwayat['PoliPertama'] == 'POLI GIZI'){
										$tbpoli = 'tbpoligizi';
									}elseif($detailriwayat['PoliPertama'] == 'POLI IMUNISASI'){
										$tbpoli = 'tbpoliimunisasi';
									}elseif($detailriwayat['PoliPertama'] == 'POLI KB'){
										$tbpoli = 'tbpolikb';
									}elseif($detailriwayat['PoliPertama'] == 'POLI KIA'){
										$tbpoli = 'tbpolikia';
									}elseif($detailriwayat['PoliPertama'] == 'POLI LANSIA'){
										$tbpoli = 'tbpolilansia';
									}elseif($detailriwayat['PoliPertama'] == 'POLI MTBM'){
										$tbpoli = 'tbpolimtbm';
									}elseif($detailriwayat['PoliPertama'] == 'POLI MTBS'){
										$tbpoli = 'tbpolimtbs';
									}elseif($detailriwayat['PoliPertama'] == 'POLI SKD'){
										$tbpoli = 'tbpoliskd';
									}elseif($detailriwayat['PoliPertama'] == 'POLI TB'){
										$tbpoli = 'tbpolitb';
									}elseif($detailriwayat['PoliPertama'] == 'POLI UGD'){
										$tbpoli = 'tbpolitindakan';
									}
									
									// karna tidak ada diagnosa di polilab
									if($detailriwayat['PoliPertama'] == 'POLI LABORATORIUM' || $detailriwayat['PoliPertama'] == 'POLI IMUNISASI' || $detailriwayat['PoliPertama'] == 'POLI SKD'){
										$dt_diagnosa['Diagnosa'] = '-';
									}else{
										$dt_diagnosa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Diagnosa` FROM `$tbpoli` WHERE `NoPemeriksaan` = '$noregs'"));
									}	
								?>
									<tr>
										<td align="center" class="noregistrasi" style="display:none"><?php echo $riwayat['NoRegistrasi'];?></td>
										<td align="center"><?php echo date('d-m-Y',strtotime($detailriwayat['TanggalRegistrasi']));?></td>
										<td align="center"class="pelayanan" align="left"><?php echo $detailriwayat['PoliPertama'];?></td>
										<td align="center"><?php echo $detailriwayat['UmurTahun']." Th ".$detailriwayat['UmurBulan']." Bl";?></td>
										<td align="center"><?php echo $detailriwayat['Asuransi'];?></td>
										<td align="center"><?php echo $statusplg;?></td>
										<td align="left"><?php echo $dt_diagnosa['Diagnosa'];?></td>
										<?php
											if (in_array("POLI GIGI", $otoritas) || in_array("POLI KB", $otoritas) || in_array("POLI KIA", $otoritas) ||
											in_array("POLI MTBS", $otoritas) || in_array("POLI MTBM", $otoritas) || in_array("POLI LANSIA", $otoritas) ||
											in_array("POLI LABORATORIUM", $otoritas) || in_array("POLI UMUM", $otoritas) || in_array("APOTEK", $otoritas) ||
											in_array("OPERATOR", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){
										?>
										<td align="center" width="5%">
											<a href="#" class="btn btn-sm btn-info btn-white btnmodalriwayat">Lihat</a>
										</td>	
										<?php }?>
									</tr>
								<?php
								}
								?>	
							</tbody>
						</table>
					</div>
				</div>
			</div>	
		</div>	
		<?php
		}
		?>
	</div>	
	
	<div class="alert alert-danger" style="display:none">
		<strong></strong> <i class="ace-icon fa fa-times pull-right"></i>
	</div>	
	
	<ul class="nav nav-tabs noprint" style="margin-top:10px;">
	<?php
	if($pelayanan != 'POLI LABORATORIUM'){
	?>
	  <li class="pemeriksaandasar"><a href="#periksa" data-toggle="tab">Pemeriksaan Dasar</a></li>
	  <li class="askep"><a href="#askep" data-toggle="tab">Asuhan Keperawatan</a></li>
	  <li class="diagnosatab"><a href="#diagnosa" data-toggle="tab">Diagnosa</a></li>
	  <li><a href="#therapy"  data-toggle="tab">Therapy</a></li>
	  <li><a href="#tindakan" data-toggle="tab">Tindakan</a></li>
	  <li><a href="#laboratorium" data-toggle="tab">Laboratorium</a></li>
	  <li><a href="#pemeriksa" data-toggle="tab">Pemeriksa</a></li>
	<?php
	}else{
	?>  
		 <li><a href="#laboratorium" data-toggle="tab">Laboratorium</a></li>
		 <li><a href="#pemeriksa" data-toggle="tab">Pemeriksa</a></li>
	<?php
	}
	?>
	</ul>

	<!--Tab panes-->
	<div class="tab-content noprint">
	<?php
	if($pelayanan != 'POLI LABORATORIUM'){
	?>
		<div class="tab-pane active" id="periksa">
			<div class="box border">
				<div class="box-body">
					<?php
					if($pelayanan == 'poli anak' || $pelayanan == 'POLI ANAK'){
						include"poli_anak.php";
					}else if($pelayanan == 'poli bersalin' || $pelayanan == 'POLI BERSALIN'){
						include"poli_bersalin.php";
					}else if($pelayanan == 'poli gigi' || $pelayanan == 'POLI GIGI'){
						include"poli_gigi.php";
					}else if($pelayanan == 'poli gizi' || $pelayanan == 'POLI GIZI'){
						include"poli_gizi.php";
					}else if($pelayanan == 'poli imunisasi' || $pelayanan == 'POLI IMUNISASI'){
						include"poli_imunisasi.php";
					}else if($pelayanan == 'poli kb' || $pelayanan == 'POLI KB'){
						include"poli_kb.php";
					}else if($pelayanan == 'poli kia' || $pelayanan == 'POLI KIA'){
						include"poli_kia.php";
					}else if($pelayanan == 'poli lansia' || $pelayanan == 'POLI LANSIA'){
						include"poli_lansia.php";
					}else if($pelayanan == 'poli mtbs' || $pelayanan == 'POLI MTBS'){
						include"poli_mtbs.php";
					}else if($pelayanan == 'poli skd' || $pelayanan == 'POLI SKD'){
						include"poli_skd.php";
					}else if($pelayanan == 'poli tb' || $pelayanan == 'POLI TB'){
						include"poli_tb.php";
					}else if($pelayanan == 'poli ugd' || $pelayanan == 'POLI UGD'){
						include"poli_tindakan.php";
					}else if($pelayanan == 'poli umum' || $pelayanan == 'POLI UMUM'){
						include"poli_umum.php";
					}else if($pelayanan == 'rawat inap' || $pelayanan == 'RAWAT INAP'){
						include"poli_rawat_inap.php";
					}
					?>
				</div>
			</div>
		</div>
		<!--askep-->
		<div class="tab-pane" id="askep">
			<div class="box border">
				<div class="box-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<td class="col-sm-2">Data Subyektif</td>
								<td class="col-sm-10"><textarea name="askep_1" class="form-control"></textarea></td>
							</tr>
							<tr>
								<td class="col-sm-2">Data Obyektif</td>
								<td class="col-sm-10"><textarea name="askep_2" class="form-control"></textarea></td>
							</tr>
							<tr>
								<td class="col-sm-2">Diagnosa Keperawatan</td>
								<td class="col-sm-10"><textarea name="askep_3" class="form-control"></textarea></td>
							</tr>
							<tr>
								<td class="col-sm-2">Rencana Keperawatan</td>
								<td class="col-sm-10"><textarea name="askep_3" class="form-control"></textarea></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!--diagnosa-->
		<div class="tab-pane" id="diagnosa">
			<div class="box border">
				<div class="box-body">
					<div class="table-responsive">
						<table>
							<tr>
								<td class="col-sm-2">Nama Penyakit</td>
								<td>:</td>
								<td class="col-sm-6">
									<input type="text" class="form-control diagnosabpjs">
									<input type="hidden" class="form-control kodebpjs">
									<input type="hidden" class="form-control diagnosahiddenbpjs">
									<input type="hidden" class="form-control spesialisbpjs">
								</td>
								<td class="col-sm-2">
									<select name="kasus" class="form-control kasusbpjs">
										<option value="">--Kasus--</option>
										<option value="Baru">Baru</option>
										<option value="Lama">Lama</option>
									</select>
								</td>
								<td class="col-sm-2">
									<select name="kelompok" class="form-control kelompok">
										<option value="">--Kelompok--</option>
										<option value="1">Primary</option>
										<option value="2">Sekunder 1</option>
										<option value="3">Sekunder 2</option>
										<option value="4">Sekunder 3</option>
										<option value="5">Komplikasi</option>
									</select>
								</td>
								<td><a type="button" class="btn btn-sm btn-success tambah-diagnosa-bpjs">Simpan</a></td>
								<td><a class="btn btn-sm btn-primary pull-right modalkamusdiagnosa">Kamus</a></td>
							</tr>
						</table>
					</div>
					<br/>
					<br/>
					<div class="table-responsive"><!--manggil diare/ispa-->
						<table class="table">
							<tr class="head-table-bpjs">
								<th class="col-sm-2">Kode</th>
								<th class="col-sm-5">Penyakit</th>
								<th class="col-sm-2">Kasus</th>
								<th class="col-sm-2">Kelompok</th>
								<th class="col-sm-1">Opsi</th>
							</tr>
							<!-- buat simpan data sementara -->
							<tr class="master-table-bpjs" style="display:none">
								<input type="hidden" class="kode-diagnosa-input">
								<input type="hidden" class="nama-diagnosa-input">
								<input type="hidden" class="kasus-diagnosa-input">
								<input type="hidden" class="kelompok-diagnosa-input">
								<input type="hidden" class="spesialis-diagnosa-input">
								<td class="kode-html"></td>
								<td class="diagnosa-html"></td>
								<td class="kasus-html"></td>
								<td class="kelompok-html"></td>
								<td>
									<a class="btn btn-xs btn-danger hapus-diagnosa">Hapus</a>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="form_tambahan">
				
				</div>
				<?php
				// include"form_campak.php";
				// include"form_ispa.php";
				// include"form_diare.php";
				// include"form_ptm.php";
				?>
			</div>
		</div>

		<!--therapy-->
		<div class="tab-pane" id="therapy">
			<div class="box border">
				<div class="box-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<td class="col-sm-2">Status</td>
								<td class="col-sm-10">
									<div class="radio">
										<label>
											<input type="radio" name="status_racikan" class="status_racikan_bpjs" value="false" checked>
											Non Racikan
										</label>
									</div>	
									
									<div class="radio">
										<label>
											<input type="radio" name="status_racikan" class="status_racikan_bpjs" value="true">
											Racikan
										</label>
									</div>					
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Nama Obat</td>
								<td class="col-sm-10">
									<input type="text" class="form-control therapybpjs">
									<input type="hidden" class="form-control kodeobatbpjs">
									<input type="hidden" class="form-control kodeobatlokal">
									<input type="hidden" class="form-control namaobatbpjs">
									<input type="hidden" class="form-control sediaobatbpjs">
									<input type="hidden" name="catatanterapibpjs" class="form-control catatan-therapy-bpjs" readonly></textarea>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Jumlah</td>
								<td class="col-sm-10">
									<input  type="number" name="jumlahbpjs" class="form-control jumlahbpjs">
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Dosis / Signa</td>
								<td class="col-sm-10">
									<div class="row">
										<div class="col-sm-2">
											<input type="text" name="dosisbpjs1" class="form-control dosisbpjs1">						
										</div>
										<div class="col-sm-2">
											<input type="text" name="dosisbpjs2" class="form-control dosisbpjs2">									
										</div>									
									</div>									
								</td>
							</tr>
							
							<tr>
								<td class="col-sm-2">Anjuran</td>
								<td class="col-sm-10">
									<select class="form-control anjuranterapi">
										<option value="-">--Pilih--</option>
										<?php
										$dtanjuranary = mysqli_query($koneksi,"SELECT Anjuran from tbapotikanjuran");
										while($dtanjuran = mysqli_fetch_assoc($dtanjuranary)){
											echo "<option value='$dtanjuran[Anjuran]'>$dtanjuran[Anjuran]</option>";
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2"></td>
								<td class="col-sm-4">
									<button type="button" class="btn btn-success tambah-therapy-bpjs">Tambah</button>
								</td>
							</tr>
						</table>
					</div>
					<br/>
					<br/>
					<div class="table-responsive">
						<table class="table">
							<tr class="head-table-therapy-bpjs">
								<th class="col-sm-1">Kode</th>
								<th class="col-sm-1">Status</th>
								<th class="col-sm-3">Nama Obat</th>
								<th class="col-sm-1">Jml</th>
								<th class="col-sm-1">Dosis</th>
								<th class="col-sm-2">Anjuran</th>
								<th class="col-sm-1">Opsi</th>
							</tr>
							<!-- buat simpan data sementara -->
							<tr class="master-table-therapy-bpjs" style="display:none">
								<input type="hidden" class="kodeobatbpjs-input">
								<input type="hidden" class="kodeobatlokal-input">
								<input type="hidden" class="status_racikan_bpjs-input">
								<input type="hidden" class="namaobatbpjs-input">
								<input type="hidden" class="namaobatnonbpjs-input">
								<input type="hidden" class="jumlahbpjs-input">
								<input type="hidden" class="dosisbpjs1-input">
								<input type="hidden" class="dosisbpjs2-input">
								<input type="hidden" class="anjuranterapi-input">
								<td class="kodeobatbpjs-html"></td>
								<td class="status_racikan_bpjs-html"></td>
								<td class="namaobatbpjs-html"></td>
								<td class="jumlahbpjs-html"></td>
								<td class="dosisbpjs-html"></td>
								<td class="anjuranterapi-html"></td>
								<td>
									<a class="btn btn-xs btn-danger hapus-therapy-bpjs">Hapus</a>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<!--tindakan BPJS-->
		<div class="tab-pane" id="tindakan">
			<div class="box border">
				<div class="box-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<td class="col-sm-2">Tindakan</td>
								<td class="col-sm-10">
									<input type="text" class="form-control tindakanbpjs">
									<input type="hidden" class="form-control kodetindakanbpjs">
									<input type="hidden" class="form-control namatindakanbpjs">
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Biaya</td>
								<td class="col-sm-10">
									<input  type="text" name="biayabpjs" class="form-control tariftindakanbpjs">
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Keterangan</td>
								<td class="col-sm-10">
									<input  type="text" name="keteranganbpjs" class="form-control keteranganbpjs">
								</td>
							</tr>
							<tr>
								<td class="col-sm-2"></td>
								<td class="col-sm-4">
									<a type="button" class="btn btn-success tambah-tindakan-bpjs">Tambah</a>
								</td>
							</tr>
						</table>
					</div>
					<br/>
					<div class="table-responsive">
						<table class="table-judul-laporan">
							<thead>
								<tr class="head-table-tindakan-bpjs">
									<th class="col-sm-1">Kode</th>
									<th class="col-sm-5">Tindakan</th>
									<th class="col-sm-2">Biaya</th>
									<th class="col-sm-1">Keterangan</th>
									<th class="col-sm-1">Opsi</th>
								</tr>
							</thead>
							<tbody>							
								<!-- buat simpan data sementara -->
								<tr class="master-table-tindakan-bpjs" style="display:none">
									<input type="hidden" class="kodetindakanbpjs-input">
									<input type="hidden" class="namatindakanbpjs-input">
									<input type="hidden" class="tariftindakanbpjs-input">
									<input type="hidden" class="keteranganbpjs-input">
									<td class="kodetindakanbpjs-html"></td>
									<td class="namatindakanbpjs-html"></td>
									<td class="tariftindakanbpjs-html"></td>
									<td class="keteranganbpjs-html"></td>
									<td>
										<a class="btn btn-xs btn-danger hapus-tindakan-bpjs">Hapus</a>
									</td>
								</tr>
							</tbody>
						</table><br/>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="alert alert-block alert-success fade in">
								<p><b>Perhatian :</b><br/>
								Pilih jenis tindakan sesuai jaminan. Jika Bpjs maka jaminannya Bpjs dan jika Umum maka jaminannya berdasarkan Perda.</p>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--Laboratorium-->
		<div class="tab-pane" id="laboratorium">
		<div class="box border">
			<div class="box-body">
				<!--<input type="text" name="tindakanlab" class="tindakanlabcls">--><!--ini buat apa?-->
				<table class="table-judul-laporan">
					<thead>
						<tr>
							<th width="5%">No.</th>
							<th width="90%">Kelompok Tindakan</th>
							<th width="5%">Aksi</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$no = 0;
						$str_lab = mysqli_query($koneksi,"SELECT DISTINCT(KelompokTindakan) as keltindakan from tbtindakan where KelompokTindakan LIKE '%Laboratorium%' AND `Kota` = '$kota' order by KelompokTindakan ASC");
						while($dt_lab = mysqli_fetch_assoc($str_lab)){
						?>
						<tr>
							<td align="center">
								<?php echo $no = $no + 1;?>
								<input type="hidden" name="tindakanlab[]" class="tindakanlabcls_<?php echo $no;?>">
							</td>
							<td align="left" class="keltind"><?php echo $dt_lab['keltindakan'];?></td>
							<td align="center">
								<button type="button" class="btn btn-xs btn-info getmodallab">Pilih</button>
							</td>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>				
			</div>
		</div>
		</div>
		<!--Pemeriksa-->
		<div class="tab-pane" id="pemeriksa">
			<div class="box border">
				<div class="box-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<td class="col-sm-2">Kesadaran</td>
								<td class="col-sm-10">
									<select name="kesadaran" class="form-control" required>
										<option value="">--Pilih--</option>
											<option value="01">Compos mentis</option>
											<option value="02">Somnolence</option>
											<option value="03">Sopor</option>
											<option value="04">Coma</option>
									</select>

								</td>
							</tr>
							<?php
							if($jeniskunjungan == 'Rawat Jalan'){
								$stskunjungan = 'false';
							}else{
								$stskunjungan = 'true';
							}
							//$data_statuspulang = get_data_statuspulang($stskunjungan);
							//$dstatus = json_decode($data_statuspulang,True);
							?>
							<tr>
								<td>Status Pulang</td>
								<td>
									<select name="statuspulang" class="form-control statuspulang" required>
										<option value="">--Pilih--</option>
										<option value="3">Berobat Jalan</option>
										<option value="4">Rujuk Lanjut</option>
										<option value="5">Rujuk Internal</option>
									</select>
								</td>
							</tr>	
							
							<tr>
								<td>Tenaga Medis I</td>
								<td>
									<select name="tenagamedis1" class="form-control tenagamedis1" >
										<option value="">--Pilih--</option>
										<?php 
											$kdpuskesmas = $_SESSION['kodepuskesmas'];
											$qrypegawai = mysqli_query($koneksi,"SELECT * FROM tbpegawaibpjs WHERE kdpuskesmas = '$kdpuskesmas' order by nmDokter ASC");
											while($pegawai = mysqli_fetch_assoc($qrypegawai)){
												echo "<option value='".$pegawai['kdDokter']."'>".$pegawai['nmDokter']."</option>";
											}
										?>
									</select>
									<input type="hidden" name="tenagamedisbpjs" class="namadokterbpjs">
									<span class="labeltenagamedis1" style="color:red;"></span>
								</td>
							</tr>
							<tr>
								<td>Tenaga Medis II</td>
								<td>
									<select name="tenagamedis2" class="form-control tenagamedis2">
										<option value="">--Pilih--</option>
										<?php 
											$kdpuskesmas = $_SESSION['kodepuskesmas'];
											$qrypegawai = mysqli_query($koneksi,"SELECT * FROM tbpegawai WHERE KodePuskesmas = '$kdpuskesmas' order by NamaPegawai ASC");
											while($pegawai = mysqli_fetch_assoc($qrypegawai)){
												echo "<option value='".$pegawai['NamaPegawai']."'>".$pegawai['NamaPegawai']."</option>";
											}
										?>
									</select>
								
									<span class="labeltenagamedis2" style="color:red;"></span>
								</td>
							</tr>
							<tr>
								<td>Tenaga Entry III</td>
								<td>
									<select name="tenagamedis3" class="form-control tenagamedis3">
										<option value="">--Pilih--</option>
										<?php 
											$qrypegawai2 = mysqli_query($koneksi,"SELECT * FROM tbpegawai WHERE KodePuskesmas = '$kdpuskesmas' order by NamaPegawai ASC");
											while($pegawai2 = mysqli_fetch_assoc($qrypegawai2)){
												echo "<option value='".$pegawai2['NamaPegawai']."'>".$pegawai2['NamaPegawai']."</option>";
											}
										?>
									</select>
									<span class="labeltenagamedis3" style="color:red;"></span>
								</td>
							</tr>
							<tr>
								<td>Farmasi</td>
								<td>
									<select name="tenagafarmasi" class="form-control tenagafarmasi">
										<option value="">--Pilih--</option>
										<?php 
											$qrypegawai2 = mysqli_query($koneksi,"SELECT * FROM tbpegawai WHERE KodePuskesmas = '$kdpuskesmas' order by NamaPegawai ASC");
											while($pegawai2 = mysqli_fetch_assoc($qrypegawai2)){
												echo "<option value='".$pegawai2['NamaPegawai']."'>".$pegawai2['NamaPegawai']."</option>";
											}
										?>
									</select>
									<span class="labeltenagafarmasi" style="color:red;"></span>
								</td>
							</tr>
						</table>
						<table class="table statuspulangform"></table>
						<?php
							if (in_array("POLI GIGI", $otoritas) || in_array("POLI KB", $otoritas) || in_array("POLI KIA", $otoritas) ||
							in_array("POLI MTBS", $otoritas) || in_array("POLI MTBM", $otoritas) || in_array("POLI LANSIA", $otoritas) ||
							in_array("POLI LABORATORIUM", $otoritas) || in_array("POLI UMUM", $otoritas) || in_array("APOTEK", $otoritas) ||
							in_array("OPERATOR", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){
						?>
						<button type="submit" class="btn btn-lg btn-success pull-right btnsimpanperiksa">Simpan</button>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	<?php
	}else{
	?>  
		<!--Poli Laboratorium-->
		<div class="tab-pane active" id="laboratorium">
		<div class="box border">
			<div class="box-body">
				<table class="table">
					<tr>
						<th>No</th>
						<th class="col-sm-1">Kode</th>
						<th class="col-sm-3">Jenis Tindakan</th>
						<th class="col-sm-4">Kelompok Tindakan</th>
						<th>Hasil</th>
					</tr>
					<?php
					$no = 0;
					$str_tindakan_detail = mysqli_query($koneksi,"SELECT * FROM tbtindakanpasiendetail a JOIN tbtindakan b on a.KodeTindakan = b.KodeTindakan WHERE a.NoRegistrasi = '$_GET[no]'");
					while($dt_tindd = mysqli_fetch_assoc($str_tindakan_detail)){
					?>
					<tr>
						<td><?php echo $no = $no + 1;?></td>
						<td><?php echo $dt_tindd['KodeTindakan'];?></td>
						<td><?php echo $dt_tindd['Tindakan'];?></td>
						<td><?php echo $dt_tindd['KelompokTindakan'];?></td>
						<td>
							<input type="text" name="hasilkdtindakan[<?php echo $dt_tindd['KodeTindakan'];?>]" class="form-control">
						</td>
					</tr>
					<?php
						$kdtind[] = $dt_tindd['KodeTindakan'];
					}
					?>
					
				</table>
				<input type="hidden" value="<?php echo implode(',',$kdtind);?>" name="kdtindakan"/>			
			</div>
		</div>
		</div>	
		
		<?php
			$tbpasienrj = 'tbpasienrj_'.substr($noregistrasi,14,2);
			$str_kesadaran = "SELECT * FROM `$tbpasienrj` WHERE `NoRegistrasi` = '$noregistrasi'";
			$str_kesadaran_dtl = mysqli_query($koneksi, $str_kesadaran);
			$dt_kesadaran = mysqli_fetch_assoc($str_kesadaran_dtl);
		?>
		<!--Pemeriksa-->
		<div class="tab-pane" id="pemeriksa">
			<div class="box border">
				<div class="box-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<td class="col-sm-2">Kesadaran</td>
								<td>:</td>
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
								<td>:</td>
								<td>
									<select name="statuspulang" class="form-control statuspulang" required>
										<option value="">--Pilih--</option>
										<option value="3" <?php if($dt_kesadaran['StatusPulang'] == '3'){echo "SELECTED";}?>>Berobat Jalan</option>
										<option value="4" <?php if($dt_kesadaran['StatusPulang'] == '4'){echo "SELECTED";}?>>Rujuk Lanjut</option>
										<option value="5" <?php if($dt_kesadaran['StatusPulang'] == '5'){echo "SELECTED";}?>>Rujuk Internal</option>
									</select>
								</td>
							</tr>	
							<tr>
								<td>Tenaga Lab.</td>
								<td>:</td>
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
						<?php
							if (in_array("POLI GIGI", $otoritas) || in_array("POLI KB", $otoritas) || in_array("POLI KIA", $otoritas) ||
							in_array("POLI MTBS", $otoritas) || in_array("POLI MTBM", $otoritas) || in_array("POLI LANSIA", $otoritas) ||
							in_array("POLI LABORATORIUM", $otoritas) || in_array("POLI UMUM", $otoritas) || in_array("APOTEK", $otoritas) ||
							in_array("OPERATOR", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){
						?>
						<button type="submit" class="btn btn-lg btn-success pull-right btnsimpanperiksa">Simpan</button>	
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
	?>	
	</div>
	</form>
</div>	

<div class="modal fade" id="myModaldiagnosa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Pencarian Nama Diagnosa</h4>
			</div>
			  
			<div class="modal-body">
				<table>
					<tr>
						<td class="col-sm-2">Nama Penyakit</td>
						<td>:</td>
						<td class="col-sm-10">
							<input type="text" class="form-control diagnosa">
						</td>
					
					</tr>
		
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>	
<script src="assets/js/jquery.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
	//Tindakan BPJS
		$('.tindakanbpjs').autocomplete({
			serviceUrl: 'get_tindakan.php/<?php echo $_SESSION['kota'];?>/<?php echo $data['Asuransi'];?>',
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
				$(this).parent().find(".kodetindakanbpjs").val(suggestion.kodetindakanbpjs);
				$(this).parent().find(".namatindakanbpjs").val(suggestion.namatindakanbpjs);
				$(this).parent().parent().parent().find(".tariftindakanbpjs").val(suggestion.tariftindakanbpjs);
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
			var noregistrasi = $(this).parent().parent().find(".noregistrasi").html()
			var pelayanan = $(this).parent().parent().find(".pelayanan").html()
			// alert(noregistrasi);
			$.post( "get_modal_riwayat.php", { no: noregistrasi, pel: pelayanan})
			  .done(function( data ) {
				 $( ".hasilmodal" ).html( data );
				 $('#ModalRiwayat').modal('show');
			});
		});
		$('.btnmodalpasien').click(function(){
			var nocm = $(this).parent().parent().find(".nocm").html()
			var noregistrasi = $(this).parent().parent().find(".noregistrasi").html()
			var pelayanan = $(this).parent().parent().find(".pelayanan").html()
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
		$(".getmodallab").click(function(){
			var nolab = $(this).parent().parent().index();
			var kel = $(this).parent().parent().find(".keltind").text();
			$.post( "get_modal_laboratorium.php", { kel: kel, nolab:nolab})
			  .done(function( data ) {
				 $( ".hasilmodal" ).html( data );
				 $('#modallab1').modal('show');
			});
		});
		
		$(".btnsimpanperiksa").click(function(){
			var anamnesa = $(".anamnesa").val();
			if(anamnesa == ''){
				$(".alert-danger").removeAttr('style');
				$(".alert-danger strong").html('Silahkan isi anamnesa terlebih dahulu.');
				$(".pemeriksaandasar a").click();
				return false;
			}
			
			var sistole = $(".sistole").val();
			if(sistole == ''){
				$(".alert-danger").removeAttr('style');
				$(".alert-danger strong").html('Sistole belum diisi, jangan isi angka 0 tidak akan bridging ke PCare..');
				$(".pemeriksaandasar a").click();
				return false;
			}
			
			var diastole = $(".diastole").val();
			if(diastole == ''){
				$(".alert-danger").removeAttr('style');
				$(".alert-danger strong").html('Diastole belum diisi, jangan isi angka 0 tidak akan bridging ke PCare..');
				$(".pemeriksaandasar a").click();
				return false;
			}
			
			var suhutubuh = $(".suhutubuh").val();
			if(suhutubuh == ''){
				$(".alert-danger").removeAttr('style');
				$(".alert-danger strong").html('Suhu Tubuh belum diisi, jangan isi angka 0 tidak akan bridging ke PCare..');
				$(".pemeriksaandasar a").click();
				return false;
			}
			
			var tinggibadan = $(".tinggibadan").val();
			if(tinggibadan == ''){
				$(".alert-danger").removeAttr('style');
				$(".alert-danger strong").html('Tinggi Badan belum diisi, jangan isi angka 0 tidak akan bridging ke PCare..');
				$(".pemeriksaandasar a").click();
				return false;
			}
			
			var beratbadan = $(".beratbadan").val();
			if(beratbadan == ''){
				$(".alert-danger").removeAttr('style');
				$(".alert-danger strong").html('Berat Badan belum diisi, jangan isi angka 0 tidak akan bridging ke PCare..');
				$(".pemeriksaandasar a").click();
				return false;
			}
			
			var heartrate = $(".heartrate").val();
			if(heartrate == ''){
				$(".alert-danger").removeAttr('style');
				$(".alert-danger strong").html('Heartrate belum diisi, jangan isi angka 0 tidak akan bridging ke PCare..');
				$(".pemeriksaandasar a").click();
				return false;
			}
			
			var resprate = $(".resprate").val();
			if(resprate == ''){
				$(".alert-danger").removeAttr('style');
				$(".alert-danger strong").html('Resprate belum diisi, jangan isi angka 0 tidak akan bridging ke PCare..');
				$(".pemeriksaandasar a").click();
				return false;
			}
			
			var kunjungangigi = $(".kunjungangigi").val();
			if(kunjungangigi == ''){
				$(".alert-danger").removeAttr('style');
				$(".alert-danger strong").html('Silahkan isi kunjungan gigi terlebih dahulu.');
				$(".pemeriksaandasar a").click();
				return false;
			}
			
			
			var frekuensinafas = $(".frekuensinafas").val();
			if(frekuensinafas == ''){
				$(".alert-danger").removeAttr('style');
				$(".alert-danger strong").html('Silahkan isi Frekuensi Nafas pada form ISPA...');
				$(".diagnosatab a").click();
				return false;
			}
			
			// var kodediagnosainput = $(".kode-diagnosa-input").val();
			// if(kodediagnosainput == ''){
				// alert('Silahkan isi diagnosa terlebih dahulu.');
				// $(".diagnosatab a").click();
				// return false;
			// }
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
	});
</script>



	
