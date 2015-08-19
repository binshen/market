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
    	$data['news'] = $this->db->select('id,title,pic')->from('news')->where('recommend','1')->order_by('created','desc')->limit(5,0)->get()->result_array();
    	$data['projects'] = $this->db->select('id,name,title,avg_price,bg_pic')->from('house')->order_by('is_top','desc')->order_by('rand()')->get()->result_array();
    	return $data;
    }
    
    public function get_project($id){
    	$data['detail'] = $this->db->select('a.*,b.name zhuangxiu')->from('house a')->join('decoration b','a.id=b.id','left')->where('a.id',$id)->get()->row_array();
    	$pics = $this->db->select()->from('house_img')->where('h_id',$id)->get()->result_array();
    	foreach($pics as $k=>$v){
    		$data['pics'][$v['type_id']][] = $v;
    	}
    	$data['news'] = $this->db->select()->from('news')->where('h_id',$id)->order_by('created','desc')->limit(5,0)->get()->result_array();
    	if($data['news']){
    		$data['news'][0]['content'] = mb_substr(strip_tags(str_replace(' ','',$data['news'][0]['content'])),0,30,'utf-8');
    	}
    	return $data;
    }
    
    public function get_news_detail($id){
    	$data['detail'] = $this->db->select()->from('news')->where('id',$id)->get()->row_array();
    	$data['list'] = $this->db->select('id,title,created')->from('news')->where('h_id',$data['detail']['h_id'])->where('id !=',$id)->order_by('created','desc')->limit(4,0)->get()->result_array();
    	return $data;
    }
}

/* End of file sysconfig_model.php */
/* Location: ./application/models/sysconfig_model.php */
