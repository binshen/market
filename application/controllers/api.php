<?php

class Api extends MY_Controller {
	
	public $APP_ID = 'wx74ecabd9ee84aa89';
	public $APP_SECRET = '03aae99bb72ec4fd2aa592e9716d762e';
	
	public $CALL_TOKEN = '8654b302d5100247d2acc6211664c6f2';
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model('api_model');
	}
	
	public function index() {
		
		die("123");
	}
}