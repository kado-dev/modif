<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$otoritas = explode(',',$_SESSION['otoritas']);
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DATA TINDAKAN</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="master_tindakan"/>
						<div class="col-xl-4">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama / Kelompok Tindakan">
						</div>
						<div class="col-xl-3">
							<select name="kelompok" class="form-control">
								<option value="" <?php if($_GET['kelompok'] == ''){echo "SELECTED";}?>>SEMUA</option>
								<?php
									$qrykelompok = mysqli_query($koneksi,"SELECT * FROM `tbtindakankelompok` ORDER BY KelompokTindakan");									
									while ($dtkelompok = mysqli_fetch_assoc($qrykelompok)) {
										if($_GET['kelompok'] == $dtkelompok['KelompokTindakan']){
											echo "<option value='$dtkelompok[KelompokTindakan]' SELECTED>$dtkelompok[KelompokTindakan]</option>";
										}else{
											echo "<option value='$dtkelompok[KelompokTindakan]'>$dtkelompok[KelompokTindakan]</option>";
										}
									} 
								?>
							</select>
						</div>
						<div class="col-xl-5">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=master_tindakan" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<?php 
								if (in_array("PROGRAMMER", $otoritas) || in_array("OPERATOR", $otoritas) || in_array("ADMINISTRATOR", $otoritas)){
							?>
							<button type="button" class="btn btn-round btn-success btnmodaltindakan">Tambah</button>
							<?php 
								} 
								if (in_array("PROGRAMMER", $otoritas)){
							?>
								<a href="import_tindakan_bpjs.php" class="btn btn-round btn-primary">Import</a>
							<?php } ?>
							<!--<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fas fa-print"></span></a>-->
						</div>
					</div>				
				</form>
			</div>
		</div>
	</div>
	<div class="row noprint">
		<div class="col-sm-12 table-responsive" style="font-size:12px">
			<table class="table-judul">
				<thead>
					<tr>
						<th width="5%">NO</th>
						<th width="10%">ID</th>
						<th width="25%">JENIS TINDAKAN</th>
						<th width="25%">KELOMPOK</th>
						<th width="10%">HARGA</th>
						<th width="10%">STATUS</th>
						<?php if (in_array("PROGRAMMER", $otoritas) || in_array("OPERATOR", $otoritas) || in_array("ADMINISTRATOR", $otoritas)){ ?>
						<th width="10%">#</th>
						<?php }?>
					</tr>
				</thead>
				<tbody font="8">
					<?php
					$jumlah_perpage = 50;
					
					if($_GET['h']==''){
						$mulai=0;
					}else{
						$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}

					$kelompok = $_GET['kelompok'];	
					$key = $_GET['key'];	

					if($kelompok == ''){
						$strkelompok = '';
					}else{
						$strkelompok = " AND `KelompokTindakan` = '$kelompok' ";
					}

					$str = "SELECT * FROM `tbtindakan` WHERE Status <> 'BPJS' AND `Tindakan` like '%$key%'".$strkelompok;
					$str2 = $str." order by `Tindakan` ASC Limit $mulai,$jumlah_perpage";
					// echo $str2;
					// die();
					
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
					?>
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="center" class="kdtdk"><?php echo $data['IdTindakan'];?></td>
							<td class="nama"><?php echo $data['Tindakan'];?></td>
							<td><?php echo $data['KelompokTindakan'];?></td>
							<td align="right"><?php echo rupiah($data['Tarif']);?></td>
							<td align="center"><?php echo $data['Status'];?></td>
							<td align="center">
								<?php if (in_array("PROGRAMMER", $otoritas) || in_array("OPERATOR", $otoritas) || in_array("ADMINISTRATOR", $otoritas)){ ?>		
									<a href="#" class="btnmodaltindakanedit btn btn-round btn-sm btn-primary">EDIT</a>
									<a onClick="return confirm('Anda yakin data ingin dihapus...?')" href="?page=master_tindakan_delete&id=<?php echo $data['IdTindakan'];?>" class="btn btn-round btn-sm  btn-danger">HAPUS</a>
								<?php } ?>
							</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
			<hr>
			<ul class="pagination">
				<?php
					$query2 = mysqli_query($koneksi,$str);
					$jumlah_query = mysqli_num_rows($query2);
					
					if(($jumlah_query % $jumlah_perpage) > 0){
						$jumlah = ($jumlah_query / $jumlah_perpage)+1;
					}else{
						$jumlah = $jumlah_query / $jumlah_perpage;
					}
					for ($i=1;$i<=$jumlah;$i++){
					$max = $_GET['h'] + 5;
					$min = $_GET['h'] - 4;
					
						if($i <= $max && $i >= $min){
							if($_GET['h'] == $i){
								echo "<li class='active'><span class='current'>$i</span></li>";
							}else{
								echo "<li><a href='?page=master_tindakan&key=$key&kelompok=$kelompok&h=$i'>$i</a></li>";
							}
						}
					}
				?>	
			</ul>
		</div>
	</div>
