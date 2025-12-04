<?php
	$otoritas = $_SESSION['otoritas'];	
	$kodepuskesmas = $_SESSION['kodepuskesmas'];		
	
	if($_POST['btn'] == 'simpan'){
		$kodepuskesmas = $_SESSION['kodepuskesmas'];	
		$idpegawai = $_SESSION['idpegawai'];	
		$modulaplikasi = $_POST['modulaplikasi'];	
		$pertanyaan = $_POST['pertanyaan'];	
		$waktupertanyaan = date('Y-m-d G:i:s');	
						
		// gambar
		$img = $_FILES['image'];
		$nama_img1 = $img['name']; // nama file asli
		if($nama_img1 != ''){
			$ext = pathinfo($nama_img1, PATHINFO_EXTENSION); // proses mendapatkan extensi file
			$tmp = $img['tmp_name']; // tmp file
			$img = date('ymdgis').".".$ext; // proses penamaan file foto
			$namaimg[] = $img;
			copy($tmp,"image/konsultasi/".$img);
			$namafoto = $_POST['namagambar'];
			if($namafoto != ''){
				if(file_exists("image/konsultasi/".$namafoto)){
				unlink("image/konsultasi/".$namafoto);
				}
			}
		}
		
		// insert
		$namaimgs = json_encode($namaimg);
		$str = "INSERT INTO `tbadm_konsultasi`(`KodePuskesmas`,`IdPegawai`,`Modul`,`Pertanyaan`,`Jawaban`,`Gambar`,`WaktuPertanyaan`) VALUES ('$kodepuskesmas','$idpegawai','$modulaplikasi','$pertanyaan','Proses','$namaimgs','$waktupertanyaan')";
		$query = mysqli_query($koneksi, $str);
			
		if($query){	
			echo "<script>";
			echo "alert('Data berhasil disimpan');";
			echo "document.location.href='index.php?page=adm_konsultasi';";
			echo "</script>";
		}else{
			echo "<script>";
			echo "alert('Data gagal disimpan');";
			echo "document.location.href='index.php?page=adm_konsultasi';";
			echo "</script>";
		} 

		//tes komen
	}elseif($_POST['btn'] == 'hapus'){
		$idkonsultasi = $_POST['idkon'];
		$str = "DELETE FROM `tbadm_konsultasi` WHERE `IdKonsultasi`='$idkonsultasi'";
		$query=mysqli_query($koneksi, $str);
		$namagambar = $_POST['namagambar'];
		unlink("image/konsultasi/".$namagambar);
			
		if($query){	
			echo "<script>";
			echo "alert('Data berhasil dihapus');";
			echo "document.location.href='?page=adm_konsultasi';";
			echo "</script>";
		}else{
			echo "<script>";
			echo "alert('Data gagal dihapus');";
			echo "document.location.href='?page=adm_konsultasi';";
			echo "</script>";
		}
	}	
