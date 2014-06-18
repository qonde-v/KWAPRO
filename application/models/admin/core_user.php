<?php
class Core_user extends CI_Model {
	private static $TABLE = 'account';
	private static $NO_MANAGER_SQL = ' and roleId = 0 ';
	
	function __construct(){
		parent::__construct();
	}
	
	function login_check($data){
		$this->db->select('id');
		$this->db->where('userCode',$data['userCode']);
		$this->db->where('pwd',$data['pwd']); 
		$query = $this->db->get(self::$TABLE);
		if($query->num_rows() > 0) {
			foreach($query->result() as $row){
				return $row->id;
			}
		} else {
			return '';
		}
	}

		
	function getRoleById($id){
		$this->db->select('roleId');
		$this->db->or_where('id',$id);
		$query=$this->db->get(self::$TABLE);
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				return $row->roleId;
			}
		}
		else{
			return '';
		}
	}


	function getNicknameById($id){
//		$this->db->select('nickname');
//		$this->db->where('wxopenid',$id);
//		$this->db->or_where('oid',$id);
//		$query=$this->db->get(self::$TABLE);
//		if($query->num_rows()>0){
//			foreach($query->result() as $row){
//				return $row->nickname;
//			}
//		}
//		else{
//			return '';
//		}
		return self::__getValueById($id, "nickname");
	}

	private function __getValueById($id, $resultKey){
		$this->db->select($resultKey);
		$this->db->or_where('id',$id);
		$query=$this->db->get(self::$TABLE);
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				return $row->$resultKey;
			}
		}
		else{
			return '';
		}
	}


	
