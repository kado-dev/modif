<?php
	$kota = $_SESSION['kota'];
	$kodepuskesmas =  $_SESSION['kodepuskesmas'];
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=dashboard" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>DATA PUSKESMAS</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="master_puskesmas"/>
						<div class="col-xl-6">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama/Kode Puskesmas">
						</div>
						<div class="col-xl-2">
							<select name="filter" class="form-control" required>
								<option value='SATU SEHAT' <?php if($_GET['filter'] == 'SATU SEHAT'){echo "SELECTED";}?>>SATU SEHAT</option>
							</select>
						</div>
						<div class="col-xl-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=master_puskesmas" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="master_puskesmas_excel.php" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
							<?php if(in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){ ?>
								<button type="button" class="btn btn-round btn-success btnmodalpuskesmas"> Tambah</button>
							<?php }?>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>

	<div class="row noprint">
		<div class="col-sm-12 table-responsive" style="font-size:12px">
			<table class="table-judul" width="100%">
				<thead>
					<tr>
						<th width="3%">NO.</th>
						<th width="10%">ID PUSKESMAS</th>
						<th width="15%">NAMA PUSKESMAS</th>
						<th width="30%">ALAMAT</th>
						<th width="10%">TELPON</th>
						<th width="20%">KEPALA PUSKESMAS</th>
						<?php if(in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){ ?>
						<th width="10%">#</th>
						<?php }?>
					</tr>
				</thead>
				<tbody>
					<?php
					$key = $_GET['key'];
					$filter = $_GET['filter'];		
					
					// if($key !=''){
					// 	$strcari = " ";
					// }else{
					// 	$strcari = " ";
					// }

					if($filter == "SATU SEHAT"){
						$filter = " AND `SatuSehat` = 'Sudah'";
					}else{
						$filter = " ";
					}
					
					
					$str = "select * from `tbpuskesmas` WHERE KodePuskesmas = '$kodepuskesmas'";
					$str2 = $str." order by NamaPuskesmas Asc";
					// echo $str2;
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					?>
						<tr>
							<?php 
								$ckabdescr = "-";
								$kodekab = $data['KodeKab'];
								$qrydatapkm = mysqli_query($koneksi,"select `CKabDescr` from `ref_kabupaten` where `CKabID` = '$kodekab'");
								if(mysqli_num_rows($qrydatapkm) > 0){
									$datapkm = mysqli_fetch_assoc($qrydatapkm);
									$ckabdescr = $datapkm['CKabDescr'];
								}
							?>
							<td style="text-align:right;"><?php echo $no;?></td>
							<td class="kodepuskesmas" style="text-align:center;"><?php echo $data['KodePuskesmas'];?></td>
							<td class="nama"><?php echo $data['NamaPuskesmas'];?></td>
							<td><?php echo strtoupper($data['Alamat']);?></td>
							<td style="text-align:left;"><?php echo $data['Telepon'];?></td>
							<td style="text-align:left;"><?php echo $data['KepalaPuskesmas'];?></td>
							<?php if(in_array("ADMINISTRATOR", $otoritas) || in_array("PROGRAMMER", $otoritas)){ ?>
							<td style="text-align:center;">
								<a href="#" class="btn btn-sm btn-round btn-info btnmodalpuskesmasedit">Edit</a>
								<!-- <a href="?page=master_puskesmas_delete&id=<?php echo $data['IdPuskesmas'];?>" class="btn btn-sm btn-round btn-danger btnhapus">Hapus</a> -->
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

	<!--untuk menampilkan modal-->
	<div class="modal fade" id="modalpuskesmas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Entry Puskesmas</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				  
				<div class="modal-body">
					<form class="form-horizontal" action="index.php?page=master_puskesmas_proses" method="post" enctype="multipart/form-data">
						<table class="table-judul" width="100%">
							<tr>
								<td class="col-sm-3">Id Puskesmas</td>
								<td>:</td>
								<td class="col-sm-9">
									<input type="text" name="idpuskesmas" class="form-control" maxlength ="15" required>
								</td>
							</tr>
							<tr>
								<td>Puskesmas</td>
								<td>:</td>
								<td>
									<input type="text" name="namapuskesmas" class="form-control" required>
								</td>
							</tr>
							<tr>
								<td>Alamat</td>
								<td>:</td>
								<td>
									<input type="text" name="alamat" class="form-control" required>
								</td>
							</tr>
							<tr>
								<td>Kelurahan</td>
								<td>:</td>
								<td>
									<input type="text" name="kelurahan" class="form-control nama_kelurahan" placeholder="Kelurahan" required>
									<input type="hidden" name="kodekelurahan" class="form-control kodekelurahan">
								</td>
							</tr>
							<tr>
								<td>Kecamatan</td>
								<td>:</td>
								<td>
									<input type="text" name="kecamatan" class="form-control nama_kecamatan" placeholder="Kecamatan" required>
									<input type="hidden" name="kodekecamatan" class="form-control kodekecamatan">
								</td>
							</tr>
							<tr>
								<td>Kota</td>
								<td>:</td>
								<td>
									<input type="text" name="kota" class="form-control nama_kota" placeholder="Kota" required>
									<input type="hidden" name="kodekota" class="form-control kodekota">
								</td>
							</tr>
							<tr>
								<td>Provinsi</td>
								<td>:</td>
								<td>
									<input type="text" name="provinsi" class="form-control nama_provinsi" placeholder="Provinsi" required>
									<input type="hidden" name="kodeprovinsi" class="form-control kodeprovinsi">
									
								</td>
							</tr>
							<tr>
								<td>Telepon</td>
								<td>:</td>
								<td>
									<input type="text" name="telepon" class="form-control" required>
								</td>
							</tr>
							<tr>
								<td>Kepala Puskesmas</td>
								<td>:</td>
								<td>
									<input type="text" name="kepalapuskesmas" class="form-control" required>
								</td>
							</tr>
							<tr>
								<td>Longitude</td>
								<td>:</td>
								<td>
									<input type="text" name="long" class="form-control" required>
								</td>
							</tr>
							<tr>
								<td>Latitude</td>
								<td>:</td>
								<td>
									<input type="text" name="lat" class="form-control" required>
								</td>
							</tr>
							<tr>
								<td>Image</td>
								<td>:</td>
								<td>
									<input type="file" name="image" class="form-control">
								</td>
							</tr>
						</table><hr/>
						<button type="submit" class="btnsimpan">SIMPAN</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="hasilmodal"></div>
</div>

<script src="assets/js/jquery.js"></script>
<script>
	$('.btnmodalpuskesmas').click(function(){
		$('#modalpuskesmas').modal('show');
	});

	$('.btnmodalpuskesmasedit').click(function(){
	var kodepuskesmas = $(this).parent().parent().find(".kodepuskesmas").html()
	//alert(kodepuskesmas);
	$.post( "get_modal_puskesmas.php", { id: kodepuskesmas })
		.done(function( data ) {
			$( ".hasilmodal" ).html( data );
			$('#modaleditpuskesmas').modal('show');
	});	
	});
</script>