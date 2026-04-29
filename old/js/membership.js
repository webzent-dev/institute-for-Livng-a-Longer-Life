$(document).ready(function ($) {
    //add maintenance validate.
    $("#addMembershipForm").validate({
        rules: {
            membership_name: {
                required: true,
            },
            membership_price: {
                required: true,
            },
            membership_period: {
                required: true,
            },
            membership_description: {
                required: true,
            },
            membership_features: {
                required: true,
            }
        },
        messages: {
            property_name: `${lang.membership_name_required}`,
            membership_price: "Enter membership price",
            membership_period: "Enter membership duration",
            membership_description: "Enter membership description",
            membership_features: "Enter membership features",
        },
        submitHandler: function (form) {
            form.submit();
        },
    });
});

// status update javascript ajax code.
function makePopular(id) {
    if ($(".membership-popular-" + id).prop("checked") == true) {
        var status = 1;
    } else {
        var status = 0;
    }
    $.ajax({
        type: "POST",
        url: "manage-membership/make-popular",
        dataType: "json",
        cache: false,
        async: true,
        data: {
            id: id,
            status: status,
            _token: $("#csrf-token")[0].content,
        },
        success: function (data) {
            if (data.success == 1) {
                toastr.success(data.message);
            } else {
                toastr.success(data.message);
            }
        },
        beforeSend: function () {
            $("#overlay").fadeIn(300);
        },
        complete: function () {
            setTimeout(function () {
                $("#overlay").fadeOut(300);
            }, 500);
        },
    });
}