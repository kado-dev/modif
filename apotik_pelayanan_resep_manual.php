<?php
	include "config/koneksi.php";
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$otoritas = explode(',',$_SESSION['otoritas']);
	$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
	$tbresep = "tbresep_".str_replace(' ', '', $namapuskesmas);
	$tbresepdetail = "tbresepdetail_".str_replace(' ', '', $namapuskesmas);
?>

<div class="tableborderdiv">
	<div class="row search-page noprint" id="search-page-1">
		<div class="col-xs-12">
			<h3 class="judul">PELAYANAN RESEP</h3>
			<div class="formbg">
				<div class="row">
					<form method="get">
						<input type="hidden" name="page" value="apotik_pelayanan_resep_manual"/>
						<input type="hidden" name="status" value="<?php echo $_GET['status'];?>"/>
						<div class="col-sm-2">
							<input type="text" name="tgl" class="form-control datepicker" value="<?php echo $_GET['tgl'];?>" placeholder = "Pilih Tanggal">
						</div>
						<div class="col-sm-6">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama Pasien / No.Resep">
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-warning btn-white"><span class="fa fa-search"></span></button>
							<a href="?page=apotik_pelayanan_resep" class="btn btn-primary btn-white"><span class="fa fa-refresh"></span></a>
							<a href="#" data-toggle="modal" data-target="#modalresep" class="btn btn-success btn-white">Entry Resep</a>
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
	
	<!--Modal-->
	
	
	<!--kolom data-->
	<div class="row search-page noprint" id="search-page-1">	
		<div class="col-xs-12">
			<div class = "row">
				<div class="col-sm-12 table-responsive" style="font-size:12px">
					<table class="table-judul">
						<thead>
							<tr>
								<th width="4%">No.</th>
								<th width="8%">Tanggal</th>
								<th width="8%">No.Resep</th>
								<th width="8%">No.Index</th>
								<th width="20%">Nama Pasien</th>
								<th width="8%">Umur</th>
								<th width="12%">Pelayanan</th>
								<th width="10%">Jaminan</th>
								<th width="8%">Status</th>
								<?php if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){?>
								<th width="6%">Opsi</th>
								<?php }?>
							</tr>
						</thead>
		
						<tbody font="8">
							<?php
							$no = 0;
							$tanggal = date('Y-m-d');
							$tgl = $_GET['tgl'];
							$key = $_GET['key'];
							$tgls = date('Y-m-d',strtotime($tgl));
							if($tgl == null){
								$tglresep = " DATE(TanggalResep) = '$tanggal' and";
							}else{								
								$tglresep = " DATE(TanggalResep) = '$tgls' and";
							}
							
							if($key !=''){
								$strcari = " AND (`NamaPasien` Like '%$key%' OR `NoResep` Like '%$key%')";
							}else{
								$strcari = " ";
							}
							
							$strresep = "SELECT * FROM `$tbresep` WHERE".$tglresep." substring(NoResep,1,11) = '$kodepuskesmas' ".$strcari." GROUP BY NamaPasien ORDER BY NoResep DESC";
							// echo $strresep;
							$query = mysqli_query($koneksi, $strresep);
							while($data = mysqli_fetch_assoc($query)){
								$no = $no + 1;
								$noindex = $data['NoIndex'];
								if(strlen($noindex) == 24){
									$noindex2 = substr($data['NoIndex'],14);
								}else{
									$noindex2 = $data['NoIndex'];
								}
							?>
							
								<tr>
									<td align="center"><?php echo $no;?></td>
									<td align="center"><?php echo date('Y-m-d', strtotime($data['TanggalResep']));?></td>
									<td align="center"><?php echo substr($data['NoResep'],19);?></td>
									<td align="center" class="noresep" style="display: none;"><?php echo $data['NoResep'];?></td>
									<td align="center"><?php echo $noindex2;?></td>
									<td align="left" class="namakk"><?php echo $data['NamaPasien'];?></td>
									<td align="center"><?php echo $data['UmurTahun']." Thn ".$data['UmurBulan']." Bln";?></td>
									<td align="left" class="pelayanan"><?php echo $data['Pelayanan'];?></td>
									<td align="center"><?php echo $data['StatusBayar'];?></td>
									<td align="center"><?php echo $data['Status'];?></td>
									<?php if (in_array("APOTEK", $otoritas) || in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){?>
									<td align="center">
										<a href="?page=apotik_pelayanan_resep_manual_lihat&status=<?php echo $_GET['status'];?>&norsp=<?php echo $data['NoResep'];?>" class="btn btn-xs btn-info btn-white">Lihat</a>
									</td>		
									<?php }?>
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


<div class="modal fade" id="modalresep" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">RESEP ELEKTRONIK</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="index.php?page=apotik_pelayanan_resep_manual_proses" method="post" enctype="multipart/form-data" role="form">
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
							<td class="col-sm-3">Sumber Data Pasien</td>
							<td class="col-sm-9">
								<div class="input-group">
									<select class="form-control sumberdata" name="sumberdata">
										<option value="online">Online</option>
										<option value="offline">Offline</option>
										
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td>Nama Pasien - Umur</td>
							<td>
								<div class="row">
									<div class="col-sm-8">
										<input type="text" class="form-control dtoffline" style="display:none" maxlength ="20">
										<select class="form-control dtonline chosenselect" name="namapasien" >
											<?php
											$query = mysqli_query($koneksi,"SELECT `NamaPasien` FROM `$tbpasienrj` WHERE `TanggalRegistrasi`=curdate() ORDER BY `NamaPasien`");
												while($data = mysqli_fetch_assoc($query)){
														echo "<option value='$data[NamaPasien]'>$data[NamaPasien]</option>";			
												}
											?>
										</select>
									</div>
									<div class="col-sm-2">
										<input type="number" name="umurtahun" class="form-control" maxlength ="3" placeholder="Tahun" required>	
									</div>
									<div class="col-sm-2">
										<input type="number" name="umurbulan" class="form-control" maxlength ="3" placeholder="Bulan" required>	
									</div>
								</div>	
							</td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td>
								<textarea name="alamat" class="form-control" maxlength ="50" required></textarea>
							</td>
						</tr>
						<tr>
							<td>Asuransi</td>
							<td>
								<select name="asuransi" class="form-control" required>
									<option value="">--Pilih--</option>
									<?php										
									$query = mysqli_query($koneksi,"SELECT * FROM `tbasuransi` WHERE Kota = '$kota' order by `Asuransi`");
										while($data = mysqli_fetch_assoc($query)){
											if($data['Asuransi'] == 'UMUM'){	
												echo "<option value='$data[Asuransi]' SELECTED>$data[Asuransi]</option>";
											}else{
												echo "<option value='$data[Asuransi]'>$data[Asuransi]</option>";
											}		
										}
									?>
								</select>
							</td>	
						</tr>
						<tr>
							<td>Diagnosa</td>
							<td>
								<input type="text" class="form-control diagnosabpjs" style="width: 635px;" placeholder="Ketikan kode / nama diagnosa">
								<input type="hidden" name = "diagnosa" class="form-control kodebpjs">
								<input type="hidden" class="form-control diagnosahiddenbpjs">
							</td>	
						</tr>
						<tr>
							<td>Poli</td>
							<td>
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
							</td>	
						</tr>
					</table><hr>
					<button type="submit" class="btnsimpan">Simpan</button>							
				</form>
			</div>
		</div>
	</div>
</div>


<script src="assets/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript">

	$(".sumberdata").change(function(){
		var isi = $(this).val()
		if(isi == 'offline'){
			$(".dtoffline").show();
			$(".dtoffline").attr("name","namapasien");
			$(".dtonline").attr("name","");
			$(".dtonline").hide();
			$('.chosen-container').hide();
		}else{
			$(".dtoffline").hide();
			$(".dtonline").hide();
			$(".dtoffline").attr("name","");
			$(".dtonline").attr("name","namapasien");
			$('.chosen-container').show();
		}
	});
</script>

