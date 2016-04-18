<?php
require "config.php";
require "game.php";

$game_list = array();
$privates = array();

foreach($steam_ids as $id => $name)
{
	$url = "http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=" . $steam_api_key . "&steamid=" . $id . "&format=json&include_played_free_games=1&include_appinfo=1";
	$data = file_get_contents($url);
	$jdata = json_decode($data, true)["response"];

	if (empty($jdata))
	{
		array_push($privates, $name);
		continue;
	}

	$jgames = $jdata["games"];

	foreach($jgames as $g)
	{
		if (!array_key_exists($g["appid"], $game_list))
		{
			$game = new Game($g);
			array_push($game->accounts, $name);
			$game_list[$game->id] = $game;
		} else {
			array_push($game_list[$g["appid"]]->accounts, $name);
		}
	}
}

echo "Private profiles: <ul>" . PHP_EOL;
foreach($privates as $name)
{
	echo "<li>" . $name . "</li>" . PHP_EOL;
}
echo "</ul>" . PHP_EOL;
echo "<input type='search' autofocus oninput='performSearch(this)' data-set='game_list' data-keys='name accounts'/>" . PHP_EOL;
echo "<ul id='game_list'>" . PHP_EOL;
foreach($game_list as $game)
{
	echo "<li data-name='" . $game->name . "' data-accounts='";
	foreach ($game->accounts as $name)
	{
		echo $name . " ";
	}
	echo "'>" . PHP_EOL;
	echo $game->toHTML();
	echo "</li>" . PHP_EOL;
}
echo "</ul>" . PHP_EOL;
?>
