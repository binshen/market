<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Test extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		
		/*
		 * 奖项数组
		 * 是一个二维数组，记录了所有本次抽奖的奖项信息，
		 * 其中id表示中奖等级，prize表示奖品，v表示中奖概率。
		 * 注意其中的v必须为整数，你可以将对应的 奖项的v设置成0，即意味着该奖项抽中的几率是0，
		 * 数组中v的总和（基数），基数越大越能体现概率的准确性。
		 * 本例中v的总和为100，那么平板电脑对应的 中奖概率就是1%，
		 * 如果v的总和是10000，那中奖概率就是万分之一了。
		 *
		 */
		$prize_arr = array(
			'0' => array('id'=>1,'prize'=>'平板电脑','v'=>1),
			'1' => array('id'=>2,'prize'=>'下次没准就能中哦','v'=>0),
// 			'0' => array('id'=>1,'prize'=>'平板电脑','v'=>1),
// 			'1' => array('id'=>2,'prize'=>'数码相机','v'=>2),
// 			'2' => array('id'=>3,'prize'=>'音箱设备','v'=>3),
// 			'3' => array('id'=>4,'prize'=>'4G优盘','v'=>12),
// 			'4' => array('id'=>5,'prize'=>'10Q币','v'=>22),
// 			'5' => array('id'=>6,'prize'=>'下次没准就能中哦','v'=>50),
		);
		foreach ($prize_arr as $key => $val) {
			$arr[$val['id']] = $val['v'];
		}
		$rid = $this->get_rand($arr); //根据概率获取奖项id
		
		$res['yes'] = $prize_arr[$rid-1]['prize']; //中奖项
		unset($prize_arr[$rid-1]); //将中奖项从数组中剔除，剩下未中奖项
		shuffle($prize_arr); //打乱数组顺序
		for($i=0;$i<count($prize_arr);$i++){
			$pr[] = $prize_arr[$i]['prize'];
		}
		$res['no'] = $pr;
		print_r($res);
	}

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
}