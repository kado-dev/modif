<?php
if($_GET['bulan'] == null){
	$bln = date('m');
}else{
	$bln = $_GET['bulan'];
}

date_default_timezone_set('Asia/Jakarta');
$kodepuskesmas = $_SESSION['kodepuskesmas'];
$namapuskesmas = $_SESSION['namapuskesmas'];
$kota = $_SESSION['kota'];
$kecamatan = $_SESSION['kecamatan'];
$kelurahan = $_SESSION['kelurahan'];
$alamat = $_SESSION['alamat'];
$kodeppk = $_SESSION['kodeppk'];

$tahun = date('Y');	
$thn = substr($tahun,2,2);
$tbpasienrj = 'tbpasienrj_'.$bln;
$hariini = date('Y-m-d');
$hariini2 = date('ymd');
$hariini3 = date('ym');

// rujukan
$jmlkarcis_hr = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbrujukluargedung` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND `TanggalRujukan`=curdate()"));
$jmlkarcis_bl = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbrujukluargedung` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(TanggalRujukan)='$tahun' AND MONTH(TanggalRujukan)='$bln'"));
$jmlkarcis_th = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(NoRegistrasi) AS Jumlah FROM `tbrujukluargedung` WHERE SUBSTRING(NoRegistrasi,1,11)='$kodepuskesmas' AND YEAR(TanggalRujukan)='$tahun'"));
$rujukan_hari = $jmlkarcis_hr['Jumlah'];
$rujukan_bulan = $jmlkarcis_bl['Jumlah'];	
$rujukan_tahun = $jmlkarcis_th['Jumlah'];	

?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-4">
			<a href="#" style="cursor:pointer; text-decoration: none;" class="btndetail_karcis">
				<div class="kotak_panel">
				<div class="font30"><?php echo rupiah($rujukan_hari);?></div>
				<div>Rujukan Hari Ini</div>
				</div>
			</a>
		</div>
		<div class="col-sm-4">
			<a href="#" style="cursor:pointer; text-decoration: none;" class="btndetail_kir">
				<div class="kotak_panel">
				<div class="font30"><?php echo rupiah($rujukan_bulan);?></div>
				<div>Rujukan Bulan Ini</div>
				</div>
			</a>	
		</div>
		<div class="col-sm-4">
			<a href="#" style="cursor:pointer; text-decoration: none;" class="btndetail_tindakan">
				<div class="kotak_panel">
				<div class="font30"><?php echo rupiah($rujukan_tahun);?></div>
				<div>Rujukan Tahun Ini</div>
				</div>
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="kotakgrafik">
				<form class="form-inline formcari">
					<input type="hidden" name="page" value="dashboard_rujukan"/>
					<select name="bulan" class="form-control" onchange="this.form.submit();" >
						<option value="01" <?php if($bln == '01'){echo "SELECTED";}?>>Januari</option>
						<option value="02" <?php if($bln == '02'){echo "SELECTED";}?>>Februari</option>
						<option value="03" <?php if($bln == '03'){echo "SELECTED";}?>>Maret</option>
						<option value="04" <?php if($bln == '04'){echo "SELECTED";}?>>April</option>
						<option value="05" <?php if($bln == '05'){echo "SELECTED";}?>>Mei</option>
						<option value="06" <?php if($bln == '06'){echo "SELECTED";}?>>Juni</option>
						<option value="07" <?php if($bln == '07'){echo "SELECTED";}?>>Juli</option>
						<option value="08" <?php if($bln == '08'){echo "SELECTED";}?>>Agustus</option>
						<option value="09" <?php if($bln == '09'){echo "SELECTED";}?>>September</option>
						<option value="10" <?php if($bln == '10'){echo "SELECTED";}?>>Oktober</option>
						<option value="11" <?php if($bln == '11'){echo "SELECTED";}?>>November</option>
						<option value="12" <?php if($bln == '12'){echo "SELECTED";}?>>Desember</option>
					</select>
				</form>	
				<div class="au-card m-b-30">
					<h3 class="title-2 m-b-40">Rujukan (Harian)</h3>
					<div class="au-card-inner">
						<canvas id="Grafik_Retribusi" height="270px"></canvas>
					</div>
				</div>
			</div>			
			<div class="kotakgrafik">
				<div class="au-card m-b-30">
					<div class="au-card-inner">
						<h3 class="title-2 m-b-40">Rujukan (Cara Bayar)</h3>
						<canvas id="lineChart"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--end grafik 3D-->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/chartjsorg.js"></script>
<script>
$(".btndetail_karcis").click(function(){
	$( ".detailretribusi_kir" ).hide();
	$( ".detailretribusi_tindakan" ).hide();
	if ( $( ".detailretribusi_karcis" ).is( ":hidden" ) ) {
		$(".detailretribusi_karcis").slideDown();
	}else{
		$(".detailretribusi_karcis").slideUp();
	}
});

$(".btndetail_kir").click(function(){
	$( ".detailretribusi_karcis" ).hide();
	$( ".detailretribusi_tindakan" ).hide();
	if ( $( ".detailretribusi_kir" ).is( ":hidden" ) ) {
		$(".detailretribusi_kir").slideDown();
	}else{
		$(".detailretribusi_kir").slideUp();
	}
});

$(".btndetail_tindakan").click(function(){
	$( ".detailretribusi_karcis" ).hide();
	$( ".detailretribusi_kir" ).hide();
	if ( $( ".detailretribusi_tindakan" ).is( ":hidden" ) ) {
		$(".detailretribusi_tindakan").slideDown();
	}else{
		$(".detailretribusi_tindakan").slideUp();
	}
});

