<?php
require "config.php";
require "game.php";

$game_list = array();

foreach($steam_ids as $id => $name)
{
	$url = "http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=" . $steam_api_key . "&steamid=" . $id . "&format=json";
	$data = file_get_contents($url);
	$jgames = json_decode($data, true)["response"]["games"];

	foreach($jgames as $g)
	{
		if (!array_key_exists($g["appid"], $game_list))
		{
			$game = new Game();
			$game->id = $g["appid"];
			array_push($game->accounts, $name);
			array_push($game_list, $game);
		}
	}
}

echo "<ul>";
foreach($game_list as $game)
{
	echo "<li>";
	echo $game->toHTML();
	echo "</li>";
}
echo "</ul>";
?>
