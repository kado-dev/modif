<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";	
	$tanggal = date('Y-m-d');
	// filterdata
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Hasil Entry SBBK(".$namapuskesmas.").xls");
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN HASIL ENTRY SBBK</b></h4>
	<p style="margin:1px;">
		<?php if($opsiform == 'bulan'){ ?>
			<p style="margin:1px;">Periode Laporan: <?php echo $bulan."/".$tahun;?></p>
		<?php }else{ ?>
			<p style="margin:1px;">Periode Laporan: <?php echo $keydat;?></p>
		<?php } ?>
	</p><br/>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr style="border:1px solid #000;">
					<th>No.</th>
					<th>Nama Pegawai</th>
					<?php
						$bln = $_GET['bulan'];
						$thn = $_GET['tahun'];
						$mulai = 1;
						$selesai = date('t',strtotime("01-".$bln."-".$thn));
						for($d = $mulai;$d <= $selesai; $d++){	
					?>
					<th><?php echo $d;?></th>
					<?php
						}
					?>
					<th>Jumlah</th>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
				<?php						
				$str = "SELECT * FROM `tbgfkpengeluaran` WHERE YEAR(TanggalPengeluaran)='$tahun' AND MONTH(TanggalPengeluaran)='$bulan' GROUP BY NamaPegawaiSimpan order by NamaPegawaiSimpan ASC";
				$query = mysqli_query($koneksi,$str);						
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$namapegawai = $data['NamaPegawaiSimpan'];					
					
				?>
					<tr style="border:1px solid #000;">
						<td><?php echo $no;?></td>
						<td><?php echo $namapegawai;?></td>	
						<?php
						$jml = 0;	
						for($d2= $mulai;$d2 <= $selesai; $d2++){	
							$tanggal = $thn."-".$bln."-".$d2;
							$strs = "SELECT COUNT(IdDistribusi) as jumlah FROM `tbgfkpengeluaran` WHERE `TanggalPengeluaran`='$tanggal' AND `NamaPegawaiSimpan`='$namapegawai'";
							$count = mysqli_fetch_assoc(mysqli_query($koneksi,$strs));
							$jml = $jml + $count['jumlah'];
						?>	
							<td><?php echo $count['jumlah'];?></td>
						<?php } ?>
						<td><?php echo $jml;?></td>
					</tr>
				<?php
				}
				?>
					<tr>
						<td>#</td>
						<td>Total</td>
					<?php
						$jmls = 0;
						for($d3= $mulai;$d3 <= $selesai; $d3++){	
						$tanggal = $thn."-".$bln."-".$d3;
						$strs2 = "select COUNT(IdDistribusi) as jumlah from `tbgfkpengeluaran` where `TanggalPengeluaran` = '$tanggal' AND `NamaPegawaiSimpan`='$namapegawai'";
						$countall = mysqli_fetch_assoc(mysqli_query($koneksi,$strs2));		
						$jmls = $jmls + $countall['jumlah'];
					?>	
						<td><?php echo $countall['jumlah'];?></td>
					<?php
						}
					?>	
						<td><?php echo $jmls;?></td>
					</tr>
			</tbody>
		</table>
	</div>
</div>
<?php
}
?>