
<?php 
if(isset($_GET['id']) && $_GET['id'] > 0){
    $user = $conn->query("SELECT * FROM products where id ='{$_GET['id']}'");
    foreach($user->fetch_array() as $k =>$v){
        $meta[$k] = $v;
    }
}
?>
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage-product">	
				<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
				<div class="form-group col-6">
					<label for="name">Name</label>
					<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required>
				</div>
				<div class="form-group col-6">
					<label for="description">Description</label>
					<input type="text" name="description" id="description" class="form-control" value="<?php echo isset($meta['description']) ? $meta['description']: '' ?>" required>
				</div>
				<div class="form-group col-6">
					<label for="cost">Cost</label>
					<input type="number" name="cost" id="cost" class="form-control" value="<?php echo isset($meta['cost']) ? $meta['cost']: '' ?>" required  autocomplete="off">
				</div>
				<div class="form-group col-6">
					<label for="price">Price</label>
					<input type="number" name="price" id="price" class="form-control" value="<?php echo isset($meta['price']) ? $meta['price']: '' ?>" autocomplete="off" <?php echo isset($meta['id']) ? "": 'required' ?>>
				</div>
				<div class="form-group col-6">
					<label for="qty">Quantity</label>
					<input type="number" name="qty" id="qty" class="form-control" value="<?php echo isset($meta['qty']) ? $meta['qty']: '' ?>" autocomplete="off" >
				</div>
				<div class="form-group col-6">
					<label for="" class="control-label">Avatar</label>
					<div class="custom-file">
		              <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
		              <label class="custom-file-label" for="customFile">Choose file</label>
		            </div>
				</div>
				<div class="form-group col-6 d-flex justify-content-center">
					<img src="<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] :'') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
				</div>
			</form>
		</div>
	</div>
	<div class="card-footer">
			<div class="col-md-12">
				<div class="row">
					<button class="btn btn-sm btn-primary mr-2" form="manage-product">Save</button>
					<a class="btn btn-sm btn-secondary" href="./?page=inventory/products/list">Cancel</a>
				</div>
			</div>
		</div>
</div>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>
	$(function(){
		$('.select2').select2({
			width:'resolve'
		})
	})
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$('#manage-product').submit(function(e){
		e.preventDefault();
		var _this = $(this)
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Product.php?f=save',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp ==1){
					location.href = './?page=inventory/products/list';
				}else{
					$('#msg').html('<div class="alert alert-danger">Product already exist</div>')
					$("html, body").animate({ scrollTop: 0 }, "fast");
				}
                end_loader()
			}
		})
	})

</script>