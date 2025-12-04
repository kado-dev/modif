<style type="text/css">
  .tdkalender{
    cursor: pointer;
  }
  .tables{
    width: 100%
  }
  .tables tr td{
    padding: 10px 5px 10px 0px;
	font-size: 12px;
  }
</style>

<?php
include "config/koneksi.php";
$hari	= date("d");
$bulan	= date ("m");
$tahun	= date("Y");
$jumlahhari=date("t",mktime(0,0,0,$bulan,$hari,$tahun));
?>

<table style="background: #f5f5f5" class="tables">
  <tr bgcolor="#ADD8E6">
  <td align=center><font color="#FF0000">Minggu</font></td>
  <td align=center>Senin</td>
  <td align=center>Selasa</td>
  <td align=center>Rabu</td>
  <td align=center>Kamis</td>
  <td align=center>Jumat</td>
  <td align=center>Sabtu</td>
  </tr>
  <?php
$s=date ("w", mktime (0,0,0,$bulan,1,$tahun));
 
for ($ds=1;$ds<=$s;$ds++) {
echo "<td></td>";
}
 
for ($d=1;$d<=$jumlahhari;$d++) {
  $tgl = $tahun."-".$bulan."-".$d;
  $getdata = mysqli_query($koneksi,"SELECT * FROM tbadm_pendampingan WHERE Tanggal = '$tgl'");
  $bgcolor = "#fff";
  $keterangan = '';
  $tglinfo = '';
  $deskripsi = '';
  if(mysqli_num_rows($getdata) > 0){
    $bgcolor = "red";
    $dtdata = mysqli_fetch_assoc($getdata);
    $keterangan = $dtdata['Puskesmas'];
    $tglinfo = $dtdata['Tanggal'];
	$deskripsi = $dtdata['Keterangan'];
  }

  if (date("w",mktime (0,0,0,$bulan,$d,$tahun)) == 0) {
  	echo "<tr>"; 
  }

  $warna="#000000"; // warna default
   
  if (date("l",mktime (0,0,0,$bulan,$d,$tahun)) == "Sunday") {
    $warna="#FF0000"; 
  }

  echo "<td class='tdkalender' align='center' valign='middle' style='background: ".$bgcolor."' data-keterangan='".$keterangan."' data-tgl='".$tglinfo."' data-deskripsi='".$deskripsi."'> <span style='color:".$warna."'>$d</span></td>"; 

  if (date("w",mktime (0,0,0,$bulan,$d,$tahun)) == 6) {
    echo "</tr>"; 
  }
}
echo '</table>'; 
?>