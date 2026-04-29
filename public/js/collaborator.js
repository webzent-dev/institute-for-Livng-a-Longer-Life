$("#add_user_form").on("submit", function (e) {
    e.preventDefault();
    let first_name = $('#first_name').val();
    let last_name  = $('#last_name').val();
    let email = $('#email').val();
    let phone = $('#phone').val();
    let password = $('#password').val();
    let password_confirmation = $('#password_confirmation').val();
    let speciality = $('#speciality').val();
    let professional_credentials = $('#professional_credentials').val();
    let experience = $('#experience').val();
    let organization = $('#organization').val();
    let website = $('#website').val();
    let collaborator_message = $('#collaborator_message').val();

    if(first_name == ''){
        toastr.error('Please enter first name.');
        $('#first_name').focus();
        return false;
    }

    $("#submit").text("Please wait...");
    $("#submit").attr("disabled", true);
    /*
    $.ajax({
        url: "/become/collaborator",
        type: "POST",
        data: new FormData(this),
        dataType: "JSON",
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function (xhr) {
            xhr.setRequestHeader(
                "X-CSRF-TOKEN",
                $("meta[name=csrf-token]").attr("content")
            );
        },
        async: true,
        success: function (data) {
            if (data.status == true) {
                toastr.success(data.message);
                $("input,textarea").val("");
                setTimeout(function () {
                    location.href = adminurl + "/users";
                }, 2000);
            } else {
                if (data.errortrue == true) {
                    for (var error in data.message) {
                        toastr.error(data.message[error]);
                    }
                } else {
                    toastr.error(data.message);
                }
            }
            $("#submit").text("Submit");
            $("#submit").attr("disabled", false);
        },
    });
    */
   
});