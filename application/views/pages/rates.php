<div class="ui items">
	<div class="item">
		<div class="ui content">
			<h3 class="ui left floated header">နှုန်းထားများ</h3>
		</div>
		<div class="btn">
			<button class="ui right floated olive button" onclick="urlRequest('ignite/newRate')">New</button>
		</div>
	</div>
</div>

<div class="ui divider"></div>


<table class="ui celled striped table mid-margin">
	<thead>
		<tr>
			<th>..</th>
			<th>Cash Type</th>
			<th class="right aligned">Cash In Percent (%)</th>
			<th class="right aligned">Cash Out Percent (%)</th>
			<th>Remark</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$counter = 1;
			foreach($rates as $row): 
		?>
			<tr>
				<td><?=$counter?></td>
				<td><?=$this->ignite_model->get_cashType_name($row->cashType)?></td>
				<td class="right aligned"><?=$row->cashInRate?></td>
				<td class="right aligned"><?=$row->cashOutRate?></td>
				<td><?=$row->remark?></td>
			</tr>
		<?php 
			$counter++;
			endforeach; 
		?>
	</tbody>
</table>