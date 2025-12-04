<?php
	include "config/helper_pasienrj.php";
	$otoritas = explode(',',$_SESSION['otoritas']);
?>

<div class="panel-header bg-primary-gradient">
	<div class="page-inner py-5">
		<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
			<div>
				<h2 class="text-white fw-bold">DASHBOARD RANAP</h2>
				<h5 class="text-white op-7">Silahkan input data Ranap</h5>
			</div>
			<div class="ml-md-auto py-2 py-md-0">
				<button type="button" class="btn btn-success btn-round" data-toggle="modal" data-target="#modaltambah">Tambah Data</button>
			</div>
		</div>
	</div>
</div>
<div class="page-inner mt--5">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<form role="form">
						<div class="row">
							<input type="hidden" name="page" value="dashboard_ranap"/>
							<div class="col-sm-6">
								<input type="text" name="key" class="form-control cari" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama Ruangan" required>
							</div>
							<div class="col-sm-4">
								<button type="submit" class="btn btn-round btn-warning btnsubmit"><span class="fa fa-search"></span></button>
								<a href="?page=dashboard_ranap" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!--untuk menampilkan modal-->
<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form class="form-horizontal" action="index.php?page=dashboard_ranap_proses" method="post" enctype="multipart/form-data" role="form">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"> Tambah Tempat Tidur</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<table class="table">
						<tr>
							<td class="col-sm-3">Ruangan</td>
							<td class="col-sm-9">
								<div class="row">
									<input type="text" name="ruangan" class="form-control" maxlength ="20" required>
								</div>
							</td>
						</tr>
						<tr>
							<td>Perawatan</td>
							<td>
								<div class="row">
									<select name="perawatan" class="form-control">
										<option value="-">--Pilih--</option>
										<option value="1">1</option>
										<option value="2">2</option>
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td>Kelas</td>
							<td>
								<div class="row">
									<select name="kelas" class="form-control">
										<option value="-">--Pilih--</option>
										<option value="1">1</option>
										<option value="2">2</option>
									</select>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success btn-round">SIMPAN</button>
					<button type="button" class="btn btn-danger btn-round" data-dismiss="modal">KELUAR</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="hasilmodal"></div>

<div class="page-inner mt--5">
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<tr>
							<th width="5%" rowspan="2">NO.</th>
							<th width="25%" rowspan="2">RUANGAN</th>
							<th width="10%" rowspan="2">PERAWATAN</th>
							<th width="10%" rowspan="2">KELAS</th>
							<th width="10%" rowspan="2">TERSEDIA</th>
							<th width="10%" rowspan="2">TERPAKAI</th>
							<th width="10%" rowspan="2">BELUM SIAP</th>
							<th width="20%" colspan="2">PASIEN</th>
						</tr>
						<tr>
							<th>PRIA</th>
							<th>WANNITA</th>
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
						
						$str = "SELECT * FROM `tbpegawai` WHERE `KodePuskesmas` = '$kodepuskesmas' AND (`NamaPegawai` LIKE '%$key%' OR `Status` LIKE '%$key%' OR `Nip` LIKE '%$key%')";
						$str2 = $str." order by NamaPegawai Asc LIMIT $mulai,$jumlah_perpage";
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
							
							// tbpuskesmas
							$kdpkm = $data['KodePuskesmas'];
							$datapkm = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kdpkm'"));
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td align="left"></td>		
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
				<ul class="pagination mt-4 noprint">
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
									echo "<li><a href='?page=dashboard_ranap&ruangan=$ruangan&h=$i'>$i</a></li>";
								}
							}
						}
					?>	
				</ul>
			</div>	
		</div>
	</div>	
</div>	
	