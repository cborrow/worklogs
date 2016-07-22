var baseURI = 'http://localhost/worklogs/public/index.php/';

function showOverlay() {
    var popup = $('.popup-overlay');
    popup.css('display', 'block');
}

function showPassword(str) {
    var popup = $('.popup-overlay');
    var content = $('.popup-editable-content');
    content.html('<h2 class="subdue-gray" style="text-align: center">Users password</h2><h1 style="font-size: 32pt; text-align: center;">' + str + '</h1>');
    popup.css('display', 'block');
}

function changeJobStatus(id) {
    var popup = $('.popup-overlay');
    var content = $('.popup-editable-content');
    var curStatus = 'Status not set';
    var statusList = [];
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax(baseURI + 'api/getjobstatus/' + id, { async: false }).done(function(data) {
        curStatus = data;
    });
    $.ajax(baseURI + 'api/getstatuslist', { dataType: "json" }).done(function(data) {
        statusList = data;

        var str = '<span style="font-size: 18pt;">Current status</span><br />';
        str += '<span style="font-size: 14pt;">' + curStatus + '</span><br /><br />';
        str += '<select id="change-status" name="status">';
        for(i = 0; i < statusList.length; i++) {
            var s = (statusList[i].name == curStatus) ? 'selected="selected"' : '';
            str += '<option ' + s + ' value=' + statusList[i].id + '>' + statusList[i].name + '</option>';
        }
        str += '</select>';
        content.html(str);

        $("#change-status").change(function() {
            var name = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post(baseURI + 'api/setjobstatus/' + id, { value: name }).done(function() {
                hideOverlay();
                content.html('You\'re not supposed to see this.');
                location.reload();
            });
        });
        popup.css('display', 'block');
    });
}

function hideOverlay() {
    var popup = $('.popup-overlay');
    popup.css('display', 'none');
}
