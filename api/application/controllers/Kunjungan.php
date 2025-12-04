<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk API Kunjungan dengan detail jenis kelamin dan jenis kunjungan
 * Endpoint: /index.php/kunjungan/index/{kode_puskesmas}/{tahun}/{bulan}
 * Method: GET
 */
class Kunjungan extends REST_Controller {

	/**
	 * Get kunjungan dengan detail jenis kelamin dan jenis kunjungan
	 * 
	 * Parameter:
	 * - kode_puskesmas (required)
	 * - tahun (required)
	 * - bulan (optional, jika tidak ada akan mengambil semua bulan)
	 * 
	 * Query Parameter:
	 * - table_suffix (optional) - suffix nama tabel, jika tidak ada akan diambil dari nama puskesmas
	 */
	public function index_get(){
		try {
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
			$tbpasienrj = "tbpasienrj_" . $table_suffix;
			
			// Cek apakah tabel ada
			$query_table = $this->db->query("SHOW TABLES LIKE '$tbpasienrj'");
			$table_exists = ($query_table && $query_table->num_rows() > 0);
			if (!$table_exists) {
				$hasil['Pesan']['Status'] = 'Tabel ' . $tbpasienrj . ' tidak ditemukan';
				$hasil['Pesan']['Kode'] = 404;
				$this->response($hasil, 404);
				return;
			}
			
			// Build kondisi waktu
			$waktu = "YEAR(TanggalRegistrasi) = '$tahun'";
			if (!empty($bulan) && $bulan != 'Semua') {
				$waktu .= " AND MONTH(TanggalRegistrasi) = '$bulan'";
			}
			
			// Inisialisasi variabel
			$jml_l_rajal = 0;
			$jml_p_rajal = 0;
			$jml_l_ranap = 0;
			$jml_p_ranap = 0;
			
			// Query untuk Rawat Jalan Laki-laki
			$query_l_rajal = $this->db->query("SELECT COUNT(IdPasienrj) AS Jml FROM `$tbpasienrj` WHERE $waktu AND JenisKelamin = 'L' AND `JenisKunjungan`='1'");
			if ($query_l_rajal === FALSE) {
				$db_error = $this->db->error();
				throw new Exception('Query Error (L Rajal): ' . $db_error['message']);
			}
			$row = $query_l_rajal->row();
			$jml_l_rajal = isset($row->Jml) ? (int)$row->Jml : 0;
			
			// Query untuk Rawat Jalan Perempuan
			$query_p_rajal = $this->db->query("SELECT COUNT(IdPasienrj) AS Jml FROM `$tbpasienrj` WHERE $waktu AND JenisKelamin = 'P' AND `JenisKunjungan`='1'");
			if ($query_p_rajal === FALSE) {
				$db_error = $this->db->error();
				throw new Exception('Query Error (P Rajal): ' . $db_error['message']);
			}
			$row = $query_p_rajal->row();
			$jml_p_rajal = isset($row->Jml) ? (int)$row->Jml : 0;
			
			// Query untuk Rawat Inap Laki-laki
			$query_l_ranap = $this->db->query("SELECT COUNT(IdPasienrj) AS Jml FROM `$tbpasienrj` WHERE $waktu AND JenisKelamin = 'L' AND `JenisKunjungan`='2'");
			if ($query_l_ranap === FALSE) {
				$db_error = $this->db->error();
				throw new Exception('Query Error (L Ranap): ' . $db_error['message']);
			}
			$row = $query_l_ranap->row();
			$jml_l_ranap = isset($row->Jml) ? (int)$row->Jml : 0;
			
			// Query untuk Rawat Inap Perempuan
			$query_p_ranap = $this->db->query("SELECT COUNT(IdPasienrj) AS Jml FROM `$tbpasienrj` WHERE $waktu AND JenisKelamin = 'P' AND `JenisKunjungan`='2'");
			if ($query_p_ranap === FALSE) {
				$db_error = $this->db->error();
				throw new Exception('Query Error (P Ranap): ' . $db_error['message']);
			}
			$row = $query_p_ranap->row();
			$jml_p_ranap = isset($row->Jml) ? (int)$row->Jml : 0;
			
			// Total
			$total = $jml_l_rajal + $jml_p_rajal + $jml_l_ranap + $jml_p_ranap;
			
			// Response
			$hasil['Response'] = array(
				'kode_puskesmas' => $kode_puskesmas,
				'tahun' => $tahun,
				'bulan' => (!empty($bulan)) ? $bulan : 'Semua',
				'table_suffix' => $table_suffix,
				'rawat_jalan' => array(
					'laki_laki' => $jml_l_rajal,
					'perempuan' => $jml_p_rajal,
					'total' => ($jml_l_rajal + $jml_p_rajal)
				),
				'rawat_inap' => array(
					'laki_laki' => $jml_l_ranap,
					'perempuan' => $jml_p_ranap,
					'total' => ($jml_l_ranap + $jml_p_ranap)
				),
				'total_kunjungan' => $total
			);
			
			$hasil['Pesan']['Status'] = 'Berhasil';
			$hasil['Pesan']['Kode'] = 200;
			
			$this->response($hasil, 200);
			
		} catch (Exception $e) {
			// Log error untuk debugging
			log_message('error', 'Kunjungan API Error: ' . $e->getMessage());
			
			$hasil['Pesan']['Status'] = 'Error: ' . $e->getMessage();
			$hasil['Pesan']['Kode'] = 500;
			$hasil['Response'] = null;
			
			// Jika development, tampilkan detail error
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

