<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recruitment extends AppController {
	public function __construct(){
		parent::__construct();
		$this->load->model('recruitment_model');
	}

	public function index(){
		$field = 'id,name,thumb,review';

		$this->paginate('recruitment',$field, 3, '/recruitment/index/');

		$this->paginate['per_page'] = 8;
		$this->paginate['total_rows'] = $this->pagination_model->total_rows();
		$this->pagination->initialize($this->paginate);
		$this->data['pagination_link'] = $this->pagination->create_links();

		$this->data['pagination'] = $this->pagination_model->fetch(
			$this->uri->segment(3),$this->paginate['per_page']
		);

		$this->render('recruitment/index',null, array('board'));
	}

	public function detail($id = null, $name = null){
		if(empty($id) || empty($name))
			redirect('/');

		$this->data['recruitment_detail'] = $this->recruitment_model->select($id,'id');
		if(empty($this->data['recruitment_detail']))
			redirect('/');

		$this->render('recruitment/detail',null, array('board','contact','tip'));
	}

	public function admin_index(){
		$field = 'recruitment.id,recruitment.name,recruitment.thumb,recruitment.review';
		$link = '/admincp/recruitment/index/';

		$this->paginate('recruitment', $field, 4, $link);

		$this->paginate['total_rows'] = $this->pagination_model->total_rows();
		$this->pagination->initialize($this->paginate);
		$this->data['pagination_link'] = $this->pagination->create_links();

		$this->data['pagination'] = $this->pagination_model->fetch(
			$this->uri->segment(4),$this->paginate['per_page']
		);

		$this->render('recruitment/admin_index',array('jquery.sceditor.bbcode.min','jquery-ui'),array('back','default.min','jquery-ui'));
	}

	public function admin_add(){
		$this->validation();
		$this->isAjax();

		if($this->input->post() && $this->form_validation->run('tipAdd')):
			if($this->recruitment_model->add())
				$this->session->set_flashdata('success','Thêm tin tuyển dụng thành công');
			else
				$this->session->set_flashdata('error','Lỗi sql, thử lại');

			redirect('/admincp/recruitment');
		endif;

		$this->data['captTime'] = $this->captcha();
		$this->render('recruitment/admin_add',array('jquery.sceditor.bbcode.min','jquery-ui'),array('back','default.min','jquery-ui'));
	}

	public function admin_edit($id = null){
		if(empty($id))
			redirect('/admincp/recruitment');

		$this->validation();
		$this->isAjax();

		if($this->input->post() && $this->form_validation->run('tipEdit')):
			if($this->recruitment_model->edit())
				$this->session->set_flashdata('success','Sửa tin tuyển dụng thành công');
			else
				$this->session->set_flashdata('error','Lỗi sql, thử lại');

			redirect('/admincp/recruitment');
		endif;

		$this->data['recruitment'] = $this->recruitment_model->select($id,'id');
		if(empty($this->data['recruitment'])):
			$this->session->set_flashdata('error','Không có tin này');
			redirect('/admincp/recruitment');
		endif;

		$this->data['captTime'] = $this->captcha();
		$this->render('recruitment/admin_edit',array('jquery.sceditor.bbcode.min','jquery-ui'),array('back','default.min','jquery-ui'));
	}

	public function admin_delete($id = null){
		if(empty($id))
			redirect('/admincp/recruitment');

		$this->validation();
		$this->isAjax();
		if($this->input->post() && $this->form_validation->run('delete')):
			if($this->recruitment_model->delete())
				$this->session->set_flashdata('success','Xóa tin tuyển dụng thành công');
			else
				$this->session->set_flashdata('error','Lỗi sql, thử lại');
			redirect('/admincp/recruitment');
		endif;

		$this->data['captTime'] = $this->captcha();
		$this->data['id'] = $id;
		$this->render('recruitment/admin_delete',null,array('back'));
	}	
}