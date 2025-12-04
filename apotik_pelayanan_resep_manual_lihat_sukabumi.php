<?php
	session_start();
	$noresep = $_GET['norsp'];
	$noindex = $_GET['noid'];
	$statusloket = $_GET['statusloket'];
	$tgl1 = $_GET['tgl1'];
	$tgl2 = $_GET['tgl2'];
	$key = $_GET['key'];
	$statusdilayani = $_GET['statusdilayani'];
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
	$tbapotikstok = "tbapotikstok_".str_replace(' ', '', $namapuskesmas);	
		
	// tbresep
	// no index jangan dihapus, untuk mencegah data dobel / data valid
	$data_resep = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbresep` WHERE `NoResep`='$noresep' AND `NoIndex` = '$noindex'"));
	$tbwaktupelayanan = "tbwaktupelayanan_".$kodepuskesmas;
	
	// tbkk
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoIndex`,`Alamat`,`RT`,`RW`,`Kelurahan`,`Telepon` FROM `$tbkk` WHERE `NoIndex`='$data_resep[NoIndex]'"));
								
	// tbpasien
	$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
	$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `NoCM` = '$data_resep[NoCM]'"));
	
	// update waktu farmasi awal
	mysqli_query($koneksi,"UPDATE `$tbwaktupelayanan` SET `FarmasiAwal`=NOW() WHERE `NoRegistrasi` = '$noresep' AND FarmasiAwal = '0000-00-00 00:00:00'");
	
	// tbdiagnosa
	$tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
	$qrdata_kd_diagnosa = mysqli_query($koneksi, "SELECT * FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noresep'");//GROUP BY `KodeDiagnosa`
	while($data_diagnosapsn = mysqli_fetch_array($qrdata_kd_diagnosa)){
		$data_diagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
		$array_diagnosa[$no][] = $data_diagnosa['Diagnosa'];
	}
	
	if ($array_diagnosa[$no] != ''){
		$data_dgs = implode(", ", $array_diagnosa[$no]);
	}else{
		$data_dgs ="";
	}
?>
<style type="text/css">
	.formedit{
		width: 50px !important;
	}
