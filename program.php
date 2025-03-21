<?php
require "game.php";

$game_list = array();
$privates = array();

foreach($steam_ids as $id => $name)
{
	$url = "https://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=" . $steam_api_key . "&steamid=" . $id . "&format=json&include_played_free_games=1&include_appinfo=1";
	$data = cached_file_get_contents($url, "account", $id, 1);
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
			$game->accounts[] = $name;
			$game_list[$game->id] = $game;
		} else {
			$game_list[$g["appid"]]->accounts[] = $name;
		}
	}

	$url = "https://store.steampowered.com/wishlist/profiles/" . $id . "/wishlistdata/";
	$data = cached_file_get_contents($url, "wishlist", $id, 1);
	if (!$data)
		continue;

	$jdata = json_decode($data, true);
}

function cmp($a, $b)
{
	$accounts = sizeof($b->accounts) - sizeof($a->accounts);
	if ($accounts == 0)
		return strcmp($a->name, $b->name);
	return $accounts;
}

usort($game_list, "cmp");

echo "Private profiles: <ul>" . PHP_EOL;
foreach($privates as $name)
{
	echo "<li>" . $name . "</li>" . PHP_EOL;
}
echo "</ul>" . PHP_EOL;
echo "Search for Games, Developers, Platforms or whatever you want!: ";
echo "<input id='search' type='search' autofocus oninput='performSearch(this)' data-set='game_list' data-keys='name accounts platforms genres'/><br/>" . PHP_EOL;
echo "<input id='coop-check' type='checkbox' name='Co-op' onchange='performSearch(undefined)'/>🤝 (co-op)<br/>" . PHP_EOL;
echo "<input id='mp-check' type='checkbox' name='mp' onchange='performSearch(undefined)'/>👥 (Multiplayer)<br/>" . PHP_EOL;
echo "<ul id='acc_list'>" . PHP_EOL;
foreach(array_unique($steam_ids) as $id => $name)
{
	echo "<li><input type='checkbox' name='" . $name . "' onchange='performSearch(undefined)'/>" . PHP_EOL;
	echo $name . PHP_EOL;
	echo "</li>" . PHP_EOL;
}
echo "</ul>" . PHP_EOL;
echo "<ul id='game_list'>" . PHP_EOL;
foreach($game_list as $game)
{
	echo "<li data-name='" . preg_replace("/[.:'\"]/", "", $game->name);
	echo "' data-accounts='" . json_encode($game->accounts);
	echo "' data-platforms='" . implode(" ", $game->platforms);
	echo "' data-genres='" . implode(" ", $game->genres);
	echo "'";
	if($game->coop)
		echo " data-coop";
	if($game->multiplayer)
		echo " data-mp";
	echo ">" . PHP_EOL;
	echo $game->toHTML();
	echo "</li>" . PHP_EOL;
}
echo "</ul>" . PHP_EOL;
?>
