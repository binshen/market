<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
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

	private function get_house_message($house) {
		$content = array();
		$content[] = array(
			'Title' => $house['name'],
			'Description' => '',
			'PicUrl' => 'http://' . DOMAIN . '/uploadfiles/pics/' . $house['bg_pic'],
			'Url' => 'http://' . DOMAIN . '/index/get_project/' . $house['id']
		);
		
		$newsList = $this->api_model->get_news_by_hid($house['id']);
		foreach ($newsList as $news) {
			$content[] = array(
				'Title' => $news['title'],
				'Description' => '',
				'PicUrl' => 'http://' . DOMAIN . '/uploadfiles/news/' . $news['pic'],
				'Url' => 'http://' . DOMAIN .'/index/get_news/' . $news['id']
			);
		}
		return $content;
	}
	
	private function get_guajiang_message() {
		$state = 'ggk_1';
		$redirect_uri = 'http://' . DOMAIN .'/guajiang/';
		$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.APP_ID.'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_base&state='.$state.'#wechat_redirect';
		$content = array();
		$content[] = array(
			'Title' => '刮刮卡 ',
			'Description' => '刮刮卡活动测试',
			'PicUrl' => 'http://' . DOMAIN . '/css/guajiang/images/ggk.jpg',
			'Url' => $url //'http://' . DOMAIN .'/guajiang/'
		);
		return $content;
	}
	
	private function receiveText($object) {
		$keyword = trim($object->Content);
		if($keyword == '刮刮卡') {
			$content = $this->get_guajiang_message();
			return $this->transmitNews($object, $content);
		}
		$house = $this->api_model->get_house_by_keyword($keyword);
		if(empty($house)) {
			$content = "找不到对应的楼盘。可选的关键字有：" . $this->api_model->get_all_keywords();
			return $this->transmitText($object, $content);
		} else {
			$content = $this->get_house_message($house);
			return $this->transmitNews($object, $content);
		}
	}
	
	private function receiveEvent($object) {
		$content = "";
		switch ($object->Event) {
			case "subscribe":
				$content = "欢迎关注宜居花桥房产超市微信公众号。可输入关键字查找楼盘。可选的关键字有：" . $this->api_model->get_all_keywords();
				if (!empty($object->EventKey)){
					$h_id = str_replace("qrscene_", "", $object->EventKey);
					$house = $this->api_model->get_house_by_id($h_id);
					if(empty($house)) {
						$content = "该楼盘不存在，可输入关键字查找楼盘。可选的关键字有：" . $this->api_model->get_all_keywords();
					} else {
						$content = $this->get_message($house);
						return $this->transmitNews($object, $content);
					}
				}
				break;
			case "unsubscribe":
				$content = "取消关注";
				break;
			case "SCAN":
				$house = $this->api_model->get_house_by_id($object->EventKey);
				if(empty($house)) {
					$content = "该楼盘不存在，可输入关键字查找楼盘。可选的关键字有：" . $this->api_model->get_all_keywords();
				} else {
					$content = $this->get_message($house);
					return $this->transmitNews($object, $content);
				}
				break;
			case "CLICK":
				$content = "点击菜单拉取消息： " . $object->EventKey;
				break;
			case "VIEW":
				$content = "点击菜单跳转链接： " . $object->EventKey;
				break;
			case "LOCATION":
				$content = "上传位置：纬度 " . $object->Latitude . ";经度 " . $object->Longitude;
				break;
		}
		return $this->transmitText($object, $content);
	}
	

	////////////////////////////////////////////////////////////////////////////////////////////////////////
	// 以下是帮助用API
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function get_token() {
		$token_data = $this->api_model->get_or_create_token();
		echo $token_data['token'];
	}
	
	public function get_qrcode($h_id) {
		$ticket_data = $this->api_model->get_or_create_ticket($h_id);
		$ticket = $ticket_data['ticket'];
		echo "<img src='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$ticket'>";
	}
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	// 以下是测试代码
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function test() {
// 		$a = '上海';
// 		$cityCode = $this->api_model->get_city_code($a);
// 		$content = $this->getWeatherInfo($cityCode);
// 		//var_dump($content);
// 		@$object->FromUserName = 'aaaa';
// 		@$object->ToUserName = 'bbbb';
// 		$result = $this->transmitNews($object, $content);
// 		echo($result);
		$keywords = $this->api_model->get_news_by_hid(4);
		var_dump($keywords);
	}
	
// 	public function get_qrcode($scene_id, $action_name = 'QR_SCENE') {
		
// 		$ticket_data = $this->get_ticket($scene_id, $action_name);
// 		var_dump($ticket_data);
		
// 		$ticket = $ticket_data->ticket;
// 		echo "<img src='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$ticket'>";
// 	}
	
// 	private function get_ticket($scene_id, $action_name = 'QR_LIMIT_SCENE') {
	
