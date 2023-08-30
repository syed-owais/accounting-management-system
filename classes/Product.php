<?php
require_once('../config.php');
Class Product extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function save_product(){

		extract($_POST);
		$oid = $id;
		$data = '';
		
		$chk = $this->conn->query("SELECT * FROM `products` where name ='{$name}' ".($id>0? " and id!= '{$id}' " : ""))->num_rows;
		if($chk > 0){
			return 3;
			exit;
		}
		foreach($_POST as $k => $v){
			if(in_array($k,array('name','description','cost','price','qty'))){
				if(!empty($data)) $data .=" , ";
				$data .= " {$k} = '{$v}' ";
			}
		}
		
		if(empty($id)){
			$qry = $this->conn->query("INSERT INTO products set {$data}");
			if($qry){
				$id = $this->conn->insert_id;
				$this->settings->set_flashdata('success','Product Details successfully saved.');
				$resp['status'] = 1;
			}else{
				$resp['status'] = 2;
			}

		}else{
			$qry = $this->conn->query("UPDATE products set $data where id = {$id}");
			if($qry){
				$this->settings->set_flashdata('success','Product Details successfully updated.');
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
		
		if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
			$fname = 'uploads/avatar-'.$id.'.png';
			$dir_path =base_app. $fname;
			$upload = $_FILES['img']['tmp_name'];
			$type = mime_content_type($upload);
			$allowed = array('image/png','image/jpeg');
			if(!in_array($type,$allowed)){
				$resp['msg'].=" But Image failed to upload due to invalid file type.";
			}else{
				$new_height = 200; 
				$new_width = 200; 
		
				list($width, $height) = getimagesize($upload);
				$t_image = imagecreatetruecolor($new_width, $new_height);
				imagealphablending( $t_image, false );
				imagesavealpha( $t_image, true );
				$gdImg = ($type == 'image/png')? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
				imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				if($gdImg){
						if(is_file($dir_path))
						unlink($dir_path);
						$uploaded_img = imagepng($t_image,$dir_path);
						imagedestroy($gdImg);
						imagedestroy($t_image);
				}else{
				$resp['msg'].=" But Image failed to upload due to unkown reason.";
				}
			}
			if(isset($uploaded_img)){
				$this->conn->query("UPDATE products set `avatar` = CONCAT('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$id}' ");
				if($id == $this->settings->userdata('id')){
						$this->settings->set_userdata('avatar',$fname);
				}
			}
		}
		if(isset($resp['msg']))
		$this->settings->set_flashdata('success',$resp['msg']);
		return  $resp['status'];
	}
	public function delete_products(){
		extract($_POST);
		$avatar = $this->conn->query("SELECT avatar FROM products where id = '{$id}'")->fetch_array()['avatar'];
		$qry = $this->conn->query("DELETE FROM products where id = $id");
		if($qry){
			$avatar = explode("?",$avatar)[0];
			$this->settings->set_flashdata('success','Product Details successfully deleted.');
			if(is_file(base_app.$avatar))
				unlink(base_app.$avatar);
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
		}
		return json_encode($resp);
	}
	
}

$products = new product();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
	case 'save':
		echo $products->save_product();
	break;
	case 'delete':
		echo $products->delete_products();
	break;
	default:
		// echo $sysset->index();
		break;
}