var baseURI = 'http://localhost/worklogs/public/index.php/';
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(".color-block").change(function() {
    var cval = $(this).val();
    var id = $(this).attr('rel');
    $(this).css('background-color', cval);
    $.post(baseURI + 'api/setstatuscolor/' + id, { color: cval }).done(function(data) {});
});

$('.status-name').dblclick(function() {
    $(this).attr('contenteditable', 'true');
});
$('.status-name').keydown(function(e) {
    var id = $(this).attr('rel');
    var sName = $(this).text();

    if(e.keyCode == 13) {
        e.preventDefault();
        $(this).attr('contenteditable', 'false');
        $.post(baseURI + 'api/setstatusname/' + id, { name: sName }).done(function (data) {  });
    }
});
$('#add-status').click(function() {
    var str = $('input[name=status-name]').val();
    $.post(baseURI + 'api/addstatus/', { name: str, color: '#3da601'}).done(function(data) {
        var item = document.createElement('li');
        var colorPickerNode = document.createElement('input');
        colorPickerNode.setAttribute('type', 'color');
        colorPickerNode.setAttribute('class', 'color-block');
        colorPickerNode.setAttribute('value', '#3da601');
        colorPickerNode.style.backgroundColor = '#3da601';
        item.appendChild(colorPickerNode);

        var statusNameNode = document.createElement('span');
        statusNameNode.setAttribute('class', 'status-name');
        statusNameNode.setAttribute('rel', '0');

        var statusNameNodeText = document.createTextNode(str);
        statusNameNode.appendChild(statusNameNodeText);
        item.appendChild(statusNameNode);

        var deleteLinkNode = document.createElement('span');
        deleteLinkNode.setAttribute('class', 'right');
        deleteLinkNode.innerHTML = '<a href="#"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
        item.appendChild(deleteLinkNode);

        $('.non-colored-background').before(item);
    });
});
