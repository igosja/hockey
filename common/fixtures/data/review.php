<?php

use common\models\Division;
use common\models\Stage;

return [
    [
        'review_id' => 1,
        'review_country_id' => 2,
        'review_division_id' => Division::D1,
        'review_text' => 'Текст обзора',
        'review_title' => 'Заголовок обзора',
        'review_stage_id' => Stage::TOUR_1,
        'review_user_id' => 1,
    ],
];
