<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Guajiang extends MY_Controller {

	public function __construct() {
		parent::__construct();
		
	}
	
	public function index() {
		
		$redirect_uri = 'http://' . DOMAIN .'/guajiang/view';
		$state = 'ggk_1';
		$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.APP_ID.'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_base&state='.$state.'#wechat_redirect';
		$result = file_get_contents(urlencode($url));
		var_dump($result);
		
		
	}
	
	public function view() {
		
		$this->display('guajiang.html');
	}
}