<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<style>
    .img-avatar{
        width:45px;
        height:45px;
        object-fit:cover;
        object-position:center center;
        border-radius:100%;
    }
</style>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Purchase</h3>
		<div class="card-tools">
			<a href="?page=inventory/purchase/manage_purchase" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
			<table class="table table-hover table-striped">
				<!-- <colgroup>
					<col width="5%">
					<col width="10%">
					<col width="20%">
					<col width="20%">
					<col width="15%">
					<col width="15%">
					<col width="10%">
				</colgroup> -->
				<thead>
					<tr class="bg-primary">
						<th>#</th>
						<th>Purchase Date</th>
						<th>From Vendor</th>
						<th>Product</th>
						<th>Description</th>
						<th>Quantity</th>
						<th>Cost/Unit</th>
						<th>Total Cost</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$i = 1;
						$qry = $conn->query("SELECT p.*, v.name vendor, prd.name product  FROM `purchase` p 
							LEFT JOIN vendor v on v.id = p.vendor_id
							LEFT JOIN products prd on prd.id = p.product_id
							order by purchase_date desc");
						while($row = $qry->fetch_assoc()): 
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo $row['purchase_date'] ?></td>
							<td><?php echo ucwords($row['vendor']) ?></td>
							<td><?php echo ucwords($row['product']) ?></td>
							<td ><p class="m-0 truncate-1"><?php echo $row['description'] ?></p></td>
							<td><?php echo $row['qty'] ?></td>
							<td><?php echo '$'.$row['cost'] ?></td>
							<td><?php echo '$'.(intval($row['qty']) * floatval($row['cost'])) ?></td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item" href="?page=inventory/purchase/manage_purchase&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this Purchase permanently?","delete_purchase",[$(this).attr('data-id')])
		})
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		$('.table').dataTable();
	})
	function delete_purchase($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Purchase.php?f=delete",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>