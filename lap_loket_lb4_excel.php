<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];	

	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Kunjungan Pasien (LB4) (".$namapuskesmas." ".$bulan." ".$tahun.").xls");
	if(isset($bulan) and isset($tahun)){
?>

<style>
.tr, th{
	text-align:center;
}
.printheader{
	margin-top:-15px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
	display: none;
}
.printheader h4{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printheader p{
	font-size:14px;
	font-family: "Bookman Old Style";
}
.printbody{
	margin-left:-10px;
	margin-right:-10px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
	display:none;
	margin-top:10px;
}
.bawahtabel{
	margin-top:10px;
	margin-bottom:10px;
	margin-left:-50px;
	margin-right:0px;
	display:none;
}
.font10{
	font-size:10px;
	font-family: "Tahoma";
}
.font11{
	font-size:11px;
	font-family: "Tahoma";
}
.font12{
	font-size:12px;
	font-family: "Tahoma";
}
.font14{
	font-size:14px;
	font-family: "Tahoma";
}


@media print{
	body{
		padding:0px;
	}
	.noprint{
		display:none;
	}
	.printheader{
		display:block;
	}
	.printbody{
		display:block;
	}
	.atastabel{
		display:block;
	}
	.bawahtabel{
		display:block;
	}
}
</style>

<div class="printheader">
	<h4 style="margin:5px;"><b><?php echo "DINAS KESEHATAN ".$kota;?></b></h4>
	<h4 style="margin:5px;"><b><?php echo "PUSKESMAS ".$namapuskesmas;?></b></h4>
	<p  style="margin:5px;"><?php echo $alamat;?></p>
	<hr style="margin:3px; border:1px solid #000">
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN KUNJUNGAN PASIEN (LB4)</b></h4>
	<p style="margin:1px;">
		<p style="margin:1px;">Periode Laporan:<?php echo nama_bulan($bulan)." ".$tahun;?></p>
	</p><br/>
</div>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr style="border:1px solid #000;">
					<th rowspan="3">NO.</th>
					<th rowspan="3">VARIABEL</th>
					<th colspan="2">UMUM</th>
					<th rowspan="3">JML</th>
					<th colspan="6">BPJS</th>
					<th colspan="2">LAINNYA</th>
					<th rowspan="3">JML</th>
					<th rowspan="3">JUMLAH</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th rowspan="2">L</th><!--UMUM-->
					<th rowspan="2">P</th>
					<th colspan="2">NON PBI</th>
					<th rowspan="2">JUMLAH</th>
					<th colspan="2">PBI</th>
					<th rowspan="2">JUMLAH</th>
					<th rowspan="2">L</th><!--UMUM-->
					<th rowspan="2">P</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th>L</th><!--NON PBI-->
					<th>P</th>
					<th>L</th><!--PBI-->
					<th>P</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$str = "SELECT * FROM `ref_lb4_pendaftaran`";
				$str2 = $str."order by `Id` ASC";
										
				$query = mysqli_query($koneksi,$str2);
				while($data = mysqli_fetch_assoc($query)){
					$no = $no + 1;
					$variabel = $data['Variabel'];
					
					// tbpasienrj
					// umum
					$umum_l_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='UMUM' AND `StatusKunjungan` = 'Baru'"));
					$umum_p_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='UMUM' AND `StatusKunjungan` = 'Baru'"));
					$umum_jumlah_baru = $umum_l_baru['Jumlah'] + $umum_p_baru['Jumlah'];
					
					$umum_l_lama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='UMUM' AND `StatusKunjungan` = 'Lama'"));
					$umum_p_lama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='UMUM' AND `StatusKunjungan` = 'Lama'"));
					$umum_jumlah_lama = $umum_l_lama['Jumlah'] + $umum_p_lama['Jumlah'];
					
					$umum_l_bp = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='UMUM' AND `PoliPertama` = 'POLI UMUM'"));
					$umum_p_bp = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='UMUM' AND `PoliPertama` = 'POLI UMUM'"));
					$umum_jumlah_bp = $umum_l_bp['Jumlah'] + $umum_p_bp['Jumlah'];
					
					$umum_l_kia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='UMUM' AND `PoliPertama` = 'POLI KIA'"));
					$umum_p_kia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='UMUM' AND `PoliPertama` = 'POLI KIA'"));
					$umum_jumlah_kia = $umum_l_kia['Jumlah'] + $umum_p_kia['Jumlah'];
					
					$umum_l_kb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='UMUM' AND `PoliPertama` = 'POLI KB'"));
					$umum_p_kb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='UMUM' AND `PoliPertama` = 'POLI KB'"));
					$umum_jumlah_kb = $umum_l_kb['Jumlah'] + $umum_p_kb['Jumlah'];
					
					$umum_l_gigi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='UMUM' AND `PoliPertama` = 'POLI GIGI'"));
					$umum_p_gigi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='UMUM' AND `PoliPertama` = 'POLI GIGI'"));
					$umum_jumlah_gigi = $umum_l_gigi['Jumlah'] + $umum_p_gigi['Jumlah'];
					
					// nonpbi
					$nonpbi_l_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS NON PBI' AND `StatusKunjungan` = 'Baru'"));
					$nonpbi_p_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS NON PBI' AND `StatusKunjungan` = 'Baru'"));
					$nonpbi_jumlah_baru = $nonpbi_l_baru['Jumlah'] + $nonpbi_p_baru['Jumlah'];
					
					$nonpbi_l_lama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS NON PBI' AND `StatusKunjungan` = 'Lama'"));
					$nonpbi_p_lama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS NON PBI' AND `StatusKunjungan` = 'Lama'"));
					$nonpbi_jumlah_lama = $nonpbi_l_lama['Jumlah'] + $nonpbi_p_lama['Jumlah'];
					
					$nonpbi_l_bp = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS NON PBI' AND `PoliPertama` = 'POLI UMUM'"));
					$nonpbi_p_bp = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS NON PBI' AND `PoliPertama` = 'POLI UMUM'"));
					$nonpbi_jumlah_bp = $nonpbi_l_bp['Jumlah'] + $nonpbi_p_bp['Jumlah'];
					
					$nonpbi_l_kia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS NON PBI' AND `PoliPertama` = 'POLI KIA'"));
					$nonpbi_p_kia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS NON PBI' AND `PoliPertama` = 'POLI KIA'"));
					$nonpbi_jumlah_kia = $nonpbi_l_kia['Jumlah'] + $nonpbi_p_kia['Jumlah'];
					
					$nonpbi_l_kb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS NON PBI' AND `PoliPertama` = 'POLI KB'"));
					$nonpbi_p_kb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS NON PBI' AND `PoliPertama` = 'POLI KB'"));
					$nonpbi_jumlah_kb = $nonpbi_l_kb['Jumlah'] + $nonpbi_p_kb['Jumlah'];
					
					$nonpbi_l_gigi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS NON PBI' AND `PoliPertama` = 'POLI GIGI'"));
					$nonpbi_p_gigi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS NON PBI' AND `PoliPertama` = 'POLI GIGI'"));
					$nonpbi_jumlah_gigi = $nonpbi_l_gigi['Jumlah'] + $nonpbi_p_gigi['Jumlah'];
					
					// pbi
					$pbi_l_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS PBI' AND `StatusKunjungan` = 'Baru'"));
					$pbi_p_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS PBI' AND `StatusKunjungan` = 'Baru'"));
					$pbi_jumlah_baru = $pbi_l_baru['Jumlah'] + $pbi_p_baru['Jumlah'];
					
					$pbi_l_lama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS PBI' AND `StatusKunjungan` = 'Lama'"));
					$pbi_p_lama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS PBI' AND `StatusKunjungan` = 'Lama'"));
					$pbi_jumlah_lama = $pbi_l_lama['Jumlah'] + $pbi_p_lama['Jumlah'];
					
					$pbi_l_bp = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS PBI' AND `PoliPertama` = 'POLI UMUM'"));
					$pbi_p_bp = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS PBI' AND `PoliPertama` = 'POLI UMUM'"));
					$pbi_jumlah_bp = $pbi_l_bp['Jumlah'] + $pbi_p_bp['Jumlah'];
					
					$pbi_l_kia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS PBI' AND `PoliPertama` = 'POLI KIA'"));
					$pbi_p_kia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS PBI' AND `PoliPertama` = 'POLI KIA'"));
					$pbi_jumlah_kia = $pbi_l_kia['Jumlah'] + $pbi_p_kia['Jumlah'];
					
					$pbi_l_kb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS PBI' AND `PoliPertama` = 'POLI KB'"));
					$pbi_p_kb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS PBI' AND `PoliPertama` = 'POLI KB'"));
					$pbi_jumlah_kb = $pbi_l_kb['Jumlah'] + $pbi_p_kb['Jumlah'];
					
					$pbi_l_gigi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='BPJS PBI' AND `PoliPertama` = 'POLI GIGI'"));
					$pbi_p_gigi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='BPJS PBI' AND `PoliPertama` = 'POLI GIGI'"));
					$pbi_jumlah_gigi = $pbi_l_gigi['Jumlah'] + $pbi_p_gigi['Jumlah'];
					
					// lainnya
					$lainnya_l_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='LAINNYA' AND `StatusKunjungan` = 'Baru'"));
					$lainnya_p_baru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='LAINNYA' AND `StatusKunjungan` = 'Baru'"));
					$lainnya_jumlah_baru = $lainnya_l_baru['Jumlah'] + $lainnya_p_baru['Jumlah'];
					
					$lainnya_l_lama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='LAINNYA' AND `StatusKunjungan` = 'Lama'"));
					$lainnya_p_lama = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='LAINNYA' AND `StatusKunjungan` = 'Lama'"));
					$lainnya_jumlah_lama = $lainnya_l_lama['Jumlah'] + $lainnya_p_lama['Jumlah'];
					
					$lainnya_l_bp = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='LAINNYA' AND `PoliPertama` = 'POLI UMUM'"));
					$lainnya_p_bp = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='LAINNYA' AND `PoliPertama` = 'POLI UMUM'"));
					$lainnya_jumlah_bp = $lainnya_l_bp['Jumlah'] + $lainnya_p_bp['Jumlah'];
					
					$lainnya_l_kia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='LAINNYA' AND `PoliPertama` = 'POLI KIA'"));
					$lainnya_p_kia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='LAINNYA' AND `PoliPertama` = 'POLI KIA'"));
					$lainnya_jumlah_kia = $lainnya_l_kia['Jumlah'] + $lainnya_p_kia['Jumlah'];
					
					$lainnya_l_kb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='LAINNYA' AND `PoliPertama` = 'POLI KB'"));
					$lainnya_p_kb = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='LAINNYA' AND `PoliPertama` = 'POLI KB'"));
					$lainnya_jumlah_kb = $lainnya_l_kb['Jumlah'] + $lainnya_p_kb['Jumlah'];
					
					$lainnya_l_gigi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='L' AND `Asuransi`='LAINNYA' AND `PoliPertama` = 'POLI GIGI'"));
					$lainnya_p_gigi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`NoRegistrasi`) AS Jumlah FROM `$tbpasienrj` WHERE YEAR(`TanggalRegistrasi`)='$tahun' AND MONTH(`TanggalRegistrasi`)='$bulan' AND `JenisKelamin`='P' AND `Asuransi`='LAINNYA' AND `PoliPertama` = 'POLI GIGI'"));
					$lainnya_jumlah_gigi = $lainnya_l_gigi['Jumlah'] + $lainnya_p_gigi['Jumlah'];
					
					// total
					$total_baru = $umum_jumlah_baru + $nonpbi_jumlah_baru + $pbi_jumlah_baru + $lainnya_jumlah_baru;
					$total_lama = $umum_jumlah_lama + $nonpbi_jumlah_lama + $pbi_jumlah_lama + $lainnya_jumlah_lama;
					$total_bp = $umum_jumlah_bp + $nonpbi_jumlah_bp + $pbi_jumlah_bp + $lainnya_jumlah_bp;
					$total_kia = $umum_jumlah_kia + $nonpbi_jumlah_kia + $pbi_jumlah_kia + $lainnya_jumlah_kia;
					$total_kb = $umum_jumlah_kb + $nonpbi_jumlah_kb + $pbi_jumlah_kb + $lainnya_jumlah_kb;
					$total_gigi= $umum_jumlah_gigi + $nonpbi_jumlah_gigi + $pbi_jumlah_gigi + $lainnya_jumlah_gigi;
				?>
					<tr style="border:1px solid #000;">
						<td style="text-align:center; border:1px solid #000; padding:3px;"><?php echo $no;?></td>
						<td style="text-align:left; border:1px solid #000; padding:3px;"><?php echo $data['Variabel'];?></td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><!--UMUM L-->
						<?php 
							if($variabel == "Kunjungan Puskesmas (Baru)"){echo $umum_l_baru['Jumlah'];}
							if($variabel == "Kunjungan Puskesmas (Lama)"){echo $umum_l_lama['Jumlah'];}
							if($variabel == "Kunjungan Rawat Jalan BP"){echo $umum_l_bp['Jumlah'];}
							if($variabel == "Kunjungan Rawat Jalan KIA"){echo $umum_l_kia['Jumlah'];}
							if($variabel == "Kunjungan Rawat Jalan KB"){echo $umum_l_kb['Jumlah'];}
							if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $umum_l_gigi['Jumlah'];}
						?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><!--UMUM P-->
						<?php 
							if($variabel == "Kunjungan Puskesmas (Baru)"){echo $umum_p_baru['Jumlah'];}
							if($variabel == "Kunjungan Puskesmas (Lama)"){echo $umum_p_lama['Jumlah'];}
							if($variabel == "Kunjungan Rawat Jalan BP"){echo $umum_p_bp['Jumlah'];}
							if($variabel == "Kunjungan Rawat Jalan KIA"){echo $umum_p_kia['Jumlah'];}
							if($variabel == "Kunjungan Rawat Jalan KB"){echo $umum_p_kb['Jumlah'];}
							if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $umum_p_gigi['Jumlah'];}
						?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								if($variabel == "Kunjungan Puskesmas (Baru)"){echo $umum_jumlah_baru;}
								if($variabel == "Kunjungan Puskesmas (Lama)"){echo $umum_jumlah_lama;}
								if($variabel == "Kunjungan Rawat Jalan BP"){echo $umum_jumlah_bp;}
								if($variabel == "Kunjungan Rawat Jalan KIA"){echo $umum_jumlah_kia;}
								if($variabel == "Kunjungan Rawat Jalan KB"){echo $umum_jumlah_kb;}
								if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $umum_jumlah_gigi;}
							?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><!--NON PBI L-->
							<?php 
								if($variabel == "Kunjungan Puskesmas (Baru)"){echo $nonpbi_l_baru['Jumlah'];}
								if($variabel == "Kunjungan Puskesmas (Lama)"){echo $nonpbi_l_lama['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan BP"){echo $nonpbi_l_bp['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan KIA"){echo $nonpbi_l_kia['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan KB"){echo $nonpbi_l_kb['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $nonpbi_l_gigi['Jumlah'];}
							?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><!--NON PBI P-->
							<?php 
								if($variabel == "Kunjungan Puskesmas (Baru)"){echo $nonpbi_p_baru['Jumlah'];}
								if($variabel == "Kunjungan Puskesmas (Lama)"){echo $nonpbi_p_lama['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan BP"){echo $nonpbi_p_bp['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan KIA"){echo $nonpbi_p_kia['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan KB"){echo $nonpbi_p_kb['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $nonpbi_p_gigi['Jumlah'];}
							?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								if($variabel == "Kunjungan Puskesmas (Baru)"){echo $nonpbi_jumlah_baru;}
								if($variabel == "Kunjungan Puskesmas (Lama)"){echo $nonpbi_jumlah_lama;}
								if($variabel == "Kunjungan Rawat Jalan BP"){echo $nonpbi_jumlah_bp;}
								if($variabel == "Kunjungan Rawat Jalan KIA"){echo $nonpbi_jumlah_kia;}
								if($variabel == "Kunjungan Rawat Jalan KB"){echo $nonpbi_jumlah_kb;}
								if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $nonpbi_jumlah_kb;}
							?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><!--PBI L-->
							<?php 
								if($variabel == "Kunjungan Puskesmas (Baru)"){echo $pbi_l_baru['Jumlah'];}
								if($variabel == "Kunjungan Puskesmas (Lama)"){echo $pbi_l_lama['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan BP"){echo $pbi_l_bp['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan KIA"){echo $pbi_l_kia['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan KB"){echo $pbi_l_kb['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $pbi_l_gigi['Jumlah'];}
							?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><!--PBI P-->
							<?php 
								if($variabel == "Kunjungan Puskesmas (Baru)"){echo $pbi_p_baru['Jumlah'];}
								if($variabel == "Kunjungan Puskesmas (Lama)"){echo $pbi_p_lama['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan BP"){echo $pbi_p_bp['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan KIA"){echo $pbi_p_kia['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan KB"){echo $pbi_p_kb['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $pbi_p_gigi['Jumlah'];}
							?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								if($variabel == "Kunjungan Puskesmas (Baru)"){echo $pbi_jumlah_baru;}
								if($variabel == "Kunjungan Puskesmas (Lama)"){echo $pbi_jumlah_lama;}
								if($variabel == "Kunjungan Rawat Jalan BP"){echo $pbi_jumlah_bp;}
								if($variabel == "Kunjungan Rawat Jalan KIA"){echo $pbi_jumlah_kia;}
								if($variabel == "Kunjungan Rawat Jalan KB"){echo $pbi_jumlah_kb;}
								if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $pbi_jumlah_gigi;}
							?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><!--LAINNYA L-->
							<?php 
								if($variabel == "Kunjungan Puskesmas (Baru)"){echo $lainnya_l_baru['Jumlah'];}
								if($variabel == "Kunjungan Puskesmas (Lama)"){echo $lainnya_l_lama['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan BP"){echo $lainnya_l_bp['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan KIA"){echo $lainnya_l_kia['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan KB"){echo $lainnya_l_kb['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $lainnya_l_gigi['Jumlah'];}
							?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><!--LAINNYA P-->
							<?php 
								if($variabel == "Kunjungan Puskesmas (Baru)"){echo $lainnya_p_baru['Jumlah'];}
								if($variabel == "Kunjungan Puskesmas (Lama)"){echo $lainnya_p_lama['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan BP"){echo $lainnya_p_bp['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan KIA"){echo $lainnya_p_kia['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan KB"){echo $lainnya_p_kb['Jumlah'];}
								if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $lainnya_p_gigi['Jumlah'];}
							?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;">
							<?php 
								if($variabel == "Kunjungan Puskesmas (Baru)"){echo $lainnya_jumlah_baru;}
								if($variabel == "Kunjungan Puskesmas (Lama)"){echo $lainnya_jumlah_lama;}
								if($variabel == "Kunjungan Rawat Jalan BP"){echo $lainnya_jumlah_bp;}
								if($variabel == "Kunjungan Rawat Jalan KIA"){echo $lainnya_jumlah_kia;}
								if($variabel == "Kunjungan Rawat Jalan KB"){echo $lainnya_jumlah_kb;}
								if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $lainnya_jumlah_gigi;}
							?>
						</td>
						<td style="text-align:center; border:1px solid #000; padding:3px;"><!--TOTAL-->
							<?php 
								if($variabel == "Kunjungan Puskesmas (Baru)"){echo $total_baru;}
								if($variabel == "Kunjungan Puskesmas (Lama)"){echo $total_lama;}
								if($variabel == "Kunjungan Rawat Jalan BP"){echo $total_bp;}
								if($variabel == "Kunjungan Rawat Jalan KIA"){echo $total_kia;}
								if($variabel == "Kunjungan Rawat Jalan KB"){echo $total_kb;}
								if($variabel == "Kunjungan Rawat Jalan GIGI"){echo $total_gigi;}
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
<?php
}
?>