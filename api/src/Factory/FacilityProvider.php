<?php
namespace App\Factory;

use Faker\Provider\Base;
use RangeException;

class FacilityProvider extends Base
{
	const list = ['one bed', 'double bed', 'two bed', 'bath', 'tv', 'cosmetics', 'shower', 'smoke sensor', 'wi-fi', 'sea view', 'towel', 'animal friendly', 'phone', 'wardrobe', 'mini-bar', 'safe', 'hair dryer', 'mirror', 'heating', 'air conditioning'];
	public static $index = 0;
	
	public function facility()
	{
		$availableFacilityCount = count(self::list);
		if(self::$index >= count(self::list)) throw new RangeException("FacilityProvider cant generate more than $availableFacilityCount facilities names.");
		return self::list[self::$index++]; // moving index by one is importat here
	}
}