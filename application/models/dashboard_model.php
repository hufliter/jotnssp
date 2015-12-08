<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function ads(){
		$this->db->limit(5);
		$this->db->where_in('position', array('under_search','under_product_detail','bottom', 'under_news', 'main'));
		return $this->db->get('ads')->result();
	}
	
	public function ads_under_search(){
		$this->db->where('position','under_search');
		$this->db->limit(1);
		return $this->db->get('ads')->row();
	}
	public function ads_find($id, $byId = true, $admin = false){
		if(!$admin)
			if((empty($id) || !$this->data['config']->advertise)) return false;

		if($byId)
			$this->db->where('id', $id);
		else
			$this->db->where('position', $id);
			
		$this->db->limit(1);
		return $this->db->get('ads')->row();
	}
	
	public function ads_edit($id){
		$data = array(
			'link' => strip_tags($this->input->post('link')),
			'img' => strip_tags($this->input->post('img')),
			'active' => (bool)$this->input->post('active')
		);
		$this->db->where('id', $id);
		return $this->db->update('ads', $data);
	}
	
	public function overview(){
		$data = array();

		$data['productTotal'] = $this->db->count_all('product'); 
		$data['orderTotal'] = $this->db->count_all('order');

		if($data['orderTotal'] == 0):
			$data['approve'] = $data['delay'] = $data['cancel'] = 0;
			return $data;
		endif;

		$this->db->where('status',1);
		$this->db->from('order');
		$data['approve'] = $this->db->count_all_results();

		if($data['orderTotal'] == $data['approve']):
			$data['delay'] = $data['cancel'] = 0;
			return $data;
		endif;

		$this->db->where('status',2);
		$this->db->or_where('status',4);
		$this->db->from('order');
		$data['delay'] = $this->db->count_all_results();

		$data['cancel'] = $data['orderTotal'] - ($data['delay'] + $data['approve']);

		return $data;
	}

	public function lastProduct(){
		$this->db->select('
		    product.id,
		    category.name as cat_name,
		    product.cid,
		    product.name,
		    product.thumb,
		    product.price,
		    product.start,
		    product.end,
		    product.sale,
		    product.view,
		    product.available
		');
        //change from 21 to 9
        //get 9 last Products
		$this->db->limit(9);
		$this->db->order_by('available','desc');
		$this->db->order_by('date','desc');
		$this->db->join('category','category.id = product.cid','inner');

		return $this->db->get('product')->result();
	}
	
	public function lastNews(){
		$this->db->select('id, name, thumb');
		$this->db->limit(1);
		$this->db->order_by('id','desc');

		return $this->db->get('news')->result();
	}

    public function mainAds(){


        $this->db->select('img, link, active');
        $this->db->where('active', 1);
        $this->db->where('position', 'main');

        return $this->db->get('ads')->result();
    }
	public function hotProduct(){
		$this->db->select('
		    product.id,
		    product.name,
		    product.thumb,
		    product.price,
		    product.start,
		    product.end,
		    product.sale,
		    product.available
		');
		$this->db->limit(20);
		$this->db->order_by('id','desc');
		$this->db->where('hot',1);

		return $this->db->get('product')->result();
	}

	public function favorite(){
	}

	public function category(){
		$this->db->order_by('parent','asc');
		$this->db->order_by('order','asc');

		$data = $this->db->get('category')->result();

		$cat = array();
		foreach($data as $v):
			if($v->parent == 0)
				$cat[$v->id] = array(
					'id' => $v->id,
					'name' => $v->name,
					'child' => array()
				);

			elseif(empty($cat[$v->parent]))
				continue;
			else
				$cat[$v->parent]['child'][] = array(
					'id'=>$v->id,'name'=>$v->name,'link'=>$v->link
				);
		endforeach;

		return $cat;
	}

	public function config(){
		$this->db->where('id',1);
		$this->db->limit(1);
		$a = $this->db->get('config')->row();
		$a->status = 1;
		return $a;
	}

	public function edit(){
		$data = array(
			'status' => $this->input->post('status'),
			'advertise' => $this->input->post('advertise'),
			'reason' => $this->input->post('reason'),
			'contact' =>  $this->input->post('contact'),
			'phone' => $this->input->post('phone'),
			'ck' => $this->input->post('ck'),
			'ckt' => $this->input->post('ckt'),
			'cks' => $this->input->post('cks'),
			'gnh' => $this->input->post('gnh'),
		);

		$this->db->where('id',1);
		return $this->db->update('config', $data);
	}
}