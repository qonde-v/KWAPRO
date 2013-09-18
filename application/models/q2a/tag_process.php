<?php
  class Tag_process extends CI_Model
  {
	 function __construct()
	 {
	    parent::__construct();
	 }

	 //update the count for spec tag
	 //input: array('count','tag')
	 function tag_used_update($data)
	 {
	    $sql = "UPDATE tag SET count = count+{$data['count']} WHERE tag_name = '{$data['tag']}'";
		 $query = $this->db->query($sql);
	 }

	 //store array of tags for the corresponding question
	 //input: array('nId'--node id of the quesiton,'tag'--array of tags or tags_str);
	 function tag_store4question($data)
	 {
		 if($this->tag_exist_check($data['nId']))
		 {//tags for the question exist already,so update them
			 $this->tag_update4question($data);
		 }
		 else
		 {//tags for the question not exist, so insert them
			 $this->tag_insert4question($data);
		 }
	 }


	 //update an array of tags for a certain question
	 //input: array('nId'--node id of the quesiton,'tag'--array of tags or tags_str);
	 function tag_update4question($data)
	 {
		 $tag_str = is_array($data['tag']) ? implode('|', $data['tag']):$data['tag'];
		 $this->db->where('nId',$data['nId']);
		 $this->db->set('tags',$tag_str);
		 $this->db->update('questiontags');
	 }

	 //insert an array of tags for a certain question
	 //input: array('nId'--node id of the quesiton,'tag'--array of tags or tags_str);
	 function tag_insert4question($data)
	 {
		 $tag_str = is_array($data['tag']) ? implode('|', $data['tag']):$data['tag'];
		 $this->db->set('nId',$data['nId']);
		 $this->db->set('tags',$tag_str);
		 $this->db->insert('questiontags');
	 }


	 //check if there exist tags for a certain question
	 //input: nId--node id of the question
	 function tag_exist_check($nId)
	 {
		 $this->db->select('qtId');
		 $this->db->where('nId',$nId);
		 $query = $this->db->get('questiontags');
		 if($query->num_rows() > 0)
		 {//exist
			 return TRUE;
		 }
		 else
		 {//not exist
			 return FALSE;
		 }
	 }

	 //update the reverse index for tag--question
	 //input: array('nId','tag'--array of tag)
	 function tag_reverse_index_update($data)
	 {
	    //todo:
		foreach($data['tag'] as $tag)
		{
		   $tag_id = $this->get_tag_id($tag);

		   if($this->is_tag_index_exist($tag_id))
		   {
		      $this->tag_index_qid_update(array('nId'=>$data['nId'], 'tag_id'=>$tag_id));
		   }
		   else
		   {
		      $this->tag_index_qid_insert(array('nId'=>$data['nId'], 'tag_id'=>$tag_id));
		   }

		}
	 }

	 //get tag id by tag text
	 //'table'--tag
	 //return tag id if exist,otherwise return null
	 function get_tag_id($tag)
	 {
	   //todo:
       $this->db->select('tag_id');
       $this->db->where('tag_name',$tag);
       $query = $this->db->get('tag');
       if($query->num_rows() > 0)
       {
            foreach($query->result() as $row)
            {
                return $row->tag_id;
            }
       }
       else
       {
            return NULL;
       }
	 }



	 //insert tag reverse index in to table
	 //'table'--tag_reverse_index
	 //input:array('nId','tag_id')
	 function tag_index_qid_insert($data)
	 {
	    $sql = "INSERT INTO tag_reverse_index(tag_id,question_id_str) VALUES({$data['tag_id']},{$data['nId']})";
        $this->db->query($sql);
	 }


	 //update the question id string of tag index
	 //'table'--tag_reverse_index
	 //input:array('nId','tag_id')
	 function tag_index_qid_update($data)
	 {
       $sql = "UPDATE tag_reverse_index SET question_id_str = concat(`question_id_str`,' {$data['nId']}') WHERE tag_id = {$data['tag_id']}";
       $query = $this->db->query($sql);
	 }

	 //check if the tag as an index exist in DB
	 //table--'tag_reverse_index'
	 //return true if exist,otherwise return false
	 function is_tag_index_exist($tag_id)
	 {
	     //todo:
         $this->db->select('id');
         $this->db->where('tag_id',$tag_id);
         $query = $this->db->get('tag_reverse_index');
         if($query->num_rows() > 0)
         {
         //exist
            return TRUE;
         }
         else
         {
            return FALSE;
         }

	 }

	 /*****************************************************************/
	 //get tag used times from DB
	 //return -1 if tag not exist in DB,else return the reference time
	 function get_tag_frequency($tag)
	 {
	    //todo:
		$sql="SELECT count FROM tag WHERE tag_name='{$tag}'";
		$query = $this->db->query($sql);

		if($query->num_rows() > 0)
		{
		       foreach($query->result() as $row)
			   {
			      return $row->count;
			   }
		}
		else
		{
		   return -1;
		}
	 }

	 //parse the question tag
	 //return array('tag_id','tag_name','sub_cate_id','count')
	 function questiontag_parse($data)
	 {
	    //todo:
	 }

     //get all the category by language code
	 //input: array('langCode')
	 //return: array of ('category_id','category_name')
	 function get_category_data($data)
	 {
	    //todo:
		$sql = "SELECT category_id,category_name FROM category WHERE langCode = '{$data['langCode']}'";
		$query = $this->db->query($sql);
		$cate_arr = array();

		if($query->num_rows() > 0)
		{
		       foreach($query->result() as $row)
			   {
			       array_push($cate_arr,array('category_id'=>$row->category_id,'category_name'=>$row->category_name));
			   }
		}
		return $cate_arr;
	 }


	 //get all the sub category data by specified category id and language code
	 //input: array('category_id','langCode');
	 //return array of ('sub_cate_id','sub_cate_name','category_id')
	 function get_subcategory_data($data,$table='sub_category')
	 {
	    //todo:
		$sql = "SELECT sub_cate_id,sub_cate_name FROM {$table} WHERE langCode = '{$data['langCode']}' and category_id = {$data['category_id']}";
		$query = $this->db->query($sql);
		$cate_arr = array();

		if($query->num_rows() > 0)
		{
		       foreach($query->result() as $row)
			   {
			       array_push($cate_arr,array('sub_cate_id'=>$row->sub_cate_id,'sub_cate_name'=>$row->sub_cate_name,'category_id'=>$data['category_id']));
			   }
		}
		return $cate_arr;
	 }

	 //get all the sub category data by specified category id and language code
	 //input: array('category_id','langCode');
	 //return array of ('sub_cate_id','sub_cate_name','category_id')
	 function get_subcategory_data_mutli($data)
	 {
	    $table = 'sub_category';
		if($data['langCode'] != 'zh')
		{
		   $table = 'sub_category_ext';
		}

		return $this->get_subcategory_data($data,$table);
	 }


	 //get sub category id  and category id by matching the tag
	 //input:  array of tag id
	 //output: array('sub_cate'--array of sub category id,'cate'--array of category id)
	 function get_catedata_by_tag($data)
	 {
	   if(empty($data))
	   {
	     return array('sub_cate'=>'', 'cate'=>'');
	   }

	   $id_str = '('.implode(',',$data).')';
	   $sql = "SELECT DISTINCT sub_cate_id,category_id FROM tag WHERE tag_id in {$id_str}";
	   $query = $this->db->query($sql);

	   $sub_cate_data = array();
	   $cate_data = array();

	   if($query->num_rows() > 0)
	   {
		       foreach($query->result() as $row)
			   {
			       array_push($sub_cate_data, $row->sub_cate_id);
			       array_push($cate_data, $row->category_id);
			   }
	   }

	   $cate_data = array_values(array_unique($cate_data));
	   return array('sub_cate'=>$sub_cate_data, 'cate'=>$cate_data);
	 }

	 //input: array of tags
	 //output: array of (category_id,sub_cate_id,tag_id,tag_name)
	 function get_id_by_text($data)
	 {
	   if(empty($data))
	   {
	      return array();
	   }

	   $tag_str = '(\''.implode('\',\'',$data).'\')';
	   $sql = "SELECT tag_id,tag_name,sub_cate_id,category_id FROM tag WHERE tag_name in {$tag_str}";
	   $query = $this->db->query($sql);
	   $id_data = array();

	   if($query->num_rows() > 0)
	   {
		       foreach($query->result() as $row)
			   {
			       array_push($id_data, array($row->category_id,$row->sub_cate_id,$row->tag_id,$row->tag_name));
			   }
	   }
	   return $id_data;
	 }

	 //
	 function tag_frequence_update($tag_id_arr)
	 {
		 if(!empty($tag_id_arr))
		 {
			 $tag_str = '('.implode(',',$tag_id_arr).')';
			 $sql = "UPDATE tag SET `count` = `count` + 1 WHERE tag_id in {$tag_str}";
			 $this->db->query($sql);
		 }
		 //echo $sql;
	 }

	 //******************************************************************************//
	 //get hot tags
	 //input: array('num','lang_code');
	 //output: array of array('tag_name','tag_id','count')
	 function get_hot_tags($data)
	 {
	    $num = isset($data['num']) ? isset($data['num']) : 10;
		$lang_code = isset($data['lang_code']) ? isset($data['lang_code']) : 'zh';

		$sql = "SELECT tag_name,tag_id,count FROM tag WHERE langCode = '{$lang_code}' ORDER BY count DESC LIMIT {$num}";
		$query = $this->db->query($sql);

		$tag_data = array();

	    if($query->num_rows() > 0)
	    {
		       foreach($query->result() as $row)
			   {
			       array_push($tag_data, array('tag_name'=>$row->tag_name, 'tag_id'=>$row->tag_id, 'count'=>$row->count));
			   }
	    }
	    return $tag_data;
	 }

	 //store tag into public tag table
	 //input:  array('sub_cate_id','category_id','langCode','tag_name','count')
	 //return: new tag id
	 function tag_insert($data)
	 {
        $data['add_flag'] = 1;
		$this->db->insert('tag',$data);
		return $this->db->insert_id();
	 }

	 //sub category added process
	 //input: array('sub_cate_name','langCode','category_id')
	 function subcate_add($data)
	 {
	    $table = 'sub_category';
		if($data['langCode'] != 'zh')
		{
		   $table = 'sub_category_ext';
		}
		return $this->subcate_add_event($data,$table);
	 }

	 //sub category added process by language code
	 //input: array('sub_cate_name','langCode','category_id'), @table--table name to insert the data
	 function subcate_add_event($data,$table)
	 {
	 		if(!$this->sub_cate_exist($data,$table))
	 		{
	    	$this->db->insert($table,$data);
				return $this->db->insert_id();
			}
			else
			{
				return '';
			}
	 }
	 
	 //check if sub cate exist
	 //input: array('sub_cate_name','langCode','category_id'), @table--table name to insert the data
	 function sub_cate_exist($data,$table)
	 {
	 		$this->db->select('sub_cate_id');
	 		$this->db->where($data);
	 		$query = $this->db->get($table);
	 		if($query->num_rows() > 0)
	 		{
	 			return true;
	 		}
	 		else
	 		{
	 			return false;
	 		}
		}
		
		//get category id by sub_cate_id
		//input: array('sub_cate_id','langCode')
		//output: category_id
		//table--
		function get_categoryid_by_subcateid($data)
		{
			$table = 'sub_category';
			if($data['langCode'] != 'zh')
			{
		   	$table = 'sub_category_ext';
			}
			$this->db->select('category_id');
			$this->db->where($data);
			$query = $this->db->get($table);
			$row = $query->row();
			return $row->category_id;
		}

	 //get category name by given category id
	 //input:  array('category_id','langCode')
	 //output: category name
	 function get_categoryname_by_id($data)
	 {
	    //
		$table = 'category';
		$input_data = array('table'=>$table, 'column_id'=>'category_id', 'column_name'=>'category_name','val'=>$data['category_id']);
		return $this->_fun_get_text_by_id($input_data);
	 }

	 //get sub category name by given sub category id
	 //input:  array('sub_cate_id','langCode')
	 //output: sub category name
	 function get_subcatename_by_id($data)
	 {
	    $table = 'sub_category';
		if($data['langCode'] != 'zh')
		{
		   $table = 'sub_category_ext';
		}
		$input_data = array('table'=>$table, 'column_id'=>'sub_cate_id', 'column_name'=>'sub_cate_name','val'=>$data['sub_cate_id']);
		return $this->_fun_get_text_by_id($input_data);
	 }

	 //common function that get text by id val from
	 //given table, given column of id and given column of text
	 //input: array('table','column_id','column_name','val')
	 //output: text of the given column_name value
	 function _fun_get_text_by_id($data)
	 {
	   $this->db->select($data['column_name']);
       $this->db->where($data['column_id'],$data['val']);
       $query = $this->db->get($data['table']);

	   if($query->num_rows() > 0)
       {
          $row = $query->row_array();
		  return $row[$data['column_name']];
	   }
	   return '';
	 }


	 //get category name and sub category name by given tag id and language code
	 //input:  array('tag_id','langCode')
	 //output: array('c_name','sc_name')
	 function generate_cate_name_info($data)
	 {
	    $cate_id_info = $this->get_catedata_by_tag(array($data['tag_id']));

		$category_name = $this->get_categoryname_by_id(array('category_id'=>$cate_id_info['cate'][0], 'langCode'=>$data['langCode']));
		$sub_cate_name = $this->get_subcatename_by_id(array('sub_cate_id'=>$cate_id_info['sub_cate'][0], 'langCode'=>$data['langCode']));

		return array('c_name'=>$category_name,'sc_name'=>$sub_cate_name);
	 }
	 
	 	//get tags of a sub category
	 	//input: array('langCode','subcate_id')
	 	//
	 	//table--'tag'
	 	function get_tag_by_subcate($data)
	 	{
	 			$this->db->select('tag_id,tag_name');
	 			$this->db->where('langCode',$data['langCode']);
	 			$this->db->where('sub_cate_id',$data['subcate_id']);
	 			$this->db->where('add_flag', 1);
	 			$this->db->order_by('count','desc');
	 			$this->db->limit(50);
	 			$query = $this->db->get('tag');
	 			$result = array();
	 			if($query->num_rows() > 0)
	 			{
	 					foreach($query->result() as $row)
	 					{
	 							array_push($result,array('tag_id'=>$row->tag_id,'tag_name'=>$row->tag_name));
	 					}
	 			}
	 			return $result;
		}
		
		//search category by text
		//input: array('langCode','text')
		//output: array(array('category_id','category_name'))
		function search_category($data)
		{
			$this->db->select('category_id,category_name');
			$this->db->where('langCode',$data['langCode']);
			$this->db->like('category_name',$data['text']);
			$query = $this->db->get('category');
			$result = array();
			if($query->num_rows() > 0)
			{
				foreach($query->result() as $row)
				{
					array_push($result,array('category_id'=> $row->category_id,'category_name'=> $row->category_name));
				}
			}
			return $result;
		}
		
		//search sub_cate by text
		//input: array('langCode','text','category_id')
		//output: array(array('category_id','sub_cate_id','sub_cate_name'))
		function search_sub_cate($data)
		{
			$this->db->select('sub_cate_id,sub_cate_name');
			$this->db->where('category_id',$data['category_id']);
			if($data['text'] != '')
			{
				$this->db->like('sub_cate_name',$data['text']);
			}
			if($data['langCode'] == 'zh')
			{
				$query = $this->db->get('sub_category');
			}
			else
			{
				$this->db->where('langCode',$data['langCode']);
				$query = $this->db->get('sub_category_ext');
			}
			$result = array();
			if($query->num_rows() > 0)
			{
				foreach($query->result() as $row)
				{
					array_push($result,array('category_id'=> $data['category_id'],'sub_cate_id'=> $row->sub_cate_id , 'sub_cate_name'=> $row->sub_cate_name));
				}
			}
			return $result;
		}
		
		//search tag by text
		//input: array('langCode','text','subcate_id')
		//output: array(array('tag_id','tag_name'))
		function search_tag($data)
		{
				$this->db->select('tag_id,tag_name');
	 			$this->db->where('langCode',$data['langCode']);
	 			$this->db->where('sub_cate_id',$data['subcate_id']);
	 			if($data['text'] != '')
	 			{
	 				$this->db->like('tag_name',$data['text']);
	 			}
	 			$this->db->order_by('count','desc');
	 			$this->db->limit(50);
	 			$query = $this->db->get('tag');
	 			$result = array();
	 			if($query->num_rows() > 0)
	 			{
	 					foreach($query->result() as $row)
	 					{
	 							array_push($result,array('tag_id'=>$row->tag_id,'tag_name'=>$row->tag_name));
	 					}
	 			}
	 			return $result;
		}

  }//class

/*End of file*/
/*Location: ./system/appllication/model/tag_process.php*/
