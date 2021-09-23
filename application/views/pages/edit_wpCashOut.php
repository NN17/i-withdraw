<h3>ပြန်လည်ပြင်ဆင်ရန် ( <?=$this->ignite_model->get_cashType_name($cashOut->cashType)?> )</h3>
<div class="ui divider"></div>

<div class="ui grid">
	<div class="seven wide column">

		<div class="ui top attached tabular menu grey">
		  	<div class="active item" data-tab="A-to-A">Acc to Acc</div>
		  	<div class="item" data-tab="password">Password</div>
		</div>

		<div class="ui bottom attached active tab segment" data-tab="A-to-A">

			<?=form_open('ignite/updateCashOut/'.$cashOut->cashType.'/'.$cashOut->cashOut_id, 'class="ui form"')?>

			<div class="field">
				<label>Percentage (%)</label>
				<input type="number" name="cashOutRate" value="<?=$cashOut->cashOutRate?>" required />
			</div>

			<div class="field">
				<label>Withdraw Name</label>
				<input type="text" name="withdrawName" placeholder="Eg: Withdraw Name" value="<?=$cashOut->withdrawName?>" required />
			</div>

			<div class="field">
				<label>Account Number / Phone Number</label>
				<input type="number" name="accNum" value="<?=$cashOut->acc?>" placeholder="Eg: Account Number (or) Phone Number" required />
			</div>

			<div class="field">
				<label>Amount (MMK)</label>
				<input type="number" name="amount" value="<?=$cashOut->amount?>" placeholder="Cash In Amount" required />
			</div>

			<div class="field">
				<label>Remark</label>
				<textarea name="remark" value="$cashOut->remark"></textarea>
			</div>

			<div class="ui buttons fluid">
			  	<button class="ui button" onclick="urlRequest('ignite/home')">Cancel</button>
			  	<div class="or"></div>
			  	<button class="ui green button" type="submit">Continue</button>
			</div>

			<?=form_close()?>

		</div>

		<div class="ui bottom attached tab segment" data-tab="password">

			<?=form_open('ignite/updateWPCashOut/'.$cashOut->cashType.'/'.$cashOut->cashOut_id, 'class="ui form"')?>

			<div class="field">
				<label>Percentage (%)</label>
				<input type="number" name="rate" value="<?=$cashout->cashOutRate?>" required />
			</div>

			<div class="field">
				<label>Withdraw Name</label>
				<input type="text" name="withdrawName" value="<?=$cashOut->withdrawName?>" placeholder="Eg: Withdraw Name" required />
			</div>

			<div class="field">
				<label>Phone Number / Account Number</label>
				<input type="number" name="acc" value="<?=$cashOut->acc?>" placeholder="Eg: Phone Number" required />
			</div>

			<div class="field">
				<label>Withdraw ID:</label>
				<input type="number" name="withdrawId" value="<?=$cashOut->withdrawID?>" placeholder="Eg: Withdraw ID" required />
			</div>

			<div class="field">
				<label>Password</label>
				<input type="number" name="psw" value="<?=$cashOut->password?>" placeholder="(Must be 6 digit) Eg: 123456" maxlength="6" required />
			</div>

			<div class="field">
				<label>Amount (MMK)</label>
				<input type="number" name="amount" value="<?=$cashOut->amount?>" placeholder="Cash In Amount" required />
			</div>

			<div class="field">
				<label>Remark</label>
				<textarea name="remark" value="<?=$cashOut->remark?>"></textarea>
			</div>

			<div class="ui buttons fluid">
			  	<button class="ui button" onclick="urlRequest('ignite/home')">Cancel</button>
			  	<div class="or"></div>
			  	<button class="ui green button" type="submit">Continue</button>
			</div>

			<?=form_close()?>

		</div>

	

	</div>
</div>