var ctx = document.getElementById("Grafik_Retribusi").getContext('2d');
var Grafik_Retribusi = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: [
				<?php
				$hari_ini = date('Y')."-".$bln."-01";
					$mulai = 1;
					$selesai = date('t', strtotime($hari_ini));
					for($d = $mulai; $d <= $selesai; $d++){	
						echo '"'.$d.'", ';
					}
				?>
				],
		datasets: [{
			label: 'Jumlah Retribusi',
			data:[
				<?php
					$jml = 0;		
									
					for($d = $mulai; $d <= $selesai; $d++){	
						$tanggal = $tahun."-".$bln."-".$d;
						$query_retribusi = mysqli_query($koneksi,"SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `tbrujukluargedung` WHERE SUBSTRING(NoRegistrasi,1,11) = '$kodepuskesmas' AND `TanggalRujukan` = '$tanggal'");
						$jml = mysqli_fetch_assoc($query_retribusi);
						$jml_rujukan =  $jml['Jumlah'];
						
						echo '"'.$jml_rujukan.'", ';
					}		
				?>
				],
				backgroundColor: [
				<?php
				for($i = $mulai; $i <= $selesai; $i++){
				?>
					'rgba(175, 238, 247, 0.3)',
				<?php
				}
				?>	
				],
			borderColor: [
			<?php
			for($i = $mulai; $i <= $selesai; $i++){
			?>
				'rgba(114, 211, 224, 1)',
			<?php
			}
			?>
			],
			borderWidth: 1
		}]
	},
	options: {
		responsive: true,
		maintainAspectRatio: false,
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero:true
				}
			}]
		}
	}
});
</script>

 <script src="assets/js/Chart.bundle.min.js"></script>
 <script>
 //line chart
    var ctx = document.getElementById("lineChart");
    if (ctx) {
      ctx.height = 80;
      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: [
				<?php
				$hari_ini = date('Y')."-".$bln."-01";
					$mulai = 1;
					$selesai = date('t', strtotime($hari_ini));
					for($d = $mulai; $d <= $selesai; $d++){	
						echo '"'.$d.'", ';
					}
				?>
		  ],
          defaultFontFamily: "Malgun Gothic",
          datasets: [
            {
              label: "UMUM",
              borderColor: "rgba(0,0,0)",
              borderWidth: "2",
			  backgroundColor: "transparent",
              data: [
			  <?php
					$jml = 0;		
					$tbpasienrj = "tbpasienrj_".date('m');
					for($d = $mulai; $d <= $selesai; $d++){	
						$tanggal = $tahun."-".$bln."-".$d;
						$query_retribusi = mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jumlah FROM `tbrujukluargedung` a join $tbpasienrj b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND a.TanggalRujukan = '$tanggal' AND b.Asuransi = 'UMUM'");
						$jml = mysqli_fetch_assoc($query_retribusi);
						$jml_rujukan =  $jml['Jumlah'];
						
						echo $jml_rujukan.', ';
					}		
				?>
			  ]
            },
            {
              label: "BPJS",
              borderColor: "rgba(0, 123, 255, 1)",
              borderWidth: "2",
              backgroundColor: "transparent",
              pointHighlightStroke: "rgba(26,179,148,1)",
              data: [
			  <?php
					$jml = 0;		
					$tbpasienrj = "tbpasienrj_".date('m');
					for($d = $mulai; $d <= $selesai; $d++){	
						$tanggal = $tahun."-".$bln."-".$d;
						$query_retribusi = mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jumlah FROM `tbrujukluargedung` a join $tbpasienrj b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND a.TanggalRujukan = '$tanggal' AND substring(b.Asuransi,1,4) = 'BPJS'");
						$jml = mysqli_fetch_assoc($query_retribusi);
						$jml_rujukan =  $jml['Jumlah'];
						
						echo $jml_rujukan.', ';
					}		
				?>
			  ]
            },
            {
              label: "GRATIS",
              borderColor: "rgba(247, 76, 76, 1)",
              borderWidth: "2",
			  backgroundColor: "transparent",
              pointHighlightStroke: "rgba(247, 76, 76,1)",
              data: [<?php
					$jml = 0;		
					$tbpasienrj = "tbpasienrj_".date('m');
					for($d = $mulai; $d <= $selesai; $d++){	
						$tanggal = $tahun."-".$bln."-".$d;
						$query_retribusi = mysqli_query($koneksi,"SELECT COUNT(a.NoRegistrasi) AS Jumlah FROM `tbrujukluargedung` a join $tbpasienrj b on a.NoRegistrasi = b.NoRegistrasi WHERE SUBSTRING(a.NoRegistrasi,1,11) = '$kodepuskesmas' AND a.TanggalRujukan = '$tanggal' AND b.Asuransi = 'GRATIS'");
						$jml = mysqli_fetch_assoc($query_retribusi);
						$jml_rujukan =  $jml['Jumlah'];
						
						echo $jml_rujukan.', ';
					}		
				?>]
            }
          ]
        },
        options: {
          legend: {
            position: 'top',
            labels: {
              fontFamily: 'Malgun Gothic'
            }

          },
          responsive: true,
          tooltips: {
            mode: 'index',
            intersect: false
          },
          hover: {
            mode: 'nearest',
            intersect: true
          },
          scales: {
            xAxes: [{
              ticks: {
                fontFamily: "Malgun Gothic"

              }
            }],
            yAxes: [{
              ticks: {
                beginAtZero: true,
                fontFamily: "Malgun Gothic"
              }
            }]
          }

        }
      });
    }
 </script>