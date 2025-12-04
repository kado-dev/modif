<?php
	session_start();
	include "config/helper_report.php";
	include "config/koneksi.php";
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>KETERSEDIAAN PUSKESMAS</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_farmasi_ketersediaan_puskesmas"/>
						<div class="col-sm-3">
							<div class="input-group">
								<span class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</span>
								<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal">
							</div>
						</div>
						<div class="col-sm-3">
							<div class="input-group">
								<span class="input-group-addon">
									<span class="fa fa-calendar"></span>
								</span>
								<input type="text" name="keydate2" class="form-control datepicker2" value="<?php echo $_GET['keydate2'];?>" placeholder = "Tanggal Akhir">
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
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=lap_farmasi_ketersediaan_puskesmas" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
						</div>
					</form>	
				</div>	
			</div>
		</div>
	</div>
	
	<?php		
		$keydate1 = $_GET['keydate1'];
		$keydate2 = $_GET['keydate2'];
		$namaprg = $_GET['namaprg'];				
		$kodepuskesmas = $_GET['kodepuskesmas'];				
		
		if(isset($keydate1) and isset($keydate2)){
		$array_bln = array('00','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des');
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr>
							<th width="1%">No.</th>
							<th width="5%">Nama Barang</th>
							<th width="2%">Batch</th>
							<th width="2%">Expire</th>
							<th width="2%">Harga<br/>Satuan</th>
							<th width="2%">Sumber Anggaran</th>
							<th width="2%">Tahun<br/>Pengadaan</th>
							<th width="2%">Stok Awal</th>
							<th width="2%">Penerimaan</th>
							<?php
								$bulanawal = date('m', strtotime($keydate1));
								$bulanakhir = date('m', strtotime($keydate2));
								for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
									echo "<th width='3%'>".$array_bln[$b]."</th>";
								}
							?>
							<th>Total Pemakaian</th>
							<th>Saldo Akhir</th>
						</tr>
						<tr>
							<th width="1%">1</th>
							<th width="1%">2</th>
							<th width="1%">3</th>
							<th width="1%">4</th>
							<th width="1%">5</th>
							<th width="1%">6</th>
							<th width="1%">7</th>
							<th width="1%">8</th>
							<th width="1%">9</th>
							<?php
								for($c = 9;$c <= intval($bulanakhir + 10); $c++){
									echo "<th width='1%'>".$c."</th>";
								}
							?>
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
						
						$key = $_GET['key'];
						$namaprg = $_GET['namaprg'];
						
						if($key !=''){
							$strcari = " AND (`NamaBarang` like '%$key%' OR `KodeBarang` like '%$key%')";
						}else{
							$strcari = " ";
						}
						
						if($namaprg == "Semua" OR $namaprg == ""){
							$namaprg = " ";
						}else{
							$namaprg = " WHERE `NamaProgram` = '$namaprg'";
						}	
						
						// ref_obat_lplpo
						$str = "SELECT * FROM `ref_obat_lplpo`".$namaprg;
						$str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";						
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
												
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							if($namaprogram != $data['NamaProgram']){
								echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='25'>$data[NamaProgram]</td></tr>";
								$namaprogram = $data['NamaProgram'];
							}		
						
							$no = $no + 1;
							$kodebarang = $data['KodeBarang'];
							
							// pengeluaran bulan
							$bln['1']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur
										WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang' AND `b.KodePuskesmas`='$kodepuskesmas'"));
							$bln['2']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur
										WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang' AND `b.KodePuskesmas`='$kodepuskesmas'"));
							$bln['3']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur
										WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang' AND `b.KodePuskesmas`='$kodepuskesmas'"));
							$bln['4']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur
										WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang' AND `b.KodePuskesmas`='$kodepuskesmas'"));
							$bln['5']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur
										WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang' AND `b.KodePuskesmas`='$kodepuskesmas'"));
							$bln['6']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur
										WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang' AND `b.KodePuskesmas`='$kodepuskesmas'"));
							$bln['7']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur
										WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang' AND `b.KodePuskesmas`='$kodepuskesmas'"));
							$bln['8']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur
										WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang' AND `b.KodePuskesmas`='$kodepuskesmas'"));
							$bln['9']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur
										WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang' AND `b.KodePuskesmas`='$kodepuskesmas'"));
							$bln['10']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur
										WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang' AND `b.KodePuskesmas`='$kodepuskesmas'"));
							$bln['11']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur
										WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang' AND `b.KodePuskesmas`='$kodepuskesmas'"));
							$bln['12']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM `tbgudangpkmpengeluaran` a JOIN `tbgudangpkmpengeluarandetail` b ON a.NoFaktur = b.NoFaktur
										WHERE a.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2' AND b.KodeBarang = '$kodebarang' AND `b.KodePuskesmas`='$kodepuskesmas'"));
							
						?>
							<tr>
								<td align="center"><?php echo $no;?></td>											
								<td align="left">
									<?php 
										echo strtoupper($data['NamaBarang']);
										// echo "<b>".strtoupper($data['NamaBarang'])."</b><br/>".$data['KodeBarang'];
									?>
								</td>	
								<td align="left">
									<?php 
										$nobt = 0;
										$str_batch = "SELECT `NoBatch` FROM `tbgudangpkmstok` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'";
										$query_batch = mysqli_query($koneksi,$str_batch);
										while($databatch = mysqli_fetch_assoc($query_batch)){
											$nobt = $nobt + 1;
											$nobatcharr[$no][] = $databatch['NoBatch'];
											echo str_replace(",", "<br/> ", "(".$nobt.") ".$databatch['NoBatch'])."<br/>";
										}
									?>
								</td>
								<td align="left">
									<?php 
										$noed = 0;
										$str_ed = "SELECT `Expire` FROM `tbgudangpkmstok` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'";
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
										$str_hb = "SELECT `HargaSatuan` FROM `tbgudangpkmstok` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'";
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
										$str_sb = "SELECT `SumberAnggaran` FROM `tbgudangpkmstok` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'";
										$query_sb = mysqli_query($koneksi,$str_sb);
										while($datasb = mysqli_fetch_assoc($query_sb)){
											$nosb = $nosb + 1;
											echo str_replace(",", ", ", "(".$nosb.") ".$datasb['SumberAnggaran'])."<br/>";
										}
									?>
								</td>	
								<td align="left">
									<?php 
										$noth = 0;
										$str_ta = "SELECT `TahunAnggaran` FROM `tbgudangpkmstok` WHERE `KodePuskesmas`='$kodepuskesmas' AND `KodeBarang`='$kodebarang'";
										$query_ta = mysqli_query($koneksi,$str_ta);
										while($datata = mysqli_fetch_assoc($query_ta)){
											$noth = $noth + 1;
											echo str_replace(",", ", ", "(".$noth.") ".$datata['TahunAnggaran'])."<br/>";
										}
									?>
								</td>	
								<td align="right">
									<?php
									// tahap 2, menentukan stok awal
									$stokawal = '0';
																	
									// tahap2.1 cek jika 0, hitung jumlah penerimaan bulan sebelumnya
									$str_terima_lalu = "SELECT a.NoFaktur, SUM(Jumlah)AS Jumlah 
									FROM `tbgudangpkmpenerimaandetail` a JOIN `tbgudangpkmpenerimaan` b ON a.NoFaktur = b.NoFaktur
									WHERE a.`KodePuskesmas`='$kodepuskesmas' AND a.`KodeBarang`='$kodebarang' AND b.TanggalPenerimaan < '$keydate1'";
									// echo $str_terima_lalu;
									$dt_terima_lalu = mysqli_fetch_assoc(mysqli_query($koneksi, $str_terima_lalu));									
									if ($dt_terima_lalu['Jumlah'] != null || $dt_terima_lalu['Jumlah'] != 0){
										$penerimaan_lalu = $dt_terima_lalu['Jumlah'];
									}else{
										$penerimaan_lalu = '0';
									}

									// tahap2.2 cek pengeluaran sebelumnya
									$str_pengeluaran_lalu = "SELECT SUM(Jumlah) AS Jumlah FROM `tbgudangpkmpengeluarandetail` a 
									JOIN `tbgudangpkmpengeluaran` b ON a.NoFaktur = b.NoFaktur 
									WHERE a.`KodePuskesmas`='$kodepuskesmas' AND a.`KodeBarang`='$kodebarang' AND b.TanggalPengeluaran < '$keydate1'";	
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
										// dari pengeluaran dinas
										$strpenerimaan = "SELECT a.NoFaktur, SUM(Jumlah)AS Jumlah FROM `tbgfkpengeluarandetail` a
										JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur
										WHERE a.`KodeBarang`='$kodebarang' AND a.`NamaProgram`='$data[NamaProgram]' AND b.TanggalPengeluaran BETWEEN '$keydate1' AND '$keydate2'";
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
								<?php } ?>
								<td align="right"><?php echo rupiah(array_sum($total[$no]));?></td>	
								<td align="right">
									<?php
										$pengeluaran_total = array_sum($total[$no]);
										$sisaakhir = $stokawal_total + $penerimaan - $pengeluaran_total;
										echo rupiah($sisaakhir);
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
						$namaprgs = $_GET['namaprg'];
						echo "<li><a href='?page=lap_farmasi_ketersediaan_puskesmas&namaprg=$namaprgs&bulanawal=$bulanawal&bulanakhir=$bulanakhir&tahun=$tahun&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>	
	<?php
		}
	?>
	<div class="row noprint">
		<div class="col-sm-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
				<p>
					<b>Keterangan :</b><br/>
					- (Batch, Expire, Harga, Sumber, Tahun Anggaran), dari stok gudang obat Puskesmas,<br/>
					  &nbsp &nbsp silahkan Approve penerimaan agar masuk di stok gudang obat Puskesmas<br/> 
					- Penerimaan, dari pengeluaran gudang obat Dinkes<br/>
					- Pengeluaran, dari entry pengeluaran barang gudang obat Puskesmas
				</p>
			</div>
		</div>
	</div>
</div>	

