<?php
$id = $_GET['id'];
$data = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * from tbflashnews where IdFlashnews = '$id'"));
?>
<div class="tableborderdiv">
	<h3 class="judul"><b>Berita Update</b></h3>	
		<div class="formbg">
		<form class="form-horizontal" action="index.php?page=flash_news_edit_proses" method="post" enctype="multipart/form-data">
			<input type="hidden" name="id" class="idnews" value="<?php echo $data['IdFlashnews'];?>"/>
			<div class="form-group">
				<label class="control-label">Judul</label>
				<input type="text" name="judul" class="form-control" value="<?php echo $data['Judul'];?>" maxlength="50" required>
			</div>
			<div class="form-group">
				<label class="control-label">Isi</label>
				<textarea name="isi" id="editor" class="form-control" required><?php echo $data['Isi'];?></textarea>
			</div>
			<div class="form-group">
				<label class="control-label"></label>
				<button type="submit" class="btn btn-success">UPDATE</button>
			</div>
		</form>
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