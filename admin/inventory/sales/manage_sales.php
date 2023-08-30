
<?php 
if(isset($_GET['id']) && $_GET['id'] > 0){
    $user = $conn->query("SELECT * FROM sales where id ='{$_GET['id']}'");
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
			<form action="" id="manage-sales">	
				<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
				<div class="form-group col-6">
					<label for="date" class="control-label">Date</label>
                	<input type="date" id="date" name="date" class="form-control form-control-sm form-control-border rounded-0" value="<?= isset($date) ? $date : date("Y-m-d") ?>" required>
				</div>
				<div class="form-group col-6">
					<label for="customer_id" class="control-label">Customer</label>
					<select id="customer_id" name="customer_id" class="from-control form-control-sm form-control-border select2" style="width: 250px;">
						<option value="" selected>Please Select</option>
						<?php 
						$accounts = $conn->query("SELECT * FROM `customer` order by `name` asc ");
						while($row = $accounts->fetch_assoc()):
						?>
						<option value="<?= $row['id'] ?>" <?php echo (isset($meta['customer_id']) && $row['id'] === $meta['customer_id']) ? 'selected' : '' ?> ><?= $row['name'] ?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group col-6">
					<label for="product_id" class="control-label">Product</label>
					<select id="product_id" name="product_id" class="from-control form-control-sm form-control-border select2" style="width: 250px;">
						<option value="" selected>Please Select</option>
						<?php 
						$accounts = $conn->query("SELECT * FROM `products` order by `name` asc ");
						while($row = $accounts->fetch_assoc()):
						?>
						<option value="<?= $row['id'] ?>" <?php echo (isset($meta['product_id']) && $row['id'] === $meta['product_id']) ? 'selected' : '' ?> ><?= $row['name'] ?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group col-6">
					<label for="description">Description</label>
					<input type="text" name="description" id="description" class="form-control" value="<?php echo isset($meta['description']) ? $meta['description']: '' ?>" required>
				</div>
				<div class="form-group col-6">
					<label for="qty">Quantity</label>
					<input type="number" name="qty" id="qty" class="form-control" value="<?php echo isset($meta['qty']) ? $meta['qty']: '' ?>" required>
				</div>
				<div class="form-group col-6">
					<label for="price">Price</label>
					<input type="number" name="price" id="price" class="form-control" value="<?php echo isset($meta['price']) ? $meta['price']: '' ?>" required><small> Per Unit</small>
				</div>
				<div class="form-group col-6">
					<label for="payment_type">Payment Type</label>
					<select id="payment_type" name="payment_type" class="from-control form-control-sm form-control-border select2" style="width: 250px;">
						<option value="cash" <?php echo (isset($meta['payment_type']) && "cash" === $meta['payment_type']) ? 'selected' : '' ?>>Cash</option>
						<option value="credit" <?php echo (isset($meta['payment_type']) && "credit" === $meta['payment_type']) ? 'selected' : '' ?>>Credit</option>
					</select>
				</div>
			</form>
		</div>
	</div>
	<div class="card-footer">
			<div class="col-md-12">
				<div class="row">
					<button class="btn btn-sm btn-primary mr-2" form="manage-sales">Save</button>
					<a class="btn btn-sm btn-secondary" href="./?page=inventory/sales">Cancel</a>
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
	
	$('#manage-sales').submit(function(e){
		e.preventDefault();
		var _this = $(this)
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Sales.php?f=save',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp ==1){
					location.href = './?page=inventory/sales';
				}else{
					$('#msg').html('<div class="alert alert-danger">Sales already exist</div>')
					$("html, body").animate({ scrollTop: 0 }, "fast");
				}
                end_loader()
			}
		})
	})

</script>