<?php		
session_start();
include"config/koneksi.php";
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$namapuskesmas = $_SESSION['namapuskesmas'];	
include "config/helper_pasienrj.php";

$key = $_GET['key'];
$tgl = $_GET['tgl'];
$parameter = $_GET['parameter'];
$status = $_GET['status'];

$str = "SELECT `IdPasienrj`, `TanggalRegistrasi`, `NoRegistrasi`, `NoIndex`, `NamaPasien`, `PoliPertama`, `StatusPelayanan`, `Klaster`, `SiklusHidup`
FROM `$tbpasienrj`
WHERE NamaPasien != '' AND `AsalPasien`='10'";

if($parameter != ''){
	$str.=" AND PoliPertama = '".$parameter."'";
}else{
	$str.= " ";
}

if($key != ''){
	$str.=" AND NamaPasien like '%".$key."%'";
}

if($tgl != ''){
	$str.=" AND date(TanggalRegistrasi) = '".date('Y-m-d',strtotime($tgl))."'";
}

if($status == 'Antri'){
	$str.=" AND `StatusPelayanan` = '".$status."' AND `AsalPasien`='10' AND `StatusPasien`='1'";
}else{
	$str.= "AND (`StatusPelayanan`='Proses' or `StatusPelayanan`='Sudah') AND `AsalPasien`='10' AND `StatusPasien`='1'";
}
$str.=" ORDER BY `IdPasienrj` ASC";
// echo $str;

$query = mysqli_query($koneksi, $str);
if(mysqli_num_rows($query) > 0){
	$n = 0;
	while($data = mysqli_fetch_assoc($query)){
		$n++;
?>
	<a href="#" data-idreg="<?php echo $data['IdPasienrj'];?>" class="<?php echo ($n == 1) ? 'active' : ''?>">
		<?php echo $data['NamaPasien'];?><br/>
		<?php echo $data['PoliPertama'];?><br/>
		<?php echo $data['Klaster'];?><br/>
		<?php echo $data['SiklusHidup'];?><br/>
		<?php echo $data['TanggalRegistrasi'];?><br/>
		<?php if($data['StatusPelayanan'] == 'Sudah'){ ?>
				<span class="badgepanel"><?php echo $data['StatusPelayanan'];?></span>
		<?php }else{ ?>
				<span class="badgeinfo"><?php echo $data['StatusPelayanan'];?></span>
		<?php }	?>
		
	</a>
<?php
	}
}else{
	echo "<a href='#'>Tidak ada data</a>";
}
?>