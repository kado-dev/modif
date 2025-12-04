<?php
	include_once('config/koneksi.php');
	session_start();
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bl'];
    $tahun = $_GET['th'];
	$tahun1 = $tahun - 1;
	$tahun2 = $tahun + 1;	
    $namaprogram = $_GET['prg'];

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=RKO ".$namapuskesmas." (".$namaprogram." ".$tahun.").xls");
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
	<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
	<span class="font16" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
	<span class="font12" style="margin:5px;"><?php echo $alamat;?></span>
	<hr style="margin:3px; border:1px solid #000">
	<span class="font16" style="margin:15px 5px 5px 5px;"><b>RKO PUSKESMAS</b></span><br>
	<span class="font12" style="margin:15px 5px 5px 5px;">Periode Laporan: <?php echo $tahun;?></span><br>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
    <table id="" class="table-judul-form" border="1">
        <thead>
			<tr style="border:1px sollid #000;">
				<th width="2%" rowspan="2">NO.</th>
				<th width="3%" rowspan="2">KODE</th>
				<th width="15%" rowspan="2">NAMA BARANG</th>
				<th width="4%" rowspan="2">SATUAN</th>
				<th colspan="2">STOK AWAL<br/> <?php echo "(DESEMBER ".$tahun1.")";?></th>
				<th colspan="2">PENERIMAAN <br/> <?php echo $tahun1?></th>
				<th colspan="2">PEMAKAIAN RATA2<br/> <?php echo $tahun1?></th>
				<th colspan="2">SISA STOK<br/><?php echo $tahun1?></th>
				<th width="5%" rowspan="2">TINGKAT <br/>KECUKUPAN <br/><?php echo $tahun?></th>
				<th colspan="2">TOTAL KEBUTUHAN<br/> <?php echo $tahun1?></th>
				<th width="5%" rowspan="2">RANCANA PENGADAAN <br/>(SETELAH KOREKSI) <br/><?php echo $tahun2?></th>
				<th colspan="2">RENCANA <br/>PENGADAAN<br/><?php echo $tahun2?></th>
			</tr>
			<tr style="border:1px sollid #000;">
				<th width="5%">APBD</th><!--stok awal-->
				<th width="5%">JKN</th>
				<th width="5%">APBD</th><!--penerimaan-->
				<th width="5%">JKN</th>
				<th width="5%">APBD</th><!--pemakaian rata2-->
				<th width="5%">JKN</th>
				<th width="5%">APBD</th><!--sisa stok-->
				<th width="5%">JKN</th>
				<th width="5%">APBD</th><!--total kebutuhan-->
				<th width="5%">JKN</th>
				<th width="5%">APBD</th><!--rencana pengadaan-->
				<th width="5%">JKN</th>
			</tr>
		</thead>								
        <tbody>
			<tbody>
				<?php
					$str = "SELECT * FROM `ref_obat_lplpo`";
					$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC";
					// echo $str2;
											
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						if($namaprograms != $data['NamaProgram']){
							echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='18'>$data[NamaProgram]</td></tr>";
							$namaprograms = $data['NamaProgram'];
						}
						
						$no = $no + 1;
						$kodebarang = $data['KodeBarang'];
						$namabarang = strtoupper($data['NamaBarang']);
						
						// tahap 1, stok awal
						$strsopkm = "SELECT * FROM `tbstokopnam_puskesmas_bogorkab` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'";
						$dtstokopname = mysqli_fetch_assoc(mysqli_query($koneksi, $strsopkm));
						$stokawal = $dtstokopname['StokAwalApbd'] + $dtstokopname['StokAwalJkn'];
						
						// tahap 2, tarik data tbrko_bogorkab_puskesmas
						$strrko = "SELECT * FROM `tbrko_bogorkab_puskesmas` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'";
						$dtrko = mysqli_fetch_assoc(mysqli_query($koneksi, $strrko));
						
						// tahap 3, total persediaan
						$total_persediaan = $dtstokopname['StokAwalApbd'] + $dtstokopname['StokAwalJkn'] + $dtrko['Penerimaan_Apbd'] + $dtrko['Penerimaan_Jkn'];
						
						?>
						<tr>
							<td style="text-align:center; border:1px sollid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px sollid #000; padding:3px;"><?php echo $kodebarang;?></td>
							<td style="text-align:left; border:1px sollid #000; padding:3px;" class="namabarangcls"><?php echo $namabarang;?></td>
							<td style="text-align:center; border:1px sollid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
							<td style="text-align:right; border:1px sollid #000; padding:3px;">
								<?php
									// stok awal
									if($dtstokopname['StokAwalApbd'] != 0){
										echo rupiah($dtstokopname['StokAwalApbd']);
									}else{
										echo "";
									}
								?>
							</td>
							<td style="text-align:right; border:1px sollid #000; padding:3px;">
								<?php 
									if($dtstokopname['StokAwalJkn'] != 0){
										echo rupiah($dtstokopname['StokAwalJkn']);
									}else{
										echo "-";
									}
								?>
							</td>
							<td style="text-align:right; border:1px sollid #000; padding:3px;">
								<?php
									// penerimaan
									if($dtrko['Penerimaan_Apbd'] != 0){
										echo rupiah($dtrko['Penerimaan_Apbd']);
									}else{
										echo "";
									}
								?>
							</td>
							<td style="text-align:right; border:1px sollid #000; padding:3px;">
								<?php
									if($dtrko['Penerimaan_Jkn'] != 0){
										echo rupiah($dtrko['Penerimaan_Jkn']);
									}else{
										echo "";
									}
								?>	
							</td>
							<td style="text-align:right; border:1px sollid #000; padding:3px;">
								<?php
									// pemakaian rata rata
									if($dtrko['PemakaianRata_Apbd'] != 0){
										echo rupiah($dtrko['PemakaianRata_Apbd']);
									}else{
										echo "";
									}
								?>
							</td>
							<td style="text-align:right; border:1px sollid #000; padding:3px;">
								<?php
									// pemakaian rata rata
									if($dtrko['PemakaianRata_Jkn'] != 0){
										echo rupiah($dtrko['PemakaianRata_Jkn']);
									}else{
										echo "";
									}
								?>
							</td>
							<td style="text-align:right; border:1px sollid #000; padding:3px;">
								<?php
									// sisa stok
									if($dtrko['SisaStok_Apbd'] != 0){
										echo rupiah($dtrko['SisaStok_Apbd']);
									}else{
										echo "";
									}
								?>
							</td>
							<td style="text-align:right; border:1px sollid #000; padding:3px;">
								<?php
									if($dtrko['SisaStok_Jkn'] != 0){
										echo rupiah($dtrko['SisaStok_Jkn']);
									}else{
										echo "";
									}
								?>
							</td>
							<td style="text-align:right; border:1px sollid #000; padding:3px;">
								<?php
									// tingkat kecukupan
									if($dtrko['TingkatKecukupan'] != 0){
										echo rupiah($dtrko['TingkatKecukupan']);
									}else{
										echo "";
									}
								?>
							</td>
							<td style="text-align:right; border:1px sollid #000; padding:3px;">
								<?php
									// total kebutuhan
									if($dtrko['TotalKebutuhan_Apbd'] != 0){
										echo rupiah($dtrko['TotalKebutuhan_Apbd']);
									}else{
										echo "";
									}
								?>
							</td>
							<td style="text-align:right; border:1px sollid #000; padding:3px;">
								<?php
									if($dtrko['TotalKebutuhan_Jkn'] != 0){
										echo rupiah($dtrko['TotalKebutuhan_Jkn']);
									}else{
										echo "";
									}
								?>
							</td>
							<td style="text-align:right; border:1px sollid #000; padding:3px;">
								<?php
									// rencana pengadaan setelah koreksi
									if($dtrko['RencanaPengadaanKoreksi'] != 0){
										echo rupiah($dtrko['RencanaPengadaanKoreksi']);
									}else{
										echo "";
									}
								?>
							</td>
							<td style="text-align:right; border:1px sollid #000; padding:3px;">
								<?php
									// rencana pengadaan
									if($dtrko['RencanaPengadaan_Apbd'] != 0){
										echo rupiah($dtrko['RencanaPengadaan_Apbd']);
									}else{
										echo "";
									}
								?>
							</td>
							<td style="text-align:right; border:1px sollid #000; padding:3px;">
								<?php
									if($dtrko['RencanaPengadaan_Jkn'] != 0){
										echo rupiah($dtrko['RencanaPengadaan_Jkn']);
									}else{
										echo "";
									}
								?>
							</td>
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