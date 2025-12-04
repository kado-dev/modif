<?php 
//include_once(APPPATH.'libraries/REST_Controller.php');
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller {

	// GET
	public function index(){
		$username = $this->input->get_request_header('X-Username');
		$password = md5($this->input->get_request_header('X-Password'));
		//$headers = apache_request_headers();
		//echo var_dump($headers);
		//die();
		if($username != '' && $password != ''){
			//cek username dan password di db
			$cek  = $this->db->query("SELECT * FROM tbapikey WHERE Username = '$username' AND Password = '$password'");
			if($cek->num_rows() > 0){
				//get token
				$token = md5(date('ymdhis').$cek->row()->id);

				$dt['id'] = $cek->row()->id;
				$dt['token'] = $token;
				$dt['expire'] = date( "Y-m-d H:i:s", strtotime("+30 minutes"));
				$this->db->insert('tbtoken',$dt);

				$resp['response']['token'] = $token;
				$resp['metadata']['message'] = 'ok';
				$resp['metadata']['code'] = '200';
			}else{
				$resp['metadata']['message'] = 'Username atau Password Tidak Sesuai';
				$resp['metadata']['code'] = '201';
			}
		}else{
			$resp['metadata']['message'] = 'Username atau password harus diisi';
			$resp['metadata']['code'] = '201';
		}
		echo json_encode($resp);
	}
}
?>