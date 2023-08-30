<?php
require_once('../config.php');
Class Purchase extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function save_purchase(){

		extract($_POST);
		$oid = $id;
		$data = '';
		foreach($_POST as $k => $v){
			if(in_array($k,array('purchase_date','vendor_id','product_id','description','cost','qty','payment_type'))){
				if(!empty($data)) $data .=" , ";
				$data .= " {$k} = '{$v}' ";
			}
		}
		if(empty($id)){
			$qry = $this->conn->query("INSERT INTO purchase set {$data}");
			if($qry){
				$id = $this->conn->insert_id;
				$this->updateStock($product_id, intval($qty));
				$this->settings->set_flashdata('success','Purchase Details successfully saved.');
				$resp['status'] = 1;
			}else{
				$resp['status'] = 2;
			}

		}else{
			$qry = $this->conn->query("UPDATE purchase set $data where id = {$id}");
			if($qry){
				$this->settings->set_flashdata('success','Purchase Details successfully updated.');
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
		
		if(!$this->postJournalEntry($vendor_id, $payment_type, $purchase_date, $id, (floatval($cost) * intval($qty)))){
			return 3;
			exit;
		}

		if(isset($resp['msg']))
		$this->settings->set_flashdata('success',$resp['msg']);
		return  $resp['status'];
	}

	public function delete_purchase(){
		extract($_POST);
		$qry = $this->conn->query("DELETE FROM purchase where id = $id");
		if($qry){
			$this->settings->set_flashdata('success','Purchase Details successfully deleted.');
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
		}
		return json_encode($resp);
	}

	public function postJournalEntry($vendor_id, $payment_type, $date, $purchase_id, $amount){

		$purchaseJournal = $this->conn->query("SELECT * FROM purchase_journal WHERE purchase_id = $purchase_id")->fetch_assoc();
		if(!empty($purchaseJournal)){
			$deleteSql = "DELETE FROM `journal_entries` where id = {$purchaseJournal['journal_id']}";
			$this->conn->query($deleteSql);
			$deleteSql = "DELETE FROM purchase_journal WHERE purchase_id = $purchase_id";
			$this->conn->query($deleteSql);
		}

		if ($payment_type === 'cash'){
			$account_id = 1;
		}
		else{
			$qry = $this->conn->query("SELECT * FROM vendor WHERE id = $vendor_id")->fetch_assoc();
			$account_id = $qry['account_id'];
		}

		$prefix = date("Ym-");
		$code = sprintf("%'.05d",1);

		while(true){
			$check = $this->conn->query("SELECT * FROM `journal_entries` where `code` = '{$prefix}{$code}' ")->num_rows;
			if($check > 0){
				$code = sprintf("%'.05d",ceil($code) + 1);
			}else{
				break;
			}
		}
		$_code = $prefix.$code;
		$user_id = $this->settings->userdata('id');
		$sql = "INSERT INTO `journal_entries`(`code`, `journal_date`, `description`, `user_id`) values 
		(
			'{$_code}',
			'{$date}',
			'Purchase #{$purchase_id}',
			$user_id
		)";
	
		$save = $this->conn->query($sql);
		if($save){
			$jid = $this->conn->insert_id;
			$data = "";
			$this->conn->query("DELETE FROM `journal_items` where journal_id = '{$jid}'");
			/* 51 is purchase account id
			* 3 is Expenses group id 
			* 8 is Credit group id 
			*/
			$sql = "INSERT INTO `journal_items` (`journal_id`,`account_id`,`group_id`,`amount`) VALUES 
			(
				$jid,
				51,
				3,
				$amount
			),
			(
				$jid,
				$account_id,
				8,
				$amount
			)";
			$save2 = $this->conn->query($sql);
			if ($save2){
				$sql = "INSERT INTO `purchase_journal`(`purchase_id`, `journal_id`) VALUES 
				(
					$purchase_id,
					$jid
				)";
				return $this->conn->query($sql);
			}
		}
		return -1;
	}
	
	public function updateStock($product_id, $qty){
		$sql = "UPDATE `products` SET qty = qty + {$qty} WHERE id = {$product_id}";
		return $this->conn->query($sql);
	}
}

$purchase = new purchase();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
	case 'save':
		echo $purchase->save_purchase();
	break;
	case 'delete':
		echo $purchase->delete_purchase();
	break;
	default:
		// echo $sysset->index();
		break;
}