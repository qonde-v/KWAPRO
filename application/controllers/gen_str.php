<?php
  class Gen_str extends CI_Controller
  {
     function __construct()
	 {
	    parent::__construct();
		$this->load->helper('url');
		$this->load->helper('define');
		
		$this->load->model('q2a/Settings_check');
		$this->load->model('q2a/Message_manage');
		$this->load->model('q2a/Search');
		$this->load->model('q2a/Ip_location');
		$this->load->model('q2a/User_privatetag_manage');
	 }
	
	 function index()
	 {
	    $data['base'] = $this->config->item('base_url');
		$this->load->view('q2a/tooltips',$data);
	 }
	 
	 function gen_province()
	 {
	     $sql = "SELECT * FROM province_table";
		 $query = $this->db->query($sql);
		 $i = 0;
		 
		 if($query->num_rows() > 0)
         {
            foreach($query->result() as $row)
            {
                echo "arrpro[{$i}] = new Class({$row->province_code},\"{$row->province_name}\")\n";
				$i++;
			}
		 }
	 }
	 
	 function gen_city()
	 {
	     $sql = "SELECT * FROM city_table";
		 $query = $this->db->query($sql);
		 $i = 0;
		 
		 if($query->num_rows() > 0)
         {
            foreach($query->result() as $row)
            {
			    /*$arr = explode("省",$row->city_name);
				if(isset($arr[1]))
				{
				   $name = $arr[1];
				}
				else
				{
				  $arr = explode("自治区",$row->city_name);
				  if(isset($arr[1]))
				  {
				     $name = $arr[1];
				  }
				  else
				  {
				     $name = $row->city_name;
				  }
				}*/
				
				if($i == 236)
				{
				  echo $row->city_name."\n  ";
				}
                //echo "arrcity[{$i}] = new Item({$row->city_code},\"{$name}\",{$row->province_code})\n";                
				$i++;
			}
		 }
	 }
	 
	 function gen_area()
	 {
	     $sql = "SELECT * FROM town_table";
		 $query = $this->db->query($sql);
		 $i = 0;
		 
		 if($query->num_rows() > 0)
         {
            foreach($query->result() as $row)
            {
			    $arr = explode("省",$row->town_name);
				if(isset($arr[1]))
				{
				   $name = $arr[1];
				}
				else
				{
				  $arr = explode("自治区",$row->town_name);
				  if(isset($arr[1]))
				  {
				     $name = $arr[1];
				  }
				  else
				  {
				    $name = $row->town_name;
				  }
				}
				
				$arr = explode("市",$name);
				 if(isset($arr[1])&& !empty($arr[1]) )
				 {
					$name = $arr[1];
				 }
				
                echo "subDis[{$i}] = new Sub({$row->town_code},\"{$name}\",{$row->city_code},{$row->province_code})\n";                
				$i++;
			}
		 }
	 }
	 
	 function gen_user_tag()
	 {
	     $sql = "SELECT * FROM category";
		 $query = $this->db->query($sql);
		 $i = 0;
		 
		 if($query->num_rows() > 0)
         {
            foreach($query->result() as $row)
            {
                echo "cate_arr[{$i}] = new Class({$row->category_id},\"{$row->category_name}\")\n";
                //echo "arrind[{$i}] = new TagCalss({$row->sub_cate_id},\"{$row->sub_cate_name}\",{$row->category_id})\n";		
				$i++;
			}
		 }
	 }
	 
	function http()
	{
	   echo $this->uri->segment(3);
	}
	
	function ip2location()
	{
	   echo $this->Ip_location->get_location_city();
	}
	
	function test()
	{
		$code = "11;delete from categorydata";
		$this->db->select('cId');
		$this->db->where("cId",$code);
		$query = $this->db->get("categorydata");
		 if($query->num_rows() > 0)
         {
            foreach($query->result() as $row)
            {
                echo $row->cId."--";
			}
		 }
	}
  }
