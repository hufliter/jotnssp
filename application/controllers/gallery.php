<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Gallery extends AppController {
	public function __construct(){
		parent::__construct();
		$this->load->model('gallery_model');
		//$CI =& get_instance();
		//$this->load->library('upload');
	}

	public function admin_index(){
		$gallery = $this->gallery_model->getGallery();
		if(!empty($gallery) && is_array($gallery)):
			$this->load->library('pagination');

			$this->paginate['uri_segment'] = 4;
			$this->paginate['per_page'] = 60;
			$this->paginate['total_rows'] = count($gallery);
			$this->paginate['base_url'] = base_url().'admincp/gallery/index/';

			$this->pagination->initialize($this->paginate);

			$this->data['imgs'] = $this->gallery_model->paginate(
				$gallery, $this->uri->segment(4),$this->paginate['per_page']
			);

			$this->data['pagination_link'] = $this->pagination->create_links();
		else:
			$this->data['pagination_link'] = null;
		endif;

		$this->render('gallery/admin_index',
			array('jquery-ui','jquery.zclip.min'),array('back'));
	}

	public function admin_upload(){
		if($this->input->post()):
			$this->gallery_model->single_upload();
		endif;

		$this->render('gallery/admin_uploadify',array('uploadify/jquery.uploadify.min'),array('back','uploadify'));
	}

	public function admin_uploadAjax(){
		if(!empty($_FILES['userfile']))
			$this->gallery_model->single_upload(true);
		else
			echo json_encode(array(
				'status'=>'error','msg'=>'Không tìm thấy file cần upload'
			));
	}

	public function admin_delete(){
		if(!$this->input->post() || !$this->input->post('img'))
			redirect('/admincp/gallery');
		
		if($this->gallery_model->delete())
			$this->session->set_flashdata('success','Xóa hình thành công');
		else
			$this->session->set_flashdata('error','Xóa hình thất bại, thử lại');

		redirect('/admincp/gallery');
	}

	public function admin_listSet(){
		$this->validation();

		if($this->input->post() && $this->form_validation->run('galleryList')):
			if($this->gallery_model->set()):
				$this->session->set_flashdata('success','Đưa hình vào slide thành công');
				$this->site->back_erase(array('slide'));
			else:
				$this->session->set_flashdata('error','Lỗi sql hoặc slide đã có hình này');
			endif;			
		else:
			$this->session->set_flashdata('error','Không thể truy cập trực tiếp');
		endif;

		redirect('/admincp/gallery');
	}

	public function admin_listDelete(){
		$this->validation();

		if($this->input->post() && $this->form_validation->run('galleryList')):
			if($this->gallery_model->listDelete()):
				$this->session->set_flashdata('success','Xóa hình khỏi slide thành công');
				$this->site->back_erase('slide');
			else:
				$this->session->set_flashdata('error','Lỗi sql, thử lại');
			endif;
		else:
			$this->session->set_flashdata('error','Không thể truy cập trực tiếp');
		endif;

		redirect('/admincp/gallery/list');
	}
}