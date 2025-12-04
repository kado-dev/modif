<?php
	session_start();
	include "config/koneksi.php";
	$id = $_POST['id'];
	echo $id;
	$str = "select * from `tbpuskesmas` where `KodePuskesmas` = '$id'";
	$query = mysqli_query($koneksi,$str);
	$data = mysqli_fetch_assoc($query);
	$bulan = date('m');
	$tahun = date('Y');

?>
<!--untuk menampilkan modal-->
<div class="modal fade" id="modalbumil1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Data ibu Hamil (Desa/Kelurahan)</h4>
			</div>
			<div class="modal-body">
			
				<form class="form-horizontal" action="index.php?page=master_pegawai_edit_proses" method="post" enctype="multipart/form-data" role="form">
					<table class="table">
						<tr>
							<td class="col-sm-3">KodePuskesmas</td>
							<td>:</td>
							<td class="col-sm-9"><?php echo $data['KodePuskesmas'];?></td>
						</tr>
						<tr>
							<td>Nama Puskesmas</td>
							<td>:</td>
							<td><?php echo $data['NamaPuskesmas'];?></td>
						</tr>
					</table>
				</form>
				
				<div class="row">	
					<div class="col-lg-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h4 class="panel-title"><i class="fa fa-bars"></i> Kelurahan/Desa</h4>
							</div>
							<div class="box-body">
								<div class="table-responsive" style="font-size:12px">
									<table class="table table-hover table-condensed">
										<thead>
											<tr>
												<th>No.</th>
												<th>Kelurahan/Desa</th>
												<th>Jumlah</th>
												<!--<th>Aksi</th>-->
											</tr>
										</thead>
										<tbody>
											<?php			 					
											$str = "select tbkk.Kelurahan AS Kelurahan, count(tbpolikia.NoRegistrasi)AS Jumlah from `tbpolikia` join `$tbkk` on tbpolikia.NoIndex = tbkk.NoIndex
											where MONTH(tbpolikia.TanggalPeriksa)='$bulan' AND YEAR(tbpolikia.TanggalPeriksa)='$tahun'
											AND substring(tbpolikia.NoRegistrasi,1,11) = '$data[KodePuskesmas]' group by tbkk.Kelurahan order by Jumlah DESC";
											// echo $str;
											$no = 0;
											$query = mysqli_query($koneksi,$str);
											while($data = mysqli_fetch_assoc($query)){
											$no = $no + 1;
											$dt_puskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"select NamaPuskesmas from `tbpuskesmas` where KodePuskesmas = '$data[KodePuskesmas]'"));
											?>
												<tr>
													<td width="5%" align="right"><?php echo $no?></td>
													<td width="90%" align="Left"><?php echo $data['Kelurahan'];?></td>
													<td width="5%" align="right"><?php echo $data['Jumlah'];?></td>
													<!--<td><button type="submit" class="btn btn-xs btn-info btnmodalpkmbumil">Lihat</button></td>-->
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
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

