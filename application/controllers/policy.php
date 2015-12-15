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
		$this->render('policy/admin_index', null , array('back'));
	}
}
?>