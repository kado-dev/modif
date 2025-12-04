<?php
	$id = $_GET['id'];
	$nf = $_GET['nf'];
	
	// cek apakah sudah divalidasi oleh puskesmas, jika sudah divalidasi faktur tifdak dapat dihapus
	// $str_cek = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT StatusValidasi FROM `tbgudangpkmpenerimaan` WHERE `NoFaktur`='$nf'"));	
	// if($str_cek['StatusValidasi'] == 'Belum'){
		$qry = mysqli_query($koneksi,"SELECT * FROM `tbgfk_vaksin_pengeluarandetail` WHERE `NoFaktur`='$nf'");
		while($obatdetail = mysqli_fetch_assoc($qry)){
			$kdbarang = $obatdetail['KodeBarang'];
			$nobatch = $obatdetail['NoBatch'];
			$jml = $obatdetail['Jumlah'];
			
			// mengembalikan stok ke tbgfk_vaksin_stok
			$getstok = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT `Stok` FROM `tbgfk_vaksin_stok` WHERE KodeBarang = '$kdbarang' AND NoBatch='$nobatch'"));
			$stok = $getstok['Stok'] + $jml;		
			$update = mysqli_query($koneksi,"UPDATE `tbgfk_vaksin_stok` SET `Stok`='$stok' WHERE KodeBarang = '$kdbarang' AND NoBatch='$nobatch'");
		}

		$str = "DELETE FROM `tbgfk_vaksin_pengeluaran` WHERE `NoFaktur`='$nf'";
		$query = mysqli_query($koneksi,$str);
		
		// hapus penerimaan puskesmas
		// $str_penerimaan = "DELETE FROM `tbgudangpkmpenerimaan` WHERE `NoFaktur`='$nf'";
		// mysqli_query($koneksi,$str_penerimaan);		
		// $str_penerimaan_dtl = "DELETE FROM `tbgudangpkmpenerimaandetail` WHERE `NoFaktur`='$nf'";
		// mysqli_query($koneksi,$str_penerimaan_dtl);
		
	// }else{
		// echo "<script>";
		// echo "alert('Data tidak dapat dihapus, karena sudah divalidasi...');";
		// echo "document.location.href='?page=gudang_vaksin_pengeluaran';";
		// echo "</script>";
	// }
	
	if($query){
		mysqli_query($koneksi,"DELETE FROM `tbgfk_vaksin_pengeluarandetail` WHERE `NoFaktur`='$nf'");
		echo "<script>";
		echo "alert('Data berhasil dihapus');";
		echo "document.location.href='?page=gudang_vaksin_pengeluaran';";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('Data gagal dihapus');";
		echo "document.location.href='?page=gudang_vaksin_pengeluaran';";
		echo "</script>";
	} 	
?>