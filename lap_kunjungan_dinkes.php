<?php
	// include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
?>
<style type="text/css">
	.alert{
		margin-bottom: 0px;
	}
</style>

<div class="tableborderdiv">
	<div class="row noprint">
        <div class="col-sm-12 table-responsive">
			<div class="aleret"></div>
			<h3 class="judul"><b>KUNJUNGAN PUSKESMAS</b></h3>
			<div class="formbg">
                 <form role="form" id="formsx">
				    <div class = "row">
						<input type="hidden" name="page" value="lap_kunjungan_dinkes"/>
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
							<a href="?page=lap_kunjungan_dinkes" class="btn btn-round btn-info"><span class="fa fa-refresh"></span></a>
							<!--<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>-->
							<a href="lap_kunjungan_dinkes_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&kd=<?php echo $_GET['puskesmas'];?>" class="btn btn-round btn-success">Excel</a>
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
		<span class="font11" style="margin:15px 5px 5px 5px;"><b>LAPORAN KUNJUNGAN PUSKESMAS</b></span><br>
		<span class="font11" style="margin:1px;">Periode Laporan: <?php echo nama_bulan($bulan)." ".$tahun;?>
		</span><br/>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table-judul-laporan">
					<thead>
						<tr style="border:1px solid #000;">
							<th rowspan="3" width="3%">NO.</th>
							<th rowspan="3" width="17%">NAMA PUSKESMAS</th>
							<th colspan="4">JENIS KUNJUNGAN</th>
							<th rowspan="3">TOTAL</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th colspan="2">RAWAT JALAN</th>
							<th colspan="2">RAWAT INAP</th>
						</tr>
						<tr style="border:1px solid #000;">
							<th>L</th>
							<th>P</th>
							<th>L</th>
							<th>P</th>
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
                            $waktu = "YEAR(TanggalRegistrasi) = '$tahun'";
                        }else{
                            $waktu = "YEAR(TanggalRegistrasi) = '$tahun' AND MONTH(TanggalRegistrasi) = '$bulan'";
                        } 
						
						$str = "SELECT * FROM `tbpuskesmas` WHERE `NamaPuskesmas` != 'DINAS KESEHATAN' AND `NamaPuskesmas` != 'UPTD FARMASI'";
						$str2 = $str."order by `NamaPuskesmas` ASC LIMIT $mulai,$jumlah_perpage";
																	
						if($_GET['h'] == null || $_GET['h'] == 1){
							$no = 0;
						}else{
							$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
						}

                        $query = mysqli_query($koneksi, $str2);
						while($data = mysqli_fetch_assoc($query)){
							$no = $no + 1;
                            $kodepuskesmas = $data['KodePuskesmas'];
							$namapuskesmas = $data['NamaPuskesmas'];
							$tbpasienrj = "tbpasienrj_".str_replace(' ', '', $namapuskesmas);
                            // umur 7-15 Tahun
                            $jml_l_rajal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj)AS Jml FROM `$tbpasienrj` WHERE $waktu  AND JenisKelamin = 'L' AND `JenisKunjungan`='1'"));
							$jml_p_rajal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj)AS Jml FROM `$tbpasienrj` WHERE $waktu AND JenisKelamin = 'P' AND `JenisKunjungan`='1'"));
							$jml_l_ranap = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj)AS Jml FROM `$tbpasienrj` WHERE $waktu  AND JenisKelamin = 'L' AND `JenisKunjungan`='2'"));
							$jml_p_ranap = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(IdPasienrj)AS Jml FROM `$tbpasienrj` WHERE $waktu AND JenisKelamin = 'P' AND `JenisKunjungan`='2'"));
							
							// total kunjungan
							$total = $jml_l['Jml'] + $jml_p['Jml'];
							
						?>
							<tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $namapuskesmas;?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml_l_rajal['Jml'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml_p_rajal['Jml'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml_l_ranap['Jml'];?></td>
								<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $jml_p_ranap['Jml'];?></td>
								<!--total kunjungan-->
								<td style="text-align:center;border:1px solid #000; padding:3px;"><?php echo $total;?></td>
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
						echo "<li><a href='?page=lap_kunjungan_dinkes&bulan=$bulan&tahun=$tahun&puskesmas=$kodepuskesmas&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
<?php
	}
?>
   
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
   
});

</script>

