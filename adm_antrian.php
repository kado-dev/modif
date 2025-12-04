<?php
	$kodepuskesmas =  $_SESSION['kodepuskesmas'];
	//tes kolaborasi 22
?>


<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<a class="backform" style="margin-top: -10px;"><button type="submit" class="btn btn-success btnmodalpegawai btn-white"> Tambah Data</button></a>
			<a href="index.php?page=adm_antrian_print_semua" class="backform" style="margin-top: -10px; margin-right: 10px;"><button type="submit" class="btn btn-info btn-white"> Print</button></a>
			<h3 class="judul"><b>DATA ANTRIAN</b></h3>
			<!--untuk menampilkan modal-->
			<div class="modal fade" id="modalpegawai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="myModalLabel"> Entry Data</h4>
						</div>
						<div class="modal-body">
							<form class="form-horizontal" action="index.php?page=adm_antrian_proses" method="post" enctype="multipart/form-data" role="form">
								<table class="table">
									<tr>
										<td class="col-sm-3">Tgl.Pasang & Pelatihan</td>
										<td class="col-sm-10">
											<div class="row">
												<div class="col-sm-4">
													<div class="input-group">
														<span class="input-group-addon tesdate">
															<span class="fa fa-calendar"></span>
														</span>
														<?php
															$tgls = explode("-",date ('Y-m-d'));
														?>
														<input type="text" name="tanggalpasang" class="form-control datepicker" value="<?php echo $tgls[2]."-".$tgls[1]."-".$tgls[0];?>">
													</div>
												</div>
												<div class="col-sm-4">
													<div class="input-group">
														<span class="input-group-addon tesdate">
															<span class="fa fa-calendar"></span>
														</span>
														<?php
															$tgls = explode("-",date ('Y-m-d'));
														?>
														<input type="text" name="tanggalpelatihan" class="form-control datepicker" value="<?php echo $tgls[2]."-".$tgls[1]."-".$tgls[0];?>">
													</div>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td>Puskesmas</td>
										<td>
											<input type="text" name="puskesmas" class="form-control input-md puskesmas" placeholder="Puskesmas" required>
											<input type="hidden" name="kodepuskesmas" class="form-control kodepuskesmas">
										</td>
									</tr>
									<tr>
										<td>PPK</td>
										<td>
											<select name="ppk" class="form-control">
												<option value="BU DIAH">BU DIAH</option>
												<option value="BU WIDY">BU WIDY</option>
												<option value="PAK EDI">PAK EDI</option>
												<option value="PAK IYAN">PAK IYAN</option>
												<option value="PAK IDEN">PAK IDEN</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Penyedia Hardware</td>
										<td>
											<select name="penyedia" class="form-control">
												<option value="TIA">TIA</option>
												<option value="TOMMY">TOMMY</option>
												<option value="DINAN">DINAN</option>
												<option value="ARI">ARI</option>
												<option value="JEPRI">JEFRI</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Spesifikasi Hardware</td>
										<td>
											<div class="row">
												<div class="col-sm-4">
													<input type="checkbox" name="spesifikasi[]" value="Monitor Touchscreen"> Monitor Touchscreen<br/>
													<input type="checkbox" name="spesifikasi[]" value="NUC Intel Celeron"> NUC Intel Celeron<br/>
													<input type="checkbox" name="spesifikasi[]" value="NUC Intel I3"> NUC Intel I3<br/>
													<input type="checkbox" name="spesifikasi[]" value="NUC Intel I5"> NUC Intel I5<br/>
													<input type="checkbox" name="spesifikasi[]" value="TV LED 42 inch"> TV LED 42 inch<br/>
													<input type="checkbox" name="spesifikasi[]" value="TV LED 49 inch"> TV LED 49 inch<br/>
													<input type="checkbox" name="spesifikasi[]" value="Windows 10 Original"> Windows 10 Original<br/>
													
												</div>
												<div class="col-sm-4">
													<input type="checkbox" name="spesifikasi[]" value="Barcode Scan"> Barcode Scan<br/>
													<input type="checkbox" name="spesifikasi[]" value="Printer Thermal Epson"> Printer Thermal Epson<br/>
													<input type="checkbox" name="spesifikasi[]" value="Printer Thermal Eppos"> Printer Thermal Eppos<br/>
													<input type="checkbox" name="spesifikasi[]" value="Printer Fargo"> Printer Fargo<br/>
													<input type="checkbox" name="spesifikasi[]" value="Printer Etiket Zebra"> Printer Etiket Zebra<br/>
													<input type="checkbox" name="spesifikasi[]" value="Ribbon Collor"> Ribbon Collor<br/>
													<input type="checkbox" name="spesifikasi[]" value="Ribbon Black"> Ribbon Black<br/>
													
												</div>
												<div class="col-sm-4">
													<input type="checkbox" name="spesifikasi[]" value="Id Card"> Id Card<br/>
													<input type="checkbox" name="spesifikasi[]" value="Speaker"> Speaker<br/>
													<input type="checkbox" name="spesifikasi[]" value="Casing / Box Antrian"> Casing / Box Antrian<br/>
													<input type="checkbox" name="spesifikasi[]" value="Braket Monitor"> Braket Monitor<br/>
													<input type="checkbox" name="spesifikasi[]" value="Braket TV"> Braket TV<br/>
													<input type="checkbox" name="spesifikasi[]" value="Kabel HDMI"> Kabel HDMI<br/>
												</div
											</div>
										</td>
									</tr>
									<tr>
										<td>Teknisi Pasang</td>
										<td>
											<select name="teknisipasang" class="form-control">
												<option value="ADI">ADI</option>
												<option value="AGY">AGY</option>
												<option value="DODY">DODY</option>
												<option value="FAJAR">FAJAR</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>Pelatihan</td>
										<td>
											<select name="pelatihan" class="form-control">
												<option value="BELUM">BELUM</option>
												<option value="SUDAH">SUDAH</option>
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
								<button type="submit" class="btnsimpan">Simpan</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="hasilmodal"></div>
		</div>
	</div>
	
	<div class="row search-page" id="search-page-1">
		<div class="col-xs-12">
			<div class="row">
				<div class="col-xs-12 col-sm-12">
					<div class="search-area well well-sm">
						<div class="space-6"></div>
						<div class = "row">
							<div class="col-sm-12 table-responsive" style="font-size:12px">
								<table id="datatabless" class="table table-judul-form" width="100%">
									<thead>
										<tr>
											<th width="3%">No.</th>
											<th width="3%">Id</th>
											<th width="8%">Tgl.Pasang</th>
											<th width="15%">Puskesmas</th>
											<th width="7%">PPK</th>
											<th width="7%">Penyedia</th>
											<th width="7%">Teknisi</th>
											<th width="15%">Spesifikasi Harware</th>
											<th width="7%">Pelatihan</th>
											<th width="10%">Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php
										
										$str = "SELECT * FROM `tbadm_antrian`";
										$str2 = $str." ORDER BY Puskesmas";
										// echo $str2;
										// die();
										
										$query = mysqli_query($koneksi,$str2);
										while($data = mysqli_fetch_assoc($query)){
											$no = $no + 1;
										?>
											<tr>
												<td align="center"><?php echo $no;?></td>
												<td align="center" class="idantrian"><?php echo $data['IdAntrian'];?></td>
												<td align="center"><?php echo $data['TanggalPasang'];?></td>
												<td align="left"><?php echo $data['Puskesmas'];?></td>
												<td align="center"><?php echo $data['PPK'];?></td>
												<td align="center"><?php echo $data['PenyediaHardware'];?></td>
												<td align="center"><?php echo $data['TeknisiPasang'];?></td>
												<td align="left"><?php echo $data['SpesifikasiHardware'];?></td>
												<td align="center"><?php echo $data['Pelatihan'];?></td>
												<td align="center">
													<a href="#" class="btnmodalantrianedit btn btn-xs btn-success btn-white">Edit</a>
													<a href="adm_antrian_print.php?id=<?php echo $data['IdAntrian'];?>" class="btn btn-xs btn-info btn-white">Print</a>
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
			</div>		
		</div>
	</div>
</div>	
	