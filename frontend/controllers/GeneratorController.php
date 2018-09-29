<?php

namespace frontend\controllers;

use common\components\ErrorHelper;
use console\models\generator\ChampionshipAddGame;
use console\models\generator\ChampionshipLot;
use console\models\generator\CheckCronDate;
use console\models\generator\CheckLineup;
use console\models\generator\CheckTeamMoodLimit;
use console\models\generator\CountryAuto;
use console\models\generator\CountryStadiumCapacity;
use console\models\generator\CountVisitor;
use console\models\generator\DecreaseInjury;
use console\models\generator\DecreaseTeamwork;
use console\models\generator\FillLineup;
use console\models\generator\FinanceStadium;
use console\models\generator\FriendlyInviteDelete;
use console\models\generator\GameResult;
use console\models\generator\GameRowReset;
use console\models\generator\IncreaseNationalPlayerDay;
use console\models\generator\IncreaseNationalUserDay;
use console\models\generator\InsertAchievement;
use console\models\generator\InsertNews;
use console\models\generator\InsertParticipantChampionship;
use console\models\generator\InsertSwiss;
use console\models\generator\LeagueLot;
use console\models\generator\LeagueOut;
use console\models\generator\LineupToStatistic;
use console\models\generator\LoanCheck;
use console\models\generator\LoanDecreaseAndReturn;
use console\models\generator\MakeLoan;
use console\models\generator\MakePlayed;
use console\models\generator\MakeTransfer;
use console\models\generator\MoodReset;
use console\models\generator\NationalFire;
use console\models\generator\NationalStadium;
use console\models\generator\NationalViceVoteStatus;
use console\models\generator\NationalVoteStatus;
use console\models\generator\NationalVs;
use console\models\generator\PlayerGameRow;
use console\models\generator\PlayerLeaguePower;
use console\models\generator\PlayerPowerNewToOld;
use console\models\generator\PlayerPowerS;
use console\models\generator\PlayerPriceAndSalary;
use console\models\generator\PlayerRealPower;
use console\models\generator\PlayerTire;
use console\models\generator\PlusMinus;
use console\models\generator\PresidentFire;
use console\models\generator\PresidentViceFire;
use console\models\generator\PresidentViceVoteStatus;
use console\models\generator\PresidentVip;
use console\models\generator\PresidentVoteStatus;
use console\models\generator\Prize;
use console\models\generator\ReferrerBonus;
use console\models\generator\SetAuto;
use console\models\generator\SetDefaultStyle;
use console\models\generator\SetFreePlayerOnTransfer;
use console\models\generator\SetInjury;
use console\models\generator\SetStadium;
use console\models\generator\SetTicketPrice;
use console\models\generator\SetUserAuto;
use console\models\generator\SiteClose;
use console\models\generator\SiteOpen;
use console\models\generator\Snapshot;
use console\models\generator\StadiumMaintenance;
use console\models\generator\Standing;
use console\models\generator\StandingPlace;
use console\models\generator\TakeSalary;
use console\models\generator\TeamAge;
use console\models\generator\TeamPlayerCount;
use console\models\generator\TeamPowerVs;
use console\models\generator\TeamPrice;
use console\models\generator\TeamToStatistic;
use console\models\generator\TeamVisitorAfterGame;
use console\models\generator\TireBaseLevel;
use console\models\generator\TransferCheck;
use console\models\generator\UpdateBuildingBase;
use console\models\generator\UpdateBuildingStadium;
use console\models\generator\UpdateCronDate;
use console\models\generator\UpdateLeagueCoefficient;
use console\models\generator\UpdatePhysical;
use console\models\generator\UpdatePlayerStatistic;
use console\models\generator\UpdateRating;
use console\models\generator\UpdateSchool;
use console\models\generator\UpdateScout;
use console\models\generator\UpdateTeamStatistic;
use console\models\generator\UpdateTeamVisitor;
use console\models\generator\UpdateTraining;
use console\models\generator\UpdateUserRating;
use console\models\generator\UpdateUserTotalRating;
use console\models\generator\UserDecrementAutoForVocation;
use console\models\generator\UserFire;
use console\models\generator\UserFireExtraTeam;
use console\models\generator\UserHolidayEnd;
use console\models\generator\UserToRating;
use Exception;