?>
<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
		<h3 class="judul"><b>KONSULTASI SIMPUS</b></h3>
		<div class="formbg">
			<div class = "row">
				<form role="form">
					<input type="hidden" name="page" value="adm_konsultasi"/>
					<div class="col-sm-8">
						<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" Placeholder="Ketikan kata kunci modul / pertanyaan" required>
					</div>
					<div class="col-sm-4">
						<button type="submit" class="btn btn-warning btn-white"><span class="glyphicon glyphicon-search"></span></button>
						<a href="?page=adm_konsultasi" class="btn btn-success btn-white"><span class="glyphicon glyphicon-refresh"></span></a>
						<a style="margin-top: -10px;"><button type="submit" class="btn btn-sm btn-success btnmodaltambah"> Tambah Data</button></a>
					</div>
				</form>
			</div>	
		</div>
	</div>
	
	<!--modal tambah-->
	<div class="modal fade" id="modalkonsultasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">BUAT PERTANYAAN</h4>
				</div>
				<div class="modal-body">
					<form class="form-signin" method="post" enctype="multipart/form-data">
						<table class="table">
							<tr>
								<td class="col-sm-3">Modul Aplikasi</td>
								<td class="col-sm-9">
									<select name="modulaplikasi" class="form-control">
										<option value="Atrian Online">Atrian Online</option>
										<option value="Daftar Online">Daftar Online</option>
										<option value="Pendaftaran">Pendaftaran</option>
										<option value="Pemeriksaan">Pemeriksaan</option>
										<option value="Farmasi">Farmasi</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Pertanyaan</td>
								<td>
									<textarea name="pertanyaan" class="form-control" rows="5" placeholder="Jelaskan secara detail" maxlength="500"></textarea>
								</td>
							</tr>
							<tr>
								<td>Sertakan Gambar</td>
								<td>
									<input type="file" name="image" class="form-control">
									<input type="hidden" name="namagambar" value="<?php echo $datasetting['Gambar'];?>">
								</td>
							</tr>
						</table><hr/>
						<button class="btnsimpan" name="btn" value="simpan" type="submit">Simpan</button>
					</form>
				</div>
			</div>
		</div>
	</div>
			
	<div class="col-xs-12">
		<div class="table-responsive">
			<table class="table-judul" width="100%">
				<thead>
					<tr>
						<th width="5%">No.</th>
						<th width="15%">Tgl.Konsultasi</th>
						<th width="15%">Puskesmas</th>
						<th width="10%">Modul</th>
						<th width="35%">Pertanyaan</th>
						<th width="10%">Jawaban</th>
						<th width="10%">Aksi</th>
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
					
					$kategori = $_GET['kategori'];		
					$key = $_GET['key'];		
					
					if($otoritas == "PROGRAMMER"){				
						$str = "SELECT * FROM `tbadm_konsultasi`";
					}else{
						$str = "SELECT * FROM `tbadm_konsultasi` WHERE `KodePuskesmas`='$kodepuskesmas'";
					}	
					$str2 = $str." order by `IdKonsultasi` DESC LIMIT $mulai,$jumlah_perpage";
					// echo $str2;
					
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$namagambar = json_decode($data['Gambar'],true);
					$kdpuskesmas = $data['KodePuskesmas'];
					?>
						
						<form class="form-signin" method="post" enctype="multipart/form-data">
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="center"><?php echo $data['WaktuPertanyaan'];?></td>
							<td align="left">
								<?php 
									$dtpuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NamaPuskesmas` FROM `tbpuskesmas` WHERE `KodePuskesmas`='$kdpuskesmas'"));
									echo $dtpuskesmas['NamaPuskesmas'];?>
							</td>
							<td align="left"><?php echo $data['Modul'];?></td>
							<td align="left"><?php echo $data['Pertanyaan'];?></td>
							<td align="center">
								<?php 
									if( $data['Jawaban']=="Proses"){
										echo '<span class="badge badge-info">Proses</span>';
									}else{
										echo '<span class="badge badge-success">Sudah</span></br>';
										echo $data['WaktuJawaban'];
									}
								?>
							</td>
							<td align="center">
								<button type="button" class="btn btn-xs btn-info btn-white btnmodallihat" data-idkonsul="<?php echo $data['IdKonsultasi'];?>">Lihat</button>
								<?php if($_SESSION['otoritas'] == 'PROGRAMMER'){ ?>
								<input type="hidden" name="idkon" class="form-control" value="<?php echo $data['IdKonsultasi'];?>"/>
								<input type="hidden" name="namagambar" value="<?php echo $namagambar[0];?>"/>
								<button onClick="return confirm('Anda yakin data dihapus?');" value="hapus" type="submit" name="btn" class="btn btn-xs btn-danger btn-white btnhapusdata">Hapus</button>
								<?php }?>	
							</td>			
						</tr>
						</form>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>	
</div>
		
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
					echo "<li><a href='?page=adm_konsultasi&h=$i'>$i</a></li>";
				}
			}
		}
	?>	
</ul>
<div class="hasilmodal"></div>	
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>	
	$('.btnmodaltambah').click(function(){
		$('#modalkonsultasi').modal('show');
	});	
	
	$(".btnmodallihat").click(function(){
		var idkonsul = $(this).data("idkonsul");
		$.post( "get_modal_konsultasi.php", {idkonsul: idkonsul}).done(function( data ) {
			$( ".hasilmodal" ).html( data );
			$('#modaledit').modal('show');
		});
	});
</script>
