<?php
namespace Tests\Test;

use App\Test\Constraint\EntityShallowMatch;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\AssertionFailedError;
use stdClass;

class FirstDummyClass
{
	private $id;
	private $firstPrivateProperty;
	protected $secondProtectedProperty;
	public $thirdPublicProperty;
	
	public function __construct($id = null, $firstPrivateProperty = null, $secondProtectedProperty = null, $thirdPublicProperty = null)
	{
		$this->id = $id;
		$this->firstPrivateProperty = $firstPrivateProperty;
		$this->secondProtectedProperty= $secondProtectedProperty;
		$this->thirdPublicProperty = $thirdPublicProperty;
	}
}

class SecondDummyClass
{
	private $firstPrivateProperty;
	protected $secondProtectedProperty;
	public $thirdPublicProperty;
	
	public function __construct($firstPrivateProperty = null, $secondProtectedProperty = null, $thirdPublicProperty = null)
	{
		$this->firstPrivateProperty = $firstPrivateProperty;
		$this->secondProtectedProperty= $secondProtectedProperty;
		$this->thirdPublicProperty = $thirdPublicProperty;
	}
}

class EntityShallowMatchConstraintTest extends TestCase
{
	public function testFailWithWrongTypes()
	{
		$firstObject = new FirstDummyClass();
		$secondObject = 23;
		
		$this->expectException(AssertionFailedError::class);
		$this->expectExceptionMessage("Object to compare to must be an instance of class, `integer` was given.");
	
		self::assertThat($secondObject, new EntityShallowMatch($firstObject));
	}
	
	public function testFailWithWrongClassTypes()
	{
		$firstObject = new FirstDummyClass(12);
		$secondObject = new SecondDummyClass();
		
		$this->expectException(AssertionFailedError::class);
		$this->expectExceptionMessage("Object type `Tests\Test\FirstDummyClass#12` is not the same as object type `Tests\Test\SecondDummyClass`.");
		
		self::assertThat($secondObject, new EntityShallowMatch($firstObject));
	}
	
	public function testFailWithWrongPropertyTypes()
	{
		$firstObject = new FirstDummyClass(16, [], 23);
		$secondObject = new FirstDummyClass(12, "string", new stdClass);
		
		$this->expectException(AssertionFailedError::class);
		$this->expectExceptionMessage("Property value Tests\Test\FirstDummyClass#16.firstPrivateProperty{array} is not equal Tests\Test\FirstDummyClass#12.firstPrivateProperty{string}.");
		$this->expectExceptionMessage("Property value Tests\Test\FirstDummyClass#16.secondProtectedProperty{integer} is not equal Tests\Test\FirstDummyClass#12.secondProtectedProperty{object}.");
		
		self::assertThat($secondObject, new EntityShallowMatch($firstObject));
	}
	
	public function testFailWithWrongPropertyValues()
	{
		$firstObject = new FirstDummyClass(17, "blue", 1205, new stdClass);
		$secondObject = new FirstDummyClass(25, "red", 1204, null);
		
		$this->expectException(AssertionFailedError::class);
		$this->expectExceptionMessage("Property value Tests\Test\FirstDummyClass#17.firstPrivateProperty{blue} is not equal Tests\Test\FirstDummyClass#25.firstPrivateProperty{red}.");
		$this->expectExceptionMessage("Property value Tests\Test\FirstDummyClass#17.secondProtectedProperty{1205} is not equal Tests\Test\FirstDummyClass#25.secondProtectedProperty{1204}.");
		$this->expectExceptionMessage("Property value Tests\Test\FirstDummyClass#17.thirdPublicProperty{object} is not equal Tests\Test\FirstDummyClass#25.thirdPublicProperty{NULL}.");
				
		self::assertThat($secondObject, new EntityShallowMatch($firstObject));
	}
	
	public function testValuesCheckForComplexTypesWillBeSkipped()
	{
		$firstObject = new FirstDummyClass(1, ['blue','red'], new stdClass, 12.7);
		$secondObject = new FirstDummyClass(1, [], new SecondDummyClass(), 12.7);
		
		self::assertThat($secondObject, new EntityShallowMatch($firstObject));
	}
}