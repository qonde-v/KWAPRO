<?php
  class User_profile extends CI_Model
  {
	 function __construct()
	 {
	    parent::__construct();
		$this->load->helper('define');
		$this->load->helper('kpc_define');

	    $this->load->model('q2a/User_data');
		$this->load->model('q2a/Kpc_manage');
	    $this->load->model('q2a/User_privatetag_manage');
	    $this->load->model('q2a/Rss_manage');
	 }

	 /////////////////////////////////////Data display/////////////////////////
	 /********************************Basic data display*******************************/

	//output: array('username','email','passwd','gender','birthday')
	//table -- 'user'
	function get_user_basicdata($uId)
	{
        $this->db->select('*');
        $this->db->where('uId',$uId);
        $query = $this->db->get('user');
        $data = array();

		 if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                return array('username'=>$row->username,'email'=>$row->email,'passwd'=>$row->passwd,'langCode'=>$row->langCode,'gender'=>$row->gender,'birthday'=>$row->birthday,'nickname'=>$row->nickname,'realname'=>$row->realname,'qq'=>$row->qq,'weibo'=>$row->weibo,'address'=>$row->address,'address_now'=>$row->address_now,'age'=>$row->age,'school'=>$row->school,'tel'=>$row->tel,'description'=>$row->description,'tag'=>$row->tag,'avatar'=>$row->avatar);
            }
        }
		 else
		 {
		    return array('username'=>'','email'=>'','passwd'=>'');
		 }

	}

    //get all language data from table 'language'
	function get_all_language_data()
	{
	   $sql = "SELECT langName,langCode FROM language WHERE is_used = 1";
	   $query = $this->db->query($sql);
		$data = array();

	   	if($query->num_rows() > 0)
		{
		     foreach($query->result() as $row)
            {
                $data[$row->langCode] = $row->langName;
            }
		}
		return $data;
	}

	//input: $uId
	//output: array('langCode','location','tag','language_data');
   //'location'--array('country_code', 'province_code', 'city_code', 'town_code','town_name')
   //'tag'-- array of array('tag_id','tag_name')
   //table--'user','user_location','user_tag'
	function get_user_advancedata($uId)
	{
	   $advance_data = array();

	   $advance_data['langCode'] = $this->User_data->get_user_langcode($uId);

	   //$advance_data['language_data'] = $this->get_all_language_data();

	   //$advance_data['tag'] = $this->User_data->get_user_private_tag_data($uId);
	   $advance_data['location'] = $this->User_data->get_user_location($uId);
	   
	   $advance_data['rcv_rss'] = $this->get_rcv_rss($uId);

	   return $advance_data;
	}
	
	function get_user_rssdata($data)
	{
			return $this->Rss_manage->get_rss_feed4user($data);
	}

    //get user's follow tags
	//input: array('uId','lang_code')
	function profile_get_user_tag($data)
	{
	   $subcate_table = 'sub_category';

	   if($data['lang_code'] != 'zh')
	   {
	      $subcate_table = 'sub_category_ext';
	   }
	   return $this->User_data->get_user_tags($data['uId'],$subcate_table,$data['lang_code']);
	}


    //return the selected sendtype for user
    //table--'sendtype4user'
    function user_method_selected($uId)
    {
        $this->db->select('stId');
        $this->db->where('uId',$uId);
        $query = $this->db->get('sendtype4user');
        $data = array();
        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                array_push($data,$row->stId);
            }
        }
        return $data;
    }

	//get all sendtype in table 'sendtype'
	//output: array of record item in 'sendtype'
	function get_all_sendtype()
	{
	   $this->db->select('stId,stText');
	   $this->db->where('stId != '.ONLINE);
	   $this->db->where_in('stId',array(12,13));
	   $query = $this->db->get('sendtype');
	   $data = array();

	   if($query->num_rows() > 0)
	   {
	      foreach($query->result() as $row)
		  {
		     $data[$row->stId] = $row->stText;
		  }
	   }
	   return $data;
	}

	//output: array(array('stId','account','isSelected','is_visible'))
	//table--'useraccount'
	function get_user_methoddata($uId)
	{
        $this->db->select('stId,account,is_visible');
        $this->db->where('uId',$uId);
        $query = $this->db->get('useraccount');
        $data = array();
        if($query->num_rows() > 0)
        {
            $stId_selected = $this->user_method_selected($uId);
            foreach($query->result() as $row)
            {
			    $is_selected = 0;
                if(in_array($row->stId,$stId_selected))
                {
				   $is_selected = 1;
                }
                $data[$row->stId] = array('stId'=>$row->stId,'account'=>$row->account,'is_visible'=>$row->is_visible,'isSelected'=>$is_selected);
            }
        }
        return $data;
	}



    /////////////////////////////////////Data process/////////////////////////
	/**************************Basic data process******************************/
	//process user basic data
	//input: array('uId','birthday','passwd','gender')
	function user_basicdata_process($data)
	{
	   if($data['passwd'])
	   {//if value 'passwd' is not null, update user's passeword
	      $this->user_passwd_update($data);
	   }
	   //update user's basic setting: (gender,birthday)
	   $this->user_basicdata_save($data);
	}


	//update user's password and email
	//'table'--user
	//$data = array('uId','passwd')
	 function user_passwd_update($data)
	 {
	    $encode_passwd = MD5($data['passwd']);
	    $sql = "UPDATE user SET passwd = '{$encode_passwd}' WHERE uId = {$data['uId']}";
		$this->db->query($sql);
	 }

	 //update user's basic setting
	 //input: array('uId','birthday','gender','langCode','location')
	 function user_basicdata_save($data)
	 {
		$sql = "UPDATE user SET gender = {$data['gender']},birthday = '{$data['birthday']}',langCode = '{$data['langCode']}',age = '{$data['age']}',nickname = '{$data['nickname']}',realname = '{$data['realname']}',qq = '{$data['qq']}',tel = '{$data['tel']}',email = '{$data['email']}',address = '{$data['address']}',address_now = '{$data['address_now']}',description = '{$data['description']}',school = '{$data['school']}',tag = '{$data['tag']}' WHERE uId = {$data['uId']}";
		$this->db->query($sql);
		//$this->user_location_save($data);
	 }

