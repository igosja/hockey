<?php
/**
 * @var $forumgroup_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1><?= $forumgroup_array[0]['forumgroup_name']; ?></h1>
            </div>
        </div>
        <form method="POST">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                    <label for="name">Заголовок:</label>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <input class="form-control" id="name" name="data[name]"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <textarea class="form-control" name="data[text]" rows="5"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <input class="btn margin" type="submit" value="Создать">
                </div>
            </div>
        </form>
    </div>
</div>