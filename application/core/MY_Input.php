<?php if (!defined('BASEPATH')) exit('No direct access allowed.');
class MY_Input extends CI_Input {

	public function __construct() {
	    $this->_POST_RAW = $_POST;
	    parent::__construct(); 
	}

	public function get_advantage() { 
    	return @$this->_POST_RAW['advantage'];
    }

    public function get_news_detail() {
    	return @$this->_POST_RAW['detail'];
    }
}