function base_url() {
	return "http://" + location.hostname + "/codesemantic/";
}

setInterval(() => {
    isOnline();
}, 5000);

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

function isOnline(no, yes) {
	var xhr = XMLHttpRequest
		? new XMLHttpRequest()
		: new ActiveXObject("Microsoft.XMLHttp");
	xhr.onload = function() {
		if (yes instanceof Function) {
			yes();
		}
	};
	xhr.onerror = function() {
		if (no instanceof Function) {
			no();
		}
	};
	xhr.open("GET", "anypage.php", true);
	xhr.send();
}

isOnline(
	function() {
		alert("Sorry, we currently do not have Internet access.");
	},
	function() {
		alert("Succesfully connected!");
	}
);
