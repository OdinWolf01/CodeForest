<?php

class xss_filter {

	
	private $allow_http_value = false;

	
	private $input;
	
	private $preg_patterns = array(
		
		'!(&#0+[0-9]+)!' => '$1;',
		'/(&#*\w+)[\x00-\x20]+;/u' => '$1;>',
		'/(&#x*[0-9A-F]+);*/iu' => '$1;',
		
		'#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu' => '$1>',
		
		'#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu' => '$1=$2nojavascript...',
		'#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu' => '$1=$2novbscript...',
		'#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u' => '$1=$2nomozbinding...',
		
		'#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i' => '$1>',
		'#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu' => '$1>',
		// namespace elements
		'#</*\w+:\w[^>]*+>#i' => '',
		//unwanted tags
		'#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i' => ''
	);

	
	private $normal_patterns = array(
		'\'' => '&apos;',
		'"' => '&quot;',
		'&' => '&amp;',
		'<' => '&lt;',
		'>' => '&gt;',
		
		'SELECT * FROM' => '',
		'SELECT(' => '',
		'SLEEP(' => '',
		'AND (' => '',
		' AND' => '',
		'(CASE' => ''
	);

	
	public function filter_it($input){
		$this->input = html_entity_decode($input, ENT_NOQUOTES, 'UTF-8');
		$this->normal_replace();
		$this->do_grep();
		return $this->input;
	}

	
	public function allow_http(){
		$this->allow_http_value = true;
	}

	
	public function disallow_http(){
		$this->allow_http_value = false;
	}

	
	public function remove_get_parameters($url){
		return preg_replace('/\?.*/', '', $url);
	}

	
	private function normal_replace(){
		$this->input = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $this->input);
		if($this->allow_http_value === false){
			$this->input = str_replace(array('&', '%', 'script', 'http', 'localhost'), array('', '', '', '', ''), $this->input);
		}
		else
		{
			$this->input = str_replace(array('&', '%', 'script', 'localhost', '../'), array('', '', '', '', ''), $this->input);
		}
		foreach($this->normal_patterns as $pattern => $replacement){
			$this->input = str_replace($pattern,$replacement,$this->input);
		}
	}

	
	private function do_grep(){
		foreach($this->preg_patterns as $pattern => $replacement){
			$this->input = preg_replace($pattern,$replacement,$this->input);
		}
	}
}
