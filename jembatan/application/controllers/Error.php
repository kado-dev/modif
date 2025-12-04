<?php 
include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class Error extends REST_Controller {

	// GET
	public function index(){

		$hasil['Pesan']['Status'] = 'Url tidak sesuai';
		$hasil['Pesan']['Kode'] = 404;

        $this->response($hasil, 404);
	}
}
?>