<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row search-page noprint" id="search-page-1">
		<div class="col-xs-12">
			<h3 class="judul"><b>DISTRIBUSI BARANG (KEUANGAN)</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_gfk_keuangan_distribusi_barang_bogorkab"/>
						<div class="col-sm-2" style = "width:110px;">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2016 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="kategori" class="form-control">
								<option value="SEMUA" <?php if($_GET['kategori'] == 'SEMUA'){echo "SELECTED";}?>>SEMUA</option>
								<option value="PUSKESMAS" <?php if($_GET['kategori'] == 'PUSKESMAS'){echo "SELECTED";}?>>PUSKESMAS</option>
								<option value="LAINNYA" <?php if($_GET['kategori'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
							</select>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-sm btn-warning">Cari</button>
							<a href="?page=lap_gfk_keuangan_distribusi_barang_bogorkab" class="btn btn-sm btn-success">Refresh</a>
							<a href="javascript:print()" class="btn btn-sm btn-primary">Print</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php
	$tahun = $_GET['tahun'];
	$kategori = $_GET['kategori'];
	if (isset($tahun)){
	?>

	<!--data registrasi-->
	<div class="row printheader">
		<span class="font16" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br/>
		<span class="font16" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br/>
		<span class="font10" style="margin:5px;"><?php echo $alamat.", Telp.".$telepon.", Fax.".$fax;?></span>
		<hr style="margin:10px 5px 5px 5px; border:1px solid #000">
		<span class="font16" style="margin:50px;"><b>LAPORAN DISTRIBUSI BARANG (KEUANGAN)</b></span>
		<br/>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul">
					<thead>
						<tr>
							<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:10px;">No.</th>
							<th rowspan="2" style="text-align:center;width:2%;vertical-align:middle; border:1px solid #000; padding:10px;">Kode</th>
							<th rowspan="2" style="text-align:center;width:10%;vertical-align:middle; border:1px solid #000; padding:10px;">Puskesmas</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:10px;">Januari</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:10px;">Februari</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:10px;">Maret</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:10px;">April</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:10px;">Mei</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:10px;">Juni</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:10px;">Juli</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:10px;">Agustus</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:10px;">September</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:10px;">Oktober</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:10px;">November</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:10px;">Desember</th>
							<th rowspan="2" style="text-align:center;width:3%;vertical-align:middle; border:1px solid #000; padding:10px;">Jumlah</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 0;
						
						if ($kategori == 'PUSKESMAS'){
							$StatusPengeluaran = "SELECT StatusPengeluaran, KodePenerima, Penerima FROM tbgfkpengeluaran WHERE YEAR(TanggalPengeluaran)='$tahun' and StatusPengeluaran = 'PUSKESMAS' group by KodePenerima order by Penerima";
						}else if ($kategori == 'LAINNYA'){
							$StatusPengeluaran = "SELECT StatusPengeluaran, KodePenerima, Penerima FROM tbgfkpengeluaran WHERE YEAR(TanggalPengeluaran)='$tahun' and StatusPengeluaran <> 'PUSKESMAS' group by Penerima order by Penerima";
						}else{
							$StatusPengeluaran = "SELECT StatusPengeluaran, KodePenerima, Penerima FROM tbgfkpengeluaran WHERE YEAR(TanggalPengeluaran)='$tahun' group by KodePenerima order by Penerima";
						}
						// echo $StatusPengeluaran;
						
						$query_pkm=mysqli_query($koneksi,$StatusPengeluaran);
						while($dt_pkm = mysqli_fetch_assoc($query_pkm)){
							$no= $no + 1;
							$KodePenerima = $dt_pkm['KodePenerima'];
							$jan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='01' and YEAR(TanggalPengeluaran)='$tahun' and KodePenerima = '$KodePenerima'"));
							$feb = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='02' and YEAR(TanggalPengeluaran)='$tahun' and KodePenerima = '$KodePenerima'"));
							$mar = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='03' and YEAR(TanggalPengeluaran)='$tahun' and KodePenerima = '$KodePenerima'"));
							$apr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='04' and YEAR(TanggalPengeluaran)='$tahun' and KodePenerima = '$KodePenerima'"));
							$mei = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='05' and YEAR(TanggalPengeluaran)='$tahun' and KodePenerima = '$KodePenerima'"));
							$jun = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='06' and YEAR(TanggalPengeluaran)='$tahun' and KodePenerima = '$KodePenerima'"));
							$jul = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='07' and YEAR(TanggalPengeluaran)='$tahun' and KodePenerima = '$KodePenerima'"));
							$agus = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='08' and YEAR(TanggalPengeluaran)='$tahun' and KodePenerima = '$KodePenerima'"));
							$sep = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='09' and YEAR(TanggalPengeluaran)='$tahun' and KodePenerima = '$KodePenerima'"));
							$okt = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='10' and YEAR(TanggalPengeluaran)='$tahun' and KodePenerima = '$KodePenerima'"));
							$nov = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='11' and YEAR(TanggalPengeluaran)='$tahun' and KodePenerima = '$KodePenerima'"));
							$des = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='12' and YEAR(TanggalPengeluaran)='$tahun' and KodePenerima = '$KodePenerima'"));
							$jml = $jan['Jumlah'] + $feb['Jumlah'] + $mar['Jumlah'] + $apr['Jumlah'] + $mei['Jumlah'] + $jun['Jumlah'] + 
									$jul['Jumlah'] + $agus['Jumlah'] + $sep['Jumlah'] + $okt['Jumlah'] + $nov['Jumlah'] + $des['Jumlah'];
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $dt_pkm['KodePenerima'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $dt_pkm['Penerima'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($jan['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($feb['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($mar['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($apr['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($mei['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($jun['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($jul['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($agus['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($sep['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($okt['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($nov['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($des['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($jml);?></td>
							</tr>
						<?php
							}
						?>
						
						<?php
							$tahun = $_GET['tahun'];
							if ($_GET['kategori'] == 'PUSKESMAS'){
								$status = " AND StatusPengeluaran = 'PUSKESMAS'";
							}else if ($_GET['kategori'] == 'LAINNYA'){
								$status = " AND StatusPengeluaran <> 'PUSKESMAS'";
							}else{
								$status = " ";
							}
							
							// $strtes = "select SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran where MONTH(TanggalPengeluaran)='01' and YEAR(TanggalPengeluaran)='$tahun'.$status";
							// echo $strtes;
														
							$total_jan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='01' and YEAR(TanggalPengeluaran)='$tahun'".$status));
							$total_feb = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='02' and YEAR(TanggalPengeluaran)='$tahun'".$status));
							$total_mar = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='03' and YEAR(TanggalPengeluaran)='$tahun'".$status));
							$total_apr = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='04' and YEAR(TanggalPengeluaran)='$tahun'".$status));
							$total_mei = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='05' and YEAR(TanggalPengeluaran)='$tahun'".$status));
							$total_jun = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='06' and YEAR(TanggalPengeluaran)='$tahun'".$status));
							$total_jul = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='07' and YEAR(TanggalPengeluaran)='$tahun'".$status));
							$total_agus = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='08' and YEAR(TanggalPengeluaran)='$tahun'".$status));
							$total_sep = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='09' and YEAR(TanggalPengeluaran)='$tahun'".$status));
							$total_okt = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='10' and YEAR(TanggalPengeluaran)='$tahun'".$status));
							$total_nov = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='11' and YEAR(TanggalPengeluaran)='$tahun'".$status));
							$total_des = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT SUM(GrandTotal)AS Jumlah FROM tbgfkpengeluaran WHERE MONTH(TanggalPengeluaran)='12' and YEAR(TanggalPengeluaran)='$tahun'".$status));
							$jml_seluruh = $total_jan['Jumlah'] + $total_feb['Jumlah'] + $total_mar['Jumlah'] + $total_apr['Jumlah'] + $total_mei['Jumlah'] + $total_jun['Jumlah'] + 
									$total_jul['Jumlah'] + $total_agus['Jumlah'] + $total_sep['Jumlah'] + $total_okt['Jumlah'] + $total_nov['Jumlah'] + $total_des['Jumlah'];
						?>
							<tr style="border:1px solid #000; font-weight: bold;">
								<td style="text-align:left; border:1px solid #000; padding:3px;">#</td>
								<td style="text-align:left; border:1px solid #000; padding:3px;">-</td>
								<td style="text-align:left; border:1px solid #000; padding:3px;">Total</td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($total_jan['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($total_feb['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($total_mar['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($total_apr['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($total_mei['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($total_jun['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($total_jul['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($total_agus['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($total_sep['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($total_okt['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($total_nov['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($total_des['Jumlah']);?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($jml_seluruh);?></td>
							</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>
	<?php
	}
	?>
</div>