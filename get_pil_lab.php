<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	$nolab = $_POST['nolab'];
	$str = "SELECT IdTindakan,JenisTindakan,KelompokTindakan FROM `tbtindakan` WHERE `KelompokTindakan` = 'Bumil K1' order by JenisTindakan ASC";
	$query = mysqli_query($koneksi,$str);
	$data = mysqli_fetch_assoc($query);
		 														
$no = 0;
$query = mysqli_query($koneksi,$str);
while($data = mysqli_fetch_assoc($query)){
?>
	<tr>
		<td width="5%" align="right"><?php echo $no = $no + 1;?></td>
		<td width="50%" align="Left"><?php echo $data['JenisTindakan'];?></td>
		<td width="20%" align="left"><?php echo $data['KelompokTindakan'];?></td>
		<td width="35%" align="left">
			<input type="text" name="hasilkdtindakan[<?php echo $data['IdTindakan'];?>]" value="" class="form-control">
		</td>
	</tr>

<?php
$kdtind[] = $data['IdTindakan'];
	}

?>
<input type="hidden" value="<?php echo implode(',',$kdtind);?>" name="kdtindakan"/>