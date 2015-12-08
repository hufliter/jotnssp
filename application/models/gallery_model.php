<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Gallery_model extends CI_Model {
	public $path = "";
	public $url = "";
	public $imgName = null;

	public function __construct(){
		parent::__construct();
		$this->url = base_url()."assets/upload/";
		$this->path = realpath(APPPATH . "../assets/upload");
		$this->load->database();
	}

	public function do_upload($ajax = false){
		$source = array();
		$conf = array(
			'upload_path' => $this->path,
			'allowed_types' => 'gif|jpg|png|jpeg|dll|JPG|JPEG|PNG|GIF',
			'max_size' => '10240',
			'encrypt_name' => true,
			'max_width' => '1200',
			'max_height' => '800'
		);
		$this->load->library('upload');
		$this->upload->initialize($conf);
		if(!$this->upload->do_multi_upload('userfile',true)):
			if(!$ajax):
				$this->session->set_flashdata('error',$this->upload->display_errors('',''));
			else:
				$status = 'error';
				$msg = $this->upload->display_errors('','');
			endif;
		else:
			$data = $this->upload->get_multi_upload_data();
			if(!$ajax):
				$this->session->set_flashdata('success','Upload hình thành công');
			else:
				$status = 'success';
				$msg = 'File upload successfully';
			endif;
		endif;
		//create thumb
		//https://github.com/stvnthomas/CodeIgniter-Multi-Upload
		if(empty($data))
			$data = array($this->upload->data());


			$this->load->library('image_lib');
			foreach($data as $v):
				$conf = array(
					'source_image' => $v['full_path'],
					'new_image' => $this->path . '/thumbs',
					'maintain_ratio' => true,
					'width' => '150','height' => '150'
				);
				$this->image_lib->initialize($conf);
				$this->image_lib->resize();

				if($ajax)
					$source[] = array(
						'thumb'=>base_url().'assets/upload/thumbs/'.$v['file_name'],
						'img'=>base_url().'assets/upload/'.$v['file_name']
					);
			endforeach;

		if($ajax)
			echo json_encode(array(
				'status'=>$status,'msg'=>$msg,'source'=>$source
			));
		else
			redirect('/admincp/gallery');
		exit();
	}

	public function single_upload($ajax = true){
		$conf = array(
			'upload_path' => $this->path,
			'allowed_types' => 'gif|jpg|png|jpeg|JPG|JPEG|PNG|GIF',
			'max_size' => '10240',
			'encrypt_name' => true,
			'max_width' => '3000',
			'max_height' => '3000'
		);

		$this->load->library('upload', $conf);
		if(!$this->upload->do_upload('userfile')):
			if(!$ajax):
				$this->session->set_flashdata('error',$this->upload->display_errors());
			else:
				$status = 'error';
				$msg = $this->upload->display_errors('','');
			endif;
		else:
			$data = $this->upload->data();
			if(!$ajax):
				$this->session->set_flashdata('success','Upload hình thành công');
			else:
				$status = 'success';
				$msg = 'File upload successfully';
			endif;
		endif;

		//create thumb
		$conf = array(
			'source_image' => $data['full_path'],
			'new_image' => $this->path . '/thumbs',
			'maintain_ratio' => true,
			'width' => '150','height' => '100'
		);
		$this->load->library('image_lib',$conf);
		$this->image_lib->resize();

		if($ajax):
			$source = array(
				'thumb'=>base_url().'assets/upload/thumbs/'.$data['file_name'],
				'img'=>base_url().'assets/upload/'.$data['file_name']
			);
			echo json_encode(array('status'=>$status,'msg'=>$msg,'thumb'=>$source['thumb'],'img'=>$source['img']));
			exit();
		else:
			redirect('/admincp/gallery');
		endif;
	}

	public function get(){
		$f = scandir($this->path);
		$f = array_diff($f, array('.','..','thumbs','index.html'));

		$imgs = array();
		foreach($f as $img)
			$imgs[$v->getMTime()] = array(
				'url' => $this->url.$img,
				'thumb' => $this->url . 'thumbs/' . $img,
				'name' => $img
			);
		return $imgs;
	}

	public function delete(){
		$arr = explode('.', $this->input->post('img'));
		$img = url_title(array_shift($arr));
		$ext = url_title(array_pop($arr));

		$link = $this->path. DIRECTORY_SEPARATOR . $img.'.'.$ext ;
		if(file_exists($link)):
			@unlink($link);
			@unlink($this->path. DIRECTORY_SEPARATOR . 'thumbs' . DIRECTORY_SEPARATOR . $img.'.'.$ext);			
			$this->imgName = $this->input->post('img');
			$this->listDelete(true);
			return true;
		endif;
		return false;
	}

	public function getGallery(){
		$f = array();
		/* php >= 5.3
		$a = new FilesystemIterator($this->path);
		foreach($a as $v)
			if($v->isFile() && in_array(strtolower($v->getExtension()), array('jpg','png','gif','jpeg')) )
				$f[] = array(
					'url' => $this->url.$v->getFileName(),
					'thumb' => $this->url.'thumbs/'.$v->getFileName(),
					'name' => $v->getFileName(),
					'time' => $v->getMTime()
				);

		usort($f,function($a,$b){
			return $b['time'] - $a['time'];
		});
		*/
		$a = glob($this->path.DIRECTORY_SEPARATOR.'*.{jpg,jpeg,png,gif}', GLOB_BRACE);
		foreach($a as $fName)
			$f[] = array(
				'url' => $this->url.basename($fName),
				'thumb' => $this->url.'thumbs/'.basename($fName),
				'name' => basename($fName),
				'time' => filemtime($fName)
			);
		$func = create_function('$a, $b','return ($b["time"] - $a["time"]);');
		usort($f, $func);

		return $f;
	}

	public function paginate($source, $start = 0, $limit){
		$max = count($source);

		if(empty($start) || $start <0)
			$start = 0;
		elseif($start > $max)
			$start = $max;

		return array_slice($source, $start, $limit);
	}

	public function set(){
		$count = $this->db->get_where('slide',array('img'=>$this->input->post('img')))->num_rows;
		if($count != 0)
			return false;

		$data = array(
			'img' => $this->input->post('img')
		);

		return $this->db->insert('slide',$data);
	}

	public function listDelete($local = false){
		if(!empty($local) && !empty($this->imgName))
			$this->db->where('img',$this->imgName);
		else
			$this->db->where('img', $this->input->post('img'));
		$this->site->back_erase(array('slide'));
		return $this->db->delete('slide');
	}

	public function fetch($start = 0, $limit = 0){
		$start = $start ? $start : 0;

		$this->db->limit($limit, $start);
		$this->db->order_by('id','desc');

		return $this->db->get('slide')->result_array();
	}
}