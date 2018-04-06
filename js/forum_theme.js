jQuery(document).ready(function () {
    var textarea = $('#text');

    textarea.on('blur', function () {
        textarea.sync();
        check_text($(this).val());
    });

    $('#forumtheme-form').on('submit', function () {
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

    $('.forum-complain').on('click', function () {
        var message = $(this).data('message');
        $.ajax({
            data: {url: '/forum_message_update.php?num=' + message},
            dataType: 'json',
            method: 'POST',
            url: '/json/complain.php',
            success: function (data) {
                var html = '<div class="row margin-top">' +
                    '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert ' + data.class + '">' +
                    data.text +
                    '</div>' +
                    '</div>';
                var alert = $(document).find('.alert');
                if (alert.length) {
                    alert.replace(html);
                } else {
                    $('noscript').after(html);
                }
            }
        })
    })
});

function check_text(text)
{
    var text_input = $('#text');
    var text_error = $('.text-error');

    if ('' !== text)
    {
        text_error.html('');

        if (text_input.hasClass('has-error'))
        {
            text_input.removeClass('has-error');
        }
    }
    else
    {
        text_input.addClass('has-error');
        text_error.html('Введите сообщение.');
    }
}