<?php
use Ds\Set;

class Game
{
	public $id;
	public $name = "a Game";
	public $publisher = "a Publisher";
	public $accounts = null;
	public $img_icon_url;
	public $img_logo_url;
	public $platforms = array();
	public $genres = array();
	public $multiplayer = false;
	public $coop = false;

	public function __construct($g)
	{
		$this->accounts = new Set();
		$this->id = $g["appid"];
		$this->name = $g["name"];
		$this->img_icon_url = $g["img_icon_url"];

		$url = "https://store.steampowered.com/api/appdetails?appids=" . $this->id;
		$data = cached_file_get_contents($url, "game", $this->id, 30);
		// rate limited
		if(strcmp($data, "") == 0)
			return;
		$parsed = json_decode($data, true);
		if(!$parsed[$this->id]["success"])
			return;

		$data = $parsed[$this->id]["data"];
		$this->name = $data["name"];
		if($data["platforms"]["windows"])
			array_push($this->platforms, "windows");
		if($data["platforms"]["mac"])
			array_push($this->platforms, "mac");
		if($data["platforms"]["linux"])
			array_push($this->platforms, "linux");

		if(array_key_exists("genres", $data))
			foreach($data["genres"] as $g)
				array_push($this->genres, $g["description"]);

		if(array_key_exists("categories", $data)) {
			foreach($data["categories"] as $c) {
				switch($c["description"]) {
				case "Multi-player":
					$this->multiplayer = true;
					break;
				case "Co-op":
				case "Online Co-op":
					$this->coop = true;
					break;
				}
			}
		}
	}

	public function toHTML()
	{
//		$res = "<img src='https://media.steampowered.com/steamcommunity/public/images/apps/" . $this->id . "/" . $this->img_icon_url . ".jpg'/><br/>";
		$res = "<img src='https://steamcdn-a.akamaihd.net/steam/apps/" . $this->id . "/header.jpg' width='200' /><div>";
		$res .= $this->name . " (" . $this->id . ")";
		if(in_array("windows", $this->platforms))
			$res .= " 🪟";
		if(in_array("mac", $this->platforms))
			$res .= " 🍎";
		if(in_array("linux", $this->platforms))
			$res .= " 🐧";
		if($this->coop || $this->multiplayer)
			$res .= " 👥";
		if($this->coop)
			$res .= " 🤝";
		$res .= " " . implode(" ", $this->genres);
		$res .= PHP_EOL . "<ul>" . PHP_EOL;
		foreach($this->accounts as $a) {
			$res .= "<li>" . $a . "</li>" . PHP_EOL;
		}
		$res .= "</ul></div>" . PHP_EOL;
		return $res;
	}
}
?>
