<?php
function format_num($number){
	$decimals = 0;
	$num_ex = explode('.',$number);
	$decimals = isset($num_ex[1]) ? strlen($num_ex[1]) : 0 ;
	return '$'.number_format($number,$decimals);
}
$from = isset($_GET['from']) ? $_GET['from'] : date("Y-m-d",strtotime(date('Y-m-d')." -1 week"));
$to = isset($_GET['to']) ? $_GET['to'] : date("Y-m-d");
?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Balance Sheet</h3>
		<div class="card-tools">
		</div>
	</div>
	<div class="card-body">
        <div class="callout border-primary shadow rounded-0">
            <h4 class="text-muted">Filter Date</h4>
            <form action="" id="filter">
            <div class="row align-items-end">
                <div class="col-md-4 form-group">
                    <label for="from" class="control-label">Date From</label>
                    <input type="date" id="from" name="from" value="<?= $from ?>" class="form-control form-control-sm rounded-0">
                </div>
                <div class="col-md-4 form-group">
                    <label for="to" class="control-label">Date To</label>
                    <input type="date" id="to" name="to" value="<?= $to ?>" class="form-control form-control-sm rounded-0">
                </div>
                <div class="col-md-4 form-group">
                    <button class="btn btn-default bg-gradient-navy btn-flat btn-sm"><i class="fa fa-filter"></i> Filter</button>
			        <button class="btn btn-default border btn-flat btn-sm" id="print" type="button"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
            </form>
        </div>
        <div class="container-fluid" id="outprint">
        <style>
            th.p-0, td.p-0{
                padding: 0 !important;
            }
        </style>
            <h3 class="text-center"><b><?= $_settings->info('name') ?></b></h3>
            <h4 class="text-center"><b>Balance Sheet</b></h4>
            <?php if($from == $to): ?>
            <p class="m-0 text-center"><?= date("M d, Y" , strtotime($from)) ?></p>
            <?php else: ?>
            <p class="m-0 text-center"><?= date("M d, Y" , strtotime($from)). ' - '.date("M d, Y" , strtotime($to)) ?></p>
            <?php endif; ?>
            <hr>
			<div class="col-md-12">
                <table class="table table-hover table-bordered">
                    <?php 
                        // $groupList = $conn->query("SELECT gl.id ,GL.name FROM group_list GL 
                        //                             WHERE id in(
                        //                             SELECT ji.group_id FROM journal_entries je
                        //                             JOIN journal_items ji ON ji.journal_id = je.id
                        //                             WHERE date(je.journal_date) BETWEEN '{$from}' and '{$to}' 
                        //                             )
                        //                             ORDER BY gl.id");
                        $groupList = $conn->query("SELECT gl.id ,GL.name FROM group_list GL 
                                                    ORDER BY gl.id");
                        while($row = $groupList->fetch_assoc()):
                    ?>
                        <colgroup>
                        <col width="70%">
                        <col width="30%">
                        </colgroup>
                        <thead>
                        <tr>
                            <th class="py-1 px-2 align-middle" ><?= $row['name']; ?></th>
                            <th class="py-1 px-2 align-middle" >Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $total = 0;
                                $accountList = $conn->query("SELECT al.name, sum(ji.amount) amount FROM journal_items JI 
                                                            JOIN journal_entries je ON je.id = ji.journal_id
                                                            JOIN account_list AL ON AL.ID = JI.account_id
                                                            WHERE JI.group_id = {$row['id']}
                                                            AND date(je.journal_date) BETWEEN '{$from}' and '{$to}' 
                                                            GROUP BY al.name;");
                                while($alRow = $accountList->fetch_assoc()):
                            ?>
                                <tr>
                                    <td class="py-1 px-2 align-middle" style="padding-left: 7% !important;"><?= $alRow['name']; ?></td>
                                    <td style="padding-left: 7% !important;"><?= format_num($alRow['amount']); ?></td>
                                </tr>
                            <?php
                                $total += $alRow['amount'];
                                endwhile; 
                             ?>
                            <tr>
                                <td class="py-1 px-2 align-middle"><strong>Total <?= $row['name']; ?></strong></td>
                                <td><strong><?= format_num($total) ?></strong></td>
                            </tr>
                        </tbody>
                    <?php endwhile; ?>
                </table>
            </div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
        $('#filter').submit(function(e){
            e.preventDefault()
            location.href="./?page=reports/balance_sheet&"+$(this).serialize();
        })
        $('#print').click(function(){
            start_loader()
            var _h = $('head').clone();
            var _p = $('#outprint').clone();
            var el = $('<div>')
            _h.find('title').text('Balance Sheet - Print View')
            _h.append('<style>html,body{ min-height: unset !important;}</style>')
            el.append(_h)
            el.append(_p)
             var nw = window.open("","_blank","width=900,height=700,top=50,left=250")
             nw.document.write(el.html())
             nw.document.close()
             setTimeout(() => {
                 nw.print()
                 setTimeout(() => {
                     nw.close()
                     end_loader()
                 }, 200);
             }, 500);
        })
		
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
	})
	
</script>