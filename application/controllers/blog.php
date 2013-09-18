<?php
  class Blog extends CI_Controller
  {
     var $val = 0;
     function __construct()
	 {
	     parent::__construct();
		 //$this->load->scaffolding("translation");
		 $this->load->database();
         $this->load->helper('define');
		 $this->load->model('q2a/Rss_manage');
	 }

	function index()
	{
		$this->update_rss_setting();
	}

	function update_rss_setting()
	{
		$all_user_arr = $this->get_all_uId();
		foreach($all_user_arr as $user_item)
		{
			$this->update_rss_setting4user($user_item);
		}
	}
	
	function get_all_uId()
	{
		$this->db->select('uId,langCode');
		$query = $this->db->get('user');
		$result = array();
		foreach($query->result() as $row)
		{
			$langCode = ($row->langCode == '') ? 'zh' : $row->langCode;
			array_push($result,array('uId'=>$row->uId,'langCode'=>$langCode));
		}
		return $result;
	}
	
	function update_rss_setting4user($data)
	{
		$sub_cate_id_arr = $this->get_user_subcate($data['uId']);
		$rss_feed_data = $this->get_rss_feed4user($sub_cate_id_arr,$data['langCode']);
		$this->rss_feed_insert4user($rss_feed_data,$data['uId']);
	}
	
	function get_user_subcate($uId)
	{
		$this->db->select('sub_cate_id');
		$this->db->distinct();
		$this->db->where('uId',$uId);
		$query = $this->db->get('user_private_tag');
		$result = array();
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				array_push($result,$row->sub_cate_id);
			}
		}
		return $result;
	}
	
	function get_rss_feed4user($data,$langCode)
	{
		$result = array();
		if(!empty($data))
		{
			foreach($data as $sub_cate_id)
			{
				$rss_feed_id_arr = $this->Rss_manage->get_rss_feed_id_by_subcateid(array('sub_cate_id'=>$sub_cate_id,'langCode'=>$langCode));
				array_push($result,array('sub_cate_id'=>$sub_cate_id,'rss_feed'=>$rss_feed_id_arr));
			}
		}
		return $result;
	}
	
	function rss_feed_insert4user($data,$uId)
	{
		if(!empty($data))
		{
			foreach($data as $item)
			{
				$sub_cate_id = $item['sub_cate_id'];
				if(!empty($item['rss_feed']))
				{
					foreach($item['rss_feed'] as $rss_feed_id)
					{
						$this->db->set('uId',$uId);
						$this->db->set('sub_cate_id',$sub_cate_id);
						$this->db->set('rss_feed_id',$rss_feed_id);
						$this->db->insert('user_rss_feed');
					}
				}
			}
		}
	}

	function root_r()
	{
		print_r($_SERVER);
	}

  }
