<?php if(!defined("BASEPATH")){ exit("No direct script access allowed"); }

class MY_Form_validation extends CI_Form_validation {

	public function isBool($str){
		$this->set_message('isBool','%s is not boolean');
		return (is_string($str) && ($str == '0' || $str == '1'));
	}

	public function captcha($str){
		$this->set_message('captcha','Captcha doesnt match');
		if(empty($str) || $this->CI->session->userdata('captcha')==false)
			return false;

		$capt = $this->CI->session->userdata('captcha');
		$this->CI->session->unset_userdata('captcha');
		if(strcmp($capt,$str) == 0)
			return true;
		return false;
	}
}