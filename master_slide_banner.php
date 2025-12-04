<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>SLIDE BANNER</b></h3>
			<div class="formbg" style="padding: 30px 30px 30px 30px">
				<form action="master_slide_banner_proses.php" method="post" enctype="multipart/form-data" role="form">
					<div class="carousel-item active" id="crl_satu">
						<div class="row">
							<div class="col-sm-12">
								<input type="file" name="image" class="form-control" placeholder="Gambar" required><br/>
								<button type="submit" class="btn btn-round btn-success btnsimpan">SIMPAN</button>
							</div>
						</div>
					</div>
				</form><hr/>
			
				<div class="table-responsive">
					<table class="table-judul">
						<thead>
						  <tr>
							<th width="5%">NO</th>
							<th width="90%">GAMBAR</th>
							<th width="5%">#</th>
						  </tr>
						</thead>
						<tbody>
							<?php			 
							// include "config/koneksi.php";
							$str = "SELECT * FROM `tbbanner`";
							$query = mysqli_query($koneksi,$str);	
							while($data = mysqli_fetch_assoc($query)){	
								$idbanner = $data['IdBanner'];
								$no = $no + 1;
							?>
							<tr>
								<td align="center"><?php echo $no;?></td>
								<td><img id="avatar" class="img-responsive" src="image/banner/<?php echo $data['Banner'];?>" alt="Photo" width="20%"/></td>
								<td>
									<a href="?page=master_slide_banner_delete&id=<?php echo md5($data['IdBanner'])?>&img=<?php echo $data['Banner']?>" class="btn btn-sm btn-danger">Hapus</a>
								</td>
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
</div><br/>