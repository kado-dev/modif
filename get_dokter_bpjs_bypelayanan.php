<?php
session_start();
include('config/koneksi.php');
include('config/helper_pasienrj.php');
include('config/helper_bpjs_antrean_v2.php');
$kodepuskesmas = $_SESSION['kodepuskesmas'];

if($kota == "KOTA TARAKAN"){
    date_default_timezone_set('Asia/Ujung_Pandang');
}else{
    date_default_timezone_set('Asia/Jakarta');
}

$pelayanan = $_POST['kodepoli'];
$kodepoli = '001';//default 001
$getkodepoli = mysqli_query($koneksi, "SELECT * FROM `tbpelayanankesehatan` WHERE Pelayanan = '$pelayanan' order by `Pelayanan`");
if(mysqli_num_rows($getkodepoli) > 0){
    $dtpoli = mysqli_fetch_assoc($getkodepoli);
    $kodepoli = $dtpoli['kdPoli'];
}				

$tanggal = date('Y-m-d');
$get = get_data_dokter_antrean_fktp($kodepoli, $tanggal);
// echo $get;
$dtarray = json_decode($get,true);
$dt = $dtarray['response'];
// echo "<option value=''>--Pilih--</option>";

if($dt != null){
    $jmldok = count($dt);
    foreach($dt as $dok){
        ?>
        <label class="radiopilihan_dokter <?php if($jmldok == 1){echo 'active';}?>">
            <input type="radio" class="opsidokter" name="dokterbpjs" value="<?php echo $dok['kodedokter']."/".$dok['namadokter']."/".$dok['jampraktek'];?>" data-jampraktek="<?php echo $dok['jampraktek'];?>"  <?php if($jmldok == 1){echo 'checked';}?>/>
            <i class="fa fa-user"></i> <?php echo $dok['namadokter'] ;?>
        </label>
        <?php
    }
}else{
    $getdokterbpjs = mysqli_query($koneksi, "SELECT * FROM `tbpegawaibpjsjadwal` WHERE `kodepoli` = '$kodepoli' AND `kdpuskesmas`='$kodepuskesmas' order by `namadokter`");
    if(mysqli_num_rows($getdokterbpjs) > 0){
        $jmldok = mysqli_num_rows($getdokterbpjs);
        while($dok = mysqli_fetch_assoc($getdokterbpjs)){
            ?>
                <label class="radiopilihan_dokter <?php if($jmldok == 1){echo 'active';}?>">
                    <input type="radio" class="opsidokter" name="dokterbpjs" value="<?php echo $dok['kodedokter']."/".$dok['namadokter']."/".$dok['jampraktek'];?>" data-jampraktek="<?php echo $dok['jampraktek'];?>"  <?php if($jmldok == 1){echo 'checked';}?>/>
                    <i class="fa fa-user"></i> <?php echo $dok['namadokter'] ;?>
                </label>
            <?php
        }
    }else{
        //echo "<option value=''>Tidak ada data</option>";
        ?>
            <label class="radiopilihan_dokter">
                <input type="radio" class="opsidokter" name="dokterbpjs" value="0" data-jampraktek="0"/>
                Tidak ada dokter
            </label>
        <?php
    }
}


?>