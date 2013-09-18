<?php
class Note_manage extends CI_Model
{
	function __construct()
	{
		parent::__construct();
        $this->load->helper('define');
	}
	
	//save a new create note
	//input: array('uId','subject','tags','content')
	//output: insert noteId
	//table--'user_notes'
	function new_note_save($data)
	{
		$tags_arr = explode(',',$data['tags']);
		$data['tags'] = implode('|',$tags_arr);
		
		$this->db->set($data);
		$time = time();
		$this->db->set('time',date('Y-m-d H:i:s',$time));
		$this->db->insert('user_notes');
		return $this->db->insert_id();
	}
	
	//save an edited note
	//input: array('noteId','subject','tags','content','time')
	//table--'user_notes'
	function edit_note_save($data)
	{
		$this->db->where('noteId',$data['noteId']);
		$this->db->set($data);
		$this->db->update('user_notes');
	}
	
	//get details of a note
	//input: noteId
	//output: array('subject','tags','content','time')
	//table--'user_notes'
	function get_note_data($noteId)
	{
		$this->db->select('subject,tags,content,time');
		$this->db->where('noteId',$noteId);
		$query = $this->db->get('user_notes');
		$result = array();
		if($query->num_rows() > 0)
		{
			$row = $query->row_array();
			$result = $row;
		}
		return $result;
	}
	
	//get user's notes
	//input: user id, range
	//output: array(array('subject','tags','content','time'))
	//table--'user_notes'
	function get_user_notes($uId,$range = array(),$sort_type)
	{
		$this->db->select('noteId,subject,tags,content,time');
		$this->db->where('uId',$uId);
		$type = ($sort_type == 0) ? 'desc' : 'asc';
		$this->db->order_by('time',$type);
		if(!empty($range))
		{
			$this->db->limit($range['end']-$range['start']+1,$range['start']);
		}
		$query = $this->db->get('user_notes');
		$result = array();
		if($query->num_rows() > 0)
		{
			foreach($query->result_array() as $row)
			{
				$row['content'] = str_replace("\n","<br/>",$row['content']);
				array_push($result,$row);
			}
		}
		return $result;
	}
	
	//get number of user's notes
	//input: user id
	//table--'user_notes'
	function get_user_notes_num($uId)
	{
		$this->db->select('noteId');
		$this->db->where('uId',$uId);
		$query = $this->db->get('user_notes');
		return $query->num_rows();
	}
	
	//delete notes
	//input: array of noteId
	//table--'user_notes'
	function notes_delete($data)
	{
		$this->db->where_in('noteId',$data);
		$this->db->delete('user_notes');
	}
        
        
        //get subject and id of user note by given array of id
        //input:  array of id
        //output: array of array('text','id','time')
        function get_note_text_id($id_arr)
        {
               $this->db->select('noteId as id,subject as text, time');
               $this->db->where_in('noteId', $id_arr);
               $query = $this->db->get('user_notes');
               if($query->num_rows() > 0)
               {
                   return $query->result_array();
               }
               return array();
        }
		
	//store note. if subject exist, append content, else insert a new note
	//input: array('uId','subject','content','tags')
	//table--'user_notes'
	function note_store($data)
	{
		$noteId = $this->note_subject_exist($data);
		if($noteId > 0)
		{
			$data['noteId'] = $noteId;
			$this->append_content2note($data);
		}
		else
		{
			$this->new_note_save($data);
		}
	}
	
	//append content to a existed note
	//input:array('uId','subject','content','tags')
	//table--'user_notes'
	function append_content2note($data)
	{
		$note_data = $this->get_note_data($data['noteId']);
		$content = $note_data['content'].$data['content'];
		$this->db->where('noteId',$data['noteId']);
		$this->db->set('content',$content);
		$this->db->set('time',date('Y-m-d H:i:s',time()));
		$this->db->update('user_notes');
	}
		
	//check if note subject exist
	//input: $subject
	//return note id if exist, else return 0
	//table--'user_notes'
	function note_subject_exist($data)
	{
		$this->db->select('noteId');
		$this->db->where('subject',$data['subject']);
		$this->db->where('uId',$data['uId']);
		$query = $this->db->get('user_notes');
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			return $row->noteId;
		}
		else
		{
			return 0;
		}
	}
}
