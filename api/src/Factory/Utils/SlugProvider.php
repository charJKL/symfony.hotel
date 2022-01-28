<?php
namespace App\Factory\Utils;

use Faker\Provider\Base;

class SlugProvider extends Base
{
	public function slug($sentence)
	{
		return str_replace(" ", "-", strtolower($sentence));
	}
}