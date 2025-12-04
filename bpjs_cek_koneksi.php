<?php
include "config/helper_bpjs_v4.php";

$status_koneksi = "";
$pesan_koneksi = "";
$detail_response = "";

// Test koneksi dengan mengambil data poli
if(isset($_POST['test_koneksi'])){
	$start_time = microtime(true);
	
	try {
		// Test koneksi dengan fungsi get_data_poli
		$response = get_data_poli();
		$end_time = microtime(true);
		$response_time = round(($end_time - $start_time) * 1000, 2); // dalam milliseconds
		
		$response_data = json_decode($response, true);
		
		if($response_data && isset($response_data['metaData'])){
			$metaData = $response_data['metaData'];
			$code = isset($metaData['code']) ? $metaData['code'] : '';
			$message = isset($metaData['message']) ? $metaData['message'] : '';
			
			if($code == '200'){
				$status_koneksi = "success";
				$pesan_koneksi = "Koneksi ke API BPJS berhasil!";
				$detail_response = "Response Code: " . $code . "<br>Message: " . $message . "<br>Response Time: " . $response_time . " ms";
			} else {
				$status_koneksi = "warning";
				$pesan_koneksi = "Koneksi berhasil tetapi ada peringatan";
				$detail_response = "Response Code: " . $code . "<br>Message: " . $message . "<br>Response Time: " . $response_time . " ms";
			}
		} else {
			$status_koneksi = "error";
			$pesan_koneksi = "Format response tidak valid";
			$detail_response = "Response: " . htmlspecialchars(substr($response, 0, 500));
		}
	} catch (Exception $e) {
		$status_koneksi = "error";
		$pesan_koneksi = "Error: " . $e->getMessage();
		$detail_response = "Terjadi kesalahan saat menghubungi API BPJS";
	}
}
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-sm-12">
			<h3 class="judul"><b>CEK KONEKSI API BPJS</b></h3>
			
			<?php if($status_koneksi): ?>
				<div class="alert alert-<?php echo $status_koneksi == 'success' ? 'success' : ($status_koneksi == 'warning' ? 'warning' : 'danger'); ?> alert-dismissible fade show" role="alert">
					<strong><?php echo $pesan_koneksi; ?></strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<?php if($detail_response): ?>
						<hr>
						<p class="mb-0" style="font-size: 12px;"><?php echo $detail_response; ?></p>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Informasi Koneksi</h5>
					<p class="card-text">
						Halaman ini digunakan untuk mengecek koneksi ke API BPJS Kesehatan.
						Klik tombol di bawah untuk melakukan test koneksi.
					</p>
					
					<form method="POST" action="">
						<button type="submit" name="test_koneksi" class="btn btn-primary">
							<i class="fa fa-plug"></i> Test Koneksi API BPJS
						</button>
					</form>
				</div>
			</div>
			
			<div class="card mt-3">
				<div class="card-body">
					<h5 class="card-title">Detail Konfigurasi</h5>
					<?php
					$kode = $_SESSION['kodepuskesmas'];
					$qr = mysqli_query($koneksi,"SELECT * FROM tbpuskesmasdetail where KodePuskesmas = '$kode'");
					if(mysqli_num_rows($qr) > 0){
						$getuserpass = mysqli_fetch_assoc($qr);
					?>
						<table class="table table-bordered table-sm">
							<tr>
								<td width="30%"><strong>Kode Puskesmas</strong></td>
								<td><?php echo $kode; ?></td>
							</tr>
							<tr>
								<td><strong>Username</strong></td>
								<td><?php echo isset($getuserpass['Username']) ? $getuserpass['Username'] : '-'; ?></td>
							</tr>
							<tr>
								<td><strong>Cons ID</strong></td>
								<td><?php echo isset($getuserpass['ConsId']) ? $getuserpass['ConsId'] : '-'; ?></td>
							</tr>
							<tr>
								<td><strong>API URL</strong></td>
								<td>https://apijkn.bpjs-kesehatan.go.id/pcare-rest/</td>
							</tr>
						</table>
					<?php
					} else {
						echo "<div class='alert alert-warning'>Data konfigurasi puskesmas tidak ditemukan</div>";
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>

