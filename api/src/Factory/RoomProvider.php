<?php
namespace App\Factory;

use Faker\Provider\Base;

class RoomProvider extends Base
{
	public function room($from, $to)
	{
		return 'Room ' . $this->numberBetween($from, $to);
	}
}
