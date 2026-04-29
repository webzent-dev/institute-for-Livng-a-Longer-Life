//Add validation for phone number input to allow only digits and maximum lengeth of 10 characters
$('.phone_number').on('input', function() {
    let value = $(this).val();
    // Remove any non-digit characters
    value = value.replace(/[^0-9]/g, '');
    // Limit to 10 characters
    value = value.substring(0, 10);
    $(this).val(value);
});

$('#fld_phone').on('input', function() {
    let value = $(this).val();
    // Remove any non-digit characters
    value = value.replace(/[^0-9]/g, '');
    // Limit to 10 characters
    value = value.substring(0, 10);
    $(this).val(value);
});