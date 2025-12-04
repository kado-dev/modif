<?php
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$namapuskesmas = $_SESSION['namapuskesmas'];
$kota = $_SESSION['kota'];
$tahun=date('Y');
$id = $_GET['noindex'];
$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
$tbpasien = "tbpasien_".str_replace(' ', '', $namapuskesmas);
$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, "select * FROM `$tbkk` WHERE `NoIndex` = '$id'"));
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=kk_detail&id=<?php echo $id;?>" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>TAMBAH ANGGOTA KELUARGA</b></h3>
			<div class="row">
				<div class="col-sm-12">
					<div class="card full-height">
						<div class="card-body">
							<h4 class="judul">
								<i class="icon-user"></i>
								<?php echo $datakk['NamaKK']." - ".substr($datakk['NoIndex'],-10);?>
							</h4>
							<div class="card-category">
								<?php echo $datakk['Alamat']." RT.".$datakk['RT']." RW.".$datakk['RW']." NO.".$datakk['No']." <br/> ".strtoupper($datakk['Kelurahan']);?>, KEC. <?php echo strtoupper($datakk['Kecamatan']).", ".$datakk['Kota'];?><br/>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="card full-height">
				<div class="card-body">
					<h4 class="judul">
						<i class="icon-people"></i>
						INPUT DATA ANGGOTA KELUARGA
					</h4>
					<div class="card-category">
						<form class="form-horizontal formsimpanproses" action="anggota_insert_proses.php" method="post" role="form">
							<table class="table-judul">
								<?php if($kota == "KABUPATEN BULUNGAN"){?>
									<tr>
										<td class="col-sm-3">No.RM</td>
										<td class="row">
											<div class="form-group">
												<div class="col-md-3">
													<select name="norm1" class="form-control poli">
														<option value="01" selected>01 - Umum</option> 
														<option value="02">02 - Lansia</option> 
													</select>
												</div>
												<div class="col-md-4">
													<select name="norm2" class="form-control wilayah-value">
														<option value="01">01 - Tanjung Selor Hulu</option>
														<option value="02">02 - Tanjung Selor Hilir</option>
														<option value="03">03 - Tanjung Selor Timur</option>
														<option value="04">04 - Jelarai</option>
														<option value="05">05 - Tengkapak</option>
														<option value="06">06 - Gn.Seriang / Baratan</option>
														<option value="10">10 - Luar Wilayah</option>		
														<option value="11">11 - SDN</option>		
														<option value="12">12 - SMPN/MTSN</option>		
														<option value="13">13 - SMAN/MAN</option>		
														<option value="14">14 - SMKN</option>		
														<option value="15">15 - KIR KESEHATAN</option>		
														<option value="16">16 - Abjad</option>		
													</select>
												</div>
												<div class="col-md-2">
													<input type="text" name="norm3" value="" class="form-control norm6digit" size="4" maxlength="6" required="">
												</div>
												<a href="#" class="btn btn-sm btn-default btnmodalrm" style="border-radius:20px; text-decoration: none;">Bank RM</a>
											</div>
										</td>
									</tr>
									<?php }elseif(($kota == "KABUPATEN KUTAI KARTANEGARA")){ ?>
									<tr>
										<td class="col-sm-3">No.RM</td>
										<td class="input-group">
											<input type="text" name="norm" class="form-control" maxlength="8" placeholder="Ketik Manual">
											<span class="input-group-addon"><a href="#" class="btnmodalrm">Bank RM</a></span>
										</td>
									</tr>	
									<?php }?>
								<tr>
									<td>NIK</td>
									<td>									
										<div class="input-group">
											<input type="text" name="nik" class="form-control" title="NIK" maxlength="20" required>
										</div>
									</td>
								</tr>
								<tr>
									<td>Nama Pasien</td>
									<td><input type="text" name="nama" class="form-control namacls" style="text-transform: uppercase;" maxlength="50"></td>
								</tr>
								<tr>
									<td>Status Keluarga</td>
									<td>
										<select name="statuskeluarga" class="form-control statuskeluargacls" required>
												<option value="">--Pilih--</option>
												<option value="KEPALA KELUARGA" selected>KEPALA KELUARGA</option>
												<option value="ISTRI">ISTRI</option>
												<option value="ANAK 1">ANAK 1</option>
												<option value="ANAK 2">ANAK 2</option>
												<option value="ANAK 3">ANAK 3</option>
												<option value="ANAK 4">ANAK 4</option>
												<option value="ANAK 5">ANAK 5</option>
												<option value="ANAK 6">ANAK 6</option>
												<option value="ANAK 7">ANAK 7</option>
												<option value="ANAK 8">ANAK 8</option>
												<option value="ANAK 9">ANAK 9</option>
												<option value="ANAK 10">ANAK 10</option>
												<option value="ANAK 11">ANAK 11</option>
												<option value="ANAK 12">ANAK 12</option>
												<option value="ANAK 13">ANAK 13</option>
												<option value="ANAK 14">ANAK 14</option>
												<option value="ANAK 15">ANAK 15</option>
												<option value="ANAK 16">ANAK 16</option>
												<option value="ANAK 17">ANAK 17</option>
												<option value="ANAK 18">ANAK 18</option>
												<option value="ANAK 19">ANAK 19</option>
												<option value="BAPAK">BAPAK</option>
												<option value="IBU">IBU</option>
												<option value="KAKEK">KAKEK</option>
												<option value="NENEK">NENEK</option>
												<option value="CUCU">CUCU</option>	
												<option value="MENANTU">MENANTU</option>
												<option value="MERTUA">MERTUA</option>
												<option value="SAUDARA KANDUNG">SAUDARA KANDUNG</option>
												<option value="KEPONAKAN">KEPONAKAN</option>
												<option value="PONDOK PESANTREN">PONDOK PESANTREN</option>
												<option value="ANAK SEKOLAH">ANAK SEKOLAH</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Tanggal Lahir</td>
									<td>
										

										<div class="row ">
											<div class="col-sm-6">
												<?php $tgl = explode("-",date ('1970-m-d')); ?>
												<input type="text" name="tanggallahir" class="form-control datepicker tgllahir_kkinsert" value="<?php echo $tgl[2]."-".$tgl[1]."-".$tgl[0];?>">
											</div>
											<div class="col-sm-6">
												<input type="text" class="form-control umur_kkinsert" readonly>
											</div>
										</div>	
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">Jenis Kelamin</td>
									<td class="col-sm-10">
										<div class="radio">
											<label>
											<input type="radio" name="jeniskelamin" class="jkcls" value="0" checked>
											Tidak Diketahui
											</label>&nbsp&nbsp

											<label>
											<input type="radio" name="jeniskelamin" class="jkcls" value="L" checked>
											Laki-laki
											</label>&nbsp&nbsp
										
											<label>
											<input type="radio" name="jeniskelamin" class="jkcls" value="P">
											Perempuan
											</label>&nbsp&nbsp

											<label>
											<input type="radio" name="jeniskelamin" class="jkcls" value="3">
											Tidak Dapat Ditentukan
											</label>&nbsp&nbsp

											<label>
											<input type="radio" name="jeniskelamin" class="jkcls" value="4">
											Tidak Mengisi
											</label>
										</div>
									</td>
								</tr>
								<tr>
									<td>Agama</td>
									<td>
										<select name="agama" class="form-control agamacls" required>
											<option value="ISLAM">ISLAM</option>
											<option value="BUDHA">BUDHA</option>
											<option value="HINDU">HINDU</option>
											<option value="KATHOLIK">KATHOLIK</option>
											<option value="KONGHUCU">KONGHUCU</option>
											<option value="KRISTEN">KRISTEN</option>
										</select>
									</td>	
								</tr>
								<tr>
									<td>Status Nikah</td>
									<td>
										<select name="statusnikah" class="form-control statusnikahcls" required>
											<option value="BELUM MENIKAH">BELUM MENIKAH</option>
											<option value="MENIKAH">MENIKAH</option>
											<option value="JANDA">JANDA</option>
											<option value="DUDA">DUDA</option>
										</select>
									</td>	
								</tr>
								<tr>
									<td>Pendidikan</td>
									<td>
										<select name="pendidikan" class="form-control pendidikancls" required>
											<option value="BELUM SEKOLAH">BELUM SEKOLAH</option>
											<option value="TK">TK</option>
											<option value="SD">SD</option>
											<option value="SLTP">SLTP</option>
											<option value="SLTA">SLTA</option>
											<option value="D1">D1</option>
											<option value="D2">D2</option>
											<option value="D3">D3</option>
											<option value="S1">S1</option>
											<option value="S2">S2</option>
											<option value="S3">S3</option>
											<option value="TIDAK SEKOLAH">TIDAK SEKOLAH</option>
										</select>
									</td>	
								</tr>
								<tr>
									<td>Pekerjaan</td>
									<td>
										<select class="form-control pekerjaancls" name="pekerjaan" required>
											<option value="BELUM BEKERJA">BELUM BEKERJA</option>
											<option value="BURUH">BURUH</option>
											<option value="GURU">GURU</option>
											<option value="HONORER">HONORER</option>
											<option value="IRT">IRT</option>
											<option value="MAHASISWA">MAHASISWA</option>
											<option value="NELAYAN">NELAYAN</option>
											<option value="PEGAWAI SWASTA">PEGAWAI SWASTA</option>
											<option value="PELAJAR">PELAJAR</option>
											<option value="PENSIUN">PENSIUN</option>
											<option value="PETANI">PETANI</option>
											<option value="PNS">PNS</option>
											<option value="POLRI">POLRI</option>
											<option value="TNI">TNI</option>
											<option value="TKI">TKI</option>
											<option value="WIRASWASTA">WIRASWASTA</option>
										</select>
									</td>	
								</tr>
								<tr>
									<td>Asuransi</td>
									<td>
										<select name="asuransi" class="form-control asuransicls" required>
											<option value="">--Pilih--</option>
											<?php
											$query = mysqli_query($koneksi, "SELECT * FROM `tbasuransi`");
												while($data = mysqli_fetch_assoc($query)){
													echo "<option value='$data[Asuransi]'>$data[Asuransi]</option>";
												}
											?>
										</select>
									</td>	
								</tr>
								<tr>
									<td>Status</td>
									<td>
										<select name="statusasuransi" class="form-control statusasuransicls" required>
											<option value="PESERTA">PESERTA</option>
											<option value="ISTRI">ISTRI</option>
											<option value="SUAMI">SUAMI</option>
											<option value="ANAK 1">ANAK 1</option>
											<option value="ANAK 2">ANAK 2</option>
											<option value="ANAK 3">ANAK 3</option>
											<option value="ANAK 4">ANAK 4</option>
											<option value="ANAK >5">ANAK >5</option>
										</select>
									</td>	
								</tr>
								<tr>
									<td class="col-sm-2">No.Asuransi</td>
									<td class="col-sm-10"><input type="number" name="noasuransi" class="form-control noasuransicls" placeholder="Selain BPJS isikan angka 0" required></td>
								</tr>
								<tr>
									<td class="col-sm-2">Telpon</td>
									<td class="col-sm-10"><input type="number" name="telpon" class="form-control" value="0" required></td>
								</tr>
							</table><hr>
							<input type="hidden" name="noindex" value="<?php echo $_GET['noindex'];?>">
							<input type="hidden" name="namakk" value="<?php echo $datakk['NamaKK'];?>">
							<input type="hidden" name="alamatkk" value="<?php echo $datakk['Alamat'];?>">
							<input type="hidden" name="kelurahankk" value="<?php echo $datakk['Kelurahan'];?>">
							<button type="submit" class="btn btn-round btn-success btnsimpan btnsimpanproses">SIMPAN</button>						
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="hasilmodal result">
	
