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
    
    
}
