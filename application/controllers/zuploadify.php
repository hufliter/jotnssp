<?php

Class Zuploadify extends AppController{
   public function index(){
       $this->load->view('upload/index');
   }

   function uploadifyUploader(){
        $this->load->model('gallery_model');
        $this->gallery_model->do_upload(true);
    }
     function filemanipulations($extension,$filename)
        {
            // you can insert the result into the database if you want.
            if($this->is_image($extension)) 
            {
                $config['image_library']  = 'gd2';
                $config['source_image']   = './uploads/'.$filename;
                $config['new_image']      = './uploads/thumbs/';
                $config['create_thumb']   = TRUE;
                $config['maintain_ratio'] = TRUE;
                $config['thumb_marker']   = '';
                $config['width']   = 100;
                $config['height']   = 100;
 
                $this->load->library('image_lib', $config); 
 
                $this->image_lib->resize();
                echo 'image';
            }
            else echo 'file';
        }
         
        private function is_image($imagetype)
        {
            $ext = array(
                '.jpg',
                '.gif',
                '.png',
                '.bmp'
            );
            if(in_array($imagetype, $ext)) return true;
            else return false;
        }
 }