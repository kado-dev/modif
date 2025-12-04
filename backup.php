<?php
	include "config/helper_pasienrj.php";
?>

<style>
	.form-check [type=checkbox]:checked, .form-check [type=checkbox]:not(:checked){
		left:0px;
	}
</style>
<div class="tableborderdiv">
	<div class="aleret"></div>
		<div class="progress" style="background: #E6E6E6">
		<div class="progress-bar progress-bar-striped bg-success active" id="myBar" role="progressbar" style="width: 2%;display: none" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
	<h3 class="judul"><b>BACKUP DATA</b></h3>
	<div class="formbg">
		<form action="backup_proses.php" method="post" id="formbcc">
			<?php
			$kodepuskesmas = $_SESSION['kodepuskesmas'];
			// $query = mysqli_query($koneksi,"SHOW TABLES FROM `dbsmartpuskesmas` WHERE `Tables_in_dbsmartpuskesmas` LIKE '%$kodepuskesmas%'");
			// $no = 0;
			// while ($data = mysqli_fetch_array($query)) {
			// 	$no = $no + 1;
			?><!--
				<div class="form-check">
					<input class="form-check-input" name="tbls[]" type="checkbox" id="exra<?php //echo $no;?>" value="<?php //echo $data[0];?>">
					<label class="form-check-label" for="exra<?php //echo $no;?>">
					<?php //echo $data[0];?>
					</label>
				</div>-->
			<?php
				//}
			?>   
			<div class="col-sm-4">
				<div class="form-check">
					<input class="form-check-input exra" type="checkbox" id="exra" value="all">
					<label class="form-check-label" for="exra">
						Semua
					</label>
				</div> 
				<div class="form-check">
					<input class="form-check-input exras" name="tbls[]" type="checkbox" id="exra1" value="<?php echo $tbkk;?>">
					<label class="form-check-label" for="exra1">
						Tb.Kepala Keluarga
					</label>
				</div>
				<div class="form-check">
					<input class="form-check-input exras" name="tbls[]" type="checkbox" id="exra12" value="<?php echo $tbpasien;?>">
					<label class="form-check-label" for="exra12">
						Tb.Pasien
					</label>
				</div>
				<div class="form-check">
					<input class="form-check-input exras" name="tbls[]" type="checkbox" id="exra23" value="tbpasienrj_<?php echo $kodepuskesmas;?>">
					<label class="form-check-label" for="exra23">
						Tb.Registrasi (PasienRJ)
					</label>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-check">
					<input class="form-check-input exras" name="tbls[]" type="checkbox" id="exra24" value="<?php echo $tbdiagnosapasien;?>">
					<label class="form-check-label" for="exra24">
						Tb.Diagnosa Pasien
					</label>
				</div>
			</div>
			<hr/>
			<input type="hidden" name="stsdown"/>
			<button type="submit" class="btnsimpan btnckp">BACKUP</button>
		</form>
	</div>
	<div class="formbg">
		<h3 class="judul"><b>RIWAYAT BACKUP</b></h3>
		<table class="table-judul">
			<thead>
				<tr>
					<th width="5%"style="text-align:center;">NO.</th>
					<th width="10%"style="text-align:center;">TANGGAL</th>
					<th width="70%"style="text-align:center;">DESKRIPSI</th>
					<th width="15%"style="text-align:center;">PETUGAS</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$jumlah_perpage = 5;
	
				if($_GET['h']==''){
					$mulai=0;
				}else{
					$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
				}
				
				$str = "SELECT * FROM `tbbackup_puskesmas` WHERE `KodePuskesmas`='$kodepuskesmas'";
				$str2 = $str." ORDER BY `IdBackup` DESC LIMIT $mulai,$jumlah_perpage";
				
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
						<td align="center"><?php echo $no;?></td>
						<td><?php echo $data['Waktu'];?></td>
						<td><?php echo str_replace(",", ", ", $data['Deskripsi']);?></td>
						<td><?php echo $data['Petugas'];?></td>
					</tr>	
				<?php		
				}	
				?>
			</tbody>
		</table>
	</div>
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
						echo "<li><a href='?page=backup&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>

<script src="assets/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript">
$('body').on("click",".exra", function() {   
    var idtoko = $(this).val();
    if ($(this).is(':checked')) {
        $(".exras").prop("checked",true);
    }else{
        $(".exras").prop("checked",false);
    }    
});

$('body').on("click",".btnckp", function(event) {
    $('html,body').scrollTop(0);
    $(".aleret").html("");
    
      var urlaction = $("#formbcc").attr('action');
      var datak = $("#formbcc").serializeArray();
      var fd = new FormData();
      $.each(datak,function(key,input){
        fd.append(input.name,input.value);
      });

      fd.append("stsdown","tidak");
      $.ajax({
        xhr: function() {
          var xhr = new window.XMLHttpRequest();
          xhr.addEventListener("progress", function(evt) {
            if (evt.lengthComputable) {
              var percentComplete = evt.loaded / evt.total;
              percentComplete = parseInt(percentComplete * 100);
              console.log(percentComplete);
              var elem = document.getElementById("myBar");
              elem.style.display = "block";
              elem.style.width =percentComplete+"%";
              if (percentComplete === 100) {
                elem.style.width ="100%";
              }
            }
          }, false);
          return xhr;
        },
        type:"POST", 
        url:urlaction,
        cache: false,
        contentType: false,
        processData: false,
        data: fd,
        success: function(data){
          var elem = document.getElementById("myBar");
          elem.style.display = "none";
          var obj = JSON.parse(data);
          if(obj.alert == 'sukses'){
            $(".aleret").html("<div class='alert alert-success'>Backup berhasil</div>");
                  //document.location.href=obj.file;
                window.open(obj.file,'_parent','download');  
				//window.location.assign(obj.file);
          }else{
            $(".aleret").html("<div class='alert alert-danger'>"+obj.alert+"</div>");
          }
        }
      });
});
</script>