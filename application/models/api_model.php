<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Api_model extends MY_Model {

	public function __construct () {
		parent::__construct();
	}
	
	public function __destruct () {
		parent::__destruct();
	}
	
	public function get_or_create_token() {
		
		$this->db->from('token');
		$this->db->where('app_id', APP_ID);
		$this->db->where('app_secret', APP_SECRET);
		$data_token = $this->db->get()->row_array();
		if(empty($data_token)) {
			$data = array(
				'app_id' => APP_ID,
				'app_secret' => APP_SECRET,
				'token' => $this->get_access_token(),
				'created' => time()
			);
			$this->db->insert('token', $data);
			return $data;
		} else {
			$interval = time() - intval($data_token['created']);
			if($interval / 60 / 60 > 1) {
				$data_token['token'] = $this->get_access_token();
				$data_token['created'] = time();
				$this->db->where('id', $data_token['id']);
				$this->db->update('token', $data_token);
			}
			return $data_token;
		}
	}
	
	public function get_access_token() {
		$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.APP_ID.'&secret='.APP_SECRET;
		$response = file_get_contents($url);
		return json_decode($response)->access_token;
	}
	
	public function get_or_create_ticket($h_id, $action_name = 'QR_LIMIT_SCENE') {
		$this->db->from('house_ticket');
		$this->db->where('h_id', $h_id);
		$house_ticket = $this->db->get()->row_array();
		if(empty($house_ticket)) {
			$token_data = $this->get_or_create_token();
			$access_token = $token_data['token'];
			$url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token;
			@$post_data->action_name = $action_name;
			@$post_data->action_info->scene->scene_id = $h_id;
			$ticket_data = json_decode($this->post($url, $post_data));
			$ticket = $ticket_data->ticket;
			$data = array(
				'h_id' => $h_id,
				'ticket' => $ticket
			);
			$this->db->insert('house_ticket', $data);
			return $data;
		} else {
			return $house_ticket;
		}
	}
	
	function get_house_by_id($id) {
		$this->db->from('house');
		$this->db->where('id', $id);
		return $this->db->get()->row_array();
	}
	
	function get_house_by_keyword($keyword) {
		$this->db->from('house');
		$this->db->where('keyword', $keyword);
		return $this->db->get()->row_array();
	}
	
	function get_all_keywords() {
		$this->db->select('keyword');
		$this->db->from('house');
		$this->db->where('keyword IS NOT NULL');
		$data = $this->db->get()->result_array();
		$keywords = array();
		foreach ($data as $d) {
			$keywords[] = $d['keyword'];
		}
		return implode(',', $keywords);
	}
	
	public function get_news_by_hid($h_id) {
		$this->db->from('news')->where('h_id', $h_id)->limit(3)->order_by('created', 'desc');
		return $this->db->get()->result_array();
	}
	
//////////////////////////////////////////////////////////////
// Test code
//////////////////////////////////////////////////////////////
	public function get_city_code($name) {
		$this->db->select('cityCode');
		$this->db->from('city');
		$this->db->where('cityName', $name);
		$city_data = $this->db->get()->row_array();
		return $city_data['cityCode'];
	}
}