<?php
class GameInformation
{
	private static $instance;
	private $game_linux_supported = array();

	public function __construct()
	{
		$url = "https://raw.githubusercontent.com/SteamDatabase/SteamLinux/master/GAMES.json";
		$data = file_get_contents($url);
		$this->game_linux_supported = json_decode($data, true);
	}

	public static function getInstance()
	{
		if (is_null(self::$instance))
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function supportsLinux(Game $game)
	{
		if(array_key_exists($game->id, $this->game_linux_supported))
		{
			if($this->game_linux_supported[$game->id])
				return true;
		}
		return false;
	}
}

class Game
{
	public $id;
	public $name = "a Game";
	public $publisher = "a Publisher";
	public $accounts = array();
	public $img_icon_url;
	public $img_logo_url;
	public $platforms = array();

	public function __construct($g)
	{
		$this->id = $g["appid"];
		$this->name = $g["name"];
		$this->img_icon_url = $g["img_icon_url"];
		$this->img_logo_url = $g["img_logo_url"];
		if (GameInformation::getInstance()->supportsLinux($this))
			array_push($this->platforms, "linux");
	}

	public function toHTML()
	{
		$res = $this->name . " (" . $this->id . ")";
		if(in_array("linux", $this->platforms))
			$res .= " Linux support!";
		$res .= PHP_EOL . "<ul>" . PHP_EOL;
		foreach($this->accounts as $a)
		{
			$res .= "<li>" . $a . "</li>" . PHP_EOL;
		}
		$res .= "</ul>" . PHP_EOL;
		return $res;
	}
}
?>
