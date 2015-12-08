<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Tip_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function add(){
		$data = array(
			'name' => $this->input->post('name'),
			'thumb' => $this->input->post('thumb'),
			'detail' => $this->input->post('detail'),
			'review' => $this->input->post('review')
		);

		return $this->db->insert('tip', $data);
	}

	public function select($id, $rule, $field = '*'){
		$this->db->where($rule,$id);
		$this->db->select($field);
		$this->db->limit(1);

		return $this->db->get('tip')->row();
	}

	public function edit(){
		$data = array(
			'name' => $this->input->post('name'),
			'thumb' => $this->input->post('thumb'),
			'detail' => $this->input->post('detail'),
			'review' => $this->input->post('review')
		);

		$this->db->where('id', $this->input->post('id'));
		return $this->db->update('tip',$data);
	}

	public function delete(){
		$this->db->where('id',$this->input->post('id'));
		return $this->db->delete('tip');
	}
}