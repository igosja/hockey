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
        'base.php',
        'championship.php',
        'championship_statistic.php',
        'closed.php',
        'codecept.phar',
        'codeception.yml',
        'conference.php',
        'conference_statistic.php',
        'conference_table.php',
        'console/environment',
        'console/folder/environment/dev/.htaccess',
        'console/folder/environment/index.php',
        'console/folder/environment/prod/.htaccess',
        'console/folder/generator/index.php',
        'console/folder/generator/function/f_igosja_generator_building_base.php',
        'console/folder/generator/function/f_igosja_generator_building_stadium.php',
        'console/folder/generator/function/f_igosja_generator_check_lineup.php',
        'console/folder/generator/function/f_igosja_generator_count_visitor.php',
        'console/folder/generator/function/f_igosja_generator_decrease_injury.php',
        'console/folder/generator/function/f_igosja_generator_decrease_teamwork.php',
        'console/folder/generator/function/f_igosja_generator_fill_lineup.php',
        'console/folder/generator/function/f_igosja_generator_finance_stadium.php',
        'console/folder/generator/function/f_igosja_generator_game_result.php',
        'console/folder/generator/function/f_igosja_generator_lineup_to_statistic.php',
        'console/folder/generator/function/f_igosja_generator_make_played.php',
        'console/folder/generator/function/f_igosja_generator_national_vice_vote_status.php',
        'console/folder/generator/function/f_igosja_generator_national_vote_status.php',
        'console/folder/generator/function/f_igosja_generator_phisical.php',
        'console/folder/generator/function/f_igosja_generator_player_game_row.php',
        'console/folder/generator/function/f_igosja_generator_player_power_s.php',
        'console/folder/generator/function/f_igosja_generator_player_price_and_salary.php',
        'console/folder/generator/function/f_igosja_generator_player_tire.php',
        'console/folder/generator/function/f_igosja_generator_plus_minus.php',
        'console/folder/generator/function/f_igosja_generator_player_power_new_to_old.php',
        'console/folder/generator/function/f_igosja_generator_player_real_power.php',
        'console/folder/generator/function/f_igosja_generator_president_vice_vote_status.php',
        'console/folder/generator/function/f_igosja_generator_president_vote_status.php',
        'console/folder/generator/function/f_igosja_generator_rent.php',
        'console/folder/generator/function/f_igosja_generator_rent_decrease_return.php',
        'console/folder/generator/function/f_igosja_generator_school.php',
        'console/folder/generator/function/f_igosja_generator_set_auto.php',
        'console/folder/generator/function/f_igosja_generator_set_injury.php',
        'console/folder/generator/function/f_igosja_generator_set_ticket_price.php',
        'console/folder/generator/function/f_igosja_generator_site_close.php',
        'console/folder/generator/function/f_igosja_generator_site_open.php',
        'console/folder/generator/function/f_igosja_generator_standing.php',
        'console/folder/generator/function/f_igosja_generator_standing_place.php',
        'console/folder/generator/function/f_igosja_generator_swiss.php',
        'console/folder/generator/function/f_igosja_generator_team_price.php',
        'console/folder/generator/function/f_igosja_generator_team_to_statistic.php',
        'console/folder/generator/function/f_igosja_generator_team_visitor.php',
        'console/folder/generator/function/f_igosja_generator_team_visitor_after_game.php',
        'console/folder/generator/function/f_igosja_generator_team_vs.php',
        'console/folder/generator/function/f_igosja_generator_training.php',
        'console/folder/generator/function/f_igosja_generator_transfer.php',
        'console/folder/generator/function/f_igosja_generator_update_player_statistic.php',
        'console/folder/generator/function/f_igosja_generator_update_team_statistic.php',
        'console/folder/generator/function/f_igosja_generator_user_deprive_team.php',
        'console/folder/generator/function/f_igosja_generator_user_holiday_end.php',
        'console/folder/generator/function/f_igosja_generator_user_rating.php',
        'console/folder/generator/function/f_igosja_generator_user_to_rating.php',
        'console/folder/generator/secondary/f_igosja_assist_1.php',
        'console/folder/generator/secondary/f_igosja_assist_2.php',
        'console/folder/generator/secondary/f_igosja_calculate_statistic.php',
        'console/folder/generator/secondary/f_igosja_collision.php',
        'console/folder/generator/secondary/f_igosja_count_home_bonus.php',
        'console/folder/generator/secondary/f_igosja_count_player_bonus.php',
        'console/folder/generator/secondary/f_igosja_current_penalty_decrease.php',
        'console/folder/generator/secondary/f_igosja_current_penalty_decrease_after_goal.php',
        'console/folder/generator/secondary/f_igosja_current_penalty_increase.php',
        'console/folder/generator/secondary/f_igosja_defence.php',
        'console/folder/generator/secondary/f_igosja_election_national_to_close.php',
        'console/folder/generator/secondary/f_igosja_election_national_to_open.php',
        'console/folder/generator/secondary/f_igosja_election_national_vice_to_close.php',
        'console/folder/generator/secondary/f_igosja_election_national_vice_to_open.php',
        'console/folder/generator/secondary/f_igosja_election_president_to_close.php',
        'console/folder/generator/secondary/f_igosja_election_president_to_open.php',
        'console/folder/generator/secondary/f_igosja_election_president_vice_to_close.php',
        'console/folder/generator/secondary/f_igosja_election_president_vice_to_open.php',
        'console/folder/generator/secondary/f_igosja_event_bullet.php',
        'console/folder/generator/secondary/f_igosja_event_penalty.php',
        'console/folder/generator/secondary/f_igosja_event_score.php',
        'console/folder/generator/secondary/f_igosja_face_off.php',
        'console/folder/generator/secondary/f_igosja_forward.php',
        'console/folder/generator/secondary/f_igosja_game_with_bullet.php',
        'console/folder/generator/secondary/f_igosja_get_player_info.php',
        'console/folder/generator/secondary/f_igosja_get_player_real_power_from_optimal.php',
        'console/folder/generator/secondary/f_igosja_get_teamwork.php',
        'console/folder/generator/secondary/f_igosja_optimality.php',
        'console/folder/generator/secondary/f_igosja_penalty_position_array.php',
        'console/folder/generator/secondary/f_igosja_player_assist_1_increase.php',
        'console/folder/generator/secondary/f_igosja_player_assist_2_increase.php',
        'console/folder/generator/secondary/f_igosja_player_face_off_increase.php',
        'console/folder/generator/secondary/f_igosja_player_face_off_power.php',
        'console/folder/generator/secondary/f_igosja_player_face_off_win_increase.php',
        'console/folder/generator/secondary/f_igosja_player_optimal_power.php',
        'console/folder/generator/secondary/f_igosja_player_penalty_increase.php',
        'console/folder/generator/secondary/f_igosja_player_score_increase.php',
        'console/folder/generator/secondary/f_igosja_player_shot_increase.php',
        'console/folder/generator/secondary/f_igosja_player_shot_power.php',
        'console/folder/generator/secondary/f_igosja_plus_minus_increase.php',
        'console/folder/generator/secondary/f_igosja_prepare_game_result_array.php',
        'console/folder/generator/secondary/f_igosja_select_assist_1.php',
        'console/folder/generator/secondary/f_igosja_select_assist_2.php',
        'console/folder/generator/secondary/f_igosja_select_face_off.php',
        'console/folder/generator/secondary/f_igosja_select_player_shot.php',
        'console/folder/generator/secondary/f_igosja_set_teamwork.php',
        'console/folder/generator/secondary/f_igosja_team_penalty_increase.php',
        'console/folder/generator/secondary/f_igosja_team_power.php',
        'console/folder/generator/secondary/f_igosja_team_power_forecast.php',
        'console/folder/generator/secondary/f_igosja_team_score_bullet_increase.php',
        'console/folder/generator/secondary/f_igosja_team_score_increase.php',
        'console/folder/generator/secondary/f_igosja_team_shot_increase.php',
        'console/folder/generator/secondary/f_igosja_swiss.php',
        'console/folder/generator/secondary/f_igosja_swiss_one.php',
        'console/folder/generator/secondary/f_igosja_team_power_forecast.php',
        'console/folder/migrate/index.php',
        'console/folder/migrate/migration/1473578000_achievement.php',
        'console/folder/migrate/migration/1473578000_achievementplayer.php',
        'console/folder/migrate/migration/1473578000_base.php',
        'console/folder/migrate/migration/1473578000_basemedical.php',
        'console/folder/migrate/migration/1473578000_basephisical.php',
        'console/folder/migrate/migration/1473578000_baseschool.php',
        'console/folder/migrate/migration/1473578000_basescout.php',
        'console/folder/migrate/migration/1473578000_basetraining.php',
        'console/folder/migrate/migration/1473578000_building.php',
        'console/folder/migrate/migration/1473578000_buildingbase.php',
        'console/folder/migrate/migration/1473578000_buildingstadium.php',
        'console/folder/migrate/migration/1473578000_championship.php',
        'console/folder/migrate/migration/1473578000_city.php',
        'console/folder/migrate/migration/1473578000_conference.php',
        'console/folder/migrate/migration/1473578000_constructiontype.php',
        'console/folder/migrate/migration/1473578000_country.php',
        'console/folder/migrate/migration/1473578000_daytype.php',
        'console/folder/migrate/migration/1473578000_debug.php',
        'console/folder/migrate/migration/1473578000_division.php',
        'console/folder/migrate/migration/1473578000_electionnational.php',
        'console/folder/migrate/migration/1473578000_electionnationalapplication.php',
        'console/folder/migrate/migration/1473578000_electionnationalapplicationplayer.php',
        'console/folder/migrate/migration/1473578000_electionnationaluser.php',
        'console/folder/migrate/migration/1473578000_electionnationalvice.php',
        'console/folder/migrate/migration/1473578000_electionnationalviceapplication.php',
        'console/folder/migrate/migration/1473578000_electionnationalviceuser.php',
        'console/folder/migrate/migration/1473578000_electionpresident.php',
        'console/folder/migrate/migration/1473578000_electionpresidentapplication.php',
        'console/folder/migrate/migration/1473578000_electionpresidentuser.php',
        'console/folder/migrate/migration/1473578000_electionpresidentvice.php',
        'console/folder/migrate/migration/1473578000_electionpresidentviceapplication.php',
        'console/folder/migrate/migration/1473578000_electionpresidentviceuser.php',
        'console/folder/migrate/migration/1473578000_electionstatus.php',
        'console/folder/migrate/migration/1473578000_event.php',
        'console/folder/migrate/migration/1473578000_eventtextbullet.php',
        'console/folder/migrate/migration/1473578000_eventtextgoal.php',
        'console/folder/migrate/migration/1473578000_eventtextpenalty.php',
        'console/folder/migrate/migration/1473578000_eventtype.php',
        'console/folder/migrate/migration/1473578000_finance.php',
        'console/folder/migrate/migration/1473578000_financetext.php',
        'console/folder/migrate/migration/1473578000_forumchapter.php',
        'console/folder/migrate/migration/1473578000_forumgroup.php',
        'console/folder/migrate/migration/1473578000_forummessage.php',
        'console/folder/migrate/migration/1473578000_forumtheme.php',
        'console/folder/migrate/migration/1473578000_friendlyinvite.php',
        'console/folder/migrate/migration/1473578000_friendlyinvitestatus.php',
        'console/folder/migrate/migration/1473578000_friendlystatus.php',
        'console/folder/migrate/migration/1473578000_game.php',
        'console/folder/migrate/migration/1473578000_history.php',
        'console/folder/migrate/migration/1473578000_historytext.php',
        'console/folder/migrate/migration/1473578000_league.php',
        'console/folder/migrate/migration/1473578000_line.php',
        'console/folder/migrate/migration/1473578000_lineup.php',
        'console/folder/migrate/migration/1473578000_message.php',
        'console/folder/migrate/migration/1473578000_mood.php',
        'console/folder/migrate/migration/1473578000_name.php',
        'console/folder/migrate/migration/1473578000_namecountry.php',
        'console/folder/migrate/migration/1473578000_national.php',
        'console/folder/migrate/migration/1473578000_nationaltype.php',
        'console/folder/migrate/migration/1473578000_nationalvotestep.php',
        'console/folder/migrate/migration/1473578000_news.php',
        'console/folder/migrate/migration/1473578000_newscomment.php',
        'console/folder/migrate/migration/1473578000_offseason.php',
        'console/folder/migrate/migration/1473578000_payment.php',
        'console/folder/migrate/migration/1473578000_phisical.php',
        'console/folder/migrate/migration/1473578000_phisicalchange.php',
        'console/folder/migrate/migration/1473578000_player.php',
        'console/folder/migrate/migration/1473578000_playerposition.php',
        'console/folder/migrate/migration/1473578000_playerspecial.php',
        'console/folder/migrate/migration/1473578000_position.php',
        'console/folder/migrate/migration/1473578000_ratingchapter.php',
        'console/folder/migrate/migration/1473578000_ratingcountry.php',
        'console/folder/migrate/migration/1473578000_ratingteam.php',
        'console/folder/migrate/migration/1473578000_ratingtype.php',
        'console/folder/migrate/migration/1473578000_ratinguser.php',
        'console/folder/migrate/migration/1473578000_relation.php',
        'console/folder/migrate/migration/1473578000_rent.php',
        'console/folder/migrate/migration/1473578000_rentapplication.php',
        'console/folder/migrate/migration/1473578000_rentposition.php',
        'console/folder/migrate/migration/1473578000_rentspecial.php',
        'console/folder/migrate/migration/1473578000_review.php',
        'console/folder/migrate/migration/1473578000_rosterphrase.php',
        'console/folder/migrate/migration/1473578000_rude.php',
        'console/folder/migrate/migration/1473578000_rule.php',
        'console/folder/migrate/migration/1473578000_schedule.php',
        'console/folder/migrate/migration/1473578000_school.php',
        'console/folder/migrate/migration/1473578000_scout.php',
        'console/folder/migrate/migration/1473578000_season.php',
        'console/folder/migrate/migration/1473578000_sex.php',
        'console/folder/migrate/migration/1473578000_site.php',
        'console/folder/migrate/migration/1473578000_special.php',
        'console/folder/migrate/migration/1473578000_stadium.php',
        'console/folder/migrate/migration/1473578000_stage.php',
        'console/folder/migrate/migration/1473578000_statisticchapter.php',
        'console/folder/migrate/migration/1473578000_statisticplayer.php',
        'console/folder/migrate/migration/1473578000_statisticteam.php',
        'console/folder/migrate/migration/1473578000_statistictype.php',
        'console/folder/migrate/migration/1473578000_style.php',
        'console/folder/migrate/migration/1473578000_surname.php',
        'console/folder/migrate/migration/1473578000_surnamecountry.php',
        'console/folder/migrate/migration/1473578000_swissgame.php',
        'console/folder/migrate/migration/1473578000_swisstable.php',
        'console/folder/migrate/migration/1473578000_tactic.php',
        'console/folder/migrate/migration/1473578000_team.php',
        'console/folder/migrate/migration/1473578000_teamask.php',
        'console/folder/migrate/migration/1473578000_teamvisitor.php',
        'console/folder/migrate/migration/1473578000_teamwork.php',
        'console/folder/migrate/migration/1473578000_tournamenttype.php',
        'console/folder/migrate/migration/1473578000_training.php',
        'console/folder/migrate/migration/1473578000_transfer.php',
        'console/folder/migrate/migration/1473578000_transferapplication.php',
        'console/folder/migrate/migration/1473578000_transferposition.php',
        'console/folder/migrate/migration/1473578000_transferspecial.php',
        'console/folder/migrate/migration/1473578000_user.php',
        'console/folder/migrate/migration/1473578000_userrating.php',
        'console/folder/migrate/migration/1473578000_userrole.php',
        'console/folder/migrate/migration/1473578000_vote.php',
        'console/folder/migrate/migration/1473578000_voteanswer.php',
        'console/folder/migrate/migration/1473578000_votestatus.php',
        'console/folder/migrate/migration/1473578000_voteuser.php',
        'console/folder/migrate/migration/1473578000_worldcup.php',
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
        'country_finance.php',
        'country_news.php',
        'country_newscomment.php',
        'country_team.php',
        'css/bootstrap.css',
        'css/metisMenu.css',
        'css/morris.css',
        'css/sb-admin-2.css',
        'css/style.css',
        'dialog.php',
        'dialog_delete.php',
        'dialog_list.php',
        'favicon.ico',
        'forum.php',
        'forum_chapter.php',
        'forum_group.php',
        'forum_theme.php',
        'forum_theme_create.php',
        'friendly.php',
        'friendlystatus.php',
        'game_list.php',
        'game_preview.php',
        'game_view.php',
        'include/breadcrumb.php',
        'include/constant.php',
        'include/database.php',
        'include/filter.php',
        'include/function/f_igosja_base_is_school.php',
        'include/function/f_igosja_base_is_scout.php',
        'include/function/f_igosja_base_is_training.php',
        'include/function/f_igosja_birth_age.php',
        'include/function/f_igosja_birth_date.php',
        'include/function/f_igosja_check_user_by_email.php',
        'include/function/f_igosja_check_user_by_login.php',
        'include/function/f_igosja_check_user_password.php',
        'include/function/f_igosja_console_progress.php',
        'include/function/f_igosja_count_case.php',
        'include/function/f_igosja_create_team_players.php',
        'include/function/f_igosja_finance.php',
        'include/function/f_igosja_game_auto.php',
        'include/function/f_igosja_game_score.php',
        'include/function/f_igosja_generate_user_code.php',
        'include/function/f_igosja_get_count_query.php',
        'include/function/f_igosja_hash_password.php',
        'include/function/f_igosja_history.php',
        'include/function/f_igosja_money.php',
        'include/function/f_igosja_mysqli_query.php',
        'include/function/f_igosja_player_position.php',
        'include/function/f_igosja_player_position_training.php',
        'include/function/f_igosja_player_special.php',
        'include/function/f_igosja_player_special_training.php',
        'include/function/f_igosja_read_dir_to_array.php',
        'include/function/f_igosja_request.php',
        'include/function/f_igosja_request_get.php',
        'include/function/f_igosja_request_post.php',
        'include/function/f_igosja_select_player_surname_id.php',
        'include/function/f_igosja_sql_data.php',
        'include/function/f_igosja_ufu_date.php',
        'include/function/f_igosja_ufu_date_time.php',
        'include/function/f_igosja_ufu_last_visit.php',
        'include/function/f_igosja_user_from.php',
        'include/function/redirect.php',
        'include/function/refresh.php',
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
        'include/sql/country_view.php',
        'include/sql/country_view.php',
        'include/sql/player_view.php',
        'include/sql/team_view_left.php',
        'include/sql/team_view_right.php',
        'include/sql/user_view.php',
        'include/start.php',
        'include/statistic_select_sort.php',
        'include/table_link.php',
        'index.php',
        'js/admin.js',
        'js/bootstrap.js',
        'js/championship.js',
        'js/championship_statistic.js',
        'js/conference.js',
        'js/conference_statistic.js', //!
        'js/conference_table.js',
        'js/country_finance.js',
        'js/country.js',
        'js/country_news.js',
        'js/country_newscomment.js',
        'js/dialog.js',
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
        'js/offseason.js',
        'js/offseason_statistic.js', //!
        'js/offseason_table.js',
        'js/password.js',
        'js/password_restore.js',
        'js/phisical.js',
        'js/player_list.js',
        'js/player_view.js',
        'js/raphael.js',
        'js/rating.js',
        'js/sb-admin-2.js',
        'js/schedule.js',
        'js/signup.js',
        'js/stadium_decrease.js',
        'js/stadium_increase.js',
        'js/team_event.js',
        'js/team_finance.js',
        'js/team_game.js',
        'js/tournament.js',
        'js/user_finance.js',
        'js/user_password.js',
        'js/user_questionnaire.js',
        'js/user_transfermoney.js',
        'json/phisical.php',
        'json/player_view.php',
        'json/signup.php',
        'json/user_password.php',
        'login.php',
        'logout.php',
        'news.php',
        'newscomment.php',
        'offseason.php',
        'offseason_statistic.php',
        'offseason_table.php',
        'password.php',
        'password_restore.php',
        'phisical.php',
        'phisical_image.php',
        'player_achievement.php', //!
        'player_event.php',
        'player_deal.php',
        'player_list.php',
        'player_rent.php',
        'player_transfer.php',
        'player_view.php', //!
        'rent.php', //!Поиск и пагинация
        'robots.txt',
        'rule.php',
        'rule_list.php',
        'schedule.php',
        'school.php',
        'shop_error.php',
        'shop_success.php',
        'signup.php',
        'sitemap.xml',
        'stadium_decrease.php',
        'stadium_increase.php',
        'team_achievement.php',
        'team_ask.php',
        'team_event.php',
        'team_finance.php',
        'team_game.php',
        'team_list.php',
        'team_statistic.php',
        'team_view.php',
        'tests/acceptance.suite.yml',
        'tests/functional.suite.yml',
        'tests/unit.suite.yml',
        'tournament.php',
        'training.php',
        'transfer.php', //!Поиск и пагинация
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
        'view/admin_login.php',
        'view/base.php',
        'view/championship.php',
        'view/championship_statistic.php',
        'view/closed.php',
        'view/conference.php',
        'view/conference_statistic.php', //!
        'view/conference_table.php',
        'view/country_finance.php',
        'view/country_news.php',
        'view/country_newscomment.php',
        'view/country_team.php',
        'view/dialog.php',
        'view/dialog_list.php',
        'view/forum.php',
        'view/forum_chapter.php',
        'view/forum_group.php',
        'view/forum_theme.php',
        'view/forum_theme_create.php',
        'view/friendly.php',
        'view/friendlystatus.php',
        'view/game_list.php',
        'view/game_preview.php',
        'view/game_view.php',
        'view/include/championship_table_link.php',
        'view/include/country_table_link.php',
        'view/include/country_table_national_link.php',
        'view/include/country_view.php',
        'view/include/national_table_link.php',
        'view/include/player_table_link.php',
        'view/include/player_view.php',
        'view/include/register_link.php',
        'view/include/team_table_link.php',
        'view/include/team_view_bottom_right_forum.php',
        'view/include/team_view_bottom_right_my_team.php',
        'view/include/team_view_top_left.php',
        'view/include/team_view_top_right.php',
        'view/include/user_profile_top_left.php',
        'view/include/user_profile_top_right.php',
        'view/include/user_table_link.php',
        'view/index.php',
        'view/layout/admin.php',
        'view/layout/main.php',
        'view/news.php',
        'view/newscomment.php',
        'view/offseason.php',
        'view/offseason_statistic.php', //!Какая-то хуйня. Пересмотреть правильность записи данных в таблицу и правильность выборки по каждому типу
        'view/offseason_table.php',
        'view/password.php',
        'view/password_restore.php',
        'view/phisical.php',
        'view/player_achievement.php', //!
        'view/player_deal.php', //!
        'view/player_event.php',
        'view/player_list.php',
        'view/player_rent.php',
        'view/player_transfer.php',
        'view/player_view.php', //!
        'view/rent.php',
        'view/rule.php',
        'view/rule_list.php',
        'view/schedule.php',
        'view/school.php',
        'view/signup.php',
        'view/stadium_decrease.php',
        'view/stadium_increase.php',
        'view/team_achievement.php',
        'view/team_ask.php',
        'view/team_event.php',
        'view/team_finance.php',
        'view/team_game.php',
        'view/team_list.php',
        'view/team_statistic.php',
        'view/team_view.php',
        'view/tournament.php',
        'view/training.php',
        'view/transfer.php',
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