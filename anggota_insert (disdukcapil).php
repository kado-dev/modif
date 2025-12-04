<?php
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$kota = $_SESSION['kota'];
$tahun=date('Y');
$id = $_GET['noindex'];
$datakk = mysqli_fetch_assoc(mysqli_query($koneksi, "select * from `$tbkk` where `NoIndex` = '$id'"));

?>

<div class="tableborderdiv" style="margin-top: 20px">
	<div class="row">
		<div class="col-xs-12">
			<div class="formbg" style="padding: 30px 30px 20px 40px">
				<div class = "row">
					<p style="line-height: 20px;">
						<!--KK-->
						<span class="editnormtext" style = "font-size:16px;font-weight:bold;color:black">	
							<?php echo $datakk['NamaKK'].", #".substr($id,-10);?>							
						</span><br/>KEPALA KELUARGA<br/>
						<!--Alamat-->
						<?php echo $datakk['Alamat'];?>, RT <?php echo $datakk['RT'];?> RW <?php echo $datakk['RW'];?> NO. <?php echo $datakk['No'];?> KEL. <?php echo strtoupper($datakk['Kelurahan']);?>, KEC. <?php echo strtoupper($datakk['Kecamatan']);?><br/>
						<?php echo $datakk['Kota'];?>
					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="formbg" style="padding: 10px 40px 30px 40px">
				<a href="index.php?page=kk_detail&id=<?php echo $id;?>" class="backform" style="padding-top:20px;"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
				<h3>Data Pasien</h3>
				<!--
				<form>
					<input type="number" name="nik" class="form-control nikkey" title="NIK" maxlength="20" required>
										
				</form>	
			-->
				<hr>
				<div class = "row">
					<form class="form-horizontal" action="index.php?page=anggota_insert_proses" method="post" role="form">
						<table class="table">
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
								<?php }else{ ?>
								
								<?php }?>
							<tr>
								<td class="col-sm-2">NIK</td>
								<td class="col-sm-10">									
									<div class="input-group">
										<input type="number" name="nik" class="form-control nikkey" title="NIK" maxlength="20" required>
										<span class="input-group-addon btn-primary btncarinik" style="cursor: pointer;color:#fff">Cari</span>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Nama Pasien</td>
								<td class="col-sm-10"><input type="text" name="nama" class="form-control namacls" style="text-transform: uppercase;" maxlength="50"></td>
							</tr>
							<tr>
								<td class="col-sm-2">Status Keluarga</td>
								<td class="col-sm-10">
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
											<div class="input-group">
												<span class="input-group-addon tesdate">
													<span class="fa fa-calendar"></span>
												</span>
												<?php
													$tgl = explode("-",date ('1970-m-d'));
												?>
												<input type="text" name="tanggallahir" class="form-control datepicker tgllahir_kkinsert" value="<?php echo $tgl[2]."-".$tgl[1]."-".$tgl[0];?>">
											</div>
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
										<input type="radio" name="jeniskelamin" class="jkcls" value="L" checked>
										Laki-laki
									  </label>
									</div>
									
									<div class="radio">
									  <label>
										<input type="radio" name="jeniskelamin" class="jkcls" value="P">
										Perempuan
									  </label>
									</div>
								
								</td>
							</tr>
							<tr>
								<td>Agama - Status Nikah</td>
								<td>
									<div class="row ">
										<div class="col-sm-6">
											<select name="agama" class="form-control agamacls" required>
												<option value="">--Pilih--</option>
												<option value="BUDHA">BUDHA</option>
												<option value="HINDU">HINDU</option>
												<option value="ISLAM">ISLAM</option>
												<option value="KATHOLIK">KATHOLIK</option>
												<option value="KONGHUCU">KONGHUCU</option>
												<option value="KRISTEN">KRISTEN</option>
											</select>
										</div>
										<div class="col-sm-6">
											<select name="statusnikah" class="form-control statusnikahcls" required>
												<option value="">--Pilih--</option>
												<option value="BELUM MENIKAH">BELUM MENIKAH</option>
												<option value="MENIKAH">MENIKAH</option>
												<option value="JANDA">JANDA</option>
												<option value="DUDA">DUDA</option>
											</select>
										</div>
									</div>
								</td>	
							</tr>
							<tr>
								<td>Pendidikan - Pekerjaan</td>
								<td>
									<div class="row ">
										<div class="col-sm-6">
											<select name="pendidikan" class="form-control pendidikancls" required>
												<option value="">--Pilih--</option>
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
										</div>
										<div class="col-sm-6">
											<select class="form-control pekerjaancls" name="pekerjaan" required>
												<option value="">--Pilih--</option>
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
										</div>
									</div>	
								</td>	
							</tr>
							<tr>
								<td>Asuransi - Status</td>
								<td>
									<div class="row ">
										<div class="col-sm-6">
											<select name="asuransi" class="form-control asuransicls" required>
												<option value="">--Pilih--</option>
												<?php
												$query = mysqli_query($koneksi, "SELECT * FROM `tbasuransi` WHERE Kota = '$kota'");
													while($data = mysqli_fetch_assoc($query)){
														echo "<option value='$data[Asuransi]'>$data[Asuransi]</option>";
													}
												?>
											</select>
										</div>
										<div class="col-sm-6">
											<select name="statusasuransi" class="form-control statusasuransicls" required>
												<option value="">--Pilih--</option>
												<option value="PESERTA">PESERTA</option>
												<option value="ISTRI">ISTRI</option>
												<option value="SUAMI">SUAMI</option>
												<option value="ANAK 1">ANAK 1</option>
												<option value="ANAK 2">ANAK 2</option>
												<option value="ANAK 3">ANAK 3</option>
												<option value="ANAK 4">ANAK 4</option>
												<option value="ANAK >5">ANAK >5</option>
											</select>
										</div>
									</div>	
								</td>	
							</tr>
							<tr>
								<td class="col-sm-2">No.Asuransi</td>
								<td class="col-sm-10"><input type="number" name="noasuransi" class="form-control noasuransicls" placeholder="Selain BPJS isikan angka 0" required></td>
							</tr>
						</table><hr>
						<input type="hidden" name="noindex" value="<?php echo $_GET['noindex'];?>">
						<input type="hidden" name="namakk" value="<?php echo $datakk['NamaKK'];?>">
						<input type="hidden" name="alamatkk" value="<?php echo $datakk['Alamat'];?>">
						<input type="hidden" name="kelurahankk" value="<?php echo $datakk['Kelurahan'];?>">
						<button type="submit" class="btnsimpan">Simpan</button>						
					</form>
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
				
