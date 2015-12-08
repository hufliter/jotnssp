<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Site {
	public $x = null;
	public $type = array('overview','favorite','category','config','lastProduct','hotProduct','lastNews', 'mainAds');

	public function __construct($param){
		$this->x = $param['x'];

		$this->x->load->driver('cache',array('adapter'=>'file'));
		$this->cache =& $this->x->cache->file;
	}

	public function back($type = null, $force = false){
		if(empty($type) || empty($this->x))
			return false;
    /**
    bỏ lưu cache
     */
//		if(!$force):
//			$data = $this->getCache($type);
//			if(!empty($data))
//				return $data;
//		endif;

		$data = array();
		if($type == 'all'):
			$data = array(
				'overview'=>$this->x->dashboard_model->overview(),
				'favorite'=>$this->x->dashboard_model->favorite(),
				'lastProduct'=>$this->x->dashboard_model->lastProduct(),
				'hotProduct'=>$this->x->dashboard_model->hotProduct(),
				'lastNews'=>$this->x->dashboard_model->lastNews(),
				'config'=>$this->x->dashboard_model->config(),
				'category'=>$this->x->dashboard_model->category(),
                'mainAds'=>$this->x->dashboard_model->mainAds(),
			);
			foreach($this->type as $v)
				$this->cache->save($v, $data[$v], 259200);
		else:
			foreach($this->type as $v)
				if($v == $type):
					$data[$type] = $this->x->dashboard_model->{$v}();
					$this->cache->save($v, $data[$type], 259200);
				endif;
		endif;

		return $data;
	}

	public function back_erase($type = null){
		if(empty($type) || $type == 'all')
			foreach($this->type as $v)
				$this->cache->delete($v);

		elseif(is_string($type) && in_array($type, $this->type))
			$this->cache->delete($type);

		elseif(is_array($type))
			foreach($type as $v)
				if(in_array($v, $this->type))
					$this->cache->delete($v);
	}

	public function getCache($type){
		$data = $reSelect = array();

		if($type == 'all'):
			foreach($this->type as $v):
				$data[$v] = $this->cache->get($v);
				if(empty($data[$v]))
					$reSelect[] = $v;
			endforeach;
		elseif(in_array($type, $this->type)):
			$data[$type] = $this->cache->get($type);
			if(empty($data[$type]))
				$reSelect[] = $type;
		endif;

		if(empty($reSelect)):
			return $data;
		elseif(count($reSelect) == count($this->type)):
			return false;

		elseif(count($reSelect > 0)):
			foreach($reSelect as $v):
				$data[$v] = $this->x->dashboard_model->{$v}();
				$this->cache->save($v, $data[$v], 259200);
			endforeach;
			return $data;
		endif;

		return false;
	}
}