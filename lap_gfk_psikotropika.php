<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>NARKOTIK / PSIKOTROPIK</b></h3>
			<div class="formbg">				
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_gfk_psikotropika"/>
						<div class="col-sm-2">
							<select name="bulan" class="form-control">
								<option value="01" <?php if($_GET['bulan'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulan'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulan'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulan'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulan'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulan'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulan'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulan'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulan'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulan'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulan'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulan'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="group" class="form-control">
								<option value="Group" <?php if($_GET['group'] == 'Group'){echo "SELECTED";}?>>Group</option>
								<option value="UnGroup" <?php if($_GET['group'] == 'UnGroup'){echo "SELECTED";}?>>UnGroup</option>
							</select>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_gfk_psikotropika" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print"></span></a>
							<a href="contoh_excel.php" class="btn btn-round btn-success"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$group = $_GET['group'];

	if($_SESSION['kodepuskesmas'] == '-'){
		$kdpuskesmas = $_GET['kodepuskesmas'];
		if($kdpuskesmas == 'semua'){
			$semua = " ";
		}else{
			$semua = " AND substring(a.NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
		}
	}else{
		$kdpuskesmas = $_SESSION['kodepuskesmas'];
		$semua = " AND substring(a.NoRegistrasi,1,11) = '".$kdpuskesmas."' ";
	}
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<?php
		$datapuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `KodePuskesmas` = '$kodepuskesmas'"));
		$kota1 = $datapuskesmas['Kota'];
		$datadinas = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbdinkes` where `Kota` = '$kota1'"));
		?>
			<?php 
			if($kdpuskesmas == 'semua'){
			?>
				<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></h4>
				<h4 style="margin:5px;"><b><?php echo $namapuskesmas;?></b></h4>
				<p style="margin:5px;"><?php echo $alamat;?></p>
			<?php
			}else{
			?>
				<h4 style="margin:5px;"><b><?php echo "PEMERINTAH ".$datapuskesmas['Kota'];?></b></h4>
				<h4 style="margin:5px;"><b><?php echo $datadinas['NamaDinkes'];?></b></h4>
				<h4 style="margin:5px;"><b><?php echo $datapuskesmas['NamaPuskesmas'];?></b></h4>
				<p style="margin:5px;"><?php echo $datapuskesmas['Alamat']?></p>
			<?php	
			}
			?>
			<hr style="margin:3px; border:1px solid #000">
			<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN PSIKOTROPIKA</b></h4>
			<p style="margin:1px;">Periode Laporan: <?php echo $tanggal?></p>
			<br/>
	</div>
	<div class="row font10">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead style="font-size:10px;">
						<tr style="border:1px solid #000;">
							<th rowspan="2" width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No</th>
							<th rowspan="2" width="5%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Kode</th>
							<th rowspan="2" width="20%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Nama Barang</th>
							<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Satuan</th>
							<?php if ($group == 'UnGroup'){?>
							<th rowspan="2" width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Batch</th>
							<?php } ?>
							<th rowspan="2" width="12%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Sumber</th>
							<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Stok Awal IFK</th>
							<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Stok Awal Kab/Kota</th>
							<th colspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Pemasukan</th>
							<th colspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah Pengeluaran</th>
							<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Retur Puskesmas ke IFK</th>
							<th colspan="3" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Pemusnahan</th>
							<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Stok Akhir IFK</th>
							<th rowspan="2" width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Stok Akhir Kab/Kota</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">PBF</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">IF Lain</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">IFK</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Pemakaian Pkm</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Jumlah</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.BAP</th>
							<th style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tgl.BAP</th>
						</tr>
					</thead>
					<tbody style="font-size:10px;">
					<?php
						// gudang besar
						if ($group == 'Group'){
							$str = "SELECT * FROM `tbgfkstok` WHERE `GolonganFungsi` like '%PSIKOTROPIKA%' OR `GolonganFungsi` like '%NARKOTIKA%' GROUP BY NamaBarang";
						}else{
							$str = "SELECT * FROM `tbgfkstok` WHERE `GolonganFungsi` like '%PSIKOTROPIKA%' OR `GolonganFungsi` like '%NARKOTIKA%'";
						}
						$str2 = $str." order by NamaBarang";
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$kodebarang = $data['KodeBarang'];
						$namabarang = $data['NamaBarang'];
						
						// stok awal ifk
						if ($group == 'Group'){
							$str_stokawal = "SELECT SUM(a.Stok)AS Stok FROM `tbstokbulanangudangbsr` a JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang WHERE b.`NamaBarang`='$namabarang' AND a.`bulan`='$bulan' AND a.`tahun`='$tahun'";
						}else{
							$str_stokawal = "SELECT `Stok` FROM `tbstokbulanangudangbsr` WHERE `KodeBarang`='$kodebarang' AND `bulan`='$bulan' AND `tahun`='$tahun'";
						}
						
						$query_stokawal = mysqli_query($koneksi,$str_stokawal);
						$data_stokawal = mysqli_fetch_assoc($query_stokawal);
						if($data_stokawal !== ''){
							$stokifk = $data_stokawal['Stok'];
						}else{
							$stokifk = "0";
						}
						
						// stok kab/kota (gabungan stok gudang pkm dan dinkes)
						if ($group == 'Group'){
							$str_gop = "SELECT SUM(a.Stok)AS Stok FROM `tbgudangpkmstok` a JOIN `tbgfkstok` b ON a.KodeBarang = b.KodeBarang WHERE b.`NamaBarang`='$namabarang'";
						}else{
							$str_gop = "SELECT `Stok` FROM `tbgudangpkmstok` WHERE `KodeBarang`='$kodebarang'";
						}
						$query_gop = mysqli_query($koneksi,$str_gop);
						$data_gop = mysqli_fetch_assoc($query_gop);
						if(mysqli_num_rows($query_gop) == 0){
							$stok_gop = "0";
						}else{
							$stok_gop = $data_gop['Stok'];
						}
						$stok_kabkota = $stokifk + $stok_gop;
						
						// penerimaan/pemasukan
						$str_terima = "SELECT * FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
						WHERE YEAR(a.TanggalPenerimaan)='$tahun' AND MONTH(a.TanggalPenerimaan)='$bulan' AND b.KodeBarang='$kodebarang'";
						$query_terima = mysqli_query($koneksi, $str_terima);
						$dt_terima = mysqli_fetch_assoc($query_terima);
						
						// pengeluaran dinas
						if ($group == 'Group'){
							$str_keluar = "SELECT * FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
							JOIN tbgfkstok c ON b.KodeBarang = c.KodeBarang
							WHERE YEAR(a.TanggalPengeluaran)='$tahun' AND MONTH(a.TanggalPengeluaran)='$bulan' AND c.NamaBarang='$namabarang'";
						}else{
							$str_keluar = "SELECT * FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
							WHERE YEAR(a.TanggalPengeluaran)='$tahun' AND MONTH(a.TanggalPengeluaran)='$bulan' AND b.KodeBarang='$kodebarang'";
						}
						$query_keluar = mysqli_query($koneksi, $str_keluar);
						$dt_keluar = mysqli_fetch_assoc($query_keluar);
						
						// pengeluaran puskesmas
						$str_keluar_pkm = "SELECT * FROM tbgudangpkmpengeluaran a JOIN tbgudangpkmpengeluarandetail b ON a.NoFaktur = b.NoFaktur
						WHERE YEAR(a.TanggalPengeluaran)='$tahun' AND MONTH(a.TanggalPengeluaran)='$bulan' AND b.KodeBarang='$kodebarang'";
						$query_keluar_pkm = mysqli_query($koneksi, $str_keluar_pkm);
						$dt_keluar_pkm = mysqli_fetch_assoc($query_keluar_pkm);
						
						// stok akhir ifk
						$stok_akhir_ifk = $stokifk + $dt_terima['Jumlah'] - $dt_keluar['Jumlah'];
						
						// stok akhir kab/kota
						$stok_akhir_kabkota = $stok_kabkota + $dt_terima['Jumlah'] - $dt_keluar['Jumlah'] - $dt_keluar_pkm['Jumlah'];
						?>
						<tr>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $kodebarang;?></td>
							<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namabarang;?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
							<?php if ($group == 'UnGroup'){?>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['NoBatch'];?></td>
							<?php } ?>
							<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['SumberAnggaran'];?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($stokifk);?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($stok_kabkota);?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_terima['Jumlah']);?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;">-</td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_keluar['Jumlah']);?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_keluar_pkm['Jumlah']);?></td>
							<td style="text-align:center; border:1px solid #000; padding:3px;">-</td>
							<td style="text-align:center; border:1px solid #000; padding:3px;">-</td>
							<td style="text-align:center; border:1px solid #000; padding:3px;">-</td>
							<td style="text-align:center; border:1px solid #000; padding:3px;">-</td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($stok_akhir_ifk);?></td>
							<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($stok_akhir_kabkota);?></td>				
						</tr>
					<?php
					}
					?>
					</tbody>
				</table>
			</div>	
		</div>
	</div>
	<?php
	}
	?>
</div>