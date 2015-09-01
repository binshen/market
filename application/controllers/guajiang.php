<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Guajiang extends MY_Controller {

	public function __construct() {
		parent::__construct();
		
	}
	
	public function index() {
		
		if(empty($_GET['code'])){
			$redirect_uri = 'http://' . DOMAIN .'/guajiang';
			$state = 'ggk_1';
			$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.APP_ID.'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_base&state='.$state.'#wechat_redirect';
			redirect(urlencode($url));
		} else {
			$result = file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$secret}&code={$_GET['code']}&grant_type=authorization_code");
			$jsonInfo = json_decode($result,true);
			//$access_token = $jsonInfo["access_token"];
			//$openid = $jsonInfo["openid"];
			var_dump($jsonInfo);
		}
	}
	
	public function view() {
		
		$this->display('guajiang.html');
	}
}