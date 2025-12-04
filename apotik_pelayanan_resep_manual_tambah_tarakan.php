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
		<div class="col-xs-12">
			<a href="index.php?page=apotik_pelayanan_resep&statusloket=<?php echo $statusloket;?>" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
			<h3 class="judul"><b>ENTRY RESEP <?php echo "(".strtoupper($statusloket).")";?></b></h3>
			<div class="formbg" style="padding: 30px 50px 50px 50px;">
				<div class = "row">
					<form class="form-horizontal" action="index.php?page=apotik_pelayanan_resep_manual_proses" method="post" role="form">
						<table class="table">							
							<tr>
								<td class="col-sm-3">Tanggal Resep</td>
								<td class="col-sm-9">
									<div class="input-group">
										<span class="input-group-addon tesdate">
											<span class="fa fa-calendar"></span>
										</span>
										<?php
											$tgle = explode("-",date ('Y-m-d'));
										?>
										<input type="text" name="tanggalresep" class="form-control datepicker" value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>" readonly><!--panggil clas dari halaman index.php-->
									</div>
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
												$query = mysqli_query($koneksi,"SELECT `NoRegistrasi`,`NoIndex`, `NamaPasien`, `UmurTahun`, `UmurBulan` FROM `$tbpasienrj` WHERE `TanggalRegistrasi`=curdate() AND SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' ORDER BY `NamaPasien`");
													while($data = mysqli_fetch_assoc($query)){
														$alamat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Alamat` FROM `$tbkk` WHERE `NoIndex` = '$data[NoIndex]'"))['Alamat'];
														echo "<option value='$data[NamaPasien]-$data[UmurTahun]-$data[UmurBulan]-$alamat-$data[NoRegistrasi]'>$data[NamaPasien]</option>";			
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
						</table>
						<hr>
						<table class="table-judul">
							<thead>
								<tr>
									<th width="9%">RACIKAN</th>
									<th width="50%">NAMA OBAT</th>
									<th class="showsth">SIGNA</th>
									<th width="7%">JUMLAH</th>
									<th>ANJURAN</th>
									<th width="5%"><i class="fa fa-plus btnadd"></i></th>
								</tr>
							</thead>
							<tbody>		
								<tr class="trclones" style="display: none">
									<td colspan="6">
										<table class="table" style="background: #f5f5f5;margin: 0px">
											<tr>
												<td width="9%">
													<select class="form-control sts_racikan" name="status_racikan[]">
														<option value="false">Tidak</option>
														<option value="true">Ya</option>										
													</select>
												</td>
												<td width="50%">
													<input type="text" class="form-control therapybpjs">
													<input type="hidden" name="kodebarang[]" class="form-control kodeobatlokal">
													<input type="hidden" name="nobatch[]" class="form-control nobatch">
													<input type="hidden" class="form-control kodeobatbpjs">
													<input type="hidden" class="form-control namaobatbpjs">
												</td>
												<td class="shows">
													<div class="col-sm-6">
														<input type="text" name="signa1[]" class="form-control signa1">						
													</div>
													<div class="col-sm-6">
														<input type="text" name="signa2[]" class="form-control signa2">									
													</div>
												</td>
												<td width="7%">
													<input type="text" name="jumlah[]" class="form-control jumlah" maxlength="4">
												</td>
												<td class="shows">
													<select name="anjuran[]" class="form-control anjuranterapi">
														<option value="-">--Pilih--</option>
														<option value="Lainnya">Lainnya</option>
														<?php
														$dtanjuranary = mysqli_query($koneksi,"SELECT Anjuran FROM `tbapotikanjuran`");
														while($dtanjuran = mysqli_fetch_assoc($dtanjuranary)){
															echo "<option value='$dtanjuran[Anjuran]'>$dtanjuran[Anjuran]</option>";
														}
														?>
													</select>
												</td>
												<td style="display: none;" class="ket_racikantr">
													<input type="text" class="form-control ket_racikan" name="ket_racikan" placeholder="m.f.pulv"/>
												</td>
												<td  width="5%" align="center">
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
						</table>
						<hr/>
						<div class="row">
							<div class="col-sm-12">
								<input type="hidden" name="statusloket" class="form-control" value="<?php echo $statusloket;?>">	
								<button type="submit" class="btnsimpan">SIMPAN</button>
							</div>
						</div>						
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/jquery.js"></script>
<script src="assets/js/chosen.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
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
				if(isi == 'true'){
					$(this).parent().parent().find(".ket_racikantr").show();
					$(this).parent().parent().find(".shows").hide();
					$(".showsth").hide();
				}else{
					$(this).parent().parent().find(".ket_racikantr").hide();
					$(this).parent().parent().find(".shows").show();
					$(".showsth").show();
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