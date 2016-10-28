<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">
            <?php if (isset($vote_array[0]['vote_text'])) { ?>
                <?= $vote_array[0]['vote_text']; ?>
            <?php } else { ?>
                Создание опроса
            <?php } ?>
        </h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a href="/admin/vote_list.php">
            <button class="btn btn-default">Список</button>
        </a>
    </li>
    <?php if (isset($num_get)) { ?>
        <li>
            <a href="/admin/vote_view.php?num=<?= $num_get; ?>">
                <button class="btn btn-default">Просмотр</button>
            </a>
        </li>
    <?php } ?>
</ul>
<form class="form-horizontal" method="POST">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <tr>
                    <td class="text-right col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <label class="control-label" for="vote_name">Вопрос</label>
                    </td>
                    <td>
                        <input
                            class="form-control"
                            id="vote_name"
                            name="data[vote_text]"
                            value="<?= isset($vote_array[0]) ? $vote_array[0]['vote_text'] : ''; ?>"
                        >
                    </td>
                </tr>
                <tr>
                    <td class="text-right col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <label class="control-label" for="vote_answer_1">Ответ</label>
                    </td>
                    <td>
                        <input
                            class="form-control"
                            id="vote_answer_1"
                            name="answer[voteanswer_text][]"
                            value="<?= isset($vote_array[0]) ? $vote_array[0]['voteanswer_text'] : ''; ?>"
                        >
                    </td>
                </tr>
                <tr>
                    <td class="text-right col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <label class="control-label" for="vote_answer_2">Ответ</label>
                    </td>
                    <td>
                        <input
                            class="form-control"
                            id="vote_answer_2"
                            name="answer[voteanswer_text][]"
                            value="<?= isset($vote_array[0]) ? $vote_array[0]['voteanswer_text'] : ''; ?>"
                        >
                    </td>
                </tr>
                <tr>
                    <td class="text-right col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <label class="control-label" for="vote_answer_3">Ответ</label>
                    </td>
                    <td>
                        <input
                            class="form-control"
                            id="vote_answer_3"
                            name="answer[voteanswer_text][]"
                            value="<?= isset($vote_array[0]) ? $vote_array[0]['voteanswer_text'] : ''; ?>"
                        >
                    </td>
                </tr>
                <tr>
                    <td class="text-right col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <label class="control-label" for="vote_answer_4">Ответ</label>
                    </td>
                    <td>
                        <input
                            class="form-control"
                            id="vote_answer_4"
                            name="answer[voteanswer_text][]"
                            value="<?= isset($vote_array[0]) ? $vote_array[0]['voteanswer_text'] : ''; ?>"
                        >
                    </td>
                </tr>
                <tr>
                    <td class="text-right col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <label class="control-label" for="vote_answer_5">Ответ</label>
                    </td>
                    <td>
                        <input
                            class="form-control"
                            id="vote_answer_5"
                            name="answer[voteanswer_text][]"
                            value="<?= isset($vote_array[0]) ? $vote_array[0]['voteanswer_text'] : ''; ?>"
                        >
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <button class="btn btn-default" type="submit">Сохранить</button>
        </div>
    </div>
</form>