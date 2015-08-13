<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 系统设置模型
 * 可用于抓取系统初始数据以及定义系统变量和获取一些首页需要的信息
 *
 * @package		app
 * @subpackage	core
 * @category	model
 * @author		yaobin<645894453@qq.com>
 *        
 */
class Sysconfig_model extends MY_Model
{
	
    public function __construct ()
    {
        parent::__construct();
    }

    public function __destruct ()
    {
        parent::__destruct();
    }
    
    public function get_index_info(){
    	$data['news1'] = $this->db->select('id,title,pic,title2,xq_id')->from('news')->where('index_area','1')->order_by('cdate','desc')->limit(5,0)->get()->result_array();
    	$data['news2'] = $this->db->select('id,title,pic,title2,xq_id')->from('news')->where('index_area','2')->order_by('cdate','desc')->limit(12,0)->get()->result_array();
    	$data['news3'] = $this->db->select('id,title,pic,title2,xq_id')->from('news')->where('index_area','3')->order_by('cdate','desc')->get()->row_array();
    	$data['news4'] = $this->db->select('id,title,pic,title2,xq_id')->from('news')->where('index_area','4')->order_by('cdate','desc')->get()->row_array();
    	$data['news5'] = $this->db->select('id,title,pic,title2,xq_id')->from('news')->where('index_area','5')->order_by('cdate','desc')->limit(2,0)->get()->result_array();
    	$data['region_list'] = $this->db->select('id,name')->from('house_region')->get()->result_array();
    	$data['style_list_2'] = $this->db->select('id,name')->from('house_substyle')->where('style_id', 2)->get()->result_array();
    	$data['style_list_3'] = $this->db->select('id,name')->from('house_substyle')->where('style_id', 3)->get()->result_array();
    	$data['style_list_4'] = $this->db->select('id,name')->from('house_substyle')->where('style_id', 4)->get()->result_array();
    	return $data;
    }
    
    public function post_register(){
    	$rs = $this->db->select('count(1) num')->from('users')->where('username',$this->input->post('username'))->get()->row();
    	if($rs->num > 0){
    		return -2;//用户名已经存在
    	}
    	$data = array(
    		'username'=>$this->input->post('username'),
    		'password'=>sha1($this->input->post('password')),
    		'cdate'=>date('Y-m-d H:i:s',time())
    	);
    	$res = $this->db->insert('users',$data);
    	if($res)
    		return 1;
    	else
    		return -1;
    }
    
    public function check_login(){
    	$rs = $this->db->select()->from('users')
    		->where('username',$this->input->post('username'))
    		->where('password',sha1($this->input->post('password')))->get()->row();
    	if($rs){
    		$data['member_id'] = $rs->id;
    		$data['member_username'] = $rs->username;
    		$this->session->set_userdata($data);
    		return 1;
    	}else{
    		return -1;
    	}
    }
    
}

/* End of file sysconfig_model.php */
/* Location: ./application/models/sysconfig_model.php */
