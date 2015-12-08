<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tip extends AppController {

	public function __construct(){
		parent::__construct();
		$this->load->model('tip_model');
	}

	public function index(){
		$field = 'tip.id,tip.name,tip.thumb,tip.review';

		$this->paginate('tip',$field, 3, '/tip/index/');

		$this->paginate['per_page'] = 8;
		$this->paginate['total_rows'] = $this->pagination_model->total_rows();
		$this->pagination->initialize($this->paginate);
		$this->data['pagination_link'] = $this->pagination->create_links();

		$this->data['pagination'] = $this->pagination_model->fetch(
			$this->uri->segment(3),$this->paginate['per_page']
		);

		$this->data['description'] = 'danh sách bí kíp, mẹo nhỏ từ jotunshop, trang '.$this->uri->segment(3);
		$this->render('tip/index',null, array('board'));
	}

	public function detail($id = null, $name = null){
		if(empty($id) || empty($name))
			redirect('/');

		$this->data['tip_detail'] = $this->tip_model->select($id,'id');
		if(empty($this->data['tip_detail']))
			redirect('/');

		$this->data['description'] = 'bí kíp chi tiết, '.html_escape($this->data['tip_detail']->name);
		$this->render('tip/detail',null, array('board','contact','tip'));
	}

	public function admin_index($sortBy = 'stt', $sortOrder = 'desc'){
		$this->load->helper('text');

		$field = 'tip.id,tip.name,tip.thumb,tip.review';
		$link = '/admincp/tip/index';

		$this->paginate('tip', $field, 6, $link.$sortBy.'/'.$sortOrder);

		$this->pagination_model->sortList = array(
			'stt'=>'id','ten'=>'name'
		);

		$this->paginate['total_rows'] = $this->pagination_model->total_rows();
		$this->pagination->initialize($this->paginate);
		$this->data['pagination_link'] = $this->pagination->create_links();

		$this->data['pagination'] = $this->pagination_model->fetch(
			$this->uri->segment(6),$this->paginate['per_page'],null,null,
			$sortBy,$sortOrder
		);

		$this->data['sort_link'] = $link;
		$this->data['pagination_sortBy'] = $sortBy;
		$this->data['pagination_sortOrder'] = $this->pagination_model->sortOrder;
		$this->render('tip/admin_index',array('jquery.sceditor.bbcode.min','jquery-ui'),array('back','default.min','jquery-ui'));
	}

	public function admin_add(){
		$this->validation();
		$this->isAjax();

		if($this->input->post() && $this->form_validation->run('tipAdd')):
			if($this->tip_model->Add())
				$this->session->set_flashdata('success','Thêm bí kíp thành công');
			else
				$this->session->set_flashdata('error','Lỗi sql, thử lại');

			redirect('/admincp/tip');
		endif;

		$this->data['captTime'] = $this->captcha();
		$this->render('tip/admin_add',array('jquery.sceditor.bbcode.min','jquery-ui'),array('back','default.min','jquery-ui'));
	}

	public function admin_edit($id = null){
		if(empty($id))
			redirect('/admincp/tip');

		$this->validation();
		$this->isAjax();

		if($this->input->post() && $this->form_validation->run('tipEdit')):
			if($this->tip_model->edit())
				$this->session->set_flashdata('success','Sửa bí kíp thành công');
			else
				$this->session->set_flashdata('error','Lỗi sql, thử lại');

			redirect('/admincp/tip');
		endif;

		$this->data['tip'] = $this->tip_model->select($id,'id');
		if(empty($this->data['tip'])):
			$this->session->set_flashdata('error','Không có bí kíp này');
			redirect('/admincp/tip');
		endif;

		$this->data['captTime'] = $this->captcha();
		$this->render('tip/admin_edit',array('jquery.sceditor.bbcode.min','jquery-ui'),array('back','default.min','jquery-ui'));
	}

	public function admin_delete($id = null){
		if(empty($id))
			redirect('/admincp/tip');

		$this->validation();
		$this->isAjax();
		if($this->input->post() && $this->form_validation->run('delete')):
			if($this->tip_model->delete())
				$this->session->set_flashdata('success','Xóa bí kíp thành công');
			else
				$this->session->set_flashdata('error','Lỗi sql, thử lại');
			redirect('/admincp/tip');
		endif;

		$this->data['captTime'] = $this->captcha();
		$this->data['id'] = $id;
		$this->render('tip/admin_delete',null,array('back'));
	}

}