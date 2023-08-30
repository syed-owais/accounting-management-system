<?php
require_once('../config.php');
Class Sales extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function save_sales(){
		extract($_POST);
		$data = '';
		foreach($_POST as $k => $v){
			if(in_array($k,array('date','customer_id','product_id','description','price','qty','payment_type'))){
				if(!empty($data)) $data .=" , ";
				$data .= " {$k} = '{$v}' ";
			}
		}
		if(empty($id)){
			$qry = $this->conn->query("INSERT INTO sales set {$data}");
			if($qry){
				$id = $this->conn->insert_id;
				$this->updateStock($product_id, intval($qty));
				$this->settings->set_flashdata('success','Sales Details successfully saved.');
				$resp['status'] = 1;
			}else{
				$resp['status'] = 2;
			}

		}else{
			$qry = $this->conn->query("UPDATE sales set $data where id = {$id}");
			if($qry){
				$this->settings->set_flashdata('success','Sales Details successfully updated.');
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
		
		if(!$this->postJournalEntry($payment_type, $date, $id, (floatval($price) * intval($qty)))){
			return 3;
			exit;
		}
		
		if(isset($resp['msg']))
		$this->settings->set_flashdata('success',$resp['msg']);
		return  $resp['status'];
	}

	public function delete_sales(){
		extract($_POST);
		$qry = $this->conn->query("DELETE FROM sales where id = $id");
		if($qry){
			$this->settings->set_flashdata('success','Sales Details successfully deleted.');
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
		}
		return json_encode($resp);
	}

	public function postJournalEntry($payment_type, $date, $sales_id, $amount){

		$salesJournal = $this->conn->query("SELECT * FROM sales_journal WHERE sales_id = $sales_id")->fetch_assoc();
		if(!empty($purchaseJournal)){
			$deleteSql = "DELETE FROM `journal_entries` where id = {$salesJournal['journal_id']}";
			$this->conn->query($deleteSql);
			$deleteSql = "DELETE FROM sales_journal WHERE sales_id = $sales_id";
			$this->conn->query($deleteSql);
		}

		if ($payment_type === 'cash'){
			$account_id = 1;
		}
		else{
			$account_id = 4;// Accounts Receivable id
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
			'Sales #{$sales_id}',
			$user_id
		)";

		$save = $this->conn->query($sql);
		if($save){
			$jid = $this->conn->insert_id;
			$data = "";
			$this->conn->query("DELETE FROM `journal_items` where journal_id = '{$jid}'");
			/* 56 is sales account id
			* 2 is Revenue group id 
			* 9 is Debit group id 
			*/
			$sql = "INSERT INTO `journal_items` (`journal_id`,`account_id`,`group_id`,`amount`) VALUES 
			(
				$jid,
				$account_id,
				9,
				$amount
			),
			(
				$jid,
				56,
				2,
				$amount
			)";
			$save2 = $this->conn->query($sql);
			if ($save2){
				$sql = "INSERT INTO `sales_journal`(`sales_id`, `journal_id`) VALUES 
				(
					$sales_id,
					$jid
				)";
				return $this->conn->query($sql);
			}
		}
		return -1;
	}
	
	public function updateStock($product_id, $qty){
		$sql = "UPDATE `products` SET qty = qty - {$qty} WHERE id = {$product_id}";
		return $this->conn->query($sql);
	}
}

$sales = new sales();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
	case 'save':
		echo $sales->save_sales();
	break;
	case 'delete':
		echo $sales->delete_sales();
	break;
	default:
		// echo $sysset->index();
		break;
}