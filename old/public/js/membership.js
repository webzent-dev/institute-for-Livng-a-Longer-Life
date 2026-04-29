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
    var baseurl = $('meta[name=base-url]').attr("content");
    var popular_value = $('#membership_popular_'+id).text();
    var url = baseurl+'/manage-membership/make-popular';
    if(popular_value.trim() == 'Yes'){
        popular_value = 'no';
    }else{
        popular_value = 'yes';    
    }
    $.ajax(
        {
            url: url,
            type: "post",
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name=csrf-token]').attr("content"));
            },
            cache: false,
            async: true,
            data: {id:id,popular_value:popular_value},
            success: function (response) {
                if(response!='') {
                    if(response.status==true) {
                        toastr.success(response.message);
                        if(response.membership_popular == 'Yes'){
                            $('#membership_popular_'+id).attr('class','rounded-full self-center px-3 py-1 text-xs font-semibold text-primary-foreground bg-primary text-green-700');
                        }else{
                            $('#membership_popular_'+id).attr('class','rounded-full self-center px-3 py-1 text-xs font-semibold text-primary-foreground bg-red-100 text-red-700');
                        }
                        $('#membership_popular_'+id).text(response.membership_popular);
                    }else{
                        if(response.errortrue==true){
                            for(var error in response.message){
                                toastr.error(response.message[error]);
                            }
                        }else{
                            toastr.error(response.message);
                        }
                    }
                }
            }
        }
    ); 
}