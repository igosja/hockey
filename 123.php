<?php

include(__DIR__ . '/include/include.php');

$email_text = '
То, чего мы так долго ждали, наконец случилось!
Сегодня мы запускаем наш сайт, который, как мы надеемся, станет вашим любимым онлайн-менеджером.
<br/>
Приглашаем вас подать заявку на получение команды. Первые игры пройдут в понедельник, 1 января 2018 года.
<br/>
А пока мы бы хотели поблагодарить вас за вашу поддержку и веру в наш проект!';
$mail = new Mail();
$mail->setSubject('Виртуальная Хоккейная Лига начинает работу');
$mail->setHtml($email_text);

$sql = "SELECT `user_email`
        FROM `user`
        WHERE `user_id`!=0
        ORDER BY `user_id` ASC";
$user_sql = f_igosja_mysqli_query($sql);

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

foreach ($user_array as $item)
{
    $mail->setTo($item['user_email']);
    $mail->send();
}