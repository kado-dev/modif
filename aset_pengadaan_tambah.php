<div class="tableborderdiv">
	<a href="index.php?page=aset_pengadaan" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i></a>
	<h3 class="judul"><b>PENGADAAN BARANG <small>(Aset)</small></h3>
	<div class="formbg">
		<div class="row">	
			<div class="col-lg-12">
				<form class="form-horizontal" action="?page=aset_pengadaan_tambah_proses" method="post" role="form">	
					<div class="table-responsive">
						<table class="table-judul">
							<tr>
								<td class="col-sm-2">Tgl.Pengadaan</td>
								<td class="col-sm-10">
									<div class="input-group">
										<span class="input-group-addon tesdate">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
										<?php $tgle = explode("-",date ('Y-m-d')); ?>
										<input type="text" name="tanggalpenerimaan" class="form-control datepicker" value="<?php echo $tgle[2]."-".$tgle[1]."-".$tgle[0];?>">
									</div>
								</td>
							</tr>
							<tr>
								<td>Sumber Anggaran</td>
								<td>
									<select name="sumberanggaran" class="form-control" required>
										<option value="DONASI">DONASI</option>
										<option value="JKN">JKN</option>
										<option value="PROGRAM">PROGRAM</option>
										<option value="LAINNYA">LAINNYA</option>
									</select>								
								</td>
							</tr>
							<tr>
								<td>Tahun</td>
								<td>
									<select name="tahunanggaran" class="form-control">
										<?php
											for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
											?>
											<option value="<?php echo $tahun;?>" <?php if($_GET['tahunanggaran'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
										<?php }?>
									</select>						
								</td>
							</tr>
							<tr>
								<td>Supplier</td>
								<td style="overflow-x:hidden">
									<div class="row">
										<div class="col-sm-8">
											<input type="text" name="supplier" class="form-control nama_produsen" Placeholder="Ketikan Nama Supplier" required>
										</div>
										<div class="col-sm-4">
											<input type="text" name="kodesupplier" class="form-control id" readonly>
										</div>
									</div>	
								</td>
							</tr>
							<tr>
								<td>Keterangan</td>
								<td>
									<input type="text" name="keterangan" class="form-control" placeholder="Isikan jika lainnya">
								</td>
							</tr>
						</table><br/>
						<button type="submit" class="btnsimpan">Simpan</button>
					</div>
				</form>		
			</div>		
		</div>		
	</div>	
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<span style="font-weight: normal;">
					<b>Produsen,</b> jika nama tidak ditemukan maka ketik lainnya<br/>
					<b>Keterangan,</b> diisi jika status produsen lainnya<br>
				</span>
			</div>
		</div>
	</div>	
</div>
