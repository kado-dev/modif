<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	$bulan = date('m');
	$tahun = date('Y');
	$key = $_GET['key'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_Daftar_Kisaran_Harga (".nama_bulan($bulan)." ".$tahun.").xls");
	if(isset($bulan)){
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
	<?php if($namapuskesmas == "DINAS KESEHATAN" || $namapuskesmas == "UPTD FARMASI" || $namapuskesmas == "KLINIK DINAS"){?>
	<h4 style="margin:5px;"><b><?php echo $namapuskesmas;?></b></h4>
	<?php }else{ ?>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<?php } ?>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN DAFTAR KISARAN HARGA</b></h4>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
		<thead>
			<tr style="border:1px solid #000;">
				<th width="2%">NO.</th>
				<th width="15%">KEGIATAN</th>
				<th width="15%">PEKERJAAN</th>
				<th width="8%">KODE KEGIATAN</th>
				<th width="8%">KODE REKENING</th>
				<th width="8%">PAGU DANA</th>
				<th width="8%">TAHUN ANGGARAN</th>
				<th width="6%">PAKET</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$key = $_GET['key'];
				if($key != ''){
					$keys = " AND `NamaBarang` like '%$key%'";				
				}else{
					$keys = "";
				}		
				$str = "SELECT * FROM `tbgudangpkmdkh` WHERE `KodePuskesmas`='$kodepuskesmas'".$keys;
				$str2 = $str." ORDER BY IdDkh DESC";
				// echo $str2;
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
				$no = $no + 1;
			?>
				<tr>
					<td align="right" style="vertical-align:middle;"><?php echo $no;?></td>							
					<td align="left">
						<?php 
							echo "<b>".strtoupper($data['Kegiatan'])."</b><br/> 
							TGL.INPUT: ".date("d-m-Y", strtotime($data['TanggalEntry']))."<br/> 
							STATUS: ".strtoupper($data['StatusKatalog']);
						?>
					</td>									
					<td align="left" style="vertical-align:middle;"><?php echo strtoupper($data['Pekerjaan']);?></td>									
					<td align="center" style="vertical-align:middle;"><?php echo $data['KodeKegiatan'];?></td>									
					<td align="center" style="vertical-align:middle;"><?php echo $data['KodeRekening'];?></td>									
					<td align="right" style="vertical-align:middle;"><?php echo rupiah($data['PaguDana']);?></td>									
					<td align="center" style="vertical-align:middle;"><?php echo $data['TahunAnggaran'];?></td>									
					<td align="center" style="vertical-align:middle;"><?php echo strtoupper($data['PaketDkh']);?></td>										
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