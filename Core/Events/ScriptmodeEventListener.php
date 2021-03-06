<?php

/**
 * @author      Petri Järvisalo (petri.jarvisalo at gmail.com)
 * @copyright    GNU GENERAL PUBLIC LICENSE
 *                     Version 3, 29 June 2007
 *
 * PHP version 5.3 and above
 *
 * LICENSE: This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see {http://www.gnu.org/licenses/}.
 */

namespace ManiaLivePlugins\eXpansion\Core\Events;

/**
 * Description of 
 *
 * @author reaby
 */
interface ScriptmodeEventListener {

    function LibXmlRpc_BeginMatch($number);

    function LibXmlRpc_LoadingMap($number);

    function LibXmlRpc_BeginMap($number);

    function LibXmlRpc_BeginSubmatch($number);

    function LibXmlRpc_BeginRound($number);

    function LibXmlRpc_BeginTurn($number);

    function LibXmlRpc_EndTurn($number);

    function LibXmlRpc_EndRound($number);

    function LibXmlRpc_EndSubmatch($number);

    function LibXmlRpc_EndMap($number);

    function LibXmlRpc_EndMatch($number);

    function LibXmlRpc_BeginWarmUp();

    function LibXmlRpc_EndWarmUp();

    /* storm common */

    function LibXmlRpc_Rankings($array);

    function LibXmlRpc_Scores($MatchScoreClan1, $MatchScoreClan2, $MapScoreClan1, $MapScoreClan2);

    function LibXmlRpc_PlayerRanking($rank, $login, $nickName, $teamId, $isSpectator, $isAway, $currentPoints, $zone);

    function WarmUp_Status($status);

    function LibAFK_IsAFK($login);

    function LibAFK_Properties($idleTimelimit, $spawnTimeLimit, $checkInterval, $forceSpec);

    /* tm common */

    function LibXmlRpc_OnStartLine($login);

    function LibXmlRpc_OnWayPoint($login, $blockId, $time, $cpIndex, $isEndBlock, $lapTime, $lapNb, $isLapEnd);

    function LibXmlRpc_OnGiveUp($login);

    function LibXmlRpc_OnRespawn($login);

    function LibXmlRpc_OnStunt($login, $points, $combo, $totalScore, $factor, $stuntname, $angle, $isStraight, $isReversed, $isMasterJump);
}

?>
