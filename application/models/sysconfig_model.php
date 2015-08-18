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
    	return $this->db->select('id,name,title,avg_price,bg_pic')->from('house')->order_by('is_top','desc')->order_by('rand()')->get()->result_array();
    }
    
}

/* End of file sysconfig_model.php */
/* Location: ./application/models/sysconfig_model.php */
