<?php
    session_start();
	include "config/helper_pasienrj.php";
	include "config/helper.php";
	include_once('config/koneksi.php');	
	$hariini = date('d-m-Y');
	
	// get
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
    $keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$kodepuskesmas = $_GET['kd'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Kasir (".$hariini.").xls");
	if(isset($keydate1) and isset($keydate2)){
?>
<style>
.tr, th{
	text-align:center;
}
td {
	vertical-align: middle;
}
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
}
.printheader h4{
	font-size:14px;
	font-family: "Poppins", sans-serif;
}
.printheader p{
	font-size:14px;
	font-family: "Poppins", sans-serif;
}
.printbody{
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Poppins", sans-serif;
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
	font-family: "Poppins", sans-serif;
}
.font11{
	font-size:11px;
	font-family: "Poppins", sans-serif;
}
.font14{
	font-size:14px;
	font-family: "Poppins", sans-serif;
}
.str{
	mso-number-format:\@; 
}


@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
	}
	.printheader{
		display:block;
	}
	.printbody{
		display:block;
	}
	.atastabel{
		display:block;
	}
	.bawahtabel{
		display:block;
	}
}
</style>

<div class="printheader">
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN KASIR</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($keydate1))." s/d ".date('d-m-Y', strtotime($keydate2));?></p><br/>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
            <thead>
                <tr>
                    <th width="3%" rowspan="2">NO.</th>
                    <!--<th width="7%" rowspan="2">TGL.DAFTAR</th>-->
                    <th width="8%" rowspan="2">NO.REGISTRASI</th>
                    <th width="15%" rowspan="2">NAMA PASIEN</th>
                    <th width="15%" rowspan="2">ALAMAT</th>
                    <th width="8%" rowspan="2">PELAYANAN</th>
                    <th width="15%" rowspan="2">JENIS TINDAKAN</th>
                    <th width="8%" rowspan="2">CARA BAYAR</th>
                    <th width="15%" colspan="3">TARIF</th>
                    <th width="5%" rowspan="2">TOTAL</th>
                </tr>
                <tr>
                    <th>KASIR</th>
                    <th>KIR</th>
                    <th>TINDAKAN</th>
                </tr>
            </thead>
			<tbody>
                <?php
                $str = "SELECT * FROM `$tbpasienrj`
                WHERE date(TanggalRegistrasi) BETWEEN '$keydate1' AND '$keydate2' AND (`TarifKarcis` != '0' OR `TarifKir` != '0' OR `TarifTindakan` != '0')";
                $str2 = $str." GROUP BY date(TanggalRegistrasi), NamaPasien ORDER BY date(`TanggalRegistrasi`) DESC, `NamaPasien` ASC";
                // echo $str2;
                
                $hariini = '';
                $query = mysqli_query($koneksi, $str2);
                while($data = mysqli_fetch_assoc($query)){
                    $tglreg = date('Y-m-d', strtotime($data['TanggalRegistrasi']));
                    if($hariini != $tglreg){
                        echo "<tr style='border:1px dashed #7a7a7a; font-weight: bold;'><td colspan='11'>$tglreg</td></tr>";
                        $hariini = date('Y-m-d', strtotime($data['TanggalRegistrasi']));
                    }	
                    $no = $no + 1;
                    $noregistrasi = $data['NoRegistrasi'];
                    $noindex = $data['NoIndex'];
                    $kelamin = $data['JenisKelamin'];
                    $pelayanan = $data['PoliPertama'];
                    $carabayar = $data['Asuransi'];						
                    $tarifkarcis = $data['TarifKarcis'];						
                    $tarifkir = $data['TarifKir'];
                    $tariftindakan = $data['TarifTindakan'];
                    $tariftotal	= $tarifkarcis + $tarifkir + $tariftindakan;
                    
                    // tbtindakanpasien
                    $str_tindakan = "SELECT * FROM `$tbtindakanpasien` WHERE `NoRegistrasi`='$noregistrasi'";
                    $query_tindakan = mysqli_query($koneksi, $str_tindakan);
                    while($dt_tindakan = mysqli_fetch_array($query_tindakan)){
                        // tbtindakan
                        $datatindakan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Tindakan`,`Tarif` FROM `tbtindakan` WHERE `IdTindakan`='$dt_tindakan[IdTindakan]'"));
                        $array_tindakan[$no][] = $datatindakan['Tindakan'];
                    }
                    if ($array_tindakan[$no] != ''){
                        $data_tindakan = implode("<br/>", $array_tindakan[$no]);
                    }else{
                        $data_tindakan ="";
                    }	
                    
                    // tbkk
                    $str_kk = "SELECT `NamaKK`, `Alamat`, `RT`, `RW`, `Kelurahan` FROM `$tbkk` WHERE `NoIndex` = '$noindex'";
                    $query_kk = mysqli_query($koneksi,$str_kk);
                    $data_kk = mysqli_fetch_assoc($query_kk);
                    $alamat = $data_kk['Alamat'].", RT.".$data_kk['RT'].", NO.".$data_kk['No'].", ".$data_kk['Kelurahan'];
                    
                    // cek umur kelamin
                    if ($kelamin == 'L'){
                        $umur_l = $data['UmurTahun']." Th";
                        $umur_p = "-";
                    }else{
                        $umur_l = "-";
                        $umur_p = $data['UmurTahun']." Th";
                    }
                    
                ?>
                    <tr>
                        <td align="center"><?php echo $no;?></td>
                        <!--<td align="center"><?php //echo date('d-m-Y', strtotime($data['TanggalRegistrasi']));?></td>-->
                        <td align="center"><?php echo substr($data['NoRegistrasi'],-10);?></td>
                        <td align="left"><?php echo strtoupper($data['NamaPasien']);?></td>
                        <td align="left"><?php echo $alamat;?></td>
                        <td align="left"><?php echo str_replace('POLI ','',$pelayanan);?></td>
                        <td align="left">
                            <?php 
                                if($data_tindakan != ''){
                                    echo strtoupper($data_tindakan);
                                }else{
                                    if($carabayar == "UMUM"){
                                        echo "RETRIBUSI PENDAFTARAN";
                                    }else{
                                        echo "RETRIBUSI KIR";
                                    }	
                                }	
                            ?>
                        </td>
                        <td align="left"><?php echo $carabayar;?></td>
                        <td align="right"><?php echo $tarifkarcis;?></td>
                        <td align="right"><?php echo $tarifkir;?></td>
                        <td align="right"><?php echo $tariftindakan;?></td>
                        <td align="right"><?php echo $tariftotal;?></td>
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