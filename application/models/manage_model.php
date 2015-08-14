<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 网站后台模型
 *
 * @package		app
 * @subpackage	core
 * @category	model
 * @author		yaobin<645894453@qq.com>
 *        
 */
class Manage_model extends MY_Model
{
    public function __construct ()
    {
        parent::__construct();
    }

    public function __destruct ()
    {
        parent::__destruct();
    }
    
    /**
     * 用户登录检查
     * 
     * @return boolean
     */
    public function check_login ()
    {
        $login_id = $this->input->post('username');
        $passwd = $this->input->post('password');
        $this->db->from('admin');
        $this->db->where('username', $login_id);
        $this->db->where('passwd', sha1($passwd));
        $rs = $this->db->get();
        if ($rs->num_rows() > 0) {
        	$res = $rs->row();
        	$user_info['user_id'] = $res->id;
            $user_info['username'] = $this->input->post('username');
            $user_info['group_id'] = $res->admin_group;
            $user_info['rel_name'] = $res->rel_name;
            $this->session->set_userdata($user_info);
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 修改密码
     * 
     */
    public function change_pwd ()
    {
        $login_id = $this->input->post('username');
        $newpassword = $this->input->post('newpassword');
        
		$rs=$this->db->where('username', $login_id)->update('admin', array('passwd'=>sha1($newpassword))); 
        if ($rs) {
            return 1;
        } else {
            return $rs;
        }
    }
    
/////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * 开发商管理
     */
    public function list_customer(){
    	// 每页显示的记录条数，默认20条
    	$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
    	$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
    
    	//获得总记录数
    	$this->db->select('count(1) as num');
    	$this->db->from('customer');
    	if($this->input->post('rel_name'))
    		$this->db->like('rel_name',$this->input->post('rel_name'));
    	$this->db->where('id >', 1);
    
    	$rs_total = $this->db->get()->row();
    	//总记录数
    	$data['countPage'] = $rs_total->num;
    
    	$data['name'] = null;
    	//list
    	$this->db->select('*');
    	$this->db->from('customer');
    	if($this->input->post('name')){
    		$this->db->like('name',$this->input->post('name'));
    		$data['name'] = $this->input->post('name');
    	}
    	$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
    	$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
    	$data['res_list'] = $this->db->get()->result();
    	$data['pageNum'] = $pageNum;
    	$data['numPerPage'] = $numPerPage;
    	return $data;
    }
    
    public function save_customer() {
    	$data = array(
    		'name' => $this->input->post('name'),
    		'address' => $this->input->post('address'),
    		'tel' => $this->input->post('tel')
    	);
    	$this->db->trans_start();//--------开始事务
    
    	if($this->input->post('id')){//修改
    		$customer_id = $this->input->post('id');
    		$this->db->where('id', $customer_id);
    		$this->db->update('customer', $data);
    	} else {
    		$this->db->insert('customer', $data);
    		$customer_id = $this->db->insert_id();
    	}
    	
    	$admin = $this->db->from('admin')->where('customer_id', $customer_id)->get()->row_array();
    	if(empty($admin)) {
    		$admin = array(
    			'username' => $data['name'],
    			'passwd' => sha1('888888'),
    			'rel_name' => $data['name'],
    			'admin_group' => 2,
    			'customer_id' => $customer_id
    		);
    		$this->db->insert('admin', $admin);
    	} else {
    		$admin['username'] = $data['name'];
    		if(empty($admin['passwd'])) {
    			$admin['passwd'] = sha1('888888');
    		}
    		$admin['rel_name'] = $data['name'];
    		$admin['admin_group'] = 2;
    		$this->db->where('id', $admin['id']);
    		$this->db->update('admin', $admin);
    	}
    	
    	$this->db->trans_complete();//------结束事务
    	if ($this->db->trans_status() === FALSE) {
    		return -1;
    	} else {
    		return 1;
    	}
    }
    
    public function get_customer($id) {
    	return $this->db->get_where('customer', array('id' => $id))->row_array();
    }
    
    public function delete_customer($id) {
    	$this->db->where('id', $id);
    	return $this->db->delete('customer');
    }
}
