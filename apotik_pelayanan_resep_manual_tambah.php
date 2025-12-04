<link rel="stylesheet" href="assets/css/bootstrap4-chosen.css" />
<?php
	$kota = $_SESSION['kota'];
	$noresep = $_GET['norsp'];
	$statusloket = $_GET['statusloket'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
	$data_resep = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tbresep` WHERE `NoResep`='$noresep'"));
?>	

<div class="tableborderdiv">
	<div class="row">	
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=apotik_pelayanan_resep&statusloket=<?php echo $statusloket;?>" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>ENTRY RESEP <?php echo "(".strtoupper($statusloket).")";?></b></h3>
			<div class="formbg">
				<form class="form-horizontal" action="index.php?page=apotik_pelayanan_resep_manual_proses" method="post" role="form">
					<table class="table-judul" width="100%">							
						<tr>
							<td class="col-sm-3">Tanggal Resep</td>
							<td class="col-sm-9">
								<?php $tgle = explode("-",date ('Y-m-d')); ?>
								<input type="text" name="tanggalresep" class="form-control datepicker" value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>" readonly><!--panggil clas dari halaman index.php-->
							</td>
						</tr>
						<tr>
							<td>Nama Pasien - Umur</td>
							<td>
								<div class="row">
									<div class="col-sm-2">
										<select class="form-control sumberdata" name="sumberdata">
										<option value="online">Online</option>
										<option value="offline">Offline</option>
									</select>
									</div>
									<div class="col-sm-6">
										<input type="hidden" class="form-control noregistrasi" name="noregistrasi">
										<input type="hidden" class="form-control inputext" name="namapasien" maxlength ="25">
										<select class="form-control chosenselects">	
											<option value="">Pilih</option>										
											<?php
											$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
											$query = mysqli_query($koneksi,"SELECT `NoRegistrasi`,`NoIndex`, `NamaPasien`, `UmurTahun`, `UmurBulan`, `PoliPertama`, `Asuransi` FROM `$tbpasienrj` WHERE date(`TanggalRegistrasi`)=curdate() AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' ORDER BY `NamaPasien`");
												while($data = mysqli_fetch_assoc($query)){
													$alamat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Alamat` FROM `$tbkk` WHERE `NoIndex` = '$data[NoIndex]'"))['Alamat'];
													echo "<option value='$data[NamaPasien]-$data[UmurTahun]-$data[UmurBulan]-$data[PoliPertama]-$data[Asuransi]-$alamat-$data[NoRegistrasi]'>$data[NamaPasien]</option>";			
												}
											?>
										</select>
									</div>
									<div class="col-sm-2">
										<input type="number" name="umurtahun" class="form-control umurtahun" maxlength ="3" placeholder="Tahun" required>	
									</div>
									<div class="col-sm-2">
										<input type="number" name="umurbulan" class="form-control umurbulan" maxlength ="3" placeholder="Bulan" required>	
									</div>
								</div>	
							</td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td>
								<textarea name="alamat" class="form-control alamat" maxlength ="50" required></textarea>
							</td>
						</tr>						
						<tr>
							<td>Asuransi - Pelayanan</td>
							<td>
								<div class="row">
									<div class="col-sm-2">
										<?php
											if($kota == 'KABUPATEN BOGOR'){
										?>
											<select name="asuransi" class="form-control">
												<option value="BPJS">BPJS</option>
												<option value="GRATIS">GRATIS</option>
												<option value="UMUM" SELECTED>UMUM</option>
											</select>
										<?php
											}else{
										?>
											<select name="asuransi" class="form-control asuransi" required>
												<option value="">--Pilih--</option>
												<?php
												$query = mysqli_query($koneksi, "SELECT * FROM `tbasuransi` WHERE Kota = '$kota'");
													while($data = mysqli_fetch_assoc($query)){
														if($data['Asuransi'] == 'UMUM'){
															echo "<option value='$data[Asuransi]' SELECTED>$data[Asuransi]</option>";
														}else{
															echo "<option value='$data[Asuransi]'>$data[Asuransi]</option>";
														}
													}
												?>
											</select>
										<?php
											}
										?>	
									</div>
									<div class="col-sm-8">
										<select name="poli" class="form-control polipertama" required>
											<option value="">--Pilih--</option>
											<?php
											$query = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` WHERE JenisPelayanan = 'KUNJUNGAN SAKIT' order by `Pelayanan`");
												while($data = mysqli_fetch_assoc($query)){
													if($data['Pelayanan'] == 'POLI UMUM'){
														echo "<option value='$data[Pelayanan]' SELECTED>$data[Pelayanan]</option>";
													}else{
														echo "<option value='$data[Pelayanan]'>$data[Pelayanan]</option>";
													}
												}
											?>
										</select>
									</div>	
								</div>	
							</td>	
						</tr>
						<tr>
							<td>Diagnosa</td>
							<td>
								<input type="text" class="form-control diagnosabpjs" style="width: 684px;" placeholder="Ketikan kode / nama diagnosa">
								<input type="hidden" name = "diagnosa" class="form-control kodebpjs">
								<input type="hidden" class="form-control diagnosahiddenbpjs">
								<!--<select name="diagnosa" class="form-control">
									<option value="-">-</option>
									<option value="DIARE">DIARE</option>
									<option value="MYALGIA">MYALGIA</option>
									<option value="ISPA">ISPA</option>
								</select>-->
							</td>	
						</tr>
					</table><br/>

					<table class="table-judul" widtg="100%">
						<thead>
							<tr>
								<th width="9%">Racikan</th>
								<th width="50%">Nama Obat</th>
								<th class="showsth">Signa</th>
								<th width="7%">Jumlah</th>
								<th>Anjuran</th>
								<th width="5%"><i class="fa fa-plus btnadd"></i></th>
							</tr>
						</thead>
						<tbody>		
							<tr class="trclones" style="display: none">
								<td colspan="6">
									<table class="table-judul" style="background: #f5f5f5;margin: 0px">
										<tr>
											<td width="9%">
												<select class="form-control sts_racikan" name="status_racikan[]">
													<option value="false">Tidak</option>
													<!-- <option value="true">Ya</option>										 -->
													<option value="R1">R1</option>										
													<option value="R2">R2</option>										
													<option value="R3">R3</option>										
												</select>
											</td>
											<td width="50%">
												<input type="text" class="form-control therapybpjs">
												<input type="hidden" name="kodebarang[]" class="form-control kodeobatlokal">
												<input type="hidden" name="nobatch[]" class="form-control nobatch">
												<input type="hidden" class="form-control kodeobatbpjs">
												<input type="hidden" name="namaobatbpjs[]" class="form-control namaobatbpjs">
											</td>
											<td class="shows">
												<div class="row">
													<div class="col-sm-6">
														<input type="text" name="signa1[]" class="form-control signa1">						
													</div>
													<div class="col-sm-6">
														<input type="text" name="signa2[]" class="form-control signa2">									
													</div>
												</div>
											</td>
											<td width="7%">
												<input type="text" name="jumlah[]" class="form-control jumlah" maxlength="4">
											</td>
											<td class="shows">
												<select name="anjuran[]" class="form-control anjuranterapi "><!-- chosenselect -->
													<option value="-">--Pilih--</option>
													<option value="Lainnya">Lainnya</option>
													<?php
													$dtanjuranary = mysqli_query($koneksi,"SELECT Anjuran FROM `tbapotikanjuran` ORDER BY Anjuran");
													while($dtanjuran = mysqli_fetch_assoc($dtanjuranary)){
														echo "<option value='$dtanjuran[Anjuran]'>$dtanjuran[Anjuran]</option>";
													}
													?>
												</select>
											</td>
											<td style="display: none;" class="ket_racikantr">
												<input type="text" class="form-control ket_racikan" name="ket_racikan" placeholder="m.f.pulv"/>
											</td>
											<td width="5%" align="center">
												<i class="fa fa-minus btnremove"></i>
											</td>
										</tr>
										<tr style="display: none" class="formanjuranlainnya">
											<td colspan="5"><input type="text" class="form-control anjuranterapilain" name="anjuranterapilain[]"></td>
										</tr>
									</table>
								</td>								
							</tr>
						</tbody>
					</table><br/>
					<div class="row">
						<div class="col-sm-12">
							<input type="hidden" name="idpasienrj" class="form-control" value="<?php echo $idpasienrj;?>">	
							<input type="hidden" name="statusloket" class="form-control" value="<?php echo $statusloket;?>">	
							<button type="submit" class="btn btn-round btn-success btnsimpan">SIMPAN</button>
						</div>
					</div>	
				</form>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/jquery.js"></script>
<script src="assets/js/chosen.js"></script>
<script type="text/javascript">
	$(document).ready(function() {

		var poli;
		poli = $(".polipertama").val();
		$(".polipertama").change(function(){
			poli = $(this).val();
		});

		$('body').on('keydown', 'input, select, textarea', function(e) {
		    var self = $(this)
		      , form = self.parents('form:eq(0)')
		      , focusable
		      , next
		      ;
		    if (e.keyCode == 13) {
		        focusable = form.find('input,a,select,button,textarea').filter(':visible');
		        next = focusable.eq(focusable.index(this)+1);
		        if (next.length) {
		            next.focus();
		        } else {
		            form.submit();
		        }
		        return false;
		    }
		});

		$('.chosenselects').chosen().change(function(){
			var string = $(this).val().split('-');		
			$(".inputext").val(string[0]);
			$(".umurbulan").val(string[2]);
			$(".umurtahun").val(string[1]);
			$(".polipertama").val(string[3]);
			$(".asuransi").val(string[4]);
			$(".alamat").val(string[5]);
			$(".noregistrasi").val(string[6]);
		});
		$('.chosen-container').css({width: "100%"});

		$(".sumberdata").change(function(){
			var isi = $(this).val()
			if(isi == 'offline'){			
				$(".inputext").show();
				$(".inputext").attr("type","text");
				$(".chosenselects").hide();
				$('.chosen-container').hide();	
				$(".inputext").val("");
				$(".umurbulan").val("");
				$(".umurtahun").val("");
				$(".polipertama").val("");
				$(".asuransi").val("");
				$(".alamat").val("");		
			}else{			
				$(".inputext").attr("type","hidden");
				$('.chosen-container').show();
				$(".chosenselects").hide();
				//$(".chosenselects").val("").trigger("liszt:updated");
				$('.chosen-container').show();
			}
		});

		$(".btnadd").click(function(){


			var clon = $(".trclones").clone();
			clon.removeClass("trclones");
			clon.removeAttr("style");
			clon.find(".therapybpjs").prop('required',true);
			clon.find(".signa1").prop('required',true);
			clon.find(".signa2").prop('required',true);
			clon.find(".jumlah").prop('required',true);

			// if($(".sts_racikan").val() == 'R1'){
			// 	var jumlah_first = $(".jumlah").val();
			// 	var ket_racikan_first = $(".ket_racikan").val();
			// 	clon.find(".jumlah").val(jumlah_first);
			// 	clon.find(".ket_racikan").val(ket_racikan_first);
			// }

			$(".trclones").before(clon);
			
			//therapy BPJS
			$('.therapybpjs').autocomplete({
				// serviceUrl: 'get_therapy_manual.php?keyword=/'+poli,
				// serviceUrl: 'get_therapy_manual.php/'+poli,
				serviceUrl: 'get_therapy.php?keyword=',
				onSelect: function (suggestion) {
					$(this).val(suggestion.value);
					$(this).parent().find(".kodeobatbpjs").val(suggestion.kodeobatbpjs);
					$(this).parent().find(".kodeobatlokal").val(suggestion.kodeobatlokal);
					$(this).parent().find(".nobatch").val(suggestion.nobatch);
					$(this).parent().find(".namaobatbpjs").val(suggestion.namaobatbpjs);
					$(this).parent().find(".sediaobatbpjs").val(suggestion.sediaobatbpjs);
				}
			});

			// chosen
			$('.chosenselects').chosen();

			//btnremove
			$(".btnremove").click(function(){
				$(this).parent().parent().parent().remove();
			});

			$(".sts_racikan").change(function(){
				var isi = $(this).val();
				if(isi == 'true' || isi == 'R1' || isi == 'R2' || isi == 'R3'){
					$(this).parent().parent().find(".ket_racikantr").show();
					$(this).parent().parent().find(".shows").hide();
					$(".showsth").hide();
				}else{
					$(this).parent().parent().find(".ket_racikantr").hide();
					$(this).parent().parent().find(".shows").show();
					$(".showsth").show();
				}

				if(isi == 'R1'){
					var thiss = $(this);
					thiss.parent().parent().find(".jumlah").val('');
					thiss.parent().parent().find(".ket_racikan").val('');
					$( ".sts_racikan" ).each(function(index, elem) {
						
						if($(elem).val() == 'R1'){
							//console.log('tes: '+index);
							var jumlah_first = $( ".sts_racikan" ).eq(index).parent().parent().find(".jumlah").val();
							var ket_racikan_first = $( ".sts_racikan" ).eq(index).parent().parent().find(".ket_racikan").val();
							thiss.parent().parent().find(".jumlah").val(jumlah_first);
							thiss.parent().parent().find(".ket_racikan").val(ket_racikan_first);
						}
					});

					
				}else if(isi == 'R2'){
					var thiss = $(this);
					thiss.parent().parent().find(".jumlah").val('');
					thiss.parent().parent().find(".ket_racikan").val('');
					$( ".sts_racikan" ).each(function(index, elem) {
						
						if($(elem).val() == 'R2'){
							//console.log('tes: '+index);
							var jumlah_first = $( ".sts_racikan" ).eq(index).parent().parent().find(".jumlah").val();
							var ket_racikan_first = $( ".sts_racikan" ).eq(index).parent().parent().find(".ket_racikan").val();
							thiss.parent().parent().find(".jumlah").val(jumlah_first);
							thiss.parent().parent().find(".ket_racikan").val(ket_racikan_first);
						}
					});

					
				}else if(isi == 'R3'){
					var thiss = $(this);
					thiss.parent().parent().find(".jumlah").val('');
					thiss.parent().parent().find(".ket_racikan").val('');
					$( ".sts_racikan" ).each(function(index, elem) {
						
						if($(elem).val() == 'R3'){
							//console.log('tes: '+index);
							var jumlah_first = $( ".sts_racikan" ).eq(index).parent().parent().find(".jumlah").val();
							var ket_racikan_first = $( ".sts_racikan" ).eq(index).parent().parent().find(".ket_racikan").val();
							thiss.parent().parent().find(".jumlah").val(jumlah_first);
							thiss.parent().parent().find(".ket_racikan").val(ket_racikan_first);
						}
					});

					
				}else{
					$(this).parent().parent().find(".jumlah").val('');
					$(this).parent().parent().find(".ket_racikan").val('');
				}
			});
			
			$(".anjuranterapi").change(function(){
				if($(this).val() == 'Lainnya'){
					$(".formanjuranlainnya").show();
				}else{
					$(".formanjuranlainnya").hide();
				}
			});

		});

		//therapy BPJS
		$('.therapybpjs').autocomplete({
			// serviceUrl: 'get_therapy.php?keyword=',
			// serviceUrl: 'get_therapy_manual.php/'+poli,
			onSelect: function (suggestion) {
				$(this).val(suggestion.value);
				$(this).parent().find(".kodeobatbpjs").val(suggestion.kodeobatbpjs);
				$(this).parent().find(".kodeobatlokal").val(suggestion.kodeobatlokal);
				$(this).parent().find(".nobatch").val(suggestion.nobatch);
				$(this).parent().find(".namaobatbpjs").val(suggestion.namaobatbpjs);
				$(this).parent().find(".sediaobatbpjs").val(suggestion.sediaobatbpjs);
			}
		});
		
		$('.chosenselect').chosen();
		$('.chosen-container').css({width: "100%"});
	});
</script>	