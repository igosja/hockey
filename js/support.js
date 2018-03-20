jQuery(document).ready(function () {
    var textarea = $('#message');

    textarea.on('blur', function () {
        textarea.sync();
        check_text($(this).val());
    });

    $('#message-form').on('submit', function () {
        textarea.sync();
        check_text(textarea.val());

        if ($('textarea.has-error').length)
        {
            return false;
        }
    });

    if (1 === textarea.data('bb'))
    {
        textarea.wysibb({
            buttons: "bold,italic,underline,strike,|,img,link,|,bullist,numlist,|,quote,table",
            lang: "ru"
        });
    }

    var lazy_in_progress = 0;
    var scroll_div = $(".message-scroll");
    var lazy_div = $('#lazy');

    scroll_div.scrollTop(scroll_div.prop('scrollHeight'));

    $(".message-scroll, body").on('scroll', function() {
        if (scroll_div.scrollTop() + scroll_div.offset().top <= lazy_div.offset().top && 0 === lazy_in_progress && 1 == lazy_div.data('continue'))
        {
            lazy_in_progress = 1;

            $.ajax({
                url: '/json/support.php?limit=' + lazy_div.data('limit') + '&offset=' + lazy_div.data('offset'),
                dataType: 'json',
                success: function (data)
                {
                    var scroll_height = scroll_div.prop('scrollHeight');
                    lazy_div.after(data['list']);
                    lazy_div.data('offset', data['offset']);
                    lazy_div.data('continue', data['lazy']);
                    lazy_in_progress = 0;
                    scroll_div.scrollTop(scroll_div.prop('scrollHeight') - scroll_height);
                }
            });
        }
    });
});

function check_text(message)
{
    var message_input = $('#message');
    var message_error = $('.message-error');

    if ('' !== message)
    {
        message_error.html('');

        if (message_input.hasClass('has-error'))
        {
            message_input.removeClass('has-error');
        }
    }
    else
    {
        message_input.addClass('has-error');
        message_error.html('Введите сообщение.');
    }
}