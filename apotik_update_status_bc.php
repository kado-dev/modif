<?php
	include "config/helper_pasienrj.php";
	$status = $_GET['status'];
?>

<style>
.printheader{
	margin-top:30px;
	margin-left:5px;
	margin-right:0px;
	text-align:center;
	width:48%;
	line-height:10px;
}

.printheader h4{
	font-size:12px;
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}

.printheader p{
	font-size:11px;
}

.printbody{
	margin-left:5px;
	margin-right:-2px;
}

.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}

.atastabel{
	display:none;
	margin-top:10px;
}

.bawahtabel{
	margin-top:20px;
	margin-bottom:10px;
	margin-left:50px;
	display:none;
}

.tables{
	border:0.5px #000;
	border-collapse:collapse;
	width:48%;
	font-size:12px;
	margin-top:10px;
	margin-left:5px;
}

.tables_resep{
	border:0.5px #000;
	border-collapse:collapse;
	width:48%;
	font-size:12px;
	margin-top:20px;
	margin-left:5px;
	line-height:25px;
}

.prints{
	display:hidden;
	visibility:hidden;
}

@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
		visibility:hidden;
	}
	.prints{
		display:block;
		visibility:visible;
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
.rotate{
	-ms-transform: rotate(270deg); /* IE 9 */
    -webkit-transform: rotate(270deg); /* Safari */
    transform: rotate(0deg);
}
</style>

<?php
	// tbpuskesmas
	$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepuskesmas'"));
	$kota1 = $datapuskesmas['Kota'];
	$datadinas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdinkes` WHERE `Kota` = '$kota1'"));

	// tbresep
	$no = $_GET['id'];
	$query_resep = mysqli_query($koneksi,"SELECT * FROM `tbresep` WHERE `NoResep`='$no'");
	$data_resep = mysqli_fetch_assoc($query_resep);
	
	// tbdiagnosapasien
	$qrdata_kd_diagnosa = mysqli_query($koneksi,"SELECT * FROM `$tbdiagnosapasien` WHERE `NoRegistrasi` = '$data_resep[NoResep]'");
	
	while($data_kd_diagnosa = mysqli_fetch_assoc($qrdata_kd_diagnosa)){
		$kode_diagnosa[] = $data_kd_diagnosa['KodeDiagnosa'];
		$data_diagnosa = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa` = '$data_kd_diagnosa[KodeDiagnosa]'"));
		$nama_diagnosa[] = $data_diagnosa['Diagnosa'];
	}
?>
<!--html-->
<div class="rotates">	
	<div class="printheader">
		<p style="font-size:14px; font-family:Trebuchet MS; margin-top:-5px;"><b><?php echo "PEMERINTAH ".$datapuskesmas['Kota'];?></b></p>
		<p style="font-size:14px; font-family:Trebuchet MS; margin-top:-5px;"><b><?php echo $datadinas['NamaDinkes'];?></b></p>
		<p style="font-size:14px; font-family:Trebuchet MS; margin-top:-5px;"><b><?php echo "PUSKESMAS ".$datapuskesmas['NamaPuskesmas'];?></b></p>
		<p style="font-family:Trebuchet MS; margin-top:-5px;"><?php echo $datapuskesmas['Alamat']?></p>
		<hr style="border:1px solid #000; margin-top:-3px;">
		<p style="font-size:22px; font-family:Trebuchet MS; margin-top:-5px;"><b>RESEP OBAT</b></p>
		<br/>
	</div>

	<!--tbresep-->
	<table class="tables" style="font-family:Trebuchet MS; margin-top:-5px;">
		<tr>	
			<td width="30%">Tanggal</td>
			<td width="2%">:</td>
			<td width="100%"><?php echo $data_resep['TanggalResep'];?></td>
		</tr>
		<tr>	
			<td>No.Resep</td>
			<td>:</td>
			<td><?php echo $data_resep['NoResep'];?></td>
		</tr>
		<tr>	
			<td>Nama Pasien</td>
			<td>:</td>
			<td><?php echo $data_resep['NamaPasien'];?></td>
		</tr>
		<tr>	
			<td>Umur</td>
			<td>:</td>
			<td><?php echo $data_resep['UmurTahun']." thn ".$data_resep['UmurBulan']." Bln";?></td>
		</tr>
		<tr>
			<td>Poli / Jaminan</td>
			<td>:</td>
			<td><?php echo $data_resep['Pelayanan'];?> / <?php echo $data_resep['StatusBayar'];?></td>
		</tr>
		<tr>	
			<td>Kode Diagnosa</td>
			<td>:</td>
			<td><?php if($kode_diagnosa != null){echo implode($kode_diagnosa,", ");}else{echo "-";}?></td>
			
		</tr>
		<tr>	
			<td>Diagnosa</td>
			<td>:</td>
			<td height="100%"><?php if($nama_diagnosa != null){echo implode($nama_diagnosa,", ");}else{echo "-";}?></td>
		</tr>
	</table>
	<hr style="border:0.5px dotted #000;margin:0px 0px -10px 0px;width:48%;"/>
	<table class="tables_resep" style="style=font-family:Trebuchet MS; margin-top:10px; font-family:Trebuchet MS">
		<tr>
			<th width="80%" style="text-align:center;">Nama Barang</th>
			<th width="10%" style="text-align:center;">Jml</th>
			<th width="10%" style="text-align:center;">Dosis</th>
		</tr>
		<?php
		$query = mysqli_query($koneksi,"SELECT * FROM `tbresepdetail` 
		join `tbgfkstok` on tbresepdetail.Kodebarang = tbgfkstok.Kodebarang  
		WHERE tbresepdetail.NoResep='$no'");
		while($data = mysqli_fetch_assoc($query)){
		?>
		<tr>
			<td><?php echo $data['NamaBarang'];?></td>
			<td align="center"><?php echo $data['jumlahobat'];?></td>
			<td align="center"><?php echo $data['signa1'];?> x <?php echo $data['signa2'];?></td>
		</tr>
		<?php
		}
		?>
	</table>
	<hr style="border:0.5px dotted #000; margin:0px 0px 10px 0px; width:48%;"/>
	<table width="48%" style="font-family:Trebuchet MS; margin-left:20px;">
		<tr>
			<td width="30%" style="text-align:center;">Pasien</td>
			<!--<td width="30%" style="text-align:center;">Petugas Farmasi</td>-->
			<td width="40%" style="text-align:center;">Dokter</td>
		</tr>
	</table>
	<table width="48%" style="font-family:Trebuchet MS; margin-left:20px; margin-top:60px;">
			<td width="30%" style="text-align:center;"><?php echo $data_resep['NamaPasien'];?></td>
			<!--<td width="30%" style="text-align:center;">Tommy Natalianto, JH. ST</td>-->
			<td width="40%" style="text-align:center;"><?php echo $data_resep['NamaPegawai'];?></td>
		</tr>
	</table><br>
	<div style="text-align:center; width:48%; font-family:Trebuchet MS; font-style:italic; font-weight:bold;">"Semoga Lekas Sembuh"</div>
	<a href="javascript:print()" class="btn btn-info noprint">Print Resep</a>
</div>
	
<?php
	$str = "UPDATE tbresep set `Status`='Sudah' where `NoResep`='$no'";
	$query=mysqli_query($koneksi,$str);
?>