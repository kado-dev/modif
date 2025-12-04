<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$hariini = $_GET['tgl'];
	
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=Retribusi Karcis (".$namapuskesmas." ".$hariini.").xls");
	if(isset($hariini)){
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
	font-size:24px;
	font-family: "Roboto Condensed", Arial, sans-serif;
}
.printheader p{
	font-size:24px;
	font-family: "Roboto Condensed", Arial, sans-serif;
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
	<h4 style="margin:15px 5px 5px 5px;"><b>RETRIBUSI KARCIS</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo $hariini;?></p>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
    <table class="table-judul-form" border="1" width="100%">
		<thead>
			<tr>
				<th width="5%">NO.</th>
				<th width="60%">NAMA PASIEN</th>
				<th width="15%">POLI</th>
				<th width="15%">JAMINAN</th>
				<th width="10%">TARIF</th>
			</tr>
		</thead>							
		<tbody>
			<?php 
			if($_GET['tgl']==''){
				$caritanggal = " AND TanggalRegistrasi = curdate()"; 
			}else{
				$caritanggal = " AND TanggalRegistrasi = '$_GET[tgl]'";
			}	
			
			$s_karcis = "SELECT `NamaPasien`,`PoliPertama`,`Asuransi`,`TarifKarcis` FROM `$tbpasienrj`
			WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `Asuransi` = 'UMUM'".$caritanggal;
			$str2 = $s_karcis."ORDER BY `NamaPasien`";
									
			$query = mysqli_query($koneksi,$str2);
			while($dt_karcis = mysqli_fetch_assoc($query)){
				$no = $no + 1;
				$namapasien = $dt_karcis['NamaPasien'];
				$polipertama = $dt_karcis['PoliPertama'];
				$asuransi = $dt_karcis['Asuransi'];
				
				// tbpelayanankesehatan
				$dttarif = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Tarif` FROM `tbpelayanankesehatan` WHERE `Pelayanan`='$polipertama'"));
				$tarif = $dttarif['Tarif'];
				$total = $total + $dttarif['Tarif'];
			?>	
			<tr>
				<td align="center"><?php echo $no;?></td>
				<td align="left"><?php echo $namapasien;?></td>
				<td align="left"><?php echo $polipertama;?></td>
				<td align="left"><?php echo $asuransi;?></td>
				<td align="right"><?php echo rupiah($tarif);?></td>
			</tr>
			<?php
			}						
			?>
			<tr>
				<td align="center" colspan="4">TOTAL</td>
				<td align="right"><?php echo rupiah($total);?></td>
			</tr>
		</tbody>
    </table>
	</div>
</div>
<?php
}
?>