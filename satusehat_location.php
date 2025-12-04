<?php
	include "config/helper_pasienrj.php";
	$otoritas = explode(',',$_SESSION['otoritas']);

?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>Location</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="satusehat_location"/>
						<div class="col-xl-6">
							<input type="text" name="key" class="form-control cari" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama Pelayanan" required>
						</div>
						<div class="col-xl-6">
							<button type="submit" class="btn btn-round btn-warning btnsubmit"><span class="fa fa-search"></span></button>
							<a href="?page=satusehat_location" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
						</div>
					</div>
				</form>		
			</div>
		</div>
	</div>

	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<table class="table-judul table-bordered" width="100%">
				<thead>
					<tr>
						<th width="3%">NO.</th>
						<th width="32%">PELAYANAN</th>
						<th width="55%">ID LOCATION</th>
						<th width="10%">AKSI</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$jumlah_perpage = 50;
					
					if($_GET['h']==''){
						$mulai=0;
					}else{
						$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
							
					$key = $_GET['key'];			
					
					
					$str = "SELECT * FROM `tbpelayanankesehatan` WHERE (`JenisPelayanan` = 'Kunjungan Sakit' OR `JenisPelayanan` = 'Pendaftaran')";
					$str2 = $str." ORDER BY Pelayanan LIMIT $mulai,$jumlah_perpage";
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

						$Satusehat_IdLocation = '';
						$getSidLo = mysqli_query($koneksi, "SELECT * FROM satusehat_location WHERE KodePelayanan = '$data[KodePelayanan]' AND `KodePuskesmas`='$kodepuskesmas'");
						// echo "SELECT * FROM satusehat_location WHERE KodePelayanan = '$data[KodePelayanan]' AND `KodePuskesmas`='$kodepuskesmas'";
						if(mysqli_num_rows($getSidLo) > 0){
							$Satusehat_IdLocation = mysqli_fetch_assoc($getSidLo)['Satusehat_IdLocation'];
						}
					?>
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="left" class="idpelayanan" style="display: none;"><?php echo $data['KodePelayanan'];?></td>
							<td align="left"><?php echo $data['Pelayanan'];?></td>
							<td align="left"><?php echo strtoupper($Satusehat_IdLocation);?></td>
							<td align="center">
								<a href="#" class="btnmodaledit btn btn-sm btn-round btn-primary">EDIT</a>
							</td>								
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div><hr/>
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
						echo "<li><a href='?page=satusehat_location&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>
<div class="hasilmodal"></div>

<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>
	$(document).ready(function() {
		$('.btnmodaledit').click(function(){
			var idpelayanan = $(this).parent().parent().find(".idpelayanan").html()
			// alert(idpelayanan);
			$.post( "get_modal_location.php", { id: idpelayanan })
				.done(function( data ) {
					$( ".hasilmodal" ).html( data );
					$('#modaleditlocation').modal('show');
			});	
		});


	});
</script>
	