<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Test extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		
		/*
		 * ��������
		 * ��һ����ά���飬��¼�����б��γ齱�Ľ�����Ϣ��
		 * ����id��ʾ�н��ȼ���prize��ʾ��Ʒ��v��ʾ�н����ʡ�
		 * ע�����е�v����Ϊ����������Խ���Ӧ�� �����v���ó�0������ζ�Ÿý�����еļ�����0��
		 * ������v���ܺͣ�������������Խ��Խ�����ָ��ʵ�׼ȷ�ԡ�
		 * ������v���ܺ�Ϊ100����ôƽ����Զ�Ӧ�� �н����ʾ���1%��
		 * ���v���ܺ���10000�����н����ʾ������֮һ�ˡ�
		 *
		 */
		$prize_arr = array(
			'0' => array('id'=>1,'prize'=>'ƽ�����','v'=>1),
			'1' => array('id'=>2,'prize'=>'�´�û׼������Ŷ','v'=>0),
// 			'0' => array('id'=>1,'prize'=>'ƽ�����','v'=>1),
// 			'1' => array('id'=>2,'prize'=>'�������','v'=>2),
// 			'2' => array('id'=>3,'prize'=>'�����豸','v'=>3),
// 			'3' => array('id'=>4,'prize'=>'4G����','v'=>12),
// 			'4' => array('id'=>5,'prize'=>'10Q��','v'=>22),
// 			'5' => array('id'=>6,'prize'=>'�´�û׼������Ŷ','v'=>50),
		);
		foreach ($prize_arr as $key => $val) {
			$arr[$val['id']] = $val['v'];
		}
		$rid = $this->get_rand($arr); //���ݸ��ʻ�ȡ����id
		
		$res['yes'] = $prize_arr[$rid-1]['prize']; //�н���
		unset($prize_arr[$rid-1]); //���н�����������޳���ʣ��δ�н���
		shuffle($prize_arr); //��������˳��
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