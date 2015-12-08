<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends AppController {
	public function __construct(){
		parent::__construct();
		$this->load->model('news_model');
	}

	public function index(){
		$field = 'id,name,thumb,review';

		$this->paginate('news',$field, 3, '/news/index/');

		$this->paginate['per_page'] = 4;
		$this->paginate['total_rows'] = $this->pagination_model->total_rows();
		$this->pagination->initialize($this->paginate);
		$this->data['pagination_link'] = $this->pagination->create_links();

		$this->data['pagination'] = $this->pagination_model->fetch(
			$this->uri->segment(3),$this->paginate['per_page']
		);

		$this->data['description'] = 'tin tức, danh sách tin tức, jotunshop news, tin tức mới nhất từ jotunshop';
		$this->render('news/index',null, array('board','news'));
	}

	public function detail($id = null, $name = null){
		if(empty($id) || empty($name))
			redirect('/');

		$this->data['news_detail'] = $this->news_model->select($id,'id');
		if(empty($this->data['news_detail']))
			redirect('/');

		$this->data['description'] = 
			'tin tức '.html_escape($this->data['news_detail']->name).','.
			html_escape($this->data['news_detail']->review);
		$this->render('news/detail',null, array('board','news'));
	}

	public function admin_index(){
		$field = 'news.id,news.name,news.thumb,news.review';
		$link = '/admincp/news/index/';

		$this->paginate('news', $field, 4, $link);

		$this->paginate['total_rows'] = $this->pagination_model->total_rows();
		$this->pagination->initialize($this->paginate);
		$this->data['pagination_link'] = $this->pagination->create_links();

		$this->data['pagination'] = $this->pagination_model->fetch(
			$this->uri->segment(4),$this->paginate['per_page']
		);

		$this->render('news/admin_index',array('jquery.sceditor.bbcode.min','jquery-ui'),array('back','default.min','jquery-ui'));
	}

	public function admin_add(){
		$this->validation();
		$this->isAjax();

		if($this->input->post() && $this->form_validation->run('tipAdd')):
			if($this->news_model->Add()):
				$this->session->set_flashdata('success','Thêm tin tức thành công');
				$this->site->back_erase('lastNews');
			else:
				$this->session->set_flashdata('error','Lỗi sql, thử lại');
			endif;

			redirect('/admincp/news');
		endif;

		$this->data['captTime'] = $this->captcha();
		$this->render('news/admin_add',array('jquery.sceditor.bbcode.min','jquery-ui'),array('back','default.min','jquery-ui'));
	}

	public function admin_edit($id = null){
		if(empty($id))
			redirect('/admincp/news');

		$this->validation();
		$this->isAjax();

		if($this->input->post() && $this->form_validation->run('tipEdit')):
			if($this->news_model->edit()):
				$this->session->set_flashdata('success','Sửa tin tức thành công');
				$this->site->back_erase('lastNews');
			else:
				$this->session->set_flashdata('error','Lỗi sql, thử lại');
			endif;

			redirect('/admincp/news');
		endif;

		$this->data['news'] = $this->news_model->select($id,'id');
		if(empty($this->data['news'])):
			$this->session->set_flashdata('error','Không có tin tức này');
			redirect('/admincp/news');
		endif;

		$this->data['captTime'] = $this->captcha();
		$this->render('news/admin_edit',array('jquery.sceditor.bbcode.min','jquery-ui'),array('back','default.min','jquery-ui'));
	}

	public function admin_delete($id = null){
		if(empty($id))
			redirect('/admincp/news');

		$this->validation();
		$this->isAjax();
		if($this->input->post() && $this->form_validation->run('delete')):
			if($this->news_model->delete()):
				$this->session->set_flashdata('success','Xóa tin tức thành công');
				$this->site->back_erase('lastNews');
			else:
				$this->session->set_flashdata('error','Lỗi sql, thử lại');
			endif;
			redirect('/admincp/news');
		endif;

		$this->data['captTime'] = $this->captcha();
		$this->data['id'] = $id;
		$this->render('news/admin_delete',null,array('back'));
	}	
}