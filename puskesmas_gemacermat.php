<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>GEMA CERMAT</b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="puskesmas_gemacermat"/>
						<div class="col-sm-2">
							<select name="kategori" class="form-control kategori_bulan" required>
								<option value="">--Pilih--</option>
								<option value="Tempat" <?php if($_GET['kategori'] == 'Tempat'){echo "SELECTED";}?>>Tempat</option>
								<option value="Sumber Dana" <?php if($_GET['kategori'] == 'Sumber Dana'){echo "SELECTED";}?>>Sumber Dana</option>
								<option value="TanggalPengeluaran" <?php if($_GET['kategori'] == 'TanggalPengeluaran'){echo "SELECTED";}?>>Bulan</option>
							</select>
						</div>
						<div class="col-sm-5 isi_bulan">
							<?php
							if($_GET['kategori'] == 'TanggalPengeluaran'){
								echo "<select class='form-control' name='key'>
										<option value='01'>Januari</option>
										<option value='02'>Februari</option>
										<option value='03'>Maret</option>
										<option value='04'>April</option>
										<option value='05'>Mei</option>
										<option value='06'>Juni</option>
										<option value='07'>Juli</option>
										<option value='08'>Agustus</option>
										<option value='09'>September</option>
										<option value='10'>Oktober</option>
										<option value='11'>November</option>
										<option value='12'>Desember</option>
									</select>";
							}else{
							?>
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" required>
							<?php
							}
							?>
						</div>
						<div class="col-sm-5">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=puskesmas_gemacermat" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="puskesmas_gemacermat_excel.php?kategori=<?php echo $_GET['kategori'];?>&key=<?php echo $_GET['key'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="?page=puskesmas_gemacermat_tambah" class="btn btn-sm btn-success">Tambah Kegiatan</a>
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
		
		$key = $_GET['key'];	
		$kategori = $_GET['kategori'];	
		$namapuskesmas = $_SESSION['namapuskesmas'];
		
		if($kategori == "Tempat"){
			$kategori = " AND `Tempat` like '%$key%'";
		}elseif($kategori == "Sumber Dana"){	
			$kategori = " AND `SumberDana` like '%$key%'";
		}else{
			$kategori = "";
		}	
		
		$str = "SELECT * FROM `tbgfkgemacermat` WHERE `Penyelenggara`='$namapuskesmas'".$kategori;
		$str2 = $str." ORDER BY `IdKegiatan` DESC LIMIT $mulai,$jumlah_perpage";
		// echo $str2;
		
		if($_GET['h'] == null || $_GET['h'] == 1){
			$no = 0;
		}else{
			$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}
	?>		
	
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<table class="table-judul-laporan">
				<thead>
					<tr>
						<th width="3%" rowspan="2">NO.</th>
						<th width="7%" rowspan="2">TGL.<br/>KEGIATAN</th>
						<th width="12%" rowspan="2">TEMPAT</th>
						<th width="6%" rowspan="2">SUMBER<br/>DANA</th>
						<th width="10%" rowspan="2">PESERTA PERTEMUAN</th>
						<th width="25%" colspan="5">JUMLAH PESERTA</th>
						<th width="10%" rowspan="2">HASIL PELAKSANAAN<br/>KEGIATAN</th>
						<th width="10%" rowspan="2">RENCANA TINDAK<br/>LANJUT</th>
						<th width="10%" rowspan="2">AKSI</th>
					</tr>
					<tr>
						<th>APOTEKER</th>
						<th>NAKES LAINNYA</th>
						<th>KADER</th>
						<th>MASYARAKAT<br/>UMUM</th>
						<th>TOTAL</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$ttl_peserta = $data['JumlahApoteker'] + $data['JumlahNakesLain'] + $data['JumlahKader'] + $data['JumlahMasyarakat'];
				?>
					<tr>
						<td align="right"><?php echo $no;?></td>		
						<td align="center"><?php echo $data['TanggalKegiatan'];?></td>		
						<td align="left"><?php echo strtoupper($data['Tempat']);?></td>		
						<td align="center"><?php echo $data['SumberDana'];?></td>		
						<td align="left"><?php echo strtoupper($data['Peserta']);?></td>		
						<td align="center"><?php echo $data['JumlahApoteker'];?></td>		
						<td align="center"><?php echo $data['JumlahNakesLain'];?></td>		
						<td align="center"><?php echo $data['JumlahKader'];?></td>		
						<td align="center"><?php echo $data['JumlahMasyarakat'];?></td>		
						<td align="center"><?php echo $ttl_peserta;?></td>	
						<td align="left"><?php echo strtoupper($data['HasilKegiatan']);?></td>		
						<td align="left"><?php echo strtoupper($data['RencanaTindakLanjut']);?></td>	
						<td align="center">
							<a href="?page=puskesmas_gemacermat_edit&id=<?php echo $data['IdKegiatan'];?>" class="btn btn-xs btn-success"> Edit</a>
							<a href="?page=puskesmas_gemacermat_print&id=<?php echo $data['IdKegiatan'];?>&nf=<?php echo $data['NoFakturKegiatan'];?>" class="btn btn-xs btn-info"> Print</a>
						</td>	
					</tr>
				<?php
				}
				?>
				</tbody>
			</table>
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
						echo "<li><a href='?page=puskesmas_gemacermat&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>	
