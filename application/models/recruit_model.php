<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 企业招聘控制器
 *
 * @package		app
 * @subpackage	core
 * @category	model
 * @author		yaobin<645894453@qq.com>
 *        
 */
class Recruit_model extends MY_Model
{
	protected $tables = array(
			'recruit'

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
     * 获取简历列表
     */
	public function get_recruit($per_page,$offset){
		$this->db->select('*');
		$this->db->from($this->tables[0]);
		$this->db->order_by("order_num,id", "asc"); 
		$this->db->limit($per_page,$offset);
		$rs = $this->db->get()->result_array();
		return $rs;
	}
	
	/**
     * 获取简历条目
     */
	public function get_count_recruit(){
		$this->db->select('count(1) num');
		$this->db->from($this->tables[0]);
		$rs = $this->db->get()->row();
		return $rs->num;
	}
}

/* End of file recruit_model.php */
/* Location: ./application/models/recruit_model.php */