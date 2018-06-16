<?php

$q = array();

$q[] = 'CREATE TABLE `rosterphrase`
        (
            `rosterphrase_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `rosterphrase_text` VARCHAR(255)
        );';
$q[] = "INSERT INTO `rosterphrase` (`rosterphrase_text`)
        VALUES ('Уезжая надолго и без интернета - не забудьте поставить статус <a href=\"/user_holiday.php\">в отпуске</a>'),
               ('<a href=\"/user_referral.php\">Пригласите друзей</a> в Лигу и получите вознаграждение'),
               ('Если у вас есть вопросы - задайте их специалистам <a href=\"/support.php\">тех.поддержки</a> Лиги'),
               ('Можно достичь высоких результатов, не нарушая правил'),
               ('Играйте честно - так интереснее выигрывать')";