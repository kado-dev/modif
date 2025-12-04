<table class="table-judul mt-2" width="100%">
<?php
include "config/koneksi.php";
$id = $_POST['id'];
$key = $_POST['key'];
$search = "";
if($key != ''){
    $search = " WHERE NamaSkrining LIKE '%".$key."%'";
}
$str = "SELECT * FROM `ref_skrining`".$search." ORDER By NamaSkrining ASC";
					
$query = mysqli_query($koneksi,$str);
while($dt = mysqli_fetch_assoc($query)){
    $ceks = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `siklushidup_skrining` WHERE `IdSiklusHidup` = '$id' AND `IdSkrining` = '$dt[IdSkrining]'"));

    if($ceks > 0){
        echo "<tr><td><input type='checkbox' name='list[]' value='".$dt['IdSkrining']."' checked></td><td>".$dt['NamaSkrining']."</td></tr>";
    }else{
        echo "<tr><td><input type='checkbox' name='list[]' value='".$dt['IdSkrining']."'></td><td>".$dt['NamaSkrining']."</td></tr>";
    }
    
}
?>
<input type="hidden" name="IdSiklusHidup" value="<?php echo $id;?>">
</table>