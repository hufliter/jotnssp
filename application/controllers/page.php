<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends AppController {
	
	public function __construct(){
		parent::__construct();
	}

	public function loadding(){
		//$this->layout = false;
		//$this->render('page/loadding');
		show_404();
	}

	public function index(){
		/*
		if($this->agent->referrer() == base_url().'page/loadding'):
			$this->input->set_cookie(array(
				'name'=>'loaded','value'=>true,'expire'=>'86500'
			));
		endif;
		*/
		$this->load->model('page_model');
		
		$this->data = array_merge($this->data, $this->site->back('hotProduct'));
		$this->data = array_merge($this->data, $this->site->back('lastProduct'));
		$this->data['page_ads'] = $this->page_model->ads_under_news();

		$this->data['category_slide'] = $this->load->view('category/inner_slide', $this->data, true);
		$this->data['new_product'] = $this->load->view('product/inner_new', $this->data, true);
		$this->data['ads_under_news'] = $this->load->view('page/ads_under_news', $this->data, true);
        $this->data['login_success'] = $this->session->flashdata('login_success');
		$this->render('page/index');
	}

	public function contact($id = 'ck'){
		switch($id):
			case 'cks':
				$title = "Bưu điện \n chuyển khoản sau";break;
			case 'gnh':
				$title = "Bưu điện \n gửi nhận hàng";break;
			case 'ckt':
				$title = "Bưu điện \n chuyển khoản trước";break;
			default:
				$id = 'ck';$title = 'Liên Hệ';
		endswitch;

		$this->data['contact']['name'] = $title;
		$this->data['contact']['content'] = $this->data['config']->{$id};
		$this->render('page/contact',null,array('board','contact'));
	}
}