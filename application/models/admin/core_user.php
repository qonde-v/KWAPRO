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
	function show_one($id){
		$this->db->where('id', $id);
		$query = $this->db->get(self::$TABLE);
		$data = array(
			'id'=>'',
			'pwd' => '',
			'userCode' => '',
			'username' => '',
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
					'id'=>$row->id,
					'pwd' => $row->pwd,
					'userCode' => $row->userCode,
					'nickname' => $row->nickname,
					'createTime' => $row->createTime == '0000-00-00 00:00:00' ? '' : date('Y-m-d H:i:s', strtotime($row->createTime)),
					'roleId' => $row->roleId
				);
			}
		} 
		
		return $data;
	}
	
	private function __assembeSQL($sql, $createid, $condition, $pid){
		if($condition !='' && $condition['cdt_name'] != ''){
			$sql .=" ( nickname like '%".$condition['cdt_name']."%'"
				." or userCode like '%".$condition['cdt_name']."%') and ";
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
		$this->db->where('id', $id);
		$this->db->update(self::$TABLE, $data);
		return $data;
	}
	function insert($data){
		$id = $data["id"];
		if($id<=1){//新增
			$data['createTime']= date('Y-m-d H:i:s', time()+8*60*60);
			$this->db->insert(self::$TABLE, $data);
			$id = mysql_insert_id();
			$data["id"] = $id;
			return $data;
		} else {
			return $data;
		}
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
	
	
	function get_all(){
//		$this->db->order_by("userpath", "asc"); 
		$query = $this->db->get(self::$TABLE);
//		$this->db->where('oid', $row->oid);
		$sql = "select * from ".self::$TABLE." order by userpath asc";
		$query = $this->db->query($sql);
		

		return $query->result();
	}
	function delete($id){
		$this->db->where('id', $id);
		$this->db->delete(self::$TABLE);
	}
}
?>