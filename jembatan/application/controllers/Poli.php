<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk API Poli dengan detail per hari
 * Endpoint: /index.php/poli/index/{kode_puskesmas}/{tahun}/{bulan}
 * Method: GET
 * 
 * Response format:
 * {
 *   "Response": {
 *     "POLI UMUM": {
 *       "1": 48,
 *       "2": 0,
 *       ...
 *       "30": 0,
 *       "total": 668
 *     },
 *     ...
 *   },
 *   "Pesan": {
 *     "Status": "Berhasil",
 *     "Kode": 200
 *   }
 * }
 */
class Poli extends REST_Controller {

	/**
	 * Get data poli dengan detail per hari
	 * 
	 * Parameter:
	 * - kode_puskesmas (required)
	 * - tahun (required)
	 * - bulan (required)
	 * 
	 * Query Parameter:
	 * - table_suffix (optional) - suffix nama tabel, jika tidak ada akan diambil dari nama puskesmas
	 */
	public function index_get(){
		try {
			// Tingkatkan execution time limit untuk menghindari timeout
			set_time_limit(120); // 2 menit
			
			// Cek koneksi database
			if (!$this->db->conn_id) {
				throw new Exception('Database connection failed');
			}
			
			$kode_puskesmas = $this->uri->segment(3);
			$tahun = $this->uri->segment(4);
			$bulan = $this->uri->segment(5);
			
			// Get table_suffix from query parameter or generate from puskesmas name
			$table_suffix = $this->input->get('table_suffix');
			
			// Validasi parameter
			if (empty($kode_puskesmas) || empty($tahun) || empty($bulan)) {
				$hasil['Pesan']['Status'] = 'Parameter tidak lengkap. Diperlukan: kode_puskesmas, tahun, dan bulan';
				$hasil['Pesan']['Kode'] = 400;
				$this->response($hasil, 400);
				return;
			}
			
			// Jika table_suffix tidak ada, ambil dari nama puskesmas
			if (empty($table_suffix)) {
				$query_puskesmas = $this->db->get_where('tbpuskesmas', array('KodePuskesmas' => $kode_puskesmas));
				if ($query_puskesmas && $query_puskesmas->num_rows() > 0) {
					$puskesmas = $query_puskesmas->row();
					$table_suffix = str_replace(' ', '', $puskesmas->NamaPuskesmas);
				} else {
					$hasil['Pesan']['Status'] = 'Puskesmas tidak ditemukan. Kode: ' . $kode_puskesmas . '. Pastikan kode puskesmas ada di tabel tbpuskesmas atau kirim parameter table_suffix via query string (?table_suffix=...)';
					$hasil['Pesan']['Kode'] = 404;
					$this->response($hasil, 404);
					return;
				}
			}
			
			// Nama tabel - escape untuk keamanan
			// Pastikan table_suffix sudah di-escape dengan benar
			$table_suffix_clean = $this->db->escape_str($table_suffix);
			$tbpasienrj = "tbpasienrj_" . $table_suffix_clean;
			
			// Log untuk debugging
			log_message('debug', 'Poli API - Kode: ' . $kode_puskesmas . ' | Table Suffix: ' . $table_suffix . ' | Table: ' . $tbpasienrj);
			
			// Cek apakah tabel ada - gunakan query yang lebih reliable
			$db_name = $this->db->database;
			$query_table = $this->db->query("SELECT COUNT(*) as cnt FROM information_schema.tables 
											  WHERE table_schema = " . $this->db->escape($db_name) . " 
											  AND table_name = " . $this->db->escape($tbpasienrj));
			
			$table_exists = false;
			if ($query_table && $query_table->num_rows() > 0) {
				$row = $query_table->row();
				$table_exists = ($row->cnt > 0);
			}
			
			if (!$table_exists) {
				// Coba lagi dengan SHOW TABLES sebagai fallback
				$query_table2 = $this->db->query("SHOW TABLES LIKE " . $this->db->escape($tbpasienrj));
				$table_exists = ($query_table2 && $query_table2->num_rows() > 0);
			}
			
			if (!$table_exists) {
				$hasil['Pesan']['Status'] = 'Tabel ' . $tbpasienrj . ' tidak ditemukan di database ' . $db_name;
				$hasil['Pesan']['Kode'] = 404;
				$hasil['Pesan']['Detail'] = array(
					'kode_puskesmas' => $kode_puskesmas,
					'table_suffix' => $table_suffix,
					'tbpasienrj' => $tbpasienrj,
					'database' => $db_name
				);
				$this->response($hasil, 404);
				return;
			}
			
			// Hitung jumlah hari dalam bulan
			$jumlah_hari = date('t', strtotime($tahun . '-' . $bulan . '-01'));
			
			// Ambil daftar pelayanan
			$query_pelayanan = $this->db->query("SELECT `Pelayanan` FROM `tbpelayanankesehatan` WHERE `JenisPelayanan` = 'Kunjungan Sakit' ORDER BY Pelayanan");
			
			if (!$query_pelayanan) {
				$db_error = $this->db->error();
				throw new Exception('Query Error (Pelayanan): ' . $db_error['message']);
			}
			
			$hasil['Response'] = array();
			
			// OPTIMASI: Gunakan satu query dengan GROUP BY untuk semua data sekaligus
			// Ini jauh lebih efisien daripada loop query
			$tanggal_awal = $tahun . '-' . $bulan . '-01';
			$tanggal_akhir = $tahun . '-' . $bulan . '-' . str_pad($jumlah_hari, 2, '0', STR_PAD_LEFT);
			
			// Query untuk mendapatkan semua data sekaligus dengan GROUP BY
			// Gunakan raw query dengan escape untuk keamanan
			$tanggal_awal_escaped = $this->db->escape($tanggal_awal);
			$tanggal_akhir_escaped = $this->db->escape($tanggal_akhir);
			
			// Cek apakah tabel benar-benar ada dan bisa diakses
			$check_table_query = $this->db->query("SHOW TABLES LIKE " . $this->db->escape($tbpasienrj));
			if (!$check_table_query || $check_table_query->num_rows() == 0) {
				throw new Exception('Tabel tidak ditemukan: ' . $tbpasienrj);
			}
			
			// Cek apakah ada data di periode tersebut
			$check_data = $this->db->query("SELECT COUNT(*) as total FROM `$tbpasienrj` 
											WHERE DATE(TanggalRegistrasi) >= $tanggal_awal_escaped 
											AND DATE(TanggalRegistrasi) <= $tanggal_akhir_escaped");
			if ($check_data === FALSE) {
				$db_error = $this->db->error();
				throw new Exception('Error checking data: ' . $db_error['message']);
			}
			
			$sql_all = "SELECT DAY(TanggalRegistrasi) as hari, PoliPertama, COUNT(IdPasienrj) AS jumlah 
						FROM `$tbpasienrj` 
						WHERE DATE(TanggalRegistrasi) >= $tanggal_awal_escaped 
						AND DATE(TanggalRegistrasi) <= $tanggal_akhir_escaped 
						AND PoliPertama IS NOT NULL 
						AND PoliPertama != '' 
						GROUP BY DAY(TanggalRegistrasi), PoliPertama";
			
			// Log query untuk debugging
			log_message('debug', 'Poli API Query: ' . $sql_all);
			log_message('debug', 'Poli API Table: ' . $tbpasienrj);
			
			$query_all = $this->db->query($sql_all);
			
			if ($query_all === FALSE) {
				$db_error = $this->db->error();
				$error_msg = 'Query Error (All Data): ' . $db_error['message'];
				$error_msg .= ' | Error Code: ' . $db_error['code'];
				$error_msg .= ' | SQL: ' . $sql_all;
				$error_msg .= ' | Table: ' . $tbpasienrj;
				log_message('error', $error_msg);
				throw new Exception($error_msg);
			}
			
			// Inisialisasi array untuk menyimpan data
			$data_all = array();
			foreach($query_pelayanan->result() as $pelayanan_row) {
				$pelayanan = $pelayanan_row->Pelayanan;
				if (!empty($pelayanan)) {
					$data_all[$pelayanan] = array();
					for($hari = 1; $hari <= $jumlah_hari; $hari++) {
						$data_all[$pelayanan][(string)$hari] = 0;
					}
					$data_all[$pelayanan]['total'] = 0;
				}
			}
			
			// Isi data dari hasil query
			$row_count = 0;
			foreach($query_all->result() as $row) {
				$row_count++;
				$hari = isset($row->hari) ? (string)(int)$row->hari : '0';
				$poli = isset($row->PoliPertama) ? trim($row->PoliPertama) : '';
				$jumlah = isset($row->jumlah) ? (int)$row->jumlah : 0;
				
				// Skip jika hari atau poli tidak valid
				if (empty($hari) || empty($poli)) {
					log_message('debug', 'Skipping invalid row - hari: ' . $hari . ', poli: ' . $poli);
					continue;
				}
				
				if (isset($data_all[$poli]) && isset($data_all[$poli][$hari])) {
					$data_all[$poli][$hari] = $jumlah;
					$data_all[$poli]['total'] += $jumlah;
				} else {
					// Log jika poli tidak ada di daftar pelayanan
					log_message('debug', 'Poli tidak ada di daftar: ' . $poli);
				}
			}
			
			log_message('debug', 'Poli API - Total rows processed: ' . $row_count);
			
			// Simpan ke response
			foreach($data_all as $pelayanan => $data_pelayanan) {
				$hasil['Response'][$pelayanan] = $data_pelayanan;
			}
			
			// OPTIMASI: Hitung total per hari dengan satu query GROUP BY
			// Gunakan raw query dengan escape untuk keamanan
			$sql_total_hari = "SELECT DAY(TanggalRegistrasi) as hari, COUNT(IdPasienrj) as Jumlah 
							   FROM `$tbpasienrj` 
							   WHERE DATE(TanggalRegistrasi) >= $tanggal_awal_escaped 
							   AND DATE(TanggalRegistrasi) <= $tanggal_akhir_escaped 
							   GROUP BY DAY(TanggalRegistrasi)";
			
			$query_total_hari_all = $this->db->query($sql_total_hari);
			
			if ($query_total_hari_all === FALSE) {
				$db_error = $this->db->error();
				throw new Exception('Query Error (Total Hari): ' . $db_error['message'] . ' | SQL: ' . $sql_total_hari . ' | Table: ' . $tbpasienrj);
			}
			
			// Inisialisasi total per hari
			$total_per_hari = array();
			for($hari = 1; $hari <= $jumlah_hari; $hari++) {
				$total_per_hari[(string)$hari] = 0;
			}
			
			// Isi data dari hasil query
			foreach($query_total_hari_all->result() as $row_total) {
				$hari = (string)(int)$row_total->hari;
				$total_per_hari[$hari] = (int)$row_total->Jumlah;
			}
			
			// Tambahkan total per hari ke response
			$hasil['Response']['_total_per_hari'] = $total_per_hari;
			$hasil['Response']['_total_semua'] = array_sum($total_per_hari);
			
			$hasil['Pesan']['Status'] = 'Berhasil';
			$hasil['Pesan']['Kode'] = 200;
			
			$this->response($hasil, 200);
			
		} catch (Exception $e) {
			log_message('error', 'Poli API Error: ' . $e->getMessage());
			log_message('error', 'Poli API Error - Kode: ' . $kode_puskesmas . ' | Tahun: ' . $tahun . ' | Bulan: ' . $bulan);
			
			$hasil['Pesan']['Status'] = 'Error: ' . $e->getMessage();
			$hasil['Pesan']['Kode'] = 500;
			$hasil['Response'] = null;
			
			// Selalu tampilkan detail error untuk debugging (tidak hanya development)
			$hasil['Pesan']['Detail'] = array(
				'file' => $e->getFile(),
				'line' => $e->getLine(),
				'kode_puskesmas' => isset($kode_puskesmas) ? $kode_puskesmas : 'N/A',
				'tahun' => isset($tahun) ? $tahun : 'N/A',
				'bulan' => isset($bulan) ? $bulan : 'N/A',
				'table_suffix' => isset($table_suffix) ? $table_suffix : 'N/A',
				'tbpasienrj' => isset($tbpasienrj) ? $tbpasienrj : 'N/A'
			);
			
			// Jika development, tambahkan stack trace
			if (ENVIRONMENT === 'development') {
				$hasil['Pesan']['Detail']['trace'] = $e->getTraceAsString();
			}
			
			$this->response($hasil, 500);
		}
	}
}
?>
