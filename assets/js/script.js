$(function () {
    var $form = $('#billForm');
    var $units = $('#units');
    var $clientError = $('#clientError');

    $form.on('submit', function (event) {
        var raw = $.trim($units.val());

        if (raw === '') {
            event.preventDefault();
            $clientError.text('Please enter consumed units before calculating.').removeClass('d-none');
            $units.trigger('focus');
            return;
        }

        var value = Number(raw);

        if (!Number.isFinite(value) || value < 0) {
            event.preventDefault();
            $clientError.text('Units should be a valid non-negative number.').removeClass('d-none');
            $units.trigger('focus');
            return;
        }

        $clientError.addClass('d-none').text('');
    });

    $units.on('input', function () {
        if (!$clientError.hasClass('d-none')) {
            $clientError.addClass('d-none').text('');
        }
    });
});
