<div class="kolomkonten2">
<form class="form-inline formnik">
	<input type="hidden" name="page" value="dashboard"/>
	<input name="key" value="<?php echo $_GET['key'];?>" type="text" class="form-control input-lg puskesmas" placeholder="Ketikan Nama Puskesmas"/>
	<button name="button" value="cari" type="submit" class="btn btn-round btn-warning btns"><span class="fa fa-search"></span></button>
</form>	
</div>
<div class="kolomkonten">
	<table class="table table-striped">
		<?php
		if($_GET['key'] == null){
			$dt = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `StatusDaftarOnline`='Y' ORDER by NamaPuskesmas Limit 5");
		}else{
			$key = $_GET['key'];
			$dt = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE NamaPuskesmas LIKE '%$key%' AND `StatusDaftarOnline`='Y' ORDER by NamaPuskesmas Limit 5");
		}		
		if(mysqli_num_rows($dt)>0){
			if(mysqli_num_rows($dt)==1){
				$dtpus = mysqli_fetch_array($dt);
				// header("location:index.php?page=cari&kode=".$dtpus['KodePuskesmas']."&simpus=".$dtpus['NamaPuskesmas']);
				echo "<script>document.location.href='?page=cari&kode=".$dtpus['KodePuskesmas']."&simpus=".$dtpus['NamaPuskesmas']."';</script>";
			}else{	
			while($dtpus = mysqli_fetch_array($dt)){
		?>
			<tr>
				<td style="vertical-align:middle"><?php echo $dtpus['NamaPuskesmas'];?></td>
				<td style="text-align: center;">
					<a href="?page=cari&kode=<?php echo $dtpus['KodePuskesmas'];?>&simpus=<?php echo $dtpus['NamaPuskesmas'];?>" data-kodepus="<?php echo $dtpus['KodePuskesmas'];?>" class="btn btn-round btn-info">PILIH</a>
				</td>
			</tr>
		<?php
			}
			}
		}else{
			echo "<tr><td colspan='2'>Puskesmas belum tersedia untuk daftar online</td></tr>";
		}
		?>
	</table>
</div>

