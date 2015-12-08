<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_model extends CI_Model {
	public $data = array();

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function detail($id){
		$this->db->select('
			order.id, order.uid, order.total, order.address, order.note, order.status, order.date,
			user.name
		');

		$this->db->join('user','user.id = order.uid','left');
		$this->db->where('order.id',$id);

		$this->data['order'] = $this->db->get('order')->row();
		$this->data['product'] = $this->productIn($this->data['order']->id);

	}

	public function productIn($detailId){
		$this->db->select('
			cart.pid, cart.name, cart.price, cart.qty,
			product.thumb
		');

		$this->db->join('product','cart.pid = product.id','left');

		$this->db->where('cart.oid', $detailId);

		return $this->db->get('cart')->result();
	}

	public function status($id){
		$this->db->select('order.id, order.status');
		$this->db->where('id', $id);
		return $this->db->get('order')->row();
	}

	public function updateStatus(){
		$data = array(
			'status' => (int)$this->input->post('status')
		);

		$this->db->where('id', $this->input->post('id'));
		return $this->db->update('order',$data);
	}
}