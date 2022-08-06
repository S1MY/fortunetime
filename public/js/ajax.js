$(document).ready(function () {
    $('.AJAXForm').submit(function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let ajaxurl = $(this).attr('action');
        let formData = $(this).serialize();
        let formController = $(this).attr('id');
        let errorSvg = '<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 64 64"><circle cx="32" cy="32" r="28" fill="none" stroke="#010101" stroke-miterlimit="10" stroke-width="4"/><line x1="32" x2="32" y1="18" y2="38" fill="none" stroke="#010101" stroke-miterlimit="10" stroke-width="4"/><line x1="32" x2="32" y1="42" y2="46" fill="none" stroke="#010101" stroke-miterlimit="10" stroke-width="4"/></svg>';

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                if( formController == 'ReviewStore' ){
                    window.location.href = '/reviews';
                }else if(formController == 'SetPincode'){
                    window.location.href = '/settings';
                }else{
                    window.location.href = '/account';
                }
            },
            error: function (data) {
                console.log(data);
                $('p.errors').remove();

                if( formController == 'ReviewStore' ){
                    $('form#'+formController+' textarea.error').removeClass('error');
                    $.each(data.responseJSON.errors, function(key, value) {
                        $('form#'+formController+' textarea').addClass('error');
                        $('form#'+formController+' textarea').after('<p class="errors">'+errorSvg+''+value+'</p>');
                    });
                }else if( formController == 'SetPincode' ){
                    $('form#'+formController+' input.error').removeClass('error');
                    $.each(data.responseJSON.errors, function(key, value) {
                        $('form#'+formController+' input').addClass('error');
                        $('form#'+formController+' input[name="'+key+'"]').next().after('<p class="errors">'+errorSvg+''+value+'</p>');
                    });
                }else{
                    $('form#'+formController+' input.error').removeClass('error');
                    $.each(data.responseJSON.errors, function(key, value) {
                        let mval = $('form#'+formController+' input[name="'+key+'"]').attr('placeholder');
                        $('form#'+formController+' input[name="'+key+'"]').addClass('error');
                        $('form#'+formController+' input[name="'+key+'"]').after('<p class="errorsOne">'+value+'</p>');
                        $('form#'+formController+' input[name="'+key+'"]').after('<p class="errors">'+errorSvg+''+$('form#'+formController+' input[name="'+key+'"]').next().text().replace(key, '"'+mval+'"')+'</p>');
                        $('p.errorsOne').remove();
                    });
                }

            }
        });

    });
});
