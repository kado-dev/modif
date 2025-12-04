<?php
	session_start();
	include "config/koneksi.php";
	$idantrian = $_POST['id'];
	$str = "SELECT * FROM `tbadm_antrian` WHERE `IdAntrian` = '$idantrian'";
	$query = mysqli_query($koneksi,$str);
	$data = mysqli_fetch_assoc($query);

?>
<!--untuk menampilkan modal-->
<div class="modal fade" id="modaleditantrian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Edit Data</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="index.php?page=adm_antrian_edit_proses" method="post" enctype="multipart/form-data" role="form">
					<table class="table">
						<tr>
							<td class="col-sm-3">Tgl.Pasang & Pelatihan</td>
							<td class="col-sm-10">
								<div class="row">
									<div class="col-sm-4">
										<div class="input-group">
											<span class="input-group-addon">
												<span class="fa fa-calendar"></span>
											</span>
											<input type="text" name="tanggalpasang" class="form-control datepicker2" value="<?php echo date('d-m-Y', strtotime($data['TanggalPasang']));?>">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="input-group">
											<span class="input-group-addon">
												<span class="fa fa-calendar"></span>
											</span>
											<input type="text" name="tanggalpelatihan" class="form-control" value="<?php echo date('d-m-Y', strtotime($data['TanggalPelatihan']));?>">
										</div>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>Puskesmas</td>
							<td>
								<input type="text" name="puskesmas" class="form-control input-md puskesmas" value="<?php echo $data['Puskesmas'];?>" required>
								<input type="hidden" name="kodepuskesmas" class="form-control kodepuskesmas">
							</td>
						</tr>
						<tr>
							<td>PPK</td>
							<td>
								<select name="ppk" class="form-control">
									<option value="BU DIAH" <?php if($data['PPK'] == 'BU DIAH'){echo "SELECTED";}?>>BU DIAH</option>
									<option value="BU WIDY" <?php if($data['PPK'] == 'BU WIDY'){echo "SELECTED";}?>>BU WIDY</option>
									<option value="PAK EDI" <?php if($data['PPK'] == 'PAK EDI'){echo "SELECTED";}?>>PAK EDI</option>
									<option value="PAK IYAN" <?php if($data['PPK'] == 'PAK IYAN'){echo "SELECTED";}?>>PAK IYAN</option>
									<option value="PAK IDEN" <?php if($data['PPK'] == 'PAK IDEN'){echo "SELECTED";}?>>PAK IDEN</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Penyedia Hardware</td>
							<td>
								<select name="penyedia" class="form-control">
									<option value="TIA" <?php if($data['PenyediaHardware'] == 'TIA'){echo "SELECTED";}?>>TIA</option>
									<option value="TOMMY" <?php if($data['PenyediaHardware'] == 'TOMMY'){echo "SELECTED";}?>>TOMMY</option>
									<option value="DINAN" <?php if($data['PenyediaHardware'] == 'DINAN'){echo "SELECTED";}?>>DINAN</option>
									<option value="ARI" <?php if($data['PenyediaHardware'] == 'ARI'){echo "SELECTED";}?>>ARI</option>
									<option value="JEPRI" <?php if($data['PenyediaHardware'] == 'JEPRI'){echo "SELECTED";}?>>JEFRI</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Spesifikasi Hardware</td>
							<td>
								<div class="row">
									<?php
										$arrSpesifikasi = explode(",",$data['SpesifikasiHardware']);
									?>
									<div class="col-sm-4">
										<input type="checkbox" name="spesifikasi[]" value="Monitor Touchscreen" value="Monitor Touchscreen" <?php if(in_array("Monitor Touchscreen", $arrSpesifikasi)){echo "CHECKED";}?>> Monitor Touchscreen<br/>
										<input type="checkbox" name="spesifikasi[]" value="NUC Intel Celeron" value="NUC Intel Celeron" <?php if(in_array("NUC Intel Celeron", $arrSpesifikasi)){echo "CHECKED";}?>> NUC Intel Celeron<br/>
										<input type="checkbox" name="spesifikasi[]" value="NUC Intel I3" value="NUC Intel I3" <?php if(in_array("NUC Intel I3", $arrSpesifikasi)){echo "CHECKED";}?>> NUC Intel I3<br/>
										<input type="checkbox" name="spesifikasi[]" value="NUC Intel I5" value="NUC Intel I5" <?php if(in_array("NUC Intel I5", $arrSpesifikasi)){echo "CHECKED";}?>> NUC Intel I5<br/>
										<input type="checkbox" name="spesifikasi[]" value="TV LED 42 inch" value="TV LED 42 inch" <?php if(in_array("TV LED 42 inch", $arrSpesifikasi)){echo "CHECKED";}?>> TV LED 42 inch<br/>
										<input type="checkbox" name="spesifikasi[]" value="TV LED 49 inch" value="TV LED 49 inch" <?php if(in_array("TV LED 49 inch", $arrSpesifikasi)){echo "CHECKED";}?>> TV LED 49 inch<br/>
										<input type="checkbox" name="spesifikasi[]" value="Windows 10 Original" value="Windows 10 Original" <?php if(in_array("Windows 10 Original", $arrSpesifikasi)){echo "CHECKED";}?>> Windows 10 Original<br/>
										
									</div>
									<div class="col-sm-4">
										<input type="checkbox" name="spesifikasi[]" value="Barcode Scan" value="Barcode Scan" <?php if(in_array("Barcode Scan", $arrSpesifikasi)){echo "CHECKED";}?>> Barcode Scan<br/>
										<input type="checkbox" name="spesifikasi[]" value="Printer Thermal Epson" value="Printer Thermal Epson" <?php if(in_array("Printer Thermal Epson", $arrSpesifikasi)){echo "CHECKED";}?>> Printer Thermal Epson<br/>
										<input type="checkbox" name="spesifikasi[]" value="Printer Thermal Eppos" value="Printer Thermal Eppos" <?php if(in_array("Printer Thermal Eppos", $arrSpesifikasi)){echo "CHECKED";}?>> Printer Thermal Eppos<br/>
										<input type="checkbox" name="spesifikasi[]" value="Printer Fargo" value="Printer Fargo" <?php if(in_array("Printer Fargo", $arrSpesifikasi)){echo "CHECKED";}?>> Printer Fargo<br/>
										<input type="checkbox" name="spesifikasi[]" value="Printer Etiket Zebra" value="Printer Etiket Zebra" <?php if(in_array("Printer Etiket Zebra", $arrSpesifikasi)){echo "CHECKED";}?>> Printer Etiket Zebra<br/>
										<input type="checkbox" name="spesifikasi[]" value="Ribbon Collor" value="Ribbon Collor" <?php if(in_array("Ribbon Collor", $arrSpesifikasi)){echo "CHECKED";}?>> Ribbon Collor<br/>
										<input type="checkbox" name="spesifikasi[]" value="Ribbon Black" value="Ribbon Black" <?php if(in_array("Ribbon Black", $arrSpesifikasi)){echo "CHECKED";}?>> Ribbon Black<br/>
										
									</div>
									<div class="col-sm-4">
										<input type="checkbox" name="spesifikasi[]" value="Id Card" value="Id Card" <?php if(in_array("Id Card", $arrSpesifikasi)){echo "CHECKED";}?>> Id Card<br/>
										<input type="checkbox" name="spesifikasi[]" value="Speaker" value="Speaker" <?php if(in_array("Speaker", $arrSpesifikasi)){echo "CHECKED";}?>> Speaker<br/>
										<input type="checkbox" name="spesifikasi[]" value="Casing / Box Antrian" value="Casing / Box Antrian" <?php if(in_array("Casing / Box Antrian", $arrSpesifikasi)){echo "CHECKED";}?>> Casing / Box Antrian<br/>
										<input type="checkbox" name="spesifikasi[]" value="Braket Monitor" value="Braket Monitor" <?php if(in_array("Braket Monitor", $arrSpesifikasi)){echo "CHECKED";}?>> Braket Monitor<br/>
										<input type="checkbox" name="spesifikasi[]" value="Braket TV" value="Braket TV" <?php if(in_array("Braket TV", $arrSpesifikasi)){echo "CHECKED";}?>> Braket TV<br/>
										<input type="checkbox" name="spesifikasi[]" value="Kabel HDMI" value="Kabel HDMI" <?php if(in_array("Kabel HDMI", $arrSpesifikasi)){echo "CHECKED";}?>> Kabel HDMI<br/>
									</div
								</div>
							</td>
						</tr>
						<tr>
							<td>Teknisi Pasang</td>
							<td>
								<select name="teknisipasang" class="form-control">
									<option value="ADI" <?php if($data['TeknisiPasang'] == 'ADI'){echo "SELECTED";}?>>ADI</option>
									<option value="AGY" <?php if($data['TeknisiPasang'] == 'AGY'){echo "SELECTED";}?>>AGY</option>
									<option value="DODY" <?php if($data['TeknisiPasang'] == 'DODY'){echo "SELECTED";}?>>DODY</option>
									<option value="FAJAR" <?php if($data['TeknisiPasang'] == 'FAJAR'){echo "SELECTED";}?>>FAJAR</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Pelatihan</td>
							<td>
								<select name="pelatihan" class="form-control">
									<option value="BELUM" <?php if($data['Pelatihan'] == 'BELUM'){echo "SELECTED";}?>>BELUM</option>
									<option value="SUDAH" <?php if($data['Pelatihan'] == 'SUDAH'){echo "SELECTED";}?>>SUDAH</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Foto</td>
							<td>
								<input type="file" name="image" class="form-control">
							</td>
						</tr>
					</table><hr/>
					<input type="hidden" name="idantrian" class="form-control datepicker2" value="<?php echo $idantrian;?>">
					<button type="submit" class="btnsimpan">Simpan</button>
				</form>
			</div>
		</div>
	</div>
</div>