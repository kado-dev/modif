<?php
	include "otoritas.php";
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
			<h3 class="judul"><b>CIKUNGUNYA</b></h3>
			<div class="formbg">
                 <form role="form" id="formsx">
				    <div class = "row">
						<input type="hidden" name="page" value="lap_P2M_cikungunya_dinkes"/>
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
							<a href="?page=lap_P2M_cikungunya_dinkes" class="btn btn-round btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
							<a href="lap_P2M_cikungunya_dinkes_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $_GET['puskesmas'];?>" class="btn btn-round btn-success">Excel</a>
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
							<th rowspan="3" width="3%">NO.</th>
							<th rowspan="3" width="17%">NAMA PUSKESMAS</th>
							<th colspan="24">JUMLAH KASUS BARU MENURUT GOLONGAN UMUR</th>
							<th rowspan="2"  colspan="3">TOTAL</th>
						</tr>
						<tr>
							<th colspan="2">0-7HR</th>
							<th colspan="2">8-30HR</th>
							<th colspan="2"><1TH</th>
							<th colspan="2">1-4TH</th>
							<th colspan="2">5-9TH</th>
							<th colspan="2">10-14TH</th>
							<th colspan="2">15-19TH</th>
							<th colspan="2">20-44TH</th>
							<th colspan="2">45-54TH</th>
							<th colspan="2">55-59TH</th>
							<th colspan="2">60-69TH</th>
							<th colspan="2">>=70TH</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th>L</th><!--0-7Hr-->
							<th>P</th>
							<th>L</th><!--8-30Hr-->
							<th>P</th>
							<th>L</th><!--<1Th-->
							<th>P</th>
							<th>L</th><!--1-4Th-->
							<th>P</th>
							<th>L</th><!--5-9Th-->
							<th>P</th>
							<th>L</th><!--10-14Th-->
							<th>P</th>
							<th>L</th><!--15-19Th-->
							<th>P</th>
							<th>L</th><!--20-24Th-->
							<th>P</th>
							<th>L</th><!--45-54Th-->
							<th>P</th>
							<th>L</th><!--55-59Th-->
							<th>P</th>
							<th>L</th><!--60-69Th-->
							<th>P</th>
							<th>L</th><!--70Th-->
							<th>P</th>
							<th rowspan="2">L</th><!--Kasus Baru-->
							<th rowspan="2">P</th>
							<th rowspan="2">JML</th>
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
						
						$str = "SELECT * FROM `tbpuskesmas` WHERE `NamaPuskesmas` != 'DINAS KESEHATAN' AND `NamaPuskesmas` != 'UPTD FARMASI'";
						$str2 = $str."order by `NamaPuskesmas` ASC LIMIT $mulai,$jumlah_perpage";
																	
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}

                        $kodedgs = " AND (`KodeDiagnosa` = 'A92.0')";
															
						$query = mysqli_query($koneksi, $str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
                            $kodepuskesmas = $data['KodePuskesmas'];
							$namapuskesmas = $data['NamaPuskesmas'];
                            $tbdiagnosapasien = 'tbdiagnosapasien_'.str_replace(' ', '', $namapuskesmas);
                            // umur 1-7 Hari
							$umur17hrL= mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between 1 AND 7 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur17hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between 1 AND 7 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							// umur 1-2 Bulan
                            $umur1830hrL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between 8 AND 30 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur1830hrP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs  AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between 8 AND 30 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							// umur 1-2 Bulan
                            $umur12blnL = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun = '0' AND UmurBulan Between 2 AND 12 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur12blnP = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun = '0' AND UmurBulan Between 2 AND 12 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							// umur 1-4 Tahun
                            $umur14L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 1 AND 4 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur14P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 1 AND 4 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							// umur 5-8 Tahun
                            $umur59L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs  AND UmurTahun Between 5 AND 9 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur59P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 5 AND 9 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							// umur 10-14 Tahun
                            $umur1014L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 10 AND 14 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur1014P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 10 AND 14 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							// umur 15-19 Tahun
                            $umur1519L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 15 AND 19 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur1519P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 15 AND 19 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							// umur 20-44 Tahun
                            $umur2044L = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 20 AND 44 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
                            $umur2044P = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 20 AND 44 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							// umur 45-54 Tahun
                            $umur4554L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 45 AND 54 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur4554P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 45 AND 54 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							// umur 55-59 Tahun
                            $umur5559L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 55 AND 59 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur5559P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 55 AND 59 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							// umur 60-69 Tahun
                            $umur6069L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 60 AND 69 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur6069P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 60 AND 69 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							// umur 70-100 Tahun
                            $umur70100L = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 70 AND 100 AND JenisKelamin = 'L' AND Kasus = 'Baru'"));
							$umur70100P = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(IdDiagnosa)AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 70 AND 100 AND JenisKelamin = 'P' AND Kasus = 'Baru'"));
							
							// total kasus
							$total_l = $umur17hrL['Jml'] + $umur1830hrL['Jml'] + $umur12blnL['Jml'] + $umur14L['Jml'] + $umur59L['Jml']
								+ $umur1014L['Jml'] + $umur1519L['Jml'] + $umur2044L['Jml'] + $umur4554L['Jml'] + $umur5559L['Jml']
								+ $umur6069L['Jml'] + $umur70100L['Jml'];
							$total_p = $umur17hrP['Jml'] + $umur1830hrP['Jml'] + $umur12blnP['Jml'] + $umur14P['Jml'] + $umur59P['Jml']
								+ $umur1014P['Jml'] + $umur1519P['Jml'] + $umur2044P['Jml'] + $umur4554P['Jml'] + $umur5559P['Jml']
								+ $umur6069P['Jml'] + $umur70100P['Jml'];
							$total = $total_l+ $total_p;
							
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namapuskesmas;?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur17hrL['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur17hrP['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1830hrL['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1830hrP['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur12blnL['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur12blnP['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur14L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur14P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur59L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur59P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1014L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1014P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1519L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur1519P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur2044L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur2044P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4554L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur4554P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur5559L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur5559P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur6069L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur6069P['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur70100L['Jml'];?></td>
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $umur70100P['Jml'];?></td>
								<!--total kasus-->
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total_l;?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total_p;?></td>
								<td style="text-align:right;border:1px solid #000; padding:3px;"><?php echo $total;?></td>
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
						echo "<li><a href='?page=lap_P2M_cikungunya_dinkes&bulan=$bulan&tahun=$tahun&puskesmas=$kodepuskesmas&h=$i'>$i</a></li>";
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
                    - Cikungunya (A92.0)<br/>
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

