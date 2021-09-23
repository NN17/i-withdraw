<h3>Preview Cash In</h3>
<div class="ui divider"></div>

<?php 
	$payBackAmt = $cashInData['amount']*($cashInData['payBackPercent']/100);

	if($cashInData['transferType'] === 'B'){
		$tranCharges = $this->ignite_model->waveTransferRate($cashInData['amount']);
	}else{
		$tranCharges = 0;
	}
?>
<div class="ui two center aligned stackable cards">
	<div class="card green">
		<div class="content">
		    <div class="header"><?=$this->ignite_model->get_cashType_name($cashInData['cashType'])?> ( <?=$cashInData['transferType']=='A'?'Account':'Password'?> )</div>
		    <div class="meta"><?=sprintf('%05d', $cashInData['cashIn_id']).'-'.date('dym')?></div>
		</div>
	  	<div class="content">
	  		<div class="right aligned">
	  			Date: <?=date('d/M/Y (h:i A)')?>
	  		</div>
	  		<div class="">
	  			Name : <?=$cashInData['senderName']?><br/>
	  			<?=$cashInData['transferType'] == 'A'?'Acc / Ph : '.$cashInData['r_accNum']:''?>
	  			
	  		</div>
	      	<table class="ui table preview">
	      		<?php if($cashInData['transferType'] === "B"):?>
	      		<tr>
	      			<td>Sender Phone Number</td>
	      			<td class="right aligned"><strong><?=$cashInData['s_accNum']?></strong></td>
	      		</tr>
	      		<tr>
	      			<td>Recipient Phone Number</td>
	      			<td class="right aligned"><strong><?=$cashInData['r_accNum']?></strong></td>
	      		</tr>
	      		<tr>
	      			<td>Password</td>
	      			<td class="right aligned"><strong><?=$cashInData['password']?></strong></td>
	      		</tr>
	      		<?php endif; ?>
	      		<tr>
	      			<td>Transfer Amount</td>
	      			<td class="right aligned"><strong><?=number_format($cashInData['amount'])?></strong></td>
	      		</tr>
	      		<?php if($cashInData['transferType'] === "B"): ?>
	      		<tr>
	      			<td>Transfer Charges</td>
	      			<td class="right aligned"><?=number_format($tranCharges)?></td>
	      		</tr>
	      		<?php endif; ?>
	      		<tr>
	      			<td>Pay Back Amount</td>
	      			<td class="right aligned"><?=number_format($payBackAmt)?></td>
	      		</tr>
	      			
	      		<tr>
	      			<td>Balance</td>
	      			<td class="right aligned"><strong><?=number_format(($cashInData['amount'] + $tranCharges) - ($payBackAmt))?></strong></td>
	      		</tr>
	      	</table>
	    </div>
	    <div class="ui buttons">
	    	<div class="ui button" onclick="urlRequest('ignite/editCashIn/<?=$cashInData["cashIn_id"]?>')">
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
  		<?=$this->ignite_model->get_cashType_name($cashInData['cashType'])?>
  	</div>
  	<div class="content">
    	<div class="receipt-head center aligned">
    		<h3>Commercial Receipt</h3>
    	</div>
    	<div class="right aligned">
    		<p class="text-right"><?='CI-'.sprintf('%05d', $cashInData['cashIn_id']).'-'.date('ydm')?></p>
    		<p class="text-right"><?=date('d-m-Y h:i A')?></p>
    	</div>
    	<div>
    		<p>Customer Name : <?=$cashInData['senderName']?></p>
    	</div>
    	<div class="ui divider"></div>
    	<div class="receipt-content">
    		<table class="ui table no-border preview">
    			<?php if($cashInData['transferType'] === 'A'): ?>
    			<tr>
    				<td>Account</td>
    				<td class="right aligned"><?=$cashInData['r_accNum']?></td>
    			</tr>
    			<?php else: ?>
    			<tr>
    				<td>From Account</td>
    				<td class="right aligned"><?=$cashInData['s_accNum']?></td>
    			</tr>
    			<tr>
    				<td>To Account</td>
    				<td class="right aligned"><?=$cashInData['r_accNum']?></td>
    			</tr>
    			<tr>
    				<td>Password</td>
    				<td class="right aligned"><?=$cashInData['password']?></td>
    			</tr>
    			<?php endif; ?>
    			<tr>
    				<td>Transfer Amount</td>
    				<td class="right aligned"><?=number_format($cashInData['amount'])?></td>
    			</tr>
    			<?php if($cashInData['transferType'] === 'B'): ?>
    			<tr>
    				<td>Service Charges</td>
    				<td class="right aligned"><?=number_format($tranCharges)?></td>
    			</tr>
    			<?php endif; ?>
    			<tr>
    				<td>Pay Back Amount</td>
    				<td class="right aligned"><?=number_format($payBackAmt)?></td>
    			</tr>
    			<tr>
    				<td class="right aligned"><strong>Total<strong></td>
    				<td class="right aligned"><strong><?=number_format(($cashInData['amount'] + $tranCharges) - $payBackAmt)?></strong></td>
    			</tr>
    			<tr class="ui form">
    				<td class="right aligned"><strong>Discount</strong></td>
    				<td class="right aligned discount-input"><input type="text" id="discount" onkeyup="addDiscount(<?=($cashInData['amount'] + $tranCharges) - $payBackAmt?>,<?=$cashInData['cashIn_id']?>, 'IN')" /></td>
    			</tr>
    			<tr class="ui form">
    				<td class="right aligned"><strong>Grand Total</strong></td>
    				<td class="right aligned"><input type="text" value="<?=number_format($payBackAmt + $cashInData['amount'])?>" id="gTotal" disabled="disabled" /></td>
    			</tr>
    		</table>
    	</div>
  	</div>
  	<div class="actions">
    	<div class="ui cancel button">Cancel</div>
    	<div class="ui button green" id="print" onclick="urlRequest('ignite/printReceipt/IN/<?=$cashInData['cashIn_id']?>/0')"><i class="print icon"></i> Print Receipt</div>
  	</div>
</div>