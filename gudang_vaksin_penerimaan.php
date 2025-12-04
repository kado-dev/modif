<?php
	session_start();
	include "config/helper_report.php";
	$kota = $_SESSION['kota'];
?>

<style>
.imglogo{
	width: 55px;
	height: 65px;
	margin-left: 40px;
	margin-bottom: -90px;
	margin-top: 10px;
	display: none;
}
.imglogo2{
	margin-left: 20px;
	margin-bottom: -120px;
	margin-top: 0px;
	display: none;
}
.table-responsive{
	overflow-x: hidden;
}	
	
@media print{
	.imglogo{
		display:block;
	}
	.imglogo2{
		display:block;
	}
	.printheader{
		display:block;
	}
}
</style>

<div class="tableborderdiv noprint">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>PENERIMAAN </b><small>Gudang Vaksin</small></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="gudang_vaksin_penerimaan"/>
						<div class="col-sm-6">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nomor Pembukuan" required>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-sm btn-warning"><span class="fa fa-search"></span></button>
							<a href="?page=gudang_vaksin_penerimaan" class="btn btn-sm btn-info"><span class="fa fa-refresh"></span></a>
							<a href="gudang_vaksin_penerimaan_excel.php?kategori=<?php echo $_GET['kategori'];?>&key=<?php echo $_GET['key'];?>" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span></a>
							<a href="javascript:print()" class="btn btn-sm btn-primary"><span class="fa fa-print"></span></a>
							<a href="?page=gudang_vaksin_penerimaan_tambah" class="btn btn-sm btn-primary">Buat Faktur</a>
						</div>
					</form>	
				</div>
			</div>	
		</div>
	</div>
	<?php	
		$key = $_GET['key'];
	?>
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul"  width="100%">
					<thead>
						<tr>
							<th width="3%">No</th>
							<th width="8%">Tanggal</th>
							<th width="8%">No.Pembukuan</th>
							<th width="20%">Supplier</th>
							<th width="15%">Anggaran</th>
							<th width="15%">No.Kontrak</th>
							<th width="10%">Grand Total</th>
							<th width="5%">Foto</th>
							<th width="10%">Aksi</th>
						</tr>
					</thead>
					<tbody font="8">
						<?php
						$jumlah_perpage = 20;	
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}		
														
						$str = "SELECT * FROM `tbgfk_vaksin_penerimaan` WHERE `NomorPembukuan` like '%$key%'";	
						$str2 = $str." ORDER BY IdPenerimaan DESC LIMIT $mulai,$jumlah_perpage";
						// echo $str2;
						
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}
		
						$query = mysqli_query($koneksi,$str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
							$idpabrik = $data['KodeSupplier'];
							
							// ref_pabrik
							$dt_pabrik = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_pabrik` WHERE `id`='$idpabrik'"));
						?>
							<tr>
								<td align="right"><?php echo $no;?></td>
								<td align="center"><?php echo $data['TanggalPenerimaan'];?></td>
								<td align="center"><?php echo $data['NomorPembukuan'];?></td>
								<td align="left"><?php echo $dt_pabrik['nama_prod_obat'];?></td>
								<td align="center"><?php echo $data['SumberAnggaran'];?> <?php echo $data['TahunAnggaran'];?></td>
								<td align="left"><?php echo $data['NomorKontrak'];?></td>
								<td align="right" style="color:red;font-weight:bold">
									<?php 
										$strgt = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
										FROM `tbgfk_vaksin_penerimaandetail` a JOIN `tbgfk_vaksin_penerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
										WHERE a.`NomorPembukuan` LIKE '%$data[NomorPembukuan]%'";
										// echo $strgt;
										$dtgt = mysqli_fetch_assoc(mysqli_query($koneksi, $strgt));
										echo number_format($dtgt['Jumlah'],2,",","."); 
									?>
								</td>
								<td align="center">
									<?php
										$cekgambar = file_exists ( 'image/dokumen_penerimaan_vaksin/'.$data['ImageDok'] );
										if($cekgambar == true){
									?>
									<span class="btnimgmodal" id="<?php echo $data['ImageDok'];?>" data-id="<?php echo $data['IdPenerimaan'];?>" style="cursor: pointer;"><i class="fas fa-image"></i></span>
									<?php
										}else{
									?>
										<span class="btnuploadlist" id="<?php echo $data['IdPenerimaan'];?>" style="cursor: pointer;"><i class="fas fa-image"></i></span>
									<?php		
										}
									?>
								</td>
								<td align="center">
									<a href="?page=gudang_vaksin_penerimaan_lihat&id=<?php echo $data['NomorPembukuan'];?>" class="btn btn-xs btn-info btn-white">Lihat</a>
									<?php
										$cekfaktur = mysqli_num_rows(mysqli_query($koneksi, "SELECT `NomorPembukuan` FROM `tbgfk_vaksin_penerimaandetail` WHERE `NomorPembukuan`='$data[NomorPembukuan]'"));
										if($cekfaktur == 0){
									?>
									<a href="?page=gudang_vaksin_penerimaan_hapus&id=<?php echo $data['IdPenerimaan'];?>" class="btn btn-xs btn-danger btn-white" onClick="return confirm('Anda yakin data ingin dihapus...?')">Hapus</a>
									<?php
										}
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
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
			
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=gudang_vaksin_penerimaan&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
	<div class="row noprint">
		<div class="col-lg-12">
			<div class="alert alert-block alert-success fade in">
				<a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
					<p>
						<h4><b>Perhatikan</b></h4> 
						- Pertama, klik menu Buat Faktur</br>
						- Kedua, klik menu lihat pada faktur yang dibuat lalu isikan nama barang pada faktur tsb.
					</p>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/jquery.js"></script>	
<script>	
	$(".btnimgmodal").click(function(){
		var namagambar = $(this).attr('id');
		var idpener = $(this).data('id');
		var srcs = 'image/dokumen_penerimaan_vaksin/'+namagambar;
		$(".imgmodals").attr('src',srcs);
		$(".btnuploadlist").attr('id',idpener);
		$(".btnuploadlist").attr('data-namelama',namagambar);
		$("#exampleModal").modal('show');

		$(".btnuploadlist").click(function(){
			$("#exampleModal").modal('hide');
			var id = $(this).attr('id');
			var namelama = $(this).data('namelama');
			$("#id").val(id);
			$("#namelama").val(namelama);
			$("#ModalUps").modal('show');
		});
	});

	$(".btnuploadlist").click(function(){
		$("#exampleModal").modal('hide');
		var id = $(this).attr('id');
		$("#id").val(id);
		$("#ModalUps").modal('show');
	});
</script>

<!-- Modal View-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
		<h4 class="modal-title" id="exampleModalLabel">Foto</h4>
      </div>
      <div class="modal-body">
		<p style="text-align:center">
			<img src="" class="img-fluid imgmodals" width="550px">
		</p>
		<button type="button" class="btnuploadlist btnsimpan">Edit</button>
      </div>
    </div>
  </div>
</div>
 
<!-- Modal Upload-->
<div class="modal fade" id="ModalUps" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
		<h4 class="modal-title" id="exampleModalLabel">Upload Foto</h4>
      </div>
      <div class="modal-body">
      	<form action="gudang_vaksin_penerimaan_upload.php" method="post" enctype="multipart/form-data">
      		<input type="hidden" name="id" id="id">
      		<input type="hidden" name="namalama" id="namelama">
      		<input type="file" name="foto" class="form-control">
      		<input type="submit" value="Upload" class="btnsimpan" style="margin-top: 10px">
      	</form>		
      </div>
    </div>
  </div>
</div>



<!--tabel report-->
<?php if($kota == "KABUPATEN BOGOR"){ ?>	
	<img src="image/bogorkab.png" class="imglogo">
<?php }elseif($kota == "KABUPATEN BEKASI"){ ?>	
	<img src="image/bekasikab.png" class="imglogo2" style="width: 100px; height: 100px;">
<?php }else{ ?>
	<img src="image/bandungkab.png" class="imglogo" style="width: 100px; height: 100px;">
<?php } ?>

<?php if($kota == "KABUPATEN BEKASI"){ ?>	
	<div class="printheader">
		<span style="font-size: 18px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br/>
		<span style="font-size: 24px;"><b>UPTD FARMASI</b></span><br/>
		<p style="font-size: 12px; margin:1px;">
			<?php echo substr($alamat,0,62);?><br/>
			Kabupaten Bekasi, 17510 Jawa Barat<br/>
			<b>e-mail : laporangudangtambun@gmail.com Telp.</b><?php echo $telepon?>
		</p>
		<hr style="margin:3px; border:1px solid #000">
		<p class="font16" style="margin:10px 5px 5px 5px; font-family: Poppins;"><b>LAPORAN PENERIMAAN BARANG (GUDANG VAKSIN)</b></p>
	</div>
<?php }else{ ?>
	<div class="printheader">
		<span style="font-size: 18px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></span><br/>
		<span style="font-size: 24px;"><b>UPTD FARMASI</b></span><br/>
		<p style="font-size: 12px; margin:1px; font-family: 'Poppins', sans-serif;"><?php echo $alamat;?><br/>
			<b><?php echo "e-mail: ".$email;?></b>
		</p>
		<hr style="margin:3px; border:1px solid #000">
		<p class="font16" style="margin:10px 5px 5px 5px; font-family: Poppins;"><b>LAPORAN PENERIMAAN BARANG (GUDANG VAKSIN)</b></p><br>
	</div>
<?php } ?>

<div class="printbody">
	<div class="row font10">
		<div class="col-sm-12">
			<table class="table table-condensed" style="margin-top: 10px;" width="100%">
				<thead style="font-size:10px;">
					<tr>
						<th width="3%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No</th>
						<th width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Tanggal</th>
						<th width="8%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.Pembukuan</th>
						<th width="20%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Supplier</th>
						<th width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Anggaran</th>
						<th width="15%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">No.Kontrak</th>
						<th width="10%" style="text-align:center; vertical-align:middle; border:1px solid #000; padding:3px;">Grand Total</th>
					</tr>
				</thead>
				<tbody font="8">
					<?php
					$jumlah_perpage = 20;	
					
					if($_GET['h']==''){
						$mulai=0;
					}else{
						$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}		
													
					$str = "SELECT * FROM `tbgfk_vaksin_penerimaan` WHERE `NomorPembukuan` like '%$key%'";	
					$str2 = $str." ORDER BY IdPenerimaan DESC LIMIT $mulai,$jumlah_perpage";
					// echo $str2;
					
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
	
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						$idpabrik = $data['KodeSupplier'];
						
						// ref_pabrik
						$dt_pabrik = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `ref_pabrik` WHERE `id`='$idpabrik'"));
					?>
						<tr>
							<td align="right" style="vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
							<td align="center" style="vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $data['TanggalPenerimaan'];?></td>
							<td align="center" style="vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $data['NomorPembukuan'];?></td>
							<td align="left" style="vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $dt_pabrik['nama_prod_obat'];?></td>
							<td align="center" style="vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $data['SumberAnggaran'];?> <?php echo $data['TahunAnggaran'];?></td>
							<td align="left" style="vertical-align:middle; border:1px solid #000; padding:3px;"><?php echo $data['NomorKontrak'];?></td>
							<td align="right" style="vertical-align:middle; border:1px solid #000; padding:3px;">
								<?php 
									$strgt = "SELECT SUM(a.Jumlah * a.Harga) AS Jumlah 
									FROM `tbgfk_vaksin_penerimaandetail` a JOIN `tbgfk_vaksin_penerimaan` b ON a.NomorPembukuan = b.NomorPembukuan
									WHERE a.`NomorPembukuan` LIKE '%$data[NomorPembukuan]%'";
									// echo $strgt;
									$dtgt = mysqli_fetch_assoc(mysqli_query($koneksi, $strgt));
									echo number_format($dtgt['Jumlah'],2,",","."); 
								?>
							</td>			
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>	
		<div class="font10">
			<?php 
				$dt_penerima = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM `tb_user_profil_sbbk`"));
			?>
			<table width="100%">
				<tr style="font-size: 12px;">
					<td style="text-align:center;">
					<p style="margin-top:15px;">Yang Menyerahkan,
					<br>
					<br>
					<br>
					<br>
					(..............................)</p>
					</td>	
					<td width="10%"></td>
					<td style="text-align:center;">
					<p>Mengetahui,<br/>
					<?php
						if($kota == "KABUPATEN BOGOR"){
					?>	
						Kasie Kefarmasian,
					<?php
						}else{
					?>
						Ka. UPTD Farmasi,
					<?php
						}
					?>					
					<br>
					<br>
					<br>
					<br>
					<b><u><?php echo $dt_penerima['nama_kasie'];?></u></b><br/>
					<?php echo "NIP. ".$dt_penerima['nip_kasie'];?></p>
					</td>
					<td width="10%"></td>
					<td style="text-align:center;">
						<p>
						<?php 
							echo $kota.", ".date('d-m-Y');?><br/>
							Yang Menerima,
							<br>
							<br>
							<br>
							<br>
							<b><u><?php echo $dt_penerima['nama_pemberi'];?></u></b><br/>
						<?php echo "NIP. ".$dt_penerima['nip_pemberi'];?>
						</p>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
 