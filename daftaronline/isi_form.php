<style>
	.btnsearch{
		font-size: 1.2vw;font-weight: 400;padding:0.6vw;
	}
	.form-group{
		margin-top:0;margin-bottom: 0
	}

	.inputcss{
		padding:0.6vw;font-size: 1.4vw;height: 3vw;margin-bottom: 6px
	}
	.formselect{
		height: 3vw;font-size: 1.4vw;margin-bottom: 6px
	}
	.col-form-label{
		font-weight: 400;padding-top: 1.3vh
	}

@media (max-width: 576px) {
	body{
		overflow: auto;
	}
	.btns{
		font-size: 3.5vw;font-weight: 400;padding:1.7vw;height: 40px;
	}
	.btnsearch{
		font-size: 3.2vw;font-weight: 400;padding:1.7vw;
	}
	.form-group{
		margin-top:0;margin-bottom: 0
	}
	.col-form-label{
		font-size: 3vw;margin:0;padding-top: 2px
	}
	.namapuskesmascls{
		font-size: 3.4vw;height: 40px;padding: 10px;color: #545454;margin-bottom: 1vh
	}
	.formselect{
		font-size: 3.4vw;height: 40px;color: #545454
	}
	.datepickers{
		font-size: 3.4vw;height: 40px;color: #545454
	}
	.inputcss{
		font-size: 3.4vw;height: 40px;color: #545454
	}
}
</style>
<?php
	$id = $_GET['id'];
	$key = $_GET['key'];
	$kodpuskesmas = $_GET['kode'];
	$namapuskesmas = $_GET['simpus'];
	$tbpasien = 'tbpasien_'.str_replace(' ', '', $namapuskesmas);

	if(strlen($key) == 13){//bpjs
		$str1 = "SELECT * FROM `$tbpasien` WHERE `NoAsuransi` = '$key'";
		$query = mysqli_query($koneksi, $str1);
		$data = mysqli_fetch_assoc($query);
		$asuransi = 'BPJS';
	}else if(strlen($key) == 16){
		$str1 = "SELECT * FROM `$tbpasien` WHERE `Nik` = '$key'";
		$query = mysqli_query($koneksi, $str1);
		$data = mysqli_fetch_assoc($query);	

		if(strpos($key, "3204") == 0){
			$asuransi = 'GRATIS';
		}else{
			$asuransi = 'UMUM';
		}
	}else{
		$str1 = "SELECT * FROM `$tbpasien` WHERE `IdPasien` = '$id'";
		$query = mysqli_query($koneksi, $str1);
		$data = mysqli_fetch_assoc($query);	

		if(strpos($key, "3204") == 0){
			$asuransi = 'GRATIS';
		}else{
			$asuransi = 'UMUM';
		}
	}

	// tbpasien_tahun
	$tbpasien = 'tbpasien_'.str_replace(' ', '', $namapuskesmas);
	$dtpasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbpasien` WHERE `IdPasien` = '$id'"));
			
	// tbpuskesmas
	$kodepuskesmas = $_GET['kode'];
	$dtpuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '".$kodepuskesmas."'"));
	$puskesmas = $dtpuskesmas['NamaPuskesmas'];

	$getdatasetting = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbantrian_setting` WHERE KodePuskesmas = '$kodepuskesmas'"));
