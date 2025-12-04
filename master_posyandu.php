<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-4">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white fw-bold">Data Posyandu</h2>
			</div>
		</div>
	</div>
</div>

<div class="page-inner mt--5">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<form method="get">
						<input type="hidden" name="page" value="master_posyandu">
						<div class="row">
							<div class="col-xl-8">
								<input type="text" name="key" class="form-control inputan cari" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama Posyandu" minlenght="2">
							</div>
							<div class="col-xl-4">
								<button type="submit" class="btn btn-warning btn-round btnsubmit"><span class="fa fa-search"></span></button>
								<a href="?page=master_posyandu" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
								<button type="button" class="btn btn-success btn-round" data-toggle="modal" data-target="#modaltambah"><span class="fa fa-plus"></span> Posyandu</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!--untuk menampilkan modal-->
	<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form class="form-horizontal" action="index.php?page=master_posyandu_proses" method="post" enctype="multipart/form-data" role="form">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel"> Tambah Data Posyandu</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<table class="table-konten" width="100%">
							<tr>
                                <td width="30%">Nama Posyandu</td>
                                <td width="70%">
                                    <input type="text" name="namaposyandu" class="form-control" placeholder="Nama Posyandu" required>
                                </td>
                            </tr>
							<tr>
                                <td>Alamat Posyandu</td>
                                <td>
                                    <textarea name="alamatposyandu" class="form-control" placeholder="Alamat Posyandu" required></textarea>
                                </td>
                            </tr>					
						</table>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-round btn-success btnsimpan">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<table class="table-judul">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="10%">Kode Puskesmas</th>                         
						<th width="30%">Nama Posyandu</th>                         
						<th>Alamat</th>                         
						<th width="5%">#</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$jumlah_perpage = 200;
					
					if($_GET['h']==''){
						$mulai=0;
					}else{
						$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
							
					$key = $_GET['key'];				
					
					
					$str = "SELECT * FROM `ref_posyandu` WHERE (`NamaPosyandu` LIKE '%$key%')";
					$str2 = $str." WHERE `KodePuskesmas`='$kodepuskesmas' ORDER BY NamaPosyandu ASC LIMIT $mulai,$jumlah_perpage";
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
							<td align="center"><?php echo $data['KodePuskesmas'];?></td>
							<td align="left" class="idposyandu" style="display: none;"><?php echo $data['IdPosyandu'];?></td>
							<td align="left"> <?php echo $data['NamaPosyandu'];?><br/> </td>
							<td align="left"> <?php echo $data['AlamatPosyandu'];?><br/> </td>
							<td align="center">
								<a href="#" class="btnmodalposyanduedit btn btn-sm btn-round btn-info">Edit</a>
								<!-- <a href="?page=master_posyandu_delete&nip=<?php echo $data['Nip'];?>" data-ketconfirm="Apakah data ini akan dihapus?" class="btn btn-sm btn-round btn-danger btnconfirm">Hapus</a> -->
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
						echo "<li><a href='?page=master_posyandu&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>

<div class="hasilmodal"></div>

<script src="assets_atlantis/js/core/jquery.3.2.1.min.js"></script>
<script>
$('.btnmodalposyanduedit').click(function(){
	var idposyandu = $(this).parent().parent().find(".idposyandu").html()
	// alert(idposyandu);
	$.post( "get_modal_posyandu.php", { id: idposyandu })
	  .done(function( data ) {
		// alert(data);
		 $( ".hasilmodal" ).html( data );
		 $('#modaleditdata').modal('show');
	});	
});
</script>


