<?php
	include_once('config/koneksi.php');
	session_start();
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota = $_SESSION['kota'];
	$kelurahan = $_SESSION['kelurahan'];
	$kecamatan = $_SESSION['kecamatan'];
	$alamat = $_SESSION['alamat'];
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	$opsiform = $_GET['opsiform'];
				
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Kunjungan_Pasien_Perpuskesmas (".$hariini.").xls");
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
	<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b>DINAS KESEHATAN</b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN KUNJUNGAN PASIEN (PUSKESMAS) PERTAHUN</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo "Tahun ".$tahun;?></p><br/>
</div>
<br/>

<?php
	$kategori = $_GET['kategori'];		
	$key = $_GET['key'];				
	
	if($kategori !='' && $key !=''){
		if($kategori == 'Expire'){
			$strcari = " and datediff(Expire,current_date()) < '180'";
		}else{
			$strcari = " and ".$kategori." Like '%$key%'";
		}
	}else{
		$strcari = " ";
	}
		
	$str = "SELECT * FROM `tbgfkstok` WHERE `Stok` > '0' AND `SumberAnggaran` != 'BLUD'".$strcari;
	$str2 = $str." order by NamaBarang";
?>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead style="font-size:9.5px;">
				<tr style="border:1px solid #000;">
					<th width="3%" rowspan="2">No.</th>
					<th width="10%" rowspan="2">Puskesmas</th>
					<th colspan="12">Jumlah Kunjungan</th>
					<th width="8%">Total</th>
				</tr>
				<tr style="border:1px solid #000;">
					<?php
					for($bln = 1; $bln <= 12;$bln++){
						echo "<th style='text-align:center vertical-align:middle; border:1px solid #000; padding:3px;'>".$bln."</th>";
					}
					?>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
				<?php
				$no = 0;
				$str = "SELECT * FROM `tbpuskesmas` WHERE `Kota` = '$kota'".$semua;
				$str2 = $str." ORDER BY NamaPuskesmas";
				// echo $str2;
				
				$query = mysqli_query($koneksi, $str2);					
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$kdpuskesmas = $data['KodePuskesmas'];
					$namapuskesmas = $data['NamaPuskesmas'];						
					
					if ($tahun == date('Y')){
						$dtrj1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_01` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_02` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj3 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_03` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj4 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_04` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj5 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_05` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_06` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj7 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_07` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj8 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_08` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj9 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_09` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_10` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_11` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_12` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
					}else{
						$dtrj1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_01_bc` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_02_bc` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj3 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_03_bc` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj4 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_04_bc` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj5 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_05_bc` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj6 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_06_bc` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj7 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_07_bc` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj8 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_08_bc` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj9 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_09_bc` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj10 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_10_bc` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj11 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_11_bc` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
						$dtrj12 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`)AS Jml FROM `tbpasienrj_12_bc` WHERE YEAR(TanggalRegistrasi) = '$tahun' AND SUBSTRING(NoRegistrasi,1,11)='$kdpuskesmas'"));
					}	
					$dtttl = $dtrj1['Jml'] + $dtrj2['Jml'] + $dtrj3['Jml'] + $dtrj4['Jml'] + $dtrj5['Jml'] + $dtrj6['Jml'] + $dtrj7['Jml'] + $dtrj8['Jml'] + $dtrj9['Jml'] + $dtrj10['Jml'] + $dtrj11['Jml'] + $dtrj12['Jml'];
				?>
					<tr style="border:1px solid #000;">
						<td><?php echo $no;?></td>
						<td><?php echo $namapuskesmas;?></td>
						<td><?php echo $dtrj1['Jml'];?></td>
						<td><?php echo $dtrj2['Jml'];?></td>
						<td><?php echo $dtrj3['Jml'];?></td>
						<td><?php echo $dtrj4['Jml'];?></td>
						<td><?php echo $dtrj5['Jml'];?></td>
						<td><?php echo $dtrj6['Jml'];?></td>
						<td><?php echo $dtrj7['Jml'];?></td>
						<td><?php echo $dtrj8['Jml'];?></td>
						<td><?php echo $dtrj9['Jml'];?></td>
						<td><?php echo $dtrj10['Jml'];?></td>
						<td><?php echo $dtrj11['Jml'];?></td>
						<td><?php echo $dtrj12['Jml'];?></td>
						<td><?php echo $dtttl;?></td>	
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