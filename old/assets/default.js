var job = 0;

$("select").on('change', function() {
    var status_id = this.value;
    var request = $.ajax('http://worklogs.nationalpcpro.com/index.php/settings/getstatuscolor/' + status_id);
    request.done(function(data, status, jqXHR) {
        $('input:text[name=status_color]').val(jqXHR.responseText);
    });
    
});

$(".table_status").click(function() {
	var item = $(this);
	var request = $.ajax('http://worklogs.nationalpcpro.com/index.php/settings/getstatuslist',
	{ dataType: 'json'});
	request.done(function(data) {
		var ele = '<select id="status_change_field" name="status-name">';
		ele += '<option>Please select a status</option>';
		
		for(i = 0; i < data.length; i++) {
			ele += '<option>' + data[i] + '</option>';
		}
		
		ele += '</select>';
		
		if(!item.html().contains('select'))
			item.html(ele);
		
		$("#status_change_field").change(function() {
			var status = this.value;
			job = item.attr('job_id');
			var request = $.post('http://worklogs.nationalpcpro.com/index.php/jobs/setstatus', 
			{ id: job, name: status }, 
			function(data) {
				item.text(status);
			});
		});
	});
});