<?php
	include "config/helper_report.php";
?>

<div class="tableborderdiv">
	<div class="row noprint">
		<div class="col-xs-12">
			<h3 class="judul"><b>KETERSEDIAAN</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="lap_gfk_ketersediaan_barang_bogorkab_group_view_puskesmas"/>
						<div class="col-sm-2">
							<div class="tampilformdate">
								<div class="input-group tampilformdate">
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>
									<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal">
								</div>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="tampilformdate">
								<div class="input-group tampilformdate">
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>
									<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir">
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="input-group">
								<select name="namaprg" class="form-control">
									<option value='Semua'>Semua</option>
									<?php
									$queryp = mysqli_query($koneksi,"SELECT * FROM `ref_obatprogram` order by `nama_program`");
									while($data3 = mysqli_fetch_assoc($queryp)){
										if($_GET['namaprg'] == $data3['nama_program']){
											echo "<option value='$data3[nama_program]' SELECTED>$data3[nama_program]</option>";
										}else{
											echo "<option value='$data3[nama_program]'>$data3[nama_program]</option>";
										}
									}
									?>
								</select>
								<span class="input-group-addon">Program</span>
							</div>
						</div>	
						<div class="col-sm-2">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketik Nama Barang">
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-warning btn-white"><span class="fa fa-search"></span></button>
							<a href="?page=lap_gfk_ketersediaan_barang_bogorkab_group_view_puskesmas" class="btn btn-info btn-white"><span class="fa fa-refresh"></span></a>
							<a href="lap_gfk_ketersediaan_barang_bogorkab_group_view_puskesmas_excel.php?keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&namaprg=<?php echo $_GET['namaprg'];?>&key=<?php echo $_GET['key'];?>" class="btn btn-success btn-white"><span class="fa fa-file-excel"></span></a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
	<?php
		$keydate1 = $_GET['keydate1'];
		$keydate2 = $_GET['keydate2'];	
		$namaprg = $_GET['namaprg'];
		$key = $_GET['key'];
		if(isset($_GET['namaprg'])){
	?>	
	
	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo $namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font14" style="margin:15px 5px 5px 5px;"><b>LAPORAN PERSEDIAAN</b></span><br>
		<span class="font10" style="margin:15px 5px 5px 5px;">Periode : <?php echo $_GET['keydate1']." s/d ".$_GET['keydate2'];?></span><br>
		<br/>
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan" width="100%">
					<thead>
						<tr>
							<th width="3%">No.</td>
							<th width="15%">Nama Barang</td>
							<th width="5%">Satuan</td>
							<th width="10%">Batch</td>
							<th width="8%">Expire</td>
							<th width="10%">Sumber Anggaran</td>
							<th width="3%">Tahun</td>
							<th width="15%">Supplier</td>
							<th width="7%" style="display: none">Saldo Awal</td>
							<th width="7%" style="display: none">Penerimaan</td>
							<th width="7%" style="display: none">Pengeluaran</td>
							<th width="7%">Stok</td>
						</tr>
					</thead>
					<tbody>
						<?php						
							$jumlah_perpage = 20;
							if($_GET['h']==''){
								$mulai=0;
							}else{
								$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
							
							if($namaprg == "Semua" || $namaprg == ""){
								$program = "";
							}else{
								$program = "AND `NamaProgram`='$namaprg'";
							}
							
							// tahap1, tbgfkstok karena berdasarkan ketersediaan real jangan pakai ref_obat_lplpo
							$str = "SELECT * FROM `tbgfkstok` WHERE (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%') ".$program;
							$str2 = $str." GROUP BY KodeBarang, NamaProgram ORDER BY `NamaProgram`,`NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";
							// echo $str2;							
							
							if($_GET['h'] == null || $_GET['h'] == 1){
								$no = 0;
							}else{
								$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
							}
														
							$query_obat = mysqli_query($koneksi,$str2);
							while($data = mysqli_fetch_assoc($query_obat)){
								if($namaprogram != $data['NamaProgram']){
									echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='12'>$data[NamaProgram]</td></tr>";
									$namaprogram = $data['NamaProgram'];
								}
								
								$no = $no + 1;
								$kodebarang = $data['KodeBarang'];
								$namabarang = $data['NamaBarang'];
								$idprogram = $data['IdProgram'];
								$namaprogram = $data['NamaProgram'];
								$nobatch = $data['NoBatch'];
								
								// Batch
								$no1 = 0;
								$query_batch = mysqli_query($koneksi, "SELECT `NoBatch` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NamaProgram`='$namaprogram'");
								while($dt_batch = mysqli_fetch_assoc($query_batch)){
									$no1 = $no1 + 1;
									$array_data[$no][] = "(".$no1.") ".$dt_batch['NoBatch'];
									$nobats[$no][] = $dt_batch['NoBatch'];
								}	
								
								if ($array_data[$no] != ''){
									$nomorbatch = implode("<br/>", $array_data[$no]);
								}else{
									$nomorbatch ="";
								}
								
								// Expire
								$no2 = 0;
								$query_expire = mysqli_query($koneksi, "SELECT `Expire` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NamaProgram`='$namaprogram'");
								while($dt_expire = mysqli_fetch_assoc($query_expire)){
									$no2 = $no2 + 1;
									$array_data1[$no][] = "(".$no2.") ".$dt_expire['Expire'];
								}	
								if ($array_data1[$no] != ''){
									$exp = implode("<br/>", $array_data1[$no]);
								}else{
									$exp ="";
								}
								
								// Sumber Anggaran
								$no3 = 0;
								$query_sumber_anggaran = mysqli_query($koneksi, "SELECT `SumberAnggaran` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NamaProgram`='$namaprogram'");
								while($dt_sumber_anggaran= mysqli_fetch_assoc($query_sumber_anggaran)){
									$no3 = $no3 + 1;
									$array_data2[$no][] = "(".$no3.") ".$dt_sumber_anggaran['SumberAnggaran'];
								}	
								if ($array_data2[$no] != ''){
									$sbag = implode("<br/>", $array_data2[$no]);
								}else{
									$sbag ="";
								}
								
								// Tahun Anggaran
								$no3 = 0;
								$query_tahun_anggaran = mysqli_query($koneksi, "SELECT `TahunAnggaran` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NamaProgram`='$namaprogram'");
								while($dt_tahun_anggaran= mysqli_fetch_assoc($query_tahun_anggaran)){
									$no4 = $no4 + 1;
									$array_data3[$no][] = "(".$no4.") ".$dt_tahun_anggaran['TahunAnggaran'];
								}	
								if ($array_data3[$no] != ''){
									$thag = implode("<br/>", $array_data3[$no]);
								}else{
									$thag ="";
								}
								
								// Supplier
								$no4 = 0;
								$query_supplier = mysqli_query($koneksi, "SELECT b.nama_prod_obat FROM `tbgfkstok` a
								JOIN `ref_pabrik` b ON a.Produsen = b.id
								WHERE a.`KodeBarang`='$kodebarang' AND a.`NamaProgram`='$namaprogram'");
								while($dt_supplier= mysqli_fetch_assoc($query_supplier)){
									$no5 = $no5 + 1;
									$array_data4[$no][] = "(".$no5.") ".$dt_supplier['nama_prod_obat'];
								}	
								if ($array_data4[$no] != ''){
									$supp = implode("<br/>", $array_data4[$no]);
								}else{
									$supp ="";
								}
																															
								// tahap2, menentukan stok awal stok / saldo awal
								$nbct = implode(",", $nobats[$no]);
								$str_stokawal = "SELECT SUM(Stok) AS Stok FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `NamaProgram`='$namaprogram'";
								// echo $str_stokawal;
								$dt_stokawal_dtl = mysqli_fetch_assoc(mysqli_query($koneksi, $str_stokawal));
								if ($dt_stokawal_dtl['Stok'] != ''){
									$stokawal = $dt_stokawal_dtl['Stok'];
								}else{
									$stokawal = '0';
								}
																
								// tahap2.1 cek jika 0, hitung jumlah penerimaan bulan sebelumnya
								$str_terima_lalu = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah 
								FROM `tbgfkpenerimaandetail` a JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE a.`KodeBarang`='$kodebarang' AND a.`NamaProgram`='$namaprogram' AND b.TanggalPenerimaan < '$keydate1'";
								// echo $str_terima_lalu;
								$dt_terima_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_terima_lalu));									
								if ($dt_terima_lalu['Jumlah'] != null || $dt_terima_lalu['Jumlah'] != 0){
									$penerimaan_lalu = $dt_terima_lalu['Jumlah'];
								}else{
									$penerimaan_lalu = '0';
								}

								// tahap2.2 cek pengeluaran sebelumnya
								$str_pengeluaran_lalu = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
								JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
								WHERE a.`KodeBarang`='$kodebarang' AND a.`NamaProgram`='$namaprogram' AND b.TanggalPengeluaran < '$keydate1'";	
								// echo $str_pengeluaran_lalu;
								$dt_pengeluaran_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_lalu));									
								if ($dt_pengeluaran_lalu['Jumlah'] != null){
									$pengeluaran_lalu = $dt_pengeluaran_lalu['Jumlah'];
								}else{
									$pengeluaran_lalu = '0';
								}	
								
								$stokawal_total = $stokawal + $penerimaan_lalu - $pengeluaran_lalu;

								// tahap3, menentukan penerimaan (tampil semua aja, tidak perlu tanggal nanti minus di sisa akhir)
								$strpenerimaan = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` a
								JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE a.`KodeBarang`='$kodebarang' AND a.`NamaProgram`='$namaprogram' AND b.TanggalPenerimaan BETWEEN '$keydate1' AND '$keydate2'";
								$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan));
								if ($dtpenerimaan['Jumlah'] != null || $dtpenerimaan['Jumlah'] != 0){
									$penerimaan = $dtpenerimaan['Jumlah'];
								}else{
									$penerimaan = '0';
								}		
								
								// tahap4, menentukan pemakaian/pengeluaran
								$strpengeluaran = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
								JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
								WHERE a.`KodeBarang`='$kodebarang' AND a.`NamaProgram`='$namaprogram' AND b.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2'";
								// echo $strpengeluaran;
								$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, $strpengeluaran));								
								if ($dtpengeluaran['Jumlah'] != null || $dtpengeluaran['Jumlah'] != 0){
									$pengeluaran = $dtpengeluaran['Jumlah'];
								}else{
									$pengeluaran = '0';
								}	
								
								// tahap4.1, hitung jumlah pengeluaran bulan sebelumnya
								$str_pengeluaran_lalu = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgfkpengeluarandetail` a 
								JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur 
								WHERE a.`KodeBarang`='$kodebarang' AND a.`NamaProgram`='$data[NamaProgram]' AND b.TanggalPengeluaran < '$keydate1'";
								// echo $str_pengeluaran_lalu;
								$dt_pengeluaran_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_lalu));									
								if ($dt_pengeluaran_lalu['Jumlah'] != null){
									$pengeluaran_lalu = $dt_pengeluaran_lalu['Jumlah'];
								}else{
									$pengeluaran_lalu = '0';
								}								
								$pengeluaran_total = $pengeluaran; // + $pengeluaran_lalu
																
								// tahap5, sisaakhir
								$sisaakhir = $stokawal_total + $penerimaan - $pengeluaran_total;
								
						?>
								<tr>
									<td style="text-align:center;"><?php echo $no;?></td>
									<td style="text-align:left;" class="namabarangcls">
										<?php 
											echo "<b>".$data['NamaBarang']."</b><br/>";
											// echo $data['KodeBarang']."<br/>";
											// echo "<b>Keterangan :</b><br/>";
											// echo "Stok Master = ".$stokawal."<br/>";
											// echo "Penerimaan Lalu = ".$penerimaan_lalu."<br/>";
											// echo "Pengeluaran Lalu = ".$pengeluaran_lalu."<br/>";
											// echo "Saldo Awal = ".$stokawal_total;
										?>
									</td>
									<td style="text-align:center;"><?php echo $data['Satuan'];?></td>
									<td style="text-align:left;"><?php echo str_replace(",", ", ", $nomorbatch);?></td>
									<td style="text-align:left;"><?php echo str_replace(",", ", ", $exp);?></td>
									<td style="text-align:left;"><?php echo str_replace(",", ", ", $sbag);?></td>
									<td style="text-align:left;"><?php echo str_replace(",", ", ", $thag);?></td>
									<td style="text-align:left;"><?php echo str_replace(",", ", ", $supp);?></td>
									<td style="text-align:right; display: none;"><?php echo rupiah($stokawal_total);?></td>
									<td style="text-align:right; display: none;"><?php echo rupiah($penerimaan);?></td>
									<td style="text-align:right; display: none;"><?php echo rupiah($pengeluaran_total);?></td>
									<td style="text-align:right;"><?php echo rupiah($sisaakhir);?></td>
								</tr>
							<?php
							}
							?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<ul class="pagination noprint">
		<?php
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
						echo "<li><a href='?page=lap_gfk_ketersediaan_barang_bogorkab_group_view_puskesmas&keydate1=$keydate1&keydate2=$keydate2&namaprg=$namaprg&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php }?>
</div>	