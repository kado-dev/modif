<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Model_default');
    }
	

	public function index()
	{
		$data['title'] = 'Login User';
		$this->load->view('login',$data);
	}
	
	public function proses(){
		
		$username = $this->input->post('username');
		$pass = md5($this->input->post('pass'));
		
		$login = $this->Model_default->login_pegawai($username,$pass);
		if($login){
			redirect('home'); //ini ambil dari controler
		}else{
			$this->session->set_flashdata("report", error("Data login anda salah.."));
			redirect('login');
		}
	}
	
	public function registrasi_proses(){

		$data['Username'] = $this->input->post('username');
		$data['Password'] = md5($this->input->post('pass'));
		$data['Email'] = $this->input->post('email');
		$data['Handphone'] = $this->input->post('handphone');
		$data['Approve'] = 'N';
	
		$cek = $this->Model_default->simpan('tbapikey',$data);
		if($cek){
			$this->session->set_flashdata("report", valid("Registrasi berhasil"));
			redirect('login');
		}else{
			$this->session->set_flashdata("report", error("Registrasi gagal"));
			redirect('login');
		}
	}
	
}
