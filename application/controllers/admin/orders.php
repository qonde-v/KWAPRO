<?php
class Orders extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->helper('form','url');
		$this->load->database();
		$this->load->library('session');
		$this->load->library('table');
		$this->load->library('pagination');
		
		$this->load->model('q2a/Auth');
		$this->load->model('admin/Core_user');
		$this->load->model('admin/Core_order');
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
		
		$data['total_num'] = $this->Core_order->get_count($createid, $condition, $pid);
		
		$list = $this->Core_order->show_all($createid, $condition, $pid, $limit, $per_page);
		
		
		$data['list'] = $list;
		if($condition != "" && $condition['cdt_name'] != '')
			$data["cdt_name"] = $condition['cdt_name'];
		else 
			$data["cdt_name"] = "";
		
		$arr_status = $this->Core_order->get_status();
		$data['arr_status'] = $arr_status;


		$arr_factory = $this->Core_order->get_factory();
		$data['arr_factory'] = $arr_factory;

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
		$this->load->view('admin/order_list', $data);
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

		$data['info'] = $this->Core_factory->show_one($id);
				
		if(!$this->check_info()){
			$this->load->view('admin/factory_edit', $data);
		}else{
			$data = array(
				'id'=>$_POST['id'],
				'name' => $_POST['name'],
				'address' => $_POST['address'],
				'tel' => $_POST['tel'],
				'contacts' => $_POST['contacts'],
				'business' => $_POST['business']
			);
			

			if ($data['id']>=1){
				$data['info'] = $this->Core_factory->update($data, $_POST['id']);
				$data['saveinfo'] = "信息保存成功！";
				
			}else {
				$data['info'] = $this->Core_factory->insert($data);
				$data['saveinfo'] = "信息新增成功！";
				
			}
			$data = self::initBaseinfo($data);
				$uri = $this->uri->segment(1)
				."/".$this->uri->segment(2)
				."/".$this->uri->segment(3);
				if($this->uri->segment(4) != '')
					$uri.="/".$this->uri->segment(4);
				$data['uri'] = $uri;
				$this->load->view('admin/factory_edit', $data);
		}
	}
	
	function check_info(){
            $this->load->helper(array('form','url'));
	     	$this->load->library('form_validation');
	     	$this->form_validation->set_rules('name', '厂家名称','required');
	     	$this->form_validation->set_rules('tel', '联系电话','required');
			$this->form_validation->set_rules('contacts','联系人','required');	
		    return $this->form_validation->run();
	}
	
		
	function search($offset = ''){
		$condition["cdt_name"] = $_GET['cdt_name'];
		$pid = isset($_GET["createid"])? $_GET["createid"]:"";
		self::get_list($offset, $condition,$pid);
	}
	function delete(){
		$id = $_GET['id'];
		$this->Core_order->delete($id);
		self::index();
	}
	function set_status(){
		$id = $_GET['id'];
		$status = $_GET['status'];
		$data = array('status'=>$status);
		if($status==1){
			$data['confirmtime'] = date('Y-m-d H:i:s', time()+8*60*60);
			$data['operator'] = $this->session->userdata('userCode');
		}
		if($status==3)$data['completetime'] = date('Y-m-d H:i:s', time()+8*60*60);
		if($status==4)$data['posttime'] = date('Y-m-d H:i:s', time()+8*60*60);
		if($status==5)$data['committime'] = date('Y-m-d H:i:s', time()+8*60*60);
		$this->Core_order->update($data,$id);
		self::index();
	}
	function set_status1(){
		$id = $_POST['id'];print_r($_POST);
		$status = $_POST['status'];
		$data = array('status'=>$status);
		$data['factory_id'] = $_POST['factory_id'];
		$this->Core_order->update($data,$id);
		self::index();
	}
}

?>