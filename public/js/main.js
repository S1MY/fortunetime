$(document).ready(function () {
    let header = $(".header");
    if (header.length) {
        let headerTop = header.offset().top;

        if (headerTop > 150) {
            $(".header").addClass('fixed');
        } else {
            $(".header").removeClass('fixed');
        }
        $(window).scroll(function () {
            if ($(this).scrollTop() > 150) {
                $(".header").addClass('fixed');
            } else {
                $(".header").removeClass('fixed');
            }
        });
    }
    let daun = 1;
    let deg = 360 / 5000;
    let index = 1;
    let antiindex = -1;
    setInterval(function () {
        if (daun == 1) {
            $('.orbital').css('transform', 'rotate(' + index * deg + 'deg)');
            $('.planet').css('transform', 'rotate(' + antiindex * deg + 'deg)');
            index++;
            antiindex--;
        }
    }, deg);
    $(".planet").hover(function () {
        $(this).parent().parent().addClass('hovered');
        daun = 0;
    }, function () {
        $(this).parent().parent().removeClass('hovered');
        daun = 1;
    });
    $('body').on('click', '.password-control', function(){
        if ($('.password-input').attr('type') == 'password'){
            $('.password-control').addClass('view');
            $('.password-input').attr('type', 'text');
        } else {
            $('.password-control').removeClass('view');
            $('.password-input').attr('type', 'password');
        }
        return false;
    });
    // Попапс
    $('.popupBtn').click(function (e) {
        e.preventDefault();
        let popupName = $(this).attr('data-popup');
        $('.popupWrapper').fadeIn();

        if( popupName == 'starter' ){

            let lvl = $(this).attr('data-matrix-id');

            let title = 'Внесение взноса за первую матрицу';
            let value = 1000;

            if( lvl == 2){
                title = 'Внесение взноса за вторую матрицу';
                value = 5000;
            }
            if( lvl == 3){
                title = 'Внесение взноса за третью матрицу';
                value = 10000;
            }
            if( lvl == 4){
                title = 'Внесение взноса за четвёртую матрицу';
                value = 25000;
            }
            if( lvl == 5){
                title = 'Внесение взноса за пятую матрицу';
                value = 50000;
            }
            if( lvl == 6){
                title = 'Внесение взноса за шестую матрицу';
                value = 100000;
            }
            if( lvl == 7){
                title = 'Внесение взноса за седьмую матрицу';
                value = 250000;
            }
            if( lvl == 8){
                title = 'Внесение взноса за восьмую матрицу';
                value = 500000;
            }
            if( lvl == 9){
                title = 'Внесение взноса за девятую матрицу';
                value = 1000000;
            }

            $('.popupElement[data-popup=starter] h2').text(title);

            $('.popupElement[data-popup=starter] input[name=oa]').val(value);

        }

        $('.popupElement[data-popup=' + popupName + ']').fadeIn();
    });

    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Введите ответ на вопрос',
            lang: 'ru-RU'
          });
          $('#summernotenews').summernote({
            placeholder: 'Введите содержание новости',
            lang: 'ru-RU'
          });
    });

    $('body').on('click', '.answerItem .editIcon', function(e){
        e.preventDefault();
        let faqID = $(this).attr('data-faq-id');
        let question = $('.faqIDTitle_'+faqID).html();
        let answer = $('.faqIDContent_'+faqID).html();

        $('.editID').attr('value', faqID);
        $('#question').attr('value', question);
        $('.note-editable').html(answer);
        $('.note-placeholder').hide();
    });

    $('.answerItem .removeIcon').click(function (e) {
        e.preventDefault();

        $('.popupResponse.deleteQuestion').fadeIn(500);

        let faqID = $(this).attr('data-faq-id');

        $('#removeid').attr('value', faqID);

    });

    $('body').on('click', '.newsItem .editIcon', function(e){
        e.preventDefault();
        let faqID = $(this).attr('data-faq-id');
        let question = $('.faqIDTitle_'+faqID).html();
        let answer = $('.faqIDContent_'+faqID).html();

        $('.editID').attr('value', faqID);
        $('#question').attr('value', question);
        $('#summernotenews').attr('value', answer);
        $('.note-editable').html(answer);
        $('.note-placeholder').hide();
    });

    $('.formLink').click(function (e) {
        e.preventDefault();
        let popupName = $(this).attr('data-popup');
        $('.popupElement').fadeOut();
        $('.popupElement[data-popup=' + popupName + ']').fadeIn();
    });
    $('.popupBg, .popupClose').click(function (e) {
        e.preventDefault();
        $('.popupWrapper').fadeOut();
        $('.popupElement').fadeOut();
    });
    $('.policeBtn').click(function (e) {
        e.preventDefault();
        $('.policeForm').hide();
        $('#regForm').fadeIn();
    });
    // Мобайлс
    $('.burgerBtn').click(function (e) {
        e.preventDefault();
        $('.mobileMenu').addClass('open');
    });
    $('.mobileBg, .menuClose').click(function (e) {
        e.preventDefault();
        $('.mobileMenu').removeClass('open');
    });
    // FAQ
    $('.answerHeader').click(function (e) {
        e.preventDefault();
        $(this).children('.answerIcon').toggleClass('active');
        $(this).next().slideToggle();
    });
    // matrixTab
    $('.matrixTab').click(function (e) {
        e.preventDefault();
        if ($(this).hasClass('disabled')) {

        }else{
            let matrixNumb = $(this).attr('data-matrix');
            let matrixURL = $(this).attr('data-matrix-url');

            $('.matrixTab').removeClass('active');
            $(this).addClass('active');
            $('.matrixElement').removeClass('active');
            $('.matrixElement[data-matrix=' + matrixNumb + ']').addClass('active');
            $('.martixBuyer').attr('data-matrix-id', matrixNumb);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: matrixURL,
                data: "data",
                dataType: "dataType",
                success: function (response) {
                    console.log(response['responseText']);
                },
                error: function (data) {
                    var content = data['responseText'];
                    $('.mainContainerMatrix').html(content);
                    // console.log(data);
                }
            });
        }
    });
    // Меню юзера
    $('.userNavWrapper').click(function (e) {
        e.preventDefault();
        $(this).parent().toggleClass('actived');
    });
    // Клик вне меню
    $(document).mouseup(function (e) {
        let select = $(".userNav");
        if (!select.is(e.target) && select.has(e.target).length === 0) {
            $(".userNav").removeClass('actived');
        }
    });
    // Копирование
    $('.linkCopy').click(function () {

        var copyText = $(this).next().text();

        var copytext2 = document.createElement('input');

        copytext2.value = copyText;

        document.body.appendChild(copytext2);

        copytext2.select();

        document.execCommand("copy");

        document.body.removeChild(copytext2);

        $(this).parent().children('.copy').addClass('active');

        setTimeout(function () {

            $(".copy").removeClass('active');

        }, 5000);

    });
    // MatrixTabs
    $('.cabMatrixElement').click(function (e) {
        e.preventDefault();
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        }else{
            $(this).addClass('active');
        }
    });
    $(document).on("click", '.popupResponseBg, .responseBtn', function (event) {

        event.preventDefault();

        $('.popupResponse').fadeOut(500);

    });
    $('.matrixImage').magnificPopup({type:'iframe'});
});
