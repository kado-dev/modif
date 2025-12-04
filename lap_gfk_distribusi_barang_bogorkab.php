<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>DISTRIBUSI ITEM BARANG</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_gfk_distribusi_barang_bogorkab"/>
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
						<div class="col-sm-2">
							<select name="namaprg" class="form-control">
								<option value='semua'>Semua</option>
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
						</div>
						<div class="col-sm-2">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketik Nama Barang">
						</div>
						<div class="col-sm-2">
							<button type="submit" class="btn btn-warning btn-white"><span class="fa fa-search"></span></button>
							<a href="?page=lap_gfk_distribusi_barang_bogorkab" class="btn btn-info btn-white"><span class="fa fa-refresh"></span></a>
							<a href="lap_gfk_distribusi_barang_bogorkab_excel.php?keydate1=<?php echo $_GET['keydate1'];?>&keydate2=<?php echo $_GET['keydate2'];?>&namaprg=<?php echo $_GET['namaprg'];?>&key=<?php echo $_GET['key'];?>" class="btn btn-success btn-white"><span class="fa fa-file-excel"></span></a>
						</div>
					</form>	
				</div>	
			</div>
		</div>
	</div>
	
	<?php
		$jumlah_perpage = 20;
		if($_GET['h']==''){
			$mulai=0;
		}else{
			$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}
		
		$keydate1 = $_GET['keydate1'];
		$keydate2 = $_GET['keydate2'];	
		$namaprg = $_GET['namaprg'];
		$key = $_GET['key'];
							
		if($key != ""){
			$namabarang = " AND `NamaBarang` like '%$key%'";
		}else{
			$namabarang = "";
		}
		
		if($namaprg == "semua"){
			$str = "SELECT * FROM `ref_obat_lplpo` WHERE (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%')";
		}else{
			$str = "SELECT * FROM `ref_obat_lplpo` WHERE `NamaProgram`='$namaprg'".$namabarang;
		}
		$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";
		
		if(isset($keydate1) and isset($keydate2)){
		$array_bln = array('00','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des');
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min">
					<thead>
						<tr>
							<th width="3%">No.</th>
							<th width="17%">Nama Obat & BMHP</th>
							<th width="10%">Batch</th>
							<th width="10%">Expire</th>
							<th width="8%">Harga<br/>Satuan</th>
							<th width="12%">Sumber</br>Anggaran</th>
							<th width="5%">Tahun<br/>Pengadaan</th>
							<th width="8%">Saldo</br>Awal</th>
							<th>Penerimaan</th>
							<?php
								$bulanawal = date('m', strtotime($keydate1));
								$bulanakhir = date('m', strtotime($keydate2));
								for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
									echo "<th width='3%'>".$array_bln[$b]."</th>";
								}
							?>
							<th width="10%">Total Pengeluaran</th>
							<th width="10%">Saldo Akhir</th>
							<th width="5%">Aksi</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						if($namaprograms != $data['NamaProgram']){
							if($data['NamaProgram'] == "PKD"){
								$prg = "OBAT (PKD)";	
							}
							echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='23'>$prg</td></tr>";
							$namaprograms = $data['NamaProgram'];
						}
						
						$no = $no + 1;
						$kodebarang = $data['KodeBarang'];
						
						// pengeluaran bulan
						$bln['1']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE MONTH(a.TanggalPengeluaran) = '01' AND a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
						$bln['2']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE MONTH(a.TanggalPengeluaran) = '02' AND a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
						$bln['3']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE MONTH(a.TanggalPengeluaran) = '03' AND a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
						$bln['4']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE MONTH(a.TanggalPengeluaran) = '04' AND a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
						$bln['5']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE MONTH(a.TanggalPengeluaran) = '05' AND a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
						$bln['6']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE MONTH(a.TanggalPengeluaran) = '06' AND a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
						$bln['7']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE MONTH(a.TanggalPengeluaran) = '07' AND a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
						$bln['8']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE MONTH(a.TanggalPengeluaran) = '08' AND a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
						$bln['9']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE MONTH(a.TanggalPengeluaran) = '09' AND a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
						$bln['10']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE MONTH(a.TanggalPengeluaran) = '10' AND a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
						$bln['11']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE MONTH(a.TanggalPengeluaran) = '11' AND a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
						$bln['12']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE MONTH(a.TanggalPengeluaran) = '12' AND a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang'"));
					
					?>
						<tr>
							<td align="center"><?php echo $no;?></td>									
							<td align="left">
								<?php 
									echo "<b>".strtoupper($data['NamaBarang'])."</b><br/>".$data['KodeBarang'];
								?>
							</td>									
							<td align="left">
								<?php 
									$nobt = 0;
									$str_batch = "SELECT `NoBatch` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NamaProgram`='$data[NamaProgram]'";
									$query_batch = mysqli_query($koneksi,$str_batch);
									while($databatch = mysqli_fetch_assoc($query_batch)){
										$nobt = $nobt + 1;
										$nobatcharr[$no][] = $databatch['NoBatch'];
										echo str_replace(",", "<br/> ", "(".$nobt.") ".$databatch['NoBatch'])."<br/>";
									}
								?>
							</td>							
							<td align="center">
								<?php 
									$noed = 0;
									$str_ed = "SELECT `Expire` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NamaProgram`='$data[NamaProgram]'";
									$query_ed = mysqli_query($koneksi,$str_ed);
									while($dataed = mysqli_fetch_assoc($query_ed)){
										$noed = $noed + 1;
										echo str_replace(",", ", ", "(".$noed.") ".date("d-m-Y", strtotime($dataed['Expire'])))."<br/>";
									}
								?>
							</td>
							<td align="left">
								<?php 
									$nohb = 0;
									$str_hb = "SELECT `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NamaProgram`='$data[NamaProgram]'";
									$query_hb = mysqli_query($koneksi,$str_hb);
									while($datahb = mysqli_fetch_assoc($query_hb)){
										$nohb = $nohb + 1;
										echo str_replace(",", ", ", "(".$nohb.") ".rupiah($datahb['HargaBeli']))."<br/>";
									}
								?>
							</td>		
							<td align="left">
								<?php 
									$nosb = 0;
									$str_sb = "SELECT `SumberAnggaran` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NamaProgram`='$data[NamaProgram]'";
									$query_sb = mysqli_query($koneksi,$str_sb);
									while($datasb = mysqli_fetch_assoc($query_sb)){
										$nosb = $nosb + 1;
										echo str_replace(",", ", ", "(".$nosb.") ".$datasb['SumberAnggaran'])."<br/>";
									}
								?>
							</td>
							<td align="center">
								<?php 
									$noth = 0;
									$str_ta = "SELECT `TahunAnggaran` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang' AND `NamaProgram`='$data[NamaProgram]'";
									$query_ta = mysqli_query($koneksi,$str_ta);
									while($datata = mysqli_fetch_assoc($query_ta)){
										$noth = $noth + 1;
										echo str_replace(",", ", ", "(".$noth.") ".$datata['TahunAnggaran'])."<br/>";
									}
								?>
							</td>	
							<td align="right">
								<?php
								// tahap2, menentukan stok awal stok / saldo awal (update 29 Juli 2021)
								$str_stokawal = "SELECT SUM(Stok) AS Stok FROM `tbstokawalmaster_gudang_besar` WHERE `KodeBarang`='$kodebarang' AND `NamaProgram`='$data[NamaProgram]'";
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
								WHERE a.`KodeBarang`='$kodebarang' AND a.`NamaProgram`='$data[NamaProgram]' AND b.TanggalPenerimaan < '$keydate1'";
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
								WHERE a.`KodeBarang`='$kodebarang' AND a.`NamaProgram`='$data[NamaProgram]' AND b.TanggalPengeluaran < '$keydate1'";	
								// echo $str_pengeluaran_lalu;
								$dt_pengeluaran_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_pengeluaran_lalu));									
								if ($dt_pengeluaran_lalu['Jumlah'] != null){
									$pengeluaran_lalu = $dt_pengeluaran_lalu['Jumlah'];
								}else{
									$pengeluaran_lalu = '0';
								}	
								
								$stokawal_total = $stokawal + $penerimaan_lalu - $pengeluaran_lalu;
								echo rupiah($stokawal_total)."<br/>";
								// echo "Stok Awal : ".$stokawal."<br/>";
								// echo "Terima : ".$penerimaan_lalu."<br/>";
								// echo "Keluar : ".$pengeluaran_lalu."<br/>";
								?>
							</td>
							<td align="right">
								<?php
									$strpenerimaan = "SELECT a.NomorPembukuan, SUM(Jumlah)AS Jumlah FROM `tbgfkpenerimaandetail` a
									JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
									WHERE a.`KodeBarang`='$kodebarang' AND a.`NamaProgram`='$data[NamaProgram]' AND b.TanggalPenerimaan BETWEEN '$keydate1' AND '$keydate2'";
									$dtpenerimaan = mysqli_fetch_assoc(mysqli_query($koneksi, $strpenerimaan));
									if ($dtpenerimaan['Jumlah'] != null || $dtpenerimaan['Jumlah'] != 0){
										$penerimaan = $dtpenerimaan['Jumlah'];
									}else{
										$penerimaan = '0';
									}	
									echo rupiah($penerimaan);
								?>
							</td>
							<?php
							$bulanawal = date('m', strtotime($keydate1));
							$bulanakhir = date('m', strtotime($keydate2));
							for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
								$total[$no][] = $bln[$b]['Jumlah'];
							?>		
							<td align="right">
								<?php 
									if($bln[$b]['Jumlah'] == ""){
										echo "0";
									}else{
										echo rupiah($bln[$b]['Jumlah']);
									}
								?>
							</td>	
							<?php
								}
								// $total = array_sum($total[$no]);
								$arrbatch = $nobatcharr[$no];
							?>							
							<td align="right"><?php echo rupiah(array_sum($total[$no]));?></td>	
							<td align="right"><b>								
								<?php
									$pengeluaran_total = array_sum($total[$no]);
									$sisaakhir = $stokawal_total + $penerimaan - $pengeluaran_total;
									echo rupiah($sisaakhir);
								?></b>
							</td>								
							<td align="center">								
								<a href="?page=lap_gfk_distribusi_barang_bogorkab_detail&kd=<?php echo $kodebarang;?>&batch=<?php echo implode(",", $arrbatch);?>&keydate1=<?php echo $keydate1;?>&keydate2=<?php echo $keydate2;?>&namaprg=<?php echo $data['NamaProgram'];?>&namaprg2=<?php echo $namaprg;?>&key=<?php echo $key;?>&namabrg=<?php echo $data['NamaBarang'];?>" class="btn btn-sm btn-info btn-white" style="margin-bottom: 3px">Lihat</a>															
							</td>							
						</tr>
					<?php
					}
					?>
					</tbody>
				</table>
			</div>
		</div>
	</div><hr/>	
	<ul class="pagination">
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
						echo "<li><a href='?page=lap_gfk_distribusi_barang_bogorkab&keydate1=$keydate1&keydate2=$keydate2&namaprg=$namaprg&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
		}
	?>
</div>	