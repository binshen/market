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
	 * 客户信息
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
}
