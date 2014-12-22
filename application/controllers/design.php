<?php
ini_set("memory_limit","100M");
  class Design extends CI_Controller
  {
	   var $pre_msg_num=5;
    function __construct()
	 {
	    parent::__construct();
		 $this->load->helper('url');
		 $this->load->helper('define');
		 $this->load->helper('kpc_define');

		 $this->load->database();
		 $this->load->library('security');
		 $this->load->library('session');
		 $this->load->model('q2a/User_activity');
		 $this->load->model('q2a/Auth');
		 $this->load->library('account_format_check');

         $this->load->model('q2a/User_profile');
		$this->load->model('q2a/User_data');
		$this->load->model('q2a/Photo_upload');
		 $this->load->model('q2a/Right_nav_data');
		 $this->load->model('q2a/Invite_data_process');
         $this->load->model('q2a/Load_common_label');
		 $this->load->model('q2a/Check_process');
		 $this->load->model('q2a/Friend_manage');
		 $this->load->model('q2a/Kpc_manage');
         $this->load->model('q2a/Ip_location');
         $this->load->model('q2a/User_privacy');
		 $this->load->model('q2a/Demand_management');
	 }

	function index()
	{
	   //$this->output->cache(1);
	   $base = $this->config->item('base_url');

	   //login permission check
	   $this->Auth->permission_check("login/");

	   //get current login user id
	   $user_id = $this->session->userdata('uId');

	   $language = $this->Ip_location->get_language();

	   $data = array('base'=>$base);
	   if($user_id!='')$data['login'] = "login";

	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
	   $data = array_merge($right_data,$data);

	   //get designs for user 
		$designs=array();;
		$pre_msg_num = $this->pre_msg_num;
	    $range = array('start'=>0,'end'=>$pre_msg_num-1);
		$this->db->select('id,title,viewnum,messnum,status,createdate');
		$this->db->where('uId',$user_id);
		$t_query=$this->db->get('design');
		$data['inbox_num']=	$t_query->num_rows();

		$this->db->order_by('createdate','desc');
		$this->db->where('uId',$user_id);
		$this->db->limit($range['end']-$range['start']+1,$range['start']);
		$query = $this->db->get('design');
		foreach($query->result_array() as $row)
		{
			array_push($designs,$row);
		}
		$data['designs'] = $designs;
		$data['pre_msg_num'] = $this->pre_msg_num;
		$data['inbox_page_num'] = ($data['inbox_num'] == 0) ? 1 : ceil($data['inbox_num']/$data['pre_msg_num']);

	   $this->load->view('q2a/design',$data);

	}

	function practice()
	{
	   //$this->output->cache(1);
	   $base = $this->config->item('base_url');
	   $base_photoupload_path = $this->config->item('base_photoupload_path');

	   //login permission check
	   $this->Auth->permission_check("login/");

	   //get current login user id
	   $user_id = $this->session->userdata('uId');

	   $data = array('base'=>$base,'base_photoupload_path'=>$base_photoupload_path);
	   $data['login'] = "login";
		
		//get demand
	   $result=array();
	   $result=$this->Demand_management->get_user_demand($_GET['id']);
	   foreach($result as $val){
		   $data['demand']=$val;
	   }

	   // get similar templet
	   $condition='';
	   $arr_de=$data['demand'];
	   if(!empty($arr_de)){
			$condition=array('id'=>$arr_de['id'],'strength'=>$arr_de['strength'],'sporttime'=>$arr_de['sporttime'],'temperature'=>$arr_de['temperature'],'humidity'=>$arr_de['humidity'],'proficiency'=>$arr_de['proficiency'],'age'=>$arr_de['age'],'weight'=>$arr_de['weight']);
		   $result_s=array();
		   $result_s=$this->Demand_management->get_similar_data($condition);
		   foreach($result_s as $val){
			   $data['similar']=$val;
		   }
		}


		//get design Pictures
		$design_pic = array();
		$this->db->select('*');
		$query = $this->db->get('design_pic');
		foreach($query->result_array() as $val)
		{
			array_push($design_pic,$val);
		}		
		$data['design_pic']=$design_pic;

		//get fabrics
		$fabric = array();
		$this->db->select('*');
		$this->db->limit(7,0);
		$query = $this->db->get('fabric');
		foreach($query->result_array() as $val)
		{
			array_push($fabric,$val);
		}		
		$data['fabric']=$fabric;

	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
	   $data = array_merge($right_data,$data);


	   $this->load->view('q2a/practice',$data);

	}
	
	function sort_design()
	{

		$base = $this->config->item('base_url');
		$user_id = $this->session->userdata('uId');
		$index = $this->input->post('index',TRUE);
		$pre_num = $this->pre_msg_num;
		$range = array('start'=>($index-1)*$pre_num, 'end'=>$index*$pre_num-1);
		$data = array('uId'=>$user_id,'range'=>$range);

		$designs=array();
		$this->db->select('*');
		$this->db->where('uId',$user_id);
		$this->db->order_by('createdate','desc');
		$this->db->limit($range['end']-$range['start']+1,$range['start']);
		$query = $this->db->get('design');
		foreach($query->result_array() as $row)
		{
			array_push($designs,$row);
		}

		$html = '';
		if(!empty($designs))
		{
			$i=0;
			$html .= '<ul class="main-list">';
			foreach($designs as $item){
				$i++;
				$html .= '	<li>';
				$html .= '		<a href="'.$base.'design/design_detail?id='.$item['id'].'" class="title">'. $i.'、'.$item['title'].'</a>';
				$html .= '		<div class="btns">';
				if($item['status']==0){
					$html .= '<a href="#" onclick="javascript:subsim('.$item['id'].','.$item['demand_id'].')" >提交仿真</a>';
				}elseif($item['status']==1){
					$html .= '<a href="#" class="black" >等待仿真</a>';
				}elseif($item['status']==2){
					$html .= '<a href="'.$base.'design/similar_detail" class="black">查看仿真</a>';
				}
				$html .= '		<a href="'.$base.'design/order?id='.$item['id'].'">提交订单</a>';
				$html .= '		</div>';
				$html .= '		<p><span class="link link-liulan">浏览（'.$item['viewnum'].'）</span><span class="link link-liuyan">留言（'.$item['messnum'].'）</span><span class="pull-right">发布于'.$item['createdate'].'</span></p>';
				$html .= '	</li>';
			}
			$html .= '</ul>';
		}
		echo $html;

	}


	function design_detail()
	{
	   //$this->output->cache(1);
	   $base = $this->config->item('base_url');
	   $base_photoupload_path = $this->config->item('base_photoupload_path');
		$design_id = $_GET['id'];

		$tmp=$this->session->userdata('ds'.$design_id);
		if($tmp==''){
			//session
			$tmpsess=array();
			$tmpsess=$this->session->userdata;
			$tmpsess['ds'.$design_id]=1;
			$this->session->set_userdata($tmpsess,'');
			//浏览量+1
			$this->Demand_management->update_viewnum($design_id,2);
		}

	   //login permission check
	   //$this->Auth->permission_check("login/");

	   //get current login user id
	   $user_id = $this->session->userdata('uId');

	   $data = array('base'=>$base,'base_photoupload_path'=>$base_photoupload_path);
	   if($user_id!='')$data['login'] = "login";

	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
	   $data = array_merge($right_data,$data);
		
	   $result=array();
	   
		$this->db->select('*');
		$this->db->where('id',$design_id);
		$query = $this->db->get('design');
		$result = array();
		if($query->num_rows() > 0)
		{
			foreach($query->result_array() as $row)
			{
				array_push($result,$row);
			}
		}
	   foreach($result as $val){
		   $data['design']=$val;
	   }


	    
		$result_s=array();		
		if($data['design']['fabric']>0){
			$result_s=$this->Demand_management->get_fabric($data['design']['fabric']);
			foreach($result_s as $val){
			   $data['fabric']=$val;
			}
		}else{
			$this->db->select('*');
			$this->db->where('design_id',$design_id);
			$query = $this->db->get('design_pic');
			$res = array();
			if($query->num_rows() > 0)
			{
				foreach($query->result_array() as $row)
				{
					$result_s=$this->Demand_management->get_fabric($row['fabric']);
					foreach($result_s as $val){
					   $row['fabric']=$val;
					}
					array_push($res,$row);
				}
			}		
			$data['design_pic']=$res;
		}
		
		$result_d=array();
		$result_d=$this->Demand_management->get_user_demand($data['design']['demand_id']);
		foreach($result_d as $val){
			  $data['demand']=$val;
		}


		//get messagelist
	    $condition = array('uId'=>$data['demand']['uId'],'related_id'=>$design_id,'p_md_Id'=>0,'sort_attr'=>'time','sort_type'=>0,'type'=>2);
	    $message_data = $this->Message_management->get_related_messages($condition);

		$message = array();
		//get second messagelist
		foreach($message_data as $val){
			$con = array('uId'=>$val['from_uId'],'related_id'=>$design_id,'p_md_Id'=>$val['md_Id'],'sort_attr'=>'time','sort_type'=>0,'type'=>2);
			$sec_data = $this->Message_management->get_related_messages($con);
			if(!empty($sec_data)){
				$val['sec_data'] = $sec_data;
			}else{
				$val['sec_data'] =array();
			}
			array_push($message,$val);
		}
	    $data['message_data'] = $message;


		$this->load->view('q2a/design_detail',$data);
	}


	function save_pic()
	 {
	 	if($this->Auth->request_access_check())
		{
			$post_arr = array();
			foreach($_POST as $key => $value)
			{
				$post_value = $this->input->post($key);
				$post_arr[$key] = $post_value;
			}
			

			$scale = 1;
			$base = $this->config->item('base_url');
			$base_photoupload_path = $this->config->item('base_photoupload_path');
			$user_id = $this->session->userdata('uId');
			
			if($_GET['type']==1){
				$msg = $this->Photo_upload->user_photo_upload(array('user_id'=>$user_id, 'file_id'=>'f_design'));
			}elseif($_GET['type']==2){
				$msg = $this->Photo_upload->user_photo_upload(array('user_id'=>$user_id, 'file_id'=>'f_effect'));
			}elseif($_GET['type']==3){
				$msg = $this->Photo_upload->user_photo_upload(array('user_id'=>$user_id, 'file_id'=>'f_detail'));
			}
			if(UPDATE_SUCCESS == $msg['msg'])
			{
				/*if($_GET['type']==1){
					$file_name = $this->security->sanitize_filename($_FILES['f_design']['name']);
				}elseif($_GET['type']==2){
					$file_name = $this->security->sanitize_filename($_FILES['f_effect']['name']);
				}elseif($_GET['type']==3){
					$file_name = $this->security->sanitize_filename($_FILES['f_detail']['name']);
				}*/

				$file_name = $msg['file_name'];

				 $img_src = $base.$base_photoupload_path.'temp/'.$file_name;

				
				/*$save_thumb_path = "./".$base_photoupload_path.$user_id."/".$post_arr['filename'];
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
				echo $user_photo_path."##".$msg;*/
				if($_GET['type']==1){
					echo "<img id=\"design_img\" width=50 height=50 border=\"1\" style=\"display:\" src=\"".$img_src."\"/>";
				}elseif($_GET['type']==2){
					echo "<img id=\"effect_img\" width=50 height=50 border=\"1\" style=\"display:\" src=\"".$img_src."\"/>";
				}elseif($_GET['type']==3){
					echo "<img id=\"detail_img\" width=100 height=100 border=\"1\" style=\"display:none\" src=\"".$img_src."\"/>";
				}
				
			}
			else
			  {
				echo $this->Check_process->get_prompt_msg(array('pre'=>'design','code'=> $msg));
			  }
		}
	 }


	function designok()
	{
		$post_arr = array();
		$pic_arr = array();
		
		foreach($_POST as $key=>$value)
		{
			$post_value = $this->input->post($key,TRUE);
			if(substr($key,0,4)=='crop'){
				$pic_arr[substr($key,strlen($key)-1,1)][substr($key,0,strlen($key)-1)] = $post_value ? $post_value : 0;
			}else{
				$post_arr[$key] = $post_value ? $post_value : 0;
			}
		}
		$post_arr['title'] = str_replace("\n","<BR/>",$post_arr['title']);
		if($this->Demand_management->design_title_exist($post_arr['title'])){
			echo '1';return;
		}
		$post_arr['createdate'] = date("Y-m-d H:i:s", time());
		$userid=$this->session->userdata('uId');
		$username = $this->User_data->get_username(array('uId'=>$userid));
		$post_arr['uId'] = $userid;
		$post_arr['username'] = $username;
	
		$design_id=$this->Demand_management->design_record_insert($post_arr);
		
		foreach($pic_arr as $val)
		{ 
			$picdata = array();
			$picdata['design_id']=$design_id;
			$picdata['createdate'] = date("Y-m-d H:i:s", time());
			$picdata['pic_url']=$val['crop_photo'];
			$picdata['name']=$val['crop_name'];
			$picdata['fabric']=$val['crop_fabric'];
			$this->Demand_management->designpic_record_insert($picdata);
		}
		//update designnum
		$this->Demand_management->update_designnum($post_arr['demand_id']);

		//给需求发布者发送提醒
		$result_d=array();
		$result_d=$this->Demand_management->get_user_demand($post_arr['demand_id']);
		foreach($result_d as $val){
			  $demand=$val;
		}
		$data = array();
		$data['uId'] = $userid;
		$data['username'] = $username;
		$data['type'] = 1;
		$data['createdate'] = date("Y-m-d H:i:s", time());
		$data['to_uId'] = $demand['uId'];
		$data['title'] = $demand['title'];
		$data['relateid'] = $design_id;
		$this->Demand_management->information_record_insert($data);

		
		$base = $this->config->item('base_url');
		$base_photoupload_path = $this->config->item('base_photoupload_path');

		// get similar templet
	   $condition='';
	   $condition=array('strength'=>$demand['strength'],'sporttime'=>$demand['sporttime'],'temperature'=>$demand['temperature'],'humidity'=>$demand['humidity'],'proficiency'=>$demand['proficiency'],'age'=>$demand['age'],'weight'=>$demand['weight']);
	   $result_s=array();
	   $result_s=$this->Demand_management->get_similar_design($condition);
	   

		$html="";
		$html .= '<div class="submin-info">';
        $html .= '    	<img src="'.$base.'img/wc_xtb.png" />';
        $html .= '        <strong>成功</strong>';
        $html .= '        <span> </span><span>提交时间：'.$data['createdate'].'</span>';
        $html .= '        <p>详细情况请点击：<a id="d_url" href="'.$base.'design/design_detail?id='.$design_id.'" >查看详情</a></p>';
        $html .= '    </div>';
        $html .= '    <div class="other_title">相关设计产品</div>';
        $html .= '    <ul class="others">';
		foreach($result_s as $item){
            	 $html .= '<li><a href="'.$base.'design/design_detail?id='.$item['id'].'"><img width="130" height="107" src="'.$base.$base_photoupload_path.'temp/'.$item['design_pic'].'" /></a></li>';
	   }
        $html .= '    </ul>';

		echo $html;

	}

	function subsim()
	{
		$user_id = $this->session->userdata('uId');
		$design_id = $_POST['design_id'];
		$demand_id = $_POST['demand_id'];
		$result_d=array();
		$result_d=$this->Demand_management->get_user_demand($demand_id);
		foreach($result_d as $val){
			  $demand=$val;
		}
		//print_r($demand);
		if($demand['target']=='女')$sex=1;else $sex=0;

		//////////////强度////////
		$type=$demand['type'];
		if($type=='步行' || $type='高尔夫' || $type=='钓鱼'){
			$intensity=1;
		}elseif($type=='羽毛球 网球 乒乓球' || $type=='水上运动' || $type=='自行车运动' || $type=='轮滑运动' || $type=='马术' || $type=='狩猎' || $type=='目标运动'){
			$intensity=3;
		}elseif($type=='户外山地运动' || $type='健身' || $type=='跑步' || $type=='游泳' || $type=='篮球 足球 排球' || $type=='篮球 足球 排球'){
			$intensity=5;
		}else{
			$intensity=0;
		}
		//////////////BMR///////
		$age=$demand['age'];
		$weight=$demand['weight'];
		if($age>=7 && $age<=9){if($sex==0)$BMR=0.0295;else $BMR=0.0279;}
		elseif($age>=10 && $age<=12){if($sex==0)$BMR=0.0244;else $BMR=0.0231;}
		elseif($age>=13 && $age<=15){if($sex==0)$BMR=0.0205;else $BMR=0.0194;}
		elseif($age>=16 && $age<=19){if($sex==0)$BMR=0.0183;else $BMR=0.0168;}
		elseif($age>=20 && $age<=24){if($sex==0)$BMR=0.0167;else $BMR=0.0162;}
		elseif($age>=25 && $age<=34){if($sex==0)$BMR=0.0159;else $BMR=0.0153;}
		elseif($age>=35 && $age<=54){if($sex==0)$BMR=0.0154;else $BMR=0.0147;}
		elseif($age>=55 && $age<=69){if($sex==0)$BMR=0.0151;else $BMR=0.0144;}
		elseif($age>=70){if($sex==0)$BMR=0.0145;else $BMR=0.0144;}
		else $BMR=0;

		$MetRate=$BMR*60*$demand['weight']*$intensity*$demand['strength'] ;  //MetRate=BMR*60  *  体重  *  强度

		///////////////风速///////////
		$weather=$demand['weather'];
		if($weather=='下雨')$windspeed = 2;
		elseif($weather=='刮风')$windspeed = 10;
		elseif($weather=='晴天')$windspeed = 5;
		elseif($weather=='下雪')$windspeed = 2;
		elseif($weather=='小雪转多云')$windspeed = 3;
		elseif($weather=='小雨转阴')$windspeed = 3;
		elseif($weather=='雨夹雪')$windspeed = 4;
		elseif($weather=='阴天')$windspeed = 3;
		else $windspeed = 0;
         
		 
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$xml .= "<SimPlan>\n";
		$xml .= "	<SimPlanID>".$design_id.$user_id."</SimPlanID><!-- ID  用户编号 + 设计编号 -->\n";
		$xml .= "	<BodySet>\n";
		$xml .= "		<MetRate>".$MetRate."</MetRate>  <!-- 代谢率 -->\n";
		$xml .= "		<Sex>".$sex."</Sex> <!-- 性别 0 男  1 女 -->\n";
		$xml .= "		<Age>".$age."</Age> <!-- 年龄 -->\n";
		$xml .= "		<Weight>".$weight."</Weight> <!-- 体重 -->\n";
		$xml .= "	</BodySet>\n";
		$xml .= "	<FabricSet> <!-- 这个节点是衣服原料的参数，等数据库的表整好了再做，暂时不用改就用这些参数 -->\n";
		$xml .= "		<LayerCount>1</LayerCount>\n";
		$xml .= "		<Layer>\n";
		$xml .= "			<FabricID>1</FabricID>\n";
		$xml .= "			<M0mtype>0</M0mtype>\n";
		$xml .= "			<M1mtype>0</M1mtype>\n";
		$xml .= "			<InnerIsContact>0</InnerIsContact>\n";
		$xml .= "			<OuterIsContact>1</OuterIsContact>\n";
		$xml .= "			<Thickness>0.0980</Thickness>\n";
		$xml .= "		</Layer>\n";
		$xml .= "	</FabricSet>\n";
		$xml .= "	<EnvSet>\n";
		$xml .= "		<EnvTem>".$demand['temperature']."</EnvTem> <!-- 温度 -->\n";
		$xml .= "		<EnvRH>".$demand['humidity']."</EnvRH><!-- 湿度 -->\n";
		$xml .= "		<EnvWind>".$windspeed."</EnvWind><!-- 风速 -->\n";
		$xml .= "	</EnvSet>\n";
		$xml .= "	<SimSet> <!-- 仿真计算参数，不用改就用这些参数 -->\n";
		$xml .= "		<SimTime>20.00</SimTime>\n";
		$xml .= "		<TimeStep>1.0000</TimeStep>\n";
		$xml .= "		<DiscreteLimit>0.0186</DiscreteLimit>\n";
		$xml .= "		<SaveFrequence>1.00</SaveFrequence>\n";
		$xml .= "	</SimSet>\n";
		$xml .= "</SimPlan>\n";
		//echo $xml;       
		
		//更新设计状态为等待仿真
		$this->Demand_management->update_designstatus($design_id,1);
		
		$filename = "c:\wamp\Apache2\cgi-bin\SP".$user_id.$design_id.".xml";
		$f_name="SP".$user_id.$design_id.".xml";

		$of = fopen($filename,'w');//创建并打开
		if($of){
		 fwrite($of,$xml);//把执行文件的结果写入
		}
		fclose($of);

		echo $f_name;


	}

	function similar_detail()
	{
		//$this->output->cache(1);
	   $base = $this->config->item('base_url');
	   $base_photoupload_path = $this->config->item('base_photoupload_path');

	   //login permission check
	   $this->Auth->permission_check("login/");

	   //get current login user id
	   $user_id = $this->session->userdata('uId');

	   $language = $this->Ip_location->get_language();

	   $data = array('base'=>$base,'base_photoupload_path'=>$base_photoupload_path);
	   if($user_id!='')$data['login'] = "login";

	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
	   $data = array_merge($right_data,$data);
		

		//处理舒适度DAT文件 取后三列
	   $data['ComfortEvaluationRes']=$base."SimResult/ComfortEvaluationRes.DAT";
	   /*$content = trim(file_get_contents($data['ComfortEvaluationRes']));
	   $arr = explode("\n", $content);
	   $newcontent = "";
	   foreach ($arr as $v) {
			$tmp = explode("	", $v);
			if(count($tmp)>4)$newcontent .= "\n".$tmp[0]."	".$tmp[7]."	".$tmp[8]."	".$tmp[9];
			unset($tmp);
	   }
	   if($newcontent!=''){
		   $newcontent = "date	R_th	R_dp	R_tc".$newcontent;
		   file_put_contents("C:\wamp\www\TIT\SimResult\ComfortEvaluationRes.DAT",$newcontent);
	   }*/
	   


	   //处理皮肤湿度DAT文件
	   $data['SkinWetness']=$base."SimResult/SkinWetness.DAT";
	   /*$content = trim(file_get_contents($data['SkinWetness']));
	   $arr = explode("\n", $content);
	   $newcontent = "";
	   foreach ($arr as $v) {
			$tmp = explode(" ", $v);
			if(count($tmp)>=2)$newcontent .= "\n".$tmp[0]."	".$tmp[1];
			unset($tmp);
	   }
	   if($newcontent!=''){
		   $newcontent = "date	SkinWetness".$newcontent;
		   file_put_contents("C:\wamp\www\TIT\SimResult\SkinWetness.DAT",$newcontent);
	   }*/


		//处理温度DAT文件
	   $data['Temperature']=$base."SimResult/Temperature.DAT";
	   /*if(!file_exists("C:\wamp\www\TIT\SimResult\Temperature.DAT")){
		   $content = trim(file_get_contents($base."SimResult/CoreTem.DAT"));
		   $content1 = trim(file_get_contents($base."SimResult/SkinTem.DAT"));
		   $arr = explode("\n", $content);
		   $arr1 = explode("\n", $content1);
		   $newcontent = "";
		   foreach ($arr as $key=>$v) {
				$v=preg_replace('/\r|\n/', '', $v);
				$tmp = explode(" ", $v);
				$tmp1 = explode(" ", $arr1[$key]);
				$newcontent .= "\n".$tmp[0]."\t".$tmp[1]."\t".$tmp1[1];
				unset($tmp);
				unset($tmp1);
		   }
		   if($newcontent!=''){
			   $newcontent = "date\tCoreTem\tSkinTem".$newcontent;
			   chmod("C:\wamp\www\TIT\SimResult",0777);
			   file_put_contents("C:\wamp\www\TIT\SimResult\Temperature.DAT",$newcontent);
		   }
	   }*/


	   $this->load->view('q2a/similar_detail',$data);
	}

	function order()
	{
	   //$this->output->cache(1);
	   $base = $this->config->item('base_url');
	   $base_photoupload_path = $this->config->item('base_photoupload_path');

	   //login permission check
	   $this->Auth->permission_check("login/");

	   //get current login user id
	   $user_id = $this->session->userdata('uId');

	   $language = $this->Ip_location->get_language();

	   $data = array('base'=>$base,'base_photoupload_path'=>$base_photoupload_path);
	   if($user_id!='')$data['login'] = "login";

	   $data['design_id']=$_GET['id'];
		
	   $right_data = $this->Right_nav_data->get_rgiht_nav_data($user_id);
	   $data = array_merge($right_data,$data);


	   $this->load->view('q2a/order',$data);

	}

	function submit_order()
	{
		//login permission check
	    $this->Auth->permission_check("login/");

		$post_arr = array();
		foreach($_POST as $key=>$value)
		{
			$post_value = $this->input->post($key,TRUE);
			$post_arr[$key] = $post_value ? $post_value : 0;
		}
		$post_arr['createtime'] = date("Y-m-d H:i:s", time());
		$userid=$this->session->userdata('uId');
		$post_arr['uId'] = $userid;
		$post_arr['username'] = $this->User_data->get_username(array('uId'=>$userid));

		$this->Demand_management->order_record_insert($post_arr);

		echo 'submit order OK';
	}
	

	function getfabric(){
		//get fabrics
		$fabric = array();
		$this->db->select('*');
		$this->db->where('id',$_POST['id']);
		$query = $this->db->get('fabrics');
		foreach($query->result_array() as $val)
		{
			$fabric = $val;
		}print_r($fabric);
		echo $fabric['id'].'||'.$fabric['name'].'||'.$fabric['pic'].'||'.$fabric['description'].'||'.$fabric['feature'];
		

	}


}

 /*End of file*/
  /*Location: ./system/appllication/controller/design.php*/
