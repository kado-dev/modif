<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper_pasienrj.php');
	include_once('config/helper_report.php');
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$bulanini = date('m');
	$tahun = $_GET['tahun'];
					
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Kunjungan (Usia) (".$tahun.").xls");
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
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN KUNJUNGAN PUSKESMAS</b></h4>
	<p style="margin:1px;">
		<?php if($bulan == 'Semua'){ ?>
			<p style="margin:1px;">Periode Laporan: <?php echo $tahun;?></p>
		<?php }else{ ?>
			<p style="margin:1px;">Periode Laporan: <?php echo $bulan."/".$tahun;?></p>
		<?php } ?>
	</p><br/>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table-judul-laporan-min" width="100%">
			<thead>
				<tr style="border:1px solid #000;">
					<th rowspan="3" width="3%">NO.</th>
					<th rowspan="3" width="17%">NAMA PUSKESMAS</th>
					<th colspan="4">JENIS KUNJUNGAN</th>
					<th rowspan="3">TOTAL</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th colspan="2">RAWAT JALAN</th>
					<th colspan="2">RAWAT INAP</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th>L</th>
					<th>P</th>
					<th>L</th>
					<th>P</th>
				</tr>
			</thead>
			<tbody>
                <?php
                    if($bulan == 'Semua'){
                        $waktu = "YEAR(TanggalRegistrasi) = '$tahun'";
                    }else{
                        $waktu = "YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan'";
                    } 
                    
                    $str = "SELECT * FROM `tbpuskesmas` WHERE `NamaPuskesmas` != 'DINAS KESEHATAN' AND `NamaPuskesmas` != 'UPTD FARMASI'";
                    $str2 = $str."order by `NamaPuskesmas` ASC";
                                        
                    $query = mysqli_query($koneksi, $str2);
                    while($data = mysqli_fetch_assoc($query)){
                        $no = $no + 1;
                        $namapuskesmas = $data['NamaPuskesmas'];
						$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
                        // umur 7-15 Tahun
						$jml_l_rajal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj)AS Jml FROM `$tbpasienrj` WHERE $waktu  AND JenisKelamin = 'L' AND `JenisKunjungan`='1'"));
						$jml_p_rajal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj)AS Jml FROM `$tbpasienrj` WHERE $waktu AND JenisKelamin = 'P' AND `JenisKunjungan`='1'"));
						$jml_l_ranap = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj)AS Jml FROM `$tbpasienrj` WHERE $waktu  AND JenisKelamin = 'L' AND `JenisKunjungan`='2'"));
						$jml_p_ranap = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj)AS Jml FROM `$tbpasienrj` WHERE $waktu AND JenisKelamin = 'P' AND `JenisKunjungan`='2'"));
						
                        // total kunjungan
                        $total = $jml_l['Jml'] + $jml_p['Jml'];
                        
                    ?>
                        <tr style="border:1px solid #000;">
                            <td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
                            <td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namapuskesmas;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml_l_rajal['Jml'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml_p_rajal['Jml'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml_l_ranap['Jml'];?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml_p_ranap['Jml'];?></td>
							<!--total kunjungan-->
                            <td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $total;?></td>
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