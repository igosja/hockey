jQuery(document).ready(function () {
    $('#votetext').on('blur', function () {
        check_votetext($(this).val());
    });

    $('#voteanswer-1, #voteanswer-2, #voteanswer-3, #voteanswer-4, #voteanswer-5').on('blur', function () {
        check_voteanswer();
    });

    $('#vote-form').on('submit', function () {
        check_votetext($('#votetext').val());
        check_voteanswer();

        if ($('input.has-error').length)
        {
            return false;
        }
    });
});

function check_votetext(votetext)
{
    var votetext_input = $('#votetext');
    var votetext_error = $('.votetext-error');

    if ('' !== votetext)
    {
        votetext_error.html('');

        if (votetext_input.hasClass('has-error'))
        {
            votetext_input.removeClass('has-error');
        }
    }
    else
    {
        votetext_input.addClass('has-error');
        votetext_error.html('Введите вопрос.');
    }
}

function check_voteanswer()
{
    var voteanswer_input_1 = $('#voteanswer-1');
    var voteanswer_input_2 = $('#voteanswer-2');
    var voteanswer_input_3 = $('#voteanswer-3');
    var voteanswer_input_4 = $('#voteanswer-4');
    var voteanswer_input_5 = $('#voteanswer-5');
    var voteanswer_error   = $('.voteanswer-error');

    if ('' !== voteanswer_input_1.val() || '' !== voteanswer_input_2.val() || '' !== voteanswer_input_3.val() || '' !== voteanswer_input_4.val() || '' !== voteanswer_input_5.val())
    {
        voteanswer_error.html('');

        if (voteanswer_input_1.hasClass('has-error'))
        {
            voteanswer_input_1.removeClass('has-error');
        }

        if (voteanswer_input_2.hasClass('has-error'))
        {
            voteanswer_input_2.removeClass('has-error');
        }

        if (voteanswer_input_3.hasClass('has-error'))
        {
            voteanswer_input_3.removeClass('has-error');
        }

        if (voteanswer_input_4.hasClass('has-error'))
        {
            voteanswer_input_4.removeClass('has-error');
        }

        if (voteanswer_input_5.hasClass('has-error'))
        {
            voteanswer_input_5.removeClass('has-error');
        }
    }
    else
    {
        voteanswer_input_1.addClass('has-error');
        voteanswer_input_2.addClass('has-error');
        voteanswer_input_3.addClass('has-error');
        voteanswer_input_4.addClass('has-error');
        voteanswer_input_5.addClass('has-error');
        voteanswer_error.html('Введите ответы.');
    }
}