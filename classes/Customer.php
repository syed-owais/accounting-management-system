<?php
require_once('../config.php');
Class Customer extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function save_customer(){

		extract($_POST);
		$oid = $id;
		$data = '';
		
		$chk = $this->conn->query("SELECT * FROM `customer` where name ='{$name}' ".($id>0? " and id!= '{$id}' " : ""))->num_rows;
		if($chk > 0){
			return 3;
			exit;
		}
		foreach($_POST as $k => $v){
			if(in_array($k,array('name','address'))){
				if(!empty($data)) $data .=" , ";
				$data .= " {$k} = '{$v}' ";
			}
		}
		
		if(empty($id)){
			$qry = $this->conn->query("INSERT INTO customer set {$data}");
			if($qry){
				$id = $this->conn->insert_id;
				$this->settings->set_flashdata('success','Customer Details successfully saved.');
				$resp['status'] = 1;
			}else{
				$resp['status'] = 2;
			}

		}else{
			$qry = $this->conn->query("UPDATE customer set $data where id = {$id}");
			if($qry){
				$this->settings->set_flashdata('success','Customer Details successfully updated.');
				if($id == $this->settings->userdata('id')){
					foreach($_POST as $k => $v){
						if($k != 'id'){
							if(!empty($data)) $data .=" , ";
							$this->settings->set_userdata($k,$v);
						}
					}
					
				}
				$resp['status'] = 1;
			}else{
				$resp['status'] = 2;
			}
			
		}
		

		if(isset($resp['msg']))
		$this->settings->set_flashdata('success',$resp['msg']);
		return  $resp['status'];
	}
	public function delete_customer(){
		extract($_POST);
		$qry = $this->conn->query("DELETE FROM customer where id = $id");
		if($qry){
			$this->settings->set_flashdata('success','Customer Details successfully deleted.');
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
		}
		return json_encode($resp);
	}
	
}

$customer = new customer();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
	case 'save':
		echo $customer->save_customer();
	break;
	case 'delete':
		echo $customer->delete_customer();
	break;
	default:
		break;
}