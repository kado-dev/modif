<?php
	$kodepkm = $_SESSION['kodepuskesmas'];
	$data = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas`='$kodepkm'"));
?>

<style>
	.imgcenter{
		display: block; 
		margin-top: 15px; 
		margin-left: auto; 
		margin-right: auto;
		width: 65%;
	}
</style>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DATA PENUNJANG</b></h3>
			<div class = "formbg">
				<form class="form-horizontal" action="adm_penunjang_proses.php" method="post" enctype="multipart/form-data" role="form">
					<input type="hidden" name="fotolama" value="<?php echo $data['Img'];?>">
					<div class="row">
						<div class="col-sm-12">					
							<table class="table-judul">
								<h4><b>Workshop/Pelatihan</b></h4><hr/>
                                <tr>
									<td class="col-sm-3">RME</td>
									<td class="col-sm-8">
										<select name="rme" class="form-control" value="<?php echo $data['Rme'];?>">
											<option>--Pilih--</option>
											<option value="Belum" <?php if($data['Rme'] == 'Belum'){echo "SELECTED";}?>>Belum</option>
											<option value="Sudah" <?php if($data['Rme'] == 'Sudah'){echo "SELECTED";}?>>Sudah</option>
										</select>
									</td>
									<td class="col-sm-1">
                                        <a href="#" class="btnmodalrme btn btn-sm btn-round btn-info">Lihat</a>
                                    </td>
								</tr>
							</table>	
							<table class="table-judul">	
								<tr>
									<td class="col-sm-3">Antrian ISAP Simpus</td>
									<td class="col-sm-8">
										<select name="antrian" class="form-control" value="<?php echo $data['Antrian'];?>">
											<option>--Pilih--</option>
											<option value="Belum" <?php if($data['Antrian'] == 'Belum'){echo "SELECTED";}?>>Belum</option>
											<option value="Sudah" <?php if($data['Antrian'] == 'Sudah'){echo "SELECTED";}?>>Sudah</option>
										</select>
									</td>
                                    <td>
                                        <a href="#" class="btnmodalantrian btn btn-sm btn-round btn-info">Lihat</a>
                                    </td>
								</tr>
								<tr>
									<td>Fingerprint</td>
									<td>
										<select name="finger" class="form-control" value="<?php echo $data['Fingerprint'];?>">
											<option>--Pilih--</option>
											<option value="Belum" <?php if($data['Fingerprint'] == 'Belum'){echo "SELECTED";}?>>Belum</option>
											<option value="Sudah" <?php if($data['Fingerprint'] == 'Sudah'){echo "SELECTED";}?>>Sudah</option>
										</select>
									</td>
                                    <td>
                                        <a href="#" class="btnmodalfinger btn btn-sm btn-round btn-info">Lihat</a>
                                    </td>
								</tr>
							</table><br/>
							<table class="table-judul">
								<h4><b>Jasa Lainnya</b></h4><hr/>
                                <tr>
									<td class="col-sm-3">Maintenance Simpus</td>
									<td class="col-sm-8">
										<select name="maintenance" class="form-control" value="<?php echo $data['Fingerprint'];?>">
											<option>--Pilih--</option>
											<option value="Belum" <?php if($data['Maintenance'] == 'Belum'){echo "SELECTED";}?>>Belum</option>
											<option value="Sudah" <?php if($data['Maintenance'] == 'Sudah'){echo "SELECTED";}?>>Sudah</option>
										</select>
									</td>
                                    <td>
                                        <a href="#" class="btnmodalmaintenance btn btn-sm btn-round btn-info">Lihat</a>
                                    </td>
								</tr>
								<tr>
									<td>Bridging V4</td>
									<td>
										<select name="bridging" class="form-control" value="<?php echo $data['BridgingV4'];?>">
											<option>--Pilih--</option>
											<option value="Belum" <?php if($data['BridgingV4'] == 'Belum'){echo "SELECTED";}?>>Belum</option>
											<option value="Sudah" <?php if($data['BridgingV4'] == 'Sudah'){echo "SELECTED";}?>>Sudah</option>
										</select>
									</td>
								</tr>
                                <tr>
									<td>Bridging Antrol M-JKN</td>
									<td>
										<select name="antrol" class="form-control" value="<?php echo $data['BridgingAntrol'];?>">
											<option>--Pilih--</option>
											<option value="Belum" <?php if($data['BridgingAntrol'] == 'Belum'){echo "SELECTED";}?>>Belum</option>
											<option value="Sudah" <?php if($data['BridgingAntrol'] == 'Sudah'){echo "SELECTED";}?>>Sudah</option>
										</select>
									</td>
								</tr>
                                <tr>
									<td>Bridging I-Care</td>
									<td>
										<select name="icare" class="form-control" value="<?php echo $data['BridgingIcare'];?>">
											<option>--Pilih--</option>
											<option value="Belum" <?php if($data['BridgingIcare'] == 'Belum'){echo "SELECTED";}?>>Belum</option>
											<option value="Sudah" <?php if($data['BridgingIcare'] == 'Sudah'){echo "SELECTED";}?>>Sudah</option>
										</select>
									</td>
								</tr>
							</table><hr/>
							<input type="hidden" name="kodepuskesmas" class="form-control" value="<?php echo $data['KodePuskesmas'];?>" readonly>
							<input type="hidden" name="kota" class="form-control" value="<?php echo $data['Kota'];?>" required>
							<input type="hidden" name="provinsi" class="form-control" value="<?php echo $data['Profinsi'];?>" required>						
							<button type="submit" class="btn btn-round btn-success btnsimpan">Simpan</button><br/><br/>
						</div>
					</div>	
				</form>
			</div>
		</div>
	</div>
</div>

<!--modal rme-->
<div class="modal fade" id="modalrme" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"> Rekam Medis Elektronik</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="index.php?page=master_pegawai_proses" method="post" enctype="multipart/form-data" role="form">
                    <table class="table-judul">
                        <tr>
                            <td class="col-sm-3">Kegiatan</td>
                            <td class="col-sm-9">
                                Implementasi Rekam Medis Elektornik di Lingkup Puskesmas
                            </td>
                        </tr>
                        <tr>
                            <td>Periode</td>
                            <td>
                                Juni - 2023
                            </td>
                        </tr>
						<tr>
                            <td colspan="2">
								<canvas id="myCanvas" width="750px" height="450px"></canvas>
							</td>
                        </tr>
                    </table><br/>
                    <input type="hidden" name="puskesmas" class="form-control" value="<?php echo $_SESSION['kodepuskesmas'];?>">
                    <button type="submit" class="btnsimpan">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!--modal antrian-->
<div class="modal fade" id="modalantrian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"> Rekam Medis Elektronik</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="index.php?page=adm_penunjang_proses" method="post" enctype="multipart/form-data" role="form">
                    <table class="table-judul">
						<tr>
                            <td class="col-sm-3">Kode Rekening</td>
                            <td class="col-sm-9">
								5.2.02.05.01.0005
                            </td>
                        </tr>
                        <tr>
                            <td>Kegiatan</td>
                            <td>
								Belanja Modal Alat Kantor Lainnya
                            </td>
                        </tr>
						<tr>
                            <td>Spesifikasi</td>
                            <td>
								Mesin Antrian Isap Simpus
                            </td>
                        </tr>
						<tr>
                            <td>Satuan</td>
                            <td>
								Set
                            </td>
                        </tr>
						<tr>
                            <td>Nilai</td>
                            <td>
								Rp. 60.000.000
                            </td>
                        </tr>
						<tr>
                            <td colspan="2">
								<canvas id="myCanvasAntrian" width="750px" height="450px"></canvas>
							</td>
                        </tr>
                    </table>
				</form>
            </div>
        </div>
    </div>
</div>

<!--modal finger-->
<div class="modal fade" id="modalfinger" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"> Rekam Medis Elektronik</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="index.php?page=adm_penunjang_proses" method="post" enctype="multipart/form-data" role="form">
                    <table class="table-judul">
						<tr>
                            <td class="col-sm-3">Kode Rekening</td>
                            <td class="col-sm-9">
								5.2.02.05.01.0005
                            </td>
                        </tr>
						<tr>
                            <td>Kegiatan</td>
                            <td>
								Belanja Modal Alat Kantor Lainnya
                            </td>
                        </tr>
                        <tr>
                            <td>Spesifikasi</td>
                            <td>
								Fingerprint Solution 4500 U
                            </td>
                        </tr>
						<tr>
                            <td>Satuan</td>
                            <td>
								Unit
                            </td>
                        </tr>
						<tr>
                            <td>Nilai</td>
                            <td>
								Rp. 1.500.000
                            </td>
                        </tr>
						<tr>
                            <td>Keterangan</td>
                            <td>
								Kebutuhan 6 unit (Pendaftaran, Gigi, Kebidanan, Laboratrorium, IGD/Tindakan, Farmasi)
                            </td>
                        </tr>
						<tr>
                            <td colspan="2">
								<canvas id="myCanvasFinger" width="750px" height="450px"></canvas>
							</td>
                        </tr>
                    </table>
				</form>
            </div>
        </div>
    </div>
</div>

<!--modal maintenance-->
<div class="modal fade" id="modalmaintenance" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"> Rekam Medis Elektronik</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="index.php?page=adm_penunjang_proses" method="post" enctype="multipart/form-data" role="form">
                    <table class="table-judul">
						<tr>
                            <td class="col-sm-3">Kode Rekening</td>
                            <td class="col-sm-9">
								5.1.02.02.26.001
                            </td>
                        </tr>
                        <tr>
                            <td>Kegiatan</td>
                            <td>
								Belanja Jasa Tenaga Ahli Penetrasi Test dan Monitoring Aplikasi Pada Domain Kabupaten Bandung
                            </td>
                        </tr>
						<tr>
                            <td>Nilai</td>
                            <td>
								Rp. 7.000.000
                            </td>
                        </tr>
                    </table>
				</form>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/jquery.js"></script>
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>
    $('.btnmodalrme').click(function(){
        $('#modalrme').modal('show');
    });

	$('.btnmodalmaintenance').click(function(){
        $('#modalmaintenance').modal('show');
    });

	$('.btnmodalantrian').click(function(){
        $('#modalantrian').modal('show');
    });

	$('.btnmodalfinger').click(function(){
        $('#modalfinger').modal('show');
    });

	// maintenance
	var canvas1 = document.getElementById('myCanvas');
	var context1 = canvas1.getContext('2d');
	var imageObj1 = new Image();

	imageObj1.onload = function() {
		context1.drawImage(imageObj1, 0, 0, canvas1.width, canvas1.height);
	};
	imageObj1.src = 'image/penunjang/esertifikat_ws_rme_2023.jpg';

	// antrian
	var canvas2 = document.getElementById('myCanvasAntrian');
	var context2 = canvas2.getContext('2d');
	var imageObj2 = new Image();

	imageObj2.onload = function() {
		context2.drawImage(imageObj2, 0, 0, canvas2.width, canvas2.height);
	};
	imageObj2.src = 'image/penunjang/mesinantrianisapsimpus.jpg';

	// finger
	var canvas3 = document.getElementById('myCanvasFinger');
	var context3 = canvas3.getContext('2d');
	var imageObj3 = new Image();

	imageObj3.onload = function() {
		context3.drawImage(imageObj3, 0, 0, canvas3.width, canvas3.height);
	};
	imageObj3.src = 'image/penunjang/fingeru4500u.jpg';
</script>