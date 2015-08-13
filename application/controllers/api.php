<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!defined('APP_ID')) define('APP_ID', 'wx74ecabd9ee84aa89');
if(!defined('APP_SECRET')) define('APP_SECRET', '03aae99bb72ec4fd2aa592e9716d762e');
if(!defined('TOKEN')) define('TOKEN', '8654b302d5100247d2acc6211664c6f2');
 
class Api extends MY_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->load->model('api_model');
	}
	
	public function index() {
		//$access_token = $this->api_model->get_or_create_token();
		//var_dump($access_token);
		
		$echoStr = $_GET["echostr"];
		if(!empty($echoStr)) {
			if($this->checkSignature()){
				echo $echoStr;
				exit;
			}
		} else {
			$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
			if (!empty($postStr)){
				$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
				$fromUsername = $postObj->FromUserName;
				$toUsername = $postObj->ToUserName;
				$keyword = trim($postObj->Content);
				$time = time();
				$textTpl = "
					<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
					</xml>
				";
				if(!empty( $keyword )) {
					$msgType = "text";
					$contentStr = "Welcome to wechat world!";
					$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
					echo $resultStr;
				}else{
					echo "Input something...";
				}
			} else {
				echo "";
				exit;
			}
		}
	}
	
	private function checkSignature() {
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce = $_GET["nonce"];
	
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
	
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}