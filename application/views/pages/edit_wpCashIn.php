<h3>ပြန်လည်ပြင်ဆင်ရန် ( ငွေသွင်း / ငွေလွှဲ )</h3>
<div class="ui divider"></div>

<div class="ui grid">
	<div class="seven wide column">

		<div class="ui top attached tabular menu grey">
		  	<div class="<?=$cashIn['transferType'] === 'A'?'active':''?> item" data-tab="A-to-A">Acc to Acc</div>
		  	<div class="<?=$cashIn['transferType'] === 'B'?'active':''?> item" data-tab="password">Password</div>
		</div>

		<div class="ui bottom attached tab segment <?=$cashIn['transferType'] === 'A'?'active':''?>" data-tab="A-to-A">

			<?=form_open('ignite/modifyCashIn/'.$cashIn['cashIn_id'], 'class="ui form"')?>

			<div class="field">
				<label>Percentage (%)</label>
				<input type="number" name="payBackPercent" value="<?=$cashIn['transferType'] === 'A'?$cashIn['payBackPercent']:''?>" required />
			</div>

			<div class="field">
				<label>Sender Name</label>
				<input type="text" name="senderName" placeholder="Eg: Sender Name" value="<?=$cashIn['transferType'] === 'A'?$cashIn['senderName']:''?>" required />
			</div>

			<div class="field">
				<label>Receipent Phone Number</label>
				<input type="number" name="accNum" placeholder="Eg: Phone Number" value="<?=$cashIn['transferType'] === 'A'?$cashIn['r_accNum']:''?>" required />
			</div>

			<div class="field">
				<label>Amount (MMK)</label>
				<input type="number" name="amount" placeholder="Cash In Amount" value="<?=$cashIn['transferType'] === 'A'?$cashIn['amount']:''?>" required />
			</div>

			<div class="field">
				<label>Remark</label>
				<textarea name="remark" value="<?=$cashIn['transferType'] === 'A'?$cashIn['remark']:''?>"></textarea>
			</div>

			<div class="ui buttons fluid">
			  	<button class="ui button" onclick="urlRequest('ignite/home')">Cancel</button>
			  	<div class="or"></div>
			  	<button class="ui green button" type="submit">Continue</button>
			</div>

			<?=form_close()?>

		</div>

		<div class="ui bottom attached tab segment <?=$cashIn['transferType'] === 'B'?'active':''?>" data-tab="password">

			<?=form_open('ignite/modifyWavePswCashIn/'.$cashIn['cashIn_id'], 'class="ui form"')?>

			<div class="field">
				<label>Percentage (%)</label>
				<input type="number" name="payBackPercent" value="<?=$cashIn['transferType'] === 'B'?$cashIn['payBackPercent']:''?>" required />
			</div>

			<div class="field">
				<label>Sender Name</label>
				<input type="text" name="senderName" placeholder="Eg: Sender Name" value="<?=$cashIn['transferType'] === 'B'?$cashIn['senderName']:''?>" required />
			</div>

			<div class="field">
				<label>Sender Phone Number</label>
				<input type="number" name="s_accNum" placeholder="Eg: Phone Number" value="<?=$cashIn['transferType'] === 'B'?$cashIn['s_accNum']:''?>" required />
			</div>

			<div class="field">
				<label>Receipent Phone Number</label>
				<input type="number" name="r_accNum" placeholder="Eg: Phone Number" value="<?=$cashIn['transferType'] === 'B'?$cashIn['r_accNum']:''?>" required />
			</div>

			<div class="field">
				<label>Password</label>
				<input type="number" name="psw" placeholder="(Must be 6 digit) Eg: 123456" value="<?=$cashIn['transferType'] === 'B'?$cashIn['password']:''?>" required />
			</div>

			<div class="field">
				<label>Amount (MMK)</label>
				<input type="number" name="amount" placeholder="Cash In Amount" value="<?=$cashIn['transferType'] === 'B'?$cashIn['amount']:''?>" required />
			</div>

			<div class="field">
				<label>Remark</label>
				<textarea name="remark" value="<?=$cashIn['transferType'] === 'B'?$cashIn['remark']:''?>"></textarea>
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