<?php
	include "config/helper_report.php";
	$tanggal = date('d-m-Y');
?>
<style>
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
	display:none;
}
.printheader h4{
	font-size:12px;
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}
.printheader p{
	font-size:10px;
}
.printbody{
	margin-top:0px;
	margin-left:-15px;
	margin-right:-15px;
	display:none;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Tahoma, sans-serif;
}
.atastabel{
	display:none;
	margin-top:0px;
	margin-left:-15px;
}
.bawahtabel{
	margin-top:20px;
	margin-bottom:10px;
	margin-left:50px;
	display:none;
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

<div class="tableborderdiv noprint">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>PENERIMAAN REALISASI BARANG</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="lap_gfk_penerimaan_barang"/>
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
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2019 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="sumberanggaran" class="form-control">
								<option value="APBD KAB/KOTA" <?php if($_GET['sumberanggaran'] == 'APBD KAB/KOTA'){echo "SELECTED";}?> SELECTED>APBD KAB/KOTA</option>
								<option value="APBD PROV" <?php if($_GET['sumberanggaran'] == 'APBD PROV'){echo "SELECTED";}?>>APBD PROV</option>
								<option value="APBN" <?php if($_GET['sumberanggaran'] == 'APBN'){echo "SELECTED";}?>>APBN</option>
								<option value="DAK KAB/KOTA" <?php if($_GET['sumberanggaran'] == 'DAK KAB/KOTA'){echo "SELECTED";}?>>DAK KAB/KOTA</option>
								<option value="LAINNYA" <?php if($_GET['sumberanggaran'] == 'LAINNYA'){echo "SELECTED";}?>>LAINNYA</option>
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
							<a href="?page=lap_gfk_penerimaan_barang" class="btn btn-info btn-white"><span class="fa fa-refresh"></span></a>
							<a href="lap_gfk_penerimaan_barang_excel.php?bulanawal=<?php echo $_GET['bulanawal'];?>&bulanakhir=<?php echo $_GET['bulanakhir'];?>&tahun=<?php echo $_GET['tahun'];?>&sumberanggaran=<?php echo $_GET['sumberanggaran'];?>&namaprogram=<?php echo $_GET['namaprogram'];?>&key=<?php echo $_GET['key'];?>" class="btn btn-success btn-white"><span class="fa fa-file-excel"></span></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row noprint">	
		<div class="col-xs-12">
			<div class="row noprint">
				<div class="col-sm-12">
					<div class="alert alert-block alert-success fade in">
						<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
						<p>
							<b>TOTAL SALDO PENERIMAAN :</b><br/>
							<?php 	
								$bulanawal = $_GET['bulanawal'];		
								$bulanakhir = $_GET['bulanakhir'];		
								$tahun = $_GET['tahun'];					
								$sumberanggaran = $_GET['sumberanggaran'];				
								$namaprogram = $_GET['namaprogram'];
								$key = $_GET['key'];
								
								if($key != ""){
									$namabarang = " AND c.`NamaBarang` like '%$key%'";
								}else{
									$namabarang = "";
								}
								
								if($namaprogram == "semua" || $namaprogram == ""){
									$program = "";
								}else{
									$program = "AND `NamaProgram`='$namaprogram'";
								}
								
								// menghitung grand total (obat, bmhp, lab)
								$grand_obat = 0;	
								$str_obat = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
										FROM tbgfkpenerimaandetail a JOIN tbgfkpenerimaan b ON a.NomorPembukuan = b.NomorPembukuan
										WHERE YEAR(b.TanggalPenerimaan)='$tahun' AND MONTH(b.TanggalPenerimaan) BETWEEN '$bulanawal' AND '$bulanakhir' AND
										b.`SumberAnggaran`='$sumberanggaran' AND a.NamaProgram = 'PKD'".$namabarang;
								// echo $str_obat;
								$query_obat = mysqli_query($koneksi,$str_obat);
								while($data = mysqli_fetch_assoc($query_obat)){
									$jumlahobat = $data['Jumlah'];
									$grand_obat = $grand_obat + $jumlahobat;
								}
								
								// bmhp
								$grand_bmhp = 0;
								$str_bmhp = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
								FROM tbgfkpenerimaandetail a JOIN tbgfkpenerimaan b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE YEAR(b.TanggalPenerimaan)='$tahun' AND MONTH(b.TanggalPenerimaan) BETWEEN '$bulanawal' AND '$bulanakhir' AND
								b.`SumberAnggaran`='$sumberanggaran' AND a.NamaProgram = 'BMHP'".$namabarang;
								$query_bmhp = mysqli_query($koneksi,$str_bmhp);
								while($data = mysqli_fetch_assoc($query_bmhp)){
									$jumlahbmhp = $data['Jumlah'];
									$grand_bmhp = $grand_bmhp + $jumlahbmhp;
								}
								
								// laboratorium
								$grand_lab = 0;
								$str_lab = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
								FROM tbgfkpenerimaandetail a JOIN tbgfkpenerimaan b ON a.NomorPembukuan = b.NomorPembukuan
								WHERE YEAR(b.TanggalPenerimaan)='$tahun' AND MONTH(b.TanggalPenerimaan) BETWEEN '$bulanawal' AND '$bulanakhir' AND
								b.`SumberAnggaran`='$sumberanggaran' AND a.NamaProgram = 'LABORATORIUM'".$namabarang;
								$query_lab = mysqli_query($koneksi,$str_lab);
								while($data = mysqli_fetch_assoc($query_lab)){
									$jumlahlab = $data['Jumlah'];
									$grand_lab = $grand_lab + $jumlahlab;
								}
							?>
							<table width="100%">
								<tr>
									<td width="10%">OBAT</td>
									<td width="90%"><b><?php echo ": ".rupiah($grand_obat);?></b></td>
								</tr>
								<tr>
									<td>BMHP</td>
									<td><b><?php echo ": ".rupiah($grand_bmhp);?></b></td>
								</tr>
								<tr>
									<td>LAB</td>
									<td><b><?php echo ": ".rupiah($grand_lab);?></b></td>
								</tr>
								<tr>
									<td>GRAND TOTAL</td>
									<td><b><?php echo ": ".rupiah($grand_obat + $grand_bmhp + $grand_lab);?></b></td>
								</tr>
							</table>
						</p>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table-judul" width="100%">
					<thead>
						<tr>
							<th width="3%">No.</th>
							<th width="10%">Tgl.Terima</th>
							<th width="5%">Kode</th>
							<th width="25%">Nama Barang</th>
							<th width="20%">Batch</th>
							<th width="10%">Harga</th>
							<th width="10%">Jumlah Terima</th>
							<th width="10%">Total Terima</th>
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
						
						if($namaprogram == "semua"){
							$programs = "";
						}else{
							$programs = " AND a.`NamaProgram`='$namaprogram'";
						}	
							
						$str = "SELECT b.TanggalPenerimaan, a.NomorPembukuan, a.KodeBarang, c.NamaBarang, a.NoBatch, a.SumberAnggaran, a.NamaProgram, a.Harga, a.Jumlah 
						FROM `tbgfkpenerimaandetail` a
						JOIN `tbgfkpenerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
						JOIN `tbgfkstok` c ON a.KodeBarang = c.KodeBarang
						WHERE YEAR(b.TanggalPenerimaan) = '$tahun' AND MONTH(b.TanggalPenerimaan) BETWEEN '$bulanawal' AND '$bulanakhir'
						AND a.`SumberAnggaran`='$sumberanggaran'".$programs.$namabarang;								
						$str2 = $str." GROUP BY a.KodeBarang, a.NoBatch ORDER BY c.`NamaBarang` LIMIT $mulai,$jumlah_perpage";
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
						
						$query = mysqli_query($koneksi,$str2);						
						while($data = mysqli_fetch_assoc($query)){
							if($nomorfaktur != $data['NomorPembukuan']){
								echo "<tr style='border:1px solid #000; font-weight: bold; background: #adabab;'><td colspan='8'>$data[NomorPembukuan], $data[SumberAnggaran], $data[NamaProgram]</td></tr>";
								$nomorfaktur = $data['NomorPembukuan'];
							}
							
							$no = $no + 1;
							$nomorpembukuan = $data['NomorPembukuan'];
							$nobatch = str_replace(",", ", ", $data['NoBatch']);
							$total = $data['Harga'] * $data['Jumlah'];
						?>
							<tr>
								<td align="right"><?php echo $no;?></td>
								<td align="center"><?php echo $data['TanggalPenerimaan'];?></td>
								<td align="center"><?php echo $data['KodeBarang'];?></td>
								<td align="left"><?php echo $data['NamaBarang'];?></td>
								<td align="left"><?php echo $nobatch;?></td>
								<td align="right"><?php echo rupiah($data['Harga']);?></td>
								<td align="right"><?php echo rupiah($data['Jumlah']);?></td>	
								<td align="right"><b><?php echo rupiah($total);?></b></td>	
							</tr>
						<?php
						$jumlah = $jumlah + $total;
						$jumlahbarang = mysqli_num_rows(mysqli_query($koneksi, $str2));
						}	
						?>
							<tr>
								<td align="center" colspan="7"><b>TOTAL <?php echo $jumlahbarang;?> ITEM BARANG</b></td>
								<td align="right"><b><?php echo rupiah($jumlah);?></b></td>
							</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
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
			$max = $_GET['h'] + 20;
			$min = $_GET['h'] - 19;
			
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=lap_gfk_penerimaan_barang&bulanawal=$bulanawal&bulanakhir=$bulanakhir&tahun=$tahun&sumberanggaran=$sumberanggaran&namaprogram=$namaprogram$key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>
