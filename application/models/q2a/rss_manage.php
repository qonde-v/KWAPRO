<?php
  class Rss_manage extends CI_Model
  {
	 function __construct()
	 {
	    parent::__construct();
	    $this->load->model('q2a/Tag_process');
		$this->load->model('q2a/Sphinx_search');
	 }
	 
	 //laod rss data by array of artical id
	 //input: artical id
	 //output: array of artical data 
	 function rss_data_load($artical_id)
	 {
	    //todo:
		   $sql = "SELECT * FROM rss_artical_data WHERE artical_id = {$artical_id}";
		   $query = $this->db->query($sql);
	
			if($query->num_rows() > 0)
			{
			   return $query->row_array();
			}
			return array();
	 }
	 
	 //save user's added rss resource
	 //input: array('category_id','sub_cate_id','rss_url','langCode')
	 function rss_resource_save($data)
	 {
	 	if($this->rss_resource_exist($data) == '')
		{
			return $this->rss_resource_insert($data);
		}
		else
		{
			return $this->rss_resource_exist($data);
		}
	 }
	 
	 //check if user's added rss resource exist or not
	 //input: array('category_id','sub_cate_id','rss_url','langCode')
	 //table--'category_rss_resource'
	 function rss_resource_exist($data)
	 {
	 	$this->db->select('rss_feed_id');
		$this->db->where('category_id',$data['category_id']);
		$this->db->where('sub_cate_id',$data['sub_cate_id']);
		$this->db->where('langCode',$data['langCode']);
		$this->db->like('rss_url',$data['rss_url']);
		$query = $this->db->get('category_rss_resource');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			return $row->rss_feed_id;
		}
		else
		{
			return '';
		}
	 }
	 
	 //insert user's rss resource
	 //input: array('category_id','sub_cate_id','rss_url','langCode')
	 //table--'category_rss_resource'
	 function rss_resource_insert($data)
	 {
	 		$this->db->set($data);
	 		$this->db->set('is_user_add',1);
	 		$this->db->insert('category_rss_resource');
	 		return $this->db->insert_id();
	 }
	 
	 //
	 function rss_data_insert($data)
	 {
	    //todo:
		 $this->db->insert('rss_artical_data',$data);
		 return $this->db->insert_id(); 
	 }
	 
	 //
	 function rss_data_category_insert($data)
	 {
	    $this->db->insert('artical_category_data',$data);
		 return $this->db->insert_id(); 
	 }
	 
	 	//get rss data for a user
	 	//input: array('uId','range','type','id')
	 	//output: array(array('article_id','title','description','link','pubDate'))
	 	function get_rss_4user($data)
	 	{
	 		$article_id_arr = $this->get_article4user($data);
	 		$article_data = $this->get_article_data($article_id_arr);
	 		return $article_data;
	 	}
	 	
		//get number of rss article for a user
		//input: array('uId','type','id')
	 	function rss_data_num($data)
	 	{
	 		$this->db->select('article_id');
			$this->db->where('uId',$data['uId']);
			if($data['type'] != '')
			{
				$this->db->where($data['type'].'_id',$data['id']);
			}
			$query = $this->db->get('user_sub_article');
			return $query->num_rows();
	 	}
		
		//get article_id for a user
		//input: array('uId','range','type','id')
		//output: array of article_id
		//table--'user_sub_article'
		function get_article4user($data)
		{
			$range = $data['range'];
			$this->db->select('article_id');
			$this->db->where('uId',$data['uId']);
			if($data['type'] != '')
			{
				$this->db->where($data['type'].'_id',$data['id']);
			}
			$this->db->order_by('pubDate','desc');
			if(!empty($range))
			{
				$this->db->limit($range['end']-$range['start']+1,$range['start']);
			}
			$query = $this->db->get('user_sub_article');
			$result = array();
			if($query->num_rows() > 0)
			{
				foreach($query->result() as $row)
				{
					array_push($result,$row->article_id);
				}
			}
			return $result;
		}
	 	
	 	//get rss sub_cate_id for a user
	 	//input:user id
	 	//output: array of sub_cate_id
	 	//table--'user_sub_article'
	 	function get_rss_sub_cate($uId)
	 	{
	 			$this->db->select('sub_cate_id');
	 			$this->db->where('uId',$uId);
	 			$this->db->distinct();
	 			$query = $this->db->get('user_sub_article');
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
	 	
	 	//get article id according to sub_cate_id of a user
	 	//input: user id, array of sub_cate_id
	 	//output: array of article id
	 	//table--'user_sub_article'
	 	function get_article_id($uId,$sub_cate_id_arr,$range)
	 	{
	 			$result = array();
	 			if(empty($sub_cate_id_arr))
	 			{
	 					return $result;
	 			}
	 			foreach($sub_cate_id_arr as $sub_cate_id)
	 			{
	 					$this->db->select('article_id');
	 					$this->db->where('uId',$uId);
	 					$this->db->order_by('pubDate','desc');
	 					$this->db->order_by('article_id','desc');
	 					if($range!='')
         		{
            		$this->db->limit($range['end']-$range['start']+1,$range['start']);
         		}
	 					$query = $this->db->get('user_sub_article');
	 					if($query->num_rows() > 0)
	 					{
	 							foreach($query->result() as $row)
	 							{
	 									array_push($result,$row->article_id);
	 							}
	 					}
	 			}
	 			return $result;
	 	}
	 	
	 	//get article data in detail
	 	//input: array of article id
	 	//output: array of article data
	 	//table--'rss_article_data'
	 	function get_article_data($article_id_arr)
	 	{
	 			if(empty($article_id_arr))
	 			{
	 					return array();
	 			}
	 			$this->db->select('title,description,link,pubDate');
	 			$this->db->where_in('artical_id',$article_id_arr);
	 			$query = $this->db->get('rss_artical_data');
	 			$result = array();
	 			if($query->num_rows() > 0)
	 			{
	 					foreach($query->result() as $row)
	 					{
	 						array_push($result,array('title'=>$row->title,'description'=>$this->Ctruncate(strip_tags($row->description),200),'link'=>$row->link,'pubDate'=>$row->pubDate));
	 					}
	 			}
	 			return $result;
	 	}
	 	
	 	//get rss feed for a user
	 	//input: array('uId','langCode')
	 	//output: array(array('sub_cate_id','sub_cate_name','rss_feed'=>array(array('rss_feed_id','rss_title','rss_url'))))
	 	function get_rss_feed4user($data)
	 	{
	 			$sub_cate_id_arr = $this->get_rss_topic($data['uId']);
	 			$result = array();
	 			foreach($sub_cate_id_arr as $sub_cate_id)
	 			{
	 					$item = array('sub_cate_id'=> $sub_cate_id,'langCode'=> $data['langCode']);
	 					$sub_cate_name = $this->Tag_process->get_subcatename_by_id($item);
	 					$rss_feed = $this->get_rss_by_subcate($item);
	 					array_push($result, array('sub_cate_id'=> $sub_cate_id, 'sub_cate_name'=> $sub_cate_name, 'rss_feed'=> $rss_feed));
	 			}
	 			return $result;
	 	}
	 	
	 	//get rss topic of a user
	 	//input: user id
	 	//output: array of sub_cate_id
	 	//table--'user_private_tag'
	 	function get_rss_topic($uId)
	 	{
	 			$this->db->select('sub_cate_id');
	 			$this->db->where('uId',$uId);
	 			$this->db->distinct();
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
	 	
	 	//get rss feed by a sub_cate_id
	 	//input: array('sub_cate_id','langCode')
	 	//output: array(array('rss_feed_id','rss_title','rss_url'))
	 	//table--'category_rss_resource'
	 	function get_rss_by_subcate($data)
	 	{
	 			$this->db->select('rss_feed_id,title,rss_url');
	 			$this->db->where($data);
	 			$this->db->order_by('is_user_add','asc');
	 			$query = $this->db->get('category_rss_resource');
	 			$result = array();
	 			if($query->num_rows() > 0)
	 			{
	 					foreach($query->result() as $row)
	 					{
	 							array_push($result,array('rss_feed_id'=> $row->rss_feed_id, 'rss_title'=> $row->title, 'rss_url'=> $row->rss_url));
	 					}
	 			}
	 			return $result;
	 	}
		
		//get rss feed data by sub_cate_id
		//input: array('sub_cate_id','langCode')
		//output: array(array('rss_feed_id','title'))
		//table--'category_rss_resource'
		function get_rss_feed_by_subcate($data)
		{
			$this->db->select('rss_feed_id,title');
			$this->db->where($data);
			$query = $this->db->get('category_rss_resource');
			$result = array();
			if($query->num_rows() > 0)
			{
				foreach($query->result_array() as $row)
				{
					array_push($result,$row);
				}
			}
			return $result;
		}
		
		//get rss_feed_id of system by sub_cate_id
		//input: array('sub_cate_id','langCode')
		//output: array of rss_feed_id
		//table--'category_rss_resource'
		function get_rss_feed_id_by_subcateid($data)
		{
			$this->db->select('rss_feed_id');
			$this->db->where($data);
			$this->db->where('is_user_add',0);
			$query = $this->db->get('category_rss_resource');
			$result = array();
			if($query->num_rows() > 0)
			{
				foreach($query->result() as $row)
				{
					array_push($result,$row->rss_feed_id);
				}
			}
			return $result;
		}
		
		//get rss article data related with an array of tags
		//input : array of tags
		//output: array(array('article_id','title','description','link','pubDate'))
		function load_tag_rss_article($tag_arr,$range)
		{
			$article_id_arr = $this->Sphinx_search->rss_search($tag_arr,$range);
			$article_data = $this->get_article_data($article_id_arr['id_arr']);
	 		return $article_data;
		}
		
		//get number of rss article data related with an array of tags
		//input : array of tags
		function tag_rss_article_count($tag_arr,$range)
		{
			$article_id_arr = $this->Sphinx_search->rss_search($tag_arr,$range);
	 		return count($article_id_arr['id_arr']);
		}
		
		function Ctruncate($str = '', $len = 0, $etc = ' ...') 
		{ 
			if(0 == $len) return ""; 

			$str_len = preg_match_all('/[\x00-\x7F\xC0-\xFD]/', $str, $dummy); 
			if($len >= $str_len) 
			{ 
				return $str; 
			} 
			else 
			{ 
				$newstr = mb_substr($str,0,$len,'utf-8'); 
				return $newstr.$etc; 
			} 
		} 

        //get title and id of rss news by given array of id
        //input:  array of id
        //output: array of array('text','id','time')
        function get_rss_text_id($id_arr)
        {
               $this->db->select('artical_id as id, title as text, pubDate as time');
               $this->db->where_in('artical_id', $id_arr);
               $query = $this->db->get('rss_artical_data');
               if($query->num_rows() > 0)
               {
                   return $query->result_array();
               }
               return array();
        }
		
		//input:array('table','attr','id','lang')
		function get_cate_name($data)
		{
			switch($data['lang'])
			{
				case 'chinese':$langCode = 'zh';break;
				case 'english':$langCode = 'en';break;
				case 'german':$langCode = 'de';break;
				case 'italian':$langCode = 'it';break;
			}
			$this->db->select($data['attr'].'_name');
			$this->db->where($data['attr'].'_id',$data['id']);
			$this->db->where('langCode',$langCode);
			if($langCode != 'zh' && $data['attr'] == 'sub_cate')
			{
				$query = $this->db->get('sub_category_ext');
			}
			else
			{
				$query = $this->db->get($data['table']);	
			}
			$row = $query->row_array();
			return $row[$data['attr'].'_name'];
		}
		
		//get link by article_id
		function get_article_link($article_id)
		{
			$this->db->select('link');
			$this->db->where('artical_id',$article_id);
			$query = $this->db->get('rss_artical_data');
			if($query->num_rows() > 0)
			{
				$row = $query->row();
				return $row->link;
			}
			else
			{
				return '';
			}
		}

	 
  }//END OF CLASS
  