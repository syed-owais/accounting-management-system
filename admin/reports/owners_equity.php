<?php
function format_num($number){
	$decimals = 0;
	$num_ex = explode('.',$number);
	$decimals = isset($num_ex[1]) ? strlen($num_ex[1]) : 0 ;
	return '$'.number_format($number,$decimals);
}
$from = isset($_GET['from']) ? $_GET['from'] : date("Y-m-d",strtotime(date('Y-m-d')." -1 week"));
$to = isset($_GET['to']) ? $_GET['to'] : date("Y-m-d");

$queryOwnerCapital = "SELECT al.name, sum(ji.amount) capital FROM journal_items JI 
                        JOIN journal_entries je ON je.id = ji.journal_id
                        JOIN account_list AL ON AL.ID = JI.account_id
                        WHERE JI.group_id = 5
                        AND date(je.journal_date) < concat(YEAR('".date("Y-m-d" , strtotime($to))."') , '-01-01') 
                        GROUP BY al.name";

$ownersCapitalStart = (float) ($conn->query($queryOwnerCapital)->fetch_object()->capital ?? 0);

$queryNetIncome = "SELECT sum(amount) net_income FROM (
                        SELECT al.name, sum(ji.amount) amount FROM journal_items JI 
                        JOIN journal_entries je ON je.id = ji.journal_id
                        JOIN account_list AL ON AL.ID = JI.account_id
                        WHERE JI.group_id in(2)
                        AND date(je.journal_date) <= '{$to}' 
                        GROUP BY al.name
                        union all
                        SELECT al.name, sum(ji.amount)*-1 amount FROM journal_items JI 
                        JOIN journal_entries je ON je.id = ji.journal_id
                        JOIN account_list AL ON AL.ID = JI.account_id
                        WHERE JI.group_id in(3)
                        AND date(je.journal_date) <= '{$to}' 
                        GROUP BY al.name
                    )AS tr";

$netIncome = (float) ($conn->query($queryNetIncome)->fetch_object()->net_income ?? 0);

$queryOwnersWithdrawals = "SELECT al.name, sum(ji.amount) owners_withdrawals FROM journal_items JI 
                    JOIN journal_entries je ON je.id = ji.journal_id
                    JOIN account_list AL ON AL.ID = JI.account_id
                    WHERE AL.id = 15
                    AND date(je.journal_date) <= '{$to}' 
                    GROUP BY al.name;";

$ownersWithdrawals = (float) ($conn->query($queryOwnersWithdrawals)->fetch_object()->owners_withdrawals ?? 0);

$subtotal = $ownersCapitalStart + $netIncome;
$total = $subtotal - $ownersWithdrawals;

?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Owner's Equity</h3>
		<div class="card-tools">
		</div>
	</div>
	<div class="card-body">
        <div class="callout border-primary shadow rounded-0">
            <h4 class="text-muted">Filter Date</h4>
            <form action="" id="filter">
            <div class="row align-items-end">
                <!-- <div class="col-md-4 form-group">
                    <label for="from" class="control-label">Date From</label>
                    <input type="date" id="from" name="from" value="<?= $from ?>" class="form-control form-control-sm rounded-0">
                </div> -->
                <div class="col-md-4 form-group">
                    <label for="to" class="control-label">Date</label>
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
            <h4 class="text-center"><b>Owner's Equity</b></h4>
            <p class="m-0 text-center"><?= date("M d, Y" , strtotime($to)) ?></p>
            <hr>
			<div class="col-md-12">
                <table class="table table-hover table-bordered">
                    
                        <colgroup>
                        <col width="70%">
                        <col width="30%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="py-1 px-2 align-middle" >Capital</th>
                                <th class="py-1 px-2 align-middle" ><?= format_num($ownersCapitalStart); ?></th>
                            </tr>
                            <tr>
                                <th class="py-1 px-2 align-middle" >Net Income</th>
                                <th class="py-1 px-2 align-middle" ><?= format_num($netIncome); ?></th>
                            </tr>
                            <tr>
                                <th class="py-1 px-2 align-middle" >Subtotal</th>
                                <th class="py-1 px-2 align-middle" ><?= format_num($subtotal); ?></th>
                            </tr>
                            <tr>
                                <th class="py-1 px-2 align-middle" >Owner's Drawings</th>
                                <th class="py-1 px-2 align-middle" ><?= format_num($ownersWithdrawals); ?></th>
                            </tr>
                        </thead>
                </table>
            </div>
            <div class='row'>
                <div class="col-md-4">
                    <h1>Capital Till Date: <?= format_num($total)?></h1>
                </div>
            </div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
        $('#filter').submit(function(e){
            e.preventDefault()
            location.href="./?page=reports/owners_equity&"+$(this).serialize();
        })
        $('#print').click(function(){
            start_loader()
            var _h = $('head').clone();
            var _p = $('#outprint').clone();
            var el = $('<div>')
            _h.find('title').text('Owner\'s Equity - Print View')
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