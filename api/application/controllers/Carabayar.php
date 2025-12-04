<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk API Cara Bayar
 * Endpoint: /index.php/carabayar/index/{kode_puskesmas}/{tahun}
 * Method: GET
 * 
 * Response format:
 * {
 *   "Response": {
 *     "01": {
 *       "UMUM": 100,
 *       "BPJS": 50,
 *       "GRATIS": 20,
 *       "SKTM": 5
 *     },
 *     ...
 *   },
 *   "Pesan": {
 *     "Status": "Berhasil",
 *     "Kode": 200
 *   }
 * }
 */
class Carabayar extends REST_Controller {

	/**
	 * Get cara bayar per puskesmas per tahun (dengan detail per bulan)
	 * 
	 * Parameter:
	 * - kode_puskesmas (required)
	 * - tahun (required)
	 * 
	 * Query Parameter:
	 * - table_suffix (optional) - suffix nama tabel, jika tidak ada akan diambil dari nama puskesmas
	 */
	public function index_get(){
		try {
			set_time_limit(120); // 2 menit
			
			// Cek koneksi database
			if (!$this->db->conn_id) {
				throw new Exception('Database connection failed');
			}
			
			$kode_puskesmas = $this->uri->segment(3);
			$tahun = $this->uri->segment(4);
			
			// Get table_suffix from query parameter or generate from puskesmas name
			$table_suffix = $this->input->get('table_suffix');
			
			// Validasi parameter
			if (empty($kode_puskesmas) || empty($tahun)) {
				$hasil['Pesan']['Status'] = 'Parameter tidak lengkap. Diperlukan: kode_puskesmas dan tahun';
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
			
			// Nama tabel
			$tbpasienrj = "tbpasienrj_" . $this->db->escape_str($table_suffix);
			
			// Cek apakah tabel ada
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
				$query_table2 = $this->db->query("SHOW TABLES LIKE " . $this->db->escape($tbpasienrj));
				$table_exists = ($query_table2 && $query_table2->num_rows() > 0);
			}
			
			if (!$table_exists) {
				$hasil['Pesan']['Status'] = 'Tabel ' . $tbpasienrj . ' tidak ditemukan di database ' . $db_name;
				$hasil['Pesan']['Kode'] = 404;
				$this->response($hasil, 404);
				return;
			}
			
			// Ambil daftar cara bayar dari tbasuransi
			$query_asuransi = $this->db->query("SELECT * FROM tbasuransi ORDER BY Asuransi");
			if ($query_asuransi === FALSE) {
				$db_error = $this->db->error();
				throw new Exception('Query Error (Asuransi): ' . $db_error['message']);
			}
			
			$hasil['Response'] = array();
			
			// Loop untuk setiap bulan (01-12)
			for($bulan = 1; $bulan <= 12; $bulan++){
				$bulan_str = str_pad($bulan, 2, '0', STR_PAD_LEFT);
				$hasil['Response'][$bulan_str] = array();
				
				// Inisialisasi BPJS (gabungan BPJS PBI + BPJS NON PBI)
				$hasil['Response'][$bulan_str]['BPJS'] = 0;
				
				// Loop untuk setiap cara bayar
				foreach($query_asuransi->result() as $asuransi_row){
					$asuransi = $asuransi_row->Asuransi;
					
					// Query untuk menghitung jumlah berdasarkan cara bayar
					// BPJS PBI dan BPJS NON PBI digabungkan menjadi "BPJS"
					if($asuransi == 'BPJS PBI' || $asuransi == 'BPJS NON PBI'){
						// Untuk BPJS, gabungkan kedua jenis
						$query = $this->db->query("SELECT COUNT(IdPasienrj) AS Jumlah 
													FROM `$tbpasienrj` 
													WHERE YEAR(TanggalRegistrasi) = " . $this->db->escape($tahun) . " 
													AND MONTH(TanggalRegistrasi) = " . $this->db->escape($bulan_str) . " 
													AND (`Asuransi` = " . $this->db->escape($asuransi) . ")");
						
						if ($query === FALSE) {
							$db_error = $this->db->error();
							throw new Exception('Query Error (Cara Bayar): ' . $db_error['message']);
						}
						
						$row = $query->row();
						$jumlah = isset($row->Jumlah) ? (int)$row->Jumlah : 0;
						
						// Gabungkan ke BPJS
						$hasil['Response'][$bulan_str]['BPJS'] += $jumlah;
					} else {
						// Untuk cara bayar lainnya (UMUM, GRATIS, SKTM)
						$query = $this->db->query("SELECT COUNT(IdPasienrj) AS Jumlah 
													FROM `$tbpasienrj` 
													WHERE YEAR(TanggalRegistrasi) = " . $this->db->escape($tahun) . " 
													AND MONTH(TanggalRegistrasi) = " . $this->db->escape($bulan_str) . " 
													AND `Asuransi` = " . $this->db->escape($asuransi));
						
						if ($query === FALSE) {
							$db_error = $this->db->error();
							throw new Exception('Query Error (Cara Bayar): ' . $db_error['message']);
						}
						
						$row = $query->row();
						$jumlah = isset($row->Jumlah) ? (int)$row->Jumlah : 0;
						
						$hasil['Response'][$bulan_str][$asuransi] = $jumlah;
					}
				}
			}
			
			$hasil['Pesan']['Status'] = 'Berhasil';
			$hasil['Pesan']['Kode'] = 200;
			
			$this->response($hasil, 200);
			
		} catch (Exception $e) {
			log_message('error', 'Carabayar API Error: ' . $e->getMessage());
			
			$hasil['Pesan']['Status'] = 'Error: ' . $e->getMessage();
			$hasil['Pesan']['Kode'] = 500;
			$hasil['Response'] = null;
			
			if (ENVIRONMENT === 'development') {
				$hasil['Pesan']['Detail'] = array(
					'file' => $e->getFile(),
					'line' => $e->getLine(),
					'trace' => $e->getTraceAsString()
				);
			}
			$this->response($hasil, 500);
		}
	}
}
?>