?>

		<form action="registrasi_proses.php" method="post" id="forminti">
			<div class="kolomkonten" style="margin-top: 0px">			
	 			<input type="hidden" name="nik" value="<?php echo $dtpasien['Nik'];?>"/>
				<input type="hidden" name="jk" value="<?php echo $dtpasien['JenisKelamin'];?>"/>
				<input type="hidden" name="tgllhr" value="<?php echo $dtpasien['TanggalLahir'];?>"/>
				<input type="hidden" name="kodepuskesmas" class="kodepuskesmascls" value="<?php echo $kodepuskesmas;?>"/>
				<input type="hidden" name="nama" class="form-control" value="<?php echo $dtpasien['NamaPasien'];?>" readonly>
				<input type="hidden" name="idpasien" value="<?php echo $dtpasien['IdPasien'];?>" class="form-control" readonly>
				<input type="hidden" name="noindex" value="<?php echo $dtpasien['NoIndex'];?>" class="form-control" readonly>
				
				<div class="form-group row">
				    <label for="staticEmail" class="col-sm-3 col-form-label">Puskesmas</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control namapuskesmascls inputcss" value="<?php echo $puskesmas;//$datapkmpasien['NamaPuskesmas'];?> " readonly/>
				    </div>
				</div>
				<div class="form-group row">
				    <label for="staticEmail" class="col-sm-3 col-form-label">Tanggal</label>
				    <div class="col-sm-9">
				      <input type="text" name="tanggal" value="<?php //echo date('Y-m-d');?>" placeholder="Tanggal" class="form-control inputcss datepickers"/>
				    </div>
				</div>
				<div class="form-group row">
				    <label for="inputPassword" class="col-sm-3 col-form-label">Cara Bayar</label>
				    <div class="col-sm-9">
				      <select name="asuransi" class="form-control formselect asuransicls" required>
						<option value="">--Pilih--</option>
						<?php
						echo "<option value='BPJS'>BPJS</option>";
						$query = mysqli_query($koneksi,"SELECT * FROM `tbasuransi` order by `Asuransi` ASC");
						while($data1 = mysqli_fetch_assoc($query)){
							if($data1['Asuransi'] != 'BPJS NON PBI' and $data1['Asuransi'] != 'BPJS PBI'){
								echo "<option value='$data1[Asuransi]'>$data1[Asuransi]</option>";
							}
						}

						?>
					</select>
				    </div>
				</div>
				<div class="form-group row" id="nokartu" style="display: none;">
				    <label for="staticEmail" class="col-sm-3 col-form-label">No. Kartu</label>
				    <div class="col-sm-9">
				      <input type="text" name="nokartu" class="form-control nokartucls inputcss"/>
				    </div>
				</div>
			</div>
			<div class="kolomkonten3">
				<?php
				$query = mysqli_query($koneksi, "SELECT * FROM `tbantrian_pelayanan` WHERE (KuotaOnline > 0 AND Pelayanan != '') AND KodePuskesmas = '$kodepuskesmas' order by `Pelayanan`");
					while($data2 = mysqli_fetch_assoc($query)){
						// belumbisa
						// $kuotaonline = $data2['KuotaOnline'];

						if($data2['Pelayanan'] == 'POLI LABORATORIUM'){
							echo "<label class='lbl'><img src='../image/logo_puskesmas.png'><input type='radio' name='polipertama' value='POLI $data2[Pelayanan]'>LAB</label>";
						}else{
							echo "<label class='lbl'><img src='../image/logo_puskesmas.png'><input type='radio' name='polipertama' value='POLI $data2[Pelayanan]'>".$data2['Pelayanan']."</label>";
						}					
					}
				?>
			</div>
			<div class="kolomkonten2">			
					<!--<a href="?page=cari_pasien&id=<?php echo $dtpasien['Nik'];?>" class="btn btn-info btn-big btns">Kembali</a>-->
					<button type="button" class="btn btn-primary btn-lg btn-block btns btnsimpan">SIMPAN</button>
			</div>
		</form>
