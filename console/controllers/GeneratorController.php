<?php

namespace console\controllers;

use common\components\ErrorHelper;
use console\models\generator\CountryStadiumCapacity;
use console\models\generator\FriendlyInviteDelete;
use console\models\generator\GameRowReset;
use console\models\generator\IncreaseNationalPlayerDay;
use console\models\generator\IncreaseNationalUserDay;
use console\models\generator\InsertNews;
use console\models\generator\InsertSwiss;
use console\models\generator\LoanCheck;
use console\models\generator\LoanDecreaseAndReturn;
use console\models\generator\MakeLoan;
use console\models\generator\MakeTransfer;
use console\models\generator\MoodReset;
use console\models\generator\NationalFire;
use console\models\generator\NationalStadium;
use console\models\generator\NationalViceVoteStatus;
use console\models\generator\NationalVoteStatus;
use console\models\generator\NewSeason;
use console\models\generator\PlayerLeaguePower;
use console\models\generator\PlayerPowerS;
use console\models\generator\PlayerPrice;
use console\models\generator\PlayerRealPower;
use console\models\generator\PresidentFire;
use console\models\generator\PresidentViceFire;
use console\models\generator\PresidentViceVoteStatus;
use console\models\generator\PresidentVip;
use console\models\generator\PresidentVoteStatus;
use console\models\generator\ReferrerBonus;
use console\models\generator\SetFreePlayerOnTransfer;
use console\models\generator\SiteOpen;
use console\models\generator\Snapshot;
use console\models\generator\TakeSalary;
use console\models\generator\TeamAge;
use console\models\generator\TeamPlayerCount;
use console\models\generator\TeamPowerVs;
use console\models\generator\TeamPrice;
use console\models\generator\TireBaseLevel;
use console\models\generator\TransferCheck;
use console\models\generator\UpdateRating;
use console\models\generator\UpdateUserTotalRating;
use console\models\generator\UserDecrementAutoForVocation;
use console\models\generator\UserFire;
use console\models\generator\UserFireExtraTeam;
use console\models\generator\UserHolidayEnd;
use Exception;

/**
 * Class GeneratorController
 * @package console\controllers
 */
class GeneratorController extends AbstractController
{
    /**
     * @return void
     */
    public function actionIndex()
    {
        $modelArray = [
//            new UpdateCronDate(),
//            new SiteClose(),
//            new DumpDatabase(),
//            new PlayerPowerNewToOld(),
//            new CheckLineup(),
//            new FillLineup(),
//            new PlayerSpecialToLineup(),
//            new CheckCaptain(),
//            new SetAuto(),
//            new CheckTeamMoodLimit(),
//            new SetDefaultStyle(),
//            new SetUserAuto(),
//            new SetTicketPrice(),
//            new CountVisitor(),
//            new SetStadium(),
//            new FinanceStadium(),
//            new TeamToStatistic(),
//            new UserToRating(),
//            new LineupToStatistic(),
//            new NationalVs(),
//            new GameResult(),
//            new UpdateLeagueCoefficient(),
//            new UpdateTeamStatistic(),
//            new UpdatePlayerStatistic(),
//            new UpdateUserRating(),
//            new CountryAuto(),
//            new TeamVisitorAfterGame(),
//            new UpdateTeamVisitor(),
//            new PlusMinus(),
//            new DecreaseTeamwork(),
//            new Standing(),
//            new StandingPlace(),
//            new PlayerGameRow(),
//            new PlayerTire(),
//            new UpdateTraining(),
//            new UpdatePhysical(),
//            new UpdateSchool(),
//            new UpdateScout(),
//            new UpdateBuildingBase(),
//            new UpdateBuildingStadium(),
//            new StadiumMaintenance(),
//            new DecreaseInjury(),
//            new SetInjury(),
//            new MakePlayed(),
//            new LeagueOut(),
//            new LeagueLot(),
//            new InsertParticipantChampionship(),
//            new ChampionshipAddGame(),
//            new ChampionshipLot(),
//            new InsertAchievement(),
//            new Prize(),
            new InsertSwiss(),
            new LoanDecreaseAndReturn(),
            new MakeTransfer(),
            new TransferCheck(),
            new MakeLoan(),
            new LoanCheck(),
            new TireBaseLevel(),
            new GameRowReset(),
            new MoodReset(),
            new IncreaseNationalUserDay(),
            new IncreaseNationalPlayerDay(),
            new UserDecrementAutoForVocation(),
            new UserFire(),
            new UserHolidayEnd(),
            new NationalVoteStatus(),
            new NationalViceVoteStatus(),
            new NationalFire(),
            new PresidentVoteStatus(),
            new PresidentViceVoteStatus(),
            new PresidentFire(),
            new PresidentViceFire(),
            new ReferrerBonus(),
            new NewSeason(),
            new PlayerLeaguePower(),
            new PlayerPrice(),
            new PlayerPowerS(),
            new PlayerRealPower(),
            new TakeSalary(),
            new TeamPowerVs(),
            new TeamPrice(),
            new TeamAge(),
            new TeamPlayerCount(),
            new CountryStadiumCapacity(),
            new UpdateUserTotalRating(),
            new UpdateRating(),
            new InsertNews(),
            new PresidentVip(),
            new FriendlyInviteDelete(),
            new UserFireExtraTeam(),
            new NationalStadium(),
            new SetFreePlayerOnTransfer(),
            new Snapshot(),
            new SiteOpen(),
        ];

        try {
//            (new CheckCronDate())->execute();
            $this->progress($modelArray);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }
    }
}
