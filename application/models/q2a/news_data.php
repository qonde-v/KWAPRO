<?php
  class News_data extends CI_Model
  {
	  private static $TABLE = 'news';
	function __construct()
	 {
	    parent::__construct();
		$this->load->model('q2a/Kpc_manage');
        $this->load->model('q2a/User_privatetag_manage');
        $this->load->helper('define');
	 }


	 //get news by value of specified key
	 //input array('key'=>value)
	 function get_newslist($data,$limit=0,$offset=0)
	 {
		$this->db->select('*');
        if($data!='')$this->db->where($data);
		$this->db->order_by('createTime','desc');
		if($limit!=0) $this->db->limit($limit,$offset);
        $query = $this->db->get('news');
		$result = array();

		 if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                array_push($result,(array)$row);
            }
        } 
		return $result;
	 }


	 private function __assembeSQL($sql, $createid, $condition){
		if($condition !='' && $condition['cdt_name'] != ''){
			$sql .=" ( title like '%".$condition['cdt_name']."%'"
				." or content like '%".$condition['cdt_name']."%') and ";
		}
		if($createid!= "")
			$sql .=" createid=".$createid;
		else 
			$sql .=" 1=1 ";
		return $sql;
	}
	
	/**
	 * 根据条件查询所有数据，支持分页
	 * @param $condition 查询条件 支持时间，人员等信息过滤查询
	 * @param $offset， $limit 分页参数
	 */
	function show_all($createid, $condition, $limit, $offset){
		if($offset == ''){
			$offset = 0;
		}
		$sql = "select * from ".self::$TABLE." where ";
		$sql = self::__assembeSQL($sql, $createid, $condition);

		$sql .= " order by createTime desc limit ".$offset." , ".$limit;
		
		$result = $this->db->query($sql);
		return $result->result();
	}

	/**
	 * 根据条件获取查询结果总数量
	 * @param $condition 查询条件
	 */
	function get_count($createid, $condition){
		$sql = "select count(*) sumdata from ".self::$TABLE." where ";
		$sql = self::__assembeSQL($sql, $createid, $condition);
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				return $row->sumdata;
			}
		} else{
			return 0;
		}
	}

	function delete($id){
		$this->db->where('id', $id);
		$this->db->delete(self::$TABLE);
	}

		/**
	 * 根据ID获取信息
	 * @param $id
	 */
	function show_one($id){
		$this->db->where('id', $id);
		$query = $this->db->get(self::$TABLE);
		$data = array(
			'id'=>'0',
			'type' => '',
			'source' => '',
			'author' => '',
			'title' => '',
			'createTime' => '',
			'content' => '',
			'pricefilename' => '',
			'createid' =>'',
			'isfirst' =>0,
			'isbest' => 0
		);
		if ($query->num_rows() > 0){
			foreach ($query->result() as $row){
				$data = array(
					'id'=>$row->ID,
					'type' => $row->type,
					'source' => $row->source,
					'author' => $row->author,
					'title' => $row->title,
					'createTime' => $row->createTime == null ? '' : date('Y-m-d H:i:s', strtotime($row->createTime)),
					'content' => $row->content,
					'pricefilename' => $row->pricefilename,
					'createid' => $row->createid,
					'isfirst' => $row->isfirst,
					'isbest' => $row->isbest
				);
			}
		} 
		return $data;
	}

	function insert($data){
		$id = $data["id"];
		if($id<=1){//新增订单
			$data['createTime']= date('Y-m-d H:i:s', time()+8*60*60);
			$this->db->insert(self::$TABLE, $data);
			$id = mysql_insert_id();
			$data["id"] = $id;
			return $data;
		} else {
			return $data;
		}
	}

	function update($data, $id){
		$this->db->where('id', $id);
		$this->db->update(self::$TABLE, $data);
		return $data;
	}

	function get_lastid($id,$type)
	 {
	   $sql = "SELECT ID from news WHERE id<".$id." and type=".$type." limit 1";
	   $query = $this->db->query($sql);

	   	if($query->num_rows() > 0)
		{
		     foreach($query->result() as $row)
            {
                return $row->ID;
            }
		}
		return 0;
	 }
	 function get_nextid($id,$type)
	 {
	   $sql = "SELECT ID from news WHERE id>".$id." and type=".$type." limit 1";
	   $query = $this->db->query($sql);

	   	if($query->num_rows() > 0)
		{
		     foreach($query->result() as $row)
            {
                return $row->ID;
            }
		}
		return 0;
	 }

	 function  get_news_text_id($id_arr)
    {
       $this->db->select('ID as id, title as text,content,viewnum,createTime as time');
       $this->db->where_in('ID',$id_arr);
       $query = $this->db->get('news');
       if($query->num_rows() > 0)
       {
           return $query->result_array();
       }
       return array();
    }


  }


  /*End of file*/
  /*Location: ./system/appllication/model/news_data.php*/