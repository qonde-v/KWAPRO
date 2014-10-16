<?php
class Core_order extends CI_Model {
	private static $TABLE = 'orders';
	private static $NO_MANAGER_SQL = ' and roleId = 0 ';
	
	function __construct(){
		parent::__construct();
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
			'uId' => '',
			'username' => '',
			'realname' => '',
			'address' => '',
			'tel' => '',
			'design_id' => '',
			'status' => '',
			'operator' => '',
			'confirmtime' => '',
			'completetime' => '',
			'committime' => '',
			'remark' => '',
			'createTime' => ''
		);
		if ($query->num_rows() > 0){
			foreach ($query->result() as $row){
				$data = array(
					'id'=>$row->id,
					'uId' => $row->uId,
					'username' => $row->username,
					'realname' => $row->realname,
					'address' => $row->address,
					'tel' => $row->tel,
					'design_id' => $row->design_id,
					'status' => $row->status,
					'operator' => $row->operator,
					'confirmtime' => $row->confirmtime,
					'completetime' => $row->completetime,
					'committime' => $row->committime,
					'remark' => $row->remark,
					'createTime' => $row->createTime == '0000-00-00 00:00:00' ? '' : date('Y-m-d H:i:s', strtotime($row->createTime))
				);
			}
		} 
		
		return $data;
	}
	
	private function __assembeSQL($sql, $createid, $condition, $pid){
		if($condition !='' && $condition['cdt_name'] != ''){
			$sql .=" ( name like '%".$condition['cdt_name']."%'"
				." or contacts like '%".$condition['cdt_name']."%') and ";
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
		$sql = "select a.*,b.title from ".self::$TABLE." a inner join design b on a.design_id=b.id where ";
		$sql = self::__assembeSQL($sql, $createid, $condition, $pid);

		$sql .= " order by id limit ".$offset." , ".$limit;
		
		$result = $this->db->query($sql);
		return $result->result();
	}

	///getstatus
	function get_status(){
		$sql = "select * from order_status ";

		$result = $this->db->query($sql);
		return $result->result();
	}

	///getstatus
	function get_factory(){
		$sql = "select * from factory ";

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