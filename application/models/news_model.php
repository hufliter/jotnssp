<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class News_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	protected function getData(){
		$data = array(
			'name' => $this->input->post('name'),
			'thumb' => $this->input->post('thumb'),
			'review' => $this->input->post('review')
		);

		$data['detail'] = html_escape($this->input->get_news_detail());
		$this->load->helper('security');
		$data['detail'] = xss_clean($data['detail']);

		return $data;
	}

	public function add(){
		return $this->db->insert('news', $this->getData());
	}

	public function edit(){

		$this->db->where('id', $this->input->post('id'));
		return $this->db->update('news', $this->getData());
	}

	public function select($id, $rule, $field = '*'){
		$this->db->where($rule,$id);
		$this->db->select($field);
		$this->db->limit(1);

		return $this->db->get('news')->row();
	}

	public function delete(){
		$this->db->where('id',$this->input->post('id'));
		return $this->db->delete('news');
	}
}