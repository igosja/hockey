<?php

namespace console\models\generator;

use common\models\Team;
use common\models\TeamVisitor;

/**
 * Class UpdateTeamVisitor
 * @package console\models\generator
 */
class UpdateTeamVisitor
{
    /**
     * @return void
     */
    public function execute(): void
    {
        $teamArray = Team::find()
            ->where(['!=', 'team_id', 0])
            ->orderBy(['team_id' => SORT_ASC])
            ->each();
        foreach ($teamArray as $team) {
            /**
             * @var Team $team
             */
            $visitor = 0;

            $visitorArray = TeamVisitor::find()
                ->where(['team_visitor_team_id' => $team->team_id])
                ->orderBy(['team_visitor_id' => SORT_DESC])
                ->limit(5)
                ->all();
            foreach ($visitorArray as $item) {
                $visitor = $visitor + $item->team_visitor_visitor;
            }

            $countVisitor = count($visitorArray);
            if (0 == $countVisitor) {
                $countVisitor = 1;
            }

            $visitor = round($visitor / $countVisitor * 100);

            $team->team_visitor = $visitor;
            $team->save();
        }
    }
}