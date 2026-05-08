var baseurl = $('meta[name=base-url]').attr("content");

/***********Delete function start here**********/
function deleteFromList(id='',text='')
{
    var r = confirm(`${lang.are_you_sure_to_delete} ${text}?`);
    if(r) {
        $(`#${text}_delete_form_`+id).submit();
    }
}
/***********Delete function end here**********/

//Change Status status
function changeStatus(id,text){
    var status_element;
    var url;
    
    if(text == 'user'){
        status_element = $('#user_status_'+id);
        var current_status = status_element.text().trim();
        url = baseurl+'/users/changeStatus';
        text = 'user';
    }else if(text == 'zoom_sessions'){
        status_element = $('#zoom_session_'+id);
        var current_status = status_element.text().trim();
        url = baseurl+'/zoom-sessions/changeStatus';
        text = 'zoom_session';
    }

    // Add cursor pointer and hover effect
    status_element.css('cursor', 'pointer');
    
    // Show loading state
    status_element.addClass('opacity-50 cursor-not-allowed');
    
    var new_status_value = current_status.toLowerCase() === 'active' ? 'inactive' : 'active';

    $.ajax(
        {
            url: url,
            type: "post",
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name=csrf-token]').attr("content"));
            },
            cache: false,
            async: true,
            data: {id:id,status_value:new_status_value},
            success: function (response) {
                console.log('Success response:', response); // Debug log
                // Remove loading state and restore cursor
                status_element.removeClass('opacity-50 cursor-not-allowed');
                status_element.css('cursor', 'pointer');
                
                if(response && (response.status == true || response.status === 'true')) {
                    toastr.success(response.message || 'Status updated successfully');
                    
                    // Update UI immediately
                    if(response.user_status && response.user_status.toLowerCase() === 'active'){
                        status_element.removeClass('bg-red-100 text-red-700');
                        status_element.addClass('bg-primary text-green-700');
                    }else{
                        status_element.removeClass('bg-primary text-green-700');
                        status_element.addClass('bg-red-100 text-red-700');
                    }
                    
                    // Update text
                    status_element.text(response.user_status);
                    
                }else{
                    console.log('Error in response:', response); // Debug log
                    if(response && response.errortrue==true){
                        for(var error in response.message){
                            toastr.error(response.message[error]);
                        }
                    }else{
                        toastr.error(response.message || 'Status update failed');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error:', {xhr: xhr, status: status, error: error}); // Debug log
                // Remove loading state and restore cursor
                status_element.removeClass('opacity-50 cursor-not-allowed');
                status_element.css('cursor', 'pointer');
                
                // Show specific error message
                var errorMessage = 'An error occurred while updating status.';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if(xhr.statusText) {
                    errorMessage = xhr.statusText;
                }
                toastr.error(errorMessage + ' Please try again.');
            }
        }
    ); 
}
//Change Status end

$(".numbered").keydown(function (e) {
  if (
    $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
    (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
    (e.keyCode >= 35 && e.keyCode <= 40)
  ) {
    return;
  }
  if (
    (e.shiftKey || e.keyCode < 48 || e.keyCode > 57) &&
    (e.keyCode < 96 || e.keyCode > 105)
  ) {
    e.preventDefault();
  }
});