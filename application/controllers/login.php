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
class Login extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$this->display('login.html');
	}
	
	public function check_login(){
		$rs = $this->sysconfig_model->check_login();
		if($rs == 1){
			$this->show_message('登陆成功',site_url('index'));
		}else{
			$this->show_message('用户名或密码错误',site_url('index'));
		}
	}
	

	/**
	 * 退出登录，并定向到登录页
	 */
	public function logout(){
		$this->session->sess_destroy();
		redirect(site_url('index'));
	}
	
}