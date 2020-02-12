$(document).ready(function() {
	var options = {
	url: "countries.json",

	getValue: "name",

	list: {
		maxNumberOfElements: 10,
		match: {
			enabled: true
		},
		onClickEvent: function() {
			alert("Click !");
		},
	}
	
};

$("#provider-json").easyAutocomplete(options);

				});

