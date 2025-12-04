<?php
	include "config/helper_pasienrj.php";
	$otoritas = explode(',',$_SESSION['otoritas']);
?>

<div class="tableborderdiv">
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<h3 class="judul"><b>PRACTITIONER</b></h3>
			<div class="formbg">
				<form role="form">
					<div class = "row">
						<input type="hidden" name="page" value="satusehat_practitioner"/>
						<div class="col-xl-6">
							<input type="text" name="key" class="form-control cari" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama / Nip Pegawai" required>
						</div>
						<div class="col-xl-6">
							<button type="submit" class="btn btn-round btn-warning btnsubmit"><span class="fa fa-search"></span></button>
							<a href="?page=satusehat_practitioner" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
						</div>
					</div>
				</form>		
			</div>
		</div>
	</div>

	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<table class="table-judul table-bordered">
				<thead>
					<tr>
						<th width="3%">NO.</th>
						<th width="32%">NIK</th>
						<th width="25%">PRACTITIONER</th>
						<th width="35%">Id Practitioner</th>
						<th width="5%">AKSI</th>
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
					
					
					$str = "SELECT * FROM `tbpegawai` WHERE `KodePuskesmas` = '$kodepuskesmas' AND (`NamaPegawai` LIKE '%$key%' OR `Status` LIKE '%$key%' OR `Nik` LIKE '%$key%') AND `Status`='Dokter'";
					$str2 = $str." order by NamaPegawai Asc LIMIT $mulai,$jumlah_perpage";
					// echo $str2;
					// die();
					
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}					
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						
						// tbpuskesmas
						$kdpkm = $data['KodePuskesmas'];
						$datapkm = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kdpkm'"));
					?>
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="left">
								<span class="editnikps" style = "font-size: 13px; color:black;"><?php echo $data['Nik'];?></span>
							</td>
							<td align="left"><?php echo strtoupper($data['NamaPegawai']);?></td>
							<td align="center" class="tmp-IdPractitioner"><?php echo $data['IdPractitioner'];?></td>
							<td align="center">
								<input type="hidden" class="idpegawai" value="<?php echo $data['IdPegawai']?>">
								<a href="#" class="btn btn-sm btn-round btn-primary btneditnikpasien">EDIT</a>
								<a href="#" class="btn btn-sm btn-round btn-primary btnupdatenikpasien" style="display:none">UPDATE</a>
							</td>								
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
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
						echo "<li><a href='?page=satusehat_practitioner&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>

<script src="assets/js/jquery-2.1.4.min.js"></script>
<script>
	$(document).ready(function() {
		$(".btneditnikpasien").click(function(){
			var tmpbtton = $(this);
			var isiawal = $(this).parent().parent().find(".editnikps").html();
			$(this).hide();
			$(this).parent().find(".btnupdatenikpasien").show();
			$(this).parent().parent().find(".editnikps").html('<input type="text" class="form-control valnamapsn" value="'+isiawal+'" size="25px">');
			
			$(this).parent().find(".btnupdatenikpasien").click(function(){
				var nik = $(this).parent().parent().find(".valnamapsn").val();
				var idpegawai = $(this).parent().find(".idpegawai").val();
				//alert(nik + " | " + idpegawai);
				$.post( "edit_nik_pegawai_jquery.php", { nik: nik, idpegawai: idpegawai}).done(function(data){
				//alert(data);
					tmpbtton.parent().parent().find(".tmp-IdPractitioner").html(data);
				});
				$(this).parent().parent().find(".editnikps").html(nik);
				$(this).hide();
				$(this).parent().find(".btneditnikpasien").show();
			});
		});
	});
</script>
		