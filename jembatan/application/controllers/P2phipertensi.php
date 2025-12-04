<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller untuk API P2P Hipertensi & DM
 * Endpoint: /index.php/p2phipertensi/index/{kode_puskesmas}/{tahun}/{bulan}
 * Method: GET
 * 
 * Mengembalikan data kasus Hipertensi (I10, I15) per golongan umur dan jenis kelamin
 */
class P2phipertensi extends REST_Controller {

	public function index_get(){
		try {
			set_time_limit(120);
			
			if (!$this->db->conn_id) {
				throw new Exception('Database connection failed');
			}
			
			$kode_puskesmas = $this->uri->segment(3);
			$tahun = $this->uri->segment(4);
			$bulan = $this->uri->segment(5);
			$table_suffix = $this->input->get('table_suffix');
			
			if (empty($kode_puskesmas) || empty($tahun)) {
				$this->response([
					'Pesan' => [
						'Status' => 'Parameter tidak lengkap. Diperlukan: kode_puskesmas dan tahun',
						'Kode' => 400
					]
				], 400);
				return;
			}
			
			if (empty($table_suffix)) {
				$query_puskesmas = $this->db->get_where('tbpuskesmas', array('KodePuskesmas' => $kode_puskesmas));
				if ($query_puskesmas && $query_puskesmas->num_rows() > 0) {
					$puskesmas = $query_puskesmas->row();
					$table_suffix = str_replace(' ', '', $puskesmas->NamaPuskesmas);
				} else {
					$this->response([
						'Pesan' => [
							'Status' => 'Puskesmas tidak ditemukan. Kode: ' . $kode_puskesmas,
							'Kode' => 404
						]
					], 404);
					return;
				}
			}
			
			$tbdiagnosapasien = "tbdiagnosapasien_" . $this->db->escape_str($table_suffix);
			$db_name = $this->db->database;
			$query_table = $this->db->query("SELECT COUNT(*) as cnt FROM information_schema.tables WHERE table_schema = " . $this->db->escape($db_name) . " AND table_name = " . $this->db->escape($tbdiagnosapasien));
			$table_exists = ($query_table && $query_table->num_rows() > 0 && $query_table->row()->cnt > 0);
			
			if (!$table_exists) {
				$this->response([
					'Pesan' => [
						'Status' => 'Tabel ' . $tbdiagnosapasien . ' tidak ditemukan di database ' . $db_name,
						'Kode' => 404
					]
				], 404);
				return;
			}
			
			if ($bulan == 'Semua' || empty($bulan)) {
				$waktu = "YEAR(TanggalDiagnosa) = " . $this->db->escape($tahun);
			} else {
				$waktu = "YEAR(TanggalDiagnosa) = " . $this->db->escape($tahun) . " AND MONTH(TanggalDiagnosa) = " . $this->db->escape($bulan);
			}
			
			$kodedgs = " AND (`KodeDiagnosa` like '%I10%' OR `KodeDiagnosa` like '%I15%')";
			
			// Query untuk setiap golongan umur
			$umur17hrL = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between 1 AND 7 AND JenisKelamin = 'L' AND Kasus = 'Baru'");
			$umur17hrP = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between 1 AND 7 AND JenisKelamin = 'P' AND Kasus = 'Baru'");
			$umur1830hrL = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between 8 AND 30 AND JenisKelamin = 'L' AND Kasus = 'Baru'");
			$umur1830hrP = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun = '0' AND UmurBulan = '0' AND UmurHari Between 8 AND 30 AND JenisKelamin = 'P' AND Kasus = 'Baru'");
			$umur12blnL = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun = '0' AND UmurBulan Between 2 AND 12 AND JenisKelamin = 'L' AND Kasus = 'Baru'");
			$umur12blnP = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun = '0' AND UmurBulan Between 2 AND 12 AND JenisKelamin = 'P' AND Kasus = 'Baru'");
			$umur14L = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 1 AND 4 AND JenisKelamin = 'L' AND Kasus = 'Baru'");
			$umur14P = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 1 AND 4 AND JenisKelamin = 'P' AND Kasus = 'Baru'");
			$umur59L = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 5 AND 9 AND JenisKelamin = 'L' AND Kasus = 'Baru'");
			$umur59P = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 5 AND 9 AND JenisKelamin = 'P' AND Kasus = 'Baru'");
			$umur1014L = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 10 AND 14 AND JenisKelamin = 'L' AND Kasus = 'Baru'");
			$umur1014P = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 10 AND 14 AND JenisKelamin = 'P' AND Kasus = 'Baru'");
			$umur1519L = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 15 AND 19 AND JenisKelamin = 'L' AND Kasus = 'Baru'");
			$umur1519P = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 15 AND 19 AND JenisKelamin = 'P' AND Kasus = 'Baru'");
			$umur2044L = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 20 AND 44 AND JenisKelamin = 'L' AND Kasus = 'Baru'");
			$umur2044P = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 20 AND 44 AND JenisKelamin = 'P' AND Kasus = 'Baru'");
			$umur4554L = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 45 AND 54 AND JenisKelamin = 'L' AND Kasus = 'Baru'");
			$umur4554P = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 45 AND 54 AND JenisKelamin = 'P' AND Kasus = 'Baru'");
			$umur5559L = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 55 AND 59 AND JenisKelamin = 'L' AND Kasus = 'Baru'");
			$umur5559P = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 55 AND 59 AND JenisKelamin = 'P' AND Kasus = 'Baru'");
			$umur6069L = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 60 AND 69 AND JenisKelamin = 'L' AND Kasus = 'Baru'");
			$umur6069P = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 60 AND 69 AND JenisKelamin = 'P' AND Kasus = 'Baru'");
			$umur70100L = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 70 AND 100 AND JenisKelamin = 'L' AND Kasus = 'Baru'");
			$umur70100P = $this->db->query("SELECT COUNT(IdDiagnosa) AS Jml FROM `$tbdiagnosapasien` WHERE $waktu $kodedgs AND UmurTahun Between 70 AND 100 AND JenisKelamin = 'P' AND Kasus = 'Baru'");
			
			$hasil['Response'] = array(
				'0_7hr' => array(
					'L' => isset($umur17hrL->row()->Jml) ? (int)$umur17hrL->row()->Jml : 0,
					'P' => isset($umur17hrP->row()->Jml) ? (int)$umur17hrP->row()->Jml : 0
				),
				'8_30hr' => array(
					'L' => isset($umur1830hrL->row()->Jml) ? (int)$umur1830hrL->row()->Jml : 0,
					'P' => isset($umur1830hrP->row()->Jml) ? (int)$umur1830hrP->row()->Jml : 0
				),
				'lt1th' => array(
					'L' => isset($umur12blnL->row()->Jml) ? (int)$umur12blnL->row()->Jml : 0,
					'P' => isset($umur12blnP->row()->Jml) ? (int)$umur12blnP->row()->Jml : 0
				),
				'1_4th' => array(
					'L' => isset($umur14L->row()->Jml) ? (int)$umur14L->row()->Jml : 0,
					'P' => isset($umur14P->row()->Jml) ? (int)$umur14P->row()->Jml : 0
				),
				'5_9th' => array(
					'L' => isset($umur59L->row()->Jml) ? (int)$umur59L->row()->Jml : 0,
					'P' => isset($umur59P->row()->Jml) ? (int)$umur59P->row()->Jml : 0
				),
				'10_14th' => array(
					'L' => isset($umur1014L->row()->Jml) ? (int)$umur1014L->row()->Jml : 0,
					'P' => isset($umur1014P->row()->Jml) ? (int)$umur1014P->row()->Jml : 0
				),
				'15_19th' => array(
					'L' => isset($umur1519L->row()->Jml) ? (int)$umur1519L->row()->Jml : 0,
					'P' => isset($umur1519P->row()->Jml) ? (int)$umur1519P->row()->Jml : 0
				),
				'20_44th' => array(
					'L' => isset($umur2044L->row()->Jml) ? (int)$umur2044L->row()->Jml : 0,
					'P' => isset($umur2044P->row()->Jml) ? (int)$umur2044P->row()->Jml : 0
				),
				'45_54th' => array(
					'L' => isset($umur4554L->row()->Jml) ? (int)$umur4554L->row()->Jml : 0,
					'P' => isset($umur4554P->row()->Jml) ? (int)$umur4554P->row()->Jml : 0
				),
				'55_59th' => array(
					'L' => isset($umur5559L->row()->Jml) ? (int)$umur5559L->row()->Jml : 0,
					'P' => isset($umur5559P->row()->Jml) ? (int)$umur5559P->row()->Jml : 0
				),
				'60_69th' => array(
					'L' => isset($umur6069L->row()->Jml) ? (int)$umur6069L->row()->Jml : 0,
					'P' => isset($umur6069P->row()->Jml) ? (int)$umur6069P->row()->Jml : 0
				),
				'gte70th' => array(
					'L' => isset($umur70100L->row()->Jml) ? (int)$umur70100L->row()->Jml : 0,
					'P' => isset($umur70100P->row()->Jml) ? (int)$umur70100P->row()->Jml : 0
				)
			);
			
			$total_l = $hasil['Response']['0_7hr']['L'] + $hasil['Response']['8_30hr']['L'] + $hasil['Response']['lt1th']['L'] + 
					   $hasil['Response']['1_4th']['L'] + $hasil['Response']['5_9th']['L'] + $hasil['Response']['10_14th']['L'] + 
					   $hasil['Response']['15_19th']['L'] + $hasil['Response']['20_44th']['L'] + $hasil['Response']['45_54th']['L'] + 
					   $hasil['Response']['55_59th']['L'] + $hasil['Response']['60_69th']['L'] + $hasil['Response']['gte70th']['L'];
			
			$total_p = $hasil['Response']['0_7hr']['P'] + $hasil['Response']['8_30hr']['P'] + $hasil['Response']['lt1th']['P'] + 
					   $hasil['Response']['1_4th']['P'] + $hasil['Response']['5_9th']['P'] + $hasil['Response']['10_14th']['P'] + 
					   $hasil['Response']['15_19th']['P'] + $hasil['Response']['20_44th']['P'] + $hasil['Response']['45_54th']['P'] + 
					   $hasil['Response']['55_59th']['P'] + $hasil['Response']['60_69th']['P'] + $hasil['Response']['gte70th']['P'];
			
			$hasil['Response']['total'] = array(
				'L' => $total_l,
				'P' => $total_p,
				'JML' => $total_l + $total_p
			);
			
			$this->response([
				'Pesan' => [
					'Status' => 'Berhasil',
					'Kode' => 200
				],
				'Response' => $hasil['Response']
			], 200);
			
		} catch (Exception $e) {
			log_message('error', 'P2P Hipertensi API Error: ' . $e->getMessage());
			$response_data = [
				'Pesan' => [
					'Status' => 'Error: ' . $e->getMessage(),
					'Kode' => 500
				],
				'Response' => null
			];
			
			if (ENVIRONMENT === 'development') {
				$response_data['Pesan']['Detail'] = [
					'file' => $e->getFile(),
					'line' => $e->getLine(),
					'trace' => $e->getTraceAsString()
				];
			}
			
			$this->response($response_data, 500);
		}
	}
}
