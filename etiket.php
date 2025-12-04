<?php
$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$kota1 = $_SESSION['kota'];
	$alamat = $_SESSION['alamat'];
	$tanggal = date('Y-m-d');
	$noreg = $_GET['id'];
?>
<style>
.printheader{
	margin-top:5px;
	margin-left:5px;
	margin-right:5px;
	text-align:center;
	background:#cbe9f2;
	padding:15px;
	// border-bottom:1px solid #111;
	width:40%;
}
.printbody{
	margin-left:5px;
	margin-right:5px;
	background:#cbe9f2;
	padding:15px;
	width:40%;
	font-family: Verdana;
}
.printfooter{
	margin-left:5px;
	margin-right:5px;
	background:#cbe9f2;
	padding:5px;
	text-align:center;
	width:40%;
	font-family: Verdana;
	font-size:9px;
}
.tables{
	width:100%;
	margin-top:-15px;
	font-size:9px;
}

@media print{
	body{
		padding:0px;
		margin-top:-5px;
		width:100%;
	}
	.noprint{
		display:none;
		visibility:hidden;
	}
	.printheader{
		margin-left:20px; 
		width:100%;
		float:center;
	}
	.printbody{
		margin-left:20px; 
		width:100%;
	}
	.printfooter{ 
		margin-left:20px; 
		width:100%;
	}
}	
</style>

<?php
	$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `KodePuskesmas` = '$kodepuskesmas'"));
	$kota1 = $datapuskesmas['Kota'];
	$datadinas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdinkes` where `Kota` = '$kota1'"));
	
	// tbresep
	$kode_brg = $_GET['kd'];
	$str = "SELECT * FROM `tbresep` WHERE `NoResep`='$noreg'";
	$query2 = mysqli_query($koneksi,$str);
	$data_resep = mysqli_fetch_assoc($query2);
?>
	
<div class="col-sm-12">
	<div class="printheader">
		<h4 style="margin:-5px; font-size:10px; font-family: Verdana;"><b><?php echo "PEMERINTAH ".$datapuskesmas['Kota'];?></b></h4>
		<h4 style="margin:5px; font-size:10px; font-family: Verdana;"><b><?php echo $datadinas['NamaDinkes'];?></b></h4>
		<h4 style="margin:-5px; font-size:10px; font-family: Verdana;"><b><?php echo "PUSKESMAS ".$datapuskesmas['NamaPuskesmas'];?></b></h4>
		<p style="margin:5px; font-size:8px; font-family: Verdana; margin-bottom:-10px;"><?php echo $datapuskesmas['Alamat']?></p>
	</div>

	<div class="printbody">
		<table class="tables">
			<tr>
				<td width="35%">No Resep</td>
				<td width="5%">:</td>
				<td width="60%"><?php echo $data_resep['NoResep'];?></td>
			</tr>
			<tr>
				<td>Tanggal Resep</td>
				<td>:</td>
				<td><?php echo $data_resep['TanggalResep'];?></td>
			</tr>
			<tr>
				<td>Nama Pasien</td>
				<td>:</td>
				<td><?php echo $data_resep['NamaPasien'];?></td>
			</tr>
			<tr>
				<td>Poli</td>
				<td>:</td>
				<td><?php echo $data_resep['Pelayanan'];?></td>
			</tr>
		</table>
		
		<?php
			$detailresep = mysqli_query($koneksi,"SELECT * FROM `tbresepdetail` a JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang WHERE a.NoResep = '$data_resep[NoResep]' AND a.KodeBarang = '$kode_brg'");
			$dt_resep = mysqli_fetch_assoc($detailresep);
		?>
		<table class="tables" style="margin-top:5px;">
			<tr>
				<td width="60%"><?php echo $dt_resep['NamaBarang'];?></td>
				<td width="20%"><?php echo $dt_resep['signa1'];?> x <?php echo $dt_resep['signa2'];?></td>
				<td><?php echo $dt_resep['jumlahobat'];?></td>
			</tr>
		</table>
	</div>
	<div class="printfooter" style="margin-top:-15px;">
		<i>--Semoga Lekas Sembuh--</i>
	</div>
	<div class="row noprint">
		<i style="margin-left:17px;">*Printer menggunakan seri : Argox OS-214NU PPLA</i> <a href="javascript:print()" style="margin-left:100px;">[Print]</a><br>	
	</div>
</div>	

