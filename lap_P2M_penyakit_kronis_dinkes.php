<?php
	// include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>
<style type="text/css">
	.alert{
		margin-bottom: 0px;
	}
	.progress{
		height: 14px;
	}
</style>

<div class="tableborderdiv">
	<div class="row noprint">
        <div class="col-sm-12 table-responsive">
			<div class="aleret"></div>
			<div class="progress" style="background: transparent;">
				<div class="progress-bar progress-bar-striped bg-success active" id="myBar" role="progressbar" style="width: 1%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
			<h3 class="judul"><b>Penyakit Kronis</b></h3>
			<div class="formbg">
                 <form role="form" id="formsx">
				    <div class = "row">
						<input type="hidden" name="page" value="lap_P2M_penyakit_kronis_dinkes"/>
						<div class="col-xl-2">
							<select name="bulan" class="form-control">
								<option value="Semua" <?php if($_GET['bulan'] == 'Semua'){echo "SELECTED";}?>>Semua</option>
								<option value="01" <?php if($_GET['bulan'] == '01'){echo "SELECTED";}?>>Januari</option>
								<option value="02" <?php if($_GET['bulan'] == '02'){echo "SELECTED";}?>>Februari</option>
								<option value="03" <?php if($_GET['bulan'] == '03'){echo "SELECTED";}?>>Maret</option>
								<option value="04" <?php if($_GET['bulan'] == '04'){echo "SELECTED";}?>>April</option>
								<option value="05" <?php if($_GET['bulan'] == '05'){echo "SELECTED";}?>>Mei</option>
								<option value="06" <?php if($_GET['bulan'] == '06'){echo "SELECTED";}?>>Juni</option>
								<option value="07" <?php if($_GET['bulan'] == '07'){echo "SELECTED";}?>>Juli</option>
								<option value="08" <?php if($_GET['bulan'] == '08'){echo "SELECTED";}?>>Agustus</option>
								<option value="09" <?php if($_GET['bulan'] == '09'){echo "SELECTED";}?>>September</option>
								<option value="10" <?php if($_GET['bulan'] == '10'){echo "SELECTED";}?>>Oktober</option>
								<option value="11" <?php if($_GET['bulan'] == '11'){echo "SELECTED";}?>>November</option>
								<option value="12" <?php if($_GET['bulan'] == '12'){echo "SELECTED";}?>>Desember</option>
							</select>
						</div>
						<div class="col-xl-2" style ="width:125px">
							<select name="tahun" class="form-control">
								<?php
									for($tahun = 2021 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
						<div class="col-xl-8">
							<button type="submit" class="btn btn-round btn-warning btnsimpans"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_penyakit_kronis_dinkes" class="btn btn-round btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
							<a href="lap_P2M_penyakit_kronis_dinkes_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $_GET['puskesmas'];?>" class="btn btn-round btn-success">Excel</a>
						</div>
				    </div>
                </form>
			</div>
		</div>
	</div>

	<?php
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	if(isset($bulan) and isset($tahun)){
	?>

	<div class="printheader">
		<span class="font14" style="margin:5px;"><b><?php echo "PEMERINTAH ".$kota;?></b></span><br>
		<span class="font14" style="margin:5px;"><b>DINAS KESEHATAN</b></span><br>
		<span class="font14" style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></span><br>
		<span class="font10" style="margin:5px;"><?php echo $alamat;?></span>
		<hr style="margin:3px; border:1px solid #000">
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN P2P (HIPERTENSI)</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?>
		</span><br/>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead>
						<tr>
							<th rowspan="2" width="3%">NO.</th>
							<th rowspan="2" width="17%">Nama Puskesmas</th>
							<th colspan="24">Jumlah Kasus Penyakit Kronis</th>
						</tr>
						<tr>
							<th>Hipertensi</th>
							<th>Jantung</th>
							<th>TBC Paru</th>
							<th>TBC Saraf</th>
							<th>Diabet</th>
                            <th>Ginjal</th>
							<th>G.Mental</th>
							<th>Thalasemi</th>
							<th>Sistem Saraf</th>
						</tr>
						
					</thead>
					<tbody>
						<?php
						$jumlah_perpage = 30;						
						
						if($_GET['h']==''){
							$mulai=0;
						}else{
							$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}

                        if($bulan == 'Semua'){
                            $waktu = "YEAR(TanggalDiagnosa) = '$tahun'";
                        }else{
                            $waktu = "YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan'";
                        } 
						
						$str = "SELECT * FROM `tbpuskesmas`";
						$str2 = $str."order by `NamaPuskesmas` ASC LIMIT $mulai,$jumlah_perpage";
																	
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}

                        $kodedgs_hipertensi = " AND (`KodeDiagnosa` like '%I10%')";
                        $kodedgs_jantung = " AND (`KodeDiagnosa` like '%I25%' OR `KodeDiagnosa` like '%I50%')";
                        $kodedgs_tbc_paru = " AND (`KodeDiagnosa` like '%J44%' OR `KodeDiagnosa` like '%J45%' OR `KodeDiagnosa` like '%A15%')";
                        $kodedgs_tbc_saraf = " AND (`KodeDiagnosa` like '%A17%' OR `KodeDiagnosa` like '%A18%' OR `KodeDiagnosa` like '%A19%')";
                        $kodedgs_diabet = " AND (`KodeDiagnosa` like '%E10%' OR `KodeDiagnosa` like '%E11%' OR `KodeDiagnosa` like '%E14%')";
                        $kodedgs_ginjal = " AND (`KodeDiagnosa` like '%N18%')";
                        $kodedgs_mental = " AND (`KodeDiagnosa` like '%F20%' OR `KodeDiagnosa` like '%F32%' OR `KodeDiagnosa` like '%F33%')";
                        $kodedgs_thalasemi = " AND (`KodeDiagnosa` like '%D56%')";
                        $kodedgs_sistemsaraf = " AND (`KodeDiagnosa` like '%A17%')";
															
						$query = mysqli_query($koneksi, $str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
                            $kodepuskesmas = $data['KodePuskesmas'];
							$namapuskesmas = $data['NamaPuskesmas'];
                            $tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
							$Hipertensi= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs_hipertensi"));
							$Jantung= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs_jantung"));
							$TbcParu= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs_tbc_paru"));
							$TbcSaraf= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs_tbc_saraf"));
							$Diabet= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs_diabet"));
							$Ginjal= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs_ginjal"));
							$Mental= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs_mental"));
							$Thalasemi= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs_thalasemi"));
							$SistemSaraf= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs_sistemsaraf"));
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namapuskesmas;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><a href="?page=lap_P2M_penyakit_kronis_dinkes_detail&sts=hipertensi&bln=<?php echo $bulan;?>&thn=<?php echo $tahun;?>&pkm=<?php echo $namapuskesmas;?>" style="color: black" target="_blank"><?php echo $Hipertensi['Jml'];?></a></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><a href="?page=lap_P2M_penyakit_kronis_dinkes_detail&sts=jantung&bln=<?php echo $bulan;?>&thn=<?php echo $tahun;?>&pkm=<?php echo $namapuskesmas;?>" style="color: black" target="_blank"><?php echo $Jantung['Jml'];?></a></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><a href="?page=lap_P2M_penyakit_kronis_dinkes_detail&sts=tbcparu&bln=<?php echo $bulan;?>&thn=<?php echo $tahun;?>&pkm=<?php echo $namapuskesmas;?>" style="color: black" target="_blank"><?php echo $TbcParu['Jml'];?></a></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><a href="?page=lap_P2M_penyakit_kronis_dinkes_detail&sts=tbcsaraf&bln=<?php echo $bulan;?>&thn=<?php echo $tahun;?>&pkm=<?php echo $namapuskesmas;?>" style="color: black" target="_blank"><?php echo $TbcSaraf['Jml'];?></a></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><a href="?page=lap_P2M_penyakit_kronis_dinkes_detail&sts=diabet&bln=<?php echo $bulan;?>&thn=<?php echo $tahun;?>&pkm=<?php echo $namapuskesmas;?>" style="color: black" target="_blank"><?php echo $Diabet['Jml'];?></a></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><a href="?page=lap_P2M_penyakit_kronis_dinkes_detail&sts=ginjal&bln=<?php echo $bulan;?>&thn=<?php echo $tahun;?>&pkm=<?php echo $namapuskesmas;?>" style="color: black" target="_blank"><?php echo $Ginjal['Jml'];?></a></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><a href="?page=lap_P2M_penyakit_kronis_dinkes_detail&sts=mental&bln=<?php echo $bulan;?>&thn=<?php echo $tahun;?>&pkm=<?php echo $namapuskesmas;?>" style="color: black" target="_blank"><?php echo $Mental['Jml'];?></a></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><a href="?page=lap_P2M_penyakit_kronis_dinkes_detail&sts=thalasemi&bln=<?php echo $bulan;?>&thn=<?php echo $tahun;?>&pkm=<?php echo $namapuskesmas;?>" style="color: black" target="_blank"><?php echo $Thalasemi['Jml'];?></a></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><a href="?page=lap_P2M_penyakit_kronis_dinkes_detail&sts=sistemsaraf&bln=<?php echo $bulan;?>&thn=<?php echo $tahun;?>&pkm=<?php echo $namapuskesmas;?>" style="color: black" target="_blank"><?php echo $SistemSaraf['Jml'];?></a></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div><br/>

	<hr class="noprint"><!--css-->
	<ul class="pagination noprint">
		<?php
			$bulan = $_GET['bulan'];
			$tahun = $_GET['tahun'];
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
						echo "<li><a href='?page=lap_P2M_penyakit_kronis_dinkes&bulan=$bulan&tahun=$tahun&puskesmas=$kodepuskesmas&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
<?php
	}
?>

    <div class = "row noprint">
        <div class="col-sm-12 table-responsive">
            <div class="formbg">
                <p><b>Perhatikan :</b><br/>
                    - Klasifikasi Hipertensi (I10, I15)<br/>
                </p>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript">
$('body').on("click",".btnsimpans", function(event) {
    $('html,body').scrollTop(0);
    $(".aleret").html("");
    
      var urlaction = $("#formsx").attr('action');
      var datak = $("#formsx").serializeArray();
      var fd = new FormData();
      $('.filex').each(function(index,val){
	      const x_x = val.files[0];
	      var attr_name = $(this).attr('name');
	      if(typeof x_x !== 'undefined'){
	        fd.append(attr_name,x_x,x_x.name);        
	      }
	    });
      $.each(datak,function(key,input){
        fd.append(input.name,input.value);
      });

      $.ajax({
        // xhr: function() {
        //   var xhr = new window.XMLHttpRequest();
        //   xhr.upload.addEventListener("progress", function(evt) {
        //     if (evt.lengthComputable) {
        //       var percentComplete = evt.loaded / evt.total;
        //       percentComplete = parseInt(percentComplete * 100);
        //       console.log(percentComplete);
        //       var elem = document.getElementById("myBar");
        //       elem.style.display = "block";
        //       elem.style.width =percentComplete+"%";
        //       if (percentComplete === 100) {
        //         elem.style.width ="100%"; 
        //       }
        //     }
        //   }, false);
        //   return xhr;
        // },         
        url:urlaction,
        data: fd,
        contentType: false,
        processData: false,  
        type:"POST",      
        xhr: function () {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    percentComplete = parseInt(percentComplete * 100);
                    var elem = document.getElementById("myBar");
		            elem.style.width =percentComplete+"%";
                }
            }, false);
            return xhr;
        },
        success: function(data){
          var elem = document.getElementById("myBar");
          elem.style.display = "none";
         // var obj = JSON.parse(data);
          // if(data == 'sukses'){
            // $(".aleret").html("<div class='alert alert-success'>File berhasil import, Silahkan refresh halaman ini</div>");        
          // }else{
            // $(".aleret").html("<div class='alert alert-danger'>File gagal di import</div>");
          // }
        }
      });
   
});

</script>

