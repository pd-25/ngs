if (!$('.datepicker-here').val()) {
    $('.datepicker-here').datepicker({
        dateFormat: 'dd-M-yyyy', // Date format without time initially
        timepicker: true, // Enable time picker
        timeFormat: 'hh:ii AA', // Time format with capital AM/PM
        minDate: null, // Optional: Minimum date (null for no limit)
        onSelect: function(formattedDate, date, inst) {
            // Optional: Handle date selection event
        },
        onShow: function(inst, animationCompleted) {
            inst.settings.dateFormat = 'dd-M-yyyy'; // Ensure date format is consistent
        }
    });
}