$("#job-form").submit(function(data) {
	if($('input:workorder').val() == '') {
		$('#errors').text('You must specify a workorder number');
		return;
	}
	if($('input:customer').val() == '') {
		$('#errors').text('You must specify a customer name');
		return;
	}
	if($('input:phone').val() == '') {
		$('#errors').text('You must specify a phone number');
		return;
	}
	
	
});