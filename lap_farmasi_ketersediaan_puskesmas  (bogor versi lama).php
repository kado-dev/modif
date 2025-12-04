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
							<div class="tampilformdate">
								<div class="input-group tampilformdate">
									<span class="input-group-addon">
										<span class="fa fa-calendar"></span>
									</span>
									<input type="text" name="keydate1" class="form-control datepicker2" value="<?php echo $_GET['keydate1'];?>" placeholder = "Tanggal Awal">
								</div>
							</div>
						</div>
						<div class="col-sm-3">
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
		$tahun = '2021';	
		
		if(isset($keydate1) and isset($keydate2)){
		$array_bln = array('00','JAN','FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES');
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr>
							<th width="2%">NO.</th>
							<th width="23%">NAMA BARANG</th>
							<th width="5%">STOK<br/>AWAL</th>
							<th width="5%">PENERIMAAN</th>
							<?php
								$bulanawal = date('m', strtotime($keydate1));
								$bulanakhir = date('m', strtotime($keydate2));
								for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
									echo "<th width='3%'>".$array_bln[$b]."</th>";
								}
							?>
							<th width="5%">TOTAL<br/>PEMAKAIAN</th>
							<th width="5%">STOK<br/>AKHIR</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$jumlah_perpage = 50;
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
								echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='20'>$data[NamaProgram]</td></tr>";
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
								<td align="right">
									<?php
									// menentukan stok awal, tbstokopnam_puskesmas_bogorkab
									$stokawal = '0';
									$data_stokopnam = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tbstokopnam_puskesmas_bogorkab` WHERE `KodePuskesmas`='$kodepuskesmas' AND `Tahun`='$tahun' AND `KodeBarang`='$kodebarang'"));
									$stok_awal = $data_stokopnam['StokAwalApbd'] + $data_stokopnam['StokAwalJkn'];	
									echo rupiah($stok_awal)."<br/>";
									?>
								</td>	
								<td align="right">
									<?php
										// dari pengeluaran dinas
										$strpngeluaran = "SELECT SUM(Jumlah)AS Jumlah FROM `tbgfkpengeluarandetail` a
										JOIN `tbgfkpengeluaran` b ON a.NoFaktur = b.NoFaktur
										WHERE a.`KodeBarang`='$kodebarang' AND a.`NamaProgram`='$data[NamaProgram]' AND b.TanggalPengeluaran 
										BETWEEN '$keydate1' AND '$keydate2' AND `KodePenerima`='$kodepuskesmas'";
										// echo $strpngeluaran;
										
										$dtpengeluaran = mysqli_fetch_assoc(mysqli_query($koneksi, $strpngeluaran));
										if ($dtpengeluaran['Jumlah'] != null || $dtpengeluaran['Jumlah'] != 0){
											$penerimaan = $dtpengeluaran['Jumlah'];
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
						echo "<li><a href='?page=lap_farmasi_ketersediaan_puskesmas&keydate1=$keydate1&keydate2=$keydate2&namaprg=$namaprgs&h=$i'>$i</a></li>";
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
					- Penerimaan, dari pengeluaran gudang obat Dinkes<br/>
					- Pengeluaran, dari entry pengeluaran barang gudang obat Puskesmas
				</p>
			</div>
		</div>
	</div>
</div>	