</div>
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>
$(document).ready(function() {
	var tgllahir = $(".tgllahir_kkinsert").val();
	$.post( "get_umur.php", { 
		tgllahir: tgllahir
	}).done(function( data ) {
		$(".umur_kkinsert").val(data);
	});
});

$("body").click(function(){
	var tgllahir = $(".tgllahir_kkinsert").val();
	$.post( "get_umur.php", { 
		tgllahir: tgllahir
	}).done(function( data ) {
		$(".umur_kkinsert").val(data);
	});
});

$(".btncarinik").click(function(){
	var nik = $(".nikkey").val();
	$.get( "get_datacasip_jquery.php?nik="+nik, function( data ) {
		var obj = JSON.parse(data);
	  	$( ".namacls" ).val( obj.content[0].NAMA_LGKP );
	  	var tgllahirs = obj.content[0].TGL_LHR.split('-');

	  	$( ".tgllahir_kkinsert" ).val(tgllahirs[2]+'-'+tgllahirs[1]+'-'+tgllahirs[0]);
	  	$.post( "get_umur.php", { 
			tgllahir: tgllahirs[2]+'-'+tgllahirs[1]+'-'+tgllahirs[0]
		}).done(function( data ) {
			$(".umur_kkinsert").val(data);
		});
		if(obj.content[0].JENIS_KLMIN == 'Laki-Laki'){
			$(".jkcls[value='L']").prop('checked',true);
		}else{
			$(".jkcls[value='P']").prop('checked',true);
		}
		$( ".agamacls" ).val( obj.content[0].AGAMA );
		if(obj.content[0].STAT_HBKEL == "ANAK"){
			$( ".statuskeluargacls" ).val("ANAK 1");
		}else{
			$( ".statuskeluargacls" ).val(obj.content[0].STAT_HBKEL);
		}			
	  	
	  	$( ".pendidikancls" ).val( obj.content[0].PDDK_AKH.split('/')[0] );
	  	if(obj.content[0].JENIS_PKRJN == 'MENGURUS RUMAH TANGGA'){
	  		$( ".pekerjaancls" ).val( "IRT" );
	  	}else{
	  		$( ".pekerjaancls" ).val( obj.content[0].JENIS_PKRJN.split('/')[0] );
	  	}
	  		
	  	$( ".statusnikahcls" ).val( obj.content[0].STATUS_KAWIN.replace("KAWIN", "MENIKAH") );

	  	var varasuransi = '';
	  	if(nik.substring(0, 4) == '<?php echo substr($kodepuskesmas, 1,4);?>'){
	  		varasuransi = 'GRATIS';
	  	}else{
	  		varasuransi = 'UMUM';
	  	}

	  	$( ".asuransicls" ).val(varasuransi);
	  	$(".statusasuransicls").val('PESERTA');
		$(".noasuransicls").val('0');

	});
});


</script>



				
