<?php
	//error_reporting(0);
	session_start();
	//$_SESSION['LoketPanggil'] = 'loket 1';
	include "config/koneksi.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	
	$tbantrian_farmasi = "tbantrian_farmasi_".str_replace(' ', '', $namapuskesmas);
	//$tbwaktupelayanan = "tbwaktupelayanan_".$kodepuskesmas;

	
	$sts = $_GET['sts'];
	if($sts == 'selesai'){
		$loket = $_POST['loket'];	
		$_SESSION['loket'] = $loket;		
		
		$id = $_POST['id'];
		//select berdasarkan id
		$dtantrian = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT NomorAntrian FROM $tbantrian_farmasi WHERE `IdAntrianFarmasi`='$id'"));
		
		//update waktu panggil
		//mysqli_query($koneksi,"UPDATE `$tbwaktupelayanan` SET `PanggilAntrian`=NOW() WHERE `NomorAntrianPoli` = '$dtantrian[NomorAntrianPoli]' AND PoliPertama = '$dtantrian[PoliPertama]'");

		$disps = $dtantrian['NomorAntrian'];
		
		//cek kode
		$strr = "SELECT * FROM tbantrian_farmasi_view WHERE `KodePuskesmas`='$kodepuskesmas' AND `DisplayUtama` LIKE '$disps%'";
		$cekdisplayutama = mysqli_num_rows(mysqli_query($koneksi,$strr));
		if($cekdisplayutama == 1){
			mysqli_query($koneksi,"UPDATE `$tbantrian_farmasi` SET `StatusAntrian`='Selesai' WHERE `IdAntrianFarmasi` = '$id'");
			
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


			mysqli_query($koneksi,"UPDATE `tbantrian_farmasi_view` SET `DisplayUtama`= '', `$disp`= '$nomorantrian', `Waktu` = '$time' WHERE `KodePuskesmas`='$kodepuskesmas'");
			//display antiran
			
			$qry = mysqli_query($koneksi,"select * from `$tbantrian_farmasi` where date(WaktuAntrian) = curdate() AND `KodePuskesmas`='$kodepuskesmas' AND `StatusAntrian` != 'Selesai' order by NomorAntrian");
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
		mysqli_query($koneksi,"UPDATE `$tbantrian_farmasi` SET `StatusAntrian`='Pending' WHERE `IdAntrianFarmasi` = '$id'");

		$time = date('Y-m-d H:i:s');
		mysqli_query($koneksi,"UPDATE `tbantrian_farmasi_view` SET `DisplayUtama`= '', `Waktu` = '$time' where `KodePuskesmas` = '$kodepuskesmas' ");
		//display antiran
		
		$qry = mysqli_query($koneksi,"select * from `$tbantrian_farmasi` where date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` != 'Selesai' order by NomorAntrian");
		echo mysqli_num_rows($qry);
	}else if($sts == 'refresh'){
		$time = date('Y-m-d H:i:s');
		mysqli_query($koneksi,"UPDATE `tbantrian_farmasi_view` SET `Waktu` = '$time' where `KodePuskesmas` = '$kodepuskesmas' ");
	}else if($sts == 'cekdata'){
		$qry = mysqli_query($koneksi,"select * from `$tbantrian_farmasi` where date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` != 'Selesai' order by NomorAntrian");
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
		$dtwaktu = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Waktu` from `tbantrian_farmasi_view` where `KodePuskesmas` = '$kodepuskesmas'"));
		$selisih = strtotime($time) - strtotime($dtwaktu['Waktu']);

		//jika lebih dari 30 detik baru panggil lagi/yg baru
		// if($selisih > 3){
			mysqli_query($koneksi,"UPDATE `tbantrian_farmasi_view` SET `$disp`='$nomorantrian',`DisplayUtama`= '$nomorantrian', `Waktu` = '$time' where `KodePuskesmas` = '$kodepuskesmas'"); //AND `DisplayUtama` = ''(query yg lama)
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
		mysqli_query($koneksi,"UPDATE `$tbantrian_farmasi` SET `StatusBpjs`='Selesai' WHERE `IdAntrianFarmasi` = '$id'");
		echo "1";
	}else{
		$qry = mysqli_query($koneksi,"select * from `$tbantrian_farmasi` where date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Antri' order by NomorAntrian Limit 1");
		if(mysqli_num_rows($qry) == 0){
			$qry = mysqli_query($koneksi,"select * from `$tbantrian_farmasi` where date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Pending' order by NomorAntrian Limit 1");
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
		margin-left:5px;
		border:none;
	}
	.btns{
		border-radius:6px;
	}
	/* .table thead tr th{
		padding:10px;background: #d8d8d8;border-bottom: 1px solid #ddd;
	}*/
</style>
<div class="modal fade noprint" id="Modalantrian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">PANGGIL ANTRIAN FARMASI</h4>
			</div>
	  
			<div class="modal-body">
				<input type="hidden" class="idantrian" value="<?php echo $dt['IdAntrian']?>">
				
					<h3 style="text-align:center;margin:10px 0px">
						<span style="font-size:18px">Nomor Antrian</span><br/>
						<span style="font-size:39px" class="viewantrian"><?php echo $dt['NomorAntrian']?></span>
						<span class="noantriancls" style="display:none"><?php echo $dt['NomorAntrian']?></span>
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
							
						</table>
						<div class="col-sm-4">
							<a href="#" class="btn btn-success btn-block selesaibtn btns">Selesai</a>
						</div>
						<div class="col-sm-4">
						<a href="#" class="btn btn-danger btn-block pendingbtn btns" style="margin-right:5px">Pending</a>
						</div>
						<div class="col-sm-4">
						<a href="#" class="btn btn-primary btn-block refreshbtn btns" style="margin-right:5px">Reload View Antrian</a>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="dataview" style="margin-top:10px;height:350px;overflow:auto">
								<table class="table table-condensed table-bordered" width="350px">
										<thead>
											<tr>
												<th style="text-align:center">Antri</th>
												<th style="text-align:center">Pending</th>
												<th style="text-align:center;">Selesai</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<?php
													$qryantri = mysqli_query($koneksi,"SELECT `IdAntrianFarmasi`,`NomorAntrian` FROM `$tbantrian_farmasi` WHERE date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Antri' group by NomorAntrian order by NomorAntrian");
													while($dta = mysqli_fetch_array($qryantri)){
														
														echo "<li class='list'>
																<input type='hidden' class='idanlist' value='".$dta['IdAntrianFarmasi']."'/>
																<input type='hidden' class='nomorantrian' value='".$dta['NomorAntrian']."'/>
																<input type='hidden' class='viewnomorantrian' value='".$dta['NomorAntrian']."'/>
																<span>No ".$dta['NomorAntrian']."</span>
																<button class='btnantrian antrianlistbtn'><i class='ace-icon fa fa-bullhorn'></button></i>
															</li>";
														
													}
													?>
												</td>
												<td>
													<?php
													
													$qrypending = mysqli_query($koneksi,"SELECT `IdAntrianFarmasi`,`NomorAntrian` FROM `$tbantrian_farmasi` WHERE date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Pending' group by NomorAntrian order by NomorAntrian");
													while($dtp = mysqli_fetch_array($qrypending)){
														
														echo "<li class='list'>
																<input type='hidden' class='idanlist' value='".$dtp['IdAntrianFarmasi']."'/>
																<input type='hidden' class='nomorantrian' value='".$dtp['NomorAntrian']."'/>
																<input type='hidden' class='viewnomorantrian' value='".$dtp['NomorAntrian']."'/>
																<span>No ".$dtp['NomorAntrian']."</span><button class='btnantrian pendinglistbtn'>
																<i class='ace-icon fa fa-bullhorn'></i></button>
															</li>";
														
													}
													?>
												</td>
												<td>
													<?php
													$qryselesai = mysqli_query($koneksi,"SELECT `IdAntrianFarmasi`,`NomorAntrian` FROM `$tbantrian_farmasi` WHERE date(WaktuAntrian) = curdate() AND `KodePuskesmas` = '$kodepuskesmas' AND `StatusAntrian` = 'Selesai' group by NomorAntrian order by NomorAntrian");
													while($dts = mysqli_fetch_array($qryselesai)){
													
														echo "<li class='list'>No ".$dts['NomorAntrian']."</li>";
														
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
			$.post( "get_modal_panggil_antrian_farmasi.php?sts=session_set", {namasession:sess,status:'set'});
		}else{
			$.post( "get_modal_panggil_antrian_farmasi.php?sts=session_set", {namasession:sess,status:'unset'});
			$('.'+list).hide();
		}
	});
	
	$(".selesaibtn").click(function(){
		var loket = '<?php echo $_SESSION['LoketPanggil'];?>';//$(".loketcls").val();
		var idantrian = $(".idantrian").val();
		var viewantrian = $(".viewantrian").text();
		$.post( "get_modal_panggil_antrian_farmasi.php?sts=selesai", { id: idantrian, loket:loket, noantrian:viewantrian}).done(function( data ) {
			// alert(data);
			if(data == 'belumselesai'){
				alert("Silahkan klik tombol panggil...");
			}else{
				$('#Modalantrian').modal('hide');
				if(data == 0){
					 document.location.href='index.php?page=apotik_pelayanan_resep&statusloket=LOKET OBAT';
				}
			}
		});
	});
	
	$(".pendingbtn").click(function(){
		var loket = '<?php echo $_SESSION['LoketPanggil'];?>';//$(".loketcls").val();
		var idantrian = $(".idantrian").val();
		$.post( "get_modal_panggil_antrian_farmasi.php?sts=pending", { id: idantrian, loket:loket}).done(function( data ) {
			$('#Modalantrian').modal('hide');
			if(data == 0){
				 document.location.href='index.php?page=apotik_pelayanan_resep&statusloket=LOKET OBAT';
			}
		});
	});

	$(".refreshbtn").click(function(){
		$.post( "get_modal_panggil_antrian_farmasi.php?sts=refresh").done(function( data ) {
			$('#Modalantrian').modal('hide');
			// if(data == 0){
			// 	 document.location.href='index.php?page=apotik_pelayanan_resep&statusloket=LOKET OBAT';
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
		$.post( "get_modal_panggil_antrian_farmasi.php?sts=insertdisplay", {noantrian:view_antrian,loket:loket}).done(function( data ) {
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
		$.post( "get_modal_panggil_antrian_farmasi.php?sts=insertdisplay", {noantrian:view_antrian,loket:loket}).done(function( data ) {
			console.log(data);
			// if(data < 3){
				// alert('Silahkan tunggu antrian sebelumnya selesai dipanggil...');
			// }
		});	
	});	


	$(".applistbtn").click(function(){
		var idantrian = $(this).parent().data("idantrian");
		$.post( "get_modal_panggil_antrian_farmasi.php?sts=update_sts_bpjs", {idantrian:idantrian}).done(function( data ) {
			console.log(data);
			$('#Modalantrian').modal('hide');
		});	
	});	
</script>
	<?php 
		}
	
	?>