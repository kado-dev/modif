<?php
	session_start();
	include "config/koneksi.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$arrpolipanggil = json_decode($_SESSION['PoliPanggil']);
	$tbantrian_pasien = "tbantrian_pasien_".$kodepuskesmas."_pustu";
	
	$datasettingantrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbantrian_setting WHERE KodePuskesmas = '$kodepuskesmas'"));
	

	if($datasettingantrian['versi_antrian'] == 'versi2'){
		include "get_modal_panggil_antrianv2.php";
	}else{
	
	$sts = $_GET['sts'];
	if($sts == 'selesai'){
		$loket = $_POST['loket'];
	
		$_SESSION['loket'] = $loket;
		
		
		$id = $_POST['id'];
		//select berdasarkan id
		$dtantrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT NomorAntrianPoli, PoliPertama FROM $tbantrian_pasien WHERE `IdAntrian`='$id'"));
		//select kodep  
		$dtpelayanan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` WHERE `Pelayanan`='$dtantrian[PoliPertama]' AND `KodePuskesmas`='$kodepuskesmas'"));
		$disps = $dtpelayanan['KodePelayanan']." - ".$dtantrian['NomorAntrianPoli'];
		//cek kode
		$strr = "SELECT * FROM tbantrian_view_pustu WHERE `DisplayUtama` LIKE '$disps%'";
		
		$cekdisplayutama = mysqli_num_rows(mysqli_query($koneksi,$strr));
		if($cekdisplayutama == 1){
		mysqli_query($koneksi,"UPDATE `$tbantrian_pasien` SET `StatusAntrian`='Selesai' WHERE `IdAntrian` = '$id'");
		
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

		//untuk membuat session noantrian dan poli(digunakan u validasi registrasi)
		$_SESSION['nomorantrian'] = str_replace(" - ", "", $nomorantrian);
		$_SESSION['poliantrian'] = "POLI ".$dtantrian['PoliPertama'];

		mysqli_query($koneksi,"UPDATE `tbantrian_view_pustu` SET `DisplayUtama`= '', `$disp`= '$nomorantrian', `Waktu` = '$time' WHERE `KodePuskesmas`='$kodepuskesmas'");
		//display antiran
		
		$qry = mysqli_query($koneksi,"select * from `$tbantrian_pasien` where date(WaktuAntrian) = curdate() AND `KodePuskesmas`='$kodepuskesmas' AND `StatusAntrian` != 'Selesai' order by NomorAntrian");
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
		mysqli_query($koneksi,"UPDATE `$tbantrian_pasien` SET `StatusAntrian`='Pending' WHERE `IdAntrian` = '$id'");

		$time = date('Y-m-d H:i:s');
		mysqli_query($koneksi,"UPDATE `tbantrian_view_pustu` SET `DisplayUtama`= '', `Waktu` = '$time' where `KodePuskesmas` = '$kodepuskesmas' ");
		//display antiran
		
		$qry = mysqli_query($koneksi,"select * from `$tbantrian_pasien` where date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` != 'Selesai' order by NomorAntrian");
		echo mysqli_num_rows($qry);
		
	}else if($sts == 'cekdata'){
		$qry = mysqli_query($koneksi,"select * from `$tbantrian_pasien` where date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` != 'Selesai' order by NomorAntrian");
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
		$dtwaktu = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Waktu` from `tbantrian_view_pustu` where `KodePuskesmas` = '$kodepuskesmas'"));
		$selisih = strtotime($time) - strtotime($dtwaktu['Waktu']);

		//jika lebih dari 30 detik baru panggil lagi/yg baru
		if($selisih > 3){
			mysqli_query($koneksi,"UPDATE `tbantrian_view_pustu` SET `$disp`='$nomorantrian',`DisplayUtama`= '$nomorantrian|$loket', `Waktu` = '$time' where `KodePuskesmas` = '$kodepuskesmas'"); //AND `DisplayUtama` = ''(query yg lama)
		}
		echo $selisih;
	}else if($sts == 'session_set'){	
		$namasession = $_POST['namasession'];
		$sts = $_POST['status'];
		if($sts == 'set'){
			$_SESSION[$namasession] = $namasession;
		}else{
			unset($_SESSION[$namasession]);
		}
		
	}else{
		$qry = mysqli_query($koneksi,"select * from `$tbantrian_pasien` where date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Antri' order by NomorAntrian Limit 1");
		if(mysqli_num_rows($qry) == 0){
			$qry = mysqli_query($koneksi,"select * from `$tbantrian_pasien` where date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Pending' order by NomorAntrian Limit 1");
		}
	$dt = mysqli_fetch_array($qry);
?>
<style>
	td li{
		list-style:none;
		cursor:pointer;
		padding:5px;
		border-bottom:1px solid #ddd;
	}
	td li:last-child{
		border-bottom:none;
	}
	.btnantrian{
		background:#ddd;
		color:#111;
		padding:4px 9px;
		border-radius:3px;
		margin-left:15px;
		border:none;
	}
	.btns{
		border-radius:6px;
	}
	.table thead tr th{
		padding:10px;background: #f5f5f5;border-bottom: 1px solid #ddd;
	}
</style>
<div class="modal fade noprint" id="Modalantrian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">PANGGIL ANTRIAN PUSTU</h4>
			</div>
	  
			<div class="modal-body">
				<input type="hidden" class="idantrian" value="<?php echo $dt['IdAntrian']?>">
				
				<?php
					$strkdantrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `KodePelayanan` FROM `tbantrian_pelayanan` where Pelayanan = '$dt[PoliPertama]' AND `KodePuskesmas`='$kodepuskesmas'"));
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
						</table>
						<div class="col-sm-6">
							<a href="#" class="btn btn-primary btn-block btn-white selesaibtn btns">Selesai</a>
						</div>
						<div class="col-sm-6">
						<a href="#" class="btn btn-danger btn-block btn-white pendingbtn btns" style="margin-right:5px">Pending</a>
						</div>
					</div>
				<div class="dataview" style="margin-top:10px;height:350px;overflow:auto">
					<table class="table table-condensed table-bordered">
							<thead>
								<tr>
									<th style="text-align:center">Pending</th>
									<th style="text-align:center">Antri</th>
									<th style="text-align:center">Selesai</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<?php
										

										$qrypending = mysqli_query($koneksi,"select `IdAntrian`,`NomorAntrian`,`NomorAntrianPoli`,`PoliPertama` from `$tbantrian_pasien` WHERE date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Pending' group by NomorAntrian order by NomorAntrian");
										while($dtp = mysqli_fetch_array($qrypending)){
											$strkdantrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `KodePelayanan` FROM `tbantrian_pelayanan` WHERE Pelayanan = '$dtp[PoliPertama]' AND `KodePuskesmas`='$kodepuskesmas'"));
											if(in_array($strkdantrian['KodePelayanan'], $arrpolipanggil)){
											echo "<li class='".$dtp['PoliPertama']."-list'>
													<input type='hidden' class='idanlist' value='".$dtp['IdAntrian']."'/>
													<input type='hidden' class='nomorantrian' value='".str_replace(" ","`",$strkdantrian['KodePelayanan'])." - ".$dtp['NomorAntrianPoli']."'/>
													<input type='hidden' class='viewnomorantrian' value='".str_replace(" ","",$strkdantrian['KodePelayanan'])." - ".$dtp['NomorAntrianPoli']."'/>
													<span>".$dtp['NomorAntrian']." - ".$strkdantrian['KodePelayanan']." - ".$dtp['PoliPertama']." | ".$dtp['NomorAntrianPoli']."</span><button class='btnantrian pendinglistbtn'>
													<i class='ace-icon fa fa-bullhorn'></button></i>
												</li>";
											}	
										}
										?>
									</td>
									<td>
										<?php
										 $qryantri = mysqli_query($koneksi,"select `IdAntrian`,`NomorAntrian`,`NomorAntrianPoli`, `PoliPertama` from `$tbantrian_pasien` WHERE date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Antri' group by NomorAntrian order by NomorAntrian");
										while($dta = mysqli_fetch_array($qryantri)){
											$strkdantrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `KodePelayanan` FROM `tbantrian_pelayanan` WHERE Pelayanan = '$dta[PoliPertama]' AND `KodePuskesmas`='$kodepuskesmas'"));
											//echo "<li>".$dta['NomorAntrian']." - ".$dta['PoliPertama']."</li>";
											if(in_array($strkdantrian['KodePelayanan'], $arrpolipanggil)){
											echo "<li class='".$dta['PoliPertama']."-list'>
													<input type='hidden' class='idanlist' value='".$dta['IdAntrian']."'/>
													<input type='hidden' class='nomorantrian' value='".str_replace(" ","`",$strkdantrian['KodePelayanan'])." - ".$dta['NomorAntrianPoli']."'/>
													<input type='hidden' class='viewnomorantrian' value='".str_replace(" ","",$strkdantrian['KodePelayanan'])." - ".$dta['NomorAntrianPoli']."'/>
													<span>".$dta['NomorAntrian']." - ".$strkdantrian['KodePelayanan']." - ".$dta['PoliPertama']." | ".$dta['NomorAntrianPoli']."</span><button class='btnantrian antrianlistbtn'>
													<i class='ace-icon fa fa-bullhorn'></button></i>
												</li>";
											}	
										}
										?>
									</td>
									<td>
										<?php
										$qryselesai = mysqli_query($koneksi,"select `NomorAntrian`, `PoliPertama`, `NomorAntrianPoli` from `$tbantrian_pasien` WHERE date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Selesai' group by NomorAntrian order by NomorAntrian");
										while($dts = mysqli_fetch_array($qryselesai)){
											$strkdantrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `KodePelayanan` FROM `tbantrian_pelayanan` WHERE Pelayanan = '$dts[PoliPertama]' AND `KodePuskesmas`='$kodepuskesmas'"));
											if(in_array($strkdantrian['KodePelayanan'], $arrpolipanggil)){
											echo "<li class='".$dts['PoliPertama']."-list'>".$dts['NomorAntrian']." - ".$strkdantrian['KodePelayanan']." - ".$dts['PoliPertama']." | ".$dts['NomorAntrianPoli']."</li>";
											}
										}
										?>
									</td>
								</tr>
							</tbody>
							
					</table>
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
			$.post( "get_modal_panggil_antrian_pustu.php?sts=session_set", {namasession:sess,status:'set'});
		}else{
			$.post( "get_modal_panggil_antrian_pustu.php?sts=session_set", {namasession:sess,status:'unset'});
			$('.'+list).hide();
		}
	});

	

	
	$(".selesaibtn").click(function(){
		var loket = '<?php echo $_SESSION['LoketPanggil'];?>';//$(".loketcls").val();
		var idantrian = $(".idantrian").val();

		var viewantrian = $(".viewantrian").text();
		$.post( "get_modal_panggil_antrian_pustu.php?sts=selesai", { id: idantrian, loket:loket, noantrian:viewantrian}).done(function( data ) {
			//alert(data);
			if(data == 'belumselesai'){
				alert("Silahkan klik tombol panggil..");
			}else{
				$('#Modalantrian').modal('hide');
				if(data == 0){
					 document.location.href='index.php?page=registrasi';
				}
			}
		});
	});
	
	$(".pendingbtn").click(function(){
		var loket = '<?php echo $_SESSION['LoketPanggil'];?>';//$(".loketcls").val();
		var idantrian = $(".idantrian").val();
		$.post( "get_modal_panggil_antrian_pustu.php?sts=pending", { id: idantrian, loket:loket}).done(function( data ) {
			$('#Modalantrian').modal('hide');
			if(data == 0){
				 document.location.href='index.php?page=registrasi';
			}
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
		$.post( "get_modal_panggil_antrian_pustu.php?sts=insertdisplay", {noantrian:view_antrian,loket:loket}).done(function( data ) {
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
		$.post( "get_modal_panggil_antrian_pustu.php?sts=insertdisplay", {noantrian:view_antrian,loket:loket}).done(function( data ) {
			console.log(data);
			if(data < 3){
				alert('Silahkan tunggu antrian sebelumnya selesai dipanggil...');
			}
		});	
	});	
</script>
	<?php 
		}
	}
	?>