<?php
function base_url(){
	return "https://www.puskesmassabilulungan.com";
}
// tes kolaborasi
include("config/koneksi.php");
	$id = $_GET['id']; 
	$var_file = $_FILES['upload'];
	$nama_file = $var_file['name']; // nama file asli
	$ext = pathinfo($nama_file, PATHINFO_EXTENSION); // proses mengambil extensi file
	$tmp = $var_file['tmp_name']; // sumber file
	
	if($ext == 'jpg' || $ext == 'png' || $ext == 'JPG' || $ext == 'jpeg'){
	
		$nama_baru = "img-".date('Ymdgis')."-".$id.".".$ext;

		$funcNum = $_GET['CKEditorFuncNum'];
		$copy = copy($tmp,'image/flashnews/'.$nama_baru);//proses copy
				
			if($copy){	
				$upload_result = base_url().'/image/flashnews/'. $nama_baru;
				$message = 'Upload success!';


				$strphoto = "INSERT INTO `tbflashnewsimg`(`IdFlashNewsImg`, `IdFlashnews`, `NamaImg`) VALUES ('','$id','$nama_baru')";
				mysqli_query($koneksi,$strphoto);
			}else{
				$message = "File gagal diupload";
				$upload_result = "";
			}
		
	}else{
		$message = "File gagal diupload";
		$upload_result = "";
	}
		echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$upload_result', '$message');</script>";
?>