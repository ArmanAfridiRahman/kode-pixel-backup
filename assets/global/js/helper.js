
//toaster functions
function toastr(text, className) {

    if (className == 'danger') {
        className = 'bg-' + className;
    }
    else {
        className = 'bg-soft-' + className;
    }
    Toastify({
        newWindow: !0,
        text: text,
        gravity: 'top',
        position: 'right',
        className: className,
        stopOnFocus: !0,
        offset: { x: 0, y: 0 },
        duration: 3000,
        close: "close" == "close",

    }).showToast();
}



//EMPTY INPUT FIELD 
function emptyInputFiled(id, selector = 'id', html = true) {
    var identifier = selector === 'id' ? `#${id}` : `.${id}`;
    $(identifier)[html ? 'html' : 'val']('');
}


//delete event start
$(document).on('click', ".delete-item", function (e) {
    e.preventDefault();
    var href = $(this).attr('data-href');
    var message = 'Are you sure you want to remove this record ?'
    if (($(this).attr('data-message'))) {
        message = $(this).attr('data-message')
    }
    $("#delete-href").attr("href", href);
    $(".warning-message").html(message)
    $("#deleteModal").modal("show");
})

const disableInput = document.querySelectorAll('input[disabled]');
disableInput.forEach(element => {
  element.style.cssText = `background-color: rgba(0,0,0,0.025);`;
});


//file upload preview
$(document).on('change', '.preview', function (e) {
    var file = e.target.files[0];
    console.log(file);
    var size = ($(this).attr('data-size')).split("x");
    $(this).closest('div').find('#image-preview-section').html(
        `<img alt='${file.type}' class="mt-2 rounded  d-block"
             style="width:${size[0]}px;height:${size[1]}px;"
            src='${URL.createObjectURL(file)}'>`
    );
    e.preventDefault();
})


$(document).on('click', '.copy-text ', function (e) {
    var data = $(this).attr('data-text')
    var modal = $(this).data('type');

    var $tempInput = $('<input>');
 

    if(modal){
        $('.modal').append($tempInput);
    }else{
        $('body').append($tempInput);
    }


    $tempInput.val(data).select();
  
    document.execCommand('copy');
    $tempInput.remove();

    toastr('Text/ Url Copied Successfully', 'success')
})

function send_browser_notification(heading, icon, message, route) {
    Push.create(`${heading}`, {
        body: message,
        icon: `${icon}`,
        timeout: 4000,
        onClick: function () {
            window.location.href = route
            this.close();
        }
    });
}

function checkebox_event(selector, sub_selector) {
    var length = $(`${selector}`).length
    checked_length = $(`${selector}:checked`).length;
    if (length == checked_length) {
        $(`${sub_selector}`).prop('checked', true);
    }
    else {
        $(`${sub_selector}`).prop('checked', false);
    }
    return length;
}

// CHECK BOX METHOD 
function checkUncheckMethod(selector, status, type = 'class') {
    if (type == 'class') {
      $(`.${selector}`).prop('checked', status)
    }
    else {
      $(`#${selector}`).prop('checked', status)
    }
  }
// ALL DATA SELECT 
$(document).on('click', '#select-all', function (e) {
    if ($(this).is(':checked')) {
      checkUncheckMethod(`all-data-select input[type=checkbox]`, true)
    } else {
      checkUncheckMethod(`all-data-select input[type=checkbox]`, false)
    }
})
/** bulk action js start */

$(document).on('click','.check-all' ,function(e){
    if($(this).is(':checked')){
        $(`.data-checkbox`).prop('checked', true);
        $(`.bulk-action`).removeClass('d-none');
    }
    else{
        $(`.data-checkbox`).prop('checked', false);
        $(`.bulk-action`).addClass('d-none');
    }
})

$(document).on('click','.data-checkbox' ,function(e){
     var length = checkebox_event(".data-checkbox",'.check-all');
     console.log(length);
     if(length > 0){
        $(`.bulk-action`).removeClass('d-none');
     }
     else{
        $(`.bulk-action`).addClass('d-none');
     }
})


$(document).on('click','#bulkActionBtn' ,function(e){

    var type = $(this).attr("data-type")
    var value = $(this).val()

    const checkedIds = $('.data-checkbox:checked').map(function () {
        return $(this).val();
    }).get();

    $('#bulkid').val(JSON.stringify(checkedIds));
    $('#value').val(value);
    $('#type').val(type);

    $("#bulkActionForm").submit()

});



$(document).on('click','#deleteModal',function(e){
    var modal = $('#bulkDeleteModal')
    modal.modal('show')
})

/** bulk action js end */













