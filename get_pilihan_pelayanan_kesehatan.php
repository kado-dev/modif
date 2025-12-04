<?php
session_start();
include "config/koneksi.php";
$jenispelayanan = $_POST['jenispelayanan'];

$query = mysqli_query($koneksi,"SELECT * FROM `tbpelayanankesehatan` WHERE JenisPelayanan = '$jenispelayanan' order by `Pelayanan`");

while($data = mysqli_fetch_assoc($query)){
    if($data['Pelayanan'] == $_SESSION['poliantrian']){
        $stschecked = 'checked';
    }else{
        $stschecked = '';
    }
    ?>
        <label class="radiopilihan">
            <input type="radio" class="opsipolipertama" name="polipertama" value="<?php echo $data['Pelayanan'];?>" <?php echo $stschecked;?>/>
            <img src="image/satusehat.png" width="15px" class="iconpoli"> <?php echo str_replace('POLI ','', $data['Pelayanan']);?>
        </label>
    <?php
}
?>