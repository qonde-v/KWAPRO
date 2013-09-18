<?php
  class Search extends CI_Model
  {
	 function __construct()
	 {
	    parent::__construct();
		$this->load->helper('define');
		$this->load->model('q2a/Question_data');
		$this->load->model('q2a/Sphinx_search');
		$this->load->model('q2a/User_data');
	 }

	 //search question by matching the tags
	 //input: array of tags
	 //ouput: array of question nid
     //table--'tag','tag_reverse_index'
	 function search_by_tags($data,$connect_type='and')
	 {
        $this->db->select('question_id_str');
        $this->db->where_in('tag.tag_name',$data);
        $this->db->join('tag','tag.tag_id = tag_reverse_index.tag_id');
        $query = $this->db->get('tag_reverse_index');
        $question_nid_arr = array();
        if($query->num_rows() > 0)
        {
            $first_str = $query->row();
            $question_nid_arr = explode(" ",$first_str->question_id_str);

            if($connect_type == 'and')
            {
                foreach($query->result() as $row)
                {
                    $question_nid_arr = array_intersect($question_nid_arr,explode(" ",$row->question_id_str));
                }
            }
            else         // $connect_type == 'or'
            {
                foreach($query->result() as $row)
                {
                    $question_nid_arr = array_unique(array_merge($question_nid_arr,explode(" ",$row->question_id_str)));
                }
            }
        }
        return $question_nid_arr;
	 }

	 //search question that asked by specific user
	 //input: array('uId')
	 //ouput: array of question nid
     //table--'node'
	 function search_by_user_asked($data)
	 {
	     //todo:
         $this->db->select('nId');
         $this->db->where_in('uId',$data);
         $this->db->where('ntId',QUESTION);
         $query = $this->db->get('node');
         $question_nid_arr = array();
         if($query->num_rows() > 0)
         {
            foreach($query->result() as $row)
            {
                array_push($question_nid_arr,$row->nId);
            }
         }
         return $question_nid_arr;
	 }

	 //search question that answered by specific user
	 //input: array('uId')
	 //ouput: array of question nid
     //table--'node','node_relation'
	 function search_by_user_answered($data)
	 {
	     //todo:
         $this->db->select('nToId');
         $this->db->where_in('node.uId',$data);
         $this->db->where('node.ntId',ANSWER);
         $this->db->join('node','node.nId = node_relation.nFromId');
         $query = $this->db->get('node_relation');
         $question_nid_arr = array();
         if($query->num_rows() > 0)
         {
            foreach($query->result() as $row)
            {
                array_push($question_nid_arr,$row->nToId);
            }
         }
         return array_unique($question_nid_arr);
	 }

	 //search question by asked time
	 //input: array('start_time','end_time')
	 //ouput: array of question nid
     //table--'node'
	 function search_by_time($data)
	 {
	    //todo:
        $this->db->select('nId');
        if($data['end_time'] == NULL)
        {
            $this->db->where("time > '{$data['start_time']}'");
        }
        elseif($data['start_time'] == NULL)
        {
            $this->db->where("time < '{$data['end_time']}'");
        }
        else
        {
            $this->db->where("time between '{$data['start_time']}' and '{$data['end_time']}'");
        }

        $this->db->where('ntId',QUESTION);
        $query = $this->db->get('node');

        $question_nid_arr = array();
        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                array_push($question_nid_arr,$row->nId);
            }
        }
        return $question_nid_arr;
	 }

	 //search question by input text string
	 //input:text string
	 //ouput: array of question nid
     //table--'node'
	 function search_by_text($text)
	 {
	    //todo:
        $this->db->select('nId');
        $where = "INSTR(`text`,'$text') > 0";
        $this->db->where($where);
        $this->db->where('ntId',QUESTION);
        $query = $this->db->get('node');

        $question_nid_arr = array();
        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                array_push($question_nid_arr,$row->nId);
            }
        }
        return $question_nid_arr;

	 }

	 //search question by location information
	 //input: array('country_code', 'province_code', 'city_code', 'town_code')
	 //output: array of question id
	 function search_Q_by_location_data($location_data)
	 {
		$question_id_arr = array();

	    if(!empty($location_data))
		{
			if(isset($location_data['town_code']))
			{
				$question_id_arr = $this->_fun_search_by_location_id(array('town_code'=>$location_data['town_code']));
			}
		    if(empty($question_id_arr ))
			{
				if(isset($location_data['city_code']))
				{
					$question_id_arr = $this->_fun_search_by_location_id(array('city_code'=>$location_data['city_code']));
				}
				if(empty($question_id_arr ))
				{
					if(isset($location_data['province_code']))
					{
						$question_id_arr = $this->_fun_search_by_location_id(array('province_code'=>$location_data['province_code']));
					}
					if(empty($question_id_arr ))
					{
						$question_id_arr = $this->_fun_search_by_location_id(array('country_code'=>$location_data['country_code']));
					}
				}
			}
		}
		return $question_id_arr;
	 }

	 //search question by location-level code
	 //input: array(level_code=>level_value)
	 //output: array of question id
	 function _fun_search_by_location_id($data,$num=5)
	 {
	    if(empty($data))
		{
		   return array();
		}
		//print_r($data);
	    $this->db->select('nId');
		$this->db->where($data);
		$this->db->limit($num);
		$query = $this->db->get('question_location');

		$question_id_arr = array();

		if($query->num_rows() > 0)
		{
		   foreach($query->result() as $row)
		   {
			   array_push($question_id_arr, $row->nId);
		   }
		}
		return array_values(array_unique($question_id_arr));
	 }

	 //search question by sub category and category
	 //input:array('cate'=>array of category id, 'sub_cate'=>array of sub category id)
	 //output: array of quesiton node id
	 function search_by_cate_data($cate_data)
	 {
	     $quesiton_id_arr = $this->search_by_sub_category($cate_data['sub_cate']);
		 if(empty($quesiton_id_arr))
		 {
		    $quesiton_id_arr = $this->search_by_category($cate_data['cate']);
		 }
		 return $quesiton_id_arr;
	 }

	 //search question by tag
	 //input:array of tag id, range--array('start','end'), empty for default value
	 //output: array of quesiton node id
	 function search_Q_by_tagid($id_arr,$range=array())
	 {
	    $data = array('column'=>'tag_id', 'id_arr'=>$id_arr);
		return $this->search_question_by_cateinfo($data,$range);
	 }


	  //search question by sub category
	  //input: array of sub category id
	  function search_by_sub_category($id_arr)
	  {
		 $data = array('column'=>'sub_cate_id', 'id_arr'=>$id_arr);
		 return $this->search_question_by_cateinfo($data);
	  }

	  //search question by category
	  //input: array of category id
	  function search_by_category($id_arr)
	  {
		 $data = array('column'=>'category_id', 'id_arr'=>$id_arr);
		 return $this->search_question_by_cateinfo($data);
	  }

	  //search question by category or sub category information
	  //input:  $data = array('column'=>column name, 'id_arr'=>array of id),$range = array('start'=>,'end'=>)
      //if $range is empty, return all
	  //output:
	  function search_question_by_cateinfo($data,$range = array())
	  {

		 $id_arr = $data['id_arr'];
		 $column = $data['column'];

		 if(empty($id_arr))
		 {
			return array();
		 }

		 $question_id_arr = array();

		 $this->db->select('question_tag.nId');
		 $this->db->where_in($column,$id_arr);
         $this->db->join('node','node.nId = question_tag.nId');
         $this->db->order_by('node.time','desc');
         $this->db->distinct();
         if(!empty($range))
         {
            $this->db->limit($range['end']-$range['start']+1,$range['start']);
         }
		 $query = $this->db->get('question_tag');

		 if($query->num_rows() > 0)
		 {
			   foreach($query->result() as $row)
			   {
				   array_push($question_id_arr, $row->nId);
			   }
		 }
		 return $question_id_arr;
	  }

	  //re-generate data string for db query
	  function array_token_combine($data)
	  {
	     $arr = array();
	     for($i=0; $i<count($data); $i++)
		 {
		    $arr[$i] = "'".$data[$i]."'";
		 }
		 return $arr;
	  }

	  //search related question by matching question tags
	  //input:  array of tags
	  //output: array of question id
	  function search_by_tagname($tag_arr)
	  {
	     //todo:
		 //$tag_arr = $this->array_token_combine($tag_arr);
		 $data = array('column'=>'tag_name', 'id_arr'=>$tag_arr);
		 return $this->search_question_by_cateinfo($data);
	  }

	  //search related question matching question tags and location infomation
	  //input: nId for a certain question
	  //output: array of question nId
	  function search_Q_by_tag_location($nId)
	  {
		  $tag_str = $this->Question_data->get_question_tags($nId);
		  $tag_str_arr = explode("|",$tag_str);
		  $search_res = $this->Sphinx_search->question_search($tag_str_arr, array('start'=>0,'end'=>5));
		  $nid_arr_tag = $search_res['id_arr'];
		  $data = array();
		  foreach($nid_arr_tag as $item)
          {
                 if($item != $nId)
                 {
                       array_push($data,$item);
                 }
          }
		  return $data;
	  }

      //search question by tag name
      //input : array(nid,array of tag name)
      //table--'questiontags'
      //output : array of question nId
      function search_Q_by_tagname($data)
      {
          $q_nId_arr = array();
          foreach($data['tags'] as $tag)
          {
                $this->db->select('nId');
                $this->db->where('nId !=',$data['nId']);
                $this->db->like('tags',$tag);
                $query = $this->db->get('questiontags');
                if($query->num_rows() > 0)
                {
                    foreach($query->result() as $row)
                    {
                        array_push($q_nId_arr,$row->nId);
                    }
                }
          }
          if(empty($q_nId_arr))
          {
            return array();
          }
          else
          {
            $arr = array_count_values($q_nId_arr);
            arsort($arr);
            $arr = array_keys($arr);
            $result = array();
            for($i=0;$i<5;$i++)
            {
                array_push($result,$arr[$i]);
            }
            return $result;
          }
      }

	  //********************************USERNAME MATCH*********************************//
	  //search username by specify matching condition
	  //input: array('match_str','match_type');
	  function search_username($data)
	  {
	     $username_data = array();
	     switch($data['match_type'])
		 {
		     case MATCH_BEGIN:
			   $username_data = $this->match_username_begin($data['match_str']);
			   break;
			 case MATCH_INCLUDE:
			   $username_data = $this->match_username_include($data['match_str']);
			   break;
			 default:
			   $username_data = $this->match_username_begin($data['match_str']);
			   break;
		 }
		 return $username_data;
	  }

	  //
	  function match_username_begin($match_str)
	  {
	     //$sql = "SELECT uId,username FROM user WHERE username LIKE '{$match_str}%'";
		 //$query = $this->db->query($sql);

		 $this->db->select("uId,username");
		 $this->db->like('username',$match_str,'after');
		 $this->db->where('uId >',0);
		 $query = $this->db->get('user');

		 $data = array();

		 if($query->num_rows() > 0)
		 {
			   foreach($query->result() as $row)
			   {
				   $data[$row->uId] = $row->username;
			   }
		 }
		 return $data;
	  }

	  //
	  function match_username_include($match_str)
	  {
	     //$sql = "SELECT uId,username FROM user WHERE username LIKE '%{$match_str}%'";
		 //$query = $this->db->query($sql);

		 $this->db->select("uId,username");
		 $this->db->like('username',$match_str);
		 $this->db->where('uId >',0);
		 $query = $this->db->get('user');

		 $data = array();

		 if($query->num_rows() > 0)
		 {
			   foreach($query->result() as $row)
			   {
				   $data[$row->uId] = $row->username;
			   }
		 }
		 return $data;
	  }

	  //input: array('category_id','sub_cate_id','keyword')
	  function search_tag($data,$num=5)
	  {
		  $keyword = $data['keyword'];
		  unset($data['keyword']);
		  $this->db->select("tag_id,tag_name");
		  $this->db->where($data);
		  $this->db->like('tag_name',$keyword, 'after');
		  $this->db->limit($num);
		  $query = $this->db->get('tag');

		  $data = array();

		  if($query->num_rows() > 0)
		  {
			   foreach($query->result() as $row)
			   {
				   $data[$row->tag_id] = $row->tag_name;
			   }
		  }
		  return $data;
	  }

	  //tag match by keyword
	  //input: array('keyword','num')
	  //output: array('tag_id','tag_name','count');
	  function tag_match($data)
	  {
	      $this->db->select("tag_id,tag_name,count");
		  $this->db->like('tag_name',$data['keyword'], 'after');
		  $this->db->order_by("count", "desc");
		  $this->db->limit($data['num']);
		  $query = $this->db->get('tag');

		  if($query->num_rows() > 0)
		  {
			   return $query->result_array();
		  }
		  return array();
	  }

	  //get searched question number by tag id
	  //input: array of tag id
	  //output: question number
	  function _get_searched_Q_num($data)
	  {
	       $this->db->distinct();
		   $this->db->select('nId');
	       $this->db->where_in('tag_id', $data);
           $this->db->from('question_tag');
           return $this->db->count_all_results();
	  }
	  
	//search friends by keyword
	//input : array('keyword','uId')
	function friend_match($data)
	{
		$this->db->select('user.uId,user.username');
		$this->db->like('user.username',$data['keyword']);
		$this->db->join('user_friends','user_friends.friend_uId = user.uId');
		$this->db->where('user_friends.uId',$data['uId']);
		$query = $this->db->get('user');
		$result = array();
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				$photo_path = $this->User_data->get_user_headphotopath($row->uId);
				array_push($result,array('uId'=>$row->uId,'username'=>$row->username,'photo_path'=>$photo_path));
			}
		}
		return $result;
	}
	
	//search location data
	//input:array('code','type')
	function search_location_data($data)
	{
		$this->db->select($data['type'].'_code,'.$data['type'].'_name');
		$this->db->where($data['attr'].'_code',$data['code']);
		$query = $this->db->get($data['type'].'_table');
		$arr = array();
		if($query->num_rows() > 0)
		{
			foreach($query->result_array() as $row)
			{
				array_push($arr,$row[$data['type'].'_code'].'#'.$row[$data['type'].'_name']);
			}
		}
		$result = implode('@',$arr);
		return $result;
	}
 }
/*End of file*/
/*Location: ./system/appllication/model/search.php*/
