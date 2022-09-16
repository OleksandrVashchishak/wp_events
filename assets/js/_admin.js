$(function () {
    let dateFormat = "yy-mm-dd"
    let fromDatepicker = $("#ax_from_date")
    let fromDatepickerVal = $("#ax_from_date").val()
    let toDatepicker = $("#ax_to_date")
    let toDatepickerVal = $("#ax_to_date").val()
    let from = fromDatepicker.datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1
    }).on("change", function () {
        to.datepicker("option", "minDate", getDate(this));
    })
    fromDatepicker.datepicker("option", "dateFormat", 'yy-mm-dd');
    fromDatepicker.datepicker('setDate', fromDatepickerVal);

    let to = toDatepicker.datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1
    }).on("change", function () {
        from.datepicker("option", "maxDate", getDate(this));
    });
    toDatepicker.datepicker("option", "dateFormat", 'yy-mm-dd');
    toDatepicker.datepicker('setDate', toDatepickerVal);


    function getDate(element) {
        var date;
        try {
            date = $.datepicker.parseDate(dateFormat, element.value);
        } catch (error) {
            date = null;
        }

        return date;
    }
});