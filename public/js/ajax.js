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
        let successSvg = '<svg width="97" height="96" viewBox="0 0 97 96" fill="none" xmlns="http://www.w3.org/2000/svg"><circle opacity="0.12" cx="48.5" cy="48.0001" r="48" fill="#27AE60"/><g clip-path="url(#clip0_2669_4694)"><path d="M36.9847 49.0672C36.3679 48.557 35.5642 48.2802 34.7347 48.2923C33.9053 48.3044 33.1116 48.6045 32.5126 49.1323C31.9137 49.6602 31.554 50.3769 31.5056 51.1385C31.4572 51.9001 31.7237 52.6504 32.2517 53.2389L39.5484 60.2824C39.8539 60.5772 40.221 60.8121 40.6276 60.9732C41.0343 61.1342 41.4721 61.218 41.9149 61.2196C42.3553 61.2219 42.7917 61.1429 43.1982 60.9871C43.6047 60.8313 43.9731 60.6019 44.2814 60.3127L66.5659 39.1518C66.8681 38.866 67.106 38.5282 67.2662 38.1578C67.4265 37.7874 67.5058 37.3916 67.4997 36.993C67.4936 36.5944 67.4022 36.2008 67.2307 35.8347C67.0592 35.4685 66.811 35.1371 66.5002 34.8592C66.1894 34.5813 65.8222 34.3624 65.4194 34.2151C65.0167 34.0677 64.5863 33.9948 64.1529 34.0004C63.7195 34.006 63.2916 34.0901 62.8935 34.2478C62.4955 34.4055 62.1351 34.6338 61.8329 34.9197L41.9477 53.8435L36.9847 49.0672Z" fill="#27AE60"/></g><defs><clipPath id="clip0_2669_4694"><rect width="96" height="96" fill="white" transform="translate(0.5)"/></defs></svg>';
        let errorSvg = '<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 64 64"><circle cx="32" cy="32" r="28" fill="none" stroke="#010101" stroke-miterlimit="10" stroke-width="4"/><line x1="32" x2="32" y1="18" y2="38" fill="none" stroke="#010101" stroke-miterlimit="10" stroke-width="4"/><line x1="32" x2="32" y1="42" y2="46" fill="none" stroke="#010101" stroke-miterlimit="10" stroke-width="4"/></svg>';
        if( formController == 'registerAjaxForm' ){
            $('.mailConfirm').show();
        }
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if( formController == 'ReviewStore' ){
                    window.location.href = '/reviews';
                }else if(formController == 'SetPincode' || formController == 'presonal'){
                    window.location.href = '/settings';
                }else if(formController == 'aboutForm'){
                    $('#aboutForm')[0].reset();
                    $('.popupResponse').fadeIn(500);
                }else if(formController == 'adminFAQ'){
                    $('#adminFAQ')[0].reset();
                    $('.note-editable').html('<p></p>');
                    $('.popupResponse.succes').fadeIn(500);
                    setTimeout(() => {
                        window.location.href = '/admin/faq';
                    }, 1500);
                }else if(formController == 'output'){
                    location.reload();
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
                }else if( formController == 'aboutForm' ){
                    $('#aboutForm')[0].reset();
                    $('.popupResponse').fadeIn(500);
                }else if(formController == 'adminFAQ'){
                    $('form#'+formController+' input.error').removeClass('error');
                    $.each(data.responseJSON.errors, function(key, value) {
                        if( key == 'question' ){
                            $('form#'+formController+' input').addClass('error');
                            $('form#'+formController+' input[name="'+key+'"]').before('<p class="errors">'+errorSvg+''+value+'</p>');
                        }else{
                            $('form#'+formController+' textarea[name="'+key+'"]').before('<p class="errors">'+errorSvg+''+value+'</p>');
                        }

                    });
                }else if(formController == 'output'){
                    location.reload();
                }else{
                    $('form#'+formController+' input.error').removeClass('error');
                    $.each(data.responseJSON.errors, function(key, value) {
                        let mval = $('form#'+formController+' input[name="'+key+'"]').attr('placeholder');
                        $('form#'+formController+' input[name="'+key+'"]').addClass('error');
                        $('form#'+formController+' input[name="'+key+'"]').after('<p class="errorsOne">'+value+'</p>');
                        if( key == 'mailConfirm' ){
                            $('form#'+formController+' input[name="'+key+'"]').after('<p class="errors">'+errorSvg+'Подтвердите ваш Email адрес.</p>');
                        }else{
                            $('form#'+formController+' input[name="'+key+'"]').after('<p class="errors">'+errorSvg+''+$('form#'+formController+' input[name="'+key+'"]').next().text().replace(key, '"'+mval+'"')+'</p>');
                        }
                        $('p.errorsOne').remove();
                    });
                }

            }
        });

    });

    $('.deleteQuestion .cabMenuLink').click(function (e) {
        e.preventDefault();

        if( $(this).hasClass('delete') ){
            $('#faqRemove').submit();
        }

        $('.popupResponse.deleteQuestion').fadeOut(500);

    });

    $('#faqRemove').submit(function (e) {
        e.preventDefault();

        let ajaxurl = $(this).attr('action');
        let formData = $(this).serialize();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                setTimeout(() => {
                    location.reload();
                }, 1500);
                $('.popupResponse.succes').fadeIn(500);
            },
            error: function (data) {
                console.log(data);
                location.href = data.responseText;
            }
        });
    });

    $('#adminNews').submit(function(e){
        e.preventDefault();
        let ajaxurl = $(this).attr('action');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var $input = $(".newsimgInput");
        var fd = new FormData($(this)[0]);

        fd.append('img', $input.prop('files')[0]);

        $.ajax({
            url: ajaxurl,
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                console.log(data);
                $('.popupResponse.succes').fadeIn(500);
                setTimeout(() => {
                    window.location.href = '/admin/news';
                }, 1500);
            },
            error: function (data) {
                console.log(data);
            }
        });
    })

    $('.adminPayed').click(function (e) {
        e.preventDefault();

        let ajaxurl = $(this).attr('data-action');
        let formData = $(this).attr('data-id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {id: formData},
            dataType: 'json',
            success: function (data) {
                location.reload();
            },
            error: function (data) {
                location.reload();
            }
        });
    });

    $('.activationBigBtn').click(function (e) {
        e.preventDefault();

        $('#activation').submit();

    });

    $(document).on('submit', '#activation', function(e) {
        $('.popupResponse.changeRef').fadeOut(500);
        e.preventDefault();
        let ajaxurl = $(this).attr('action');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('.popupResponse.succes').fadeIn(500);
                setTimeout(() => {
                    location.reload();
                }, 1500);
            },
            error: function (data) {
                console.log(data);
                $('.popupResponse.succes').fadeIn(500);
                setTimeout(() => {
                    location.reload();
                }, 1500);
            }
        });
    })

    $('#changeReferal').submit(function(e){
        $('.popupResponse.changeRef').fadeOut(500);
        e.preventDefault();
        let ajaxurl = $(this).attr('action');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('.popupResponse.succes').fadeIn(500);
                setTimeout(() => {
                    window.location.href = '/admin';
                }, 1500);
            },
            error: function (data) {
                console.log(data);
            }
        });
    })

    $('.avatarInput').change(function (e) {
        e.preventDefault();
        $('#avatarUpload').submit();
    });

    $('#avatarUpload').submit(function (e) {
        e.preventDefault();
        let ajaxurl = $(this).attr('action');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var $input = $(".avatarInput");
        var fd = new FormData;

        console.log(fd);

        fd.append('img', $input.prop('files')[0]);

        $.ajax({
            url: ajaxurl,
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                console.log(data);
                location.reload();
            },
            error: function (data) {
                console.log(data);
            }
        });
    });

    $('.AJAXFormFK .platItem').click(function (e) {
        e.preventDefault();
        $('.AJAXFormFK').submit();
    });

    $('.AJAXFormPY .platItem').click(function (e) {
        e.preventDefault();
        $('.AJAXFormPY').submit();
    });

    $('.AJAXFormAdv .platItem').click(function (e) {
        e.preventDefault();
        $('.AJAXFormAdv').submit();
    });

    $('.langItem, .menuLangItem').click(function (e){
        e.preventDefault();

        let ajaxurl = $(this).attr('data-action');
        let formData = $(this).attr('data-lang');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {lang: formData},
            dataType: 'json',
            success: function (data) {
                location.reload();
            },
            error: function (data) {
                location.reload();
            }
        });
    })

    $(document).on('click', '.adminBtn', function(e) {
        e.preventDefault();
        if( $(this).hasClass('reviewsAdminBtn') ){

            let ajaxurl = $(this).attr('data-action');
            let value = $(this).attr('data-value');

            if( value == 1 ){
                $(this).attr('data-value', 2);
                $(this).text('Снятые с публикации');
            }
            if( value == 2 ){
                $(this).attr('data-value', 0);
                $(this).text('Все отзывы');
            }
            if( value == 0 ){
                $(this).attr('data-value', 1);
                $(this).text('Опубликованные');
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {value: value},
                dataType: 'json',
                success: function (data) {
                    console.log(data['responseText']);
                    $('.uReviewsWrapper').html(data['responseText']);
                },
                error: function (data) {
                    $('.uReviewsWrapper').html(data['responseText']);
                    console.log(data['responseText']);
                }
            });

        }else{
            if( $(this).attr('data-sorting-name') == 'all' && $('#formSorting #all').attr('value') == 0 ){
                $('.adminBtn').removeClass('active');
                $('#formSorting input').attr('value', 0);
            }else{
                $('.adminBtn[data-sorting-name=all]').removeClass('active');
            }

            $(this).toggleClass('active');

            if( $(this).attr('data-sorting-name') == 'sponsor_login' ){
                $('.adminBtn[data-sorting-name=activated]').removeClass('active');
                $('#formSorting #activated').attr('value', 0);
            }

            if( $('#formSorting #'+$(this).attr('data-sorting-name')).attr('value') == 1 ){
                $('#formSorting #'+$(this).attr('data-sorting-name')).attr('value', 0);
            } else{
                $('#formSorting #'+$(this).attr('data-sorting-name')).attr('value', 1);
            }

            $('#formSorting').submit();
        }


    })

    $(document).on('submit', '#formSorting', function(e) {
        e.preventDefault();

        let ajaxurl = $(this).attr('action');
        let formData = $(this).serialize();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                $('.tableWrapper').html(data['responseText']);
            },
            error: function (data) {
                $('.tableWrapper').html(data['responseText']);
                console.log(data['responseText']);
            }
        });
    });

    $(document).on('submit', '#changePwd', function(e) {
        e.preventDefault();

        let ajaxurl = $(this).attr('action');
        let formData = $(this).serialize();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                // $('.tableWrapper').html(data['responseText']);
            },
            error: function (data) {
                console.log(data);
            }
        });
    });

    $('.reviewController').click(function (e) {
        e.preventDefault();

        let ajaxurl = $(this).attr('data-action');
        let id = $(this).attr('data-id');
        let value = $(this).attr('data-value');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {id: id, value: value},
            dataType: 'json',
            success: function (data) {
                console.log(data);
                setTimeout(() => {
                    window.location.href = '/admin/reviews';
                }, 1500);
                $('.popupResponse.succes').fadeIn(500);
            },
            error: function (data) {
                console.log(data);
            }
        });

    });

    $('.AJAXFormFK').submit(function (e) {
        e.preventDefault();

        let ajaxurl = $(this).attr('action');
        let formData = $(this).serialize();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('.popupResponse').fadeIn(500);
            },
            error: function (data) {
                console.log(data);
                location.href = data.responseText;
            }
        });
    });

    $('.AJAXFormPY').submit(function (e) {
        e.preventDefault();

        let ajaxurl = $(this).attr('action');
        let formData = $(this).serialize();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('.formPY').html(data.responseText);
                $('.formPY').submit();
                // $('.popupResponse').fadeIn(500);
            },
            error: function (data) {
                console.log(data);
                $('.formPY').html(data.responseText);
                $('.formPY').submit();
                // location.href = data.responseText;
            }
        });
    });

    $('.AJAXFormAdv').submit(function (e) {
        e.preventDefault();

        let ajaxurl = $(this).attr('action');
        let formData = $(this).serialize();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $('.formAdv').html(data.responseText);
                $('.formAdv').submit();
                // $('.popupResponse').fadeIn(500);
            },
            error: function (data) {
                console.log(data);
                $('.formAdv').html(data.responseText);
                $('.formAdv').submit();
                // location.href = data.responseText;
            }
        });
    });
});
