<style>
	.btnlengkung{
		border-radius:20px;
	}
	.bggreen{
		background:green;
		padding:15px 40px;
		min-height:650px;
	}
	.btns{
		height: 3vw;font-size: 1.3vw;
	}
	.formpuskesmas{
		margin-bottom: 10px;
	}
	.formpuskesmas input{
		border-radius: 15px; width: calc(100% - 90px) !important;
	}
	.listpuskesmas{
		width: 100%;margin-bottom: 0px;
	}
	.listpuskesmas tr td{
		padding:2px;
	}
	.listpuskesmas tr td input{
			padding:0.6vw;font-size: 1.4vw;height: 3vw;
	}
	.formselect{
		height: 3vw;font-size: 1.4vw;
	}

</style>
<?php
	$nik = $_GET['id'];
	$jk = $_GET['jk'];
	$str1 = "SELECT * FROM `tbpasien` WHERE `Nik` = '$nik' or `NoIndex` LIKE '%$nik' or `NoRM` = '$nik'";
	$query = mysqli_query($koneksi, $str1);
	$data = mysqli_fetch_assoc($query);
	$kodepuskesmas = substr($data['NoIndex'],2,11);
	$tbpasien = "tbpasien_".substr($data['NoIndex'],14,4);
	$datapkmpasien = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbpuskesmas WHERE `KodePuskesmas` = '".$kodepuskesmas."'"));
?>
		<form action="registrasi_proses.php" method="post" id="forminti">
		<div class="kolomkonten" style="margin-top: -20px">
			
 			<input type="hidden" name="nik" value="<?php echo $data['Nik'];?>"/>
			<input type="hidden" name="jk" value="<?php echo $jk;?>"/>
			<input type="hidden" name="kodepuskesmas" class="kodepuskesmascls" value="<?php echo $kodepuskesmas;?>"/>
			<input type="hidden" name="nama" class="form-control" value="<?php echo $data['NamaPasien'];?>"readonly>
			<input type="hidden" value="<?php echo date('Y-m-d');?>" class="form-control" readonly/>
			<table class="listpuskesmas">
				<tr>
					<td>Puskesmas</td>
					<td  width="6%">:</td>
					<td>
						<input type="text" class="form-control namapuskesmascls" value="<?php echo $datapkmpasien['NamaPuskesmas'];?> " readonly/>
					</td>
					<td>
						<a href="#" class="btn btn-info btns btn-lg pull-right btnshowmodal">Ganti</a>
					</td>
				</tr>
		
				<tr>
					<td>Cara Bayar</td>
					<td>:</td>
					<td colspan="2">
						<select name="asuransi" class="form-control formselect" required>
							<option value="">--Pilih--</option>
							<?php
							$query = mysqli_query($koneksi,"SELECT * FROM `tbasuransi` order by `Asuransi`");
							while($data1 = mysqli_fetch_assoc($query)){
								if($data1['Asuransi'] != 'BPJS NON PBI' and $data1['Asuransi'] != 'BPJS PBI'){
									echo "<option value='$data1[Asuransi]'>$data1[Asuransi]</option>";
								}
							}
							?>
						</select>
					</td>
				</tr>
				<!--
				<tr>
					<td>Poli Tujuan</td>
					<td>:</td>
					<td colspan="2">
						<select name="polipertama" class="form-control formselect" required>
							<option value="">--Pilih--</option>
							<?php
							$query = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` WHERE `Status`='DAFTAR ONLINE' order by `Pelayanan`");
								while($data2 = mysqli_fetch_assoc($query)){
									if($data2['Pelayanan'] == $_SESSION['poliantrian']){
										echo "<option value='$data2[Pelayanan]' SELECTED>$data2[Pelayanan]</option>";
									}else{
										echo "<option value='$data2[Pelayanan]'>$data2[Pelayanan]</option>";
									}
								}
							?>
						</select>
					</td>
				</tr>
					-->
			</table>
		</div>
		<div class="kolomkonten3">
			<?php
			$query = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` WHERE `Status`='DAFTAR ONLINE' order by `Pelayanan`");
				while($data2 = mysqli_fetch_assoc($query)){
					if($data2[Pelayanan] == 'POLI LABORATORIUM'){
						echo "<label class='lbl'><img src='image/logo_puskesmas.png'><input type='radio' name='polipertama' value='$data2[Pelayanan]'>LAB</label>";
					}else{
						echo "<label class='lbl'><img src='image/logo_puskesmas.png'><input type='radio' name='polipertama' value='$data2[Pelayanan]'>".str_replace("POLI","", $data2[Pelayanan])."</label>";
					}					
				}
			?>
		</div>
		<div class="kolomkonten2">			
				<!--<a href="?page=cari_pasien&id=<?php echo $data['Nik'];?>" class="btn btn-info btn-big btns">Kembali</a>-->
				<button type="button" class="btn btn-primary btn-lg btn-block btns btnsimpan">Simpan</button>
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
			$dt = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `Kota` = 'KABUPATEN BANDUNG' ORDER by NamaPuskesmas Limit 5");
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

<script>

	$(document).on("click", ".btnsimpan", function() {	
		var poli = $("input[name='polipertama']:checked").length;//$("input[name='polipertama']:checked").val();
		var asuransi = $("select[name='asuransi']").val();
		
		if(asuransi == ''){
			alert('Silahkan pilih cara bayar terlebih dahulu!');
		}else{		
			if(poli == 0){
				alert('Silahkan pilih poli terlebih dahulu!');
			}else{
				$("#forminti").submit();
			}
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