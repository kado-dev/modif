<?php
	session_start();
	include "config/koneksi.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$arrpolipanggil = json_decode($_SESSION['PoliPanggil']);
	$lantai = $_SESSION['lantai'];
	$tbantrian_pasien = "tbantrian_pasien_".$kodepuskesmas;
	$tbwaktupelayanan = "tbwaktupelayanan_".$kodepuskesmas;
	$datasettingantrian = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tbantrian_setting WHERE `KodePuskesmas` = '$kodepuskesmas'"));
	
	if($kota == "KOTA TARAKAN"){
		date_default_timezone_set('Asia/Ujung_Pandang');
	}else{
		date_default_timezone_set('Asia/Jakarta');
	}

	$hariini = date('Y-m-d');

	if($datasettingantrian['versi_antrian'] == 'versi2'){
		include "get_modal_panggil_antrianv2.php";
	}else{
	
	$sts = $_GET['sts'];
	if($sts == 'selesai'){
		$loket = $_POST['loket'];	
		$_SESSION['loket'] = $loket;		
		
		$id = $_POST['id'];
		// select berdasarkan id
		$dtantrian = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `IdAntrian`,`NomorAntrianPoli`,`PoliPertama`,`nomorkartubpjs`,`kodepolibpjs`,`Klaster` FROM $tbantrian_pasien WHERE `IdAntrian`='$id'"));
		// echo "SELECT `IdAntrian`,`NomorAntrianPoli`,`PoliPertama`,`nomorkartubpjs`,`kodepolibpjs`,`Klaster` FROM $tbantrian_pasien WHERE `IdAntrian`='$id'";
		// die();
		// update waktu panggil
		// mysqli_query($koneksi,"UPDATE `$tbwaktupelayanan` SET `PanggilAntrian`=NOW() 
		// WHERE `NomorAntrianPoli` = '$dtantrian[NomorAntrianPoli]' AND PoliPertama = '$dtantrian[PoliPertama]'");		
		
		// select kode pelayanan  
		$dtpelayanan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbantrian_pelayanan` WHERE `Pelayanan`='$dtantrian[PoliPertama]' AND `KodePuskesmas`='$kodepuskesmas'"));
		$disps = $dtpelayanan['KodePelayanan']." - ".$dtantrian['NomorAntrianPoli'];
		// echo "SELECT * FROM `tbantrian_pelayanan` WHERE `Pelayanan`='$dtantrian[PoliPertama]' AND `KodePuskesmas`='$kodepuskesmas'";

		// cek kode
		$strr = "SELECT * FROM `tbantrian_view1` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Lantai` = '$lantai' AND `DisplayUtama` LIKE '$disps%'";
		// echo $strr;
		
		$cekdisplayutama = mysqli_num_rows(mysqli_query($koneksi, $strr));
		if($cekdisplayutama == 1){
			mysqli_query($koneksi,"UPDATE `$tbantrian_pasien` SET `StatusAntrian`='Selesai' WHERE `IdAntrian` = '$id'");
			mysqli_query($koneksi, "UPDATE `$tbantrian_pasien` SET `PanggilAntrian`=NOW() WHERE `NomorAntrianPoli` = '$dtantrian[NomorAntrianPoli]' AND PoliPertama = '$dtantrian[PoliPertama]' AND `IdAntrian` = '$id'");

			if($loket == 'loket 1'){
				$disp = 'DisplaySatu';
			}else if($loket == 'loket 2'){
				$disp = 'DisplayDua';
			}else if($loket == 'loket 3'){
				$disp = 'DisplayTiga';
			}else if($loket == 'loket 4'){
				$disp = 'DisplayEmpat';
			}
			
			$nomorantrian = $_POST['noantrian'];
			$time = date('Y-m-d H:i:s');

			// untuk membuat session noantrian dan poli(digunakan u validasi registrasi)
			$_SESSION['nomorantrian'] = str_replace(" - ", "", $nomorantrian);
			$_SESSION['poliantrian'] = "POLI ".$dtantrian['PoliPertama'];
			$_SESSION['ses_NomorAntrianPoli'] = $dtantrian['NomorAntrianPoli'];
			$_SESSION['ses_PoliPertama'] = $dtantrian['PoliPertama'];
			$_SESSION['ses_IdAntrian'] = $dtantrian['IdAntrian'];	
			$_SESSION['ses_Klaster'] = $dtantrian['Klaster'];	
			
			if($dtantrian['nomorkartubpjs'] != ''){//jika nokartu isi

				include('config/helper_bpjs_antrean_v2.php');

				$tanggalperiksa = date('Y-m-d');
				$kodepoli = $dtantrian['kodepolibpjs'];
				$nomorkartu = $dtantrian['nomorkartubpjs'];
				$status = 1; //1, ---> Status 1 = Hadir; Status 2 = Tidak Hadir
				$time_in_ms = round(microtime(true) * 1000); 
				$waktu = $time_in_ms ; //1616559330000 ---> Waktu dalam bentuk timestamp milisecond

				$pgl = update_antrean_fktp($tanggalperiksa,$kodepoli,$nomorkartu,$status,$waktu);
				// echo $pgl;
				// die();
				// mysqli_query($koneksi, "UPDATE `$tbantrian_pasien` SET `responseBpjs`='$pgl' WHERE `IdAntrian` = '$id'");
			}

			mysqli_query($koneksi,"UPDATE `tbantrian_view1` SET `DisplayUtama`= '', `$disp`= '$nomorantrian', `Lantai` = '$lantai', `Waktu` = '$time' WHERE `KodePuskesmas`='$kodepuskesmas'");
			//display antiran
			
			$qry = mysqli_query($koneksi,"select * FROM `$tbantrian_pasien` where date(WaktuAntrian) = '$hariini' AND `KodePuskesmas`='$kodepuskesmas' AND `StatusAntrian` != 'Selesai' order by NomorAntrian");
			echo mysqli_num_rows($qry);
		}else{
			echo 'belumselesai';
		}
	}else if($sts == 'pending'){
		$loket = $_POST['loket'];
		if($_SESSION['loket'] == null){
			$_SESSION['loket'] = $loket;
		}
		$id = $_POST['id'];
		$dtantrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `IdAntrian`,`NomorAntrianPoli`,`PoliPertama`,`nomorkartubpjs`,`kodepolibpjs` FROM $tbantrian_pasien WHERE `IdAntrian`='$id'"));
		if($dtantrian['nomorkartubpjs'] != ''){//jika nokartu isi

			include('config/helper_bpjs_antrean_v2.php');

			$tanggalperiksa = date('Y-m-d');
			$kodepoli = $dtantrian['kodepolibpjs'];
			$nomorkartu = $dtantrian['nomorkartubpjs'];
			$status = 2; //1, ---> Status 1 = Hadir; Status 2 = Tidak Hadir
			$time_in_ms = round(microtime(true) * 1000); 
			$waktu = $time_in_ms ; //1616559330000 ---> Waktu dalam bentuk timestamp milisecond

			$pgl = update_antrean_fktp($tanggalperiksa,$kodepoli,$nomorkartu,$status,$waktu);
			// echo $pgl;
			// die();
			mysqli_query($koneksi,"UPDATE `$tbantrian_pasien` SET `responseBpjs`='$pgl' WHERE `IdAntrian` = '$id'");
		}

		mysqli_query($koneksi,"UPDATE `$tbantrian_pasien` SET `StatusAntrian`='Pending' WHERE `IdAntrian` = '$id'");

		$time = date('Y-m-d H:i:s');
		mysqli_query($koneksi,"UPDATE `tbantrian_view1` SET `DisplayUtama`= '', `Lantai` = '$lantai', `Waktu` = '$time' where `KodePuskesmas` = '$kodepuskesmas' ");
		//display antiran
		
		$qry = mysqli_query($koneksi,"select * from `$tbantrian_pasien` where date(WaktuAntrian) = '$hariini' AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` != 'Selesai' order by NomorAntrian");
		echo mysqli_num_rows($qry);
	}else if($sts == 'batal'){		
		$id = $_POST['id'];
		$dtantrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `IdAntrian`,`NomorAntrianPoli`,`PoliPertama`,`nomorkartubpjs`,`kodepolibpjs` FROM $tbantrian_pasien WHERE `IdAntrian`='$id'"));
		if($dtantrian['nomorkartubpjs'] != ''){//jika nokartu isi

			include('config/helper_bpjs_antrean_v2.php');
			$tanggalperiksa = date('Y-m-d');
			$kodepoli = $dtantrian['kodepolibpjs'];
			$nomorkartu = $dtantrian['nomorkartubpjs'];
			$alasan = $_POST['alasan'];

			$batalRes = batal_antrean_fktp($tanggalperiksa,$kodepoli,$nomorkartu,$alasan);//batal
			// echo $batalRes;
			// die();
			mysqli_query($koneksi,"UPDATE `$tbantrian_pasien` SET `responseBpjs`='$batalRes' WHERE `IdAntrian` = '$id'");
		}

		mysqli_query($koneksi,"UPDATE `$tbantrian_pasien` SET `StatusAntrian`='Batal' WHERE `IdAntrian` = '$id'");
		
		$qry = mysqli_query($koneksi,"select * from `$tbantrian_pasien` where date(WaktuAntrian) = '$hariini' AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` != 'Selesai' order by NomorAntrian");
		echo mysqli_num_rows($qry);
	}else if($sts == 'refresh'){
		$time = date('Y-m-d H:i:s');
		mysqli_query($koneksi,"UPDATE `tbantrian_view1` SET `Lantai` = '$lantai', `Waktu` = '$time' where `KodePuskesmas` = '$kodepuskesmas' ");
	}else if($sts == 'cekdata'){
		$qry = mysqli_query($koneksi,"select * from `$tbantrian_pasien` where date(WaktuAntrian) = '$hariini' AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` != 'Selesai' order by NomorAntrian");
		echo mysqli_num_rows($qry);
	}else if($sts == 'insertdisplay'){
		$loket = $_POST['loket'];
		if($loket == 'loket 1'){
			$disp = 'DisplaySatu';
		}else if($loket == 'loket 2'){
			$disp = 'DisplayDua';
		}else if($loket == 'loket 3'){
			$disp = 'DisplayTiga';
		}else if($loket == 'loket 4'){
			$disp = 'DisplayEmpat';
		}
		$nomorantrian = $_POST['noantrian'];

		$time = date('Y-m-d H:i:s');
		
		//mencari selisih
		$dtwaktu = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Waktu` from `tbantrian_view1` where `KodePuskesmas` = '$kodepuskesmas' AND `Lantai` = '$lantai'"));
		$selisih = strtotime($time) - strtotime($dtwaktu['Waktu']);

		//jika lebih dari 30 detik baru panggil lagi/yg baru
		// if($selisih > 3){
			mysqli_query($koneksi,"UPDATE `tbantrian_view1` SET `$disp`='$nomorantrian',`DisplayUtama`= '$nomorantrian|$loket', `Lantai` = '$lantai', `Waktu` = '$time' where `KodePuskesmas` = '$kodepuskesmas'"); //AND `DisplayUtama` = ''(query yg lama)
		// }
		echo $selisih;
	}else if($sts == 'session_set'){	
		$namasession = $_POST['namasession'];
		$sts = $_POST['status'];
		if($sts == 'set'){
			$_SESSION[$namasession] = $namasession;
		}else{
			unset($_SESSION[$namasession]);
		}
	}else if($sts == 'update_sts_bpjs'){
		$time = date('Y-m-d H:i:s');
		$id = $_POST['idantrian'];
		mysqli_query($koneksi,"UPDATE `$tbantrian_pasien` SET `StatusBpjs`='Selesai' WHERE `IdAntrian` = '$id'");
		mysqli_query($koneksi,"UPDATE `tbantrian_view_jkn` SET `Waktu` = '$time' where `KodePuskesmas` = '$kodepuskesmas'");
		echo "1";
	}else{
		$qry = mysqli_query($koneksi,"select * from `$tbantrian_pasien` where date(WaktuAntrian) = '$hariini' AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Antri' order by NomorAntrian Limit 1");
		if(mysqli_num_rows($qry) == 0){
			$qry = mysqli_query($koneksi,"select * from `$tbantrian_pasien` where date(WaktuAntrian) = '$hariini' AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Pending' order by NomorAntrian Limit 1");
		}
	$dt = mysqli_fetch_array($qry);
?>
<style>
	.listantr li{
		list-style:none;
		cursor:pointer;
		padding:5px;
		border-bottom:1px solid #ddd;
	}
	.listantr li:last-child{
		border-bottom:none;
	}
	.btnantrian{
		background:#ddd;
		color:#111;
		padding:4px 9px;
		border-radius:3px;
		margin-left:5px;
		border:none;
	}
	.btns{
		border-radius:6px;
	}
	/* .table thead tr th{
		padding:10px;background: #d8d8d8;border-bottom: 1px solid #ddd;
	}*/
	.modal-content{
		top:140px;
	}
</style>
<div class="modal fade noprint" id="Modalantrian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				
				<h4 class="modal-title" id="myModalLabel">PANGGIL ANTRIAN</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
	  
			<div class="modal-body tmpform"></div>
			<div class="modal-body tmpasl">
				<input type="hidden" class="idantrian" value="<?php echo $dt['IdAntrian']?>">
				<?php
					$strkdantrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `KodePelayanan` FROM `tbantrian_pelayanan` WHERE `Pelayanan`='$dt[PoliPertama]' AND `KodePuskesmas`='$kodepuskesmas'"));
				?>
					<h3 style="text-align:center;margin:10px 0px">
						<span style="font-size:18px">Nomor Antrian</span><br/>
						<span style="font-size:39px" class="viewantrian"><?php echo str_replace(" ","",$strkdantrian['KodePelayanan'])." - ".$dt['NomorAntrianPoli']?></span>
						<span class="noantriancls" style="display:none"><?php echo str_replace(" ","`",$strkdantrian['KodePelayanan'])." - ".$dt['NomorAntrianPoli']?></span>
					</h3>
					<div class="row">
						<table width="350px" style="margin: 0px 0px 10px 10px">
							<tr>
								<td width="90px">User</td>
								<td width="30px">:</td>
								<td><?php echo $_SESSION['nama_petugas']; ?></td>
							</tr>
							<tr>
								<td>Loket</td>
								<td>:</td>
								<td><?php echo $_SESSION['LoketPanggil']; ?></td>
							</tr>
							<tr>
								<td>Poli</td>
								<td>:</td>
								<td>
									<?php
									$poliarr = json_decode($_SESSION['PoliPanggil']); 
									foreach($poliarr as $plr){
										//echo "SELECT `Pelayanan` FROM `tbantrian_pelayanan` WHERE KodePelayanan = '$plr' AND `KodePuskesmas`='$kodepuskesmas'";
										$dtpelayanans = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Pelayanan` FROM `tbantrian_pelayanan` WHERE KodePelayanan = '$plr' AND `KodePuskesmas`='$kodepuskesmas'"));
										$newpoliarr[] = $dtpelayanans['Pelayanan'];
									}
									echo implode(", ", $newpoliarr);
									?>
								</td>
							</tr>
							<tr>
								<td>Lantai</td>
								<td>:</td>
								<td><?php echo $_SESSION['lantai']; ?></td>
							</tr>
						</table>
					</div>

					<div class="row">					
						<div class="col-sm-3">
							<a href="#" class="btn btn-success btn-block selesaibtn btns">Selesai</a>
						</div>
						<div class="col-sm-3">
							<a href="#" class="btn btn-warning btn-block pendingbtn btns" style="margin-right:5px">Pending</a>
						</div>
						<div class="col-sm-3">
							<a href="#" class="btn btn-danger btn-block batalbtn btns" style="margin-right:5px">Batal</a>
						</div>
						<div class="col-sm-3">
							<a href="#" class="btn btn-primary btn-block refreshbtn btns" style="margin-right:5px">Reload View Antrian</a>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							<div class="dataview" style="margin-top:10px;height:350px;overflow-y:auto">
								<div class="row">
									<div class="col-sm-3"><b>ANTRI</b></div>
									<div class="col-sm-3"><b>PENDING</b></div>
									<div class="col-sm-3"><b>BATAL</b></div>
									<div class="col-sm-3"><b>SELESAI</b></div>
								</div>
								<div class="row">
									<div class="col-sm-3 listantr">
										<?php
										// $qryantri = mysqli_query($koneksi, "SELECT `IdAntrian`,`IdPasienOnline`,`NomorAntrian`,`NomorAntrianPoli`, `PoliPertama`, `nomorkartubpjs` FROM `$tbantrian_pasien` WHERE date(WaktuAntrian) = '$hariini' AND `StatusAntrian` = 'Antri' group by NomorAntrian order by NomorAntrian");
										// echo "SELECT `IdAntrian`,`IdPasienOnline`,`NomorAntrian`,`NomorAntrianPoli`, `PoliPertama`, `nomorkartubpjs` FROM `$tbantrian_pasien` WHERE date(WaktuAntrian) = '$hariini' AND `StatusAntrian` = 'Antri' order by NomorAntrian";
										$qryantri = mysqli_query($koneksi, "SELECT `IdAntrian`,`IdPasienOnline`,`NomorAntrian`,`NomorAntrianPoli`, `PoliPertama`, `nomorkartubpjs` FROM `$tbantrian_pasien` WHERE date(WaktuAntrian) = '$hariini' AND `StatusAntrian` = 'Antri' order by NomorAntrian");
										while($dta = mysqli_fetch_array($qryantri)){
											$strkdantrian = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `KodePelayanan` FROM `tbantrian_pelayanan` WHERE Pelayanan = '$dta[PoliPertama]' AND `KodePuskesmas`='$kodepuskesmas'"));
											//echo "<li>".$dta['NomorAntrian']." - ".$dta['PoliPertama']."</li>";
											if(in_array($strkdantrian['KodePelayanan'], $arrpolipanggil)){
												echo "<li class='".$dta['PoliPertama']."-list'>
												<input type='hidden' class='idanlist' value='".$dta['IdAntrian']."'/>
												<input type='hidden' class='nomorantrian' value='".str_replace(" ","`",$strkdantrian['KodePelayanan'])." - ".$dta['NomorAntrianPoli']."'/>
												<input type='hidden' class='viewnomorantrian' value='".str_replace(" ","",$strkdantrian['KodePelayanan'])." - ".$dta['NomorAntrianPoli']."'/>
												<span>".$dta['NomorAntrian'].". ".$strkdantrian['KodePelayanan']." - ".$dta['PoliPertama']." | ".$dta['NomorAntrianPoli']."</span>
												<button class='btnantrian antrianlistbtn'><i class='ace-icon fa fa-bullhorn'></button></i>
												</li>";

												if($dta['IdPasienOnline'] != '0'){
													echo "<button class='btn btn-xs btn-round btn-success'>Daftar Online</button>";	
												}	
											}	
										}
										?>
									</div>
									<div class="col-sm-3 listantr">
										<?php
											// $qrypending = mysqli_query($koneksi, "SELECT `IdAntrian`,`IdPasienOnline`,`NomorAntrian`,`NomorAntrianPoli`,`PoliPertama`, `nomorkartubpjs` FROM `$tbantrian_pasien` WHERE date(WaktuAntrian) = '$hariini' AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Pending' group by NomorAntrian order by NomorAntrian");
											$qrypending = mysqli_query($koneksi, "SELECT `IdAntrian`,`IdPasienOnline`,`NomorAntrian`,`NomorAntrianPoli`,`PoliPertama`, `nomorkartubpjs` FROM `$tbantrian_pasien` WHERE date(WaktuAntrian) = '$hariini' AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Pending' order by NomorAntrian");
											while($dtp = mysqli_fetch_array($qrypending)){
												$strkdantrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `KodePelayanan` FROM `tbantrian_pelayanan` WHERE Pelayanan = '$dtp[PoliPertama]' AND `KodePuskesmas`='$kodepuskesmas'"));
												
												if(in_array($strkdantrian['KodePelayanan'], $arrpolipanggil)){
													echo "<li class='".$dtp['PoliPertama']."-list'>
													<input type='hidden' class='idanlist' value='".$dtp['IdAntrian']."'/>
													<input type='hidden' class='nomorantrian' value='".str_replace(" ","`",$strkdantrian['KodePelayanan'])." - ".$dtp['NomorAntrianPoli']."'/>
													<input type='hidden' class='viewnomorantrian' value='".str_replace(" ","",$strkdantrian['KodePelayanan'])." - ".$dtp['NomorAntrianPoli']."'/>
													<span>".$dtp['NomorAntrian'].". ".$strkdantrian['KodePelayanan']." - ".$dtp['PoliPertama']." | ".$dtp['NomorAntrianPoli']."</span>
													<button class='btnantrian pendinglistbtn'><i class='ace-icon fa fa-bullhorn'></i></button> 
													</li>";
													
													if($dtp['IdPasienOnline'] != '0'){
														echo "<button class='btn btn-xs btn-round btn-success'>Daftar Online</button>";	
													}	
												}
											}
										?>
									</div>
									<div class="col-sm-3 listantr">
										<?php
											// $qrypending = mysqli_query($koneksi, "SELECT `IdAntrian`,`IdPasienOnline`,`NomorAntrian`,`NomorAntrianPoli`,`PoliPertama`, `nomorkartubpjs` FROM `$tbantrian_pasien` WHERE date(WaktuAntrian) = '$hariini' AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Batal' group by NomorAntrian order by NomorAntrian");
											$qrypending = mysqli_query($koneksi, "SELECT `IdAntrian`,`IdPasienOnline`,`NomorAntrian`,`NomorAntrianPoli`,`PoliPertama`, `nomorkartubpjs` FROM `$tbantrian_pasien` WHERE date(WaktuAntrian) = '$hariini' AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Batal' order by NomorAntrian");
											while($dtp = mysqli_fetch_array($qrypending)){
												$strkdantrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `KodePelayanan` FROM `tbantrian_pelayanan` WHERE Pelayanan = '$dtp[PoliPertama]' AND `KodePuskesmas`='$kodepuskesmas'"));
												
												if(in_array($strkdantrian['KodePelayanan'], $arrpolipanggil)){
													echo "<li class='".$dtp['PoliPertama']."-list'>
														<input type='hidden' class='idanlist' value='".$dtp['IdAntrian']."'/>
														<input type='hidden' class='nomorantrian' value='".str_replace(" ","`",$strkdantrian['KodePelayanan'])." - ".$dtp['NomorAntrianPoli']."'/>
														<input type='hidden' class='viewnomorantrian' value='".str_replace(" ","",$strkdantrian['KodePelayanan'])." - ".$dtp['NomorAntrianPoli']."'/>
														<span>".$dtp['NomorAntrian'].". ".$strkdantrian['KodePelayanan']." - ".$dtp['PoliPertama']." | ".$dtp['NomorAntrianPoli']."</span> 
														</li>";
														
														if($dtp['IdPasienOnline'] != '0'){
															echo "<button class='btn btn-xs btn-round btn-success'>Daftar Online</button>";	
														}	
												}
											}
										?>
									</div>
									<div class="col-sm-3 listantr">
										<?php
											$qryselesai = mysqli_query($koneksi, "SELECT `IdPasienOnline`,`NomorAntrian`,`PoliPertama`,`NomorAntrianPoli`,`StatusAntrian`,`StatusDaftar`, `nomorkartubpjs` FROM `$tbantrian_pasien` WHERE date(WaktuAntrian) = '$hariini' AND (`StatusAntrian` = 'Selesai' OR `StatusAntrian` = 'Batal') order by PoliPertama, NomorAntrianPoli");
											while($dts = mysqli_fetch_array($qryselesai)){
												$strkdantrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `KodePelayanan` FROM `tbantrian_pelayanan` WHERE Pelayanan = '$dts[PoliPertama]' AND `KodePuskesmas`='$kodepuskesmas'"));
												// if($dts['IdPasienOnline'] != 0){
													if($dts['StatusDaftar'] == 'M-JKN' && $dts['StatusAntrian'] == 'Batal'){
														$ket = " <button class='btn btn-xs btn-round btn-success'>$dts[StatusDaftar]</button>";
													}elseif($dts['StatusDaftar'] == 'ISAP'){
														$ket = " <button class='btn btn-xs btn-round btn-primary'>$dts[StatusDaftar]</button>";											
													}else{
														$ket = " ";
													}
												// }

												if(in_array($strkdantrian['KodePelayanan'], $arrpolipanggil)){
													echo 
													"<li class='".
														$dts['PoliPertama']."-list'>".
														$dts['NomorAntrian'].". ".
														$strkdantrian['KodePelayanan']." - ".
														$dts['PoliPertama']." | ".
														$dts['NomorAntrianPoli'].
														$ket." ".
													"</li>";	
													
												}
												// if($dts['IdPasienOnline'] != '0'){echo "<button class='btn btn-xs btn-round btn-success'>Daftar Online</button>";}
											}
										?>
									</div>
								</div>
								
							</div>
						</div>
						<!--<div class="col-sm-4">
							<div class="dataview" style="margin-top:10px;height:350px;overflow:auto">
								<table class="table table-condensed table-bordered">
										<thead>
											<tr>
												<th style="text-align:center">M-JKN Proses</th>
												<th style="text-align:center">M-JKN Selesai</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<?php
													// $qryselesaijkn1 = mysqli_query($koneksi,"select `IdAntrian`,`NomorAntrian`, `PoliPertama`, `NomorAntrianPoli` from `$tbantrian_pasien` WHERE date(WaktuAntrian) = '$hariini' AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Selesai' AND `StatusBpjs` = 'proses' group by NomorAntrian order by NomorAntrian");
													// while($dts = mysqli_fetch_array($qryselesaijkn1)){
														// $strkdantrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `KodePelayanan` FROM `tbantrian_pelayanan` WHERE Pelayanan = '$dts[PoliPertama]' AND `KodePuskesmas`='$kodepuskesmas'"));
														// if(in_array($strkdantrian['KodePelayanan'], $arrpolipanggil)){
														// echo "<li class='".$dts['PoliPertama']."-list' data-idantrian='".$dts['IdAntrian']."'>".$dts['NomorAntrian']." - ".$strkdantrian['KodePelayanan']." - ".$dts['PoliPertama']." | ".$dts['NomorAntrianPoli']."<button class='btnantrian btn-success applistbtn'>
																// Approve</button></li>";
														// }
													// }
													?>
												</td>
												<td>
													<?php
													// $qryselesaijkn2 = mysqli_query($koneksi,"select `NomorAntrian`, `PoliPertama`, `NomorAntrianPoli` from `$tbantrian_pasien` WHERE date(WaktuAntrian) = '$hariini' AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Selesai' AND `StatusBpjs` = 'selesai' group by NomorAntrian order by NomorAntrian");
													// while($dts = mysqli_fetch_array($qryselesaijkn2)){
														// $strkdantrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `KodePelayanan` FROM `tbantrian_pelayanan` WHERE Pelayanan = '$dts[PoliPertama]' AND `KodePuskesmas`='$kodepuskesmas'"));
														// if(in_array($strkdantrian['KodePelayanan'], $arrpolipanggil)){
														// echo "<li class='".$dts['PoliPertama']."-list'>".$dts['NomorAntrian']." - ".$strkdantrian['KodePelayanan']." - ".$dts['PoliPertama']." | ".$dts['NomorAntrianPoli']."</li>";
														// }
													// }
													?>
												</td>
											</tr>
										</tbody>
								</table>
							</div>
						</div>-->
					</div>	
			</div>
		</div>
	</div>
</div>
<script>	
	$( ".lbc" ).each(function( index ) {
	  	var dtc = $(this).prop( "checked" );
	  	var dtl = $(this).data('label')+"-list";
		if(dtc == true){
			$('.'+dtl).show();
		}else{
			$('.'+dtl).hide();
		}
	});

	$(".lbc").click(function(){
		var ini = $(this).prop( "checked" );
		var dt = $(this).data('label');
		var list = dt+"-list";
		var sess = dt;
		if(ini == true){
			$('.'+list).show();
			$.post( "get_modal_panggil_antrian.php?sts=session_set", {namasession:sess,status:'set'});
		}else{
			$.post( "get_modal_panggil_antrian.php?sts=session_set", {namasession:sess,status:'unset'});
			$('.'+list).hide();
		}
	});
	
	$(".selesaibtn").click(function(){
		var loket = '<?php echo $_SESSION['LoketPanggil'];?>';//$(".loketcls").val();
		var idantrian = $(".idantrian").val();
		var viewantrian = $(".viewantrian").text();
		$.post( "get_modal_panggil_antrian.php?sts=selesai", { id: idantrian, loket:loket, noantrian:viewantrian}).done(function( data ) {
			console.log(data);
			// alert(data);
			if(data == 'belumselesai'){
				alert("Silahkan klik tombol panggil...");
			}else{
				$('#Modalantrian').modal('hide');
				if(data == 0){
					 //document.location.href='index.php?page=registrasi_form';
					 location.reload();
				}else{
					location.reload();
				}
			}
		});
	});
	
	$(".pendingbtn").click(function(){
		var loket = '<?php echo $_SESSION['LoketPanggil'];?>';//$(".loketcls").val();
		var idantrian = $(".idantrian").val();
		$.post( "get_modal_panggil_antrian.php?sts=pending", { id: idantrian, loket:loket}).done(function( data ) {
			$('#Modalantrian').modal('hide');
			console.log(data);
			if(data == 0){
				 document.location.href='index.php?page=registrasi';
			}
		});
	});

	$(".batalbtn").click(function(){
		var idantrian = $(".idantrian").val();
		var form = `<input type="hidden" class="idantrian_batal" value="`+idantrian+`">
                <textarea class="form-control alasan_batal" placeholder="Alasan batal"></textarea><br/>
                <button class="btn btn-info batalbtn_conf">Simpan</button>`;
		$(".tmpform").html(form);
		$(".tmpasl").hide();

		$(".batalbtn_conf").click(function(){
			var idantrian = $(".idantrian_batal").val();
			var alasan = $(".alasan_batal").val();
			$.post( "get_modal_panggil_antrian.php?sts=batal", { id: idantrian, alasan: alasan}).done(function( data ) {
				console.log(data);
				$('#Modalantrian').modal('hide');
				if(data == 0){
					document.location.href='index.php?page=registrasi';
				}
			});
		});		
	});
	
	$(".refreshbtn").click(function(){
		$.post( "get_modal_panggil_antrian.php?sts=refresh").done(function( data ) {
			$('#Modalantrian').modal('hide');
			// if(data == 0){
			// 	 document.location.href='index.php?page=registrasi';
			// }
		});
	});
	
	$(".pendinglistbtn").click(function(){
		var loket = '<?php echo $_SESSION['LoketPanggil'];?>';//$(".loketcls").val();
		var view_antrian = $(this).parent().find(".viewnomorantrian").val();
		var antrian = $(this).parent().find(".nomorantrian").val();
		var idantrian = $(this).parent().find(".idanlist").val();
		
		$(".viewantrian").text(view_antrian);
		$(".idantrian").val(idantrian);
		$(".noantriancls").text(antrian);
		// responsiveVoice.speak("Nomor Antrian "+antrian+" Ke "+loket,"Indonesian Female", {rate: 0.7});
		$.post( "get_modal_panggil_antrian.php?sts=insertdisplay", {noantrian:view_antrian,loket:loket}).done(function( data ) {
			console.log(data);
			if(data < 3){
				alert('Silahkan tunggu antrian sebelumnya selesai dipanggil...');
			}
		});	
	});		

	
	
	$(".antrianlistbtn").click(function(){
		var loket = '<?php echo $_SESSION['LoketPanggil'];?>';//$(".loketcls").val();
		var view_antrian = $(this).parent().find(".viewnomorantrian").val();
		var antrian = $(this).parent().find(".nomorantrian").val();
		var idantrian = $(this).parent().find(".idanlist").val();
		
		$(".viewantrian").text(view_antrian);
		$(".idantrian").val(idantrian);
		$(".noantriancls").text(antrian);
		// responsiveVoice.speak("Nomor Antrian "+antrian+" Ke "+loket,"Indonesian Female", {rate: 0.7});
		$.post( "get_modal_panggil_antrian.php?sts=insertdisplay", {noantrian:view_antrian,loket:loket}).done(function( data ) {
			console.log(data);
			// if(data < 3){
				// alert('Silahkan tunggu antrian sebelumnya selesai dipanggil...');
			// }
		});	
	});	


	$(".applistbtn").click(function(){
		var idantrian = $(this).parent().data("idantrian");
		$.post( "get_modal_panggil_antrian.php?sts=update_sts_bpjs", {idantrian:idantrian}).done(function( data ) {
			console.log(data);
			$('#Modalantrian').modal('hide');
		});	
	});	
</script>
	<?php 
		}
	}
	?>