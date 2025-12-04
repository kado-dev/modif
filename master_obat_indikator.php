<?php
	$kodepuskesmas =  $_SESSION['kodepuskesmas'];
	$otoritas = explode(',',$_SESSION['otoritas']);
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>DATA OBAT INDIKATOR</b></h3>
			<div class="formbg">				
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="master_obat_indikator"/>
						<div class="col-sm-6">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama Barang" required>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=master_obat_indikator" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="hasilmodal"></div>

	<!--data-->
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<table class="table-judul">
				<thead>
					<tr>
						<th width="3%">NO.</th>
						<th width="17%">KODE BARANG</th>
						<th width="60%">NAMA BARANG</th>
						<th width="20%">SATUAN</th>
						<th width="5%">AKSI</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$key = $_GET['key'];	
					$str = "SELECT * FROM `ref_obatindikator` WHERE (`nama_indikator` like '%$key%' OR `KodeBarang` like '%like%')";
					$str2 = $str." order by nama_indikator";
					// echo $str2;
					// die();
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$kodebarang = $data['KodeBarang'];
						
						// ref_obat_lplpo
						$dtlplpo = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Satuan` FROM `ref_obat_lplpo` WHERE `KodeBarang`='$kodebarang' LIMIT 1"));
						$satuan = $dtlplpo['Satuan'];
					?>
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="center" class="idindikator" style="display: none;"><?php echo $data['id_indikator'];?></td>
							<td align="center"><?php echo $kodebarang;?></td>
							<td align="left"><?php echo strtoupper($data['nama_indikator']);?></td>
							<td align="left"><?php echo $satuan;?></td>
							<td align="center">
								<a href="#" class="btnmodalindikatoredit btn btn-xs btn-info">Edit</a>
							</td>								
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div><hr/>
</div>

<script src="assets/js/jquery.js"></script>
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script src="assets/bootstrapdatepicker/js/bootstrap-datepicker.min.js"></script>
<script>
	$('.btnmodalindikatoredit').click(function(){
		var idindikator = $(this).parent().parent().find(".idindikator").html()
		// alert(idindikator);
		$.post( "get_modal_obat_indikator.php", { id: idindikator })
		  .done(function( data ) {
			 $( ".hasilmodal" ).html( data );
			 $('#modaleditindikator').modal('show');
		});					
	});
</script>
	