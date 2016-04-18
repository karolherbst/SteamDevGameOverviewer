<?php
class Game
{
	public $id;
	public $name = "a Game";
	public $accounts = array();

	public function __construct($id)
	{
		$this->id = $id;
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
