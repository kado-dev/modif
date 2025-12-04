<?php
	session_start();
	include_once('config/koneksi.php');
	include_once('config/helper.php');
	include_once('config/helper_report.php');
	include_once('config/helper_pasienrj.php');
	$tanggal_awal = date('Y-m-d', strtotime($_GET['tanggal_awal']));
	$tanggal_akhir = date('Y-m-d', strtotime($_GET['tanggal_akhir']));
	$namavaksin = $_GET['namavaksin'];
	$dosis = $_GET['dosis'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Permohonan Usulan Vaksin (".$kota.").xls");
	if(isset($tanggal_awal)){
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
</style>

<div class="printheader">
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>LAPORAN PERMOHONAN USULAN VAKSIN</b></span><br>
	<span class="font12" style="margin:1px;">Periode Laporan: <?php echo date('d-m-Y', strtotime($tanggal_awal))." s/d ".date('d-m-Y', strtotime($tanggal_akhir));?></span>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr style="border:1px solid #000;">
					<th width="3%">NO.</th>
					<th width="12%">TGL.KEGIATAN</th>
					<th width="20%">UNIT PENERIMA</th>
					<th width="45%">NAMA BARANG</th>
					<th width="10%">DOSIS</th>
					<th width="10%">JUMLAH</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($dosis == 'SEMUA'){
					$dosis = " ";
				}else{
					$dosis = " AND `Dosis`='$dosis'";
				}

				if($namavaksin == 'SEMUA'){
					$namavaksin = " ";
				}else{
					$namavaksin = " AND `NamaVaksin`='$namavaksin'";
				}				
				
				// tahap1, tbgfk_vaksin_usulan
				$str = "SELECT * FROM `tbgfk_vaksin_usulan` 
				WHERE TanggalKegiatan BETWEEN '$tanggal_awal' AND '$tanggal_akhir'".$namavaksin.$dosis;							
				$str2 = $str." ORDER BY `IdUsulan`";
				// echo $str2;
				
				$no = 0;
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
				?>
				
				<tr style="border:1px solid #000; font-weight: bold;">
					<td><?php echo $no;?></td>
					<td><?php echo $data['TanggalKegiatan'];?></td>
					<td><?php echo $data['UnitPenerima'];?></td>
					<td><?php echo $data['NamaVaksin'];?></td>
					<td><?php echo $data['Dosis'];?></td>
					<td><?php echo $data['JumlahUsulan'];?></td>
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