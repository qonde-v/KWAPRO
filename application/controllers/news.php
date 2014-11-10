<?php
  class News extends CI_Controller
  {
	  var $pre_msg_num=5;
    function __construct()
	 {
	    parent::__construct();
		 $this->load->helper('url');
		 $this->load->helper('define');
		 $this->load->helper('kpc_define');

		 $this->load->database();
		 $this->load->library('session');
		 $this->load->model('q2a/User_activity');
		 $this->load->model('q2a/Auth');
		 $this->load->library('account_format_check');

                 $this->load->model('q2a/User_profile');
		 $this->load->model('q2a/Right_nav_data');
		 $this->load->model('q2a/Invite_data_process');
         $this->load->model('q2a/Load_common_label');
		 $this->load->model('q2a/Friend_manage');
		 $this->load->model('q2a/Kpc_manage');
         $this->load->model('q2a/Ip_location');
         $this->load->model('q2a/User_privacy');
		 $this->load->model('q2a/News_data');
	 }

	function index()
	{
	   //$this->output->cache(1);
	   $base = $this->config->item('base_url');

	   $language = $this->Ip_location->get_language();


	   $data = array('base'=>$base);

	   $user_id = $this->session->userdata('uId');
	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
	   $data = array_merge($right_data,$data);

		$data['type'] = empty($_GET['type'])?1:$_GET['type'];
		$data['cdt_name'] = empty($_GET['cdt_name'])?'':$_GET['cdt_name'];

		if($this->session->userdata('site')=='WebSite'){
			$user_id = $this->session->userdata('uId');
			$data['login'] = "login";
		 }

	   //get news 
		$where="type = ".$data['type'];
		if($data['cdt_name']!=''){
			$where .= " and (title like '%".$data['cdt_name']."%' or content like '%".$data['cdt_name']."%')";
		}
		$news=array();;
		$pre_msg_num = $this->pre_msg_num;
	    $range = array('start'=>0,'end'=>$pre_msg_num-1);
		$this->db->select('*');
		$this->db->where($where);
		$t_query=$this->db->get('news');
		$data['inbox_num']=	$t_query->num_rows();



		$this->db->where($where);
		$this->db->order_by('createTime','desc');
		$this->db->limit($range['end']-$range['start']+1,$range['start']);
		$query = $this->db->get('news');
		foreach($query->result_array() as $row)
		{
			array_push($news,$row);
		}
		$data['news'] = $news;
		$data['pre_msg_num'] = $this->pre_msg_num;
		$data['inbox_page_num'] = ($data['inbox_num'] == 0) ? 1 : ceil($data['inbox_num']/$data['pre_msg_num']);


		//jinghuatuijian
	   $best_list = array();
	   $best_list = $this->News_data->get_newslist(array('isbest'=>1,'type'=>$data['type']), 2);
	   $data['best_list'] = $best_list;

	   $status = array('1'=>'动态','11'=>'行业动态','12'=>'潮流资讯','13'=>'明星动态','2'=>'知识','21'=>'运动','22'=>'面料','23'=>'制衣',);
	   $data['status'] = $status;

	   $this->load->view('q2a/news',$data);

	}

	function sort_news()
	{

		$base = $this->config->item('base_url');
		$user_id = $this->session->userdata('uId');
		$index = $this->input->post('index',TRUE);
		$pre_num = $this->pre_msg_num;
		$range = array('start'=>($index-1)*$pre_num, 'end'=>$index*$pre_num-1);

		$news=array();
		$this->db->select('*');
		$this->db->where('type',$this->input->post('type',TRUE));
		$this->db->order_by('createTime','desc');
		$this->db->limit($range['end']-$range['start']+1,$range['start']);
		$query = $this->db->get('news');
		foreach($query->result_array() as $row)
		{
			array_push($news,$row);
		}

		$html = '';
		if(!empty($news))
		{
			foreach($news as $item){
				$html .= '<div class="media">';
				$html .= '  <a class="media-pic" href="#">';
				$html .= '	<img src="'.$base.'upload/uploadimages/'.$item['pricefilename'].'" alt="..." width="250" height="185">';
				$html .= '  </a>';
				$html .= '  <div class="media-body">';
				$html .= '	<a href="'.$base.'news/news_detail?id='.$item['ID'].'" class="media-heading">'.$item['title'].'</a>';
				$html .= '	<span>'.self::utf8Substr($item['content'],0,100).'...........</span>';
				$html .= '	<div class="media-footer">阅览（'.$item['viewnum'].'）</div>';
				$html .= '  </div>';
				$html .= '</div>';
			}
		}
		echo $html;

	}

    function utf8Substr($str, $from, $len)   
    {   
      return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.   
                         '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',   
                         '$1',$str);   
    }  

	function news_detail()
	{
	   //$this->output->cache(1);
	   $base = $this->config->item('base_url');
	   $data = array('base'=>$base);

	   //login permission check
	   //$this->Auth->permission_check("login/");

	   //get current login user id
	   $user_id = $this->session->userdata('uId');
	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
	   $data = array_merge($right_data,$data);

	   $language = $this->Ip_location->get_language();

	   if($this->session->userdata('site')=='WebSite'){
			$user_id = $this->session->userdata('uId');
			$data['login'] = "login";
		 }

	   $status = array('1'=>'动态','11'=>'行业动态','12'=>'潮流资讯','13'=>'明星动态','2'=>'知识','21'=>'运动','22'=>'面料','23'=>'制衣',);
	   $data['status'] = $status;

	   $result=array();
	   
		$this->db->select('*');
		$this->db->where('id',$_GET['id']);
		$query = $this->db->get('news');
		$result = array();
		if($query->num_rows() > 0)
		{
			foreach($query->result_array() as $row)
			{
				array_push($result,$row);
			}
		}
		
	   foreach($result as $val){
		   $data['news']=$val;
	   }

	   //jinghuatuijian
	   $best_list = array();
	   $best_list = $this->News_data->get_newslist(array('isbest'=>1), 2);
	   $data['best_list'] = $best_list;

	   $lastid = $this->News_data->get_lastid($data['news']['ID'],$data['news']['type']);
	   $nextid = $this->News_data->get_nextid($data['news']['ID'],$data['news']['type']);
		
		$data['lastid'] = $lastid;
		$data['nextid'] = $nextid;

		$this->load->view('q2a/news_detail',$data);
	}

 }

 /*End of file*/
  /*Location: ./system/appllication/controller/Consult.php*/
