<?php
  class Settings_request extends CI_Controller
  {
     function __construct()
	 {
	     parent::__construct();
		 $this->load->helper('url');
		 $this->load->database();
		 $this->load->library('security');
		 $this->load->library('session');

		 $this->load->model('q2a/Auth');
		 $this->load->model('q2a/Search');
		 $this->load->model('q2a/Settings_check');
		 $this->load->model('q2a/User_profile');
		 $this->load->model('q2a/Photo_upload');
                 $this->load->model('q2a/Check_process');
                 $this->load->model('q2a/User_privatetag_manage');
                 $this->load->model('q2a/Ip_location');
		 $this->load->model('q2a/Tag_process');
		 $this->load->model('q2a/User_privacy');
		 $this->load->model('q2a/Image_process');
		 $this->load->driver('cache');
	 }

	 //*************************data submit process functions**************************//
	 //basic data submit process
	 //include: photo upload, birthday,username,gender and password
	 //input: array('gender','birthday','old_password','new_password','new_passwordc')
	 function basic()
	 {
	    if($this->Auth->request_access_check())
		{
			$post_arr = array();
		   
		   foreach($_POST as $key => $value)
		   {
		   		$post_value = $this->input->post($key,TRUE);
				if(!$post_value)
				{
				   $post_arr[$key] = ($key == 'gender') ? 0: '';
				}
				else
				{
				  $post_arr[$key] = $post_value;
				}
		   }
			$post_arr['uId'] = $this->session->userdata('uId');
			$msg_id_arr = $this->Settings_check->profile_basic_check($post_arr);
			//print_r($msg_id_arr);
			if(empty($msg_id_arr))
			{
			   $data = $this->Settings_check->generate_basic_format_data($post_arr);
			   $this->User_profile->user_basicdata_process($data);
                           
                           $lang_version = $this->Ip_location->get_language_by_code($data['langCode']);
                           $this->session->set_userdata(array('language'=>$lang_version));
                           
			   echo $this->Check_process->get_prompt_msg(array('pre'=>'profile','code'=> UPDATE_SUCCESS));
			}
			else
			{
			   //return error message
			   //data can't match the condition to update
			   echo $this->Check_process->get_prompt_msg(array('pre'=>'profile','code'=> UPDATE_FAIL));
			   foreach($msg_id_arr as $error_code)
			   {
                  $msg = $this->Check_process->get_prompt_msg(array('pre'=>'profile','code'=> $error_code));
				  echo $msg."<br/>";
			   }
			}
		}
	 }

	 //
	 function photo_upload()
	 {
	     if($this->Auth->request_access_check())
		 {
			  $user_id = $this->session->userdata('uId');
			  $msg = $this->Photo_upload->user_photo_upload(array('user_id'=>$user_id, 'file_id'=>'user_photo'));
			
			  if(UPDATE_SUCCESS == $msg)
			  {
			  	
				 $file_name = $this->security->sanitize_filename($_FILES['user_photo']['name']);
				 $max_height = "350";
				
				 $base = $this->config->item('base_url');
				 $base_photoupload_path = $this->config->item('base_photoupload_path');
				 
				 $file_path = './'.$base_photoupload_path.'temp/'.$file_name;
				 $img_src = $base.$base_photoupload_path.'temp/'.$file_name;
				 chmod($file_path,0777);
				 $width = $this->Image_process->getWidth($file_path);
				 $height = $this->Image_process->getHeight($file_path);
				 if($height > $max_height)
				 {
				 	$scale = $max_height/$height;
					$uploaded = $this->Image_process->resizeImage($file_path,$width,$height,$scale);
				 }
				 else
				 {
				 	$scale = 1;
					$uploaded = $this->Image_process->resizeImage($file_path,$width,$height,$scale);
				 }
				 echo "<img id=\"original_img\" border=\"1\" style=\"\" src=\"".$img_src."\"/>";
			  }
			  else
			  {
				echo $this->Check_process->get_prompt_msg(array('pre'=>'profile','code'=> $msg));
			  }
         }
	 }
	 
	 //request for deleting temp photo file
	 function temp_photo_delete()
	 {
	 	if($this->Auth->request_access_check())
		{
			$file_name = $this->input->post('filename');
			$base_photoupload_path = $this->config->item('base_photoupload_path');
			$file_path = "./".$base_photoupload_path.'temp/'.$file_name;
			unlink($file_path);
		}
	 }
	 
	 //save cropped thumb
	 function save_thumb()
	 {
	 	if($this->Auth->request_access_check())
		{
			$post_arr = array();
			foreach($_POST as $key => $value)
			{
				$post_value = $this->input->post($key);
				$post_arr[$key] = $post_value;
			}
			
			$scale = 100 / $post_arr['w'];
			$base = $this->config->item('base_url');
			$base_photoupload_path = $this->config->item('base_photoupload_path');
			$user_id = $this->session->userdata('uId');
			
			$save_thumb_path = "./".$base_photoupload_path.$user_id."/".$post_arr['filename'];
			$temp_thumb_path = "./".$base_photoupload_path."temp/".$post_arr['filename'];

			$new_uid_folder = "./".$base_photoupload_path.$user_id."/";
                        if(!file_exists($new_uid_folder))
                        {
                                mkdir($new_uid_folder,0777);
                        }

			if(file_exists($save_thumb_path))
			{
				unlink($save_thumb_path);
			}
			$this->Image_process->resizeThumbnailImage($save_thumb_path,$temp_thumb_path,$post_arr['w'],$post_arr['h'],$post_arr['x1'],$post_arr['y1'],$scale);
			$this->Photo_upload->user_photo_save(array('uId'=>$user_id,'photo_name'=>$post_arr['filename'],'photo_type'=>1));
			$msg = $this->Check_process->get_prompt_msg(array('pre'=>'profile','code'=> UPDATE_SUCCESS));
			$user_photo_path = $base.$base_photoupload_path.$user_id."/".$post_arr['filename'];
			echo $user_photo_path."##".$msg;
		}
	 }

	 //advance data submit process
	 //include: language, local data and tags setting
	 //input: array('language_code','location','tags')
	 function advance()
	 {
	    if($this->Auth->request_access_check())
		{
			$post_arr = array();
		   
		   foreach($_POST as $key => $value)
		   {
		   		$post_value = $this->input->post($key,TRUE);
		   		$post_arr[$key] = $post_value ? $post_value : 0;
		   }
			$post_arr['uId'] = $this->session->userdata('uId');

			$msg_id_arr = $this->Settings_check->profile_advance_check($post_arr);
			if(empty($msg_id_arr))
			{
			   //data format correct to update
			   $data = $this->Settings_check->generate_advance_format_data($post_arr);
			   $this->User_profile->user_advancedata_process($data);
			   echo $this->Check_process->get_prompt_msg(array('pre'=>'profile','code'=> UPDATE_SUCCESS));
			}
			else
			{
			  echo $this->Check_process->get_prompt_msg(array('pre'=>'profile','code'=> UPDATE_FAIL));
			  foreach($msg_id_arr as $error_code)
			  {
				$msg = $this->Check_process->get_prompt_msg(array('pre'=>'profile','code'=> $error_code));
				  echo $msg."<br/>";
			  }
			}
        }
	 }
	 
	 	//rss setting submit process
	 	//input: array('rcv_rss','rss_feed')
	 	function rss_setting()
	 	{
	 			if($this->Auth->request_access_check())
	 			{
	 					$user_id = $this->session->userdata('uId');
	 					$rcv_rss = $this->input->post('rcv_rss');
	 					$rss_feed_str = $this->input->post('rss_feed');
	 					if($rss_feed_str != '')
	 					{
	 						$rss_feed_arr = explode('@@',$rss_feed_str);
	 					}
	 					else
	 					{
	 						$rss_feed_arr = array();
	 					}
	 					$data = array('uId'=> $user_id, 'rcv_rss'=> $rcv_rss, 'rss_feed'=> $rss_feed_arr);
	 					$this->User_profile->rss_setting_save($data);
	 					echo $this->Check_process->get_prompt_msg(array('pre'=>'profile','code'=> UPDATE_SUCCESS));
	 			}
		}

	 //interact data submit process
	 //input: array('email','gtalk','msn','qq','sms','selected_method_id')
	 function interact()
	 {
	   if($this->Auth->request_access_check())
	   {
		   $user_id = $this->session->userdata('uId');
		   $post_arr = array();
		   
		   foreach($_POST as $key => $value)
		   {
		   		$post_value = $this->input->post($key,TRUE);
		   		$post_arr[$key] = $post_value ? $post_value : 0;
		   }
		   $data = $this->Settings_check->generate_interact_format_data($user_id,$post_arr);
		   //print_r($data);
		   $msg_id_arr = $this->Settings_check->profile_interact_check($data);

		   if(empty($msg_id_arr))
		   {
			   //data format correct to update
			   //print_r($data);
			   $this->User_profile->user_method_process($data);
			   echo $this->Check_process->get_prompt_msg(array('pre'=>'profile','code'=> UPDATE_SUCCESS));
		   }
		   else
		   {
			  //data can't match the condition to update
			  echo $this->Check_process->get_prompt_msg(array('pre'=>'profile','code'=> UPDATE_FAIL));
			  foreach($msg_id_arr as $error_code)
			  {
				$msg = $this->Check_process->get_prompt_msg(array('pre'=>'profile','code'=> $error_code));
				  echo $msg."<br/>";
			  }
		   }
       }//if
	 }
	 
	 //privacy data process
	 function privacy()
	 {
	 		if($this->Auth->request_access_check())
	   {
		   $user_id = $this->session->userdata('uId');
		   $post_arr = array();
		   
		   foreach($_POST as $key => $value)
		   {
		   		$post_value = $this->input->post($key,TRUE);
		   		$post_arr[$key] = $post_value ? $post_value : 0;
		   }
		   $data = $this->Settings_check->generate_privacy_format_data($post_arr);
		   
		   $this->User_privacy->update_user_privacy(array('uId'=>$user_id,'privacy_info'=>$data));
				echo $this->Check_process->get_prompt_msg(array('pre'=>'profile','code'=> UPDATE_SUCCESS));
		   
       }//if
	 }
	 
	 
	 //process the tag-added event
	 function tag_added2subcate()
	 {
		if($this->Auth->request_access_check())
	    {
	    	$tag_str = $this->input->post('tag_str',TRUE);
	    	if($tag_str)
	    	{
	    		$tag_arr = explode('@@',$tag_str);
	    	}
	    	else
	    	{
	    		$tag_arr = array();
	    	}
	    	$id_info_str = $this->input->post('id_info',TRUE);
	    	if($id_info_str)
	    	{
	    		$id_info = explode('_',$id_info_str);
	    	}
	    	else
	    	{
	    		$id_info = array();
	    	}
			$user_id = $this->session->userdata('uId');
			
			$data = array('uId'=>$user_id,'sub_cate_id'=>$id_info[1],'category_id'=>$id_info[0],'langCode'=>$_POST['langCode'],'tag_arr'=>$tag_arr);
			
			$this->User_privatetag_manage->privatetag_add_process($data);
			echo $this->Check_process->get_prompt_msg(array('pre'=>'profile','code'=> UPDATE_SUCCESS));
        }
	 }
	 
	 //
	 function get_private_tags()
	 {
		if($this->Auth->request_access_check())
	    {
	    	$id_info_str = $this->input->post('id_info',TRUE);
	    	if($id_info_str)
	    	{
	    		$id_info = explode('_', $id_info_str);
	    	}
				else
				{
					$id_info = array();
				}
			$user_id = $this->session->userdata('uId');
			
			$data = array('uId'=>$user_id,'sub_cate_id'=>$id_info[1],'category_id'=>$id_info[0]);
			$tag_data = $this->User_privatetag_manage->get_privatetag_data($data);
			echo implode('@@', $tag_data);
        }  
	 }
	 
	 //
	 function profile_search_tag()
	 {
		if($this->Auth->request_access_check())
	    {
			$keyword = $this->input->post('keyword',TRUE);
			if($keyword)
			{
				$id_info_str = $this->input->post('id_info',TRUE);
				if($id_info_str)
				{
					$id_info = explode('_', $id_info_str);
				}
				else
				{
					$id_info = array();
				}
				$tag_data = $this->Search->search_tag(array('keyword'=>$keyword,'category_id'=>$id_info[0],'sub_cate_id'=>$id_info[1]));
				
				if(count($tag_data))
				{
					  $i = 0;
					  $html_str = "";
					  foreach ($tag_data as $key=>$value) 
					  {
						 $i++;
						 $html_str .= "<li id='li_".$i."' value = '".$key."' >".$value."</li>";
					  }
					  echo $i."##".$html_str;
				}
				else
				{
					echo '##';
				}
			}
			else
			{
				echo '##';
			}
        }   
	 }
	 
	 //get sub category data by category id and language code
	 function get_subcate_by_cate_id()
	 {
	 	if($this->Auth->request_access_check())
	    {
			$langCode    = $this->input->post('langCode',TRUE);
			$category_id = $this->input->post('category_id',TRUE);
			$data = $this->Tag_process->get_subcategory_data_mutli(array('langCode'=>$langCode,'category_id'=>$category_id));
			
			$item_arr = array();
			for($i=0; $i<count($data); $i++)
			{
			   $item_arr[$i] = $data[$i]['sub_cate_id'].'#'.$data[$i]['sub_cate_name'].'#'.$data[$i]['category_id'];
			}
			
			echo implode('@',$item_arr);
	    }
	 }
	 
	function get_tag_by_sub_cate()
	{
		if($this->Auth->request_access_check())
		{
				$langCode = $this->input->post('langCode',TRUE);
				$subcate_id = $this->input->post('subcate_id',TRUE);
				
				$data = $this->Tag_process->get_tag_by_subcate(array('langCode'=>$langCode,'subcate_id'=>$subcate_id));
			
				$item_arr = array();
				for($i=0; $i<count($data); $i++)
				{
			  	$item_arr[$i] = $data[$i]['tag_id'].'#'.$data[$i]['tag_name'];
				}
			
				echo implode('@',$item_arr);
		}
	}
	 
	 function subcate_add_process()
	 {
	    if($this->Auth->request_access_check())
	    {
		    $value    = $this->input->post('value',TRUE);
			$langCode    = $this->input->post('langCode',TRUE);
			$category_id = $this->input->post('category_id',TRUE);
			
			$id = $this->Tag_process->subcate_add(array('sub_cate_name'=>$value,'langCode'=>$langCode,'category_id'=>$category_id));
			if($id == '')
			{
				echo "##".$this->Check_process->get_prompt_msg(array('pre'=>'profile','code'=> SUB_CATE_EXIST));
			}
			else
			{
				echo $category_id.'_'.$id;
			}
	    }
	 }
	 
	function search_category()
	{
		if($this->Auth->request_access_check())
		{
			$langCode = $this->input->post('langCode',TRUE);
			$text = $this->input->post('text',TRUE);
			$data = array('langCode'=> $langCode, 'text'=> $text);
			$result = $this->Tag_process->search_category($data);
			$item_arr = array();
			for($i=0; $i<count($result); $i++)
			{
			  $item_arr[$i] = $result[$i]['category_id'].'#'.$result[$i]['category_name'];
			}
			echo implode('@',$item_arr);
		}
	}
	
	function search_sub_cate()
	{
		if($this->Auth->request_access_check())
		{
			$post_arr = array();	   
		  foreach($_POST as $key => $value)
		  {
		   	$post_value = $this->input->post($key,TRUE);
		   	$post_arr[$key] = $post_value ? $post_value : 0;
		  }
			$result = $this->Tag_process->search_sub_cate($post_arr);
			$item_arr = array();
			for($i=0; $i<count($result); $i++)
			{
			  $item_arr[$i] = $result[$i]['sub_cate_id'].'#'.$result[$i]['sub_cate_name'].'#'.$result[$i]['category_id'];
			}
			echo implode('@',$item_arr);
		}
	}
	
	function search_tag()
	{
		if($this->Auth->request_access_check())
		{
			$post_arr = array();	   
		  foreach($_POST as $key => $value)
		  {
		   	$post_value = $this->input->post($key,TRUE);
		   	$post_arr[$key] = $post_value ? $post_value : 0;
		  }
				
			$data = $this->Tag_process->search_tag($post_arr);
			
			$item_arr = array();
			for($i=0; $i<count($data); $i++)
			{
			  $item_arr[$i] = $data[$i]['tag_id'].'#'.$data[$i]['tag_name'];
			}
			
			echo implode('@',$item_arr);
		}
	}
	
	function get_location_data()
	{
		if($this->Auth->request_access_check())
		{
			$post_arr = array();	   
		  	foreach($_POST as $key => $value)
		  	{
		   		$post_value = $this->input->post($key,TRUE);
		   		$post_arr[$key] = $post_value ? trim($post_value) : 0;
		  	}
			if($this->cache->memcached->get($post_arr['code']))
			{
				echo $this->cache->memcached->get($post_arr['code']);
			}
			else
			{
				$data = $this->Search->search_location_data($post_arr);
				$this->cache->memcached->save($post_arr['code'],$data,60);
				echo $data;
			}
		}
	}
	
	
	 
	  
 }//END OF CLASS
 /*End of file*/
  /*Location: ./system/appllication/controller/settings_request.php*/
