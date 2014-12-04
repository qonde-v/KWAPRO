<?php
class Demand extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->helper('form','url');
		$this->load->database();
		$this->load->library('session');
		$this->load->library('table');		
		$this->load->library('pagination');
		
		$this->load->model('Auth');
		$this->load->model('Core_user');
	}
	
	protected function initBaseinfo($data){
		$data['base'] = $this->config->item('base_url');
		$this->Auth->permission_check($data['base']);
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
		$data['total_num'] = $this->Biz_order->get_count($createid, $condition);
		
		$list = $this->Biz_order->show_all($createid, $condition, $limit, $per_page);
		
		foreach ($list as $record) {
			$record->creator = $this->Core_user->getUserCodeById($record->createid);
			$record->product = $this->Biz_product->getNameById($record->productid);
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
		$this->load->view('demand_list', $data);
	}
	
	public function edit(){
		$data = array();
		$data = self::initBaseinfo($data);
		
		$oid = $this->uri->segment(3);
		//echo $id;
		$uri = $this->uri->segment(1)
			."/".$this->uri->segment(2)
			."/".$this->uri->segment(3);
		$data['uri'] = $uri;

		$data['info'] = $this->Biz_order->show_one($oid);
		
		$data['order_info'] = $this->Biz_order->show_one($oid);

		$data['productid_2'] = $this->Biz_product->product_safe();
		$data['sonorders'] = $this->Biz_order->show_son_all($oid);
		if(!$this->check_info()){
			if($oid<1){
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
			$data["car_brands"] = $this->Biz_order->show_car_brand();
			$this->load->view('biz_order_edit', $data);
		}else{
		if(isset ($_POST['nocarnum'])){
			$nocarnum=1;
		}else{
			$nocarnum=0;
		}
			$data = array(
				'oid'=>$_POST['oid'],
				'productid'=>$_POST['productid'],
				'orderno' => $_POST['orderno'],
				'name' => $_POST['name'],
				'idcard' => $_POST['idcard'],
				'tel' => $_POST['tel'],
				'address' => $_POST['address'],
				'bankaccount' => $_POST['bankaccount'],
				'bankname' => $_POST['bankname'],
				'createTime' => $_POST['createTime'],
				'createid' => $_POST['createid'],
				'pricefilename' =>$_POST['pricefilename'],
				'policyno' =>$_POST['policyno'],
				'policycontract' =>$_POST['policycontract'],
				'policyamount' =>$_POST['policyamount'],
				'policyTime' =>$_POST['policyTime'] == null ? '' : date('Y-m-d', strtotime($_POST['policyTime'])),
				'signTime' =>$_POST['signTime'] == null ? '' : date('Y-m-d', strtotime($_POST['signTime'])),
				'expresscompany' =>$_POST['expresscompany'],
				'expressno' =>$_POST['expressno'],
				'expressbackno' =>$_POST['expressbackno'],
				'remark' =>$_POST['remark'],
				'car_num' =>$_POST['car_num'],
				'car_model' =>$_POST['car_model'],
				'car_vin' =>$_POST['car_vin'],
				'car_frame' =>$_POST['car_frame'],
				'car_type' =>$_POST['car_type'],
				'car_engine' =>$_POST['car_engine'],
				'car_passenger' =>$_POST['car_passenger'],
				'car_quality' =>$_POST['car_quality'],
				'car_year' =>$_POST['car_year'],
				'car_addtime' =>$_POST['car_addtime'] == null ? '' : date('Y-m-d', strtotime($_POST['car_addtime'])),
				'car_mileage' =>$_POST['car_mileage'],
				'car_nature' =>$_POST['car_nature'],
				'car_area' =>$_POST['car_area'],
				'car_newmoney' =>$_POST['car_newmoney'],
				'area' =>$_POST['area'],
				'insured' =>$_POST['insured'],
				'insured_idcard' =>$_POST['insured_idcard'],
				'car_name' =>$_POST['car_name'],
				'car_brand' =>$_POST['car_brand'],
				'nocarnum' =>$nocarnum

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
			if($data['oid'] <1){
				$data['createid'] = $this->session->userdata('user_id');

			}
			if ($data['oid']>=1){
				$data['order_info'] = $this->Biz_order->update($data, $_POST['oid']);
				$this->Biz_order->son_delete($_POST['oid']);

				$data['saveinfo'] = "订单修改保存成功！";
			}else {
				$data['order_info'] = $this->Biz_order->insert($data);
				$data['saveinfo'] = "订单新增成功，订单号： ".$data['order_info']['orderno'];
				
			}
				//如果是车险
				if($_POST['productid']==2){
					$productdata=array();
					if(isset($_POST["check"])){ 
						foreach($_POST["check"] as $k=>$u){
							$productdata=array(
								'oid'=>$data['order_info']['oid'],
								'money'=>$_POST['car_money_'.$u],
					//			'num'=>$_POST['car_num_'.$u],
								'pid'=>$u,
							);

							$this->Biz_order->son_insert($productdata);
						}
					}

				}
			//保存之后清空缓存
		//	$this->session->unset_userdata('picture_array');

			$data = self::initBaseinfo($data);
				$uri = $this->uri->segment(1)
				."/".$this->uri->segment(2)
				."/".$this->uri->segment(3);
				$data['uri'] = $uri;
				$data['picture_array']=$this->session->userdata('picture_array');
				$data['productid_2'] = $this->Biz_product->product_safe();
				$data['sonorders'] = $this->Biz_order->show_son_all($data['order_info']['oid']);
				$data["car_brands"] = $this->Biz_order->show_car_brand();

				$this->load->view('biz_order_edit', $data);
			//redirect($this->config->item('base_url').$uri);
			
		}
		
	}
	
	function check_info(){
            $this->load->helper(array('form','url'));
	     	$this->load->library('form_validation');
	     	$this->form_validation->set_rules('name', '姓名','required|callback_login_account_check');
	     	$this->form_validation->set_rules('tel', '联系电话','required|callback_login_account_check');
		//$this->form_validation->set_rules('organization','Organization','required');	
		    return $this->form_validation->run();
	}
	
	function check_info_process(){
		if(//(strcmp($_POST['preSlaughterNum'], '')==0)
			//||(!preg_match('/^\d*$/',$_POST['preSlaughterNum']))
			//||(strcmp($_POST['currentStockNum'], '')==0)
			//||(!preg_match('/^\d*$/',$_POST['currentStockNum']))
			//||(strcmp($_POST['currentCardNum'], '')==0)
			//||(!preg_match('/^\d*$/',$_POST['currentCardNum']))
			(strcmp($_POST['tel'], '')==0)
			||(!preg_match('/^\d*$/',$_POST['tel']))
			//||(strcmp($_POST['personInCharge'], '')==0)
			//||(strcmp($_POST['applySendDate'], '')==0)
			){
			//all information is empty return false
			$this->form_validation->set_message('check_info_process', '填写信息不完整，或信息格式不符，请确认后再提交订单');
			return false;
		}else{
			/*
			$status = $this->Apply_tag->get_status($_POST['id']);
			if ($status > 2){
				$this->form_validation->set_message('check_info_process', '申请已被签收，不能修改');
				return false;
			}*/
		}
	}
		
	function search($offset = ''){
		$condition["cdt_name"] = $_GET['cdt_name'];
		self::get_list($offset, $condition);
	}
	
	function delete(){
		$id = $_GET['oid'];
		$this->Biz_order->delete($id);
		self::index();
	}

	//上传图片
	function upload_picture(){
		$config['upload_path'] = './uploadimages/';
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
			if($_POST['oid']>0){
   				$temp=$this->session->userdata('picture_array');  
				$pricefilename='';
   				foreach($temp as $k=>$onepricefilename){
					if($pricefilename!=''){
						$pricefilename.=',';
					}
					$pricefilename.=$onepricefilename;
				}
				$data['pricefilename ']=$pricefilename;
				$this->Biz_order->update($data, $_POST['oid']);
			}
  		}
	}	
	

	//显示图片
	function get_picture(){
		$data['oid'] = $_POST['oid'];		
		$data['base'] = $this->config->item('base_url');		
		$data['picture_array']=$this->session->userdata('picture_array');
	
   		$this->load->view('related_picture_default',$data);
	}	
	//delete picture
	function delete_picture(){
		$key=$this->input->get('key',TRUE);
   		$temp=$this->session->userdata('picture_array');   				
   		unset($temp[$key]);
   		$this->session->set_userdata('picture_array',$temp);
			if($_GET['oid']>0){
   				$temp=$this->session->userdata('picture_array');  
				$pricefilename='';
   				foreach($temp as $k=>$onepricefilename){
					if($pricefilename!=''){
						$pricefilename.=',';
					}
					$pricefilename.=$onepricefilename;
				}
				$data['pricefilename ']=$pricefilename;
				$this->Biz_order->update($data, $_GET['oid']);
			}
			
		$data['oid'] = $_GET['oid'];		

		$data['base'] = $this->config->item('base_url');		
		$data['picture_array']=$this->session->userdata('picture_array');
   		$this->load->view('related_picture_default',$data);
	}
}

?>