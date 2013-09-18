<?php
  class Photo_upload extends CI_Model
  {
	 function __construct()
	 {
	    parent::__construct();
		$this->load->helper('profile_error');
        $this->load->helper('prompt');
	 }

	 //upload user photo
	 //input: array('user_id','file_id');
	 function user_photo_upload($data)
	 {
	     //configure data
		 // $config['file_name'] = $data['file_name'];
		  $photo_path = $this->config->item('base_photoupload_path');

		  $config['upload_path'] = './'.$photo_path.'temp/';
		  $config['allowed_types'] = 'gif|jpg|png';
		  $config['max_size'] = '2048';
		  $config['max_width']  = '';
		  $config['max_height']  = '';

		  //
		  $this->file_path_check($config['upload_path']);

		  //init class upload
		  $this->load->library('upload', $config);

		  if(!$this->upload->do_upload($data['file_id']))
		  {
			 $error = array('error' => $this->upload->display_errors());
			 echo $error['error'];

			 return FAIL_PHOTO;
			 //return $error['error'];
		  }
		  else
		  {
		     return UPDATE_SUCCESS;
		  }

	 }

	 function file_path_check($file_path)
	 {
	    if(!file_exists($file_path))
		{
		   mkdir($file_path,0777);
		}
	 }

	 //save user uploaded photo
	 //input: array('uId','photo_name','photo_type')
	 function user_photo_save($data)
	 {
	    if($this->is_photo_exist($data))
		{
		   $this->user_photo_update($data);
		}
		else
		{
		   $this->user_photo_insert($data);
		}
	 }

	 //check if the same record (uId,photo_name,photo_type) of user photo
	 //exist in DB,
	 //return true if exist,otherwise return false
	 function is_photo_exist($data)
	 {
	    $sql = "SELECT uId FROM user_photo WHERE uId = {$data['uId']} and photo_type = {$data['photo_type']}";
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

	 //update user's photo record
	 //input: array('uId','photo_name','photo_type')
	 function user_photo_update($data)
	 {
	    $sql = "UPDATE user_photo SET photo_name = '{$data['photo_name']}' WHERE uId = {$data['uId']} and photo_type = {$data['photo_type']}";
		 $this->db->query($sql);
	 }

	 //insert user's photo record
	 //input: array('uId','photo_name','photo_type')
	 function user_photo_insert($data)
	 {
		 $this->db->insert('user_photo',$data);
	 }

	 //

  }//end of class
/*End of file*/
/*Location: ./system/appllication/model/q2a/photo_upload.php*/