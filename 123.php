<?php

$home = 0;
$draw = 0;
$guest = 0;

for ($k=0; $k<1000; $k++) {
    $home_score = 0;
    $home_defence_ok = 0;
    $home_forward_ok = 0;
    $home_shot_ok = 0;
    $home_penalty = 0;
    $guest_score = 0;
    $guest_defence_ok = 0;
    $guest_forward_ok = 0;
    $guest_shot_ok = 0;
    $guest_penalty = 0;

    $home_player_gk = 150;
    $home_player_1_ld = 100;
    $home_player_1_rd = 100;
    $home_player_1_lf = 100;
    $home_player_1_c = 100;
    $home_player_1_rf = 100;
    $home_player_2_ld = 100;
    $home_player_2_rd = 100;
    $home_player_2_lf = 100;
    $home_player_2_c = 100;
    $home_player_2_rf = 100;
    $home_player_3_ld = 100;
    $home_player_3_rd = 100;
    $home_player_3_lf = 100;
    $home_player_3_c = 100;
    $home_player_3_rf = 100;

    $home_gk = $home_player_gk;
    $home_defence_1 = $home_player_1_ld + $home_player_1_rd;
    $home_forward_1 = $home_player_1_lf + $home_player_1_c + $home_player_1_rf;
    $home_defence_2 = $home_player_2_ld + $home_player_2_rd;
    $home_forward_2 = $home_player_2_lf + $home_player_2_c + $home_player_2_rf;
    $home_defence_3 = $home_player_3_ld + $home_player_3_rd;
    $home_forward_3 = $home_player_3_lf + $home_player_3_c + $home_player_3_rf;

    $guest_player_gk = 100;
    $guest_player_1_ld = 90;
    $guest_player_1_rd = 90;
    $guest_player_1_lf = 90;
    $guest_player_1_c = 90;
    $guest_player_1_rf = 90;
    $guest_player_2_ld = 110;
    $guest_player_2_rd = 110;
    $guest_player_2_lf = 110;
    $guest_player_2_c = 110;
    $guest_player_2_rf = 110;
    $guest_player_3_ld = 110;
    $guest_player_3_rd = 110;
    $guest_player_3_lf = 110;
    $guest_player_3_c = 110;
    $guest_player_3_rf = 110;

    $guest_gk = $guest_player_gk;
    $guest_defence_1 = $guest_player_1_ld + $guest_player_1_rd;
    $guest_forward_1 = $guest_player_1_lf + $guest_player_1_c + $guest_player_1_rf;
    $guest_defence_2 = $guest_player_2_ld + $guest_player_2_rd;
    $guest_forward_2 = $guest_player_2_lf + $guest_player_2_c + $guest_player_2_rf;
    $guest_defence_3 = $guest_player_3_ld + $guest_player_3_rd;
    $guest_forward_3 = $guest_player_3_lf + $guest_player_3_c + $guest_player_3_rf;

    for ($i = 0; $i < 60; $i++) {
        if (0 == $i % 3) {
            $home_defence = $home_defence_1;
            $home_forward = $home_forward_1;
            $guest_defence = $guest_defence_1;
            $guest_forward = $guest_forward_1;
        } elseif (1 == $i % 3) {
            $home_defence = $home_defence_2;
            $home_forward = $home_forward_2;
            $guest_defence = $guest_defence_2;
            $guest_forward = $guest_forward_2;
        } else {
            $home_defence = $home_defence_3;
            $home_forward = $home_forward_3;
            $guest_defence = $guest_defence_3;
            $guest_forward = $guest_forward_3;
        }

        if (rand(0, 40) >= 34) {
            $home_penalty++;
            $home_current_penalty = 1;
        } else {
            $home_current_penalty = 0;
        }

        if (rand(0, 40) >= 34) {
            $guest_penalty++;
            $guest_current_penalty = 1;
        } else {
            $guest_current_penalty = 0;
        }

        if (rand(0, $home_defence / (1 + $home_current_penalty)) > rand(0, $guest_forward / (2 + $guest_current_penalty))) {
            $home_defence_ok++;

            if (rand(0, $home_forward / (1 + $home_current_penalty)) > rand(0, $guest_defence / (2 + $guest_current_penalty))) {
                $home_forward_ok++;

                $player = rand(1, 5);

                if (1 == $player) {
                    if (0 == $i % 3) {
                        $player_shot = $home_player_1_ld;
                        $player_defence = $guest_player_1_ld;
                    } elseif (1 == $i % 3) {
                        $player_shot = $home_player_2_ld;
                        $player_defence = $guest_player_2_ld;
                    } else {
                        $player_shot = $home_player_3_ld;
                        $player_defence = $guest_player_3_ld;
                    }
                } elseif (2 == $player) {
                    if (0 == $i % 3) {
                        $player_shot = $home_player_1_rd;
                        $player_defence = $guest_player_1_rd;
                    } elseif (1 == $i % 3) {
                        $player_shot = $home_player_2_rd;
                        $player_defence = $guest_player_2_rd;
                    } else {
                        $player_shot = $home_player_3_rd;
                        $player_defence = $guest_player_3_rd;
                    }
                } elseif (3 == $player) {
                    if (0 == $i % 3) {
                        $player_shot = $home_player_1_lf;
                        $player_defence = $guest_player_1_lf;
                    } elseif (1 == $i % 3) {
                        $player_shot = $home_player_2_lf;
                        $player_defence = $guest_player_2_lf;
                    } else {
                        $player_shot = $home_player_3_lf;
                        $player_defence = $guest_player_3_lf;
                    }
                } elseif (4 == $player) {
                    if (0 == $i % 3) {
                        $player_shot = $home_player_1_c;
                        $player_defence = $guest_player_1_c;
                    } elseif (1 == $i % 3) {
                        $player_shot = $home_player_2_c;
                        $player_defence = $guest_player_2_c;
                    } else {
                        $player_shot = $home_player_3_c;
                        $player_defence = $guest_player_3_c;
                    }
                } else {
                    if (0 == $i % 3) {
                        $player_shot = $home_player_1_rf;
                        $player_defence = $guest_player_1_rf;
                    } elseif (1 == $i % 3) {
                        $player_shot = $home_player_2_rf;
                        $player_defence = $guest_player_2_rf;
                    } else {
                        $player_shot = $home_player_3_rf;
                        $player_defence = $guest_player_3_rf;
                    }
                }

                $home_shot_ok++;

                if (rand(0, $player_shot) > rand(0, $guest_gk * 5)) {
                    $home_score++;
                }
            }
        }

        if (rand(0, $guest_defence / (1 + $guest_current_penalty)) > rand(0, $home_forward / (2 + $home_current_penalty))) {
            $guest_defence_ok++;

            if (rand(0, $guest_forward / (1 + $guest_current_penalty)) > rand(0, $home_defence / (2 + $home_current_penalty))) {
                $guest_forward_ok++;

                $player = rand(1, 5);

                if (1 == $player) {
                    if (0 == $i % 3) {
                        $player_shot = $guest_player_1_ld;
                        $player_defence = $home_player_1_ld;
                    } elseif (1 == $i % 3) {
                        $player_shot = $guest_player_2_ld;
                        $player_defence = $home_player_2_ld;
                    } else {
                        $player_shot = $guest_player_3_ld;
                        $player_defence = $home_player_3_ld;
                    }
                } elseif (2 == $player) {
                    if (0 == $i % 3) {
                        $player_shot = $guest_player_1_rd;
                        $player_defence = $home_player_1_rd;
                    } elseif (1 == $i % 3) {
                        $player_shot = $guest_player_2_rd;
                        $player_defence = $home_player_2_rd;
                    } else {
                        $player_shot = $guest_player_3_rd;
                        $player_defence = $home_player_3_rd;
                    }
                } elseif (3 == $player) {
                    if (0 == $i % 3) {
                        $player_shot = $guest_player_1_lf;
                        $player_defence = $home_player_1_lf;
                    } elseif (1 == $i % 3) {
                        $player_shot = $guest_player_2_lf;
                        $player_defence = $home_player_2_lf;
                    } else {
                        $player_shot = $guest_player_3_lf;
                        $player_defence = $home_player_3_lf;
                    }
                } elseif (4 == $player) {
                    if (0 == $i % 3) {
                        $player_shot = $guest_player_1_c;
                        $player_defence = $home_player_1_c;
                    } elseif (1 == $i % 3) {
                        $player_shot = $guest_player_2_c;
                        $player_defence = $home_player_2_c;
                    } else {
                        $player_shot = $guest_player_3_c;
                        $player_defence = $home_player_3_c;
                    }
                } else {
                    if (0 == $i % 3) {
                        $player_shot = $guest_player_1_rf;
                        $player_defence = $home_player_1_rf;
                    } elseif (1 == $i % 3) {
                        $player_shot = $guest_player_2_rf;
                        $player_defence = $home_player_2_rf;
                    } else {
                        $player_shot = $guest_player_3_rf;
                        $player_defence = $home_player_3_rf;
                    }
                }

                $guest_shot_ok++;

                if (rand(0, $player_shot) > rand(0, $home_gk * 5)) {
                    $guest_score++;
                }
            }
        }
    }

    if ($home_score > $guest_score)
    {
        $home++;
    } elseif ($home_score == $guest_score)
    {
        $draw++;
    } else {
        $guest++;
    }
}
print $home . ':' . $draw . ':' . $guest;
print '<br>';