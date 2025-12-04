<?php
include"../config/koneksi.php";
$key = $_POST['key'];
?>
<tr>
	<th>Nama Puskesmas</th>
	<th width="80px">Aksi</th>
</tr>
<?php
$dt = mysqli_query($koneksi,"SELECT * FROM tbpuskesmas WHERE Kota = 'KABUPATEN BANDUNG' AND NamaPuskesmas LIKE '%$key%' ORDER by NamaPuskesmas Limit 5");
while($dtpus = mysqli_fetch_array($dt)){
?>
<tr>
	<td  style="vertical-align:middle"><?php echo $dtpus['NamaPuskesmas'];?></td>
	<td>
		<a href="#" data-kodepus="<?php echo $dtpus['KodePuskesmas'];?>" data-namapus="<?php echo $dtpus['NamaPuskesmas'];?>" class="btn btn-info btnpilihpuskesmas btns btn-lg">Pilih</a>
	</td>
</tr>
<?php
}
?>