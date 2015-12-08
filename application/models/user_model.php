<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	public $key = null;

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('encrypt');
	}

	public function login(){
		$this->db->where('user', $this->input->post('user'));
		$this->db->where('pass', $this->password());
		$this->db->select('id,admin');

		return $this->db->get('user');
	}

	public function edit(){
		$data = array(
			'pass' => $this->password()
		);

		$this->db->where('id', $this->session->userdata('uid'));
		$this->db->where('user', $this->session->userdata('user'));

		return $this->db->update('user',$data);
	}

	public function signup($data = array()){
		$data = array(
			'user' => $this->input->post('user'),
			'pass' => md5($this->encrypt->encode($this->input->post('pass'))),
			'email'	   => $this->input->post('email'),
			'ip'	   => $this->input->ip_address()
		);

		return $this->db->insert('user',$data);
	}

	private function password(){
		return md5(sha1( substr($this->key, 0,5) . $this->input->post('pass') . substr($this->key, -5) ));
	}
}