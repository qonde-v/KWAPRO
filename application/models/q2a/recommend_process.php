<?php

    class Recommend_process extends CI_Model
    {
        function __construct()
        {
            parent::__construct();
            //$this->load->model('q2a/Question_process');
            $this->load->model('q2a/User_data');
            $this->load->model('q2a/Search');
            $this->load->helper('define');

            //date_default_timezone_set ('Asia/Shanghai');
	    }


        //get recommended tags for user not including the out-date recommended tags
        //input:$data=array('uId'=>,'time'=>array('day'=>,'hour'=>,'minute'=>,'second'=>))
        //output: array of tag id
        //table--'recommend_tag'
        function get_recommend_tag($data)
        {
            $now = time();

		    $time = $data['time'];
		    //compute the number of seconds
		    $diff_time = (($time['day']*24 + $time['hour']) * 60 + $time['minute']) * 60 + $time['second'];

            $this->db->select('tag_id,UNIX_TIMESTAMP(time)');
            $this->db->where('uId',$data['uId']);
            $query = $this->db->get('recommend_tag');

            $result = array();
            if($query->num_rows() > 0)
            {
                foreach($query->result_array() as $row)
			    {
				    if($now - $row['UNIX_TIMESTAMP(time)'] < $diff_time)
				    {//the record is not out-date, get it
					    array_push($result,$row['tag_id']);
				    }
				    else
				    {//the record is out-date, delete it
					    $del_node = array('tag_id'=>$row['tag_id'],'uId'=>$data['uId']);
					    $this->recommend_tag_delete($del_node);
				    }
			    }
            }
            return $result;
        }

        //recommend tags for user
        //input:$data = array('uId'=>,'num'=>)
        function recommend_tag4user($data)
        {
            $tag_id_arr = $this->get_tag4user($data);
            if(!empty($tag_id_arr))
            {
                $this->add_tag_recommend_data(array('tag'=>$tag_id_arr,'uId'=>$data['uId']));
            }
        }


        //get recommended questions for user
        //input:$data=array('uId'=>,'range'=>)
        //output: array of question nid
        //table--'recommend_question'
        function get_recommend_question($data)
        {
            $now = time();
            $range = $data['range'];

            $this->db->select('nId');
            $this->db->where('uId',$data['uId']);
            $this->db->order_by('time','desc');
            if(!empty($range))
	        {
		        $this->db->limit($range['end']-$range['start']+1,$range['start']);
	        }
            $query = $this->db->get('recommend_question');

            $result = array();
            if($query->num_rows() > 0)
            {
                foreach($query->result() as $row)
			    {
				     array_push($result,$row->nId);
			    }
            }
            return $result;
        }

        function get_recommend_Q_num($uId)
        {
            $this->delete_outdate_Q($uId);

            $this->db->select('nId');
            $this->db->where('uId',$uId);
            $query = $this->db->get('recommend_question');
            return $query->num_rows();
        }

        function delete_outdate_Q($uId)
        {
            $Q_nid_arr = $this->get_outdate_Qnid($uId);
            if(!empty($Q_nid_arr))
            {
                $this->db->where('uId',$uId);
                $this->db->where_in('nId',$Q_nid_arr);
                $this->db->delete('recommend_question');
            }
        }

        function get_outdate_Qnid($uId)
        {
            $time = array('day'=>3,'hour'=>0,'minute'=>0,'second'=>0);
            $diff_time = (($time['day']*24 + $time['hour']) * 60 + $time['minute']) * 60 + $time['second'];
            $now = time();

            $this->db->select('nId,UNIX_TIMESTAMP(time)');
            $this->db->where('uId',$uId);
            $query = $this->db->get('recommend_question');
            $result = array();
            if($query->num_rows() > 0)
            {
                foreach($query->result_array() as $row)
			    {
				    if($now - $row['UNIX_TIMESTAMP(time)'] >= $diff_time)
				    {//the record is out-date
					    array_push($result,$row['nId']);
				    }
			    }
            }
            return $result;
        }

        //recommend questions for user to answer
        //input:$uId
       /* function recommend_Q4user($uId)
        {
            //get question according to user's location and tag
            $Q_nid_arr = $this->Question_process->get_question4user_qnid($uId);
            $user_qustion = $this->Search->search_by_user_asked(array($uId));
            $Q_nid_arr = array_diff($Q_nid_arr,$user_qustion);

            if(!empty($Q_nid_arr))
            {
                $this->add_Q_recommend_data(array('Qnid'=>$Q_nid_arr,'uId'=>$uId));
            }
        }  */


        //get recommended friends for user not including the out-date recommended questions
        //input:$data=array('uId'=>,'rtId'=>,'time'=>array('day'=>,'hour'=>,'minute'=>,'second'=>))
        //output: array of friend uid
        //table--'recommend_friend'
        function get_recommend_friend($data)
        {
            $now = time();

		    $time = $data['time'];
		    //compute the number of seconds
		    $diff_time = (($time['day']*24 + $time['hour']) * 60 + $time['minute']) * 60 + $time['second'];

            $this->db->select('friend_uId,UNIX_TIMESTAMP(time)');
            $this->db->where('to_uId',$data['uId']);
            $this->db->where('rtId',$data['rtId']);
            $query = $this->db->get('recommend_friend');

            $result = array();
            if($query->num_rows() > 0)
            {
                foreach($query->result_array() as $row)
			    {
				    if($now - $row['UNIX_TIMESTAMP(time)'] < $diff_time)
				    {//the record is not out-date, get it
					    array_push($result,$row['friend_uId']);
				    }
				    else
				    {//the record is out-date, delete it
					    $del_node = array('friend_uId'=>$row['friend_uId'],'to_uId'=>$data['uId'],'rtId'=>$data['rtId']);
					    $this->recommend_friend_delete($del_node);
				    }
			    }
            }
            return $result;
        }


        //recommend friends to user
        //input:$uId
        function recommend_friend4user($uId)
        {
            $friend_by_location = $this->get_friend_by_location($uId);
            $friend_by_tag = $this->get_friend_by_tag($uId);
            $friend_by_friend = $this->get_friend_by_friend($uId);

            $user_friend = $this->get_user_friend($uId);

            $friend_by_location = array_diff($friend_by_location,$user_friend);
            $friend_by_tag = array_diff($friend_by_tag,$user_friend);
            $friend_by_friend = array_diff($friend_by_friend,$user_friend);

            $result = array('uId'=>$uId,'location'=>$friend_by_location,'tag'=>$friend_by_tag,'friend'=>$friend_by_friend);

            $this->add_friend_recommend_data($result);
        }






        //----------------tags recommendation model----------------------
        //---------------------------------------------------------------


        //get the most frequently used tags that are included in the user's questions
        //input:$data = array('uId'=>,'num'=>)
        //output:array of tag id
        function get_tag4user($data)
        {
            $Q_nid_arr = $this->get_user_question($data['uId']);
            if(!empty($Q_nid_arr))
            {
                $tag_id_arr = $this->get_tagid_by_question($Q_nid_arr);
                if(!empty($tag_id_arr))
                {
                    $data['tag'] = $tag_id_arr;
                    $tags = $this->get_topn_tags($data);
                    return $tags;
                }
                else
                {
                    return array();
                }
            }
            else
            {
                return array();
            }
        }

        //get questions that user asked
        //input: $uId
        //output: array of question nid
        //table--'node'
        function get_user_question($uId)
        {
            $this->db->select('nId');
            $this->db->where('uId',$uId);
            $this->db->where('ntId',QUESTION);
            $query = $this->db->get('node');
            $result = array();
            if($query->num_rows() > 0)
            {
                foreach($query->result() as $row)
                {
                    array_push($result,$row->nId);
                }
            }
            return $result;
        }

        //get tag id of given questions
        //input: array of question nId
        //output: array of tag id
        //tabel--'question_tag'
        function get_tagid_by_question($Q_nid_arr)
        {
            $this->db->select('tag_id');
            $this->db->where_in('nId',$Q_nid_arr);
            $this->db->distinct();
            $query = $this->db->get('question_tag');
            $result = array();
            if($query->num_rows() > 0)
            {
                foreach($query->result() as $row)
                {
                    array_push($result,$row->tag_id);
                }
            }
            return $result;
        }

        //get the top n used tags  and   exclude those which the user already have
        //input: $data=array('uId'=>,'num'=>,'tag'=>)
        //$data['tag']:array of tag id that occured in the user's questions
        //$data['num']:numbers of tags want to get
        //output: array of tag id
        //table--'tag'
        function get_topn_tags($data)
        {
            $user_tag_id_arr = $this->get_user_tag($data['uId']);

            $this->db->select('tag_id');
            $this->db->where_in('tag_id',$data['tag']);
            $this->db->where_not_in('tag_id',$user_tag_id_arr);
            $this->db->order_by('count','desc');
            $this->db->limit($data['num']);
            $query = $this->db->get('tag');
            $result = array();
            if($query->num_rows() > 0)
            {
                foreach($query->result() as $row)
                {
                    array_push($result,$row->tag_id);
                }
            }
            return $result;
        }

        //get tags of a user
        //input:user id
        //output:array of tag id
        //table--'user_private_tag'
        function get_user_tag($uId)
        {
            $this->db->select('tag_id');
            $this->db->where('uId',$uId);
            $query = $this->db->get('user_private_tag');
            $result = array();
            if($query->num_rows() > 0)
            {
                foreach($query->result() as $row)
                {
                    array_push($result,$row->tag_id);
                }
            }
            return $result;
        }

        //add tag recommend data to DB
        //input: array('tag'=>,'uId'=>)
        //table--'recommend_tag'
        function add_tag_recommend_data($data)
        {
            $tag_id_arr = $data['tag'];
            date_default_timezone_set ('Asia/Shanghai');

            foreach($tag_id_arr as $tag_id)
            {
                if(!$this->tag_recommend_exist($data['uId'],$tag_id))
                {
                    $this->db->set('uId',$data['uId']);
                    $this->db->set('tag_id',$tag_id);
                    $time = time();
		            $this->db->set('time',date('Y-m-d H:i:s',$time));
                    $this->db->insert('recommend_tag');
                }
                else
                {//update the time
                    $this->db->where('uId',$data['uId']);
                    $this->db->where('tag_id',$tag_id);
                    $time = time();
		            $this->db->set('time',date('Y-m-d H:i:s',$time));
                    $this->db->update('recommend_tag');
                }
            }
        }

        //check if a record of tag recommendation exist
        //input:user id ,  tag id
        //table--'recommend_tag'
        //return true if exist
        function tag_recommend_exist($uId,$tag_id)
        {
            $this->db->select('tag_id');
            $this->db->where('uId',$uId);
            $this->db->where('tag_id',$tag_id);
            $query = $this->db->get('recommend_tag');
            if($query->num_rows() > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }


        //delete the outdate recommended tags
        //input:$data = array('uId'=>,'tag_id'=>)
        //table--'recommend_tag'
        function recommend_tag_delete($data)
        {
            $this->db->where('uId',$data['uId']);
            $this->db->where('tag_id',$data['tag_id']);
            $this->db->delete('recommend_tag');
        }



        //----------------quesitons recommendation model----------------------
        //--------------------------------------------------------------------

        //add tag recommend data to DB
        //input: array('Qnid'=>,'uId'=>)
        //table--'recommend_question'
        function add_Q_recommend_data($data)
        {
            $Q_nid_arr = $data['Qnid'];

            $time = time();

            foreach($Q_nid_arr as $Q_nid)
            {
                if(!$this->Q_recommend_exist($data['uId'],$Q_nid))
                {
                    $this->db->set('uId',$data['uId']);
                    $this->db->set('nId',$Q_nid);
		            $this->db->set('time',date('Y-m-d H:i:s',$time));
                    $this->db->insert('recommend_question');
                }
                else
                {//update the time
                    $this->db->where('uId',$data['uId']);
                    $this->db->where('nId',$Q_nid);
		            $this->db->set('time',date('Y-m-d H:i:s',$time));
                    $this->db->update('recommend_question');
                }
            }
        }

        //check if a record of question recommendation exist
        //input:user id ,  question nid
        //table--'recommend_question'
        //return true if exist
        function Q_recommend_exist($uId,$Q_nid)
        {
            $this->db->select('nId');
            $this->db->where('uId',$uId);
            $this->db->where('nId',$Q_nid);
            $query = $this->db->get('recommend_question');
            if($query->num_rows() > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        //delete the outdate recommended questions
        //input:$data = array('uId'=>,'nId'=>)
        //table--'recommend_question'
        function recommend_Q_delete($data)
        {
            $this->db->where('uId',$data['uId']);
            $this->db->where('nId',$data['nId']);
            $this->db->delete('recommend_question');
        }


        //----------------friends recommendation model----------------------
        //------------------------------------------------------------------


        //get friends by user's location
        //input: $uId
        function get_friend_by_location($uId)
        {
            $user_location = $this->User_data->get_user_location($uId);
            if(!empty($user_location))
            {
                $data = array('uId'=>$uId,'location'=>$user_location);
                $friends = $this->search_user_by_location($data);
                return $friends;
            }
            else
            {
                return array();
            }
        }

        //search users by location data excluding the user itself
        //input: $data = array('uId'=>,'location'=>)
        //input: $data['location'] = array('country_code'=>,'province_code'=>,'city_code'=>,'town_code'=>)
        //output: array of user id
        //table--'user_location'
        function search_user_by_location($data)
        {
            $this->db->select('uId');
            $location = $data['location'];
            if($location['town_code'])
            {
                $this->db->where('town_code',$location['town_code']);
            }
            else
            {
                if($location['city_code'])
                {
                    $this->db->where('city_code',$location['city_code']);
                }
                else
                {
                    if($location['province_code'])
                    {
                        $this->db->where('province_code',$location['province_code']);
                    }
                    else
                    {
                        $this->db->where('country_code',$location['country_code']);
                    }
                }
            }
            $this->db->where('uId !=',$data['uId']);
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


        //get friends by user's tag
        //input: $uId
        //output: array of user id
        function get_friend_by_tag($uId)
        {
            $user_tag = $this->get_user_tag($uId);
            if(!empty($user_tag))
            {
                $data = array('uId'=>$uId,'tag'=>$user_tag);
                $friends = $this->search_user_by_tag($data);
                return $friends;
            }
            else
            {
                return array();
            }
        }

        //search users by tag excluding the user itself
        //input: $data = array('uId'=>,'tag'=>)
        //output: array of user id
        //table--'user_private_tag'
        function search_user_by_tag($data)
        {
            $this->db->select('uId');
            $this->db->where_in('tag_id',$data['tag']);
            $this->db->where('uId !=',$data['uId']);
            $this->db->distinct();
            $query = $this->db->get('user_private_tag');
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

        //get friends by the user's friends
        //input: $uId
        //output: array of user id
        function get_friend_by_friend($uId)
        {
            $user_friend = $this->get_user_friend($uId);
            if(!empty($user_friend))
            {
                $result = array();
                foreach($user_friend as $friend_uId)
                {
                    $friend_of_friend = $this->get_user_friend($friend_uId);
                    if(!empty($friend_of_friend))
                    {
                        foreach($friend_of_friend as $row)
                        {
                            if($row != $uId)
                            {
                                array_push($result,$row);
                            }
                        }
                    }
                }
                $result = array_count_values($result);
                arsort($result);
                return array_keys($result);
            }
            else
            {
                return array();
            }
        }


        //get a user's all friends
        //input: user id
        //output: array of user id
        //table--'user_friends'
        function get_user_friend($uId)
        {
            $this->db->select('friend_uId');
            $this->db->where('uId',$uId);
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

        //add friend recommend data to DB
        //input: array('uId'=>,'location'=>,'tag'=>,'friend'=>)
        //table--'recommend_friend'
        function add_friend_recommend_data($data)
        {
            if(!empty($data['location']))
            {
                foreach($data['location'] as $row)
                {
                    $record = array('friend_uId'=>$row,'to_uId'=>$data['uId'],'rtId'=>LOCATION);
                    if(!$this->friend_recommend_exist($record))
                    {
                        $this->insert_friend_recommend($record);
                    }
                    else
                    {//exist,update the time
                        $this->update_friend_recommend($record);
                    }
                }
            }
            if(!empty($data['tag']))
            {
                foreach($data['tag'] as $row)
                {
                    $record = array('friend_uId'=>$row,'to_uId'=>$data['uId'],'rtId'=>TAG);
                    if(!$this->friend_recommend_exist($record))
                    {
                        $this->insert_friend_recommend($record);
                    }
                    else
                    {//exist,update the time
                        $this->update_friend_recommend($record);
                    }
                }
            }
            if(!empty($data['friend']))
            {
                foreach($data['friend'] as $row)
                {
                    $record = array('friend_uId'=>$row,'to_uId'=>$data['uId'],'rtId'=>FRIEND);
                    if(!$this->friend_recommend_exist($record))
                    {
                        $this->insert_friend_recommend($record);
                    }
                    else
                    {//exist,update the time
                        $this->update_friend_recommend($record);
                    }
                }
            }
        }

        //check if a record of friend recommendation exist
        //input: array('friend_uId'=>,'to_uId'=>,'rtId'=>)
        //table--'recommend_friend'
        //return true if exist
        function friend_recommend_exist($data)
        {
            $this->db->select('to_uId');
            $this->db->where($data);
            $query = $this->db->get('recommend_friend');
            if($query->num_rows() > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        //insert friend recommend data to db
        //input: array('friend_uId'=>,'to_uId'=>,'rtId'=>)
        //table--'recommend_friend'
        function insert_friend_recommend($data)
        {
            $time = time();
            $this->db->set($data);
            $this->db->set('time',date('Y-m-d H:i:s',$time));
            $this->db->insert('recommend_friend');
        }

        //update the time of friend recommend data
        //input: array('friend_uId'=>,'to_uId'=>,'rtId'=>)
        //table--'recommend_friend'
        function update_friend_recommend($data)
        {
            $time = time();
            $this->db->where($data);
            $this->db->set('time',date('Y-m-d H:i:s',$time));
            $this->db->update('recommend_friend');
        }

        //delete the outdate recommended friends
        //input:$data = array('friend_uId'=>,'to_uId'=>,'rtId'=>)
        //table--'recommend_friend'
        function recommend_friend_delete($data)
        {
            $this->db->where($data);
            $this->db->delete('recommend_friend');
        }
    }