<?php
header("Content-type: text/html; charset=utf-8");

class News extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->helper('form','url');
		$this->load->database();
		$this->load->library('session');
		$this->load->library('table');		
		$this->load->library('pagination');
		
		$this->load->model('q2a/Auth');
		$this->load->model('admin/Core_user');
		$this->load->model('q2a/News_data');

	}
	
	protected function initBaseinfo($data){
		$data['base'] = $this->config->item('base_url');
		$this->Auth->permission_check($data['base'].'admin/login','MainSite');
		$data['login'] = "login";
		$roleId = $this->session->userdata('roleId');
		$data['roleId'] = $roleId;
		$data['user_id'] = $this->session->userdata('user_id');
		$data['nickname']=$this->Core_user->getNicknameById($data['user_id']);
		if($roleId==1){
			$createid = isset($_GET["createid"])?$_GET["createid"]:$this->session->userdata('user_id');//$roleId == 1 ? "" :$this->session->userdata('user_id');
		}else{
			$createid = $this->session->userdata('user_id');
		}
		$data['createid'] = $createid;


		$status = array('1'=>'动态','11'=>'行业动态','12'=>'潮流资讯','13'=>'明星动态','2'=>'知识','21'=>'运动与服装','22'=>'纤维与面料','23'=>'服装设计与打理',);
	    $data['status'] = $status;


		return $data;
	}
	
	public function index($offset = ''){
		self::get_list($offset, "");
	}
	
	//列表页显示（查询页面）
	function get_list($offset, $condition){
		$data = array();
		$limit = 20;
		
		//$limit = $data['total_num'];
		$data = self::initBaseinfo($data);
		
		$per_page = isset($_GET["per_page"])? $_GET["per_page"]:0;
		$roleId = $this->session->userdata('roleId');
		$createid = $data['createid'];
		$data['total_num'] = $this->News_data->get_count($createid, $condition);
		
		$list = $this->News_data->show_all($createid, $condition, $limit, $per_page);

		foreach ($list as $record) {
			$record->creator = $this->Core_user->getUserCodeById($record->createid);
		}
		
		$data['list'] = $list;
				
		if($condition != "" && $condition['cdt_name'] != '')
			$data["cdt_name"] = $condition['cdt_name'];
		else 
			$data["cdt_name"] = "";
	
 
		$uri = $this->uri->segment(1);
		if($this->uri->segment(2) != ""){
			$uri = $uri."/".$this->uri->segment(2);
		}
		
		$base_url = $data['base'].$uri."?per_page=".$per_page."&createid=".($this->session->userdata('user_id'));
		$base_url = $base_url."&cdt_name=".(isset($_GET['cdt_name'])?$_GET['cdt_name'] : '');
		
		
		
		$config['base_url'] = $base_url;
		$config['total_rows'] = $data['total_num'];
		$config['per_page'] = $limit;
		$config['first_link'] = "首页";
		$config['last_link'] = "尾页";
		$config['num_links'] = 5;
		$this->pagination->initialize($config);
		$data['limit'] = $limit;
		$data['offset'] = $offset;
		$data['pagination'] = $this->pagination->create_links();
		$this->load->view('admin/news_list', $data);
	}
	
	public function edit(){
		$data = array();
		$data = self::initBaseinfo($data);
		
		$id = $this->uri->segment(4);
		//echo $id;
		$uri = $this->uri->segment(1)
			."/".$this->uri->segment(2)
			."/".$this->uri->segment(3)
			."/".$this->uri->segment(4);
		$data['uri'] = $uri; 

		$data['info'] = $this->News_data->show_one($id);
		$data['id'] = $id;
		//$data['order_info'] = $this->News_data->show_one($id);
		if(!$this->check_info()){
			if($id<1){
				$this->session->set_userdata('picture_array');
				$data['picture_array']=array();
			}else{
				//清空之前的缓存
				$this->session->unset_userdata('picture_array');
				if($data['info']['pricefilename']!='' && $data['info']['pricefilename']!=NULL){
					$data['picture_array']=explode(',',$data['info']['pricefilename']);
					$this->session->set_userdata('picture_array',explode(',',$data['info']['pricefilename']));
				}
			}
			$this->load->view('admin/news_edit', $data);
		}else{
			$data = array(
				'id'=>$_POST['id'],
				'type'=>$_POST['type'],
				'author' => $_POST['author'],
				'source' => $_POST['source'],
				'title' => $_POST['title'],
				'content' => $_POST['content'],
				'createTime' => $_POST['createTime'],
				'createid' => $_POST['createid'],
				'isfirst' => empty($_POST['isfirst'])?0:$_POST['isfirst'],
				'isbest' => empty($_POST['isbest'])?0:$_POST['isbest']
			);

			if(!($this->session->userdata('picture_array')===FALSE)){
   				$temp=$this->session->userdata('picture_array');  
				$pricefilename='';
				if($this->session->userdata('picture_array')!=FALSE && $temp!=''){
					foreach($temp as $k=>$onepricefilename){
						if($pricefilename!=''){
							$pricefilename.=',';
						}
						$pricefilename.=$onepricefilename;
					}
					$data['pricefilename']=$pricefilename;
				}
		//	$this->session->unset_userdata('picture_array');
   			}   
			//第一次修改时
			if($data['id'] <1){
				$data['createid'] = $this->session->userdata('user_id');

			}
			if ($data['id']>=1){
				$data['info'] = $this->News_data->update($data, $_POST['id']);

				$data['saveinfo'] = "新闻修改保存成功！";
			}else {
				$data['info'] = $this->News_data->insert($data);
				$data['saveinfo'] = "新闻新增成功！";
				
			}

			//保存之后清空缓存
		//	$this->session->unset_userdata('picture_array');

			$data = self::initBaseinfo($data);
				$uri = $this->uri->segment(1)
				."/".$this->uri->segment(2)
				."/".$this->uri->segment(3)
				."/".$this->uri->segment(4);
				$data['uri'] = $uri;
				$data['picture_array']=$this->session->userdata('picture_array');

				$this->load->view('admin/news_edit', $data);
			//redirect($this->config->item('base_url').$uri);
			
		}
		
	}
	
	function check_info(){
            $this->load->helper(array('form','url'));
	     	$this->load->library('form_validation');
	     	$this->form_validation->set_rules('title', '标题','required|callback_login_account_check');
	     	$this->form_validation->set_rules('content', '内容','required|callback_login_account_check');
		//$this->form_validation->set_rules('organization','Organization','required');	
		    return $this->form_validation->run();
	}
	
		
	function search($offset = ''){
		$condition["cdt_name"] = $_GET['cdt_name'];
		self::get_list($offset, $condition);
	}
	
	function delete(){
		$id = $_GET['id'];
		$this->News_data->delete($id);
		self::index();
	}

	//上传图片
	function upload_picture(){
		$config['upload_path'] = './upload/uploadimages/';
  		$config['allowed_types'] = 'gif|jpg|png';
  		$config['max_size'] = '2000';
  		//$config['max_width']  = '1024';
  		//$config['max_height']  = '768';
  		$config['overwrite'] = FALSE;
  		$config['remove_spaces'] = TRUE;
  		$config['encrypt_name']=true;
  
		$this->load->library('upload', $config);
		$field_name = "picture_file";
		//upload failed
  		if (!$this->upload->do_upload($field_name))
  		{
			$error = array('error' => $this->upload->display_errors());
			$error_str = "";
			foreach($error as $key=>$value){
				$error_str.= $value.".";
			}
			echo '<head>';
			echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
   			echo "<script>alert('$error_str')</script>";
   			
			echo '</head>';
  		} 
  		else //upload success
  		{
   			$upload_data = $this->upload->data();
   			if($this->session->userdata('picture_array')==FALSE){
   				$temp=array();
   				array_push($temp,$upload_data['file_name']);
   				$this->session->set_userdata('picture_array',$temp);
   			}else{
   				$temp=$this->session->userdata('picture_array');   				
   				array_push($temp,$upload_data['file_name']);
   				$this->session->set_userdata('picture_array',$temp);
   			}   
			if($_POST['id']>0){
   				$temp=$this->session->userdata('picture_array');  
				$pricefilename='';
   				foreach($temp as $k=>$onepricefilename){
					if($pricefilename!=''){
						$pricefilename.=',';
					}
					$pricefilename.=$onepricefilename;
				}
				$data['pricefilename ']=$pricefilename;
				$this->News_data->update($data, $_POST['id']);
			}
  		}
	}	
	

	//显示图片
	function get_picture(){
		$data['id'] = $_POST['id'];		
		$data['base'] = $this->config->item('base_url');		
		$data['picture_array']=$this->session->userdata('picture_array');
	
   		$this->load->view('admin/related_picture_default',$data);
	}	
	//delete picture
	function delete_picture(){
		$key=$this->input->get('key',TRUE);
   		$temp=$this->session->userdata('picture_array');   				
   		unset($temp[$key]);
   		$this->session->set_userdata('picture_array',$temp);
			if($_GET['id']>0){
   				$temp=$this->session->userdata('picture_array');  
				$pricefilename='';
   				foreach($temp as $k=>$onepricefilename){
					if($pricefilename!=''){
						$pricefilename.=',';
					}
					$pricefilename.=$onepricefilename;
				}
				$data['pricefilename ']=$pricefilename;
				$this->News_data->update($data, $_GET['id']);
			}
			
		$data['id'] = $_GET['id'];		

		$data['base'] = $this->config->item('base_url');		
		$data['picture_array']=$this->session->userdata('picture_array');
   		$this->load->view('admin/related_picture_default',$data);
	}
}

?>