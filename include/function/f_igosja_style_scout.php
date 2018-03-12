<?php

/**
 * Улюбленний стиль гри хоккеїста
 * @param $style_id integer Улюбленний стиль гри хоккеїста
 * @param $count_scout integer кількіть вивчень стилю хоккеїста
 * @return string
 */

function f_igosja_style_scout($style_id, $count_scout)
{
    if (2 == $count_scout)
    {
        $sql = "SELECT `style_id`,
                       `style_name`
                FROM `style`
                WHERE `style_id`=$style_id
                AND `style_id`!=" . STYLE_NORMAL . "
                ORDER BY `style_id` ASC";
    }
    else
    {
        $limit = 2 - $count_scout;

        $sql = "SELECT `style_id`
                FROM `style`
                WHERE `style_id`!=$style_id
                AND `style_id`!=" . STYLE_NORMAL . "
                ORDER BY `style_id` ASC
                LIMIT $limit";
        $style_sql = f_igosja_mysqli_query($sql);

        $style_array = $style_sql->fetch_all(MYSQLI_ASSOC);

        $style_id_array = array();

        foreach ($style_array as $item)
        {
            $style_id_array[] = $item['style_id'];
        }

        $style_id_array = implode(',', $style_id_array);

        $sql = "SELECT `style_id`,
                       `style_name`
                FROM `style`
                WHERE (`style_id`=$style_id
                OR `style_id` IN ($style_id_array))
                AND `style_id`!=" . STYLE_NORMAL . "
                ORDER BY `style_id` ASC";
    }

    $style_sql = f_igosja_mysqli_query($sql);

    $style_array = $style_sql->fetch_all(MYSQLI_ASSOC);

    $style_img_array = array();

    foreach ($style_array as $item)
    {
        $style_img_array[] =
            '<img
                alt="' . $item['style_name'] . '"
                src="/img/style/' . $item['style_id'] . '.png"
                title="' . $item['style_name'] . '"
            />';
    }

    $style = implode(' ', $style_img_array);

    return $style;
}