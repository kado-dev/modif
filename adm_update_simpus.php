<?php
	$kodepuskesmas =  $_SESSION['kodepuskesmas'];
	$otoritas = explode(',',$_SESSION['otoritas']);
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=dashboard" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul"><b>UPDATE APLIKASI</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="adm_update_simpus"/>
						<div class="col-xl-6">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Kata Kunci (Judul / Kategori)" required>
						</div>
						<div class="col-xl-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=adm_update_simpus" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<?php
								if(in_array("PROGRAMMER", $otoritas)){ 
							?>
							<button type="submit" class="btn btn-round btn-success btnmodalpegawai">Tambah Data</button>
							<?php } ?>
						</div>
					</div>	
				</form>	
			</div>
		</div>
	</div>

	<!--untuk menampilkan modal-->
	<div class="modal fade" id="modalpegawai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">TAMBAH DATA</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" action="index.php?page=adm_update_simpus_proses" method="post" enctype="multipart/form-data" role="form">
						<table class="table-judul" width="100%">
							<tr>
								<td class="col-sm-3">Tanggal Update</td>
								<td class="col-sm-9">
									<input type="text" name="tanggalupdate" class="form-control datepicker tglreg" value="<?php echo date("d-m-Y");;?>" autofocus>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Judul</td>
								<td class="col-sm-9">
									<input type="text" name="judul" style="text-transform: uppercase;" class="form-control" maxlength ="50" required>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Deskripsi</td>
								<td class="col-sm-9">
									<textarea name="deskripsi" class="form-control" style="text-transform: uppercase; height: 150px !important;"maxlength="300" required></textarea>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Kategori</td>
								<td class="col-sm-10">
									<select name="kategori" class="form-control" required>
										<option value="">--Pilih--</option>
										<option value="ANTRIAN">ANTRIAN</option>
										<option value="ANJUNGAN DAFTAR MANDIRI">ANJUNGAN DAFTAR MANDIRI</option>
										<option value="DAFTAR ONLINE">DAFTAR ONLINE</option>
										<option value="MASTER DATA">MASTER DATA</option>
										<option value="PENDAFTARAN">PENDAFTARAN</option>
										<option value="PEMERIKSAAN">PEMERIKSAAN</option>
										<option value="FARMASI">FARMASI</option>
										<option value="PELAPORAN">PELAPORAN</option>
										<option value="WEB SERVICE">WEB SERVICE</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Versi</td>
								<td class="col-sm-10">
									<select name="versi" class="form-control" required>
										<option value="">--Pilih--</option>
										<option value="2.1">2.1</option>
										<option value="2.2">2.2</option>
										<option value="2.3 FREE OPEN SOURCE">2.3 FREE OPEN SOURCE</option>
										<option value="2.4 FREE OPEN SOURCE">2.4 FREE OPEN SOURCE</option>
										<option value="2.5 FREE OPEN SOURCE">2.5 FREE OPEN SOURCE</option>
									</select>
								</td>
							</tr>
						</table><hr/>
						<button type="submit" class="btn btn-round btn-success btnsimpan">SIMPAN</button>
					</form>
				</div>
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
						<th width="5%">NO.</th>
						<th width="15%">TANGGAL UPDATE</th>
						<th width="20%">JUDUL</th>
						<th width="20%">KATEGORI</th>
						<th width="20%">VERSI</th>
						<th width="20%">#</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$jumlah_perpage = 20;
					
					if($_GET['h']==''){
						$mulai=0;
					}else{
						$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
							
					$key = $_GET['key'];	

					if($key != ""){
						$cari = " WHERE (`Judul` like '%$key%' OR `Kategori` like '%$key%') ";
					}else{
						$cari = "";
					}	
					
					$str = "SELECT * FROM `tbupdatesimpus`".$cari;
					$str2 = $str." order by TanggalUpdate DESC LIMIT $mulai,$jumlah_perpage";
					// echo var_dump($str2);
					//die();
					
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
							<td align="left" class="idupdate" style="display:none"><?php echo $data['IdUpdate'];?></td>
							<td align="left"><?php echo $data['TanggalUpdate'];?></td>
							<td align="left"><?php echo $data['Judul'];?></td>
							<td align="left"><?php echo $data['Kategori'];?></td>
							<td align="center"><?php echo $data['Versi'];?></td>
							<td align="center">
								<a href="#" class="btnmodallihat btn btn-sm btn-round btn-info">Lihat</a>
								<?php if(in_array("PROGRAMMER", $otoritas)){ ?>
								<a href="#" class="btnmodaledit btn btn-sm btn-round btn-primary">Edit</a>
								<a href="?page=adm_update_simpus_delete&id=<?php echo $data['IdUpdate'];?>" class="btn btn-sm btn-round btn-danger" onClick="return confirm('Data ingin dihapus...?')">Hapus</a>
								<?php } ?>	
							</td>	
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
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
						echo "<li><a href='?page=adm_update_simpus&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>	
<div class="hasilmodal"></div>
<script src="assets/js/jquery.js"></script>
<script src="assets/js/jquery.autocomplete.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.btnmodaledit').click(function(){
			var idupdate = $(this).parent().parent().find(".idupdate").html()
			// alert(idupdate);
			$.post( "get_modal_updatesimpus.php", { id: idupdate })
			  .done(function( data ) {
				 $( ".hasilmodal" ).html( data );
				 $('#modaleditsimpus').modal('show');
			});					
		});
		
		$('.btnmodallihat').click(function(){
			var idupdate = $(this).parent().parent().find(".idupdate").html()
			// alert(idupdate);
			$.post( "get_modal_updatesimpus_lihat.php", { id: idupdate })
			.done(function( data ) {
				 $( ".hasilmodal" ).html( data );
				 $('#modallihatupdate').modal('show');
			});					
		});
	});
</script>
	