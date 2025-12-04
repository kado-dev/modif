<?php
	include "config/helper_pasienrj.php";	
	$tahun = date('Y');
	$bulan = date('m');
	$pel = $_GET['pelayanan'];
	$klaster = $_GET['klaster'];
	$petugas = $_GET['petugas'];
	
	if($_GET['sort'] == 'ASC'){
		$sorts = 'DESC';
	}else{
		$sorts = 'ASC';
	}
	
?>
<style>
	.overlay {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: rgba(0, 0, 0, 0.4);
		display: flex;
		justify-content: center;
		align-items: center;
	}
	.tmploadings{
		background:rgba(0, 0, 0, 0.7);
		width:300px;
		color:#fff;
		padding:40px 40px;
		border-radius:12px;
		text-align:center;
		font-size:19px;
	}
	.chosen-container-single .chosen-single{
		height:44px !important;
		line-height:44px !important;
	}
	.btn-group.special{
		display: flex;
	}
	.special .btn{
		flex: 1
	}
</style>

<div class="page-inner py-3">
	
</div>

<div class="page-inner py-3 mt--4">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<h2 class="text-black fw-bold judul">Pemeriksaan Medis	
						<a href="index.php?page=poli&pelayanan=<?php echo $pel?>&status=Antri&tptgl=No" class="btn btn-sm btn-danger btn-round pull-right"><?php echo "Belum entry bulan ini : ".$dt_antri['Jml']." Pasien";?></a>
						<?php 
							// echo str_replace('POLI','LAYANAN',$pel);
							$dt_antri = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan' AND `PoliPertama` = '$pel' AND `StatusPelayanan`='Antri'")); 
						?>
					</h2>
					<form role="form" class="submit">
						<div class="row">
							<input type="hidden" name="page" value="poli"/>
							<?php
								// rujuk internal
								if($_GET['tgl'] == ''){
									$tgl = date('Y-m-d');
								}else{
									$tgl = date('Y-m-d', strtotime($_GET['tgl']));
								}
								$str_rujuk_internal = "SELECT count(`IdPasienrj`) AS Jml FROM tbrujukinternal WHERE date(TanggalRujukan)='$tgl' AND SUBSTRING(NoRujukan,1,11)='$kodepuskesmas' AND `PoliRujukan`='$pel' AND `StatusPemeriksaan`='Rujuk internal'";
								$jml_rujuk_internal = mysqli_fetch_assoc(mysqli_query($koneksi, $str_rujuk_internal));
								if($jml_rujuk_internal['Jml'] != '0'){
									$jumlahinternal = $jml_rujuk_internal['Jml'];
								}
							?>

							<div class="col-sm-3">
								<input type="text" name="tgl" class="form-control inputan tglform" value="<?php echo $_GET['tgl'];?>" placeholder = "Pilih Tanggal">
							</div>

							<div class="col-sm-3">
								<select name="klaster" class="form-control inputan klasterform chosenselects">
									<option value="">--Klaster--</option>
									<option value="">Semua</option>
									<?php
									$query_klaster = mysqli_query($koneksi,"SELECT * FROM `ref_siklushidup` GROUP BY `Klaster`");
										while($dtklaster = mysqli_fetch_assoc($query_klaster)){
											if($dtklaster['Klaster'] == $klaster){
												echo "<option value='$dtklaster[Klaster]' SELECTED>$dtklaster[Klaster]</option>";
											}else{
												echo "<option value='$dtklaster[Klaster]'>$dtklaster[Klaster]</option>";
											}
										}
									?>
								</select>
							</div>

							<div class="col-sm-3">
								<select name="pelayanan" class="form-control inputan pelayananform chosenselects">
									<option value="">--Pelayanan--</option>
									<option value="">Semua</option>
									<?php
									$query = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` WHERE JenisPelayanan = 'KUNJUNGAN SAKIT' order by `Pelayanan`");
										while($dtp = mysqli_fetch_assoc($query)){
											if($dtp['Pelayanan'] == $pel){
												echo "<option value='$dtp[Pelayanan]' SELECTED>$dtp[Pelayanan]</option>";
											}else{
												echo "<option value='$dtp[Pelayanan]'>$dtp[Pelayanan]</option>";
											}
										}
									?>
								</select>
							</div>

							<div class="col-sm-3">
								<select name="petugas" class="form-control inputan petugasform chosenselects">
									<option value="">--Petugas--</option>
									<option value="">Semua</option>
									<?php
									$query = mysqli_query($koneksi, "SELECT * FROM `tbpegawai` WHERE `KodePuskesmas` = '$kodepuskesmas' order by `NamaPegawai`");
										while($dtpg = mysqli_fetch_assoc($query)){
											if($dtpg['NamaPegawai'] == $petugas){
												echo "<option value='$dtpg[NamaPegawai]' SELECTED>$dtpg[NamaPegawai]</option>";
											}else{
												echo "<option value='$dtpg[NamaPegawai]'>$dtpg[NamaPegawai]</option>";
											}
										}
									?>
								</select>
							</div>
						</div>

						<div class="row mb-2 mt-3">
							<div class="col-sm-6">
								<div class="btn-group special" role="group" aria-label="Basic example">
									<button type="button" class="btn btn-outline-secondary btntabforms <?php if($_GET['status'] == 'belumdilayani' || $_GET['status'] == ''){echo 'btn-info';}?>" data-ket="belumdilayani">Antri</button>
									<button type="button" class="btn btn-outline-secondary btntabforms <?php if($_GET['status'] == 'sudahdilayani'){echo 'btn-info';}?>" data-ket="sudahdilayani">Sudah Dilayani</button>
									<button type="button" class="btn btn-outline-secondary btntabforms <?php if($_GET['status'] == 'rujukinternal'){echo 'btn-info';}?>" data-ket="rujukinternal"><span class='badge badge-danger'><?php echo $jumlahinternal;?></span> Rujuk Internal</button>
								</div>
							</div>	
							<div class="col-sm-6">
								<div class="input-group">
									<input class="form-control inputan search namaform" type="text" name="nama" placeholder="Masukan Nama Pasien" value="<?php echo $_GET['nama'];?>">
									<div class="input-append">
										<button type="button" class="sort btn btn-warning buttonsearch" data-sort="username"><span class="fa fa-search"></span></button>
										<a href="?page=poli" class="sort btn btn-info"><span class="fa fa-refresh"></span></a>
									</div>
								</div>
							</div>	
						</div>	
					</form>

					<div class="datalist"></div>
				</div>
			</div>
		</div>	
	</div>	
</div>

<script src="assets/js/jquery.js"></script>
<script src="assets/bootstrapdatepicker/js/bootstrap-datepicker.min.js"></script>
<script src="assets/js/chosen.js"></script>
<script>

	var status = '<?php echo $_GET['status']?>';
	if(status == ''){
		get_data('belumdilayani','');
	}else{
		get_data(status,'');
	}

	
	$('.tglform').datepicker( {
		format: 'dd-mm-yyyy'
    }).on('changeDate', function (ev) {
		var status = $(".btntabforms.btn-info").data("ket");
		get_data(status,'');
	});

	$(".chosenselects").chosen().change( function(){
		var status = $(".btntabforms.btn-info").data("ket");
		get_data(status,'');
	} );

	$('.buttonsearch').click(function(){
		var status = $(".btntabforms.btn-info").data("ket");
		get_data(status,'');
	});

	$('.btntabforms').click(function(){
		$('.btntabforms').removeClass('btn-info');

		$(this).addClass('btn-info');
		var status = $(this).data("ket");//belumdilayani, sudahdilayani, rujukinternal
		get_data(status,'');
	});

	$(document).on("click",".page-a",function() {
		var status = $(".btntabforms.btn-info").data("ket");
		var hal = $(this).data("hal");

		get_data(status,hal);
	});
	
	function get_data(status, hal){
		
		var tglform = $(".tglform").val();
		var klasterform = $(".klasterform").val();
		var pelayananform = $(".pelayananform").val();
		var namaform = $(".namaform").val();
		var petugasform = $(".petugasform").val();

		$(".datalist").html('<div class="overlay"><div class="tmploadings"><i class="fa fa-spinner fa-spin "></i> Memuat data</div></div>');
		
		$.get( "get_data_pemeriksaan.php?status="+status+"&tgl="+tglform+"&klaster="+klasterform+"&pelayanan="+pelayananform+"&petugas="+petugasform+"&nama="+namaform+"&tptgl=&h="+hal).done(function( data ) {
			$(".datalist").html(data);
		});
	}

	//$(".btnprint").dblclick(function(){
	//	var idpasienrj = $(this).data("idrj");
	//	var noregistrasi = $(this).data("noreg");
	//	var pelayanan = $(this).data('pel');		
	//	document.location.href='index.php?page=poli_periksa_print&noreg='+noregistrasi+'&idrj='+idpasienrj+'&pelayanan='+pelayanan;
	//});

	$(".panggilantrian").click(function(){
		var noantrian = $(this).data('noantrian');
		var sts = $(this).data('stsantrian');
		var poli = "<?php echo $_GET['pelayanan'];?>";
		$.get( "get_modal_panggil_antrian_poli.php?noa="+noantrian+"&poli="+poli).done(function( data ) {
			$(".modaltampil").html(data);
			$('#Modalantrian').modal('show');
		});
	});	
	
	$('.chosenselectmod').chosen();
	$('.chosen-container').css({width: "100%"});

</script>

<div class="modaltampil"></div>