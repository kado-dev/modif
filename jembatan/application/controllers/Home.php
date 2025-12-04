<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('Model_default');
		$this->Model_default->ceklogin();	
    }
	
	public function index()
	{
		$data['title'] = 'Dashboard | Web Service Simpus';
		$tmp['content'] = $this->load->view('dashboard',$data,TRUE);
		$this->load->view('template',$tmp);
	}

	public function detail()
	{
		$username = $this->session->userdata('username');
		$data['title'] = 'Detail | Webservice Simpus';
		$data['data'] = $this->db->query("SELECT * from tbapikey where username = '$username'")->row();
		$tmp['content'] = $this->load->view('detail',$data,TRUE);
		$this->load->view('template',$tmp);
	}

	public function registrasi()
	{
		if($this->session->userdata("level") == 'programmer'){
			$data['title'] = 'Registrasi | Webservice Simpus';
			$data['data'] = $this->db->query("SELECT * from tbapikey");
			$tmp['content'] = $this->load->view('registrasi',$data,TRUE);
			$this->load->view('template',$tmp);
		}else{
			redirect('home');
		}
	}	
	
	public function registrasi_approve(){
		if($this->session->userdata("level") == 'programmer'){
			$id = $this->uri->segment(3);
			$keys = get_password();
			$data['keys'] = $keys;
			$data['Approve'] = 'Y';
			$this->db->where('id', $id);
			$this->db->update('tbapikey', $data);
			
			//kirim email
			$user = $this->db->query("SELECT * from tbapikey where id = '$id'")->row();
			$email = $user->Email;
			$isipesan = "Berikut apikey: ".$keys;
			
			$this->kirim_email($email,$isipesan,"API key simpus pkmonline");
			$this->session->set_flashdata("report", valid("Registrasi berhasil di approve"));
			redirect('home/registrasi');
		}else{
			redirect('home');
		}
	}

	public function bpjs()
	{
		$data['title'] = 'Bpjs | Webservice Simpus';
		$tmp['content'] = $this->load->view('bpjs',$data,TRUE);
		$this->load->view('template',$tmp);
	}

	public function kunjungan()
	{
		$data['title'] = 'Kunjungan | Webservice Simpus';
		$tmp['content'] = $this->load->view('kunjungan',$data,TRUE);
		$this->load->view('template',$tmp);
	}	

	public function penyakit()
	{
		$data['title'] = 'Penyakit | Webservice Simpus';
		$tmp['content'] = $this->load->view('penyakit',$data,TRUE);
		$this->load->view('template',$tmp);
	}
	
	public function obat()
	{
		$data['title'] = 'Obat | Webservice Simpus';
		$tmp['content'] = $this->load->view('obat',$data,TRUE);
		$this->load->view('template',$tmp);
	}

	public function pegawai()
	{
		$data['title'] = 'Pegawai | Webservice Simpus';
		$tmp['content'] = $this->load->view('pegawai',$data,TRUE);
		$this->load->view('template',$tmp);
	}	
	
	public function logout(){
		$this->session->unset_userdata("username");
		$this->session->unset_userdata("password");
		$this->session->unset_userdata("key");
		$this->session->unset_userdata("approve");
		$this->session->unset_userdata("level");
		redirect('login');
	}
	
	// ===================== KIRIM EMAIL =================================
	function kirim_email($email,$isipesan,$subject){
	
		$email_sistem = "admin@puskesmasjuara.id";
		
		$this->load->library('email');

		$config['protocol'] = "smtp";
		$config['smtp_host'] = "mail.puskesmasjuara.id";
		$config['smtp_port'] = "25";
		$config['smtp_user'] = "admin@puskesmasjuara.id"; 
		$config['smtp_pass'] = "tarakan771113334";
		$config['mailtype'] = 'html';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;

		$this->email->initialize($config);
		$this->email->from($email_sistem, 'Puskesmas Online');
		$this->email->to($email);
		$this->email->subject($subject);
		$this->email->message($isipesan);

		if($this->email->send()){
			$status = true;
		}else{
			$status = false;
		}

		return $status;
	}	
	
	
}
