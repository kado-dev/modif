<!--menu header-->
<table class="table table-striped table-condensed">
	<tr>
		<td class="col-sm-10">
			<h4><span class="glyphicon glyphicon-hdd"></span> Kepala Keluarga</h4>
		</td>
		<td class="col-sm-2" align="right">
			<a href="?page=pendaftaran_pilih" class="btn btn-success"><span class="glyphicon glyphicon-chevron-left"></span> Kembali</a>
		</td>
	</tr>
</table>

<div class="panel panel-default">
	<div class="panel-heading">
		Isi Data KK (Sesuai E-KTP) :
	</div>
	
	<!--nomor index-->
	<?php
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	$namapuskesmas = $_SESSION['namapuskesmas'];
	$tbkk = 'tbkk_'.str_replace(' ', '', $namapuskesmas);
	$tahun=date('Y');
	//echo $tahun;
	$sql_cek='SELECT max(NoIndex)as maxno FROM `$tbkk` WHERE SUBSTRING(NoIndex,7,4)=YEAR(now())';
	$query_cek=mysqli_query($koneksi,$sql_cek);
	$data=mysqli_fetch_array($query_cek);
		$no=substr($data['maxno'],-5);
		$no_next=$no+1;
		
			if(strlen($no_next)==1)
			{
				$no="0000".$no_next;
			}
			elseif(strlen($no_next)==2)
			{
				$no="000".$no_next;
			}
			elseif(strlen($no_next)==3)
			{
				$no="00".$no_next;
			}
			elseif(strlen($no_next)==4)
			{
				$no="0".$no_next;
			}
			else
			{
				$no=$no_next;
			}
	$noindex1="ID".$kodepuskesmas."/".$tahun."/".$no;
	?>

	<div class="panel-body">
		<form class="form-horizontal" action="index.php?page=anggota_kk_insert_proses" method="post" role="form">
			<!--masuk ke tbkk-->
			<table class="table">
				<tr>
					<td class="col-sm-2">No Index</td>
					<td>:</td>
					<td class="col-sm-10">
						<input type="text" name="noindex" value="<?php echo $noindex1;?>" class="form-control" readonly><!--style="width:200px"-->
					</td>
				</tr>
				<tr>
					<td class="col-sm-2">No.Kartu Keluarga</td>
					<td>:</td>
					<td class="col-sm-10"><input type="text" name="nokk" class="form-control" placeholder="Sesuai Kartu Keluarga" required></td>
				</tr>
				<tr>
					<td class="col-sm-2">No.E-KTP / NIK</td>
					<td>:</td>
					<td class="col-sm-10"><input type="text" name="nik" class="form-control" placeholder="Sesuai E-KTP" required></td>
				</tr>						
				<tr>
					<td class="col-sm-2">Nama KK</td>
					<td>:</td>
					<td class="col-sm-10"><input type="text" name="namakk" class="form-control" placeholder="Sesuai E-KTP" required></td>
				</tr>
			</table><hr>
			
			<!--masuk ke tbkk-->
			<table class="row">
				<tr>
					<td class="col-sm-2"><b>Alamat Tinggal (Sesuai E-KTP) :</b></td>
				</tr>
			</table><p>
			
			<table class="table">
				<tr>
					<td class="col-sm-2">Daerah</td>
					<td>:</td>
					<td class="col-sm-10">
						<select name="daerah"  class="form-control" required>
							<option value="">--Pilih--</option>
							<option value="Luar">Luar</option>
							<option value="Dalam">Dalam</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="col-sm-2">Wilayah</td>
					<td>:</td>
					<td class="col-sm-10">
						<select name="wilayah"  class="form-control" required>
							<option value="">--Pilih--</option>
							<option value="Luar">Luar</option>
							<option value="Dalam">Dalam</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="col-sm-2">Alamat</td>
					<td>:</td>
			
					<td class="col-sm-10">
						<div class="row" >
							<div class="col-sm-12"> 
								<input type="text" name="alamat" class="form-control" placeholder = "Sesuai E-KTP" required>
							</div>
							<div class="col-sm-2" style="padding:10px 15px 0px 15px">
								<input type="text" name="rt" class="form-control" maxlength ="2" placeholder = "RT" required>						
							</div>
							<div class="col-sm-2" style="padding:10px 15px 0px 15px">
								<input type="text" name="rw" class="form-control" maxlength ="2" placeholder = "RW" required>
							</div>
							<div class="col-sm-2" style="padding:10px 15px 0px 15px">
								<input type="text" name="no" class="form-control" maxlength ="8" placeholder = "No" required>									
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="col-sm-2">Provinsi</td>
					<td>:</td>
					<td class="col-sm-10"><input type="text" name="provinsi" class="form-control nama_provinsi"></td>
				</tr>
				<tr>
					<td class="col-sm-2">Kota</td>
					<td>:</td>
					<td class="col-sm-10"><input type="text" name="kota" class="form-control nama_kota"></td>
				</tr>
				<tr>
					<td class="col-sm-2">Kecamatan</td>
					<td>:</td>
					<td class="col-sm-10"><input type="text" name="kecamatan" class="form-control nama_kecamatan"></td>
				</tr>
				<tr>
					<td class="col-sm-2">Kelurahan</td>
					<td>:</td>
					<td class="col-sm-10"><input type="text" name="kelurahan" class="form-control nama_kelurahan"></td>
				</tr>
				<tr>
					<td class="col-sm-2">Telepon</td>
					<td>:</td>
					<td class="col-sm-10"><input type="number" name="telepon" class="form-control" required></td>
				</tr>
				<tr>
					<td class="col-sm-2"></td>
					<td></td>
					<td class="col-sm-10"><button type="submit" class="btn btn-success pull-right" >Submit</button></td>
				</tr>
			</table>
		</form>
	</div>
