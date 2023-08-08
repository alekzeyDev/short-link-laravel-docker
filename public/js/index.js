
// Create form submit
$('#generate_form').on('submit', function (e) {
    e.preventDefault();

    let form = e.currentTarget;
    let action  = form.action;
    let data = $(form).serialize();

    $.ajax({
        url: action,
        type: "POST",
        data: data,
        success: function (response) {
            let title = response.message;
            toastr['success'](title, 'Success!');
            $('#for_short_link').html(response.link);
            $('#for_short_link').removeAttr('hidden');
            $('.form-control').prop( "disabled", true );
        },
        error: function (response) {
            let title = response.responseJSON.message;
            let err = response.responseJSON.errors;
            let msg = [];
            $.each(err, function(idx,val) {
                msg.push(val);
            });
            toastr['error'](msg.join('<br>'), title);
        },
    });
});

// Copy link to clipboard
$('.message-container').on('click',function (e) {
    let link = $('#for_short_link');
    if (link.html()) {
        link.select();
        navigator.clipboard.writeText(link.html());
        toastr['success']('The link has been copied to the clipboard', 'Success!');
    } else {
        toastr['warning']('Nothing to copy(((', 'Copy error!');
    }
});

// Reset form
$('#reset_button').on('click',function (e) {
    e.preventDefault();
    e.stopPropagation();
    $('.form-control').prop("disabled", false);
    $('#generate_form').trigger("reset");
});
