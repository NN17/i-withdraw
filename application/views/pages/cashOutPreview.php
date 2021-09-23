<h3>Cash Out Preview</h3>
<div class="ui divider"></div>

<?php 
	$withdrawRate = $cashOut->amount * ($cashOut->cashOutRate / 100);
 ?>

<div class="ui two center aligned stackable cards">
	<div class="card green">
		<div class="content">
		    <div class="header"><?=$this->ignite_model->get_cashType_name($cashOut->cashType)?> ( Cash Out )</div>
		    <div class="meta"><?=sprintf('%05d', $cashOut->cashOut_id).'-'.date('dym')?></div>
		</div>
	  	<div class="content">
	  		<div class="right aligned">
	  			Date: <?=date('d/M/Y (h:i A)')?>
	  		</div>
	  		<div class="">
	  			Name : <?=$cashOut->withdrawName?><br/>
	  			<?=$cashOut->acc?>
	  			
	  		</div>
	      	<table class="ui table preview">
	      		<?php if($cashOut->withdrawType === "B"): ?>
	      		<tr>
	      			<td>Withdraw ID:</td>
	      			<td class="right aligned red"><?=$cashOut->withdrawID?></td>
	      		</tr>
	      		<tr>
	      			<td>Password</td>
	      			<td class="right aligned"><?=$cashOut->password?></td>
	      		</tr>
	      		<?php endif; ?>
	      		<tr>
	      			<td>Withdraw Amount</td>
	      			<td class="right aligned"><strong><?=number_format($cashOut->amount)?></strong></td>
	      		</tr>
	      		
	      		<tr>
	      			<td>Withdraw Rate</td>
	      			<td class="right aligned"><?=number_format($withdrawRate)?></td>
	      		</tr>
	      			
	      		<tr>
	      			<td>Balance</td>
	      			<td class="right aligned"><strong><?=number_format(($cashOut->amount) - ($withdrawRate))?></strong></td>
	      		</tr>
	      	</table>
	    </div>
	    <div class="ui buttons">
	    	<div class="ui button" onclick="urlRequest('ignite/editCashOut/<?=$cashOut->cashOut_id?>')">
	    		<i class="edit icon"></i>
	    		Edit
	    	</div>
		    <div class="ui bottom green attached button" onclick="receipt_modal()">
		      	<i class="sign-out icon"></i>
		      	Check Out
		    </div>
		</div>
	</div>
</div>

<!-- Receipt Modal -->
<div class="ui modal receipt">
  	<div class="header">
  		<?=$this->ignite_model->get_cashType_name($cashOut->cashType).' ( '.$cashOut->cashOutRate.' % )'?>
  	</div>
  	<div class="content">
    	<div class="receipt-head center aligned">
    		<h3>Commercial Receipt</h3>
    	</div>
    	<div class="right aligned">
    		<p class="text-right"><?='CI-'.sprintf('%05d', $cashOut->cashOut_id).'-'.date('ydm')?></p>
    		<p class="text-right"><?=date('d-m-Y h:i A')?></p>
    	</div>
    	<div>
    		<p>Customer Name : <?=$cashOut->withdrawName?></p>
    	</div>
    	<div class="ui divider"></div>
    	<div class="receipt-content">
    		<table class="ui table no-border preview">
    			<tr>
    				<td>Account</td>
    				<td class="right aligned"><?=$cashOut->acc?></td>
    			</tr>
    			<?php if($cashOut->withdrawType === "B"): ?>
    			<tr>
    				<td>Withdraw ID:</td>
    				<td class="right aligned"><?=$cashOut->withdrawID?></td>
    			</tr>
    			<tr>
    				<td>Password</td>
    				<td class="right aligned"><?=$cashOut->password?></td>
    			</tr>
    			<?php endif; ?>
    			<tr>
    				<td>Withdraw Amount</td>
    				<td class="right aligned"><?=number_format($cashOut->amount)?></td>
    			</tr>
    			<tr>
    				<td>Withdraw Rate</td>
    				<td class="right aligned"><?=number_format($withdrawRate)?></td>
    			</tr>
    			<tr>
    				<td class="right aligned"><strong>Total<strong></td>
    				<td class="right aligned"><strong><?=number_format($cashOut->amount - $withdrawRate)?></strong></td>
    			</tr>
    			<tr class="ui form">
    				<td class="right aligned"><strong>Discount</strong></td>
    				<td class="right aligned discount-input"><input type="text" id="discount" onkeyup="addDiscount(<?=($cashOut->amount) - $withdrawRate?>,<?=$cashOut->cashOut_id?>, 'OUT')" /></td>
    			</tr>
    			<tr class="ui form">
    				<td class="right aligned"><strong>Grand Total</strong></td>
    				<td class="right aligned"><input type="text" value="<?=number_format($cashOut->amount - $withdrawRate)?>" id="gTotal" disabled="disabled" /></td>
    			</tr>
    		</table>
    	</div>
  	</div>
  	<div class="actions">
    	<div class="ui cancel button">Cancel</div>
    	<div class="ui button green" id="print" onclick="urlRequest('ignite/printReceipt/OUT/<?=$cashOut->cashOut_id?>/0')"><i class="print icon"></i> Print Receipt</div>
  	</div>
</div>