<div class="modal fade" id="modalpuskesmas" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Pilih Puskesmas</h3>
    
      </div>
      <div class="modal-body">
		<form style="display:flex">
			<input type="text" name="key" id="keypus" placeholder="Ketikan nama puskesmas" class="form-control forminputs"/>
			<button type="button" class="btn btn-info btns" id="btncaripus">Cari</button>
		</form>
		<table class="table tablecaripus" style="margin-top:20px">
			<tr>
				<th>Nama Puskesmas</th>
				<th width="80px">Aksi</th>
			</tr>
			<?php
			$dt = mysqli_query($koneksi,"SELECT * FROM tbpuskesmas WHERE Kota = 'KABUPATEN BANDUNG' ORDER by NamaPuskesmas Limit 5");
			while($dtpus = mysqli_fetch_array($dt)){
			?>
			<tr>
				<td style="vertical-align:middle"><?php echo $dtpus['NamaPuskesmas'];?></td>
				<td>
					<a href="#" data-kodepus="<?php echo $dtpus['KodePuskesmas'];?>" data-namapus="<?php echo $dtpus['NamaPuskesmas'];?>" class="btn btn-info btns btn-lg btnpilihpuskesmas">Pilih</a>
				</td>
			</tr>
			<?php
			}
			?>
		</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script src="../assets/bootstrapdatepicker/js/bootstrap-datepicker.min.js"></script>
<?php
if(strtotime($getdatasetting['WaktuPelayananTutup']) > time()){
?>
<script>
	$('.datepickers').datepicker({
		format: 'yyyy-mm-dd',
		startDate: '7d',
		endDate: '+7d'
	});
</script>
<?php
}else{
?>
<script>
	$('.datepickers').datepicker({
		format: 'yyyy-mm-dd',
		startDate: '7d',
		endDate: '+7d'
	});

	$(document).on("change", ".datepickers", function() {	
		if($(".datepickers").val() == '<?php echo date('Y-m-d');?>'){
			alert('Waktu pelayanan hari ini sudah tutup!');
			$(".datepickers").val('');
			return false;
		}
	});
</script>
<?php }?>

<script>
	$(document).on("click", ".btnsimpan", function() {	
		var poli = $("input[name='polipertama']:checked").length;//$("input[name='polipertama']:checked").val();
		var asuransi = $("select[name='asuransi']").val();
		
		if($(".datepickers").val() == ''){
			alert('Silahkan isi tanggal terlebih dahulu!');
			//$(".datepickers").val('<?php echo date('Y-m-d');?>');
			return false;
		}	

		if(asuransi == ''){
			alert('Silahkan pilih cara bayar terlebih dahulu!');
		}else{		
			if(poli == 0){
				alert('Silahkan pilih poli terlebih dahulu!');
			}else{
				if(asuransi == 'BPJS'){
					if($(".nokartucls").val() == ''){
						alert('Silahkan isi no kartu bpjs terlebih dahulu!');
						return false;
					}else{
						if($(".nokartucls").val().length < 13){
							alert('No kartu bpjs tidak valid!');
							return false;
						}
					}
				}				
				$("#forminti").submit();
			}
		}		
	});

	$(document).on("change", ".asuransicls", function() {	
		var is = $(this).val();
		if(is == 'BPJS'){
			$("#nokartu").show();
			$('#nokartu').keypress(function (event) {
			    var keycode = event.which;
			    var value = Number(event.target.value + event.key) || 0;
			   	if(value.toString().length <= 13){
				    if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
				        event.preventDefault();
				    }
				}else{
					event.preventDefault();
				}
			});
		}else{
			$("#nokartu").hide();
		}
	});

	$(document).on("click", ".btnshowmodal", function() {	
		$("#modalpuskesmas").modal("show");
	});
	$(document).on("click", ".lbl", function() {
	$(".lbl").removeClass("active");	
		$(this).addClass("active");
	});

	$(document).on("click", ".btnpilihpuskesmas", function() {
		var kode = $(this).data('kodepus');
		var namapus = $(this).data('namapus');
		
		$(".kodepuskesmascls").val(kode);
		$(".namapuskesmascls").val(namapus);
		
		$("#modalpuskesmas").modal("hide");
	});
	
	$(document).on("click", "#btncaripus", function() {	
		var key = $("#keypus").val();	
		$(".tablecaripus").html("Memuat...");
		$.post( "jquery_caripuskesmas.php", { key: key })
		  .done(function( data ) {
			$(".tablecaripus").html(data);
		  });
	});
	
</script>