<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>DISTRIBUSI UNIT PER-ITEM BARANG</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_gfk_distribusi_unitdetail_bogorkab"/>
						<div class="col-sm-2">
							<select name="bulanawal" class="form-control">
								<option value="01" <?php if($_GET['bulanawal'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulanawal'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulanawal'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulanawal'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulanawal'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulanawal'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulanawal'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulanawal'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulanawal'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulanawal'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulanawal'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulanawal'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<!--<div class="col-sm-1">
							<select name="tahunawal" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahunawal'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>-->
						<div class="col-sm-2">
							<select name="bulanakhir" class="form-control">
								<option value="01" <?php if($_GET['bulanakhir'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulanakhir'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulanakhir'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulanakhir'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulanakhir'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulanakhir'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulanakhir'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulanakhir'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulanakhir'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulanakhir'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulanakhir'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulanakhir'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-sm-1">
							<select name="tahunakhir" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahunakhir'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="namaprogram" class="form-control">
								<option value='semua'>Semua</option>
								<?php
								$queryp = mysqli_query($koneksi,"SELECT * FROM `ref_obatprogram` order by `nama_program`");
								while($data3 = mysqli_fetch_assoc($queryp)){
									if($_GET['namaprogram'] == $data3['nama_program']){
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
							<a href="?page=lap_gfk_distribusi_unitdetail_bogorkab" class="btn btn-info btn-white"><span class="fa fa-refresh"></span></a>
							<a href="lap_gfk_distribusi_unitdetail_bogorkab_excel.php?bulanawal=<?php echo $_GET['bulanawal'];?>&bulanakhir=<?php echo $_GET['bulanakhir'];?>&tahunakhir=<?php echo $_GET['tahunakhir'];?>&namaprogram=<?php echo $_GET['namaprogram'];?>&key=<?php echo $_GET['key'];?>" class="btn btn-success btn-white"><span class="fa fa-file-excel"></span></a>
							<!--<a href="lap_gfk_distribusi_unitdetail_bogorkab_print.php?bulanawal=<?php echo $_GET['bulanawal'];?>&bulanakhir=<?php echo $_GET['bulanakhir'];?>&tahunakhir=<?php echo $_GET['tahunakhir'];?>&namaprogram=<?php echo $_GET['namaprogram'];?>&key=<?php echo $_GET['key'];?>" class="btn btn-info btn-white"><span class="fa fa-print"></span></a>-->
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
		
		$bulanawal = $_GET['bulanawal'];
		$bulanakhir = $_GET['bulanakhir'];		
		$tahunakhir = $_GET['tahunakhir'];
		$namaprogram = $_GET['namaprogram'];
		$key = $_GET['key'];
							
		if($key != ""){
			$namabarang = " AND `NamaBarang` like '%$key%'";
		}else{
			$namabarang = "";
		}
		
		// if($namaprogram == "semua"){
			// $str = "SELECT * FROM `ref_obat_lplpo` WHERE `NamaBarang` like '%$key%'";
		// }else{
			// $str = "SELECT * FROM `ref_obat_lplpo` WHERE `NamaProgram`='$namaprogram'".$namabarang;
		// }
		// $str2 = $str." ORDER BY `IdLplpo`,`NamaBarang` ASC LIMIT $mulai,$jumlah_perpage";
		
		
		$str = "SELECT b.TanggalPengeluaran, b.NoFaktur, b.Penerima, a.KodeBarang, c.NamaBarang, SUM(a.Jumlah) AS Jumlah, a.Harga
				FROM tbgfkpengeluarandetail a 
				JOIN tbgfkpengeluaran b ON a.NoFaktur = b.NoFaktur
				JOIN tbgfkstok c ON a.KodeBarang = c.KodeBarang
				WHERE c.NamaBarang LIKE '%$key%'
				GROUP BY Penerima";
		$str2 = $str." ORDER BY b.`Penerima` ASC LIMIT $mulai,$jumlah_perpage";		
		
		if(isset($bulanawal) and isset($tahunakhir)){
		$array_bln = array('00','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des');
	?>
	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table-judul-laporan-min" width="100%">
					<thead>
						<tr>
							<th width="2%">NO.</th>
							<th width="15%">UNIT PENERIMA</th>
							<th width="5%">TAHUN<br/>PENGADAAN</th>
							<th width="5%">BATCH</th>
							<th width="7%">ED</th>
							<th width="6%">HARGA<br/>SATUAN</th>
							<?php
								for($b = intval($bulanawal);$b <= intval($bulanakhir); $b++){
									echo "<th width='4%'>".$array_bln[$b]."</th>";
								}
							?>
							<th width="6%">TOTAL PEMAKAIAN</th>
						</tr>
					</thead>
					<tbody style="font-size: 12px;">
					<?php
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						if($namaprograms != $data['NamaProgram']){
							echo "<tr style='border:1px dashed #000; font-weight: bold;'><td colspan='20'>$data[NamaProgram]</td></tr>";
							$namaprograms = $data['NamaProgram'];
						}
						
						$no = $no + 1;
						$penerima = $data['Penerima'];
						$kodebarang = $data['KodeBarang'];
						$namabarang = $data['NamaBarang'];
						$nobatch = $data['NoBatch'];
						
						// pengeluaran bulan
						$bln['1']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='01' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND (MONTH(a.TanggalPengeluaran)<='01' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.`Penerima`='$penerima'"));
						$bln['2']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='02' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND (MONTH(a.TanggalPengeluaran)<='02' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.`Penerima`='$penerima'"));
						$bln['3']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='03' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND (MONTH(a.TanggalPengeluaran)<='03' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.`Penerima`='$penerima'"));
						$bln['4']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='04' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND (MONTH(a.TanggalPengeluaran)<='04' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.`Penerima`='$penerima'"));
						$bln['5']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='05' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND (MONTH(a.TanggalPengeluaran)<='05' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.`Penerima`='$penerima'"));
						$bln['6']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='06' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND (MONTH(a.TanggalPengeluaran)<='06' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.`Penerima`='$penerima'"));
						$bln['7']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='07' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND (MONTH(a.TanggalPengeluaran)<='07' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.`Penerima`='$penerima'"));
						$bln['8']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='08' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND (MONTH(a.TanggalPengeluaran)<='08' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.`Penerima`='$penerima'"));
						$bln['9']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='09' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND (MONTH(a.TanggalPengeluaran)<='09' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.`Penerima`='$penerima'"));
						$bln['10']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='10' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND (MONTH(a.TanggalPengeluaran)<='10' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.`Penerima`='$penerima'"));
						$bln['11']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='11' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND (MONTH(a.TanggalPengeluaran)<='11' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.`Penerima`='$penerima'"));
						$bln['12']  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT a.TanggalPengeluaran, b.KodeBarang, SUM(b.Jumlah)AS Jumlah FROM tbgfkpengeluaran a JOIN tbgfkpengeluarandetail b ON a.NoFaktur = b.NoFaktur
									WHERE (MONTH(a.TanggalPengeluaran)>='12' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND (MONTH(a.TanggalPengeluaran)<='12' AND YEAR(a.TanggalPengeluaran)='$tahunakhir') AND b.KodeBarang = '$kodebarang' AND a.`Penerima`='$penerima'"));
						
						if($penerima != '' AND $penerima != '-'){
					?>
						<tr>
							<td align="center"><?php echo $no;?></td>										
							<td align="left"><?php echo $penerima;?></td>									
							<td align="center">
								<?php 
									$noth = 0;
									$str_ta = "SELECT `TahunAnggaran` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'";
									$query_ta = mysqli_query($koneksi,$str_ta);
									while($datata = mysqli_fetch_assoc($query_ta)){
										$noth = $noth + 1;
										echo str_replace(",", ", ", $noth.": ".$datata['TahunAnggaran'])."<br/>";
									}
								?>
							</td>							
							<td align="center">
								<?php 
									$nobt = 0;
									$str_batch = "SELECT `NoBatch` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'";
									$query_batch = mysqli_query($koneksi,$str_batch);
									while($databatch = mysqli_fetch_assoc($query_batch)){
										$nobt = $nobt + 1;
										echo str_replace(",", ", ", $nobt.": ".$databatch['NoBatch'])."<br/>";
									}
								?>
							</td>							
							<td align="center">
								<?php 
									$noed = 0;
									$str_ed = "SELECT `Expire` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'";
									$query_ed = mysqli_query($koneksi,$str_ed);
									while($dataed = mysqli_fetch_assoc($query_ed)){
										$noed = $noed + 1;
										echo str_replace(",", ", ", $noed.": ".date("d-m-Y", strtotime($dataed['Expire'])))."<br/>";
									}
								?>
							</td>
							<td align="center">
								<?php 
									$nohb = 0;
									$str_hb = "SELECT `HargaBeli` FROM `tbgfkstok` WHERE `KodeBarang`='$kodebarang'";
									$query_hb = mysqli_query($koneksi,$str_hb);
									while($datahb = mysqli_fetch_assoc($query_hb)){
										$nohb = $nohb + 1;
										echo str_replace(",", ", ", $nohb.": ".rupiah($datahb['HargaBeli']))."<br/>";
									}
								?>
							</td>		
							<?php
							//$total = 0;
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
								//$total = array_sum($total[$no]);
							?>							
							<td align="right"><?php echo rupiah(array_sum($total[$no]));?></td>							
						</tr>
					<?php
						}
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
						echo "<li><a href='?page=lap_gfk_distribusi_unitdetail_bogorkab&bulanawal=$bulanawal&bulanakhir=$bulanakhir&tahunakhir=$tahunakhir&namaprogram=$namaprogram&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
		}
	?>
</div>	