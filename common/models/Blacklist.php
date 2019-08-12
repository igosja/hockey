<?php

namespace common\models;

/**
 * Class Blacklist
 * @package common\models
 *
 * @property int $blacklist_id
 * @property int $blacklist_interlocutor_user_id
 * @property int $blacklist_owner_user_id
 */
class Blacklist extends AbstractActiveRecord
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'blacklist_id',
                    'blacklist_interlocutor_user_id',
                    'blacklist_owner_user_id',
                ],
                'integer'
            ],
        ];
    }
}
