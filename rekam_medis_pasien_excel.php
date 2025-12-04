<?php
    session_start();
	include "config/helper_css_laporan.php";
	include "config/helper_pasienrj.php";
	include "config/koneksi.php";
    $key = $_GET['key'];
    $tahun = $_GET['tahun'];
	$lamakunjungan = $_GET['lamakunjungan'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Retensi (".$tahun.").xls");
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
	font-family: "Trebuchet MS";
}
.printheader p{
	font-size:14px;
	font-family: "Trebuchet MS";
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	margin-top:10px;
}
.font14{
	font-size:14px;
	font-family: "Tahoma";
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
	.atastabel{
		display:block;
	}
}
</style>

<div class="printheader">
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN RETENSI</b></h4>
	<p style="margin:1px; font-size: 16px;">
		<p style="margin:1px;">Periode Laporan: <?php echo $tahun;?></p>
	</p><br/>
</div>

<div class="atastabel font14">
	<div style="float:left; width:65%; margin-bottom:0px;">
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5 style="margin:5px;">KODE PUSKESMAS</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".$kodepuskesmas;?></h5 ></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">PUSKESMAS</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".$namapuskesmas;?></h5 ></td>
			</tr>
		</table>
	</div>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
    <table class="table-judul" border="1">
        <thead>
            <tr>
                <th width="3%">NO</th>
                <th width="10%">TGL DAFTAR</th>
                <th width="10%">NO RM</th>
                <th width="10%">NO INDEX</th>
                <th width="20%">NAMA PASIEN</th>
                <th width="22%">ALAMAT</th>
                <th width="15%">TGL KUNJUNGAN<br/>TERAKHIR</th>
                <th width="5%">JUMLAH<br/>KUNJUNGAN</th>
                <th width="10%">DIAGNOSA</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $key = $_GET['key'];
            $lamakunjungan = $_GET['lamakunjungan'];
            $tahun = $_GET['tahun'];
           
             $strlmkunjungan = "";
            if($lamakunjungan !=''){
               if($lamakunjungan == 'less2'){
                   $strlmkunjungan = " AND TIMESTAMPDIFF(year,TanggalDaftar, now()) <= 2";
               }else if($lamakunjungan == 'less3'){
                   $strlmkunjungan = " AND TIMESTAMPDIFF(year,TanggalDaftar, now()) >= 2";
               }	
             }

            if($tahun != 'Semua'){
               $tahuns = " AND SUBSTRING(NoIndex,15,4) = $tahun";
             }else{
               $tahuns = "";	
            }
             $str = "SELECT IdPasien, NoIndex, NoCM, NoRM, NamaPasien, TanggalDaftar, StatusRetensi, TIMESTAMPDIFF(year,TanggalDaftar, now()) as lamakunjungan 
            FROM `$tbpasien`
            WHERE (`NamaPasien` like '%$key%' OR `NoIndex` like '%$key%' OR `NoRM` like '%$key%')".$strlmkunjungan.$tahuns;
             $str2 = $str." ORDER BY NoIndex ASC, NamaPasien DESC";
            // echo $str2;
           
            $query = mysqli_query($koneksi,$str2);
            while($data = mysqli_fetch_assoc($query)){
                $no = $no + 1;
                $idpasien = $data['IdPasien'];
                $noindex = $data['NoIndex'];
                $nocm = $data['NoCM'];
                
                // tbkk
                $dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Alamat`,`RT`,`Kelurahan` FROM `$tbkk` WHERE `NoIndex`='$noindex'"));
                $dttbpasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `NoRegistrasi`,`TanggalRegistrasi` FROM `$tbpasienrj` WHERE `NoCM`='$nocm' AND `StatusPasien` = '1' ORDER BY TanggalRegistrasi DESC Limit 1"));
                $jumlahkunjungan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj)AS Jml FROM `$tbpasienrj` WHERE `NoCM`='$nocm' AND `StatusPasien` = '1' ORDER BY TanggalRegistrasi DESC Limit 1"));
                
            ?>
               <tr>
                    <td align="center"><?php echo $no;?></td>
                    <td align="center"><?php echo date('d-m-Y', strtotime($data['TanggalDaftar']));?></td>
                    <td align="center"><?php echo substr($data['NoRM'],-6);?></td>
                    <td align="center"><?php echo substr($data['NoIndex'],-10);?></td>
                    <td align="left"><?php echo strtoupper($data['NamaPasien']);?></td>
                    <td align="left"><?php echo strtoupper($dtkk['Alamat'].", RT".$dtkk['RT'].", Des/Kel.".$dtkk['Kelurahan']);?></td>
                    <td align="center">
                        <?php 
                            if ($dttbpasienrj['TanggalRegistrasi'] != ''){
                                echo date('d-m-Y', strtotime($dttbpasienrj['TanggalRegistrasi']));
                            }else{
                                echo date('d-m-Y', strtotime($data['TanggalDaftar']));;
                            }
                        ?>
                    </td>
                    <td align="center"><?php echo $jumlahkunjungan['Jml'];?></td>
                    <td align="center">
                        <?php		
                            // diagnosa
                            $data_dgs ="";
                            $noregs = $dttbpasienrj['NoRegistrasi'];
                            $str_diagnosapsn = "SELECT `KodeDiagnosa` FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$noregs' GROUP BY `KodeDiagnosa`";
                            $query_diagnosapsn = mysqli_query($koneksi, $str_diagnosapsn);
                            while($data_diagnosapsn = mysqli_fetch_array($query_diagnosapsn)){
                                $dtdiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_diagnosapsn[KodeDiagnosa]'"));
                                // $array_data[$noregs][] = "<b>".$data_diagnosapsn['KodeDiagnosa']."</b> ".$dtdiagnosa['Diagnosa'];
                                $array_data[$noregs][] = "<b>".$data_diagnosapsn['KodeDiagnosa']."</b> ";
                            }
                            
                            if ($array_data[$noregs] != ''){
                                $data_dgs = implode("<br/>", $array_data[$noregs]);
                            }else{
                                $data_dgs ="";
                            }
                            echo strtoupper($data_dgs);
                        ?>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table><br/>
	</div>
</div>
<?php
}
?>