<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Pagination_model extends CI_Model {
	public $table = null;
	public $field = null;
	public $sortList = array();
	public $sortBy = 'id';
	public $sortOrder = 'desc';

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function total_rows($id = null, $cond = null){
		if(empty($this->table))
			return 0;

		$this->db->select('id');

		if(is_string($id) && !empty($id) && !empty($cond)):
			$this->db->where($id, $cond);
		elseif(is_array($id)):
			foreach($id as $k => $v)
				$this->db->where($k, $v);
		endif;

		return $this->db->get($this->table)->num_rows;
	}

	public function fetch($start = 0, $limit = 0, $id = null, $cond = null, $sortBy = 'id', $sortOrder = 'desc'){
		if(empty($limit))
			return false;

		if(!empty($this->field))
			$this->db->select($this->field);

		if(!empty($this->sortList[$sortBy]))
			$sortBy = $this->sortList[$sortBy];
		elseif(empty($this->sortList[$sortBy]) && !empty($this->sortList))
			$sortBy = array_shift(array_values($this->sortList));

		if($sortOrder != 'desc')
			$sortOrder = 'asc';
		else
			$sortOrder = 'desc';

		$start = $start ? $start : 0;

		if(is_string($id) && !empty($id) && !empty($cond)):
			$this->db->where($id, $cond);
		elseif(is_array($id)):
			foreach($id as $k => $v)
				$this->db->where($k, $v);
		endif;

		$this->db->limit($limit, $start);
		$this->db->order_by($sortBy, $sortOrder);

		$this->sortBy = $sortBy;
		$this->sortOrder = $sortOrder;
		return $this->db->get($this->table)->result();
	}
}