<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	include_once('config/helper_pasienrj.php');
	// get data
	$tahun = $_GET['tahun'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Lap_Retribusi (".$tahun.").xls");
	if(isset($tahun)){
?>

<style>
.tr, th{
	text-align:center;
}
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
}
.printheader h4{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printbody{
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	margin-top:10px;
}
.bawahtabel{
	margin-top:10px;
	margin-bottom:10px;
	margin-left:-50px;
	margin-right:0px;
	display:none;
}
.font10{
	font-size:10px;
	font-family: "Tahoma";
}
.font11{
	font-size:11px;
	font-family: "Tahoma";
}
.font14{
	font-size:14px;
	font-family: "Tahoma";
}
.str{
	mso-number-format:\@; 
}
</style>

<div class="printheader">
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>RETRIBUSI PUSKESMAS</b></span><br>
	<span class="font12" style="margin:1px;">Periode Laporan: <?php echo $tahun;?></span>
	<br/>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
            <thead style="font-size:10px;">
                <tr style="border:1px solid #000;">
                    <th width="3%" rowspan="3">No.</th>
                    <th width="10%" rowspan="3">Puskesmas</th>
                    <th colspan="24">Jumlah Retribusi Puskesmas</th>
                    <th width="8%" colspan="2" rowspan="2">Total</th>
                </tr>
                <tr style="border:1px solid #000;">
                    <?php
                    for($bln = 1; $bln <= 12;$bln++){
                        echo "<th colspan='2'>".nama_bulan_singkat($bln)."</th>";
                    }
                    ?>
                </tr>
                <tr style="border:1px solid #000;">
                    <?php
                    for($bln = 1; $bln <= 12;$bln++){
                    ?>	
                    <th width="3%">KARCIS</th>
                    <th width="3%">TINDAKAN</th>
                    <?php
                    }
                    ?>
                    <th width="3%">KARCIS</th>
                    <th width="3%">TINDAKAN</th>
                </tr>
            </thead>			
			<tbody style="font-size:10px;">
                <?php						
                $str = "SELECT * FROM `tbpuskesmas` WHERE `Kota` = '$kota'";
                $str2 = $str." ORDER BY `NamaPuskesmas`";
                // echo $str2;
        
                $query = mysqli_query($koneksi, $str2);					
                while($data = mysqli_fetch_assoc($query)){
                    $no = $no + 1;
                    $kdpuskesmas = $data['KodePuskesmas'];
                    $namapuskesmas = $data['NamaPuskesmas'];						
                    $tbpasienrj = 'tbpasienrj_'.str_replace(' ', '', $namapuskesmas);
                    $tbtindakanpasien = "tbtindakanpasien_".str_replace(' ', '', $namapuskesmas);
                    $dt_karcis_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '01' AND `Asuransi`='UMUM'"));
                    $dt_tindakan_1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '01' AND `CaraBayar` ='UMUM'"));
                    $dt_karcis_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '02' AND `Asuransi`='UMUM'"));
                    $dt_tindakan_2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '02' AND `CaraBayar` ='UMUM'"));
                    $dt_karcis_3 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '03' AND `Asuransi`='UMUM'"));
                    $dt_tindakan_3 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '03' AND `CaraBayar` ='UMUM'"));
                    $dt_karcis_4 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '04' AND `Asuransi`='UMUM'"));
                    $dt_tindakan_4 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '04' AND `CaraBayar` ='UMUM'"));
                    $dt_karcis_5 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '05' AND `Asuransi`='UMUM'"));
                    $dt_tindakan_5 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '05' AND `CaraBayar` ='UMUM'"));
                    $dt_karcis_6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '06' AND `Asuransi`='UMUM'"));
                    $dt_tindakan_6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '06' AND `CaraBayar` ='UMUM'"));
                    $dt_karcis_7 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '07' AND `Asuransi`='UMUM'"));
                    $dt_tindakan_7 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '07' AND `CaraBayar` ='UMUM'"));
                    $dt_karcis_8 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '08' AND `Asuransi`='UMUM'"));
                    $dt_tindakan_8 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '08' AND `CaraBayar` ='UMUM'"));
                    $dt_karcis_9 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '09' AND `Asuransi`='UMUM'"));
                    $dt_tindakan_9 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '09' AND `CaraBayar` ='UMUM'"));
                    $dt_karcis_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '10' AND `Asuransi`='UMUM'"));
                    $dt_tindakan_10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '10' AND `CaraBayar` ='UMUM'"));
                    $dt_karcis_11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '11' AND `Asuransi`='UMUM'"));
                    $dt_tindakan_11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '11' AND `CaraBayar` ='UMUM'"));
                    $dt_karcis_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '12' AND `Asuransi`='UMUM'"));
                    $dt_tindakan_12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(`Tarif`)AS Jml FROM `$tbtindakanpasien` WHERE YEAR(TanggalTindakan) = '$tahun' AND MONTH(TanggalTindakan) = '12' AND `CaraBayar` ='UMUM'"));
                    $dt_karcis = $dt_karcis_1['Jml'] + $dt_karcis_2['Jml'] + $dt_karcis_3['Jml'] + $dt_karcis_4['Jml'] + $dt_karcis_5['Jml'] + $dt_karcis_6['Jml'] + $dt_karcis_7['Jml'] + $dt_karcis_8['Jml'] + $dt_karcis_9['Jml'] + $dt_karcis_10['Jml'] + $dt_karcis_11['Jml'] + $dt_karcis_12['Jml'];
                    $dt_tindakan = $dt_tindakan_1['Jml'] + $dt_tindakan_2['Jml'] + $dt_tindakan_3['Jml'] + $dt_tindakan_4['Jml'] + $dt_tindakan_5['Jml'] + $dt_tindakan_6['Jml'] + $dt_tindakan_7['Jml'] + $dt_tindakan_8['Jml'] + $dt_tindakan_9['Jml'] + $dt_tindakan_10['Jml'] + $dt_tindakan_11['Jml'] + $dt_tindakan_12['Jml'];
                    $dtttl = $dt_karcis + $dt_tindakan;
                ?>
                    <tr style="border:1px solid #000;">
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
                        <td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namapuskesmas;?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_1['Jml'] * 7000);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;" class="str"><?php echo rupiah($dt_tindakan_1['Jml']);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_2['Jml'] * 7000);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;" class="str"><?php echo rupiah($dt_tindakan_2['Jml']);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_3['Jml'] * 7000);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;" class="str"><?php echo rupiah($dt_tindakan_3['Jml']);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_4['Jml'] * 7000);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;" class="str"><?php echo rupiah($dt_tindakan_4['Jml']);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_5['Jml'] * 7000);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;" class="str"><?php echo rupiah($dt_tindakan_5['Jml']);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_6['Jml'] * 7000);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;" class="str"><?php echo rupiah($dt_tindakan_6['Jml']);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_7['Jml'] * 7000);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;" class="str"><?php echo rupiah($dt_tindakan_7['Jml']);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_8['Jml'] * 7000);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;" class="str"><?php echo rupiah($dt_tindakan_8['Jml']);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_9['Jml'] * 7000);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;" class="str"><?php echo rupiah($dt_tindakan_9['Jml']);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_10['Jml'] * 7000);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;" class="str"><?php echo rupiah($dt_tindakan_10['Jml']);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_11['Jml'] * 7000);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;" class="str"><?php echo rupiah($dt_tindakan_11['Jml']);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis_12['Jml'] * 7000);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;" class="str"><?php echo rupiah($dt_tindakan_12['Jml']);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_karcis * 7000);?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;" class="str"><?php echo rupiah($dt_tindakan);?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
		</table>
	</div>
</div>
<?php
}
?>