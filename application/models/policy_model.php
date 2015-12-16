<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* TP Elisoft
*/
class Policy_model extends CI_Model
{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function add(){
		$data = array(
			'name' => $this->input->post('name'),
			'link' => $this->input->post('link'),
			'status' => $this->input->post('status'),
		);
		return $this->db->insert('policy',$data);
	}
	public function edit(){
		$data = array(
			'name' => $this->input->post('name'),
			'link' => $this->input->post('link'),
			'status' => $this->input->post('status'),
		);
		$this->db->where('id',$this->input->post('id'));
		return $this->db->update('policy', $data);
	}
	public function select($id, $rule, $field = '*'){
		$this->db->where($rule,$id);
		$this->db->select($field);
		$this->db->limit(1);

		return $this->db->get('policy')->row();
	}

	public function delete(){
		$this->db->where('id',$this->input->post('id'));
		return $this->db->delete('policy');
	}
}
?>