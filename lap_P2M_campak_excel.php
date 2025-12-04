<?php
	session_start();
	include_once('config/koneksi.php');
	include "config/helper_pasienrj.php";
	$hariini = date('d-m-Y');
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
	$keydate1 = $_GET['keydate1'];
	$keydate2 = $_GET['keydate2'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan_P2M_Campak (".$namapuskesmas.").xls");
	if(isset($bulan) and isset($tahun)){
?>
<style>
.tr, th{
	text-align:center;
}
.printheader{
	margin-top:10px;
	margin-left:0px;
	margin-right:0px;
	text-align:center;
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
	margin-left:0px;
	margin-right:0px;
}
.table-responsive{
	font-family: "Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "Tahoma", "sans-serif";
}
.atastabel{
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
	<h4 style="margin:15px 5px 5px 5px;"><b>REGISTRASI CAMPAK (C1)</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo $keydate1." s/d ".$keydate2;?></p><br/>
</div>

<div class="atastabel font14">
	<div style="float:right; width:35%; margin-bottom:10px;">	
		<table style="font-size:10px; width:300px;">
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kelurahan/Desa</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".strtoupper($kelurahan);?></h5></td>
			</tr>
			<tr>
				<td style="padding:2px 4px;"><h5  style="margin:5px;">Kecamatan</h5 ></td>
				<td style="padding:2px 4px;"><h5  style="margin:5px;"><?php echo ": ".strtoupper($kecamatan);?></h5></td>
			</tr>
		</table>
	</div>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
			<thead>
				<tr style="border:1px solid #000;">
					<th rowspan="3">No.</th>
					<th rowspan="3">Nama Anak</th>
					<th rowspan="3">Nama Orang Tua</th>
					<th rowspan="3">Alamat</th>
					<th colspan="2">Gender</th>
					<th colspan="2">Vaksin Campak sblm Sakit</th>
					<th colspan="2">Tgl.Timbul</th>
					<th colspan="2">Tgl.diambil Spesimen</th>
					<th colspan="2">Hasil Spesimen</th>
					<th colspan="1">Diberi Vit.A</th>
					<th colspan="1">Keadaan Akhir</th>
					<th colspan="5">Klasifikasi Final</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th rowspan="2">L</th>
					<th rowspan="2">P</th>
					<th rowspan="2">Berapa Kali</th>
					<th rowspan="2">Tidak Tahu</th>
					<th rowspan="2">Demam</th>
					<th rowspan="2">Rash</th>
					<th rowspan="2">Darah</th>
					<th rowspan="2">Urin</th>
					<th rowspan="2">Darah</th>
					<th rowspan="2">Urin</th>
					<th rowspan="2">(Y/T)</th>
					<th rowspan="2">(H/M)</th>
					<th colspan="3">Campak</th>
					<th rowspan="2">Rubela</th>
					<th rowspan="2">Bkn.Campak</th>
				</tr>
				<tr style="border:1px solid #000;">
					<th>Lap(+)</th>
					<th>Epid</th>
					<th>Klinis</th>
				</tr>
			</thead>
			<tbody style="font-size:10px;">
				<?php
				$no = 0;
				
				//tbdiagnosacampak
				$kasus = $_GET['kasus'];
				$str_campak = "SELECT * FROM `tbdiagnosacampak` WHERE `TanggalRegistrasi` BETWEEN  '$tgl1' AND '$tgl2' AND".$semua;
				// echo $str_campak;
				// die();
				$query_campak = mysqli_query($koneksi,$str_campak);
				while($data_campak = mysqli_fetch_assoc($query_campak)){
				$no = $no + 1;
				$kelamin = $data_campak['Kelamin'];
				$vaksincampak = $data_campak['VaksinCampak'];
				$klasifikasidetail = $data_campak['KlasifikasiDetail'];
				
				//tbkk
				$strkk = "select `NamaKK`,`Alamat` from `$tbkk` where `NoIndex`='".$datapasienrj['NoIndex']."'";
				$querykk = mysqli_query($koneksi,$strkk);
				$datakk = mysqli_fetch_assoc($querykk);
				
				//kelamin
				if($kelamin == 'L'){
					$kelamin_l = '<span class="glyphicon glyphicon-ok"></span>';
					$kelamin_p = '-';
				}else{
					$kelamin_p = '<span class="glyphicon glyphicon-ok"></span>';
					$kelamin_l = '-';
				}
				
				//vaksincampak
				if($vaksincampak != '0'){
					$brpkali = '<span class="glyphicon glyphicon-ok"></span>';
					$tdktahu = '-';
				}else{
					$tdktahu = '<span class="glyphicon glyphicon-ok"></span>';
					$brpkali = '-';
				}
				
				//klasifikasidetail
				if($klasifikasidetail == 'Campak: Lab (+)'){
					$klasifikasidetail1 = '<span class="glyphicon glyphicon-ok"></span>';
					$klasifikasidetail2= '-';
					$klasifikasidetail3= '-';
					$klasifikasidetail4= '-';
					$klasifikasidetail5= '-';
				}elseif($klasifikasidetail == 'Campak: Epid'){
					$klasifikasidetail2= '<span class="glyphicon glyphicon-ok"></span>';
					$klasifikasidetail1 = '-';
					$klasifikasidetail3= '-';
					$klasifikasidetail4= '-';
					$klasifikasidetail5= '-';
				}elseif($klasifikasidetail == 'Campak: Klinis'){
					$klasifikasidetail3= '<span class="glyphicon glyphicon-ok"></span>';
					$klasifikasidetail1 = '-';
					$klasifikasidetail2= '-';
					$klasifikasidetail4= '-';
					$klasifikasidetail5= '-';
				}elseif($klasifikasidetail == 'Rubela Lab (+)'){
					$klasifikasidetail4= '<span class="glyphicon glyphicon-ok"></span>';
					$klasifikasidetail1 = '-';
					$klasifikasidetail2= '-';
					$klasifikasidetail3= '-';
					$klasifikasidetail5= '-';
				}elseif($klasifikasidetail == 'Bukan Campak/Rubela'){
					$klasifikasidetail5= '<span class="glyphicon glyphicon-ok"></span>';
					$klasifikasidetail1 = '-';
					$klasifikasidetail2= '-';
					$klasifikasidetail3= '-';
					$klasifikasidetail4= '-';
				}
				
				?>
					<tr style="border:1px solid #000;">
						<td><?php echo $no;?></td>
						<td><?php echo $data_campak['NamaPasien'];?></td>
						<td><?php echo $data_campak['NamaOrangTua'];?></td>
						<td>-</td>
						<td><?php echo $kelamin_l;?></td>
						<td><?php echo $kelamin_p;?></td>
						<td><?php echo $brpkali;?></td>
						<td><?php echo $tdktahu;?></td>
						<td><?php echo date("y/m/d", strtotime($data_campak['TanggalTimbulDemam']));?></td>
						<td><?php echo date("y/m/d", strtotime($data_campak['TanggalTimbulRash']));?></td>
						<td><?php echo date("y/m/d", strtotime($data_campak['TanggalSpesimenDarah']));?></td>
						<td><?php echo date("y/m/d", strtotime($data_campak['TanggalSpesimenUrin']));?></td>
						<td><?php echo $data_campak['HasilSpesimenDarah'];?></td>
						<td><?php echo $data_campak['HasilSpesimenUrin'];?></td>
						<td><?php echo $data_campak['VitaminA'];?></td>
						<td><?php echo $data_campak['KeadaanAkhir'];?></td>
						<td><?php echo $klasifikasidetail1;?></td>
						<td><?php echo $klasifikasidetail2;?></td>
						<td><?php echo $klasifikasidetail3;?></td>
						<td><?php echo $klasifikasidetail4;?></td>
						<td><?php echo $klasifikasidetail5;?></td>
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