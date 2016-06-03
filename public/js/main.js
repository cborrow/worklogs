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
    var curStatus = 'In Progress';
    var statusList = [];

    $.ajax('/ajax/getjobstatus/' + id).done(function(data) {
        curStatus = data;
    });
    $.ajax('/ajax/getstatuslist').done(function(data) {
        statusList = data;
    });

    content.html('<form action="/ajax/updatestatus/"' + id ' >
    <p>
        <option name="status">'
        for(var item in statusList) {
            + '<li>' + item + '</li>'
        }
        + '</option>
    </p>
    </form>');
    popup.css('display', 'block');
}

function hideOverlay() {
    var popup = $('.popup-overlay');
    popup.css('display', 'none');
}