</div>

<!--untuk menampilkan modal-->
<div class="modal fade" id="modaltindakan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Input Tindakan</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="master_tindakan_proses.php" method="post" enctype="multipart/form-data" role="form">
					<table class="table-judul">
						<tr>
							<td width="20%">Nama Tindakan</td>
							<td width="80%">
								<input type="text" name="namatindakan" style="text-transform: uppercase;" class="form-control" maxlength ="100" required>
							</td>
						</tr>
						<tr>
							<td>Kelompok Tindakan</td>
							<td>
								<select name="kelompoktindakan" class="form-control" required>
									<option value="">--Pilih--</option>
									<?php
									$querytdk = mysqli_query($koneksi,"SELECT * FROM `tbtindakankelompok` order by `KelompokTindakan`");
										while($datatdk = mysqli_fetch_assoc($querytdk)){
											echo "<option value='$datatdk[KelompokTindakan]'>$datatdk[KelompokTindakan]</option>";
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Tarif</td>
							<td>
								<input type="number" name="tarif" class="form-control" maxlength ="20" required>
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

<!--tabel report-->
<div class="printheader">
	<?php
	$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `KodePuskesmas` = '$kodepuskesmas'"));
	if($kodepuskesmas == 'semua'){
	?>
		<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></h4>
		<h4 style="margin:5px;"><b><?php echo $namapuskesmas;?></b></h4>
		<p style="margin:5px;"><?php echo $alamat;?></p>
	<?php
	}else{
	?>
		<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$datapuskesmas['Kota'];?></b></h4>
		<h4 style="margin:5px;"><b>DINAS KESEHATAN</b></h4>
		<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$datapuskesmas['NamaPuskesmas'];?></b></h4>
		<p style="margin:5px;"><?php echo $datapuskesmas['Alamat']?></p>
	<?php	
	}
	?>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN MASTER TINDAKAN</b></h4>
	<br/>
</div>

<div class="row printbody">
	<div class="col-lg-12">
		<table class="table table-condensed" >
			<thead style="font-size:12px;">
				<tr>
					<th width="5%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">No.</th>
					<th width="5%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">Kode</th>
					<th width="30%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">Jenis Tindakan</th>
					<th width="20%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">Kelompok</th>
					<th width="5%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">Harga</th>
					<th width="10%" rowspan="2" style="text-align:center;vertical-align:middle; border:1px dashed #000; padding:3px;">Status</th>
				</tr>
			</thead>
			
			<tbody style="font-size:12px;">				
				<?php
					$str = "select * from `tbtindakan` where Kota = '$kota' AND Status <> 'Bpjs'".$strcari;
							$str2 = $str." order by KodeTindakan";
							echo $str;
					$query = mysqli_query($koneksi,$str2);
					$no = 0;
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
				?>
					<tr>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['KodeTindakan'];?></td>
						<td class="nama" style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['Tindakan'];?></td>
						<td class="nama" style="text-align:left; border:1px dashed #000; padding:3px;"><?php echo $data['KelompokTindakan'];?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo rupiah($data['Tarif']);?></td>
						<td style="text-align:right; border:1px dashed #000; padding:3px;"><?php echo $data['Status'];?></td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>

<script src="assets/js/jquery-2.1.4.min.js"></script>
<script src="assets/js/jquery.autocomplete.js"></script>
<script>
$('.btnmodaltindakanedit').click(function(){
	var kdtdk = $(this).parent().parent().find(".kdtdk").html()
	$.post( "get_modal_tindakan.php", { id: kdtdk })
		.done(function( data ) {
			$( ".hasilmodal" ).html( data );
			$('#modaledittdk').modal('show');
	});					
});
</script>

