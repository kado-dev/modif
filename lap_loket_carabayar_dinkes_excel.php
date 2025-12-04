<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	include_once('config/helper_pasienrj.php');
	// get data
	$tahun = $_GET['tahun'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Lap_CaraBayar (".$tahun.").xls");
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
</style>

<div class="printheader">
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>CARA BAYAR</b></span><br>
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
                    <th colspan="48">Jumlah Kunjungan</th>
                    <th width="8%" rowspan="3">Total</th>
                </tr>
                <tr style="border:1px solid #000;">
                    <?php
                    for($bln = 1; $bln <= 12;$bln++){
                        echo "<th colspan='4'>".nama_bulan_singkat($bln)."</th>";
                    }
                    ?>
                </tr>
                <tr style="border:1px solid #000;">
                    <?php
                    for($bln = 1; $bln <= 12;$bln++){
                    ?>	
                    <th width="3%">UMUM</th>
                    <th width="3%">BPJS</th>
                    <th width="3%">GRATIS</th>
                    <th width="3%">SKTM</th>
                    <?php
                    }
                    ?>
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
                    $dtrj1_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '01' AND `Asuransi`='UMUM'"));
                    $dtrj1_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '01' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
                    $dtrj1_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '01' AND `Asuransi`='GRATIS'"));
                    $dtrj1_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '01' AND `Asuransi`='SKTM'"));
                    $dtrj2_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '02' AND `Asuransi`='UMUM'"));
                    $dtrj2_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '02' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
                    $dtrj2_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '02' AND `Asuransi`='GRATIS'"));
                    $dtrj2_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '02' AND `Asuransi`='SKTM'"));
                    $dtrj3_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '03' AND `Asuransi`='UMUM'"));
                    $dtrj3_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '03' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
                    $dtrj3_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '03' AND `Asuransi`='GRATIS'"));
                    $dtrj3_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '03' AND `Asuransi`='SKTM'"));
                    $dtrj4_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '04' AND `Asuransi`='UMUM'"));
                    $dtrj4_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '04' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
                    $dtrj4_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '04' AND `Asuransi`='GRATIS'"));
                    $dtrj4_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '04' AND `Asuransi`='SKTM'"));
                    $dtrj5_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '05' AND `Asuransi`='UMUM'"));
                    $dtrj5_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '05' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
                    $dtrj5_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '05' AND `Asuransi`='GRATIS'"));
                    $dtrj5_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '05' AND `Asuransi`='SKTM'"));
                    $dtrj6_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '06' AND `Asuransi`='UMUM'"));
                    $dtrj6_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '06' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
                    $dtrj6_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '06' AND `Asuransi`='GRATIS'"));
                    $dtrj6_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '06' AND `Asuransi`='SKTM'"));
                    $dtrj7_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '07' AND `Asuransi`='UMUM'"));
                    $dtrj7_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '07' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
                    $dtrj7_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '07' AND `Asuransi`='GRATIS'"));
                    $dtrj7_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '07' AND `Asuransi`='SKTM'"));
                    $dtrj8_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '08' AND `Asuransi`='UMUM'"));
                    $dtrj8_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '08' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
                    $dtrj8_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '08' AND `Asuransi`='GRATIS'"));
                    $dtrj8_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '08' AND `Asuransi`='SKTM'"));
                    $dtrj9_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '09' AND `Asuransi`='UMUM'"));
                    $dtrj9_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '09' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
                    $dtrj9_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '09' AND `Asuransi`='GRATIS'"));
                    $dtrj9_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '09' AND `Asuransi`='SKTM'"));
                    $dtrj10_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '10' AND `Asuransi`='UMUM'"));
                    $dtrj10_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '10' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
                    $dtrj10_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '10' AND `Asuransi`='GRATIS'"));
                    $dtrj10_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '10' AND `Asuransi`='SKTM'"));
                    $dtrj11_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '11' AND `Asuransi`='UMUM'"));
                    $dtrj11_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '11' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
                    $dtrj11_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '11' AND `Asuransi`='GRATIS'"));
                    $dtrj11_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '11' AND `Asuransi`='SKTM'"));
                    $dtrj12_umum = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '12' AND `Asuransi`='UMUM'"));
                    $dtrj12_bpjs = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '12' AND (`Asuransi`='BPJS PBI' OR `Asuransi`='BPJS NON PBI')"));
                    $dtrj12_gratis = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '12' AND `Asuransi`='GRATIS'"));
                    $dtrj12_sktm = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`IdPasienrj`)AS Jml FROM `$tbpasienrj` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '12' AND `Asuransi`='SKTM'"));
                    $dtttl_umum = $dtrj1_umum['Jml'] + $dtrj2_umum['Jml'] + $dtrj3_umum['Jml'] + $dtrj4_umum['Jml'] + $dtrj5_umum['Jml'] + $dtrj6_umum['Jml'] + $dtrj7_umum['Jml'] + $dtrj8_umum['Jml'] + $dtrj9_umum['Jml'] + $dtrj10_umum['Jml'] + $dtrj11_umum['Jml'] + $dtrj12_umum['Jml'];
                    $dtttl_bpjs = $dtrj1_bpjs['Jml'] + $dtrj2_bpjs['Jml'] + $dtrj3_bpjs['Jml'] + $dtrj4_bpjs['Jml'] + $dtrj5_bpjs['Jml'] + $dtrj6_bpjs['Jml'] + $dtrj7_bpjs['Jml'] + $dtrj8_bpjs['Jml'] + $dtrj9_bpjs['Jml'] + $dtrj10_bpjs['Jml'] + $dtrj11_bpjs['Jml'] + $dtrj12_bpjs['Jml'];
                    $dtttl_gratis = $dtrj1_gratis['Jml'] + $dtrj2_gratis['Jml'] + $dtrj3_gratis['Jml'] + $dtrj4_gratis['Jml'] + $dtrj5_gratis['Jml'] + $dtrj6_gratis['Jml'] + $dtrj7_gratis['Jml'] + $dtrj8_gratis['Jml'] + $dtrj9_gratis['Jml'] + $dtrj10_gratis['Jml'] + $dtrj11_gratis['Jml'] + $dtrj12_gratis['Jml'];
                    $dtttl_sktm = $dtrj1_sktm['Jml'] + $dtrj2_sktm['Jml'] + $dtrj3_sktm['Jml'] + $dtrj4_sktm['Jml'] + $dtrj5_sktm['Jml'] + $dtrj6_sktm['Jml'] + $dtrj7_sktm['Jml'] + $dtrj8_sktm['Jml'] + $dtrj9_sktm['Jml'] + $dtrj10_sktm['Jml'] + $dtrj11_sktm['Jml'] + $dtrj12_sktm['Jml'];
                    $dtttl = $dtttl_umum + $dtttl_bpjs + $dtttl_gratis;
                ?>
                    <tr style="border:1px solid #000;">
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
                        <td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namapuskesmas;?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj1_umum['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj1_bpjs['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj1_gratis['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj1_sktm['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj2_umum['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj2_bpjs['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj2_gratis['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj2_sktm['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj3_umum['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj3_bpjs['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj3_gratis['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj3_sktm['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj4_umum['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj4_bpjs['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj4_gratis['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj4_sktm['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj5_umum['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj5_bpjs['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj5_gratis['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj5_sktm['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj6_umum['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj6_bpjs['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj6_gratis['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj6_sktm['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj7_umum['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj7_bpjs['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj7_gratis['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj7_sktm['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj8_umum['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj8_bpjs['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj8_gratis['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj8_sktm['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj9_umum['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj9_bpjs['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj9_gratis['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj9_sktm['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj10_umum['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj10_bpjs['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj10_gratis['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj10_sktm['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj11_umum['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj11_bpjs['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj11_gratis['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj11_sktm['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj12_umum['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj12_bpjs['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj12_gratis['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtrj12_sktm['Jml'];?></td>
                        <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $dtttl;?></td>	
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