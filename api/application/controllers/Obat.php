<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class Obat extends REST_Controller {

	// GET
	public function index_get(){
		$keyword = $this->uri->segment(3);
		$start = $this->uri->segment(4);
		$limit = $this->uri->segment(5);
        if ($keyword == '') {
			$hasil['Pesan']['Status'] = 'Parameter tidak lengkap';
			$hasil['Pesan']['Kode'] = 204;
        } else {
			$tbgfkstok = "tbgfkstok";
			$this->db->where('Stok !=', 0);
			$this->db->like('NamaBarang', $keyword);
			if($start != '' and $limit != ''){
				$this->db->limit($limit, $start);
			}
            $x = $this->db->get($tbgfkstok);
			
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