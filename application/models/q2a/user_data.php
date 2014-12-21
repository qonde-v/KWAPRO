<?php
  class User_data extends CI_Model
  {
	function __construct()
	 {
	    parent::__construct();
		$this->load->model('q2a/Kpc_manage');
        $this->load->model('q2a/User_privatetag_manage');
        $this->load->helper('define');
	 }


	 //get user name by value of specified key
	 //input array('key'=>value)
	 function get_username($data)
	 {
		$this->db->select('username');
        $this->db->where($data);
        $query = $this->db->get('user');

		 if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                return $row->username;
            }
        }
		 else
		 {
		    return '';
		 }
	 }

	 //get user's sending account by user id
	 //return array('account','stId')
	 function get_user_send_account($user_id)
	 {
	   $sql = "SELECT useraccount.account,useraccount.stId FROM useraccount,sendtype4user WHERE sendtype4user.uId = {$user_id} AND sendtype4user.uId = useraccount.uId AND sendtype4user.stId = useraccount.stId";
	   $query = $this->db->query($sql);

	   	if($query->num_rows() > 0)
		{
		     foreach($query->result() as $row)
            {
                return array('account'=>$row->account, 'stId'=>$row->stId);
            }
		}
		return array('account'=>'', 'stId'=>'');
	 }

	 //get user's question number,reply number
	 //array('ntid'=>, 'num'=> )
	 //'table'--useractivity
	 function get_user_content_num($uId="")
	 {
	    $this->db->select('num,ntId');
	    $this->db->where('uId',$uId);
	    $query = $this->db->get('useractivity');
	    $data = array();
	    if($query->num_rows() > 0)
	    {
	    	foreach($query->result() as $row)
	    	{
	    		//array_push($data,array('ntId'=>$row->ntId, 'num'=>$row->num));
				$data[$row->ntId] = $row->num;
	    	}
	    }
	    ksort($data);
		 return $data;

	 }

	 //get user's current kpc
	 function get_user_kpc($uId="")
	 {
	    //todo:
        return $this->Kpc_manage->get_user_kpc_score($uId);
	 }

	 //
	 function get_user_kpclog($uId="")
	 {
	   //todo:

	 }

	 //get user's current login place
	 function get_user_curlocal($uId="")
	 {
	    //todo:

	 }

	 //get user's friends
	 //table--'user_friends'
	 //input: user's id ,range=array('start'=>,'end'=>)
	 //output: array of array('user_id','username','headphoto_path')
	 //you can call function 'get_user_headphotopath' in this model to get user's head photo path
	 function get_user_friends($uId="",$range='')
	 {
		$result = array();
		$f_id_arr = $this->get_user_friend_id_data($uId,$range);
		foreach($f_id_arr as $f_u_id)
		{
	        $item = $this->get_user_info_data($f_u_id);
			array_push($result,array('user_id'=>$f_u_id, 'username'=>$item['username'], 'headphoto_path'=>$item['user_photopath'],'kpc'=>$item['user_score'],'ask_num'=>$item['user_ask_num'],'answer_num'=>$item['user_answer_num'],'location'=>$item['user_place']));
		}
		return $result;
	 }

	 //get username and user's avatar path
	 //input: user id
	 //output: array('username','headphoto_path')
	 function get_user_basic_data($user_id)
	 {
	      $username= $this->get_username(array('uId'=>$user_id));
	      $headphoto_path = $this->get_user_headphotopath($user_id);
		  return array('username'=>$username, 'headphoto_path'=>$headphoto_path);
	 }

     //get user's number of friends
     //input: user id
     function get_user_friend_num($uId)
     {
         $this->db->select('friend_uId');
         $this->db->where('uId',$uId);
         $query = $this->db->get('user_friends');
         return $query->num_rows();
     }


     //get user's friend id
	 //input: user id,range=array('start'=>,'end'=>)
	 //output: array of user's friend id
	 function get_user_friend_id_data($uId,$range='')
	 {
	     $this->db->select('friend_uId');
         $this->db->where('uId',$uId);
         if($range!='')
         {
            $this->db->limit($range['end']-$range['start']+1,$range['start']);
         }
         $query = $this->db->get('user_friends');
         $result = array();

		 if($query->num_rows() > 0)
         {
            foreach($query->result() as $row)
            {
                array_push($result,$row->friend_uId);
            }
         }
         return $result;
	 }

    //get user friends' simple profile
	//input: user id,range=array('start'=>,'end'=>)
	//output: array of ('user_id','username','headphoto_path','tag_data','content_data')
	function get_user_friend_browse_data($user_id,$range='')
	{
	    $result = array();
	    $f_id_data = $this->get_user_friend_id_data($user_id,$range);
		foreach($f_id_data as $f_id)
		{
		      $content_data = $this->get_user_content_num($f_id);
			  $tag_data = $this->get_user_private_tag_data($f_id);
              $kpc_score = $this->get_user_kpc($f_id);
			  $user_basic_info = $this->get_user_basic_data($f_id);
              $location = $this->get_user_location($f_id);
			  $item = array('user_id'=>$f_id ,'location'=>$location['town_name'],'kpc'=>$kpc_score,'tag_data'=>$tag_data,'content_data'=>$content_data, 'username'=>$user_basic_info['username'], 'headphoto_path'=>$user_basic_info['headphoto_path']);
			  array_push($result,$item);
		}
		return $result;
	}


	 //get user's language code
	 //return: user's langCode value
	 function get_user_langcode($uId)
	 {
	    //
        $this->db->select('langCode');
        $this->db->where('uId',$uId);
        $query = $this->db->get('user');
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            return $row->langCode;
        }
        else
        {
            return NULL;
        }
	 }


	 //get user's private tags
	 //'table'--user_tag,sub_category
	 //return: array of array('category_id', 'sub_cate_id','sub_cate_name')
	 function get_user_tags($uId, $subcate_table='sub_category', $lang_code='zh')
	 {
	    //todo:
        /*$this->db->select('user_tag.category_id,user_tag.sub_cate_id');
        $this->db->select("{$subcate_table}.sub_cate_name");
        $this->db->where('uId',$uId);
        $this->db->join("{$subcate_table}","user_tag.sub_cate_id = {$subcate_table}.sub_cate_id");
        $query = $this->db->get('user_tag');*/

		//sql query directly
		$sql = "SELECT user_tag.category_id,user_tag.sub_cate_id,{$subcate_table}.sub_cate_name FROM user_tag,{$subcate_table} WHERE user_tag.uId = {$uId} AND user_tag.sub_cate_id = {$subcate_table}.sub_cate_id AND {$subcate_table}.langCode = '{$lang_code}'";
		$query = $this->db->query($sql);

		$result = array();
        if($query->num_rows() > 0)
        {
             foreach($query->result() as $row)
             {
                array_push($result,array('category_id'=>$row->category_id,'sub_cate_id'=>$row->sub_cate_id,'sub_cate_name'=>$row->sub_cate_name));
             }
        }
        return $result;
	 }

	 //get user's location id information about:
	 //input: user id
	 //output: array('country_code', 'province_code', 'city_code', 'town_code')
     function get_user_location_id_info($user_id)
	 {
	    $this->db->select('country_code,province_code,city_code,town_code');
		$this->db->where('uId',$user_id);
		$query = $this->db->get('user_location');

		$data = array('country_code'=>'', 'province_code'=>'', 'city_code'=>'', 'town_code'=>'');

		if($query->num_rows() > 0)
        {
		   $data = $query->row_array();
        }
		return $data;
	 }


	 //get user's local tags
	 //'table'--user_location,town_table
	 //return: array('country_code', 'province_code', 'city_code', 'town_code','town_name')
	 function get_user_location($user_id)
	 {
	    //todo:
        $location_data = $this->get_location_town_level_data($user_id);
		if(!$location_data['town_code'])
		{
		   $location_data = $this->get_location_city_level_data($user_id);
		   if(!$location_data['city_code'])
		   {
		     $location_data = $this->get_location_province_level_data($user_id);
		   }
		}
		return $location_data;
	 }

	 //get user's twon level location tags
	 //'table'--user_location,town_table
	 //return: array('country_code', 'province_code', 'city_code', 'town_code','town_name')
	 function get_location_town_level_data($user_id)
	 {
	    $this->db->select('user_location.country_code,user_location.province_code,user_location.city_code');
        $this->db->select('user_location.town_code,town_table.town_name');
        $this->db->join('town_table','user_location.town_code=town_table.town_code');
        $this->db->where('uId',$user_id);
        $query= $this->db->get('user_location');
        $result = array();
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            return array('country_code'=>$row->country_code,'province_code'=>$row->province_code,'city_code'=>$row->city_code,
                            'town_code'=>$row->town_code,'town_name'=>$row->town_name);
        }
        else
		 {
		    return array('country_code'=>'','province_code'=>'','city_code'=>'',
                            'town_code'=>'','town_name'=>'');
		 }
	 }

     //get user's city level location tags
	 //'table'--user_location,city_table
	 //return: array('country_code', 'province_code', 'city_code', 'town_code','town_name')
	 function get_location_city_level_data($user_id)
	 {
	    $this->db->select('user_location.country_code,user_location.province_code,user_location.city_code');
        $this->db->select('user_location.town_code,city_table.city_name');
        $this->db->join('city_table','user_location.city_code=city_table.city_code');
        $this->db->where('uId',$user_id);
        $query= $this->db->get('user_location');
        $result = array();
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            return array('country_code'=>$row->country_code,'province_code'=>$row->province_code,'city_code'=>$row->city_code,
                            'town_code'=>$row->town_code,'town_name'=>$row->city_name);
        }
        else
		 {
		    return array('country_code'=>'','province_code'=>'','city_code'=>'',
                            'town_code'=>'','town_name'=>'');
		 }
	 }

	 //get user's province level location tags
	 //'table'--user_location,province_table
	 //return: array('country_code', 'province_code', 'city_code', 'town_code','town_name')
	 function get_location_province_level_data($user_id)
	 {
	    $this->db->select('user_location.country_code,user_location.province_code,user_location.city_code');
        $this->db->select('user_location.town_code,province_table.province_name');
        $this->db->join('province_table','user_location.province_code=province_table.province_code');
        $this->db->where('uId',$user_id);
        $query= $this->db->get('user_location');
        $result = array();
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            return array('country_code'=>$row->country_code,'province_code'=>$row->province_code,'city_code'=>$row->city_code,
                            'town_code'=>$row->town_code,'town_name'=>$row->province_name);
        }
        else
		 {
		    return array('country_code'=>'','province_code'=>'','city_code'=>'',
                            'town_code'=>'','town_name'=>'');
		 }
	 }

	  //get user's activity and the corresponding score
	 function get_kpc_info()
	 {
	    //todo:

	 }

	 //get user's currently login place
	 function get_login_place()
	 {
	    //todo:
	 }

	 //generate user's photo path
	 function get_user_headphotopath($user_id)
	 {
	    $base_photo_path = $this->config->item('base_photoupload_path');
	    if($user_id)
		{
			$photo_name = $this->get_user_photo_name($user_id);

			 if(empty($photo_name))
			{
				return $base_photo_path.'default/head.png';
			 }
			 return 'img/'.$photo_name;//$base_photo_path.$user_id.'/'.$photo_name;
        }
		else
		{
		   return $base_photo_path.'default/head.png';
		}
	 }

	 //get user's photo name from database
	 function get_user_photo_name($user_id)
	 {
	    //todo:
		//$sql = "SELECT photo_name FROM user_photo WHERE uId={$user_id} AND photo_type = 1";
		$sql = "SELECT avatar FROM user WHERE uId={$user_id}";
		$query = $this->db->query($sql);

	   	if($query->num_rows() > 0)
		{
		   $row = $query->row();
		   return $row->avatar;//photo_name;
		}
		return '';
	 }

	 //get user's inforamtion data
	 //input: user id
	 //output: array('username','user_photopath','user_score','user_ask_num','user_answer_num','user_place')
	 function get_user_info_data($user_id)
	 {
	    //todo:
		$username = $this->get_username(array('uId'=>$user_id));
		$user_photopath = $this->get_user_headphotopath($user_id);
		$user_score = $this->get_user_kpc($user_id);
		$data = $this->get_user_activity_num($user_id);
		$user_ask_num = $data['question'];
		$user_answer_num = $data['answer'];
		$user_place = $this->get_user_location($user_id);

		return array('username'=>$username,'user_photopath'=>$user_photopath,'user_score'=>$user_score, 'user_ask_num'=>$user_ask_num, 'user_answer_num'=>$user_answer_num, 'user_place'=>$user_place['town_name']);
	 }

     //get a user's private tag data
     function get_user_private_tag_data($uId)
     {
        return $this->User_privatetag_manage->get_user_private_tag($uId);
     }
	 
	 //get uId by username
	 //table--'user'
	 function get_uId_by_username($username)
	 {
	 	$this->db->select('uId');
		$this->db->where('username',$username);
		$query = $this->db->get('user');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			return $row->uId;
		}
		else
		{
			return '';
		}
	 }
	 
	 //get user's permission to invite friends
	 //table--'user'
	 function get_invite_permission($uId)
	 {
	 	$this->db->select('permission');
		$this->db->where('uId',$uId);
		$query = $this->db->get('user');
		$row = $query->row();
		return $row->permission;
	 }
	 
	 //get user's activity num
	 //input:user id
	 //output: array('question','answer','comment','follow')
	 //table--'useractivity'
	 function get_user_activity_num($uId)
	 {
	 	$this->db->select('ntId,num');
		$this->db->where('uId',$uId);
		$query = $this->db->get('useractivity');
		$result = array();
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{
				switch($row->ntId)
				{
					case QUESTION: $result['question'] = $row->num;break;
					case ANSWER: $result['answer'] = $row->num;break;
					case COMMENT: $result['comment'] = $row->num;break;
					case FOLLOW: $result['follow'] = $row->num;break;
				}
			}
		}
		$keys = array('question','answer','comment','follow');
		foreach($keys as $key)
		{
			if(!isset($result[$key]))
			{
				$result[$key] = 0;
			}
		}
		return $result;
	 }

	 //get user's gender
	 //return: user's gender
	 function get_user_gender($uId)
	 {
	    //
        $this->db->select('gender');
        $this->db->where('uId',$uId);
        $query = $this->db->get('user');
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            return $row->gender;
        }
        else
        {
            return NULL;
        }
	 }

	 function get_user_subpic($uId)
	 {
	    //
        $this->db->select('subpic');
        $this->db->where('uId',$uId);
        $query = $this->db->get('user');
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            return $row->subpic;
        }
        else
        {
            return NULL;
        }
	 }

	 function get_user_tag($uId)
	 {
	    //
        $this->db->select('tag');
        $this->db->where('uId',$uId);
        $query = $this->db->get('user');
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            return $row->tag;
        }
        else
        {
            return NULL;
        }
	 }
	 
     function get_user_ifcollect($uId)
	 {
	    //
        $this->db->select('ifcollect');
        $this->db->where('uId',$uId);
        $query = $this->db->get('user');
        if($query->num_rows() > 0)
        {
            $row = $query->row();
            return $row->ifcollect;
        }
        else
        {
            return NULL;
        }
	 }

  }







  /*End of file*/
  /*Location: ./system/appllication/model/user_data.php*/