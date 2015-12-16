<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* TP Elisoft
*/
class Policy extends AppController
{	
	public function __construct(){
		parent::__construct();
		$this->load->model('policy_model');
	}
	public function admin_index(){
		$field = 'policy.id,policy.name,policy.link,policy.status';
		$link = '/admincp/policy/index/';

		$this->paginate('policy', $field, 4, $link);
		$this->paginate['total_rows'] = $this->pagination_model->total_rows();
		$this->pagination->initialize($this->paginate);
		$this->data['pagination_link'] = $this->pagination->create_links();

		$this->data['pagination'] = $this->pagination_model->fetch(
			$this->uri->segment(4),$this->paginate['per_page']
		);

		$this->render('policy/admin_index',array('jquery.sceditor.bbcode.min','jquery-ui'),array('back','default.min','jquery-ui'));
	}
	public function admin_add(){
		$this->validation();
		$this->isAjax();

		if($this->input->post() && $this->form_validation->run('policyAdd')):
			if($this->policy_model->add())
				$this->session->set_flashdata('success','Thêm Chính sách thành công');
			else
				$this->session->set_flashdata('error','Lỗi sql, thử lại');

			redirect('/admincp/policy');
		endif;

		$this->data['captTime'] = $this->captcha();
		$this->render('policy/admin_add',array('jquery.sceditor.bbcode.min','jquery-ui'),array('back','default.min','jquery-ui'));
	}

	public function admin_edit($id = null){
		if(empty($id))
			redirect('/admincp/policy');

		$this->validation();
		$this->isAjax();

		if($this->input->post() && $this->form_validation->run('policyEdit')):
			if($this->policy_model->edit())
				$this->session->set_flashdata('success','Sửa chính sách thành công');
			else
				$this->session->set_flashdata('error','Lỗi sql, thử lại');

			redirect('/admincp/policy');
		endif;

		$this->data['policy'] = $this->policy_model->select($id,'id');
		if(empty($this->data['policy'])):
			$this->session->set_flashdata('error','Không có chính sách này');
			redirect('/admincp/policy');
		endif;

		$this->data['captTime'] = $this->captcha();
		$this->render('policy/admin_edit',array('jquery.sceditor.bbcode.min','jquery-ui'),array('back','default.min','jquery-ui'));
	}

	public function admin_delete($id = null){
		if(empty($id))
			redirect('/admincp/policy');

		$this->validation();
		$this->isAjax();
		if($this->input->post() && $this->form_validation->run('delete')):
			if($this->policy_model->delete())
				$this->session->set_flashdata('success','Xóa chính sách thành công');
			else
				$this->session->set_flashdata('error','Lỗi sql, thử lại');
			redirect('/admincp/policy');
		endif;

		$this->data['captTime'] = $this->captcha();
		$this->data['id'] = $id;
		$this->render('policy/admin_delete',null,array('back'));
	}
}
?>