<h3>New Rate</h3>
<div class="ui divider"></div>

<?php 
	$array = array();
	foreach($cashType as $type){
		array_push($array, $type->cashType);
	}
 ?>
<div class="ui grid">
	<div class="seven wide column">
<?=form_open('ignite/addRate', 'class="ui form"');?>
	
	<div class="field">
		<label class="ui">Type</label>
		<select class="ui dropdown" name="type" required="required">
			<option value="">Select Type</option>
			<option value="KP" <?=in_array('KP', $array)?'disabled':''?>>KBZ Pay</option>
			<option value="WP" <?=in_array('WP', $array)?'disabled':''?>>Wave Pay</option>
			<option value="CP" <?=in_array('CP', $array)?'disabled':''?>>CB Pay</option>
			<option value="MP" <?=in_array('MP', $array)?'disabled':''?>>Mytel Pay</option>
			<option value="AP" <?=in_array('AP', $array)?'disabled':''?>>AYA Pay</option>
			<option value="OK" <?=in_array('OK', $array)?'disabled':''?>>OK Dollar</option>
			<option value="KE" <?=in_array('KE', $array)?'disabled':''?>>KBZ Exchange</option>
			<option value="CE" <?=in_array('CE', $array)?'disabled':''?>>CB Exchange</option>
			<option value="AE" <?=in_array('AE', $array)?'disabled':''?>>AYA Exchange</option>
		</select>
	</div>

	<div class="field">
		<label>Cash In Percent (%)</label>
		<input type="number" name="cashInPercent" placeholder="Type number only. Eg: 5 for 5%" required>
	</div>

	<div class="field">
		<label>Cash Out Percent (%)</label>
		<input type="number" name="cashOutPercent" placeholder="Type number only. Eg: 5 for 5%" required>
	</div>

	<div class="field">
		<label>Remark</label>
		<textarea name="remark"></textarea>
	</div>

	<div class="ui buttons fluid">
	  	<button class="ui button" onclick="urlRequest('ignite/rates')">Cancel</button>
	  	<div class="or"></div>
	  	<button class="ui green button" type="submit">Save</button>
	</div>

<?=form_close()?>
	</div>
</div>