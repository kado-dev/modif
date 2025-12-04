<?php
	include "config/helper_pasienrj.php";
?>

<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-3">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white fw-bold">Skrining ILP</h2>
			</div>
			<div class="ml-md-auto py-2 py-md-0">
				<!-- <a href="?page=master_posyandu_tambah" class="btn btn-success btn-round"><span class="fa fa-plus"></span> Kembali</a>	 -->
			</div>
		</div>
	</div>
</div>

<div class="page-inner">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<table class="table-judul">
			
				<tbody>
					<?php
										
					$str = "SELECT * FROM `ref_siklushidup` ORDER By Klaster, Nama ASC";
								
					$klaster = '';
					$query = mysqli_query($koneksi,$str);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$jmlskrining = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `siklushidup_skrining` WHERE `IdSiklusHidup` = '$data[IdSiklusHidup]'"));

                        if($klaster != $data['Klaster']){
					?>
                        <tr>
							<td align="left" colspan="3"><strong><?php echo $data['Klaster'];?></strong></td>						
						</tr>
                    <?php
                        }
                    ?>
						<tr>
							<td align="left"><?php echo $data['Nama'];?></td>
							<td align="center" width="20%"> <?php echo $jmlskrining;?> Skrining</td>							
							<td align="center" width="15%">
                                <button type="button" class="btn btn-outline-success btn-sm btnaturformulir" data-klaster="<?php echo $data['Klaster'];?>" data-nama="<?php echo $data['Nama'];?>" data-id="<?php echo $data['IdSiklusHidup'];?>">Pilih Formulir</button>
                            </td>							
						</tr>
					<?php
                    $klaster = $data['Klaster'];
					}
					?>
				</tbody>
			</table>
		</div>
	</div>	
</div>

<div class="modal fade noprint modalformskrining" id="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header noprint">
				<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
				<h4 class="modal-title" id="myModalLabel"><b>Formulir Skrining</b></h4>
			</div>
			<div class="modal-body noprint">
                <p class="ket-modal"></p>
				<div class="row">						
					<div class="col-sm-6">
                        <p style="font-size:12px;margin:0px">Klaster</p>
                        <p style="font-size:14px;font-weight:bold" class="mdl-text-klaster">...</p>
					</div>	
                    <div class="col-sm-6">
                        <p style="font-size:12px;margin:0px">Siklus Hidup</p>
                        <p style="font-size:14px;font-weight:bold" class="mdl-text-siklushidup">...</p>
					</div>	

                    <div class="col-sm-12">
                        <input type="text" class="form-control formsearch" placeholder="Cari Skrining"/>
                        <form class="list-skrining">
					    </form>
					</div>
				</div>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success btnsimpancheck">Simpan</button>
		    </div>
		</div>
	</div>
</div>

<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>
$(document).on("click",".btnaturformulir", function(event) {
	event.preventDefault();
    var klaster = $(this).data('klaster');
    var nama = $(this).data('nama');
    var id = $(this).data('id');

    $(".formsearch").attr('data-id',id);
    $(".mdl-text-siklushidup").text(nama);
    $(".mdl-text-klaster").text(klaster);

	$(".ket-modal").html('Memuat...');
	$.post("get_skrining_ilp.php", {id:id, key: ''}).done(function(data) {
		$(".list-skrining").html(data);

        $(".modalformskrining").modal('show');
        $(".ket-modal").html('');
	});    
});

$(document).on("click",".btnsimpancheck", function(event) {
	event.preventDefault();
    var formdata = $(".list-skrining").serialize();

	$(".ket-modal").html('Menyimpan...');
	$.post("simpan_skrining_ilp.php", formdata).done(function(data) {
		// alert(data);
        $(".ket-modal").html('<div class="alert alert-success">Data berhasil disimpan</div>');
        setTimeout(function(){
            location = ''
        },600)
	});    
});


$(".formsearch").on("keyup", function() {
    var key = $(this).val();
    var id = $(this).data('id');

	$.post("get_skrining_ilp.php", {id:id, key:key}).done(function(data) {
		$(".list-skrining").html(data);
	});    
});
</script>