</style>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=apotik_pelayanan_resep&statusloket=<?php echo $statusloket;?>&tgl1=<?php echo $tgl1;?>&tgl2=<?php echo $tgl2;?>&key=<?php echo $key;?>&statusdilayani=<?php echo $statusdilayani;?>" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>NOMOR RESEP, #<?php echo substr($data_resep['NoResep'], -3);?></b></h3>
			<div class="formbg" style="padding: 30px 50px 50px 50px;">
				<table width="100%">
					<tr>	
						<td colspan="3">
							<b style="font-size:22px;"><?php echo $data_resep['NamaPasien']." (".$data_resep['UmurTahun']."Th ".$data_resep['UmurBulan']." Bl)";?></b>
							<span class="badge badge-success" style='font-size:14px; font-style: italic; padding: 6px;'><?php echo substr($dtkk['NoIndex'],-10);?></span><br/>
						</td>
					</tr>
					<tr>	
						<td width="11%">Tgl.Resep</td>
						<td width="1%">:</td>
						<td width="88%"><?php echo date('d-m-Y G:i:s', strtotime($data_resep['TanggalResep']));?></td>
					</tr>
					<tr>	
						<td>Pelayanan</td>
						<td>:</td>
						<td><?php echo str_replace('POLI','', $data_resep['Pelayanan']);?></td>
					</tr>
					<tr>	
						<td>Cara Bayar</td>
						<td>:</td>
						<td><?php echo $data_resep['StatusBayar'];?></td>
					</tr>
					<tr>	
						<td>Alamat</td>
						<td>:</td>
						<td>
							<?php echo strtoupper($dtkk['Alamat'].", RT.".$dtkk['RT']." RW.".$dtkk['RW']." Kel.".$dtkk['Kelurahan']);?>
						</td>
					</tr>
					<tr>	
						<td>Telp.</td>
						<td>:</td>
						<td>
							<?php
								if($dtkk['Telepon'] != ''){
									echo $dtkk['Telepon'];
								}else{
									if($datapasien['Telpon'] != ''){
										echo $datapasien['Telpon'];
									}else{
										echo "<span style='color:red;font-weight:bold'>Belum Diinputkan</span>";
									}	
								}	
							?>
						</td>
					</tr>
					<tr>	
						<td>Pemeriksa</td>
						<td>:</td>
						<td>
							<?php 
								// tbpasienperpegawai
								$tbpasienperpegawai = "tbpasienperpegawai_".$kodepuskesmas;
								$dtpegawai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasienperpegawai` WHERE `NoRegistrasi`='$noresep'"));
								if($dtpegawai['NamaPegawai1'] != ""){ 
									$pemeriksa = $dtpegawai['NamaPegawai1']; 
								}else{ 
									$pemeriksa = $dtpegawai['NamaPegawai2'];
								}
								echo $pemeriksa;
							?>
						</td>
					</tr>
					<tr>	
						<td>Diagnosa</td>
						<td>:</td>
						<td>
							<?php echo strtoupper($data_dgs);?>
						</td>
					</tr>
				</table><hr/>
				
				<form class="form-horizontal" action="index.php?page=apotik_pelayanan_resep_manual_lihat_tarakan_proses" method="post" role="form">
					<div class = "row">
						<div class = "col-sm-12">
							<table class="table-judul" width="100%">
								<thead>
									<tr>
										<th width="10%">RACIKAN</th>
										<th width="27%">NAMA OBAT</th>
										<th width="10%">SIGNA</th>
										<th width="10%">JML</th>
										<th width="10%">ANJURAN</th>
										<th width="5%"><i class="fa fa-plus btnadd"></i></th>
									</tr>
								</thead>
								<tbody>
									<tr class="trclones" style="display: none">
										<td colspan="6">
											<table class="table-judul" style="background: #f5f5f5;margin: 0px">
												<tr>
													<td>
														<select class="form-control sts_racikan" name="status_racikan[]">
															<option value="false">Tidak</option>
															<option value="true">Ya</option>										
														</select>
													</td>
													<td width="40%">
														<input type="text" class="form-control therapybpjs">
														<input type="hidden" name="kodebarang[]" class="form-control kodeobatlokal">
														<input type="hidden" name="nobatch[]" class="form-control nobatch">
														<input type="hidden" class="form-control kodeobatbpjs">
														<input type="hidden" class="form-control namaobatbpjs">
													</td>
													<td width="9%" class="hides">
														<input type="text" name="signa1[]" class="form-control signa1">						
													</td>
													<td width="9%" class="hides">
														<input type="text" name="signa2[]" class="form-control signa2">									
													</td>
													<td width="10%">
														<input type="text" name="jumlah[]" class="form-control jumlah" maxlength="4">
													</td>
													<td class="hides">
														<select name="anjuran[]" class="form-control anjuranterapi">
															<option value="-">--Pilih--</option>
															<option value="Lainnya">Lainnya</option>
															<?php
															$dtanjuranary = mysqli_query($koneksi,"SELECT Anjuran FROM `tbapotikanjuran`");
															while($dtanjuran = mysqli_fetch_assoc($dtanjuranary)){
																echo "<option value='$dtanjuran[Anjuran]'>$dtanjuran[Anjuran]</option>";
															}
															?>
														</select>
													</td>
													<td class="ket_racikantr" style="display: none;"><input type="text" class="form-control ket_racikan" name="ket_racikan" placeholder="Keterangan racikan, misal: m.f.pulv.no x"/></td>
													<td width="5%" align="center">
														<i class="fa fa-minus btnremove"></i>
													</td>
												</tr>
												<tr style="display: none" class="formanjuranlainnya">
													<td colspan="5"><input type="text" class="form-control anjuranterapilain" name="anjuranterapilain[]"></td>
												</tr>
											</table>
										</td>								
									</tr>
								</tbody>	
							</table></br>
							<input type="hidden" name="noindex" class="form-control" value="<?php echo $data_resep['NoIndex'];?>">	
							<input type="hidden" name="noresep" class="form-control" value="<?php echo $data_resep['NoResep'];?>">	
							<input type="hidden" name="statusloket" class="form-control" value="<?php echo $statusloket;?>">	
							<input type="hidden" name="poli" class="form-control" value="<?php echo $data_resep['Pelayanan'];?>">	
							<input type="hidden" name="tanggalresep" class="form-control" value="<?php echo $data_resep['TanggalResep'];?>">	
						</div>									
					</div>
					<div class="mt-4">
						<button type="submit" class="btn btn-round btn-success btnsimpan">SIMPAN</button>
					</div>
				</form><hr/>
				
				<div class = "row">		
					<div class = "col-sm-12">		
						<table class="table-judul">
							<thead>
								<tr>
									<th width="4%">NO.</th>
									<th width="8%">KODE</th>
									<th width="8%">RACIKAN</th>
									<th width="20%">NAMA OBAT</th>
									<th width="8%">SIGNA</th>
									<th width="8%">JML</th>
									<th width="12%">ANJURAN</th>
									<th width="10%">PELAYANAN</th>
									<th width="6%">#</th>
								</tr>
							</thead>		
							<tbody>
								<?php
								$no = 0;	
								$query = mysqli_query($koneksi, "SELECT * FROM `$tbresepdetail` WHERE `NoResep`='$noresep' AND DATE(TanggalResep) IS NOT NULL"); //  GROUP BY NoResep, KodeBarang
								while($data = mysqli_fetch_assoc($query)){
									$no = $no + 1;
									$kodebarang = $data['KodeBarang'];
									$nobatch = $data['NoBatch'];
									
									// ambil dari tbapotikstok, karena saat penulisan resep datanya dari tabel tersebut
									$dtobat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbapotikstok` WHERE `KodeBarang`='$kodebarang'"));
								?>							
									<tr>
										<td align="center"><?php echo $no;?></td>
										<td align="center"><?php echo $data['KodeBarang'];?></td>
										<td align="center">
											<?php 
											if($data['racikan'] == 'true'){
												echo "Ya";
											}else{
												echo "Tidak";
											}
											?>
										</td>
										<td align="left">
											<?php echo $dtobat['NamaBarang'];?><br/>
											<?php 
												if($data['KeteranganRacikan'] != ''){
													echo "<span style='color: red;'>Ket Racikan : ".$data['KeteranganRacikan']."</span>";
												}
											?>
										</td>
										<td align="center" data-batch="<?php echo $data['NoBatch'];?>" data-kodebarang="<?php echo $data['KodeBarang'];?>" data-idr="<?php echo $data['IdResepDetail'];?>" class="editsigna">
										<?php
											if($data['racikan'] == 'true'){
												echo "";
											}else{
												echo $data['signa1']." x ".$data['signa2'];
											}
										?>
										</td>
										<td align="right" data-batch="<?php echo $data['NoBatch'];?>" data-kodebarang="<?php echo $data['KodeBarang'];?>" data-idr="<?php echo $data['IdResepDetail'];?>" class="editjmlobat"><?php echo $data['jumlahobat'];?></td>
										<td align="center" class="anjuaranclstd" data-idr="<?php echo $data['IdResepDetail'];?>">
											<span><?php echo $data['AnjuranResep'];?></span>
											<select class="form-control anjuranterapi_edit" style="display: none;">
												<option value="">Pilih</option>
												<option value="Lainnya">Lainnya</option>
												<?php
												$dtanjuranary2 = mysqli_query($koneksi,"SELECT Anjuran FROM `tbapotikanjuran`");
												while($dtanjuran2 = mysqli_fetch_assoc($dtanjuranary2)){
													if($data['AnjuranResep'] == $dtanjuran2['Anjuran']){
														echo "<option value='$dtanjuran2[Anjuran]' SELECTED>$dtanjuran2[Anjuran]</option>";
													}else{
														echo "<option value='$dtanjuran2[Anjuran]'>$dtanjuran2[Anjuran]</option>";
													}
												}
												?>
											</select>
											<input type="text" class="form-control anjuranterapilain_edit" style="display: none;">
										</td>
										<td align="center"><?php echo str_replace('POLI ','',$data['Pelayanan']);?></td>
										<td align="center">
											<a href="?page=apotik_pelayanan_resep_manual_hapus_tarakan&id=<?php echo $data['IdResepDetail'];?>&nr=<?php echo $noresep;?>&ni=<?php echo $noindex;?>&kb=<?php echo $kodebarang;?>&bt=<?php echo $nobatch;?>&jml=<?php echo $data['jumlahobat'];?>&statusloket=<?php echo $statusloket;?>" class="btn btn-round btn-danger">HAPUS</a>
										</td>		
									</tr>
								<?php
								}
								?>	
							</tbody>
						</table>
					</div>	
				</div><br/>

				<table class="table-judul" width="100%">
					<tr>
						<td class="col-sm-2">Informasi Penggunaan Obat*</td>
						<td class="col-sm-10">
							<?php
								$arrpio = explode(",",$data_resep['Pio']);
							?>
							<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Nama Obat" <?php if(in_array("Nama Obat", $arrpio) || $data_resep['Pio'] == '' || $data_resep['Pio'] == '-'){echo "CHECKED";}?>> Nama Obat</label><br/>
							<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Sediaan" <?php if(in_array("Sediaan", $arrpio) || $data_resep['Pio'] == '' || $data_resep['Pio'] == '-'){echo "CHECKED";}?>> Sediaan</label><br/>
							<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Dosis" <?php if(in_array("Dosis", $arrpio) || $data_resep['Pio'] == '' || $data_resep['Pio'] == '-'){echo "CHECKED";}?>> Dosis</label><br/>
							<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Cara Pakai" <?php if(in_array("Cara Pakai", $arrpio) || $data_resep['Pio'] == '' || $data_resep['Pio'] == '-'){echo "CHECKED";}?>> Cara Pakai</label><br/>
							<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Penyimpanan" <?php if(in_array("Penyimpanan", $arrpio) || $data_resep['Pio'] == '' || $data_resep['Pio'] == '-'){echo "CHECKED";}?>> Penyimpanan</label><br/>
							<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Indikasi" <?php if(in_array("Indikasi", $arrpio) || $data_resep['Pio'] == '' || $data_resep['Pio'] == '-'){echo "CHECKED";}?>> Indikasi</label><br/>
							<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Kontraindikasi" <?php if(in_array("Kontraindikasi", $arrpio) || $data_resep['Pio'] == '' || $data_resep['Pio'] == '-'){echo "CHECKED";}?>> Kontraindikasi</label><br/>
							<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Stabilitas" <?php if(in_array("Stabilitas", $arrpio) || $data_resep['Pio'] == '' || $data_resep['Pio'] == '-'){echo "CHECKED";}?>> Stabilitas</label><br/>
							<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Efek Samping" <?php if(in_array("Efek Samping", $arrpio) || $data_resep['Pio'] == '' || $data_resep['Pio'] == '-'){echo "CHECKED";}?>> Efek Samping</label><br/>
							<label><input type="checkbox" name="jenis_pio[]" class="jenispio" value="Interaksi" <?php if(in_array("Interaksi", $arrpio) || $data_resep['Pio'] == '' || $data_resep['Pio'] == '-'){echo "CHECKED";}?>> Interaksi</label><br/>
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">Telaah Resep*</td>
						<td class="col-sm-10">
							<?php
								$arrtelaah = explode(",",$data_resep['Telaah']);
							?>
							<label><input type="checkbox" name="jenis_telaah[]" class="jenistelaah" value="Kejelasan Penulisan Resep" <?php if(in_array("Kejelasan Penulisan Resep", $arrtelaah) || $data_resep['Telaah'] == '' || $data_resep['Telaah'] == '-'){echo "CHECKED";}?>> Kejelasan Penulisan Resep</label><br/>
							<label><input type="checkbox" name="jenis_telaah[]" class="jenistelaah" value="Tepat Obat" <?php if(in_array("Tepat Obat", $arrtelaah) || $data_resep['Telaah'] == '' || $data_resep['Telaah'] == '-'){echo "CHECKED";}?>> Tepat Obat</label><br/>
							<label><input type="checkbox" name="jenis_telaah[]" class="jenistelaah" value="Tepat Dosis" <?php if(in_array("Tepat Dosis", $arrtelaah) || $data_resep['Telaah'] == '' || $data_resep['Telaah'] == '-'){echo "CHECKED";}?>> Tepat Dosis</label><br/>
							<label><input type="checkbox" name="jenis_telaah[]" class="jenistelaah" value="Tepat Rute" <?php if(in_array("Tepat Rute", $arrtelaah) || $data_resep['Telaah'] == '' || $data_resep['Telaah'] == '-'){echo "CHECKED";}?>> Tepat Rute</label><br/>
							<label><input type="checkbox" name="jenis_telaah[]" class="jenistelaah" value="Tepat Waktu" <?php if(in_array("Tepat Waktu", $arrtelaah) || $data_resep['Telaah'] == '' || $data_resep['Telaah'] == '-'){echo "CHECKED";}?>> Tepat Waktu</label><br/>
							<label><input type="checkbox" name="jenis_telaah[]" class="jenistelaah" value="Duplikasi" <?php if(in_array("Duplikasi", $arrtelaah) || $data_resep['Telaah'] == '' || $data_resep['Telaah'] == '-'){echo "CHECKED";}?>> Duplikasi</label><br/>
							<label><input type="checkbox" name="jenis_telaah[]" class="jenistelaah" value="Alergi" <?php if(in_array("Alergi", $arrtelaah) || $data_resep['Telaah'] == '' || $data_resep['Telaah'] == '-'){echo "CHECKED";}?>> Alergi</label><br/>
							<label><input type="checkbox" name="jenis_telaah[]" class="jenistelaah" value="Interaksi Obat" <?php if(in_array("Interaksi Obat", $arrtelaah) || $data_resep['Telaah'] == '' || $data_resep['Telaah'] == '-'){echo "CHECKED";}?>> Interaksi Obat</label><br/>
							<label><input type="checkbox" name="jenis_telaah[]" class="jenistelaah" value="Berat Badan (Anak)" <?php if(in_array("Berat Badan (Anak)", $arrtelaah) || $data_resep['Telaah'] == '' || $data_resep['Telaah'] == '-'){echo "CHECKED";}?>> Berat Badan (Anak)</label><br/>
							<label><input type="checkbox" name="jenis_telaah[]" class="jenistelaah" value="KI Lainnya" <?php if(in_array("KI Lainnya", $arrtelaah) || $data_resep['Telaah'] == '' || $data_resep['Telaah'] == '-'){echo "CHECKED";}?>> KI Lainnya</label><br/>
						</td>
					</tr>
					<tr>
						<td>Tenaga Farmasi</td>
						<td>
							<?php if ($kota == "KOTA TARAKAN"){?>
							<input type="text" name="tenagafarmasi" class="form-control" value="<?php echo $_SESSION['nama_petugas'];?>" readonly>
							<?php }else{?>
							<select name="tenagafarmasi" class="form-control tenagafarmasi">
								<?php
									$query = mysqli_query($koneksi,"SELECT NamaPegawai FROM `tbpegawai` WHERE `KodePuskesmas` = '$kodepuskesmas' AND (`Status`='APOTEKER' OR `Status`='ASISTEN APOTEKER')");
									while($data = mysqli_fetch_assoc($query)){
										if($data['NamaPegawai'] == $data_resep['NamaPegawai']){
											echo "<option value='$data[NamaPegawai]' SELECTED>$data[NamaPegawai]</option>";
										}else{
											echo "<option value='$data[NamaPegawai]'>$data[NamaPegawai]</option>";
										}
									}
								?>
							</select>
							<?php }?>
						</td>
					</tr>
					<tr>
						<td>Status Print</td>
						<td>
							<?php if($namapuskesmas == "SEBENGKOK"){?>
								<select name="statusprint" class="form-control statusprint">
								<option value="Resep Thermal">RESEP (PRINT THERMAL)</option>
								<option value="Resep">RESEP (PRINT A5)</option>
								<option value="Etiket">ETIKET</option>
							</select>
							<?php }else{?>
							<select name="statusprint" class="form-control statusprint">
								<option value="Resep Thermal">RESEP (PRINT THERMAL)</option>
								<option value="Resep">RESEP</option>
								<option value="Etiket">ETIKET</option>
							</select>
							<?php }?>
						</td>
					</tr>
					<tr>
						<td>Status Konseling*</td>
						<td>
							<select name="statuskonseling" class="form-control statuskonseling">
								<option value="TIDAK">TIDAK</option>
								<option value="YA">YA</option>
							</select>
						</td>
					</tr>
				</table>
				<br/>
				<div class="row">
					<div class="col-sm-12">
						<a href="#" data-href="apotik_print_resep_tarakan.php?norsp=<?php echo $data_resep['NoResep']?>&noid=<?php echo $data_resep['NoIndex']?>&ply=<?php echo $data_resep['Pelayanan']?>&statusloket=<?php echo $statusloket;?>&statusdilayani=<?php echo $statusdilayani;?>" class="btn btn-round btn-success btnsimpan btnprintresep" style="text-decoration: none;">PRINT</a>
					</div>
					<!--<div class="col-sm-6">
						<a href="apotik_print_etiket.php?norsp=<?php echo $data_resep['NoResep']?>&ply=<?php echo $data_resep['Pelayanan']?>" class="btnsimpan" style="text-decoration: none;">Print ETiket</a>
					</div>-->
				</div>
			</div>
		</div>
	</div>

	<div class="tableborderdiv">
		<div class="row noprint">
			<div class="col-sm-12">
				<div class="alert alert-block alert-success fade in">
					<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
					<p>
						<b>Perhatikan :</b><br/>
						1. Informasi Penggnaan Obat, link dengan laporan kefarmasian<br/>
						2. Status Konseling, link dengan laporan kefarmasian<br/>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>	

