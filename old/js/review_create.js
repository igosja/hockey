jQuery(document).ready(function () {
    var textarea = $('#text');

    $('#title').on('blur', function () {
        textarea.sync();
        check_title($(this).val());
    });

    textarea.on('blur', function () {
        textarea.sync();
        check_text($(this).val());
    });

    $('#forumtheme-form').on('submit', function () {
        textarea.sync();
        check_title($('#title').val());
        check_text(textarea.val());

        if ($('textarea.has-error').length || $('input.has-error').length)
        {
            return false;
        }
    });

    if (1 === textarea.data('bb'))
    {
        textarea.wysibb({
            buttons: "bold,italic,underline,strike,|,img,link,|,bullist,numlist,|,quote,table,smilebox",
            lang: "ru",
            smileList: [
                {img: '<img src="{themePrefix}{themeName}/img/smiles/sm01.png" class="sm">', bbcode:":)"},
                {img: '<img src="{themePrefix}{themeName}/img/smiles/sm02.png" class="sm">', bbcode:":("},
                {img: '<img src="{themePrefix}{themeName}/img/smiles/sm03.png" class="sm">', bbcode:":D"},
                {img: '<img src="{themePrefix}{themeName}/img/smiles/sm04.png" class="sm">', bbcode:";)"},
                {img: '<img src="{themePrefix}{themeName}/img/smiles/sm05.png" class="sm">', bbcode:":boss:"},
                {img: '<img src="{themePrefix}{themeName}/img/smiles/sm06.png" class="sm">', bbcode:":applause:"},
                {img: '<img src="{themePrefix}{themeName}/img/smiles/sm07.png" class="sm">', bbcode:":surprise:"},
                {img: '<img src="{themePrefix}{themeName}/img/smiles/sm08.png" class="sm">', bbcode:":sick:"},
                {img: '<img src="{themePrefix}{themeName}/img/smiles/sm09.png" class="sm">', bbcode:":angry:"}
            ]
        });
    }
});

function check_title(title)
{
    var title_input = $('#title');
    var title_error = $('.title-error');

    if ('' !== title)
    {
        title_error.html('');

        if (title_input.hasClass('has-error'))
        {
            title_input.removeClass('has-error');
        }
    }
    else
    {
        title_input.addClass('has-error');
        title_error.html('Введите заголовок.');
    }
}

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