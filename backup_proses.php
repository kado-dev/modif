<?php
	ini_set('memory_limit', '4095M');
	error_reporting(0);
	//ini_set('memory_limit', '-1');
	session_start();
	$kodepuskesmas = $_SESSION['kodepuskesmas'];
	include "config/koneksi.php";
	
	// tbbackup_puskesmas
	$waktu = date('Y-m-d G:i:s');
	$namapegawai = $_SESSION['username'];
	$deskripsi = implode(",",$_POST['tbls']);

	if($_POST['stsdown'] == null){
		$str = "INSERT INTO `tbbackup_puskesmas`(`Waktu`, `KodePuskesmas`, `Deskripsi`, `Petugas`)
		VALUES ('$waktu','$kodepuskesmas','$deskripsi','$namapegawai')";
		$query=mysqli_query($koneksi,$str);
	}
	
	
    $backupAlert = '';
    $backup_file = '';
    $dbname = "dbsimpus";
    $tables = $_POST['tbls'];
	$return = '';
	foreach ($tables as $table) {
		$return .= '---';
		$return .= "\n";
		$return .= '------------------ TABLE: ' . $table . ' ------------------';
		$return .= "\n";
		$return .= '---';
		$return .= "\n\n";
		$result = mysqli_query($koneksi, "SELECT * FROM " . $table );//. " WHERE SUBSTRING(`NoIndex`,3,11)='$kodepuskesmas'"
		if (!$result) {
			$backupAlert = 'Error found.<br/>ERROR : ' . mysqli_error($koneksi) . 'ERROR NO :' . mysqli_errno($koneksi);
		} else {
			$num_fields = mysqli_num_fields($result);
			if (!$num_fields) {
				$backupAlert = 'Error found.<br/>ERROR : ' . mysqli_error($koneksi) . 'ERROR NO :' . mysqli_errno($koneksi);
			} else {
				$return .= 'DROP TABLE ' . $table . ';';
				$row2 = mysqli_fetch_row(mysqli_query($koneksi, 'SHOW CREATE TABLE ' . $table));
				if (!$row2) {
					$backupAlert = 'Error found.<br/>ERROR : ' . mysqli_error($koneksi) . 'ERROR NO :' . mysqli_errno($koneksi);
				} else {
					$return .= "\n\n" . $row2[1] . ";\n\n";
					for ($i = 0; $i < $num_fields; $i++) {
						while ($row = mysqli_fetch_row($result)) {
							$return .= 'INSERT INTO ' . $table . ' VALUES(';
							for ($j = 0; $j < $num_fields; $j++) {
								$row[$j] = addslashes($row[$j]);
								if (isset($row[$j])) {
									$return .= '"' . $row[$j] . '"';
								} else {
									$return .= '""';
								}
								if ($j < $num_fields - 1) {
									$return .= ',';
								}
							}
							$return .= ");\n";
						}
					}
					$return .= "\n\n\n";
				}

				$backupAlert = 'sukses';

			}
		}
	}
	
	if($_POST['stsdown'] == null){
		$backup_file = 'backup/'.$kodepuskesmas."_".$dbname . date('dmyhis') . '.sql';
		$handle = fopen("{$backup_file}", 'w+');
		fwrite($handle, $return);
		fclose($handle);

		//Download the SQL backup file to the browser
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . basename($backup_file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($backup_file));
		ob_clean();
		flush();
		readfile($backup_file);
		exec('rm ' . $backup_file); 
	}
	$dt['alert'] = $backupAlert;
	$dt['file'] = $backup_file;
	echo json_encode($dt);

?>