<?php
	session_start();
	include "config/koneksi.php";
	include "config/helper_bpjs_v4.php";
	$no = $_POST['no'];
	$data_bpjs = get_data_peserta_bpjs($no);
	$dbpjs = json_decode($data_bpjs,True);
	// echo $data_bpjs;
	
	if ($dbpjs['metaData']['code'] == 500 || $dbpjs['metaData']['code'] == 401 || $dbpjs['metaData']['code'] == 408 || $dbpjs['metaData']['code'] == 424 || $dbpjs['metaData']['code'] == 204){	
?>		
		<div class="col-sm-12">
			<div class="alert alert-danger"><strong>Data tidak ditemukan : </strong><br/>- Cek ulang No BPJS <br/> - Pastikan sudah update Password BPJS maksimal 2(dua) Bulan Sekali</div>
		</div>
<?php		
	die();
	}	
?>	
<table class="table">
	<tr>
        <td class="col-sm-3">No.Kartu BPJS</td>
        <td class="col-sm-9"><?php echo $dbpjs['response']['noKartu'];?></td>
    </tr>
    <tr>
        <td>Nama</td>
        <td><?php echo $dbpjs['response']['nama'];?></td>
    </tr>
	<tr>
        <td>Status Peserta</td>
        <td><?php echo strtoupper($dbpjs['response']['hubunganKeluarga']);?></td>
    </tr>
	<tr>
        <td>Jenis Peserta</td>
        <td><?php echo $dbpjs['response']['jnsPeserta']['nama'];?></td>
    </tr>
	<tr>
        <td>Tanggal Lahir</td>
        <td><?php echo $dbpjs['response']['tglLahir'];?></td>
    </tr>
	<tr>
        <td>Kelamin</td>
        <td><?php echo $dbpjs['response']['sex'];?></td>
    </tr>
	<tr>
        <td>PPK Umum</td>
        <td>
			<?php 								
				$kdprovider = $dbpjs['response']['kdProviderPst']['kdProvider'];
				$nmprovider = $dbpjs['response']['kdProviderPst']['nmProvider'];
				$sskdprovider = $_SESSION['kodeppk'];
				if($kdprovider == $sskdprovider){
					echo $kdprovider." - ".$nmprovider;
				}else{
					echo "<span style='color:red'>".$kdprovider." - ".$nmprovider."</span>";
				}
			?>
		</td>
    </tr>
</table>