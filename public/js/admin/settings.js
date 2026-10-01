  
(function($){

    "use strict";
    
    //active
    $('#settings').addClass('active');

    //select2
    $('.select2').select2();

    // SMS gateway fieldset toggle
    function toggleSmsGatewayFields() {
        var gateway = $('#active_gateway').val() || 'mram';
        $('#bulksmsbd_gateway_fields, #mram_gateway_fields').hide();
        $('#' + gateway + '_gateway_fields').show();
    }
    $('#active_gateway').on('change', toggleSmsGatewayFields);
    toggleSmsGatewayFields();

    //Colorpicker for email header
    $('#header_color').colorpicker();
    
    $('#header_color').on('colorpickerChange', function(event) {
            $('.header_color .fa-square').css('color', event.color.toString());
    });


    //Colorpicker for email footer
    $('#footer_color').colorpicker();
    
    $('#footer_color').on('colorpickerChange', function(event) {
            $('.footer_color .fa-square').css('color', event.color.toString());
    });

    //color picker
    $('.color_input').each(function(){
        $(this).colorpicker();
    });

    $('.color_input').on('colorpickerChange', function(event) {
        $(this).next('.color_tool').find('.fa-square').css('color', event.color.toString());
    });

    $('form').each(function () {
        if ($(this).data('validator'))
            $(this).data('validator').settings.ignore = ".note-editor *";
    });

    // Summernote
    $('.summernote').summernote({
        heigt:400,
        tooltip: false,
        dialogsFade: true,
        toolbar: []
    });

    // $('#report_footer').summernote({
    //     heigt:400,
    //     tooltip: false,
    //     dialogsFade: true,
    //     toolbar: [
    //         ['para', ['paragraph']],
    //     ]
    // });

    // Custom File Input label update
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    // Booking notification recipient rows: add/remove without a dependency.
    var $bookingEmailRows = $('#booking-email-rows');
    var $bookingEmailTemplate = $('#booking-email-row-template');

    function syncBookingEmailEmptyNote() {
        var empty = $bookingEmailRows.find('.booking-email-row').length === 0;
        $('#booking-email-empty').toggle(empty);
    }

    $('#add-booking-email').on('click', function () {
        // Keep the template's name="booking_notification_emails[]". PHP assigns
        // sequential integer keys to repeated [] names on every submit, so the
        // keys stay contiguous even after a row is removed. Handing out explicit
        // [N] indices here would collide with an existing row and silently drop
        // an address.
        $bookingEmailRows.append($($bookingEmailTemplate.html()));
        syncBookingEmailEmptyNote();
    });

    $bookingEmailRows.on('click', '.remove-booking-email', function () {
        $(this).closest('.booking-email-row').remove();
        syncBookingEmailEmptyNote();
    });

    syncBookingEmailEmptyNote();

})(jQuery);
 