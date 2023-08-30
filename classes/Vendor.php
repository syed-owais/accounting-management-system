<?php
require_once('../config.php');
Class Vendor extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function save_vendor(){

		extract($_POST);
		$oid = $id;
		$data = '';
		
		$chk = $this->conn->query("SELECT * FROM `vendor` where name ='{$name}' ".($id>0? " and id!= '{$id}' " : ""))->num_rows;
		if($chk > 0){
			return 3;
			exit;
		}
		foreach($_POST as $k => $v){
			if(in_array($k,array('name','address','company'))){
				if(!empty($data)) $data .=" , ";
				$data .= " {$k} = '{$v}' ";
			}
		}
		
		if(empty($id)){
			$qry = $this->conn->query("INSERT INTO vendor set {$data}");
			if($qry){
				$id = $this->conn->insert_id;

						
				if(!empty($company)){
					$accQuery = $this->conn->query("INSERT INTO `account_list` (`name`, `description`) values ('{$company} - A/C', '{$company} - A/C')");
					$accId = $this->conn->insert_id;
					$this->conn->query("UPDATE vendor set account_id = {$accId} where id = {$id}");
				}

				$this->settings->set_flashdata('success','Vendor Details successfully saved.');
				$resp['status'] = 1;
			}else{
				$resp['status'] = 2;
			}

		}else{
			$qry = $this->conn->query("UPDATE vendor set $data where id = {$id}");
			if($qry){
				$this->settings->set_flashdata('success','Vendor Details successfully updated.');
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
	public function delete_vendor(){
		extract($_POST);
		$qry = $this->conn->query("DELETE FROM vendor where id = $id");
		if($qry){
			$this->settings->set_flashdata('success','Vendor Details successfully deleted.');
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
		}
		return json_encode($resp);
	}
	
}

$vendor = new vendor();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
	case 'save':
		echo $vendor->save_vendor();
	break;
	case 'delete':
		echo $vendor->delete_vendor();
	break;
	default:
		// echo $sysset->index();
		break;
}