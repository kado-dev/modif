<?php
    session_start();
	include "config/koneksi.php";
	include "config/helper.php";
	include "config/helper_pasienrj.php";
	$bulan = $_GET['bulan'];
	$tahun = $_GET['tahun'];
    $kasus = $_GET['kasus'];
	
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Bulanan P2M ISPA (".$namapuskesmas." ".$bulan." ".$tahun.").xls");
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
	<h4 style="margin:15px 5px 5px 5px;"><b>LAPORAN BULANAN PROGRAM PENGENDALIAN ISPA</b></h4>
	<p style="margin:1px;">Periode Laporan: <?php echo $bulan." ".$tahun;?></p><br/>
</div><br/>

<div class="row noprint">
	<div class="table-responsive noprint">
		<table class="table table-condensed" border="1">
            <thead>
                <tr style="border:1px dashed #000;">
                    <th rowspan="3">NO.</th>
                    <th rowspan="3">KELURAHAN</th>
                    <th rowspan="3">JML PDKK</th>
                    <th rowspan="3" width="6%">JML PDKK BALITA (10% PDKK)</th>
                    <th rowspan="3" width="6%">TARGET PENEMUAN PDKK PNEUMONIA</th>
                    <th colspan="4">PNEUMONIA</th>
                    <th colspan="4">PNEUMONIA BERAT</th>
                    <th colspan="7">JML</th>
                    <th rowspan="3">%</th>
                    <th colspan="5">BATUK BUKAN PNEUMONIA</th>
                    <th rowspan="3" width="6%">JML BALITA BATUK YANG DIHITUNG NAPAS ATAU LIHAT TDDK</th>
                    <th colspan="6">JML KEMATIAN BALITA KRN PNEUMONIA</th>
                    <th colspan="6">ISPA >5 TH</th>
                    <th rowspan="3">DIRUJUK</th>
                </tr>
                <tr style="border:1px dashed #000;">
                    <th colspan="2"><1 TH</th><!--Pneumonia-->
                    <th colspan="2">1-4 TH</th>
                    <th colspan="2"><1 TH</th><!--Pneumonia Berat-->
                    <th colspan="2">1-4 TH</th>
                    <th colspan="2"><1 TH</th><!--Jumlah-->
                    <th colspan="2">1-4 TH</th>
                    <th colspan="2">SUBTOTAL</th>
                    <th rowspan="2">TOTAL</th>
                    <th colspan="2"><1 TH</th><!--Bukan Pneumonia-->
                    <th colspan="2">1-4 TH</th>
                    <th rowspan="2">TOTAL</th>
                    <th colspan="2"><1 TH</th><!--Jml Kematian Balita Krn Penumonia-->
                    <th colspan="2">1-4 TH</th>
                    <th colspan="2">TOTAL</th>
                    <th colspan="3">BKN PNEUMONIA</th>
                    <th colspan="3">PNEUMONIA</th><!--ISPA >5 Thn-->
                
                </tr>
                <tr style="border:1px dashed #000;">
                    <th>L</th><!--Pneumonia-->
                    <th>P</th>
                    <th>L</th>
                    <th>P</th>
                    <th>L</th><!--Pneumonia Berat-->
                    <th>P</th>
                    <th>L</th>
                    <th>P</th>
                    <th>L</th><!--Jumlah-->
                    <th>P</th>
                    <th>L</th>
                    <th>P</th>
                    <th>L</th>
                    <th>P</th>
                    <th>L</th><!--Bukan Pneumonia-->
                    <th>P</th>
                    <th>L</th>
                    <th>P</th>
                    <th>L</th><!--Jml Kematian Balita Krn Penumonia-->
                    <th>P</th>
                    <th>L</th>
                    <th>P</th>
                    <th>L</th>
                    <th>P</th>
                    <th>L</th><!--Pneumonia-->
                    <th>P</th>
                    <th>T</th>
                    <th>L</th><!--Bukan Pneumonia-->
                    <th>P</th>
                    <th>T</th>
                </tr>
                <tr style="border:1px dashed #000;">
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>5</th>
                    <th>6</th>
                    <th>7</th>
                    <th>8</th>
                    <th>9</th>
                    <th>10</th>
                    <th>11</th>
                    <th>12</th>
                    <th>13</th>
                    <th>14</th>
                    <th>15</th>
                    <th>16</th>
                    <th>17</th>
                    <th>18</th>
                    <th>19</th>
                    <th>20</th>
                    <th>21</th>
                    <th>22</th>
                    <th>23</th>
                    <th>24</th>
                    <th>25</th>
                    <th>26</th>
                    <th>27</th>
                    <th>28</th>
                    <th>29</th>
                    <th>30</th>
                    <th>31</th>
                    <th>32</th>
                    <th>33</th>
                    <th>34</th>
                    <th>35</th>
                    <th>36</th>
                    <th>37</th>
                    <th>38</th>
                    <th>39</th>
                    <th>40</th>
                </tr>
            </thead>
			<tbody>
                <?php
                // tbdiagnosaispa
                $kasus = $_GET['kasus'];
                if($kasus != 'Semua'){
                    $qkasus = " AND Kunjungan = '$kasus' ";
                }else{
                    $qkasus = " ";
                }
                
                $str_kelurahan = "SELECT * FROM `tbkelurahan` WHERE KodePuskesmas = '$kodepuskesmas' OR KodePuskesmas = '*'";
                $str2 = $str_kelurahan."ORDER BY Kelurahan";
                // echo $str2;
                
                $query_kelurahan = mysqli_query($koneksi,$str2);
                while($data_kelurahan = mysqli_fetch_assoc($query_kelurahan)){
                    $no = $no + 1;
                    $noregistrasi = $data_kelurahan['NoRegistrasi'];
                    $umurtahun = $data_kelurahan['UmurTahun'];
                    $kelurahan = $data_kelurahan['Kelurahan'];
                
                    // pneumonia
                    if ($kelurahan == 'Luar Wilayah'){
                        $ispa_0_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun = '0' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan <> '$kelurahan'"));
                        $ispa_0_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun = '0' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan <> '$kelurahan'"));
                        $ispa_1_4_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan <> '$kelurahan' A"));
                        $ispa_1_4_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan <> '$kelurahan'"));
                    }else{
                        $ispa_0_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun = '0' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan = '$kelurahan'"));
                        $ispa_0_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun = '0' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan = '$kelurahan'"));
                        $ispa_1_4_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan = '$kelurahan'"));
                        $ispa_1_4_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan = '$kelurahan' "));
                    }	
                    
                    $ispa_0_Laki = $ispa_0_Laki_pneumonia['Jumlah'];
                    $ispa_1_4_Laki =  $ispa_1_4_Laki_pneumonia['Jumlah'];
                    $laki_pneumonia = $ispa_0_Laki + $ispa_1_4_Laki;
                    $ispa_0_perempuan = $ispa_0_Perempuan_pneumonia['Jumlah'];
                    $ispa_1_4_perempuan =  $ispa_1_4_Perempuan_pneumonia['Jumlah'];
                    $perempuan_pneumonia = $ispa_0_perempuan + $ispa_1_4_perempuan;
                
                    // pneumonia_berat
                    $ispa_0_Laki_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun = '0' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan = '$kelurahan' "));
                    $ispa_0_Perempuan_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun = '0' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan = '$kelurahan' "));
                    $ispa_1_4_Laki_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan = '$kelurahan' "));
                    $ispa_1_4_Perempuan_pneumonia_berat = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan = '$kelurahan' "));
                    $ispa_0_Laki_berat = $ispa_0_Laki_pneumonia_berat['Jumlah'];
                    $ispa_1_4_Laki_berat =  $ispa_1_4_Laki_pneumonia_berat['Jumlah'];
                    $laki_pneumonia_berat = $ispa_0_Laki_berat + $ispa_1_4_Laki_berat;			
                    $ispa_0_perempuan_berat = $ispa_0_Perempuan_pneumonia_berat['Jumlah'];
                    $ispa_1_4_perempuan_berat =  $ispa_1_4_Perempuan_pneumonia_berat['Jumlah'];
                    $perempuan_pneumonia_berat = $ispa_0_perempuan_berat + $ispa_1_4_perempuan_berat;
                
                    // sub total
                    $jumlah_0_Laki = $ispa_1_4_Laki_pneumonia['Jumlah'];
                    $jumlah_1_4_Laki = $ispa_1_4_Laki_pneumonia_berat['Jumlah'];
                    $sublaki = $jumlah_0_Laki + $jumlah_1_4_Laki;			
                    $jumlah_0_perempuan = $ispa_1_4_Perempuan_pneumonia['Jumlah'];
                    $jumlah_1_4_perempuan = $ispa_1_4_Perempuan_pneumonia_berat['Jumlah'];
                    $subperempuan = $jumlah_0_perempuan + $jumlah_1_4_perempuan;
                
                    // total
                    $total  = $sublaki + $subperempuan;
                    
                    // batuk bukan pneumonia
                    $ispa_0_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun = '4' AND (a.KodeDiagnosa = 'J00' OR a.KodeDiagnosa like '%J06%' OR a.KodeDiagnosa like '%J11%' OR a.KodeDiagnosa like '%J20%' OR a.KodeDiagnosa like '%J21%' OR a.KodeDiagnosa like '%J30%' OR a.KodeDiagnosa like '%J39%' OR a.KodeDiagnosa like '%J44%' OR a.KodeDiagnosa like '%J45%' OR a.KodeDiagnosa like '%J46%' OR a.KodeDiagnosa like '%J47%') AND b.Kelurahan = '$kelurahan'"));
                    $ispa_0_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun = '4' AND (a.KodeDiagnosa = 'J00' OR a.KodeDiagnosa like '%J06%' OR a.KodeDiagnosa like '%J11%' OR a.KodeDiagnosa like '%J20%' OR a.KodeDiagnosa like '%J21%' OR a.KodeDiagnosa like '%J30%' OR a.KodeDiagnosa like '%J39%' OR a.KodeDiagnosa like '%J44%' OR a.KodeDiagnosa like '%J45%' OR a.KodeDiagnosa like '%J46%' OR a.KodeDiagnosa like '%J47%') AND b.Kelurahan = '$kelurahan'"));
                    $ispa_1_4_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun BETWEEN '1' AND '4' AND (a.KodeDiagnosa = 'J00' OR a.KodeDiagnosa like '%J06%' OR a.KodeDiagnosa like '%J11%' OR a.KodeDiagnosa like '%J20%' OR a.KodeDiagnosa like '%J21%' OR a.KodeDiagnosa like '%J30%' OR a.KodeDiagnosa like '%J39%' OR a.KodeDiagnosa like '%J44%' OR a.KodeDiagnosa like '%J45%' OR a.KodeDiagnosa like '%J46%' OR a.KodeDiagnosa like '%J47%') AND b.Kelurahan = '$kelurahan'"));
                    $ispa_1_4_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun BETWEEN '1' AND '4' AND (a.KodeDiagnosa = 'J00' OR a.KodeDiagnosa like '%J06%' OR a.KodeDiagnosa like '%J11%' OR a.KodeDiagnosa like '%J20%' OR a.KodeDiagnosa like '%J21%' OR a.KodeDiagnosa like '%J30%' OR a.KodeDiagnosa like '%J39%' OR a.KodeDiagnosa like '%J44%' OR a.KodeDiagnosa like '%J45%' OR a.KodeDiagnosa like '%J46%' OR a.KodeDiagnosa like '%J47%') AND b.Kelurahan = '$kelurahan'"));
                    $ttl_pneumonia_bukan = $ispa_0_Laki_pneumonia_bukan['Jumlah'] + $ispa_0_Perempuan_pneumonia_bukan['Jumlah'] + $ispa_1_4_Laki_pneumonia_bukan['Jumlah'] + $ispa_1_4_Perempuan_pneumonia_bukan['Jumlah'];
                    
                    // nafas / RR, mengambil yang dihitung nafasnya (!='') berati diisi
                    $jml_nafas = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalPeriksa)='$tahun' AND MONTH(a.TanggalPeriksa)='$bulan' AND (a.KodeDiagnosa = 'J00' OR a.KodeDiagnosa like '%J06%' OR a.KodeDiagnosa like '%J11%' OR a.KodeDiagnosa like '%J20%' OR a.KodeDiagnosa like '%J21%' OR a.KodeDiagnosa like '%J30%' OR a.KodeDiagnosa like '%J39%' OR a.KodeDiagnosa like '%J44%' OR a.KodeDiagnosa like '%J45%' OR a.KodeDiagnosa like '%J46%' OR a.KodeDiagnosa like '%J47%') AND b.Kelurahan = '$kelurahan'"));
                    
                    
                    // ispa > 5th bukan pneumonia
                    $ispa_5_Laki_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun >= '5' AND (a.KodeDiagnosa = 'J00' OR a.KodeDiagnosa like '%J06%' OR a.KodeDiagnosa like '%J11%' OR a.KodeDiagnosa like '%J20%' OR a.KodeDiagnosa like '%J21%' OR a.KodeDiagnosa like '%J30%' OR a.KodeDiagnosa like '%J39%' OR a.KodeDiagnosa like '%J44%' OR a.KodeDiagnosa like '%J45%' OR a.KodeDiagnosa like '%J46%' OR a.KodeDiagnosa like '%J47%') AND b.Kelurahan = '$kelurahan'"));
                    $ispa_5_Perempuan_pneumonia_bukan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(TanggalRa.TanggalDiagnosaegistrasi)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun >= '5' AND (a.KodeDiagnosa = 'J00' OR a.KodeDiagnosa like '%J06%' OR a.KodeDiagnosa like '%J11%' OR a.KodeDiagnosa like '%J20%' OR a.KodeDiagnosa like '%J21%' OR a.KodeDiagnosa like '%J30%' OR a.KodeDiagnosa like '%J39%' OR a.KodeDiagnosa like '%J44%' OR a.KodeDiagnosa like '%J45%' OR a.KodeDiagnosa like '%J46%' OR a.KodeDiagnosa like '%J47%') AND b.Kelurahan = '$kelurahan'"));
                    $ttl_5_pneumonia_bukan = $ispa_5_Laki_pneumonia_bukan['Jumlah'] + $ispa_5_Perempuan_pneumonia_bukan['Jumlah'];
                                            
                    // ispa > 5th pneumonia
                    $ispa_5_Laki_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'L' AND a.UmurTahun >= '5' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan = '$kelurahan'"));
                    $ispa_5_Perempuan_pneumonia = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(a.IdDiagnosa)AS Jumlah FROM `$tbdiagnosapasien` a JOIN `$tbkk` b ON a.NoIndex = b.NoIndex WHERE YEAR(a.TanggalDiagnosa)='$tahun' AND a.JenisKelamin = 'P' AND a.UmurTahun >= '5' AND (a.KodeDiagnosa like '%J18%') AND b.Kelurahan = '$kelurahan'"));
                    $ttl_5_pneumonia = $ispa_5_Laki_pneumonia['Jumlah'] + $ispa_5_Perempuan_pneumonia['Jumlah'];
                                                                        
                ?>
                
                    <tr style="border:1px dashed #000;">
                        <td align="center"><?php echo $no;?></td>
                        <td align="left"><?php echo $data_kelurahan['Kelurahan'];?></td>
                        <td align="center">-</td>
                        <td align="center">-</td>
                        <td align="center">-</td>
                        <td align="right"><?php echo $ispa_0_Laki_pneumonia['Jumlah'];?></td>
                        <td align="right"><?php echo $ispa_0_Perempuan_pneumonia['Jumlah'];?></td>
                        <td align="right"><?php echo $ispa_1_4_Laki_pneumonia['Jumlah'];?></td>
                        <td align="right"><?php echo $ispa_1_4_Perempuan_pneumonia['Jumlah'];?></td>
                        <td align="right"><?php echo $ispa_0_Laki_pneumonia_berat['Jumlah'];?></td>
                        <td align="right"><?php echo $ispa_0_Perempuan_pneumonia_berat['Jumlah'];?></td>
                        <td align="right"><?php echo $ispa_1_4_Laki_pneumonia_berat['Jumlah'];?></td>
                        <td align="right"><?php echo $ispa_1_4_Perempuan_pneumonia_berat['Jumlah'];?></td>
                        <td align="right"><?php echo $laki_pneumonia;?></td>
                        <td align="right"><?php echo $perempuan_pneumonia;?></td>
                        <td align="right"><?php echo $laki_pneumonia_berat;?></td>
                        <td align="right"><?php echo $perempuan_pneumonia_berat;?></td>
                        <td align="right"><?php echo $sublaki;?></td>
                        <td align="right"><?php echo $subperempuan;?></td>
                        <td align="right"><?php echo $total;?></td>
                        <td align="center">0.00</td>
                        <td align="right"><?php echo $ispa_0_Laki_pneumonia_bukan['Jumlah'];?></td>
                        <td align="right"><?php echo $ispa_0_Perempuan_pneumonia_bukan['Jumlah'];?></td>
                        <td align="right"><?php echo $ispa_1_4_Laki_pneumonia_bukan['Jumlah'];?></td>
                        <td align="right"><?php echo $ispa_1_4_Perempuan_pneumonia_bukan['Jumlah'];?></td>
                        <td align="right"><?php echo $ttl_pneumonia_bukan?></td>
                        <td align="center"><?php echo $nafas;?></td>
                        <td align="center">-</td>
                        <td align="center">-</td>
                        <td align="center">-</td>
                        <td align="center">-</td>
                        <td align="center">-</td>
                        <td align="center">-</td>
                        <td align="right"><?php echo $ispa_5_Laki_pneumonia_bukan['Jumlah'];?></td><!--ispa >5 tahun-->
                        <td align="right"><?php echo $ispa_5_Perempuan_pneumonia_bukan['Jumlah'];?></td>
                        <td align="right"><?php echo $ttl_5_pneumonia_bukan;?></td>
                        <td align="right"><?php echo $ispa_5_Laki_pneumonia['Jumlah'];?></td>
                        <td align="right"><?php echo $ispa_5_Perempuan_pneumonia['Jumlah'];?></td>
                        <td align="right"><?php echo $ttl_5_pneumonia;?></td>
                        <td align="center">-</td>
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