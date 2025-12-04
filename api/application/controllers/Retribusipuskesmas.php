<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk API Retribusi Puskesmas
 * Endpoint: /index.php/retribusipuskesmas/index/{kode_puskesmas}/{tahun}
 * Method: GET
 * 
 * Response format:
 * {
 *   "Response": {
 *     "01": {
 *       "KARCIS": 700000,
 *       "TINDAKAN": 500000
 *     },
 *     ...
 *   },
 *   "Pesan": {
 *     "Status": "Berhasil",
 *     "Kode": 200
 *   }
 * }
 */
class Retribusipuskesmas extends REST_Controller {

	/**
	 * Get retribusi per puskesmas per tahun (dengan detail per bulan)
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
			$table_suffix_clean = $this->db->escape_str($table_suffix);
			$tbpasienrj = "tbpasienrj_" . $table_suffix_clean;
			$tbtindakanpasien = "tbtindakanpasien_" . $table_suffix_clean;
			
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
			
			$hasil['Response'] = array();
			
			// Loop untuk setiap bulan (01-12)
			for($bulan = 1; $bulan <= 12; $bulan++){
				$bulan_str = str_pad($bulan, 2, '0', STR_PAD_LEFT);
				$hasil['Response'][$bulan_str] = array();
				
				// KARCIS: COUNT dari tbpasienrj dengan Asuransi='UMUM' * 7000
				$query_karcis = $this->db->query("SELECT COUNT(IdPasienrj) AS Jml 
												   FROM `$tbpasienrj` 
												   WHERE YEAR(TanggalRegistrasi) = " . $this->db->escape($tahun) . " 
												   AND MONTH(TanggalRegistrasi) = " . $this->db->escape($bulan_str) . " 
												   AND `Asuransi` = 'UMUM'");
				
				if ($query_karcis === FALSE) {
					$db_error = $this->db->error();
					throw new Exception('Query Error (Karcis): ' . $db_error['message']);
				}
				
				$row_karcis = $query_karcis->row();
				$jml_karcis = isset($row_karcis->Jml) ? (int)$row_karcis->Jml : 0;
				$hasil['Response'][$bulan_str]['KARCIS'] = $jml_karcis * 7000;
				
				// TINDAKAN: SUM dari tbtindakanpasien dengan CaraBayar='UMUM'
				// Cek apakah tabel tbtindakanpasien ada
				$query_table_tindakan = $this->db->query("SELECT COUNT(*) as cnt FROM information_schema.tables 
														   WHERE table_schema = " . $this->db->escape($db_name) . " 
														   AND table_name = " . $this->db->escape($tbtindakanpasien));
				
				$table_tindakan_exists = false;
				if ($query_table_tindakan && $query_table_tindakan->num_rows() > 0) {
					$row_tindakan = $query_table_tindakan->row();
					$table_tindakan_exists = ($row_tindakan->cnt > 0);
				}
				
				if (!$table_tindakan_exists) {
					$query_table_tindakan2 = $this->db->query("SHOW TABLES LIKE " . $this->db->escape($tbtindakanpasien));
					$table_tindakan_exists = ($query_table_tindakan2 && $query_table_tindakan2->num_rows() > 0);
				}
				
				if ($table_tindakan_exists) {
					$query_tindakan = $this->db->query("SELECT SUM(Tarif) AS Jml 
														FROM `$tbtindakanpasien` 
														WHERE YEAR(TanggalTindakan) = " . $this->db->escape($tahun) . " 
														AND MONTH(TanggalTindakan) = " . $this->db->escape($bulan_str) . " 
														AND `CaraBayar` = 'UMUM'");
					
					if ($query_tindakan === FALSE) {
						$db_error = $this->db->error();
						throw new Exception('Query Error (Tindakan): ' . $db_error['message']);
					}
					
					$row_tindakan = $query_tindakan->row();
					$jml_tindakan = isset($row_tindakan->Jml) ? (float)$row_tindakan->Jml : 0;
					$hasil['Response'][$bulan_str]['TINDAKAN'] = round($jml_tindakan, 0);
				} else {
					$hasil['Response'][$bulan_str]['TINDAKAN'] = 0;
				}
			}
			
			$hasil['Pesan']['Status'] = 'Berhasil';
			$hasil['Pesan']['Kode'] = 200;
			
			$this->response($hasil, 200);
			
		} catch (Exception $e) {
			log_message('error', 'Retribusipuskesmas API Error: ' . $e->getMessage());
			
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
