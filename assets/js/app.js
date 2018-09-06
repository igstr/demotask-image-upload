const $ = require('jquery');

require('../css/app.css');

$(document).ready(function() {

    // Change file input label to filename when selected
    $('.custom-file-input').on('input', function() {
        const filename = $(this).val().split('\\').pop();
        $('.custom-file-label').html(filename);
    });

    // Form submit ajax
    $('form.form-image').submit(function(e) {
        e.preventDefault();
        const $this = $(this);
        const formData = new FormData(this);

        $.ajax({
            url: $this.attr('action'),
            data: formData,
            type: 'POST',
            contentType: false,
            processData: false
        })
        .done(function(data) {
            location.reload();
        })
        .fail(function(data) {
            const alert = $this.find('.alert-response');
            if (data.responseJSON && data.responseJSON.errors) {
                alert.html(data.responseJSON.errors.join('<br>')).show();
            } else {
                alert.html('Oops! Something went wrong.').show();
            }
        });
    });
});
