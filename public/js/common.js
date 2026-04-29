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
    if(text == 'user'){
        var status_value = $('#'+text+'_status_'+id).text();
        var url = baseurl+'/users/changeStatus';
        text = 'user';
    }else if(text == 'zoom_sessions'){
        var status_value = $('#zoom_session_'+id).text();
        var url = baseurl+'/zoom-sessions/changeStatus';
        text = 'zoom_session';
    }

    if(status_value.trim() == 'Active'){
        status_value = 'inactive';
    }else{
        status_value = 'active';    
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
            data: {id:id,status_value:status_value},
            success: function (response) {
                if(response!='') {
                    if(response.status==true) {
                        toastr.success(response.message);
                        if(response.user_status == 'Active'){
                            $('#'+text+'_status_'+id).attr('class','rounded-full self-center px-3 py-1 text-xs font-semibold text-primary-foreground bg-primary text-green-700');
                        }else{
                            $('#'+text+'_status_'+id).attr('class','rounded-full self-center px-3 py-1 text-xs font-semibold text-primary-foreground bg-red-100 text-red-700');
                        }
                        $('#'+text+'_status_'+id).text(response.user_status);
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