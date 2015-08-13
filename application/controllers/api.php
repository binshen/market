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
		
		$echoStr = $_GET["echostr"];
		if(isset($echoStr)) {
			if($this->checkSignature()){
				echo $echoStr;
				exit;
			}
		} else {
			$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
			if (!empty($postStr)){
				$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
				$RX_TYPE = trim($postObj->MsgType);
				switch ($RX_TYPE) {
					case "text":
						$result = $this->receiveText($postObj);
						break;
					case "event":
						$result = $this->receiveEvent($postObj);
						break;
					case "image":
						$result = $this->receiveImage($postObj);
						break;
					default:
						$result = "Unknow msg type: ".$RX_TYPE;
						break;
				}
				echo $result;
				exit;
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
		if($tmpStr == $signature){
			return true;
		} else {
			return false;
		}
	}

	public function get_qrcode() {
		
		$ticket_data = $this->get_ticket();
		$ticket = $ticket_data->ticket;
		echo 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . $ticket;
	}
	
	public function get_ticket() {
	
		$token_data = $this->api_model->get_or_create_token();
		var_dump($token_data);
		$access_token = $token_data['token'];
		$url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token;

		@$post_data->expire_seconds = 604800;
 		@$post_data->action_name = "QR_SCENE";
 		@$post_data->action_info->scene->scene_id = 1;

  		return json_decode($this->post($url, $post_data));
	}
	
	private function post($url, $post_data, $timeout = 300){
		$options = array(
			'http' => array(
				'method' => 'POST',
				'header' => 'Content-type:application/json',
				'content' => json_encode($post_data),
				'timeout' => 300
			)
		);
		$context = stream_context_create($options);
		return file_get_contents($url, false, $context);
	}
	
/////////////////
// 测试代码	
////////////////////////////////////////////////////////////////////////////////////////////////////////	
	private function receiveText($object) {
		$keyword = trim($object->Content);
		$result = "";
		if (preg_match('/^笑话[0-9]{8}$/',$keyword)){
			//include("jokes.php");
			$content = "这就是笑话:)"; //showContents($keyword);
			$result = $this->transmitText($object, $content);
		}elseif ($keyword == 'help' ||$keyword == '帮助') {
			$content = "帮助：1.查人品，回复RP名字，如RP张三  2.笑话，则回复笑话+日期，如：笑话20140319 3.看天气，回复城市名称，如TQ北京";
			$result = $this->transmitText($object, $content);
		}elseif(preg_match('/^(TQ)|(tq)[\x{4e00}-\x{9fa5}]+$/iu',$keyword)){
			//include("weather.php");
			$a = substr($keyword,2,strlen($keyword));
			$cityName = fromNameToCode($a);
			if ($cityName==''){
				$content = "帮助：1.查人品，回复RP名字，如RP张三  2.笑话，则回复笑话+日期，如：笑话20140319 3.看天气，回复城市名称，如TQ北京";
				$result = $this->transmitText($object, $content);
			}else{
				$content = "正在查询天气预报，请等待"; //getWeatherInfo($a);
				$result = $this->transmitNews($object, $content);
			}
		}elseif(preg_match('/^RP[\x{4e00}-\x{9fa5}a-zA-Z0-9]+$/iu',$keyword)){
			$a = substr($keyword,2,strlen($keyword));
			$content=$this->getMoralInfo($a);
			$result = $this->transmitText($object, $content);
		}else {
			$content = "帮助：1.查人品，回复RP名字，如RP张三  2.笑话，则回复笑话+日期，如：笑话20140319 3.看天气，回复城市名称，如TQ北京";
			$result = $this->transmitText($object, $content);
		}
		return $result;
	}
	
	private function receiveEvent($object) {
		$content = "";
		switch ($object->Event) {
			case "subscribe":
				$content = "欢迎关注宜居花桥房产超市。帮助：1.查人品，回复RP名字，如RP张三  2.笑话，则回复笑话+日期，如：笑话20140319 3.看天气，回复城市名称，如TQ北京";
				if (isset($object->EventKey)){
					$content = "关注二维码场景 " . $object->EventKey;
				}
				break;
			case "unsubscribe":
				$content = "取消关注";
				break;
			case "SCAN":
				$content = "扫描 " . $object->EventKey;
				break;
		}
		return $this->transmitText($object, $content);
	}
	
	private function receiveImage($object) {
		$apicallurl = urlencode("http://api2.sinaapp.com/recognize/picture/?appkey=0020120430&appsecert=fa6095e123cd28fd&reqtype=text&keyword=".$object->PicUrl);
		$pictureJsonInfo = file_get_contents($apicallurl);
		$pictureInfo = json_decode($pictureJsonInfo, true);
		$contentStr = $pictureInfo['text']['content'];
		$resultStr = $this->transmitText($object, $contentStr);
		return $resultStr;
	}
	
	
	private function transmitText($object, $content) {
		$textTpl = "
			<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[text]]></MsgType>
				<Content><![CDATA[%s]]></Content>
				<FuncFlag>0</FuncFlag>
			</xml>
		";
		return sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
	}
	
	private function transmitNews($object, $arr_item)
	{
		if(!is_array($arr_item))
			return;
	
		$itemTpl = "
			<item>
		        <Title><![CDATA[%s]]></Title>
		        <Description><![CDATA[%s]]></Description>
		        <PicUrl><![CDATA[%s]]></PicUrl>
		        <Url><![CDATA[%s]]></Url>
    		</item>
		";
		$item_str = "";
		foreach ($arr_item as $item)
			$item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
	
		$newsTpl = "
			<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[news]]></MsgType>
				<Content><![CDATA[]]></Content>
				<ArticleCount>%s</ArticleCount>
				<Articles>$item_str</Articles>
			</xml>
		";
		return sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item));
	}
	
	private function getUnicodeFromUTF8($word) {
		//获取其字符的内部数组表示，所以本文件应用utf-8编码！
		if (is_array( $word))
			$arr = $word;
		else
			$arr = str_split($word);
		//此时，$arr应类似array(228, 189, 160)
		//定义一个空字符串存储
		$bin_str = '';
		//转成数字再转成二进制字符串，最后联合起来。
		foreach ($arr as $value)
			$bin_str .= decbin(ord($value));
		//此时，$bin_str应类似111001001011110110100000,如果是汉字"你"
		//正则截取
		$bin_str = preg_replace('/^.{4}(.{4}).{2}(.{6}).{2}(.{6})$/','$1$2$3', $bin_str);
		//此时， $bin_str应类似0100111101100000,如果是汉字"你"
		return bindec($bin_str); //返回类似20320， 汉字"你"
		//return dechex(bindec($bin_str)); //如想返回十六进制4f60，用这句
	}
	
	private function getMoralInfo($name){
		$name = str_replace("+", "", $name);
		$f = mb_substr($name,0,1,'utf-8');
		$s = mb_substr($name,1,1,'utf-8');
		$w = mb_substr($name,2,1,'utf-8');
		$x = mb_substr($name,3,1,'utf-8');
		$n=($this->getUnicodeFromUTF8($f) + $this->getUnicodeFromUTF8($s) + $this->getUnicodeFromUTF8($w) + $this->getUnicodeFromUTF8($x)) % 100;
		$addd='';
		if(empty($name)){
			$addd="大哥不要玩我啊，名字都没有你想算什么！";
	
		} else if ($n <= 0) {
			$addd ="你一定不是人吧？怎么一点人品都没有？！";
		} else if($n > 0 && $n <= 5) {
			$addd ="算了，跟你没什么人品好谈的...";
		} else if($n > 5 && $n <= 10) {
			$addd ="是我不好...不应该跟你谈人品问题的...";
		} else if($n > 10 && $n <= 15) {
			$addd ="杀过人没有?放过火没有?你应该无恶不做吧?";
		} else if($n > 15 && $n <= 20) {
			$addd ="你貌似应该三岁就偷----看隔壁大妈洗澡的吧...";
		} else if($n > 20 && $n <= 25) {
			$addd ="你的人品之低下实在让人惊讶啊...";
		} else if($n > 25 && $n <= 30) {
			$addd ="你的人品太差了。你应该有干坏事的嗜好吧?";
		} else if($n > 30 && $n <= 35) {
			$addd ="你的人品真差!肯定经常做偷鸡摸狗的事...";
		} else if($n > 35 && $n <= 40) {
			$addd ="你拥有如此差的人品请经常祈求佛祖保佑你吧...";
		} else if($n > 40 && $n <= 45) {
			$addd ="老实交待..那些论坛上面经常出现的偷---拍照是不是你的杰作?";
		} else if($n > 45 && $n <= 50) {
			$addd ="你随地大小便之类的事没少干吧?";
		} else if($n > 50 && $n <= 55) {
			$addd ="你的人品太差了..稍不小心就会去干坏事了吧?";
		} else if($n > 55 && $n <= 60) {
			$addd ="你的人品很差了..要时刻克制住做坏事的冲动哦..";
		} else if($n > 60 && $n <= 65) {
			$addd ="你的人品比较差了..要好好的约束自己啊..";
		} else if($n > 65 && $n <= 70) {
			$addd ="你的人品勉勉强强..要自己好自为之..";
		} else if($n > 70 && $n <= 75) {
			$addd ="有你这样的人品算是不错了..";
		} else if($n > 75 && $n <= 80) {
			$addd ="你有较好的人品..继续保持..";
		} else if($n > 80 && $n <= 85) {
			$addd ="你的人品不错..应该一表人才吧?";
		} else if($n > 85 && $n <= 90) {
			$addd ="你的人品真好..做好事应该是你的爱好吧..";
		} else if($n > 90 && $n <= 95) {
			$addd ="你的人品太好了..你就是当代活雷锋啊...";
		} else if($n > 95 && $n <= 99) {
			$addd ="你是世人的榜样！";
		} else if($n > 100 && $n < 105) {
			$addd ="天啦！你不是人！你是神！！！";
		}else if($n > 105 && $n < 999) {
			$addd="你的人品已经过 100 人品计算器已经甘愿认输，3秒后人品计算器将自杀啊";
		} else if($n > 999) {
			$addd ="你的人品竟然负溢出了...我对你无语..";
		}
		return $name."的人品分数为：".$n."\n".$addd;
	}
}