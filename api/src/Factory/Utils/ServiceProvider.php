<?php
namespace App\Factory\Utils;

use Faker\Provider\Base;
use RangeException;

class ServiceProvider extends Base
{
	const list = ['wake up', 'laundry', 'transport', 'meal', 'cleaning', 'room service'];
	public static $index = 0;
	
	public function service()
	{
		$count = count(self::list);
		if(self::$index >= count(self::list)) throw new RangeException("ServiceProvider cant generate more than $count services names.");
		return self::list[self::$index++]; // moving index by one is importat here
	}
}