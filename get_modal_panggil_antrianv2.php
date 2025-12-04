<?php

	$sts = $_GET['sts'];
	if($sts == 'selesai'){
		$loket = $_POST['loket'];
		if($_SESSION['loket'] == null){
			$_SESSION['loket'] = $loket;
		}	
		$id = $_POST['id'];
		$nomorantrian = $_POST['noantrian'];
		
		$disps = $nomorantrian."|".$loket;
		
		//cek kode
		$strr = "SELECT * from tbantrian_view where DisplayUtama LIKE '$disps'";
		
		$cekdisplayutama = mysqli_num_rows(mysqli_query($koneksi,$strr));
		if($cekdisplayutama == 1){;
		mysqli_query($koneksi,"UPDATE `tbantrian_pasienv2` SET `StatusAntrian`='Selesai' WHERE `IdAntrianv2` = '$id'");
		
		if($loket == 'loket 1'){
			$disp = 'DisplaySatu';
		}else if($loket == 'loket 2'){
			$disp = 'DisplayDua';
		}else if($loket == 'loket 3'){
			$disp = 'DisplayTiga';
		}else if($loket == 'loket 4'){
			$disp = 'DisplayEmpat';
		}
		
		mysqli_query($koneksi,"UPDATE `tbantrian_view` SET `DisplayUtama`= '', `$disp`= '$nomorantrian' where `KodePuskesmas` = '$kodepuskesmas' ");
		//display antiran
		
		$qry = mysqli_query($koneksi,"select * from `tbantrian_pasienv2` where date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` != 'Selesai' order by NomorAntrian");
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
		mysqli_query($koneksi,"UPDATE `tbantrian_pasienv2` SET `StatusAntrian`='Pending' WHERE `IdAntrianv2` = '$id'");
		
		mysqli_query($koneksi,"UPDATE `tbantrian_view` SET `DisplayUtama`= '' where `KodePuskesmas` = '$kodepuskesmas' ");
		//display antiran
		
		$qry = mysqli_query($koneksi,"select * from `tbantrian_pasienv2` where date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` != 'Selesai' order by NomorAntrian");
		echo mysqli_num_rows($qry);
		
	}else if($sts == 'cekdata'){
		$qry = mysqli_query($koneksi,"select * from `tbantrian_pasienv2` where date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` != 'Selesai' order by NomorAntrian");
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
		mysqli_query($koneksi,"UPDATE `tbantrian_view` SET `$disp`='',`DisplayUtama`= '$nomorantrian|$loket' where `KodePuskesmas` = '$kodepuskesmas' ");
	}else if($sts == 'session_set'){
		$namasession = $_POST['namasession'];
		$sts = $_POST['status'];
		if($sts == 'set'){
			$_SESSION[$namasession] = $namasession;
		}else{
			unset($_SESSION[$namasession]);
		}
		
	}else{
		$qry = mysqli_query($koneksi,"select * from `tbantrian_pasienv2` where date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Antri' order by NomorAntrian Limit 1");
		if(mysqli_num_rows($qry) == 0){
			$qry = mysqli_query($koneksi,"select * from `tbantrian_pasienv2` where date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Pending' order by NomorAntrian Limit 1");
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
</style>
<div class="modal fade noprint" id="Modalantrian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Panggil Antrian</h4>
			</div>
	  
			<div class="modal-body">
				<input type="hidden" class="idantrian" value="<?php echo $dt['IdAntrianv2']?>">
				
				
					<h3 style="text-align:center;margin:10px 0px">
						<span style="font-size:18px">Nomor Antrian</span><br/>
						<span style="font-size:39px" class="viewantrian"><?php echo $dt['NomorAntrian'];?></span>
						<span class="noantriancls" style="display:none"><?php echo $dt['NomorAntrian'];?></span>
					</h3>
					<div class="row">
						<div class="col-md-7">
							<select name="loket" class="form-control loketcls">
								<option value="loket 1" <?php if($_SESSION['loket'] == 'loket 1'){echo "SELECTED";}?>>loket 1</option>
								<option value="loket 2" <?php if($_SESSION['loket'] == 'loket 2'){echo "SELECTED";}?>>loket 2</option>
								<option value="loket 3" <?php if($_SESSION['loket'] == 'loket 3'){echo "SELECTED";}?>>loket 3</option>
								<option value="loket 4" <?php if($_SESSION['loket'] == 'loket 4'){echo "SELECTED";}?>>loket 4</option>
							</select>
																			
							<label><input type="checkbox" class="bpjs-ck"  <?php if($_SESSION['bpjs-ck'] == 'bpjs-ck'){echo "CHECKED";}?>>BPJS </label>
							<label><input type="checkbox" class="umum-ck"  <?php if($_SESSION['umum-ck'] == 'umum-ck'){echo "CHECKED";}?>>UMUM </label>
						</div>	
						<div class="col-md-5">
							<a href="#" class="btn btn-primary pull-right selesaibtn btns">Selesai</a>
							<a href="#" class="btn btn-danger pull-right pendingbtn btns" style="margin-right:5px">Pending</a>
							<a href="#" class="btn btn-success pull-right panggilbtn btns" style="margin-right:5px"><i class='ace-icon fa fa-bullhorn'></i>Panggil</a>
						</div>
					</div>
				<div class="dataview" style="margin-top:10px;height:350px;overflow:auto">
					<table class="table table-condensed table-bordered">
						<tr>
							<th style="text-align:center">Pending</th>
							<th style="text-align:center">Antri</th>
							<th style="text-align:center">Selesai</th>
						</tr>
						<tr>
							<td>
								<?php
								$qrypending = mysqli_query($koneksi,"select * from `tbantrian_pasienv2` where date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Pending' order by NomorAntrian");
								while($dtp = mysqli_fetch_array($qrypending)){
									$strkdantrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `KodePelayanan` FROM `tbantrian_pelayanan` where Pelayanan = '$dtp[PoliPertama]'"));
									echo "<li class='".$dtp['CaraBayar']."-list'>
											<input type='hidden' class='idanlist' value='".$dtp['IdAntrianv2']."'/>
											<input type='hidden' class='nomorantrian' value='".$dtp['NomorAntrian']."'/>
											<input type='hidden' class='viewnomorantrian' value='".$dtp['NomorAntrian']."'/>
											<span>".$dtp['CaraBayar']." - ".$dtp['NomorAntrian']."</span><button class='btnantrian pendinglistbtn'>
											<i class='ace-icon fa fa-bullhorn'></button></i>
										</li>";
								}
								?>
							</td>
							<td>
								<?php
								$qryantri = mysqli_query($koneksi,"select * from `tbantrian_pasienv2` where date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Antri' order by NomorAntrian");
								while($dta = mysqli_fetch_array($qryantri)){
									$strkdantrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `KodePelayanan` FROM `tbantrian_pelayanan` where Pelayanan = '$dta[PoliPertama]'"));
									//echo "<li>".$dta['NomorAntrian']." - ".$dta['PoliPertama']."</li>";
									echo "<li class='".$dta['CaraBayar']."-list'>
											<input type='hidden' class='idanlist' value='".$dta['IdAntrianv2']."'/>
											<input type='hidden' class='nomorantrian' value='".$dta['NomorAntrian']."'/>
											<input type='hidden' class='viewnomorantrian' value='".$dta['NomorAntrian']."'/>
											<span>".$dta['CaraBayar']." - ".$dta['NomorAntrian']."</span><button class='btnantrian antrianlistbtn'>
											<i class='ace-icon fa fa-bullhorn'></button></i>
										</li>";
								}
								?>
							</td>
							<td>
								<?php
								$qryselesai = mysqli_query($koneksi,"select * from `tbantrian_pasienv2` where date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Selesai' order by NomorAntrian");
								while($dts = mysqli_fetch_array($qryselesai)){
									$strkdantrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `KodePelayanan` FROM `tbantrian_pelayanan` where Pelayanan = '$dts[PoliPertama]'"));
									echo "<li class='".$dts['CaraBayar']."-list'>".$dts['CaraBayar']." - ".$dts['NomorAntrian']."</li>";
								}
								?>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	
		var bpjsck = $(".bpjs-ck").prop( "checked" );
		if(bpjsck == true){
			$('.BPJS-list').show();
		}else{
			$('.BPJS-list').hide();
		}
		var umumck = $(".umum-ck").prop( "checked" );
		if(umumck == true){
			$('.UMUM-list').show();
		}else{
			$('.UMUM-list').hide();
		}
	
	


	$(".bpjs-ck").click(function(){
		var ini = $(this).prop( "checked" );
		if(ini == true){
			$('.BPJS-list').show();
			$.post( "get_modal_panggil_antrian.php?sts=session_set", {namasession:'bpjs-ck',status:'set'});
		}else{
			$.post( "get_modal_panggil_antrian.php?sts=session_set", {namasession:'bpjs-ck',status:'unset'});
			$('.BPJS-list').hide();
		}
	});

	$(".umum-ck").click(function(){
		var ini = $(this).prop( "checked" );
		if(ini == true){
			$.post( "get_modal_panggil_antrian.php?sts=session_set", {namasession:'umum-ck',status:'set'});
			$('.UMUM-list').show();
		}else{
			$.post( "get_modal_panggil_antrian.php?sts=session_set", {namasession:'umum-ck',status:'unset'});
			$('.UMUM-list').hide();
		}
	});



	
	$(".panggilbtn").click(function(){
		var loket = $(".loketcls").val();
		var antrian = $(".noantriancls").text();
		var viewantrian = $(".viewantrian").text();
		// responsiveVoice.speak("Nomor Antrian "+antrian+" Ke "+loket,"Indonesian Female", {rate: 0.7});
		$.post( "get_modal_panggil_antrian.php?sts=insertdisplay", {noantrian:viewantrian,loket:loket});
	});	
	
	$(".selesaibtn").click(function(){
		var loket = $(".loketcls").val();
		var idantrian = $(".idantrian").val();
		var viewantrian = $(".viewantrian").text();
		$.post( "get_modal_panggil_antrian.php?sts=selesai", { id: idantrian, loket:loket, noantrian:viewantrian}).done(function( data ) {
			// alert(data);
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
		var loket = $(".loketcls").val();
		var idantrian = $(".idantrian").val();
		$.post( "get_modal_panggil_antrian.php?sts=pending", { id: idantrian, loket:loket}).done(function( data ) {
			$('#Modalantrian').modal('hide');
			if(data == 0){
				 document.location.href='index.php?page=registrasi';
			}
		});
	});
	
	$(".pendinglistbtn").click(function(){
		var loket = $(".loketcls").val();
		var view_antrian = $(this).parent().find(".viewnomorantrian").val();
		var antrian = $(this).parent().find(".nomorantrian").val();
		var idantrian = $(this).parent().find(".idanlist").val();
		
		$(".viewantrian").text(view_antrian);
		$(".idantrian").val(idantrian);
		$(".noantriancls").text(antrian);
		// responsiveVoice.speak("Nomor Antrian "+antrian+" Ke "+loket,"Indonesian Female", {rate: 0.7});
		$.post( "get_modal_panggil_antrian.php?sts=insertdisplay", {noantrian:view_antrian,loket:loket});
	});	
	
	
	$(".antrianlistbtn").click(function(){
		var loket = $(".loketcls").val();
		var view_antrian = $(this).parent().find(".viewnomorantrian").val();
		var antrian = $(this).parent().find(".nomorantrian").val();
		var idantrian = $(this).parent().find(".idanlist").val();
		
		$(".viewantrian").text(view_antrian);
		$(".idantrian").val(idantrian);
		$(".noantriancls").text(antrian);
		// responsiveVoice.speak("Nomor Antrian "+antrian+" Ke "+loket,"Indonesian Female", {rate: 0.7});
		$.post( "get_modal_panggil_antrian.php?sts=insertdisplay", {noantrian:view_antrian,loket:loket});
	});	
</script>
	<?php 
		}
	?>