<?php
namespace App\Factory\Utils;

use DateTime;
use Faker\Provider\Base;

class DateTimeProvider extends Base
{
	public function exactDateTime(string $from)
	{
		$dateTime = new DateTime($from);
		if($dateTime->format('H:i:s') === '00:00:00') $dateTime->setTime($this->numberBetween(0, 23), $this->numberBetween(0,60), $this->numberBetween(0, 60), $this->numberBetween(0, 1000000));
		return $dateTime;
	}
}