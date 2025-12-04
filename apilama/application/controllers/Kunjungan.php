<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class Kunjungan extends REST_Controller {

	// GET
	public function index_get(){
        //$get = $this->db->query("SELECT count(IdPasienrj) AS Jumlah FROM `tbpasienrj` WHERE TanggalRegistrasi=curdate()");
        $jmlk = 0;
        // if($get->num_rows() > 0){
        //     $jmlk = $get->row()->Jumlah;
        // }

        if($jmlk == 0){//untuk ujicoba
            $jmlk = rand(0,122);
        }

		$hasil['hasil']['jml'] = $jmlk;
		$hasil['pesan']['status'] = 'Berhasil';
		$hasil['pesan']['kode'] = 200;
        $this->response($hasil, 200);
	}
}
?>