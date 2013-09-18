<?php
  class Friend_finder extends CI_Model
  {
     function __construct()
	 {
	    parent::__construct();
        $this->load->helper('define');
		$this->load->model('q2a/User_data');
		$this->load->model('q2a/Friend_invite');
	 }

	 //find friends by topic,include(category and sub category)
	 //input: array('topic_type','topic_id')
	 //output: array of (uId,username,headphoto_path)
	 function find_friend_in_topic($data)
	 {
	    $user_id_data = array();
	    $topic_type = $data['topic_type'];
		$topic_id = $data['topic_id'];

		switch($topic_type)
		{
		  case SEARCH_BY_CATEGORY:
		     $user_id_data = $this->find_friend_by_category($topic_id);
		     break;
		  case SEARCH_BY_SUB_CATE:
		     $user_id_data = $this->find_friend_by_subcategory($topic_id);
		     break;
		  default:
		     $user_id_data = $this->find_friend_by_category($topic_id);
		     break;
		}
		//print_r($user_id_data);
		return $this->friend_get_user_data($user_id_data);
	 }


	 //get friend inviting requests for a user not including the out-date requests
	 //requests for that user earlier than $data['time'] will be deleted
	 //input: array('uId'=>,'time'=>array('day'=>,'hour'=>,'minute'=>,'second'=>))
	 //output: 	 //output: array of (uId,username,headphoto_path)
	 function get_invite_request_userdata($user_id)
	 {
	 	$data = array('uId'=>$user_id,'time'=>array('day'=>15,'hour'=>0,'minute'=>0,'second'=>0));
	 	$user_id_arr = $this->Friend_invite->get_invite_request($data);
	 	$user_data = $this->friend_get_user_data($user_id_arr);
	 	//print_r($user_data);
	 	return $user_data;
	 }


	 //get user information data in 'friend' page
	 //input: array of user id
	 //output: array of (uId,username,headphoto_path)
	 function friend_get_user_data($user_id_data)
	 {
	    $data = array();
	    for($i=0; $i<count($user_id_data); $i++)
		{
		   $username = $this->User_data->get_username(array('uId'=>$user_id_data[$i]));
		   $headphoto_path = $this->User_data->get_user_headphotopath($user_id_data[$i]);
		   $tags = array_slice($this->User_data->get_user_private_tag_data($user_id_data[$i]),0,5); 
		   $html = "<div class='q_tags'>";
		   foreach($tags as $tag)
		   {
		   		$html .= "<a class='label'>".$tag['tag_name']."</a>";
		   }
		   $html .= "</div>";
		   array_push($data, array($user_id_data[$i],$username,$headphoto_path,$html));
		}
		return $data;
	 }

	 //find friends by category
	 //input: category id
	 //output: array of user id
     //table--'user_tag'
	 function find_friend_by_category($category_id)
	 {
	    //todo:
        $this->db->select('uId');
        $this->db->where('category_id',$category_id);
        $query = $this->db->get('user_tag');
        $result = array();

        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                array_push($result,$row->uId);
            }
        }

        return array_values(array_unique($result));
	 }

	 //get user data by location condition
	 //input: array(key=>value) (such as array('country_code'=>'zh','province_code'=>'...') or array('country_code'=>'zh'))
	 //output: array of (uId,username,headphoto_path)
	 function find_friend_in_location($data)
	 {
	    $user_id_data = $this->find_friend_by_region($data);
		return $this->friend_get_user_data($user_id_data);
	 }


	 //find friends by region
	 //input: array(key=>value) (such as array('country_code'=>'zh','province_code'=>'...') or array('country_code'=>'zh'))
	 //output: array of user id
     //table--'user_location'
	 function find_friend_by_region($data)
	 {
	     $this->db->select('uId');
         $this->db->where($data);
         $query = $this->db->get('user_location');
         $result = array();

         if($query->num_rows() > 0)
         {
            foreach($query->result() as $row)
            {
                array_push($result,$row->uId);
            }
         }

         return $result;
	 }

	 //find friends by sub category
	 //input: sub category id
	 //output: array of user id
	 function find_friend_by_subcategory($sub_cate_id)
	 {
	   $this->db->select('uId');
        $this->db->where('sub_cate_id',$sub_cate_id);
        $query = $this->db->get('user_tag');
        $result = array();

        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                array_push($result,$row->uId);
            }
        }

        return $result;
	 }

	 //get top n user by score in table 'user_score'
	 //input array('top_num'=>)
	 //output: array of user id
	 function find_friend_by_score($data)
	 {
	    //todo:
        $sql = "select uId from (select * from user_score order by score desc)a limit {$data['top_num']}";
        $query = $this->db->query($sql);
        $result = array();

        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                array_push($result,$row->uId);
            }
        }

        return $result;
	 }


	 //get top n user by their answered number
	 //'table'--useractivity,
	 //input array('top_num'=>)
	 //output: array of user id
	 function find_friend_by_answernum($data)
	 {
	    //todo:
        $sql = "select uId from (select * from useractivity where ntId = ".ANSWER." order by num desc)a limit {$data['top_num']}";
        $query = $this->db->query($sql);
        $result = array();

        if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                array_push($result,$row->uId);
            }
        }

        return $result;
	 }

	 //recommand friend for user by their private tags
	 //and region information
	 //input: user id
	 //output: array('user_by_tag'=> array of user id,'user_by_region'=>array of user id)
	 function recommand_freind4user($user_id)
	 {
	     //todo:
	 }

  }//END OF CLASS
