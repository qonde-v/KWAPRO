<?php
  class Message_manage extends CI_Model
  {
     function __construct()
	 {
	    parent::__construct();
		$this->load->helper('define');
		$this->load->library('session');
		$this->load->model('q2a/Rss_manage');
		$this->load->model('q2a/Question_data');
		$this->load->model('q2a/Content_process');
		$this->load->model('q2a/User_data');
		$this->load->model('q2a/Ip_location');
		$this->load->library('language_translate');
	 }

	 //delete message item by message id
	 //input: array of message id;
	 function message_delete($data)
	 {
	    if(!empty($data))
		{
		   /*$id_arrange_str = '('.implode(',',$data).')';
		   $sql = "DELETE FROM message_inbox WHERE message_id in {$id_arrange_str}";
		   $this->db->query($sql);*/

		   $this->db->where_in('message_id',$data);
		   $this->db->delete('message_inbox');
		}
	 }

	 //update the stat of the message(s) in the array
	 //input:array('stat'=>,'message_id'=>array of message id)
	 function message_stat_update($stat,$msg_id_arr)
	 {
		$update_data = array('key'=>'is_read','value'=>$stat);
		$this->_message_column_update($update_data,$msg_id_arr);

	 }

     //update the last activity time for the specified message
	 function message_time_update($time, $msg_id_arr)
	 {
		$update_data = array('key'=>'time','value'=>$time);
		$this->_message_column_update($update_data,$msg_id_arr);
	 }


	 //update the column 'last_data_id' in message_inbox
	 //input: new value of 'laset_data_id', array of message id
	 function message_last_replydata_id_update($last_data_id,$msg_id_arr)
	 {
		$update_data = array('key'=>'last_data_id','value'=>$last_data_id);
		$this->_message_column_update($update_data,$msg_id_arr);
	 }

     //update the column value of the specified column where message id
     //in the message id array
     //input: @update_data -- array('key','value'),@msg_id_arr -- message id array
     function _message_column_update($update_data,$msg_id_arr)
     {
     	if(!empty($msg_id_arr))
		{
           $this->db->where_in('message_id',$msg_id_arr);
           $this->db->set($update_data['key'],$update_data['value']);
           $this->db->update('message_inbox');
		}
     }


	 //process the insert event of message
	 //input: array('from_user_id','message_content','subject','sendType','message_type','to_user_id')
	 function message_insert($data)
	 {
	    $data_node_id = $this->message_source_data_insert($data);
		//echo $data_node_id;
		//generate relation data to insert into message inbox
		$relation_data = array('data_id'=>$data_node_id, 'is_read'=>UN_READ,'last_data_id'=>$data_node_id);
		$relation_data = array_merge($data,$relation_data);
		$relation_data['time'] = date("Y-m-d H:i:s", time());

	    unset($relation_data['message_content']);
		unset($relation_data['sendType']);

		//print_r($relation_data);
		$this->message_inbox_insert($relation_data);
		return $data_node_id;
	 }

	 //
	 function message_source_data_insert($data)
	 {
	    $time = date("Y-m-d H:i:s", time());
		$text = $data['message_content'];
		$send_place = $this->session->userdata('location_city');
		$lang_code = $this->language_translate->check($text);

	    $node_data = array('ntId'=>MESSAGE, 'time'=>$time, 'text'=>$text, 'stId'=>$data['sendType'], 'sendPlace'=>$send_place, 'langCode'=>$lang_code, 'uId'=>$data['from_user_id']);
		$node_id = $this->Content_process->content_insert($node_data);

		return $node_id;
	 }

	 //insert message data into message_inbox table
	 //input: data with the table structure
	 function message_inbox_insert($data)
	 {
	     $this->db->insert('message_inbox',$data);
		 return $this->db->insert_id();
	 }

	 //load message data for user
	 //input: $user_id,$range=array('start'=>,'end'=>)
	 //output:
	 function message_data_load($user_id,$range)
	 {
	    //
		$id_data = $this->message_id_info_load(array('column'=>'to_user_id','value'=>$user_id),$range);
		return $this->last_update_message_load($id_data);
	 }

     //load message data that user sent
	 //input: array('user_id')
	 //output:
	 function out_message_data_load($user_id,$range)
	 {
	    //
		$id_data = $this->message_id_info_load(array('column'=>'from_user_id','value'=>$user_id),$range);
		return $this->last_update_message_load($id_data);
	 }

	 //load (message_type,data_id) data for current login user
	 //input: $data=('column','value'),$range=array('start'=>,'end'=>)
	 //output: array of (message_type,data_id,message_id,last_data_id)
	 function message_id_info_load($data,$range=array())
	 {
         $this->db->select('message_id,message_type,subject,last_data_id,data_id,is_read');
         $this->db->where($data['column'],$data['value']);
         $this->db->order_by("time","desc");

         if(!empty($range))
         {
            $this->db->limit($range['end']-$range['start']+1,$range['start']);
         }

         $query = $this->db->get('message_inbox');

		 $data = array();
		 if($query->num_rows() > 0)
	     {
            foreach($query->result() as $row)
            {
			    array_push($data,array('last_data_id'=>$row->last_data_id, 'message_id'=>$row->message_id, 'message_type'=>$row->message_type,'subject'=>$row->subject,'data_id'=>$row->data_id,'is_read'=>$row->is_read));
            }
	    }
	    return $data;
	 }

	 //load the last reply message to display in message inbox
	 //include system message and user message
	 //input: array of (message_type,data_id,message_id,subject)
	 //output: array of ('message_type'=>array of message data )
	 function last_update_message_load($data)
	 {
	    return $this->_get_message_by_data_id($data,"last_data_id");
	 }



	 //load all content data of message from different type of message
	 //include system message and user message
	 //input: array of (message_type,data_id,message_id)
	 //output: array of ('message_type'=>array of message data )
	 function message_content_load($data)
	 {
	    return $this->_get_message_by_data_id($data);
	 }

	 //get the message data by different data id in message inbox
	 //input : array of (message_type,data_id,message_id), column name to spefic the  type of data id
	 //output: array of ('message_type'=>array of message data )
	 function _get_message_by_data_id($data,$column="data_id")
	 {
	    $message_data = array();
	    foreach($data as $item)
		{
		   $data_source = array();
		   switch($item['message_type'])
		   {
		      case USER_MESSAGE:
				 $data_source = $this->message_user_message_load($item[$column]);
			     break;
			  case SYSTEM_MESSAGE:
			     $data_source = $this->message_system_message_load($item[$column]);
				 break;
			  default:
			     break;
		   }

		   if($data_source)
		   {
		     $message_data[$item['message_id']] = array_merge($data_source,$item);
		     if(!empty($message_data[$item['message_id']]['subject']))
		     {
		     	$message_data[$item['message_id']]['message_title'] = $message_data[$item['message_id']]['subject'];
		     }
		   }
		}
		return $message_data;
	 }


	 //get data from table 'node' by node_id
	 //input:  node id
	 //output: array of node data
	 function message_user_message_load($node_id)
	 {
		/*$sql = "SELECT node.*, user.username FROM node,user WHERE node.uId=user.uId AND node.nId = {$node_id}";
		$query = $this->db->query($sql);*/

        $this->db->select('node.*,user.username');
        $this->db->where('node.nId',$node_id);
        $this->db->join('user','node.uId=user.uId');
        $query = $this->db->get('node');

		if($query->num_rows() > 0)
		{
		   $data = $query->row_array();
		   $data['message_content'] = $data['text'];
		   $data['message_title'] = 'From '.$data['username'];
		   $data['sendType'] = $this->Question_data->sendtype_map($data['stId']);

		   return $data;
		}
		return array();
	 }

	 //get data from table 'article' by article_id
	 //input: article id
	 //output:
	 function message_system_message_load($artical_id)
	 {
	    //todo:
		$data = $this->Rss_manage->rss_data_load($artical_id);
		$data['nId'] = $data['artical_id'];
		$data['username'] = 'System';
		$data['time'] = $data['pubDate'];
		$data['message_content'] = $data['description'];
		$data['message_title'] = $data['title'];
		$data['sendType'] = 'Online';
		$data['sendPlace'] = 'kwapro';

		return $data;
	 }

	 //check if the user has the permission to access the message
	 //input:array('user_id','message_id')
	 //return true if it is, otherwise return false
	 function message_visible_check($data)
	 {
	    /*$sql = "SELECT message_id FROM message_inbox WHERE message_id  = {$data['message_id']} AND to_user_id = {$data['user_id']}";
		$query = $this->db->query($sql);*/

        $this->db->select('message_id');
        $this->db->where('message_id',$data['message_id']);
        $this->db->where('to_user_id',$data['user_id']);
        $this->db->or_where('from_user_id',$data['user_id']);
        $query = $this->db->get('message_inbox');

		if($query->num_rows() > 0)
		{
		   return TRUE;
		}
		else
		{
		   return FALSE;
		}
	 }

	  //read message item
	 //input: message_id,stat--determine if message stat change, 1--change,0--unchange
	 //output: array of message data
	 function message_read($message_id,$stat=1)
	 {
	     if($stat == 1)
		 {
		   $this->message_stat_update(READ,array($message_id));
		 }

	     $message_item_data = array();
		 $message_info = $this->message_id_info_load(array('column'=>'message_id','value'=>$message_id));

		 if($message_info)
		 {
			 $message_data = $this->message_content_load($message_info);
			 if($message_data)
			 {
				 if($message_item_first = $message_data[$message_id])
				 {
				    array_push($message_item_data,$message_item_first);
				    //print_r($message_item_first);
					$message_item_second = $this->load_message_item_data($message_info[0]);
					if($message_item_second)
					{
					  foreach($message_item_second as $message_reply_item)
					  {
					     array_push($message_item_data,$message_reply_item);
					  }
					  //print_r($message_item_data);
					}
				 }
			 }
         }//if

		 return $message_item_data;
	 }

	 //input: array('message_type','data_id')
	 function load_message_item_data($data)
	 {
	    $data_source = array();
	    switch($data['message_type'])
	    {
		  case USER_MESSAGE:
			 $this->recursive_load_user_message_data($data['data_id'],$data_source);
			 break;
		  case SYSTEM_MESSAGE:
			 break;
		  default:
			 break;
	    }
		return $data_source;
	 }


	 //
	 function recursive_load_user_message_data($node_id, & $message_data)
	 {
	    $reply_node_id = $this->get_message_reply_id($node_id);
		//echo "$reply_node_id reply to====> $node_id";
		if($reply_node_id)
		{
		   $data = $this->message_user_message_load($reply_node_id);
		   //print_r($data);
		   if($data)
		   {
		      array_push($message_data,$data);
		      $this->recursive_load_user_message_data($data['nId'], $message_data);
		   }
		}
		return $message_data;
	 }

	 //get reply id of a given message data id
	 //input node id of message data
	 //output: node id of reply data
	 function get_message_reply_id($node_id)
	 {
	    /*$sql = "SELECT nFromId FROM node_relation WHERE nToId = {$node_id}";
		$query = $this->db->query($sql);*/

        $this->db->select('nFromId');
        $this->db->where('nToId',$node_id);
        $query = $this->db->get('node_relation');

		if($query->num_rows() > 0)
		{
            foreach($query->result() as $row)
            {
			    return $row->nFromId;
            }
	    }
		return 0;
	 }

	 //process of message reply
	 //input: array('node_id','reply_text','sendType','user_id','message_id')
	 function message_reply_process($data)
	 {
	    $node_id = $this->message_replydata_save($data);

		if($node_id)
		{
		   $data['last_data_id'] =  $node_id ;
		   $data['time'] = date("Y-m-d H:i:s", time());
		   $this->message_reply_inbox_process($data);
		   return TRUE;
		}
		else
		{
		   return FALSE;
		}
	 }

	 //process updating information data in message inbox
	 //input: array('time','node_id','reply_text','sendType','user_id','message_id')
	 function message_reply_inbox_process($data)
	 {
	    $orignal_data = $this->message_get_orignal_message_info($data['message_id']);
		if($orignal_data)
		{
		    //print_r($orignal_data);
			$update_data = array('time'=>$data['time'],'last_data_id'=>$data['last_data_id'],'is_read'=>UN_READ,'subject'=>$orignal_data['subject'], 'message_type'=>$orignal_data['message_type'],'data_id'=>$orignal_data['data_id'],'from_user_id'=>$orignal_data['to_user_id'],'to_user_id'=>$orignal_data['from_user_id']);
			$this->message_inbox_reply_update($update_data);
			//print_r($update_data);
		}
	 }

	 //input: array(time,subject,last_data_id,is_read,message_type,data_id,from_user_id,to_user_id);
	 function message_inbox_reply_update($data)
	 {
	    $message_id = $this->_get_message_id(array('data_id'=>$data['data_id'],'from_user_id'=>$data['from_user_id'],'to_user_id'=>$data['to_user_id']));
	    if(!$message_id)
		{
		  $this->message_inbox_insert($data);
		}
		else
		{
		  //echo "UPDATE STAT OF $message_id TO BE ".UN_READ;
		   $this->message_stat_update(UN_READ,array($message_id));
		   $this->message_last_replydata_id_update($data['last_data_id'],array($message_id));
		   $this->message_time_update($data['time'],array($message_id));
		}
	 }


	 //
	 function _get_message_id($data)
	 {
	    //print_r($data);
        $this->db->select('message_id');
        $this->db->where($data);
        $query = $this->db->get('message_inbox');

		if($query->num_rows() > 0)
		{
		    foreach($query->result() as $row)
			{
			   return $row->message_id;
			}
		}
		return 0;
	 }

	 //get the information of the first message
	 //input: message id
	 //ouput: data structure of message_inbox
	 function message_get_orignal_message_info($message_id)
	 {
	    //$sql = "SELECT * FROM message_inbox WHERE message_id = {$message_id}";
	    //$query = $this->db->query($sql);

        $this->db->where('message_id',$message_id);
        $query = $this->db->get('message_inbox');

		if($query->num_rows() > 0)
		{
			return $query->row_array();
	    }
		return array();
	 }

	 //process of message reply
	 //input: array('node_id','reply_text','sendType','user_id')
	 function message_replydata_save($data)
	 {
	    //print_r($data);
		$time = date("Y-m-d H:i:s", time());
		$text = $data['reply_text'];
		$send_place = $this->session->userdata('location_city');
		$lang_code = $this->language_translate->check($text);

	    $node_data = array('to_nId'=>$data['node_id'], 'ntId'=>MESSAGE_REPLY, 'time'=>$time, 'text'=>$text, 'stId'=>$data['sendType'], 'sendPlace'=>$send_place, 'langCode'=>$lang_code, 'uId'=>$data['user_id']);
		$node_id = $this->Content_process->content_insert($node_data);
		return $node_id;
	 }

	  //search
	  //input: array('keyword','user_id')
	  function message_search($data)
	  {
	     $search_data = array();
		 $keyword = $data['keyword'];
	     $id_data = $this->message_id_info_load(array('column'=>'to_user_id','value'=>$data['user_id']));
		 if(count($id_data))
		 {
			 foreach($id_data as $message_info)
			 {
			    $message_id = $message_info['message_id'];
				$message_data_item = $this->message_read($message_id);

				if($this->match_in_message_dialog($message_data_item,$keyword))
				{
				   array_push($search_data,$message_data_item[0]);
				}
			 }
		 }
		 return $search_data;
	  }

	  //match the search word in message dialog
	  //input: message dialog data,keyword
	  //return true if matched, otherwise return false
	  function match_in_message_dialog($message_data_item,$keyword)
	  {
	     if(count($message_data_item))
		 {
		    foreach($message_data_item as $data)
			{
			  $index = strpos(strtolower($data['message_content']),$keyword);
			  //echo $data['message_content']."---".$keyword."--->".$index."----<br/>";
		      if( $index > -1)
			  {
			     return TRUE;
			  }
			}
		 }
		 return FALSE;
	  }

	  //get the user id who the message send to by the message node id
	  //input:  node id
	  //output: array of user id
	  function _message_sent2user_id($node_id)
	  {
			$this->db->select('to_user_id');
			$this->db->where('data_id', $node_id);
			$query = $this->db->get('message_inbox');
			$data = array();

			if($query->num_rows() > 0)
			{
				foreach($query->result() as $row)
				{
				    array_push($data,$row->to_user_id);
				}
			}
			return $data;
	  }

	  /**************MESSAGE NUMBER COUNT*****************/
	  //get inbox message number specified user id
	  function get_inbox_msg_num($user_id)
	  {
	  	return $this->_fun_get_box_msg_num($user_id,'to_user_id');
	  }

	  //get outbox message number specified user id
	  function get_outbox_msg_num($user_id)
	  {
	    return $this->_fun_get_box_msg_num($user_id,'from_user_id');
	  }

	  //
	  function _fun_get_box_msg_num($user_id,$column)
	  {
	  	$this->db->where($column, $user_id);
        $this->db->from('message_inbox');
        return $this->db->count_all_results();
	  }

      //get a user's unread message number
      function get_unread_msg_num($user_id)
      {
        $this->db->select('message_id');
        $this->db->where('to_user_id',$user_id);
        $this->db->where('is_read',UN_READ);
        $query = $this->db->get('message_inbox');
        return $query->num_rows();
      }

	//generate invite answer messages to friends
	//input: array('f_uId_str','nId','uId','q_text')
	function invite_answer_message($data)
	{
		$uId_arr = array_unique(explode(',',$data['f_uId_str']));
		$username = $this->User_data->get_username(array('uId'=>$data['uId']));
		
		$send_data = array('uId'=>$data['uId'],'username'=>$username,'f_uId_arr'=>$uId_arr,'nId'=>$data['nId'],'q_text'=>$data['q_text']);
		$this->invite_answer_message_send($send_data);
	}
	
	//send invite answer messages to friends
	//input:array('uId','username','f_uId_arr','nId','q_text')
	function invite_answer_message_send($data)
	{
		$message_data = $this->invite_answer_message_data();
		$base = $this->config->item('base_url');
		$q_link = $base.'question/'.$data['nId'];
		foreach($data['f_uId_arr'] as $f_uId)
		{
			$send_data = array('subject'=>$message_data['subject']);
			$f_username = $this->User_data->get_username(array('uId'=>$f_uId));
			$send_data['message_content'] = sprintf($message_data['content'],$f_username,$data['username'],$q_link,$data['q_text']);
			$send_data['from_user_id'] = 0;// system admin
			$send_data['to_user_id'] = $f_uId;
			$send_data['sendType'] = ONLINE;
			$send_data['message_type'] = USER_MESSAGE;
			$this->message_insert($send_data);
		}
	}
	
	//get message format for inviting answer
	function invite_answer_message_data()
	{
		$lang = $this->Ip_location->get_language();
		$this->lang->load('messages',$lang);
		$subject = $this->lang->line('invite_answer_msg_subject');
		$content = $this->lang->line('invite_answer_msg_content');
		return array('subject'=>$subject,'content'=>$content);
	}

  }//END OF CLASS 'Message_manage'

















