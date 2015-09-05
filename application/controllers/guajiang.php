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
			$scope = 'snsapi_base';
			$redirect_uri = urlencode('http://' . DOMAIN .'/guajiang/');
			$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.APP_ID.'&redirect_uri='.$redirect_uri.'&response_type=code&scope='.$scope.'&state='.$state.'#wechat_redirect';
			redirect($url);
		} else {
			$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.APP_ID.'&secret='.APP_SECRET.'&code='.$code.'&grant_type=authorization_code';
			$result = file_get_contents($url);
			$jsonInfo = json_decode($result, true);
			$wx_user = $this->api_model->get_or_create_wx_user($jsonInfo);
			$open_id = $wx_user['open_id'];
			
			$lottery = $this->api_model->get_guajiang();
			//$total = intval($lottery['total']);
			
			$prize_arr = array();
			$total_m = 0;
			for($i = 1; $i <= 6; $i++){
				$prize = $lottery['p' . $i];
				$m = intval($lottery['m' . $i]);
				if(!empty($prize)) {
					$prize_arr[] = array('id' => count($prize_arr)+1, 'prize' => $prize, 'v' => $m);
				}
				$total_m += $m;
			}
			
			$prize_arr[] = array('id' => count($prize_arr)+1, 'prize' => '谢谢参与', 'v' => intval($lottery['m7']));
			foreach ($prize_arr as $key => $val) {
				$arr[$val['id']] = $val['v'];
			}
			
			var_dump($arr);
			
			$rid = $this->get_rand($arr);
			
			$lottery['prize_id'] = $rid;
			$lottery['prize_title'] = $prize_arr[$rid-1]['prize'];
			
			$this->assign('lottery', $lottery);
			
			$this->display('guajiang.html');
		}
	}

	//抽奖概率算法
	function get_rand($proArr) {
		$result = '';
		$proSum = array_sum($proArr);
		foreach ($proArr as $key => $proCur) {
			$randNum = mt_rand(1, $proSum);
			if ($randNum <= $proCur) {
				$result = $key;
				break;
			} else {
				$proSum -= $proCur;
			}
		}
		unset ($proArr);
		return $result;
	}
	
	
	public function view() {
		
		$lottery = $this->api_model->get_guajiang();
		//$total = intval($lottery['total']);
		
		$prize_arr = array();
		$total_m = 0;
		for($i = 1; $i <= 6; $i++){
			$prize = $lottery['p' . $i];
			$m = intval($lottery['m' . $i]);
			$prize_arr[] = array('id' => count($prize_arr)+1, 'prize' => $prize, 'v' => $m);
			$total_m += $m;
		}
		$prize_arr[] = array('id' => 7, 'prize' => '谢谢参与', 'v' => intval($lottery['m7']));
		
		$lottery['usenums'] = true;//TODO
		
		$quota = $total_m + intval($lottery['m7']);
		if($quota > 0) {
			foreach ($prize_arr as $key => $val) {
				$arr[$val['id']] = $val['v'];
			}
			$rid = $this->get_rand($arr);
			
			$lottery['prize_id'] = $rid;
			$lottery['prize_title'] = $prize_arr[$rid-1]['prize'];
			if($lottery['usenums']) {
				$this->api_model->decrease_total_m($lottery['id'], $rid, $lottery['m'.$rid]-1);
			}
		} else {
			$lottery['status'] = 2;
		}
		
		$lottery['display_n'] = 1;//TODO
		$prizeStr = '<p>一等奖: '.$lottery['p1'];
		if ($lottery['display_n']){
			$prizeStr .= ' 奖品数量: '.$lottery['n1'];
		}
		$prizeStr .= '</p>';
		if ($lottery['p2']){
			$prizeStr .= '<p>二等奖: '.$lottery['p2'];
			if ($lottery['display_n']){
				$prizeStr.=' 奖品数量: '.$lottery['n2'];
			}
			$prizeStr .= '</p>';
		}
		if ($lottery['p3']){
			$prizeStr .= '<p>三等奖: '.$lottery['p3'];
			if ($lottery['display_n']){
				$prizeStr .= ' 奖品数量: '.$lottery['n3'];
			}
			$prizeStr .= '</p>';
		}
		$lottery['prizeStr'] = $prizeStr;
		
		$this->assign('lottery', $lottery);
		
		$this->display('guajiang.html');
	}
}