/*****************************Advance data process***************************/
/**************************************************************************************/

	 //$data = array('uId','langCode','tag','location','rcv_rss')
	 //'tag' -- array of tag information
	 //'location' -- array of location information
	 function user_advancedata_process($data)
	 {
	    $this->user_advancedata_save($data);
	 }

	  //$data = array('uId','langCode','tag','location')
	 //'tag' -- array of tag information
	 //'location' -- array of location information
	 function user_advancedata_save($data)
	 {
		 //$this->user_language_save($data);
		 //$this->user_location_save($data);
		 $this->user_rss_feed_update($data);
		 $this->User_privatetag_manage->user_private_tag_save($data);		 
		 //$this->user_rcv_rss_save($data);
	 }
	 
	 //update a user's rss setting when s/he save the tag setting
	 //input: array of ('uId','tag')
	 function user_rss_feed_update($data)
	 {
	 	$sub_cate_db = $this->User_privatetag_manage->get_user_sub_cate($data['uId']);
		$sub_cate_save = $this->get_new_add_sub_cate($data['tag']);
		$sub_cate_add = array_diff($sub_cate_save,$sub_cate_db);
		/*print_r($sub_cate_db);
		print_r($sub_cate_save);
		print_r($sub_cate_add);*/
		$sub_cate_delete = array_diff($sub_cate_db,$sub_cate_save);
		$this->user_rss_feed_update_subcate(array('uId'=>$data['uId'],'add'=>$sub_cate_add,'delete'=>$sub_cate_delete,'langCode'=>$data['langCode']));
	 }
	 
	 //get sub_cate_id info by array of tags
	 //input: array('tag_id','tag_name','category_id','sub_cate_id')
	 //output : array of sub_cate_id
	 function get_new_add_sub_cate($data)
	 {
	 	$result = array();
		if(empty($data))
		{
			return $result;
		}
		foreach($data as $tag_item)
		{
			if(!in_array($tag_item['sub_cate_id'],$result))
			{
				array_push($result,$tag_item['sub_cate_id']);
			}
		}
		return $result;
	 }
	 
	 //update user's rss feed setting 
	 //input: array of sub_cate_id to add, array of sub_cate_id to delete, langCode
	 //table--'user_rss_feed'
	 function user_rss_feed_update_subcate($data)
	 {
	 	$this->user_rss_feed_insert_subcate(array('uId'=>$data['uId'],'add'=>$data['add'],'langCode'=>$data['langCode']));
		$this->user_rss_feed_delete_subcate(array('uId'=>$data['uId'],'delete'=>$data['delete']));
	 }
	 
	 //insert rss feeds of some categories for a user
	 //input: array('uId','add','langCode')
	 //table--'user_rss_feed'
	 function user_rss_feed_insert_subcate($data)
	 {
	 	if(!empty($data['add']))
		{
			foreach($data['add'] as $sub_cate_id)
			{
				$rss_feed_id_arr = $this->Rss_manage->get_rss_feed_id_by_subcateid(array('sub_cate_id'=>$sub_cate_id,'langCode'=>$data['langCode']));
				if(!empty($rss_feed_id_arr))
				{
					foreach($rss_feed_id_arr as $rss_feed_id)
					{
						$this->db->set('uId',$data['uId']);
						$this->db->set('sub_cate_id',$sub_cate_id);
						$this->db->set('rss_feed_id',$rss_feed_id);
						$this->db->insert('user_rss_feed');
					}
				}	
			}
		}
	 }
	 
	 //delete rss feeds of some categories for a user
	 //input: array('delete','uId')
	 //table--'user_rss_feed'
	 function user_rss_feed_delete_subcate($data)
	 {
	 	if(!empty($data['delete']))
		{
			$this->db->where_in('sub_cate_id',$data['delete']);
			$this->db->where('uId',$data['uId']);
			$this->db->delete('user_rss_feed');
		}
	 }
	 
	 	 
	 //save user's rss setting
	 	//input : array('uId','rcv_rss','rss_feed')
	 	function rss_setting_save($data)
	 	{
	 			$this->user_rcv_rss_save($data);
	 			$this->user_rss_feed_save($data);
	 	}
	 	
	 	//save user's rss feed setting
	 	//input : array('uId','rcv_rss','rss_feed')
	 	function user_rss_feed_save($data)
	 	{
	 			$rss_feed_id_db = $this->get_user_rss_feed($data['uId']);
				$rss_feed_save_data = $this->generate_rss_data($data['rss_feed']);
				$rss_feed_delete = $this->get_rss_feed_delete_id($rss_feed_id_db,$rss_feed_save_data);
				$rss_feed_insert = $this->get_rss_feed_insert_data($rss_feed_id_db,$rss_feed_save_data);
	 			$this->user_rss_feed_delete($data['uId'],$rss_feed_delete);
	 			$this->user_rss_feed_insert($data['uId'],$rss_feed_insert);
	 	}
		
		//generate rss saving data
		//input: array of rss feed data
		//output : array(array('rss_feed_id','sub_cate_id','url','langCode'))
		function generate_rss_data($data)
		{
			$result = array();
			if(!empty($data))
			{
				foreach($data as $rss_feed)
				{
					$arr = explode('##',$rss_feed);
					$rss_feed_item = array();
					if(count($arr) == 2)
					{
						$rss_feed_item['rss_feed_id'] = $arr[0];
						$rss_feed_item['sub_cate_id']= $arr[1];
					}
					else
					{
						$rss_feed_item['rss_feed_id'] = $arr[0];
						$rss_feed_item['sub_cate_id']= $arr[1];
						$rss_feed_item['url'] = $arr[2];
						$rss_feed_item['langCode']= $arr[3];
					}
					array_push($result,$rss_feed_item);
				}
			}
			return $result;
		}
		
		//get rss_feed_id to be deleted
		//input: array of rss_feed_id of a user in db, array of rss feed save data
		//output: array of rss_feed_id
		function get_rss_feed_delete_id($rss_feed_id_db,$rss_feed_save_data)
		{
			$result = array();
			if(empty($rss_feed_id_db))
			{
				return $result;
			}
			if(empty($rss_feed_save_data))
			{
				return $rss_feed_id_db;
			}

			foreach($rss_feed_id_db as $item)
			{
				$flag = 0;
				foreach($rss_feed_save_data as $row)
				{
					if($item == $row['rss_feed_id'])
					{
						$flag = 1;
						continue;
					}
				}
				if($flag == 0)
				{
					array_push($result,$item);
				}
			}
			return $result;
		}
		
		//get rss data to be inserted
		//input: array of rss_feed_id of a user in db, array of rss feed save data
		//table--'user_rss_feed'
		function get_rss_feed_insert_data($rss_feed_id_db,$rss_feed_save_data)
		{
			$result = array();
			if(empty($rss_feed_save_data))
			{
				return $result;
			}
			if(empty($rss_feed_id_db))
			{
				return $rss_feed_save_data;
			}
			foreach($rss_feed_save_data as $item)
			{
				$flag = 0;
				foreach($rss_feed_id_db as $row)
				{
					if($item['rss_feed_id'] == $row)
					{
						$flag = 1;
						continue;
					}
				}
				if($flag == 0)
				{
					array_push($result,$item);
				}
			}
			return $result;
		}
	 	
	 	//get user's rss feed data in DB
	 	//input : user id
	 	//output: array of rss_feed_id
	 	//table--'user_rss_feed'
	 	function get_user_rss_feed($uId)
	 	{
	 			$this->db->select('rss_feed_id');
	 			$this->db->where('uId',$uId);
	 			$query = $this->db->get('user_rss_feed');
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
	 	
	 	//delete user's rss feed 
	 	//input: user id , array of rss_feed_id
	 	//table--'user_rss_feed'
	 	function user_rss_feed_delete($uId,$data)
	 	{
	 			if(!empty($data))
	 			{
	 					$this->db->where('uId',$uId);
	 					$this->db->where_in('rss_feed_id',$data);
	 					$this->db->delete('user_rss_feed');
	 			}
	 	}
	 	
	 	//insert user's rss feed
	 	//input: user id , array(array('rss_feed_id,'sub_cate_id','url','langCode'))
	 	//table--'user_rss_feed'
	 	function user_rss_feed_insert($uId,$data)
	 	{
	 			if(!empty($data))
	 			{
	 					foreach($data as $rss_feed)
	 					{
	 							if($rss_feed['rss_feed_id'] > 0)
	 							{
	 								$this->db->set('uId',$uId);
	 								$this->db->set('rss_feed_id',$rss_feed['rss_feed_id']);
									$this->db->set('sub_cate_id',$rss_feed['sub_cate_id']);
	 								$this->db->insert('user_rss_feed');
	 							}
	 							else
	 							{
	 								$url = urldecode($rss_feed['url']);
	 								$sub_cate_id = $rss_feed['sub_cate_id'];
	 								$langCode = $rss_feed['langCode'];
	 								$category_id = $this->Tag_process->get_categoryid_by_subcateid(array('sub_cate_id'=> $sub_cate_id, 'langCode'=> $langCode));
	 								$data = array('category_id'=> $category_id, 'sub_cate_id'=> $sub_cate_id, 'langCode'=> $langCode, 'rss_url'=> $url);
	 								$insert_id = $this->Rss_manage->rss_resource_save($data);
	 								
	 								$this->db->set('uId',$uId);
									$this->db->set('sub_cate_id',$sub_cate_id);
	 								$this->db->set('rss_feed_id',$insert_id);
	 								$this->db->insert('user_rss_feed');
	 							}
	 					}
	 			}
	 	}
	 
	 //save whether user receives rss or not
		function user_rcv_rss_save($data)
	 	{
	 		if($this->user_rss_exist($data['uId']))
	 		{
	 				$this->user_rss_update($data);
	 		}
	 		else
	 		{
	 				$this->user_rss_insert($data);
	 		}
		}
		
		//check if setting of user receive rss exist or not
		function user_rss_exist($uId)
		{
				$this->db->select('uId');
				$this->db->where('uId',$uId);
				$query = $this->db->get('user_rss_message');
				if($query->num_rows() > 0)
				{
					return true;
				}
				else
				{
					return false;
				}
		}
		
		//update setting of user receive rss or not
		function user_rss_update($data)
		{
				$this->db->where('uId',$data['uId']);
	 			$this->db->set('rcv_rss',$data['rcv_rss']);
	 			$this->db->update('user_rss_message');
		}
		
		//insert setting of user receive rss or not
		function user_rss_insert($data)
		{
				$this->db->set('uId',$data['uId']);
	 			$this->db->set('rcv_rss',$data['rcv_rss']);
	 			$this->db->insert('user_rss_message');
		}
		
		//get user's setting of receiving rss or not
		function get_rcv_rss($uId)
		{
				$this->db->select('rcv_rss');
				$this->db->where('uId',$uId);
				$query = $this->db->get('user_rss_message');
				if($query->num_rows() > 0)
				{
						$row = $query->row();
						if($row->rcv_rss)
						{
								return true;
						}
						else
						{
								return false;
						}
				}
				else
				{
						return true;
				}
		}

	 //if user's data record exist in DB ,update user's langCode in table 'user',
	 //otherwise,insert
	 function user_language_save($data)
	 {
	   $uId = $data['uId'];
	   $langCode = $data['langCode'];

       $sql = "UPDATE user SET langCode = '{$langCode}' WHERE uId = {$uId}";
       $query = $this->db->query($sql);
	 }

	 //if user's data record exist in DB ,update user's location data in table 'user_location'
	 //otherwise,insert
	 function user_location_save($data)
	 {
        if($this->user_location_exist($data))
        {
            $this->user_location_update($data);
        }
        else
        {
		    //for new register user
		    $this->Kpc_manage->kpc_update_process(array('uId'=>$data['uId'],'kpc_value'=>KPC_VALUE_SETTING,'kpc_type'=>KPC_TYPE_SETTING));
            $this->user_location_insert($data);
        }
	 }

     //update user's location data
     //table--'user_location'
     function user_location_update($data)
     {
        $uId = $data['uId'];
		$location_data = $data['location'];//array(country_code,'province_code','city_code','town_code');

        $sql = "UPDATE user_location SET country_code = '{$location_data['country_code']}',
                                        province_code = '{$location_data['province_code']}',
                                        city_code = '{$location_data['city_code']}',
                                        town_code = '{$location_data['town_code']}'
                                    WHERE uId = {$uId}";
        $query = $this->db->query($sql);

     }

     //insert user's location data
     //table--'user_location'
     function user_location_insert($data)
     {
		$uId = $data['uId'];
		$location_data = $data['location'];//array(country_code,'province_code','city_code','town_code');

        $sql = "INSERT into user_location(uId,country_code,province_code,city_code,town_code)
                    VALUES ({$uId},'{$location_data['country_code']}','{$location_data['province_code']}',
                                '{$location_data['city_code']}','{$location_data['town_code']}')";
        $query = $this->db->query($sql);

	 }

     function user_location_exist($data)
     {
        $sql = "SELECT * FROM user_location WHERE uId = {$data['uId']}";
        $query = $this->db->query($sql);
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

	 //if user's data record exist in DB ,update user's sub_cate tag in table 'user_tag'
	 //otherwise,insert
	 function user_tag_save($data)
	 {
		$uId = $data['uId'];
		$tag_data = $data['tag'];//array of array('category_id','sub_cate_id');

		//get user's tag sub_cate_id in DB
        $user_tag_old_record = $this->get_user_subcate_record($uId);

		//get sub_cate_id of input
        $user_tag_new_select = $this->generate_user_selectTag_data($tag_data);

		//intersection of record in DB and input
        $inter_subcateid_arr = array_unique(array_intersect($user_tag_new_select,$user_tag_old_record));

		//record to be deleted from DB
        $delete_subcate_arr = array_diff($user_tag_old_record,$inter_subcateid_arr);

		//record to be inserted
        $insert_subcate_arr = array_diff($user_tag_new_select,$inter_subcateid_arr);

	   //delete record in DB
        if($delete_subcate_arr != NULL)
        {
            $this->user_tag_delete($uId,$delete_subcate_arr);
        }
        //insert new record
        if($insert_subcate_arr != NULL)
        {
            $this->user_tag_insert($uId,$insert_subcate_arr,$data['langCode']);
        }
	 }

     //get user's tag sub_cate_id in DB
     function get_user_subcate_record($uId)
     {
        $this->db->select('sub_cate_id');
        $this->db->where('uId',$uId);
        $query = $this->db->get('user_tag');
        $result = array();
        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                array_push($result,$row->sub_cate_id);
            }
        }
        return $result;
		//return array(1,2,3,4,5);
     }

     //get sub_cate_id of input
     //input:array of array('category_id','sub_cate_id');
	  //output: array of array('category_id'=>'sub_cate_id')
     function generate_user_selectTag_data($tag_data)
     {
        $result = array();
        foreach($tag_data as $item)
        {
            $result[$item['category_id'].'_'.$item['sub_cate_id']] = $item['sub_cate_id'];
        }
        return $result;
     }

     //delete record in table user_tag
     //input array of sub_cate_id
     function user_tag_delete($uId,$delete_subcate_arr)
     {
        $this->db->where('uId',$uId);
        $this->db->where_in('sub_cate_id',$delete_subcate_arr);
        $this->db->delete('user_tag');

        //delete tags in table 'user_private_tag'
        $this->User_privatetag_manage->_fun_privatetag_delete($delete_subcate_arr,$uId,'sub_cate_id');
     }

     //insert user's tag data
     //input: user id, array of sub_cate_id, language code
     function user_tag_insert($uId,$insert_subcate_arr,$langCode)
     {
        foreach($insert_subcate_arr as $category_str=>$sub_cate_id)
        {
			  $arr = explode('_', $category_str);
			  $category_id = $arr[0];
			  $sql = "INSERT into user_tag(uId,category_id,sub_cate_id,langCode)
                    VALUES ({$uId},{$category_id},{$sub_cate_id},'{$langCode}')";
            $this->db->query($sql);
        }
     }

	 /***************************Communicate method data*****************************/
	 //process the change of user's communicate method setting
	 //$data = array(array('uId','account','stId','isselected'));
	 function user_method_process($data)
	 {
		foreach($data as $item)
		{
		   if(trim($item['account']))
		   {
		      //print_r($item);
		      $this->user_accountdata_update($item);
		      $this->user_method_update($item);
		   }
		}
	 }

	 //update the account data for user
	 //$item = array('uId','account','stId','isselected')
	 //'table'--useraccount
	 function user_accountdata_update($item)
	 {
		if($this->user_account_exist($item))
		{
		    //update user account if account exists
		    $this->user_account_update($item);
			//echo "exist";
		}
		else
		{
		   //insert user account if account not exists
		   $this->user_account_insert($item);
		   //echo "un-exist";
		}
	 }

     //update existing user account
     //'table'--useraccount
     function user_account_update($item)
     {
		//$sql = "UPDATE useraccount SET account= '{$item['account']}' WHERE uId = {$item['uId']} AND stId = {$item['stId']}";
		//$this->db->query($sql);
        $this->db->where('uId',$item['uId']);
        $this->db->where('stId',$item['stId']);
        $this->db->set('account',$item['account']);
        $this->db->update('useraccount');
     }

     //insert a user account
     //'table'--useraccount
     function user_account_insert($item)
     {
        //$this->db->insert('useraccount',$item);
		//$sql = "INSERT INTO useraccount(uId,account,stId) VALUES({$item['uId']},'{$item['account']}',{$item['stId']})";
		//$this->db->query($sql);
        $this->db->set('uId',$item['uId']);
        $this->db->set('account',$item['account']);
        $this->db->set('stId',$item['stId']);
        $this->db->insert('useraccount');
     }

	 //update the method type for user
	 //$item = array('uId','account','stId','isselected','is_visible');
	 //'table'--sendtype4user
	 function user_method_update($item)
	 {
		if($item['isselected'])
		{
			//update the send type for the user by uId
			if($this->user_sendtype_exist($item['uId']))
			{
			   $this->user_sendtype_update($item);
			}
			else
			{
			   $this->user_sendtype_insert($item);
			}
		}
	 }

	 //check if this user_sendtype has been stored
	 //'table'--sendtype4user
	 function user_sendtype_exist($uId)
	 {
	 		$this->db->select('suId');
	 		$this->db->where('uId',$uId);
	 		$query = $this->db->get('sendtype4user');
	 		if($query->num_rows > 0)
	 		{
	 			//if exists
	 			return TRUE;
	 		}
	 		else
	 		{
	 			return FALSE;
	 		}
	 }

	 //update the send type for the user by uId
	 //'table'--sendtype4user
	 //$item = array('uId','stId','isselected')
	 function user_sendtype_update($item)
	 {
	  	$this->db->where('uId',$item['uId']);
	  	$this->db->set('stId',$item['stId']);
	  	$this->db->update('sendtype4user');
	 }

	 //insert send type for user if it doesn't exist
	 //'table'--sendtype4user
	 //$item = array('uId','stId','isselected')
	 function user_sendtype_insert($item)
	 {
	 		$this->db->set('uId',$item['uId']);
	 		$this->db->set('stId',$item['stId']);
	    $this->db->insert('sendtype4user');
	 }


	 //check if this account has been stored
	 //$item = array('uId','account','stId','isselected');
	 //'table'--useraccount
	 function user_account_exist($item)
	 {
	 		$this->db->select('uaId');
	 		$this->db->where('uId',$item['uId']);
	 		$this->db->where('stId',$item['stId']);
	 		$query = $this->db->get('useraccount');

		   if($query->num_rows > 0)
			{
		  	  //if exits
		  	  return TRUE;
			}
			else
			{
		  	   return FALSE;
			}
	 }


	 /********************************************************************************/
	 //get all province data for a specify country
	 //return array of ('province_code','province_name')
	 function get_province_data($country_code)
	 {
		$this->db->select('province_code,province_name');
		$this->db->where('country_code',$country_code);
		$query = $this->db->get('province_table');
		$data = array();

		if($query->num_rows() > 0)
	    {
            foreach($query->result() as $row)
            {
               array_push($data,array('province_code'=>$row->province_code, 'province_name'=>$row->province_name));
            }
	    }
		return $data;
	 }

	 //get all city data for a specify province of country
	 //input: ('country_code','province_code')
	 //return array of ('city_code','city_name')
	 function get_city_data($code_arr)
	 {
	    $this->db->select('city_code,city_name');
        $this->db->where('country_code',$code_arr['country_code']);
        $this->db->where('province_code',$code_arr['province_code']);
        $query = $this->db->get('city_table');
        $data = array();

        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                array_push($data,array('city_code'=>$row->city_code,'city_name'=>$row->city_name));
            }
        }
        return $data;

	 }

	 //get all town data for a specify town,province of country
	 //input: ('country_code','province_code','city_code')
	 //return array of ('town_code','town_name')
	 function get_town_data($code_arr)
	 {
	    $this->db->select('town_code,town_name');
        $this->db->where('country_code',$code_arr['country_code']);
        $this->db->where('province_code',$code_arr['province_code']);
        $this->db->where('city_code',$code_arr['city_code']);
        $query = $this->db->get('town_table');
        $data = array();

        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                array_push($data,array('country_code'=>$code_arr['country_code'], 'province_code'=>$code_arr['province_code'], 'city_code'=>$code_arr['city_code'], 'town_code'=>$row->town_code,'town_name'=>$row->town_name));
            }
        }
        return $data;

	 }

	 /************************************************************************/
	 //
	 function get_userphoto_path($data)
	 {
		 $sql = "SELECT photo_name FROM user_photo WHERE uId = {$data['uId']} and photo_type = {$data['photo_type']}";
		 $query = $this->db->query($sql);

		 if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
			     return 'upload/user_photo/'.$data['uId'].'/'.$row->photo_name;
			  }
        }
		 else
		 {
		    return $this->get_default_userphoto();
		 }
	 }

	 function get_default_userphoto()
	 {
	    return 'upload/user_photo/default/userphoto.jpg';
	 }

	 function user_subpic_update($item)
     {
        $this->db->where('uId',$item['uId']);
        $this->db->set('subpic',$item['subpic']);
        $this->db->update('user');
     }
	 function user_avatar_update($item)
     {
        $this->db->where('uId',$item['uId']);
        $this->db->set('avatar',$item['avatar']);
        $this->db->update('user');
     }
  }
  /*End of file*/
  /*Location: ./system/appllication/model/q2a/user_profile.php*/
