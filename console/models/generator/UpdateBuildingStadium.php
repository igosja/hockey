<?php

namespace console\models\generator;

use common\models\BuildingStadium;
use common\models\ConstructionType;
use common\models\History;
use common\models\HistoryText;
use Exception;

/**
 * Class UpdateBuildingStadium
 * @package console\models\generator
 */
class UpdateBuildingStadium
{
    /**
     * @return void
     *@throws Exception
     */
    public function execute()
    {
        BuildingStadium::updateAllCounters(['building_stadium_day' => -1], ['building_stadium_ready' => 0]);

        $buildingStadiumArray = BuildingStadium::find()
            ->with(['team.stadium'])
            ->where(['building_stadium_ready' => 0])
            ->andWhere(['<=', 'building_stadium_day', 0])
            ->orderBy(['building_stadium_id' => SORT_ASC])
            ->each(5);
        foreach ($buildingStadiumArray as $buildingStadium) {
            /**
             * @var BuildingStadium $buildingStadium
             */
            if (ConstructionType::BUILD == $buildingStadium->building_stadium_construction_type_id) {
                $historyTextId = HistoryText::STADIUM_UP;
            } else {
                $historyTextId = HistoryText::STADIUM_DOWN;
            }

            $buildingStadium->team->stadium->stadium_capacity = $buildingStadium->building_stadium_capacity;
            $buildingStadium->team->stadium->save();

            History::log([
                'history_history_text_id' => $historyTextId,
                'history_team_id' => $buildingStadium->building_stadium_team_id,
                'history_value' => $buildingStadium->building_stadium_capacity,
            ]);
        }

        BuildingStadium::updateAll(
            ['building_stadium_ready' => time()],
            ['and', ['building_stadium_ready' => 0], ['<=', 'building_stadium_day', 0]]
        );
    }
}