</div>

<!--menu header-->
<table class="table table-striped table-condensed">
	<tr>
		<td class="col-sm-10">
			<h4><span class="glyphicon glyphicon-hdd"></span> Data KK</h4>
		</td>
	</tr>
</table>

<!--data pasien-->
<div class="table-responsive">
	<table class="table table-striped table-condensed"><!-- table-condensed pada bootstrap.min.css ".table-condensed>tfoot>tr>td{padding:3px}"-->
		<thead>
			<tr>
				<th>No.</th>
				<th>No Index</th>
				<th>Nama KK</th>
				<th>Alamat</th>		
				<th>Kota</th>						
				<th>Opsi</th>
			</tr>
		</thead>
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
		
		if(isset($kategori) && isset($key)){
			$strcari = " where ".$kategori." Like '%$key%'";
		}else{
			$tglhariini = date('Y-m-d');
			$strcari = " ";
		}
		
		
		$str = "select * FROM `$tbkk` ".$strcari;
		$str2 = $str."order by NoIndex Desc limit $mulai,$jumlah_perpage";
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
		?>
			<tr>
				<td><?php echo $no;?></td>
				<td><?php echo $data['NoIndex'];?></td>
				<td><?php echo $data['NamaKK'];?></td>
				<td><?php echo $data['Alamat'];?>
					RT.<?php echo $data['RT'];?>
					RW.<?php echo $data['RW'];?>
					No.<?php echo $data['No'];?>
					, Kel.<?php echo $data['Kelurahan'];?>
				</td>	
				<td><?php echo $data['Kota'];?></td>
				<td>
					<a href="?page=anggota_insert&id=<?php echo $data['NoIndex'];?>" class="btn btn-xs btn-info">Pilih</a>
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
					echo "<li><a href='?page=anggota_kk_insert&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
				}
			}
		}
	?>	
</ul>

<div class="row">
	<div class="col-sm-12" style="font-size:12px;">
		<div class="petunjuk">
			<h4 style = "margin:0px 5px 5px 5px"><b>Silahkan lengkapi data Kepala Keluarga</b></h4>
			<p style = "margin:0px 5px 5px 5px">1. Isi data KK sesuai E-KTP /Kartu Keluarga</p>
			<p style = "margin:0px 5px 5px 5px">2. Selanjutnya simpan data KK dengan memilih menu "SIMPAN"</p>
			<p style = "margin:0px 5px 5px 5px">3. Jika berhasil maka data KK akan tampil di kolom data KK, silahkan klik menu "PILIH"</p>
		</div>
	</div>
</div>