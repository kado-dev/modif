<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	$kel = $_POST['kel'];
	$nolab = $_POST['nolab'];
	$str = "SELECT IdTindakan, JenisTindakan, Tarif FROM `tbtindakan` WHERE `KelompokTindakan` = '$kel' order by JenisTindakan ASC";
	$query = mysqli_query($koneksi,$str);
	$data = mysqli_fetch_assoc($query);

?>
<!--untuk menampilkan modal-->
<div class="modal fade" id="modallab1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"><?php echo strtoupper($kel);?></h4>
			</div>
			<div class="modal-body">
				<div class="row">	
					<div class="col-lg-12">
						<div class="table-responsive">
							<table class="table-judul" width="100%">
								<thead>
									<tr>
										<th width="5%">No.</th>
										<th width="70%">Nama Pemeriksaan</th>
										<th width="15%">Tarif</th>
										<th width="10%">Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php			 					
									
									$no = 0;
									$query = mysqli_query($koneksi,$str);
									while($data = mysqli_fetch_assoc($query)){
									?>
										<tr>
											<td width="5%" align="right"><?php echo $no = $no + 1;?></td>
											<td width="70%" align="Left"><?php echo $data['JenisTindakan'];?></td>
											<td width="20%" align="right"><?php echo rupiah($data['Tarif']);?></td>
											<td width="5%" align="right">
												<input type="checkbox" name="pemeriksaan" class="pemeriksaancls" value="<?php echo $data['IdTindakan'];?>">
											</td>
										</tr>
									
									<?php
										}

										if($kel == 'Urine Lengkap' || $kel == 'Darah Lengkap'){
									?>
										<tr>
											<td width="5%" align="right"></td>
											<td width="70%" align="Left">Pilih Semua</td>
											<td width="20%" align="right"></td>
											<td width="5%" align="right">
												<input type="checkbox" class="pemeriksaanallcls" value="all">
											</td>
										</tr>
									<?php
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>	
			</div>
			<div class="modal-footer">
				<input type="hidden" class="nolab" value="<?php echo $nolab;?>">
				<button class="btnsimpan btnsimpantindakanlab">Simpan</button>
			</div>
		</div>
	</div>
</div>
<script>
$(".pemeriksaanallcls").click(function(){
	if ($(this).is(':checked')) {
		$(".pemeriksaancls").prop('checked', true);
	}else{
		$(".pemeriksaancls").prop('checked', false);
	}
	
});	


$(".btnsimpantindakanlab").click(function(){
	var nolab = $(".nolab").val();
	var arrayKel = [];
	$(".pemeriksaancls:checked").each(function(){
		arrayKel.push($(this).val());
	});
	$(".tindakanlabcls_"+nolab).val(arrayKel);
	if(arrayKel.length > 0){
		$(".kesadarancls").val('01');
		$(".statuspulang").val('5');
		//get rujuk internal
		$.post( "get_rujuk_internal.php")
		  .done(function( data ) {
			$(".statuspulangform").html(data);

			$(".poliinternal").val("POLI LABORATORIUM");
		});	
	}
	$('#modallab1').modal('hide');
});

var nolab = $(".nolab").val();
$(".pemeriksaancls").each(function(){
	var arr = $(".tindakanlabcls_"+nolab).val().split(',');
	var kode = $(this).val();
	var cek = jQuery.inArray(kode,arr);

	if(cek >= 0){
		$(this).prop('checked', true);
	}
});
</script>

