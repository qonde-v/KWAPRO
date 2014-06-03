<?php
  class News_data extends CI_Model
  {
	function __construct()
	 {
	    parent::__construct();
		$this->load->model('q2a/Kpc_manage');
        $this->load->model('q2a/User_privatetag_manage');
        $this->load->helper('define');
	 }


	 //get news by value of specified key
	 //input array('key'=>value)
	 function get_newslist($data)
	 {
		$this->db->select('title,content,viewnum,pic,source,author');
        $this->db->where($data);
        $query = $this->db->get('news');
		$result = array();

		 if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                array_push($result,$row);
            }
        }
		return $result;
	 }
  }


  /*End of file*/
  /*Location: ./system/appllication/model/news_data.php*/