<?php

$q = array();

$q[] = 'CREATE TABLE `namecountry`
        (
            `namecountry_country_id` SMALLINT(3) DEFAULT 0,
            `namecountry_name_id` INT(11) DEFAULT 0
        );';
$q[] = 'CREATE INDEX `namecountry_country_id` ON `namecountry` (`namecountry_country_id`);';
$q[] = 'CREATE INDEX `namecountry_name_id` ON `namecountry` (`namecountry_name_id`);';
$q[] = "INSERT INTO `namecountry` (`namecountry_country_id`, `namecountry_name_id`)
        VALUES ('133', '1'),
               ('133', '2'),
               ('133', '3'),
               ('133', '4'),
               ('133', '5'),
               ('133', '6'),
               ('133', '7'),
               ('133', '8'),
               ('133', '9'),
               ('133', '10'),
               ('133', '11'),
               ('133', '12'),
               ('133', '13'),
               ('133', '14'),
               ('133', '15'),
               ('133', '16'),
               ('133', '17'),
               ('133', '18'),
               ('133', '19'),
               ('133', '20'),
               ('133', '21'),
               ('133', '22'),
               ('133', '23'),
               ('133', '24'),
               ('133', '25'),
               ('133', '26'),
               ('133', '27'),
               ('133', '28'),
               ('133', '29'),
               ('133', '30'),
               ('133', '31'),
               ('133', '32'),
               ('133', '33'),
               ('133', '34'),
               ('133', '35'),
               ('133', '36'),
               ('133', '37'),
               ('133', '38'),
               ('133', '39'),
               ('133', '40'),
               ('133', '41'),
               ('133', '42'),
               ('133', '43'),
               ('133', '44'),
               ('133', '45'),
               ('133', '46'),
               ('133', '47'),
               ('133', '48'),
               ('133', '49'),
               ('133', '50'),
               ('157', '51'),
               ('157', '52'),
               ('157', '53'),
               ('157', '54'),
               ('157', '55'),
               ('157', '56'),
               ('157', '57'),
               ('157', '58'),
               ('157', '59'),
               ('157', '60'),
               ('157', '61'),
               ('157', '62'),
               ('157', '63'),
               ('157', '64'),
               ('157', '65'),
               ('157', '66'),
               ('157', '67'),
               ('157', '68'),
               ('157', '69'),
               ('157', '70'),
               ('157', '71'),
               ('157', '72'),
               ('157', '73'),
               ('157', '74'),
               ('157', '75'),
               ('157', '76'),
               ('157', '77'),
               ('157', '78'),
               ('157', '79'),
               ('157', '80'),
               ('157', '81'),
               ('157', '82'),
               ('157', '83'),
               ('157', '84'),
               ('157', '85'),
               ('157', '86'),
               ('157', '87'),
               ('157', '88'),
               ('157', '89'),
               ('157', '90'),
               ('157', '91'),
               ('157', '92'),
               ('157', '93'),
               ('157', '94'),
               ('157', '95'),
               ('157', '96'),
               ('157', '97'),
               ('157', '98'),
               ('157', '99'),
               ('157', '100'),
               ('157', '101'),
               ('157', '102'),
               ('157', '103'),
               ('157', '104'),
               ('157', '105'),
               ('157', '106'),
               ('157', '107'),
               ('157', '108'),
               ('157', '109'),
               ('157', '110'),
               ('157', '111'),
               ('157', '112'),
               ('157', '113'),
               ('157', '114'),
               ('157', '115'),
               ('157', '116'),
               ('157', '117'),
               ('157', '118'),
               ('157', '119'),
               ('157', '120'),
               ('157', '121'),
               ('157', '122'),
               ('157', '123'),
               ('157', '124'),
               ('157', '125'),
               ('157', '126'),
               ('157', '127'),
               ('157', '128'),
               ('71', '51'),
               ('71', '52'),
               ('71', '53'),
               ('71', '54'),
               ('71', '55'),
               ('71', '56'),
               ('71', '57'),
               ('71', '58'),
               ('71', '59'),
               ('71', '60'),
               ('71', '61'),
               ('71', '62'),
               ('71', '63'),
               ('71', '64'),
               ('71', '65'),
               ('71', '66'),
               ('71', '67'),
               ('71', '68'),
               ('71', '69'),
               ('71', '70'),
               ('71', '71'),
               ('71', '72'),
               ('71', '73'),
               ('71', '74'),
               ('71', '75'),
               ('71', '76'),
               ('71', '77'),
               ('71', '78'),
               ('71', '79'),
               ('71', '80'),
               ('71', '81'),
               ('71', '82'),
               ('71', '83'),
               ('71', '84'),
               ('71', '85'),
               ('71', '86'),
               ('71', '87'),
               ('71', '88'),
               ('71', '89'),
               ('71', '90'),
               ('71', '91'),
               ('71', '92'),
               ('71', '93'),
               ('71', '94'),
               ('71', '95'),
               ('71', '96'),
               ('71', '97'),
               ('71', '98'),
               ('71', '99'),
               ('71', '100'),
               ('71', '101'),
               ('71', '102'),
               ('71', '103'),
               ('71', '104'),
               ('71', '105'),
               ('71', '106'),
               ('71', '107'),
               ('71', '108'),
               ('71', '109'),
               ('71', '110'),
               ('71', '111'),
               ('71', '112'),
               ('71', '113'),
               ('71', '114'),
               ('71', '115'),
               ('71', '116'),
               ('71', '117'),
               ('71', '118'),
               ('71', '119'),
               ('71', '120'),
               ('71', '121'),
               ('71', '122'),
               ('71', '123'),
               ('71', '124'),
               ('71', '125'),
               ('71', '126'),
               ('71', '127'),
               ('71', '128');";