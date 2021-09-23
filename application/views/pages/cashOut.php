<h3>ငွေထုတ် ( <?=$this->ignite_model->get_cashType_name($rate['cashType'])?> )</h3>
<div class="ui divider"></div>

<div class="ui grid">
	<div class="seven wide column">

	<?=form_open('ignite/createCashOut/'.$rate['cashType'], 'class="ui form"')?>

		<div class="field">
			<label>Percentage (%)</label>
			<input type="number" name="cashOutRate" value="<?=$rate['cashOutRate']?>" required />
		</div>

		<div class="field">
			<label>Withdraw Name</label>
			<input type="text" name="withdrawName" placeholder="Eg: Sender Name" required />
		</div>

		<div class="field">
			<label>Account Number / Phone Number</label>
			<input type="number" name="accNum" placeholder="Eg: Account Number (or) Phone Number" required />
		</div>

		<div class="field">
			<label>Amount (MMK)</label>
			<input type="number" name="amount" placeholder="Cash In Amount" required />
		</div>

		<div class="field">
			<label>Remark</label>
			<textarea name="remark"></textarea>
		</div>

		<div class="ui buttons fluid">
		  	<button class="ui button" onclick="urlRequest('ignite/home')">Cancel</button>
		  	<div class="or"></div>
		  	<button class="ui green button" type="submit">Continue</button>
		</div>

	<?=form_close()?>

	</div>
</div>