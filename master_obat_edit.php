<?php
    include "config/helper_satusehat.php";
    
    $idbarang = $_GET['id'];
    $qdtbarang = mysqli_query($koneksi,"SELECT * FROM `ref_obat_lplpo` WHERE IdBarang = '$idbarang'");
    if(mysqli_num_rows($qdtbarang) == 0){
        
    }

    $dtbarang = mysqli_fetch_assoc($qdtbarang);
    // $stsehat_access_token = $_SESSION['stsehat_access_token'];
    // $dtobatkfa = get_obat_kfa($stsehat_access_token,);
    // //echo $dtobatkfa;
    // //die();
    // $dtkfa = json_decode($dtobatkfa,true);
    // $dtkfa_item = $dtkfa['items']['data'];
    // for($i = 0; $i < count($dtkfa_item); $i++){
    //     echo $dtkfa_item[$i]['kfa_code']." : ".$dtkfa_item[$i]['name']."<br/>";
    // }
?>
<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=master_obat" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>TAMBAH DATA LPLPO </b></h3>
			<div class="formbg" style="padding: 50px 50px 50px 50px;">
				<form class="form-horizontal" action="master_obat_edit_proses.php" method="post" role="form">
                    <input type="hidden" value="<?php echo $dtbarang['IdBarang'];?>" name="id"/>
					<div class = "row">
					<?php
						if($_GET['stsvalidasi'] != ''){
							echo "<div class='alert alert-danger'>".$_GET['stsvalidasi']."</div>";
						}
					?>				
					<div class="table-responsive" style="font-size:12px">
						<table class="table-judul" width="100%">
							<tr>
								<td width="10%">Nama Barang</td>
								<td width="50%">
									<input type="text" value="<?php echo $dtbarang['NamaBarang'];?>" name="namabarang" class="form-control nama_barang_pornas" placeholder="Ketikan Nama Barang" required>
								</td>
							</tr>
                            <tr>
								<td width="10%">Kode KFA </td>
								<td width="50%">
									<input type="text" value="<?php echo $dtbarang['IdKfa'];?>" name="kodekfa" class="fkodekfa form-control" placeholder="Ketikan Kode KFA" required>
									<input type="text" value="<?php echo $dtbarang['namekfa'];?>" name="namekfa" class="fnamekfa form-control" >
									<input type="text" value="<?php echo $dtbarang['dosiscodekfa'];?>" name="dosiscodekfa" class="fdosiscodekfa form-control" >
									<input type="text" value="<?php echo $dtbarang['dosisnamekfa'];?>" name="dosisnamekfa" class="fdosisnamekfa form-control" >
                                    <a href="#" class="btnformcarikodekfa btn btn-info" >Cari</a>
                                </td>
							</tr>
							<tr>
								<td>Satuan</td>
								<td>
									<select name="satuan" class="form-control jarak" required>
										<option value="TABLET">TABLET</option>
										<?php
										$query = mysqli_query($koneksi,"SELECT * FROM `ref_obat_satuan` order by `satuan_obat`");
											while($data = mysqli_fetch_assoc($query)){
                                                if($dtbarang['Satuan'] == $data['satuan_obat']){
                                                    echo "<option value='$data[satuan_obat]' SELECTED>$data[satuan_obat]</option>";
                                                }else{
                                                    echo "<option value='$data[satuan_obat]'>$data[satuan_obat]</option>";
                                                }
												
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td width="10%">Program</td>
								<td width="50%">
									<select name="namaprogram" class="form-control golonganfungsi">
                                        <option value="">Program</option>
										<?php
										$query = mysqli_query($koneksi,"SELECT * FROM `ref_obatprogram` ORDER BY nama_program");
											while($data = mysqli_fetch_assoc($query)){
                                                if($dtbarang['NamaProgram'] == $data['nama_program']){
												    echo "<option value='$data[nama_program]' SELECTED>$data[nama_program]</option>";
                                                }else{
                                                    echo "<option value='$data[nama_program]'>$data[nama_program]</option>";
                                                }
											}
										?>
									</select>	
								</td>
							</tr>
							<tr>
								<td>Jenis Barang</td>
								<td>
									<select name="jenisbarang" class="form-control jenisbarang" required>
										<option value="GENERIK" <?php if($dtbarang['JenisBarang'] == 'GENERIK'){echo 'SELECTED';}?>>GENERIK</option>
										<option value="NON GENERIK" <?php if($dtbarang['JenisBarang'] == 'NON GENERIK'){echo 'SELECTED';}?>>NON GENERIK</option>
										<option value="LAINNYA" <?php if($dtbarang['JenisBarang'] == 'LAINNYA'){echo 'SELECTED';}?>>LAINNYA</option>
									</select>
								</td>
							</tr>
						</table><hr/>
						<button type="submit" class="btn btn-sound btn-success btnsimpan">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal modalkfa" tabindex="-1" role="dialog">
	<div class="modal-dialog  modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Cari Kode KFA</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="form-group">
                    <div class="input-icon">
                        <input type="text" class="form-control keyobatkfa" placeholder="Ketikan nama obat...">
                        <span class="input-icon-addon btnformcarikfa">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </div>
                <div class="tmphasilcari"></tmp>
			</div>
			<!-- <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div> -->
		</div>
	</div>
</div>
<script src="assets/js/jquery.js"></script>
<script>
    $(".btnformcarikodekfa").click(function(){
        $(".modalkfa").modal('show');
    });

    
    $(".btnformcarikfa").click(function(){
        $( ".tmphasilcari" ).html('<i class="fa fa-spinner"></i> Memuat');
        var key = $('.keyobatkfa').val();
        //alert(key);
        $.post( "get_kode_kfa_obat.php", { key: key })
            .done(function( data ) {
                $( ".tmphasilcari" ).html( data );
        });	
    });


    $(document).on("click",".btnpilihkodekfa",function(){

        $(".fkodekfa").val($(this).parent().parent().find(".kodekfa").html());
        $(".fnamekfa").val($(this).parent().parent().find(".namekfa").html());
        $(".fdosiscodekfa").val($(this).parent().parent().find(".dosiscodekfa").html());
        $(".fdosisnamekfa").val($(this).parent().parent().find(".dosisnamekfa").html());

        $(".modalkfa").modal('hide');
    });
</script>