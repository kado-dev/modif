<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";	
	$tanggal = date('Y-m-d');
	// filterdata
	$kategori = $_GET['kategori'];
	$key = $_GET['key'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Gema Cermat(".$namapuskesmas.").xls");
	// if(isset($bulan) and isset($tahun)){
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN GEMA CERMAT</b></h4>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr>
					<th width="3%" rowspan="2">NO.</th>
					<th width="7%" rowspan="2">TGL.<br/>KEGIATAN</th>
					<th width="12%" rowspan="2">TEMPAT</th>
					<th width="6%" rowspan="2">SUMBER<br/>DANA</th>
					<th width="10%" rowspan="2">PESERTA PERTEMUAN</th>
					<th width="25%" colspan="5">JUMLAH PESERTA</th>
					<th width="10%" rowspan="2">HASIL PELAKSANAAN<br/>KEGIATAN</th>
					<th width="10%" rowspan="2">RENCANA TINDAK<br/>LANJUT</th>
				</tr>
				<tr>
					<th>APOTEKER</th>
					<th>NAKES LAINNYA</th>
					<th>KADER</th>
					<th>MASYARAKAT<br/>UMUM</th>
					<th>TOTAL</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$key = $_GET['key'];	
			$kategori = $_GET['kategori'];	
			$namapuskesmas = $_SESSION['namapuskesmas'];
			
			if($kategori == "Tempat"){
				$kategori = " AND `Tempat` like '%$key%'";
			}elseif($kategori == "Sumber Dana"){	
				$kategori = " AND `SumberDana` like '%$key%'";
			}else{
				$kategori = "";
			}	
			
			$str = "SELECT * FROM `tbgfkgemacermat` WHERE `Penyelenggara`='$namapuskesmas'".$kategori;
			$str2 = $str." ORDER BY `IdKegiatan` DESC";
			// echo $str2;
			
			$query = mysqli_query($koneksi,$str2);
			while($data = mysqli_fetch_assoc($query)){
				$no = $no + 1;
				$ttl_peserta = $data['JumlahApoteker'] + $data['JumlahNakesLain'] + $data['JumlahKader'] + $data['JumlahMasyarakat'];
			?>
				<tr>
					<td align="right"><?php echo $no;?></td>		
					<td align="center"><?php echo $data['TanggalKegiatan'];?></td>		
					<td align="left"><?php echo strtoupper($data['Tempat']);?></td>		
					<td align="center"><?php echo $data['SumberDana'];?></td>		
					<td align="left"><?php echo strtoupper($data['Peserta']);?></td>		
					<td align="center"><?php echo $data['JumlahApoteker'];?></td>		
					<td align="center"><?php echo $data['JumlahNakesLain'];?></td>		
					<td align="center"><?php echo $data['JumlahKader'];?></td>		
					<td align="center"><?php echo $data['JumlahMasyarakat'];?></td>		
					<td align="center"><?php echo $ttl_peserta;?></td>	
					<td align="left"><?php echo strtoupper($data['HasilKegiatan']);?></td>		
					<td align="left"><?php echo strtoupper($data['RencanaTindakLanjut']);?></td>
				</tr>
			<?php
			}
			?>
			</tbody>
		</table>
	</div>
</div>
<?php
// }
?>