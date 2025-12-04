<?php
error_reporting(1);
include "config/helper_pasienrj.php";
?>

<style type="text/css">
	body{
		overflow-y:auto;
	}
	.leftdiv{
		background: #fff;
		padding:5px;
		height:70vh;
	}
	.rightdiv{
		background: #fff;
		padding:5px;
	}
	.leftdiv h4, .rightdiv h4{
		font-size:15px;
	}
	
	.box-search{
		margin-top:12px;
		border-radius:8px;
		border:2px solid #ddd;
		padding:7px;
	}
	.box-search > input, .box-search > select{
		margin-bottom:5px;
	}
	.divsampling{
		margin-top:12px;
		border-radius:8px;
		border:2px solid #ddd;
		padding:7px;
		height:80vh;
		overflow-y:auto;
		overflow-x:hidden;
	}
	.divsampling a{
		font-weight:bold;
		color:#444;
		display:block;
		padding:5px 10px;
		border-left:2px solid transparent;
	}
	.divsampling .active{
		/*border-left:2px solid #b7b2b2;*/
		background:#fce055 !important;
	}
	.divsampling a:nth-child(even) {background: #ddd}
	.divsampling a:nth-child(odd) {background: #f5f5f5}
	.divsampling a:hover{
		text-decoration:none;
		color:#000;
	}
	.box-kets{
		margin-top:12px;
		border-radius:8px;
		border:2px solid #ddd;
		padding:7px;
		font-weight:bold;
	}
	.formtbl{
		border:0px;background:transparent;height:25px;width:100%;margin:0px;
	}
	.tblperiksa th{
		background:#589ef4;padding:6px 2px;color:#fff;border:1px solid #ccc;
	}
	.tblperiksa td{
		padding:5px 6px;border:1px solid #ccc;
	}
	.tblperiksa tbody tr:nth-child(even) {background: #fff}
	.tblperiksa tbody tr:nth-child(odd) {background: #eee}
	.badge{
		color:#fff!important;font-size:11px!important;padding:3px 8px;margin-left:7px;
	}
	
</style>
<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-2">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white fw-bold mt-2"><i class="icon-people"></i> Nurse Station</h2>
			</div>
			<!-- <div class="ml-md-auto py-2 py-md-0">
				
			</div> -->
		</div>
	</div>
</div>
<div class="page-inner">
	<div class="card mt-2 mb--2">
		<div class="card-body">
			<div class="row mt-3">
				<div class="col-sm-2">
					<div class="leftdiv">
						<form method="get">
							<input type="text" name="key" class="form-control keyform" placeholder="Kata kunci" minlength="2">
							<div class="row">		
								<div class="col-xl-12">		
									<div class="box-search">
										<input type="text" name="tgl" class="form-control tglform" value="<?php echo ($_GET['tgl'] == '') ? date('d-m-Y') : $_GET['tgl'];?>" placeholder="Tanggal" minlength="2">
										<select name="parameter" class="form-control parameterform">
											<option value="">--Layanan--</option>
											<option value="POLI ANAK">ANAK</option>
											<option value="POLI GIGI">GIGI</option>
											<option value="POLI INFEKSIUS">INFEKSIUS</option>
											<option value="POLI KIR">KIR</option>
											<option value="POLI KIA">KIA</option>
											<option value="POLI KB">KB</option>
											<option value="POLI LANSIA">LANSIA</option>
											<option value="POLI PROLANIS">PROLANIS</option>
											<option value="POLI SCREENING">SCREENING</option>
											<option value="POLI TB DOTS">TB DOTS</option>
											<option value="POLI UMUM">UMUM</option>
										</select>	
										<select name="status" class="form-control statusform">
											<option value="">--Status Entry--</option>
											<option value="Antri" SELECTED>Belum</option>
											<option value="Proses">Sudah</option>											
										</select>
									</div>
								</div>
							</div>	
						</form>
						<div class="divsampling">
							<?php	
							// $str = "SELECT IdPasienrj, TanggalRegistrasi, NoRegistrasi, NoIndex, NamaPasien, JenisKelamin, UmurTahun, UmurBulan,
							// UmurHari, Asuransi, StatusPelayanan, PoliPertama, NoKunjunganBpjs, NoAntrianPoli, StatusAntrianPoli, AsalPasien, 
							// StatusPulang
							// FROM `$tbpasienrj`
							// WHERE date(TanggalRegistrasi) = '".date('Y-m-d')."' AND `AsalPasien`='10' AND StatusPelayanan = 'Antri'";
							// echo $str;

							$str = "SELECT `IdPasienrj`, `TanggalRegistrasi`, `NoRegistrasi`, `NoIndex`, `NamaPasien`, `JenisKelamin`, 
							`UmurTahun`, `UmurBulan`, `UmurHari`, `Asuransi`, `StatusPelayanan`, `PoliPertama`, `NoKunjunganBpjs`, `NoAntrianPoli`, 
							`StatusAntrianPoli`,`AsalPasien`, `StatusPulang`, `Klaster`, `SiklusHidup`
							FROM `$tbpasienrj`
							WHERE date(`TanggalRegistrasi`) = '".date('Y-m-d')."' AND `StatusPelayanan` = 'Antri' AND `AsalPasien`='10' AND `StatusPasien`='1'";
							// echo $str;
														
							$query = mysqli_query($koneksi,$str);
							if(mysqli_num_rows($query) > 0){
								$n = 0;
								while($data = mysqli_fetch_assoc($query)){
									$n++;
							?>
								<a href="#" data-idreg="<?php echo $data['IdPasienrj'];?>" class="<?php echo ($n == 1) ? 'active' : ''?>">
									<?php echo strtoupper($data['NamaPasien']);?><br/>
									<?php echo str_replace('POLI','PELAYANAN',$data['PoliPertama']);?><br/>
									<?php echo $data['Klaster'];?><br/>
									<?php echo $data['SiklusHidup'];?><br/>
									<?php echo $data['TanggalRegistrasi'];?><br/>
									<span class="badgeinfo"><?php echo $data['StatusPelayanan'];?></span>
								</a>
							<?php
								}
							}else{
								echo "<a href='#'>Tidak ada data</a>";
							}
							?>
						</div>
					</div>
					
				</div>
				<div class="col-sm-10">
					<div class="rightdiv">
						<button class="btn btn-primary btn-round btnprevs">Prev</button>
						<button class="btn btn-primary btn-round btnnexts">Next</button>
						<div class="loadtmpisihasil" style="height:20px;padding:5px"></div>
						<div class="tmpisihasil"></div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>

<script src="assets/js/jquery-2.1.4.min.js"></script>
<script src="assets/bootstrapdatepicker/js/bootstrap-datepicker.min.js"></script>
<script>
	
	get_form_input();

	$(document).on('click', '.divsampling a', function(){
		$(".loadtmpisihasil").html('Memuat data...');
		$('.divsampling a').removeClass('active');
		$(this).addClass('active');
		get_form_input();
	});

	$(document).on('click', '.btnprevs', function(){
		var currents = $('.divsampling .active');
		$(".loadtmpisihasil").html('Memuat data...');
		currents = currents.prev();
		if(currents.data('idreg')){
			$('.divsampling a').removeClass('active');
			currents.addClass('active');
			get_form_input();
		}else{
			$(".loadtmpisihasil").html('');
		}
	});
	$(document).on('click', '.btnnexts', function(){
		var currents = $('.divsampling .active');
		$(".loadtmpisihasil").html('Memuat data...');
		currents = currents.next();
		if(currents.data('idreg')){
			$('.divsampling a').removeClass('active');
			currents.addClass('active');
			get_form_input();
		}else{
			$(".loadtmpisihasil").html('');
		}
	});
	
	$(document).on('click', '.btnsimpanperiksa2', function(e){
		e.preventDefault();

		var heartrate = $(".heartrate").val();
		if(heartrate == ''){
			titles = 'Gagal';
			types = 'danger';
			$.notify({
				icon: 'flaticon-chat',
				title: titles,
				message: 'Heartrate belum diisi, jangan isi angka 0 tidak akan bridging ke PCare..'
			},{
				type: types,
			});
			return false;
		}else if(heartrate <= 30){
			titles = 'Gagal';
			types = 'danger';
			$.notify({
				icon: 'flaticon-chat',
				title: titles,
				message: 'Gagal Simpan! Kriteria input Heart Rate : 30-160'
			},{
				type: types,
			});
			return false;
		}else if(heartrate >= 160){
			titles = 'Gagal';
			types = 'danger';
			$.notify({
				icon: 'flaticon-chat',
				title: titles,
				message: 'Gagal Simpan! Kriteria input Heart Rate : 30-160'
			},{
				type: types,
			});
			return false;	
		}

		var resprate = $(".resprate").val();
		if(resprate == ''){
			titles = 'Gagal';
			types = 'danger';
			$.notify({
				icon: 'flaticon-chat',
				title: titles,
				message: 'Resprate belum diisi, jangan isi angka 0 tidak akan bridging ke PCare...'
			},{
				type: types,
			});
			return false;
		}else if(resprate <= 5){
			titles = 'Gagal';
			types = 'danger';
			$.notify({
				icon: 'flaticon-chat',
				title: titles,
				message: 'Gagal Simpan! Kriteria input Resp. Rate : 5-80'
			},{
				type: types,
			});
			return false;
		}else if(resprate >= 80){
			titles = 'Gagal';
			types = 'danger';
			$.notify({
				icon: 'flaticon-chat',
				title: titles,
				message: 'Gagal Simpan! Kriteria input Resp. Rate : 5-80'
			},{
				type: types,
			});
			return false;
		}		

		var formData = $("#forminputhasil").serializeArray();
		$.post( "nurse_station_periksa_proses.php", formData).done(function( data ) {
			//alert(data);
			//console.log('rer: '+data);
			
			titles = 'Gagal';
			types = 'danger';
			if(data == 'sukses'){
				var titles = 'Sukses';
				var types = 'success';

				get_form_input();
				get_list_sidebar($(".keyform").val(),$(".tglform").val(),$(".parameterform").val(),$(".statusform").val());
			}
			$.notify({
				icon: 'flaticon-chat',
				title: titles,
				message: data
			},{
				type: types,
			});
		});
	});

	$(document).on('click', '.btnundoform', function(e){
		e.preventDefault();
		$(".formtbl").val('');
	});


	$('.keyform').keyup(delay(function (e) {
	  get_list_sidebar($(".keyform").val(),$(".tglform").val(),$(".parameterform").val(),$(".statusform").val());
	}, 500));


	$('.tglform').datepicker({
		format: 'dd-mm-yyyy',
		autoclose: true
	}).on('change', function(){
        get_list_sidebar($(".keyform").val(),$(".tglform").val(),$(".parameterform").val(),$(".statusform").val());
    });
	$(document).on('change', '.parameterform, .statusform', function(e){
		get_list_sidebar($(".keyform").val(),$(".tglform").val(),$(".parameterform").val(),$(".statusform").val());
	});

	function get_list_sidebar(key,tgl,prm,sts){
		$.get( "nurse_station_listside.php?key="+key+"&tgl="+tgl+"&parameter="+prm+"&status="+sts).done(function( data ) {
			$(".divsampling").html(data);
			get_form_input();
		});
	}


	function delay(callback, ms) {
	  var timer = 0;
	  return function() {
	    var context = this, args = arguments;
	    clearTimeout(timer);
	    timer = setTimeout(function () {
	      callback.apply(context, args);
	    }, ms || 0);
	  };
	}

	$(document).ready(function() {
	  $(window).keydown(function(event){
	    if(event.keyCode == 13) {
	      event.preventDefault();
	      return false;
	    }
	  });
	});

	function get_form_input(){
		var idpasienrj = $('.divsampling .active').data('idreg');
		$.get( "nurse_station_get.php?id="+idpasienrj).done(function( data ) {
			$(".tmpisihasil").html(data);
			$(".loadtmpisihasil").html('');
		});
	}
</script>