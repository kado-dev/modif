<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
?>

<!--data registrasi-->
<div class="table-responsive">
	<table class="table table-striped table-condensed"><!-- table-condensed pada bootstrap.min.css ".table-condensed>tfoot>tr>td{padding:3px}"-->
		<thead>
			<tr>
				<th>No.</th>
				<th>Tanggal</th>
				<th>No.Index</th>
				<th>Nama Pasien</th>
				<th>L/P</th>
				<th>Umur</th>
				<th>Poli Pertama</th>
				<th>Jaminan</th>
				<th>Status</th>
				<th>Opsi</th>
			</tr>
		</thead>
		<!--tbpasienrj-->
		<tbody font="8">
			<!--paging-->
			<?php
			$jumlah_perpage = 20;
			
			if($_GET['h']==''){
				$mulai=0;
			}else{
				$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$kategori = $_GET['kategori'];		
			$key = $_GET['key'];		
			
			if($kategori !='' && $key !=''){
				$strcari = " AND ".$kategori." Like '%$key%'";
			}else{
				$strcari = " ";
			}
			
			$tanggal = date('Y-m-d');//H:i:s
			$str = "select * from `tbpasienrj` where `TanggalRegistrasi`='$tanggal' AND substring(NoRegistrasi,1,11) = '$kodepuskesmas'".$strcari;
			//echo $str;
			$str2 = $str."order by `NoRegistrasi` Desc limit $mulai,$jumlah_perpage";
			//echo var_dump($str);
			//die();
			
			if($_GET['h'] == null || $_GET['h'] == 1){
				$no = 0;
			}else{
				$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
			}
			
			$query = mysqli_query($koneksi,$str2);
			while($data = mysqli_fetch_assoc($query)){
			$no = $no + 1;
			$tbpoliumum = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * from tbpoliumum where NoPemeriksaan = '$data[NoRegistrasi]'"));
			?>
				<tr>
					<td><?php echo $no;?></td>
					<td><?php echo $data['TanggalRegistrasi'];?></td>
					<td><?php echo $data['NoIndex'];?></td>
					<td><?php echo $data['NamaPasien'];?></td>
					<td><?php echo $data['JenisKelamin'];?></td>
					<td><?php echo $data['UmurTahun'];?> Thn, <?php echo $data['UmurBulan'];?> Bln,  <?php echo $data['UmurHari'];?> Hri</td>
					<td><?php echo $data['PoliPertama'];?></td>
					<td><?php echo $data['Asuransi'];?></td>
					<td><?php echo $data['StatusPelayanan'];?></td>
					<td>
					
						<a href="?page=registrasi_delete&noregistrasi=<?php echo $data['NoRegistrasi'];?>&no=<?php echo $data['NoIndex'];?>&tgl=<?php echo $data['TanggalRegistrasi'];?>&nourut=<?php echo $data['NoUrutBpjs'];?>" class="btn btn-xs btn-danger">Delete</a>
						<?php
						if($data['Asuransi'] != 'BPJS'){
							if($data['StatusPelayanan'] != 'Sudah'){
						?>
						<a href="?page=registrasi_edit&noregistrasi=<?php echo $data['NoRegistrasi'];?>&pelayanan=<?php echo $data['PoliPertama'];?>" class="btn btn-xs btn-success">Edit</a>
						<?php
							}
							}
						?>
					<?php
					if($tbpoliumum['StatusPulang'] == 'Rujuk Lanjut'){
					?>	
						<a href="?page=cetak_rujukan_bpjs&no=<?php echo $data['NoRegistrasi'];?>&pelayanan=<?php echo $data['PoliPertama'];?>" class="btn btn-xs btn-info">Cetak</a>
					<?php }?>	
					</td>			
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>
<hr>
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
					echo "<li><a href='?page=registrasi_data&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
				}
			}
		}
	?>	
</ul>