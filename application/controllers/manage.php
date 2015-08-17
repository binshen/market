<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 后台画面控制器
 *
 * @package		app
 * @subpackage	core
 * @category	controller
 * @author		yaobin<645894453@qq.com>
 *
 */
class Manage extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('manage_model');
		$this->load->library('image_lib');
		$this->load->helper('directory');

	}

	function _remap($method,$params = array())
	{
		if(! $this->session->userdata('username'))
		{
			if($this->input->is_ajax_request()){
				header('Content-type: text/json');
				echo '{
                        "statusCode":"301",
                        "message":"\u4f1a\u8bdd\u8d85\u65f6\uff0c\u8bf7\u91cd\u65b0\u767b\u5f55\u3002"
                    }';
			}else{
				redirect(site_url('manage_login/login'));
			}

		}else{
			return call_user_func_array(array($this, $method), $params);
		}
	}

	public function index()
	{
		$this->load->view('manage/index.php');
	}

	/**
	 * 开发商管理
	 */
	public function list_customer() {
		$data = $this->manage_model->list_customer();
		$this->load->view('manage/list_customer.php', $data);
	}
	
	public function add_customer() {
		$this->load->view('manage/add_customer.php');
	}
	
	public function save_customer() {
		$ret = $this->manage_model->save_customer();
		if($ret == 1){
			form_submit_json("200", "操作成功", 'list_customer');
		} else {
			form_submit_json("300", "保存失败");
		}
	}
	
	public function edit_customer($id) {
		$data = $this->manage_model->get_customer($id);
		$this->load->view('manage/add_customer.php', $data);
	}
	
	public function delete_customer($id) {
		$ret = $this->manage_model->delete_customer($id);
		if($ret == 1) {
			form_submit_json("200", "操作成功", 'list_customer', '', '');
		} else {
			form_submit_json("300", "删除失败");
		}
	}
	
	/**
	 * 装修状况
	 */
	public function list_decoration() {
		$data = $this->manage_model->list_decoration();
		$this->load->view('manage/list_decoration.php', $data);
	}
	
	public function add_decoration() {
		$this->load->view('manage/add_decoration.php');
	}
	
	public function save_decoration() {
		$ret = $this->manage_model->save_decoration();
		if($ret == 1){
			form_submit_json("200", "操作成功", 'list_decoration');
		} else {
			form_submit_json("300", "保存失败");
		}
	}
	
	public function edit_decoration($id) {
		$data = $this->manage_model->get_decoration($id);
		$this->load->view('manage/add_decoration.php', $data);
	}
	
	public function delete_decoration($id) {
		$ret = $this->manage_model->delete_decoration($id);
		if($ret == 1) {
			form_submit_json("200", "操作成功", 'list_decoration', '', '');
		} else {
			form_submit_json("300", "删除失败");
		}
	}
	
	/**
	 * 楼盘管理
	 */
	public function list_house() {
		$data = $this->manage_model->list_house();
		$this->load->view('manage/list_house.php', $data);
	}
	
	public function add_house() {
		$data['decoration_list'] = $this->manage_model->get_decoration_list();
		$this->load->view('manage/add_house.php', $data);
	}
	
	public function save_house() {
		$ret = $this->manage_model->save_house();
		if($ret == 1){
			form_submit_json("200", "操作成功", 'list_house');
		} else {
			form_submit_json("300", "保存失败");
		}
	}
	
	public function edit_house($id) {
		$data = $this->manage_model->get_house($id);
		$data['decoration_list'] = $this->manage_model->get_decoration_list();
		$this->load->view('manage/add_house.php', $data);
	}
	
	public function delete_house($id) {
		$ret = $this->manage_model->delete_house($id);
		if($ret == 1) {
			form_submit_json("200", "操作成功", 'list_house', '', '');
		} else {
			form_submit_json("300", "删除失败");
		}
	}
}
