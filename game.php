<?php
class Game
{
	public $id;
	public $name = "a Game";
	public $accounts = array();
	public $img_icon_url;
	public $img_logo_url;

	public function __construct($g)
	{
		$this->id = $g["appid"];
		$this->name = $g["name"];
		$this->img_icon_url = $g["img_icon_url"];
		$this->img_logo_url = $g["img_logo_url"];
	}

	public function toHTML()
	{
		$res = $this->name . " (" . $this->id . ")" . PHP_EOL . "<ul>" . PHP_EOL;
		foreach($this->accounts as $a)
		{
			$res .= "<li>" . $a . "</li>" . PHP_EOL;
		}
		$res .= "</ul>" . PHP_EOL;
		return $res;
	}
}
?>
