<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends AppController {
	public $position = array(
		'under_search' => 'Q/c dưới khung search',
		'under_product_detail' => 'Q/c dưới sản phẩm chi tiết',
		'under_news' => 'Q/c dưới khung tin tức (660 x 210)',
		'bottom' => 'Q/c dưới cùng (370 x 250)',
        'main'=>'Q/c chính'
	);
		
	public function __construct(){
		parent::__construct();

	}

	public function admin_index(){
		$this->data = array_merge($this->data, $this->site->back('all'));
		$this->render('dashboard/admin_index',null,array('back'));
	}

	public function admin_advertise(){
		$this->data['ads'] = $this->dashboard_model->ads();
		$this->data['position'] = $this->position;
		$this->render('dashboard/admin_advertise',array('jquery.sceditor.bbcode.min','jquery-ui'),array('back','default.min','jquery-ui'));
	}
	
	public function admin_ads_edit($id = null){
		$ads = $this->dashboard_model->ads_find($id, true, true);
		if(empty($ads)):
			$this->session->set_flashdata('error','Không có quảng cáo này');
			redirect('/admincp/dashboard/advertise');
		endif;
		
		$this->validation();
		if($this->input->post() && $this->form_validation->run('advertise')):
			if($this->dashboard_model->ads_edit($id)):
				$this->site->back_erase('ads_under_search');
				$this->session->set_flashdata('success','Sửa quảng cáo thành công');
			else:
				$this->session->set_flashdata('error','Lỗi sql, thử lại');
			endif;
			redirect('/admincp/dashboard/advertise');
		endif;
		
		$this->data['captTime'] = $this->captcha();
		$this->data['ads'] = $ads;
		$this->data['position'] = $this->position;
		$this->render('dashboard/admin_ads_edit',null,array('back'));
	}
	
	public function admin_config(){
		$this->data = array_merge($this->data, $this->site->back('config'));
		$this->validation();

		if($this->input->post() && $this->form_validation->run('config')):
            \Entity\SiteConfig::setConfig(CONF_RESELLER_VALUE, $this->getInput('conf_reseller_value'));
            \Entity\SiteConfig::setConfig(CONF_COUPON_OFF, $this->getInput('conf_coupon_off'));
			if($this->dashboard_model->edit()):
				$this->site->back_erase('config');
				$this->session->set_flashdata('success','Cấu hình thành công');
			else:
				$this->session->set_flashdata('error','Lỗi sql, thử lại');
			endif;

			redirect('/admincp/dashboard');
		endif;

        $this->data['conf_reseller_value'] = (float) \Entity\SiteConfig::getConfig(CONF_RESELLER_VALUE, 0);
        $this->data['conf_coupon_off'] = (float) \Entity\SiteConfig::getConfig(CONF_COUPON_OFF, 0);

		$this->data['captTime'] = $this->captcha();
		$this->render('dashboard/admin_config',array('jquery.sceditor.bbcode.min','jquery-ui'),array('back','default.min','jquery-ui'));
	}
}