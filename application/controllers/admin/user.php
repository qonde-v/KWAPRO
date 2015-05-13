<?php
class User extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->helper('form','url');
		$this->load->database();
		$this->load->library('session');
		$this->load->library('table');
		$this->load->library('pagination');
		
		$this->load->model('q2a/Auth');
		$this->load->model('admin/Core_user');
	}
	
	protected function initBaseinfo($data){
		$data['base'] = $this->config->item('base_url');
		$this->Auth->permission_check($data['base'].'admin/login','MainSite');
		$data['login'] = "login";
		$roleId = $this->session->userdata('roleId');
		$data['roleId'] = $roleId;
		$data['user_id'] = $this->session->userdata('user_id');
		$data['nickname']=$this->Core_user->getNicknameById($data['user_id']);
		return $data;
	}
	
	public function index($offset = ''){
		$data = array();
		$data = self::initBaseinfo($data);
		if($data['roleId']==1){
			self::get_list($offset, "", "");
		}else{
		$this->load->view('admin/no_show', $data);
		}
	}
	
	//列表页显示（查询页面）
	function get_list($offset, $condition, $pid){
		$data = array();
		$limit = 20;
		
		//$limit = $data['total_num'];
		$data = self::initBaseinfo($data);
		
		$per_page = isset($_GET["per_page"])? $_GET["per_page"]:0;
		$roleId = $this->session->userdata('roleId');
		$createid = $roleId == 1 ? "" :$this->session->userdata('user_id');
		
		$data['total_num'] = $this->Core_user->get_count($createid, $condition, $pid);
		
		$list = $this->Core_user->show_all($createid, $condition, $pid, $limit, $per_page);
		
		
		$data['list'] = $list;
		if($condition != "" && $condition['cdt_name'] != '')
			$data["cdt_name"] = $condition['cdt_name'];
		else 
			$data["cdt_name"] = "";
		
		$uri = $this->uri->segment(1);
		$uri = $uri."/".$this->uri->segment(2);
		if($this->uri->segment(3) != ""){
			$uri = $uri."/".$this->uri->segment(3);
		}
		
		$base_url = $data['base'].$uri."?per_page=".$per_page;
		$base_url = $base_url."&cdt_name=".(isset($_GET['cdt_name'])?$_GET['cdt_name'] : '');
//		echo "pid=".$pid;
		$data['createid'] = $pid;	
		
		
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
		$this->load->view('admin/user_list', $data);
	}
		
	public function edit(){
		$data = array();
		$data = self::initBaseinfo($data);
		
		$id = isset($_GET["createid"])?$_GET["createid"]:"";
		//echo $id;
		$uri = $this->uri->segment(1)
			."/".$this->uri->segment(2)
			."/".$this->uri->segment(3);
		if($this->uri->segment(4) != '')
			$uri.="/".$this->uri->segment(4);
		$data['uri'] = $uri."?createid=".$id;

		$data['info'] = $this->Core_user->show_one($id);
				
		if(!$this->check_info()){
			$this->load->view('admin/user_edit', $data);
		}elseif($this->Core_user->getIdByUserCode($_POST['userCode'])!='' && $_POST['id']<1){
			$data['saveinfo'] = "用户名已存在";
			$this->load->view('admin/user_edit', $data);
		}else{
			$data = array(
				'id'=>$_POST['id'],
				'userCode' => $_POST['userCode'],
				'nickname' => $_POST['nickname'],
				'roleId' => $_POST['roleId']
			);
			

			if ($data['id']>=1){
				$data['info'] = $this->Core_user->update($data, $_POST['id']);
				$data['saveinfo'] = "信息保存成功！";
				
			}else {
				$data['pwd']='123456';
				$data['info'] = $this->Core_user->insert($data);
				$data['saveinfo'] = "信息新增成功！";
				
			}
			$data = self::initBaseinfo($data);
				$uri = $this->uri->segment(1)
				."/".$this->uri->segment(2)
				."/".$this->uri->segment(3);
				if($this->uri->segment(4) != '')
					$uri.="/".$this->uri->segment(4);
				$data['uri'] = $uri;
				$this->load->view('admin/user_edit', $data);
		}
	}


	public function fixPwd(){
		$data = array();
		$data = self::initBaseinfo($data);
		
		$oid = isset($_GET["createid"])?$_GET["createid"]:"";
		//echo $id;
		$uri = $this->uri->segment(1)
			."/".$this->uri->segment(2)
			."/".$this->uri->segment(3);
		if($this->uri->segment(4) != '')
			$uri.="/".$this->uri->segment(4);
		$data['uri'] = $uri."?createid=".$oid;

		$data['info'] = $this->Core_user->show_one($oid);
				
		if(!$this->check_info2()){
			$this->load->view('admin/user_fixpwd', $data);
		}else{
			$data = array(
				'id'=>$_POST['id'],
				'userCode' => $_POST['userCode'],
				'pwd' => md5($_POST['pwd2']),
				'nickname' => $_POST['nickname']
			);
			
			if ('' != $data['id']){
				$data['info'] = $this->Core_user->update($data, $_POST['id']);
				$data['saveinfo'] = "密码修改成功！";
				
			}
			$data = self::initBaseinfo($data);
				$uri = $this->uri->segment(1)
				."/".$this->uri->segment(2)
				."/".$this->uri->segment(3);
				if($this->uri->segment(4) != '')
					$uri.="/".$this->uri->segment(4);
				$data['uri'] = $uri;
				$this->load->view('admin/user_fixpwd', $data);
		}
	}
	
	function check_info2(){
            $this->load->helper(array('form','url'));
	     	$this->load->library('form_validation');
	     	$this->form_validation->set_rules('pwd2', '密码','required|callback_check_info_process');
		//$this->form_validation->set_rules('organization','Organization','required');	
		    return $this->form_validation->run();
	}
	
	function check_info(){
            $this->load->helper(array('form','url'));
	     	$this->load->library('form_validation');
	     	$this->form_validation->set_rules('nickname', '昵称','required');
//	     	$this->form_validation->set_rules('tel', '联系电话','required|callback_login_account_check');
		//$this->form_validation->set_rules('organization','Organization','required');	
		    return $this->form_validation->run();
	}
	
	function check_info_process2(){
		if($_POST['pwd1']!=$_POST['pwd2']){
			$this->form_validation->set_message('check_info_process', '两次密码输入不一致');
		    return false;
		}else {
			return true;
		}
	}
		
	function search($offset = ''){
		$condition["cdt_name"] = $_GET['cdt_name'];
		$pid = isset($_GET["createid"])? $_GET["createid"]:"";
		self::get_list($offset, $condition,$pid);
	}
	function delete(){
		$id = $_GET['id'];
		$this->Core_user->delete($id);
		self::index();
	}
	
		
}

?>