/**
 * Class GeneratorController
 * @package frontend\controllers
 */
class GeneratorController extends BaseController
{
    /**
     * @return void
     */
    public function actionIndex(): void
    {
        try {
            (new CheckCronDate())->execute();
            (new UpdateCronDate())->execute();
            (new SiteClose())->execute();
            (new PlayerPowerNewToOld())->execute();
            (new CheckTeamMoodLimit())->execute();
            (new CheckLineup())->execute();
            (new FillLineup())->execute();
            (new SetAuto())->execute();
            (new SetDefaultStyle())->execute();
            (new SetUserAuto())->execute();
            (new SetTicketPrice())->execute();
            (new CountVisitor())->execute();
            (new SetStadium())->execute();
            (new FinanceStadium())->execute();
            (new TeamToStatistic())->execute();
            (new UserToRating())->execute();
            (new LineupToStatistic())->execute();
            (new NationalVs())->execute();
            (new GameResult())->execute();
            (new UpdateLeagueCoefficient())->execute();
            (new UpdateTeamStatistic())->execute();
            (new UpdatePlayerStatistic())->execute();
            (new UpdateUserRating())->execute();
            (new CountryAuto())->execute();
            (new TeamVisitorAfterGame())->execute();
            (new UpdateTeamVisitor())->execute();
            (new PlusMinus())->execute();
            (new DecreaseTeamwork())->execute();
            (new Standing())->execute();
            (new StandingPlace())->execute();
            (new PlayerGameRow())->execute();
            (new PlayerTire())->execute();
            (new UpdateTraining())->execute();
            (new UpdatePhysical())->execute();
            (new UpdateSchool())->execute();
            (new UpdateScout())->execute();
            (new UpdateBuildingBase())->execute();
            (new UpdateBuildingStadium())->execute();
            (new StadiumMaintenance())->execute();
            (new DecreaseInjury())->execute();
            (new SetInjury())->execute();
            (new MakePlayed())->execute();
            (new LeagueOut())->execute();
            (new LeagueLot())->execute();
            (new InsertParticipantChampionship())->execute();
            (new ChampionshipAddGame())->execute();
            (new ChampionshipLot())->execute();
            (new InsertAchievement())->execute();
            (new Prize())->execute();
            (new InsertSwiss())->execute();
            (new LoanDecreaseAndReturn())->execute();
            (new MakeTransfer())->execute();
            (new TransferCheck())->execute();
            (new MakeLoan())->execute();
            (new LoanCheck())->execute();
            (new TireBaseLevel())->execute();
            (new GameRowReset())->execute();
            (new MoodReset())->execute();
            (new IncreaseNationalUserDay())->execute();
            (new IncreaseNationalPlayerDay())->execute();
            (new UserDecrementAutoForVocation())->execute();
            (new UserFire())->execute();
            (new UserHolidayEnd())->execute();
            (new NationalVoteStatus())->execute();
            (new NationalViceVoteStatus())->execute();
            (new NationalFire())->execute();
            (new PresidentVoteStatus())->execute();
            (new PresidentViceVoteStatus())->execute();
            (new PresidentFire())->execute();
            (new PresidentViceFire())->execute();
            (new ReferrerBonus())->execute();
//            (new NewSeason())->execute();
            (new PlayerLeaguePower())->execute();
            (new PlayerPriceAndSalary())->execute();
            (new PlayerPowerS())->execute();
            (new PlayerRealPower())->execute();
            (new TakeSalary())->execute();
            (new TeamPowerVs())->execute();
            (new TeamPrice())->execute();
            (new TeamAge())->execute();
            (new TeamPlayerCount())->execute();
            (new CountryStadiumCapacity())->execute();
            (new UpdateUserTotalRating())->execute();
            (new UpdateRating())->execute();
            (new InsertNews())->execute();
            (new PresidentVip())->execute();
            (new FriendlyInviteDelete())->execute();
            (new UserFireExtraTeam())->execute();
            (new NationalStadium())->execute();
            (new SetFreePlayerOnTransfer())->execute();
            (new Snapshot())->execute();
            (new SiteOpen())->execute();
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }
    }
}