// 		$token_data = $this->api_model->get_or_create_token();
// 		$access_token = $token_data['token'];
// 		$url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token;

// 		//@$post_data->expire_seconds = 604800;
//  		@$post_data->action_name = $action_name;
//  		@$post_data->action_info->scene->scene_id = $scene_id;

//   		return json_decode($this->api_model->post($url, $post_data));
// 	}
		
	private function receiveText2($object) {
		$keyword = trim($object->Content);
		$result = "";
		if (preg_match('/^笑话[0-9]{8}$/',$keyword)){
			$content = "这就是笑话:)"; //showContents($keyword);
			$result = $this->transmitText($object, $content);
		}elseif ($keyword == 'help' ||$keyword == '帮助') {
			$content = "帮助：1.查人品，回复RP名字，如RP张三  2.笑话，则回复笑话+日期，如：笑话20140319 3.看天气，回复城市名称，如TQ北京";
			$result = $this->transmitText($object, $content);
		}elseif(preg_match('/^(TQ)|(tq)[\x{4e00}-\x{9fa5}]+$/iu',$keyword)){
			$a = substr($keyword,2,strlen($keyword));
			$cityCode = $this->api_model->get_city_code($a);
			if ($cityCode==''){
				$content = "帮助：1.查人品，回复RP名字，如RP张三  2.笑话，则回复笑话+日期，如：笑话20140319 3.看天气，回复城市名称，如TQ北京";
				$result = $this->transmitText($object, $content);
			}else{
				$content = $this->getWeatherInfo($cityCode);
				$result = $this->transmitNews($object, $content);
			}
		}elseif(preg_match('/^RP[\x{4e00}-\x{9fa5}a-zA-Z0-9]+$/iu',$keyword)){
			$a = substr($keyword,2,strlen($keyword));
			$content=$this->getMoralInfo($cityCode);
			$result = $this->transmitText($object, $content);
		}else {
			$content = "帮助：1.查人品，回复RP名字，如RP张三  2.笑话，则回复笑话+日期，如：笑话20140319 3.看天气，回复城市名称，如TQ北京";
			$result = $this->transmitText($object, $content);
		}
		return $result;
	}
	
	private function receiveEvent2($object) {
		$content = "";
		switch ($object->Event) {
			case "subscribe":
				$content = "欢迎关注宜居花桥房产超市。帮助：1.查人品，回复RP名字，如RP张三  2.笑话，则回复笑话+日期，如：笑话20140319 3.看天气，回复城市名称，如TQ北京";
				if (isset($object->EventKey)){
					$content = "关注二维码场景： " . $object->EventKey;
				}
				break;
			case "unsubscribe":
				$content = "取消关注";
				break;
			case "SCAN":
				$content = "扫描场景： " . $object->EventKey;
				break;
			case "CLICK":
				$content = "点击菜单拉取消息： " . $object->EventKey;
				break;
			case "VIEW":
				$content = "点击菜单跳转链接： " . $object->EventKey;
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
	
	function getWeatherInfo($cityCode) {
		
		//获取实时天气
		$url = "http://www.weather.com.cn/data/sk/".$cityCode.".html";
		$output = file_get_contents($url);
		$weather = json_decode($output, true);
		$info = $weather['weatherinfo'];
		$weatherArray = array();
		$weatherArray[] = array("Title"=>$info['city']."天气预报", "Description"=>"", "PicUrl"=>"", "Url" =>"");
		if ((int)$cityCode < 101340000){
			$result = "实况 温度：".$info['temp']."℃ 湿度：".$info['SD']." 风速：".$info['WD'].$info['WSE']."级";
			$weatherArray[] = array("Title"=>str_replace("%", "﹪", $result), "Description"=>"", "PicUrl"=>"", "Url" =>"");
		}
		
		//获取六日天气
		$url = "http://m.weather.com.cn/data/".$cityCode.".html";
		$output = file_get_contents($url);
		$weather = json_decode($output, true);
		$info = $weather['weatherinfo'];
		
		if (!empty($info['index_d'])){
			$weatherArray[] = array("Title" =>$info['index_d'], "Description" =>"", "PicUrl" =>"", "Url" =>"");
		}
		
		$weekArray = array("日","一","二","三","四","五","六");
		$maxlength = 3;
		for ($i = 1; $i <= $maxlength; $i++) {
			$offset = strtotime("+".($i-1)." day");
			$subTitle = date("m月d日",$offset)." 周".$weekArray[date('w',$offset)]." ".$info['temp'.$i]." ".$info['weather'.$i]." ".$info['wind'.$i];
			$weatherArray[] = array("Title" =>$subTitle, "Description" =>"", "PicUrl" =>"http://discuz.comli.com/weixin/weather/"."d".sprintf("%02u",$info['img'.(($i *2)-1)]).".jpg", "Url" =>"");
		}
		
		return $weatherArray;
	}
}