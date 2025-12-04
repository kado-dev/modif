<?php
	// include "otoritas.php";
	include "config/helper_report.php";
	include "config/helper_pasienrj.php";
    include "config/helper_bpjs_v4.php";	
?>
<style type="text/css">
    table{
        font-size: 12px;
    }
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
						<input type="hidden" name="page" value="lap_P2M_penyakit_kronis_bnba"/>
						<div class="col-xl-2">
							<select name="bulan" class="form-control">
								<!-- <option value="Semua" <?php //if($_GET['bulan'] == 'Semua'){echo "SELECTED";}?>>Semua</option> -->
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
									for($tahun = 2024 ; $tahun <= date('Y'); $tahun++){
									?>
									<option value="<?php echo $tahun;?>" <?php if($_GET['tahun'] == $tahun){echo "SELECTED";}?>><?php echo $tahun;?></option>
								<?php }?>
							</select>
						</div>
                        <div class="col-xl-3">
							<select name="filterjenispeserta" class="form-control">
								<option value="PBI JAMINAN KESEHATAN" <?php if($_GET['filterjenispeserta'] == 'PBI JAMINAN KESEHATAN'){echo "SELECTED";}?>>PBI JAMINAN KESEHATAN</option>
								<option value="PBPU DAN BP PEMERINTAH DAERAH" <?php if($_GET['filterjenispeserta'] == 'PBPU DAN BP PEMERINTAH DAERAH'){echo "SELECTED";}?>>PBPU DAN BP PEMERINTAH DAERAH</option>
								<option value="PEGAWAI BUMN" <?php if($_GET['filterjenispeserta'] == 'PEGAWAI BUMN'){echo "SELECTED";}?>>PEGAWAI BUMN</option>
								<option value="PEGAWAI PEMERINTAH DENGAN PERJANJIAN KERJA" <?php if($_GET['filterjenispeserta'] == 'PEGAWAI PEMERINTAH DENGAN PERJANJIAN KERJA'){echo "SELECTED";}?>>PEGAWAI PEMERINTAH DENGAN PERJANJIAN KERJA</option>
								<option value="PEGAWAI SWASTA" <?php if($_GET['filterjenispeserta'] == 'PEGAWAI SWASTA'){echo "SELECTED";}?>>PEGAWAI SWASTA</option>
								<option value="PEKERJA MANDIRI" <?php if($_GET['filterjenispeserta'] == 'PEKERJA MANDIRI'){echo "SELECTED";}?>>PEKERJA MANDIRI</option>
								<option value="PENERIMA PENSIUN PNS" <?php if($_GET['filterjenispeserta'] == 'PENERIMA PENSIUN PNS'){echo "SELECTED";}?>>PENERIMA PENSIUN PNS</option>
								<option value="PENERIMA PENSIUN POLRI" <?php if($_GET['filterjenispeserta'] == 'PENERIMA PENSIUN POLRI'){echo "SELECTED";}?>>PENERIMA PENSIUN POLRI</option>
								<option value="PENERIMA PENSIUN TNI" <?php if($_GET['filterjenispeserta'] == 'PENERIMA PENSIUN TNI'){echo "SELECTED";}?>>PENERIMA PENSIUN TNI</option>
								<option value="PNS DAERAH" <?php if($_GET['filterjenispeserta'] == 'PNS DAERAH'){echo "SELECTED";}?>>PNS DAERAH</option>
								<option value="PNS PUSAT" <?php if($_GET['filterjenispeserta'] == 'PNS PUSAT'){echo "SELECTED";}?>>PNS PUSAT</option>
								<option value="PRAJURIT AD" <?php if($_GET['filterjenispeserta'] == 'PRAJURIT AD'){echo "SELECTED";}?>>PRAJURIT AD</option>
                                <option value="semua" <?php if($_GET['filterjenispeserta'] == 'semua'){echo "SELECTED";}?>>UPDATE DATA</option>
                            </select>
						</div>
						<div class="col-xl-5">
							<button type="submit" class="btn btn-round btn-warning btnsimpans"><span class="fa fa-search"></span></button>
							<a href="?page=lap_P2M_penyakit_kronis_bnba" class="btn btn-round btn-success"><span class="fa fa-refresh"></span></a>
							<a href="javascript:print()" class="btn btn-round btn-primary"><span class="fa fa-print noprint"></span></a>
							<a href="lap_P2M_penyakit_kronis_bnba_excel.php?bulan=<?php echo $_GET['bulan'];?>&tahun=<?php echo $_GET['tahun'];?>&filterjenispeserta=<?php echo $_GET['filterjenispeserta'];?>" class="btn btn-round btn-success">Excel</a>
						</div>
				    </div>
                </form>
			</div>
		</div>
	</div>

	<?php
	$filterjenispeserta = $_GET['filterjenispeserta'];
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
							<th width="3%">NO.</th>
							<th width="12%">Nama Pasien</th>
							<th width="7%">Tanggal Lahir</th>
							<th width="20%">Alamat</th>
							<th>Nik</th>
							<th>No.BPJS</th>
							<th>Jenis Peserta</th>
							<th>Diagnosa</th>
						</tr>						
					</thead>
					<tbody>
						<?php
						if($bulan == 'Semua'){
                            $waktu = "YEAR(TanggalDiagnosa) = '$tahun' AND";
                        }else{
                            $waktu = "YEAR(TanggalDiagnosa) = '$tahun' AND MONTH(TanggalDiagnosa) = '$bulan' AND";
                        } 

                        $str = "SELECT * FROM `tbdiagnosakronis`";
						$str2 = $str."order by `IdDiagnosaKronis` ASC";
																	
						$query = mysqli_query($koneksi, $str2);
						while($data = mysqli_fetch_assoc($query)){
						               
                            // tbdiagnosapasien
                            if($filterjenispeserta == 'semua'){
                                $strdiagnosa = "SELECT * FROM `$tbdiagnosapasien` WHERE ".$waktu." `KodeDiagnosa` like '%$data[KodeDiagnosa]%' AND (`Asuransi` != 'UMUM' AND `Asuransi` != 'GRATIS')";
                            }else{
                                $strdiagnosa = "SELECT * FROM `$tbdiagnosapasien` WHERE ".$waktu." `KodeDiagnosa` like '%$data[KodeDiagnosa]%' AND (`Asuransi` != 'UMUM' AND `Asuransi` != 'GRATIS') AND `JenisPeserta` = '$filterjenispeserta'";
                            }

                            $querydiagnosa = mysqli_query($koneksi, $strdiagnosa);
                            while($dtdiagnosa = mysqli_fetch_assoc($querydiagnosa)){
                                $no = $no + 1;
                                $idpasienrj = $dtdiagnosa['IdPasienrj'];

                                // tbpasienrj
                                $dtpasienrj = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM $tbpasienrj WHERE `IdPasienrj` = '$idpasienrj'"));
   
                                // tbpasien
                                $dtpasien = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM $tbpasien WHERE `IdPasien` = '$dtpasienrj[IdPasien]'"));
                                
                                if($filterjenispeserta == 'semua'){
                                // update jenis peserta
                                $noka = $dtpasien['NoAsuransi'];
                                $data_bpjs = get_data_peserta_bpjs($noka);
                                $dtbpjs = json_decode($data_bpjs,True);
                                $jenispeserta = $dtbpjs['response']['jnsPeserta']['nama'];
                                // echo "Hasil : ".$jenispeserta;
                                // echo "Hasil : ".$data_bpjs;						
                                mysqli_query($koneksi, "UPDATE $tbpasienrj SET `JenisPeserta` = '$jenispeserta' WHERE `IdPasienrj`='$idpasienrj'");
                                mysqli_query($koneksi, "UPDATE $tbdiagnosapasien SET `JenisPeserta` = '$jenispeserta' WHERE `IdPasienrj`='$idpasienrj'");
                                }

                                // tbkk
                                $dtkk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM $tbkk WHERE `NoIndex` = '$dtpasienrj[NoIndex]'"));
                        
                                // tbdiagnosa
								$dtnamadiagnosa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `Diagnosa` FROM `tbdiagnosabpjs` WHERE `KodeDiagnosa`='$dtdiagnosa[KodeDiagnosa]'"));
                                
                        ?>
                            <tr style="border:1px solid #000;">
								<td style="text-align:right; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $dtpasienrj['NamaPasien'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $dtpasien['TanggalLahir'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo strtoupper($dtkk['Alamat']);?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $dtpasien['Nik'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $dtpasien['NoAsuransi'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $dtpasienrj['JenisPeserta'];?></td>
								<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $dtdiagnosa['KodeDiagnosa']." - ".$dtnamadiagnosa['Diagnosa'];?></td>
                            </tr>
                        <?php
                            }                            
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
						echo "<li><a href='?page=lap_P2M_penyakit_kronis_bnba&bulan=$bulan&tahun=$tahun&puskesmas=$kodepuskesmas&h=$i'>$i</a></li>";
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
                    - Saat pilih <b>Bulan, Tahun</b> dan filter <b>Jenis Peserta</b>, namun belum menampilkan data peserta silahkan pilih (Update Data) pada filter Jenis Peserta<br/>
                    - Jika memilih <b>update data</b> akan menjalankan proses cek dan update jenis kepesertaan bpjs sehingga memerlukan waktu lbh lama estimasi 5-10 menit<br/>
                    - Selanjutnya jika data sudah tampil silahkan filter Jenis Peserta sesuai dgn data yg ingin ditampilkan
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

