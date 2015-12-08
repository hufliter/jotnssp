<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends AppController {

	public function __construct(){
		parent::__construct();
		$this->load->model('category_model');
		$this->data = array_merge($this->data,$this->site->back('category'));
	}

	public function show($id = null, $name = null){
		if(empty($id) || empty($name))
			redirect('/');

		$this->category_model->db->where('link', $name);
		$this->category_model->db->where('parent >', '0');
		$this->data['show_category'] = $this->category_model->select($id, 'id', 'id, name');

		if(!empty($this->data['category']) && !empty($this->data['show_category'])):
			$field = 'product.id, product.name, product.thumb, product.price, product.start, product.end, product.sale, product.available';
			$link = '/category/show/'.$id.'/'.$name;

			$this->paginate('product', $field, 5, $link);

			$this->pagination_model->db->where('status','1');
			$this->paginate['total_rows'] = $this->pagination_model->total_rows('cid', $id);

			$this->pagination->initialize($this->paginate);
			$this->data['pagination_link'] = $this->pagination->create_links();
			$this->pagination_model->sortList = array(
				'date' => 'date'
			);
			$this->pagination_model->db->where('status','1');
			$this->data['show_product'] = $this->pagination_model->fetch(
				$this->uri->segment(5),$this->paginate['per_page'],'cid',$id
			);
		else:
			$this->data['show_product'] = null;
			$this->data['pagination_link'] = null;
		endif;

		$this->data['description'] = @html_escape($this->data['show_category']->name);
		$this->render('category/show', null, array('board'));
	}

	public function admin_index(){
		$this->data['captTime'] = $this->captcha();
		$this->render('category/admin_category2',array('jquery-ui','touch','sorttable'), array('back','sorttable'));
	}

	public function admin_categoryAdd(){
		$this->validation();
		$this->isAjax();

		if($this->input->post() && $this->form_validation->run('categoryAdd')):
			if($this->category_model->categoryAdd()):
				$this->session->set_flashdata('success','Thêm chủng loại thành công');
				$this->site->back_erase('category');
			else:
				$this->session->set_flashdata('error','Lỗi sql, thử lại');
			endif;
			redirect('/admincp/category');
		endif;

		$this->data['captTime'] = $this->captcha();
		$this->render('category/admin_categoryAdd',null,array('back'));
	}

	public function admin_delete($id = null){
		if(empty($id))
			redirect('/admincp/category');

		$this->validation();
		$this->isAjax();
		if($this->input->post() && $this->form_validation->run('delete')):
			if($this->category_model->categoryDelete()):
				$this->session->set_flashdata('success','Xóa chủng loại thành công');
				$this->site->back_erase('category');
			else:
				$this->session->set_flashdata('error','Lỗi sql, thử lại');
			endif;
			redirect('/admincp/category');
		endif;

		$this->data['captTime'] = $this->captcha();
		$this->data['id'] = $id;
		$this->render('category/admin_categoryDelete',null,array('back'));
	}

	public function admin_edit($id = null){
		if(empty($id))
			redirect('/admincp/category');
		$this->site->back('category');

		$this->validation();
		$this->isAjax();

		if($this->input->post() && $this->form_validation->run('categoryEdit')):
			if($this->category_model->categoryEdit()):
				$this->session->set_flashdata('success','Sửa chủng loại thành công');
				$this->site->back_erase('category');
			else:
				$this->session->set_flashdata('error','Lỗi sql, thử lại');
			endif;
			redirect('/admincp/category');
		endif;

		$this->data['cat'] = $this->category_model->select($id,'id');
		if(empty($this->data['cat'])):
			$this->session->set_flashdata('error','Không có chủng loại này');
			redirect('/admincp/category');
		endif;
		$this->data['captTime'] = $this->captcha();
		$this->render('category/admin_categoryEdit',null,array('back'));
	}

	public function admin_save(){
		$this->validation();
		if($this->input->post() && $this->form_validation->run('categorySave')):
			if($this->category_model->save($this->data['category']))
				$this->session->set_flashdata('success','Cập nhật chủng loại thành công');
			else
				$this->session->set_flashdata('error','Lỗi sql, thử lại');
			$this->site->back_erase('category');
		endif;
		redirect('/admincp/category');
	}

}