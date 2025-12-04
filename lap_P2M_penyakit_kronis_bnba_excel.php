<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	// get data
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
    $filterjenispeserta = $_GET['filterjenispeserta'];

	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Penyakit Kronis (".$bulan.'-'.$tahun.").xls");
	if(isset($bulan) and isset($tahun)){
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN PENYAKIT KRONIS</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo $bulan." ".$tahun?></p>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
                    <th width="3%">NO.</th>
                    <th width="12%">Nama Pasien</th>
                    <th width="7%">Tanggal Lahir</th>
                    <th width="20%">Alamat</th>
                    <th>Nik</th>
                    <th>No.BPJS</th>
                    <th>Jenis Peserta</th>
                    <th>Diagnosa</th>
                </tr>
			</thead>
			<tbody>
                <?php
                if($bulan == 'Semua'){
                    $waktu = "YEAR(TanggalDiagnosa) = '$tahun' AND";
                }else{
                    $waktu = "YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND";
                } 

                $str = "SELECT * FROM `tbdiagnosakronis`";
                $str2 = $str."order by `IdDiagnosaKronis` ASC";
                                                            
                $query = mysqli_query($koneksi, $str2);
                while($data = mysqli_fetch_assoc($query)){
                                
                    // tbdiagnosapasien                    
                    $strdiagnosa = "SELECT * FROM `$tbdiagnosapasien` WHERE ".$waktu." `KodeDiagnosa` like '%$data[KodeDiagnosa]%' AND (`Asuransi` != 'UMUM' AND `Asuransi` != 'GRATIS') AND `JenisPeserta` = '$filterjenispeserta'";
                    
                    $querydiagnosa = mysqli_query($koneksi, $strdiagnosa);
                    while($dtdiagnosa = mysqli_fetch_assoc($querydiagnosa)){
                        $no = $no + 1;
                        $idpasienrj = $dtdiagnosa['IdPasienrj'];

                        // tbpasienrj
                        $dtpasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM $tbpasienrj WHERE `IdPasienrj` = '$idpasienrj'"));

                        // tbpasien
                        $dtpasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM $tbpasien WHERE `IdPasien` = '$dtpasienrj[IdPasien]'"));
                        
                        // tbkk
                        $dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM $tbkk WHERE `NoIndex` = '$dtpasienrj[NoIndex]'"));
                
                        // tbdiagnosa
                        $dtnamadiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa`='$dtdiagnosa[KodeDiagnosa]'"));
                        
                ?>
                    <tr style="border:1px solid #000;">
                        <td><?php echo $no;?></td>
                        <td><?php echo $dtpasienrj['NamaPasien'];?></td>
                        <td align="left"><?php echo $dtpasien['TanggalLahir'];?></td>
                        <td><?php echo strtoupper($dtkk['Alamat']);?></td>
                        <td class="str"><?php echo $dtpasien['Nik'];?></td>
                        <td class="str"><?php echo $dtpasien['NoAsuransi'];?></td>
                        <td><?php echo $dtpasienrj['JenisPeserta'];?></td>
                        <td><?php echo $dtdiagnosa['KodeDiagnosa']." - ".$dtnamadiagnosa['Diagnosa'];?></td>
                    </tr>
                <?php
                    }                            
                }
                ?>
            </tbody>
		</table>
	</div>
</div>
<?php
}
?>