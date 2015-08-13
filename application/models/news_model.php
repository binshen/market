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
class News_model extends MY_Model
{
	protected $tables = array(
			'news_type',
			'news'
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
     * 获取新闻类别列表
     */
	public function get_news_type(){
		$this->db->select('*');
		$this->db->from($this->tables[0]);
		$this->db->order_by("order_num", "asc"); 
		$rs = $this->db->get()->result_array();
		return $rs;
	}
	
	/**
     * 获取新闻列表
     * @param $id
     */
	public function get_news_list($type_id=null,$per_page,$offset){
		if(!$type_id){//如果不存在type_id，则选取类别列表的第一个类别
			$res = $this->get_news_type();
			$type_id = $res[0]['id'];
		}
		$this->db->select('id,type_id,title,order_num');
		$this->db->from($this->tables[1]);
		$this->db->where('type_id',$type_id);
		$this->db->limit($per_page,$offset);
		$this->db->order_by("order_num,id", "asc"); 
		$rs = $this->db->get()->result_array();
		return $rs;
	}
	
	/**
     * 获取新闻类别标题
     */
	public function get_type_title($type_id=null){
		$this->db->select('id,name,name_en,order_num');
		$this->db->from($this->tables[0]);
		if($type_id)
			$this->db->where('id',$type_id);
		$this->db->order_by("order_num,id", "asc"); 
		$rs = $this->db->get()->row_array();
		return $rs;
	}
	
	/**
     * 获取新闻列表总记录数
     * @param $id
     */
	public function get_count($type_id=null){
		if(!$type_id){//如果不存在type_id，则选取类别列表的第一个类别
			$res = $this->get_news_type();
			$type_id = $res[0]['id'];
		}
		$this->db->select('count(1) total_rows');
		$this->db->from($this->tables[1]);
		$this->db->where('type_id',$type_id);
		$rs = $this->db->get()->row();
		return $rs->total_rows;
	}
	
	/**
     * 获取新闻详情
     * @param $id 新闻id
     */
	public function get_news_detail($id){
		$this->db->select('*');
		$this->db->from($this->tables[1]);
		$this->db->where('id',$id);
		$rs = $this->db->get()->row_array();
		return $rs;
	}
	
	/**
	 * 取上一条和下一条新闻
	 * @param $news_id 新闻id $order_num 排序号
	 * 
	 */
	public function get_news_next_prev($news_id,$order_num,$type_id){
		
		$this->db->query('DROP TABLE IF EXISTS tmp_table');//如果存在临时表则删除临时表
		//将行号插入临时表
		$sql = "CREATE TEMPORARY TABLE tmp_table  select  @ROW := @ROW + 1 AS ROW,a.id from news a,(SELECT @ROW := 0) b where type_id = ".$type_id." order by order_num,id asc";
		$this->db->query($sql);
		
		$rs_row = $this->db->select('row')->from('tmp_table')->where('id',$news_id)->get()->row();//获取行号
		$row = $rs_row->row;
		$rs_prev_id = $this->db->select('id')->from('tmp_table')->where('row',$row-1)->get()->row();//通过行号抓取上一行id
		$rs_next_id = $this->db->select('id')->from('tmp_table')->where('row',$row+1)->get()->row();//通过行号抓取下一行id
		
		$prev_id = $rs_prev_id?$rs_prev_id->id:0;//上一篇新闻id
		$next_id = $rs_next_id?$rs_next_id->id:0;//下一篇新闻id
		$data['prev'] = $this->db->select('id,title')->from($this->tables[1])->where('id',$prev_id)->get()->row();
		$data['next'] = $this->db->select('id,title')->from($this->tables[1])->where('id',$next_id)->get()->row();
		
		return $data;
	}
	
}
//1.CREATE TEMPORARY TABLE tmp_table  select  @ROW := @ROW + 1 AS ROW,a.id from news a,(SELECT @ROW := 0) b where type_id = 5 order by order_num,id asc;
//2.select row-1 from tmp_table where id='18';
//3.select id from tmp_table where row=2;


/* End of file news_model.php */
/* Location: ./application/models/news_model.php */