<script src="assets/js/jquery.js"></script>
<script src="assets/js/chosen.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$(".editjmlobat").dblclick(function(){
			var isi = $(this).html();
			var idresepdetail = $(this).data("idr");
			var batch = $(this).data("batch");
			var kodebarang = $(this).data("kodebarang");
			$(this).html("<input type='text' class='formedit' value='"+isi+"'>");
			$(".formedit").focus();
			$(".formedit").focusout(function(){
				var isibaru = $(this).val();
				//update ke database
						$.post( "apotik_pelayanan_resep_manual_lihat_edit.php", { sts:'jml', idresepdetail: idresepdetail, jumlah: isibaru, jumlahlama: isi, batch: batch,kodebarang:kodebarang});
				//update view
				$(this).parent().html(isibaru);
			})
		});

		$(".editsigna").dblclick(function(){
			var isi = $(this).html();
			var signa = isi.split(" x ");
			var idresepdetail = $(this).data("idr");
			var batch = $(this).data("batch");
			var kodebarang = $(this).data("kodebarang");
			$(this).html("<input type='text' class='formedit1' value='"+signa[0]+"'><input type='text' class='formedit2' value='"+signa[1]+"'>");
			//$(".formedit1").focus();
			$(".formedit1, .formedit2").focusout(function(){
				var signa1 = $(".formedit1").val();
				var signa2 = $(".formedit2").val();
				//update ke database
						$.post( "apotik_pelayanan_resep_manual_lihat_edit.php", { sts:'signa', idresepdetail: idresepdetail, signa1: signa1, signa2: signa2, batch: batch,kodebarang:kodebarang});
				//update view
				$(this).parent().html(signa1+" x "+signa2);
			})
		});

		
		$(".anjuaranclstd").dblclick(function(){
			var tmppl = $(this);
			var isi =tmppl.find("span").text();
			tmppl.find("span").text('');
			tmppl.find(".anjuranterapi_edit").show();
			var idresepdetail = $(this).data("idr");
			tmppl.find(".anjuranterapi_edit").change(function(){
				var anjuran = $(this).val();
				if(anjuran == 'Lainnya'){
					tmppl.find(".anjuranterapilain_edit").show();
					$(".anjuranterapilain_edit").focusout(function(){
						var anjuran = $(this).val();
						$.post( "apotik_pelayanan_resep_manual_lihat_edit.php", { sts:'anjuran', idresepdetail: idresepdetail, anjuran: anjuran});
						//update view
						tmppl.find("span").html(anjuran);
						tmppl.find(".anjuranterapi_edit").hide();
						tmppl.find(".anjuranterapilain_edit").hide();
					});
				}else{
					//update ke database
					$.post( "apotik_pelayanan_resep_manual_lihat_edit.php", { sts:'anjuran', idresepdetail: idresepdetail, anjuran: anjuran});
					//update view
					tmppl.find("span").html(anjuran);
					tmppl.find(".anjuranterapi_edit").hide();
				}
			})
		});
		
		
		$(".btnadd").click(function(){
			var clon = $(".trclones").clone();
			clon.removeClass("trclones");
			clon.removeAttr("style");
			clon.find(".therapybpjs").prop('required',true);
			// clon.find(".signa1").prop('required',true);
			// clon.find(".signa2").prop('required',true);
			clon.find(".jumlah").prop('required',true);
			$(".trclones").before(clon);

			// therapy BPJS
			$('.therapybpjs').autocomplete({
				// serviceUrl: 'get_therapy_manual.php/<?php echo str_replace(" ","-",$_GET['pelayanan']);?>',
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

			// chosen
			$('.chosenselects').chosen();

			//btnremove
			$(".btnremove").click(function(){
				$(this).parent().parent().remove();
			});

			$(".sts_racikan").change(function(){
				var isi = $(this).val();
				if(isi == 'true'){
					$(this).parent().parent().find(".ket_racikantr").show();
					$(this).parent().parent().find(".hides").hide();
				}else{
					$(this).parent().parent().find(".ket_racikantr").hide();
					$(this).parent().parent().find(".hides").show();
				}
			});
			
			$(".anjuranterapi").change(function(){
				if($(this).val() == 'Lainnya'){
					$(".formanjuranlainnya").show();
				}else{
					$(".formanjuranlainnya").hide();
				}
			});

		});

		$(".btnprintresep").click(function(){
			var tenaga = $(".tenagafarmasi").val();
			var statusprint = $(".statusprint").val();
			var statuskonseling = $(".statuskonseling").val();
			var jenispio = $('.jenispio:checked').map(function() { return this.value;}).get().join(',');
			var jenistelaah = $('.jenistelaah:checked').map(function() { return this.value;}).get().join(',');
			if(tenaga != ''){
				var link = $(this).data('href');
				window.location.href = link+'&tenagafarmasi='+tenaga+'&jenis_pio='+jenispio+'&jenis_telaah='+jenistelaah+'&statusprint='+statusprint+'&statuskonseling='+statuskonseling;
			}else{
				alert('silahkan pilih tenaga farmasi...');
			}
		});
	});
</script>	