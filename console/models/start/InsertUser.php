<?php

namespace console\models\start;

use common\components\HockeyHelper;
use common\models\User;
use Yii;

/**
 * Class InsertUser
 * @package console\models\start
 */
class InsertUser
{
    /**
     * @throws \yii\db\Exception
     * @return void
     */
    public function execute(): void
    {
        $data = [
            ['3763f51d2ac3d333cf588479879a1fe1', HockeyHelper::unixTimeStamp(), 'jenya-legkov@mail.ru', 'Jenya', '$2y$13$JqfRNamUBiyZTfbKiVLZdeDNWQ/sLe3lQUw/sXnkcH09F1H4WyIyS'],
            ['07ecc566a474b50b26839a7b9a1ff3b3', HockeyHelper::unixTimeStamp(), 'nurbergenov78@mail.ru', 'Abeke15', '$2y$13$PwdU2XDY1oQftR6q..7MD.l/iLy99UQrMfk7Eqdp7mng7K7nPDv5y'],
            ['83bab2474d6fdd1adc094eba21fd4ee2', HockeyHelper::unixTimeStamp(), 'snurbergenova@mail.ru', 'Superkelin', '$2y$13$1A/xtxVyEYJa.D/iDt.DR.oG3Qvta/SP8.tazNeTluKSaSOh64r9i'],
            ['0a2ec92681321273888eb69d8d064fd4', HockeyHelper::unixTimeStamp(), 'alessandrochesscoach@gmail.com', 'SASHO5', '$2y$13$BluGqyIZJLOeATKmyLyj7O5.1uqdEfagqWoBydVN674dFYENBdkqW'],
            ['77e84682f7e6ca5fda1139216da7ef9c', HockeyHelper::unixTimeStamp(), 'igosja87@gmail.com', 'igosja87', '$2y$13$meEaz8/pEJXWQiePOkXVbeOX/qonPwzlK8BepoekX6bL8gshBPlTG'],
            ['77bb087fbe6a1d54cdbaa86664912dfa', HockeyHelper::unixTimeStamp(), 'igosja877@gmail.com', 'igosja877', '$2y$13$5323gb0gCPegXYoGIIw7f.2GkJXA/pmBQ71Q7oSaYdfQHm3NVV4S2'],
            ['68cf45ac9c35f48305fcbe3f0d8c8b24', HockeyHelper::unixTimeStamp(), 'kidofreason@gmail.com', 'Teemu Selanne', '$2y$13$eiNFENFMnjTp5nSss2pf/.ROdycHTy//jJ/3neCUV.KGSsCiuBfXa'],
            ['b653680fc93f4d02a145c6d643f4c870', HockeyHelper::unixTimeStamp(), 'ole8kristall@mail.ru', 'oleg8natali', '$2y$13$rpW8ADOlEugA2sE6cE8DiuMsklQU/K5Np7vvU2OI95mjL7u1jjV0.'],
            ['83246ab2ae8b049ef0bdf4cb5d1f7cf2', HockeyHelper::unixTimeStamp(), 'bubnoff.serg@yandex.ru', 'Gordik', '$2y$13$1z9g6d6l4oGUgAmYqsvB3ehgohK0AGu7WhUx7F7Qst7n8xbIvqLry'],
            ['b7dcee95da09b814a5919dfa868d5931', HockeyHelper::unixTimeStamp(), 'suronovos@mail.ru', 'suro', '$2y$13$jrSvHCmdDKKaCJNXuQ8Na.SU53vup1A6WSJkRgQe.Upa5ApKcOXsi'],
            ['d1cb4797acf8cc84b4fc5f2c598b6258', HockeyHelper::unixTimeStamp(), 'mishanyamihey1987@gmail.com', 'Angel27', '$2y$13$JkT/bC62To010Bpsk9RHxuxJb3HmnyYZ1LOornZX/QQHG5675EFDW'],
            ['750070cc4fa91145b4f6e9bc120e48af', HockeyHelper::unixTimeStamp(), 'messer_judas@mail.ru', 'stifmaster', '$2y$13$bzi5zhTJaoNHd06ThKCHyucceV4.NdFTKEriU2ag11tOgbm0J0lxO'],
            ['010d5748b94df809525e7e30c791e855', HockeyHelper::unixTimeStamp(), 'city.galaxy@gmail.com', 'Скандинавия', '$2y$13$e86pwTcxaAaJxLADLG1ctuV2k0OEQp1KE8Tf0h8/0qRFSl.U./z8S'],
            ['f087e0f7829c2ad751e09d7160b4a9ed', HockeyHelper::unixTimeStamp(), 'ediyan@mail.ru', 'ЭдиЯн', '$2y$13$V3lv/VzcoOCs0vWaFpfc6OIVUBfYkOqXylsZQ3bzq2Fyok9qBB2Va'],
            ['212929cb7e5fb5ed753262a75b28d0d8', HockeyHelper::unixTimeStamp(), 'dima.makovsky@gmail.com', 'barsenal', '$2y$13$aS4nxoK7Mm.cW7wFQKs9Ue.1dsfIUnxiVjB8nsnga9J19FVWGh7q.'],
            ['f1fab6b013c84732c3fcb1bf166a50ae', HockeyHelper::unixTimeStamp(), 'poliv-gazonov@ukr.net', 'Тигр', '$2y$13$XXeXnBfivlHr3R5dT8OFeuelzgOszYeKK8f/vdMCaxZqZkAqxbL9S'],
            ['f4689e248496faa1a3d0b2af229ba02e', HockeyHelper::unixTimeStamp(), 'Mihalych65@mail.ru', 'Mihalych', '$2y$13$JoRNyflQgpA9guv1RbXVR.N131YEPb9ddeVCE5D3IOkmi33EQiJ0K'],
            ['8149112e505fe229c31825d6e6a690a3', HockeyHelper::unixTimeStamp(), 'wade712@ukr.net', 'Danila9', '$2y$13$9yMsHRXjZdOMMH45Yw6zveQoBf4YiSNbw4DA3aDWrjqwhvN0N.6jO'],
            ['0612698a9bbdfc1c7d2105fca404cc8e', HockeyHelper::unixTimeStamp(), 'atris179@yandex.ru', 'Атрис', '$2y$13$UFWThLLJAXmX21.hysPmguVKMzXrs/PZECFOQ4dbk75ULMcZ6YSyK'],
            ['107ecc35743d471a23917e164a67bec5', HockeyHelper::unixTimeStamp(), 'tsar81@mail.ru', 'tsar81', '$2y$13$nPCpE8Hc8fOhs4VotW78zeIwA82LZKad4zBCfz4YR5h1cJ8JvrPRi'],
            ['1ad00538edfad3a69297c9520f4540bf', HockeyHelper::unixTimeStamp(), 'donetsyuriy02@gmail.com', 'lorka', '$2y$13$wNJt30JQHK.EWbf0hsFBAetjrMFP8HEJ/9AV93BnO4/trxPlTJIIy'],
            ['095ba8271dd7ab280f025d6fb98ee239', HockeyHelper::unixTimeStamp(), 'champion1969@ukr.net', 'champion1969', '$2y$13$CkNRfEh4Kr8s0uVVCV4SCOronnbPo.WcJQ1REIGi7xrk//5az0VHG'],
            ['da9c59c9d058567a90891db176409871', HockeyHelper::unixTimeStamp(), 'roman-shoskin@mail.ru', 'kol', '$2y$13$Lyp01ZTEwNPtThEDIXMITOdLUI/MbN7XKGmNCOEI3z/sA3le.JIRi'],
            ['5317ab676661b0e71227b76e5c46e3c8', HockeyHelper::unixTimeStamp(), 'leoben12340@gmail.com', 'leoben', '$2y$13$beYu/wcj7N8sVKp0VHcZPe2.cQheoMjr9pegOlSnFNjVuKZ1q1c4a'],
            ['c90cfe32a9c01eb3558d3301b58175dd', HockeyHelper::unixTimeStamp(), 'isk_tes@ukr.net', 'Alexnick', '$2y$13$WEbeV1WHBLxZeM1BL6dZMOobH1mDDp7oCw0HcJJIrXFFb7y.kvBr6'],
            ['fe61d537bc27b76b7248dfb07feaa2f6', HockeyHelper::unixTimeStamp(), 'diman_lyly@mail.ru', 'Dimanzzzo', '$2y$13$uIbBKl3OXdX3u8YwqN1SS.PVWqUIEkkg5UfE8RdpO2QZTJbyFriaK'],
            ['86cc228c4d1d1a979acea85fd2ccaf7b', HockeyHelper::unixTimeStamp(), 'samvel_a@yahoo.com', 'Samuel Abraham', '$2y$13$YO2z7bOnG7i7fo2fZv34ROQAgGfjd0L6AZc37KjiWKwC9B5sWWgFW'],
            ['621a6d32236368f1f80e2d9ec31ad9c6', HockeyHelper::unixTimeStamp(), 'pidzy26@gmail.com', 'Эллин85', '$2y$13$DNfYO23btA6AQlCdiTlK1ePFaVHl8XdgsA0giggeA2MSC9jwuiL8G'],
            ['1b35a5ffd30bb6df3417a497ef70f002', HockeyHelper::unixTimeStamp(), 'lrv-89@mail.ru', 'Tableter', '$2y$13$tWeC.SOlhx7kQrbUKA4d0e1oPZ5k4hPBpoHKIIjlqw9C/LgIZZ1he'],
            ['cf49b37be77c75f84bd4207e3eaf9393', HockeyHelper::unixTimeStamp(), 'Spectre@bk.ru', 'Spectre', '$2y$13$VCbVT.IwlywJaAq5aYPOf.ImM/UB9Dbcp0Tj7p8pikxMr2w00DL3G'],
            ['3dede772f851e9492f5ecdddf4619c8d', HockeyHelper::unixTimeStamp(), 'amuntvalencia@ukr.net', 'Dracarys', '$2y$13$qTGt5EhHtkHpCvw3WuEN8Oe3HTkJu81zgu1MPT.QgnoDnsUxx8Acy'],
            ['879e22ecbb52fe10cc053476d4af91a3', HockeyHelper::unixTimeStamp(), 'LM1985Red@yandex.ru', 'Эдмон', '$2y$13$J1tMg.MR74cWP8Q3AK6XHu7mfH357i3QvTtB7CfaOv1iPrH.vuuWG'],
            ['5507de28407d0e9f70e2ce6803e09405', HockeyHelper::unixTimeStamp(), 'rolandmu1991@gmail.com', 'RolandMU', '$2y$13$LorRby.36vwdDkxnUJCr1e5XvvS33tIN6MjfixHhxAXJ4PXqtRnny'],
            ['f15c41124763efa5b3b3564f55afe6c6', HockeyHelper::unixTimeStamp(), 'g.v.belikov@yandex.ru', 'Morelli', '$2y$13$txWfqu1z65yhTMXsOaZ5OeCrwnlSOd8OLguJSsDLBR6sYUkFKs0nu'],
            ['aa1507729688068231f7db03f218057c', HockeyHelper::unixTimeStamp(), '76udalov76@mail.ru', 'Trygg', '$2y$13$lxfQj2UDiLnMmGDWJjv3dObqCvOG1FecBN3GK.eFOBXqpAkRw0sMq'],
            ['e5ebab52876a8a3ae4e1a1d568143b43', HockeyHelper::unixTimeStamp(), 'Alligator35@ukr.net', 'Halk', '$2y$13$cLs/6mhrRyJDB5sJPXg2CejeACPIH/5FdJkr9jJ53JpPcupwgZeZu'],
            ['fb84ae4c188ed0478d81dd1043675098', HockeyHelper::unixTimeStamp(), 'y.rekun@mail.ru', 'Феникс', '$2y$13$TMdahK6wcZgjraX3Oki0POfUMb7uAMvXaBb/55Fo23euaj/v6H3di'],
            ['d60d6103b616f7df3e93d24e9c0df946', HockeyHelper::unixTimeStamp(), 'manager.ukr83@gmail.com', 'OLEXANDER', '$2y$13$2Wuyg.xXil0qh6V42TsaKeSG5CZ77rD5.BxkMeQFAcqN6uL1vMqu2'],
            ['83f218ade94406a67e5c6f66b1e5468f', HockeyHelper::unixTimeStamp(), '79536787347@ya.ru', 'Spermike', '$2y$13$uCn4vefLpZxIfn5nkLTlpuxEUayRf7C.jr2P88OuMJgQDOzrfrEme'],
            ['12e79f8f603af9bcd13f03206885937a', HockeyHelper::unixTimeStamp(), 'tikhon.smirnov@yandex.ru', 'tixon1501', '$2y$13$EI6IbkCirSw4lyoe4wfEIOVrjYrdnJUZNH6mD/S0KPGvETn8NBvWm'],
            ['c1bae25b012b57656c300eb0b7d7d44c', HockeyHelper::unixTimeStamp(), 'alpchol@rambler.ru', 'zver', '$2y$13$6Ue55CK7bF8TqK3bxcPvfe03YSew3pYDtEVjvCcsAriWj2BWe7KVu'],
        ];

        Yii::$app->db
            ->createCommand()
            ->batchInsert(
                User::tableName(),
                ['user_code', 'user_date_register', 'user_email', 'user_login', 'user_password'],
                $data
            )
            ->execute();
    }
}
