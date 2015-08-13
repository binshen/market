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
class Register extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('captcha');
	}
	
	public function index() {
		$this->display('register.html');
	}
	
	public function post_register(){
		if($this->input->post('captcha') != $this->session->userdata('captcha')){
			$this->show_message('验证码错误');
		}
		$rs = $this->sysconfig_model->post_register();
		if($rs == -2){
			$this->show_message('用户名已经存在');
		}else if($rs == -1){
			$this->show_message('注册失败，请联系管理员');
		}else{
			$this->show_message('注册成功',site_url('index'));
		}
	}
	
	public function get_captcha(){
		$vals = array(
				'img_path' => './././captcha/',
				'img_url' => base_url().'captcha/',
				'ip_address' => $this->input->ip_address(),
				'word' => rand(1000,9999),
				'img_width' => 108,
				'img_height' => 34,
				'expiration' => 300
		);
		
		$cap = create_captcha($vals);
		$this->session->set_userdata('captcha', $cap['word']);
		echo $cap['image'];
	}
}