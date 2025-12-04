<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
    $namaprg = $_GET['namaprg'];
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=Indikator Obat (".$namapuskesmas." ".$bulan." ".$tahun.").xls");
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
	<h4 style="margin:15px 5px 5px 5px;"><b>40 ITEM INDIKATOR OBAT PUSKESMAS</b></h4>
	<p style="margin:1px;"><p style="margin:1px;">Periode Laporan: <?php echo $bulan." ".$tahun;?></p>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
    <table class="table-judul-form" border="1" width="100%">
		<thead>
			<tr>
				<th width="5%">NO.</th>
				<th width="75%">NAMA BARANG</th>
				<th width="20%">SEDIA</th>
			</tr>
		</thead>							
        <tbody>
			<?php
			$str = "SELECT * FROM `tbgudangpkmindikator` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Bulan`='$bulan' AND `Tahun`='$tahun'";
			$str2 = $str." ORDER BY `NamaBarang` ASC";
						
			$query = mysqli_query($koneksi,$str2);
			while($data = mysqli_fetch_assoc($query)){
				$no = $no + 1;
				$idindikator = $data['IdIndikator'];
				$kodebarang = $data['KodeBarang'];
				$namaindikator = $data['NamaBarang'];
				
				// cek gfkstok
				$strgfkdistribusi = "SELECT * FROM `tbgfkpengeluarandetail` a JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur
				WHERE a.`Kodebarang`='$kodebarang' AND b.`KodePenerima`='$kodepuskesmas'";
				// echo $strgfkdistribusi;
				$dtgfkdistribusi = mysqli_num_rows(mysqli_query($koneksi, $strgfkdistribusi));
				if($dtgfkdistribusi > 0){
					$sedia = "1";
				}else{
					$sedia = "0";
				}	
			?>
				<tr style="border:1px solid #000;">
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
					<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($namaindikator);?></td>
					<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $sedia;?></td>
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