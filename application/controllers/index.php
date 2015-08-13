<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 站点首页控制器
 *
 * @package		app
 * @subpackage	core
 * @category	controller
 * @author		bin.shen
 *
 */
class Index extends MY_Controller {

	public function __construct() {
		parent::__construct();

	}
	
	public function index() {
		$data = $this->sysconfig_model->get_index_info();
		
		$this->assign('news1', $data['news1']);
		$this->assign('news2', $data['news2']);
		$this->assign('news3', $data['news3']);
		$this->assign('news4', $data['news4']);
		$this->assign('news5', $data['news5']);
		
		$this->assign('style_list_1', $data['region_list']);
		$this->assign('style_list_2', array(
			array('id' => 1, 'name' => '一室'),
			array('id' => 2, 'name' => '二室'),
			array('id' => 3, 'name' => '三室'),
			array('id' => 4, 'name' => '四室'),
			array('id' => 5, 'name' => '五室'),
			array('id' => 6, 'name' => '五室以上')
		));
		$this->assign('style_list_3', $data['style_list_2']);
		$this->assign('style_list_4', $data['style_list_3']);
		$this->assign('style_list_5', $data['style_list_4']);
		$this->assign('style_list_6', array(
			array('id' => 1, 'name' => '50㎡以下'),
			array('id' => 2, 'name' => '50-70㎡'),
			array('id' => 3, 'name' => '70-90㎡'),
			array('id' => 4, 'name' => '90-120㎡'),
			array('id' => 5, 'name' => '120-150㎡'),
			array('id' => 6, 'name' => '150-200㎡'),
			array('id' => 7, 'name' => '200-300㎡'),
			array('id' => 8, 'name' => '300㎡以上')
		));
		$this->assign('style_list_7', $data['region_list']);
		
		$this->display('index.html');
	}
}