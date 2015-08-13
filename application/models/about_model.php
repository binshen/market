<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 关于公司和公司简介控制器
 *
 * @package		app
 * @subpackage	core
 * @category	model
 * @author		yaobin<645894453@qq.com>
 *        
 */
class About_model extends MY_Model
{
	protected $tables = array(
			'about'

    );
	
    public function __construct ()
    {
        parent::__construct();
    }

    public function __destruct ()
    {
        parent::__destruct();
    }
    
	
	/**
     * 获取公司简介列表
     */
	public function get_about_type(){
		$this->db->select('id,title,title_en');
		$this->db->from($this->tables[0]);
		$this->db->order_by("order_num", "asc"); 
		$rs = $this->db->get()->result_array();
		return $rs;
	}
	
	/**
     * 获取公司简介的详情
     * @param $id
     */
	public function get_about_detail($id=null){
		$this->db->select('*');
		$this->db->from($this->tables[0]);
		if($id) //如果存在ID则按照ID查询
			$this->db->where('id',$id);
		$this->db->order_by("order_num", "asc"); 
		$rs = $this->db->get()->row_array();
		return $rs;
	}
	
	
}

/* End of file sysconfig_model.php */
/* Location: ./application/models/sysconfig_model.php */