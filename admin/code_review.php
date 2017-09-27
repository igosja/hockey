<?php

include(__DIR__ . '/../include/include.php');

$exception_array = array(
    'folder' => array(
        '.git',
        'font-awesome',
        'fonts',
        'img',
        'tests/_data',
        'tests/_output',
        'tests/_support',
    ),
    'file' => array(
        '.gitignore',
        '.htaccess',
        'activation.php',
        'activation_repeat.php',
        'admin/city_create.php',
        'admin/city_delete.php',
        'admin/city_list.php',
        'admin/city_update.php',
        'admin/city_view.php',
        'admin/code_review.php',
        'admin/country_create.php',
        'admin/country_delete.php',
        'admin/country_list.php',
        'admin/country_update.php',
        'admin/country_view.php',
        'admin/debug_delete.php',
        'admin/debug_list.php',
        'admin/debug_truncate.php',
        'admin/forumchapter_create.php',
        'admin/forumchapter_delete.php',
        'admin/forumchapter_list.php',
        'admin/forumchapter_update.php',
        'admin/forumchapter_view.php',
        'admin/forumgroup_create.php',
        'admin/forumgroup_delete.php',
        'admin/forumgroup_list.php',
        'admin/forumgroup_update.php',
        'admin/forumgroup_view.php',
        'admin/index.php',
        'admin/name_create.php',
        'admin/name_delete.php',
        'admin/name_list.php',
        'admin/name_update.php',
        'admin/name_view.php',
        'admin/news_create.php',
        'admin/news_delete.php',
        'admin/news_list.php',
        'admin/news_update.php',
        'admin/news_view.php',
        'admin/rule_create.php',
        'admin/rule_delete.php',
        'admin/rule_list.php',
        'admin/rule_update.php',
        'admin/rule_view.php',
        'admin/schedule_change.php',
        'admin/site_status.php',
        'admin/site_version.php',
        'admin/stadium_create.php',
        'admin/stadium_delete.php',
        'admin/stadium_list.php',
        'admin/stadium_update.php',
        'admin/stadium_view.php',
        'admin/support_list.php',
        'admin/support_view.php',
        'admin/surname_create.php',
        'admin/surname_delete.php',
        'admin/surname_list.php',
        'admin/surname_update.php',
        'admin/surname_view.php',
        'admin/team_create.php',
        'admin/team_delete.php',
        'admin/team_list.php',
        'admin/team_update.php',
        'admin/team_view.php',
        'admin/teamask_delete.php',
        'admin/teamask_list.php',
        'admin/teamask_update.php',
        'admin/teamask_view.php',
        'admin/tournamenttype_create.php',
        'admin/tournamenttype_delete.php',
        'admin/tournamenttype_list.php',
        'admin/tournamenttype_update.php',
        'admin/tournamenttype_view.php',
        'admin/user_list.php',
        'admin/user_update.php',
        'admin/user_view.php',
        'admin/vote_create.php',
        'admin/vote_delete.php',
        'admin/vote_list.php',
        'admin/vote_ok.php',
        'admin/vote_update.php',
        'admin/vote_view.php',
        'admin/view/city_list.php',
        'admin/view/city_update.php',
        'admin/view/city_view.php',
        'admin/view/code_review.php',
        'admin/view/country_list.php',
        'admin/view/country_update.php',
        'admin/view/country_view.php',
        'admin/view/debug_list.php',
        'admin/view/forumchapter_list.php',
        'admin/view/forumchapter_update.php',
        'admin/view/forumchapter_view.php',
        'admin/view/forumgroup_list.php',
        'admin/view/forumgroup_update.php',
        'admin/view/forumgroup_view.php',
        'admin/view/index.php',
        'admin/view/include/breadcrumb.php',
        'admin/view/include/pagination.php',
        'admin/view/include/summary.php',
        'admin/view/layout/main.php',
        'admin/view/name_list.php',
        'admin/view/name_update.php',
        'admin/view/name_view.php',
        'admin/view/news_list.php',
        'admin/view/news_update.php',
        'admin/view/news_view.php',
        'admin/view/rule_list.php',
        'admin/view/rule_update.php',
        'admin/view/rule_view.php',
        'admin/view/schedule_change.php',
        'admin/view/site_version.php',
        'admin/view/stadium_list.php',
        'admin/view/stadium_update.php',
        'admin/view/stadium_view.php',
        'admin/view/support_list.php',
        'admin/view/support_view.php',
        'admin/view/surname_list.php',
        'admin/view/surname_update.php',
        'admin/view/surname_view.php',
        'admin/view/team_list.php',
        'admin/view/team_update.php',
        'admin/view/team_view.php',
        'admin/view/teamask_list.php',
        'admin/view/teamask_view.php',
        'admin/view/tournamenttype_list.php',
        'admin/view/tournamenttype_update.php',
        'admin/view/tournamenttype_view.php',
        'admin/view/user_list.php',
        'admin/view/user_update.php',
        'admin/view/user_view.php',
        'admin/view/vote_list.php',
        'admin/view/vote_update.php',
        'admin/view/vote_view.php',
        'admin_login.php',
        'auth_by_key.php',
        'closed.php',
        'codecept.phar',
        'codeception.yml',
        'conference.php',
        'conference_table.php',
        'console/environment',
        'console/folder/environment/index.php',
        'console/folder/generator/index.php',
        'console/folder/migrate/index.php',
        'console/folder/migrate/migration/1473578895_user.php',
        'console/folder/migrate/migration/1474306408_country.php',
        'console/folder/migrate/migration/1474812248_city.php',
        'console/folder/migrate/migration/1474817009_stadium.php',
        'console/folder/migrate/migration/1474997743_name.php',
        'console/folder/migrate/migration/1474997751_surname.php',
        'console/folder/migrate/migration/1474997831_surnamecountry.php',
        'console/folder/migrate/migration/1474997837_namecountry.php',
        'console/folder/migrate/migration/1475585822_player.php',
        'console/folder/migrate/migration/1475586401_userrole.php',
        'console/folder/migrate/migration/1475586410_team.php',
        'console/folder/migrate/migration/1475586415_sex.php',
        'console/folder/migrate/migration/1475586422_position.php',
        'console/folder/migrate/migration/1475586429_style.php',
        'console/folder/migrate/migration/1475586464_special.php',
        'console/folder/migrate/migration/1475586510_playerspecial.php',
        'console/folder/migrate/migration/1475587849_playerposition.php',
        'console/folder/migrate/migration/1475601517_history.php',
        'console/folder/migrate/migration/1475601521_historytext.php',
        'console/folder/migrate/migration/1475670698_season.php',
        'console/folder/migrate/migration/1476899001_teamask.php',
        'console/folder/migrate/migration/1477287593_news.php',
        'console/folder/migrate/migration/1477287636_newscomment.php',
        'console/folder/migrate/migration/1477311015_message.php',
        'console/folder/migrate/migration/1477389998_rule.php',
        'console/folder/migrate/migration/1477401167_basetraining.php',
        'console/folder/migrate/migration/1477401180_basemedical.php',
        'console/folder/migrate/migration/1477401190_basephisical.php',
        'console/folder/migrate/migration/1477401206_baseschool.php',
        'console/folder/migrate/migration/1477401216_basescout.php',
        'console/folder/migrate/migration/1477401226_base.php',
        'console/folder/migrate/migration/1477472470_schedule.php',
        'console/folder/migrate/migration/1477474654_tournamenttype.php',
        'console/folder/migrate/migration/1477633341_stage.php',
        'console/folder/migrate/migration/1477633883_division.php',
        'console/folder/migrate/migration/1477634187_vote.php',
        'console/folder/migrate/migration/1477634211_voteanswer.php',
        'console/folder/migrate/migration/1477634216_voteuser.php',
        'console/folder/migrate/migration/1477634387_votestatus.php',
        'console/folder/migrate/migration/1477910486_game.php',
        'console/folder/migrate/migration/1477910783_offseason.php',
        'console/folder/migrate/migration/1477910792_conference.php',
        'console/folder/migrate/migration/1477910801_championship.php',
        'console/folder/migrate/migration/1477910812_worldcup.php',
        'console/folder/migrate/migration/1477910881_league.php',
        'console/folder/migrate/migration/1479108376_lineup.php',
        'console/folder/migrate/migration/1479192719_tactic.php',
        'console/folder/migrate/migration/1479193019_rude.php',
        'console/folder/migrate/migration/1479193028_mood.php',
        'console/folder/migrate/migration/1479490817_phisical.php',
        'console/folder/migrate/migration/1479491457_phisicalchange.php',
        'console/folder/migrate/migration/1480011107_buildingbase.php',
        'console/folder/migrate/migration/1480011619_building.php',
        'console/folder/migrate/migration/1480011637_constructiontype.php',
        'console/folder/migrate/migration/1480142279_finance.php',
        'console/folder/migrate/migration/1480142315_financetext.php',
        'console/folder/migrate/migration/1480243504_buildingstadium.php',
        'console/folder/migrate/migration/1480356334_training.php',
        'console/folder/migrate/migration/1480445150_school.php',
        'console/folder/migrate/migration/1480530927_site.php',
        'console/folder/migrate/migration/1480943435_statisticteam.php',
        'console/folder/migrate/migration/1480943440_statisticplayer.php',
        'console/folder/migrate/migration/1481050079_event.php',
        'console/folder/migrate/migration/1481051499_eventtextgoal.php',
        'console/folder/migrate/migration/1481051506_eventtextpenalty.php',
        'console/folder/migrate/migration/1481134946_eventtextbullet.php',
        'console/folder/migrate/migration/1481134976_eventtype.php',
        'console/folder/migrate/migration/1481646628_debug.php',
        'console/folder/migrate/migration/1484679025_achievement.php',
        'console/folder/migrate/migration/1484766782_achievementplayer.php',
        'console/folder/migrate/migration/1485595031_userrating.php',
        'console/folder/migrate/migration/1485889077_scout.php',
        'console/folder/migrate/migration/1485975971_transfer.php',
        'console/folder/migrate/migration/1485975976_rent.php',
        'console/folder/migrate/migration/1486061086_transferapplication.php',
        'console/folder/migrate/migration/1486105827_transferposition.php',
        'console/folder/migrate/migration/1486105833_transferspecial.php',
        'console/folder/migrate/migration/1486105840_rentspecial.php',
        'console/folder/migrate/migration/1486105847_rentposition.php',
        'console/folder/migrate/migration/1486124994_rentapplication.php',
        'console/folder/migrate/migration/1486450635_nationaltype.php',
        'console/folder/migrate/migration/1486450640_national.php',
        'console/folder/migrate/migration/1487593107_review.php',
        'console/folder/migrate/migration/1487600138_rosterphrase.php',
        'console/folder/migrate/migration/1491399714_teamwork.php',
        'console/folder/migrate/migration/1493545487_daytype.php',
        'console/folder/migrate/migration/1494238965_swisstable.php',
        'console/folder/migrate/migration/1494315555_swissgame.php',
        'console/folder/migrate/migration/1496905773_teamvisitor.php',
        'console/folder/migrate/migration/1496920741_electionpresidentapplication.php',
        'console/folder/migrate/migration/1496923484_electionpresidentuser.php',
        'console/folder/migrate/migration/1497000392_electionpresident.php',
        'console/folder/migrate/migration/1497001009_electionstatus.php',
        'console/folder/migrate/migration/1497009747_electionnational.php',
        'console/folder/migrate/migration/1497009758_electionnationalapplication.php',
        'console/folder/migrate/migration/1497009764_electionnationaluser.php',
        'console/folder/migrate/migration/1497255661_line.php',
        'console/folder/migrate/migration/1497879410_forummessage.php',
        'console/folder/migrate/migration/1497879418_forumtheme.php',
        'console/folder/migrate/migration/1497879427_forumgroup.php',
        'console/folder/migrate/migration/1497879492_forumchapter.php',
        'console/folder/migrate/migration/1498138665_friendlystatus.php',
        'console/folder/migrate/migration/1498218209_friendlyinvite.php',
        'console/folder/migrate/migration/1498477189_friendlyinvitestatus.php',
        'console/folder/migrate/migration/1499082961_payment.php',
        'console/folder/migrate/migration/1499148396_nationalvotestep.php',
        'console/folder/migrate/migration/1499170965_electionnationalapplicationplayer.php',
        'console/folder/migrate/migration/1500892501_electionnationalvice.php',
        'console/folder/migrate/migration/1500892532_electionnationalviceapplication.php',
        'console/folder/migrate/migration/1500892538_electionnationalviceuser.php',
        'console/folder/migrate/migration/1500902104_electionpresidentviceapplication.php',
        'console/folder/migrate/migration/1500902111_electionpresidentviceuser.php',
        'console/folder/migrate/migration/1500902115_electionpresidentvice.php',
        'console/folder/migrate/migration/1500981636_ratingteam.php',
        'console/folder/migrate/migration/1500981640_ratinguser.php',
        'console/folder/migrate/migration/1500981658_ratingcountry.php',
        'console/folder/migrate/migration/1500981704_ratingchapter.php',
        'console/folder/migrate/migration/1500981717_ratingtype.php',
        'console/folder/migrate/migration/1501333615_statisticchapter.php',
        'console/folder/migrate/migration/1501333621_statistictype.php',
        'console/folder/start/function/f_igosja_start_insert_championship.php',
        'console/folder/start/function/f_igosja_start_insert_conference.php',
        'console/folder/start/function/f_igosja_start_insert_name.php',
        'console/folder/start/function/f_igosja_start_insert_national.php',
        'console/folder/start/function/f_igosja_start_insert_offseason.php',
        'console/folder/start/function/f_igosja_start_insert_shedule.php',
        'console/folder/start/function/f_igosja_start_insert_surname.php',
        'console/folder/start/function/f_igosja_start_insert_team.php',
        'console/folder/start/function/f_igosja_start_insert_user.php',
        'console/folder/start/index.php',
        'console/generator',
        'console/migrate',
        'console/start',
        'css/bootstrap.css',
        'css/metisMenu.css',
        'css/morris.css',
        'css/sb-admin-2.css',
        'css/style.css',
        'favicon.ico',
        'forum.php',
        'forum_chapter.php',
        'forum_group.php',
        'forum_theme.php',
        'forum_theme_create.php',
        'include/breadcrumb.php',
        'include/constant.php',
        'include/database.php',
        'include/filter.php',
        'include/function.php',
        'include/generator.php',
        'include/include.php',
        'include/Mail.php',
        'include/menu.php',
        'include/pagination_count.php',
        'include/pagination_offset.php',
        'include/routing.php',
        'include/season.php',
        'include/seo.php',
        'include/session.php',
        'include/site.php',
        'include/sql/user_view.php',
        'include/start.php',
        'include/table_link.php',
        'index.php',
        'game_list.php',
        'js/admin.js',
        'js/bootstrap.js',
        'js/championship.js',
        'js/championship_statistic.js',
        'js/conference.js',
        'js/conference_table.js',
        'js/forum_group.js',
        'js/forum_theme.js',
        'js/forum_theme_create.js',
        'js/game_list.js',
        'js/jquery.js',
        'js/main.js',
        'js/metisMenu.js',
        'js/morris-data.js',
        'js/morris.js',
        'js/news.js',
        'js/newscomment.js',
        'js/offseason_statistic.js',
        'js/password.js',
        'js/password_restore.js',
        'js/raphael.js',
        'js/rating.js',
        'js/sb-admin-2.js',
        'js/schedule.js',
        'js/signup.js',
        'js/tournament.js',
        'js/user_password.js',
        'js/user_questionnaire.js',
        'js/user_transfermoney.js',
        'json/signup.php',
        'json/user_password.php',
        'login.php',
        'logout.php',
        'news.php',
        'newscomment.php',
        'password.php',
        'password_restore.php',
        'robots.txt',
        'rule.php',
        'rule_list.php',
        'schedule.php',
        'signup.php',
        'sitemap.xml',
        'team_ask.php',
        'team_list.php',
        'team_view.php',
        'tournament.php',
        'user_achievement.php', //!
        'user_deal.php', //!
        'user_finance.php',
        'user_holiday.php',
        'user_password.php',
        'user_questionnaire.php',
        'user_referral.php',
        'user_transfermoney.php',
        'user_view.php',
        'view/activation.php',
        'view/activation_repeat.php',
        'view/closed.php',
        'view/conference.php',
        'view/conference_table.php',
        'view/forum.php',
        'view/forum_chapter.php',
        'view/forum_group.php',
        'view/forum_theme.php',
        'view/forum_theme_create.php',
        'view/game_list.php',
        'view/include/user_profile_top_left.php',
        'view/include/user_profile_top_right.php',
        'view/index.php',
        'view/news.php',
        'view/newscomment.php',
        'view/password.php',
        'view/password_restore.php',
        'view/rule.php',
        'view/rule_list.php',
        'view/schedule.php',
        'view/signup.php',
        'view/team_ask.php',
        'view/team_list.php',
        'view/team_view.php',
        'view/tournament.php',
        'view/user_achievement.php', //!
        'view/user_deal.php', //!
        'view/user_finance.php', //!
        'view/user_holiday.php',
        'view/user_password.php',
        'view/user_questionnaire.php',
        'view/user_referral.php',
        'view/user_transfermoney.php',
        'view/user_view.php',
        'view/vip.php',
        'view/wrong_page.php',
        'vip.php',
        'wrong_page.php',
    ),
);

$file_array = array();

$file_array = f_igosja_read_dir_to_array($file_array, __DIR__ . '/../', $exception_array);

$breadcrumb_array[] = 'Code review';

$summary_from   = 1;
$summary_to     = count($file_array);
$count_item     = $summary_to;

include(__DIR__ . '/view/layout/main.php');