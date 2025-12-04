<!--<div class="tableborderdiv">-->
<?php
	// waktu
	$bulan = date('m');
	$tahun = date('Y');
	$tanggalso = date('Y-m-d');
	$kodefaskes = $_SESSION['kodefaskes'];
	$namafaskes = $_SESSION['namafaskes'];
	
		// menentukan dashboard dinkes atau puskesmas
		if($kodepuskesmas == '-'){
			// include "config/helper_bpjs.php";
			include "dashboard_dinkes.php";
		}else if($_SESSION['namapuskesmas'] == 'UPTD FARMASI'){ 
			include "dashboard_uptd_obat.php";

			// jika bulan januari maka manggil data bulan 12 tahun sebelumnya
			if ($bulan == "01"){	
				$bulansebelumnya = "12";
				$tahun = $tahun - 1;
			}else{
				$bulansebelumnya = $bulan - 1;		
			}
			
			if(strlen($bulansebelumnya) == 1){
				$bulansebelumnya = '0'.$bulansebelumnya;
			}
			
			// cek data gudang besar
			$cek_data_obat_gb = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbstokbulanangudangbsr` WHERE `Bulan` = '$bulan' AND `Tahun` = '$tahun'"));
			if($cek_data_obat_gb == 0){
				//insert ke tbstokbulanangudangbsr, yang stoknya lebih dari 0
				$dtgfk = mysqli_query($koneksi,"SELECT KodeBarang, Stok FROM `tbgfkstok` WHERE (SumberAnggaran LIKE '%APBD%' OR SumberAnggaran = 'APBN') AND Stok > 0");
				while($dtg = mysqli_fetch_assoc($dtgfk)){
					$qry_v[] = "('$bulan','$tahun','$dtg[KodeBarang]','$dtg[Stok]')";
				}
				$qry = "INSERT INTO `tbstokbulanangudangbsr`(`Bulan`, `Tahun`, `KodeBarang`, `Stok`) VALUES ".implode(",",$qry_v);
				mysqli_query($koneksi,$qry);
			}
			
			// cek data tbstokbulanandinas, (yang disimpan adalah StokAwalSistem, klo stok biarkan user mengisikan)
			$cekstokbulanandinas = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tbstokbulanandinas` WHERE `Bulan`='$bulansebelumnya' AND `Tahun`='$tahun'"));
			if($cekstokbulanandinas == 0){	
				// insert ke tbstokbulanandinas
				$dtob = mysqli_query($koneksi,"SELECT `KodeBarang`,`NamaBarang`,`NamaProgram`,`NoBatch`,`Stok` FROM `tbgfkstok`");
				while($dtobatdinkes = mysqli_fetch_assoc($dtob)){
					$qry_ob[] = "('$bulansebelumnya','$tahun','$dtobatdinkes[KodeBarang]','$dtobatdinkes[NamaBarang]','$dtobatdinkes[NamaProgram]','$dtobatdinkes[NoBatch]','$dtobatdinkes[Stok]','Dibuat oleh system','$tanggalso')";
				}
				$qryp = "INSERT INTO `tbstokbulanandinas`(`Bulan`,`Tahun`,`KodeBarang`,`NamaBarang`,`NamaProgram`,`NoBatch`,`StokAwalSistem`,`Keterangan`,`TanggalSo`) VALUES ".implode(",",$qry_ob);
				mysqli_query($koneksi,$qryp);
			}
			
		}else if($_SESSION['otoritas'] == 'APOTEK'){
			include "dashboard_puskesmas_farmasi.php";
		}else{
			include "registrasi_form.php";
		}
	
?>
<!--</div>-->