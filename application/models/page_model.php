<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Page_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function ads_under_news(){
		if(!$this->data['config']->advertise)	return false;

		$this->db->select('img, link, active');
		$this->db->where('active', 1);
		$this->db->where('position', 'under_news');
		
		return $this->db->get('ads')->row();
	}


}