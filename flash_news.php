<div class="tableborderdiv">
	<h3 class="judul"><b>Berita Update</b></h3>	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<tr>
							<th width="5%">No.</th>
							<th width="10%">Tanggal</th>
							<th width="70%">Judul</th>
							<th width="15%">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$jumlah_perpage = 10;
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
																	
						$str = "SELECT * FROM `tbflashnews`";
						$str2 = $str." ORDER BY IdFlashnews Desc limit $mulai,$jumlah_perpage";
										
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
								<td align="center"><?php echo $data['TglPosting'];?></td>
								<td align="left"><?php echo $data['Judul'];?></td>
								<td align="center">
									<a href="?page=flash_news_edit&id=<?php echo $data['IdFlashnews'];?>" class="btn btn-xs btn-success">Edit</a>
									<a href="?page=flash_news_delete&id=<?php echo $data['IdFlashnews'];?>" class="btn btn-xs btn-danger btnhapus">Hapus</a>
								</td>	
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>	
			</div>
		</div>
		
		<div class="col-sm-12"><br/>
			<div class="formbg">
				<form class="form-horizontal" action="index.php?page=flash_news_proses" method="post" enctype="multipart/form-data">
					<input type="hidden" class="idnews" value="0"/>
					<div class="form-group">
						<label class="control-label">Judul</label>
						<input type="text" name="judul" class="form-control" maxlength="50" required>
					</div>
					<div class="form-group">
						<label class="control-label">Isi</label>
						<textarea name="isi" id="editor" class="form-control" required></textarea>
					</div>
					<div class="form-group">
						<label class="control-label"></label>
						<button type="submit" class="btnsimpan">Submit</button>
					</div>
				</form>
			</div>	
		</div>
	</div>
</div>			

<script src="assets/js/jquery-2.1.4.min.js"></script>
<script src="assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
		var idblog = $(".idnews").val();
		CKEDITOR.replace('editor', {
		  "filebrowserImageUploadUrl": "addphoto.php?id="+idblog,
		});	
	
</script>