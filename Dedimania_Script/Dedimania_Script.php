<?php

namespace ManiaLivePlugins\eXpansion\Dedimania_Script;

use ManiaLivePlugins\eXpansion\Dedimania\Classes\Connection as DediConnection;
use ManiaLivePlugins\eXpansion\Dedimania\Events\Event as DediEvent;
use ManiaLivePlugins\eXpansion\Dedimania\Structures\DediRecord;

class Dedimania_Script extends \ManiaLivePlugins\eXpansion\Dedimania\DedimaniaAbstract
{


    public function exp_onReady()
    {
        parent::exp_onReady();
        $this->enableScriptEvents();
    }

    public function LibXmlRpc_BeginMap($number)
    {
        if (!$this->running)
            return;

        $this->records  = array();
        $this->rankings = array();
        $this->vReplay  = "";
        $this->gReplay  = "";
    }

    public function LibXmlRpc_OnWayPoint($login, $blockId, $time, $cpIndex, $isEndBlock, $lapTime, $lapNb, $isLapEnd)
    {
        if (!$this->running)
            return;
        if ($time == 0)
            return;

        $playerinfo = \ManiaLivePlugins\eXpansion\Core\Core::$playerInfo;

        if (!$isEndBlock)
            return;

        if ($this->storage->currentMap->nbCheckpoints == 1)
            return;

        if (!array_key_exists($login, DediConnection::$players))
            return;

        // if player is banned from dedimania, don't send his time.
        if (DediConnection::$players[$login]->banned)
            return;

        if (!array_key_exists($login, $this->rankings)) {
            $this->rankings[$login] = array();
        }

        if (!array_key_exists('BestTime', $this->rankings[$login])) {
            $this->rankings[$login] = array('Login' => $login, 'BestTime' => $time, 'BestCheckpoints' => implode(
                ",",
                $playerinfo[$login]->checkpoints
            ));
        } else {
            if ($time < $this->rankings[$login]['BestTime']) {
                $this->rankings[$login] = array('Login' => $login, 'BestTime' => $time, 'BestCheckpoints' => implode(
                    ",",
                    $playerinfo[$login]->checkpoints
                ));
            }
        }

        // if current map doesn't have records, create one.
        if (count($this->records) == 0) {
            $player     = $this->storage->getPlayerObject($login);
            $playerinfo = \ManiaLivePlugins\eXpansion\Core\Core::$playerInfo;
            if ($this->storage->currentMap->nbCheckpoints !== count($playerinfo[$login]->checkpoints)) {
                Helper::log("[DediMania]Player CP mistmach");
            }

            $this->records[$login] = new DediRecord($login, $player->nickName, DediConnection::$players[$login]->maxRank, $time, -1, $playerinfo[$login]->checkpoints);
            $this->reArrage($login);
            \ManiaLive\Event\Dispatcher::dispatch(new DediEvent(DediEvent::ON_NEW_DEDI_RECORD, $this->records[$login]));

            return;
        }

        // if last record is not set, don't continue.
        if (!is_object($this->lastRecord)) {
            return;
        }

        // so if the time is better than the last entry or the count of records

        $maxrank = DediConnection::$serverMaxRank;
        if (DediConnection::$players[$login]->maxRank > $maxrank) {
            $maxrank = DediConnection::$players[$login]->maxRank;
        }

        if ($time <= $this->lastRecord->time || count($this->records) <= $maxrank) {

            //  print "times matches!";
            // if player exists on the list... see if he got better time

            $player = $this->storage->getPlayerObject($login);

            if (array_key_exists($login, $this->records)) {


                if ($this->records[$login]->time > $time) {
                    $oldRecord = $this->records[$login];

                    $this->records[$login] = new DediRecord($login, $player->nickName, DediConnection::$players[$login]->maxRank, $time, -1, array());

                    // if new records count is greater than old count, and doesn't exceed the maxrank of the server
                    $oldCount = count($this->records);
                    if ((count(
                                $this->records
                            ) > $oldCount) && ((DediConnection::$dediMap->mapMaxRank + 1) < DediConnection::$serverMaxRank)
                    ) {
                        //print "increasing maxrank! \n";
                        DediConnection::$dediMap->mapMaxRank++;
                    }
                    $this->reArrage($login);
                    // have to recheck if the player is still at the dedi array
                    if (array_key_exists(
                        $login,
                        $this->records
                    )
                    ) // have to recheck if the player is still at the dedi array
                        \ManiaLive\Event\Dispatcher::dispatch(
                            new DediEvent(DediEvent::ON_DEDI_RECORD, $this->records[$login], $oldRecord)
                        );

                    return;
                }

                // if not, add the player to records table
            } else {
                $oldCount              = count($this->records);
                $this->records[$login] = new DediRecord($login, $player->nickName, DediConnection::$players[$login]->maxRank, $time, -1, array());
                // if new records count is greater than old count, increase the map records limit

                if ((count(
                            $this->records
                        ) > $oldCount) && ((DediConnection::$dediMap->mapMaxRank + 1) < DediConnection::$serverMaxRank)
                ) {

                    DediConnection::$dediMap->mapMaxRank++;
                }
                $this->reArrage($login);

                // have to recheck if the player is still at the dedi array
                if (array_key_exists($login, $this->records))
                    \ManiaLive\Event\Dispatcher::dispatch(
                        new DediEvent(DediEvent::ON_NEW_DEDI_RECORD, $this->records[$login])
                    );

                return;
            }
        }
    }

    /**
     *
     * @param array  $rankings
     * @param string $winnerTeamOrMap
     *
     */
    public function onEndMatch($rankings_old, $winnerTeamOrMap)
    {
        if (!$this->running)
            return;

        if ($this->expStorage->isRelay)
            return;

        usort($this->rankings, array($this, "compare_BestTime"));

        $rankings = array();
        $error    = false;
        foreach ($this->rankings as $login => $rank) {
            $checks = explode(",", $rank['BestCheckpoints']);
            foreach ($checks as $list) {
                if ($list == 0)
                    $error = true;
            }
            $rank['BestCheckpoints'] = $checks;
            $rankings[]              = $rank;
        }

        if ($error) {
            $this->console("[Dedimania] Data integrity check failed. Dedimania times not sent.");

            return;
        }

        try {
            if (sizeof($rankings) == 0) {
                $this->vReplay = "";
                $this->gReplay = "";
                $this->console("[Dedimania] No new times driven. Skipping dedimania sent.");

                return;
            }

            $this->vReplay = $this->connection->getValidationReplay($rankings[0]['Login']);

            $greplay = "";
            $grfile  = sprintf(
                'Dedimania/%s.%d.%07d.%s.Replay.Gbx',
                $this->storage->currentMap->uId,
                $this->storage->gameInfos->gameMode,
                $rankings[0]['BestTime'],
                $rankings[0]['Login']
            );
            $this->connection->SaveBestGhostsReplay($rankings[0]['Login'], $grfile);
            $this->gReplay = file_get_contents($this->connection->gameDataDirectory() . 'Replays/' . $grfile);

            // Dedimania doesn't allow times sent without validation relay. So, let's just stop here if there is none.
            if (empty($this->vReplay)) {
                $this->console(
                    "[Dedimania] Couldn't get validation replay of the first player. Dedimania times not sent."
                );

                return;
            }

            $this->dedimania->setChallengeTimes($this->storage->currentMap, $rankings, $this->vReplay, $this->gReplay);
        } catch (\Exception $e) {
            $this->console("[Dedimania] " . $e->getMessage());
            $this->vReplay = "";
            $this->gReplay = "";
        }
    }

}

?>
