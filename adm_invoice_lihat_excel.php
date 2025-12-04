<?php
	include_once('config/koneksi.php');
	include "config/helper.php";
	$id = $_GET['id'];
	$kodepuskesmas = $_GET['kd'];
	$hariini = date('d-m-Y');
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Invoice (".$hariini.").xls");
?>

<style>
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
	display: none;
}
.printbody{
	margin-left:0px;
	margin-right:0px;
	display: none;
}

.atastabel{
	display:none;
	margin-top:10px;
}
.bawahtabel{
	margin-top:50px;
	margin-bottom:10px;
	margin-left:0px;
	display:none;
}
.logo{
	position: absolute;
	top:-5px;
	left:10px;
	width:200px;
}
.teks12{
	margin-top:20px;
	font-size:14px;
	text-align:right;
}
.teks10{
	font-size:10px;
	font-style:italic;
	text-align:right;
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

<!--tabel report-->
	<div class="printheader">
		<img src="image/logometro.png" class="logo"/>
		<?php
		$pengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbadm_invoice` WHERE `NoInvoice` = '$id'"));
		?>
		<div class="teks12">PT. METRO SMART TECHNOLOGY</div>
		<div class="teks10">Ruko Metro Indah Mall/MTC Blok H-53 Soekarno Hatta Bandung</div>
		<hr style="margin-top:10px; border:1.5px solid #000">
		<h2>INVOICE</h2><br/>
	</div>

	<?php  
	$tgl = explode("-",$pengeluaran['TanggalInvoice']);
	$tgllaporan = $tgl[1] - 1;
	$tglpermintaan = $tgl[1];
	?>
	
	<div class="atastabel">
		<div style="float:left; width:55%; margin-bottom:10px;">
			<table>
				<tr>
					<td style="padding:2px 4px;">Tanggal Invoice </td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;"><?php echo date('d-m-Y', strtotime($pengeluaran['TanggalInvoice']));?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">No. Invoice </td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;"><?php echo $pengeluaran['NoInvoice'];?></td>
				</tr>
				
			</table>
		</div>
		<div style="float:right; width:45%; margin-bottom:10px;">	
			<table>
				<tr>
					<td style="padding:2px 4px;">Ditujukan </td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;"><?php echo $pengeluaran['Tujuan'];?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Ket </td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;"><?php echo $pengeluaran['Keterangan'];?></td>
				</tr>
			</table>
		</div>	
	</div>
	
	<div class="printbody">
		<table width="100%" border="1">
			<thead style="font-size:14px;">
				<tr>
					<th>No.</th>
					<th>Nama Barang</th>
					<th>Satuan</th>
					<th>Qty</th>
					<th>Harga</th>
					<th>Jumlah</th>
				</tr>
			</thead>
			
			<tbody style="font-size:12px;">
				<?php
					$str_print = "SELECT * FROM `tbadm_invoice_detail` WHERE `NoInvoice` = '$id'";
					$query_print = mysqli_query($koneksi,$str_print);
					
					$qty = 0;
					$total = 0;
					$no = 0;
					while($data = mysqli_fetch_assoc($query_print)){
						$no = $no + 1;
						$jumlah = $data['Harga'] * $data['Qty'];
						$total = $jumlah + $total;
				?>
					<tr>
						<td><?php echo $no.".";?></td>
						<td><?php echo $data['NamaBarang'];?></td>
						<td><?php echo $data['Satuan'];?></td>
						<td><?php echo $data['Qty'];?></td>
						<td><?php echo rupiah($data['Harga']);?></td>
						<td><?php echo rupiah($data['Jumlah']);?></td>
					</tr>
				<?php
				}
				?>
					<tr style="border:1px dashed #000; padding:3px;">
						<td colspan="5">TOTAL</td>
						<td><?php echo rupiah($total)?></td>
					</tr>
			</tbody>
		</table><br>
		<?php
			if($total >= 1000000){
		?>
		<i> * Harga tersebut diatas sudah termasuk PPN 10%.</i>
		<?php }else{ ?>
		<i> * Harga tersebut diatas sudah termasuk PPH 23 sebesar 2%.</i>
		<?php } ?>
	</div>
		
	<div class="bawahtabel">
		<table width="100%">
			<tr>
				<td style="text-align:center;">
				PENYEDIA JASA,
				<br>
				<br>
				<br>
				<br>
				<br>
				TOMMY NATALIANTO, JH. ST
				</td>
				<td width="10%"></td>
				
				<td width="10%"></td>
				<td style="text-align:center;">
				BENDAHARA PENGELUARAN BLUD<br>
				<?php echo $pengeluaran['Tujuan'];?>
				<br>
				<br>
				<br>
				<br>
				<br>
				(..... ..... ..... ..... ..... ..... ..... .....)
				</td>
			</tr>
		</table>
	</div> 
