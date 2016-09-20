var baseURI = 'http://localhost/worklogs/public/index.php/';
var timeoutId = 0;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(registerEvents);

function registerEvents() {
    $('#job_filter').change(filterJobs);
    $('input[name=q]').keydown(searchJobs);
    $('a[title=Delete]').click(showDeleteJobOverlay);
    $('a[title=Close]').click(function() {
        var id = $(this).attr('rel');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post(baseURI + 'api/closejob/' + id).done(function() {
            $('tr[rel=' + id + ']').remove();
        });
    });
}

function filterJobs() {
    var str = $("#job_filter").val();

    if(str == '0') {
        location.href = baseURI;
    }
    else {
        location.href = baseURI + 'jobs/status/' + str;
    }
}

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

function searchJobs() {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(fetchSearchResults, 500);
}

function fetchSearchResults() {
    var str = $('input[name=q]').val();
    $.get(baseURI + 'search', { query: str}).done(function(data) {
        $('.container.floating-box-95.no-top-pad').remove();
        $('.container.col-95.pad-25p.no-bottom-pad').after(data);
    });
    clearTimeout(timeoutId);
}

function showDeleteJobOverlay() {
    var popup = $('.popup-overlay');
    var content = $('.popup-editable-content');
    var id = $('a[title=Delete]').attr('rel');

    var str = '<span class="popup-title">Are you sure you wish to delete this entry?</span>';
    str += '<p class="popup-buttons"><a class="button danger" href="javascript:deleteJob(' + id + ')">Yes</a> <a class="button" href="javascript:hideOverlay()">No</a>';
    content.html(str);
    popup.css('display', 'block');
}

function deleteJob(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post(baseURI + 'delete/' + id, {reallydelete: 'yes'}).done(function() {
        hideOverlay();
        $('tr[rel=' + id + ']').remove();
    });
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

        var str = '<span class="popup-title">Current status</span><br />';
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
            $.post(baseURI + 'api/setjobstatus/' + id, { value: name }).done(function() {
                hideOverlay();
                location.reload();
            });
        });
        popup.css('display', 'block');
    });
}

function hideOverlay() {
    var popup = $('.popup-overlay');
    var content = $('.popup-editable-content');
    content.html('<h3>Nothing to see here</h3>');
    popup.css('display', 'none');
}
