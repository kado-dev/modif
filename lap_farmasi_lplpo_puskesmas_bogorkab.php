<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>LPLPO PUSKESMAS</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_lplpo_puskesmas_bogorkab"/>
						<?php
						if($_SESSION['kodepuskesmas'] == '3204' || $_SESSION['kodepuskesmas'] == '3201'){
						?>
							<div class="col-sm-2">
								<select name="kodepuskesmas" class="form-control">
									<option value='semua'>Semua</option>
									<?php
									$kota = $_SESSION['kota'];
									$queryp = mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` where `Kota`='$kota' order by `NamaPuskesmas`");
									while($data3 = mysqli_fetch_assoc($queryp)){
										if($_GET['kodepuskesmas'] == $data3['KodePuskesmas']){
											echo "<option value='$data3[KodePuskesmas]' SELECTed>$data3[NamaPuskesmas]</option>";
										}else{
											echo "<option value='$data3[KodePuskesmas]'>$data3[NamaPuskesmas]</option>";
										}
									}
									?>
								</select>
							</div>
						<?php
						}
						?>
						<div class="col-sm-2 bulanformcari">
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
						<div class="col-sm-1 bulanformcari" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2018 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="sumberanggaran" class="form-control">
								<option value="APBD KAB/KOTA" <?php if($_GET['sumberanggaran'] == 'APBD KAB/KOTA'){echo "SELECTED";}?>>APBD</option>
								<option value="APBN" <?php if($_GET['sumberanggaran'] == 'APBN'){echo "SELECTED";}?>>APBN</option>
								<option value="BLUD" <?php if($_GET['sumberanggaran'] == 'BLUD'){echo "SELECTED";}?>>BLUD</option>
							</select>
						</div>
						<div class="col-sm-3">
							<button type="submit" class="btn btn-warning btn-white"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_lplpo_puskesmas_bogorkab" class="btn btn-success btn-white"><span class="fa fa-refresh"></span></a>
							<a href="lap_farmasi_lplpo_puskesmas_bogorkab_print.php?kodepuskesmas=<?php echo $_GET['kodepuskesmas'];?>&bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&sumberanggaran=<?php echo $_GET['sumberanggaran'];?>" class="btn btn-primary btn-white"><span class="fa fa-print noprint"></span></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$sumberanggaran = $_GET['sumberanggaran'];	
	
	if($bulan == 1){
		$blnsebelumnya= '12';
		$thnsebelumnya = $tahun - 1;
	}else{
		$blnsebelumnya = $bulan - 1;
		if(strlen($blnsebelumnya) == 1){
			$blnsebelumnya = '0'.$blnsebelumnya;
		}
		$thnsebelumnya = $tahun;
	}
	
	$kodepuskesmas = $_GET['kodepuskesmas'];	
	$dtpuskesmas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbpuskesmas` WHERE KodePuskesmas='$kodepuskesmas'"));
	$tblplpomanual_bogorkab = "tblplpomanual_bogorkab_".$kodepuskesmas;
	if(isset($bulan) and isset($tahun)){
	?>
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN <?php echo $kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN PEMAKAIAN & LEMBAR PERMINTAAN OBAT (LPLPO)</b></span><br/>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?></span><br/>
	</div>
	
	<div class="atastabel font11">
		<div style="float:left; width:65%; margin-bottom:10px;">
			<table><!--style="margin-top:20px;"-->
				<?php
					$datakecamatan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kodepuskesmas'"));
				?>
				<tr>
					<td style="padding:2px 4px;">Kode Puskesmas </td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;"> <?php echo $datakecamatan['KodePuskesmas'];?></td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Nama Puskesmas </td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;"> <?php echo $datakecamatan['NamaPuskesmas'];?></td>
				</tr>
			</table>
		</div>
		<div style="float:right; width:35%; margin-bottom:10px;">	
			<table>
				<tr>
					<td style="padding:2px 4px;">Pelaporan Bulan</td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;">
						<?php
							$bulandepan = $bulan + 1;
							echo nama_bulan($bulan);
						?>
					</td>
				</tr>
				<tr>
					<td style="padding:2px 4px;">Permintaan Bulan</td>
					<td style="padding:2px 4px;"> : </td>
					<td style="padding:2px 4px;">
					<?php 
						$bulandepan = $bulan + 1;
						echo nama_bulan($bulandepan);?>
					</td>
				</tr>
			</table>
		</div>	
	</div>
	
	<div>	
		<div class="table-responsive">
			<table class="table-judul-laporan-min" width="100%">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="5%">Kode</th>
						<th width="30%">Nama Barang</th>
						<th width="6%">Satuan</th>
						<th width="6%">Stok Awal</th>
						<th width="6%">Penerimaan</th>
						<th width="6%">Persediaan</th>
						<th width="6%">Pemakaian</th>
						<th width="6%">Sisa Akhir</th>
						<th width="6%">Stok Optimum</th>
						<th width="6%">Permintaan</th>
						<th width="6%">Pemberian</th>
						<th width="6%">Batch</th>
						<th width="12%">Ket.</th>
					</tr>
				</thead>
				<tbody>
					<?php					
					$jumlah_perpage = 200;
					
					if($_GET['h']==''){
						$mulai=0;
					}else{
						$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					if ($sumberanggaran == 'APBD KAB/KOTA' OR $sumberanggaran == 'APBD KAB KOTA'){
						// ini ngambil dari pengeluaran dinas, karena klo ngambil dari gudang puskesmas kendala tdk diceklis
						$str = "SELECT * FROM `ref_obat_lplpo`";
						$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";
					}elseif($sumberanggaran == 'APBN'){
						// ini obat blud ngambil dari tbgudangpkmstok
						$str = "SELECT * FROM `tbgudangpkmstok`
						WHERE `KodePuskesmas`='$kodepuskesmas' AND `SumberAnggaran` = 'APBN' GROUP BY NamaBarang";
						$str2 = $str." ORDER BY NamaBarang ASC LIMIT $mulai,$jumlah_perpage";
					}else{
						// ini obat blud ngambil dari tbgudangpkmstok masing2 puskesmas
						$str = "SELECT * FROM `tbgudangpkmstok`
						WHERE `KodePuskesmas`='$kodepuskesmas' AND `SumberAnggaran` = 'BLUD' GROUP BY NamaBarang";
						$str2 = $str." ORDER BY NamaBarang ASC LIMIT $mulai,$jumlah_perpage";
					}						
					// echo $str2;
										
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						if($namaprogram != $data['NamaProgram']){
							echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='14'>$data[NamaProgram]</td></tr>";
							$namaprogram = $data['NamaProgram'];
						}		
						$no = $no + 1;
						$kodebarang = $data['KodeBarang'];
									
						// tahap1, stok awal ambil dari stok akhir bulan sebelumnya jika 0 ambil hasil import bulan ini
						$sisaakhir = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `SisaAkhir` FROM `$tblplpomanual_bogorkab` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang' AND `Tahun`='$thnsebelumnya' AND `Bulan`='$blnsebelumnya'"));
						$saldoawal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `StokAwal` FROM `$tblplpomanual_bogorkab` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang' AND `Tahun`='$tahun' AND `Bulan`='$bulan'"));
						if($sisaakhir['SisaAkhir'] != 0){
							$stokawal = $sisaakhir['SisaAkhir'];
						}else{
							$stokawal = $saldoawal['StokAwal'];
						}
						
						// tahap2, penerimaan digroup berdasar nama barang agar jika stoknya ada lebih dari 1 batch dia ngejumlahin
						$penerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah
						FROM `tbgudangpkmpenerimaandetail` a
						JOIN tbgudangpkmpenerimaan b on a.NoFaktur = b.NoFaktur
						WHERE MONTH(b.TanggalPenerimaan) = '$bulan' AND YEAR(b.TanggalPenerimaan) = '$tahun' AND a.KodePuskesmas='$kodepuskesmas'
						AND a.KodeBarang='$kodebarang'"));
						if($penerimaan['Jumlah'] != ''){
							$terima = $penerimaan['Jumlah'];
						}else{
							$terima = 0;
						}
						
						// pengadaan jkn
						$pengadaan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(Jumlah) AS Jumlah
						FROM `tbgudangpkmpengadaandetail` a
						JOIN `tbgudangpkmpengadaan` b on a.NoFaktur = b.NoFaktur
						WHERE MONTH(b.TanggalPengadaan) = '$bulan' AND YEAR(b.TanggalPengadaan) = '$tahun' AND a.KodePuskesmas='$kodepuskesmas'
						AND a.KodeBarang='$kodebarang'"));				
						
						if($pengadaan['Jumlah'] != ''){
							$adaan = $pengadaan['Jumlah'];
						}else{
							$adaan = 0;
						}
						
						if($sumberanggaran != 'JKN'){
							$penerimaancls = $terima;
						}else{
							$penerimaancls = $adaan;
						}
						
						// persediaan
						$persediaan = $stokawal + $penerimaancls;
									
						// pemakaian
						$lplpomanual = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `$tblplpomanual_bogorkab` WHERE `Tahun`='$tahun' AND `Bulan`='$bulan' AND `KodeBarang`='$kodebarang'"));
						$pemakaian = $lplpomanual['Pemakaian'];
						
						// sisa
						$sisa = $persediaan - $pemakaian;
						$stokoptimum = $sisa * 1.6;
										
						// permintaan
						if($lplpomanual['Permintaan'] != ''){
							$permintaans = $lplpomanual['Permintaan'];
						}else{
							$permintaans = 0;
						}		

					?>
						<tr style="border:1px solid #000;">
							<td><?php echo $no;?></td>
							<td class="kodecls"><?php echo $data['KodeBarang'];?></td>
							<td><?php echo $data['NamaBarang'];?></td>
							<td><?php echo $data['Satuan'];?></td>
							<td style="text-align:right; padding:3px; background-color:#dbf7ff;" class="stokawalcls"><?php echo rupiah($stokawal);?></td>
							<td align="right" class="penerimaancls"><?php  echo rupiah($penerimaancls);?></td>
							<td align="right" class="persediaancls"><?php echo $persediaan;?></td>
							<td style="text-align:right; padding:3px; background-color:#dbf7ff;" class="pemakaiancls"><?php echo rupiah($pemakaian);?></td>
							<td align="right" class="sisacls"><?php echo rupiah($sisa);?></td>
							<td align="right" class="stokoptimumcls"><?php echo rupiah($stokoptimum);?></td>
							<td style="text-align:right; padding:3px; background-color:#dbf7ff;" class="permintaancls"><?php echo rupiah($permintaans);?></td>
							<td></td>
							<td></td>
							<td align="center">
								<?php 
									if($sumberanggaran == "APBD KAB/KOTA"){
										echo "APBD";
									}else{
										echo $data['SumberAnggaran'];
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
	<hr class="noprint"><!--css-->
	<ul class="pagination noprint">
		<?php
			$bulan = $_GET['bulan'];
			$tahun = $_GET['tahun'];
			$query2 = mysqli_query($koneksi,$str);
			$jumlah_query = mysqli_num_rows($query2);
			
			if(($jumlah_query % $jumlah_perpage) > 0){
				$jumlah = ($jumlah_query / $jumlah_perpage)+1;
			}else{
				$jumlah = $jumlah_query / $jumlah_perpage;
			}
			for ($i=1;$i<=$jumlah;$i++){
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=lap_farmasi_lplpo_puskesmas_bogorkab&bulan=$bulan&tahun=$tahun&kodepuskesmas=$kodepuskesmas&sumberanggaran=$sumberanggaran&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
	}
	?>
</div>	
