<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>LAPORAN VAKSIN</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_gfk_vaksin"/>
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
									for($tahun = 2015 ; $tahun <= date('Y'); $tahun++){
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
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_gfk_vaksin" class="btn btn-sm btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print noprint"></span></a>
						</div>
					</form>
				</div>
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
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN VAKSIN</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($_GET['bulan']);?> <?php echo $_GET['tahun'];?></span>
	</div><br/>
		
	<div class="row font10">
		<div class="col-sm-12">
			<table class="table-judul-laporan">
				<thead>
					<tr style="border:1px solid #000;">
						<th rowspan="2" style="text-align:center;width:0.2%;vertical-align:middle; border:1px solid #000; padding:10px;">No.</th>
						<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:10px;">Kode</th>
						<th rowspan="2" style="text-align:center;width:3.5%;vertical-align:middle; border:1px solid #000; padding:10px;">Nama Barang</th>
						<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:10px;">Satuan</th>
						<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:10px;">Batch</th>
						<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:10px;">Expire Date</th>
						<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:10px;">Harga</th>
						<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:10px;">Stok Awal</th>
						<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:10px;">Penerimaan</th>
						<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:10px;">Pengeluaran</th>
						<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:10px;">Stok Akhir</th>
						<th rowspan="2" style="text-align:center;width:0.5%;vertical-align:middle; border:1px solid #000; padding:10px;">Ket.</th>
					</tr>
				</thead>
				<tbody>
				<?php
					// gudang besar
					$str = "SELECT * FROM `tbgfkstok` WHERE `KelasTherapy` = 'VAKSIN' AND `Stok` <> 0";
					$str2 = $str." order by NamaBarang";;
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$kodebarang = $data['KodeBarang'];
					$namabarang = $data['NamaBarang'];
					
					// stok awal
					$str_stokawal = "SELECT `Stok` FROM `tbstokbulanangudangbsr` WHERE `KodeBarang`='$kodebarang' AND `bulan`='$bulan' AND `tahun`='$tahun'";
					$query_stokawal = mysqli_query($koneksi,$str_stokawal);
					$data_stokawal = mysqli_fetch_assoc($query_stokawal);
					if($data_stokawal !== ''){
						$stokifk = $data_stokawal['Stok'];
					}else{
						$stokifk = "0";
					}
					
					// penerimaan/pemasukan
					$str_terima = "SELECT * FROM tbgfkpenerimaan a JOIN tbgfkpenerimaandetail b ON a.NomorPembukuan = b.NomorPembukuan
					WHERE YEAR(a.TanggalPenerimaan)='$tahun' AND MONTH(a.TanggalPenerimaan)='$bulan' AND b.KodeBarang='$kodebarang'";
					$query_terima = mysqli_query($koneksi, $str_terima);
					$dt_terima = mysqli_fetch_assoc($query_terima);
					
					// pengeluaran dinas
					$str_keluar = "SELECT * FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
					WHERE YEAR(a.TanggalPengeluaran)='$tahun' AND MONTH(a.TanggalPengeluaran)='$bulan' AND b.KodeBarang='$kodebarang'";
					$query_keluar = mysqli_query($koneksi, $str_keluar);
					$dt_keluar = mysqli_fetch_assoc($query_keluar);
					
					// stok akhir ifk
					$stok_akhir = $stokifk + $dt_terima['Jumlah'] - $dt_keluar['Jumlah'];
					
					?>
					<tr>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $kodebarang;?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namabarang;?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Satuan'];?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['NoBatch'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $data['Expire'];?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($data['HargaBeli']);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($stokifk);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_terima['Jumlah']);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($dt_keluar['Jumlah']);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo rupiah($stok_akhir);?></td>
						<td style="text-align:right; border:1px solid #000; padding:3px;"></td>
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
</div>	
