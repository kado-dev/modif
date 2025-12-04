<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class Pasienrj extends REST_Controller {

	// GET
	public function index_get(){
		$tgl = $this->uri->segment(3);
		$kdpuskesmas = $this->uri->segment(4);
		$start = $this->uri->segment(5);
		$limit = $this->uri->segment(6);
        if ($tgl == '' or $kdpuskesmas == '') {
			$hasil['Pesan']['Status'] = 'Parameter tidak lengkap';
			$hasil['Pesan']['Kode'] = 204;
        } else {
			// $tbpasienrj = "tbpasienrj_".date('m',strtotime($tgl));
			$tbpasienrj = "tbpasienrj";			
			$this->db->where('TanggalRegistrasi', $tgl);
            $this->db->where('SUBSTRING(NoRegistrasi,1,11)', $kdpuskesmas);
			if($start != '' and $limit != ''){
				$this->db->limit($limit, $start);
			}
            $x = $this->db->get($tbpasienrj);
			
			if($x->num_rows() > 0){
				$hasil['Response'] = $x->result();
				$hasil['Pesan']['Status'] = 'Berhasil';
				$hasil['Pesan']['Kode'] = 200;
			}else{
				$hasil['Pesan']['Status'] = 'Tidak ada data';
				$hasil['Pesan']['Kode'] = 204;
			}
			
        }
        $this->response($hasil, 200);
	}
}
?>