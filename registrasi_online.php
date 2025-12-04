<?php
	include "config/helper_pasienrj.php";
?>
<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<a href="index.php?page=dashboard" class="backform"><i class="fa fa-chevron-circle-left fa fa-2x"></i><span></span></a>
			<h3 class="judul mt-2">DAFTAR ONLINE</h3>
			<div class="formbg">
				<form role="form" class="submit">
					<div class = "row">
						<div class="col-xl-2">
							<input type="text" name="tgl" class="form-control inputan datepicker" value="<?php echo $_GET['tgl'];?>" placeholder = "Pilih Tanggal">
						</div>
						<div class="col-xl-4">
							<input type="text" name="key" class="form-control inputan" value="<?php echo $_GET['key'];?>" placeholder = "Ketikan NIK Pasien">
						</div>
						<div class="col-xl-6">
							<button type="submit" class="btn btn-round btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=registrasi_online" class="btn btn-round btn-info"><span class="fa fa-refresh"></a>
						</div>
						<input type="hidden" name="page" value="registrasi_online"/>
					</div>
				</form>	
			</div>
		</div>
	</div>
	<?php
		$jumlah_perpage = 50;
			
		if($_GET['h']==''){
			$mulai=0;
		}else{
			$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}
		
		$tgl = $_GET['tgl'];
		$key = $_GET['key'];	
		
		if($tgl != null){
			$tgls = date('Y-m-d',strtotime($tgl));
			$tgl_str = " DATE(WaktuDaftar) = '$tgls' ";
		}else{
			$tgl_str = "DATE(WaktuDaftar) = '".date('Y-m-d')."'";
		}
		
		if($key != null){
			$nama_str = " AND `Nik` like '%$key%'";
		}else{
			$nama_str = " ";
		}			
		
		$str = "SELECT * FROM `$tbpasienonline` WHERE `NamaPasien`!='' AND ".$tgl_str.$nama_str;		
		$str2 = $str." ORDER BY `IdPasienOnline` DESC LIMIT $mulai,$jumlah_perpage";
		// echo $str2;
					
		if($_GET['h'] == null || $_GET['h'] == 1){
			$no = 0;
		}else{
			$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
		}
		
		$query = mysqli_query($koneksi, $str2);		
		if(mysqli_num_rows($query) > 0){
	?>

	<div class="table-responsive" style="padding-bottom: 90px">
		<table class="table-judul">
			<thead>
				<tr>
					<th width="3%">NO.</th>
					<th width="10%">TGL.DAFTAR</th>
					<th width="5%">NO.ANTRIAN<br/>PELAYANAN</th>
					<th width="27%">NAMA PASIEN</th>
					<th width="12%">LAYANAN</th>
					<th width="10%">CARA BAYAR</th>
					<th width="5%">STATUS</th>
					<th width="30%">#</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;

					// tbantrian pasien
					// $dataantrian = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NomorAntrianPoli FROM `$tbantrianpasien` WHERE `IdPasienOnline` = '$data[IdPasienOnline]'"));
					
					// tbpasien
					$datapasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT NoIndex, NoRM, NoAsuransi FROM `$tbpasien` WHERE (`IdPasien` = '$data[IdPasien]')"));
					$noindex = $datapasien['NoIndex'];
					$norm = $datapasien['NoRM'];
					$noasuransi = $datapasien['NoAsuransi'];	
					
					// tbpasienrj
					$datakunj = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT TanggalRegistrasi FROM $tbpasienrj WHERE `NoRM` = '$norm' ORDER by TanggalRegistrasi DESC Limit 1"));
					
					// kode pelayanan antrian
					$poli = str_replace('POLI ','', $data['PoliPertama']);
					$kodeantrian = mysqli_fetch_assoc(mysqli_query($koneksi , "SELECT * FROM `tbantrian_pelayanan` WHERE `Pelayanan` = '$poli' AND `KodePuskesmas` ='$kodepuskesmas'"));
					$nomor_antrian_poli2 =  $kodeantrian['KodePelayanan'].$data['NomorAntrianPoli'];
					?>
					
					<tr>
						<td align="center"><?php echo $no;?></td>
						<td align="center"><?php echo $data['WaktuDaftar'];?></td>
						<td align="center"><?php echo $nomor_antrian_poli2;?></td>
						<td align="left">
							<?php  echo "<b>".$data['NamaPasien']."</b>";?>
							<span class="badge badge-success" style='font-style: italic; padding: 8px;'><?php echo substr($noindex,-10);?></span>
							<?php if($data['StatusDaftar'] == 'ISAP'){?>
							<span class="badge badge-primary" style='font-style: italic; padding: 8px;'><?php echo $data['StatusDaftar'];?></span><br/>
							<?php }else{?>
								<span class="badge badge-success" style='font-style: italic; padding: 8px;'><?php echo $data['StatusDaftar'];?></span><br/>
							<?php }?>
							<?php  echo	"NIK. ".$data['Nik']."<br/>";?>
						</td>
						<td align="left"><?php echo $data['PoliPertama'];?></td>
						<td align="center"><?php echo $data['Asuransi']."<br/>".$data['NoAsuransi'];?></td>
						<td align="center"><?php echo $data['Approve'];?></td>
						<td align="center">
							<?php
								if($data['Approve'] == 'N'){	
							?>
								<a href="?page=registrasi_online_approve&id=<?php echo $data['IdPasienOnline'];?>" class="btn btn-sm btn-round btn-info">Approve</a>
								<a href="#" data-idpasienonline="<?php echo $data['IdPasienOnline'];?>" data-noasuransi="<?php echo $noasuransi;?>" data-norm="<?php echo $norm;?>" data-noindex="<?php echo $noindex;?>" data-tgl="<?php echo date('d/m/Y',strtotime($datakunj['TanggalRegistrasi']));?>" class="btn btn-sm btn-round btn-success">Detail</a>
								<a href="?page=registrasi_online_delete&id=<?php echo $data['IdPasienOnline'];?>" onClick="return confirm('Apakah anda yakin?');"class="btn btn-sm btn-round btn-danger">Delete</a>
							<?php 
							}else{
								echo "Selesai";
							}
							?>
						</td>			
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div><hr/>
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
						echo "<li><a href='?page=registrasi_online&kategori=$kategori&key=$key&tgl=$tgl&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<?php
		}
	?>
</div>

<?php if($_GET['stsmodal'] == '1'){ ?>
<div class="modal show" id="modalkons" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ubah Asuransi</h5>
      </div>
      <div class="modal-body">
        	<form action="" method="get">
        		<input type="hidden" name="page" value="registrasi_online_proses"/>
        		<input type="hidden" name="id" value="<?php echo $_GET['id'];?>"/>
        		<select class="form-control inputan" name="asuransi">
        			<option value="UMUM">Umum</option>
        			<option value="GRATIS">Gratis</option>
        		</select>
        		<br/>
        		<div class="row">
        			<div class="col-sm-6"><input type="submit" class="btn btn-success btn-block" name="btn" value="Konfirmasi"></div>
        			<div class="col-sm-6"><input type="submit" class="btn btn-danger btn-block" name="btn" value="Hapus"></div>
        		</div>	
        		
        		
        	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btnsclose" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<script src="assets/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript">
	$(".btnsclose").click(function(){
		$('#modalkons').addClass('fade');
		$('#modalkons').removeClass('show');
	});
</script>