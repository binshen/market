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
		$this->buildWxData();
		$data = $this->sysconfig_model->get_index_info();
		$this->assign('news', $data['news']);
		$this->assign('projects', $data['projects']);
		$this->display('index.html');
	}
	
	public function get_project($id){
		$data = $this->sysconfig_model->get_project($id);
		$this->assign('detail', $data['detail']);
		$this->assign('news', $data['news']);
		$this->assign('pics', $data['pics']);
		$this->display('detail.html');
	}
	
	public function get_news($id){
		$data = $this->sysconfig_model->get_news_detail($id);
		$this->assign('detail', $data['detail']);
		$this->assign('list', $data['list']);
		$this->display('news_detail.html');
	}
}