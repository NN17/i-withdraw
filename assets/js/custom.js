function base_url() {
	return "http://" + location.hostname + "/i_withdraw/";
}

$(document).ready(function() {
	$(".ui.dropdown").dropdown();
	$(".menu .item").tab();
	$(":input[type='number']:enabled:visible:first").focus();


	/*
	 * DateTime Picker
	 */
	$("[id=datepicker]").datetimepicker({
		timepicker: false,
		format: "Y-m-d",
		formatDate: "Y-m-d",
		closeOnDateSelect: true
	});

	$("[id=btnChangePrice]").on("click", function() {
		var id = $(this).data("itemid");
		var price = $("#price" + id).val();
		var qty = $("#qty" + id).val();
		var token = $(this).data("token");
		if (price != "" && qty != "") {
			$.ajax({
				url: base_url() + "ignite/changeOrder/" + id,
				type: "POST",
				crossDomain: "TRUE",
				data: {
					csrf_code_semantic_token: token,
					price: price,
					qty: qty
				},
				done: location.reload()
			});
		} else {
			$.dialog({
				title: "Alert!",
				content: "Price & Qty must not be null!",
				type: "green",
				typeAnimated: true,
				boxWidth: "30%",
				useBootstrap: false
			});
		}
	});
});

function urlRequest(url, type=""){
	window.location.href = url + "/" + type;
}

function receipt_modal(){
	$('.receipt.modal')
		.modal({'closable': false})
	  	.modal('show')
	;
}

function addDiscount(total, id, type){
	var discount  = $('#discount').val();

	if(discount == ''){
		discount = 0;
	}

	if(type == 'IN'){
		var gTotal = parseInt(total) - parseInt(discount);
	}
		else{
			var gTotal = parseInt(total) + parseInt(discount);
		}

	$('#gTotal').val(Intl.NumberFormat().format(gTotal));
	$('#print').attr('onclick', "urlRequest('ignite/printReceipt/"+ type + "/" + id + "/" + parseInt(discount) +"')");
}


