<?php

$q = array();

$q[] = 'CREATE TABLE `site`
        (
            `site_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `site_date_cron` INT(11) DEFAULT 0,
            `site_status` INT(1) DEFAULT 1,
            `site_version_1` INT(5) DEFAULT 0,
            `site_version_2` INT(5) DEFAULT 0,
            `site_version_3` INT(5) DEFAULT 0,
            `site_version_4` INT(5) DEFAULT 0,
            `site_version_date` INT(11) DEFAULT 0
        );';
$q[] = 'INSERT INTO `site`
        SET `site_id`=NULL,
            `site_version_2`=9,
            `site_version_date`=UNIX_TIMESTAMP()';