<?php
class Game
{
	public $id;
	public $name = "a Game";
	public $accounts = array();

	public function toHTML()
	{
		$res = $this->name . " (" . $this->id . ")<ul>";
		foreach($this->accounts as $a)
		{
			$res .= "<li>" . $a . "</li>";
		}
		$res .= "</ul>";
		return $res;
	}
}
?>
