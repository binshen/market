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
		$this->load->model('api_model');
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
	
	//$flag如果存在则是选择户型
	public function add_pics($time,$type_id,$flag=null){
		$data['time'] = $time;
		$data['type_id'] = $type_id;
		$data['flag'] = $flag;
	
		$this->load->view('manage/add_pics.php',$data);
	}
	
	public function save_pics($time,$type_id){
		if (is_readable('./././uploadfiles/pics/'.$time) == false) {
			mkdir('./././uploadfiles/pics/'.$time);
		}
	
		if (is_readable('./././uploadfiles/pics/'.$time.'/'.$type_id) == false) {
			mkdir('./././uploadfiles/pics/'.$time.'/'.$type_id);
		}
	
		$path = './././uploadfiles/pics/'.$time.'/'.$type_id;
	
		//设置缩小图片属性
		$config_small['image_library'] = 'gd2';
		$config_small['create_thumb'] = TRUE;
		$config_small['quality'] = 80;
		$config_small['maintain_ratio'] = TRUE; //保持图片比例
		$config_small['new_image'] = $path;
		$config_small['width'] = 300;
		$config_small['height'] = 190;
	
		//设置原图限制
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '10000';
		$config['encrypt_name'] = true;
		$this->load->library('upload', $config);
	
		if($this->upload->do_upload()){
			$data = $this->upload->data();//返回上传文件的所有相关信息的数组
			$config_small['source_image'] = $data['full_path']; //文件路径带文件名
			$this->image_lib->initialize($config_small);
			$this->image_lib->resize();
			form_submit_json("200", "操作成功", "");
		}else{
			form_submit_json("300", $this->upload->display_errors('<b>','</b>'));
			exit;
		}
	}
	
	//ajax获取图片信息
	public function get_pics($time,$typ_id){
		$path = './././uploadfiles/pics/'.$time.'/'.$typ_id;
		$map = directory_map($path);
		$data = array();
		//整理图片名字，取缩略图片
		foreach($map as $v){
			if(substr(substr($v,0,strrpos($v,'.')),-5) == 'thumb'){
				$data['img'][] = $v;
			}
		}
		$data['time'] = $time;//文件夹名称
		echo json_encode($data);
	}
	
	//ajax删除图片
	public function del_pic($folder,$type_id,$pic,$id=null){
		$data = $this->manage_model->del_pic($folder,$type_id,$pic,$id);
		echo json_encode($data);
	}
	
	//清理不使用的图片数据
	public function clear_pics(){
		$rs = $this->manage_model->clear_pics();
		if($rs === 1){
			form_submit_json("200", "操作成功", "");
		}else{
			form_submit_json("300", $rs);
		}
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
		$h_id = $this->manage_model->save_house();
		if($h_id > 0){
			$this->api_model->get_or_create_ticket($h_id, 'QR_SCENE');
			form_submit_json("200", "操作成功", 'list_house');
		} else {
			form_submit_json("300", "保存失败");
		}
	}
	
	public function edit_house($id) {
		$data = $this->manage_model->get_house($id);
		$data['pics'] = $this->manage_model->get_house_pics($id);
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
	
	/**
	 * 动态管理
	 */
	public function list_news() {
		$data = $this->manage_model->list_news();
		$this->load->view('manage/list_news.php', $data);
	}
	
	public function add_news() {
		$data['decoration_list'] = $this->manage_model->get_decoration_list();
		$this->load->view('manage/add_news.php', $data);
	}
	
	public function save_news() {
		if($_FILES["userfile"]['name'] and $this->input->post('old_img')){//修改上传的图片，需要先删除原来的图片
			@unlink('./././uploadfiles/news/'.$this->input->post('old_img'));//del old img
		}else if(!$_FILES["userfile"]['name'] and !$this->input->post('old_img')){//未上传图片
			form_submit_json("300", "请添加图片");exit;
		}
		
		if(!$_FILES["userfile"]['name'] and $this->input->post('old_img')){//不修改图片信息
			$data = $this->input->post();
			unset($data['ajax']);
			unset($data['old_img']);
			unset($data['h_name']);
			$rs = $this->manage_model->save_news($data);
		}else{
			$config['upload_path'] = './././uploadfiles/news';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '1000';
			$config['encrypt_name'] = true;
			$this->load->library('upload', $config);
			if($this->upload->do_upload()){
				$img_info = $this->upload->data();
				$data = $this->input->post();
				$data['pic'] = $img_info['file_name'];
				unset($data['ajax']);
				unset($data['old_img']);
				unset($data['h_name']);
				$rs = $this->manage_model->save_news($data);
			}else{
				form_submit_json("300", $this->upload->display_errors('<b>','</b>'));
				exit;
			}
		}
		
		if ($rs === 1) {
			form_submit_json("200", "操作成功", "list_news");
		} else {
			form_submit_json("300", $rs);
		}
	}
	
	public function edit_news($id) {
		$data = $this->manage_model->get_news($id);
		$data['decoration_list'] = $this->manage_model->get_decoration_list();
		$this->load->view('manage/add_news.php', $data);
	}
	
	public function delete_news($id) {
		$ret = $this->manage_model->delete_news($id);
		if($ret == 1) {
			form_submit_json("200", "操作成功", 'list_news', '', '');
		} else {
			form_submit_json("300", "删除失败");
		}
	}
	
	public function list_house_dialog(){
		
		$data = $this->manage_model->list_house_dialog();
		$this->load->view('manage/list_house_dialog.php', $data);
	}
	
//////////////////////////////////////////////////////////////////////////
	public function check_keyword() {
		$result = $this->manage_model->check_keyword();
		echo empty($result) ? -1 : 1;
	}
}