/**
	 * 根据ID获取订单信息
	 * @param $oid id
	 */
	function show_one($oid){
		$this->db->where('oid', $oid);
		$query = $this->db->get(self::$TABLE);
		$data = array(
			'oid'=>'',
			'pwd' => '',
			'userCode' => '',
			'username' => '',
			'wxopenid' => '',
			'pid' => '',
			'nickname' => '',
			'tel' => '',
			'idcard' => '',
			'certification' => '',
			'bankname' => '',
			'bankaccount' => '',
			'wxno' => '',
			'email' => '',
			'address' => '',
			'wxsex' => '',
			'wxcity' => '',
			'wxprovince' => '',
			'createTime' => '',
			'wxcountry' => '',
			'wxheadimgurl' => '',
			'teamcode' => '',
			'teamname' => '',
			'isBred' => '',
			'isSubscribe' => '',
			'roleId' => ''
		);
		if ($query->num_rows() > 0){
			foreach ($query->result() as $row){
				$data = array(
					'oid'=>$row->oid,
					'pwd' => $row->pwd,
					'userCode' => $row->userCode,
					'username' => $row->username,
					'wxopenid' => $row->wxopenid,
					'pid' => $row->pid,
					'nickname' => $row->nickname,
					'tel' => $row->tel,
					'idcard' => $this->encrypt->decode($row->idcard),
					'certification' => $row->certification,
					'bankname' => $row->bankname,
					'bankaccount' => $this->encrypt->decode($row->bankaccount),
					'wxno' => $row->wxno,
					'email' => $row->email,
					'address' => $row->address,
					'createTime' => $row->createTime == '0000-00-00 00:00:00' ? '' : date('Y-m-d H:i:s', strtotime($row->createTime)),
					'lastSubscribe' => $row->lastSubscribe == '0000-00-00 00:00:00' ? '' : date('Y-m-d H:i:s', strtotime($row->lastSubscribe)),
					'wxsex' => $row->wxsex,
					'wxcity' => $row->wxcity,
					'wxprovince' => $row->wxprovince,
					'wxcountry' => $row->wxcountry,
					'wxheadimgurl' => $row->wxheadimgurl,
					'teamcode' => $row->teamcode,
					'teamname' => $row->teamname,
					'isBred' => $row->isBred,
					'isSubscribe' => $row->isSubscribe,
					'roleId' => $row->roleId
				);
			}
		} 
		
		return $data;
	}
	
	private function __assembeSQL($sql, $createid, $condition, $pid){
		if($condition !='' && $condition['cdt_name'] != ''){
			$sql .=" ( nickname like '%".$condition['cdt_name']."%'"
				." or userCode like '%".$condition['cdt_name']."%'"
				." or tel like '%".$condition['cdt_name']."%') and ";
		}
//		if($createid!= "")
//			$sql .=" createid=".$createid;
//		else 
		if($pid != ""){
			$sql .= " pid=".$pid." and ";
		}
			$sql .=" 1=1 ";
		return $sql;
	}
	
	/**
	 * 根据条件查询所有数据，支持分页
	 * @param $condition 查询条件 支持时间，人员等信息过滤查询
	 * @param $offset， $limit 分页参数
	 */
	function show_all($createid, $condition, $pid, $limit, $offset){
		if($offset == ''){
			$offset = 0;
		}
		$sql = "select * from ".self::$TABLE." where ";
		$sql = self::__assembeSQL($sql, $createid, $condition, $pid);

		$sql .= " order by createTime desc limit ".$offset." , ".$limit;
		
		$result = $this->db->query($sql);
		return $result->result();
	}
	/**
	 * 第一层会员
	 */
	function tree_one($createid,$condition){
		$sql = "select * from ".self::$TABLE." where ";
		if($condition !='' && $condition['cdt_name'] != ''){
			$sql .=" userCode = '".$condition['cdt_name']."'";
		}elseif($createid!= ""){
			$sql .=" oid=".$createid;
		}else{
			$sql .=" pid=0";
		}
		$sql .= " order by createTime desc ";
		
		$result = $this->db->query($sql);
		return $result->result();
	}
	/*
	function tree_test(){
		$sql = "select * from ".self::$TABLE."";

		$sql .= " order by createTime desc ";
		
		$result = $this->db->query($sql);

		foreach ($result->result() as $record) {
			$sql_2 = "select * from ".self::$TABLE." where oid=".$record->pid." order by createTime desc ";
			$result_2 = $this->db->query($sql_2)->result();
			$upuserid='';
			while($result_2[0]->oid){
				if($upuserid!=''){
					$upuserid.=',';
				}
				$upuserid.=$result_2[0]->oid;
				$sql_2 = "select * from ".self::$TABLE." where oid=".$result_2[0]->pid." order by createTime desc ";
				$result_2 = $this->db->query($sql_2)->result();
			}
			if($upuserid!=''){
				$data["upuserid"] = $upuserid;
				$this->db->where('oid', $record->oid);
				$this->db->update(self::$TABLE, $data);
			}
		}

	}
	*/
	/**
	 * 根据条件获取查询结果总数量
	 * @param $condition 查询条件
	 */
	function get_count($createid, $condition, $pid){
		$sql = "select count(*) sumdata from ".self::$TABLE." where ";
		$sql = self::__assembeSQL($sql, $createid, $condition, $pid);
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				return $row->sumdata;
			}
		} else{
			return 0;
		}
	}
	
	function update($data, $id){
		$data["idcard"] = $this->encrypt->encode($data["idcard"]);
		$data["bankaccount"] = $this->encrypt->encode($data["bankaccount"]);
		
		$this->db->where('oid', $id);
		$this->db->update(self::$TABLE, $data);
		$data["idcard"] = $this->encrypt->decode($data["idcard"]);
		$data["bankaccount"] = $this->encrypt->decode($data["bankaccount"]);
		return $data;
	}
	
	
	function __updateNewUserCode($oid){
		$code = substr(date(date('Ymd',time())), 2).rand(100,999);
//		if($oid < 10){
//			$code.="00".$oid;
//		}else if($oid <100){
//			$code.="0".$oid;
//		} else {
//			$code.=$oid%1000;
//		}		
		
		$id = self::getIdByUserCode($code);
		while ($id != ''){
			$code = substr(date(date('Ymd',time())), 2).rand(100,999);
			$id = self::getIdByUserCode($code);
		}
		
		$data["userCode"] = $code;
		$data["userpath"] = $oid;
		$this->db->where('oid', $oid);
		$this->db->update(self::$TABLE, $data);
	}
	function insert_user($data){
		$oid = self::getIDbyOpenid($data["wxopenid"]);
		if("" == $oid){//新增用户
			$this->db->insert(self::$TABLE, $data);
			$oid = mysql_insert_id();
			self::__updateNewUserCode($oid);
			$this->Core_score->addScore($oid, 1);
			
		} else {
			self::updateSubscribeTime($oid);
		}
		
		return $this->db->insert_id();
	}
	
	function updateSubscribeTime($oid){
		$data["lastSubscribe"] = date('Y-m-d H:i:s', time()+8*60*60);
		$this->db->where('oid', $oid);
		$this->db->update(self::$TABLE, $data);
	}
	
	function joinIn($parUserCode, $openid){
//		$this->db->select('pid');
//		$this->db->where('wxopenid',$openid);
//		$query=$this->db->get(self::$TABLE);
//		$oldPid = 0;
//		if($query->num_rows()>0){
//			foreach($query->result() as $row){
//				$oldPid = $row->pid;
//			}
//		}
		$pid = self::getIdByUserCode($parUserCode);
		//return "pid=".$pid."   opid=".$oldPid;
		$oldId = self::hasUser($pid);
		$oldPid = self::__getValueByKey("wxopenid", $openid, "pid");
		$uoid = self::getIDbyOpenid($openid);
		if(0 == $oldId){
			return $parUserCode."团队尚未成立。您可以在《英雄榜》中选择优秀团队加盟。";
		} else if($oldPid != 0){
			return "您已是【".self::getNicknameById($oldPid)."（".self::getUserCodeById($oldPid,44)."）】团队成员，不能再加盟到其他团队。";
		} else if(self::isChild($uoid)){
			return "您已成功组团，不能进行加盟操作！";
		} else if($oldId == $uoid){
			self::joinInOne($pid, $uoid);
			return "您已成功独立组团。您的好运来团队号是：".self::getTeamnameById($uoid)."\n"
				."您的好运来工号：".self::getUserCodeById($uoid, 44)."\n登录密码是：".self::getPwdById($uoid);
		} else if(0 == $oldPid){
//			$data["pid"] = $pid;
//			$this->db->where('wxopenid', $openid);
//			$this->db->update(self::$TABLE, $data);
//			$this->Core_score->addScore($pid, 2);
//			$this->Core_score->addScore($uoid, 3);
			self::joinInOne($pid, $uoid);
			return "您已成功加盟【".self::getNicknameById($pid)."（".self::getUserCodeById($pid, 44)."）】团队。\n"
				."您的好运来工号是：".self::getUserCodeById($uoid, 44)."\n登录密码是：".self::getPwdById($uoid)
				."请您尽快登陆好运来网站补充完善您的个人资料和修改密码，好运来网址：www.h1111.cn";
//				."退出团队请编辑信息TM@+团队推荐人工号，如"."\n\n"
//					."TM@4400001";
		} else if ($oldPid == $pid){
			return "您已是【".self::getNicknameById($pid)."（".self::getUserCodeById($pid,44)."）】团队成员。";
		} else {
			return "您已是【".self::getNicknameById($oldPid)."（".self::getUserCodeById($oldPid,44)."）】团队成员，不能再加盟到其他团队。";
//				."退出团队请编辑信息TM@+团队推荐人工号，如"."\n\n"
//				."TM@4400001";
		} 
	}
	
	function joinInOne($pid,$oid){
		$data["pid"] = $pid;
		
		$userpath = self::getUserpathById($pid);		
		$data["userpath"] = $userpath.",".$oid;
		$this->db->where('oid', $oid);
		$this->db->update(self::$TABLE, $data);
		if($pid != $oid)
			$this->Core_score->addScore($pid, 2);
		$this->Core_score->addScore($oid, 3);
	}
	
	function quitJoin($pid, $openid){
		$uid = self::getIDbyOpenid($openid);
		if(self::isInTeam($pid, $uid)){
			$data["pid"] = 0;
			$this->db->where('wxopenid', $openid);
			$this->db->update(self::$TABLE, $data);
			$this->Core_score->addScore($pid, 5);
			$this->Core_score->addScore($uid, 6);
			return "您已成功退出【".self::getNicknameById($pid)."（".self::getUserCodeById($pid,44)."）】团队。加盟团队请编辑信息@+团队推荐人工号，如"."\n\n"
					."@131303001";
		}else {
			return "您不在".self::getUserCodeById($pid,44)."团队中。请确认您的团队后再试。";
		}
	}
	
	function isInTeam($pid, $uid){
		$this->db->select('oid');
		$this->db->where('oid', $uid);
		$this->db->where('pid', $pid);
		$query=$this->db->get(self::$TABLE);

		if($query->num_rows()>0){
			foreach($query->result() as $row){
				return true;
			}
		}else {
			return false;
		}
	}
	
	private function hasUser($oid){
		$this->db->select('oid');
		$this->db->where('oid',$oid);
		$query=$this->db->get(self::$TABLE);

		if($query->num_rows()>0){
			foreach($query->result() as $row){
				return $row->oid;
			}
		}else {
			return 0;
		}
	}
	
	
	function getIDbyOpenid($openid){
		$this->db->select('oid');
		$this->db->where('wxopenid',$openid);
		$query=$this->db->get(self::$TABLE);
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				return $row->oid;
			}
		}
		else{
			return '';
		}
	}
	
	
	function getUserpathById($id){
		return self::__getValueById($id, "userpath");
	}
	function getPwdById($id){
//		$this->db->select('pwd');
//		$this->db->where('wxopenid',$id);
//		$this->db->or_where('oid',$id);
//		$query=$this->db->get(self::$TABLE);
//		if($query->num_rows()>0){
//			foreach($query->result() as $row){
//				return $row->pwd;
//			}
//		}
//		else{
//			return '';
//		}
		return self::__getValueById($id, "pwd");
	}

	
	/**
	 * 根据用户ID和类型生成工号
	 * @param unknown_type $id
	 * @param unknown_type $type
	 */
	function getUserCodeById($id, $type=44){
//		switch ($type){
//			case 44:
//				return $id + 4400000;
//				break;
//			default:
//				return $id + 4400000;
//				break;
//		}

		return self::__getValueById($id, "userCode");
	}
	
	function getIdByUserCode($userCode, $type=44){
//		switch ($type){
//			case 44:
//				return $userCode - 4400000;
//				break;
//			default:
//				return $userCode - 4400000;
//				break;
//		}
		return self::__getValueByKey("userCode", $userCode, "oid");
	}
	
	function getTeamnameById($uid){
		return "好运来第".$uid."团";
	}
	
	/**
	 * 团队人数排名
	 */
	function getTeamNumTop(){
		$sql = "select `pid`, count(*) cs from ".self::$TABLE." where pid!=0 and pid is not null ";
		$sql .= " and roleId = 0 ";
		$sql.="group by `pid` ".self::$NO_MANAGER_SQL_HAVING." order by cs desc limit 0,10;";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
			return $query->result();
		}else 
			return "";
	}
	
	
	function isChild($oid){
		$result = self::findMyMembers($oid);
		if(count($result) == 0){
			return false;
		} else {
			return true;
		}
	}
	/**
	 * 获取我的团队信息
	 * @param unknown_type $oid
	 */
	function getMyTeam($oid){
		$sql = "select * from ".self::$TABLE." where pid=".$oid;
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->result();
		}else {
			return '';
		}
	}
	
	/**
	 * 获取我的军团信息
	 * @var unknown_type
	 */
	static $ms = array();
	function findMyMembers($oid){
//		self::__findMembers($oid);
//		return self::$ms;
//		$sql = "select * from ".self::$TABLE." where find_in_set(".$oid.",userpath)" ;
		$sql = "select * from ".self::$TABLE." where userpath like '".$oid.",%' or userpath like '%,".$oid.",%'" ;
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->result();
		} else 
			return array();
	}
	function findMyMembers_me($oid){
//		self::__findMembers($oid);
//		return self::$ms;
		$sql = "select * from ".self::$TABLE." where find_in_set(".$oid.",userpath)" ;
	//	$sql = "select * from ".self::$TABLE." where userpath like '".$oid.",%' or userpath like '%,".$oid.",%'" ;
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return $query->result();
		} else 
			return array();
	}
	private function __findMembers($oid){
		
		$sql = "select * from ".self::$TABLE." where pid=".$oid;
		$query = $this->db->query($sql);
		
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				array_push(self::$ms, $row);
				//echo $row->oid."; ";
				self::__findMembers($row->oid);
			}
		}
	}
	
	private function __getValueByKey($key, $value, $resultKey){
		$this->db->select($resultKey);
		$this->db->where($key,$value);
		$query=$this->db->get(self::$TABLE);
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				return $row->$resultKey;
			}
		}
		else{
			return '';
		}
	}
	
	
	
	/**
	 * 更新用户表某个字段的数据为加密数据（用于代码更新后初始化数据）
	 * @param unknown_type $field
	 */
	function updateEncode($field){
		$query=$this->db->get(self::$TABLE);
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				$value =  $row->$field;
				if($value != ""){
					$value = $this->encrypt->encode($value);
					$data[$field] = $value;
					$this->db->where('oid', $row->oid);
					$this->db->update(self::$TABLE, $data);
				}
			}
		}
		else{
			return '';
		}
	}
	
	function refreshUserTeamInof(){
		
		
//		$this->db->trans_start();
		$team = $this->db->get(self::$TABLE);
		$this->db->truncate(self::$TABLE_ST_USER_TEAM_INFO);
		$sql = "insert into ".self::$TABLE_ST_USER_TEAM_INFO." (userid, nickname, userCode, num) values ";
		foreach ($team->result() as $row){
			$num = count(self::findMyMembers($row->oid));
//			$data = array();
//			$data["userid"] = $row->oid;
//			$data["nickname"] = $row->nickname;
//			$data["userCode"] = $row->userCode;
//			$data["num"] = $num;
			echo $i++.". ".$data["userid"]."; ".$data["nickname"].":".$num."</br>";
//			$this->db->insert(self::$TABLE_ST_USER_TEAM_INFO, $data);
			$sql.= " ('".$row->oid."', '".$row->nickname."', '".$row->userCode."',".$num."), ";
		}
//		$sql = substr($sql, 0, strlen($sql)-2);
//		$this->db->query($sql);
		echo $sql;
//		$this->db->trans_complete(); 
	}
	
	function get_all(){
//		$this->db->order_by("userpath", "asc"); 
		$query = $this->db->get(self::$TABLE);
//		$this->db->where('oid', $row->oid);
		$sql = "select * from ".self::$TABLE." order by userpath asc";
		$query = $this->db->query($sql);
		

		return $query->result();
	}
}
?>