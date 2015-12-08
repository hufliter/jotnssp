<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function categoryAdd(){
		$name = ucfirst($this->input->post('name'));
		$data = array(
			'name' => $name,
			'link' => url_title(convert_accented_characters($name),'-',TRUE),
			'parent' => $this->input->post('parent')
		);

		return $this->db->insert('category', $data);
	}

	public function categoryDelete(){
		$this->db->where('id',$this->input->post('id'));
		if($this->db->delete('category')):
			$this->db->where('cid',$this->input->post('id'));
			return $this->db->delete('product');
		else:
			return false;
		endif;
	}

	public function select($id, $rule, $field = '*'){
		$this->db->where($rule,$id);
		$this->db->select($field);
		$this->db->limit(1);

		return $this->db->get('category')->row();
	}

	public function product($cid){
		$this->db->select('id, name, thumb, price');

		$this->db->where('cid', $cid);
		$this->db->where('status', '1');
		$this->db->order_by('id','desc');

		return $this->db->get('product')->result();
	}

	public function categoryEdit(){
		$name = ucfirst($this->input->post('name'));
		$data = array(
			'name' => $name,
			'link' => url_title(convert_accented_characters($name),'-',TRUE),
			'parent' => $this->input->post('parent')
		);
		$this->db->where('id',$this->input->post('id'));
		$this->db->limit(1);

		return $this->db->update('category',$data);
	}

	public function save($cache){
		$arr = array();
		$cat = json_decode($this->input->post('category'));

		foreach($cat as $k => $v):
			if(empty($v->item_id) || empty($v->depth))
				continue;

			/*
			if(empty($v->parent_id) && empty($cache[$v->item_id]))
				$arr[] = array('id'=>$v->item_id, 'parent'=> $v->parent_id);
			elseif(!empty($v->parent_id))
			*/
			$arr[] = array('id'=>$v->item_id, 'parent'=> $v->parent_id,'order'=>$k);
		endforeach;

		if(!empty($arr))
			$this->db->update_batch('category',$arr,'id');
		return true;
	}

}