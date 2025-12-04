<style>
	#qrcode {
	  width:110px;
	  height:110px;
	  margin-top:15px;
	}
</style>
<!--judul menu-->
<div class="row noprint">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>QR Code <small>Generator</small></h1>
		</div>
	</div>
</div>

<!--Kolom Entry-->
<div class="row">	
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> Entry Data</h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" action="index.php?page=gudang_besar_qrcode_proses" method="post" role="form">
					<div class="table-responsive" style="font-size:12px">
						<table class="table table-striped table-condensed">
							<tr>
								<td class="col-sm-2">Nama Siswa</td>
								<td>:</td>
								<td class="col-sm-10">
									<input type="text" name="namasiswa" class="form-control" required>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Tanggal Lahir</td>
								<td>:</td>
								<td class="col-sm-10">
									<input type="text" name="tgllahir" class="form-control datepicker" placeholder="Pilih Tanggal" required>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">Nama Sekolah</td>
								<td>:</td>
								<td class="col-sm-10">
									<input type="text" name="namasekolah" class="form-control" required>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">
								<td></td>
								<td class="col-sm-10"><button type="submit" class="btn btn-success">Submit</button></td>
								</td>
							</tr>	
						</table>
					</div>
				</form>
				
				<table class="table">
					<tr>
						<th>Nama</th>
						<th>Tanggal Lahir</th>
						<th>Nama Sekolah</th>
						<th>QrCOde</th>
						<th>Aksi</th>
					</tr>
					<?php
						$strqrcode = mysqli_query($koneksi,"SELECT * from tbqrcode");
						while($dtqr = mysqli_fetch_assoc($strqrcode)){
					?>
						<tr>
							<td><?php echo $dtqr['NamaSiswa'];?></td>
							<td><?php echo $dtqr['TanggalLahir'];?></td>
							<td><?php echo $dtqr['NamaSekolah'];?></td>
							<td>
								<input type="hidden" id="text-<?php echo $dtqr['IdSiswa'];?>" value="<?php echo $dtqr['IdSiswa'];?> | <?php echo $dtqr['NamaSiswa'];?> | <?php echo $dtqr['TanggalLahir'];?> | <?php echo $dtqr['NamaSekolah'];?>">
								<div id="qrcode-<?php echo $dtqr['IdSiswa'];?>"></div>
							</td>
							<td>
								<a onClick="return confirm('Anda yakin');" href='?page=gudang_besar_qrcode_delete&id=<?php echo $dtqr['IdSiswa'];?>' class='btn btn-sm btn-danger'>Delete</a>
							</td>
						</tr>
						<script type="text/javascript">
							var qrcode = new QRCode(document.getElementById("qrcode-<?php echo $dtqr['IdSiswa'];?>"), {
								width : 60,
								height : 60
							});
							var elText = document.getElementById("text-<?php echo $dtqr['IdSiswa'];?>").value;
							qrcode.makeCode(elText);
						</script>
					<?php
						}
					?>
				</table>
			</div>
		</div>
	</div>
</div>