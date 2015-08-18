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
    
    //ajax删除图片
    public function del_pic($folder,$type_id,$pic,$id){
    	//echo $id;die;
    	if($id){
    		$this->db->where('pic_short',$pic);
    		$this->db->delete('house_img');
    	}
    	@unlink('./././uploadfiles/pics/'.$folder.'/'.$type_id.'/'.$pic);
    	@unlink('./././uploadfiles/pics/'.$folder.'/'.$type_id.'/'.str_replace('_thumb', '', $pic));
    	$data = array(
    			'flag'=>1,
    			'pic'=>$pic
    	);
    	return $data;
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
    
    /**
     * 装修状况
     */
    public function list_decoration(){
    	// 每页显示的记录条数，默认20条
    	$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
    	$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
    
    	//获得总记录数
    	$this->db->select('count(1) as num');
    	$this->db->from('decoration');
    
    	$rs_total = $this->db->get()->row();
    	//总记录数
    	$data['countPage'] = $rs_total->num;
    
    	//list
    	$this->db->select('*')->from('decoration');
    	$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
    	$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
    	$data['res_list'] = $this->db->get()->result();
    	$data['pageNum'] = $pageNum;
    	$data['numPerPage'] = $numPerPage;
    	return $data;
    }
    
    public function save_decoration() {
    	$data = array(
    		'name' => $this->input->post('name')
    	);
    	$this->db->trans_start();//--------开始事务
    
    	if($this->input->post('id')){//修改
    		$this->db->where('id', $this->input->post('id'));
    		$this->db->update('decoration', $data);
    	} else {
    		$this->db->insert('decoration', $data);
    	}
    	$this->db->trans_complete();//------结束事务
    	if ($this->db->trans_status() === FALSE) {
    		return -1;
    	} else {
    		return 1;
    	}
    }
    
    public function get_decoration($id) {
    	return $this->db->get_where('decoration', array('id' => $id))->row_array();
    }
    
    public function delete_decoration($id) {
    	$this->db->where('id', $id);
    	return $this->db->delete('decoration');
    }
    
    
    /**
     * 楼盘管理
     */
    public function list_house(){
    	// 每页显示的记录条数，默认20条
    	$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
    	$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
    
    	//获得总记录数
    	$this->db->select('count(1) as num');
    	$this->db->from('house');
    	if($this->input->post('name'))
    		$this->db->like('name',$this->input->post('name'));
    
    	$rs_total = $this->db->get()->row();
    	//总记录数
    	$data['countPage'] = $rs_total->num;
    
    	$data['name'] = null;
    	//list
    	$this->db->select('*');
    	$this->db->from('house');
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
    
    public function save_house() {
    	$data = array(
    		'name' => $this->input->post('name'),
    		'avg_price' => $this->input->post('avg_price'),
    		'kp_date' => $this->input->post('kp_date'),
    		'address' => $this->input->post('address'),
    		'tel' => $this->input->post('tel'),
    		'decoration_id' => $this->input->post('decoration_id'),
    		'property_right' => $this->input->post('property_right'),
    		'covered_area' => $this->input->post('covered_area'),
    		'developer' => $this->input->post('developer'),
    		'rz_date' => $this->input->post('rz_date'),
    		'plot_rate' => $this->input->post('plot_rate'),
    		'greening_rate' => $this->input->post('greening_rate'),
    		'floor_area' => $this->input->post('floor_area'),
    		'description' => $this->input->post('description'),
    		'folder' => $this->input->post('folder'),
    		'bg_pic' => $this->input->post('bg_pic'),
    		'created' => date('Y-m-d H:i:s')
    	);
    	$this->db->trans_start();//--------开始事务
    
    	if($this->input->post('id')){//修改
    		$house_id = $this->input->post('id');
    		$this->db->where('id', $house_id);
    		$this->db->update('house', $data);
    		
    		$this->db->where('h_id', $house_id);
    		$this->db->delete('house_img');
    	} else {
    		$this->db->insert('house', $data);
    		$house_id = $this->db->insert_id();
    	}
    	
    	$data_line = array();
    	for($i=1;$i<=3;$i++){
    		if($this->input->post('pic_short'.$i)){
    			foreach($this->input->post('pic_short'.$i) as $k=>$v){
    				$data_line[] = array(
    					'h_id'=>$house_id,
    					'type_id'=>$i,
    					'pic'=>str_replace('_thumb', '', $v),
    					'pic_short'=>$v
    				);
    			}
    		}
    	}
    	if(!empty($data_line)) {
    		$this->db->insert_batch('house_img', $data_line);
    	}
    	
    	$this->db->trans_complete();//------结束事务
    	if ($this->db->trans_status() === FALSE) {
    		return -1;
    	} else {
    		return 1;
    	}
    }
    
    public function get_house($id) {
    	return $this->db->get_where('house', array('id' => $id))->row_array();
    }
    
    public function delete_house($id) {
    	$this->db->where('id', $id);
    	return $this->db->delete('house');
    }
    
    public function get_decoration_list() {
    	return $this->db->get('decoration')->result();
    }
    
    public function get_house_pics($id) {
    	return $this->db->select()->from('house_img')->where('h_id',$id)->get()->result();
    }
    
    
    /**
     * 动态管理
     */
    public function list_news(){
    	// 每页显示的记录条数，默认20条
    	$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
    	$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
    
    	//获得总记录数
    	$this->db->select('count(1) as num');
    	$this->db->from('news');
    	if($this->input->post('title'))
    		$this->db->like('title',$this->input->post('title'));
    
    	$rs_total = $this->db->get()->row();
    	//总记录数
    	$data['countPage'] = $rs_total->num;
    
    	$data['title'] = null;
    	//list
    	$this->db->select('*');
    	$this->db->from('news');
    	if($this->input->post('title')){
    		$this->db->like('title',$this->input->post('title'));
    		$data['title'] = $this->input->post('title');
    	}
    	$this->db->limit($numPerPage, ($pageNum - 1) * $numPerPage );
    	$this->db->order_by($this->input->post('orderField') ? $this->input->post('orderField') : 'id', $this->input->post('orderDirection') ? $this->input->post('orderDirection') : 'desc');
    	$data['res_list'] = $this->db->get()->result();
    	$data['pageNum'] = $pageNum;
    	$data['numPerPage'] = $numPerPage;
    	return $data;
    }
    
    public function save_news() {
    	$data = array(
    		'house_id' => $this->input->post('house_id'),
    		'pic' => $this->input->post('pic'),
    		'title' => $this->input->post('title'),
    		'content' => $this->input->post('content'),
    		'created' => date('Y-m-d H:i:s')
    	);
    	$this->db->trans_start();//--------开始事务
    
    	if($this->input->post('id')){//修改
    		$this->db->where('id', $this->input->post('id'));
    		$this->db->update('news', $data);
    	} else {
    		$this->db->insert('news', $data);
    		$this->db->insert_id();
    	}
    	   	 
    	$this->db->trans_complete();//------结束事务
    	if ($this->db->trans_status() === FALSE) {
    		return -1;
    	} else {
    		return 1;
    	}
    }
    
    public function get_news($id) {
    	return $this->db->get_where('news', array('id' => $id))->row_array();
    }
    
    public function delete_news($id) {
    	$this->db->where('id', $id);
    	return $this->db->delete('news');
    }
    
    public function list_house_dialog(){
    	// 每页显示的记录条数，默认20条
    	$numPerPage = $this->input->post('numPerPage') ? $this->input->post('numPerPage') : 20;
    	$pageNum = $this->input->post('pageNum') ? $this->input->post('pageNum') : 1;
    
    	//获得总记录数
    	$this->db->select('count(1) as num');
    	$this->db->from('house');
    	if($this->input->post('name'))
    		$this->db->like('name',$this->input->post('name'));
    
    	$rs_total = $this->db->get()->row();
    	//总记录数
    	$data['countPage'] = $rs_total->num;
    
    	$data['name'] = null;
    	//list
    	$this->db->select();
    	$this->db->from('house');
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
}
