
<?php 
if(isset($_GET['id']) && $_GET['id'] > 0){
    $user = $conn->query("SELECT * FROM vendor where id ='{$_GET['id']}'");
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
			<form action="" id="manage-vendor">	
				<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
				<div class="form-group col-6">
					<label for="name">Name</label>
					<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required>
				</div>
				<div class="form-group col-6">
					<label for="address">Description</label>
					<input type="text" name="address" id="address" class="form-control" value="<?php echo isset($meta['address']) ? $meta['address']: '' ?>" required>
				</div>
				<div class="form-group col-6">
					<label for="company">Company</label>
					<input type="text" name="company" id="company" class="form-control" value="<?php echo isset($meta['company']) ? $meta['company']: '' ?>" required>
				</div>
				<div class="form-group col-6">
					<label for="account_id" class="control-label">Account</label>
					<select id="account_id" class="from-control form-control-sm form-control-border select2">
						<option value="" disabled selected></option>
						<?php 
						$accounts = $conn->query("SELECT * FROM `account_list` where delete_flag = 0 and `status` = 1 order by `name` asc ");
						while($row = $accounts->fetch_assoc()):
							unset($row['description']);
							$account_arr[$row['id']] = $row;
						?>
						<option value="<?= $row['id'] ?>" <?php echo (isset($meta['account_id']) && $row['id'] === $meta['account_id']) ? 'selected' : '' ?> ><?= $row['name'] ?></option>
						<?php endwhile; ?>
					</select>	
					<?php if(!isset($_GET['id'])): ?>
						<small class="text-info"><i>Leave this blank if you don't have company account.</i></small>
                    <?php endif; ?>
				</div>
			</form>
		</div>
	</div>
	<div class="card-footer">
			<div class="col-md-12">
				<div class="row">
					<button class="btn btn-sm btn-primary mr-2" form="manage-vendor">Save</button>
					<a class="btn btn-sm btn-secondary" href="./?page=vendor">Cancel</a>
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
	$('#manage-vendor').submit(function(e){
		e.preventDefault();
		var _this = $(this)
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Vendor.php?f=save',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp ==1){
					location.href = './?page=vendor';
				}else{
					$('#msg').html('<div class="alert alert-danger">Vendor already exist</div>')
					$("html, body").animate({ scrollTop: 0 }, "fast");
				}
                end_loader()
			}
		})
	})

</script>