<?php
/**
 * @author      Oliver de Cramer (oliverde8 at gmail.com)
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

namespace ManiaLivePlugins\eXpansion\SM_ObstaclesScores;


use ManiaLivePlugins\eXpansion\Core\types\config\types\Boolean;
use ManiaLivePlugins\eXpansion\Core\types\config\types\BoundedInt;
use ManiaLivePlugins\eXpansion\Core\types\config\types\Int;
use ManiaLivePlugins\eXpansion\LocalRecords\Config;

/**
 * Same Meta data as the local records just name and compatibility changes settings are common
 *
 * @package ManiaLivePlugins\eXpansion\SM\PlatformScores
 */
class MetaData extends \ManiaLivePlugins\eXpansion\LocalRecords\MetaData {

	protected function initName()
	{
		$this->setName('Obstacles records');

		$this->setDescription('Local Scores work the same way as LocalRecords but instead of ordering times it orders scores. Higher scores are better.');
	}

	protected function initCompatibility()
	{
		$this->addGameModeCompability(\Maniaplanet\DedicatedServer\Structures\GameInfos::GAMEMODE_SCRIPT, 'Obstacle.Script.txt');

		$this->setEnviAsTitle(false);
		$this->addTitleSupport("Obstacle@steeffeen");
	}
}