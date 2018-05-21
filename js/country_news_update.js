jQuery(document).ready(function () {
    var textarea = $('#newstext');

    $('#newstitle').on('blur', function () {
        check_newstitle($(this).val());
    });

    textarea.on('blur', function () {
        textarea.sync();
        check_newstext($(this).val());
    });

    $('#news-form').on('submit', function () {
        textarea.sync();
        check_newstitle($('#newstitle').val());
        check_newstext(textarea.val());

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

function check_newstitle(newstitle)
{
    var newstitle_input = $('#newstitle');
    var newstitle_error = $('.newstitle-error');

    if ('' !== newstitle)
    {
        newstitle_error.html('');

        if (newstitle_input.hasClass('has-error'))
        {
            newstitle_input.removeClass('has-error');
        }
    }
    else
    {
        newstitle_input.addClass('has-error');
        newstitle_error.html('Введите заголовок.');
    }
}

function check_newstext(newstext)
{
    var newstext_input = $('#newstext');
    var newstext_error = $('.newstext-error');

    if ('' !== newstext)
    {
        newstext_error.html('');

        if (newstext_input.hasClass('has-error'))
        {
            newstext_input.removeClass('has-error');
        }
    }
    else
    {
        newstext_input.addClass('has-error');
        newstext_error.html('Введите текст.');
    }
}