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
		$data['type'] = empty($_GET['type'])?1:$_GET['type'];
		$data['cdt_name'] = empty($_GET['cdt_name'])?'':$_GET['cdt_name'];

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
				$html .= '<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">';
				$html .= '<tr>';
				$html .= '<td width="20%" height="120" valign="top" align="center">';
				$html .= '<img src="'.$base.'upload/uploadimages/'.$item['pricefilename'].'" align="absmiddle" border="0" width="93" height="126" class="img_k"/>';
				$html .= '</td>';
				$html .= '<td width="80%" valign="top" align="left" style="line-height:22px;">
					<a href="'.$base.'news/news_detail?id='.$item['ID'].'" class="Red14"><font class="fDOrange14">'.$item['title'].'</font></a><br><br>'.$item['content'].'...<br>';
				$html .= '</td>';			
				$html .= '</tr>';
				$html .= '<tr>';
				$html .= '<td width="100%" height="50" valign="top" align="right" colspan="2">';
				$html .= $item['viewnum'].'浏览   &nbsp;&nbsp; 分享到： <a href="#"><img src="'. $base.'img/fenx_001.png" align="absmiddle" border="0" /> </a>   <a href="#"><img src="'. $base.'img/fenx_002.png" align="absmiddle" border="0" /> </a>   <a href="#"><img src="'. $base.'img/fenx_003.png" align="absmiddle" border="0" /> </a>   <a href="#"><img src="'. $base.'img/fenx_004.png" align="absmiddle" border="0" /> </a>   <a href="#"><img src="'. $base.'img/fenx_005.png" align="absmiddle" border="0" /> </a>';
				$html .= '</td>';
			    $html .= '</tr>';
				$html .= '</table>';

			}
		}
		echo $html;

	}


	function news_detail()
	{
	   //$this->output->cache(1);
	   $base = $this->config->item('base_url');

	   //login permission check
	   //$this->Auth->permission_check("login/");

	   //get current login user id
	   $user_id = $this->session->userdata('uId');

	   $language = $this->Ip_location->get_language();

	   $data = array('base'=>$base);
	   $data['login'] = "login";
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


		$this->load->view('q2a/news_detail',$data);
	}

 }

 /*End of file*/
  /*Location: ./system/appllication/controller/Consult.php*/
