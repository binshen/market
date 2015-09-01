<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Guajiang extends MY_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->load->model('api_model');
	}
	
	public function index() {
		
		$code = $_GET['code'];
		if(empty($code)){
			$state = 'ggk_1';
			$redirect_uri = urlencode('http://' . DOMAIN .'/guajiang/');
			$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.APP_ID.'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_base&state='.$state.'#wechat_redirect';
			redirect($url);
		} else {
			$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.APP_ID.'&secret='.APP_SECRET.'&code='.$code.'&grant_type=authorization_code';
			$result = file_get_contents($url);
			$jsonInfo = json_decode($result, true);
			$this->api_model->get_or_create_wx_user($jsonInfo);
			
			$this->display('guajiang.html');
		}
	}
}