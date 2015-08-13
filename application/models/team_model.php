<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 公司营销团队控制器
 *
 * @package		app
 * @subpackage	core
 * @category	model
 * @author		yaobin<645894453@qq.com>
 *        
 */
class Team_model extends MY_Model
{
	protected $tables = array(
			'team_type',
			'teams'

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
     * 获取营销团队类别
     */
	public function get_team_type(){
		$this->db->select('*');
		$this->db->from($this->tables[0]);
		$this->db->order_by("order_num", "asc"); 
		$rs = $this->db->get()->result_array();
		return $rs;
	}
	
	/**
     * 获取营销团队列表
     * @param $id
     */
	public function get_teams_list($type_id,$per_page,$offset){
		$this->db->select('*');
		$this->db->from($this->tables[1]);
		if($type_id) //如果存在ID则按照ID查询
			$this->db->where('type_id',$type_id);
		$this->db->order_by("order_num", "asc"); 
		$this->db->limit($per_page,$offset);
		$rs = $this->db->get()->result_array();
		return $rs;
	}
	
	/**
     * 获取营销团队默认列表
     */
	public function get_default_type(){
		$this->db->select('*');
		$this->db->from($this->tables[0]);
		$this->db->order_by("order_num", "asc"); 
		$rs = $this->db->get()->row();
		return $rs->id;
	}
	
	/**
     * 获取营销团队类别详情
     */
	public function get_type_detail($type_id){
		$this->db->select('*');
		$this->db->from($this->tables[0]);
		$this->db->where('id',$type_id);
		$this->db->order_by("order_num", "asc"); 
		$rs = $this->db->get()->row_array();
		return $rs;
	}
	
	/**
     * 获取团队条数
     * @param $type_id
     */
	public function get_count($type_id){
		$this->db->select('count(1) num');
		$this->db->from($this->tables[1]);
		$this->db->where('type_id',$type_id);
		$rs = $this->db->get()->row_array();
		return $rs['num'];
	}
	
	/**
     * 获取人员详情
     * @param $id
     */
	public function get_team_detail($id){
		$this->db->select('*');
		$this->db->from($this->tables[1]);
		$this->db->where('id',$id);
		$rs = $this->db->get()->row_array();
		return $rs;
	}
}

/* End of file team_model.php */
/* Location: ./application/models/team_model.php */